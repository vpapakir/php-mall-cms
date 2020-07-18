<?php
if(!empty($_SESSION['login_id']))
{
    $query = $connectData->prepare('SELECT user.*, user_real.* 
                                    FROM user
                                    INNER JOIN user_real ON user.id_user = user_real.id_user
                                    WHERE user.id_user = :id');

    $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $cart_type_real = $data['type_real'];
        $cart_bonus_real = $data['bonus_real'];
        $cart_delay_real = $data['cash_delay_real'];
        $cart_discount_real = $data['cash_discount_real'];
        $group_destination_real = $data['group_shipping_real'];
    }
    else
    {
        $group_destination_real = '1,3,5,6';
    }
    $query->closeCursor();
    
    include('transport/allowed_destination/cart_destination.php');
}


if(!empty($_SESSION['login_id']) 
        && (!empty($_SESSION['block_cart_default_msg']) && $_SESSION['block_cart_default_msg'] === 'opencart'))
{
    include('cart/cart_listing.php');
    
    try
    {
        $query = $connectData->prepare('SELECT * 
                                        FROM online_order
                                        WHERE id_user = :id AND id_order = :order');

        $query->execute(array(
                              'id' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                              'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                              ));

        if(($data = $query->fetch()) != false)
        {
            $number_order = $data['number_order'];
            $id_bonus = $data['id_bonus'];
        }
        $query->closeCursor();
    }
    catch (Exception $e)
    {
       die("<br>Error : ".$e->getMessage());
    }
}
$count_items = null;
//$qty[] = null;

if(empty($id_product[0]))
{
   unset($_SESSION['block_cart_default_msg']);
   try
   {
       $query = $connectData->prepare('UPDATE online_order SET status_order = \'cross clicked\'
                                       WHERE id_user = :user AND id_order = :order');

       $query->execute(array(
                             'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                             'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                             ));
       $query->closeCursor();
   }
   catch (Exception $e)
   {
       die("<br>Error : ".$e->getMessage());
   }
}

if(!empty($id_product[0]) && $id_product[0] != null)
{
    try
    {
        for($i = 0; $i < count($id_product); $i++)
        {   
            if(isset($_POST[('bt_choose_QtyCart'.$i)]))
            {
                $selected_qty = $_POST['cboQtyCart'.$i];

                if($selected_qty != 0)
                {
                    $qty[$i] = $selected_qty;
                    $count_items += $qty[$i];

                    $query = $connectData->prepare('UPDATE cart SET qty_product_cart = :qty
                                                    WHERE id_order = :order AND id_user = :user
                                                    AND id_product = :product');

                    $query->execute(array(
                                          'qty' => htmlspecialchars($qty[$i], ENT_QUOTES),
                                          'order' => htmlspecialchars($last_id_order, ENT_QUOTES),
                                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                          'product' => htmlspecialchars($id_product[$i], ENT_QUOTES)
                                          ));
                    $query->closeCursor();
                }
                else
                {
                    $query = $connectData->prepare('DELETE FROM cart 
                                                    WHERE id_order = :order AND id_user = :user
                                                    AND id_product = :product');

                    $query->execute(array(
                                          'order' => htmlspecialchars($last_id_order, ENT_QUOTES),
                                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                          'product' => htmlspecialchars($id_product[$i], ENT_QUOTES)
                                          ));
                    $query->closeCursor();

                    header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect']);
                }
            }
            else
            {
               $count_items += $qty[$i];
            }
        }

        $query = $connectData->prepare('SELECT country.id_country, name_country_L1 
                                        FROM user
                                        INNER JOIN country ON user.id_country = country.id_country
                                        WHERE id_user = :user');
        $query->bindParam('user', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
        $query->execute();

        if(($data = $query->fetch()))
        {
            $country_destination = $data['name_country_L1'];
            $id_country_destination = $data[0];
        }
        $query->closeCursor();
    
   }
   catch (Exception $e)
   {
       die("<br>Error : ".$e->getMessage());
   }
}

//$total_weigth = 0.00;
//$total_destination = null;
//$cart_prepare_query = null;

for($i = 0; $i < count($id_product); $i++)
{   
    if($i == 0)
    {
        $total_weigth = null;
    }
    
    if(empty($_SESSION['cart_cboDestination']))
    {
        try
        {
            for($x = 0; $x < count($group_destination_real); $x++)
            {
                if($x == 0)
                {
                   if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                   { 
                       $prepared_query = 'SELECT * FROM shipping_destination_reseller WHERE id_destination_shipping = '.$group_destination_real[$x];
                   }
                   else
                   {
                       $prepared_query = 'SELECT * FROM shipping_destination WHERE id_destination_shipping = '.$group_destination_real[$x];
                   }
                   
                }
                else
                {
                   $prepared_query .= ' OR id_destination_shipping = '.$group_destination_real[$x]; 
                } 
            }
            
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $selected_destination = $data[0];
            }
            $query->closeCursor();
            
            $_SESSION['cart_cash_discount_ok'] = true;
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }
    }
    else
    {
        if(isset($_POST['bt_choose_destination']))
        {
            $selected_destination = $_POST['cboDestination'];
        }
        else
        {
            $selected_destination = $_SESSION['cart_cboDestination'];
        }   
    }
     

    try
    {

        $cart_prepare_query = 'SELECT weigth_details FROM product_details WHERE id_product = '.$id_product[$i]; 

        $query = $connectData->prepare($cart_prepare_query);
        $query->execute();

        while($data = $query->fetch())
        {
            $total_weigth += $qty[$i] * $data[0]; 
        }

        $query->closeCursor();

        $_SESSION['cart_cboDestination'] = $selected_destination;
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }

}

try
{
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        $query = $connectData->prepare('SELECT shipping_reseller.*
                                        FROM shipping_reseller
                                        WHERE id_destination_shipping = :id
                                        AND min_shipping
                                        BETWEEN 1
                                        AND :weigth = 1
                                        ORDER BY min_shipping');
        $query->execute(array(
                              'id' => htmlspecialchars($selected_destination, ENT_QUOTES),
                              'weigth' => htmlspecialchars($total_weigth, ENT_QUOTES)
                              ));

        while($data = $query->fetch())
        {
            $total_destination = $data['fee_shipping']; 
        }
        $query->closeCursor();

        $query = $connectData->prepare('SELECT *
                                        FROM shipping_destination_reseller
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($selected_destination, ENT_QUOTES));
        $query->execute();

        while($data = $query->fetch())
        {
            $name_destination = $data['name_destination_shipping'];
            $pickup_destination = $data['pickup_destination_shipping'];
            $online_payment_destination = $data['payment_destination_shipping'];
        }
        $query->closeCursor();

        $query = $connectData->prepare('SELECT *
                                        FROM shipping_special_reseller
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($selected_destination, ENT_QUOTES));
        $query->execute();


        if(($data = $query->fetch()) == false)
        {
            $BoK_special_shipping = false;
        }
        else
        {
            $BoK_special_shipping = true;
            $query->execute();
            while($data = $query->fetch())
            {
                $type_special_shipping = $data['type_special_shipping'];
                $value_special_shipping = $data['value_special_shipping'];
            }
        }
    }
    else
    {
        $query = $connectData->prepare('SELECT shipping.*
                                        FROM shipping
                                        WHERE id_destination_shipping = :id
                                        AND min_shipping
                                        BETWEEN 1
                                        AND :weigth = 1
                                        ORDER BY min_shipping');
        $query->execute(array(
                              'id' => htmlspecialchars($selected_destination, ENT_QUOTES),
                              'weigth' => htmlspecialchars($total_weigth, ENT_QUOTES)
                              ));

        while($data = $query->fetch())
        {
            $total_destination = $data['fee_shipping']; 
        }
        $query->closeCursor();

        $query = $connectData->prepare('SELECT *
                                        FROM shipping_destination
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($selected_destination, ENT_QUOTES));
        $query->execute();

        while($data = $query->fetch())
        {
            $name_destination = $data['name_destination_shipping'];
            $pickup_destination = $data['pickup_destination_shipping'];
            $online_payment_destination = $data['payment_destination_shipping'];
        }
        $query->closeCursor();

        $query = $connectData->prepare('SELECT *
                                        FROM shipping_special
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($selected_destination, ENT_QUOTES));
        $query->execute();


        if(($data = $query->fetch()) == false)
        {
            $BoK_special_shipping = false;
        }
        else
        {
            $BoK_special_shipping = true;
            $query->execute();
            while($data = $query->fetch())
            {
                $type_special_shipping = $data['type_special_shipping'];
                $value_special_shipping = $data['value_special_shipping'];
            }
        }
    }
    

    $query->closeCursor(); 
    
    $query = $connectData->prepare('SELECT *
                                    FROM tax
                                    WHERE id_destination_shipping = :id');
    $query->bindParam('id', htmlspecialchars($selected_destination, ENT_QUOTES));
    $query->execute();

    while($data = $query->fetch())
    {
        $tax_percent = $data['value_tax'];
    }
    
    $value_tax = $tax_percent / 100;
    
    $tax_percent = number_format($tax_percent, 2, '.', '');

    $query->closeCursor(); 
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}


if(!empty($id_product[0]) && $id_product[0] != null)
{
    $super_total = null;
    $eco_taxe = null;
    $total_product_net = null;
    
    if($count_items == 1)
    {
        $item = 'article';
    }
    else
    {
        $item = 'articles';
    }
    
    for($i = 0; $i < count($id_product); $i++)
    { 
       try
        {
            $query = $connectData->prepare('SELECT product.*, product_details.* 
                                            FROM product
                                            INNER JOIN product_details ON product.id_product = product_details.id_product
                                            WHERE product.id_product = :id');
            
            $query->bindParam('id', htmlspecialchars($id_product[$i], ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $price_resale_cart = $data['price_resale_details'];
                $price_promo_cart = $data['price_promo_details'];            
            }
            $query->closeCursor();
            
            if($cart_bonus_real > 0)
            {
                //$price_resale_cart = $price_resale_cart - ($price_resale_cart * ($cart_bonus_real/100)); 
                $price_bonus_cart = $price_resale_cart - ($price_resale_cart * ($cart_bonus_real/100)); 
                $price_bonus_cart = number_format($price_bonus_cart, 2, '.', '');
            }
            else
            {
                $price_bonus_cart = null;
            }

            $price_resale_cart = number_format($price_resale_cart, 2, '.', '');
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        } 
        
       if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
       {
           if($cart_bonus_real > 0)
           {
               $super_total += $qty[$i] * $price_bonus_cart;
               $total_product_net += $qty[$i] * $price_bonus_cart;
           }
           else
           {
               $super_total += $qty[$i] * $price_resale_cart;
               $total_product_net += $qty[$i] * $price_resale_cart;
           }
           
           //$super_total = number_format($super_total, 2);
           $eco_taxe += $ecotaxe_product_cart[$i] * $qty[$i];
           $eco_taxe = number_format($eco_taxe, 2, '.', '');
           
           $discount_ht = $total_product_net * ($cart_discount_real/100); 
           $discount_ht = number_format($discount_ht, 2, '.', '');
           
           
       }
       else
       {
           if($price_promo_cart > 0.00)
           {
              $super_total += $qty[$i] * $price_promo_cart;
              $total_product_net += $qty[$i] * $price_promo_cart;
           }
           else
           {
              $super_total += $qty[$i] * $price_public_cart[$i]; 
              $total_product_net += $qty[$i] * $price_public_cart[$i];
           }          
           $eco_taxe += $ecotaxe_product_cart[$i] * $qty[$i];
           $eco_taxe = number_format($eco_taxe, 2, '.', '');          
       }

       
    }
    
    

    if(($cart_type_real == 'public' || $_SESSION['login_id'] > 9000000) && $type_special_shipping == 'freeshippingEuro' && $super_total >= $value_special_shipping && $BoK_special_shipping == true)
    {
       $total_destination = 0; 
       $msg_free_shipping = 'Les frais de port vous sont offerts';
    }
    else
    {
       if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && $type_special_shipping == 'freeshippingEuro' && $super_total >= $value_special_shipping && $BoK_special_shipping == true)
       {
           $total_destination = 0; 
           $msg_free_shipping = 'Les frais de port vous sont offerts';
       }
       else
       {
           $msg_free_shipping = null; 
       }
    }
    
        
    $super_total_net = null;
    
    if(!empty($_SESSION['cart_total_discount']))
    {
        $super_total_net = $super_total - ($super_total * $value_tax);        
        $super_total_net = $super_total_net - $_SESSION['cart_total_discount'];        
    }
    else
    {
        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
        {
            //$super_total_net = $super_total / (1+$value_tax);
        }
        else
        {
            $super_total_net = $super_total - ($super_total * $value_tax);
        } 
    }

    if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true))
    {
        
//       if($type_special_shipping == 'freeshippingEuro' && $super_total >= $reseller_freeshipping)
//       {
//           $total_destination2 = 0;
//           $msg_free_shipping = 'Les frais de port vous sont offerts';
//       }
//       else
//       {
           $total_destination2 = $total_destination / (1 + $value_tax);          
//       }
       
       $eco_taxe_reseller = $eco_taxe / (1 + $value_tax);
       $super_total += $eco_taxe_reseller;
    }
    else
    {
       $total_destination2 = $total_destination; 
    }
    
    $super_total += $total_destination2;

    
           
    
    if(!empty($_SESSION['cart_total_discount']))
    {
        $super_total = $super_total - $_SESSION['cart_total_discount'];        
    }      
    
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {  
        if(!empty($_SESSION['cart_total_discount']))
        {
           $vat_taxe = ($super_total * $value_tax) - ($_SESSION['cart_total_discount'] * $value_tax); 
        }
        else
        {
           $vat_taxe = $super_total * $value_tax; 
        }
        $vat_taxe = number_format($vat_taxe, 2, '.', '');
        $super_total += $vat_taxe;
    }
    else
    {

        $super_total_net = $super_total / (1+$value_tax);
        $vat_taxe = $super_total_net * $value_tax;

        
    }
    
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        $super_total_net = $super_total / (1+$value_tax);
        
        if(!empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
        {
           $super_total_net -= $discount_ht;
           $super_total = $super_total_net * (1+$value_tax);
           $vat_taxe = $super_total - $super_total_net;
        }
    }
    
    $super_total_net = number_format($super_total_net, 2, '.', '');
    $super_total = number_format($super_total, 2, '.', '');
    $vat_taxe = number_format($vat_taxe, 2, '.', '');
    $total_product_net = number_format($total_product_net, 2, '.', '');
}

//if(isset($_POST['bt_check_bonus_cart']) || !empty($_SESSION['cart_discount_code']))
//{
//    $discount_code = trim(htmlspecialchars($_POST['txtCodeBonus'], ENT_QUOTES));
//    
//    if(isset($_POST['bt_check_bonus_cart']))
//    {
//        $_SESSION['cart_discount_code'] = $discount_code;
//    }
//    
//    $discount_cart = check_code_bonus($_SESSION['cart_discount_code']);
//    
//    if($discount_cart[0] === false)
//    {
//        $_SESSION['msg_cart_bonus'] = 'Code invalide';
//        $total_discount = null;
//        unset($_SESSION['cart_total_discount']);
//    }
//    else
//    {
//        unset($_SESSION['msg_cart_bonus']);
//        
//        if($_SESSION['login_id'] != $discount_cart[5])
//        {
//           $_SESSION['msg_cart_bonus'] = 'Code invalide';
//           $total_discount = null;
//           unset($_SESSION['cart_total_discount']);
//        }
//        else
//        {
//            if($discount_cart[3] != 0)
//            {
//                $discount_percent = $discount_cart[3];
//                $total_discount = $total_product_net * ($discount_percent/100);
//                $_SESSION['cart_total_discount'] = $total_discount;
//            }
//            else
//            {
//                $discount_percent = null;
//            }
//
//            if($discount_cart[4] != 0)
//            {
//                $discount_money = $discount_cart[4];
//                $total_discount = $total_product_net - $discount_money;
//                $_SESSION['cart_total_discount'] = $total_discount;
//            }
//            else
//            {
//                $discount_money = null;
//            }
//            
//            if($discount_cart[3] == 0 && $discount_cart[4] == 0)
//            {
//                unset($_SESSION['cart_total_discount']); 
//            }
//        } 
//    }
//}

if(isset($_POST['bt_rad_choose_payment_mode']) || !empty($_SESSION['cart_rad_payment_mode']))
{
    if(!empty($_SESSION['cart_rad_payment_mode']) && !isset($_POST['bt_rad_choose_payment_mode']))
    {
       $rad_payment_mode = $_SESSION['cart_rad_payment_mode'];
    }
    else
    {
       $rad_payment_mode = htmlspecialchars($_POST['rad_payment_mode'], ENT_QUOTES);
       header('Location: '.$header.$_SESSION['index'].'?page=cart_view');
    }
    
    $_SESSION['cart_rad_payment_mode'] = $rad_payment_mode;
    
    if($rad_payment_mode == 'cash')
    {
        $_SESSION['cart_cash_discount_ok'] = true;
    }
    else
    {
        unset($_SESSION['cart_cash_discount_ok']);
    }
    
    
}
?>
