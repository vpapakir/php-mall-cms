<?php
if(isset($_POST['bt_save_newpwd']))
{
    #session
    unset($_SESSION['myaccount_editpwd_txtOldpwdUserdataEditPwd'],
            $_SESSION['myaccount_editpwd_txtNewpwdUserdataEditPwd']);
    unset($_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd'],
            $_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd'],
            $_SESSION['msg_error_editpwd_txtConfirmnewpwdUserdataEditPwd'],
            $_SESSION['msg_done_editpwd']);
    
    #msg
    $msg_error_editpwd_emptyfield = give_translation('messages.msg_error_editpwd_emptyfield', 'false', $config_showtranslationcode);
    $msg_error_editpwd_wrongoldpwd = give_translation('messages.msg_error_editpwd_wrongoldpwd', 'false', $config_showtranslationcode);
    $msg_error_editpwd_wrongpwd = give_translation('messages.msg_error_editpwd_wrongpwd', 'false', $config_showtranslationcode);
    $msg_error_editpwd_sameasoldpwd = give_translation('messages.msg_error_editpwd_sameasoldpwd', 'false', $config_showtranslationcode);
    $msg_error_editpwd_confirmpwd = give_translation('messages.msg_error_editpwd_confirmpwd', 'false', $config_showtranslationcode);
    $msg_done_editpwd = give_translation('messages.msg_done_editpwd', 'false', $config_showtranslationcode);
    
    #special
    $myaccount_editpwd_bok_update = true;
    
    #callinfo
    $myaccount_editpwd_oldpwd = trim(htmlspecialchars($_POST['txtOldpwdUserdataEditPwd'], ENT_QUOTES));
    $myaccount_editpwd_newpwd = trim(htmlspecialchars($_POST['txtNewpwdUserdataEditPwd'], ENT_QUOTES));
    $myaccount_editpwd_confirmnewpwd = trim(htmlspecialchars($_POST['txtConfirmnewpwdUserdataEditPwd'], ENT_QUOTES));
    
    #condition
    if(empty($myaccount_editpwd_oldpwd))
    {
        $myaccount_editpwd_bok_update = false;
        $_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd'] = $msg_error_editpwd_emptyfield;
    }
    else
    {
        if(strlen($myaccount_editpwd_oldpwd) < 6  
            || strlen($myaccount_editpwd_oldpwd) > 26 
            || !preg_match('#[0-9a-zA-Z]#', $myaccount_editpwd_oldpwd))
        {
            $myaccount_editpwd_bok_update = false;
            $_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd'] = $msg_error_editpwd_wrongpwd;
        }
        else
        {
            $prepared_query = 'SELECT password_user FROM user
                               WHERE password_user = :pwd
                               AND id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'pwd' => crypt_pwd($myaccount_editpwd_oldpwd),
                                  'iduser' => $main_iduser_log
                                  ));
            if(($data = $query->fetch()) == false)
            {
                $myaccount_editpwd_bok_update = false;
                $_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd'] = $msg_error_editpwd_wrongoldpwd;
            }
            $query->closeCursor();
        }
    }
    
    if(empty($myaccount_editpwd_newpwd))
    {
        $myaccount_editpwd_bok_update = false;
        $_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd'] = $msg_error_editpwd_emptyfield;
    }
    else
    {
        if(strlen($myaccount_editpwd_newpwd) < 6  
            || strlen($myaccount_editpwd_newpwd) > 26 
            || !preg_match('#[0-9a-zA-Z]#', $myaccount_editpwd_newpwd))
        {
            $myaccount_editpwd_bok_update = false;
            $_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd'] = $msg_error_editpwd_wrongpwd;
        }
        else
        {
            if($myaccount_editpwd_newpwd == $myaccount_editpwd_oldpwd)
            {
                $myaccount_editpwd_bok_update = false;
                $_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd'] = $msg_error_editpwd_sameasoldpwd;
            }
            else
            {
                if(!empty($myaccount_editpwd_newpwd) && $myaccount_editpwd_confirmnewpwd != $myaccount_editpwd_newpwd)
                {
                    $myaccount_editpwd_bok_update = false;
                    $_SESSION['msg_error_editpwd_txtConfirmnewpwdUserdataEditPwd'] = $msg_error_editpwd_confirmpwd;
                }
            }
        }
    }
    
    
    
    if($myaccount_editpwd_bok_update === true)
    {
        $myaccount_editpwd_confirmnewpwd = crypt_pwd($myaccount_editpwd_confirmnewpwd);
        $myaccount_editpwd_oldpwd = crypt_pwd($myaccount_editpwd_oldpwd);
        try
        {
            $prepared_query = 'UPDATE user
                               SET password_user = :pwd
                               WHERE password_user = :oldpwd
                               AND id_user = :iduser';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'pwd' => $myaccount_editpwd_confirmnewpwd,
                                  'oldpwd' => $myaccount_editpwd_oldpwd,
                                  'iduser' => $main_iduser_log
                                  ));
            $query->closeCursor();
            
            $_SESSION['msg_done_editpwd'] = $msg_done_editpwd;
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
        $_SESSION['myaccount_editpwd_txtOldpwdUserdataEditPwd'] = $myaccount_editpwd_oldpwd;
        $_SESSION['myaccount_editpwd_txtNewpwdUserdataEditPwd'] = $myaccount_editpwd_newpwd; 
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
