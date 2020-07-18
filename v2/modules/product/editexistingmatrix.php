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
while($data = $query->fetch())
{
	$codes[$i] = $data['code_language'];
	$statuses[$i] = $data['status_language'];
	$i++;
}

if(isset($_POST['matrix_status']) && isset($_POST['matrix_name_L1'])) {
	$status_matrix = $_POST['matrix_status'];
	$prepared_query = "UPDATE matrix VALUES ('".rand()."','$status_matrix',";
	
	for($counter = 0; $counter < $i; $counter++) {
		if($statuses[$counter] == 1) {
			if($counter == ($i-1)) {
				$prepared_query = $prepared_query."'".$_POST['matrix_name_L'.($counter+1)]."'";
			} else {
				$prepared_query = $prepared_query."'".$_POST['matrix_name_L'.($counter+1)]."',";
			}
		} else {
				$prepared_query = $prepared_query."'NULL',";
		}
	}
	$prepared_query = $prepared_query.")";

	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();

	$query->closeCursor();
	$result = 0;
	//echo "=>".$codes[0].$codes[1].$codes[2];
	echo $result;
	//echo $prepared_query;
} else {
	if(isset($_GET['matrix_status'])) {
	} else {
		$result = -1;
		echo $result;
	}
}
?>