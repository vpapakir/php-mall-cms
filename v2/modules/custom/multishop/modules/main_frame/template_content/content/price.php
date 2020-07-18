<?php
#price, currency
if($customgetinfo_displayvalue[3] == 1 || $customgetinfo_displayvalue[4] == 1
        || $customgetinfo_displayvalue[5] == 1 || $customgetinfo_displayvalue[7] == 1)
{
    $price_product = $customgetinfo_price * $main_rate_currency;
    $price_product = number_format($price_product, 0, '.', '.');
    
    $approx_product = give_translation('main.approx_product_immo', 'false'); 
    
    $prepared_query = 'SELECT L2S FROM cdreditor
                       WHERE id_cdreditor = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_feetype);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_feetype = $data[0];
    }
    
    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                       WHERE id_cdreditor = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_feeincex);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_feeincex = $data[0];
    }
    
    if(preg_match('#[Mm]oney#', $customgetinfo_feetype))
    {
        $fee_agency = $customgetinfo_fee * $main_rate_currency;
        $fee_agency = number_format($fee_agency, 0, '.', '.').'&nbsp;'.$_SESSION['current_selectedsymbol_currency'];
    }
    else
    {
        if(!empty($customgetinfo_feetype))
        {
            $fee_agency = $customgetinfo_fee.'%';
        }
        else
        {
            $customgetinfo_fee = 0;
        }
    }
    
?>
    <tr>
        <td align="left"><table class="block_main2" width="100%" style="margin: 0px 0px 4px 0px;">
            <tr>
                <td align="left"><table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                    <td align="left" style="vertical-align: top;" class="font_subtitle" width="<?php echo($custom_1column_width); ?>">
                        <?php give_translation('displayvalueimmo.price_product_immo'); ?>
                    </td>
                    <td align="left" class="font_main">
<?php
                    if($price_product > 0)
                    {
                        if($main_activatedidcurrency[0] == $main_id_currency)
                        {
                            echo($price_product.'&nbsp;'.$_SESSION['current_selectedsymbol_currency'].' ');
                        }
                        else
                        {          
                            echo($approx_product.' '.$price_product.'&nbsp;'.$_SESSION['current_selectedsymbol_currency'].' ');
                        }
                    
                        if($customgetinfo_displayvalue[7] == 1 && $customgetinfo_feeincex != 'select')
                        {
                            if($customgetinfo_fee > 0)
                            {
                                if($customgetinfo_displayvalue[5] == 1)
                                {
                                    echo('(');
                                    if($main_activatedidcurrency[0] == $main_id_currency)
                                    {  
                                        echo($fee_agency);
                                    }
                                    else
                                    {

                                        echo($approx_product.' '.$fee_agency);
                                    }
                                    echo(' ');
                                }            
                            }

                            if($customgetinfo_displayvalue[7] == 1 && $customgetinfo_feeincex != 'select')
                            {
                                if($customgetinfo_displayvalue[5] == 9 || $customgetinfo_fee <= 0)
                                {
                                    echo('(');
                                }
                                give_translation('main.fai_product_immo');
                                echo(' '.$customgetinfo_feeincex.')');
                            }
                        }
                    }
                    else
                    {
                        give_translation('displayvalueimmo.onrequest_product_immo');
                    }       
?>                     </td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
<?php            
}
?>
