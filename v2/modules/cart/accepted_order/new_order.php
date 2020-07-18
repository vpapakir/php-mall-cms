<?php
try
{
    $date = date('Y-m-d H:i:s');

    if(isset($_GET['page']) && $_GET['page'] == 'transferred_order')
    {
        $status = 'onhold';
        if($_SESSION['recap_cart_rad_payment'] == 'reunion')
        {
            $date_payment = '0000-00-00 00:00:00';
        }
        else
        {
            $date_payment = $date; 
        }
        
    }
    else
    {
        $status = 'paid';
        
    }

    $query = $connectData->prepare('SELECT number_order_history FROM order_history
                                    ORDER BY number_order_history ASC');
    $query->execute();

    while($data = $query->fetch())
    {
        $number_order = $data['number_order_history'];           
    }
    $query->closeCursor();

    $number_order++;

    $query = $connectData->prepare('SELECT amount_order, delivery_address_order, billing_address_order FROM online_order
                                    WHERE id_order = :order AND id_user = :user');

    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                          ));
    if(($data = $query->fetch()) != false)
    {
        $amount_order = $data[0];
        $delivery_order = $data[1];
        $billing_order = $data[2];
    }
    $query->closeCursor();


    $prepared_query = 'INSERT INTO order_history
                        (id_product, id_user,qty_product_order_history,
                         date_order_history,number_order_history,
                         status_order_history,amount_order_history,
                         delivery_address_order_history,billing_address_order_history,
                         new_order_history,price_product_order_history,
                         id_destination_shipping,date_payment_order_history,
                         amount_shipping_order_history, ecotax_order_history,
                         cash_discount_order_history, amount_bonus)
                       VALUES
                        (:id_product, :id_user, :qty_product, :date,
                         :number_order, :status, :amount, :delivery, :billing,
                         :status_new, :price_product, :destination, :date_payment,
                         :amount_shipping, :ecotax, :cash_discount, :bonus)';

    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'id_product' => htmlspecialchars($total_id_product, ENT_QUOTES),
                          'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'qty_product' => htmlspecialchars($total_qty, ENT_QUOTES),
                          'date' => htmlspecialchars($date, ENT_QUOTES),
                          'number_order' => htmlspecialchars($number_order, ENT_QUOTES),
                          'status' => htmlspecialchars($status, ENT_QUOTES),
                          'amount' => htmlspecialchars($amount_order, ENT_QUOTES),
                          'delivery' => htmlspecialchars($delivery_order, ENT_QUOTES),
                          'billing' => htmlspecialchars($billing_order, ENT_QUOTES),
                          'status_new' => htmlspecialchars(1, ENT_QUOTES),
                          'price_product' => htmlspecialchars($total_amount_product_ttc, ENT_QUOTES),
                          'destination' => htmlspecialchars($selected_destination, ENT_QUOTES),
                          'date_payment' => htmlspecialchars($date_payment, ENT_QUOTES),
                          'amount_shipping' => htmlspecialchars($total_destination, ENT_QUOTES),
                          'ecotax' => htmlspecialchars($eco_taxe, ENT_QUOTES),
                          'cash_discount' => htmlspecialchars($discount_ttc, ENT_QUOTES),
                          'bonus' => htmlspecialchars($_SESSION['bonus_applied'], ENT_QUOTES)
                          ));
    $query->closeCursor();
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}
?>
