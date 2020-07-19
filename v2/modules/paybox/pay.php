<?php
//if(isset($_GET['page']))
//{
//    if($_GET['page'] == 'payment')
//    {
//        $_SESSION['pay_recap'] = null;
//        $_SESSION['msg_pay_checkPayAmount_right'] = null;
//    }
//}

if(empty($_SESSION['pay_first_load']))
{
    $_SESSION['pay_first_load'] = 'notempty';
    
    $_SESSION['pay_txtPayAmount'] = null;
    
    $_SESSION['msg_pay_checkPayAmount'] = null;
    $_SESSION['msg_pay_checkPayName_wrong'] = null;
    $_SESSION['msg_pay_checkPayEmail_wrong'] = null;
    $_SESSION['msg_pay_checkPayNumCustomer_wrong'] = null;
    $_SESSION['msg_pay_checkPayNumOrder_wrong'] = null;
    
    $_SESSION['pay_bt_confirm'] = null;
    $_SESSION['pay_recap'] = null;
    
    $_SESSION['pay_txtPayName'] = null;
    $_SESSION['pay_txtPayEmail'] = null;
    $_SESSION['pay_txtPayNumCustomer'] = null;
    $_SESSION['pay_txtPayNumOrder'] = null;
    $_SESSION['pay_cboCurrency'] = null;
}

if(isset($_POST['bt_cancel_pay']))
{
    unset($_SESSION['pay_recap_show_order']);
    header('Location: '.$header.$_SESSION['index'].'?page=frontend_main');
}

if(isset($_GET['cleanPaybox']))
{
   if(!empty($_GET['cleanPaybox']) && $_GET['cleanPaybox'] == 'true')
   {
       $_SESSION['pay_recap_show_order'] = 'false';
       
       unset($_SESSION['pay_txtPayName'], $_SESSION['pay_txtPayEmail'],
             $_SESSION['pay_txtPayNumCustomer'], $_SESSION['pay_txtPayNumOrder'],
             $_SESSION['pay_cboCurrency'], $_SESSION['pay_txtPayAmount'], $readonly_txtPayAmount);
   }
}

if(isset($_GET['idorder']))
{
    $id_order = htmlspecialchars($_GET['idorder'], ENT_QUOTES);
    $readonly_txtPayAmount = true;
    if(isset($_GET['addB']))
    {
        $id_address = htmlspecialchars($_GET['addB'], ENT_QUOTES);
    }
    else
    {
        $id_address = null;
    }
    
    try
    {
        $query = $connectData->prepare('SELECT * FROM online_order
                                        WHERE id_order = :id');
        $query->bindParam('id', $id_order);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            
            $_SESSION['pay_txtPayNumOrder'] = $data['number_order'];
            $_SESSION['pay_txtPayAmount'] = $data['amount_order'];
        }
        $query->closeCursor();
        
        if(empty($id_address))
        {
            $query = $connectData->prepare('SELECT * FROM user
                                            INNER JOIN user_real
                                            ON user.id_user = user_real.id_user                                       
                                            WHERE user.id_user = :id');
            $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                if(!empty($data['name_company_real']))
                {
                   $_SESSION['pay_txtPayName'] = $data['name_company_real']; 
                }
                else
                {
                   $_SESSION['pay_txtPayName'] = $data['first_name_real'].' '.$data['name_real'];  
                }

                $_SESSION['pay_txtPayEmail'] = $data['email_user'];
                $_SESSION['pay_txtPayNumCustomer'] = (10100 + $data['id_user']);
            }
            $query->closeCursor();
        }
        else
        {
            $query = $connectData->prepare('SELECT * FROM user_address                                       
                                            WHERE id_address = :address');
            $query->bindParam('address', $id_address);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                if(!empty($data['name_company_address']))
                {
                   $_SESSION['pay_txtPayName'] = $data['name_company_address']; 
                }
                else
                {
                   $_SESSION['pay_txtPayName'] = $data['first_name_address'].' '.$data['last_name_address'];  
                }

                $_SESSION['pay_txtPayEmail'] = $data['email_address'];
                $_SESSION['pay_txtPayNumCustomer'] = (10100 + $data['id_user']);
            }
            $query->closeCursor();
        }
        $_SESSION['payment_id_order'] = $id_order;
        $_SESSION['payment_cart'] = true;
        header('Location: '.$header.$_SESSION['index'].'?page=paybox_recap');
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
    
}

if(isset($_POST['bt_send_pay']))
{
    $name = htmlspecialchars($_POST['txtPayName'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['txtPayEmail'], ENT_QUOTES);
    $num_customer = htmlspecialchars($_POST['txtPayNumCustomer'], ENT_QUOTES);
    $num_order = htmlspecialchars($_POST['txtPayNumOrder'], ENT_QUOTES);
    $currency = htmlspecialchars($_POST['cboCurrency'], ENT_QUOTES);
    $amount = htmlspecialchars($_POST['txtPayAmount'], ENT_QUOTES);
    
    
    $_SESSION['pay_txtPayEmail'] = $email;
    $_SESSION['pay_txtPayNumCustomer'] = $num_customer;
    $_SESSION['pay_txtPayNumOrder'] = $num_order;
    $_SESSION['pay_cboCurrency'] = $currency;
    
    $bok_amount = true;
    $bok_check_amount = false;
    $bok_name = true;
    $bok_email = true;
    $bok_num_customer = true;
    $bok_num_order = true;
    
    // <editor-fold defaultstate="collapsed" desc="Checking Amount">
    $amount = trim($amount);    
    
    $_SESSION['msg_pay_checkPayAmount_wrong'] = null;  
    $_SESSION['pay_bt_confirm'] = null;
    $_SESSION['pay_recap'] = null;
    
    $amount = preg_replace('#[,]#', '.', $amount);
    
    if(!is_numeric($amount))
    {       
        $_SESSION['msg_pay_checkPayAmount_wrong'] = 'Saisissez un format valide (ex: 456.78)';
        $bok_amount = false;
    }
    
    if(empty($amount))
    {
       $_SESSION['msg_pay_checkPayAmount_wrong'] = 'Veuillez indiquer un montant'; 
       $bok_amount = false; 
    }
    
    if(preg_match('#[a-zA-Z]#', $amount))
    {
       $_SESSION['msg_pay_checkPayAmount_wrong'] = 'Saisissez des caractères numériques';
       $bok_amount = false; 
    }
    
    if(strlen($amount) > 15)
    {
       $_SESSION['msg_pay_checkPayAmount_wrong'] = 'Le montant est trop élevé';
       $bok_amount = false;  
    }

    $length_amount = strlen($amount);
    
    $last_int_amount = substr($amount, ($length_amount - 3), 3);

    if($bok_amount == true)
    {
        if(preg_match('#[.,][0-9]{3,}$#', $amount))
        {
            $amount = round($amount, 2);
        }
        
        $amount = strval($amount);
        
        if(preg_match('#[.,][0-9]{2}$#', $amount))
        {

           $j = 0; 
           for($i = 0; $i < strlen($amount); $i++)
           {
               if($amount[$i] == ',' || $amount[$i] == '.' || $amount[$i] == ' ')
               {
                    $comma_point[$j] = $amount[$i];                    
                    $j++;
               }
               
               $split_amount[$i] = $amount[$i];
           }
           
           $j = 0;
           $amount = null;
           for($i = 0; $i < count($split_amount); $i++)
           {
               if($comma_point[$j] == $split_amount[$i] && $j < (count($comma_point) - 1))
               {
                   $amount .= preg_replace('#[., ]#', '', $split_amount[$i]);
                   $j++;
               }
               else
               {
                  $amount .= $split_amount[$i]; 
               }        
           } 
           
           //$_SESSION['msg_pay_checkPayAmount_right'] = 'Vérifiez le montant '.$amount.' € avant de confirmer';
           
        }
        else
        {
           $amount = preg_replace('#[.,]#', '', $amount);
           $amount .= ',00';
           //$_SESSION['msg_pay_checkPayAmount_right'] = 'Vérifiez le montant '.$amount.' € avant de confirmer';
        }
        
        $amount = preg_replace('#[ ]#', '', $amount); 
        $_SESSION['pay_bt_confirm'] = true;
        $bok_check_amount = true;
        
    }
    
    $_SESSION['pay_txtPayAmount'] = trim($amount);
    $amount = floatval($amount);
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Check Name">
    $name = trim($name);
    
    if(is_numeric($name))
    {       
        $_SESSION['msg_pay_checkPayName_wrong'] = 'Nom invalide (ex: Jean Durand)';
        $bok_name = false;
    }
    
    if(empty($name))
    {
        $_SESSION['msg_pay_checkPayName_wrong'] = 'Veuillez indiquer votre nom';
        $bok_name = false;
    }

    if($bok_name == true)
    {
        unset($_SESSION['msg_pay_checkPayName_wrong']);
        
    }
    
    $_SESSION['pay_txtPayName'] = $name;
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Check Email">
    $email = trim($email);
    
    if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $email))
    {
        $_SESSION['msg_pay_checkPayEmail_wrong'] = 'E-mail invalide (ex: durand@yahoo.fr)';
        $bok_email = false;
    }
    
    if(empty($email))
    {
        $_SESSION['msg_pay_checkPayEmail_wrong'] = 'Veuillez indiquer votre e-mail';
        $bok_email = false;
    }

    if($bok_email == true)
    {
        unset($_SESSION['msg_pay_checkPayEmail_wrong']);     
    }
    
    
    
    $_SESSION['pay_txtPayEmail'] = $email;
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Check Customer number">
//    $num_customer = trim($num_customer);
//    
    if(empty($num_customer))
    {
        //$_SESSION['msg_pay_checkPayNumCustomer_wrong'] = 'Veuillez indiquer votre numéro client';
        $bok_num_customer = true;
        $num_customer = '--';
    }
//
//    if($bok_num_customer == true)
//    {
//        unset($_SESSION['msg_pay_checkPayNumCustomer_wrong']);     
//    }
    
    
    
    $_SESSION['pay_txtPayNumCustomer'] = $num_customer;
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Check Order number">
//    $num_order = trim($num_order);
//    
//    if(empty($num_order))
//    {
//        $_SESSION['msg_pay_checkPayNumOrder_wrong'] = 'Veuillez indiquer votre numéro de commande';
//        $bok_num_order = false;
//    }
    if(empty($num_order))
    {
        //$_SESSION['msg_pay_checkPayNumCustomer_wrong'] = 'Veuillez indiquer votre numéro client';
        $bok_num_order = true;
        $num_order = '--';
    }
//
//    if($bok_num_order == true)
//    {
//        unset($_SESSION['msg_pay_checkPayNumOrder_wrong']);     
//    }
//    
    $_SESSION['pay_txtPayNumOrder'] = $num_order;
    // </editor-fold>

    if($bok_check_amount == true && $bok_name == true && $bok_email == true 
            && $bok_num_customer == true && $bok_num_order == true)
    {
        header('Location: '.$header.$_SESSION['index'].'?page=paybox_recap&sendp=true');
    }  
}


?>

<td><form method="post"><TABLE width="100%" border="0">

        

                <td id="center_subtitle">Nom</td>
                <td><input id="<?php if(!empty($_SESSION['msg_pay_checkPayName_wrong'])){ echo('error_input_txt'); }else{ echo(null); } ?>" type="text" name="txtPayName" value="<?php echo(check_session_input($_SESSION['pay_txtPayName'])); ?>"></input></td>
            
            <tr></tr>
            
                <td id="center_subtitle">Email</td>
                <td><input id="<?php if(!empty($_SESSION['msg_pay_checkPayEmail_wrong'])){ echo('error_input_txt'); }else{ echo(null); } ?>" type="text" name="txtPayEmail" value="<?php echo(check_session_input($_SESSION['pay_txtPayEmail'])); ?>"></input></td>

            <tr></tr>
            
                <td id="center_subtitle">Numero Client</td>
                <td><input <?php if(!empty($readonly_txtPayAmount)){ echo('readonly'); }else{ echo(null); } ?> id="<?php// if(!empty($_SESSION['msg_pay_checkPayNumCustomer_wrong'])){ echo('error_input_txt'); }else{ echo(null); } ?>" type="text" name="txtPayNumCustomer" value="<?php echo(check_session_input($_SESSION['pay_txtPayNumCustomer'])); ?>"></input></td>
            
            <tr></tr>
            
                <td id="center_subtitle">Numero Commande</td>
                <td><input <?php if(!empty($readonly_txtPayAmount)){ echo('readonly'); }else{ echo(null); } ?> id="<?php// if(!empty($_SESSION['msg_pay_checkPayNumOrder_wrong'])){ echo('error_input_txt'); }else{ echo(null); } ?>" type="text" name="txtPayNumOrder" value="<?php echo(check_session_input($_SESSION['pay_txtPayNumOrder'])); ?>"></input></td>
            
            <tr></tr>
            
                <td id="center_subtitle">Devise</td> 
                <td><SELECT <?php if(!empty($readonly_txtPayAmount)){ echo('readonly'); }else{ echo(null); } ?> name="cboCurrency">
                        <option value="978">Euro (€)</option>
                    </SELECT>
                </td>
            
            <tr></tr>
            
                <td><span id="center_subtitle">Montant</span></td> 
                <td><input <?php if(!empty($readonly_txtPayAmount)){ echo('readonly'); }else{ echo(null); } ?> id="<?php if(!empty($_SESSION['msg_pay_checkPayAmount_wrong'])){ echo('error_input_txt'); }else{ echo(null); } ?>" type="text" name="txtPayAmount" value="<?php echo(check_session_input($_SESSION['pay_txtPayAmount'])); ?>"></input>
                    &nbsp;
                    <span id="center_text" style="font-size: 10px; vertical-align: middle;">(Exemple: 1235.67)</span>     
                </td>
          
            <tr></tr>
            
            <td></td>
            <td><?php if(@$_SESSION['msg_pay_checkPayAmount_wrong'] != null){ ?><div id="pay_msg_wrong"><span id="msg_pay_wrong">&nbsp;&nbsp;<?php echo(check_session_input($_SESSION['msg_pay_checkPayAmount_wrong'])); ?></span></div><?php } ?>
                <?php if(@$_SESSION['msg_pay_checkPayName_wrong'] != null){ ?><clear right><div id="pay_msg_wrong"><span id="msg_pay_wrong">&nbsp;&nbsp;<?php echo(check_session_input($_SESSION['msg_pay_checkPayName_wrong'])); ?></span></div></clear><?php } ?>
                <?php if(@$_SESSION['msg_pay_checkPayEmail_wrong'] != null){ ?><clear right><div id="pay_msg_wrong"><span id="msg_pay_wrong">&nbsp;&nbsp;<?php echo(check_session_input($_SESSION['msg_pay_checkPayEmail_wrong'])); ?></span></div></clear><?php } ?>
                
            </td>
            <tr></tr>

            <tr><td colspan="2"><hr color="grey" size="1"></hr></td></tr>
            
            <td></td>
            <td>
                <input type="submit" name="bt_send_pay" value="Envoyer"></input>
                &nbsp;
                </form>
                <input type="submit" name="bt_cancel_pay" value="Annuler"></input>
            </td>
            

     
</TABLE></form></td>


