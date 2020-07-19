<?php
if(isset($_POST['bt_logme_loginbox']))
{
    try
    {
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "myaccount"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $logbox_rewritingF_page = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "myaccount"
                           AND family_page_translation = "rewritingB"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $logbox_rewritingB_page = $data[0];
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
    
    #session
    unset($_SESSION['current_log_iduser'],
            $_SESSION['current_log_rightsuser']);
    unset($_SESSION['msg_logmebox_wronglogin']);
    
    $_SESSION['expand_box_login'] = 'true';
    
    #msg
    $msg_error_logmebox_wronglogin = give_translation('messages.msg_error_logmebox_wronglogin', 'false', $config_showtranslationcode);
    $msg_error_logmebox_onholdaccount = give_translation('messages.msg_error_logmebox_onholdaccount', 'false', $config_showtranslationcode);
    $msg_error_logmebox_blockedaccount = give_translation('messages.msg_error_logmebox_blockedaccount', 'false', $config_showtranslationcode);
    
    #special
    $logmebox_bok_emptyloginfo = false;
    $logmebox_bok_allowlogin = true;
    
    #callinfo
    $logmebox_nickemail = trim(htmlspecialchars($_POST['txtPseudoEmailLoginBox'], ENT_QUOTES));
    $logmebox_password = trim(htmlspecialchars($_POST['txtPasswordLoginBox'], ENT_QUOTES));

    #condition
    if(empty($logmebox_nickemail) || empty($logmebox_password))
    {
        $logmebox_bok_emptyloginfo = true;
        $_SESSION['msg_logmebox_wronglogin'] = $msg_error_logmebox_wronglogin;
    }
    else
    {
        $logmebox_password = crypt_pwd($logmebox_password);
    }
    
    $msg_error_logmebox_blockedaccount = str_replace('[#href]', '<a href="#" class="link_main" style="font-size: 9px;">', $msg_error_logmebox_blockedaccount);
    $msg_error_logmebox_blockedaccount = str_replace('[#/href]', '</a>', $msg_error_logmebox_blockedaccount);
    
    if($logmebox_bok_emptyloginfo === false)
    {    
        #check status and login info
        try
        {
            $prepared_query = 'SELECT id_user, rights_user, status_user, id_language,shop_id
                               FROM user
                               WHERE (nickname_user = :nickname 
                               OR email_user = :email)
                               AND password_user = :password';
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'nickname' => $logmebox_nickemail,
                                  'email' => $logmebox_nickemail,
                                  'password' => $logmebox_password
                                  ));
            if(($data = $query->fetch()) != false)
            {
				if($data['shop_id'] == $_SESSION['cooshopid']) {
					$logmebox_id_user = $data['id_user'];
					$logmebox_rights_user = $data['rights_user'];
					$logmebox_status_user = $data['status_user'];
					$logmebox_language_user = $data['id_language'];
					
					if(empty($logmebox_language_user))
					{
						$logmebox_language_user = $main_id_language;
					}
				} else {
					$logmebox_bok_allowlogin = false;
					$_SESSION['msg_logmebox_wronglogin'] = $msg_error_logmebox_wronglogin;
				}
            }
            else
            {
                $logmebox_bok_allowlogin = false;
                $_SESSION['msg_logmebox_wronglogin'] = $msg_error_logmebox_wronglogin;
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
        
        switch ($logmebox_status_user)
        {
            case 2:
                $logmebox_bok_allowlogin = false;
                $_SESSION['msg_logmebox_wronglogin'] = $msg_error_logmebox_onholdaccount;
                break;
            case 9:
                $logmebox_bok_allowlogin = false;
                $_SESSION['msg_logmebox_wronglogin'] = $msg_error_logmebox_blockedaccount;
                break;
        }
        
        if($logmebox_bok_allowlogin === true)
        {
            $_SESSION['current_log_iduser'] = $logmebox_id_user;
            $_SESSION['current_log_rightsuser'] = $logmebox_rights_user;
            $_SESSION['current_log_onlinestatususer'] = 1;
            $_SESSION['current_language'] = $logmebox_language_user;
            
            #change user status
            try
            {
                $prepared_query = 'UPDATE user
                                   SET online_user = 1,
                                   current_log_user = NOW(),
                                   current_timestamp_user = :timestamp,
                                   ip_user = :ip
                                   WHERE id_user = :iduser';
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'timestamp' => time(),
                                      'ip' => $_SERVER['REMOTE_ADDR'],
                                      'iduser' => $logmebox_id_user
                                      ));
                $query->closeCursor();
                
                $prepared_query = 'UPDATE stats_online
                                   SET status_statsonline = 1,
                                   id_user = :iduser,
                                   rights_statsonline = :rights
                                   WHERE sessionid_statsonline  = :sessionid';
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'iduser' => $logmebox_id_user,
                                      'rights' => $logmebox_rights_user,
                                      'sessionid' => session_id(),
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
        }
    }
    
//    if($url_page == 'login_subscribe' && $logmebox_bok_emptyloginfo === false && $logmebox_bok_allowlogin === true)
//    {
//        try
//        {
//            $prepared_query = 'SELECT L'.$main_id_language.' FROM page
//                               INNER JOIN page_translation
//                               ON page_translation.id_page = page.id_page
//                               WHERE url_page = "myaccount"
//                               AND family_page_translation = "rewritingF"';
//            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
//            $query = $connectData->prepare($prepared_query);
//            $query->execute();
//
//            if(($data = $query->fetch()) != false)
//            {
//                $rewritingF_page = $data[0];
//            }
//            $query->closeCursor();
//        }
//        catch(Exception $e)
//        {
//            $_SESSION['error400_message'] = $e->getMessage();
//            if($_SESSION['index'] == 'index.php')
//            {
//                die(header('Location: '.$config_customheader.'Error/400'));
//            }
//            else
//            {
//                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
//            }
//        }
//        
//        header('Location: '.$config_customheader.$rewritingF_page);
//    }
//    else
//    {
////        if($url_page == 'login_subscribe')
////        {
//            if($_SESSION['index'] == 'index.php')
//            {
//                header('Location: '.$config_customheader.$logbox_rewritingF_page);
//            }
//            else
//            {
//                header('Location: '.$config_customheader.$logbox_rewritingB_page);
//            }
////        }
//    }
    
    if($url_page != 'login_subscribe')
    {
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
    }
    else
    {
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$logbox_rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$logbox_rewritingB_page);
        }
    } 
}

?>
