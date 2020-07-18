<?php
$_SESSION['error400_message'] = $e->getMessage();
if($_SESSION['index'] == 'index.php')
{
    die(header('Location: '.$config_customheader.'Error/400'));
}
else
{
    die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
}
?>
