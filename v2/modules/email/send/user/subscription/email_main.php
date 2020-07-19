<?php
include('modules/email/send/user/subscription/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$subscription_confirm_sendername.' <'.$subscription_confirm_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$subscription_confirm_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$subscription_confirm_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$subscription_confirm_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$subscription_confirm_boundary.$line_jump;
$message .= 'Content-Type: text/html; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= '<html>
    
            <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
    
            <body>

                <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#header   
if(!empty($subscription_confirm_part1))
{
    $message .= '<tr>
                    <td>
                    '.$subscription_confirm_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($subscription_confirm_script))
{
    include($subscription_confirm_script);
}

#bottom
if(!empty($subscription_confirm_part2))
{
    $message .= '<tr>
                    <td>
                    '.$subscription_confirm_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($subscription_confirm_signature))
{
    $message .= '<tr>
                    <td>
                    '.$subscription_confirm_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($subscription_confirm_signature_script))
{
    include($subscription_confirm_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$subscription_confirm_boundary.'--'.$line_jump;


mail($subscriptionform_email, $subscription_confirm_subject, $message, $header, " -f ".$subscription_confirm_senderemail);
?>