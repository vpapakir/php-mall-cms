<?php
if(isset($_POST['bt_radProductContent']))
{
    $radcontent_selectedproduct = trim(htmlspecialchars($_POST['radProductContent'], ENT_QUOTES));
    
    $_SESSION['product_property_radProductContent'] = $radcontent_selectedproduct;
    
    $_SESSION['product_property_txtProductCode'] = trim(htmlspecialchars($_POST['txtProductCode'], ENT_QUOTES));
    $_SESSION['product_property_cboProductFamily'] = trim(htmlspecialchars($_POST['cboProductFamily'], ENT_QUOTES));
    $_SESSION['product_property_txtProductURL'] = trim(htmlspecialchars($_POST['txtProductURL'], ENT_QUOTES));
    $_SESSION['product_property_txtProductScriptPath'] = trim(htmlspecialchars($_POST['txtProductScriptPath'], ENT_QUOTES));
    $_SESSION['product_property_cboProductStatus'] = trim(htmlspecialchars($_POST['cboProductStatus'], ENT_QUOTES));
    $_SESSION['product_property_radProductContent'] = $radcontent_selectedproduct;
    $_SESSION['product_property_radProductSearch'] = trim(htmlspecialchars($_POST['radProductSearch'], ENT_QUOTES));
    $_SESSION['product_property_cboProductTemplate'] = trim(htmlspecialchars($_POST['cboProductTemplate'], ENT_QUOTES));
    
    $listingfamkey_productproperty = trim(htmlspecialchars($_POST['txtProductListingFamilyKeyword'], ENT_QUOTES));
    $listingfam_productproperty = $_POST['cboxProductListing'];
    $listingrelated_productproperty = $_POST['cboxProductListingRelated'];
    $listingkeywords_productproperty = trim(htmlspecialchars($_POST['txtProductListingKeyword'], ENT_QUOTES));
    
    
    $listingfamkey_productproperty = str_replace(' ', '$', $listingfamkey_productproperty);
    $listingfam_productproperty = join_string($cbolistingfam_productproperty, '$', '');
    $listingrelated_productproperty = join_string($cbolistingrelated_productproperty, '$', '');
    $listingkeywords_productproperty = str_replace(' ', '$', $listingkeywords_productproperty);
    
    $_SESSION['product_property_txtProductListingFamilyKeyword'] = $listingfamkey_productproperty;
    $_SESSION['product_property_cboxProductListing'] = $listingfam_productproperty;
    $_SESSION['product_property_cboxProductListingRelated'] = $listingrelated_productproperty;
    $_SESSION['product_property_txtProductListingKeyword'] = $listingkeywords_productproperty;
    
    if($radcontent_selectedproduct == 'html')
    {
        $_SESSION['product_edit_active_ckEditor'] = true;
    }
    else
    {
        unset($_SESSION['product_edit_active_ckEditor']);
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
