<?php
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$fcontactmain_legend_maininfo.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#title
if(!empty($fcontactmain_email))
{
    $fcontactmain_subtitle_email = give_translation('form_contactmain.subtitle_email_email', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fcontactmain_subtitle_email.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fcontactmain_email.'    
                    </td>
                </tr>';
}

#name
if(!empty($fcontactmain_name))
{
    $fcontactmain_email_name = give_translation('form_contactmain.subtitle_name', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fcontactmain_email_name.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fcontactmain_name.'   
                    </td>
                </tr>';
}

#phone
if(!empty($fcontactmain_phone))
{
    $fcontactmain_email_phone = give_translation('form_contactmain.subtitle_phone', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fcontactmain_email_phone.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fcontactmain_phone.'  
                    </td>
                </tr>';
}

$message .= '</table></td>
            </tr>';

#subject & message
$message .= '<tr>
             <td align="left">
             <FIELDSET>
             <LEGEND>'.$fcontactmain_legend_msg.'</legend>
             <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#subject
if(!empty($fcontactmain_email_selected_subject))
{
    $fcontactmain_email_subject = give_translation('form_contactmain.subtitle_subject', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left">
                    '.$fcontactmain_email_subject.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fcontactmain_email_selected_subject.'
                    </td>
                </tr>';
}

#message
if(!empty($fcontactmain_msg))
{
    $fcontactmain_email_msg = give_translation('form_contactmain.subtitle_email_msg', 'false', $config_showtranslationcode);
    
    $message .= '<tr>
                    <td align="left" style="vertical-align: top;">
                    '.$fcontactmain_email_msg.'
                    </td>
                    <td align="left" width="'.$right_column_width.'">
                    '.$fcontactmain_msg.'
                    </td>
                </tr>';
}

$message .= '</table></FIELDSET></td>
             </tr>';
?>
