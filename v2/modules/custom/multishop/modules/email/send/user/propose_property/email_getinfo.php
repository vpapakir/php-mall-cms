<?php
unset($message, $header);
unset($fproposep_sendername, $fproposep_senderemail,
            $fproposep_bcc, $fproposep_script, $fproposep_idsignature,
            $fproposep_subject, $fproposep_part1, $fproposep_part2,
            $fproposep_signature, $fproposep_signature_script); 

try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "kform_proposep"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $fproposep_sendername = $data['sendername_mailtext'];
        $fproposep_senderemail = $data['senderemail_mailtext'];
        $fproposep_bcc = $data['bcc_mailtext'];
        $fproposep_script = $data['scriptpath_mailtext'];
        $fproposep_idsignature = $data['idsignature_mailtext'];
        $fproposep_subject = $data['L'.$main_id_language.'S'];
        $fproposep_part1 = $data['L'.$main_id_language.'P1'];
        $fproposep_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($fproposep_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $fproposep_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $fproposep_signature = $data['L'.$main_id_language.'S'];
            $fproposep_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";

    $fproposep_date = date('d-m-Y', time());
    $fproposep_time = date('H:i', time());
    $fproposep_boundary = md5(rand());
    
    $fproposep_legend_propertyinfo = give_translation('propose_property.email_legend_propertyinfo', 'false', $config_showtranslationcode);
    $fproposep_legend_userinfo = give_translation('propose_property.email_legend_userinfo', 'false', $config_showtranslationcode);
    $fproposep_legend_desc = give_translation('propose_property.email_legend_desc', 'false', $config_showtranslationcode);
    $fproposep_legend_msg = give_translation('propose_property.email_legend_msg', 'false', $config_showtranslationcode);
    $fproposep_email_selected_offer = giveCDRvalue($fproposep_offer, 'cdreditor', $main_id_language);
    $fproposep_email_selected_typeobject = giveCDRvalue($fproposep_typeobject, 'cdreditor', $main_id_language);
    $fproposep_email_selected_condition = giveCDRvalue($fproposep_condition, 'cdreditor', $main_id_language);
    $fproposep_email_selected_situation = giveCDRvalue($fproposep_situation, 'cdreditor', $main_id_language);
    
    if(!empty($proposep_user_companyname))
    {
        $fproposep_name = $proposep_user_companyname;
    }
    else
    {
        $fproposep_name = $proposep_user_firstname.' '.$proposep_user_lastname;
    }
    #replace value       
    $fproposep_sendername = str_replace('[#user_name]', $fproposep_name, $fproposep_sendername);
    $fproposep_senderemail = str_replace('[#user_email]', $proposep_user_email, $fproposep_senderemail);
    $fproposep_subject = str_replace('[#user_name]', $fproposep_name, $fproposep_subject);
    $fproposep_subject = str_replace('[#type_offer]', $fproposep_email_selected_offer, $fproposep_subject);
    $fproposep_part1 = str_replace('[#url_site]', $config_customheader, $fproposep_part1);
    $fproposep_part2 = str_replace('[#date]', $fproposep_date, $fproposep_part2);
    $fproposep_part2 = str_replace('[#time]', $fproposep_time, $fproposep_part2);
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
