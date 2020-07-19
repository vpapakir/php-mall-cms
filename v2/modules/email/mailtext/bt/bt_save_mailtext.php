<?php
if(isset($_POST['bt_add_mailtext']) || isset($_POST['bt_edit_mailtext']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    #session
    unset($_SESSION['mailtext_cboFamilyMailtext'],
            $_SESSION['mailtext_txtSendernameMailtext'],
            $_SESSION['mailtext_txtSenderemailMailtext'],
            $_SESSION['mailtext_txtBccMailtext'],
            $_SESSION['mailtext_txtScriptpathMailtext'],
            $_SESSION['mailtext_cboStatusMailtext'],
            $_SESSION['mailtext_cboSignatureMailtext']);
    unset($_SESSION['msg_mailtext_cboFamilyMailtext'],
            $_SESSION['msg_mailtext_txtSendernameMailtext'],
            $_SESSION['msg_mailtext_txtSenderemailMailtext'],
            $_SESSION['msg_mailtext_txtNameMailtext'],
            $_SESSION['msg_mailtext_txtSubjectMailtext'],
            $_SESSION['msg_mailtext_done']);
    
    #msg
    $msg_error_mailtext_choicefamily = give_translation('messages.msg_error_mailtext_choicefamily', 'false', $config_showtranslationcode);
    $msg_error_mailtext_emptysendername = give_translation('messages.msg_error_mailtext_emptysendername', 'false', $config_showtranslationcode);
    $msg_error_mailtext_emptysenderemail = give_translation('messages.msg_error_mailtext_emptysenderemail', 'false', $config_showtranslationcode);
    $msg_error_mailtext_emptyname = give_translation('messages.msg_error_mailtext_emptyname', 'false', $config_showtranslationcode);
    $msg_error_mailtext_emptysubject = give_translation('messages.msg_error_mailtext_subject', 'false', $config_showtranslationcode);
    $msg_done_mailtext_add = give_translation('messages.msg_done_mailtext_add', 'false', $config_showtranslationcode);
    $msg_done_mailtext_edit = give_translation('messages.msg_done_mailtext_edit', 'false', $config_showtranslationcode);
    
    #special
    $mailtext_bool_gotodata = true; 
    
    #calling
    $mailtext_selected = htmlspecialchars($_POST['cboTemplateMailtext'], ENT_QUOTES);
    $mailtext_family = htmlspecialchars($_POST['cboFamilyMailtext'], ENT_QUOTES);
    $mailtext_sendername = trim(htmlspecialchars($_POST['txtSendernameMailtext'], ENT_QUOTES));
    $mailtext_senderemail = trim(htmlspecialchars($_POST['txtSenderemailMailtext'], ENT_QUOTES));
    $mailtext_bcc = trim(htmlspecialchars($_POST['txtBccMailtext'], ENT_QUOTES));
    $mailtext_scriptpath = trim(htmlspecialchars($_POST['txtScriptpathMailtext'], ENT_QUOTES));
    $mailtext_status = htmlspecialchars($_POST['cboStatusMailtext'], ENT_QUOTES);
    $mailtext_selected_signature = htmlspecialchars($_POST['cboSignatureMailtext'], ENT_QUOTES);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]]);
        
        $mailtext_contentname[$i] = trim(htmlspecialchars($_POST['txtNameMailtext'.$main_activatedidlang[$i]], ENT_QUOTES));
        $mailtext_contentsubject[$i] = trim(htmlspecialchars($_POST['txtSubjectMailtext'.$main_activatedidlang[$i]], ENT_QUOTES));
        $mailtext_contenttop[$i] = trim(addslashes($_POST['areaTopMailtext'.$main_activatedidlang[$i]]));
        $mailtext_contentbottom[$i] = trim(addslashes($_POST['areaBottomMailtext'.$main_activatedidlang[$i]]));
        
        if($main_activatedidlang[$i] == $main_id_language)
        {
            $mailtext_name_selectedlang = $i;
        }
    }
    
    #checking
    if($mailtext_selected_signature == 'select')
    {
        $mailtext_selected_signature = 0;
    }
    
    if($mailtext_family == 'select')
    {
        $mailtext_bool_gotodata = false;
        $_SESSION['msg_mailtext_cboFamilyMailtext'] = $msg_error_mailtext_choicefamily;
    }
    
    if(empty($mailtext_sendername))
    {
        $mailtext_bool_gotodata = false;
        $_SESSION['msg_mailtext_txtSendernameMailtext'] = $msg_error_mailtext_emptysendername;
    }
    
    if(empty($mailtext_senderemail))
    {
        $mailtext_bool_gotodata = false;
        $_SESSION['mailtext_txtSenderemailMailtext'] = $msg_error_mailtext_emptysenderemail;
    }
    
    if(empty($mailtext_contentname[0]))
    {
        $mailtext_bool_gotodata = false;
        $_SESSION['msg_mailtext_txtNameMailtext'] = $msg_error_mailtext_emptyname;
    }
    
    if(empty($mailtext_contentsubject[0]))
    {
        $mailtext_bool_gotodata = false;
        $_SESSION['msg_mailtext_txtSubjectMailtext'] = $msg_error_mailtext_emptysubject;
    }
    
    if($mailtext_bool_gotodata === true)
    {
        try
        {
            if(isset($_POST['bt_add_mailtext']))
            { 
                $prepared_query = 'SELECT COUNT(id_mailtext) FROM email_mailtext';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $mailtext_selected = $data[0] + 1;
                }
                $query->closeCursor();
                
                include('modules/email/mailtext/bt/bt_save_mailtext/mailtext_insert.php');
            }

            if(isset($_POST['bt_edit_mailtext']))
            {  
                include('modules/email/mailtext/bt/bt_save_mailtext/mailtext_update.php');
            }
            
            if($mailtext_status == 1)
            {
                $prepared_query = 'UPDATE email_mailtext 
                                   SET status_mailtext = 9
                                   WHERE family_mailtext = :family
                                   AND id_mailtext <> :idmailtext';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array('family' => $mailtext_family,
                                      'idmailtext' => $mailtext_selected));
                $query->closeCursor();
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
        $_SESSION['mailtext_cboFamilyMailtext'] = $mailtext_family;
        $_SESSION['mailtext_txtSendernameMailtext'] = $mailtext_sendername;
        $_SESSION['mailtext_txtSenderemailMailtext'] = $mailtext_senderemail;
        $_SESSION['mailtext_txtBccMailtext'] = $mailtext_bcc;
        $_SESSION['mailtext_txtScriptpathMailtext'] = $mailtext_scriptpath;
        $_SESSION['mailtext_cboSignatureMailtext'] = $mailtext_selected_signature;
        $_SESSION['mailtext_cboStatusMailtext'] = $mailtext_status;

        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]] = $mailtext_name[$i];
            $_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]] = $mailtext_contentsubject[$i];
            $_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]] = stripslashes($mailtext_contenttop[$i]);
            $_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]] = stripslashes($mailtext_contentbottom[$i]);
        }
    }
}
?>
