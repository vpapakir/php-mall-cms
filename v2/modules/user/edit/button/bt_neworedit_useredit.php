<?php
if(isset($_POST['bt_new_useredit']) || isset($_GET['user']) || isset($_POST['bt_cboSelectUserEdit']))
{
    $_SESSION['useredit_gotoedition'] = true;
    unset($_SESSION['useredit_iduser']);
    
    if(isset($_GET['user']) || isset($_POST['bt_cboSelectUserEdit']))
    {
        if(isset($_POST['bt_cboSelectUserEdit']))
        {
            $useredit_iduser = htmlspecialchars($_POST['cboSelectUserEdit'], ENT_QUOTES);
        }
        else
        {
            $useredit_iduser = urldecode(htmlspecialchars($_GET['user'], ENT_QUOTES));
        }        
    }
    
    if((isset($_GET['user']) || isset($_POST['bt_cboSelectUserEdit'])) && !empty($useredit_iduser) && $useredit_iduser != 'new')
    {
        $_SESSION['useredit_iduser'] = $useredit_iduser;
        try
        {
            $prepared_query = 'SELECT * FROM user
                               WHERE id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('iduser', $useredit_iduser);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                #-main
                $_SESSION['userdata_radUserdataType'] = $data['type_user'];
                $_SESSION['userdata_cdreditor_title_userdata'] = $data['title_user'];
                $_SESSION['userdata_txtUserdataFirstname'] = $data['firstname_user'];
                $_SESSION['userdata_txtUserdataLastname'] = $data['name_user'];
                $_SESSION['userdata_txtUserdataNamecompany'] = $data['namecompany_user'];
                $_SESSION['userdata_cdreditor_typecompany_userdata'] = $data['typecompany_user'];
                $_SESSION['userdata_cdreditor_activitycompany_userdata'] = $data['activitycompany_user'];
                $_SESSION['userdata_cdreditor_functioncompany_userdata'] = $data['functioncompany_user'];
                $_SESSION['userdata_txtUserdataSiretcompany'] = $data['siretcompany_user'];
                $_SESSION['userdata_txtUserdataVatintracompany'] = $data['vatintracompany_user'];
                #-address
                $_SESSION['userdata_txtUserdataAddress1']= $data['address1_user'];
                $_SESSION['userdata_txtUserdataAddress2']= $data['address2_user'];
                $_SESSION['userdata_txtUserdataZip']= $data['zip_user'];
                $_SESSION['userdata_txtUserdataCity']= $data['city_user'];
                $_SESSION['userdata_cdrgeo_country_situation']= $data['country_user'];
                $_SESSION['userdata_cboUserdataLanguage'] = $data['id_language'];
                #-phone & web info
                $useredit_modify_birthday = split_string($data['birthday_user'], '-');
                $_SESSION['userdata_cboUserdataBirthDay'] = $useredit_modify_birthday[2];
                $_SESSION['userdata_cboUserdataBirthMonth'] = $useredit_modify_birthday[1];
                $_SESSION['userdata_cboUserdataBirthYear'] = $useredit_modify_birthday[0];
                $_SESSION['userdata_txtUserdataWebsite']= $data['website_user'];
                $_SESSION['userdata_txtUserdataLandline']= $data['landline_user'];
                $_SESSION['userdata_txtUserdataMobile']= $data['mobile_user'];
                $_SESSION['userdata_txtUserdataFax']= $data['fax_user'];
                #-login info
                $_SESSION['userdata_txtUserdataNickname']= $data['nickname_user'];
                $_SESSION['userdata_txtUserdataEmail']= $data['email_user'];
                #-admin
                $_SESSION['useredit_cboRightsUserEdit'] = $data['rights_user'];
                $_SESSION['useredit_cboStatusUserEdit'] = $data['status_user'];
                $_SESSION['useredit_areaRemarksUserEdit'] = $data['remarks_user'];
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
    else
    {
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
