<?php
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$fproposep_legend_propertyinfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#offer
if($fproposep_offer != 'select')
{
    $fproposep_offer_email = give_translation('propose_property.subtitle_typeoffer', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_offer_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fproposep_email_selected_offer.'    
                    </td>
                </tr>';
}

#type object
if($fproposep_typeobject != 'select')
{
    $fproposep_typeobject_email = give_translation('propose_property.subtitle_typeproduct', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_typeobject_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fproposep_email_selected_typeobject.'    
                    </td>
                </tr>';
}

#condition
if($fproposep_condition != 'select')
{
    $fproposep_condition_email = give_translation('propose_property.subtitle_condition', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_condition_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fproposep_email_selected_condition.'    
                    </td>
                </tr>';
}

#location
if($fproposep_situation != 'select')
{
    $fproposep_situation_email = give_translation('propose_property.subtitle_location', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_situation_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fproposep_email_selected_situation.'    
                    </td>
                </tr>';
}

#price
if(!empty($fproposep_price))
{
    $fproposep_price_email = give_translation('propose_property.subtitle_price', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_price_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fproposep_price.'    
                    </td>
                </tr>';
}

$message .= '</table></td>
            </tr>';

#desc
if(!empty($fproposep_desc))
{
    
    $message .= '<tr>
                 <td align="left">
                 <FIELDSET>
                 <LEGEND>'.$fproposep_legend_desc.'</legend>
                 <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_desc.'
                    </td>
                 </tr>';
   
    $message .= '</table></FIELDSET></td>
                 </tr>';
}

#userinfo
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$fproposep_legend_userinfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#firstname & lastname
if(!empty($proposep_user_firstname))
{
    $fproposep_firstname_email = give_translation('propose_property.subtitle_email_name', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_firstname_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_firstname.' '.$proposep_user_lastname.'   
                    </td>
                </tr>';
}

#name company
if(!empty($proposep_user_companyname))
{
    $fproposep_companyname_email = give_translation('propose_property.subtitle_email_companyname', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fproposep_companyname_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_companyname.'   
                    </td>
                </tr>';
}

#address1 & 2
if(!empty($proposep_user_address1))
{
    $fproposep_address_email = give_translation('propose_property.subtitle_email_address', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_address_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_address1.'<br clear="left"/>'.$proposep_user_address2.'   
                    </td>
                </tr>';
}

#zip & city
if(!empty($proposep_user_zip))
{
    $fproposep_zipcity_email = give_translation('propose_property.subtitle_email_zipcity', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_zipcity_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_zip.' '.$proposep_user_city.'   
                    </td>
                </tr>';
}

#country
if(!empty($proposep_user_selected_country))
{
    $fproposep_country_email = give_translation('propose_property.subtitle_email_country', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_country_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_selected_country.'   
                    </td>
                </tr>';
}

#landline
if(!empty($proposep_user_landline))
{
    $fproposep_landline_email = give_translation('propose_property.subtitle_email_landline', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_landline_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_landline.'   
                    </td>
                </tr>';
}

#mobile
if(!empty($proposep_user_mobile))
{
    $fproposep_mobile_email = give_translation('propose_property.subtitle_email_mobile', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_mobile_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_mobile.'   
                    </td>
                </tr>';
}

#fax
if(!empty($proposep_user_fax))
{
    $fproposep_fax_email = give_translation('propose_property.subtitle_email_fax', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_fax_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_fax.'   
                    </td>
                </tr>';
}

#email
if(!empty($proposep_user_email))
{
    $fproposep_email_email = give_translation('propose_property.subtitle_email_email', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fproposep_email_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$proposep_user_email.'   
                    </td>
                </tr>';
}

$message .= '</table></FIELDSET></td>
             </tr>';

#message
if(!empty($fproposep_msg))
{
    
    $message .= '<tr>
                 <td align="left">
                 <FIELDSET>
                 <LEGEND>'.$fproposep_legend_msg.'</legend>
                 <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

   $message .= '<tr>
                    <td align="left">
                    '.$fproposep_msg.'
                    </td>
                </tr>';
   
    $message .= '</table></FIELDSET></td>
                 </tr>';
}
?>
