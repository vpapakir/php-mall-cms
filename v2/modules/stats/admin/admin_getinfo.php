<?php
try
{
    unset($stats_admin_useronline, $stats_admin_usernick);
    $prepared_query = 'SELECT nickname_user, online_user FROM user
                       WHERE status_user = 1
                       AND rights_user > 5
                       AND rights_user < 9';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $stats_admin_useronline[$i] = $data[1];
        $stats_admin_usernick[$i] = $data[0];
        $i++;
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
