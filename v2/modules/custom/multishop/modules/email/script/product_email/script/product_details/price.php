<?php
if($customgetinfo_displayvalue[3] == 1 || $customgetinfo_displayvalue[4] == 1
        || $customgetinfo_displayvalue[5] == 1 || $customgetinfo_displayvalue[7] == 1)
{
    $price_product = $customgetinfo_price * $main_rate_currency;
    $price_product = number_format($price_product, 0, '.', '.');
    
    $approx_product = give_translation('main.approx_product_immo', 'false', $config_showtranslationcode); 
    
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
    
    $message .= '<tr>
                <td align="left"><table width="100%" style="border: 1px solid;
                                border-color: #CCCCCC;
                                border-radius: 8px 8px 8px 8px;
                                -moz-border-radius: 8px 8px 8px 8px;
                                -webkit-border-radius: 8px 8px 8px 8px;
                                background-color: #FFFFFF;
                                width: 100%;
                                height: 100%;
                                padding: 4px;
                                font-size: 12px;
                                font-weight: normal;
                                color: #000000;
                                text-decoration: none;
                                text-align: left; margin-bottom: 4px;">
                    <tr>
                        <td align="left"><table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                            <td align="left" style="vertical-align: top; font-size: 12px;
                            font-weight: bold;
                            color: #0B3B02;
                            text-decoration: none;
                            text-align: left;" width="'.$custom_1column_width.'" class="font_subtitle">
                                '.give_translation('displayvalueimmo.price_product_immo', 'false', $config_showtranslationcode).'
                            </td>
                            <td align="left" class="font_main">';

                    if($price_product > 0)
                    {
                        if($main_activatedidcurrency[0] == $main_id_currency)
                        {
                            $message .= $price_product.'&nbsp;'.$_SESSION['current_selectedsymbol_currency'].' ';
                        }
                        else
                        {          
                            $message .= $approx_product.' '.$price_product.'&nbsp;'.$_SESSION['current_selectedsymbol_currency'].' ';
                        }
                    
                        if($customgetinfo_displayvalue[7] == 1 && $customgetinfo_feeincex != 'select')
                        {
                            if($customgetinfo_fee > 0)
                            {
                                if($customgetinfo_displayvalue[5] == 1)
                                {
                                    $message .='(';
                                    if($main_activatedidcurrency[0] == $main_id_currency)
                                    {  
                                        $message .= $fee_agency;
                                    }
                                    else
                                    {

                                        $message .= $approx_product.' '.$fee_agency;
                                    }
                                    $message .= ' ';
                                }            
                            }

                            if($customgetinfo_displayvalue[7] == 1 && $customgetinfo_feeincex != 'select')
                            {
                                if($customgetinfo_displayvalue[5] == 9 || $customgetinfo_fee <= 0)
                                {
                                    $message .= '(';
                                }
                                $message .= give_translation('main.fai_product_immo', 'false', $config_showtranslationcode);
                                $message .= ' '.$customgetinfo_feeincex.')';
                            }
                        }
                    }
                    else
                    {
                        $message .= give_translation('displayvalueimmo.onrequest_product_immo', 'false', $config_showtranslationcode);
                    }
    $message .= '</td>
                </tr>
            </table></td>
        </tr>
    </table></td>
</tr>';
           
}
?>