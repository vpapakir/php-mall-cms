<?php
if(isset($_POST['bt_subscriptionform_userdata']))
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
    
        #-main
    unset($_SESSION['subscriptionform_radUserdataType'],
            $_SESSION['subscriptionform_cdreditor_title_userdata'],
            $_SESSION['subscriptionform_txtUserdataFirstname'],
            $_SESSION['subscriptionform_txtUserdataLastname'],
            $_SESSION['subscriptionform_txtUserdataNamecompany'],
            $_SESSION['subscriptionform_cdreditor_typecompany_userdata'],
            $_SESSION['subscriptionform_cdreditor_activitycompany_userdata'],
            $_SESSION['subscriptionform_cdreditor_functioncompany_userdata'],
            $_SESSION['subscriptionform_txtUserdataSiretcompany'],
            $_SESSION['subscriptionform_txtUserdataVatintracompany']);
        #-address
    unset($_SESSION['subscriptionform_txtUserdataAddress1'],
            $_SESSION['subscriptionform_txtUserdataAddress2'],
            $_SESSION['subscriptionform_txtUserdataZip'],
            $_SESSION['subscriptionform_txtUserdataCity'],
            $_SESSION['subscriptionform_cdrgeo_country_situation'],
            $_SESSION['subscriptionform_cboUserdataLanguage']);
        #-phone & web info
    unset($_SESSION['subscriptionform_cboUserdataBirthDay'],
            $_SESSION['subscriptionform_cboUserdataBirthMonth'],
            $_SESSION['subscriptionform_cboUserdataBirthYear'],
            $_SESSION['subscriptionform_txtUserdataWebsite'],
            $_SESSION['subscriptionform_txtUserdataLandline'],
            $_SESSION['subscriptionform_txtUserdataMobile'],
            $_SESSION['subscriptionform_txtUserdataFax']);
        #-login info
    unset($_SESSION['subscriptionform_txtUserdataNickname'],
            $_SESSION['subscriptionform_txtUserdataEmail'],
            $_SESSION['subscriptionform_txtUserdataEmailconfirm'],
            $_SESSION['subscriptionform_txtUserdataPassword'],
            $_SESSION['subscriptionform_txtUserdataPasswordconfirm']); 
    
    unset($_SESSION['msg_subscriptionform_cdreditor_title_userdata'],
            $_SESSION['msg_subscriptionform_txtUserdataNamecompany'],
            $_SESSION['msg_subscriptionform_txtUserdataSiretcompany'],
            $_SESSION['msg_subscriptionform_txtUserdataFirstname'],
            $_SESSION['msg_subscriptionform_txtUserdataLastname'],
            $_SESSION['msg_subscriptionform_txtUserdataAddress1'],
            $_SESSION['msg_subscriptionform_txtUserdataZip'],
            $_SESSION['msg_subscriptionform_txtUserdataCity'],
            $_SESSION['msg_subscriptionform_cdrgeo_country_situation'],
            $_SESSION['msg_subscriptionform_phone'],
            $_SESSION['msg_subscriptionform_txtUserdataNickname'],
            $_SESSION['msg_subscriptionform_txtUserdataEmail'],
            $_SESSION['msg_subscriptionform_txtUserdataEmailconfirm'],
            $_SESSION['msg_subscriptionform_txtUserdataPassword'],
            $_SESSION['msg_subscriptionform_txtUserdataPasswordconfirm'],
            $_SESSION['msg_subscriptionform_txtUserdataCaptcha'],
            $_SESSION['msg_subscriptionform_birthday'],
            $_SESSION['msg_subscriptionform_emailsent']);
    
    #special
    $subscriptionform_bok_gotodb = true;
    $subscriptionform_bok_existnickname = false;
    
    #msg
    $msg_error_userdata_title = give_translation('messages.msg_error_userdata_title', 'false', $config_showtranslationcode);
    $msg_error_userdata_firstname = give_translation('messages.msg_error_userdata_firstname', 'false', $config_showtranslationcode);
    $msg_error_userdata_lastname = give_translation('messages.msg_error_userdata_lastname', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_companyname = give_translation('messages.msg_error_userdata_companyname', 'false', $config_showtranslationcode);
    $msg_error_userdata_siret = give_translation('messages.msg_error_userdata_siret', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_address1 = give_translation('messages.msg_error_userdata_address1', 'false', $config_showtranslationcode);
    $msg_error_userdata_zip = give_translation('messages.msg_error_userdata_zip', 'false', $config_showtranslationcode);
    $msg_error_userdata_city = give_translation('messages.msg_error_userdata_city', 'false', $config_showtranslationcode);
    $msg_error_userdata_country = give_translation('messages.msg_error_userdata_country', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_phone = give_translation('messages.msg_error_userdata_phone', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_exist_nickname = give_translation('messages.msg_error_userdata_exist_nickname', 'false', $config_showtranslationcode);
    $msg_error_userdata_nickname = give_translation('messages.msg_error_userdata_nickname', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_exist_email = give_translation('messages.msg_error_userdata_exist_email', 'false', $config_showtranslationcode);
    $msg_error_userdata_email = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_emailconfirm = give_translation('messages.msg_error_userdata_emailconfirm', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_password = give_translation('messages.msg_error_userdata_password', 'false', $config_showtranslationcode);
    $msg_error_userdata_passwordconfirm = give_translation('messages.msg_error_userdata_passwordconfirm', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_captcha = give_translation('messages.msg_error_captcha', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_birthday = give_translation('messages.msg_error_userdata_birthday', 'false', $config_showtranslationcode);
    
    $msg_error_userdata_emailsent = give_translation('messages.msg_error_userdata_emailsent', 'false', $config_showtranslationcode);
    
    #callinfo
    
    $subscriptionform_type = htmlspecialchars($_POST['radUserdataType'], ENT_QUOTES);
    $subscriptionform_title = htmlspecialchars($_POST['cdreditor_title_userdata'], ENT_QUOTES);
    $subscriptionform_firstname = trim(htmlspecialchars($_POST['txtUserdataFirstname'], ENT_QUOTES));
    $subscriptionform_lastname = trim(htmlspecialchars($_POST['txtUserdataLastname'], ENT_QUOTES));
    $subscriptionform_companyname = trim(htmlspecialchars($_POST['txtUserdataNamecompany'], ENT_QUOTES));
    $subscriptionform_companytype = htmlspecialchars($_POST['cdreditor_typecompany_userdata'], ENT_QUOTES);
    $subscriptionform_companyactivity = htmlspecialchars($_POST['cdreditor_activitycompany_userdata'], ENT_QUOTES);
    $subscriptionform_companyfunction = htmlspecialchars($_POST['cdreditor_functioncompany_userdata'], ENT_QUOTES);
    $subscriptionform_companysiret = trim(htmlspecialchars($_POST['txtUserdataSiretcompany'], ENT_QUOTES));
    $subscriptionform_companyvatintra = trim(htmlspecialchars($_POST['txtUserdataVatintracompany'], ENT_QUOTES));
    
    $subscriptionform_address1 = trim(htmlspecialchars($_POST['txtUserdataAddress1'], ENT_QUOTES));
    $subscriptionform_address2 = trim(htmlspecialchars($_POST['txtUserdataAddress2'], ENT_QUOTES));
    $subscriptionform_zip = trim(htmlspecialchars($_POST['txtUserdataZip'], ENT_QUOTES));
    $subscriptionform_city = trim(htmlspecialchars($_POST['txtUserdataCity'], ENT_QUOTES));
    $subscriptionform_country = trim(htmlspecialchars($_POST['cdrgeo_country_situation'], ENT_QUOTES));
    
    if(count($main_activatedidlang) > 1)
    {
        $subscriptionform_language = trim(htmlspecialchars($_POST['cboUserdataLanguage'], ENT_QUOTES));
    }
    else
    {
        $subscriptionform_language = $main_id_language;
    }
    
    $subscriptionform_birthday = htmlspecialchars($_POST['cboUserdataBirthDay'], ENT_QUOTES);
    $subscriptionform_birthmonth = htmlspecialchars($_POST['cboUserdataBirthMonth'], ENT_QUOTES);
    $subscriptionform_birthyear = htmlspecialchars($_POST['cboUserdataBirthYear'], ENT_QUOTES);
    $subscriptionform_website = trim(htmlspecialchars($_POST['txtUserdataWebsite'], ENT_QUOTES));
    $subscriptionform_landline = trim(htmlspecialchars($_POST['txtUserdataLandline'], ENT_QUOTES));
    $subscriptionform_mobile = trim(htmlspecialchars($_POST['txtUserdataMobile'], ENT_QUOTES));
    $subscriptionform_fax = trim(htmlspecialchars($_POST['txtUserdataFax'], ENT_QUOTES));
    
    $subscriptionform_nickname = trim(htmlspecialchars($_POST['txtUserdataNickname'], ENT_QUOTES));
    $subscriptionform_email = trim(htmlspecialchars($_POST['txtUserdataEmail'], ENT_QUOTES));
    $subscriptionform_confirmemail = trim(htmlspecialchars($_POST['txtUserdataEmailconfirm'], ENT_QUOTES));
    $subscriptionform_password = trim(htmlspecialchars($_POST['txtUserdataPassword'], ENT_QUOTES));
    $subscriptionform_confirmpassword = trim(htmlspecialchars($_POST['txtUserdataPasswordconfirm'], ENT_QUOTES));
    
    $subscriptionform_captcha = trim(htmlspecialchars($_POST['txtUserdataCaptcha'], ENT_QUOTES));
    $subscriptionform_captchacurrent = trim(htmlspecialchars($_POST['txtUserdataHiddenK'], ENT_QUOTES));
    
    #condition
    $subscriptionform_password_foremail = $subscriptionform_password;
    $subscription_birthday_data = $subscriptionform_birthyear.'-'.$subscriptionform_birthmonth.'-'.$subscriptionform_birthday;
    
    if($subscriptionform_birthday != 'select' || $subscriptionform_birthmonth != 'select' || $subscriptionform_birthyear != 'select')
    {
        if(($subscriptionform_birthday == 'select' || $subscriptionform_birthmonth == 'select' || $subscriptionform_birthyear == 'select')
                &&($subscriptionform_birthday != 'select' || $subscriptionform_birthmonth != 'select' || $subscriptionform_birthyear != 'select'))
        {
            $subscriptionform_bok_gotodb = false;
            $_SESSION['msg_subscriptionform_birthday'] = $msg_error_userdata_birthday;
        }
        else
        {
            if((check_date($subscription_birthday_data)) == false)
            {
                $subscriptionform_bok_gotodb = false;
                $_SESSION['msg_subscriptionform_birthday'] = $msg_error_userdata_birthday;
            }
        }
    }
    
    if($subscriptionform_title == 'select')
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_cdreditor_title_userdata'] = $msg_error_userdata_title;
    }
    else
    {
        if($subscriptionform_type == 'professional')
        {
            if(empty($subscriptionform_companyname) || strlen($subscriptionform_companyname) < 3)
            {
                $subscriptionform_bok_gotodb = false;
                $_SESSION['msg_subscriptionform_txtUserdataNamecompany'] = $msg_error_userdata_companyname;
            }
            
            if(!empty($subscriptionform_companysiret) && 
                    (strlen($subscriptionform_companysiret) < 9 
                    || strlen($subscriptionform_companysiret) > 14))
            {
                $subscriptionform_bok_gotodb = false;
                $_SESSION['msg_subscriptionform_txtUserdataSiretcompany'] = $msg_error_userdata_siret;
            }
            
            if($subscriptionform_companytype == 'select')
            {
                $subscriptionform_companytype = null;
            }
            
            if($subscriptionform_companyactivity == 'select')
            {
                $subscriptionform_companyactivity = null;
            }
            
            if($subscriptionform_companyfunction == 'select')
            {
                $subscriptionform_companyfunction = null;
            }
        }
        else
        {
            if(empty($subscriptionform_firstname) || is_numeric($subscriptionform_firstname))
            {
                $subscriptionform_bok_gotodb = false;
                $_SESSION['msg_subscriptionform_txtUserdataFirstname'] = $msg_error_userdata_firstname;
            }
            
            if(empty($subscriptionform_lastname) || is_numeric($subscriptionform_lastname))
            {
                $subscriptionform_bok_gotodb = false;
                $_SESSION['msg_subscriptionform_txtUserdataLastname'] = $msg_error_userdata_lastname;
            }
        }
    }
    
    if(empty($subscriptionform_address1))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataAddress1'] = $msg_error_userdata_address1;
    }
    
    if(empty($subscriptionform_zip))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataZip'] = $msg_error_userdata_zip;
    }
    
    if(empty($subscriptionform_city))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataCity'] = $msg_error_userdata_city;
    }
    
    if($subscriptionform_country == 'select')
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_cdrgeo_country_situation'] = $msg_error_userdata_country;
    }
    
    if(empty($subscriptionform_landline) && empty($subscriptionform_mobile))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_phone'] = $msg_error_userdata_phone;
    }
    
    if(strlen($subscriptionform_nickname) < 4 || !preg_match("#([0-9a-zA-Z]{1,}[-._]?)+#", $subscriptionform_nickname) || strlen($subscriptionform_nickname) > 15 || empty($subscriptionform_nickname))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataNickname'] = $msg_error_userdata_nickname;
    }
    else
    {
        try
        {
            $prepared_query = 'SELECT nickname_user FROM user
                               WHERE nickname_user = :nickname';
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('nickname', $subscriptionform_nickname);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $subscriptionform_bok_gotodb = false;
                $subscriptionform_bok_existnickname = true;
                $_SESSION['msg_subscriptionform_txtUserdataNickname'] = $msg_error_userdata_exist_nickname;
                $_SESSION['subscriptionform_txtUserdataNickname'] = $subscriptionform_nickname.$subscriptionform_zip;
            }
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
    }

    if(empty($subscriptionform_email))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataEmail'] = $msg_error_userdata_email;
    }
    else 
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $subscriptionform_email))
        {
            $subscriptionform_bok_gotodb = false;
            $_SESSION['msg_subscriptionform_txtUserdataEmail'] = $msg_error_userdata_email;
        }
        else
        {
            try
            {
                $prepared_query = 'SELECT email_user FROM user
                                   WHERE email_user = :email';
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('email', $subscriptionform_email);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $subscriptionform_bok_gotodb = false;
                    $_SESSION['msg_subscriptionform_txtUserdataEmail'] = str_replace('[#]', $config_sitename, $msg_error_userdata_exist_email);
                }
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
        }
    }
    
    if($subscriptionform_confirmemail != $subscriptionform_email)
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataEmailconfirm'] = $msg_error_userdata_emailconfirm;
    }
    
    if(empty($subscriptionform_password) 
            || strlen($subscriptionform_password) < 6  
            || strlen($subscriptionform_password) > 26 
            || !preg_match('#[0-9a-zA-Z]#', $subscriptionform_password))
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataPassword'] = $msg_error_userdata_password;
    }
    
    if($subscriptionform_confirmpassword != $subscriptionform_password)
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataPasswordconfirm'] = $msg_error_userdata_passwordconfirm;
    }
    
    if($subscriptionform_captcha != $subscriptionform_captchacurrent)
    {
        $subscriptionform_bok_gotodb = false;
        $_SESSION['msg_subscriptionform_txtUserdataCaptcha'] = $msg_error_userdata_captcha;
    }
    
    #data
    if($subscriptionform_bok_gotodb === true)
    {
        try
        {    
            include('modules/user/subscription/insert_user.php');
            include('modules/user/subscription/insert_user_tempconfirmcode.php');
            include('modules/email/send/user/subscription/email_main.php');  
            
            include('modules/email/send/admin/subscription/email_main.php');
            $messages_insert_parent = 0;
            $messages_insert_status = 1;
            $messages_insert_target = 'admin';
            $messages_insert_iduser = $subscriptionform_lastiduser;
            $messages_insert_sender = $subscriptionform_email;
            $messages_insert_receiver = $config_email_senderemail;
            $messages_insert_bcc = $subscription_confirm_bcc;
            $messages_insert_type = 'subscription';
            $messages_insert_subject = $subscription_confirm_subject;
            $messages_contentmsg_part1 = strstr($message, '<body', true);
            $messages_contentmsg_part2 = strstr($message, '</body>');
            $messages_insert_content = str_replace($messages_contentmsg_part1, '', $message);
            $messages_insert_content = str_replace($messages_contentmsg_part2, '', $messages_insert_content);
            $messages_insert_content = str_replace('<body>', '', $messages_insert_content);
            $messages_insert_content = trim(str_replace('</body>', '', $messages_insert_content));
            include('modules/email/messages/messages_insert.php');
            
            $_SESSION['msg_subscriptionform_emailsent'] = str_replace('[#]', $config_sitename, $msg_error_userdata_emailsent);
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
    }
    else
    {
        #-main
        $_SESSION['subscriptionform_radUserdataType'] = $subscriptionform_type;
        $_SESSION['subscriptionform_cdreditor_title_userdata'] = $subscriptionform_title;
        $_SESSION['subscriptionform_txtUserdataFirstname'] = $subscriptionform_firstname;
        $_SESSION['subscriptionform_txtUserdataLastname'] = $subscriptionform_lastname;
        $_SESSION['subscriptionform_txtUserdataNamecompany'] = $subscriptionform_companyname;
        $_SESSION['subscriptionform_cdreditor_typecompany_userdata'] = $subscriptionform_companytype;
        $_SESSION['subscriptionform_cdreditor_activitycompany_userdata'] = $subscriptionform_companyactivity;
        $_SESSION['subscriptionform_cdreditor_functioncompany_userdata'] = $subscriptionform_companyfunction;
        $_SESSION['subscriptionform_txtUserdataSiretcompany'] = $subscriptionform_companysiret;
        $_SESSION['subscriptionform_txtUserdataVatintracompany'] = $subscriptionform_companyvatintra;
        #-address
        $_SESSION['subscriptionform_txtUserdataAddress1']= $subscriptionform_address1;
        $_SESSION['subscriptionform_txtUserdataAddress2']= $subscriptionform_address2;
        $_SESSION['subscriptionform_txtUserdataZip']= $subscriptionform_zip;
        $_SESSION['subscriptionform_txtUserdataCity']= $subscriptionform_city;
        $_SESSION['subscriptionform_cdrgeo_country_situation']= $subscriptionform_country;
        $_SESSION['subscriptionform_cboUserdataLanguage'] = $subscriptionform_language;
        #-phone & web info
        $_SESSION['subscriptionform_cboUserdataBirthDay'] = $subscriptionform_birthday;
        $_SESSION['subscriptionform_cboUserdataBirthMonth'] = $subscriptionform_birthmonth;
        $_SESSION['subscriptionform_cboUserdataBirthYear'] = $subscriptionform_birthyear;
        $_SESSION['subscriptionform_txtUserdataWebsite']= $subscriptionform_website;
        $_SESSION['subscriptionform_txtUserdataLandline']= $subscriptionform_landline;
        $_SESSION['subscriptionform_txtUserdataMobile']= $subscriptionform_mobile;
        $_SESSION['subscriptionform_txtUserdataFax']= $subscriptionform_fax;
        #-login info
        $_SESSION['subscriptionform_txtUserdataEmail']= $subscriptionform_email;
        $_SESSION['subscriptionform_txtUserdataEmailconfirm']= $subscriptionform_confirmemail;
        $_SESSION['subscriptionform_txtUserdataPassword']= $subscriptionform_password;
        $_SESSION['subscriptionform_txtUserdataPasswordconfirm']= $subscriptionform_confirmpassword;
        
        if($subscriptionform_bok_existnickname === true)
        {
            $_SESSION['subscriptionform_txtUserdataNickname']= $subscriptionform_nickname.$subscriptionform_zip;
        }
        else
        {
            $_SESSION['subscriptionform_txtUserdataNickname']= $subscriptionform_nickname;
        }
    }
}
?>
