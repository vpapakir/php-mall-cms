<?php
try
{
    $prepared_query = 'SELECT count_statsvisit FROM stats_visits
                      WHERE id_statsvisit = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_boxvisit_count = $data[0];
        $stats_boxvisit_count = number_format($stats_boxvisit_count, 0, ',', '.');
    }
    $query->closeCursor();
    
    if(empty($stats_boxvisit_count))
    {
        $stats_boxvisit_count = 0;
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
