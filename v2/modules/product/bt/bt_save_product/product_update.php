<?php
$prepared_query = 'UPDATE page
                   SET status_page = :status,
                       status_search_page = :status_search,
                       template_page = :template, 
                       code_page = :code,
                       family_page = :family,
                       url_page = :url,
                       script_page = :script,
                       listingfamkey_page = :listfamkey,
                       listingfam_page = :listfam, 
                       listingrelated_page = :listrelated,
                       listingkey_page = :listkey,
                       ajaxpath_page = :scriptajax,
                       level_rights = :level,
                       allowstats_page = :allowstats
                   WHERE id_page = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'status' => $status_productproperty,
                      'status_search' => $status_search_productproperty,
                      'template' => $template_productproperty,
                      'code' => $code_productproperty,
                      'family' => $family_productproperty,
                      'url' => $url_productproperty,
                      'script' => $script_productproperty,
                      'listfamkey' => $listingfamkey_productproperty,
                      'listfam' => $listingfam_productproperty,
                      'listrelated' => $listingrelated_productproperty,
                      'listkey' => $listingkeywords_productproperty,
                      'scriptajax' => $scriptajax_productproperty,
                      'level' => $userrights_productproperty,
                      'allowstats' => $allowstats_productproperty,
                      'id' => $selected_product
                      ));
$query->closeCursor();

include('modules/product/bt/bt_save_product/product_translation_update.php');
include('modules/product/bt/bt_save_product/product_image_update.php');

#custom
if(!empty($config_module_immo) && $config_module_immo == 1)
{
    include('modules/custom/immo/modules/Kprodimmo/bt/update.php');
    include('modules/custom/immo/modules/Kprodimmo/bt/keepsession.php');
} else {
    include('modules/custom/multishop/modules/Kprodimmo/bt/update.php');
    include('modules/custom/multishop/modules/Kprodimmo/bt/keepsession.php');
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
    $_SESSION['product_url_txtProductURLRewritingF'.$main_activatedidlang[$i]] = $array_urlrewritingF_producturl[$i];
    $_SESSION['product_url_txtProductURLRewritingB'.$main_activatedidlang[$i]] = $array_urlrewritingB_producturl[$i];

    $_SESSION['txtProductTitleL'.$main_activatedidlang[$i]] = stripslashes($array_title_productcontent[$i]);
    $_SESSION['areaProductIntroL'.$main_activatedidlang[$i]] = stripslashes($array_intro_productcontent[$i]);
    $_SESSION['areaProductDescL'.$main_activatedidlang[$i]] = stripslashes($array_desc_productcontent[$i]);
    $_SESSION['txtProductBrowserL'.$main_activatedidlang[$i]] = stripslashes($array_browser_productcontent[$i]);
    $_SESSION['areaProductTagsL'.$main_activatedidlang[$i]] = stripslashes($array_tags_productcontent[$i]);
    
    if($main_activatedidlang[$i] == $main_id_language)
    {
        $productedit_selected_lang = $i;
    }
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

if(empty($array_title_productcontent[$productedit_selected_lang]))
{
    $productedit_namesave = $url_productproperty;
}
else
{
    $productedit_namesave = $array_title_productcontent[$productedit_selected_lang];
}

$msg_product_savedone_edit = str_replace('[#name_product]', $productedit_namesave, $msg_product_savedone_edit);
$_SESSION['msg_product_savedone'] = $msg_product_savedone_edit;
?>
