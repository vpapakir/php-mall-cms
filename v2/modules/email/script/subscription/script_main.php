<?php
$message .= '<tr>
             <td align="left">
             <fieldset>
             <legend>'.$subscription_confirm_legend_maininfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#type
if(!empty($subscriptionform_type))
{
    $subscription_confirm_email_type = give_translation('subscription.subtitle_typeuser', 'false', $config_showtranslationcode);
    $subscriptionform_confirm_email_value_type = give_translation('subscription.typeuser_'.$subscriptionform_type, 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_type.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_confirm_email_value_type.'    
                    </td>
                </tr>';
}

#title
if(!empty($subscriptionform_title))
{
    $subscription_confirm_email_title = give_translation('subscription.email_title', 'false', $config_showtranslationcode);
    if(is_numeric($subscriptionform_title))
    {
        $subscriptionform_title = giveCDRvalue($subscriptionform_title, 'cdreditor', $main_id_language);
    }
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_title.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_title.'    
                    </td>
                </tr>';
}

#firstname & lastname
if(!empty($subscriptionform_firstname) && !empty($subscriptionform_lastname))
{
    $subscription_confirm_email_firstlastname = give_translation('subscription.email_firstlastname', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_firstlastname.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_firstname.' '.$subscriptionform_lastname.'   
                    </td>
                </tr>';
}

#birthday
if((!empty($subscriptionform_birthday) && $subscriptionform_birthday != 'select')
        && (!empty($subscriptionform_birthmonth) && $subscriptionform_birthmonth != 'select')
        && (!empty($subscriptionform_birthyear) && $subscriptionform_birthyear != 'select'))
{
    $subscription_confirm_email_birthday = give_translation('subscription.email_birthday', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_birthday.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_birthday.'/'.$subscriptionform_birthmonth.'/'.$subscriptionform_birthyear.'  
                    </td>
                </tr>';
}

#company name & type
if(!empty($subscriptionform_companyname))
{
    $subscription_confirm_email_companyname = give_translation('subscription.email_companyname', 'false', $config_showtranslationcode);
    if(!empty($subscriptionform_companytype) && $subscriptionform_companytype != 'select')
    {
        if(is_numeric($subscriptionform_companytype))
        {
            $subscriptionform_companytype = giveCDRvalue($subscriptionform_companytype, 'cdreditor', $main_id_language);
        }
    }
    else
    {
        $subscriptionform_companytype = null;
    }
    
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_companyname.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_companytype.' '.$subscriptionform_companyname.'   
                    </td>
                </tr>';
}

#company activity
if(!empty($subscriptionform_companyactivity) && $subscriptionform_companyactivity != 'select')
{
    $subscription_confirm_email_companyactivity = give_translation('subscription.email_companyactivity', 'false', $config_showtranslationcode);
    if(is_numeric($subscriptionform_companyactivity))
    {
        $subscriptionform_companyactivity = giveCDRvalue($subscriptionform_companyactivity, 'cdreditor', $main_id_language);
    }
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_companyactivity.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_companyactivity.'   
                    </td>
                </tr>';
}

#company function
if(!empty($subscriptionform_companyfunction) && $subscriptionform_companyfunction != 'select')
{
    $subscription_confirm_email_companyfunction = give_translation('subscription.email_companyfunction', 'false', $config_showtranslationcode);
    if(is_numeric($subscriptionform_companyfunction))
    {
        $subscriptionform_companyfunction = giveCDRvalue($subscriptionform_companyfunction, 'cdreditor', $main_id_language);
    }
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_companyfunction.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_companyfunction.'   
                    </td>
                </tr>';
}

#company SIRET
if(!empty($subscriptionform_companysiret))
{
    $subscription_confirm_email_companysiret = give_translation('subscription.email_companysiret', 'false', $config_showtranslationcode);
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_companysiret.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_companysiret.'   
                    </td>
                </tr>';
}

#company VAT INTRA
if(!empty($subscriptionform_companyvatintra))
{
    $subscription_confirm_email_companyvatintra = give_translation('subscription.email_companyvatintra', 'false', $config_showtranslationcode);
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_companyvatintra.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_companyvatintra.'   
                    </td>
                </tr>';
}

#address 1
if(!empty($subscriptionform_address1))
{
    $subscription_confirm_email_address1 = give_translation('subscription.email_address1', 'false', $config_showtranslationcode);
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_address1.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_address1.'   
                    </td>
                </tr>';
}

#address 2
if(!empty($subscriptionform_address2))
{
    $subscription_confirm_email_address2 = give_translation('subscription.email_address2', 'false', $config_showtranslationcode);
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_address2.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_address2.'   
                    </td>
                </tr>';
}

#zip & city
if(!empty($subscriptionform_zip) && !empty($subscriptionform_city))
{
    $subscription_confirm_email_zipcity = give_translation('subscription.email_zipcity', 'false', $config_showtranslationcode);
 
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_zipcity.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_zip.' '.$subscriptionform_city.'  
                    </td>
                </tr>';
}

#country
if(!empty($subscriptionform_country))
{
    $subscription_confirm_email_country = give_translation('subscription.email_country', 'false', $config_showtranslationcode);
    if(is_numeric($subscriptionform_country))
    {
        $subscriptionform_country = giveCDRvalue($subscriptionform_country, 'cdrgeo', $main_id_language);
    }
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_country.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_country.'  
                    </td>
                </tr>';
}

#website
if(!empty($subscriptionform_website))
{
    $subscription_confirm_email_website = give_translation('subscription.email_website', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_website.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    <a href="http://'.$subscriptionform_website.'">'.$subscriptionform_website.'</a>  
                    </td>
                </tr>';
}

#landline
if(!empty($subscriptionform_landline))
{
    $subscription_confirm_email_landline = give_translation('subscription.email_landline', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_landline.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_landline.'
                    </td>
                </tr>';
}

#mobile
if(!empty($subscriptionform_mobile))
{
    $subscription_confirm_email_mobile = give_translation('subscription.email_mobile', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_mobile.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_mobile.'
                    </td>
                </tr>';
}

#fax
if(!empty($subscriptionform_fax))
{
    $subscription_confirm_email_fax = give_translation('subscription.email_fax', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_fax.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_fax.'
                    </td>
                </tr>';
}

$message .= '</table></fieldset></td>
            </tr>';

#connection info
$message .= '<tr>
             <td align="left">
             <fieldset>
             <legend>'.$subscription_confirm_legend_connexioninfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#nickname
if(!empty($subscriptionform_nickname))
{
    $subscription_confirm_email_nickname = give_translation('subscription.email_nickname', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_nickname.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_nickname.'
                    </td>
                </tr>';
}

#email
if(!empty($subscriptionform_email))
{
    $subscription_confirm_email_email = give_translation('subscription.email_email', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscriptionform_email.'
                    </td>
                </tr>';
}

#password
if(!empty($subscriptionform_password_foremail))
{
    $subscription_confirm_email_password = give_translation('subscription.email_password', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$subscription_confirm_email_password.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$subscription_uncrypted_pwd_part1.$subscription_uncrypted_pwd_part2.$subscription_uncrypted_pwd_part3.'
                    </td>
                </tr>';
}

$message .= '</table></fieldset></td>
             </tr>';
?>
