<?php
if(isset($_POST['bt_cancel_pay_paybox']))
{
    if(!empty($_SESSION['payment_cart']) && $_SESSION['payment_cart'] === true)
    {
        header('Location: '.$header.$_SESSION['index'].'?page=cart_view');
    }
    else
    {
        header('Location: '.$header.$_SESSION['index'].'?page=payment');
    }
}



$name = $_SESSION['pay_txtPayName'];
$email = $_SESSION['pay_txtPayEmail'];
$num_customer = $_SESSION['pay_txtPayNumCustomer'];

try
{
    $prepared_query = 'SELECT number_order_history FROM order_history
                       ORDER BY number_order_history ASC';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    while($data = $query->fetch())
    {
        $num_order = $data[0];           
    }
    $query->closeCursor();

    $num_order++;
    
    $_SESSION['pay_txtPayNumOrder'] = $num_order;
}
catch(Exception $e)
{
   die('<br>Error: '.$e->getMessage()); 
}

if(isset($_GET['sendp']))
{
    $num_order = $_SESSION['pay_txtPayNumOrder'];
    $_SESSION['pay_txtPayNumOrder'] = $num_order;
}

$currency = /*$_SESSION['pay_cboCurrency']*/978;
$amount = $_SESSION['pay_txtPayAmount'];
$amount = convert_to_cent($amount);

if(empty($_SESSION['pay_recap']))
{
    $_SESSION['pay_recap'] = 'notempty';
    
    try
    {
        $query = $connectData->prepare('INSERT INTO payment
                                                  (name_payment, email_user,
                                                   customer_number_user, order_number_payment,
                                                   currency_payment, amount_payment)
                                        VALUES(:name, :email, :num_customer, :num_order,
                                               :currency, :amount)');

        $query->execute(array(
                              'name' => htmlspecialchars($name, ENT_QUOTES),
                              'email' => htmlspecialchars($email, ENT_QUOTES),
                              'num_customer' => htmlspecialchars($num_customer, ENT_QUOTES),
                              'num_order' => htmlspecialchars($num_order, ENT_QUOTES),
                              'currency' => htmlspecialchars($currency, ENT_QUOTES),
                              'amount' => htmlspecialchars($amount, ENT_QUOTES)
                              ));
        $query-> closeCursor(); 
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }      
}

try
{
    $query = $connectData->prepare('SELECT id_payment 
                                        FROM payment
                                        WHERE email_user = :email');

    $query->bindParam('email', htmlspecialchars($email, ENT_QUOTES));

    $query->execute();

    while($data = $query->fetch())
    {
        $file_number = $data[0];   
    }
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}
$query-> closeCursor();

if(isset($_POST['bt_confirm_pay']))
{
    $id_order = $_SESSION['payment_id_order'];
    
    try
    {


       $query = $connectData->prepare('UPDATE online_order SET status_order = \'waiting payment\' 
                                       WHERE id_order = :order');
       $query->bindParam('order', htmlspecialchars($id_order, ENT_QUOTES));
       $query->execute();
       $query->closeCursor();
        
        unset($_SESSION['pay_txtPayName'], $_SESSION['pay_txtPayEmail'],
              $_SESSION['pay_txtPayNumCustomer'], $_SESSION['pay_txtPayNumOrder'],
              $_SESSION['pay_cboCurrency'], $_SESSION['pay_txtPayAmount']);
        
        
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
}

if(file_exists('finance/paylist/paybox'.$file_number))
{
   $file = fopen('finance/paylist/paybox'.$file_number, 'r+'); 
}
else
{
   $file = fopen('finance/paylist/paybox'.$file_number, 'w+'); 
   $test2 = chmod($path_file, octdec('777'));
}

$path_file = 'finance/paylist/paybox'.$file_number;

$path_paybox = '/var/www/francepurification/finance/paylist/paybox'.$file_number;

$test2 = chmod($path_file, octdec('777'));


$test = file_perms($path_file, false);

$file = fopen($path_file, 'w+');
   
   
fputs($file, 'PBX_SITE=1533071'. "\n");
fputs($file, 'PBX_RANG=01'. "\n");
fputs($file, 'PBX_IDENTIFIANT=522884403'. "\n");

fputs($file, 'PBX_TOTAL='.$amount. "\n");
fputs($file, 'PBX_DEVISE='.$currency. "\n");
fputs($file, 'PBX_CMD='.$num_order. "\n");
fputs($file, 'PBX_PORTEUR='.$email. "\n");

fputs($file, 'PBX_RETOUR=montant:M;ref:R;auto:A;trans:T'. "\n");

fputs($file, 'PBX_EFFECTUE=http://france-purification.com/index.php?page=accepted'. "\n");
fputs($file, 'PBX_REFUSE=http://france-purification.com/index.php?page=refused'. "\n");
fputs($file, 'PBX_ANNULE=http://france-purification.com/index.php?page=cancelled');

fclose($file);

?>


<td align="center"><form method="post" action="/cgi-bin/modulev2.cgi"><div style="border: 1px solid grey; width: 60%; padding: 9px;">
        <TABLE width="100%" border="0">
                  
            
                        
                    <td id="center_subtitle">Nom</td>
                    <td id="center_intro" align="right"><span><?php echo(check_session_input($_SESSION['pay_txtPayName'])); ?></span>&nbsp;</td>

                <tr></tr>

                    <td id="center_subtitle">Email</td>
                    <td id="center_intro" align="right"><span><?php echo(check_session_input($_SESSION['pay_txtPayEmail'])); ?></span>&nbsp;</td>

                <tr></tr>

                    <td id="center_subtitle">Numero Client</td>
                    <td id="center_intro" align="right"><span><?php echo(check_session_input($_SESSION['pay_txtPayNumCustomer'])); ?></span>&nbsp;</td>

                <tr></tr>

                    <td id="center_subtitle">Numero Commande</td>
                    <td id="center_intro" align="right"><span><?php echo(check_session_input($_SESSION['pay_txtPayNumOrder'])); ?></span>&nbsp;</td>

<!--                <tr></tr>-->

<!--                    <td id="center_subtitle">Devise</td> 
                    <td id="center_text" align="right"><span><?php echo('Euro (€)'); ?></span>&nbsp;</td>-->
                
                <tr></tr>

                    <td><span id="center_subtitle">Montant</span></td> 
                    <td id="center_intro" align="right"><span><?php echo(number_format(check_session_input($_SESSION['pay_txtPayAmount']), 2, '.', '').' Euro'); ?></span>&nbsp;</td> 
                 
                <tr></tr>
                
                    <td></td>
                    <td><input type="hidden" name="PBX_MODE" value="13"></input>
                        <input type="hidden" name="PBX_OPT" value="<?php echo($path_paybox); ?>"></input>
                        <input type="hidden" name="PBX_OUTPUT" value="E"></input>   
                    </td>
                  
        </TABLE>
</div></td>

<tr></tr>

<td>
    <TABLE width="100%" border="0">

            <td width="50%" align="right">
                <input type="submit" name="bt_confirm_pay" value="Confirmer"></input>
                &nbsp; 
                
            </td>
            
            </form>
   
            <form method="post"><td><input type="submit" name="bt_cancel_pay_paybox" value="Corriger"></input></td></form>

    </TABLE>
</td>



