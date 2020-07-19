<?php
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
    
    $query = $connectData->prepare('SELECT number_order_history FROM order_history
                                            ORDER BY number_order_history ASC');
    $query->execute();

    while($data = $query->fetch())
    {
        $number_order = $data['number_order_history'];           
    }
    $query->closeCursor();

    $number_order++;
    
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
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
?>
