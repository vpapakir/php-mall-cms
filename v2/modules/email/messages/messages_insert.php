<?php
try
{
    $prepared_query = 'INSERT INTO email_messages
                       (parent_messages, status_messages, firstdate_messages, 
                       lastdate_messages, target_messages, id_user, senderemail_messages, 
                       receiveremail_messages, bcc_messages, type_messages, 
                       subject_messages, content_messages)
                       VALUES
                       (:parent, :status, NOW(), NOW(), :target, :iduser, :sender,
                       :receiver, :bcc, :type, :subject, :content)';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'parent' => $messages_insert_parent,
                          'status' => $messages_insert_status,
                          'target' => $messages_insert_target,
                          'iduser' => $messages_insert_iduser,
                          'sender' => $messages_insert_sender,
                          'receiver' => $messages_insert_receiver,
                          'bcc' => $messages_insert_bcc,
                          'type' => $messages_insert_type,
                          'subject' => $messages_insert_subject,
                          'content' => $messages_insert_content
                          ));
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
?>
