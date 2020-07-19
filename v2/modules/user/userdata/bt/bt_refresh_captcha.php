<?php
if(isset($_POST['bt_refresh_captcha_x']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page.'#bt_refresh_captcha');
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page.'#bt_refresh_captcha');
    }
    
    unset($_SESSION['msg_subscriptionform_txtUserdataCaptcha']);

    #-main
    $_SESSION['subscriptionform_radUserdataType']= htmlspecialchars($_POST['radUserdataType'], ENT_QUOTES);
    $_SESSION['subscriptionform_cdreditor_title_userdata']= htmlspecialchars($_POST['cdreditor_title_userdata'], ENT_QUOTES);
    $_SESSION['subscriptionform_txtUserdataFirstname']= trim(htmlspecialchars($_POST['txtUserdataFirstname'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataLastname']= trim(htmlspecialchars($_POST['txtUserdataLastname'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataNamecompany']= trim(htmlspecialchars($_POST['txtUserdataNamecompany'], ENT_QUOTES));
    $_SESSION['subscriptionform_cdreditor_typecompany_userdata']= htmlspecialchars($_POST['cdreditor_typecompany_userdata'], ENT_QUOTES);
    $_SESSION['subscriptionform_cdreditor_activitycompany_userdata']= htmlspecialchars($_POST['cdreditor_activitycompany_userdata'], ENT_QUOTES);
    $_SESSION['subscriptionform_cdreditor_functioncompany_userdata']= htmlspecialchars($_POST['cdreditor_functioncompany_userdata'], ENT_QUOTES);
    $_SESSION['subscriptionform_txtUserdataSiretcompany']= trim(htmlspecialchars($_POST['txtUserdataSiretcompany'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataVatintracompany']= trim(htmlspecialchars($_POST['txtUserdataVatintracompany'], ENT_QUOTES));
    #-address
    $_SESSION['subscriptionform_txtUserdataAddress1']= trim(htmlspecialchars($_POST['txtUserdataAddress1'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataAddress2']= trim(htmlspecialchars($_POST['txtUserdataAddress2'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataZip']= trim(htmlspecialchars($_POST['txtUserdataZip'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataCity']= trim(htmlspecialchars($_POST['txtUserdataCity'], ENT_QUOTES));
    $_SESSION['subscriptionform_cdrgeo_country_situation']= trim(htmlspecialchars($_POST['cdrgeo_country_situation'], ENT_QUOTES));
    $_SESSION['subscriptionform_cboUserdataLanguage'] = htmlspecialchars($_POST['cboUserdataLanguage'], ENT_QUOTES);
    #-phone & web info
    $_SESSION['subscriptionform_cboUserdataBirthDay'] = htmlspecialchars($_POST['cboUserdataBirthDay'], ENT_QUOTES);
    $_SESSION['subscriptionform_cboUserdataBirthMonth'] = htmlspecialchars($_POST['cboUserdataBirthMonth'], ENT_QUOTES);
    $_SESSION['subscriptionform_cboUserdataBirthYear'] = htmlspecialchars($_POST['cboUserdataBirthYear'], ENT_QUOTES);
    $_SESSION['subscriptionform_txtUserdataWebsite']= trim(htmlspecialchars($_POST['txtUserdataWebsite'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataLandline']= trim(htmlspecialchars($_POST['txtUserdataLandline'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataMobile']= trim(htmlspecialchars($_POST['txtUserdataMobile'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataFax']= trim(htmlspecialchars($_POST['txtUserdataFax'], ENT_QUOTES));
    #-login info 
    $_SESSION['subscriptionform_txtUserdataEmail']= trim(htmlspecialchars($_POST['txtUserdataEmail'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataEmailconfirm']= trim(htmlspecialchars($_POST['txtUserdataEmailconfirm'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataPassword']= trim(htmlspecialchars($_POST['txtUserdataPassword'], ENT_QUOTES));
    $_SESSION['subscriptionform_txtUserdataPasswordconfirm']= trim(htmlspecialchars($_POST['txtUserdataPasswordconfirm'], ENT_QUOTES));

    $_SESSION['subscriptionform_txtUserdataNickname']= trim(htmlspecialchars($_POST['txtUserdataNickname'], ENT_QUOTES));
    
}
?>
