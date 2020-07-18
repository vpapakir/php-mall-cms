<?php
if(isset($_GET['user']))
{   
    $subscription_callback_codeconfirm = htmlspecialchars($_GET['user'], ENT_QUOTES);

    $prepared_query = 'SELECT id_user FROM subscription_codeconfirm
                       WHERE code_codeconfirm = :code';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('code', $subscription_callback_codeconfirm);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $subscription_callback_iduser = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'UPDATE user 
                       SET status_user = 1
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $subscription_callback_iduser);
    $query->execute();
    $query->closeCursor();
    
    $prepared_query = 'DELETE FROM subscription_codeconfirm 
                       WHERE code_codeconfirm = :code';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('code', $subscription_callback_codeconfirm);
    $query->execute();
    $query->closeCursor();
    
    reallocate_table_id('id_codeconfirm', 'subscription_codeconfirm');
}
?>
