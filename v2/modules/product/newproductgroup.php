<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

$prepared_query = "SELECT * FROM language";
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$i=0;
$codes = array();
$statuses = array();
while(($data = $query->fetch()) != false)
{
	$codes[$i] = $data['code_language'];
	$statuses[$i] = $data['status_language'];
	$i++;
}

if( isset($_POST['shopsForProductGroup']) ) {

	$prepared_query = "INSERT INTO product_group VALUES ('".rand(1,1000)."','".$_POST['cooshopStatusEdit']."',".rand().",";
	
	for($counter = 0; $counter < $i; $counter++) {
		if($statuses[$counter] == 1) {
			$prepared_query = $prepared_query."'".$_POST['newProductGroupName'.$codes[$counter]]."',";
		} else {
				$prepared_query = $prepared_query."'NULL',";
		}
	}
	
	$prepared_query = $prepared_query."'";
	foreach ($_POST['shopsForProductGroup'] as $shops)
	{
        $prepared_query = $prepared_query.$shops.",";
	}
	$prepared_query = $prepared_query."')";
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
	$query->closeCursor();
	echo $prepared_query;
} else {
	$result = -1;
	echo $result;
}

?>