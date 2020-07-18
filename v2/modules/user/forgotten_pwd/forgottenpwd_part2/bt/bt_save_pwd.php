<?php
if(isset($_POST['bt_save_pwd']))
{
    #session
    unset($_SESSION['msg_forgottenpwd2_txtNewPwdConfirmForgottenpwd2'],
            $_SESSION['msg_forgottenpwd2_txtNewPwdForgottenpwd2'],
            $_SESSION['msg_done_forgottenpwd2']);
    unset($_SESSION['forgottenpwd2_txtNewPwdForgottenpwd2']);
    #msg
    $msg_error_forgottenpwd2_password = give_translation('messages.msg_error_userdata_password', 'false', $config_showtranslationcode);
    $msg_error_forgottenpwd2_passwordconfirm = give_translation('messages.msg_error_userdata_passwordconfirm', 'false', $config_showtranslationcode);
    $msg_done_forgottenpwd2 = give_translation('messages.msg_done_forgottenpwd2', 'false', $config_showtranslationcode);
    #special
    $forgottenpwd2_bok_gotodb = true;
    #callinfo
    $forgottenpwd2_password = trim(htmlspecialchars($_POST['txtNewPwdForgottenpwd2'], ENT_QUOTES));
    $forgottenpwd2_confirmpassword = trim(htmlspecialchars($_POST['txtNewPwdConfirmForgottenpwd2'], ENT_QUOTES));
    
    #condition    
    if(empty($forgottenpwd2_password) 
            || strlen($forgottenpwd2_password) < 6  
            || strlen($forgottenpwd2_password) > 26 
            || !preg_match('#[0-9a-zA-Z]#', $forgottenpwd2_password))
    {
        $forgottenpwd2_bok_gotodb = false;
        $_SESSION['msg_forgottenpwd2_txtNewPwdForgottenpwd2'] = $msg_error_forgottenpwd2_password;
    }
    
    if($forgottenpwd2_confirmpassword != $forgottenpwd2_password)
    {
        $forgottenpwd2_bok_gotodb = false;
        $_SESSION['msg_forgottenpwd2_txtNewPwdConfirmForgottenpwd2'] = $msg_error_forgottenpwd2_passwordconfirm;
    }
    
    #operation
    if($forgottenpwd2_bok_gotodb === true)
    {
        $forgottenpwd2_confirmpassword = crypt_pwd($forgottenpwd2_confirmpassword);
        
        try
        {    
            $prepared_query = 'UPDATE user
                               SET password_user = :pwd
                               WHERE email_user = :email';
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'pwd' => $forgottenpwd2_confirmpassword,
                                  'email' => $_SESSION['forgottenpwd2_email']
                                  ));
            $query->closeCursor();
            
            unset($_SESSION['forgottenpwd2_email']);
            $_SESSION['msg_done_forgottenpwd2'] = $msg_done_forgottenpwd2;
            
            $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                               INNER JOIN page_translation
                               ON page_translation.id_page = page.id_page
                               WHERE url_page = "login_subscribe"
                               AND family_page_translation = "rewritingF"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $forgottenpwd2_rewritingF_dispatcher = $data[0];
            }
            $query->closeCursor();

            header('Location: '.$config_customheader.$forgottenpwd2_rewritingF_dispatcher);

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
        $_SESSION['forgottenpwd2_txtNewPwdForgottenpwd2'] = $forgottenpwd2_password;
        header('Location: '.$config_customheader.$rewritingF_page);
    }

}
?>
