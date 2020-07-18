<?php
unset($line_jump);
$line_jump = "\n";
$myaccount_msg_boundary = md5(rand());

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$myaccount_msg_view_receiver.' <'.$myaccount_msg_reply_receiver.'>'.$line_jump;
$header .= 'Bcc: '.$config_email_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$config_email_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$myaccount_msg_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$myaccount_msg_boundary.$line_jump;
$message .= 'Content-Type: text/html; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= '<html>
    
            <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
    
            <body>';

$message .= '<table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';


$message .= '<tr>
                <td align="left">
                '.$myaccount_msg_reply_message.'
                </td>
             </tr>';

$message .= '</table>';

$message .= '<hr style="height: 1px"></hr>';

$message .= $myaccount_msg_reply_originmsg;

$message .='</body>
            </html>'.$line_jump;
$message .= '--'.$myaccount_msg_boundary.'--'.$line_jump;


mail($myaccount_msg_reply_sender, $myaccount_msg_reply_subject, $message, $header, " -f ".$myaccount_user_email);
?>
