<?php
if(isset($_POST['bt_delete_memo']))
{
    unset($_SESSION['memo_txtTitleMemo'],
            $_SESSION['memo_areaMemo'],
            $_SESSION['memo_cboStatusMemo'],
            $_SESSION['memo_cboMemo'],
            $_SESSION['memo_view']);
    
    $selected_memo = htmlspecialchars($_POST['cboMemo'], ENT_QUOTES);
    
    try
    {
        $prepared_query = 'DELETE FROM memo
                           WHERE id_memo = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_memo);
        $query->execute();

        reallocate_table_id('id_memo', 'memo');
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
