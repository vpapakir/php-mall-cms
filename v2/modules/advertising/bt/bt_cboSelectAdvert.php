<?php
if(isset($_POST['bt_cboSelectAdvert']))
{
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        #session
        unset($_SESSION['advertedit_UploadAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtNameAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtKeywordAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtAltAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_areaLegendAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtLinkAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtWidthlimitAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtHeightlimitAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtScriptpathAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_areaScriptcodeAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_txtPositionAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_areaCommentAdvert'.$main_activatedidlang[$i]],
                $_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]]);
        
        unset($_SESSION['msg_advertedit_txtNameAdvert'.$main_activatedidlang[$i]],
                $_SESSION['msg_advertedit_txtAltAdvert'.$main_activatedidlang[$i]],
                $_SESSION['msg_advertedit_txtPositionAdvert'.$main_activatedidlang[$i]],
                $_SESSION['msg_advertedit_AdvertScriptFile'.$main_activatedidlang[$i]],
                $_SESSION['msg_advertedit_upload'.$main_activatedidlang[$i]],
                $_SESSION['msg_advertedit_done']);
    }
    
    unset($_SESSION['advertedit_cboSelectAdvert']);
    
    $advertedit_selected_advert = htmlspecialchars($_POST['cboSelectAdvert'], ENT_QUOTES);
    
    if($advertedit_selected_advert != 'new')
    {
        $_SESSION['advertedit_cboSelectAdvert'] = $advertedit_selected_advert;
        
        try
        {
            $prepared_query = 'SELECT * FROM advertising
                               WHERE id_advertising = :idadvert';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idadvert', $advertedit_selected_advert);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['advertedit_UploadAdvert'.$main_activatedidlang[$i]] = $data['path_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtNameAdvert'.$main_activatedidlang[$i]] = $data['name_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]] = $data['userrights_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]] = $data['relatedpage_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtKeywordAdvert'.$main_activatedidlang[$i]] = $data['keyword_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]] = $data['frame_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtAltAdvert'.$main_activatedidlang[$i]] = $data['alt_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_areaLegendAdvert'.$main_activatedidlang[$i]] = $data['legend_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtLinkAdvert'.$main_activatedidlang[$i]] = $data['link_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]] = $data['target_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtWidthlimitAdvert'.$main_activatedidlang[$i]] = $data['widthlimit_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtHeightlimitAdvert'.$main_activatedidlang[$i]] = $data['heightlimit_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtScriptpathAdvert'.$main_activatedidlang[$i]] = $data['scriptpath_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_areaScriptcodeAdvert'.$main_activatedidlang[$i]] = $data['scriptcode_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_txtPositionAdvert'.$main_activatedidlang[$i]] = $data['position_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_areaCommentAdvert'.$main_activatedidlang[$i]] = $data['comment_advertising_L'.$main_activatedidlang[$i]];
                    $_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]] = $data['status_advertising_L'.$main_activatedidlang[$i]];
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
