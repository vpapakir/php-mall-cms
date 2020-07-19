<?php
include('modules/custom/immo/modules/email/send/admin/propose_property/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$fproposep_sendername.' <'.$fproposep_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$fproposep_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$fproposep_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$fproposep_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$fproposep_boundary.$line_jump;
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
if(!empty($fproposep_part1))
{
    $message .= '<tr>
                    <td>
                    '.$fproposep_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($fproposep_script))
{
    include($fproposep_script);
}

#bottom
if(!empty($fproposep_part2))
{
    $message .= '<tr>
                    <td>
                    '.$fproposep_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($fproposep_signature))
{
    $message .= '<tr>
                    <td>
                    '.$fproposep_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($fproposep_signature_script))
{
    include($fproposep_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$fproposep_boundary.'--'.$line_jump;


mail($config_email_senderemail, $fproposep_subject, $message, $header, " -f ".$fproposep_senderemail);
?>
