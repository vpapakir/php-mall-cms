<?php
if(isset($_POST['bt_settounread_myaccountmsg']))
{
    unset($myaccount_msg_settounread_chk);
    for($i = 1; $i <= $myaccount_msg_last_idmsg; $i++)
    {
        $myaccount_msg_settounread_chk = trim(htmlspecialchars($_POST['chk_myaccountmsg'.$i], ENT_QUOTES));
        if($myaccount_msg_settounread_chk == 1)
        {
            try
            {
                $prepared_query = 'UPDATE email_messages
                                   SET status_messages = 1,
                                   lastdate_messages = NOW()
                                   WHERE id_messages = :idmsg';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idmsg', $i);
                $query->execute();
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
        unset($myaccount_msg_settounread_chk);
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
