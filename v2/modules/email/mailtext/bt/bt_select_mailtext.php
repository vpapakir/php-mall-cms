<?php
if(isset($_POST['bt_select_mailtext']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['mailtext_cboTemplateMailtext'],
            $_SESSION['mailtext_cboFamilyMailtext'],
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
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]],
                $_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]]);
    }
    
    $mailtext_selected = htmlspecialchars($_POST['cboTemplateMailtext'], ENT_QUOTES);
    
    if($mailtext_selected != 'new')
    {
        $_SESSION['mailtext_cboTemplateMailtext'] = $mailtext_selected;
        
        try
        {
            $prepared_query = 'SELECT *
                               FROM `email_mailtext`
                               WHERE id_mailtext = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $mailtext_selected);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['mailtext_cboFamilyMailtext'] = $data['family_mailtext'];
                $_SESSION['mailtext_txtSendernameMailtext'] = $data['sendername_mailtext'];
                $_SESSION['mailtext_txtSenderemailMailtext'] = $data['senderemail_mailtext'];
                $_SESSION['mailtext_txtBccMailtext'] = $data['bcc_mailtext'];
                $_SESSION['mailtext_txtScriptpathMailtext'] = $data['scriptpath_mailtext'];
                $_SESSION['mailtext_cboStatusMailtext'] = $data['status_mailtext'];
                $_SESSION['mailtext_cboSignatureMailtext'] = $data['idsignature_mailtext'];
                
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i].'T'];
                    $_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i].'S'];
                    $_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]] = stripslashes($data['L'.$main_activatedidlang[$i].'P1']);
                    $_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]] = stripslashes($data['L'.$main_activatedidlang[$i].'P2']);
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
}
?>
