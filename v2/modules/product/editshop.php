<?php
$include_dbconnect_info = '../dbconnect/dinxdev/dbconnect_info.php';
include('../dbconnect/dinxdev/dbconnect.php');
include('../functions/function.php');

if( isset($_POST['cooshopName']) && isset($_POST['cooshopURL']) && isset($_POST['cooshopHier']) ) {
	$cooshopHier = $_POST['cooshopHier'];
	$cooshopName = $_POST['cooshopName'];
	$cooshopURL  = $_POST['cooshopURL'];
	$previousName = $_POST['cooshopPrevious'];
	
	$prepared_query = 'UPDATE cooshops SET name=:name,url=:url,shop_hier=:hier WHERE shop_id=:previousname';
	
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                      'name' => $cooshopName,
                      'url' => $cooshopURL,
					  'previousname' => $previousName,
                      'hier' => $cooshopHier
                      ));
	$query->closeCursor();
	give_translation('edit_level.editshop.shop_edited_successfully', '', $config_showtranslationcode);
} else {
	give_translation('edit_level.editshop.please_fill_in_all_the_info', '', $config_showtranslationcode);
}

?>