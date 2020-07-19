<?php
	// echo $_SESSION['product_management_cboShopSelect'];
	// echo $_SESSION['product_management_cboGroupSelect'];
?>
<div id="editGroupdiv" class="editGroupdiv">
<form method="post" id="editGroupForm" name="editGroupForm" enctype="multipart/form-data">
	<table>
	
		<tr>
			<td><?php give_translation('edit_level.edit_group.shop_name', '', $config_showtranslationcode); ?>:</td>
			<td>
			<?php
				$prepared_query = 'SELECT * FROM cooshops WHERE shop_id=:selected_shop';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute(array(
								'selected_shop' => $_SESSION['product_management_cboShopSelect']
				));
				while(($data = $query->fetch()) != false) {
					echo '<input id="newShopName" name="newShopName" value="'.$data['name'].'" />';
				}
			?>
			</td>
		</tr>
	
		<tr>
			<td><?php give_translation('edit_level.edit_group.product_group_name', '', $config_showtranslationcode); ?>:</td>
			<td>
			<?php
				$prepared_query = 'SELECT * FROM product_group WHERE id_group_product=:selected_group';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute(array(
								'selected_group' => $_SESSION['product_management_cboGroupSelect']
				));
				while(($data = $query->fetch()) != false) {
					echo '<input id="newProductGroupName" name="newProductGroupName" value="'.$data['name_group_product_L1'].'" />';
				}
			?>
			<hr />
			</td>
		</tr>
	
		<tr>
			<td><?php give_translation('edit_level.edit_group.product_types', '', $config_showtranslationcode); ?>:</td>
			<td>
			<?php
				$prepared_query = 'SELECT * FROM product_type';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				echo "<table>";
				while(($data = $query->fetch()) != false) {
					echo '<tr><td><label>'.$data['name_type_product_L1'].'</label><input value="'.$data['name_type_product_L1'].'" type="checkbox" /></td></tr>';
				}
				echo "</table>";
			?>
			<hr />
			</td>
		</tr>
	
		<tr>
			<td><?php give_translation('edit_level.edit_group.product_classes', '', $config_showtranslationcode); ?>:</td>
			<td>
			<?php
				$prepared_query = 'SELECT * FROM product_class';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				echo "<table>";
				while(($data = $query->fetch()) != false) {
					echo '<tr><td><label>'.$data['name_class_product_L1'].'</label><input value="'.$data['name_class_product_L1'].'" type="checkbox" /></td></tr>';
				}
				echo "</table>";
			?>
			<hr />
			</td>
		</tr>

		<tr>
			<td><input id="bt_editGroupForm" name="bt_editGroupForm" type="submit" value="Submit" /></td>
			<td><div id="results"></div></td>
		</tr>

	</table>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#editShopForm").validate({
			debug: false,
			rules: {
				cooshopName: "required",
				cooshopURL: {
					required: true,
				},
				cooshopHier: "required",
				cooshopPrevious: "required"
			},
			messages: {
				cooshopName: "*",
				cooshopURL:  "*",
				cooshopPrevious: "required",
				cooshopHier: "*",
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('modules/product/editshop.php', $("#editShopForm").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
</script>
</div>