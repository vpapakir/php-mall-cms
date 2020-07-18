<?php
if(isset($_POST['bt_save_product']) || isset($_POST['bt_add_edit_product']) || isset($_POST['bt_radProductContent']))
{
    #custom
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
		$prepared_query = 'SELECT * FROM config_module';
		if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
		$query = $connectData->prepare($prepared_query);
		$query->execute();
		while(($data = $query->fetch()) != false)
		{
			if($data['element_id'] == 'adminconfig_edit.module_immo') {
				if($data['immo_module'] == 1) { // If immo module is active
					include('modules/custom/immo/modules/Kprodimmo/bt/unsetsession.php');
				} else {
					include('modules/custom/multishop/modules/Kprodimmo/bt/unsetsession.php');
				}
			}
		}
        
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
        unset($_SESSION['page_url_txtProductURLRewritingF'.$main_activatedidlang[$i]],
                $_SESSION['page_url_txtProductURLRewritingB'.$main_activatedidlang[$i]]);
        
        unset($_SESSION['txtProductTitleL'.$main_activatedidlang[$i]],
                $_SESSION['areaProductIntroL'.$main_activatedidlang[$i]],
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
    $msg_productproperty_1a = give_translation('messages.msg_error_emptycode_product', 'false', $config_showtranslationcode);
    $msg_productproperty_1b = give_translation('messages.msg_error_codelength_product', 'false', $config_showtranslationcode);
    $msg_productproperty_1c = give_translation('messages.msg_error_codeallowedchars_product', 'false', $config_showtranslationcode);
    
    $msg_productproperty_2a = give_translation('messages.msg_error_emptyurl_product', 'false', $config_showtranslationcode);
    $msg_productproperty_2b = give_translation('messages.msg_error_urllength_product', 'false', $config_showtranslationcode);
    $msg_productproperty_2c = give_translation('messages.msg_error_urlallowedchars_product', 'false', $config_showtranslationcode);
    $msg_productproperty_2d = give_translation('messages.msg_error_urlalreadyexist_product', 'false', $config_showtranslationcode);
    
    $msg_product_savedone_add = give_translation('messages.msg_done_add_product', 'false', $config_showtranslationcode);
    $msg_product_savedone_edit = give_translation('messages.msg_done_edit_product', 'false', $config_showtranslationcode);
    
    #property
    $Bok_productproperty = true;
    $listingfam_productproperty = null;
    
    #[type text radio]
    if(isset($_POST['bt_radProductContent']))
    {
        $Bok_productproperty = false;
    }
    
    $radcontent_selectedproduct = trim(htmlspecialchars($_POST['radProductContent'], ENT_QUOTES));
    $_SESSION['product_property_radProductContent'] = $radcontent_selectedproduct;
    if($radcontent_selectedproduct == 'html')
    {
        $_SESSION['product_edit_active_ckEditor'] = true;
    }
    else
    {
        unset($_SESSION['product_edit_active_ckEditor']);
    }
    #[/type text radio]
    
    #custom
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
        include('modules/custom/immo/modules/Kprodimmo/bt/callinfo.php');
    }
    
    #property
    $selected_product = trim(htmlspecialchars($_SESSION['product_select_cboProductSelect'], ENT_QUOTES));
    
    $code_productproperty = trim(htmlspecialchars($_POST['txtProductCode'], ENT_QUOTES));
    $family_productproperty = trim(htmlspecialchars($_POST['cboProductFamily'], ENT_QUOTES));
    $url_productproperty = trim(htmlspecialchars($_POST['txtProductURL'], ENT_QUOTES));
    $script_productproperty = trim(htmlspecialchars($_POST['txtProductScriptPath'], ENT_QUOTES));
    $typecontent_productproperty = trim(htmlspecialchars($_POST['radProductContent'], ENT_QUOTES));
    $status_search_productproperty = trim(htmlspecialchars($_POST['radProductSearch'], ENT_QUOTES));
    $allowstats_productproperty = trim(htmlspecialchars($_POST['cboProductAllowstats'], ENT_QUOTES));
    $status_productproperty = trim(htmlspecialchars($_POST['cboProductStatus'], ENT_QUOTES));
    
    $template_productproperty = trim(htmlspecialchars($_POST['cboProductTemplate'], ENT_QUOTES));
    $listingfamkey_productproperty = trim(htmlspecialchars($_POST['txtProductListingFamilyKeyword'], ENT_QUOTES));
    $cbolistingfam_productproperty = $_POST['cboxProductListing'];
    $cbolistingrelated_productproperty = $_POST['cboxProductListingRelated'];
    $listingkeywords_productproperty = trim(htmlspecialchars($_POST['txtProductListingKeyword'], ENT_QUOTES));
    
    $listingfamkey_productproperty = str_replace(' ', '$', $listingfamkey_productproperty);
    $listingfam_productproperty = join_string($cbolistingfam_productproperty, '$', '');
    $listingrelated_productproperty = join_string($cbolistingrelated_productproperty, '$', '');
    $listingkeywords_productproperty = str_replace(' ', '$', $listingkeywords_productproperty);
    $scriptajax_productproperty = trim(htmlspecialchars($_POST['areaProductScriptAjaxPath'], ENT_QUOTES));
    $rights_productproperty = $_POST['cboProductRights'];

    $userrights_productproperty = null;

    if($rights_productproperty[0] == 'all')
    {
        $userrights_productproperty = 'all';
    }
    else
    {
        for($i = 0, $count = count($rights_productproperty); $i < $count; $i++)
        {
            if($i == 0)
            {
               $userrights_productproperty = $rights_productproperty[$i];
            }
            else
            {
               $userrights_productproperty .= ','.$rights_productproperty[$i];               
            }
        } 
        $userrights_productproperty .= ',9';
    }
    
    #content
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $array_title_productcontent[$i] = trim(addslashes(htmlspecialchars($_POST['txtProductTitleL'.$main_activatedidlang[$i]], ENT_QUOTES)));
        $array_intro_productcontent[$i] = trim(addslashes($_POST['areaProductIntroL'.$main_activatedidlang[$i]]));
        $array_desc_productcontent[$i] = trim(addslashes($_POST['areaProductDescL'.$main_activatedidlang[$i]]));
        $array_browser_productcontent[$i] = trim(htmlspecialchars(addslashes($_POST['txtProductBrowserL'.$main_activatedidlang[$i]]), ENT_QUOTES));
        
        $array_tags_productcontent[$i] = trim(htmlspecialchars(addslashes($_POST['areaProductTagsL'.$main_activatedidlang[$i]]), ENT_QUOTES));
        #[custom]
        if(!empty($array_tags_productcontent[$i]))
        {
            $array_tags_productcontent[$i] = str_replace($kprodimmo_reference_general, '', $array_tags_productcontent[$i]);
            if(!empty($array_tags_productcontent[$i]))
            {
                $array_tags_productcontent[$i] .= ' ';
            }
        }
        $array_tags_productcontent[$i] .= strtolower($kprodimmo_reference_general);
        #[/custom]
        $array_keyword_productcontent[$i] = str_replace_char($array_tags_productcontent[$i], $main_activatedidlang[$i], '', true);
        $array_tags_productcontent[$i] = replace_dirtyword($array_keyword_productcontent[$i], $main_activatedidlang[$i], '', true);
        
        
        
    }
    
    #URLRewriting
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $array_urlrewritingF_producturl[$i] = trim(htmlspecialchars($_POST['txtProductURLRewritingF'.$main_activatedidlang[$i]], ENT_QUOTES));
        $array_urlrewritingB_producturl[$i] = trim(htmlspecialchars($_POST['txtProductURLRewritingB'.$main_activatedidlang[$i]], ENT_QUOTES));
        
        if(empty($array_urlrewritingF_producturl[$i]))
        {
            if(empty($array_title_productcontent[$i]))
            {
                $array_urlrewritingF_producturl[$i] = $url_pageproperty;
            }
            else
            {
                $array_urlrewritingF_producturl[$i] = strtolower(str_replace_char($array_title_productcontent[$i], $main_activatedidlang[$i], '', true));
                $array_urlrewritingF_producturl[$i] = preg_replace('#[ ]{1,}#', ' ', $array_urlrewritingF_producturl[$i]);
                $array_urlrewritingF_producturl[$i] = preg_replace('#[ ]#', '-', $array_urlrewritingF_producturl[$i]);
            }
        }
        
        if(empty($array_urlrewritingB_producturl[$i]))
        {
            if(empty($array_title_productcontent[$i]))
            {
                $array_urlrewritingB_producturl[$i] = 'backoffice/'.$url_pageproperty;
            }
            else
            {
                $array_urlrewritingB_producturl[$i] = strtolower(str_replace_char($array_title_productcontent[$i], $main_activatedidlang[$i], '', true));
                $array_urlrewritingB_producturl[$i] = preg_replace('#[ ]{1,}#', ' ', $array_urlrewritingB_producturl[$i]);
                $array_urlrewritingB_producturl[$i] = 'backoffice/'.preg_replace('#[ ]#', '-', $array_urlrewritingB_producturl[$i]);
            }
        }
    }
    
    #image
    for($i = 0, $count = count($idimage_saving_product); $i < $count; $i++)
    {
        $arrayimage_name_productcontent[$i] = trim(htmlspecialchars($_POST['txtListNameImage'.$idimage_saving_product[$i]], ENT_QUOTES));
        $arrayimage_alt_productcontent[$i] = trim(htmlspecialchars($_POST['txtListAltImage'.$idimage_saving_product[$i]], ENT_QUOTES));
        $arrayimage_position_productcontent[$i] = htmlspecialchars($_POST['cboListPositionImage'.$idimage_saving_product[$i]], ENT_QUOTES);
        
        for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
        {
            $arrayimage_title_productcontent[$i][$y] = trim(htmlspecialchars($_POST['areaListTitleImage'.$idimage_saving_product[$i].'L'.$main_activatedidlang[$y]], ENT_QUOTES));
        }
    }
    
    if(empty($code_productproperty))
    {
        $Bok_productproperty = false;
        $_SESSION['msg_product_property_txtProductCode'] = $msg_productproperty_1a;
    }
    else
    {
        if(strlen($code_productproperty) < 3 || strlen($code_productproperty) > 56)
        {
            $Bok_productproperty = false;
            $_SESSION['msg_product_property_txtProductCode'] = $msg_productproperty_1b;
        }
        else
        {   
            if(!preg_match('#^[0-9a-zA-Z_.-]{1,}$#', $code_productproperty))
            {
                $Bok_productproperty = false;
                $_SESSION['msg_product_property_txtProductCode'] = $msg_productproperty_1c;
            }
        }
    }
    
    if(empty($url_productproperty))
    {
        $Bok_productproperty = false;
        $_SESSION['msg_product_property_txtProductURL'] = $msg_productproperty_2a;
    }
    else
    {
        if(strlen($url_productproperty) < 3 || strlen($url_productproperty) > 56)
        {
            $Bok_productproperty = false;
            $_SESSION['msg_product_property_txtProductURL'] = $msg_productproperty_2b;
        }
        else
        {
            
            if(!preg_match('#^[0-9a-z_-]{1,}$#', $url_productproperty))
            {
                $Bok_productproperty = false;
                $_SESSION['msg_product_property_txtProductURL'] = $msg_productproperty_2c;
            }
            else
            {
                
                    try
                    {
                        if($selected_product == 'new' || empty($selected_product))
                        {
                            $prepared_query = 'SELECT url_page FROM page
                                               WHERE url_page = :url';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('url', $url_productproperty);
                            $query->execute();

                            if(($data = $query->fetch()) != false)
                            {
                                $Bok_productproperty = false;
                                $_SESSION['msg_product_property_txtProductURL'] = $msg_productproperty_2d;
                            }
                        }
                        else
                        {
                            $prepared_query = 'SELECT url_page FROM page
                                               WHERE url_page = :url
                                               AND id_page <> :id';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'url' => $url_productproperty,
                                                  'id' => $selected_product
                                                  ));

                            if(($data = $query->fetch()) != false)
                            {
                                $Bok_productproperty = false;
                                $_SESSION['msg_product_property_txtProductURL'] = $msg_productproperty_2d;
                            }
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
    
    if($Bok_productproperty === true)
    {
        try
        {
            if($selected_product == 'new' || empty($selected_product))
            {
                include('modules/product/bt/bt_save_product/product_insert.php');
            }
            else
            {
                include('modules/product/bt/bt_save_product/product_update.php');
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
        #custom
        if(!empty($config_module_immo) && $config_module_immo == 1)
        {
            include('modules/custom/immo/modules/Kprodimmo/bt/keepsession.php');
        }
        
        $_SESSION['product_property_txtProductCode'] = $code_productproperty;
        $_SESSION['product_property_cboProductFamily'] = $family_productproperty;
        $_SESSION['product_property_txtProductURL'] = $url_productproperty;
        $_SESSION['product_property_txtProductScriptPath'] = $script_productproperty;
        $_SESSION['product_property_cboProductStatus'] = $status_productproperty;
        $_SESSION['product_property_radProductSearch'] = $status_search_productproperty;
        $_SESSION['product_property_cboProductAllowstats'] = $allowstats_productproperty;
        $_SESSION['product_property_cboProductTemplate'] = $template_productproperty;
        $_SESSION['product_property_txtProductListingFamilyKeyword'] = $listingfamkey_productproperty;
        $_SESSION['product_property_cboxProductListing'] = $listingfam_productproperty;
        $_SESSION['product_property_cboxProductListingRelated'] = $listingrelated_productproperty;
        $_SESSION['product_property_txtProductListingKeyword'] = $listingkeywords_productproperty;
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['page_url_txtProductURLRewritingF'.$main_activatedidlang[$i]] = $array_urlrewritingF_producturl[$i];
            $_SESSION['page_url_txtProductURLRewritingB'.$main_activatedidlang[$i]] = $array_urlrewritingB_producturl[$i];
            
            $_SESSION['txtProductTitleL'.$main_activatedidlang[$i]] = stripslashes($array_title_productcontent[$i]);
            $_SESSION['areaProductIntroL'.$main_activatedidlang[$i]] = stripslashes($array_intro_productcontent[$i]);
            $_SESSION['areaProductDescL'.$main_activatedidlang[$i]] = stripslashes($array_desc_productcontent[$i]);
            $_SESSION['txtProductBrowserL'.$main_activatedidlang[$i]] = stripslashes($array_browser_productcontent[$i]);
            $_SESSION['areaProductTagsL'.$main_activatedidlang[$i]] = stripslashes($array_tags_productcontent[$i]);
        }
        
        for($i = 0, $count = count($idimage_saving_product); $i < $count; $i++)
        {
            $_SESSION['txtListNameImage'.$idimage_saving_product[$i]] = $arrayimage_name_productcontent[$i];
            $_SESSION['txtListAltImage'.$idimage_saving_product[$i]] = $arrayimage_alt_productcontent[$i];
            $_SESSION['cboListPositionImage'.$idimage_saving_product[$i]] = $array_position_productcontent[$i];
            
            for($y = 0, $count = count($main_activatedidlang); $y < $count; $y++)
            {
                $_SESSION['areaListTitleImage'.$idimage_saving_product[$i].'L'.$main_activatedidlang[$y]] = $arrayimage_title_productcontent[$i][$y];
            }
        }
        
        $_SESSION['product_property_areaProductScriptAjaxPath'] = $scriptajax_productproperty;
        $_SESSION['product_property_cboProductRights'] = $userrights_productproperty;
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
