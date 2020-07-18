<?php
if(isset($_POST['bt_save_advert']) || isset($_POST['bt_modify_advert']))
{
    #msg
    $msg_done_advert_add = give_translation('messages.msg_done_advert_add', 'false', $config_showtranslationcode);
    $msg_done_advert_edit = give_translation('messages.msg_done_advert_edit', 'false', $config_showtranslationcode);
    $msg_error_advert_name = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_advert_alt = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_advert_position = give_translation('messages.msg_error_advert_position', 'false', $config_showtranslationcode);
    $msg_error_advert_scriptfile = give_translation('messages.msg_error_advert_scriptfile', 'false', $config_showtranslationcode);
    #special
    $advertedit_bok_data = true;
    $advertedit_bok_checkupload = false;
    unset($adveredit_userrights);
    
    $adveredit_selected_idadvert = htmlspecialchars($_POST['cboSelectAdvert'], ENT_QUOTES);
    
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
        
        #callinfo
        $adveredit_upload[$i] = $_FILES['upload_advert'.$main_activatedidlang[$i]]['name'];
        $adveredit_name[$i] = trim(htmlspecialchars($_POST['txtNameAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_array_userrights[$i] = $_POST['cboRightsAdvert'.$main_activatedidlang[$i]];
        $adveredit_array_relatedpage[$i] = $_POST['cboPageAdvert'.$main_activatedidlang[$i]];
        $adveredit_keyword[$i] = trim(htmlspecialchars($_POST['txtKeywordAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_frame[$i] = htmlspecialchars($_POST['cboFrameAdvert'.$main_activatedidlang[$i]], ENT_QUOTES);
        $adveredit_alt[$i] = trim(htmlspecialchars($_POST['txtAltAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_legend[$i] = trim(htmlspecialchars($_POST['areaLegendAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_link[$i] = trim(htmlspecialchars($_POST['txtLinkAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_target[$i] = htmlspecialchars($_POST['cboTargetAdvert'.$main_activatedidlang[$i]], ENT_QUOTES);
        $adveredit_width[$i] = trim(htmlspecialchars($_POST['txtWidthlimitAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_height[$i] = trim(htmlspecialchars($_POST['txtHeightlimitAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_scriptpath[$i] = trim(htmlspecialchars($_POST['txtScriptpathAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_scriptcode[$i] = trim($_POST['areaScriptcodeAdvert'.$main_activatedidlang[$i]]);
        $adveredit_position[$i] = trim(htmlspecialchars($_POST['txtPositionAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_comment[$i] = trim(htmlspecialchars($_POST['areaCommentAdvert'.$main_activatedidlang[$i]], ENT_QUOTES));
        $adveredit_status[$i] = htmlspecialchars($_POST['cboStatusAdvert'.$main_activatedidlang[$i]], ENT_QUOTES);
        
        #condition
        if($i > 0 && empty($adveredit_name[$i]) && $advertedit_bok_data === true)
        {
            $adveredit_upload[$i] = $_FILES['upload_advert'.$main_activatedidlang[0]]['name'];
            $adveredit_name[$i] = trim(htmlspecialchars($_POST['txtNameAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_array_userrights[$i] = $_POST['cboRightsAdvert'.$main_activatedidlang[0]];
            $adveredit_array_relatedpage[$i] = $_POST['cboPageAdvert'.$main_activatedidlang[0]];
            $adveredit_keyword[$i] = trim(htmlspecialchars($_POST['txtKeywordAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_frame[$i] = htmlspecialchars($_POST['cboFrameAdvert'.$main_activatedidlang[0]], ENT_QUOTES);
            $adveredit_alt[$i] = trim(htmlspecialchars($_POST['txtAltAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_legend[$i] = trim(htmlspecialchars($_POST['areaLegendAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_link[$i] = trim(htmlspecialchars($_POST['txtLinkAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_target[$i] = htmlspecialchars($_POST['cboTargetAdvert'.$main_activatedidlang[0]], ENT_QUOTES);
            $adveredit_width[$i] = trim(htmlspecialchars($_POST['txtWidthlimitAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_height[$i] = trim(htmlspecialchars($_POST['txtHeightlimitAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_scriptpath[$i] = trim(htmlspecialchars($_POST['txtScriptpathAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_scriptcode[$i] = trim($_POST['areaScriptcodeAdvert'.$main_activatedidlang[0]]);
            $adveredit_position[$i] = trim(htmlspecialchars($_POST['txtPositionAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_comment[$i] = trim(htmlspecialchars($_POST['areaCommentAdvert'.$main_activatedidlang[0]], ENT_QUOTES));
            $adveredit_status[$i] = htmlspecialchars($_POST['cboStatusAdvert'.$main_activatedidlang[0]], ENT_QUOTES);
        }
        
        if(empty($adveredit_name[$i]))
        {
            $advertedit_bok_data = false;
            $_SESSION['msg_advertedit_txtNameAdvert'.$main_activatedidlang[$i]] = $msg_error_advert_name;
        }
        
        if(empty($adveredit_position[$i]))
        {
            $adveredit_position[$i] = 1010;
        }
        else
        {
            if(strlen($adveredit_position[$i]) > 4 || !is_numeric($adveredit_position[$i]))
            {
                $advertedit_bok_data = false;
                $_SESSION['msg_advertedit_txtPositionAdvert'.$main_activatedidlang[$i]] = $msg_error_advert_position;
            }
        }
        
        if(empty($adveredit_alt[$i]))
        {
            $advertedit_bok_data = false;
            $_SESSION['msg_advertedit_txtAltAdvert'.$main_activatedidlang[$i]] = $msg_error_advert_alt;
        }
        
        try
        {
            $prepared_query = 'SELECT path_advertising_L1 FROM advertising
                               WHERE id_advertising = :idadvert';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idadvert', $adveredit_selected_idadvert);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                if(empty($data[0]))
                {
                    $advertedit_bok_checkupload = true;
                }
            }
            else
            {
                $advertedit_bok_checkupload = true;
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
        
        if(empty($adveredit_upload[$i]) 
                && empty($adveredit_scriptpath[$i]) 
                && empty($adveredit_scriptcode[$i])
                && $advertedit_bok_checkupload === true)
        {
            $advertedit_bok_data = false;
            $_SESSION['msg_advertedit_AdvertScriptFile'.$main_activatedidlang[$i]] = $msg_error_advert_scriptfile;
        }
        
        for($y = 0, $county = count($adveredit_array_userrights[$i]); $y < $county; $y++)
        {
            if($y == 0)
            {
                if($adveredit_array_userrights[$i][$y] == 'all' && $adveredit_array_userrights[$i][($county - 1)] != 9)
                {
                    $adveredit_userrights[$i] = 'all';
                    $y = $county;
                }
                else
                {
                    $adveredit_userrights[$i] = $adveredit_array_userrights[$i][$y];
                }
                
            }
            else
            {
                $adveredit_userrights[$i] .= ','.$adveredit_array_userrights[$i][$y];
            }
            
            if($y == ($county - 1))
            {
                if($adveredit_array_userrights[$i][$y] == 9)
                {
                    $adveredit_userrights[$i] = 9;
                }
                else
                {
                    $adveredit_userrights[$i] .= ',9';
                }
            }
        }
        
        for($y = 0, $county = count($adveredit_array_relatedpage[$i]); $y < $county; $y++)
        {
            if($y == 0)
            {
                $adveredit_relatedpage[$i] = $adveredit_array_relatedpage[$i][$y];
            }
            else
            {
                $adveredit_relatedpage[$i] .= '$'.$adveredit_array_relatedpage[$i][$y];
            }
        }
        
        $adveredit_relatedpage[$i] = str_replace('select$', '', $adveredit_relatedpage[$i]);
        
        if($main_activatedidlang[$i] == $main_id_language)
        {
            $advertedit_selected_lang = $i;
        }
    }
    
    if($advertedit_bok_data === true)
    {
        try
        {
            if(isset($_POST['bt_save_advert']))
            {
                include('modules/advertising/bt/bt_save_advert/advert_insert.php');
            }

            if(isset($_POST['bt_modify_advert']))
            {
                include('modules/advertising/bt/bt_save_advert/advert_update.php');
                
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
    else
    {
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
