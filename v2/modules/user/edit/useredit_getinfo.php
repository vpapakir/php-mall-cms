<?php
try
{
    unset($useredit_totaluser,$useredit_listing_blocktitle,
            $useredit_rights, $useredit_status);
    unset($useredit_orderby_nrpage);
    
    $prepared_query = 'SELECT COUNT(id_user) FROM user';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $useredit_totalregistereduser = $data[0];
    }
    $query->closeCursor();
    
    if($useredit_totalregistereduser > 0)
    {
        $useredit_info_totalregistereduser = give_translation('user_edit.subtitle_totalregistereduser', 'false', $config_showtranslationcode);
        $useredit_info_totalregistereduser = str_replace('[#totalregistered_useredit]', '<strong>'.$useredit_totalregistereduser.'</strong>', $useredit_info_totalregistereduser);
    }
    else
    {
        $useredit_info_totalregistereduser = give_translation('user_edit.subtitle_totalregistereduser', 'false', $config_showtranslationcode);
    }
    $useredit_info_totalregistereduser = str_replace('[#sitename]', '<strong>'.$config_sitename.'</strong>', $useredit_info_totalregistereduser);

    
    #firstloading
    if(empty($_SESSION['useredit_searchdone']))
    {
        $useredit_rights = null;
        $useredit_status = give_translation('main.user_status_active', 'false', $config_showtranslationcode);
        
        $prepared_query = 'SELECT COUNT(id_user) FROM user
                           WHERE status_user = 1
                           ORDER BY name_user ASC';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $useredit_totaluser = $data[0];
        }
        $query->closeCursor();
        
        #[paging]
        if(empty($useredit_orderby_nrpage))
        {
            $useredit_orderby_nrpage = 25;
        }
        $paging_resultperpage = $useredit_orderby_nrpage;
        $paging_page_max = 5;
        $paging_countresult = $useredit_totaluser;
        //$paging_jsevent = 'onclick="OnChange(\'bt_checked_useredit\');"';
        include('modules/search/paging/paging_getinfo.php');
        
        $_SESSION['paging_defaultdisplay'] = 'false';
        if(empty($_SESSION['paging_limitmin']))
        {
            $useredit_limitmin = 0;
        }
        else
        {
            $useredit_limitmin = $_SESSION['paging_limitmin'];
        }

        if(empty($_SESSION['paging_limitmax']))
        {
            $useredit_limitmax = $paging_resultperpage;
        }
        else
        {
            $useredit_limitmax = $_SESSION['paging_limitmax'];
        }
        #[/paging]
        
        $useredit_preparedquery = 'SELECT * FROM user
                                   INNER JOIN user_rights
                                   ON user_rights.level_rights = user.rights_user
                                   WHERE status_user = 1
                                   ORDER BY COALESCE(namecompany_user, "z") ASC, COALESCE(name_user, "z") ASC
                                   LIMIT '.$useredit_limitmin.', '.$useredit_limitmax;

        $useredit_listing_blocktitle = give_translation('user_edit.listing_block_title', 'false', $config_showtranslationcode);
        $useredit_listing_blocktitle = str_replace('[#count_useredit]', $useredit_totaluser, $useredit_listing_blocktitle);
        $useredit_listing_blocktitle = str_replace('[#type_useredit]', $useredit_rights, $useredit_listing_blocktitle);
        $useredit_listing_blocktitle = str_replace('[#status_useredit]', $useredit_status, $useredit_listing_blocktitle);
    }
    else #search
    {
        #get session
        $useredit_search_keyword = $_SESSION['useredit_search_keyword'];
        $useredit_search_rights = $_SESSION['useredit_search_rights'];
        $useredit_search_status = $_SESSION['useredit_search_status'];
        $useredit_search_type = $_SESSION['useredit_search_type'];
        $useredit_search_order = $_SESSION['useredit_search_order'];
        
        #get rights translation
        if(!empty($useredit_search_rights) && $useredit_search_rights != 'all')
        {
            $prepared_query = 'SELECT * FROM user_rights
                               WHERE level_rights = :level';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('level', $useredit_search_rights);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $useredit_rights = give_translation('main.'.$data['name_rights'], 'false', $config_showtranslationcode);
            }
            $query->closeCursor();
        }
        else
        {
            $useredit_rights = null;
        }
        
        #get status translation
        switch ($useredit_search_status)
        {
            case 1:
                $useredit_status = give_translation('main.user_status_active', 'false', $config_showtranslationcode);
                break;
            case 2:
                $useredit_status = give_translation('main.user_status_onhold', 'false', $config_showtranslationcode);
                break;
            case 9:
                $useredit_status = give_translation('main.user_status_blocked', 'false', $config_showtranslationcode);
                break;
        }
        
        #count result
        $prepared_query = 'SELECT COUNT(id_user) FROM user
                           WHERE status_user = "'.$useredit_search_status.'" ';
        
        if(!empty($useredit_search_rights) && $useredit_search_rights != 'all')
        {
            $prepared_query .= 'AND rights_user = "'.$useredit_search_rights.'" ';
        }
                           
        if(!empty($useredit_search_keyword))
        {
            $prepared_query .= ' AND (';  
            $useredit_search_keyword = split_string(trim($useredit_search_keyword), ' ');
            
            for($i = 0, $count = count($useredit_search_keyword); $i < $count; $i++)
            {
                if($i == 0)
                {
                    $prepared_query .= ' firstname_user LIKE "%'.$useredit_search_keyword[$i].'%" 
                                        OR name_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR namecompany_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR city_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR zip_user LIKE "%'.$useredit_search_keyword[$i].'%"';
                }
                else
                {
                    $prepared_query .= ' OR firstname_user LIKE "%'.$useredit_search_keyword[$i].'%" 
                                        OR name_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR namecompany_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR city_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                        OR zip_user LIKE "%'.$useredit_search_keyword[$i].'%"';
                }
            }
            $prepared_query .= ') ';
        }
        $prepared_query .= ' ORDER BY COALESCE('.$useredit_search_type.', "z") '.$useredit_search_order;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $useredit_totaluser = $data[0];
        }
        $query->closeCursor();

        #[paging]
        if(empty($useredit_orderby_nrpage))
        {
            $useredit_orderby_nrpage = 25;
        }
        $paging_resultperpage = $useredit_orderby_nrpage;
        $paging_page_max = 5;
        $paging_countresult = $useredit_totaluser;
        //$paging_jsevent = 'onclick="OnChange(\'bt_checked_useredit\');"';
        include('modules/search/paging/paging_getinfo.php');
        
        $_SESSION['paging_defaultdisplay'] = 'false';
        if(empty($_SESSION['paging_limitmin']))
        {
            $useredit_limitmin = 0;
        }
        else
        {
            $useredit_limitmin = $_SESSION['paging_limitmin'];
        }

        if(empty($_SESSION['paging_limitmax']))
        {
            $useredit_limitmax = $paging_resultperpage;
        }
        else
        {
            $useredit_limitmax = $_SESSION['paging_limitmax'];
        }
        #[/paging]
        
        #prepared listing query
        $useredit_search_keyword = $_SESSION['useredit_search_keyword'];
        
        $useredit_preparedquery = 'SELECT * FROM user
                                   INNER JOIN user_rights
                                   ON user_rights.level_rights = user.rights_user
                                   WHERE status_user = "'.$useredit_search_status.'" ';
        if(!empty($useredit_search_rights) && $useredit_search_rights != 'all')
        {
            $useredit_preparedquery .= 'AND rights_user = "'.$useredit_search_rights.'" ';
        }
        
        if(!empty($useredit_search_keyword))
        {
            $useredit_preparedquery .= 'AND (';
            $useredit_search_keyword = split_string(trim($useredit_search_keyword), ' ');
            
            for($i = 0, $count = count($useredit_search_keyword); $i < $count; $i++)
            {
                if($i == 0)
                {
                    $useredit_preparedquery .= ' firstname_user LIKE "%'.$useredit_search_keyword[$i].'%" 
                                                OR name_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR namecompany_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR city_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR zip_user LIKE "%'.$useredit_search_keyword[$i].'%"';
                }
                else
                {
                    $useredit_preparedquery .= ' OR firstname_user LIKE "%'.$useredit_search_keyword[$i].'%" 
                                                OR name_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR namecompany_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR city_user LIKE "%'.$useredit_search_keyword[$i].'%"
                                                OR zip_user LIKE "%'.$useredit_search_keyword[$i].'%"';
                }
            }
            $useredit_preparedquery .= ') ';
        }
        $useredit_preparedquery .= ' ORDER BY COALESCE('.$useredit_search_type.', "z") '.$useredit_search_order;
        $useredit_preparedquery .= ' LIMIT '.$useredit_limitmin.', '.$useredit_limitmax;;

        $useredit_listing_blocktitle = give_translation('user_edit.listing_block_title', 'false', $config_showtranslationcode);
        $useredit_listing_blocktitle = str_replace('[#count_useredit]', $useredit_totaluser, $useredit_listing_blocktitle);
        if(!empty($useredit_rights) && $useredit_rights != 'all')
        {
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', give_translation('user_edit.listing_block_title_rights', 'false', $config_showtranslationcode), $useredit_listing_blocktitle);
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', $useredit_rights, $useredit_listing_blocktitle);
        }
        else 
        {
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', $useredit_rights, $useredit_listing_blocktitle);
        }
        $useredit_listing_blocktitle = str_replace('[#status_useredit]', $useredit_status, $useredit_listing_blocktitle);   
    }
    
    if($useredit_totaluser == 0)
    {
        $useredit_listing_blocktitle = give_translation('user_edit.listing_block_title_noresult', 'false', $config_showtranslationcode);
        if(!empty($useredit_rights) && $useredit_rights != 'all')
        {
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', give_translation('user_edit.listing_block_title_rights', 'false', $config_showtranslationcode), $useredit_listing_blocktitle);
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', $useredit_rights, $useredit_listing_blocktitle);
        }
        else
        {
            $useredit_listing_blocktitle = str_replace('[#type_useredit]', $useredit_rights, $useredit_listing_blocktitle);
        }
        $useredit_listing_blocktitle = str_replace('[#status_useredit]', $useredit_status, $useredit_listing_blocktitle);   
    }
    
    //$_SESSION['useredit_query'] = $useredit_preparedquery;       
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
