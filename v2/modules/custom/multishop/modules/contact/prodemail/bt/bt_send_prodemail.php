<?php
if(isset($_POST['bt_send_prodemail']))
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
    unset($_SESSION['msg_kform_prodemail_txtCaptchaProdemail'],
            $_SESSION['msg_kform_prodemail_txtUseremailProdemail'],
            $_SESSION['msg_kform_prodemail_done']);
    
    unset($_SESSION['kform_prodemail_txtUseremailProdemail']);
    for($i = 0; $i < 5; $i++)
    {
        unset($_SESSION['kform_prodemail_txtOtheremailProdemail'.$i],
                $_SESSION['msg_kform_prodemail_txtOtheremailProdemail'.$i]);
    }

    #special
    $kformprodemail_bok_sendemail = true;
    #msg
    $msg_error_kformprodemail_email = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    $msg_error_kformprodemail_captcha = give_translation('messages.msg_error_captcha', 'false', $config_showtranslationcode);
    $msg_done_kformprodemail = give_translation('messages.msg_done_kformprodemail', 'false', $config_showtranslationcode);
    #callinfo
    $kformprodemail_email = trim(htmlspecialchars($_POST['txtUseremailProdemail'], ENT_QUOTES));

    for($i = 0; $i < 5; $i++)
    {
       $kformprodemail_otheremail[$i] = trim(htmlspecialchars($_POST['txtOtheremailProdemail'.$i], ENT_QUOTES)); 
    }
    
    $kformprodemail_captcha = trim(htmlspecialchars($_POST['txtCaptchaProdemail'], ENT_QUOTES));
    $kformprodemail_currentcaptcha = htmlspecialchars($_POST['txtCaptchaHiddenProdemail'], ENT_QUOTES);
    
    $kformprodemail_otherbcc = null;
    #condition
    if(empty($kformprodemail_email))
    {
        $kformprodemail_bok_sendemail = false;
        $_SESSION['msg_kform_prodemail_txtUseremailProdemail'] = $msg_error_kformprodemail_email;
    }
    else 
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $kformprodemail_email))
        {
            $kformprodemail_bok_sendemail = false;
            $_SESSION['msg_kform_prodemail_txtUseremailProdemail'] = $msg_error_kformprodemail_email;
        }
    }
    
    for($i = 0; $i < 5; $i++)
    {
        if(!empty($kformprodemail_otheremail[$i]) && !preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $kformprodemail_otheremail[$i]))
        {
            $kformprodemail_bok_sendemail = false;
            $_SESSION['msg_kform_prodemail_txtOtheremailProdemail'.$i] = $msg_error_kformprodemail_email;
        }
        else
        {
            if($i == 0)
            {
                $kformprodemail_otherbcc = $kformprodemail_otheremail[$i];
            }
            else
            {
                $kformprodemail_otherbcc .= ', '.$kformprodemail_otheremail[$i];
            }
        }       
    }
    
    if($kformprodemail_captcha != $kformprodemail_currentcaptcha)
    {
        $kformprodemail_bok_sendemail = false;
        $_SESSION['msg_kform_prodemail_txtCaptchaProdemail'] = $msg_error_kformprodemail_captcha;
    }
    
    #operation
    if($kformprodemail_bok_sendemail === true)
    {
        $fproposep_iduser = null;
        $prepared_query = 'SELECT id_user FROM user
                           WHERE email_user = :emailuser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('emailuser', $kformprodemail_senderemail);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $fproposep_iduser = $data[0];
        }
        $query->closeCursor();
        
        include('modules/custom/immo/modules/email/send/user/product_email/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'user';
        $messages_insert_iduser = $fproposep_iduser;
        $messages_insert_sender = $kformprodemail_senderemail;
        $messages_insert_receiver = $kformprodemail_email;
        $messages_insert_bcc = $kformprodemail_bcc.$kformprodemail_otherbcc;
        $messages_insert_type = 'kform_prodemail';
        $messages_insert_subject = $kformprodemail_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        $_SESSION['msg_kform_prodemail_done'] = $msg_done_kformprodemail;
    }
    else
    {
        $_SESSION['kform_prodemail_txtUseremailProdemail'] = $kformprodemail_email;
        for($i = 0; $i < 5; $i++)
        {
            $_SESSION['kform_prodemail_txtOtheremailProdemail'.$i] = $kformprodemail_otheremail[$i];
        }
    }
}
?>
