<?php
try
{
    $prepared_query = 'SELECT * FROM config_admin
                       WHERE status_configadmin = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();    
    if(($data = $query->fetch()) != false)
    {
        $configadmin_stats_page_count = $data['stats_page_count'];
        $config_customfolder = $data['folder_name'];
        $config_customheader = $data['header_url'];
        $config_sitename = $data['sitename'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM config_module
                       WHERE status_configmodule = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();    
    if(($data = $query->fetch()) != false)
    {
        $config_module_immo = $data['immo_module'];
    }
    $query->closeCursor();
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
