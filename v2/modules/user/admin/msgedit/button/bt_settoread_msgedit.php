<?php
for($i = 1; $i <= $msgedit_last_idmsg; $i++)
{    
    try
    {      
        if(isset($_POST['bt_settoread_msgedit'.$i]))
        {  
            $prepared_query = 'SELECT * FROM email_messages
                               WHERE id_messages = :idmsg';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idmsg', $i);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $msgedit_backtolist_idmsg = $data['status_messages'];
            }
            $query->closeCursor();
            
            if($msgedit_backtolist_idmsg == 1)
            {
                $prepared_query = 'UPDATE email_messages
                                   SET status_messages = 2,
                                   lastdate_messages = NOW()
                                   WHERE id_messages = :idmsg';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'idmsg' => $i               
                                    ));
                $query->closeCursor();
            }

            $i = $msgedit_last_idmsg + 1;

            if($_SESSION['index'] == 'index.php')
            {
                header('Location: '.$config_customheader.$rewritingF_page);
            }
            else
            {
                header('Location: '.$config_customheader.$rewritingB_page);
            }
        }       
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

if(isset($_POST['bt_settoread_msgedit']))
{
    unset($msgedit_settoread_unread_chk, $msgedit_settoread_deleted_chk);
    for($i = 1; $i <= $msgedit_last_idmsg; $i++)
    {
        $msgedit_settoread_unread_chk = trim(htmlspecialchars($_POST['chk_msgedit_unread'.$i], ENT_QUOTES));
        $msgedit_settoread_deleted_chk = trim(htmlspecialchars($_POST['chk_msgedit_deleted'.$i], ENT_QUOTES));
        if($msgedit_settoread_unread_chk == 1 || $msgedit_settoread_deleted_chk == 1)
        {
            try
            {
                $prepared_query = 'SELECT laststatus_messages FROM email_messages
                                   WHERE id_messages = :idmsg';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idmsg', $i);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $msgedit_settoread_laststatus = $data[0];
                }
                $query->closeCursor();
                
                if($msgedit_settoread_laststatus == 3)
                {
                    $prepared_query = 'UPDATE email_messages
                                       SET status_messages = 3,
                                       lastdate_messages = NOW()
                                       WHERE id_messages = :idmsg';
                }
                else
                {
                    $prepared_query = 'UPDATE email_messages
                                       SET status_messages = 2,
                                       lastdate_messages = NOW()
                                       WHERE id_messages = :idmsg';
                }
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idmsg', $i);
                $query->execute();
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
        unset($msgedit_settoread_unread_chk,$msgedit_settoread_deleted_chk);
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
