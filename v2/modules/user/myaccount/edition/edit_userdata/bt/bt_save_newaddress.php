<?php
if(isset($_POST['bt_save_newaddress']))
{
//    if($_SESSION['index'] == 'index.php')
//    {
//        header('Location: '.$config_customheader.$rewritingF_page);
//    }
//    else
//    {
//        header('Location: '.$config_customheader.$rewritingB_page);
//    }
    
    #session
    
        #-main
    unset($_SESSION['myaccount_useredition_radUserEditionType'],
            $_SESSION['myaccount_useredition_cdreditor_title_UserEdition'],
            $_SESSION['myaccount_useredition_txtUserEditionFirstname'],
            $_SESSION['myaccount_useredition_txtUserEditionLastname'],
            $_SESSION['myaccount_useredition_txtUserEditionNamecompany'],
            $_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'],
            $_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'],
            $_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'],
            $_SESSION['myaccount_useredition_txtUserEditionSiretcompany'],
            $_SESSION['myaccount_useredition_txtUserEditionVatintracompany']);
        #-address
    unset($_SESSION['myaccount_useredition_txtUserEditionAddress1'],
            $_SESSION['myaccount_useredition_txtUserEditionAddress2'],
            $_SESSION['myaccount_useredition_txtUserEditionZip'],
            $_SESSION['myaccount_useredition_txtUserEditionCity'],
            $_SESSION['myaccount_useredition_cdrgeo_country_situation'],
            $_SESSION['myaccount_useredition_cboUserEditionLanguage']);
        #-phone & web info
    unset($_SESSION['myaccount_useredition_cboUserEditionBirthDay'],
            $_SESSION['myaccount_useredition_cboUserEditionBirthMonth'],
            $_SESSION['myaccount_useredition_cboUserEditionBirthYear'],
            $_SESSION['myaccount_useredition_txtUserEditionWebsite'],
            $_SESSION['myaccount_useredition_txtUserEditionLandline'],
            $_SESSION['myaccount_useredition_txtUserEditionMobile'],
            $_SESSION['myaccount_useredition_txtUserEditionFax']);  
    
    unset($_SESSION['msg_myaccount_useredition_cdreditor_title_UserEdition'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionNamecompany'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionSiretcompany'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionFirstname'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionLastname'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionAddress1'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionZip'],
            $_SESSION['msg_myaccount_useredition_txtUserEditionCity'],
            $_SESSION['msg_myaccount_useredition_cdrgeo_country_situation'],
            $_SESSION['msg_myaccount_useredition_phone'],
            $_SESSION['msg_myaccount_useredition_birthday'],
            $_SESSION['msg_myaccount_useredition_done']);
    
    #special
    $myaccount_useredition_bok_gotodb = true;
    $myaccount_useredition_bok_existnickname = false;
    
    #msg
    $msg_error_useredition_title = give_translation('messages.msg_error_userdata_title', 'false', $config_showtranslationcode);
    $msg_error_useredition_firstname = give_translation('messages.msg_error_userdata_firstname', 'false', $config_showtranslationcode);
    $msg_error_useredition_lastname = give_translation('messages.msg_error_userdata_lastname', 'false', $config_showtranslationcode);
    
    $msg_error_useredition_companyname = give_translation('messages.msg_error_userdata_companyname', 'false', $config_showtranslationcode);
    $msg_error_useredition_siret = give_translation('messages.msg_error_userdata_siret', 'false', $config_showtranslationcode);
    
    $msg_error_useredition_address1 = give_translation('messages.msg_error_userdata_address1', 'false', $config_showtranslationcode);
    $msg_error_useredition_zip = give_translation('messages.msg_error_userdata_zip', 'false', $config_showtranslationcode);
    $msg_error_useredition_city = give_translation('messages.msg_error_userdata_city', 'false', $config_showtranslationcode);
    $msg_error_useredition_country = give_translation('messages.msg_error_userdata_country', 'false', $config_showtranslationcode);
    
    $msg_error_useredition_phone = give_translation('messages.msg_error_userdata_phone', 'false', $config_showtranslationcode);
    $msg_done_useredition = give_translation('messages.msg_done_useredition', 'false', $config_showtranslationcode);
    $msg_error_useredition_birthday = give_translation('messages.msg_error_userdata_birthday', 'false', $config_showtranslationcode);
    #callinfo
    
    $myaccount_useredition_type = htmlspecialchars($_POST['radUserEditionType'], ENT_QUOTES);
    $myaccount_useredition_title = htmlspecialchars($_POST['cdreditor_title_userdata'], ENT_QUOTES);
    $myaccount_useredition_firstname = trim(htmlspecialchars($_POST['txtUserEditionFirstname'], ENT_QUOTES));
    $myaccount_useredition_lastname = trim(htmlspecialchars($_POST['txtUserEditionLastname'], ENT_QUOTES));
    $myaccount_useredition_companyname = trim(htmlspecialchars($_POST['txtUserEditionNamecompany'], ENT_QUOTES));
    $myaccount_useredition_companytype = htmlspecialchars($_POST['cdreditor_typecompany_userdata'], ENT_QUOTES);
    $myaccount_useredition_companyactivity = htmlspecialchars($_POST['cdreditor_activitycompany_userdata'], ENT_QUOTES);
    $myaccount_useredition_companyfunction = htmlspecialchars($_POST['cdreditor_functioncompany_userdata'], ENT_QUOTES);
    $myaccount_useredition_companysiret = trim(htmlspecialchars($_POST['txtUserEditionSiretcompany'], ENT_QUOTES));
    $myaccount_useredition_companyvatintra = trim(htmlspecialchars($_POST['txtUserEditionVatintracompany'], ENT_QUOTES));
    
    $myaccount_useredition_address1 = trim(htmlspecialchars($_POST['txtUserEditionAddress1'], ENT_QUOTES));
    $myaccount_useredition_address2 = trim(htmlspecialchars($_POST['txtUserEditionAddress2'], ENT_QUOTES));
    $myaccount_useredition_zip = trim(htmlspecialchars($_POST['txtUserEditionZip'], ENT_QUOTES));
    $myaccount_useredition_city = trim(htmlspecialchars($_POST['txtUserEditionCity'], ENT_QUOTES));
    $myaccount_useredition_country = trim(htmlspecialchars($_POST['cdrgeo_country_situation'], ENT_QUOTES));
    
    if(count($main_activatedidlang) > 1)
    {
        $myaccount_useredition_language = trim(htmlspecialchars($_POST['cboUserEditionLanguage'], ENT_QUOTES));
    }
    else
    {
        $myaccount_useredition_language = $main_id_language;
    }
    
    $myaccount_useredition_birthday = htmlspecialchars($_POST['cboUserEditionBirthDay'], ENT_QUOTES);
    $myaccount_useredition_birthmonth = htmlspecialchars($_POST['cboUserEditionBirthMonth'], ENT_QUOTES);
    $myaccount_useredition_birthyear = htmlspecialchars($_POST['cboUserEditionBirthYear'], ENT_QUOTES);
    $myaccount_useredition_website = trim(htmlspecialchars($_POST['txtUserEditionWebsite'], ENT_QUOTES));
    $myaccount_useredition_landline = trim(htmlspecialchars($_POST['txtUserEditionLandline'], ENT_QUOTES));
    $myaccount_useredition_mobile = trim(htmlspecialchars($_POST['txtUserEditionMobile'], ENT_QUOTES));
    $myaccount_useredition_fax = trim(htmlspecialchars($_POST['txtUserEditionFax'], ENT_QUOTES));
    
    #condition
    $subscription_birthday_data = $myaccount_useredition_birthyear.'-'.$myaccount_useredition_birthmonth.'-'.$myaccount_useredition_birthday;
    
    if($myaccount_useredition_birthday != 'select' || $myaccount_useredition_birthmonth != 'select' || $myaccount_useredition_birthyear != 'select')
    {
        if(($myaccount_useredition_birthday == 'select' || $myaccount_useredition_birthmonth == 'select' || $myaccount_useredition_birthyear == 'select')
                &&($myaccount_useredition_birthday != 'select' || $myaccount_useredition_birthmonth != 'select' || $myaccount_useredition_birthyear != 'select'))
        {
            $myaccount_useredition_bok_gotodb = false;
            $_SESSION['msg_myaccount_useredition_birthday'] = $msg_error_useredition_birthday;
        }
        else
        {
            if((check_date($subscription_birthday_data)) == false)
            {
                $myaccount_useredition_bok_gotodb = false;
                $_SESSION['msg_myaccount_useredition_birthday'] = $msg_error_useredition_birthday;
            }
        }
    }
    
    if($myaccount_useredition_title == 'select')
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_cdreditor_title_UserEdition'] = $msg_error_useredition_title;
    }
    else
    {
        if($myaccount_useredition_type == 'professional')
        {
            if(empty($myaccount_useredition_companyname) || strlen($myaccount_useredition_companyname) < 3)
            {
                $myaccount_useredition_bok_gotodb = false;
                $_SESSION['msg_myaccount_useredition_txtUserEditionNamecompany'] = $msg_error_useredition_companyname;
            }
            
            if(!empty($myaccount_useredition_companysiret) && 
                    (strlen($myaccount_useredition_companysiret) < 9 
                    || strlen($myaccount_useredition_companysiret) > 14))
            {
                $myaccount_useredition_bok_gotodb = false;
                $_SESSION['msg_myaccount_useredition_txtUserEditionSiretcompany'] = $msg_error_useredition_siret;
            }
            
            if($myaccount_useredition_companytype == 'select')
            {
                $myaccount_useredition_companytype = null;
            }
            
            if($myaccount_useredition_companyactivity == 'select')
            {
                $myaccount_useredition_companyactivity = null;
            }
            
            if($myaccount_useredition_companyfunction == 'select')
            {
                $myaccount_useredition_companyfunction = null;
            }
        }
        else
        {
            unset($myaccount_useredition_companyname, $myaccount_useredition_companysiret, 
                    $myaccount_useredition_companytype, $myaccount_useredition_companyactivity, $myaccount_useredition_companyfunction);
            
            if(empty($myaccount_useredition_firstname) || is_numeric($myaccount_useredition_firstname))
            {
                $myaccount_useredition_bok_gotodb = false;
                $_SESSION['msg_myaccount_useredition_txtUserEditionFirstname'] = $msg_error_useredition_firstname;
            }
            
            if(empty($myaccount_useredition_lastname) || is_numeric($myaccount_useredition_lastname))
            {
                $myaccount_useredition_bok_gotodb = false;
                $_SESSION['msg_myaccount_useredition_txtUserEditionLastname'] = $msg_error_useredition_lastname;
            }
        }
    }
    
    if(empty($myaccount_useredition_address1))
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_txtUserEditionAddress1'] = $msg_error_useredition_address1;
    }
    
    if(empty($myaccount_useredition_zip))
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_txtUserEditionZip'] = $msg_error_useredition_zip;
    }
    
    if(empty($myaccount_useredition_city))
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_txtUserEditionCity'] = $msg_error_useredition_city;
    }
    
    if($myaccount_useredition_country == 'select')
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_cdrgeo_country_situation'] = $msg_error_useredition_country;
    }
    
    if(empty($myaccount_useredition_landline) && empty($myaccount_useredition_mobile))
    {
        $myaccount_useredition_bok_gotodb = false;
        $_SESSION['msg_myaccount_useredition_phone'] = $msg_error_useredition_phone;
    }
    
    #data
    if($myaccount_useredition_bok_gotodb === true)
    {
        try
        {  
            include('modules/user/myaccount/edition/edit_userdata/bt/bt_save_newaddress/newaddress_update.php');
            $_SESSION['msg_myaccount_useredition_done'] = $msg_done_useredition;
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
        $_SESSION['myaccount_useredition_radUserEditionType'] = $myaccount_useredition_type;
        $_SESSION['myaccount_useredition_cdreditor_title_UserEdition'] = $myaccount_useredition_title;
        $_SESSION['myaccount_useredition_txtUserEditionFirstname'] = $myaccount_useredition_firstname;
        $_SESSION['myaccount_useredition_txtUserEditionLastname'] = $myaccount_useredition_lastname;
        $_SESSION['myaccount_useredition_txtUserEditionNamecompany'] = $myaccount_useredition_companyname;
        $_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'] = $myaccount_useredition_companytype;
        $_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'] = $myaccount_useredition_companyactivity;
        $_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'] = $myaccount_useredition_companyfunction;
        $_SESSION['myaccount_useredition_txtUserEditionSiretcompany'] = $myaccount_useredition_companysiret;
        $_SESSION['myaccount_useredition_txtUserEditionVatintracompany'] = $myaccount_useredition_companyvatintra;
        #-address
        $_SESSION['myaccount_useredition_txtUserEditionAddress1']= $myaccount_useredition_address1;
        $_SESSION['myaccount_useredition_txtUserEditionAddress2']= $myaccount_useredition_address2;
        $_SESSION['myaccount_useredition_txtUserEditionZip']= $myaccount_useredition_zip;
        $_SESSION['myaccount_useredition_txtUserEditionCity']= $myaccount_useredition_city;
        $_SESSION['myaccount_useredition_cdrgeo_country_situation']= $myaccount_useredition_country;
        $_SESSION['myaccount_useredition_cboUserEditionLanguage'] = $myaccount_useredition_language;
        #-phone & web info
        $_SESSION['myaccount_useredition_cboUserEditionBirthDay'] = $myaccount_useredition_birthday;
        $_SESSION['myaccount_useredition_cboUserEditionBirthMonth'] = $myaccount_useredition_birthmonth;
        $_SESSION['myaccount_useredition_cboUserEditionBirthYear'] = $myaccount_useredition_birthyear;
        $_SESSION['myaccount_useredition_txtUserEditionWebsite']= $myaccount_useredition_website;
        $_SESSION['myaccount_useredition_txtUserEditionLandline']= $myaccount_useredition_landline;
        $_SESSION['myaccount_useredition_txtUserEditionMobile']= $myaccount_useredition_mobile;
        $_SESSION['myaccount_useredition_txtUserEditionFax']= $myaccount_useredition_fax;
        
    }
}
?>
