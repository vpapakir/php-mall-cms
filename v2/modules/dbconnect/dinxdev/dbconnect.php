<?php
include($include_dbconnect_info);

try
{
   //connect to database
   $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
   $pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
   $connectData = new PDO('mysql:host='.$database_host.'; '.$database_connect.'', ''.$database_user.'',
                            ''.$database_pass.'', $pdo_options);
   
   $connectData->query('SET NAMES UTF8');
}
catch (Exception $e)
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
