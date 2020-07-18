<?php
if(isset($_POST['bt_backtolisting_useredit']))
{
    unset($_SESSION['useredit_gotoedition'],
            $_SESSION['useredit_iduser']);
    
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
