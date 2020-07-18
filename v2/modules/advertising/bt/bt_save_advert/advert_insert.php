<?php
$prepared_query = 'INSERT INTO advertising (';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= 'name_advertising_L'.$main_activatedidlang[$i].',
                        relatedpage_advertising_L'.$main_activatedidlang[$i].',
                        keyword_advertising_L'.$main_activatedidlang[$i].',
                        frame_advertising_L'.$main_activatedidlang[$i].',
                        alt_advertising_L'.$main_activatedidlang[$i].',
                        legend_advertising_L'.$main_activatedidlang[$i].',
                        link_advertising_L'.$main_activatedidlang[$i].',
                        target_advertising_L'.$main_activatedidlang[$i].',
                        widthlimit_advertising_L'.$main_activatedidlang[$i].',
                        heightlimit_advertising_L'.$main_activatedidlang[$i].',
                        scriptpath_advertising_L'.$main_activatedidlang[$i].',
                        scriptcode_advertising_L'.$main_activatedidlang[$i].',
                        position_advertising_L'.$main_activatedidlang[$i].',
                        status_advertising_L'.$main_activatedidlang[$i].',
                        comment_advertising_L'.$main_activatedidlang[$i].',
                        userrights_advertising_L'.$main_activatedidlang[$i];
    
    if($i == ($count - 1))
    {
        $prepared_query .= ') ';
    }
    else
    {
        $prepared_query .= ', ';
    }
    
}

$prepared_query .= 'VALUES (';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= '"'.$adveredit_name[$i].'",
                       "'.$adveredit_relatedpage[$i].'",
                       "'.$adveredit_keyword[$i].'",
                       "'.$adveredit_frame[$i].'",
                       "'.$adveredit_alt[$i].'",
                       "'.$adveredit_legend[$i].'",
                       "'.$adveredit_link[$i].'",
                       "'.$adveredit_target[$i].'",
                       "'.$adveredit_width[$i].'",
                       "'.$adveredit_height[$i].'",
                       "'.$adveredit_scriptpath[$i].'",
                       "'.$adveredit_scriptcode[$i].'",
                       "'.$adveredit_position[$i].'",
                       "'.$adveredit_status[$i].'",
                       "'.$adveredit_comment[$i].'",
                       "'.$adveredit_userrights[$i].'"';
    
    if($i == ($count - 1))
    {
        $prepared_query .= ') ';
    }
    else
    {
        $prepared_query .= ', ';
    }   
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$query->closeCursor();

include('modules/advertising/bt/bt_save_advert/advert_upload.php');

$_SESSION['msg_advertedit_done'] = str_replace('[#name_advertedit]', $adveredit_name[$advertedit_selected_lang], $msg_done_advert_add);
?>
