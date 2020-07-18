<?php
if(isset($_POST['bt_backto_home2']))
{
    unset($_SESSION['msg_forgottenpwd2_txtNewPwdConfirmForgottenpwd2'],
            $_SESSION['msg_forgottenpwd2_txtNewPwdForgottenpwd2'],
            $_SESSION['msg_done_forgottenpwd2']);
    unset($_SESSION['forgottenpwd2_email'],
            $_SESSION['forgottenpwd2_txtNewPwdForgottenpwd2']);
    try
    {
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "home_frontend"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $forgottenpwd2_rewritingF_page = $data[0];
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
    
    header('Location: '.$config_customheader.$forgottenpwd2_rewritingF_page);
    unset($forgottenpwd2_rewritingF_page);
}
?>
