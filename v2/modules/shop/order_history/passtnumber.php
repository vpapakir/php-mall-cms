<?php
/*include('../../config.php');
include_once('../../function.php');
include('../../dbconnect.php');
include('../../language_link_switcher.php');
include('../../section_call.php');
include('../../login_autorisation.php');
include('../../header_refresh.php');*/

if(!isset($_SESSION)) 
{
	session_start(); 
} else {
	echo "Session is already started";
}

//$tnumber = ($_GET['tnumber']) ? $_GET['tnumber'] : $_POST['tnumber'];
//$ordid = ($_GET['ordid']) ? $_GET['ordid'] : $_POST['ordid'];

$tnumber = "sample";
$ordid = $_GET['ordid'];

if((!isset($_POST['tnumber']))) {
	echo "Error on posting the new tracking number. Setting it to 9999...";
	$tnumber = 9999;
} else {
	$tnumber = $_POST['tnumber'];
}

if( (empty($tnumber)) || (strcmp($tnumber,"0") == 0) || (strcmp($tnumber,"tracking number") == 0) ) {
	$tnumber = 9999;
}

$_SESSION['tnumber'] = $tnumber;

/*try
{
	$query = $connectData->prepare('INSERT INTO tracking
                                            (id_tracking, id_order, number_tracking)
                                            VALUES
                                            (:idtr, :orderid, :tracknum)');

	$query->execute(array(
                                  'idtr' => htmlspecialchars($ordid, ENT_QUOTES, 'UTF-8'),
                                  'orderid' => htmlspecialchars($ordid, ENT_QUOTES, 'UTF-8'),
                                  'tracknum' => htmlspecialchars($_SESSION['tnumber'], ENT_QUOTES, 'UTF-8')                                      
                                  ));
	$query->closeCursor();
	echo "Data OK";
} catch (Exception $e) {
	die("<br>Error : ".$e->getMessage());
}*/

echo $tnumber;

echo "\n";

echo $_SESSION['tnumber'];

$con = mysql_connect("localhost","francepurdb","Fp0248Lx");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("francepurification", $con);

//$ttnumber = mysql_real_escape_string($tnumber);
$sql = "INSERT INTO tracking (id_tracking, id_order, number_tracking) VALUES ('".htmlspecialchars($ordid, ENT_QUOTES, 'UTF-8')."', '".htmlspecialchars($ordid, ENT_QUOTES, 'UTF-8')."','".$tnumber."') ON DUPLICATE KEY UPDATE id_order=values(id_order), number_tracking=values(number_tracking) ";

$resvar = mysql_query($sql);

if($resvar) {
	mysql_close($con);
	echo "Tracking number "./*$_SESSION['tnumber']*/$tnumber." stored for order: ".$ordid;
} else {
	echo $sql."\n".mysql_error();
}

//$_SESSION['tnumber'] = "sample";

/*$line_jump = "\n";

$sent_order_boundary = md5(rand());

$subject = 'Expedition commande no. '.$number_sent_order;

$subject = utf8_decode($subject);

$content_message_sent_order = 'Chere cliente, Cher client'.$line_jump.$line_jump.
                               'Nous avons expedie votre commande no. '.$number_sent_order.' aujourd\'hui'.$line_jump.
                               'Toutefois, si au bout de 7 jours ouvres, vous n\'avez toujours pas recu cette derniere, veuillez nous contacter.'.$line_jump.$line_jump.
                               'Merci de votre confiance et de ne pas repondre a ce mail.'.$line_jump.
                               'Envoye le: '.date('d-m-Y a H:i', time());

$content_message_sent_order = wordwrap($content_message_sent_order, 70);

$mailing_header = 'MIME-Version: 1.0'.$line_jump;
$mailing_header .= 'From: '.$author.' <'.$used_mail_adress.'>'.$line_jump;
$mailing_header .= 'Bcc: '.$used_mail_cc.$line_jump;
$mailing_header .= 'X-Mailer: PHP/'.phpversion().$line_jump;
$mailing_header .= 'Return-path: <'.$used_mail_adress.'>'.$line_jump;
//$mailing_header .= "Cc: ".$mail_destination.$line_jump;
$mailing_header .= 'Content-Type: multipart/alternative;'.$line_jump.' boundary="'.$sent_order_boundary.'"'.$line_jump;


#Message content in text/plain
$message = '--'.$sent_order_boundary.$line_jump;
$message .= 'Content-Type: text/plain; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= $content_message_sent_order.$line_jump;
//$message .= $mail_address.$line_jump;

#Message content in text/html
$message .= '--'.$sent_order_boundary.$line_jump;
$message .= 'Content-Type: text/html; charset="UTF-8"'.$line_jump;
$message .= 'Content-Transfer-Encoding: 8bit'.$line_jump;
$message .= $line_jump;
$message .= '<HTML>
    
    <HEAD>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </HEAD>
    
    <BODY style="background-color: white;">
     
        <TABLE align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">
   
                <td>
                   Chere cliente, Cher client
                </td>
                
            <tr style="height: 8px;"></tr>
            
                <td>
                    Vous avez un nouveau message du site <span style="color: '.$company_color.'">'.$sitename.'</span>
                </td>
                
            <tr style="height: 8px;"></tr>

                <td>
                    Nous avons expedie votre commande no. '.$number_sent_order.' aujourd\'hui
                </td>
           
            <tr></tr>
            
                <td>
                    Toutefois, si au bout de 7 jours ouvres, vous n\'avez toujours pas recu cette derniere, veuillez nous contacter via les coordonnees que vous trouverez en bas de cet email.
                </td>

            <tr style="height: 8px;"></tr>

                <td>
                    Merci de votre confiance et de ne pas repondre a ce mail.
                </td>
  
            '.$signature.'

        </TABLE>
     
    </BODY>

</HTML>'.$line_jump;
$message .= '--'.$sent_order_boundary.'--'.$line_jump;

mail($email_sent_order, $form_pay_accepted.' '.$subject, $message, $mailing_header, " -f ".$used_mail_adress);*/

echo '
<script type="text/javascript" language="javascript">
window.close();
</script>
';

//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>