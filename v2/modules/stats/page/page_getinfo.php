<?php
try
{
    if(isset($stats_page_count)) {
    	#unset($stats_page_count);
    } else {
	$stats_page_count = 0;
    }
    $prepared_query = 'SELECT count_statspage FROM stats_page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $stats_page_count += $data[0];
    }
    $query->closeCursor();
    
    if(empty($stats_page_count))
    {
        $stats_page_count = 0;
    }
    
    $stats_page_count = $stats_page_count + $configadmin_stats_page_count;
    $stats_page_count = number_format($stats_page_count, 0, ',', '.');
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
