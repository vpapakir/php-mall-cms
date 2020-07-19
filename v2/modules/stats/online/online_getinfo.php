<?php
try
{
    $prepared_query = 'SELECT COUNT(id_statsonline) FROM stats_online
                       WHERE status_statsonline = 1
                       AND (rights_statsonline < 6 || rights_statsonline IS NULL)';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_online_count = number_format($data[0], 0, ',', '.');
    }
    $query->closeCursor();
    
    if(empty($stats_online_count))
    {
        $stats_online_count = 0;
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
