<?php
if(isset($_POST['bt_settodeleted_msgedit']))
{
    unset($msgedit_settodeleted_unread_chk, $msgedit_settodeleted_read_chk,$msgedit_settodeleted_sent_chk);
    for($i = 1; $i <= $msgedit_last_idmsg; $i++)
    {
        $msgedit_settodeleted_unread_chk = trim(htmlspecialchars($_POST['chk_msgedit_unread'.$i], ENT_QUOTES));
        $msgedit_settodeleted_read_chk = trim(htmlspecialchars($_POST['chk_msgedit_read'.$i], ENT_QUOTES));
        $msgedit_settodeleted_sent_chk = trim(htmlspecialchars($_POST['chk_msgedit_sent'.$i], ENT_QUOTES));
        if($msgedit_settodeleted_unread_chk == 1 
                || $msgedit_settodeleted_read_chk == 1 
                || $msgedit_settodeleted_sent_chk == 1)
        {
            if($msgedit_settodeleted_unread_chk == 1)
            {
                $msgedit_laststatus = 1;
            }
            else
            {
                if($msgedit_settodeleted_read_chk == 1)
                {
                    $msgedit_laststatus = 2; 
                }
                else
                {
                    $msgedit_laststatus = 3;
                }
            }                
            
            try
            {
                $prepared_query = 'UPDATE email_messages
                                   SET laststatus_messages = :laststatus,
                                   status_messages = 9,
                                   lastdate_messages = NOW()
                                   WHERE id_messages = :idmsg';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'laststatus' => $msgedit_laststatus,
                                      'idmsg' => $i,
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
        unset($msgedit_settodeleted_unread_chk, $msgedit_settodeleted_read_chk,$msgedit_settodeleted_sent_chk);
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
