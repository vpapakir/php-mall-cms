<?php
if(isset($_POST['bt_cboSelectLangDirtyword']) 
        || isset($_POST['bt_cboOrderTypeDirtyword']) 
        || isset($_POST['bt_cboOrderModeDirtyword'])
        || isset($_POST['bt_cboSelectTypeDirtyword']))
{
    unset($_SESSION['dirtyword_cboSelectTypeDirtyword'],
            $_SESSION['dirtyword_cboSelectLangDirtyword'],
            $_SESSION['dirtyword_cboSelectLangDirtyword'],
            $_SESSION['dirtyword_idreplace'],
            $_SESSION['dirtyword_txtSourceDirtyword'],
            $_SESSION['dirtyword_txtReplaceDirtyword'],
            $_SESSION['dirtyword_chkStatusDirtyword'],
            $_SESSION['dirtyword_chkCommentDirtyword'],
            $_SESSION['dirtyword_chkSearchDirtyword'],
            $_SESSION['dirtyword_chkKeywordDirtyword']);
    
    if(isset($_POST['bt_cboSelectTypeDirtyword']))
    {
        $dirtyword_selected_type = htmlspecialchars($_POST['cboSelectTypeDirtyword'], ENT_QUOTES);
        $dirtyword_selected_lang = 'select';
        
        if($dirtyword_selected_type != 'select')
        {
            $_SESSION['dirtyword_cboSelectTypeDirtyword'] = $dirtyword_selected_type;
        }
    }
    else
    {
        $dirtyword_selected_type = htmlspecialchars($_POST['cboSelectTypeDirtyword'], ENT_QUOTES);
        $dirtyword_selected_lang = htmlspecialchars($_POST['cboSelectLangDirtyword'], ENT_QUOTES);
        $dirtyword_selected_ordertype = htmlspecialchars($_POST['cboOrderTypeDirtyword'], ENT_QUOTES);
        $dirtyword_selected_ordermode = htmlspecialchars($_POST['cboOrderModeDirtyword'], ENT_QUOTES);
    }
    
    if($dirtyword_selected_lang != 'select' && $dirtyword_selected_type != 'select')
    {
        $_SESSION['dirtyword_cboSelectTypeDirtyword'] = $dirtyword_selected_type;
        $_SESSION['dirtyword_cboSelectLangDirtyword'] = $dirtyword_selected_lang;
        if(empty($dirtyword_selected_ordertype))
        {
            $dirtyword_selected_ordertype = 'dateadd_replace';
        }
        if(empty($dirtyword_selected_ordermode))
        {
            $dirtyword_selected_ordermode = 'ASC';
        }
        $_SESSION['dirtyword_cboOrderTypeDirtyword'] = $dirtyword_selected_ordertype;
        $_SESSION['dirtyword_cboOrderModeDirtyword'] = $dirtyword_selected_ordermode;

        try
        {
            $prepared_query = 'SELECT * FROM '.$dirtyword_selected_type;       
            $prepared_query .= ' ORDER BY COALESCE('.$dirtyword_selected_ordertype.', "z")';           
            $prepared_query .= ' '.$dirtyword_selected_ordermode;

            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $i = 0;
            while($data = $query->fetch())
            {
                $dirtyword_id[$i] = $data['id_replace'];
                $dirtyword_source[$i] = $data['sourceL'.$dirtyword_selected_lang];
                $dirtyword_replace[$i] = $data['replaceL'.$dirtyword_selected_lang];
                $dirtyword_status[$i] = $data['statusL'.$dirtyword_selected_lang];
                $dirtyword_comment[$i] = $data['commentL'.$dirtyword_selected_lang];
                $dirtyword_search[$i] = $data['searchL'.$dirtyword_selected_lang];
                $dirtyword_keyword[$i] = $data['keywordL'.$dirtyword_selected_lang];
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
