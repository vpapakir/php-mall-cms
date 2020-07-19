<?php
try
{  
    // <editor-fold defaultstate="collapsed" desc="Check if used address is the subscribe address">  
    
    $prepared_query = 'SELECT * FROM order_history
                        INNER JOIN user_real 
                        ON order_history.id_user = user_real.id_user
                        INNER JOIN shipping_destination
                        ON shipping_destination.id_destination_shipping = order_history.id_destination_shipping
                        INNER JOIN tax
                        ON tax.id_destination_shipping = shipping_destination.id_destination_shipping
                        WHERE order_history.id_user = :user AND number_order_history = :order';
    
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'order' => htmlspecialchars($number_order, ENT_QUOTES)
                          ));
    

    if(($data = $query->fetch()) != false)
    {
        $total_id_product = $data['id_product'];
        $qty_product = $data['qty_product_order_history'];
        $total_amount_product_ttc_order_history = $data['price_product_order_history'];
        $super_total = $data['amount_order_history'];
        
        $total_destination2 = $data['amount_shipping_order_history'];
        $total_destination = $data['amount_shipping_order_history'];
        $eco_taxe = $data['ecotax_order_history'];
        $value_tax = $data['value_tax'] / 100;
        
        $discount_ht = $data['cash_discount_order_history'];
        
        
        $id_billing_address = $data['billing_address_order_history'];
        $id_delivery_address = $data['delivery_address_order_history'];
        
        $name_destination = $data['name_destination_shipping'];
        
        $cart_type_real = $data['type_real'];
        $cart_bonus_real = $data['bonus_real'];
        
        $amount_bonus = $data['amount_bonus'];
        
        $tax_percent = number_format($data['value_tax'], 2, '.', '');
    }
    $query->closeCursor();  
    
    include('cart/accepted_order/new_order_address.php');    
    
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        $total_destination2 = $total_destination / (1+$value_tax);
    }
    
    
    $id_product = explode(',', $total_id_product);
    $qty = explode(',', $qty_product);
    $amount_product_ttc = explode(',', $total_amount_product_ttc_order_history);
    
    for($i = 0; $i < count($id_product); $i++)
    {
        $total_product_net += $amount_product_ttc[$i] / (1+$value_tax);
        $total_product_ht += ($amount_product_ttc[$i] / (1+$value_tax));
        
        $prepared_query = 'SELECT * FROM product
                       INNER JOIN product_details
                       ON product.id_product = product_details.id_product
                       WHERE product.id_product = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', htmlspecialchars($id_product[$i], ENT_QUOTES));
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $name_product_cart[$i] = $data['name_product_L1'];
            $price_public_cart[$i] = $data['price_public_details'];
        }
        $query->closeCursor();
    }
    
    $total_product_ht -= $amount_bonus;
    
    $amount_bonus_ht = $amount_bonus / (1+$value_tax);
    $amount_bonus_vat = $amount_bonus - $amount_bonus_ht;
    
    $total_product_net -= ($discount_ht / (1+$value_tax)) - ($eco_taxe / (1+$value_tax));
    $total_product_net = number_format($total_product_net, 2, '.', '');
    
    $destination_ht = $total_destination2 / (1+$value_tax);
    
    $vat_taxe = $super_total - $total_product_ht - $destination_ht - $amount_bonus_vat;
    $vat_taxe = number_format($vat_taxe, 2, '.', '');
    
    // </editor-fold>        
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
?>
