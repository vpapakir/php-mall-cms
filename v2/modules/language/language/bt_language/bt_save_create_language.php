<?php
if(isset($_POST['bt_save_create_language']))
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

    $Bok_name_add_language = true;
    $Bok_code_add_language = true;
    $Bok_image_add_language = true;
    $Bok_keep_session = false;
    
    #msg
    $msg_done_language_add = give_translation('messages.msg_done_language_add', 'false', $config_showtranslationcode);
    
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
        
        $prepared_query = 'SELECT code_language FROM language';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        $i = 0;
        
        while($data = $query->fetch())
        {
            $code_exist_lang[$i] = $data[0];
            $i++;
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
            die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
        }
    }
    
    if($count_lang == 0)
    {
        unset($_SESSION['language_add_txtAddNameL1']);
        $name_add_language = trim(htmlspecialchars($_POST['txtAddNameL1'], ENT_QUOTES));
        $count_lang_insert = 1;
        
        if(empty($name_add_language))
        {
            $Bok_name_add_language = false;
            $_SESSION['msg_language_add_txtAddNameL1'] = 'Veuillez indiquer un nom pour la langue L1'; 
        }
    }
    else
    {
        $count_lang_insert = $count_lang;
        $count_lang_insert++;
        
        for($i = 1, $y = 0; $i <= $count_lang_insert; $i++, $y++)
        {
            unset($_SESSION['language_add_txtAddNameL'.$i]);
            $array_name_add_language[$y] = trim(htmlspecialchars($_POST['txtAddNameL'.$i], ENT_QUOTES));
        }
        
        if(empty($array_name_add_language[0]))
        {
            $Bok_name_add_language = false;
            $_SESSION['msg_language_add_txtAddNameL1'] = 'Veuillez indiquer un nom pour la langue L1'; 
        }
    }

    $upload_add_activated_language = $_FILES['upload_add_language']['name'][0];
    $upload_add_disabled_language = $_FILES['upload_add_language']['name'][1];
    $name_image_add_language = trim(htmlspecialchars($_POST['txtNameImageAddLanguage'], ENT_QUOTES));
    
    if(empty($upload_add_disabled_language))
    {
        $upload_add_disabled_language = $upload_add_activated_language;
        $upload_index = 0;
    }
    else
    {
        $upload_index = 1;
    }
    
    $code_add_language = trim(htmlspecialchars($_POST['cboCodeAddLanguage'], ENT_QUOTES));
    $name_image_add_language = trim(htmlspecialchars($_POST['txtNameImageAddLanguage'], ENT_QUOTES));
    
    $default_add_language = trim(htmlspecialchars($_POST['chk_priority_add_language'], ENT_QUOTES));
    $position_add_language = trim(htmlspecialchars($_POST['txtPositionAddLanguage'], ENT_QUOTES));
    $status_add_language = trim(htmlspecialchars($_POST['cboStatusAddLanguage'], ENT_QUOTES));
    
    if($default_add_language == 'on' ? $defaultnb_add_language = 1 : $defaultnb_add_language = 0);
    
    if(!empty($code_add_language) && $code_add_language == 'select')
    {
        $Bok_code_add_language = false;
        $_SESSION['msg_language_add_cboCodeAddLanguage'] = 'Veuillez sélectionner un code pour la langue'; 
    }
    
    for($i = 0, $count = count($code_exist_lang); $i < $count; $i++)
    {
        if($code_add_language == $code_exist_lang[$i])
        {
            $Bok_code_add_language = false;
            $_SESSION['msg_language_add_cboCodeAddLanguage'] = 'Le code "'.$code_add_language.'" est déjà utilisé'; 
            $i = $count;
        }
    }
    
    if(empty($upload_add_activated_language) && empty($upload_add_disabled_language))
    {
        $Bok_image_add_language = false;
        $_SESSION['msg_language_upload_add_activated_language'] = 'Veuillez sélectionner une image pour la langue utilisée';
    }
    
    if($Bok_name_add_language === true && $Bok_code_add_language === true && $Bok_image_add_language === true)
    {
        try
        {
            if(empty($position_add_language))
            {
                $prepared_query = 'SELECT position_language FROM language
                                   ORDER BY position_language';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
                    $position_add_language = $data[0];
                }
                $query->closeCursor();

                $position_add_language = $position_add_language + 100;
            }


            $prepared_query = 'INSERT INTO language
                               (code_language, priority_language, position_language, status_language)
                               VALUES
                               (:code, :priority, :position, :status)';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'code' => $code_add_language,
                                  'priority' => $defaultnb_add_language,
                                  'position' => $position_add_language,
                                  'status' => $status_add_language
                                  ));
            $query->closeCursor();

            $prepared_query = 'ALTER TABLE `translation` ADD `L'.$count_lang_insert.'` MEDIUMTEXT NOT NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `page_translation` ADD `L'.$count_lang_insert.'` MEDIUMTEXT NOT NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `page_image` ADD `L'.$count_lang_insert.'` MEDIUMTEXT NOT NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `cdreditor` ADD `L'.$count_lang_insert.'S` MEDIUMTEXT NOT NULL,
                                                       ADD `L'.$count_lang_insert.'P` MEDIUMTEXT NOT NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `cdrgeo` ADD `L'.$count_lang_insert.'` MEDIUMTEXT NOT NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `email_signature` ADD `L'.$count_lang_insert.'T` MEDIUMTEXT NULL,
                                                             ADD `L'.$count_lang_insert.'S` MEDIUMTEXT NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `email_mailtext` ADD `L'.$count_lang_insert.'S` MEDIUMTEXT NULL,
                                                            ADD `L'.$count_lang_insert.'T` MEDIUMTEXT NULL,
                                                            ADD `L'.$count_lang_insert.'P1` LONGTEXT NULL,
                                                            ADD `L'.$count_lang_insert.'P2` LONGTEXT NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `hierarchy_box` ADD `L'.$count_lang_insert.'` TEXT NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `hierarchy_box_content` ADD `L'.$count_lang_insert.'` TEXT NULL, 
                                                                   ADD `L'.$count_lang_insert.'I` MEDIUMTEXT NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `advertising` ADD `path_advertising_L'.$count_lang_insert.'` TEXT NULL,
                                                         ADD `name_advertising_L'.$count_lang_insert.'` VARCHAR(256) NOT NULL,
                                                         ADD `relatedpage_advertising_L'.$count_lang_insert.'` MEDIUMTEXT NULL,
                                                         ADD `keyword_advertising_L'.$count_lang_insert.'` VARCHAR(512) NULL,
                                                         ADD `frame_advertising_L'.$count_lang_insert.'` INT(11) NULL,
                                                         ADD `alt_advertising_L'.$count_lang_insert.'` VARCHAR(256) NULL,
                                                         ADD `legend_advertising_L'.$count_lang_insert.'` TEXT NULL,
                                                         ADD `link_advertising_L'.$count_lang_insert.'` VARCHAR(512) NULL,
                                                         ADD `target_advertising_L'.$count_lang_insert.'` VARCHAR(32) NOT NULL,
                                                         ADD `widthlimit_advertising_L'.$count_lang_insert.'` INT(11) NULL,
                                                         ADD `heightlimit_advertising_L'.$count_lang_insert.'` INT(11) NULL,
                                                         ADD `scriptpath_advertising_L'.$count_lang_insert.'` TEXT NULL,
                                                         ADD `scriptcode_advertising_L'.$count_lang_insert.'` MEDIUMTEXT NULL,
                                                         ADD `position_advertising_L'.$count_lang_insert.'` INT(4) NOT NULL,
                                                         ADD `status_advertising_L'.$count_lang_insert.'` INT(1) NOT NULL,
                                                         ADD `comment_advertising_L'.$count_lang_insert.'` MEDIUMTEXT NULL,
                                                         ADD `userrights_advertising_L'.$count_lang_insert.'` TEXT NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `style_color` ADD `L'.$count_lang_insert.'` VARCHAR(126) NULL ';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `replace_value` ADD `sourceL'.$count_lang_insert.'` TINYTEXT NULL,
                                                           ADD `replaceL'.$count_lang_insert.'` TINYTEXT NULL,
                                                           ADD `statusL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `commentL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `searchL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `keywordL'.$count_lang_insert.'` INT(1) NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'ALTER TABLE `replace_char` ADD `sourceL'.$count_lang_insert.'` TINYTEXT NULL,
                                                           ADD `replaceL'.$count_lang_insert.'` TINYTEXT NULL,
                                                           ADD `statusL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `commentL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `searchL'.$count_lang_insert.'` INT(1) NULL,
                                                           ADD `keywordL'.$count_lang_insert.'` INT(1) NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();

            if($count_lang == 0)
            {
                $prepared_query = 'INSERT INTO translation
                                   (code_translation, id_page, L'.$count_lang_insert.')
                                   VALUES
                                   (:code, :page, :L'.$count_lang_insert.')';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'code' => $code_add_language,
                                      'page' => 0,
                                      'L'.$count_lang_insert => $name_add_language
                                      ));
                $query->closeCursor();
            }
            else
            {
                $prepared_query = 'INSERT INTO translation
                                   (code_translation, id_page, ';
                for($i = 1; $i <= $count_lang_insert; $i++)
                {
                    if($i < $count_lang_insert)
                    {
                        $prepared_query .= 'L'.$i.', ';
                    }
                    else
                    {
                        $prepared_query .= 'L'.$i.')';
                    }
                    
                    if($i == $main_id_language)
                    {
                        $language_selected_lang = $y;
                    }
                }

                $prepared_query .= 'VALUES(:code, :page, ';

                for($i = 0, $count = count($array_name_add_language); $i < $count; $i++)
                {
                    if($i < ($count - 1))
                    {
                        $prepared_query .= '\''.$array_name_add_language[$i].'\', ';
                    }
                    else
                    {
                        $prepared_query .= '\''.$array_name_add_language[$i].'\')';
                    }
                }

                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'code' => $code_add_language,
                                      'page' => 0
                                      ));
                $query->closeCursor();
            }

            $prepared_query = 'SELECT id_language FROM language';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            while($data = $query->fetch())
            {
                $id_language = $data[0];
            }

            if($default_add_language == 'on')
            {
                $prepared_query = 'UPDATE language
                                   SET priority_language = 0
                                   WHERE id_language <> :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $id_language);
                $query->execute();
            }

            $prepared_query = 'UPDATE country
                               SET used_code_country = 1
                               WHERE code_country = :code';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('code', $code_add_language);
            $query->execute();

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




        $_SESSION['msg_language_upload_add_activated_language'] = 
        upload_file_language
                   ('upload_add_language',
                    0,
                    $name_image_add_language, 
                    5242880, 
                    600, 
                    1200, 
                    30, 
                    30,
                    'modules/language/language/icons/original_activated/',
                    'modules/language/language/icons/icon_activated/', 
                    $id_language,
                    1,
                    true,
                    'language_image',
                    'id_language');
        
        $_SESSION['msg_language_upload_add_disabled_language'] = 
        upload_file_language
                   ('upload_add_language',
                    $upload_index,
                    $name_image_add_language,
                    5242880, 
                    600, 
                    1200, 
                    30, 
                    30,
                    'modules/language/language/icons/original_disabled/',
                    'modules/language/language/icons/icon_disabled/', 
                    $id_language,
                    9,
                    true,
                    'language_image',
                    'id_language');

        unset($_SESSION['language_create_new']);
        
        $msg_done_language_add = str_replace('[#name_language]', $array_name_add_language[$language_selected_lang], $msg_done_language_add);
        $_SESSION['msg_language_done'] = $msg_done_language_add;
    }
    else
    {
        $Bok_keep_session = true;
    }
    
    if($Bok_keep_session === true)
    {
        if($count_lang == 0)
        {
            $_SESSION['language_add_txtAddNameL1'] = $name_add_language;
        }
        else
        {
            for($i = 1, $y = 0; $i <= $count_lang; $i++, $y++)
            {
                $_SESSION['language_add_txtAddNameL'.$i] = $array_name_add_language[$y];
            }
        }

        $_SESSION['language_add_cboCodeAddLanguage'] = $code_add_language;
        $_SESSION['language_add_txtNameImageAddLanguage'] = $name_image_add_language;
        $_SESSION['language_add_chkpriority'] = $defaultnb_add_language;
        $_SESSION['language_add_txtPositionAddLanguage'] = $position_add_language;
        $_SESSION['language_add_cboStatusAddLanguage'] = $status_add_language; 
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
