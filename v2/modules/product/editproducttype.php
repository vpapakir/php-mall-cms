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

//if( isset($_POST['shopsForProductGroup']) ) {

	$prepared_query = "UPDATE product_type SET status_group_product='".$_POST['productTypeStatusEdit']."',code_type_product=".rand().",";
	
	for($counter = 0; $counter < $i; $counter++) {
		$prepared_query = $prepared_query."name_type_product_L".($counter+1)."='".$_POST['editProductTypeName'.$codes[$counter]]."',";
	}
	
	$prepared_query = $prepared_query."product_group_id='";
	foreach ($_POST['groupsForProductType'] as $shops)
	{
        $prepared_query = $prepared_query.$shops.",";
	}
	$prepared_query = $prepared_query."' WHERE name_product_type_L1='".$_POST['editProductGroupNameFR']."'";
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
	$query->closeCursor();
	$result = 0;
	echo $result;
	//echo $prepared_query;
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