<?php
include('modules/email/send/admin/mailing/email_getinfo.php');

$header = 'MIME-Version: 1.0'.$line_jump;
$header .= 'From: '.$usermailing_sendername.' <'.$usermailing_senderemail.'>'.$line_jump;
$header .= 'Bcc: '.$usermailing_bcc.$line_jump;
$header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$header .= 'Return-path: <'.$usermailing_senderemail.'>'.$line_jump;
$header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$usermailing_boundary.'"'.$line_jump;

#Message content in text/html
$message .= '--'.$usermailing_boundary.$line_jump;
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

if($usermailing_typemsg == 'existing')
{
    #header   
    if(!empty($usermailing_part1))
    {
        $message .= '<tr>
                        <td>
                        '.$usermailing_part1.'
                        </td>
                     </tr>';
    }

    #main script
    if(!empty($usermailing_script))
    {
        include($usermailing_script);
    }

    #bottom
    if(!empty($usermailing_part2))
    {
        $message .= '<tr>
                        <td>
                        '.$usermailing_part2.'
                        </td>
                     </tr>';
    }
}
else
{
    $message .= '<tr>
                    <td>
                    '.$usermailing_message.'
                    </td>
                 </tr>';
}

#signature
if(!empty($usermailing_signature))
{
    $message .= '<tr>
                    <td>
                    '.$usermailing_signature.'
                    </td>
                 </tr>';
}

#signature script
if(!empty($usermailing_signature_script))
{
    include($usermailing_signature_script);
}

$message .= '</table>
             </body>
             </html>'.$line_jump;
$message .= '--'.$usermailing_boundary.'--'.$line_jump;


mail($usermailing_senderemail, $usermailing_subject, $message, $header, " -f ".$usermailing_senderemail);
?>
