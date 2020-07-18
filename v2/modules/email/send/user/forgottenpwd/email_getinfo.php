<?php
try
{
    #mailtext
    $prepared_query = 'SELECT * FROM email_mailtext
                       WHERE family_mailtext = "forgotten_pwd"
                       AND status_mailtext = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $forgottenpwd_confirm_sendername = $data['sendername_mailtext'];
        $forgottenpwd_confirm_senderemail = $data['senderemail_mailtext'];
        $forgottenpwd_confirm_bcc = $data['bcc_mailtext'];
        $forgottenpwd_confirm_script = $data['scriptpath_mailtext'];
        $forgottenpwd_confirm_idsignature = $data['idsignature_mailtext'];
        $forgottenpwd_confirm_subject = $data['L'.$main_id_language.'S'];
        $forgottenpwd_confirm_part1 = $data['L'.$main_id_language.'P1'];
        $forgottenpwd_confirm_part2 = $data['L'.$main_id_language.'P2'];
    }
    $query->closeCursor();
    
    if($forgottenpwd_confirm_idsignature > 0)
    {
        #signature
        $prepared_query = 'SELECT * FROM email_signature
                           WHERE id_signature = :idsignature';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idsignature', $forgottenpwd_confirm_idsignature);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $forgottenpwd_confirm_signature = $data['L'.$main_id_language.'S'];
            $forgottenpwd_confirm_signature_script = $data['scriptpath_signature'];
        }
        $query->closeCursor();
    }
    
    #line jump
    unset($line_jump);
    $line_jump = "\n";
   
    $forgottenpwd_confirm_date = date('d-m-Y', time());
    $forgottenpwd_confirm_time = date('H:i', time());
    $forgottenpwd_confirm_boundary = md5(rand());    
    
    #replace value
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page.id_page = page_translation.id_page
                       WHERE family_page_translation = "rewritingF"
                       AND url_page = "form_contactmain"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $forgottenpwd_rewritingF_contact = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT nickname_user FROM user
                       WHERE email_user = :email';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('email', $forgottenpwd_email);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $forgottenpwd_nickname = $data[0];
    }
    $query->closeCursor();
    $forgottenpwd_confirm_subject = str_replace('[#user_nickname]', $forgottenpwd_nickname, $forgottenpwd_confirm_subject);
    $forgottenpwd_confirm_part1 = str_replace('[#href_forgottenpwd]', '<a href="'.$config_customheader.'index.php?page=forgotten_pwd_part2&amp;pwd='.$forgottenpwd_code.'" target="_blank">', $forgottenpwd_confirm_part1);
    $forgottenpwd_confirm_part1 = str_replace('[#/href_forgottenpwd]', '</a>', $forgottenpwd_confirm_part1);
    $forgottenpwd_confirm_part1 = str_replace('[#href_contact]', '<a href="'.$config_customheader.$forgottenpwd_rewritingF_contact.'" target="_blank">', $forgottenpwd_confirm_part1);
    $forgottenpwd_confirm_part1 = str_replace('[#/href_contact]', '</a>', $forgottenpwd_confirm_part1);
    $forgottenpwd_confirm_part1 = str_replace('[#url_site]', $config_customheader, $forgottenpwd_confirm_part1);
   
    $forgottenpwd_confirm_part2 = str_replace('[#date]', $forgottenpwd_confirm_date, $forgottenpwd_confirm_part2);
    $forgottenpwd_confirm_part2 = str_replace('[#time]', $forgottenpwd_confirm_time, $forgottenpwd_confirm_part2);
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
