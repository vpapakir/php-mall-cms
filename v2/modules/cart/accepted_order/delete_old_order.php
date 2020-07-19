<?php
try
{
    $prepared_query = 'DELETE FROM online_order 
                       WHERE id_user = :user AND id_order = :order';
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                          ));
    $query->closeCursor();
    
    reallocate_table_id('id_order', 'online_order');
    
    $prepared_query = 'DELETE FROM cart 
                       WHERE id_user = :user AND id_order = :order';
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                          ));
    $query->closeCursor();
    
    reallocate_table_id('id_cart', 'cart');
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}
?>
