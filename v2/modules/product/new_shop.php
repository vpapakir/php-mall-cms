<form method="post" id="newShopForm" name="newShopForm" enctype="multipart/form-data">
<table>
  <tr>
    <td><label><?php give_translation('edit_level.new_shop.shop_name', '', $config_showtranslationcode); ?>:</label></td>
    <td><input id="cooshopName" name="cooshopName" size="40" maxlength="40" /></td>
  </tr>
  <tr>
    <td><label><?php give_translation('edit_level.new_shop.shop_URL', '', $config_showtranslationcode); ?>:</label></td>
    <td><input id="cooshopURL" name="cooshopURL" size="40" maxlength="40" /></td>
  </tr>
  <tr>
    <td><label><?php give_translation('edit_level.new_shop.shop_hierarcy', '', $config_showtranslationcode); ?>:</label></td>
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
      </select></td>
  </tr>
  <tr>
    <td><input id="bt_cboNewShopSelect" type="submit" name="bt_cboNewShopSelect" value="Register New Shop" onclick="">
      </input></td>
    <td><div id="results"></div></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#newShopForm").validate({
			debug: false,
			rules: {
				cooshopName: "required",
				cooshopURL: {
					required: true,
				},
				cooshopHier: "required"
			},
			messages: {
				cooshopName: "*",
				cooshopURL:  "*",
				cooshopHier: "*",
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('modules/product/addnewshop.php', $("#newShopForm").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
</script>