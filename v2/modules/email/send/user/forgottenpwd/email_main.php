<?php
include('modules/email/send/user/forgottenpwd/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$forgottenpwd_confirm_sendername.' <'.$forgottenpwd_confirm_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$forgottenpwd_confirm_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$forgottenpwd_confirm_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$forgottenpwd_confirm_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$forgottenpwd_confirm_boundary.$line_jump;
$message .= 'Content-Type: text/html; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= '<HTML>
    
            <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
    
            <body style="background-color: white;">

                <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">';

#header   
if(!empty($forgottenpwd_confirm_part1))
{
    $message .= '<tr>
                    <td>
                    '.$forgottenpwd_confirm_part1.'
                    </td>
                 </tr>';
}

#main script
if(!empty($forgottenpwd_confirm_script))
{
    include($forgottenpwd_confirm_script);
}

#bottom
if(!empty($forgottenpwd_confirm_part2))
{
    $message .= '<tr>
                    <td>
                    '.$forgottenpwd_confirm_part2.'
                    </td>
                 </tr>';
}

#signature
if(!empty($forgottenpwd_confirm_signature))
{
    $message .= '<tr>
                    <td>
                    '.$forgottenpwd_confirm_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($forgottenpwd_confirm_signature_script))
{
    include($forgottenpwd_confirm_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$forgottenpwd_confirm_boundary.'--'.$line_jump;


mail($forgottenpwd_email, $forgottenpwd_confirm_subject, $message, $header, " -f ".$forgottenpwd_confirm_senderemail);

unset($message, $header);
unset($forgottenpwd_confirm_sendername, $forgottenpwd_confirm_senderemail,
            $forgottenpwd_confirm_bcc, $forgottenpwd_confirm_script, $forgottenpwd_confirm_idsignature,
            $forgottenpwd_confirm_subject, $forgottenpwd_confirm_part1, $forgottenpwd_confirm_part2,
            $forgottenpwd_confirm_signature, $forgottenpwd_confirm_signature_script); 
?>
