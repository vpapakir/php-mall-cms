<?php
if(!isset($_SESSION)) 
{
	session_start(); 
} else {
	echo "Session is already started";
}

$ordid = ($_GET['ordid']) ? $_GET['ordid'] : $_POST['ordid'];
?>
<html>
<head>
</head>
<body style="text-align:center;font-size:12px;">
<form method="post" enctype="application/x-www-form-urlencoded" action="passtnumber.php?ordid=<?php echo $ordid; ?>">
Rentrez le numero de colis:<input type="text" size="25" maxlength="25" name="tnumber"><br />
<input type="submit"><br />
</form>
</body>
</html>