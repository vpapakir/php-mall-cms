<?php
try
{
    if($usermailing_typemsg == 'existing')
    {       
        #mailtext
        $prepared_query = 'SELECT * FROM email_mailtext
                           WHERE id_mailtext = :idmailtext';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idmailtext', $usermailing_selected_template);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $usermailing_sendername = $data['sendername_mailtext'];
            $usermailing_senderemail = $data['senderemail_mailtext'];
            $usermailing_bcc = $data['bcc_mailtext'];
            $usermailing_script = $data['scriptpath_mailtext'];
            $usermailing_idsignature = $data['idsignature_mailtext'];
            $usermailing_subject = $data['L'.$main_id_language.'S'];
            $usermailing_part1 = $data['L'.$main_id_language.'P1'];
            $usermailing_part2 = $data['L'.$main_id_language.'P2'];
        }
        $query->closeCursor();
        
        if($usermailing_idsignature > 0)
        {
            #signature
            $prepared_query = 'SELECT * FROM email_signature
                               WHERE id_signature = :idsignature';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idsignature', $usermailing_idsignature);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $usermailing_signature = $data['L'.$main_id_language.'S'];
                $usermailing_signature_script = $data['scriptpath_signature'];
            }
            $query->closeCursor();
        }
        
        #line jump
        unset($line_jump);
        $line_jump = "\n";

        $usermailing_date = date('d-m-Y', time());
        $usermailing_time = date('H:i', time());
        $usermailing_boundary = md5(rand());
        
        #replace value
        $usermailing_sendername = str_replace('[#user_fullname]', $subscriptionform_firstname.' '.$subscriptionform_lastname, $usermailing_sendername);
        $usermailing_senderemail = str_replace('[#user_email]', $subscriptionform_email, $usermailing_senderemail);
        $usermailing_subject = str_replace('[#user_fullname]', $subscriptionform_firstname.' '.$subscriptionform_lastname, $usermailing_subject);
        $usermailing_part2 = str_replace('[#date]', $usermailing_date, $usermailing_part2);
        $usermailing_part2 = str_replace('[#time]', $usermailing_time, $usermailing_part2);
        
        $usermailing_signature = str_replace('[#date]', $usermailing_date, $usermailing_signature);
        $usermailing_signature = str_replace('[#time]', $usermailing_time, $usermailing_signature);
    }
    else
    {        
        $usermailing_sendername = $usermailing_sender_name;
        
        
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $usermailing_selected_signature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $usermailing_signature = $data['L'.$main_id_language.'S'];
            $usermailing_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
        
        #line jump
        unset($line_jump);
        $line_jump = "\n";

        $usermailing_date = date('d-m-Y', time());
        $usermailing_time = date('H:i', time());
        $usermailing_boundary = md5(rand());
        
        $usermailing_signature = str_replace('[#date]', $usermailing_date, $usermailing_signature);
        $usermailing_signature = str_replace('[#time]', $usermailing_time, $usermailing_signature);
    }
    
    if(isset($_POST['bt_send_testmail']))
    {
        $usermailing_senderemail = $usermailing_testemail;
        unset($usermailing_bcc);
    }
    
    $usermailing_subject = $usermailing_subject_title.' '.$usermailing_subject_content;
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
