<?php
include('modules/custom/immo/modules/email/send/user/product_email/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$kformprodemail_sendername.' <'.$kformprodemail_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$kformprodemail_bcc.$kformprodemail_otherbcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$kformprodemail_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$kformprodemail_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$kformprodemail_boundary.$line_jump;
$message .= 'Content-Type: text/html; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= '<html>
    
            <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

include('modules/email/send/style/font.php');  
include('modules/email/send/style/block.php'); 

$message .= '</head>
                <body>';
            
      

$message .= '<table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#header   
if(!empty($kformprodemail_part1))
{
    $message .= '<tr>
                    <td>
                    '.$kformprodemail_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($kformprodemail_script))
{
    include($kformprodemail_script);
}

#bottom
if(!empty($kformprodemail_part2))
{
    $message .= '<tr>
                    <td>
                    '.$kformprodemail_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($kformprodemail_signature))
{
    $message .= '<tr>
                    <td>
                    '.$kformprodemail_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($kformprodemail_signature_script))
{
    include($kformprodemail_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$kformprodemail_boundary.'--'.$line_jump;


mail($kformprodemail_email, $kformprodemail_subject, $message, $header, " -f ".$kformprodemail_senderemail);
?>
