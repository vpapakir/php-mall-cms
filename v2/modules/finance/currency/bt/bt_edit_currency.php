<?php
if(isset($_POST['bt_edit_currency']))
{    
    unset($_SESSION['currency_txtTransCodeCurrency'],
            $_SESSION['currency_txtCodeCurrency'],
            $_SESSION['currency_txtSymbolCurrency'],
            $_SESSION['currency_chkPriorityCurrency'],
            $_SESSION['currency_txtPositionCurrency'],
            $_SESSION['currency_cboStatusCurrency'],
            $_SESSION['currency_txtDefaultvalueCurrency']);
    
    unset($_SESSION['msg_currency_transcode'],
            $_SESSION['msg_currency_code'],
            $_SESSION['msg_currency_position'],
            $_SESSION['msg_currency_upload_activated'],
            $_SESSION['msg_currency_upload_disabled'],
            $_SESSION['msg_currency_done']);
    
    for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
    {
        unset($_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]]);
    }
    
    #msg
    $msg_done_currency_edit = give_translation('messages.msg_done_currency_edit', 'false', $config_showtranslationcode);
    $msg_currency_transcode = 'Cette devise existe déjà ou possède le même code';
    $msg_currency_code = 'Veuillez renseigner un code (ex: EUR, GBP, USD, ...)';
    $msg_currency_position_length = 'La position doit être composée de 4 chiffres';
    $msg_currency_position_numeric = 'La position doit être composée uniquement de chiffres (ex: 1010, 2320, ...)';
    
    $selected_currency_edit = htmlspecialchars($_POST['cboSelectCurrency'], ENT_QUOTES);
    
    $currency_translationcode_edit = trim(htmlspecialchars($_POST['txtTransCodeCurrency'], ENT_QUOTES));
    $currency_code_edit = trim(htmlspecialchars($_POST['txtCodeCurrency'], ENT_QUOTES));
    $currency_oldcode_edit = trim(htmlspecialchars($_POST['hiddenOldCodeCurrency'], ENT_QUOTES));
    $currency_symbol_edit = trim(htmlspecialchars($_POST['txtSymbolCurrency'], ENT_QUOTES));
    
    $currency_default_edit = htmlspecialchars($_POST['chkPriorityCurrency'], ENT_QUOTES);
    $currency_position_edit = trim(htmlspecialchars($_POST['txtPositionCurrency'], ENT_QUOTES));
    $currency_status_edit = htmlspecialchars($_POST['cboStatusCurrency'], ENT_QUOTES);

    $currency_defaultvalue_edit = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtDefaultvalueCurrency']), ENT_QUOTES));
    for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
    {
        $currency_value_edit[$i] = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtValueCurrency'.$main_activatedidcurrency[$i]]), ENT_QUOTES));
    }
    
    $currency_activated_image_name = trim(htmlspecialchars($_POST['txtActNameImageCurrency'], ENT_QUOTES));
    $currency_activated_image_alt = trim(htmlspecialchars($_POST['txtActAltImageCurrency'], ENT_QUOTES));
    $currency_activated_image_title = trim(htmlspecialchars($_POST['txtActTitleImageCurrency'], ENT_QUOTES));
    $currency_activated_image_repeat = htmlspecialchars($_POST['cboActRepeatImageCurrency'], ENT_QUOTES);
    
    $currency_disabled_image_name = trim(htmlspecialchars($_POST['txtDisNameImageCurrency'], ENT_QUOTES));
    $currency_disabled_image_alt = trim(htmlspecialchars($_POST['txtDisAltImageCurrency'], ENT_QUOTES));
    $currency_disabled_image_title = trim(htmlspecialchars($_POST['txtDisTitleImageCurrency'], ENT_QUOTES));
    $currency_disabled_image_repeat = htmlspecialchars($_POST['cboDisRepeatImageCurrency'], ENT_QUOTES);
    
    $currency_upload_activated = $_FILES['upload_currency']['name'][0];
    $currency_upload_disabled = $_FILES['upload_currency']['name'][1];
    $currency_name_image = strtolower($currency_code_edit);
    
    if(empty($currency_upload_disabled))
    {
        $currency_upload_disabled = $currency_upload_activated;
        $upload_index = 0;
    }
    else
    {
        $upload_index = 1;
    }
    
    if(empty($currency_defaultvalue_edit) ? $currency_defaultvalue_edit = 1 : $currency_defaultvalue_edit= $currency_defaultvalue_edit);
    
    $Bok_currency_insert = true;
    
    if(empty($currency_code_edit))
    {
        $Bok_currency_insert = false;
        $_SESSION['msg_currency_code'] = $msg_currency_code;
    }
    
    if(empty($currency_symbol_edit) ? $currency_symbol_edit = $currency_code_edit : $currency_symbol_edit = $currency_symbol_edit);
    
    if(!empty($msg_currency_position) && !is_numeric($msg_currency_position))
    {
        $Bok_currency_insert = false;
        $_SESSION['msg_currency_position'] = $msg_currency_position_numeric;
    }
    else
    {
        if(!empty($msg_currency_position) && strlen($currency_position_edit) != 4)
        {
            $Bok_currency_insert = false;
            $_SESSION['msg_currency_position'] = $msg_currency_position_length;
        }
    }
    
    $Bok_insert_activatedimage_currency = true;
    $Bok_insert_disabledimage_currency = true;
    
    $id_activatedimage_currency = null;
    $id_disabledimage_currency = null;

    try
    {
        $prepared_query = 'SELECT longname_currency FROM currency
                           WHERE longname_currency = :longname
                           AND id_currency <> :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'longname' => $currency_translationcode_edit,
                              'id' => $selected_currency_edit
                              ));
        if(($data = $query->fetch()) != false)
        {
            $Bok_currency_insert = false;
            $_SESSION['msg_currency_transcode'] = $msg_currency_transcode;
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT id_image FROM currency_image
                           WHERE id_currency = :id
                           AND status_image = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_currency_edit);
        $query->execute();
        $i = 0;
        if(($data = $query->fetch()) != false)
        {
            $Bok_insert_activatedimage_currency = false;
            $id_activatedimage_currency = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT id_image FROM currency_image
                           WHERE id_currency = :id
                           AND status_image = 9';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_currency_edit);
        $query->execute();
        $i = 0;
        if(($data = $query->fetch()) != false)
        {
            $Bok_insert_disabledimage_currency = false;
            $id_disabledimage_currency = $data[0];
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
    
    
    
    if($Bok_currency_insert === true)
    {
        try
        {
            if(empty($currency_position_edit))
            {
                $prepared_query = 'SELECT MAX(position_currency)
                                   FROM currency
                                   WHERE status_currency <> 9';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $currency_position_edit = $data[0] + 10;
                }
                $query->closeCursor();
            }
            
            if($currency_default_edit == 1)
            {
                $prepared_query = 'UPDATE currency
                                   SET priority_currency = 9
                                   WHERE id_currency <> :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $selected_currency_edit);
                $query->execute();
                $query->closeCursor();
            }
            else
            {
                $currency_default_edit = 9;
            }
            
            if(!empty($currency_upload_activated) || !empty($currency_upload_disabled))
            { 
                
                if(empty($id_activatedimage_currency))
                {
                    $id_activatedimage_currency = $selected_currency_edit;
                }

                if(empty($id_disabledimage_currency))
                {
                    $id_disabledimage_currency = $selected_currency_edit;
                }

                if(!empty($currency_upload_activated))
                {
                    $_SESSION['msg_currency_upload_activated'] = 
                    upload_file_language
                               ('upload_currency',
                                0,
                                $currency_name_image, 
                                5242880, 
                                600, 
                                1200, 
                                30, 
                                30,
                                'modules/finance/currency/icons/original_activated/',
                                'modules/finance/currency/icons/icon_activated/', 
                                $id_activatedimage_currency,
                                1,
                                $Bok_insert_activatedimage_currency,
                                'currency_image',
                                'id_image');
                }

                if(!empty($currency_upload_disabled))
                {
                    $_SESSION['msg_currency_upload_disabled'] = 
                    upload_file_language
                               ('upload_currency',
                                $upload_index,
                                $currency_name_image, 
                                5242880, 
                                600, 
                                1200, 
                                30, 
                                30,
                                'modules/finance/currency/icons/original_disabled/',
                                'modules/finance/currency/icons/icon_disabled/', 
                                $id_disabledimage_currency,
                                9,
                                $Bok_insert_disabledimage_currency,
                                'currency_image',
                                'id_image');
                }
            }
            
            $prepared_query = 'UPDATE currency_image
                               SET name_image = :name,
                                   alt_image = :alt,
                                   title_image = :title,
                                   repeat_image = :repeat
                               WHERE id_currency = :id
                               AND status_image = 1';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $currency_activated_image_name,
                                  'alt' => $currency_activated_image_alt,
                                  'title' => $currency_activated_image_title,
                                  'repeat' => $currency_activated_image_repeat,
                                  'id' => $selected_currency_edit 
                                  ));
            $query->closeCursor();
            
            $prepared_query = 'UPDATE currency_image
                               SET name_image = :name,
                                   alt_image = :alt,
                                   title_image = :title,
                                   repeat_image = :repeat
                               WHERE id_currency = :id
                               AND status_image = 9';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $currency_disabled_image_name,
                                  'alt' => $currency_disabled_image_alt,
                                  'title' => $currency_disabled_image_title,
                                  'repeat' => $currency_disabled_image_repeat,
                                  'id' => $selected_currency_edit 
                                  ));
            $query->closeCursor();
            
            if($currency_oldcode_edit != $currency_code_edit)
            {
                $prepared_query = 'ALTER TABLE `currency` `'.$currency_oldcode_edit.'` RENAME `'.$currency_code_add.'`';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                $query->closeCursor();
            }
            
            $prepared_query = 'UPDATE currency
                               SET longname_currency = :longname,
                                   shortname_currency = :shortname,
                                   symbol_currency = :symbol,
                                   priority_currency = :priority, 
                                   position_currency = :position,
                                   status_currency = :status,
                                   defaultvalue_currency = :defaultvalue, ';
            
            for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
            {
                if($i == 0)
                {
                    $currency_value_edit[$i] = $currency_defaultvalue_edit;
                }
                
                if($i > 0 && empty($currency_value_edit[$i]))
                {
                    $currency_value_edit[$i] = 'NULL';
                }
                
                if($i == ($count - 1))
                {
                    $prepared_query .= $main_activatedcodecurrency[$i].' = '.$currency_value_edit[$i].' ';
                }
                else
                {
                    $prepared_query .= $main_activatedcodecurrency[$i].' = '.$currency_value_edit[$i].', ';
                }
            }
            $prepared_query .= 'WHERE id_currency = :id';

            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'longname' => $currency_translationcode_edit,
                                  'shortname' => $currency_code_edit,
                                  'symbol' => $currency_symbol_edit,
                                  'priority' => $currency_default_edit,
                                  'position' => $currency_position_edit,
                                  'status' => $currency_status_edit,
                                  'defaultvalue' => $currency_defaultvalue_edit,
                                  'id' => $selected_currency_edit
                                  ));
            $query->closeCursor();
            
            $_SESSION['currency_txtTransCodeCurrency'] = $currency_translationcode_edit;
            $_SESSION['currency_txtCodeCurrency'] = $currency_code_edit;
            $_SESSION['currency_txtSymbolCurrency'] = $currency_symbol_edit;
            $_SESSION['currency_chkPriorityCurrency'] = $currency_default_edit;
            $_SESSION['currency_txtPositionCurrency'] = $currency_position_edit;
            $_SESSION['currency_cboStatusCurrency'] = $currency_status_edit;

            $_SESSION['currency_txtDefaultvalueCurrency'] = $currency_defaultvalue_edit;
            for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
            {
                $_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]] = $currency_value_edit[$i];
            }
            
            $msg_done_currency_edit = str_replace('[#name_currency]', give_translation('main.currency_'.strtolower($currency_code_edit), 'false', $config_showtranslationcode), $msg_done_currency_edit);
            $_SESSION['msg_currency_done'] = $msg_done_currency_edit;
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
    else
    {
        $_SESSION['currency_txtTransCodeCurrency'] = $currency_translationcode_edit;
        $_SESSION['currency_txtCodeCurrency'] = $currency_code_edit;
        $_SESSION['currency_txtSymbolCurrency'] = $currency_symbol_edit;
        $_SESSION['currency_chkPriorityCurrency'] = $currency_default_edit;
        $_SESSION['currency_txtPositionCurrency'] = $currency_position_edit;
        $_SESSION['currency_cboStatusCurrency'] = $currency_status_edit;
        
        $_SESSION['currency_txtDefaultvalueCurrency'] = $currency_defaultvalue_edit;
        for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
        {
            $_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]] = $currency_value_edit[$i];
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
