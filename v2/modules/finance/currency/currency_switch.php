<?php
if(empty($_SESSION['currency_switch_firstload']))
{
    $_SESSION['currency_switch_firstload'] = 'notempty';
    try
    {
       $prepared_query = 'SELECT * FROM currency
                          WHERE priority_currency = 1';
       $query = $connectData->prepare($prepared_query);
       $query->execute();
       
       if(($data = $query->fetch()) != false)
       {
           $main_id_currency = $data[0];
           $main_priority_currency = $data[0];
           $main_rate_currency = $data['defaultvalue_currency'];
           $main_code_currency = $data['shortname_currency'];
           $main_selectedcode_currency = $data['shortname_currency'];
           $main_selectedsymbol_currency = $data['symbol_currency'];
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
    
    $_SESSION['current_currency'] = $main_id_currency;
    $_SESSION['current_priority_currency'] = $main_priority_currency;
    $_SESSION['current_coef_currency'] = number_format((1 / $main_rate_currency), 5, '.', '');
    $_SESSION['current_rate_currency'] = $main_rate_currency;
    $_SESSION['current_code_currency'] = $main_code_currency;
    $_SESSION['current_selectedcode_currency'] = $main_selectedcode_currency;
    $_SESSION['current_selectedsymbol_currency'] = $main_selectedsymbol_currency;
}

if(isset($_GET['currency']))
{
    $main_id_currency = trim(htmlspecialchars($_GET['currency'], ENT_QUOTES));
    $_SESSION['current_currency'] = $main_id_currency;
    
    try
    {
       $prepared_query = 'SELECT * FROM currency
                          WHERE id_currency = :id';
       $query = $connectData->prepare($prepared_query);
       $query->bindParam('id', $main_id_currency);
       $query->execute();
       
       if(($data = $query->fetch()) != false)
       {
           $main_id_currency = $data[0];
           $main_selectedcode_currency = $data['shortname_currency'];
           $main_selectedsymbol_currency = $data['symbol_currency'];
       }
       
       
       
       $prepared_query = 'SELECT * FROM currency
                          WHERE priority_currency = 1';
       $query = $connectData->prepare($prepared_query);
       $query->execute(); 
       
       if(($data = $query->fetch()) != false)
       {
           $main_priority_currency = $data[0];
           $main_rate_currency = $data[$main_selectedcode_currency];
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
    
    
    $_SESSION['current_coef_currency'] = number_format((1 / $main_rate_currency), 5, '.', '');
    $_SESSION['current_rate_currency'] = $main_rate_currency;
    $_SESSION['current_priority_currency'] = $main_priority_currency;
    $_SESSION['current_selectedcode_currency'] = $main_selectedcode_currency;
    $_SESSION['current_selectedsymbol_currency'] = $main_selectedsymbol_currency;
    
    unset($_SESSION['quicksearch_cboCurrencyQuicksearch'],
            $_SESSION['SaleSearch_cboCurrencySaleSearch']);
}

try
{
    $prepared_query = 'SELECT * FROM currency
                       WHERE status_currency = 1
                       ORDER BY priority_currency, position_currency, shortname_currency';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $main_activatedidcurrency[$i] = $data[0];
        $main_activatedcodecurrency[$i] = $data['shortname_currency'];
        $main_activatedtranscodecurrency[$i] = 'main.'.$data['longname_currency'];
        $main_activatedsymbolcurrency[$i] = $data['symbol_currency'];
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
