<?php
if(isset($_POST['bt_add_dirtyword']))
{
    #session
    unset($_SESSION['msg_dirtyword_txtSourceDirtyword'],
            $_SESSION['msg_dirtyword_done']);
    #msg
    $msg_error_dirtyword_emptysource = give_translation('messages.msg_error_main_emptyinput', 'false', $config_showtranslationcode);
    $msg_error_dirtyword_existingsource = give_translation('messages.msg_error_dirtyword_existingsource', 'false', $config_showtranslationcode);
    $msg_done_dirtyword_add = give_translation('messages.msg_done_dirtyword_add', 'false', $config_showtranslationcode);
    #special
    $dirtyword_insert_bok = true;
    
    #callinfo
    $dirtyword_typedata = htmlspecialchars($_POST['cboSelectTypeDirtyword'], ENT_QUOTES);
    $dirtyword_lang = htmlspecialchars($_POST['cboSelectLangDirtyword'], ENT_QUOTES);
    $dirtyword_ordertype = htmlspecialchars($_POST['cboOrderTypeDirtyword'], ENT_QUOTES);
    $dirtyword_ordermode = htmlspecialchars($_POST['cboOrderModeDirtyword'], ENT_QUOTES);
    $dirtyword_add_source = $_POST['txtSourceDirtyword'];
    $dirtyword_add_replace = $_POST['txtReplaceDirtyword'];
    $dirtyword_add_chkstatus = $_POST['chkStatusDirtyword'];
    $dirtyword_add_chkcomment = $_POST['chkCommentDirtyword'];
    $dirtyword_add_chksearch = $_POST['chkSearchDirtyword'];
    $dirtyword_add_chkkeyword = $_POST['chkKeywordDirtyword'];
    
    #condition
    if($dirtyword_add_chkstatus != 1 ? $dirtyword_add_chkstatus = 9 : $dirtyword_add_chkstatus = 1);
    if($dirtyword_add_chkcomment != 1 ? $dirtyword_add_chkcomment = 9 : $dirtyword_add_chkcomment = 1);
    if($dirtyword_add_chksearch != 1 ? $dirtyword_add_chksearch = 9 : $dirtyword_add_chksearch = 1);
    if($dirtyword_add_chkkeyword != 1 ? $dirtyword_add_chkkeyword = 9 : $dirtyword_add_chkkeyword = 1);
    
    if(empty($dirtyword_add_source))
    {
        $dirtyword_insert_bok = false;
        $_SESSION['msg_dirtyword_txtSourceDirtyword'] = $msg_error_dirtyword_emptysource;
    } 
    
    try
    {
        if($dirtyword_typedata == 'replace_char')
        {
            $prepared_query = 'SELECT id_replace FROM replace_value
                               WHERE BINARY sourceL'.$dirtyword_lang.' LIKE "'.$dirtyword_add_source.'%"';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $dirtyword_insert_bok = false;
                $_SESSION['msg_dirtyword_txtSourceDirtyword'] = $msg_error_dirtyword_existingsource;
            }
            $query->closeCursor();
        }
        
        if($dirtyword_insert_bok === true)
        {
            $prepared_query = 'INSERT INTO '.$dirtyword_typedata.'
                               (dateadd_replace, sourceL'.$dirtyword_lang.', 
                                replaceL'.$dirtyword_lang.', statusL'.$dirtyword_lang.', 
                                commentL'.$dirtyword_lang.', searchL'.$dirtyword_lang.', 
                                keywordL'.$dirtyword_lang.')
                               VALUES
                               (NOW(), :source, :replace, :status, :comment, :search, :keyword)';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'source' => $dirtyword_add_source,
                                  'replace' => $dirtyword_add_replace,
                                  'status' => $dirtyword_add_chkstatus,
                                  'comment' => $dirtyword_add_chkcomment,
                                  'search' => $dirtyword_add_chksearch,
                                  'keyword' => $dirtyword_add_chkkeyword
                                ));
            $query->closeCursor();

            $msg_done_dirtyword_add = str_replace('[#source_dirtyword]', $dirtyword_add_source, $msg_done_dirtyword_add);
            $_SESSION['msg_dirtyword_done'] = $msg_done_dirtyword_add;
        
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
