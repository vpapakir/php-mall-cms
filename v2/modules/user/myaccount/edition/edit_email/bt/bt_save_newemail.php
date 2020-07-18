<?php
if(isset($_POST['bt_save_newemail']))
{
    #session
    unset($_SESSION['myaccount_editemail_txtOldemailUserdataEditEmail'],
            $_SESSION['myaccount_editemail_txtNewemailUserdataEditEmail']);
    unset($_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail'],
            $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'],
            $_SESSION['msg_error_editemail_txtConfirmnewemailUserdataEditEmail'],
            $_SESSION['msg_done_editemail']);
    
    #msg
    $msg_error_editemail_emptyfield = give_translation('messages.msg_error_editemail_emptyfield', 'false', $config_showtranslationcode);
    $msg_error_editemail_wrongoldemail = give_translation('messages.msg_error_editemail_wrongoldemail', 'false', $config_showtranslationcode);
    $msg_error_editemail_wrongemail = give_translation('messages.msg_error_editemail_wrongemail', 'false', $config_showtranslationcode);
    $msg_error_editemail_sameasoldemail = give_translation('messages.msg_error_editemail_sameasoldemail', 'false', $config_showtranslationcode);
    $msg_error_editemail_existnewemail = give_translation('messages.msg_error_editemail_existnewemail', 'false', $config_showtranslationcode);
    $msg_error_editemail_confirmemail = give_translation('messages.msg_error_editemail_confirmemail', 'false', $config_showtranslationcode);
    $msg_done_editemail = give_translation('messages.msg_done_editemail', 'false', $config_showtranslationcode);
    
    #special
    $myaccount_editemail_bok_update = true;
    
    #callinfo
    $myaccount_editemail_oldemail = trim(htmlspecialchars($_POST['txtOldemailUserdataEditEmail'], ENT_QUOTES));
    $myaccount_editemail_newemail = trim(htmlspecialchars($_POST['txtNewemailUserdataEditEmail'], ENT_QUOTES));
    $myaccount_editemail_confirmnewemail = trim(htmlspecialchars($_POST['txtConfirmnewemailUserdataEditEmail'], ENT_QUOTES));
    
    #condition
    if(empty($myaccount_editemail_oldemail))
    {
        $myaccount_editemail_bok_update = false;
        $_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail'] = $msg_error_editemail_emptyfield;
    }
    else
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $myaccount_editemail_oldemail))
        {
            $myaccount_editemail_bok_update = false;
            $_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail'] = $msg_error_editemail_wrongemail;
        }
        else
        {
            $prepared_query = 'SELECT id_user FROM user
                               WHERE email_user = :email
                               AND id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'email' => $myaccount_editemail_oldemail,
                                  'iduser' => $main_iduser_log
                                  ));
            if(($data = $query->fetch()) == false)
            {
                $myaccount_editemail_bok_update = false;
                $_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail'] = $msg_error_editemail_wrongoldemail;
            }
            $query->closeCursor();
        }
    }
    
    if(empty($myaccount_editemail_newemail))
    {
        $myaccount_editemail_bok_update = false;
        $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'] = $msg_error_editemail_emptyfield;
    }
    else
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $myaccount_editemail_newemail))
        {
            $myaccount_editemail_bok_update = false;
            $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'] = $msg_error_editemail_wrongemail;
        }
        else
        {
            if($myaccount_editemail_newemail == $myaccount_editemail_oldemail)
            {
                $myaccount_editemail_bok_update = false;
                $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'] = $msg_error_editemail_sameasoldemail;
            }
        }
    }
    
    if(!empty($myaccount_editemail_newemail) && $myaccount_editemail_confirmnewemail != $myaccount_editemail_newemail)
    {
        $myaccount_editemail_bok_update = false;
        $_SESSION['msg_error_editemail_txtConfirmnewemailUserdataEditEmail'] = $msg_error_editemail_confirmemail;
    }
    else
    {    
        try
        {
            $prepared_query = 'SELECT id_user FROM user
                               WHERE email_user = :email';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('email', $myaccount_editemail_confirmnewemail);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $myaccount_editemail_bok_update = false;
                $msg_error_editemail_existnewemail = str_replace('[#href]', '<a class="link_main" style="font-size: 9px;" href="#">', $msg_error_editemail_existnewemail);
                $msg_error_editemail_existnewemail = str_replace('[#/href]', '</a>', $msg_error_editemail_existnewemail);
                $_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail'] = $msg_error_editemail_existnewemail;
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
    
    if($myaccount_editemail_bok_update === true)
    {
        try
        {
            $prepared_query = 'UPDATE user
                               SET email_user = :email
                               WHERE email_user = :oldemail
                               AND id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'email' => $myaccount_editemail_confirmnewemail,
                                  'oldemail' => $myaccount_editemail_oldemail,
                                  'iduser' => $main_iduser_log
                                  ));
            $query->closeCursor();
            
            $_SESSION['msg_done_editemail'] = str_replace('[#user_email]', '"'.$myaccount_editemail_confirmnewemail.'"', $msg_done_editemail);
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
        $_SESSION['myaccount_editemail_txtOldemailUserdataEditEmail'] = $myaccount_editemail_oldemail;
        $_SESSION['myaccount_editemail_txtNewemailUserdataEditEmail'] = $myaccount_editemail_newemail; 
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
