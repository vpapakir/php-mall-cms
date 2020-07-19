<tr>
    <td></td>
    <td style="vertical-align: top;" class="font_subtitle">
        <?php give_translation('immo.searchproperty_result_price', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
    if(!empty($_SESSION['quicksearch_txtPriceMinQuicksearch']) || !empty($_SESSION['quicksearch_txtPriceMaxQuicksearch'])
            || !empty($_SESSION['SaleSearch_txtPriceMinSaleSearch']) || !empty($_SESSION['SaleSearch_txtPriceMaxSaleSearch']))
    {
        if(empty($_SESSION['quicksearch_cboCurrencyQuicksearch']) && empty($_SESSION['SaleSearch_cboCurrencySaleSearch']))
        {
            $resultsalesearch_currency = $main_id_currency;
            $resultsalesearch_rate_currency = $main_rate_currency;
        }
        else
        {
            if(!empty($_SESSION['quicksearch_cboCurrencyQuicksearch']))
            {
                $resultsalesearch_currency = $_SESSION['quicksearch_cboCurrencyQuicksearch'];
            }
            else
            {
                $resultsalesearch_currency = $_SESSION['SaleSearch_cboCurrencySaleSearch'];
            }
        }
        
        try
        {
            if(!empty($_SESSION['quicksearch_cboCurrencyQuicksearch']))
            {
                $prepared_query = 'SELECT * FROM currency
                                   WHERE id_currency = :id';
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $resultsalesearch_currency);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                   $resultsalesearch_selectedcode_currency = $data['shortname_currency'];
                }
                $query->closeCursor();

                $prepared_query = 'SELECT * FROM currency
                                  WHERE priority_currency = 1';
                $query = $connectData->prepare($prepared_query);
                $query->execute(); 

                if(($data = $query->fetch()) != false)
                {
                   $resultsalesearch_idpriority_currency = $data[0];
                   $resultsalesearch_rate_currency = $data[$resultsalesearch_selectedcode_currency];
                }
                $query->closeCursor();
            }
            
            $resultsalesearch_coef_currency = 1 / $resultsalesearch_rate_currency;
            
            $prepared_query = 'SELECT * FROM currency
                               WHERE id_currency = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $resultsalesearch_currency);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $resultsalesearch_symbol_currency = $data['symbol_currency'];
            }
            $query->closeCursor();
        }
        catch (Exception $e)
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
        
        if(!empty($_SESSION['quicksearch_txtPriceMinQuicksearch']))
        {
            $resultsalesearch_pricemin = $_SESSION['quicksearch_txtPriceMinQuicksearch'];
        }
        else 
        {
            $resultsalesearch_pricemin = $_SESSION['SaleSearch_txtPriceMinSaleSearch'];
        }
        
        if(!empty($_SESSION['quicksearch_txtPriceMaxQuicksearch']))
        {
            $resultsalesearch_pricemax = $_SESSION['quicksearch_txtPriceMaxQuicksearch'];
        }
        else 
        {
            $resultsalesearch_pricemax = $_SESSION['SaleSearch_txtPriceMaxSaleSearch'];
        }
        
        $resultsalesearch_priceeuromin = $resultsalesearch_pricemin * $resultsalesearch_coef_currency;
        $resultsalesearch_priceeuromax = $resultsalesearch_pricemax * $resultsalesearch_coef_currency;
        
        $resultsalesearch_priceeuromin = number_format($resultsalesearch_priceeuromin, 0, ',', '.');
        $resultsalesearch_priceeuromax = number_format($resultsalesearch_priceeuromax, 0, ',', '.');
        
        
        
        $resultsalesearch_pricemin = number_format($resultsalesearch_pricemin, 0, ',', '.');
        $resultsalesearch_pricemax = number_format($resultsalesearch_pricemax, 0, ',', '.');
        
        if(!empty($resultsalesearch_pricemin) && !empty($resultsalesearch_pricemax))
        {
            echo($resultsalesearch_pricemin.' - '.$resultsalesearch_pricemax.' '.$resultsalesearch_symbol_currency);
        }
        else
        {
            if(!empty($resultsalesearch_pricemin))
            {
                echo($resultsalesearch_pricemin.' '.$resultsalesearch_symbol_currency.' '); give_translation('immo.searchproperty_result_minimum', $echo, $config_showtranslationcode);
            }
            
            if(!empty($resultsalesearch_pricemax))
            {
                echo($resultsalesearch_pricemax.' '.$resultsalesearch_symbol_currency.' '); give_translation('immo.searchproperty_result_maximum', $echo, $config_showtranslationcode);
            }
        }
        
        if($resultsalesearch_idpriority_currency != $resultsalesearch_currency && $main_code_currency != $main_selectedcode_currency)
        {
            if(!empty($resultsalesearch_priceeuromin) && !empty($resultsalesearch_priceeuromax))
            {
                echo('<br/>('); give_translation('immo.searchproperty_result_priceapprox', $echo, $config_showtranslationcode); echo(' '.$resultsalesearch_priceeuromin.' - '.$resultsalesearch_priceeuromax.' €)');
            }
            else
            {
                if(!empty($resultsalesearch_priceeuromin))
                {
                    echo('<br/>('); give_translation('immo.searchproperty_result_priceapprox', $echo, $config_showtranslationcode); echo(' '.$resultsalesearch_priceeuromin.' € '); give_translation('immo.searchproperty_result_minimum', $echo, $config_showtranslationcode); echo(')');
                }

                if(!empty($resultsalesearch_priceeuromax))
                {
                    echo('<br/>('); give_translation('immo.searchproperty_result_priceapprox', $echo, $config_showtranslationcode); echo(' '.$resultsalesearch_priceeuromax.' € '); give_translation('immo.searchproperty_result_maximum', $echo, $config_showtranslationcode); echo(')');
                }
            }
        }
    }
    else
    {
        echo('<I>'); give_translation('immo.searchproperty_result_notrequested', $echo, $config_showtranslationcode); echo('</I>');
    }
?>
    </td>
</tr>
