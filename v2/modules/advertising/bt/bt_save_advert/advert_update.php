<?php
$prepared_query = 'UPDATE advertising 
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query .= 'name_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_name[$i].'",
                        relatedpage_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_relatedpage[$i].'",
                        keyword_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_keyword[$i].'",
                        frame_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_frame[$i].'",
                        alt_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_alt[$i].'",
                        legend_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_legend[$i].'",
                        link_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_link[$i].'",
                        target_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_target[$i].'",
                        widthlimit_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_width[$i].'",
                        heightlimit_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_height[$i].'",
                        scriptpath_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_scriptpath[$i].'",
                        scriptcode_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_scriptcode[$i].'",
                        position_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_position[$i].'",
                        status_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_status[$i].'",
                        comment_advertising_L'.$main_activatedidlang[$i].' = "'.$adveredit_comment[$i].'",
                        userrights_advertising_L'.$main_activatedidlang[$i]. ' = "'.$adveredit_userrights[$i].'"';
    
    if($i == ($count - 1))
    {
        $prepared_query .= ' ';
    }
    else
    {
        $prepared_query .= ', ';
    }
    
}
$prepared_query .= 'WHERE id_advertising = :idadvert';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('idadvert', $adveredit_selected_idadvert);
$query->execute();
$query->closeCursor();

include('modules/advertising/bt/bt_save_advert/advert_upload.php');

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $_SESSION['advertedit_txtNameAdvert'.$main_activatedidlang[$i]] = $adveredit_name[$i];
    $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]] = $adveredit_userrights[$i];
    $_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]] = $adveredit_relatedpage[$i];
    $_SESSION['advertedit_txtKeywordAdvert'.$main_activatedidlang[$i]] = $adveredit_keyword[$i];
    $_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]] = $adveredit_frame[$i];
    $_SESSION['advertedit_txtAltAdvert'.$main_activatedidlang[$i]] = $adveredit_alt[$i];
    $_SESSION['advertedit_areaLegendAdvert'.$main_activatedidlang[$i]] = $adveredit_legend[$i];
    $_SESSION['advertedit_txtLinkAdvert'.$main_activatedidlang[$i]] = $adveredit_link[$i];
    $_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]] = $adveredit_target[$i];
    $_SESSION['advertedit_txtWidthlimitAdvert'.$main_activatedidlang[$i]] = $adveredit_width[$i];
    $_SESSION['advertedit_txtHeightlimitAdvert'.$main_activatedidlang[$i]] = $adveredit_height[$i];
    $_SESSION['advertedit_txtScriptpathAdvert'.$main_activatedidlang[$i]] = $adveredit_scriptpath[$i];
    $_SESSION['advertedit_areaScriptcodeAdvert'.$main_activatedidlang[$i]] = $adveredit_scriptcode[$i];
    $_SESSION['advertedit_txtPositionAdvert'.$main_activatedidlang[$i]] = $adveredit_position[$i];
    $_SESSION['advertedit_areaCommentAdvert'.$main_activatedidlang[$i]] = $adveredit_comment[$i];
    $_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]] = $adveredit_status[$i];
}

$_SESSION['msg_advertedit_done'] = str_replace('[#name_advertedit]', $adveredit_name[$advertedit_selected_lang], $msg_done_advert_edit);
?>
