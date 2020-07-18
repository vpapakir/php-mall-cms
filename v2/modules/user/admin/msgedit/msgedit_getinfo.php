<?php
unset($msgedit_total_count,$msgedit_view_count,$msgedit_read_count,
        $msgedit_sent_count,$msgedit_deleted_count);

try
{
    #[delete old msg]
    $msgedit_deletedold = false;
    $msgedit_currenttime = time();
    $msgedit_maxtime = 86400 * 10;
    
    $msgedit_elapsedtime = $msgedit_currenttime - $msgedit_maxtime;
    $msgedit_elapsedtime_date = date('Y-m-d H:i:s', $msgedit_elapsedtime);
    
    $prepared_query = 'SELECT * FROM email_messages
                       WHERE target_messages = "admin"
                       AND status_messages = 9
                       AND lastdate_messages < :elapsedtime';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('elapsedtime', $msgedit_elapsedtime_date);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $msgedit_deletedold = true;
    }
    $query->closeCursor();
    
    if($msgedit_deletedold === true)
    {
        $prepared_query = 'DELETE FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 9
                           AND lastdate_messages < :elapsedtime';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('elapsedtime', $msgedit_elapsedtime_date);
        $query->execute();
        $query->closeCursor();
        
        reallocate_table_id('id_messages', 'email_messages');
    }
    #[/delete old msg]
    
    $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                       WHERE target_messages = "admin"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $msgedit_total_count = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT MAX(id_messages) FROM email_messages
                       WHERE target_messages = "admin"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $msgedit_last_idmsg = $data[0];
    }
    $query->closeCursor();
    
    #[unread]
    if(empty($_SESSION['msgedit_cboSelectuserMsgEdit']))
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
    }
    else
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 1
                           AND id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $_SESSION['msgedit_cboSelectuserMsgEdit']);
        $query->execute();
    }
    while($data = $query->fetch())
    {
        $msgedit_unread_count = $data[0];
    }
    $query->closeCursor();
    
    $msgedit_unread_blocktitle = give_translation('message_edit.block_title_unread', 'false', $config_showtranslationcode);
    $msgedit_unread_blocktitle = str_replace('[#count_msgedit_unread]', $msgedit_unread_count, $msgedit_unread_blocktitle);
    #[/unread]
    
    #[read]
    if(empty($_SESSION['msgedit_cboSelectuserMsgEdit']))
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 2';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
    }
    else
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 2
                           AND id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $_SESSION['msgedit_cboSelectuserMsgEdit']);
        $query->execute();
    }
    
    while($data = $query->fetch())
    {
        $msgedit_read_count = $data[0];
    }
    $query->closeCursor();
    
    $msgedit_read_blocktitle = give_translation('message_edit.block_title_read', 'false', $config_showtranslationcode);
    $msgedit_read_blocktitle = str_replace('[#count_msgedit_read]', $msgedit_read_count, $msgedit_read_blocktitle);
    #[/read]
    
    #[sent]
    if(empty($_SESSION['msgedit_cboSelectuserMsgEdit']))
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 3';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
    }
    else
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 3
                           AND id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $_SESSION['msgedit_cboSelectuserMsgEdit']);
        $query->execute();
    }
    while($data = $query->fetch())
    {
        $msgedit_sent_count = $data[0];
    }
    $query->closeCursor();
    
    $msgedit_sent_blocktitle = give_translation('message_edit.block_title_sent', 'false', $config_showtranslationcode);
    $msgedit_sent_blocktitle = str_replace('[#count_msgedit_sent]', $msgedit_sent_count, $msgedit_sent_blocktitle);
    #[/sent]
    
    #[deleted]
    if(empty($_SESSION['msgedit_cboSelectuserMsgEdit']))
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 9';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
    }
    else
    {
        $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                           WHERE target_messages = "admin"
                           AND status_messages = 9
                           AND id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $_SESSION['msgedit_cboSelectuserMsgEdit']);
        $query->execute();
    }
    while($data = $query->fetch())
    {
        $msgedit_deleted_count = $data[0];
    }
    $query->closeCursor();
    
    $msgedit_deleted_blocktitle = give_translation('message_edit.block_title_deleted', 'false', $config_showtranslationcode);
    $msgedit_deleted_blocktitle = str_replace('[#count_msgedit_deleted]', $msgedit_deleted_count, $msgedit_deleted_blocktitle);
    #[/deleted]
    
    if(isset($_GET['idmsg']))
    {
        $msgedit_view_idmsg = trim(htmlspecialchars($_GET['idmsg'], ENT_QUOTES));
        $prepared_query = 'SELECT * FROM email_messages
                           WHERE id_messages = :idmsg';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idmsg', $msgedit_view_idmsg);
        $query->execute();
       

        if(($data = $query->fetch()) != false)
        {
            $msgedit_view_shortdate = converto_timestamp($data['firstdate_messages']);
            $msgedit_view_longdate = date('d-m-Y, H:i', $msgedit_view_shortdate);
            $msgedit_view_shortdate = date('d-m-Y', $msgedit_view_shortdate);

            $msgedit_prepared_query = 'SELECT * FROM user
                                       WHERE id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $msgedit_prepared_query; }
            $msgedit_query = $connectData->prepare($msgedit_prepared_query);
            $msgedit_query->bindParam('iduser', $data['id_user']);
            $msgedit_query->execute();
            if(($msgedit_data = $msgedit_query->fetch()) != false)
            {
                if(!empty($msgedit_data['namecompany_user']))
                {
                    $msgedit_view_sender = $msgedit_data['namecompany_user'];
                    $msgedit_view_sender_title = $msgedit_data['namecompany_user']."\r\n".$msgedit_data['firstname_user'].' '.$msgedit_data['name_user']."\r\n".$data['senderemail_messages'];
                }
                else
                {
                    $msgedit_view_sender = substr($msgedit_data['firstname_user'], 0, 1).'. '.$msgedit_data['name_user'];
                    $msgedit_view_sender_title = $msgedit_data['firstname_user'].' '.$msgedit_data['name_user']."\r\n".$data['senderemail_messages'];   
                }
            }
            else
            {
                $msgedit_view_sender = $data['senderemail_messages'];
                $msgedit_view_sender_title = $data['senderemail_messages'];
            }
            $msgedit_query->closeCursor();

            $msgedit_view_subject = $data['subject_messages'];
            $msgedit_view_subject_toreplace = strstr($msgedit_view_subject, ']', true);
            $msgedit_view_subject = trim(str_replace($msgedit_view_subject_toreplace.']', '', $msgedit_view_subject));
            $msgedit_view_type = give_translation('mail_edit.dd_family_'.$data['type_messages'], 'false', $config_showtranslationcode);

            if((strstr($msgedit_view_type, '(', true)) == true)
            {
                $msgedit_view_type = strstr($msgedit_view_type, '(', true);
            }
            $msgedit_view_sender_title = nl2br($msgedit_view_sender_title);
            $msgedit_view_status = str_replace('([#count_msgedit_unread])', '', give_translation('message_edit.block_title_unread', 'false', $config_showtranslationcode));
        
            $msgedit_view_btreply_show = give_translation('main.bt_answer', 'false', $config_showtranslationcode);
            $msgedit_view_btreply_hide = give_translation('main.bt_cancel_reply', 'false', $config_showtranslationcode);
        }
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
?>
