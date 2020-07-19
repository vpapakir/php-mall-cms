<?php
if($_SESSION['autorisation'] === true)#collapse cart block if connected user is an admin or a site owner at first loading page
{
    if(empty($_SESSION['autorisation_first_load']))
    {
        $_SESSION['frontend_menu_right_display_expand_blockcart'] = false;
        $_SESSION['frontend_menu_right_display_expand_expandFMRcart'] = 'false';
        $_SESSION['autorisation_first_load'] = 'notempty';
    }
}

if(isset($_POST['bt_add_cart']))
{ 
    $_SESSION['frontend_menu_right_display_expand_blockcart'] = true;
}

if(!empty($_SESSION['login_id']) 
        && (!empty($_SESSION['block_cart_default_msg']) && $_SESSION['block_cart_default_msg'] === 'opencart'))
{
    include('cart/cart_listing.php');
}

if(isset($_POST['bt_truncate_cart_x']))
{  
   $_SESSION['block_cart_ask_delete'] = true;       
}

if(isset($_POST['bt_confirm_truncate_cart']))
{
   try
   {
       $query = $connectData->prepare('DELETE FROM cart WHERE id_order = :order');
       $query->bindParam('order', htmlspecialchars($last_id_order, ENT_QUOTES));
       $query->execute();
       $query->closeCursor();
       
       reallocate_table_id('id_cart', 'cart');
       
       $query = $connectData->prepare('UPDATE online_order SET status_order = \'cross clicked\' 
                                       WHERE id_order = :order');
       $query->bindParam('order', htmlspecialchars($last_id_order, ENT_QUOTES));
       $query->execute();
       $query->closeCursor();
       
       unset($_SESSION['block_cart_default_msg'], $_SESSION['block_cart_ask_delete']);
       
       header('Location: '.$header.$_SESSION['index'].'?page=frontend_main');
   }
   catch (Exception $e)
   {
       die("<br>Error : ".$e->getMessage());
   }  
}

if(isset($_POST['bt_cancel_truncate_cart']))
{
   unset($_SESSION['block_cart_ask_delete']); 
}
?>

<TABLE width="100%" id="<?php echo($block_border_color);  ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?>">
    <form method="post">
<?php 
if(isset($_GET['expandFMRcart']))
{
    if(isset($_GET['expandFMRcart']) && $_GET['expandFMRcart'] == 'true')
    {
       $_SESSION['frontend_menu_right_display_expand_blockcart'] = true;
       $_SESSION['frontend_menu_right_display_expand_imagecart'] = 'graphics/icons/minus16x16.png';
       $expandFMRcart = 'false';
       $_SESSION['frontend_menu_right_display_expand_expandFMRcart'] = 'true';
    }
    else
    {
       $_SESSION['frontend_menu_right_display_expand_blockcart'] = false;
       $_SESSION['frontend_menu_right_display_expand_imagecart'] = 'graphics/icons/plus16x16.png';
       $expandFMRcart = 'true';
       $_SESSION['frontend_menu_right_display_expand_expandFMRcart'] = 'false';
    }
}
else
{
    if(empty($_SESSION['frontend_menu_right_display_expand_blockcart']) || $_SESSION['frontend_menu_right_display_expand_blockcart'] == false)
    {
       if((!empty($expandFMRcart) && $expandFMRcart == 'false') || (!empty($_SESSION['frontend_menu_right_display_expand_expandFMRcart']) && $_SESSION['frontend_menu_right_display_expand_expandFMRcart'] == 'false'))
       {
           $_SESSION['frontend_menu_right_display_expand_blockcart'] = false;
           $_SESSION['frontend_menu_right_display_expand_imagecart'] = 'graphics/icons/plus16x16.png';
           $expandFMRcart = 'true';
       }
       else
       {
           $_SESSION['frontend_menu_right_display_expand_blockcart'] = true;
           $_SESSION['frontend_menu_right_display_expand_imagecart'] = 'graphics/icons/minus16x16.png';
           $expandFMRcart = 'false'; 
       }
    }
    else
    {
       $_SESSION['frontend_menu_right_display_expand_blockcart'] = true;
       $_SESSION['frontend_menu_right_display_expand_imagecart'] = 'graphics/icons/minus16x16.png';
       $expandFMRcart = 'false';
    }   
}

if($_SESSION['frontend_menu_right_display_expand_blockcart'] == true)
{
?>
    <td>
       <!--[if !IE]>--><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&expandFMRcart=<?php echo($expandFMRcart); ?>"><!--<![endif]-->
           <TABLE width="100%" border="0"> 

            <td>
                <!--[if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&expandFMRcart=<?php echo($expandFMRcart); ?>"><![endif]-->
                <image style="vertical-align: inherit;" src="<?php echo($_SESSION['frontend_menu_right_display_expand_imagecart']); ?>" name="<?php $_SESSION['frontend_menu_right_display_expand_imagecart'] ?>" alt="expand" title="Réduire"/>
                <!--[if IE]></a><![endif]-->
            </td>
            <td width="100%">
                &nbsp;<span id="menu_subtitle" style="color: #92122a;">Panier</span>
            </td>

           </TABLE>
       <!--[if !IE]>--></a><!--<![endif]-->
    </td>
    
    <tr></tr>
    <?php
    if(!empty($_SESSION['block_cart_default_msg']) && $_SESSION['block_cart_default_msg'] === 'opencart')
    {
    ?>
    <td>       
        <TABLE width="100%" border="0" <?php echo($cellpadding_block_content.' '.$cellspacing_block_content); ?> style="<?php echo($bg_color_blocks_front.' '.$border_blocks); ?>" id="<?php echo($block_border_color);  ?>" border="0">
         
            <td><TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
                    
                <td id="center_text" align="left">
                    <?php
                    if($count_items == 1)
                    {
                        echo('1 article');
                    }
                    else
                    {
                        echo($count_items.' articles');
                    }
                    ?>                    
                </td>
                <td id="center_text" align="right">
<?php


for($i = 0; $i < count($id_product); $i++)
{
    if($type_user == 'reseller' || $_SESSION['autorisation'] === true)
    {
        if($bonus_real > 0)
        {
           $price_bonus = $price_resale[$i] - ($price_resale[$i] * ($bonus_real/100)); 
           $total += $price_bonus * $qty[$i];  
        }
        else
        {
           $total += $price_resale[$i] * $qty[$i];  
        }       
    }
    else
    {
       if($price_promo[$i] > 0.00)
       {
          $total += $price_promo[$i] * $qty[$i];  
       }
       else
       {
          $total += $price_public[$i] * $qty[$i]; 
       }    
    }   
}

if(!empty($total))
{
    if($type_user == 'reseller' || $_SESSION['autorisation'] === true)
    {
       $taxe = 'HT'; 
    }
    else
    {
       $taxe = 'TTC';
    } 
    
    echo(number_format($total, 2, '.', '').' € '.$taxe);  
}
?>                   
                </td>
                
                <tr style="height: 4px;"></tr>
<?php
if(empty($_SESSION['block_cart_ask_delete']))
{
?>
                <td colspan="2"><TABLE width="100%" cellpadding="0" cellspacing="0">
                <td align="center">
                    <a id="other_link" style="text-decoration: underline;" href="index.php?page=cart_view" title="Voir panier"><img src="graphics/buttons/showcartlink.gif" alt="Voir panier" title="Voir panier"></img></a>
                </td>
                <td>
                    <input style="vertical-align: middle;" type="image" name="bt_truncate_cart" src="graphics/icons/cross16x16.gif" alt="Vider le panier" title="Vider le panier"></input>
                </td>
                    </TABLE></td>
<?php
}
else
{
?>
                <td colspan="2" align="center">
                    <span id="center_text">Vider le panier ?</span>
                    <br clear="left">
                    <input type="submit" name="bt_confirm_truncate_cart" value="Oui"></input>
                    <input type="submit" name="bt_cancel_truncate_cart" value="Non"></input>
                </td>
<?php
}
?>
                
            </TABLE></td>        
            
            <tr style="height: 4px;"></tr>
            
            <td><TABLE width="100%" cellpadding="0" cellspacing="0">
<?php
for($i = 0; $i < count($id_product); $i++)
{
    try
    {
       $query = $connectData->prepare('SELECT * FROM product pr
                                       INNER JOIN product_details pr_de ON pr.id_product = pr_de.id_product
                                       WHERE pr.id_product = :id');
       
       $query->bindParam('id', htmlspecialchars($id_product[$i]));
       $query->execute();
       
       if(($data = $query->fetch()) != false)
       {          
?>
            <td align="right">
                <span id="center_text" style="font-size: 9px;"><?php echo($qty[$i]); ?>&nbsp;</span>
            </td>
            
            <td width="100%">
                <a id="other_link" style="font-size: 9px;" href="index.php?page=<?php echo($data['number_product']); ?>" title="<?php echo($data['name_product_'.$used_language]); ?>">
                <?php
                if(strlen($data['name_product_'.$used_language]) > 29)
                {
                ?>
                    <span><?php echo(utf8_encode(substr(utf8_decode($data['name_product_'.$used_language]), 0, 29)).'...'); ?></span>
                <?php
                }
                else
                {
                ?>
                    <span><?php echo($data['name_product_'.$used_language]); ?></span>
                <?php
                }
                ?>
                </a>
            </td> 
            
            <tr></tr>
<?php
       }
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
}
?>  
            
            </TABLE></td>
            
        </TABLE>
    </td>
    <?php
    }
    else
    {
    ?>
    <td>       
        <TABLE width="100%" border="0" <?php echo($cellpadding_block_content.' '.$cellspacing_block_content); ?> style="<?php echo($bg_color_blocks_front.' '.$border_blocks); ?>" id="<?php echo($block_border_color);  ?>" border="0">
        
            <td id="center_text">
                <div style="<?php echo($marginL_block_content); ?>">Merci de noter que nous livrons uniquement en:</div>
            </td>
            <tr></tr>
            <td><TABLE width="100%" cellpadding="0" cellspacing="0">
                    
                    <td><img style="margin-left: 6px;" src="graphics/icons/arrowR12x12.png" alt="arrow"></img></td>
                    <td><span id="center_subtitle" >&nbsp;France Métropole</span></td>
                    
                    <tr></tr>
                    
                    <td><img style="margin-left: 6px;" src="graphics/icons/arrowR12x12.png" alt="arrow"></img></td>
                    <td><span id="center_subtitle" >&nbsp;La Réunion</span></td>
                    
                    <tr></tr>
                    
                    <td><img style="margin-left: 6px;" src="graphics/icons/arrowR12x12.png" alt="arrow"></img></td>
                    <td><span id="center_subtitle" >&nbsp;Guadeloupe</span></td>
                    
                    <tr></tr>
                    
                    <td><img style="margin-left: 6px;" src="graphics/icons/arrowR12x12.png" alt="arrow"></img></td>
                    <td><span id="center_subtitle" >&nbsp;Martinique</span></td>
                    
            </TABLE></td>
            <tr></tr>
            <td id="center_text">
                <div style="<?php echo($marginL_block_content); ?>">Pour toute autre destination veuillez consulter le site de 
                <br>
                <a id="link" href="http://www.fr.luxint.nine.ch/" target="_blank">Lux International</a></div>
            </td>
            
        </TABLE></td>
    <?php
    }
}
else
{
?>
    <td>
       <!--[if !IE]>--><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&expandFMRcart=<?php echo($expandFMRcart); ?>"><!--<![endif]-->
           <TABLE width="100%" border="0"> 

            <td>
                <!--[if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&expandFMRcart=<?php echo($expandFMRcart); ?>"><![endif]-->
                <image style="vertical-align: inherit;" src="<?php echo($_SESSION['frontend_menu_right_display_expand_imagecart']); ?>" name="<?php $_SESSION['frontend_menu_right_display_expand_imagecart'] ?>" alt="expand" title="Afficher"/>
                <!--[if IE]></a><![endif]-->
            </td>
            <td width="100%">
                &nbsp;<span id="menu_subtitle" style="color: #92122a;">Panier</span>
            </td>

           </TABLE>
       <!--[if !IE]>--></a><!--<![endif]-->
    </td> 
<?php
}
?>
    </form>
</TABLE>
