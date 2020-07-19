<?php
try
{
    $i = 0;
    
    $prepared_query = 'SELECT id_order_history FROM order_history';
    $query = $connectData->prepare($prepared_query); 
    $query->execute();
    
    while($data = $query->fetch())
    {
        $id_order_history[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}

for($i = 0; $i < count($id_order_history); $i++)
{
    if(isset($_POST['bt_change_order_pending_status'.$id_order_history[$i]]))
    {
        $new_status = htmlspecialchars($_POST['cboOrderPendingStatus'.$id_order_history[$i]], ENT_QUOTES);
        
        $date = date('Y-m-d H:i:s', time());
        
        if($new_status == 'paid' || $new_status == 'onhold')
        {
            try
            {
                $prepared_query = 'UPDATE order_history 
                                   SET status_order_history = :new_status,
                                       date_payment_order_history = :date,
                                       new_order_history = :new
                                   WHERE id_order_history = :id';

                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'new_status' => $new_status,
                                      'date' => $date,
                                      'new' => 1,
                                      'id' => $id_order_history[$i]
                                     )); 
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
        }
        else
        {
            try
            {
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
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
        }
        
        if($new_status == 'sent')
        {
            try
            {
                $prepared_query = 'SELECT * FROM order_history
                                   INNER JOIN user
                                   ON order_history.id_user = user.id_user
                                   WHERE id_order_history = :id';
                
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $id_order_history[$i]);
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $number_sent_order = $data['number_order_history'];
                    $email_sent_order = $data['email_user'];
                    //$id_user_sent_order = $data['id_user'];
                }
                $query->closeCursor();  
                
                $prepared_query = 'UPDATE order_history
                                   SET new_order_history = 1
                                   WHERE id_order_history = :id';
                
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $id_order_history[$i]);
                $query->execute();
                $query->closeCursor();                
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
            
            include('mail/order_sent/answer_order_sent.php');
            
//            $sender_message = '<TABLE align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\';" border="0">
//   
//                                        <td>
//                                           Chère cliente, Cher client
//                                        </td>
//
//                                    <tr style="height: 8px;"></tr>
//
//                                        <td>
//                                            Vous avez un nouveau message du site <span style="color: '.$company_color.'">'.$sitename.'</span>
//                                        </td>
//
//                                    <tr style="height: 8px;"></tr>
//
//                                        <td>
//                                            Nous avons expédié votre commande no. '.$number_sent_order.' aujourd\'hui
//                                        </td>
//
//                                    <tr></tr>
//
//                                        <td>
//                                            Toutefois, si au bout de 7 jours ouvrés, vous n\'avez toujours pas reçu cette dernière. Veuillez nous contacter via les coordonnées que vous trouverez en bas de cet email.
//                                        </td>
//
//                                    <tr style="height: 8px;"></tr>
//
//                                        <td>
//                                            Merci de votre confiance et de ne pas répondre à ce mail.
//                                        </td>
//
//                                    '.$signature.'
//
//                                </TABLE>';
//            
//            $prepared_query = 'INSERT INTO message_out
//                               (id_user, type_message_out, sender_message_out,
//                                receiver_message_out, subject_message_out,
//                                content_message_out, date_message_out,
//                                status_message_out, thread_message_out)
//                               VALUES
//                               (:user, :type, :sender, :receiver, :subject, :content,
//                                NOW(), :status, :thread)';
//            $query = $connectData->prepare($prepared_query);
//            $query->execute(array(
//                                  'user' => $id_user_sent_order,
//                                  'type' => 'order_sent',
//                                  'sender' => $used_mail_adress,
//                                  'receiver' => $email_sent_order,
//                                  'subject' => $subject,
//                                  'content' => $sender_message,
//                                  'status' => 1,
//                                  'thread' => 0
//                                  ));
//            $query->closeCursor();
        }
        
        $i = count($id_order_history);
    }
}
?>
