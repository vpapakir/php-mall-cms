<?php
try
{
    $prepared_query = 'SELECT COUNT(id_user) FROM user
                       WHERE status_user = 1
                       AND rights_user < 6';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_member_count = number_format($data[0], 0, ',', '.');
    }
    $query->closeCursor();
    
    if(empty($stats_member_count))
    {
        $stats_member_count = 0;
    }
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
