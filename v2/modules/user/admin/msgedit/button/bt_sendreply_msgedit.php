<?php
for($i = 1; $i <= $msgedit_last_idmsg; $i++)
{
    if(isset($_POST['bt_sendreply_msgedit'.$i]))
    {
        $msgedit_reply_message = trim($_POST['areaMsgReplyMsgEdit']);
        
        try
        {
            $prepared_query = 'UPDATE email_messages
                               SET status_messages = 3,
                               lastdate_messages = NOW(),
                               reply_messages = :reply
                               WHERE id_messages = :idmsg';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'reply' => $msgedit_reply_message,
                                  'idmsg' => $i               
                                ));
            $query->closeCursor();
            
            $prepared_query = 'SELECT * FROM email_messages
                               WHERE id_messages = :idmsg';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'idmsg' => $i               
                                ));
            if(($data = $query->fetch()) != false)
            {
                $msgedit_reply_subject = $data['subject_messages'];
                $msgedit_reply_originmsg = $data['content_messages'];
                $msgedit_reply_sender = $data['senderemail_messages'];
            }
            $query->closeCursor();
            $msgedit_reply_subject_shortreply = give_translation('message_edit.subject_shortreply', 'false', $config_showtranslationcode);
            $msgedit_reply_subject_part1 = strstr($msgedit_reply_subject, ']', true);
            $msgedit_reply_subject_part1 .= ']';
            $msgedit_reply_subject_part2 = str_replace($msgedit_reply_subject_part1, '', $msgedit_reply_subject);
            $msgedit_reply_subject_part2 = $msgedit_reply_subject_shortreply.' '.$msgedit_reply_subject_part2;
            
            $msgedit_reply_subject = $msgedit_reply_subject_part1.' '.$msgedit_reply_subject_part2;
                       
            include('modules/email/send/admin/msgedit/email_main.php');
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
        
        $i = $msgedit_last_idmsg + 1;
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
    }
}
?>
