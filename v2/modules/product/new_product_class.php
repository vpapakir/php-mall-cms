<form method="post" id="newProductClassForm" name="newProductClassForm" enctype="multipart/form-data">

<table>
<tr>
<td><?php give_translation('edit_level.new_product_class.product_class_name', '', $config_showtranslationcode); ?>:</td>
<td>
	<input id="className" name="className" type="text" />
</td>
</tr>

<tr>
<td><?php give_translation('edit_level.new_product_class.product_type_name', '', $config_showtranslationcode); ?>:</td>
<td>
<select id="productTypeName" name="productTypeName">
<?php
$prepared_query = 'SELECT * FROM product_type';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
while(($data = $query->fetch()) != false)
{
	echo "<option value=\"".$data['id_type_product']."\">".$data['name_type_product_L1']."</option>";
}
?>
</select>
</td>
</tr>

<tr>
<td><input id="bt_newProductClassForm" name="bt_newProductClassForm" type="submit" value="Submit" /></td>
<td><div id="results" name="results"></div></td>
</tr>
</table>

</form>

<script type="text/javascript">
	$(document).ready(function(){
		$("#newProductClassForm").validate({
			debug: false,
			rules: {
				className: "required",
				productTypeName: {
					required: true,
				}
			},
			messages: {
				className: "*",
				productTypeName:  "*",
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('modules/product/addnewproductclass.php', $("#newProductClassForm").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
</script>