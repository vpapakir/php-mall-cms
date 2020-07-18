<?php
for($i = 1; $i <= $myaccount_msg_last_idmsg; $i++)
{
    if(isset($_POST['bt_sendreply_myaccountmsg'.$i]))
    {
        $myaccount_msg_reply_message = trim(htmlspecialchars($_POST['areaMsgReplyMyaccountMsg'], ENT_QUOTES));
        $myaccount_msg_reply_message = nl2br($myaccount_msg_reply_message);
        try
        {
            $prepared_query = 'UPDATE email_messages
                               SET status_messages = 2,
                               lastdate_messages = NOW(),
                               reply_messages = :reply
                               WHERE id_messages = :idmsg';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'reply' => $myaccount_msg_reply_message,
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
                $myaccount_msg_reply_subject = $data['subject_messages'];
                $myaccount_msg_reply_originmsg = $data['content_messages'];
                $myaccount_msg_reply_sender = $data['senderemail_messages'];
                $myaccount_msg_reply_receiver = $data['receiveremail_messages'];
            }
            $query->closeCursor();
            $myaccount_msg_reply_subject_shortreply = give_translation('message_edit.subject_shortreply', 'false', $config_showtranslationcode);
            $myaccount_msg_reply_subject_part1 = strstr($myaccount_msg_reply_subject, ']', true);
            $myaccount_msg_reply_subject_part1 .= ']';
            $myaccount_msg_reply_subject_part2 = str_replace($myaccount_msg_reply_subject_part1, '', $myaccount_msg_reply_subject);
            $myaccount_msg_reply_subject_part2 = $myaccount_msg_reply_subject_shortreply.' '.$myaccount_msg_reply_subject_part2;
            
            $myaccount_msg_reply_subject = $myaccount_msg_reply_subject_part1.' '.$myaccount_msg_reply_subject_part2;
                       
            include('modules/email/send/user/myaccountmsg/email_main.php');
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
        
        $i = $myaccount_msg_last_idmsg + 1;
        
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
