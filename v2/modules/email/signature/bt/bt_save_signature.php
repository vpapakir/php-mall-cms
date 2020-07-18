<?php
if(isset($_POST['bt_add_signature']) || isset($_POST['bt_edit_signature']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['signature_txtScriptpathSignature']);
    unset($_SESSION['msg_signature_txtNameSignature'],
            $_SESSION['msg_signature_done']);
    
    $msg_error_signature_emptyname = give_translation('messages.msg_error_signature_emptyname', 'false', $config_showtranslationcode);
    $msg_done_signature_add = give_translation('messages.msg_done_signature_add', 'false', $config_showtranslationcode);
    $msg_done_signature_edit = give_translation('messages.msg_done_signature_edit', 'false', $config_showtranslationcode);
    
    $signature_bool_gotodata = true; 
    
    $signature_selected = htmlspecialchars($_POST['cboTemplateSignature'], ENT_QUOTES);
    $signature_scriptpath = trim(htmlspecialchars($_POST['txtScriptpathSignature'], ENT_QUOTES));
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]],
                $_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]]);
        $signature_name[$i] = trim(htmlspecialchars($_POST['txtNameSignature'.$main_activatedidlang[$i]], ENT_QUOTES));
        $signature_content[$i] = trim(addslashes($_POST['areaContentSignature'.$main_activatedidlang[$i]]));
        
        if($main_activatedidlang[$i] == $main_id_language)
        {
            $signature_name_selectedlang = $i;
        }
    }
    
    if(empty($signature_name[0]))
    {
        $signature_bool_gotodata = false;
        $_SESSION['msg_signature_txtNameSignature'] = $msg_error_signature_emptyname;
    }
    
    if($signature_bool_gotodata === true)
    {
        try
        {
            if(isset($_POST['bt_add_signature']))
            {    
                include('modules/email/signature/bt/bt_save_signature/signature_insert.php');
            }

            if(isset($_POST['bt_edit_signature']))
            {  
                include('modules/email/signature/bt/bt_save_signature/signature_update.php');
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
        $_SESSION['signature_txtScriptpathSignature'] = $signature_scriptpath;
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]] = $signature_name[$i];
            $_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]] = stripslashes($signature_content[$i]);
        }
    }
}
?>
