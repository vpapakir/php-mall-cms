<?php
if(isset($_POST['bt_save_exist_language']))
{   
    unset($_SESSION['language_add_chkpriority'],
            $_SESSION['language_add_txtPositionAddLanguage'],
            $_SESSION['language_add_cboStatusAddLanguage'],
            $_SESSION['language_add_cboCodeAddLanguage'],
            $_SESSION['language_add_txtNameImageAddLanguage'],
            $_SESSION['msg_language_upload_add_activated_language'],
            $_SESSION['msg_language_upload_add_disabled_language'],
            $_SESSION['msg_language_add_txtAddNameL1'],
            $_SESSION['msg_language_add_cboCodeAddLanguage'],
            $_SESSION['msg_language_done']);
    
    #msg
    $msg_done_language_edit = give_translation('messages.msg_done_language_edit', 'false', $config_showtranslationcode);
    
    $code_edit_language = trim(htmlspecialchars($_POST['cboCodeEditLanguage'], ENT_QUOTES));
    $id_edit_language = htmlspecialchars($_POST['cboLanguage'], ENT_QUOTES);
    
    $Bok_name_edit_language = true;
    $Bok_keep_session = false;
    $Bok_insert_activatedimage_language = true;
    $Bok_insert_disabledimage_language = true;
    
    $id_activatedimage_language = null;
    $id_disabledimage_language = null;
    
    try
    {
        $prepared_query = 'SELECT COUNT(id_language) FROM language
                           WHERE status_language = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()))
        {
            $count_lang = $data[0];
        } 
        $query->closeCursor();
        
        $prepared_query = 'SELECT id_image FROM language_image
                           WHERE id_language = :id
                           AND status_image = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_edit_language);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $Bok_insert_activatedimage_language = false;
            $id_activatedimage_language = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT id_image FROM language_image
                           WHERE id_language = :id
                           AND status_image = 9';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_edit_language);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $Bok_insert_disabledimage_language = false;
            $id_disabledimage_language = $data[0];
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
    
    
    
    if($count_lang == 0)
    {
        unset($_SESSION['language_edit_txtEditNameL1']);
        $name_edit_language = trim(htmlspecialchars($_POST['txtEditNameL1'], ENT_QUOTES));
        $count_lang_insert = 1;
        
        if(empty($name_edit_language))
        {
            $Bok_name_edit_language = false;
            $_SESSION['msg_language_edit_txtEditNameL1'] = 'Veuillez indiquer un nom pour la langue L1'; 
        }
    }
    else
    {
        $count_lang_insert = $count_lang;
        
        for($i = 1, $y = 0; $i <= $count_lang_insert; $i++, $y++)
        {
            unset($_SESSION['language_edit_txtEditNameL'.$i]);
            $array_name_edit_language[$y] = trim(htmlspecialchars($_POST['txtEditNameL'.$i], ENT_QUOTES));
        }
        
        if(empty($array_name_edit_language[0]))
        {
            $Bok_name_edit_language = false;
            $_SESSION['msg_language_edit_txtEditNameL1'] = 'Veuillez indiquer un nom pour la langue L1'; 
        }
    }

    $upload_edit_activated_language = $_FILES['upload_edit_language']['name'][0];
    $upload_edit_disabled_language = $_FILES['upload_edit_language']['name'][1];
    $name_image_edit_language = trim(htmlspecialchars($_POST['txtNameImageEditLanguage'], ENT_QUOTES));
    
    if(empty($upload_edit_disabled_language))
    {
        $upload_edit_disabled_language = $upload_edit_activated_language;
        $upload_index = 0;
    }
    else
    {
        $upload_index = 1;
    }
    
    $code_edit_language = trim(htmlspecialchars($_POST['cboCodeEditLanguage'], ENT_QUOTES));
    $name_image_edit_language = trim(htmlspecialchars($_POST['txtNameImageEditLanguage'], ENT_QUOTES));
    
    $default_edit_language = trim(htmlspecialchars($_POST['chk_priority_edit_language'], ENT_QUOTES));
    $position_edit_language = trim(htmlspecialchars($_POST['txtPositionEditLanguage'], ENT_QUOTES));
    $status_edit_language = trim(htmlspecialchars($_POST['cboStatusEditLanguage'], ENT_QUOTES));
    
    $name_activated_image_language = trim(htmlspecialchars($_POST['txtActNameImageEditLanguage'], ENT_QUOTES));
    $alt_activated_image_language = trim(htmlspecialchars($_POST['txtActAltImageEditLanguage'], ENT_QUOTES));
    $title_activated_image_language = trim(htmlspecialchars($_POST['txtActTitleImageEditLanguage'], ENT_QUOTES));
    $repeat_activated_image_language = trim(htmlspecialchars($_POST['cboActRepeatImageEditLanguage'], ENT_QUOTES));
    
    $name_disabled_image_language = trim(htmlspecialchars($_POST['txtDisNameImageEditLanguage'], ENT_QUOTES));
    $alt_disabled_image_language = trim(htmlspecialchars($_POST['txtDisAltImageEditLanguage'], ENT_QUOTES));
    $title_disabled_image_language = trim(htmlspecialchars($_POST['txtDisTitleImageEditLanguage'], ENT_QUOTES));
    $repeat_disabled_image_language = trim(htmlspecialchars($_POST['cboDisRepeatImageEditLanguage'], ENT_QUOTES));
    
    if($default_edit_language == 'on' ? $defaultnb_edit_language = 1 : $defaultnb_edit_language = 0);
    
    if(!empty($code_edit_language) && $code_edit_language == 'select')
    {
        $Bok_name_edit_language = false;
        $_SESSION['msg_language_add_cboCodeAddLanguage'] = 'Veuillez sélectionner un code pour la langue'; 
    }
    
    if($Bok_name_edit_language === true)
    {
        
        try
        {
            if($_SESSION['language_edit_cboCodeEditLanguage'] != $code_edit_language)
            {
                $prepared_query = 'UPDATE country 
                                   SET used_code_country = 0
                                   WHERE code_country = :code';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('code', $_SESSION['language_edit_cboCodeEditLanguage']);
                $query->execute();

                $prepared_query = 'UPDATE country 
                                   SET used_code_country = 1
                                   WHERE code_country = :code';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('code', $code_edit_language);
                $query->execute();
            }

            if(empty($position_edit_language))
            {
                $prepared_query = 'SELECT position_language FROM language
                                   ORDER BY position_language';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
                    $position_edit_language = $data[0];
                }
                $query->closeCursor();

                $position_edit_language = $position_edit_language + 100;
            }
            
            $prepared_query = 'UPDATE language_image
                               SET name_image = :name,
                                   alt_image = :alt,
                                   title_image = :title,
                                   repeat_image = :repeat
                               WHERE id_language = :id_language
                               AND status_image = 1';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_activated_image_language,
                                  'alt' => $alt_activated_image_language,
                                  'title' => $title_activated_image_language,
                                  'repeat' => $repeat_activated_image_language,
                                  'id_language' => $id_edit_language
                                  ));
            $query->closeCursor();
            
            $prepared_query = 'UPDATE language_image
                               SET name_image = :name,
                                   alt_image = :alt,
                                   title_image = :title,
                                   repeat_image = :repeat
                               WHERE id_language = :id_language
                               AND status_image = 0';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_disabled_image_language,
                                  'alt' => $alt_disabled_image_language,
                                  'title' => $title_disabled_image_language,
                                  'repeat' => $repeat_disabled_image_language,
                                  'id_language' => $id_edit_language
                                  ));
            $query->closeCursor();

            $prepared_query = 'UPDATE language
                               SET code_language = :code,
                                   priority_language = :priority,
                                   position_language = :position,
                                   status_language = :status
                               WHERE id_language = :id_language';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'code' => $code_edit_language,
                                  'priority' => $defaultnb_edit_language,
                                  'position' => $position_edit_language,
                                  'status' => $status_edit_language,
                                  'id_language' => $id_edit_language
                                  ));
            $query->closeCursor();

            if($count_lang == 0)
            {
                $prepared_query = 'UPDATE translation
                                   SET code_translation = :code,
                                       L'.$count_lang_insert.' = :L'.$count_lang_insert.'
                                   WHERE id_language = :id_language';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'code' => $code_edit_language,
                                      'L'.$count_lang_insert => $name_edit_language,
                                      'id_language' => $id_edit_language
                                      ));
                $query->closeCursor();
            }
            else
            {
                $prepared_query = 'UPDATE translation
                                   SET code_translation = :code, ';
                for($i = 1, $y = 0; $i <= $count_lang_insert; $i++, $y++)
                {
                    if($i < $count_lang_insert)
                    {
                        $prepared_query .= 'L'.$i.' = \''.$array_name_edit_language[$y].'\', ';
                    }
                    else
                    {
                        $prepared_query .= 'L'.$i.' = \''.$array_name_edit_language[$y].'\'';
                    }
                    
                    if($i == $main_id_language)
                    {
                        $language_selected_lang = $y;
                    }
                }

                $prepared_query .= ' WHERE code_translation = :code_translation';

                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'code' => $code_edit_language,
                                      'code_translation' => $_SESSION['language_edit_cboCodeEditLanguage']
                                      ));
                $query->closeCursor();
            }

            if($default_edit_language == 'on')
            {
                $prepared_query = 'UPDATE language
                                   SET priority_language = 0
                                   WHERE id_language <> :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $id_edit_language);
                $query->execute();
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
        
       $Bok_upload_activatedimage_language = false;
       $Bok_upload_disabledimage_language = false;
       $Bok_upload_bothimage_language = false;

       if(!empty($upload_edit_activated_language) || !empty($upload_edit_disabled_language))
       { 
            if(empty($id_activatedimage_language))
            {
                $id_activatedimage_language = $id_edit_language;
            }

            if(empty($id_disabledimage_language))
            {
                $id_disabledimage_language = $id_edit_language;
            }
            
            if($Bok_insert_activatedimage_language === true)
            {
                $language_activatedimage_column = 'id_language';
            }
            else
            {
                $language_activatedimage_column = 'id_image';
            }
            
            if($Bok_insert_disabledimage_language === true)
            {
                $language_disabledimage_column = 'id_language';
            }
            else
            {
                $language_disabledimage_column = 'id_image';
            }
            
            if(!empty($upload_edit_activated_language))
            {   
                $_SESSION['msg_language_upload_edit_activated_language'] = 
                upload_file_language
                           ('upload_edit_language',
                            0,
                            $name_image_edit_language, 
                            5242880, 
                            600, 
                            1200, 
                            30, 
                            30,
                            'modules/language/language/icons/original_activated/',
                            'modules/language/language/icons/icon_activated/', 
                            $id_activatedimage_language,
                            1,
                            $Bok_insert_activatedimage_language,
                            'language_image',
                            $language_activatedimage_column);
            }

            if(!empty($upload_edit_disabled_language))
            {

                $_SESSION['msg_language_upload_edit_disabled_language'] = 
                upload_file_language
                           ('upload_edit_language',
                            $upload_index,
                            $name_image_edit_language,
                            5242880, 
                            600, 
                            1200, 
                            30, 
                            30,
                            'modules/language/language/icons/original_disabled/',
                            'modules/language/language/icons/icon_disabled/', 
                            $id_disabledimage_language,
                            9,
                            $Bok_insert_disabledimage_language,
                            'language_image',
                            $language_disabledimage_column);
            }
        }
        
        $msg_done_language_edit = str_replace('[#name_language]', $array_name_edit_language[$language_selected_lang], $msg_done_language_edit);
        $_SESSION['msg_language_done'] = $msg_done_language_edit;
    }
    
    if($count_lang == 0)
    {
        $_SESSION['language_edit_txtEditNameL1'] = $name_edit_language;
    }
    else
    {
        for($i = 1, $y = 0; $i <= $count_lang; $i++, $y++)
        {
            $_SESSION['language_edit_txtEditNameL'.$i] = $array_name_edit_language[$y];
        }
    }

    $_SESSION['language_edit_cboCodeEditLanguage'] = $code_edit_language;
    $_SESSION['language_edit_txtNameImageEditLanguage'] = $name_image_edit_language;
    $_SESSION['language_edit_chkpriority'] = $defaultnb_edit_language;
    $_SESSION['language_edit_txtPositionEditLanguage'] = $position_edit_language;
    $_SESSION['language_edit_cboStatusEditLanguage'] = $status_edit_language; 
    
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
