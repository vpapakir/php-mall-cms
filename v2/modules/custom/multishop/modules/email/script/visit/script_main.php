<?php
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$kformvisit_legend_propertyinfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

for($i = 0, $count = count($kformvisit_selectedid_property); $i < $count; $i++)
{
    $message .= '<tr>                        
        <td align="left">
            <a href="'.$config_customheader.$kformvisit_product_rewritingF[$i].'" style="text-decoration: none;">
                <table style="border: 1px solid;
                            border-color: #CCCCCC;
                            border-radius: 8px 8px 8px 8px;
                            -moz-border-radius: 8px 8px 8px 8px;
                            -webkit-border-radius: 8px 8px 8px 8px;
                            background-color: #FFFFFF;
                            width: 100%;
                            height: 100%;
                            padding: 1px;
                            font-size: 12px;
                            font-weight: normal;
                            color: #000000;
                            text-decoration: none;
                            text-align: left;
                            font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';" width="100%" ';

    if(!empty($searchlisting_priority_blockstyle))
    { 
        $message .= 'style="background-color: '.$searchlisting_priority_blockstyle.';"'; 
    }

    $message .= 'onmouseover="this.style.backgroundColor = \'\';" onmouseout="this.style.backgroundColor = '.$searchlisting_priority_blockstyle.';" style="margin-bottom: 4px;">
                <tr>
                    <td colspan="3"><table style="border-radius: 8px 8px 0px 0px;
                                                -moz-border-radius: 8px 8px 0px 0px;
                                                -webkit-border-radius: 8px 8px 0px 0px;
                                                background-color: #707070;
                                                width: 100%;
                                                height: 100%;
                                                font-size: 12px;
                                                font-weight: normal;
                                                color: #FFFFFF;
                                                text-decoration: none;
                                                text-align: center;
                                                font-family: \'Tahoma\', \'Geneva\', \'Trebuchet MS\', \'Verdana\', \'sans-serif\';" width="100%">
                        <tr>
                            <td align="left">
                                '.$kformvisit_product_offer[$i].': '.$kformvisit_product_title[$i].'                                        
                            </td>
                            <td align="right" width="29%" style="vertical-align: top;">';

                                if(!empty($kformvisit_product_price[$i]))
                                {
                                    $message .= number_format($kformvisit_product_price[$i], 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency;
                                    if($main_id_currency != $main_priority_currency)
                                    {
                                        $kformvisit_approx = give_translation('kform_visit.listing_price_approx', 'false', $config_showtranslationcode); 
                                        $message .= ' '.$kformvisit_approx;
                                    }
                                }
                                else
                                {
                                    $kformvisit_onrequest = give_translation('kform_visit.listing_price_onrequest', 'false', $config_showtranslationcode); 
                                    $message .= ' '.$kformvisit_onrequest;
                                }

    $message .= '                        </td>
                        </tr>
                    </table></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">
                        <img style="border: 1px solid lightgray;" src="'.$config_customheader.$kformvisit_product_pathimage[$i].'" alt="'.$kformvisit_product_altimage[$i].'">
                    </td>
                    <td style="vertical-align: top;" width="52%">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">
                            <tr>
                                <td align="left">
                                    <span>
                                        '.cut_string($kformvisit_product_intro[$i], 0, 120, '...').'
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <span>Ref: '.$kformvisit_product_reference[$i].'</span> <span class="font_info2">'.$kformvisit_product_comdetails[$i].'</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="height: 100%; vertical-align: top;" width="30%">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';">
                            <tr>
                                <td align="right">
                                    '.$kformvisit_product_type[$i].'
                                </td>
                            </tr>
                            <tr>
                                <td align="right">';

                                    if(!empty($kformvisit_product_surfhab[$i]))
                                    {
                                        $message .= $kformvisit_product_surfhab[$i].'m² habitable';
                                    }

    $message .= '               </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    '.$kformvisit_product_condition[$i].'
                                </td>
                            </tr>
                            <tr>
                                <td align="right">';

                                    if(!empty($kformvisit_product_location[$i]) || !empty($kformvisit_product_locdetails[$i]))
                                    {
                                        if(!empty($kformvisit_product_location[$i]) && !empty($kformvisit_product_locdetails[$i]))
                                        {
                                            $message .= cut_string($kformvisit_product_location[$i].', '.$kformvisit_product_locdetails[$i], 0, 22, '...');
                                        }
                                        else
                                        {
                                            if(!empty($kformvisit_product_location[$i]))
                                            {
                                                $message .= $kformvisit_product_location[$i];
                                            }

                                            if(!empty($kformvisit_product_locdetails[$i]))
                                            {
                                                $message .= $kformvisit_product_locdetails[$i];
                                            }
                                        }
                                    }

    $message .= '              </td>
                            </tr>
                        </table>
                    </td>              
                </tr>
                </table>
            </a>
        </td>
    </tr>';
}

$message .= '</table></td>
            </tr>';

#userinfo
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$kformvisit_legend_userinfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#firstname & lastname
if(!empty($kformvisit_user_firstname))
{
    $kformvisit_firstname_email = give_translation('kform_visit.subtitle_email_name', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$kformvisit_firstname_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_firstname.' '.$kformvisit_user_lastname.'   
                    </td>
                </tr>';
}

#name company
if(!empty($kformvisit_user_companyname))
{
    $kformvisit_companyname_email = give_translation('kform_visit.subtitle_email_companyname', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$kformvisit_companyname_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_companyname.'   
                    </td>
                </tr>';
}

#address1 & 2
if(!empty($kformvisit_user_address1))
{
    $kformvisit_address_email = give_translation('kform_visit.subtitle_email_address', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_address_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_address1.'<br clear="left"/>'.$kformvisit_user_address2.'   
                    </td>
                </tr>';
}

#zip & city
if(!empty($kformvisit_user_zip))
{
    $kformvisit_zipcity_email = give_translation('kform_visit.subtitle_email_zipcity', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_zipcity_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_zip.' '.$kformvisit_user_city.'   
                    </td>
                </tr>';
}

#country
if(!empty($kformvisit_user_selected_country))
{
    $kformvisit_country_email = give_translation('kform_visit.subtitle_email_country', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_country_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_selected_country.'   
                    </td>
                </tr>';
}

#landline
if(!empty($kformvisit_user_landline))
{
    $kformvisit_landline_email = give_translation('kform_visit.subtitle_email_landline', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_landline_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_landline.'   
                    </td>
                </tr>';
}

#mobile
if(!empty($kformvisit_user_mobile))
{
    $kformvisit_mobile_email = give_translation('kform_visit.subtitle_email_mobile', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_mobile_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_mobile.'   
                    </td>
                </tr>';
}

#fax
if(!empty($kformvisit_user_fax))
{
    $kformvisit_fax_email = give_translation('kform_visit.subtitle_email_fax', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_fax_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_fax.'   
                    </td>
                </tr>';
}

#email
if(!empty($kformvisit_user_email))
{
    $kformvisit_email_email = give_translation('kform_visit.subtitle_email_email', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$kformvisit_email_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$kformvisit_user_email.'   
                    </td>
                </tr>';
}

$message .= '</table></FIELDSET></td>
             </tr>';

#message
if(!empty($kformvisit_msg))
{
    
    $message .= '<tr>
                 <td align="left">
                 <FIELDSET>
                 <LEGEND>'.$kformvisit_legend_msg.'</legend>
                 <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

   $message .= '<tr>
                    <td align="left">
                    '.$kformvisit_msg.'
                    </td>
                </tr>';
   
    $message .= '</table></FIELDSET></td>
                 </tr>';
}
?>
