<?php
if(isset($_POST['bt_save_memo']) || isset($_POST['bt_savenquit_memo']))
{
    unset($_SESSION['memo_txtTitleMemo'],
            $_SESSION['memo_areaMemo'],
            $_SESSION['memo_cboStatusMemo'],
            $_SESSION['memo_view']);
    
    $title_memo = trim($_POST['txtTitleMemo']);
    $areaMemo = trim($_POST['areaMemo']);
    $status_memo = trim(htmlspecialchars($_POST['cboStatusMemo'], ENT_QUOTES));
    $selected_memo = htmlspecialchars($_POST['cboMemo'], ENT_QUOTES);
    
    if(isset($_POST['bt_savenquit_memo']))
    {
        $_SESSION['memo_view'] = true;
    }
    
    try
    {
        if($selected_memo == 'new')
        {
            $prepared_query = 'INSERT INTO memo
                               (title_memo, content_memo, status_memo, datecreate_memo, dateupdate_memo)
                               VALUES
                               (:title, :content, :status, NOW(), NOW())';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'title' => $title_memo,
                                  'content' => $areaMemo,
                                  'status' => $status_memo
                                  ));
            $query->closeCursor();
            
            $prepared_query = 'SELECT MAX(id_memo) FROM memo';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $selected_memo = $data[0];
            }
            $query->closeCursor();
        }
        else
        {
            $prepared_query = 'UPDATE memo
                               SET title_memo = :title,
                                   content_memo = :content,
                                   status_memo = :status,
                                   dateupdate_memo = NOW()
                               WHERE id_memo = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'title' => $title_memo,
                                  'content' => $areaMemo,
                                  'status' => $status_memo,
                                  'id' => $selected_memo
                                  ));
            $query->closeCursor();
        }
        
        $_SESSION['memo_txtTitleMemo'] = $title_memo;
        $_SESSION['memo_areaMemo'] = $areaMemo;
        $_SESSION['memo_cboStatusMemo'] = $status_memo;
        $_SESSION['memo_cboMemo'] = $selected_memo;
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
