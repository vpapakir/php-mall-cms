<?php
include('modules/custom/immo/modules/email/send/user/visit/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$kformvisit_sendername.' <'.$kformvisit_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$kformvisit_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$kformvisit_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$kformvisit_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$kformvisit_boundary.$line_jump;
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
if(!empty($kformvisit_part1))
{
    $message .= '<tr>
                    <td>
                    '.$kformvisit_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($kformvisit_script))
{
    include($kformvisit_script);
}

#bottom
if(!empty($kformvisit_part2))
{
    $message .= '<tr>
                    <td>
                    '.$kformvisit_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($kformvisit_signature))
{
    $message .= '<tr>
                    <td>
                    '.$kformvisit_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($kformvisit_signature_script))
{
    include($kformvisit_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$kformvisit_boundary.'--'.$line_jump;


mail($config_email_senderemail, $kformvisit_subject, $message, $header, " -f ".$kformvisit_senderemail);
?>
