<?php
if(isset($_POST['bt_save_useredit']))
{
    #session
    
    unset($_SESSION['userdata_radUserdataType'],
            $_SESSION['userdata_cdreditor_title_userdata'],
            $_SESSION['userdata_txtUserdataFirstname'],
            $_SESSION['userdata_txtUserdataLastname'],
            $_SESSION['userdata_txtUserdataNamecompany'],
            $_SESSION['userdata_cdreditor_typecompany_userdata'],
            $_SESSION['userdata_cdreditor_activitycompany_userdata'],
            $_SESSION['userdata_cdreditor_functioncompany_userdata'],
            $_SESSION['userdata_txtUserdataSiretcompany'],
            $_SESSION['userdata_txtUserdataVatintracompany'],
            $_SESSION['userdata_txtUserdataAddress1'],
            $_SESSION['userdata_txtUserdataAddress2'],
            $_SESSION['userdata_txtUserdataZip'],
            $_SESSION['userdata_txtUserdataCity'],
            $_SESSION['userdata_cdrgeo_country_situation'],
            $_SESSION['userdata_cboUserdataLanguage'],
            $_SESSION['userdata_cboUserdataBirthDay'],
            $_SESSION['userdata_cboUserdataBirthMonth'],
            $_SESSION['userdata_cboUserdataBirthYear'],
            $_SESSION['userdata_txtUserdataWebsite'],
            $_SESSION['userdata_txtUserdataLandline'],
            $_SESSION['userdata_txtUserdataMobile'],
            $_SESSION['userdata_txtUserdataFax'],
            $_SESSION['userdata_txtUserdataNickname'],
            $_SESSION['userdata_txtUserdataEmail'],
            $_SESSION['userdata_txtUserdataPassword'],
            $_SESSION['useredit_cboRightsUserEdit'],
            $_SESSION['useredit_cboStatusUserEdit'],
            $_SESSION['useredit_areaRemarksUserEdit'],
            $_SESSION['useredit_chkchangepassword']);
    
    unset($_SESSION['msg_userdata_cdreditor_title_userdata'],
            $_SESSION['msg_userdata_txtUserdataNamecompany'],
            $_SESSION['msg_userdata_txtUserdataSiretcompany'],
            $_SESSION['msg_userdata_txtUserdataFirstname'],
            $_SESSION['msg_userdata_txtUserdataLastname'],
            $_SESSION['msg_userdata_txtUserdataAddress1'],
            $_SESSION['msg_userdata_txtUserdataZip'],
            $_SESSION['msg_userdata_txtUserdataCity'],
            $_SESSION['msg_userdata_cdrgeo_country_situation'],
            $_SESSION['msg_userdata_phone'],
            $_SESSION['msg_userdata_txtUserdataNickname'],
            $_SESSION['msg_userdata_txtUserdataEmail'],
            $_SESSION['msg_userdata_txtUserdataPassword'],
            $_SESSION['msg_userdata_birthday'],
            $_SESSION['msg_useredit_done']);
    
    #special
    $useredit_bok_gotodb = true;
    $useredit_bok_existnickname = false;
    
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
    $msg_error_userdata_password = give_translation('messages.msg_error_userdata_password', 'false', $config_showtranslationcode);
    $msg_error_userdata_birthday = give_translation('messages.msg_error_userdata_birthday', 'false', $config_showtranslationcode);
    
    $msg_done_useredit_edit = give_translation('messages.msg_done_useredit_edit', 'false', $config_showtranslationcode);
    $msg_done_useredit_add = give_translation('messages.msg_done_useredit_add', 'false', $config_showtranslationcode);
    
    #callinfo
    $useredit_type = htmlspecialchars($_POST['radUserdataType'], ENT_QUOTES);
    $useredit_title = htmlspecialchars($_POST['cdreditor_title_userdata'], ENT_QUOTES);
    $useredit_firstname = trim(htmlspecialchars($_POST['txtUserdataFirstname'], ENT_QUOTES));
    $useredit_lastname = trim(htmlspecialchars($_POST['txtUserdataLastname'], ENT_QUOTES));
    $useredit_companyname = trim(htmlspecialchars($_POST['txtUserdataNamecompany'], ENT_QUOTES));
    $useredit_companytype = htmlspecialchars($_POST['cdreditor_typecompany_userdata'], ENT_QUOTES);
    $useredit_companyactivity = htmlspecialchars($_POST['cdreditor_activitycompany_userdata'], ENT_QUOTES);
    $useredit_companyfunction = htmlspecialchars($_POST['cdreditor_functioncompany_userdata'], ENT_QUOTES);
    $useredit_companysiret = trim(htmlspecialchars($_POST['txtUserdataSiretcompany'], ENT_QUOTES));
    $useredit_companyvatintra = trim(htmlspecialchars($_POST['txtUserdataVatintracompany'], ENT_QUOTES));
    
    $useredit_address1 = trim(htmlspecialchars($_POST['txtUserdataAddress1'], ENT_QUOTES));
    $useredit_address2 = trim(htmlspecialchars($_POST['txtUserdataAddress2'], ENT_QUOTES));
    $useredit_zip = trim(htmlspecialchars($_POST['txtUserdataZip'], ENT_QUOTES));
    $useredit_city = trim(htmlspecialchars($_POST['txtUserdataCity'], ENT_QUOTES));
    $useredit_country = trim(htmlspecialchars($_POST['cdrgeo_country_situation'], ENT_QUOTES));
    
    if(count($main_activatedidlang) > 1)
    {
        $useredit_language = trim(htmlspecialchars($_POST['cboUserdataLanguage'], ENT_QUOTES));
    }
    else
    {
        $useredit_language = $main_id_language;
    }
    
    $useredit_birthday = htmlspecialchars($_POST['cboUserdataBirthDay'], ENT_QUOTES);
    $useredit_birthmonth = htmlspecialchars($_POST['cboUserdataBirthMonth'], ENT_QUOTES);
    $useredit_birthyear = htmlspecialchars($_POST['cboUserdataBirthYear'], ENT_QUOTES);
    $useredit_website = trim(htmlspecialchars($_POST['txtUserdataWebsite'], ENT_QUOTES));
    $useredit_landline = trim(htmlspecialchars($_POST['txtUserdataLandline'], ENT_QUOTES));
    $useredit_mobile = trim(htmlspecialchars($_POST['txtUserdataMobile'], ENT_QUOTES));
    $useredit_fax = trim(htmlspecialchars($_POST['txtUserdataFax'], ENT_QUOTES));
    
    $useredit_nickname = trim(htmlspecialchars($_POST['txtUserdataNickname'], ENT_QUOTES));
    $useredit_email = trim(htmlspecialchars($_POST['txtUserdataEmail'], ENT_QUOTES));
    $useredit_password = trim(htmlspecialchars($_POST['txtUserdataPassword'], ENT_QUOTES));
    
    $useredit_checknewpassword = htmlspecialchars($_POST['chk_useredit_changepassword'], ENT_QUOTES);
    
    $useredit_status = htmlspecialchars($_POST['cboStatusUserEdit'], ENT_QUOTES);
    $useredit_rights = htmlspecialchars($_POST['cboRightsUserEdit'], ENT_QUOTES);
    $useredit_remarks = trim(htmlspecialchars($_POST['areaRemarksUserEdit'], ENT_QUOTES));
    
    #condition
    $useredit_birthday_data = $useredit_birthyear.'-'.$useredit_birthmonth.'-'.$useredit_birthday;
    
    if($useredit_birthday != 'select' || $useredit_birthmonth != 'select' || $useredit_birthyear != 'select')
    {
        if(($useredit_birthday == 'select' || $useredit_birthmonth == 'select' || $useredit_birthyear == 'select')
                &&($useredit_birthday != 'select' || $useredit_birthmonth != 'select' || $useredit_birthyear != 'select'))
        {
            $useredit_bok_gotodb = false;
            $_SESSION['msg_userdata_birthday'] = $msg_error_userdata_birthday;
        }
        else
        {
            if((check_date($useredit_birthday_data)) == false)
            {
                $useredit_bok_gotodb = false;
                $_SESSION['msg_userdata_birthday'] = $msg_error_userdata_birthday;
            }
        }
    }
    
    if($useredit_title == 'select')
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_cdreditor_title_userdata'] = $msg_error_userdata_title;
    }
    else
    {
        if($useredit_type == 'professional')
        {
            if(empty($useredit_companyname) || strlen($useredit_companyname) < 3)
            {
                $useredit_bok_gotodb = false;
                $_SESSION['msg_userdata_txtUserdataNamecompany'] = $msg_error_userdata_companyname;
            }
            
            if($useredit_companytype == 'select')
            {
                $useredit_companytype = null;
            }
            
            if($useredit_companyactivity == 'select')
            {
                $useredit_companyactivity = null;
            }
            
            if($useredit_companyfunction == 'select')
            {
                $useredit_companyfunction = null;
            }
        }
        else
        {
            unset($useredit_companyname,$useredit_companytype,$useredit_companyactivity,
                    $useredit_companyfunction,$useredit_companysiret,$useredit_companyvatintra);
            if(empty($useredit_firstname) || is_numeric($useredit_firstname))
            {
                $useredit_bok_gotodb = false;
                $_SESSION['msg_userdata_txtUserdataFirstname'] = $msg_error_userdata_firstname;
            }
            
            if(empty($useredit_lastname) || is_numeric($useredit_lastname))
            {
                $useredit_bok_gotodb = false;
                $_SESSION['msg_userdata_txtUserdataLastname'] = $msg_error_userdata_lastname;
            }
        }
    }
    
    if(empty($useredit_address1))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_txtUserdataAddress1'] = $msg_error_userdata_address1;
    }
    
    if(empty($useredit_zip))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_txtUserdataZip'] = $msg_error_userdata_zip;
    }
    
    if(empty($useredit_city))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_txtUserdataCity'] = $msg_error_userdata_city;
    }
    
    if($useredit_country == 'select')
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_cdrgeo_country_situation'] = $msg_error_userdata_country;
    }
    
    if(empty($useredit_landline) && empty($useredit_mobile))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_phone'] = $msg_error_userdata_phone;
    }
    
    if(strlen($useredit_nickname) < 4 || !preg_match("#([0-9a-zA-Z]{1,}[-._]?)+#", $useredit_nickname) || strlen($useredit_nickname) > 15 || empty($useredit_nickname))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_txtUserdataNickname'] = $msg_error_userdata_nickname;
    }
    else
    {
        try
        {
            $prepared_query = 'SELECT nickname_user FROM user
                               WHERE nickname_user = :nickname
                               AND id_user <> :iduser';
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'nickname' => $useredit_nickname,
                                  'iduser' => $_SESSION['useredit_iduser']
                                  ));
            
            if(($data = $query->fetch()) != false)
            {
                $useredit_bok_gotodb = false;
                $useredit_bok_existnickname = true;
                $_SESSION['msg_userdata_txtUserdataNickname'] = $msg_error_userdata_exist_nickname;
                $_SESSION['userdata_txtUserdataNickname'] = $useredit_nickname.$useredit_zip;
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

    if(empty($useredit_email))
    {
        $useredit_bok_gotodb = false;
        $_SESSION['msg_userdata_txtUserdataEmail'] = $msg_error_userdata_email;
    }
    else 
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $useredit_email))
        {
            $useredit_bok_gotodb = false;
            $_SESSION['msg_userdata_txtUserdataEmail'] = $msg_error_userdata_email;
        }
        else
        {
            try
            {
                $prepared_query = 'SELECT email_user FROM user
                                   WHERE email_user = :email
                                   AND id_user <> :iduser';
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                  'email' => $useredit_email,
                                  'iduser' => $_SESSION['useredit_iduser']
                                  ));

                if(($data = $query->fetch()) != false)
                {
                    $useredit_bok_gotodb = false;
                    $_SESSION['msg_userdata_txtUserdataEmail'] = str_replace('[#]', $config_sitename, $msg_error_userdata_exist_email);
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
    
    if(empty($_SESSION['useredit_iduser']) || $useredit_checknewpassword == 1)
    {
        if(empty($useredit_password) 
                || strlen($useredit_password) < 6  
                || strlen($useredit_password) > 26 
                || !preg_match('#[0-9a-zA-Z]#', $useredit_password))
        {
            $useredit_bok_gotodb = false;
            $_SESSION['msg_userdata_txtUserdataPassword'] = $msg_error_userdata_password;
        }
    }
    
    #data
    if($useredit_bok_gotodb === true)
    {
        try
        {    
            if(empty($_SESSION['useredit_iduser']))
            {
                include('modules/user/edit/button/bt_save_useredit/useredit_insert.php');               
            }
            else
            {
                include('modules/user/edit/button/bt_save_useredit/useredit_update.php');                
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
    }
    else
    {
        #-main
        $_SESSION['userdata_radUserdataType'] = $useredit_type;
        $_SESSION['userdata_cdreditor_title_userdata'] = $useredit_title;
        $_SESSION['userdata_txtUserdataFirstname'] = $useredit_firstname;
        $_SESSION['userdata_txtUserdataLastname'] = $useredit_lastname;
        $_SESSION['userdata_txtUserdataNamecompany'] = $useredit_companyname;
        $_SESSION['userdata_cdreditor_typecompany_userdata'] = $useredit_companytype;
        $_SESSION['userdata_cdreditor_activitycompany_userdata'] = $useredit_companyactivity;
        $_SESSION['userdata_cdreditor_functioncompany_userdata'] = $useredit_companyfunction;
        $_SESSION['userdata_txtUserdataSiretcompany'] = $useredit_companysiret;
        $_SESSION['userdata_txtUserdataVatintracompany'] = $useredit_companyvatintra;
        #-address
        $_SESSION['userdata_txtUserdataAddress1']= $useredit_address1;
        $_SESSION['userdata_txtUserdataAddress2']= $useredit_address2;
        $_SESSION['userdata_txtUserdataZip']= $useredit_zip;
        $_SESSION['userdata_txtUserdataCity']= $useredit_city;
        $_SESSION['userdata_cdrgeo_country_situation']= $useredit_country;
        $_SESSION['userdata_cboUserdataLanguage'] = $useredit_language;
        #-phone & web info
        $_SESSION['userdata_cboUserdataBirthDay'] = $useredit_birthday;
        $_SESSION['userdata_cboUserdataBirthMonth'] = $useredit_birthmonth;
        $_SESSION['userdata_cboUserdataBirthYear'] = $useredit_birthyear;
        $_SESSION['userdata_txtUserdataWebsite']= $useredit_website;
        $_SESSION['userdata_txtUserdataLandline']= $useredit_landline;
        $_SESSION['userdata_txtUserdataMobile']= $useredit_mobile;
        $_SESSION['userdata_txtUserdataFax']= $useredit_fax;
        #-login info
        $_SESSION['userdata_txtUserdataEmail']= $useredit_email;
        #-admin
        $_SESSION['useredit_cboRightsUserEdit'] = $useredit_rights;
        $_SESSION['useredit_cboStatusUserEdit'] = $useredit_status;
        $_SESSION['useredit_chkchangepassword'] = $useredit_checknewpassword;
        $_SESSION['useredit_areaRemarksUserEdit'] = $useredit_remarks;
        
        if($useredit_bok_existnickname === true)
        {
            $_SESSION['userdata_txtUserdataNickname']= $useredit_nickname.$useredit_zip;
        }
        else
        {
            $_SESSION['userdata_txtUserdataNickname']= $useredit_nickname;
        }
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
