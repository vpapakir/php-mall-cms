<?php
if(!isset($_SESSION)) 
{
	session_start(); 
}
$tnumber = ($_GET['tnumber']) ? $_GET['tnumber'] : $_POST['tnumber'];

$_SESSION['tnumber'] = $tnumber;

echo $_SESSION['tnumber'];
?>