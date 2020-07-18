<?php
$prepared_query = 'INSERT INTO page
                   (status_page, status_search_page, template_page,
                    code_page, family_page, url_page, script_page,
                    listingfamkey_page, listingfam_page, 
                    listingrelated_page, listingkey_page, 
                    ajaxpath_page, level_rights, allowstats_page)
                   VALUES
                   (:status, :status_search, :template,
                    :code, :family, :url, :script,
                    :listfamkey, :listfam, :listrelated, :listkey,
                    :scriptajax, :level, :allowstats)';
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
                      'allowstats' => $allowstats_pageproperty
                      ));
$query->closeCursor();

include('modules/page/bt/bt_save_page/page_translation.php');

//if(isset($_POST['bt_add_edit_page']))
//{
    $prepared_query = 'SELECT MAX(id_page) FROM page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $last_insert_idpage = $data[0];
    }
    $query->closeCursor();

    $_SESSION['page_add_edit_lastidpage'] = $last_insert_idpage;
//}

include('modules/page/bt/bt_save_page/page_insert_sitemap.php');

$_SESSION['msg_page_savedone'] = $msg_page_savedone1.$code_pageproperty.$msg_page_savedone2;
?>
