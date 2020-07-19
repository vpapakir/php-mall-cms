<?php
if(isset($_POST['bt_gotomailing_useredit']) || isset($_POST['bt_checked_useredit']) || isset($_POST['bt_checkedall_useredit']))
{
    $useredit_gotomailing_preparedquery = $useredit_preparedquery;
    try
    {
        $prepared_query = $useredit_gotomailing_preparedquery;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;
        while($data = $query->fetch())
        {
            $useredit_mailing_iduser[$i] = $data[0];
            $i++;
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "user_mailing"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $useredit_mailing_rewritingF = $data[0];
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

    if(isset($_POST['bt_checkedall_useredit']))
    {
        $useredit_chk_all = htmlspecialchars($_POST['chk_useredit_all'], ENT_QUOTES);
        if($useredit_chk_all == 1)
        {
            $_SESSION['useredit_chkall'] = 1;
            for($i = 1, $count = $useredit_totalregistereduser; $i <= $count; $i++)
            {
                $_SESSION['useredit_chk'.$i] = 1;
                unset($_SESSION['usermailing_chk'.$i]);
            }
        }
        else
        {
            unset($_SESSION['useredit_chkall']);
            for($i = 1, $count = $useredit_totalregistereduser; $i <= $count; $i++)
            {
                unset($_SESSION['useredit_chk'.$i]);
                unset($_SESSION['usermailing_chk'.$i]);
            }
        }
    }
    
    if(isset($_POST['bt_checked_useredit']))
    {
        unset($_SESSION['useredit_chkall']);
        unset($useredit_chk);
        for($i = 0, $count = count($useredit_mailing_iduser); $i < $count; $i++)
        {
            $useredit_chk = htmlspecialchars($_POST['chk_useredit'.$useredit_mailing_iduser[$i]], ENT_QUOTES);

            if(!empty($useredit_chk) && $useredit_chk == 1)
            {
                $_SESSION['useredit_chk'.$useredit_mailing_iduser[$i]] = 1;
                unset($_SESSION['usermailing_chk'.$useredit_mailing_iduser[$i]]);
            }
            else
            {
                unset($_SESSION['useredit_chk'.$useredit_mailing_iduser[$i]]);
            }
            unset($useredit_chk);
        }       
    }
    
    if(!isset($_POST['bt_checked_useredit']) && !isset($_POST['bt_checkedall_useredit']) && !isset($_GET['paging']))
    {
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$useredit_mailing_rewritingF);
        }
        else
        {
            header('Location: '.$config_customheader.$useredit_mailing_rewritingF);
        }
    }
    
    unset($useredit_mailing_rewritingF);
}
?>
