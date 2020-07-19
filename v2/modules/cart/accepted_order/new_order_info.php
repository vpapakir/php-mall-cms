<?php
try
{
    $total_qty = null;
    $total_id_product = null;
    $total_amount_product_ttc = null;

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
                //$name_product_cart = $data['name_product_L1'];
                //$price_public_cart = $data['price_public_details'];
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
            }
            else
            {
               $total_amount = $qty[$i] * $price_resale_cart;

               $total_amount_ttc = $total_amount * (1+$value_tax);
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');
            }

            $total_amount = number_format($total_amount, 2, '.', '');          
        }
        else
        {
            if($price_promo_cart > 0.00)
            {
               $total_amount_ttc = $qty[$i] * $price_promo_cart;
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');                 
            }
            else
            {
               $total_amount_ttc = $qty[$i] * $price_public_cart[$i];
               $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');     
            }

        }

        if($i == (count($id_product) - 1))
        {
            $total_qty .= $qty[$i]; 
            $total_id_product .= $id_product[$i];
            $total_amount_product_ttc .= $total_amount_ttc; 
        }
        else
        {
            $total_qty .= $qty[$i].','; 
            $total_id_product .= $id_product[$i].',';
            $total_amount_product_ttc .= $total_amount_ttc.','; 
        }
    }
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}
?>
