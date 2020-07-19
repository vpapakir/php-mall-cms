<form method="post" id="editShopForm" name="editShopForm" enctype="multipart/form-data">
  <table>
    <tr>
      <td><label><?php give_translation('edit_level.edit_shop.shop_name', '', $config_showtranslationcode); ?>:</label></td>
      <td><input id="cooshopName" name="cooshopName" size="30" maxlength="30" value="<?php $prepared_query = 'SELECT name FROM cooshops WHERE shop_id=:shop_id';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute(array('shop_id' => $_SESSION['product_management_cboShopSelect']));if(($data = $query->fetch()) != false) {echo $data['name'];}?>"/>
      </td>
    </tr>
    <tr>
      <td><label><?php give_translation('edit_level.edit_shop.shop_URL', '', $config_showtranslationcode); ?>:</label></td>
      <td><input id="cooshopURL" name="cooshopURL" size="30" maxlength="30"  value="<?php $prepared_query = 'SELECT url FROM cooshops WHERE shop_id=:shop_id';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute(array('shop_id' => $_SESSION['product_management_cboShopSelect']));if(($data = $query->fetch()) != false) {		echo $data['url'];}?>"/>
      </td>
    </tr>
    <tr>
      <td><label><?php give_translation('edit_level.edit_shop.hierarcy', '', $config_showtranslationcode); ?>:</label></td>
      <td><select id="cooshopHier" name="cooshopHier">
          <?php
$prepared_query = 'SELECT * FROM cooshops_hierarcy';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
while(($data = $query->fetch()) != false)
{
	echo "<option value=\"".$data['level_hierarcy']."\">".$data['name_hierarcy']."</option>";
}
?>
        </select><input name="cooshopPrevious" type="text" style="display:none;" value="<?php echo $_SESSION['product_management_cboShopSelect'];?>" id="cooshopPrevious" size="30" maxlength="30" readonly="readonly" /></td>
    </tr>
    <tr>
      <td><input id="bt_cboEditShopSelect" type="submit" name="bt_cboEditShopSelect" value="Submit" onclick="">
        </input></td>
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