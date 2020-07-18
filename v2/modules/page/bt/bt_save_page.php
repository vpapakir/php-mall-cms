<?php
if(isset($_POST['bt_save_page']) || isset($_POST['bt_add_edit_page']) || isset($_POST['bt_radPageContent']))
{
    unset($_SESSION['page_property_txtPageCode'],
            $_SESSION['page_property_cboPageFamily'],
            $_SESSION['page_property_txtPageURL'],
            $_SESSION['page_property_txtPageScriptPath'],
            $_SESSION['page_property_cboPageAllowstats'],
            $_SESSION['page_property_cboPageStatus'],
            $_SESSION['page_property_radPageContent'],
            $_SESSION['page_property_radPageSearch'],
            $_SESSION['page_property_cboPageTemplate'],
            $_SESSION['page_property_txtPageListingFamilyKeyword'],
            $_SESSION['page_property_cboxPageListing'],
            $_SESSION['page_property_cboxPageListingRelated'],
            $_SESSION['page_property_txtPageListingKeyword'],
            $_SESSION['page_property_areaPageScriptAjaxPath'],
            $_SESSION['page_property_cboPageRights']);   
    
    unset($_SESSION['msg_page_property_txtPageCode'],
            $_SESSION['msg_page_property_txtPageURL'],
            $_SESSION['msg_page_savedone']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$i]],
                $_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$i]]);
        
        unset($_SESSION['txtPageTitleL'.$main_activatedidlang[$i]],
                $_SESSION['areaPageIntroL'.$main_activatedidlang[$i]],
                $_SESSION['areaPageDescL'.$main_activatedidlang[$i]],
                $_SESSION['txtPageBrowserL'.$main_activatedidlang[$i]],
                $_SESSION['areaPageTagsL'.$main_activatedidlang[$i]]);
    }
    
    for($i = 0, $count = count($idimage_saving_page); $i < $count; $i++)
    {
        unset($_SESSION['txtListNameImage'.$idimage_saving_page[$i]],
                $_SESSION['txtListAltImage'.$idimage_saving_page[$i]],
                $_SESSION['cboListPositionImage'.$idimage_saving_page[$i]]);
        
        for($y = 0, $count = count($main_activatedidlang); $y < $count; $y++)
        {
            unset($_SESSION['areaListTitleImage'.$idimage_saving_page[$i].'L'.$main_activatedidlang[$y]]);
        }
    }
    
    
    
    $msg_pageproperty_1a = 'Veuillez indiquer un code pour la page';
    $msg_pageproperty_1b = 'Le code doit comporter 3 à 56 caractères';
    $msg_pageproperty_1c = 'Caractères autorisés: 0-9, a-z, A-Z, et remplacer les espaces par: _ - .';
    
    $msg_pageproperty_2a = 'Veuillez indiquer une URL pour la page';
    $msg_pageproperty_2b = 'L\'URL doit comporter 3 à 56 caractères';
    $msg_pageproperty_2c = 'Caractères autorisés: 0-9, a-z, et remplacer les espaces par: _ -';
    $msg_pageproperty_2d = 'L\'URL que vous avez tapé existe déjà';
    
    $msg_page_savedone1 = 'La page "';
    $msg_page_savedone2 = '" a été créée';
    $msg_page_savedone3 = '" a été modifiée';
    
    #property
    $Bok_pageproperty = true;
    $listingfam_pageproperty = null;
    
    #[type text radio]
    if(isset($_POST['bt_radPageContent']))
    {
        $Bok_pageproperty = false;
    }
    
    $radcontent_selectedpage = trim(htmlspecialchars($_POST['radPageContent'], ENT_QUOTES));
    
    $_SESSION['page_property_radPageContent'] = $radcontent_selectedpage;
    
    if($radcontent_selectedpage == 'html')
    {
        $_SESSION['page_edit_active_ckEditor'] = true;
    }
    else
    {
        unset($_SESSION['page_edit_active_ckEditor']);
    }
    #[/type text radio]
    
    
    $selected_page = trim(htmlspecialchars($_SESSION['page_select_cboPageSelect'], ENT_QUOTES));
    
    $code_pageproperty = trim(htmlspecialchars($_POST['txtPageCode'], ENT_QUOTES));
    $family_pageproperty = trim(htmlspecialchars($_POST['cboPageFamily'], ENT_QUOTES));
    $url_pageproperty = trim(htmlspecialchars($_POST['txtPageURL'], ENT_QUOTES));
    $script_pageproperty = trim(htmlspecialchars($_POST['txtPageScriptPath'], ENT_QUOTES));
    $typecontent_pageproperty = trim(htmlspecialchars($_POST['radPageContent'], ENT_QUOTES));
    $status_search_pageproperty = trim(htmlspecialchars($_POST['radPageSearch'], ENT_QUOTES));
    $allowstats_pageproperty = trim(htmlspecialchars($_POST['cboPageAllowstats'], ENT_QUOTES));
    $status_pageproperty = trim(htmlspecialchars($_POST['cboPageStatus'], ENT_QUOTES));
    
    $template_pageproperty = trim(htmlspecialchars($_POST['cboPageTemplate'], ENT_QUOTES));
    $listingfamkey_pageproperty = trim(htmlspecialchars($_POST['txtPageListingFamilyKeyword'], ENT_QUOTES));
    $cbolistingfam_pageproperty = $_POST['cboxPageListing'];
    $cbolistingrelated_pageproperty = $_POST['cboxPageListingRelated'];
    $listingkeywords_pageproperty = trim(htmlspecialchars($_POST['txtPageListingKeyword'], ENT_QUOTES));
    
    $listingfamkey_pageproperty = str_replace(' ', '$', $listingfamkey_pageproperty);
    $listingfam_pageproperty = join_string($cbolistingfam_pageproperty, '$', '');
    $listingrelated_pageproperty = join_string($cbolistingrelated_pageproperty, '$', '');
    $listingkeywords_pageproperty = str_replace(' ', '$', $listingkeywords_pageproperty);
    
    $scriptajax_pageproperty = trim(htmlspecialchars($_POST['areaPageScriptAjaxPath'], ENT_QUOTES));
    $rights_pageproperty = $_POST['cboPageRights'];

    $userrights_pageproperty = null;
    
    if($rights_pageproperty[0] == 'all')
    {
        $userrights_pageproperty = 'all';
    }
    else
    {
        for($i = 0, $count = count($rights_pageproperty); $i < $count; $i++)
        {
            if($i == 0)
            {
               $userrights_pageproperty = $rights_pageproperty[$i];
            }
            else
            {
               $userrights_pageproperty .= ','.$rights_pageproperty[$i]; 
            }
        } 
        $userrights_pageproperty .= ',9';
    }
    
    
    
    #content
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $array_title_pagecontent[$i] = trim(addslashes(htmlspecialchars($_POST['txtPageTitleL'.$main_activatedidlang[$i]], ENT_QUOTES)));
        $array_intro_pagecontent[$i] = trim(addslashes($_POST['areaPageIntroL'.$main_activatedidlang[$i]]));
        $array_desc_pagecontent[$i] = trim(addslashes($_POST['areaPageDescL'.$main_activatedidlang[$i]]));
        $array_browser_pagecontent[$i] = trim(htmlspecialchars(addslashes($_POST['txtPageBrowserL'.$main_activatedidlang[$i]]), ENT_QUOTES));
        
        $array_tags_pagecontent[$i] = trim(addslashes($_POST['areaPageTagsL'.$main_activatedidlang[$i]]), ENT_QUOTES);

        $array_keyword_pagecontent[$i] = str_replace_char($array_tags_pagecontent[$i], $main_activatedidlang[$i], '', true);
        $array_tags_pagecontent[$i] = replace_dirtyword($array_keyword_pagecontent[$i], $main_activatedidlang[$i], '', true);
        
//        $count_duplicate_value = split_string($array_tags_pagecontent[$i], ' ');
//        $temparray_keyword_pagecontent = array_unique($count_duplicate_value);      
//        
//        $temp3array_keyword_pagecontent = join_2variablestring($temp2array_keyword_pagecontent, $temparray_keyword_pagecontent, ' ', '', $x);
//        $array_tags_pagecontent[$i] = $temp3array_keyword_pagecontent;
        
//        unset($temparray_keyword_pagecontent, $temp2array_keyword_pagecontent, $temp3array_keyword_pagecontent);
    }
    
    #URLRewriting
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $array_urlrewritingF_pageurl[$i] = trim(htmlspecialchars($_POST['txtPageURLRewritingF'.$main_activatedidlang[$i]], ENT_QUOTES));
        $array_urlrewritingB_pageurl[$i] = trim(htmlspecialchars($_POST['txtPageURLRewritingB'.$main_activatedidlang[$i]], ENT_QUOTES));
        
        if(empty($array_urlrewritingF_pageurl[$i]))
        {
            if(empty($array_title_pagecontent[$i]))
            {
                $array_urlrewritingF_pageurl[$i] = $url_pageproperty;
            }
            else
            {
                $array_urlrewritingF_pageurl[$i] = strtolower(str_replace_char($array_title_pagecontent[$i], $main_activatedidlang[$i], '', true));
                $array_urlrewritingF_pageurl[$i] = preg_replace('#[ ]{1,}#', ' ', $array_urlrewritingF_pageurl[$i]);
                $array_urlrewritingF_pageurl[$i] = preg_replace('#[ ]#', '-', $array_urlrewritingF_pageurl[$i]);
            }
        }
        
        if(empty($array_urlrewritingB_pageurl[$i]))
        {
            if(empty($array_title_pagecontent[$i]))
            {
                $array_urlrewritingB_pageurl[$i] = 'backoffice/'.$url_pageproperty;
            }
            else
            {
                $array_urlrewritingB_pageurl[$i] = strtolower(str_replace_char($array_title_pagecontent[$i], $main_activatedidlang[$i], '', true));
                $array_urlrewritingB_pageurl[$i] = preg_replace('#[ ]{1,}#', ' ', $array_urlrewritingB_pageurl[$i]);
                $array_urlrewritingB_pageurl[$i] = 'backoffice/'.preg_replace('#[ ]#', '-', $array_urlrewritingB_pageurl[$i]);
            }
        }
    }
    
    #image
    for($i = 0, $count = count($idimage_saving_page); $i < $count; $i++)
    {
        $arrayimage_name_pagecontent[$i] = trim(htmlspecialchars($_POST['txtListNameImage'.$idimage_saving_page[$i]], ENT_QUOTES));
        $arrayimage_alt_pagecontent[$i] = trim(htmlspecialchars($_POST['txtListAltImage'.$idimage_saving_page[$i]], ENT_QUOTES));
        $arrayimage_position_pagecontent[$i] = htmlspecialchars($_POST['cboListPositionImage'.$idimage_saving_page[$i]], ENT_QUOTES);
        
        for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
        {
            $arrayimage_title_pagecontent[$i][$y] = trim(htmlspecialchars($_POST['areaListTitleImage'.$idimage_saving_page[$i].'L'.$main_activatedidlang[$y]], ENT_QUOTES));
        }
    }
    
    if(empty($code_pageproperty))
    {
        $Bok_pageproperty = false;
        $_SESSION['msg_page_property_txtPageCode'] = $msg_pageproperty_1a;
    }
    else
    {
        if(strlen($code_pageproperty) < 3 || strlen($code_pageproperty) > 56)
        {
            $Bok_pageproperty = false;
            $_SESSION['msg_page_property_txtPageCode'] = $msg_pageproperty_1b;
        }
        else
        {   
            if(!preg_match('#^[0-9a-zA-Z_.-]{1,}$#', $code_pageproperty))
            {
                $Bok_pageproperty = false;
                $_SESSION['msg_page_property_txtPageCode'] = $msg_pageproperty_1c;
            }
        }
    }
    
    if(empty($url_pageproperty))
    {
        $Bok_pageproperty = false;
        $_SESSION['msg_page_property_txtPageURL'] = $msg_pageproperty_2a;
    }
    else
    {
        if(strlen($url_pageproperty) < 3 || strlen($url_pageproperty) > 56)
        {
            $Bok_pageproperty = false;
            $_SESSION['msg_page_property_txtPageURL'] = $msg_pageproperty_2b;
        }
        else
        {
            
            if(!preg_match('#^[0-9a-z_-]{1,}$#', $url_pageproperty))
            {
                $Bok_pageproperty = false;
                $_SESSION['msg_page_property_txtPageURL'] = $msg_pageproperty_2c;
            }
            else
            {
                if($selected_page == 'new' || empty($selected_page))
                {
                    try
                    {
                        $prepared_query = 'SELECT url_page FROM page
                                           WHERE url_page = :url';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('url', $url_pageproperty);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            $Bok_pageproperty = false;
                            $_SESSION['msg_page_property_txtPageURL'] = $msg_pageproperty_2d;
                        }
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
                }
            }
        }
    }
    
    if($Bok_pageproperty === true)
    {
        try
        {
            if($selected_page == 'new' || empty($selected_page))
            {
                include('modules/page/bt/bt_save_page/page_insert.php');
            }
            else
            {
                include('modules/page/bt/bt_save_page/page_update.php');
            }
            
            include('modules/settings/urlrewriting/rewriting_main.php');
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
    }
    else
    {
        $_SESSION['page_property_txtPageCode'] = $code_pageproperty;
        $_SESSION['page_property_cboPageFamily'] = $family_pageproperty;
        $_SESSION['page_property_txtPageURL'] = $url_pageproperty;
        $_SESSION['page_property_txtPageScriptPath'] = $script_pageproperty;
        $_SESSION['page_property_radPageContent'] = $typecontent_pageproperty;
        $_SESSION['page_property_cboPageStatus'] = $status_pageproperty;
        $_SESSION['page_property_radPageSearch'] = $status_search_pageproperty;
        $_SESSION['page_property_cboPageAllowstats'] = $allowstats_pageproperty;
        $_SESSION['page_property_cboPageTemplate'] = $template_pageproperty;
        $_SESSION['page_property_txtPageListingFamilyKeyword'] = $listingfamkey_pageproperty;
        $_SESSION['page_property_cboxPageListing'] = $listingfam_pageproperty;
        $_SESSION['page_property_cboxPageListingRelated'] = $listingrelated_pageproperty;
        $_SESSION['page_property_txtPageListingKeyword'] = $listingkeywords_pageproperty;
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$i]] = $array_urlrewritingF_pageurl[$i];
            $_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$i]] = $array_urlrewritingB_pageurl[$i];
            
            $_SESSION['txtPageTitleL'.$main_activatedidlang[$i]] = stripslashes($array_title_pagecontent[$i]);
            $_SESSION['areaPageIntroL'.$main_activatedidlang[$i]] = stripslashes($array_intro_pagecontent[$i]);
            $_SESSION['areaPageDescL'.$main_activatedidlang[$i]] = stripslashes($array_desc_pagecontent[$i]);
            $_SESSION['txtPageBrowserL'.$main_activatedidlang[$i]] = stripslashes($array_browser_pagecontent[$i]);
            $_SESSION['areaPageTagsL'.$main_activatedidlang[$i]] = stripslashes($array_tags_pagecontent[$i]);
        }
        
        for($i = 0, $count = count($idimage_saving_page); $i < $count; $i++)
        {
            $_SESSION['txtListNameImage'.$idimage_saving_page[$i]] = $arrayimage_name_pagecontent[$i];
            $_SESSION['txtListAltImage'.$idimage_saving_page[$i]] = $arrayimage_alt_pagecontent[$i];
            $_SESSION['cboListPositionImage'.$idimage_saving_page[$i]] = $array_position_pagecontent[$i];
            
            for($y = 0, $count = count($main_activatedidlang); $y < $count; $y++)
            {
                $_SESSION['areaListTitleImage'.$idimage_saving_page[$i].'L'.$main_activatedidlang[$y]] = $arrayimage_title_pagecontent[$i][$y];
            }
        }
        
        $_SESSION['page_property_areaPageScriptAjaxPath'] = $scriptajax_pageproperty;
        $_SESSION['page_property_cboPageRights'] = $userrights_pageproperty;
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
