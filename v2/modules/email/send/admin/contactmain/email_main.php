<?php
include('modules/email/send/admin/contactmain/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$fcontactmain_sendername.' <'.$fcontactmain_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$fcontactmain_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$fcontactmain_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$fcontactmain_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$fcontactmain_boundary.$line_jump;
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
if(!empty($fcontactmain_part1))
{
    $message .= '<tr>
                    <td>
                    '.$fcontactmain_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($fcontactmain_script))
{
    include($fcontactmain_script);
}

#bottom
if(!empty($fcontactmain_part2))
{
    $message .= '<tr>
                    <td>
                    '.$fcontactmain_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($fcontactmain_signature))
{
    $message .= '<tr>
                    <td>
                    '.$fcontactmain_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($fcontactmain_signature_script))
{
    include($fcontactmain_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$fcontactmain_boundary.'--'.$line_jump;


mail($fcontactmain_email, $fcontactmain_subject, $message, $header, " -f ".$fcontactmain_senderemail);
?>
