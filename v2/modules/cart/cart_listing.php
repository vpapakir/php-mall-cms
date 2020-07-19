<?php
$used_language = $_SESSION['lang'];
$count_items = null;
$i = 0;
$j = 0;
$x = 0;
$total = null;

try
{  
    $query = $connectData->prepare('SELECT * FROM user_real
                                    WHERE id_user = :user');

    $query->bindParam('user', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
    $query->execute();   
    
    if(($data = $query->fetch()) != false)
    {
        $type_user = $data['type_real'];
        $bonus_real = $data['bonus_real'];
    }
    else
    {
        $type_user = 'public'; 
        $bonus_real = 0;
    }
    $query->closeCursor();
    
    $query = $connectData->prepare('SELECT * FROM online_order
                                    WHERE id_user = :user');

    $query->bindParam('user', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
    $query->execute();

    while($data = $query->fetch())
    {
        $last_id_order = $data[0];
    }
    $query->closeCursor();

    $query = $connectData->prepare('SELECT COUNT(id_product), id_product 
                                    FROM cart 
                                    WHERE id_order = :id_order AND id_user = :id_user
                                    GROUP BY id_product
                                    ORDER BY date_cart');

    $query->execute(array(
                          'id_order' => htmlspecialchars($last_id_order, ENT_QUOTES),
                          'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES)
                          ));

    while($data = $query->fetch())
    {
       $id_product[$i] = $data['id_product'];
       $number_product[$i] = $data['number_product'];
       $i++;
    }
    $query->closeCursor();

    if(!empty($id_product[0]) && $id_product[0] != null)
    {
        for($j = 0; $j < count($id_product); $j++)
        {
            $qty[$x] = null;
            $x++;
            $query = $connectData->prepare('SELECT * FROM product_details
                                            WHERE id_product = :id');

            $query->bindParam('id', htmlspecialchars($id_product[$j], ENT_QUOTES));
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $price_public[$j] = $data['price_public_details'];
                $price_resale[$j] = $data['price_resale_details'];
                $price_promo[$j] = $data['price_promo_details'];
            }
            $query->closeCursor();

            $query = $connectData->prepare('SELECT * FROM cart
                                            WHERE id_product = :id
                                            AND id_order = :order');

            $query->execute(array(
                                  'id' => htmlspecialchars($id_product[$j], ENT_QUOTES),
                                  'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                                  ));         

            while($data = $query->fetch())
            {
                $qty[$j] = $data['qty_product_cart'];    
            }
            $query->closeCursor();

            $count_items += $qty[$j];         
        } 

        for($j = 0; $j < count($id_product); $j++)
        {
            $query = $connectData->prepare('SELECT * FROM product pr
                                            INNER JOIN (product_details pr_de
                                            INNER JOIN product_stock pr_s ON pr_de.id_product = pr_s.id_product)
                                            ON pr.id_product = pr_de.id_product
                                            WHERE pr.id_product = :id_product');
            $query->bindParam('id_product', htmlspecialchars($id_product[$j], ENT_QUOTES));
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $id_product_cart[$j] = $data['id_product'];
                $image_product_cart[$j] = $data['image_thumb_product'];
                $name_product_cart[$j] = $data['name_product_'.$used_language];
                $intro_product_cart[$j] = $data['introduction_product_'.$used_language];
                $number_product_cart[$j] = $data['number_product'];
                $price_public_cart[$j] = number_format($data['price_public_details'], 2, '.', '');
                $available_stock_cart[$j] = $data['quantity_stock'];
                $ecotaxe_product_cart[$j] = $data['price_ecotax_details'];
                $price_promo_cart[$j] = number_format($data['price_promo_details'], 2, '.', '');
            }
        }
        
        $query = $connectData->prepare('SELECT id_country FROM user WHERE id_user = :user');
        $query->bindParam('user', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
           $id_country = $data[0]; 
        }
        else
        {
           $id_country = 0; 
        }
    }
}
catch (Exception $e)
{
    die("<br><span id=\"center_text\">Error : ".$e->getMessage().'</span>');
}
?>
