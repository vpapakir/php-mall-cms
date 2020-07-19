<?php
if(isset($_POST['bt_refresh_captcha_x']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['msg_form_contactmain_txtCaptchaFormContactMain'],
            $_SESSION['msg_form_contactmain_done']);

    $_SESSION['form_contactmain_txtEmailFormContactMain']= trim(htmlspecialchars($_POST['txtEmailFormContactMain'], ENT_QUOTES));
    $_SESSION['form_contactmain_txtNameFormContactMain']= trim(htmlspecialchars($_POST['txtNameFormContactMain'], ENT_QUOTES));
    $_SESSION['form_contactmain_txtPhoneFormContactMain']= trim(htmlspecialchars($_POST['txtPhoneFormContactMain'], ENT_QUOTES));
    $_SESSION['form_contactmain_cdreditor_formcontact_subject']= htmlspecialchars($_POST['cdreditor_formcontact_subject'], ENT_QUOTES);
    $_SESSION['form_contactmain_areaMsgFormContactMain']= trim(htmlspecialchars($_POST['areaMsgFormContactMain'], ENT_QUOTES));
}
?>
