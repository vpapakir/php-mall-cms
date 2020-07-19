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
    
    unset($_SESSION['msg_kform_prodemail_txtCaptchaProdemail'],
            $_SESSION['msg_kform_prodemail_done']);

    $_SESSION['kform_prodemail_txtUseremailProdemail'] = trim(htmlspecialchars($_POST['txtUseremailProdemail'], ENT_QUOTES));
    for($i = 0; $i < 5; $i++)
    {
        $_SESSION['kform_prodemail_txtOtheremailProdemail'.$i] = trim(htmlspecialchars($_POST['txtOtheremailProdemail'.$i], ENT_QUOTES));
    }

}
?>
