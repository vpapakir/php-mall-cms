<?php
$prepared_query = 'SELECT * FROM config_module';
$query = $connectData->prepare($prepared_query);
$query->execute();
while(($data = $query->fetch()) != false)
{
	echo '<tr>';
	echo '<td align="left">';
	//if(!empty($adminconfig_admin_module_immo) && $adminconfig_admin_module_immo == 1) {
	if($data['immo_module'] == 1) {
		echo '<input id="chkAdminconfigAdminModuleImmo" type="radio" name="chkAdminconfigAdminModuleImmo" value="1" checked="checked" disabled>';
		$adminconfig_selected_template = $data['name_configmodule'];
	} else {
		echo '<input id="chkAdminconfigAdminModuleImmo" type="radio" name="chkAdminconfigAdminModuleImmo" value="1" disabled>';
	}
	echo '</td>';
	echo '<td align="left" width="95%">';
	echo '<label class="font_main" for="chkAdminconfigAdminModuleImmo" style="cursor: pointer;">';
	echo give_translation($data['element_id'], $echo, $config_showtranslationcode);
	echo '</label>';
	echo '</td>';
	echo '</tr>';
}
$query->closeCursor();
?>
