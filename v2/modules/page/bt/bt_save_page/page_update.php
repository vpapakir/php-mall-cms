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
                      'status' => $status_pageproperty,
                      'status_search' => $status_search_pageproperty,
                      'template' => $template_pageproperty,
                      'code' => $code_pageproperty,
                      'family' => $family_pageproperty,
                      'url' => $url_pageproperty,
                      'script' => $script_pageproperty,
                      'listfamkey' => $listingfamkey_pageproperty,
                      'listfam' => $listingfam_pageproperty,
                      'listrelated' => $listingrelated_pageproperty,
                      'listkey' => $listingkeywords_pageproperty,
                      'scriptajax' => $scriptajax_pageproperty,
                      'level' => $userrights_pageproperty,
                      'allowstats' => $allowstats_pageproperty,
                      'id' => $selected_page
                      ));
$query->closeCursor();

include('modules/page/bt/bt_save_page/page_translation_update.php');
include('modules/page/bt/bt_save_page/page_image_update.php');


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

if(empty($array_title_pagecontent[0]))
{
    $pagedone_pageproperty = $code_pageproperty;
}
else
{
    $pagedone_pageproperty = $array_title_pagecontent[0];
}

$_SESSION['msg_page_savedone'] = $msg_page_savedone1.$pagedone_pageproperty.$msg_page_savedone3;
?>
