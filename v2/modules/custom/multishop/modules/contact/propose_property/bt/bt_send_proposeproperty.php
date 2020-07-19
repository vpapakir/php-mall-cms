<?php
if(isset($_POST['bt_send_proposeproperty']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    #session
    unset($_SESSION['msg_form_proposep_done']);
    
    unset($_SESSION['form_proposep_cdreditor_offer_object'],
            $_SESSION['form_proposep_cdreditor_type_object'],
            $_SESSION['form_proposep_cdreditor_condition_object'],
            $_SESSION['form_proposep_cdreditor_location_situation'],
            $_SESSION['form_proposep_txtPriceProposeP'],
            $_SESSION['form_proposep_areaDescProposeP'],
            $_SESSION['form_proposep_areaMsgProposeP']);
    
    unset($_SESSION['msg_form_proposep_cdreditor_offer_object'],
            $_SESSION['msg_form_proposep_cdreditor_type_object']);
    #special
    $fproposep_bok_sendemail = true;
    #msg
    $msg_error_fproposep_offer = give_translation('messages.msg_error_fproposep_offer', 'false', $config_showtranslationcode);
    $msg_error_fproposep_typeobject = give_translation('messages.msg_error_fproposep_typeobject', 'false', $config_showtranslationcode);
    $msg_done_fproposep = give_translation('messages.msg_done_fproposep', 'false', $config_showtranslationcode);
    #callinfo
    $fproposep_offer = htmlspecialchars($_POST['cdreditor_offer_object'], ENT_QUOTES);
    $fproposep_typeobject = htmlspecialchars($_POST['cdreditor_type_object'], ENT_QUOTES);
    $fproposep_condition = htmlspecialchars($_POST['cdreditor_condition_object'], ENT_QUOTES);
    $fproposep_situation = htmlspecialchars($_POST['cdreditor_location_situation'], ENT_QUOTES);
    $fproposep_price = trim(htmlspecialchars($_POST['txtPriceProposeP'], ENT_QUOTES));
    $fproposep_desc = trim(htmlspecialchars($_POST['areaDescProposeP'], ENT_QUOTES));
    $fproposep_msg = trim(htmlspecialchars($_POST['areaMsgProposeP'], ENT_QUOTES));
    
    #condition
    if($fproposep_offer == 'select')
    {
        $fproposep_bok_sendemail = false;
        $_SESSION['msg_form_proposep_cdreditor_offer_object'] = $msg_error_fproposep_offer;
    }
    
    if($fproposep_typeobject == 'select')
    {
        $fproposep_bok_sendemail = false;
        $_SESSION['msg_form_proposep_cdreditor_type_object'] = $msg_error_fproposep_typeobject;
    }
    
    #operation
    if($fproposep_bok_sendemail === true)
    {
        $fproposep_desc = '<p style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">'.$fproposep_desc.'</p>';
        $fproposep_desc = nl2br($fproposep_desc);
        $fproposep_msg = '<p style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">'.$fproposep_msg.'</p>';
        $fproposep_msg = nl2br($fproposep_msg);
        include('modules/custom/immo/modules/email/send/user/propose_property/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'admin';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $fproposep_senderemail;
        $messages_insert_receiver = $config_email_senderemail;
        $messages_insert_bcc = $fproposep_bcc;
        $messages_insert_type = 'kform_proposep';
        $messages_insert_subject = $fproposep_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        $fproposep_emailuser = null;
        $prepared_query = 'SELECT email_user FROM user
                           WHERE id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $main_iduser_log);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $fproposep_emailuser = $data[0];
        }
        $query->closeCursor();
        
        include('modules/custom/immo/modules/email/send/admin/propose_property/email_main.php');
        $messages_insert_parent = 0;
        $messages_insert_status = 1;
        $messages_insert_target = 'user';
        $messages_insert_iduser = $main_iduser_log;
        $messages_insert_sender = $config_email_senderemail;
        $messages_insert_receiver = $fproposep_emailuser;
        $messages_insert_bcc = $fproposep_bcc;
        $messages_insert_type = 'kform_proposep';
        $messages_insert_subject = $fproposep_subject;
        $messages_contentmsg_part1 = strstr($message, '<body', true);
        $messages_contentmsg_part2 = strstr($message, '</body>');
        $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
        $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
        $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
        $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
        include('modules/email/messages/messages_insert.php');
        
        $_SESSION['msg_form_proposep_done'] = $msg_done_fproposep;
    }
    else
    {
        $_SESSION['form_proposep_cdreditor_offer_object'] = $fproposep_offer;
        $_SESSION['form_proposep_cdreditor_type_object'] = $fproposep_typeobject;
        $_SESSION['form_proposep_cdreditor_condition_object'] = $fproposep_condition;
        $_SESSION['form_proposep_cdreditor_location_situation'] = $fproposep_situation;
        $_SESSION['form_proposep_txtPriceProposeP'] = $fproposep_price;
        $_SESSION['form_proposep_areaDescProposeP'] = $fproposep_desc;
        $_SESSION['form_proposep_areaMsgProposeP'] = $fproposep_msg;
    }
}
?>
