<?php
unset($message, $header);
unset($kformvisit_sendername, $kformvisit_senderemail,
            $kformvisit_bcc, $kformvisit_script, $kformvisit_idsignature,
            $kformvisit_subject, $kformvisit_part1, $kformvisit_part2,
            $kformvisit_signature, $kformvisit_signature_script); 

try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "kform_visit_copy"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kformvisit_sendername = $data['sendername_mailtext'];
        $kformvisit_senderemail = $data['senderemail_mailtext'];
        $kformvisit_bcc = $data['bcc_mailtext'];
        $kformvisit_script = $data['scriptpath_mailtext'];
        $kformvisit_idsignature = $data['idsignature_mailtext'];
        $kformvisit_subject = $data['L'.$main_id_language.'S'];
        $kformvisit_part1 = $data['L'.$main_id_language.'P1'];
        $kformvisit_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($kformvisit_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $kformvisit_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $kformvisit_signature = $data['L'.$main_id_language.'S'];
            $kformvisit_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";

    $kformvisit_date = date('d-m-Y', time());
    $kformvisit_time = date('H:i', time());
    $kformvisit_boundary = md5(rand());
    
    $kformvisit_legend_propertyinfo = give_translation('kform_visit.email_legend_propertyinfo', 'false', $config_showtranslationcode);
    $kformvisit_legend_userinfo = give_translation('kform_visit.email_legend_userinfo', 'false', $config_showtranslationcode);
    $kformvisit_legend_msg = give_translation('kform_visit.email_legend_msg', 'false', $config_showtranslationcode);
    if(!empty($kformvisit_user_companyname))
    {
        $kformvisit_name = $kformvisit_user_companyname;
    }
    else
    {
        $kformvisit_name = $kformvisit_user_firstname.' '.$kformvisit_user_lastname;
    }
    $kformvisit_email_selected_ref = null;
    for($i = 0, $count = count($kformvisit_product_reference); $i < $count; $i++)
    {
        if($i == 0)
        {
            $kformvisit_email_selected_ref = $kformvisit_product_reference[$i];
        }
        else
        {
            $kformvisit_email_selected_ref .= ', '.$kformvisit_product_reference[$i];
        }
    } 
    #replace value       
    $kformvisit_subject = str_replace('[#user_name]', $kformvisit_name, $kformvisit_subject);
    $kformvisit_subject = str_replace('[#ref_product]', $kformvisit_email_selected_ref, $kformvisit_subject);
    $kformvisit_part1 = str_replace('[#user_name]', $kformvisit_name, $kformvisit_part1);
    $kformvisit_signature = str_replace('[#date]', $kformvisit_date, $kformvisit_signature);
    $kformvisit_signature = str_replace('[#time]', $kformvisit_time, $kformvisit_signature);
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
