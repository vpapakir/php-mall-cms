<?php 
if(isset($_POST['bt_send_contactmain']))
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
    unset($_SESSION['msg_form_contactmain_txtCaptchaFormContactMain']);
    unset($_SESSION['msg_form_contactmain_done']);
    
    unset($_SESSION['form_contactmain_txtEmailFormContactMain'],
            $_SESSION['form_contactmain_txtNameFormContactMain'],
            $_SESSION['form_contactmain_txtPhoneFormContactMain'],
            $_SESSION['form_contactmain_cdreditor_formcontact_subject'],
            $_SESSION['form_contactmain_areaMsgFormContactMain']);
    
    unset($_SESSION['msg_form_contactmain_txtEmailFormContactMain'],
            $_SESSION['msg_form_contactmain_txtNameFormContactMain'],
            $_SESSION['msg_form_contactmain_txtPhoneFormContactMain'],
            $_SESSION['msg_form_contactmain_cdreditor_formcontact_subject']);
    #special
    $fcontactmain_bok_sendemail = true;
    #msg
    $msg_error_fcontactmain_email = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    $msg_error_fcontactmain_name = give_translation('messages.msg_error_fcontactmain_name', 'false', $config_showtranslationcode);
    $msg_error_fcontactmain_phone = give_translation('messages.msg_error_userdata_phone', 'false', $config_showtranslationcode);
    $msg_error_fcontactmain_subject = give_translation('messages.msg_error_fcontactmain_subject', 'false', $config_showtranslationcode);
    $msg_error_fcontactmain_captcha = give_translation('messages.msg_error_captcha', 'false', $config_showtranslationcode);
    $msg_done_fcontactmain = give_translation('messages.msg_done_fcontactmain', 'false', $config_showtranslationcode);
    #callinfo
    $fcontactmain_email = trim(htmlspecialchars($_POST['txtEmailFormContactMain'], ENT_QUOTES));
    $fcontactmain_name = trim(htmlspecialchars($_POST['txtNameFormContactMain'], ENT_QUOTES));
    $fcontactmain_phone = trim(htmlspecialchars($_POST['txtPhoneFormContactMain'], ENT_QUOTES));
    $fcontactmain_selected_subject = htmlspecialchars($_POST['cdreditor_formcontact_subject'], ENT_QUOTES);
    $fcontactmain_msg = htmlspecialchars($_POST['areaMsgFormContactMain'], ENT_QUOTES);
    $fcontactmain_captcha = trim(htmlspecialchars($_POST['txtCaptchaFormContactMain'], ENT_QUOTES));
    $fcontactmain_currentcaptcha = htmlspecialchars($_POST['txtCaptchaHiddenFormContactMain'], ENT_QUOTES);
    
    #condition
    if(empty($fcontactmain_email))
    {
        $fcontactmain_bok_sendemail = false;
        $_SESSION['msg_form_contactmain_txtEmailFormContactMain'] = $msg_error_fcontactmain_email;
    }
    else 
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $fcontactmain_email))
        {
            $fcontactmain_bok_sendemail = false;
            $_SESSION['msg_form_contactmain_txtEmailFormContactMain'] = $msg_error_fcontactmain_email;
        }
    }
    
    if(empty($fcontactmain_name))
    {
        $fcontactmain_bok_sendemail = false;
        $_SESSION['msg_form_contactmain_txtNameFormContactMain'] = $msg_error_fcontactmain_name;
    }
    
    if(empty($fcontactmain_phone))
    {
        $fcontactmain_bok_sendemail = false;
        $_SESSION['msg_form_contactmain_txtPhoneFormContactMain'] = $msg_error_fcontactmain_phone;
    }
    
    if($fcontactmain_selected_subject == 'select')
    {
        $fcontactmain_bok_sendemail = false;
        $_SESSION['msg_form_contactmain_cdreditor_formcontact_subject'] = $msg_error_fcontactmain_subject;
    }
    
    if($fcontactmain_captcha != $fcontactmain_currentcaptcha)
    {
        $fcontactmain_bok_sendemail = false;
        $_SESSION['msg_form_contactmain_txtCaptchaFormContactMain'] = $msg_error_fcontactmain_captcha;
    }
    
    #operation
    if($fcontactmain_bok_sendemail === true)
    {
        $fcontactmain_msg = '<p style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">'.$fcontactmain_msg.'</p>';
        $fcontactmain_msg = nl2br($fcontactmain_msg);
        include('modules/email/send/user/contactmain/email_main.php');
        
        $fcontactmain_iduser = null;
        $prepared_query = 'SELECT id_user FROM user
                           WHERE email_user = :email';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('email', $fcontactmain_senderemail);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $fcontactmain_iduser = $data[0];
        }
        $query->closeCursor();
        
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'admin';
        $messages_insert_iduser = $fcontactmain_iduser;
        $messages_insert_sender = $fcontactmain_senderemail;
        $messages_insert_receiver = $config_email_senderemail;
        $messages_insert_bcc = $fcontactmain_bcc;
        $messages_insert_type = 'form_contactmain';
        $messages_insert_subject = $fcontactmain_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        include('modules/email/send/admin/contactmain/email_main.php');
        
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'user';
        $messages_insert_iduser = $fcontactmain_iduser;
        $messages_insert_sender = $config_email_senderemail;
        $messages_insert_receiver = $fcontactmain_email;
        $messages_insert_bcc = $fcontactmain_bcc;
        $messages_insert_type = 'form_contactmain';
        $messages_insert_subject = $fcontactmain_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        $_SESSION['msg_form_contactmain_done'] = $msg_done_fcontactmain;
    }
    else
    {
        $_SESSION['form_contactmain_txtEmailFormContactMain'] = $fcontactmain_email;
        $_SESSION['form_contactmain_txtNameFormContactMain'] = $fcontactmain_name;
        $_SESSION['form_contactmain_txtPhoneFormContactMain'] = $fcontactmain_phone;
        $_SESSION['form_contactmain_cdreditor_formcontact_subject'] = $fcontactmain_selected_subject;
        $_SESSION['form_contactmain_areaMsgFormContactMain'] = $fcontactmain_msg;
    }
}
?>
