<?php
if(isset($_POST['bt_cboPageSelect']) || $_POST['bt_add_edit_page'] || isset($_GET['pg']))
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
    
    if(!isset($_POST['bt_add_edit_page']))
    {
        if(!isset($_GET['pg']))
        {
            $selected_page_selector = trim(htmlspecialchars($_POST['cboPageSelect'], ENT_QUOTES)); 
        }
        else
        {
            $selected_page_selector = trim(htmlspecialchars($_GET['pg'], ENT_QUOTES));
        }
    }
    else
    {
        $selected_page_selector = $_SESSION['page_add_edit_lastidpage'];
    }
    
    
    if($selected_page_selector == 'new')
    {
        $_SESSION['page_edit_display_content'] = false;
    }
    else
    {
        $_SESSION['page_edit_display_content'] = true;
        try
        {
            $prepared_query = 'SELECT * FROM page
                               INNER JOIN page_translation AS pt
                               ON pt.id_page = page.id_page
                               WHERE page.id_page = :id
                               AND family_page_translation = \'title\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['page_property_txtPageCode'] = $data['code_page'];
                $_SESSION['page_property_cboPageFamily'] = $data['family_page'];
                $_SESSION['page_property_txtPageURL'] = $data['url_page'];
                $_SESSION['page_property_txtPageScriptPath'] = $data['script_page'];
                $_SESSION['page_property_cboPageStatus'] = $data['status_page'];
                $_SESSION['page_property_radPageContent'] = $data['typecontent_page_translation'];
                $_SESSION['page_property_radPageSearch'] = $data['status_search_page'];
                $_SESSION['page_property_cboPageTemplate'] = $data['template_page'];
                $_SESSION['page_property_txtPageListingFamilyKeyword'] = $data['listingfamkey_page'];
                $_SESSION['page_property_cboxPageListing'] = $data['listingfam_page'];
                $_SESSION['page_property_cboxPageListingRelated'] = $data['listingrelated_page'];
                $_SESSION['page_property_txtPageListingKeyword'] = $data['listingkey_page'];
                $_SESSION['page_property_areaPageScriptAjaxPath'] = $data['ajaxpath_page'];
                $_SESSION['page_property_cboPageRights'] = $data['level_rights'];
                $_SESSION['page_property_cboPageAllowstats'] = $data['allowstats_page'];
            }
            $query->closeCursor();
            
            
            #get image title (legend)
            $prepared_query = 'SELECT * FROM page_image
                               WHERE id_page = :id
                               ORDER BY position_image';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            while($data = $query->fetch())
            {
                for($y = 0, $count = count($main_activatedidlang); $y < $count; $y++)
                {
                    $_SESSION['areaListTitleImage'.$data[0].'L'.$main_activatedidlang[$y]] = $data['L'.$main_activatedidlang[$y]];
                }
            }
            $query->closeCursor();
            
            #get title
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = "title"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['txtPageTitleL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get intro
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = "intro"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaPageIntroL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get desc
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = "desc"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaPageDescL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get browser
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = "browser"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['txtPageBrowserL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get tags
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = "tags"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaPageTagsL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();

            #get url rewriting Frontend
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = \'rewritingF\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();

            #get url rewriting Backoffice
            $prepared_query = 'SELECT * FROM page_translation AS pt
                               WHERE id_page = :id
                               AND family_page_translation = \'rewritingB\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_page_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();

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
    
    $_SESSION['page_select_cboPageSelect'] = $selected_page_selector;
    
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
