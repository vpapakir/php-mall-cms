<?php
if(isset($_POST['bt_cboProductSelect']) || isset($_GET['product']) || !empty($_SESSION['product_addedit_id']))
{
    #custom
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
        include('modules/custom/immo/modules/Kprodimmo/bt/unsetsession.php');
    }
    
    unset($_SESSION['product_property_txtProductCode'],
            $_SESSION['product_property_cboProductFamily'],
            $_SESSION['product_property_txtProductURL'],
            $_SESSION['product_property_txtProductScriptPath'],
            $_SESSION['product_property_cboProductAllowstats'],
            $_SESSION['product_property_cboProductStatus'],
            $_SESSION['product_property_radProductContent'],
            $_SESSION['product_property_radProductSearch'],
            $_SESSION['product_property_cboProductTemplate'],
            $_SESSION['product_property_txtProductListingFamilyKeyword'],
            $_SESSION['product_property_cboxProductListing'],
            $_SESSION['product_property_cboxProductListingRelated'],
            $_SESSION['product_property_txtProductListingKeyword'],
            $_SESSION['product_property_areaProductScriptAjaxPath'],
            $_SESSION['product_property_cboProductRights']);
    
    unset($_SESSION['msg_product_property_txtProductCode'],
            $_SESSION['msg_product_property_txtProductURL'],
            $_SESSION['msg_product_savedone']);
    
    
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['product_url_txtProductURLRewritingF'.$main_activatedidlang[$i]],
                $_SESSION['product_url_txtProductURLRewritingB'.$main_activatedidlang[$i]]);
        
        unset($_SESSION['txtProductTitleL'.$main_activatedidlang[$i]],
                $_SESSION['areaProductIntroL1'.$main_activatedidlang[$i]],
                $_SESSION['areaProductDescL'.$main_activatedidlang[$i]],
                $_SESSION['txtProductBrowserL'.$main_activatedidlang[$i]],
                $_SESSION['areaProductTagsL'.$main_activatedidlang[$i]]);
    }
    
    for($i = 0, $count = count($idimage_saving_product); $i < $count; $i++)
    {
        unset($_SESSION['txtListNameImage'.$idimage_saving_product[$i]],
                $_SESSION['txtListAltImage'.$idimage_saving_product[$i]],
                $_SESSION['cboListPositionImage'.$idimage_saving_product[$i]]);
        
        for($y = 0, $count = count($main_activatedidlang); $y < $count; $y++)
        {
            unset($_SESSION['areaListTitleImage'.$idimage_saving_product[$i].'L'.$main_activatedidlang[$y]]);
        }
    }
    
    if(empty($_SESSION['product_addedit_id']))
    {
        if(!isset($_GET['product']))
        {
            $selected_product_selector = trim(htmlspecialchars($_POST['cboProductSelect'], ENT_QUOTES)); 
        }
        else
        {
            $selected_product_selector = trim(htmlspecialchars($_GET['product'], ENT_QUOTES));
        }
    }
    else
    {
        $selected_product_selector = $_SESSION['product_addedit_id'];
        unset($_SESSION['product_addedit_id']);
    }
    
    
    if($selected_product_selector == 'new')
    {
        $_SESSION['product_edit_display_content'] = false;
    }
    else
    {
        $_SESSION['product_edit_display_content'] = true;
        try
        {
            $prepared_query = 'SELECT * FROM page
                               INNER JOIN page_translation AS pt
                               ON pt.id_page = page.id_page
                               WHERE page.id_page = :id
                               AND family_page_translation = \'title\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['product_property_txtProductCode'] = $data['code_page'];
                $_SESSION['product_property_cboProductFamily'] = $data['family_page'];
                $_SESSION['product_property_txtProductURL'] = $data['url_page'];
                $_SESSION['product_property_txtProductScriptPath'] = $data['script_page'];
                $_SESSION['product_property_cboProductStatus'] = $data['status_page'];
                $_SESSION['product_property_radProductContent'] = $data['typecontent_page_translation'];
                $_SESSION['product_property_radProductSearch'] = $data['status_search_page'];
                $_SESSION['product_property_cboProductTemplate'] = $data['template_page'];
                $_SESSION['product_property_txtProductListingFamilyKeyword'] = $data['listingfamkey_page'];
                $_SESSION['product_property_cboxProductListing'] = $data['listingfam_page'];
                $_SESSION['product_property_cboxProductListingRelated'] = $data['listingrelated_page'];
                $_SESSION['product_property_txtProductListingKeyword'] = $data['listingkey_page'];
                $_SESSION['product_property_areaProductScriptAjaxPath'] = $data['ajaxpath_page'];
                $_SESSION['product_property_cboProductRights'] = $data['level_rights'];
                $_SESSION['product_property_cboProductAllowstats'] = $data['allowstats_page'];
            }
            $query->closeCursor();
            
            
            #get image title (legend)
            $prepared_query = 'SELECT * FROM page_image
                               WHERE id_page = :id
                               ORDER BY position_image';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
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
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = "title"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['txtProductTitleL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get intro
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = "intro"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaProductIntroL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            
            
            #get desc
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = "desc"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaProductDescL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get browser
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = "browser"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['txtProductBrowserL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #get tags
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = "tags"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['areaProductTagsL'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();

            #get url rewriting Frontend
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = \'rewritingF\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['product_url_txtProductURLRewritingF'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();

            #get url rewriting Backoffice
            $prepared_query = 'SELECT * FROM page_translation
                               WHERE id_page = :id
                               AND family_page_translation = \'rewritingB\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_product_selector);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['product_url_txtProductURLRewritingB'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i]];
                }
            }
            $query->closeCursor();
            
            #custom
            if(!empty($config_module_immo) && $config_module_immo == 1)
            {
                include('modules/custom/immo/modules/Kprodimmo/bt/select.php');
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
    
    $_SESSION['product_select_cboProductSelect'] = $selected_product_selector;
    
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
