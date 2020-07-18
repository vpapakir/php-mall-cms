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

//if( isset($_POST['shopsForProductGroup']) ) {

	$prepared_query = "UPDATE product_group SET status_group_product='".$_POST['productGroupStatusEdit']."',code_group_product=".rand().",";
	
	for($counter = 0; $counter < $i; $counter++) {
		if($statuses[$counter] == 1) {
			$prepared_query = $prepared_query."name_group_product_L".($counter+1)."='".$_POST['editProductGroupName'.$codes[$counter]]."',";
		} else {
			$prepared_query = $prepared_query."name_group_product_L".($counter+1)."='NULL',";
		}
	}
	
	$prepared_query = $prepared_query."product_shop_id='";
	foreach ($_POST['shopsForProductGroup'] as $shops)
	{
        $prepared_query = $prepared_query.$shops.",";
	}
	$prepared_query = $prepared_query."' WHERE name_product_group_L1='".$_POST['editProductGroupNameFR']."'";
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
	$query->closeCursor();
	//$result = 0;
	//echo $result;
	echo $prepared_query;
//} else {
	//$result = -1;
	//echo $result;
//}






















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