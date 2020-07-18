<?php
if(isset($_POST['bt_cboSelectCurrency']))
{
    unset($_SESSION['currency_chkPriorityCurrency'],
            $_SESSION['currency_txtTransCodeCurrency'],
            $_SESSION['currency_txtCodeCurrency'],
            $_SESSION['currency_txtSymbolCurrency'],
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
    
    $selected_currency = htmlspecialchars($_POST['cboSelectCurrency'], ENT_QUOTES);
    
    if($selected_currency == 'new')
    {
        unset($_SESSION['currency_cboSelectCurrency']);
    }
    else
    {
        $_SESSION['currency_cboSelectCurrency'] = $selected_currency;
        
        try
        {
            $prepared_query = 'SELECT * FROM currency
                               WHERE id_currency = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_currency);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {  
                $_SESSION['currency_chkPriorityCurrency'] = $data['priority_currency'];
                $_SESSION['currency_txtTransCodeCurrency'] = $data['longname_currency'];
                $_SESSION['currency_txtCodeCurrency'] = $data['shortname_currency'];
                $_SESSION['currency_txtSymbolCurrency'] = $data['symbol_currency'];
                $_SESSION['currency_txtPositionCurrency'] = $data['position_currency'];
                $_SESSION['currency_cboStatusCurrency'] = $data['status_currency'];
                $_SESSION['currency_txtDefaultvalueCurrency'] = $data['defaultvalue_currency'];
                
                for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
                {
                    $_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]] = $data[$main_activatedcodecurrency[$i]];
                }
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
