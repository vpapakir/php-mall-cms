<?php
if(isset($_POST['bt_save_dirtyword']))
{
    #session
    unset($_SESSION['msg_dirtyword_done']);
    #msg
    $msg_error_dirtyword_emptysource = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_dirtyword_existingsource = give_translation('messages.msg_error_dirtyword_existingsource', 'false', $config_showtranslationcode);
    $msg_done_dirtyword_edit = give_translation('messages.msg_done_dirtyword_edit', 'false', $config_showtranslationcode);
    $msg_done_dirtyword_edit_partially = give_translation('messages.msg_done_dirtyword_edit_partially', 'false', $config_showtranslationcode);
    
    $dirtyword_total_idreplace = $_SESSION['dirtyword_idreplace'];
    $dirtyword_update_partially_bok = false;
    
    $dirtyword_typedata = htmlspecialchars($_POST['cboSelectTypeDirtyword'], ENT_QUOTES);
    $dirtyword_lang = htmlspecialchars($_POST['cboSelectLangDirtyword'], ENT_QUOTES);
    $dirtyword_ordertype = htmlspecialchars($_POST['cboOrderTypeDirtyword'], ENT_QUOTES);
    $dirtyword_ordermode = htmlspecialchars($_POST['cboOrderModeDirtyword'], ENT_QUOTES);

    for($i = 0, $count = count($dirtyword_total_idreplace); $i < $count; $i++)
    {
        unset($_SESSION['msg_dirtyword_txtSourceDirtyword'.$dirtyword_total_idreplace[$i]]);
            
        #special
        $dirtyword_update_bok = true;

        #callinfo
        $dirtyword_edit_source = $_POST['txtSourceDirtyword'.$dirtyword_total_idreplace[$i]];
        $dirtyword_edit_replace = $_POST['txtReplaceDirtyword'.$dirtyword_total_idreplace[$i]];
        $dirtyword_edit_chkstatus = $_POST['chkStatusDirtyword'.$dirtyword_total_idreplace[$i]];
        $dirtyword_edit_chkcomment = $_POST['chkCommentDirtyword'.$dirtyword_total_idreplace[$i]];
        $dirtyword_edit_chksearch = $_POST['chkSearchDirtyword'.$dirtyword_total_idreplace[$i]];
        $dirtyword_edit_chkkeyword = $_POST['chkKeywordDirtyword'.$dirtyword_total_idreplace[$i]];

        #condition
        if($dirtyword_edit_chkstatus != 1 ? $dirtyword_edit_chkstatus = 9 : $dirtyword_edit_chkstatus = 1);
        if($dirtyword_edit_chkcomment != 1 ? $dirtyword_edit_chkcomment = 9 : $dirtyword_edit_chkcomment = 1);
        if($dirtyword_edit_chksearch != 1 ? $dirtyword_edit_chksearch = 9 : $dirtyword_edit_chksearch = 1);
        if($dirtyword_edit_chkkeyword != 1 ? $dirtyword_edit_chkkeyword = 9 : $dirtyword_edit_chkkeyword = 1);

        if(empty($dirtyword_edit_source))
        {
            $dirtyword_update_bok = false;
            $_SESSION['msg_dirtyword_txtSourceDirtyword'.$dirtyword_total_idreplace[$i]] = $msg_error_dirtyword_emptysource;
        } 

        try
        {
            $prepared_query = 'SELECT sourceL'.$dirtyword_lang.', replaceL'.$dirtyword_lang.' 
                               FROM '.$dirtyword_typedata.'
                               WHERE id_replace = :idreplace';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('idreplace', $dirtyword_total_idreplace[$i]);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $dirtyword_old_source = $data[0];
                $dirtyword_old_replace = $data[1];
            }
            $query->closeCursor();
            
            if($dirtyword_old_source != $dirtyword_edit_source || $dirtyword_old_replace != $dirtyword_edit_replace)
            {
                $dirtyword_edit_date = 'NOW()';
            }
            
            if($dirtyword_typedata == 'replace_char')
            {
                $prepared_query = 'SELECT id_replace FROM replace_value
                                   WHERE BINARY sourceL'.$dirtyword_lang.' LIKE "'.$dirtyword_edit_source.'%"';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $dirtyword_update_bok = false;
                    $_SESSION['msg_dirtyword_txtSourceDirtyword'.$dirtyword_total_idreplace[$i]] = $msg_error_dirtyword_existingsource;
                }
                $query->closeCursor();
            }

            if($dirtyword_update_bok === true)
            {
                $prepared_query = 'UPDATE '.$dirtyword_typedata.'
                                   SET ';
                if(!empty($dirtyword_edit_date))
                {
                    $prepared_query .= 'dateedit_replace = NOW(), ';
                }
                $prepared_query .= '   sourceL'.$dirtyword_lang.' = :source,
                                       replaceL'.$dirtyword_lang.' = :replace,
                                       statusL'.$dirtyword_lang.' = :status,
                                       commentL'.$dirtyword_lang.' = :comment,
                                       searchL'.$dirtyword_lang.' = :search,
                                       keywordL'.$dirtyword_lang.' = :keyword
                                   WHERE id_replace = :idreplace';
                
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'source' => $dirtyword_edit_source,
                                      'replace' => $dirtyword_edit_replace,
                                      'status' => $dirtyword_edit_chkstatus,
                                      'comment' => $dirtyword_edit_chkcomment,
                                      'search' => $dirtyword_edit_chksearch,
                                      'keyword' => $dirtyword_edit_chkkeyword,
                                      'idreplace' => $dirtyword_total_idreplace[$i]
                                    ));
                $query->closeCursor();
            }
            else
            {
                $i = $count;
                $dirtyword_update_partially_bok = true;
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
        
        unset($dirtyword_edit_source,$dirtyword_edit_replace,$dirtyword_edit_chkstatus,
                $dirtyword_edit_chkcomment,$dirtyword_edit_chksearch,$dirtyword_edit_chkkeyword,
                $dirtyword_old_source,$dirtyword_old_replace,$dirtyword_edit_date);
    }
    
    if($dirtyword_update_bok === true)
    {
        $_SESSION['msg_dirtyword_done'] = $msg_done_dirtyword_edit;
    }

    if($dirtyword_update_partially_bok === true)
    {
        $_SESSION['msg_dirtyword_done'] = $msg_done_dirtyword_edit_partially;
    }
    
    $prepared_query = 'SELECT * FROM '.$dirtyword_typedata;       
    $prepared_query .= ' ORDER BY COALESCE('.$dirtyword_ordertype.', "z")';           
    $prepared_query .= ' '.$dirtyword_ordermode;

    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $dirtyword_id[$i] = $data['id_replace'];
        $dirtyword_source[$i] = $data['sourceL'.$dirtyword_lang];
        $dirtyword_replace[$i] = $data['replaceL'.$dirtyword_lang];
        $dirtyword_status[$i] = $data['statusL'.$dirtyword_lang];
        $dirtyword_comment[$i] = $data['commentL'.$dirtyword_lang];
        $dirtyword_search[$i] = $data['searchL'.$dirtyword_lang];
        $dirtyword_keyword[$i] = $data['keywordL'.$dirtyword_lang];
        $i++;
    }
    $query->closeCursor();

    $_SESSION['dirtyword_idreplace'] = $dirtyword_id;
    $_SESSION['dirtyword_txtSourceDirtyword'] = $dirtyword_source;
    $_SESSION['dirtyword_txtReplaceDirtyword'] = $dirtyword_replace;
    $_SESSION['dirtyword_chkStatusDirtyword'] = $dirtyword_status;
    $_SESSION['dirtyword_chkCommentDirtyword'] = $dirtyword_comment;
    $_SESSION['dirtyword_chkSearchDirtyword'] = $dirtyword_search;
    $_SESSION['dirtyword_chkKeywordDirtyword'] = $dirtyword_keyword;
    
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
