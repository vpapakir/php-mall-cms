<?php
if(isset($_POST['bt_cboLanguage']))
{
    unset($_SESSION['msg_language_edit_done'],
            $_SESSION['msg_language_upload_edit_disabled_language'],
            $_SESSION['msg_language_upload_edit_activated_language']);
    
    unset($_SESSION['language_add_chkpriority'],
            $_SESSION['language_add_txtPositionAddLanguage'],
            $_SESSION['language_add_cboStatusAddLanguage'],
            $_SESSION['language_add_cboCodeAddLanguage'],
            $_SESSION['language_add_txtNameImageAddLanguage'],
            $_SESSION['msg_language_upload_add_activated_language'],
            $_SESSION['msg_language_upload_add_disabled_language'],
            $_SESSION['msg_language_add_txtAddNameL1'],
            $_SESSION['msg_language_add_cboCodeAddLanguage']);
    
    $selected_language = trim(htmlspecialchars($_POST['cboLanguage'], ENT_QUOTES));
    
    if($selected_language == 'new')
    {
        $_SESSION['language_create_new'] = true;
        $_SESSION['language_select_cboLanguage'] = $selected_language;
    }
    else
    {
        $_SESSION['language_create_new'] = false;
        
        try
        {
            $prepared_query = 'SELECT COUNT(id_language) FROM language
                               WHERE status_language = 1';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $count_language = $data[0];
            }
            $query->closeCursor();

            $prepared_query = 'SELECT * FROM language
                               INNER JOIN translation
                               ON language.code_language = translation.code_translation
                               WHERE id_language = :id_language';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id_language', $selected_language);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['language_select_cboLanguage'] = $data[0];
                $_SESSION['language_edit_cboCodeEditLanguage'] = $data['code_language'];
                $_SESSION['language_edit_txtNameImageEditLanguage'] = strtolower($data['code_language']);
                for($i = 1; $i <= $count_language; $i++)
                {
                    $_SESSION['language_edit_txtEditNameL'.$i] = $data['L'.$i];
                }
                $_SESSION['language_edit_chkpriority'] = $data['priority_language'];
                $_SESSION['language_edit_txtPositionEditLanguage'] = $data['position_language'];
                $_SESSION['language_edit_cboStatusEditLanguage'] = $data['status_language'];
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
    }
}
?>
