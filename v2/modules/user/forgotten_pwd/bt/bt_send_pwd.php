<?php
if(isset($_POST['bt_send_pwd']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['msg_forgottenpwd_txtEmailForgottenpwd'],
            $_SESSION['msg_done_forgottenpwd']);
    unset($_SESSION['forgottenpwd_txtEmailForgottenpwd']);
    
    #msg
    $msg_error_forgottenpwd_email = give_translation('messages.msg_error_userdata_email', 'false', $config_showtranslationcode);
    $msg_done_forgottenpwd = give_translation('messages.msg_done_forgottenpwd', 'false', $config_showtranslationcode);
    #special
    $forgottendpwd_bok_gotodb = true;
    #callinfo
    $forgottenpwd_email = trim(htmlspecialchars($_POST['txtEmailForgottenpwd'], ENT_QUOTES));
    
    #condition
    if(empty($forgottenpwd_email))
    {
        $forgottendpwd_bok_gotodb = false;
        $_SESSION['msg_forgottenpwd_txtEmailForgottenpwd'] = $msg_error_forgottenpwd_email;
    }
    else 
    {
        if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $forgottenpwd_email))
        {
            $forgottendpwd_bok_gotodb = false;
            $_SESSION['msg_forgottenpwd_txtEmailForgottenpwd'] = $msg_error_forgottenpwd_email;
        }
        else
        {
            try
            {
                $prepared_query = 'SELECT email_user FROM user
                                   WHERE email_user = :email';
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('email', $forgottenpwd_email);
                $query->execute();

                if(($data = $query->fetch()) == false)
                {
                    $forgottendpwd_bok_gotodb = false;
                    $_SESSION['msg_forgottenpwd_txtEmailForgottenpwd'] = $msg_error_forgottenpwd_email;
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
    
    if($forgottendpwd_bok_gotodb === true)
    {
        $forgottenpwd_code = give_randomstr($strsearch, 0, 12, $onlynumber);
        try
        {
            $prepared_query = 'INSERT INTO forgottenpwd_codeconfirm
                               (email_forgottenpwd, code_forgottenpwd, date_forgottenpwd)
                               VALUES
                               (:email, :code, NOW())';
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('email', $forgottenpwd_email);
            $query->execute(array(
                                  'email' => $forgottenpwd_email,
                                  'code' => $forgottenpwd_code
                                  ));
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
        include('modules/email/send/user/forgottenpwd/email_main.php');
        $_SESSION['msg_done_forgottenpwd'] = $msg_done_forgottenpwd;
    }
    else
    {
        $_SESSION['forgottenpwd_txtEmailForgottenpwd'] = $forgottenpwd_email;
    }
}
?>
