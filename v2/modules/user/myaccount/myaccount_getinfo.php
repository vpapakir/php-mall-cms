<?php
try
{
    #USER INFO
    $prepared_query = 'SELECT * FROM user
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $myaccount_user_nickname = $data['nickname_user'];
        $myaccount_user_email = $data['email_user'];
        $myaccount_user_type = $data['type_user'];
        $myaccount_user_title = $data['title_user'];
        $myaccount_user_firstname = $data['firstname_user'];
        $myaccount_user_lastname = $data['name_user'];
        $myaccount_user_birthday = $data['birthday_user'];
        $myaccount_user_companytype = $data['typecompany_user'];
        $myaccount_user_companyname = $data['namecompany_user'];
        $myaccount_user_companyfunction = $data['functioncompany_user'];
        $myaccount_user_companyactivity = $data['activitycompany_user'];
        $myaccount_user_companysiret = $data['siretcompany_user'];
        $myaccount_user_companyvatintra = $data['vatcompany_user'];
        $myaccount_user_address1 = $data['address1_user'];
        $myaccount_user_address2 = $data['address2_user'];
        $myaccount_user_zip = $data['zip_user'];
        $myaccount_user_city = $data['city_user'];
        $myaccount_user_language = $data['id_language'];
        $myaccount_user_country = $data['country_user'];
        $myaccount_user_landline = $data['landline_user'];
        $myaccount_user_mobile = $data['mobile_user'];
        $myaccount_user_fax = $data['fax_user'];
        $myaccount_user_website = $data['website_user'];
        
        $myaccount_user_lastlog = $data['last_log_user'];
        $myaccount_user_subscriptiondate = $data['subscription_date_user'];
    }
    $query->closeCursor();
    
    #MESSAGE
    $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                       WHERE target_messages = "user"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $myaccount_msg_total_count = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT MAX(id_messages) FROM email_messages
                       WHERE target_messages = "user"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $myaccount_msg_last_idmsg = $data[0];
    }
    $query->closeCursor();
    
    #[unread]
    $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                       WHERE target_messages = "user"
                       AND status_messages = 1
                       AND id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    
    while($data = $query->fetch())
    {
        $myaccount_msg_unread_count = $data[0];
    }
    $query->closeCursor();
    
    $myaccount_msg_blocktitle = give_translation('myaccount.block_title_msg', 'false', $config_showtranslationcode);
    $myaccount_msg_blocktitle = str_replace('[#count_myaccount_unread]', $myaccount_msg_unread_count, $myaccount_msg_blocktitle);
    #[/unread]
    
    #[read]
    $prepared_query = 'SELECT COUNT(id_messages) FROM email_messages
                       WHERE target_messages = "user"
                       AND status_messages = 2
                       AND id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    
    while($data = $query->fetch())
    {
        $myaccount_msg_read_count = $data[0];
    }
    $query->closeCursor();
    
    $myaccount_msg_blocktitle = str_replace('[#count_myaccount_read]', $myaccount_msg_read_count, $myaccount_msg_blocktitle);
    #[/read]
    
    if(isset($_GET['idmsg']))
    {
        $myaccount_msg_view_idmsg = trim(htmlspecialchars(rawurldecode($_GET['idmsg']), ENT_QUOTES));
        
        $prepared_query = 'UPDATE email_messages
                           SET status_messages = 2,
                           lastdate_messages = NOW()
                           WHERE id_messages = :idmsg';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'idmsg' => $myaccount_msg_view_idmsg               
                            ));
        $query->closeCursor();
        
        $prepared_query = 'SELECT * FROM email_messages
                           WHERE id_messages = :idmsg';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idmsg', $myaccount_msg_view_idmsg);
        $query->execute();
       

        if(($data = $query->fetch()) != false)
        {
            $myaccount_msg_view_shortdate = converto_timestamp($data['firstdate_messages']);
            $myaccount_msg_view_longdate = date('d-m-Y, H:i', $myaccount_msg_view_shortdate);
            $myaccount_msg_view_shortdate = date('d-m-Y', $myaccount_msg_view_shortdate);

            $myaccount_msg_prepared_query = 'SELECT * FROM user
                                             WHERE email_user = :emailuser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $myaccount_msg_prepared_query; }
            $myaccount_msg_query = $connectData->prepare($myaccount_msg_prepared_query);
            $myaccount_msg_query->bindParam('emailuser', $data['senderemail_messages']);
            $myaccount_msg_query->execute();
            if(($myaccount_msg_data = $myaccount_msg_query->fetch()) != false)
            {
                if(!empty($myaccount_msg_data['namecompany_user']))
                {
                    $myaccount_msg_view_sender = $myaccount_msg_data['namecompany_user'];
                    $myaccount_msg_view_sender_title = $myaccount_msg_data['namecompany_user']."\r\n".$myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['senderemail_messages'];
                }
                else
                {
                    $myaccount_msg_view_sender = substr($myaccount_msg_data['firstname_user'], 0, 1).'. '.$myaccount_msg_data['name_user'];
                    $myaccount_msg_view_sender_title = $myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['senderemail_messages'];   
                }
            }
            else
            {
                $myaccount_msg_view_sender = $data['senderemail_messages'];
                $myaccount_msg_view_sender_title = $data['senderemail_messages'];
            }
            $myaccount_msg_query->closeCursor();
            
            $myaccount_msg_prepared_query = 'SELECT * FROM user
                                             WHERE email_user = :emailuser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $myaccount_msg_prepared_query; }
            $myaccount_msg_query = $connectData->prepare($myaccount_msg_prepared_query);
            $myaccount_msg_query->bindParam('emailuser', $data['receiveremail_messages']);
            $myaccount_msg_query->execute();
            if(($myaccount_msg_data = $myaccount_msg_query->fetch()) != false)
            {
                if(!empty($myaccount_msg_data['namecompany_user']))
                {
                    $myaccount_msg_view_receiver = $myaccount_msg_data['namecompany_user'];
                    $myaccount_msg_view_receiver_title = $myaccount_msg_data['namecompany_user']."\r\n".$myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['receiveremail_messages'];
                }
                else
                {
                    $myaccount_msg_view_receiver = substr($myaccount_msg_data['firstname_user'], 0, 1).'. '.$myaccount_msg_data['name_user'];
                    $myaccount_msg_view_receiver_title = $myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['receiveremail_messages'];   
                }
            }
            else
            {
                $myaccount_msg_view_receiver = $data['senderemail_messages'];
                $myaccount_msg_view_receiver_title = $data['senderemail_messages'];
            }
            $myaccount_msg_query->closeCursor();

            $myaccount_msg_view_subject = $data['subject_messages'];
            $myaccount_msg_view_subject_toreplace = strstr($myaccount_msg_view_subject, ']', true);
            $myaccount_msg_view_subject = trim(str_replace($myaccount_msg_view_subject_toreplace.']', '', $myaccount_msg_view_subject));
            $myaccount_msg_view_type = give_translation('mail_edit.dd_family_'.$data['type_messages'], 'false', $config_showtranslationcode);

            if((strstr($myaccount_msg_view_type, '(', true)) == true)
            {
                $myaccount_msg_view_type = strstr($myaccount_msg_view_type, '(', true);
            }
            $myaccount_msg_view_sender_title = nl2br($myaccount_msg_view_sender_title);
            $myaccount_msg_view_receiver_title = nl2br($myaccount_msg_view_receiver_title);
            $myaccount_msg_view_status = str_replace('([#count_msgedit_unread])', '', give_translation('message_edit.block_title_unread', 'false', $config_showtranslationcode));
        
            $myaccount_msg_view_btreply_show = give_translation('main.bt_answer', 'false', $config_showtranslationcode);
            $myaccount_msg_view_btreply_hide = give_translation('main.bt_cancel_reply', 'false', $config_showtranslationcode);
        }
    }
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
