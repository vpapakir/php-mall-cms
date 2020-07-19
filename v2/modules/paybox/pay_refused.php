<?php
unset($_SESSION['pay_recap_show_order']);

if(empty($_SESSION['pay_refused_first_loading']))
{
    include('cart/cart_operation.php');
    
    for($i = 0; $i < count($id_product); $i++)
    { 
        unset($_SESSION[('msg_alert_qty'.$id_product[$i])]);
    }
    
    include('cart/accepted_order/delete_old_order.php');
    
    $_SESSION['pay_refused_first_loading'] = 'notempty';
    unset($_SESSION['block_cart_default_msg'], $_SESSION['cart_item_already_in_number']);
}
?>
