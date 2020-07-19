<?php
try
{
    $prepared_query = 'SELECT listingfamkey_page
                       FROM page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $temp_listingfamilykey_pageproperty = null;
    
    while($data = $query->fetch())
    {
        if(!empty($data[0]))
        {
            if($temp_listingfamilykey_pageproperty != null)
            {
                $temp_listingfamilykey_pageproperty .= '$'.$data[0];
            }
            else
            {
                $temp_listingfamilykey_pageproperty = $data[0];
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

if(!empty($_SESSION['page_property_txtPageListingFamilyKeyword']))
{
    $listingfamilykey_pageproperty = $_SESSION['page_property_txtPageListingFamilyKeyword'];
    $txtlistingfamilykey_pageproperty = str_replace('$', ' ', $listingfamilykey_pageproperty);
    $cbolistingfamilykey_pageproperty = split_string($temp_listingfamilykey_pageproperty, '$');
    sort($cbolistingfamilykey_pageproperty);
}

if(!empty($_SESSION['page_property_cboxPageListing']))
{
    $selected_listingfamily_pageproperty = $_SESSION['page_property_cboxPageListing'];
    $selected_listingfamily_pageproperty = split_string($selected_listingfamily_pageproperty, '$');
    sort($selected_listingfamily_pageproperty);
}

if(!empty($_SESSION['page_property_cboxPageListingRelated']))
{
    $selected_listingrelated_pageproperty = $_SESSION['page_property_cboxPageListingRelated'];
    $selected_listingrelated_pageproperty = split_string($selected_listingrelated_pageproperty, '$');
}

if(!empty($_SESSION['page_property_txtPageListingKeyword']))
{
    $listingkey_pageproperty = $_SESSION['page_property_txtPageListingKeyword'];
    $listingkey_pageproperty = str_replace('$', ' ', $listingkey_pageproperty);
}


?>
