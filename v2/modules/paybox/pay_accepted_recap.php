<?php
if(empty($_SESSION['pay_recap_show_order']))
{
    if(empty($_SESSION['order_accepted_first_loading']))
    {


        include('cart/cart_operation.php'); 
    }

    try
    {
        $query = $connectData->prepare('SELECT number_order_history FROM order_history
                                        WHERE id_user = :user
                                        ORDER BY number_order_history ASC');
        $query->bindParam('user', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
        $query->execute();

        while($data = $query->fetch())
        {
            $number_order = $data[0];           
        }
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }


    if(empty($_SESSION['order_accepted_first_loading']))
    {
    //    if(isset($_GET['montant']))
    //    {        
        try
        { 
            $query = $connectData->prepare('SELECT number_order_history FROM order_history
                                            ORDER BY number_order_history ASC');
            $query->execute();

            while($data = $query->fetch())
            {
                $number_order = $data['number_order_history'];           
            }
            $query->closeCursor();

            $number_order++;



            #set status order to paid in database
    //        $query = $connectData->prepare('UPDATE online_order SET status_order = \'paid\'
    //                                           WHERE id_user = :user AND id_order = :order');
    //        $query->execute(array(
    //                              'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
    //                              'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
    //                              ));
    //        $query->closeCursor();

            if($online_payment_destination == 1)
            {
                for($i = 0; $i < count($id_product); $i++)
                {
                    $query = $connectData->prepare('SELECT quantity_stock FROM product_stock
                                                    WHERE id_product = :id');
                    $query->bindParam('id', htmlspecialchars($id_product[$i], ENT_QUOTES));
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $old_stock = $data[0];
                    }

                    $new_stock = $old_stock - $qty[$i];

                    if($new_stock < 0 ? $new_stock = 0 : $new_stock = $new_stock)

                    $query->closeCursor();

                    $query = $connectData->prepare('UPDATE product_stock SET quantity_stock = :newstock
                                                    WHERE id_product = :id');
                    $query->execute(array(
                                          'newstock' => htmlspecialchars($new_stock, ENT_QUOTES),
                                          'id' => htmlspecialchars($id_product[$i], ENT_QUOTES)
                                          ));
                    $query->closeCursor();
                }
            }



        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }


    //    }
    }
    else
    {
       include('cart/accepted_order/new_order_recap.php'); 
    }

    $query = $connectData->prepare('SELECT delivery_address_order, billing_address_order FROM online_order
                                            WHERE id_user = :user AND id_order = :order');

    $query->execute(array(
                      'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                      'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                      ));
    if(($data = $query->fetch()) != false)
    {
        $id_delivery_address = $data[0];
        $id_billing_address = $data[1];
    }

    $query->closeCursor();

    include('cart/accepted_order/new_order_address.php');

    ?>


    <td><TABLE width="100%" cellpadding="0" cellspacing="0" border="0">

            <td>
                <TABLE width="100%" cellpadding="0" cellspacing="0">

                    <td colspan="6">
                        <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                            <td>
                                <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Votre commande no. <?php echo($number_order); ?></span>
                            </td>
                        </TABLE>
                    </td>

                    <tr style="height: 6px;"></tr>

                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Qté</span></div></td>
                    <td id="center_text_table" align="center" width="50%"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Libellé</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Taux</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">H.T.</span></div></td>            
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">TVA</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">T.T.C.</span></div></td>

                    <tr></tr>
    <?php
    //if(empty($_SESSION['order_accepted_first_loading']))
    //{
        $total_product_ht = null;
        $total_amount_ht = null;
        $total_product_ttc = null;
    //}

    for($i = 0; $i < count($id_product); $i++)
    { 
        unset($_SESSION[('msg_alert_qty'.$id_product[$i])]);

        try
        {
            $query = $connectData->prepare('SELECT product.*, product_details.* 
                                            FROM product
                                            INNER JOIN product_details 
                                            ON product.id_product = product_details.id_product
                                            WHERE product.id_product = :id');

            $query->bindParam('id', htmlspecialchars($id_product[$i], ENT_QUOTES));
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $price_resale_cart = $data['price_resale_details'];
                $price_promo_cart = $data['price_promo_details'];
                $delivery_cart = $data['delivery_details'];
    //            $name_product_cart = $data['name_product_L1'];
    //            $price_public_cart = $data['price_public_details'];
            }

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
               $total_amount = $qty[$i] * $price_bonus_cart;

               $total_amount_ttc = $total_amount * (1+$value_tax);
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');

               $vat_amount = $total_amount_ttc - $total_amount;
               $vat_amount = number_format($vat_amount, 2, '.', '');
            }
            else
            {
               $total_amount = $qty[$i] * $price_resale_cart;

               $total_amount_ttc = $total_amount * (1+$value_tax);
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');

               $vat_amount = $total_amount_ttc - $total_amount;
               $vat_amount = number_format($vat_amount, 2, '.', '');
            }

            $total_amount = number_format($total_amount, 2, '.', '');          
        }
        else
        {
            if($price_promo_cart > 0.00)
            {
               $total_amount_ttc = $qty[$i] * $price_promo_cart;
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');

               $total_amount = $total_amount_ttc / (1+$value_tax);
               $total_amount = number_format($total_amount, 2, '.', '');

               $vat_amount = $total_amount * $value_tax;
               $vat_amount = number_format($vat_amount, 2, '.', '');                 
            }
            else
            {
               $total_amount_ttc = $qty[$i] * $price_public_cart[$i];
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');

               $total_amount = $total_amount_ttc / (1+$value_tax);
               $total_amount = number_format($total_amount, 2, '.', '');

               $vat_amount = $total_amount * $value_tax;
               $vat_amount = number_format($vat_amount, 2, '.', '');     
            }

        }

        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
        {
            $total_product_ht += $total_amount; 
            $total_product_ht = number_format($total_product_ht, 2, '.', '');

            $total_product_ttc += $total_amount_ttc;
            $total_product_ttc = number_format($total_product_ttc, 2, '.', '');      

            $total_product_vat = $total_product_ttc - $total_product_ht;
            $total_product_vat = number_format($total_product_vat, 2, '.', '');
        }
        else
        {
            $total_product_ttc += $total_amount_ttc;
            $total_product_ttc = number_format($total_product_ttc, 2, '.', '');

            $total_product_ht = $total_product_ttc / (1+$value_tax); 
            $total_product_ht = number_format($total_product_ht, 2, '.', '');

            $total_product_vat = $total_product_ht * $value_tax;
            $total_product_vat = number_format($total_product_vat, 2, '.', '');


        }



    ?>                
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($qty[$i]); ?></span>
                    </td>
                    <td>
                        <p id="center_text" style="margin-left: 4px;"><?php echo($name_product_cart[$i]); ?></p>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($total_amount); ?></span>
                    </td>           
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($vat_amount); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($total_amount_ttc); ?></span>
                    </td>

                    <tr></tr>
    <?php
    }

    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {   
        $vat_destination = $total_destination - $total_destination2;
        $vat_destination = number_format($vat_destination, 2, '.', '');

        $ecotax_ht = $eco_taxe / (1 + $value_tax);
        $ecotax_ht = number_format($ecotax_ht, 2, '.', '');

        $ecotax_vat = $eco_taxe - $ecotax_ht;
        $ecotax_vat = number_format($ecotax_vat, 2, '.', '');

    }
    else
    {
    //    if(!empty($_SESSION['order_accepted_first_loading']))
    //    {
    //       $total_destination = $total_destination2; 
    //    }

        $total_destination2 = $total_destination2 / (1+$value_tax);
        $total_destination2 = number_format($total_destination2, 2, '.', '');

        $vat_destination = $total_destination - $total_destination2;
        $vat_destination = number_format($vat_destination, 2, '.', '');

        $ecotax_ht = $eco_taxe / (1 + $value_tax);
        $ecotax_ht = number_format($ecotax_ht, 2, '.', '');

        $ecotax_vat = $eco_taxe - $ecotax_ht;
        $ecotax_vat = number_format($ecotax_vat, 2, '.', '');


    }
    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Somme des articles</span></td>
                    <td></td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_ht); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_vat); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_ttc); ?></span>
                    </td>
                    
<?php
if(!empty($_SESSION['bonus_applied']))
{
    $bonus_ttc = $_SESSION['bonus_applied'];
    $bonus_ttc = number_format($bonus_ttc, 2, '.', '');
    
    $bonus_ht = $bonus_ttc / (1 + $value_tax);
    $bonus_ht = number_format($bonus_ht, 2, '.', '');
    
    $bonus_vat = $bonus_ttc - $bonus_ht;
    $bonus_vat = number_format($bonus_vat, 2, '.', '');
    
?>
                <tr></tr>    
                    
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;">Bon de réduction</p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_ht); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_ttc); ?></span>
                </td>

                
<?php               
}
?>                    

                    <tr></tr>

                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;">1</span>
                    </td>
                    <td>
                        <p id="center_text" style="margin-left: 4px;">Transport: <?php echo($name_destination); ?></p>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($total_destination2, 2, '.', '')); ?></span>
                    </td>           
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($vat_destination); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($total_destination, 2, '.', '')); ?></span>
                    </td>

    <?php
    if(!empty($eco_taxe) && $eco_taxe > 0.00)
    {
    ?>
                    <tr></tr>

                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;">1</span>
                    </td>
                    <td>
                        <p id="center_text" style="margin-left: 4px;">Total Eco-Taxe</p>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($ecotax_ht); ?></span>
                    </td>           
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($ecotax_vat); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($eco_taxe, 2, '.', '')); ?></span>
                    </td>

    <?php               
    }
    else
    {
       $eco_taxe = 0; 
    }

    if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
    {
        if(!empty($_SESSION['order_accepted_first_loading']))
        {
            $discount_ttc = $discount_ht;
            $discount_ht = $discount_ttc / (1+$value_tax);
            $discount_ht = number_format($discount_ht, 2, '.', '');
        }
        else
        {
            $discount_ttc = $discount_ht * (1+$value_tax);       
        }  
        $discount_ttc = number_format($discount_ttc, 2, '.', '');

        $discount_vat = $discount_ttc - $discount_ht;
        $discount_vat = number_format($discount_vat, 2, '.', '');
    ?>
                    <tr></tr>

                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;">1</span>
                    </td>
                    <td>
                        <p id="center_text" style="margin-left: 4px;">Escompte de <?php echo($cart_discount_real); ?>% sur <?php echo($total_product_net.'&nbsp;€&nbsp;Hors&nbsp;Taxes'); ?></p>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_ht); ?></span>
                    </td>           
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_vat); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_ttc); ?></span>
                    </td>

    <?php               
    }
    else
    {
        $discount_ttc = 0;
    }

    //if(!empty($_SESSION['cart_total_discount']))
    //{
    //    $discount_value = $_SESSION['cart_total_discount'];
    //
    //    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    //    {
    //       $discount_value_ht = $discount_value * $value_tax;
    //       $discount_vat = $discount_value - $discount_value_ht;
    //
    //       $discount_value_ht = number_format($discount_value_ht, 2, '.', '');
    //       $discount_vat = number_format($discount_vat, 2, '.', ''); 
    //       $discount_value = number_format($discount_value, 2, '.', ''); 
    //    }
    //    else
    //    {
    //       $discount_vat = $discount_value * $value_tax;
    //       $discount_value_ht = $discount_value - $discount_vat;
    //
    //       $discount_value_ht = number_format($discount_value_ht, 2, '.', '');
    //       $discount_vat = number_format($discount_vat, 2, '.', '');
    //       $discount_value = number_format($discount_value, 2, '.', ''); 
    //    }
    ?>
    <!--                <tr></tr>

                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;">1</span>
                    </td>
                    <td>
                        <span id="center_text" style="margin-left: 4px;">Bon de réduction</span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php //echo($tax_percent.'%'); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_value_ht); ?></span>
                    </td>           
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_vat); ?></span>
                    </td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_value); ?></span>
                    </td>-->
    <?php
    //}

    if(!empty($discount_value) && $discount_value > 0.00)
    {
        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
        {

        }
        else
        {
            $super_total_ht = $total_product_ht + $total_destination2 + $ecotax_ht - $discount_value_ht; 
            $super_total_ht = number_format($super_total_ht, 2, '.', '');

            $super_total_ttc = $total_product_ttc + $total_destination + $eco_taxe - $discount_value;
            $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

            $super_total_vat = $super_total_ttc * $value_tax;
            $super_total_vat = number_format($super_total_vat, 2, '.', '');
        }
    }
    else
    {
        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
        {
            if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
            {
                $super_total_ht -= $discount_ht;
                $super_total_ttc -= $discount_ttc;
                $super_total_vat -= $discount_vat;
            }

            if(!empty($_SESSION['order_accepted_first_loading']))
            {
               $super_total_ht = $total_product_net;  
            }
            else
            {   
               $super_total_ht += $total_product_net + $total_destination2 + $eco_taxe_reseller;  
            }


            $super_total_ht = number_format($super_total_ht, 2, '.', '');

            $super_total_ttc = $super_total;
            $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

            $super_total_vat = $super_total - $super_total_ht;
            $super_total_vat = number_format($super_total_vat, 2, '.', '');
        }
        else
        {
            if(empty($_SESSION['order_accepted_first_loading']))
            {
                $super_total_ht = ($super_total / (1+$value_tax)) - $bonus_ht; 
                $super_total_ht = number_format($super_total_ht, 2, '.', '');

                $super_total_ttc = $super_total - $bonus_ttc;
                $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

                $super_total_vat = $super_total_ttc - $super_total_ht - $bonus_vat;
                $super_total_vat = number_format($super_total_vat, 2, '.', '');
            }
            else
            {
                $super_total_ht = ($super_total / (1+$value_tax)); 
                $super_total_ht = number_format($super_total_ht, 2, '.', '');

                $super_total_ttc = $super_total;
                $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

                $super_total_vat = $super_total_ttc - $super_total_ht;
                $super_total_vat = number_format($super_total_vat, 2, '.', '');
            }
            
            
        }
    }
    ?>
                    <tr></tr>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total Hors Taxes</span></td>
                    <td></td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_ht); ?></span>
                    </td>
                    <td></td>
                    <td></td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total TVA <?php echo($tax_percent.'%'); ?></span></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_vat); ?></span>
                    </td>
                    <td></td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total T.T.C.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_ttc); ?></span>
                    </td>

                    <tr></tr>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Somme à payer en Euro T.T.C.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <span id="center_subtitle" style="margin-right: 4px;"><?php echo($super_total_ttc); ?></span>
                    </td>

                    <tr></tr>

                    <td></td>
                    <td align="right"><span id="center_text" style="margin-right: 4px;">Valeur en Franc T.T.C.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo(number_format(($super_total_ttc* $currency_franc), 2, '.', '')); ?></span>
                    </td>

                    <tr style="height: 6px;"></tr>

                    <td colspan="6" style="border-bottom: 1px solid lightgray;"><span></span></td>

                    <tr style="height: 6px;"></tr>


                </TABLE>
            </td>
    <?php
    //if($BoK_address_billing_real === true)
    //{
    ?>        
        <tr style="height: 6px;"></tr>

            <td>            
                <TABLE width="100%" cellpadding="0" cellspacing="0">

                    <td colspan="6">
                        <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                            <td>
                                <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Adresse de Facturation</span>
                            </td>
                        </TABLE>
                    </td>

                    <tr style="height: 6px;"></tr>

                    <td width="100%">
                        <TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                            <td>
                                <span id="center_text"><?php echo($company_pay_accepted_billing); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php //echo($landline_pay_accepted_billing); ?></span>
                            </td>-->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo(upper_firstchar($title_pay_accepted_billing).' '.$firstname_pay_accepted_billing.' '.$lastname_pay_accepted_billing); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php //echo($mobile_pay_accepted_billing); ?></span>
                            </td>-->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($address1_pay_accepted_billing); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Email: <?php //echo($email_pay_accepted_billing); ?></span>
                            </td>  -->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($address2_pay_accepted_billing); ?></span>
                            </td>                                       

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($zip_pay_accepted_billing.' '.$city_pay_accepted_billing); ?></span>
                            </td>
                            <td></td>

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo(@$country_pay_accepted_billing); ?></span>
                            </td>
                            <td></td>

                        </TABLE>
                    </td>
                </TABLE>           
            </td>
    <?php
    //}
    ?>
        <tr style="height: 6px;"></tr>

            <td>            
                <TABLE width="100%" cellpadding="0" cellspacing="0">

                    <td colspan="6">
                        <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                            <td>
                                <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Adresse de Livraison</span>
                            </td>
                        </TABLE>
                    </td>

                    <tr style="height: 6px;"></tr>

                    <td width="100%">
                        <TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                            <td>
                                <span id="center_text"><?php echo($company_pay_accepted_delivery); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php //echo($landline_pay_accepted_billing); ?></span>
                            </td>-->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo(upper_firstchar($title_pay_accepted_delivery).' '.$firstname_pay_accepted_delivery.' '.$lastname_pay_accepted_delivery); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php //echo($mobile_pay_accepted_billing); ?></span>
                            </td>-->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($address1_pay_accepted_delivery); ?></span>
                            </td>

    <!--                        <td>
                                <span style="margin-left: 4px;" id="center_text">Email: <?php //echo($email_pay_accepted_billing); ?></span>
                            </td>  -->

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($address2_pay_accepted_delivery); ?></span>
                            </td>                                       

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo($zip_pay_accepted_delivery.' '.$city_pay_accepted_delivery); ?></span>
                            </td>
                            <td></td>

                            <tr></tr>

                            <td>
                                <span id="center_text"><?php echo(@$country_pay_accepted_delivery); ?></span>
                            </td>
                            <td></td>

                        </TABLE>
                    </td>
                </TABLE>           
            </td>    

            <tr></tr>

            <td align="center">
                <form method="post"><input type="submit" name="bt_pay_accepted_home" value="Accueil"></input>
                &nbsp;
                <input type="submit" name="bt_pay_accepted_print" value="Imprimer" onclick="popup('<?php echo($header.$_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&pop=true', '600', '700')"></input> 
                </form>
            </td>

    <!--        <tr></tr>
            <td><?php //echo(var_dump($_SESSION['123'])); ?></td>-->

    </TABLE></td>

    <?php
    if(empty($_SESSION['order_accepted_first_loading']))
    {
        include('cart/accepted_order/new_order_info.php');
        include('cart/accepted_order/new_order.php'); 

        $pay_accepted_boundary = md5(rand());
        $form_name = $form_user_registration;

        include('mail/order_accepted/send_order_accepted.php');
        include('mail/order_accepted/autoanswer_order_accepted.php');

        include('cart/accepted_order/delete_old_order.php');

        $_SESSION['order_accepted_first_loading'] = 'notempty';
        unset($_SESSION['block_cart_default_msg'], $_SESSION['cart_item_already_in_number']);
    }
}
else
{
?>
    <td><TABLE width="100%" cellpadding="0" cellspacing="0" border="0">

            <td align="center">
                <a href="index.php?page=frontend_main&amp;unsetpayshow=true">
                 <div id="contact_msg_right"><span id="msg_contact_right">Vous êtes redirigé vers la page d'acceuil...</span></div>
                </a>             
            </td>
            
    </TABLE></td>
<?php    
    
    header('Refresh: 10; url='.$header.$_SESSION['index'].'?page=frontend_main&unsetpayshow=true');  
}
    ?>