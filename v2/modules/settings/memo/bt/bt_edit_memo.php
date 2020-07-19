<?php
if(isset($_POST['bt_edit_memo']))
{
    unset($_SESSION['memo_view']);
    
    $selected_memo = htmlspecialchars($_POST['cboMemo'], ENT_QUOTES);
    
    try
    {
        $prepared_query = 'SELECT * FROM memo
                           WHERE id_memo = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_memo);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $title_memo = $data['title_memo'];
            $content_memo = $data['content_memo'];
            $status_memo = $data['status_memo'];
        }
        $query->closeCursor();

        $_SESSION['memo_txtTitleMemo'] = $title_memo;
        $_SESSION['memo_areaMemo'] = $content_memo;
        $_SESSION['memo_cboStatusMemo'] = $status_memo;
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
