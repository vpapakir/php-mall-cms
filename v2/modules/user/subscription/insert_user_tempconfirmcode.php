<?php
$subscriptionform_random_confirmcode = null;
$subscriptionform_random_confirmcode = give_randomstr($strsearch, 0, 12, $onlynumber);


$prepared_query = 'INSERT INTO subscription_codeconfirm
                   (id_user, code_codeconfirm, date_codeconfirm)
                   VALUES
                   (:iduser, :code, NOW())';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'iduser' => $subscriptionform_lastiduser,
                      'code' => $subscriptionform_random_confirmcode
                      ));
$query->closeCursor();
?>
