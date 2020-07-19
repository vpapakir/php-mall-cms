<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

if( isset($_POST['cooshopName']) && isset($_POST['cooshopURL']) && isset($_POST['cooshopHier']) ) {
	$cooshopHier = $_POST['cooshopHier'];
	$cooshopName = $_POST['cooshopName'];
	$cooshopURL  = $_POST['cooshopURL'];
	$cooshopStatusNew = $_POST['cooshopStatusNew'];
	
	$prepared_query = 'INSERT INTO cooshops (name,url,shop_hier,status_shop) VALUES (:name,:url,:hier,:status)';
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                      'name' => $cooshopName,
                      'url' => $cooshopURL,
                      'hier' => $cooshopHier,
					  'status' => $cooshopStatusNew
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