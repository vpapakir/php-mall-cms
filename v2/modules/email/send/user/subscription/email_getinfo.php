<?php
unset($message, $header);
unset($subscription_confirm_sendername, $subscription_confirm_senderemail,
            $subscription_confirm_bcc, $subscription_confirm_script, $subscription_confirm_idsignature,
            $subscription_confirm_subject, $subscription_confirm_part1, $subscription_confirm_part2,
            $subscription_confirm_signature, $subscription_confirm_signature_script); 
try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "subscription"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $subscription_confirm_sendername = $data['sendername_mailtext'];
        $subscription_confirm_senderemail = $data['senderemail_mailtext'];
        $subscription_confirm_bcc = $data['bcc_mailtext'];
        $subscription_confirm_script = $data['scriptpath_mailtext'];
        $subscription_confirm_idsignature = $data['idsignature_mailtext'];
        $subscription_confirm_subject = $data['L'.$main_id_language.'S'];
        $subscription_confirm_part1 = $data['L'.$main_id_language.'P1'];
        $subscription_confirm_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($subscription_confirm_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $subscription_confirm_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $subscription_confirm_signature = $data['L'.$main_id_language.'S'];
            $subscription_confirm_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";

    #hidden user password
    unset($subscription_uncrypted_pwd_part1, $subscription_uncrypted_pwd_part2, $subscription_uncrypted_pwd_part3);
    $subscription_uncrypted_passwordlength = (strlen($subscriptionform_password_foremail)) - 2;
    for($i = 0; $i < $subscription_uncrypted_passwordlength; $i++)
    {
        $subscription_uncrypted_pwd_part2 .= '*';   
    }
    $subscription_uncrypted_pwd_part1 = substr($subscriptionform_password_foremail, 0, 1);
    $subscription_uncrypted_pwd_part3 = substr($subscriptionform_password_foremail, (($subscription_uncrypted_passwordlength) + 1), 1);


    $subscription_confirm_date = date('d-m-Y', time());
    $subscription_confirm_time = date('H:i', time());
    $subscription_confirm_boundary = md5(rand());
    $subscription_confirm_legend_maininfo = give_translation('subscription.email_legend_maininfo', 'false', $config_showtranslationcode);
    $subscription_confirm_legend_connexioninfo = give_translation('subscription.email_legend_connexioninfo', 'false', $config_showtranslationcode);
    
    #replace value
    $subscription_confirm_link = give_translation('subscription.email_confirmlink', 'false', $config_showtranslationcode);
    $subscription_confirm_part1 = str_replace('[#subscription_confirm_link]', '<a href="'.$config_customheader.'index.php?page=myaccount&amp;user='.$subscriptionform_random_confirmcode.'" target="_blank"><span>'.$subscription_confirm_link.'</span></a>', $subscription_confirm_part1);
   
    $subscription_confirm_signature = str_replace('[#date]', $subscription_confirm_date, $subscription_confirm_signature);
    $subscription_confirm_signature = str_replace('[#time]', $subscription_confirm_time, $subscription_confirm_signature);
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
