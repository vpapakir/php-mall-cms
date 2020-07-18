<?php
if(!empty($_SESSION['product_edit_display_content']) && $_SESSION['product_edit_display_content'] === true)
{
	$prepared_query = 'SELECT * FROM config_module';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();
	while(($data = $query->fetch()) != false)
	{
		if($data['element_id'] == 'adminconfig_edit.module_immo') {
			if($data['immo_module'] == 1) { // If immo module is active
				include('modules/custom/immo/modules/Kprodimmo/situation/situation_main.php');
				include('modules/custom/immo/modules/Kprodimmo/interior/interior_main.php');
				include('modules/custom/immo/modules/Kprodimmo/exterior/exterior_main.php');
			} else {
				include('modules/custom/multishop/modules/Kprodimmo/situation/situation_main.php');
				include('modules/custom/multishop/modules/Kprodimmo/interior/interior_main.php');
				include('modules/custom/multishop/modules/Kprodimmo/exterior/exterior_main.php');
			}
		}
	}

}
?>