<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

if( isset($_POST['cooshopNameEdit']) && isset($_POST['cooshopURLEdit']) && isset($_POST['cooshopHierEdit']) ) {
	$cooshopHierEdit = $_POST['cooshopHierEdit'];
	$cooshopNameEdit = $_POST['cooshopNameEDit'];
	$cooshopURLEdit  = $_POST['cooshopURLEdit'];
	$cooshopStatusEdit = $_POST['cooshopStatusEdit'];
	
	$prepared_query = 'UPDATE cooshops SET name=:name, url=:url, shop_hier=:shop_hier, status_shop=:status_shop WHERE name=:name';
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                      'name' => $cooshopNameEdit,
                      'url' => $cooshopURLEdit,
                      'shop_hier' => $cooshopHierEdit,
					  'status_shop' => $cooshopStatusEdit
                      ));
	$query->closeCursor();
	$result = 0;
	echo $result;
	//give_translation('edit_level.addnewshop.shop_added_successfully', '', $config_showtranslationcode);
} else {
	$result = -1;
	echo $result;
	//give_translation('edit_level.addnewshop.please_fill_in_all_the_info', '', $config_showtranslationcode);
}

?>