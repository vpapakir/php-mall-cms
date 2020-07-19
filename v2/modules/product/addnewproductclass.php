<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

if( isset($_POST['className']) && isset($_POST['productTypeName']) ) {
	$className = $_POST['className'];
	$productTypeName = $_POST['productTypeName'];
	
	/*$prepared_query = 'INSERT INTO product_class (name_class_product_L1,url,shop_hier) VALUES (:name,:url,:hier)';
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                      'name' => $cooshopName,
                      'url' => $cooshopURL,
                      'hier' => $cooshopHier
                      ));
	$query->closeCursor();*/
	give_translation('edit_level.addnewproductclass.shop_added_successfully', '', $config_showtranslationcode);
} else {
	give_translation('edit_level.addnewproductclass.please_fill_in_all_the_info', '', $config_showtranslationcode);
}
?>