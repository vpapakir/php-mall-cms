<?php
if(isset($_POST['bt_send_visit']))
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
    unset($_SESSION['msg_form_visit_done']);
    #special
    $kformvisit_bok_sendemail = true;
    #msg
    $msg_done_kformvisit = give_translation('messages.msg_done_kformvisit', 'false', $config_showtranslationcode);
    #callinfo
    $kformvisit_msg = trim(htmlspecialchars($_POST['areaMsgKformVisit'], ENT_QUOTES));    
    #condition
    
    #operation
    if($kformvisit_bok_sendemail === true)
    {
        $kformvisit_msg = '<p style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">'.$kformvisit_msg.'</p>';
        $kformvisit_msg = nl2br($kformvisit_msg);
        
        $kformvisit_emailuser = null;
        $prepared_query = 'SELECT email_user FROM user
                           WHERE id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $main_iduser_log);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $kformvisit_emailuser = $data[0];
        }
        $query->closeCursor();
        
        include('modules/custom/immo/modules/email/send/user/visit/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'user';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $config_email_senderemail;
        $messages_insert_receiver = $kformvisit_emailuser;
        $messages_insert_bcc = $kformvisit_bcc;
        $messages_insert_type = 'kform_visit';
        $messages_insert_subject = $kformvisit_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        include('modules/custom/immo/modules/email/send/admin/visit/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'admin';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $kformvisit_senderemail;
        $messages_insert_receiver = $config_email_senderemail;
        $messages_insert_bcc = $kformvisit_bcc;
        $messages_insert_type = 'kform_visit';
        $messages_insert_subject = $kformvisit_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        $_SESSION['msg_form_visit_done'] = $msg_done_kformvisit;
    }
    else
    {
        
    }
}
?>
