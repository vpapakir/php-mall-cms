<?php
if(isset($_POST['bt_send_testmail']) || isset($_POST['bt_send_mailing']))
{
    #session
    unset($_SESSION['mailing_chkall']);
    
    unset($_SESSION['usermailing_txtTestemailUserMailing'],
            $_SESSION['usermailing_txtNameUserMailing'],
            $_SESSION['usermailing_txtEmailUserMailing'],
            $_SESSION['usermailing_txtTitleSubjectUserMailing'],
            $_SESSION['usermailing_txtDescSubjectUserMailing'],
            $_SESSION['usermailing_areaReceiverUserMailing'],
            $_SESSION['usermailing_radTypeMsgUserMailing']);
    unset($_SESSION['msg_usermailing_txtNameUserMailing'],
            $_SESSION['msg_usermailing_txtEmailUserMailing'],
            $_SESSION['msg_usermailing_txtTestemailUserMailing'],
            $_SESSION['msg_usermailing_txtDescSubjectUserMailing'],
            $_SESSION['msg_usermailing_areaMsgUserMailing'],
            $_SESSION['msg_usermailing_cboTemplateUserMailing'],
            $_SESSION['msg_usermailing_done']);
    
    #special
    $_SESSION['expand_mailing_listing'] = trim(htmlspecialchars($_POST['expand_mailing_listing'], ENT_QUOTES));
    $usermailing_bok_sendemail = true;
    
    #msg
    $msg_done_usermailing_testemail = give_translation('messages.msg_done_usermailing_testemail', 'false', $config_showtranslationcode);
    $msg_done_usermailing = give_translation('messages.msg_done_usermailing', 'false', $config_showtranslationcode);
    
    $msg_error_usermailing_name = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_usermailing_email = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    $msg_error_usermailing_testemail = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    $msg_error_usermailing_subject = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    
    $msg_error_usermailing_message = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_usermailing_template = give_translation('messages.msg_error_usermailing_template', 'false', $config_showtranslationcode);
    
    #callinfo
    
        #-msg
    $usermailing_typemsg = htmlspecialchars($_POST['radTypeMsgUserMailing'], ENT_QUOTES);
    
    if($usermailing_typemsg == 'existing')
    {
        $usermailing_selected_template = htmlspecialchars($_POST['cboTemplateUserMailing'], ENT_QUOTES);
        $_SESSION['usermailing_radTypeMsgUserMailing'] = $usermailing_typemsg;
    }
    else
    {
        $usermailing_selected_signature = htmlspecialchars($_POST['cboSignatureUserMailing'], ENT_QUOTES);
        $usermailing_message = trim($_POST['areaMsgUserMailing']);
    }
    
    
    $_SESSION['usermailing_areaMsgUserMailing'] = $usermailing_message;
    $_SESSION['usermailing_cboSignatureUserMailing'] = $usermailing_selected_signature;
    
    $_SESSION['usermailing_cboTemplateUserMailing'] = $usermailing_selected_template;
    
        #-listing
    unset($usermailing_listing_chk,$usermailing_listing_temp_iduser,
            $usermailing_counttotalreceiver,$usermailing_bcc_iduser);
    $y = 0;
    for($i = 0, $count = count($usermailing_listing_iduser); $i < $count; $i++)
    {
        $usermailing_listing_temp_iduser = split_string($usermailing_listing_iduser[$i], '$');
        $usermailing_listing_chk = htmlspecialchars($_POST['chk_mailing'.$usermailing_listing_temp_iduser[3]], ENT_QUOTES);
        if($usermailing_listing_chk == 1)
        {
            $usermailing_bcc_iduser[$y] = $usermailing_listing_temp_iduser[3];
            $usermailing_counttotalreceiver++;
            $_SESSION['usermailing_chk'.$usermailing_listing_temp_iduser[3]] = 1;
            $y++;
        }
        else
        {
            $_SESSION['mailing_chkall'] = 'false';
            $_SESSION['usermailing_chk'.$usermailing_listing_temp_iduser[3]] = 9;
        }
        unset($usermailing_listing_chk,$usermailing_listing_temp_iduser);
    }
    
        #-info
    
    $usermailing_testemail = trim(htmlspecialchars($_POST['txtTestemailUserMailing'], ENT_QUOTES));
    $usermailing_sendername = trim(htmlspecialchars($_POST['txtNameUserMailing'], ENT_QUOTES));
    $usermailing_senderemail = trim(htmlspecialchars($_POST['txtEmailUserMailing'], ENT_QUOTES));
    $usermailing_subject_title = trim(htmlspecialchars($_POST['txtTitleSubjectUserMailing'], ENT_QUOTES));
    $usermailing_subject_content = trim(htmlspecialchars($_POST['txtDescSubjectUserMailing'], ENT_QUOTES));
    $usermailing_more_receiver = trim(htmlspecialchars($_POST['areaReceiverUserMailing'], ENT_QUOTES));
    
    $_SESSION['usermailing_txtTestemailUserMailing'] = $usermailing_testemail;
    $_SESSION['usermailing_txtNameUserMailing'] = $usermailing_sendername;
    $_SESSION['usermailing_txtEmailUserMailing'] = $usermailing_senderemail;
    $_SESSION['usermailing_txtTitleSubjectUserMailing'] = $usermailing_subject_title;
    $_SESSION['usermailing_txtDescSubjectUserMailing'] = $usermailing_subject_content;
    $_SESSION['usermailing_areaReceiverUserMailing'] = $usermailing_more_receiver;
    
    #condition
    unset($usermailing_bcc);

    try
    {
        for($i = 0, $count = count($usermailing_bcc_iduser); $i < $count; $i++)
        {
            $prepared_query = 'SELECT * FROM user
                               WHERE id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('iduser', $usermailing_bcc_iduser[$i]);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                if($i == 0)
                {
                    $usermailing_bcc = $data['email_user'];
                }
                else
                {
                    $usermailing_bcc .= ','.$data['email_user']; 
                } 
            }
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
    
    
    if(!empty($usermailing_more_receiver))
    {
        $usermailing_temp_more_receiver = split_string($usermailing_more_receiver, ',');
        $usermailing_counttotalreceiver += count($usermailing_temp_more_receiver);
        
        $usermailing_bcc .= ','.$usermailing_more_receiver;
        
        $usermailing_bcc = preg_replace('#,$#', '', $usermailing_bcc);
    }

    if(empty($usermailing_sendername))
    {
        $usermailing_bok_sendemail = false;
        $_SESSION['msg_usermailing_txtNameUserMailing'] = $msg_error_usermailing_name;
    }
    
    if(empty($usermailing_testemail) 
            || !preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $usermailing_testemail))
    {
        $usermailing_bok_sendemail = false;
        $_SESSION['msg_usermailing_txtTestemailUserMailing'] = $msg_error_usermailing_testemail;
    }
    
    if(empty($usermailing_senderemail) 
            || !preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $usermailing_senderemail))
    {
        $usermailing_bok_sendemail = false;
        $_SESSION['msg_usermailing_txtEmailUserMailing'] = $msg_error_usermailing_email;
    }
    
    if(empty($usermailing_subject_content))
    {
        $usermailing_bok_sendemail = false;
        $_SESSION['msg_usermailing_txtDescSubjectUserMailing'] = $msg_error_usermailing_subject;
    }
    
    if($usermailing_typemsg == 'existing')
    {
        if($usermailing_selected_template == 'select')
        {
            $usermailing_bok_sendemail = false;
            $_SESSION['msg_usermailing_cboTemplateUserMailing'] = $msg_error_usermailing_template;
        }
    }
    else
    {
        if(empty($usermailing_message))
        {
            $usermailing_bok_sendemail = false;
            $_SESSION['msg_usermailing_areaMsgUserMailing'] = $msg_error_usermailing_message;
        }
    }
    
    #operation
    if($usermailing_bok_sendemail === true)
    {
        if(isset($_POST['bt_send_testmail']))
        {
            include('modules/email/send/admin/mailing/email_main.php');
            $msg_done_usermailing_testemail = str_replace('[#testemail_usermailing]', $usermailing_testemail, $msg_done_usermailing_testemail);
            $_SESSION['msg_usermailing_done'] = $msg_done_usermailing_testemail;
        }
        
        if(isset($_POST['bt_send_mailing']))
        {
            
            include('modules/email/send/admin/mailing/email_main.php');
            $usermailing_loop_bcc = null;
            $usermailing_loop_bcc = str_replace($config_email_bcc, '', $usermailing_bcc);
            $usermailing_loop_bcc = split_string($usermailing_loop_bcc, ',');
            for($i = 0, $count = count($usermailing_loop_bcc); $i < $count; $i++)
            {
                if(preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $usermailing_loop_bcc[$i]))
                {
                    try
                    {
                        $prepared_query = 'SELECT id_user FROM user
                                           WHERE email_user = :email';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('email', $usermailing_loop_bcc[$i]);
                        $query->execute();
                        if(($data = $query->fetch()) != false)
                        {
                            $usermailing_iduser = $data[0];
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
                    
                    $messages_insert_parent = 0;
                    $messages_insert_status = 3;
                    $messages_insert_target = 'admin';
                    $messages_insert_iduser = $usermailing_iduser;
                    $messages_insert_sender = $usermailing_senderemail;
                    $messages_insert_receiver = $usermailing_loop_bcc[$i];
                    $messages_insert_bcc = $usermailing_bcc;
                    $messages_insert_type = 'mailing';
                    $messages_insert_subject = $usermailing_subject;
                    $messages_contentmsg_part1 = strstr($message, '<body', true);
                    $messages_contentmsg_part2 = strstr($message, '</body>');
                    $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
                    $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
                    $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
                    $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
                    include('modules/email/messages/messages_insert.php');
                    $messages_insert_parent = 0;
                    $messages_insert_status = 1;
                    $messages_insert_target = 'user';
                    $messages_insert_iduser = $usermailing_iduser;
                    $messages_insert_sender = $usermailing_senderemail;
                    $messages_insert_receiver = $usermailing_loop_bcc[$i];
                    $messages_insert_bcc = $usermailing_bcc;
                    $messages_insert_type = 'mailing';
                    $messages_insert_subject = $usermailing_subject;
                    $messages_contentmsg_part1 = strstr($message, '<body', true);
                    $messages_contentmsg_part2 = strstr($message, '</body>');
                    $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
                    $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
                    $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
                    $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
                    include('modules/email/messages/messages_insert.php');
                }
            }
            $msg_done_usermailing = str_replace('[#countreceiver_usermailing]', $usermailing_counttotalreceiver, $msg_done_usermailing);
            $_SESSION['msg_usermailing_done'] = $msg_done_usermailing;
        }
        
        unset($message, $header);
        unset($usermailing_sendername, $usermailing_senderemail,
                    $usermailing_bcc, $usermailing_script, $usermailing_idsignature,
                    $usermailing_subject, $usermailing_part1, $usermailing_part2,
                    $usermailing_signature, $usermailing_signature_script);
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
