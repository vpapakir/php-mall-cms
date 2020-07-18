<?php

$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

$prepared_query = 'SELECT * FROM cooshops WHERE shop_id=:shop_id';
$query = $connectData->prepare($prepared_query);
$query->execute(array(
					'shop_id' => $_POST['shop_select_cboShopSelect'];
				));
while(($data = $query->fetch()) != false) {

	$_SESSION['product_management_cboShopSelect'] = $data['url'];
	
}
?>