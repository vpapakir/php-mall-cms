<?php
unset($message, $header);
unset($fcontactmain_sendername, $fcontactmain_senderemail,
            $fcontactmain_bcc, $fcontactmain_script, $fcontactmain_idsignature,
            $fcontactmain_subject, $fcontactmain_part1, $fcontactmain_part2,
            $fcontactmain_signature, $fcontactmain_signature_script); 

try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "form_contactmain"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $fcontactmain_sendername = $data['sendername_mailtext'];
        $fcontactmain_senderemail = $data['senderemail_mailtext'];
        $fcontactmain_bcc = $data['bcc_mailtext'];
        $fcontactmain_script = $data['scriptpath_mailtext'];
        $fcontactmain_idsignature = $data['idsignature_mailtext'];
        $fcontactmain_subject = $data['L'.$main_id_language.'S'];
        $fcontactmain_part1 = $data['L'.$main_id_language.'P1'];
        $fcontactmain_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($fcontactmain_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $fcontactmain_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $fcontactmain_signature = $data['L'.$main_id_language.'S'];
            $fcontactmain_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";

    $fcontactmain_date = date('d-m-Y', time());
    $fcontactmain_time = date('H:i', time());
    $fcontactmain_boundary = md5(rand());
    
    $fcontactmain_legend_maininfo = give_translation('form_contactmain.email_legend_maininfo', 'false', $config_showtranslationcode);
    $fcontactmain_legend_msg = give_translation('form_contactmain.email_legend_msg', 'false', $config_showtranslationcode);
    $fcontactmain_email_selected_subject = giveCDRvalue($fcontactmain_selected_subject, 'cdreditor', $main_id_language);
    #replace value 
    $fcontactmain_part1 = str_replace('[#user_name]', $fcontactmain_name, $fcontactmain_part1);
    $fcontactmain_subject = str_replace('[#subject]', $fcontactmain_email_selected_subject, $fcontactmain_subject);
    $fcontactmain_signature = str_replace('[#date]', $fcontactmain_date, $fcontactmain_signature);
    $fcontactmain_signature = str_replace('[#time]', $fcontactmain_time, $fcontactmain_signature);
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
