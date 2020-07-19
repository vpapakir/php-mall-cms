<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

$prepared_query = 'SELECT * FROM language WHERE status_language=1';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$i=0;
$codes = array();
while(($data = $query->fetch()) != false)
{
	$codes[$i] = $data['code_language'];
	$i++;
}

if( isset($_POST['typesForProductClass']) ) {

	$prepared_query = "INSERT INTO product_class VALUES (NULL,'".$_POST['productClassStatusNew']."',".rand().",";
	
	for($counter = 0; $counter < $i; $counter++) {
		$prepared_query = $prepared_query."'".$_POST['newProductGroupName'.$codes[$counter]]."',";
	}
	
	$prepared_query = $prepared_query."'";
	foreach ($_POST['typesForProductClass'] as $groups)
	{
        $prepared_query = $prepared_query.$groups.",";
	}
	$prepared_query = $prepared_query."')";
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
	$query->closeCursor();
	$result = 0;
	echo $result;
	//echo $prepared_query;
} else {
	$result = -1;
	echo $result;
}

?>