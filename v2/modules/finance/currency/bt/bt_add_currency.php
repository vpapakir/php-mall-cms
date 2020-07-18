<?php
if(isset($_POST['bt_add_currency']))
{
    unset($_SESSION['currency_txtTransCodeCurrency'],
            $_SESSION['currency_txtCodeCurrency'],
            $_SESSION['currency_txtSymbolCurrency'],
            $_SESSION['currency_chkPriorityCurrency'],
            $_SESSION['currency_txtPositionCurrency'],
            $_SESSION['currency_cboStatusCurrency']);
    
    unset($_SESSION['msg_currency_transcode'],
            $_SESSION['msg_currency_code'],
            $_SESSION['msg_currency_position'],
            $_SESSION['msg_currency_upload_activated'],
            $_SESSION['msg_currency_upload_disabled'],
            $_SESSION['msg_currency_done']);
    
    #msg
    $msg_done_currency_add = give_translation('messages.msg_done_currency_add', 'false', $config_showtranslationcode);
    $msg_currency_transcode = 'Cette devise existe déjà ou possède le même code';
    $msg_currency_code = 'Veuillez renseigner un code (ex: EUR, GBP, USD, ...)';
    $msg_currency_position_length = 'La position doit être composée de 4 chiffres';
    $msg_currency_position_numeric = 'La position doit être composée uniquement de chiffres (ex: 1010, 2320, ...)';
    
    
    $currency_translationcode_add = trim(htmlspecialchars($_POST['txtTransCodeCurrency'], ENT_QUOTES));
    $currency_code_add = trim(htmlspecialchars($_POST['txtCodeCurrency'], ENT_QUOTES));
    $currency_symbol_add = trim(htmlspecialchars($_POST['txtSymbolCurrency'], ENT_QUOTES));
    
    $currency_default_add = htmlspecialchars($_POST['chkPriorityCurrency'], ENT_QUOTES);
    $currency_position_add = trim(htmlspecialchars($_POST['txtPositionCurrency'], ENT_QUOTES));
    $currency_status_add = htmlspecialchars($_POST['cboStatusCurrency'], ENT_QUOTES);
    
    $currency_upload_activated = $_FILES['upload_currency']['name'][0];
    $currency_upload_disabled = $_FILES['upload_currency']['name'][1];
    $currency_name_image = strtolower($currency_code_add);
    
    if(empty($currency_upload_disabled))
    {
        $currency_upload_disabled = $currency_upload_activated;
        $upload_index = 0;
    }
    else
    {
        $upload_index = 1;
    }
    
    $Bok_currency_insert = true;
    
    if(empty($currency_code_add))
    {
        $Bok_currency_insert = false;
        $_SESSION['msg_currency_code'] = $msg_currency_code;
    }
    
    if(empty($currency_symbol_add) ? $currency_symbol_add = $currency_code_add : $currency_symbol_add = $currency_symbol_add);
    
    if(!empty($msg_currency_position) && !is_numeric($msg_currency_position))
    {
        $Bok_currency_insert = false;
        $_SESSION['msg_currency_position'] = $msg_currency_position_numeric;
    }
    else
    {
        if(!empty($msg_currency_position) && strlen($currency_position_add) != 4)
        {
            $Bok_currency_insert = false;
            $_SESSION['msg_currency_position'] = $msg_currency_position_length;
        }
    }
    
    try
    {
        $prepared_query = 'SELECT longname_currency FROM currency
                           WHERE longname_currency = :longname';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('longname', $currency_translationcode_add);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $Bok_currency_insert = false;
            $_SESSION['msg_currency_transcode'] = $msg_currency_transcode;
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
            if(empty($currency_position_add))
            {
                $prepared_query = 'SELECT MAX(position_currency)
                                   FROM currency
                                   WHERE status_currency <> 9';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $currency_position_add = $data[0] + 10;
                }
                $query->closeCursor();
            }
            
            if($currency_default_add == 1)
            {
                $prepared_query = 'UPDATE currency
                                   SET priority_currency = 9';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                $query->closeCursor();
            }
            
            $prepared_query = 'SELECT MAX(id_currency)
                               FROM currency';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $currency_id = $data[0];
            }
            $query->closeCursor();
            
            $currency_id++;
            
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
                            $currency_id,
                            1,
                            true,
                            'currency_image',
                            'id_currency');
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
                            $currency_id,
                            9,
                            true,
                            'currency_image',
                            'id_currency');
            }
            
            $prepared_query = 'INSERT INTO currency
                               (longname_currency, shortname_currency, symbol_currency,
                                priority_currency, position_currency, status_currency,
                                defaultvalue_currency)
                               VALUES
                               (:longname, :shortname, :symbol, 
                                :priority, :position, :status, 
                                :defaultvalue)';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'longname' => $currency_translationcode_add,
                                  'shortname' => $currency_code_add,
                                  'symbol' => $currency_symbol_add,
                                  'priority' => $currency_default_add,
                                  'position' => $currency_position_add,
                                  'status' => $currency_status_add,
                                  'defaultvalue' => 1
                                  ));
            $query->closeCursor();

            $prepared_query = 'ALTER TABLE `currency` ADD `'.$currency_code_add.'` DOUBLE NULL';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $msg_done_currency_add = str_replace('[#name_currency]', give_translation('main.currency_'.strtolower($currency_code_add), 'false', $config_showtranslationcode), $msg_done_currency_add);
            $_SESSION['msg_currency_done'] = $msg_done_currency_add;
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
        $_SESSION['currency_txtTransCodeCurrency'] = $currency_translationcode_add;
        $_SESSION['currency_txtCodeCurrency'] = $currency_code_add;
        $_SESSION['currency_txtSymbolCurrency'] = $currency_symbol_add;
        $_SESSION['currency_chkPriorityCurrency'] = $currency_default_add;
        $_SESSION['currency_txtPositionCurrency'] = $currency_position_add;
        $_SESSION['currency_cboStatusCurrency'] = $currency_status_add;
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
