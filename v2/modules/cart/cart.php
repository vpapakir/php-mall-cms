<?php
include('cart/cart_operation.php');
include('cart/bt_check_promocode.php');

if(!empty($id_product[0]) && $id_product[0] != null)
{    
?> 
<td><TABLE width="100%" border="0" style="<?php echo($list_box); ?>">
        <form method="post">
                
                    <td colspan="2" id="<?php echo($block_frontend_approach_result); ?>" style="border-radius: 6px 0px 0px 0px;">
                        <span id="<?php echo($text_frontend_approach_result); ?>" style="margin-left: 4px;">
                            Votre panier contient <?php echo($count_items.' '.$item); ?><?php //echo('pour un montant total de '.$super_total.'&nbsp;€'); ?>                          
                        </span>
                    </td>
                    <td id="<?php echo($block_frontend_approach_result); ?>" style="border-radius: 0px 0px 0px 0px;" align="center">
                        <span id="<?php echo($text_frontend_approach_result); ?>">
                            Quantité
                        </span>
                    </td>
                    <td id="<?php echo($block_frontend_approach_result); ?>" style="border-radius: 0px 6px 0px 0px;" align="center">
                        <span id="<?php echo($text_frontend_approach_result); ?>">
<?php
                        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                        {
?>
                            Montant
<?php
                        }
                        else
                        {
?>
                            Total&nbsp;TTC                   
<?php
                        }
?>
                        </span>
                    </td>
                    
                <tr></tr>
    <?php
    for($i = 0; $i < count($id_product); $i++)
    { 

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
            }
            else
            {
               $total_amount = $qty[$i] * $price_resale_cart; 
            }
            
            $total_amount = number_format($total_amount, 2, '.', '');          
        }
        else
        {
            if($price_promo_cart > 0.00)
            {
                $total_amount = $qty[$i] * $price_promo_cart;
                $total_amount = number_format($total_amount, 2, '.', '');
            }
            else
            {
               $total_amount = $qty[$i] * $price_public_cart[$i];
               $total_amount = number_format($total_amount, 2, '.', ''); 
            }
            
        }
        
        $total_product += $total_amount;
    ?>         
                <td style="vertical-align: top;">
                    <a href="index.php?page=<?php echo($number_product_cart[$i]); ?>">
                        <img style="border: 1px solid lightgray;" src="<?php echo($image_product_cart[$i]); ?>" alt="<?php echo($name_product_cart[$i]); ?>" width="100"></img>
                    </a>
                </td>
                
                <td>
                    <TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
                      
                    <td>
                       <a id="other_link" href="index.php?page=<?php echo($number_product_cart[$i]); ?>">
                           <span id="center_subtitle"><?php echo($name_product_cart[$i]) ?></span>
                       </a>                
                    </td>
                    
                    <tr></tr>
                        
                    <td>
                       <span id="center_text"><?php echo($intro_product_cart[$i]) ?></span>               
                    </td>                                       
<?php
                           if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                           {
                               if(empty($price_bonus_cart))
                               {
?>
                                    <tr></tr>

                                    <td>
                                       <span id="center_subtitle" style="font-weight: bold;"><?php echo('Votre&nbsp;prix:&nbsp;'.$price_resale_cart.'&nbsp;€&nbsp;HT&nbsp;l\'unité'); ?></span>
                                       <span id="center_text"><?php echo('(Prix&nbsp;public:&nbsp;'.$price_public_cart[$i].'&nbsp;€&nbsp;TTC)'); ?></span>                                    
<?php 
                               }
                               else
                               {
?>
                                    <tr></tr>

                                    <td>
                                       <span id="center_subtitle" style="font-weight: bold;"><?php echo('Prix&nbsp;revendeur:&nbsp;'.$price_resale_cart.'&nbsp;€&nbsp;HT&nbsp;l\'unité'); ?></span>
                                       <span id="center_text"><?php echo('(Prix&nbsp;public:&nbsp;'.$price_public_cart[$i].'&nbsp;€&nbsp;TTC)'); ?></span>   
                                       <br clear="left">
                                       <span id="center_text_lux"><?php echo('Votre&nbsp;prix:&nbsp;'.$price_bonus_cart.'&nbsp;€&nbsp;HT&nbsp;l\'unité'); ?></span>
<?php                   
                               }
                               
                               if($_SESSION['autorisation'] == true)
                               {
                                   if($price_promo_cart > 0.00)
                                   {
?>                                       
                                        <br clear="left">
                                        <span id="center_text_lux">PROMOTION:&nbsp;<?php echo($price_promo_cart); ?>&nbsp;€&nbsp;TTC</span>
<?php           
                                   }
                                   echo('</td>');
                               }
                               else
                               {
                                  echo('</td>'); 
                               }
                           }
                           else
                           {
                               if($price_promo_cart > 0.00)
                               {
?>                               
                                    <tr></tr>
                        
                                    <td>
                                        <span id="center_subtitle" style="font-weight: normal; text-decoration: line-through;"><?php echo('Prix: '.$price_public_cart[$i].'&nbsp;€&nbsp;TTC&nbsp;l\'unité'); ?></span>
                                        &nbsp;
                                        <span id="center_text_lux">PROMOTION:&nbsp;<?php echo($price_promo_cart); ?>&nbsp;€&nbsp;TTC</span>     
                                    <td>                                           
<?php                               
                               }
                               else
                               {
?>
                                    <tr></tr>
                        
                                    <td>
                                       <span id="center_subtitle" style="font-weight: normal;"><?php echo('Prix:&nbsp;'.$price_public_cart[$i].'&nbsp;€&nbsp;TTC&nbsp;l\'unité'); ?></span>       
                                    <td>                                    
<?php
                               }
                           }
                           
                           if($delivery_cart > 0 && $available_stock_cart[$i] == 0)                              
                           {
                               if($delivery_cart == 1 ? $day = 'jour' : $day = 'jours')                  
?>
                                    <tr></tr>
                                    
                                    <td>
                                        <span id="center_subtitle" style="color: #EE4022;">Livraison sous <?php echo($delivery_cart.' '.$day); ?></span> 
                                    </td>
<?php                                        
                           }
                           else
                           {
?>
                               <tr></tr>
                                    
                                <td>
                                    <span id="msg_stock_ok">En Stock</span> 
                                </td>     
<?php
                           }
?>
                    </TABLE>
                </td>

                
                
                <td style="border-right: 1px solid lightgray; border-left: 1px solid lightgray;" align="center">
<!--                    <input id="txtQtyProduct" style="width: 24px; direction: rtl;" type="text" name="txtQtyCart" value="<?php //echo($qty[$i]) ?>" size="2"></input>-->
                    <SELECT name="cboQtyCart<?php echo($i) ?>" style="width: 50px;" onchange="OnChange('bt_choose_QtyCart<?php echo($i); ?>')">
                        <option value="remove" title="Enlever du panier">0</option>
<?php
if($available_stock_cart[$i] == 0)
{
    $available_stock_cart[$i] = 99;
}

for($y = 1; $y <= $available_stock_cart[$i]; $y++)
{
    echo('<option value="'.$y.'" ');
    if($y == $qty[$i])
    {
        echo('selected');
    }
    else
    {
        echo(null);
    }
    echo('>'.$y.'</option>');
}
?>                      
                    </SELECT>
                    <input style="display: none;" id="bt_choose_QtyCart<?php echo($i); ?>" type="submit" name="bt_choose_QtyCart<?php echo($i); ?>" value="Changer"></input>
                </td>
                
                <td align="right">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
<?php
                    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                    {
?>                          
                        <td align="right">
                            <span id="center_text"><?php echo($total_amount.'&nbsp;€'); ?></span>
                        </td> 
<?php                            
                    }
                    else
                    {
?>                   
                        <td align="right">
                            <span id="center_text"><?php echo($total_amount.'&nbsp;€'); ?></span>
                        </td>                   
<?php
                    }
?>
                    </TABLE>   
                </td>

                <tr>
                    <td colspan="4" style="border-bottom: 1px solid lightgray;"><span></span></td>
                </tr>
    <?php
         
    }
    ?>
                <!-- Shipment Cost -->
                <td>
                   <a href="index.php?page=shipment_info" style="text-decoration: none;">
                       <TABLE border="0" cellpadding="1" width="100%" id="<?php echo($block_border_color); ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?> height: 40px;">

                        <td>
                            <!--[if IE]><a href="index.php?page=shipment_info" style="text-decoration: none;"><![endif]-->
                            <span id="menu_subtitle" style="color: #92122a; margin-left: 4px;">
<?php
                            if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                            {
                                echo('Transport HT');
                            }
                            else
                            {
                                echo('Transport');
                            }
?>
                            </span>
                            <!--[if IE]></a><![endif]-->
                        </td>
                       </TABLE>
                   </a>
                </td>
                <td style="border-right: 1px solid lightgray; vertical-align: middle;" width="100%" colspan="2">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <SELECT name="cboDestination" onchange="OnChange('bt_choose_destination')">
                            <?php
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

                                while($data = $query->fetch())
                                {
                                    echo('<option value="'.$data[0].'" ');                                    
                                    
                                    if(!empty($_SESSION['cart_cboDestination']) && $_SESSION['cart_cboDestination'] == $data[0])
                                    {
                                        echo('selected');
                                    }
                                    else
                                    {
//                                        if($group_destination_real[0] == $data[0])
//                                        {
//                                            echo('selected');
//                                        }
//                                        else
//                                        {
                                            echo(null);  
//                                        }
//                                        if(empty($_SESSION['cart_cboDestination']) && $data['id_country'] == $id_country_destination && $id_country_destination != 249)
//                                        {
//                                           echo('selected'); 
//                                        }
//                                        else
//                                        {
                                           
//                                        }  
                                    }

                                    echo('>'.$data[1].'</option>');
                                }
                            }
                            catch (Exception $e)
                            {
                               die("<br>Error : ".$e->getMessage());
                            }
                            ?>
                            </SELECT>
                            <input style="display: none;" id="bt_choose_destination" type="submit" name="bt_choose_destination" value="Changer"></input>
                            <br clear="left">            
                            <span id="center_text_lux">
<?php
                                if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                                {
                                    $freeshipping_part = $total_product_net;
                                }
                                else
                                {
                                    $freeshipping_part = ($super_total - $total_destination2);
                                }

                                if(($cart_type_real == 'public' || $_SESSION['login_id'] > 9000000) && $freeshipping_part >= ($value_special_shipping - 20) && $freeshipping_part < $value_special_shipping && $pickup_destination == 0 && $BoK_special_shipping == true)
                                {   
                                    $free_shipping = $value_special_shipping - $total_product_net;           
                                    $msg_free_shipping = null;
                                    echo('Il vous manque '.number_format($free_shipping, 2, '.', '').' € pour bénéficier des frais de transports offerts');
                                }
                                else
                                {
                                    if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && $freeshipping_part >= ($value_special_shipping - 200) && $freeshipping_part < $value_special_shipping && $pickup_destination == 0 && $BoK_special_shipping == true)
                                    {
                                        $free_shipping = $value_special_shipping - $total_product_net;           
                                        $msg_free_shipping = null;
                                        echo('Il vous manque '.number_format($free_shipping, 2, '.', '').' € pour bénéficier des frais de transports offerts');
                                    }
                                }

                                if(!empty($msg_free_shipping))
                                {
                                    echo($msg_free_shipping);
                                }
    ?>
                            </span>
                        </td>
                    </TABLE>
                </td>                
                <td align="right">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                    <td align="right">
                        <span id="center_text">
<?php 
                        if(!empty($total_destination))
                        { 
                            if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                            {
                                //$vat_taxe_destination = $total_destination * $value_tax;
                                //$total_destination = $total_destination - $vat_taxe_destination;                           
                                echo(number_format($total_destination2, 2, '.', '').'&nbsp;€'); 
                            }
                            else
                            {
                                echo(number_format($total_destination2, 2, '.', '').'&nbsp;€'); 
                            }   
                        }
                        else
                        { 
                            echo('0.00&nbsp;€'); 

                        } 

?>
                        </span>
                    </td>
                    </TABLE>
                </td>
                
                
<?php
            if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true && $cart_discount_real > 0)
            {         
?>
                <tr>
                    <td colspan="4" style="border-bottom: 1px solid lightgray;"><span></span></td>
                </tr>
                <!-- Cash Discount -->
                <td>
                       <TABLE border="0" cellpadding="1" width="100%" id="<?php echo($block_border_color); ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?> height: 40px;">

                        <td>
                            <span id="menu_subtitle" style="color: #92122a; margin-left: 4px;">
<?php
                                echo('Escompte');
?>
                            </span>
                        </td>
                       </TABLE>
                </td>
                <td style="border-right: 1px solid lightgray; vertical-align: middle;" width="100%" colspan="2">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                        <td>
                                <span id="center_subtitle">Votre réduction de <?php echo($cart_discount_real); ?>%</span>
                                <span id="center_text">sur <?php echo($total_product_net.'&nbsp;€&nbsp;Hors&nbsp;Taxes'); ?></span>
                        </td>
                    </TABLE>
                </td>                
                <td align="right">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                    <td align="right">
                        <span id="center_text">
<?php
                            echo('-'.$discount_ht.'&nbsp;€');
?>
                        </span>
                    </td>
                    </TABLE>
                </td>                
<?php
            }
            
if($cart_type_real == 'public' || empty($_SESSION['login_id']) || $_SESSION['login_id'] > 9000000)  
{
?>
<!-- Bonus Amount -->
            
            <tr>
                <td colspan="4" style="border-bottom: 1px solid lightgray;"><span></span></td>
            </tr>
            
<?php
    
    // <editor-fold defaultstate="collapsed" desc="Bonus">
?>
                <td>
                   <a href="index.php?page=discount_advantage_info" style="text-decoration: none;">
                       <TABLE border="0" cellpadding="1" width="100%" id="<?php echo($block_border_color); ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?> height: 40px;">

                        <td>
                            <!--[if IE]><a href="index.php?page=discount_advantage_info" style="text-decoration: none;"><![endif]-->
                            <span id="menu_subtitle" style="color: #92122a; margin-left: 4px;">
                                Bonus
                            </span>
                            <!--[if IE]></a><![endif]-->
                        </td>
                       </TABLE>
                   </a>
                </td>                       
                <td style="border-right: 1px solid lightgray;" width="100%" colspan="2">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
<?php
                    if(!empty($_SESSION['login_id']) && $_SESSION['login_id'] < 9000000)
                    {
?>
                        <td><span id="center_subtitle">Code Promo</span>
                            &nbsp;
                            <input id="textfield_bonus" style="border: 1px solid lightgrey; border-radius: 6px; padding: 2px; width: 80px;" type="text" name="txtCodeBonus"></input>
                            &nbsp;
                            <input type="submit" name="bt_check_promocode" value="Vérifier"></input>
                            &nbsp;
                            <span id="msg_wrong"><?php echo(check_session_input(@$_SESSION['msg_cart_txtCodeBonus'])); ?></span>
                        </td>
<?php
                    }
                    else
                    {
?>
                        <td>
                            <span id="center_text">Si vous êtes en possession d'un code promotionnel, il est impératif de vous connecter ou de 
                                <a id="link" href="<?php echo($header.$_SESSION['index']); ?>?page=form_registration&captcha=true">vous inscrire gratuitement</a> avant de pouvoir le saisir</span>
                            
                        </td>    
<?php                        
                    }
?>
                    </TABLE>
                </td>                
                <td align="right">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                    <td align="right">
                        <span id="center_text">
<?php 
                        if(!empty($_SESSION['bonus_typevalue']) && $_SESSION['bonus_typevalue'] == '%')
                        {  
                            $amount_bonus = $total_product * ($_SESSION['bonus_value'] / 100);
                            $amount_bonus = number_format($amount_bonus, 2, '.', '');
                            echo('-'.$amount_bonus.'&nbsp;€');                                             
                        }
                        else
                        {
                            if(!empty($_SESSION['bonus_typevalue']) && $_SESSION['bonus_typevalue'] == 'money')
                            {
                                $amount_bonus = $_SESSION['bonus_value'];
                                $amount_bonus = number_format($amount_bonus, 2, '.', '');
                                echo('-'.$amount_bonus.'&nbsp;€');  
                            }
                            else
                            {
                                $amount_bonus = 0;
                                echo($amount_bonus.'&nbsp;€');
                            }
                        }
                        
                        $_SESSION['bonus_applied'] = $amount_bonus;
                        $super_total = $super_total - $_SESSION['bonus_applied'];
                        $super_total = number_format($super_total, 2, '.', '');
?>
                        </span>
                    </td>
                    </TABLE>
                </td>
<?php
//</editor-fold>   
}
?>                
                
            <!-- Taxes Amount -->    
                
            <tr>
                <td colspan="4" style="border-bottom: 1px solid lightgray;"><span></span></td>
            </tr>
            
<?php
// <editor-fold defaultstate="collapsed" desc="Taxes">
?>
                <td>
                   <a href="index.php?page=tax_info" style="text-decoration: none;">
                       <TABLE border="0" cellpadding="1" width="100%" id="<?php echo($block_border_color); ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?> height: 40px;">

                        <td>
                            <!--[if IE]><a href="index.php?page=tax_info" style="text-decoration: none;"><![endif]-->
                            <span id="menu_subtitle" style="color: #92122a; margin-left: 4px;">
                                Taxes
                            </span>
                            <!--[if IE]></a><![endif]-->
                        </td>
                       </TABLE>
                   </a>
                </td>                       
                <td style="border-right: 1px solid lightgray; vertical-align: middle;" width="100%" colspan="2">
                    <TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_text">
                                <span id="center_subtitle">Total Eco-Taxe:&nbsp;</span>
<?php
                                if(($cart_type_real == 'public' || $_SESSION['login_id'] > 9000000) && $eco_taxe > 0.00)
                                {
                                    echo($eco_taxe.' € inclue');
                                }                              
?>
                            </span>                           
                        </td> 
                        <tr></tr>
                        <td> 
                            <span id="center_text">
                                <span id="center_subtitle">Total TVA<?php echo(' '.$tax_percent.' %'); if($cart_type_real == 'public'){ echo(':'); } ?></span>
<?php 
                                if($cart_type_real == 'public' || $_SESSION['login_id'] > 9000000)
                                { 
                                   $temp_total_ht = $super_total / (1 + $value_tax);
                                   $vat_taxe = $super_total - $temp_total_ht;
                                   echo(' '.number_format($vat_taxe, 2, '.', '').' € inclue');  
                                } 
                                else
                                {
                                    //$vat_taxe += $vat_taxe_destination;
                                    
                                    
                                    
                                    
                                    echo(' sur '.$super_total_net.' € Hors Taxes');
                                }
?>
                            </span>
                        </td>
                    </TABLE>
                </td>                
                <td style="vertical-align: middle;" align="right">
                    <TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
                        <td align="right">
                            <span id="center_text">                              
<?php 
                            if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                            {
                                echo(number_format($eco_taxe_reseller, 2, '.', '').'&nbsp;€');
                            }
                            else
                            {
                                echo(number_format(0, 2, '.', '').'&nbsp;€');
                            }
?>
                            </span>
                        </td>
                        <tr></tr>
                        <td align="right">
<?php
                        if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
                        {
?>
                            <span id="center_text"><?php echo(number_format($vat_taxe, 2, '.', '').'&nbsp;€'); ?></span>                               
<?php
                        }
                        else
                        {
?>
                            <span id="center_text"><?php echo(number_format(0, 2, '.', '').'&nbsp;€'); ?></span>    
<?php
                        }
?>                          
                        </td>  
                    </TABLE>
                </td>

<?php
//</editor-fold>
?>
                         
            <tr>
                <td colspan="4" style="border-bottom: 1px solid lightgray;"><span></span></td>
            </tr>
            
                <td>
                   <a href="index.php?page=discount_advantage_info" style="text-decoration: none;">
                       <TABLE border="0" cellpadding="1" width="100%" id="<?php echo($block_border_color); ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?> height: 40px;">

                        <td>
                            <!--[if IE]><a href="index.php?page=discount_advantage_info" style="text-decoration: none;"><![endif]-->
                            <span id="menu_subtitle" style="color: #92122a; margin-left: 4px;">
                                Paiement
                            </span>
                            <!--[if IE]></a><![endif]-->
                        </td>
                       </TABLE>
                   </a>
                </td>                       
                <td style="border-right: 1px solid lightgray;" width="100%" colspan="2">
                    <TABLE width="100%" cellpadding="0" cellspacing="0">
                        <td>
<?php
                            if($online_payment_destination == 1)
                            {
                                if($cart_delay_real == 'cash_credit')
                                {
?>
                                        <input type="radio" name="rad_payment_mode" value="cash" <?php if(empty($_SESSION['cart_rad_payment_mode']) || $_SESSION['cart_rad_payment_mode'] == 'cash'){ echo('checked'); }else{ echo(null); } ?> onclick="OnChange('bt_rad_choose_payment_mode')"></input>
                                        <span id="center_subtitle">Comptant avant livraison</span>&nbsp;<span id="center_text">(CB,Chèque ou Virement)</span>
                                    
                                    </td>
                                    
                                    <tr></tr>
                                    
                                    <td>
                                        <input type="radio" name="rad_payment_mode" value="cash_credit" <?php if(!empty($_SESSION['cart_rad_payment_mode']) && $_SESSION['cart_rad_payment_mode'] == 'cash_credit'){ echo('checked'); }else{ echo(null); } ?> onclick="OnChange('bt_rad_choose_payment_mode')"></input>
                                        <span id="center_subtitle">Paiement sous <?php echo($user_add_reseller_creditdelay) ?> jours</span>&nbsp;<span id="center_text">(CB,Chèque ou Virement)</span>
                                        <input id="bt_rad_choose_payment_mode" hidden style="display: none;" type="submit" name="bt_rad_choose_payment_mode" value="Choix Paiement"></input>
                                    </td> 
                                    
<?php                                    
                                }
                                else
                                {
?>
                                    <span id="center_subtitle">Comptant avant livraison</span>&nbsp;<span id="center_text">(CB,Chèque ou Virement)</span>
                                    
                                    </td>
<?php
                                }
                            }
                            else
                            {
?>
                                <span id="center_text">La commande sera traitée par </span>
                                <span id="center_subtitle">Lux Réunion.</span>
                                <span id="center_text">Vous n'avez rien à payer lors de la confirmation de votre commande</span>
                                
                                </td>
<?php
                            }
?>
                        
                    </TABLE>
                </td>                
                <td align="right">
                    <span id="center_text"></span>
                </td>

            <tr></tr>

                <!-- Total Amount -->
            
                <td colspan="3" id="<?php echo($block_frontend_approach_result); ?>" style="border-radius: 0px 0px 0px 6px;" id="center_title" align="right">
                    <span id="<?php echo($text_frontend_approach_result); ?>">
                        Montant total de votre commande TTC
                    </span>
                </td>
                <td id="<?php echo($block_frontend_approach_result); ?>" style="border-radius: 0px 0px 6px 0px;" align="right">
                    <span id="<?php echo($text_frontend_approach_result); ?>">
<?php
                        $_SESSION['cart_id_order'] = $last_id_order;
                        $_SESSION['cart_super_total'] = $super_total;
                        echo($super_total.'&nbsp;€');                       
?>                        
                    </span>
                </td>
             
           
        <tr></tr> 
        </TABLE></td>
        
                <?php
}
else
{
?> 
    
    <td>
        <TABLE border="0" width="100%" id="<?php echo($block_frontend_approach_result); ?>">
            <td id="<?php echo($text_frontend_approach_result); ?>" align="center">
                Votre Panier est vide
            </td>
        </TABLE>
    </td>    
<?php
}
?>
           
    
    
<tr></tr>
<?php 
if(!empty($id_product[0]))
{
?>
<td align="right">
    <TABLE width="100%" border="0">
    
<!--    <td id="<?php //echo($block_frontend_approach_result); ?>" style="border-radius: 6px;" width="65%">
        <TABLE width="100%" cellpadding="0">
        <td><span id="<?php //echo($text_frontend_approach_result); ?>">Code Promotion</span></td>
        <td><input style="border: none; border-radius: 6px; padding: 2px;" type="text" name="txtPromoCode"></input></td>
        <td><input type="image" name="bt_check_promocode" src="graphics/icons/check.png" alt="Valider" title="Valider"></input></td>
        </TABLE>
    </td>-->
        
    <td width="100%" align="right">
        <input type="submit" name="bt_checkout" value="Commander"></input>
    </td>
    
    <td align="right">
<!--        <a id="other_link" href="" onclick="javascript: history.back();">
            <img style="vertical-align: middle;" src="graphics/buttons/continuelink.gif" alt="Continuer vos achats"></img>
        </a>-->
        <input type="submit" name="bt_continue_shopping" value="Continuer vos achats"></input>
    </td>
    </form>
        
    </TABLE>
</td>
<tr></tr>
<td><?php //echo(var_dump($_SESSION['bonus_typevalue'])); ?></td>
<tr></tr>
<td><?php //echo(var_dump($_SESSION['bonus_value'])); ?></td>
<tr></tr>
<td><?php //echo(var_dump(' = '.@$super_total_net)); ?></td>
<?php
}
?>
