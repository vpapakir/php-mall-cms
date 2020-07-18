<?php
unset($message, $header);
unset($kformprodemail_sendername, $kformprodemail_senderemail,
            $kformprodemail_bcc, $kformprodemail_script, $kformprodemail_idsignature,
            $kformprodemail_subject, $kformprodemail_part1, $kformprodemail_part2,
            $kformprodemail_signature, $kformprodemail_signature_script); 
try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "kform_prodemail"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kformprodemail_sendername = $data['sendername_mailtext'];
        $kformprodemail_senderemail = $data['senderemail_mailtext'];
        $kformprodemail_bcc = $data['bcc_mailtext'];
        $kformprodemail_script = $data['scriptpath_mailtext'];
        $kformprodemail_idsignature = $data['idsignature_mailtext'];
        $kformprodemail_subject = $data['L'.$main_id_language.'S'];
        $kformprodemail_part1 = $data['L'.$main_id_language.'P1'];
        $kformprodemail_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($kformprodemail_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $kformprodemail_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $kformprodemail_signature = $data['L'.$main_id_language.'S'];
            $kformprodemail_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";

    $kformprodemail_date = date('d-m-Y', time());
    $kformprodemail_time = date('H:i', time());
    $kformprodemail_boundary = md5(rand());
    
    if(!empty($kformprodemail_bcc))
    {
        $kformprodemail_bcc = $kformprodemail_bcc.', ';
    }

    #replace value       
    $kformprodemail_subject = str_replace('[#ref_product]', $kformprodemail_product_reference, $kformprodemail_subject);
    $kformprodemail_part1 = str_replace('[#url_site]', $config_customheader, $kformprodemail_part1);
    $kformprodemail_part2 = str_replace('[#date]', $kformprodemail_date, $kformprodemail_part2);
    $kformprodemail_part2 = str_replace('[#time]', $kformprodemail_time, $kformprodemail_part2);
    $kformprodemail_signature = str_replace('[#date]', $kformprodemail_date, $kformprodemail_signature);
    $kformprodemail_signature = str_replace('[#time]', $kformprodemail_time, $kformprodemail_signature);
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
