<?php
try
{
    $prepared_query = 'SELECT listingfamkey_page
                       FROM page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $temp_listingfamilykey_productproperty = null;
    
    while($data = $query->fetch())
    {
        if(!empty($data[0]))
        {
            if($temp_listingfamilykey_productproperty != null)
            {
                $temp_listingfamilykey_productproperty .= '$'.$data[0];
            }
            else
            {
                $temp_listingfamilykey_productproperty = $data[0];
            }
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

if(!empty($_SESSION['product_property_txtProductListingFamilyKeyword']))
{
    $listingfamilykey_productproperty = $_SESSION['product_property_txtProductListingFamilyKeyword'];
    $txtlistingfamilykey_productproperty = str_replace('$', ' ', $listingfamilykey_productproperty);
    $cbolistingfamilykey_productproperty = split_string($temp_listingfamilykey_productproperty, '$');
    sort($cbolistingfamilykey_productproperty);
}

if(!empty($_SESSION['product_property_cboxProductListing']))
{
    $selected_listingfamily_productproperty = $_SESSION['product_property_cboxProductListing'];
    $selected_listingfamily_productproperty = split_string($selected_listingfamily_productproperty, '$');
    sort($selected_listingfamily_productproperty);
}

if(!empty($_SESSION['product_property_cboxProductListingRelated']))
{
    $selected_listingrelated_productproperty = $_SESSION['product_property_cboxProductListingRelated'];
    $selected_listingrelated_productproperty = split_string($selected_listingrelated_productproperty, '$');
}

if(!empty($_SESSION['product_property_txtProductListingKeyword']))
{
    $listingkey_productproperty = $_SESSION['product_property_txtProductListingKeyword'];
    $listingkey_productproperty = str_replace('$', ' ', $listingkey_productproperty);
}


?>
