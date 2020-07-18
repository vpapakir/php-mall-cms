<?php
try
{
    $prepared_query = 'SELECT * FROM config_image
                       WHERE id_config_image = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $config_image_ratio_x = $data['ratiox_image'];
        $config_image_ratio_y = $data['ratioy_image'];
        $config_image_status_online = $data['statusonline_image'];
        $config_image_status_away = $data['statusaway_image'];
        $config_image_status_offline = $data['statusoffline_image'];
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
        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
    }
}
?>
