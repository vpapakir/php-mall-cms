<?php
for($i = 0; $i < count($id_order_history); $i++)
{
    if(isset($_POST['bt_change_order_closed_status'.$id_order_history[$i]]))
    {
        $new_status = htmlspecialchars($_POST['cboOrderClosedStatus'.$id_order_history[$i]], ENT_QUOTES);      
        
        try
        {
            if($new_status == 'paid' || $new_status == 'onhold')
            {
                $prepared_query = 'SELECT date_order_history FROM order_history 
                                   WHERE id_order_history = :id';
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $id_order_history[$i]);
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $date_order = $data[0];
                }
                $query->closeCursor();
                
                $prepared_query = 'UPDATE order_history 
                                   SET status_order_history = :new_status,
                                       date_payment_order_history = :date,
                                       new_order_history = :new
                                   WHERE id_order_history = :id';
                
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'new_status' => $new_status,
                                      'date' => $date_order,
                                      'new' => 1,
                                      'id' => $id_order_history[$i]
                                     ));
                $query->closeCursor();
            }
            else
            {
                $date = date('Y-m-d H:i:s', time());
                
                $prepared_query = 'UPDATE order_history 
                                   SET status_order_history = :new_status,
                                       date_payment_order_history = :date,
                                       new_order_history = :new
                                   WHERE id_order_history = :id';
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'new_status' => $new_status,
                                      'date' => $date,
                                      'new' => 0,
                                      'id' => $id_order_history[$i]
                                     ));
                $query->closeCursor();
            }

            $i = count($id_order_history);
            $_SESSION['order_history_expand_block'] = true;
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }
    }
}
?>
