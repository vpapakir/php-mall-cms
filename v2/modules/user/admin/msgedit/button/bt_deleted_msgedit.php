<?php
if(isset($_POST['bt_deleted_msgedit']))
{
    unset($msgedit_deleted_sent_chk);
    for($i = 1; $i <= $msgedit_last_idmsg; $i++)
    {
        $msgedit_deleted_sent_chk = trim(htmlspecialchars($_POST['chk_msgedit_deleted'.$i], ENT_QUOTES));
        if($msgedit_deleted_sent_chk == 1)
        {
            try
            {
                $prepared_query = 'DELETE FROM email_messages
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
        unset($msgedit_deleted_sent_chk);
    }
    
    reallocate_table_id('id_messages', 'email_messages');
    
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
