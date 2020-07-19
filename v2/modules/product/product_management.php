<?php
nosubmit_form_historyback();
#content
include('modules/product/content/product_content_getinfo.php');
#main
#upload
include('modules/product/bt/upload/bt_send_image_product.php');
include('modules/product/bt/upload/bt_delete_image_product.php');
#select
include('modules/product/select/bt_select/bt_cboProductSelect.php');
#expand
include('modules/product/bt/product_expand.php');
$_SESSION['product_management_cboShopSelect'] = "no selection";
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">
function setSelectedIndex(s, v) {
    for ( var i = 0; i < s.options.length; i++ ) {
        if ( s.options[i].value == v ) {
            s.options[i].selected = true;
            return;
        }
    }
}

function AddItem(Text,Value,Element)
{
	var opt = document.createElement("option");
	document.getElementById(Element).options.add(opt);
	opt.text = Text;
	opt.value = Value;
}
 
$(document).ready(function(){

    $(".newShopDiv").hide();
    $(".editShopDiv").hide();
    $(".newProductGroupDiv").hide();
    $(".editProductGroupDiv").hide();
    $(".newProductTypeDiv").hide();
    $(".editProductTypeDiv").hide();
    $(".newProductClassDiv").hide();
    $(".editProductClassDiv").hide();
    $(".shop_select_cboShopSelect").show();
    $(".shop_select_cboProductGroupSelect").hide();
    $(".shop_select_cboProductTypeSelect").hide();
    $(".shop_select_cboProductClassSelect").hide();
 
    $('#shop_select_cboShopSelect').change(function(){
		var e = document.getElementById("shop_select_cboShopSelect");
		var strUser = e.options[e.selectedIndex].value;
		if(strUser == 'new') {
			$(".newShopDiv").fadeIn("slow");
			$(".editShopDiv").fadeOut("slow");
			$(".newProductGroupDiv").fadeOut("slow");
			$(".editProductGroupDiv").fadeOut("slow");
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".shop_select_cboProductGroupSelect").fadeOut("slow");
			$(".shop_select_cboProductTypeSelect").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else if (strUser == 'select') {
			$(".newShopDiv").fadeOut("slow");
			$(".editShopDiv").fadeOut("slow");
			$(".newProductGroupDiv").fadeOut("slow");
			$(".editProductGroupDiv").fadeOut("slow");
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".shop_select_cboShopSelect").fadeIn("slow");
			$(".shop_select_cboProductGroupSelect").fadeOut("slow");
			$(".shop_select_cboProductTypeSelect").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else { // some shop selected: edit it and show product groups
			var ee = document.getElementById("cooshopNameEdit");
			ee.value = e.options[e.selectedIndex].innerHTML;
			$(".editShopDiv").fadeIn("slow");
			$(".newShopDiv").fadeOut("slow");
			$(".shop_select_cboProductGroupSelect").fadeIn("slow");
			var e2 = document.getElementById("shop_select_cboProductGroupSelect");
			if (e2.length == 2) {
				setSelectedIndex(e2,'new');
				$(".newProductGroupDiv").show();
				$(".editProductGroupDiv").hide();
			} else if( (e2.length == 3) ) {
				$(".newProductGroupDiv").hide();
				$(".editProductGroupDiv").show();
			} else {
				// Do nothing
			}
			/*$(".newShopDiv").fadeOut("slow");
			$(".editShopDiv").fadeOut("slow");
			document.getElementById('shop_select_cboShopSelect').disabled=true;*/
		}
    });
	
	$('#shop_select_cboProductGroupSelect').change(function(){
		$(".newShopDiv").fadeOut("slow");
		$(".editShopDiv").fadeOut("slow");
		document.getElementById('shop_select_cboShopSelect').disabled=true;
		var e = document.getElementById("shop_select_cboProductGroupSelect");
		var strUser = e.options[e.selectedIndex].value;
		if(strUser == 'new') {
			$(".newProductGroupDiv").fadeIn("slow");
			$(".editProductGroupDiv").fadeOut("slow");
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".shop_select_cboProductTypeSelect").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else if (strUser == 'select') {
			$(".editProductGroupDiv").fadeOut("slow");
			$(".newProductGroupDiv").fadeOut("slow");
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".shop_select_cboProductTypeSelect").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else { // some group selected: edit it and show product types
			var ee = document.getElementById("editProductGroupNameFR");
			ee.value = e.options[e.selectedIndex].innerHTML;
			$(".editProductGroupDiv").fadeIn("slow");
			$(".newProductGroupDiv").fadeOut("slow");
			//$(".newShopDiv").fadeOut("slow");
			//$(".editShopDiv").fadeOut("slow");
			$(".shop_select_cboProductTypeSelect").fadeIn("slow");
			var e3 = document.getElementById("shop_select_cboProductTypeSelect");
			if (e3.length == 2) {
				setSelectedIndex(e3,'new');
				$(".newProductTypeDiv").show();
				$(".editProductTypeDiv").hide();
			} else if( (e3.length == 3) ) {
				$(".newProductTypeDiv").hide();
				$(".editProductTypeDiv").show();
			} else {
				// Do nothing
			}
		}
	});

	$('#shop_select_cboProductTypeSelect').change(function(){
		$(".newShopDiv").fadeOut("slow");
		$(".editShopDiv").fadeOut("slow");
		$(".newProductGroupDiv").fadeOut("slow");
		$(".editProductGroupDiv").fadeOut("slow");
		document.getElementById('shop_select_cboShopSelect').disabled=true;
		document.getElementById('shop_select_cboProductGroupSelect').disabled=true;
		var e = document.getElementById("shop_select_cboTypeSelect");
		var strUser = e.options[e.selectedIndex].value;
		if(strUser == 'new') {
			$(".newProductTypeDiv").fadeIn("slow");
			//$(".newShopDiv").fadeOut("slow");
			//$(".editShopDiv").fadeOut("slow");
			//$(".newProductGroupDiv").fadeOut("slow");
			//$(".editProductGroupDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else if (strUser == 'select') {
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeOut("slow");
			$(".shop_select_cboProductClassSelect").fadeOut("slow");
		} else { // some type selected: edit it and show product classes
			var ee = document.getElementById("editProductTypeNameFR");
			ee.value = e.options[e.selectedIndex].innerHTML;
			$(".newProductTypeDiv").fadeOut("slow");
			$(".editProductTypeDiv").fadeIn("slow");		
			$(".shop_select_cboProductClassSelect").fadeIn("slow");
			var e4 = document.getElementById("shop_select_cboProductClassSelect");
			if (e4.length == 2) {
				setSelectedIndex(e4,'new');
				$(".newProductClassDiv").show();
				$(".editProductClassDiv").hide();
			} else if( (e4.length == 3) ) {
				$(".newProductClassDiv").hide();
				$(".editProductClassDiv").show();
			} else {
				// Do nothing
			}
		}
	});

	$('#shop_select_cboProductClassSelect').change(function(){
		$(".newShopDiv").fadeOut("slow");
		$(".editShopDiv").fadeOut("slow");
		$(".newProductGroupDiv").fadeOut("slow");
		$(".editProductGroupDiv").fadeOut("slow");
		$(".newProductTypeDiv").fadeOut("slow");
		$(".editProductTypeDiv").fadeOut("slow");
		document.getElementById('shop_select_cboShopSelect').disabled=true;
		document.getElementById('shop_select_cboProductGroupSelect').disabled=true;
		document.getElementById('shop_select_cboProductTypeSelect').disabled=true;
		document.getElementById('shop_select_cboTypeSelect').disabled=true;
		var e = document.getElementById("shop_select_cboClassSelect");
		var strUser = e.options[e.selectedIndex].value;
		if(strUser == 'new') {
			//$(".newShopDiv").fadeOut("slow");
			//$(".editShopDiv").fadeOut("slow");
			//$(".newProductGroupDiv").fadeOut("slow");
			//$(".editProductGroupDiv").fadeOut("slow");
			//$(".newProductTypeDiv").fadeOut("slow");
			//$(".editProductTypeDiv").fadeOut("slow");
			$(".editProductClassDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeIn("slow");
		} else if (strUser == 'select') {
			$(".editProductClassDiv").fadeOut("slow");
			$(".newProductClassDiv").fadeOut("slow");
		} else { // some group selected: edit it and show product types
			$(".editProductClassDiv").fadeIn("slow");
			$(".newProductClassDiv").fadeOut("slow");
		}
	});
});
</script>

<?php
	$prepared_query = 'SELECT bgcolor_body FROM structure_body WHERE id_body=:id_body';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute(array(
				'id_body' => $_SESSION['cooshopid']
	));
	while(($data = $query->fetch()) != false)
	{
		$_SESSION['body_bg_color'] = $data['bgcolor_body'];
	}	
?>

<style>

.newShopDiv {
}

.editShopDiv {
}

.newProductGroupDiv {
}

.editProductGroupDiv {
}

.newProductTypeDiv {
}

.editProductTypeDiv {
}

.newProductClassDiv {
}

.editProductClassDiv {
}

.shop_select_cboShopSelect {
}

.shop_select_cboProductGroupSelect {
}

.shop_select_cboProductTypeSelect {
}

.shop_select_cboProductClassSelect {
}
 
.show_hide {
    display:none;
}

</style>

<div id="shop_select_cboProductShopSelect" class="shop_select_cboProductShopSelect">
<table class="block_expandmain1" width="100%" border="0">
	<form method="post" id="selectShopForm" name="selectShopForm" enctype="multipart/form-data">
		<tr>
			<td><?php give_translation('edit_level.product_management.select_shop', '', $config_showtranslationcode); ?>: </td>
			<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
				<span class="font_subtitle">
					<select name="shop_select_cboShopSelect" onchange="selectShop();" id="shop_select_cboShopSelect" class="shop_select_cboShopSelect" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
						<option value="select"><?php give_translation('edit_level.product_management.shop_select_cboShopSelect.select_shop', '', $config_showtranslationcode);?></option>
						<?php
							if($_SESSION['cooshopid'] == 1) {
						?>
						<option value="new"><?php give_translation('edit_level.product_management.shop_select_cboShopSelect.new_shop', '',$config_showtranslationcode); ?></option>
						<?php
							}
						?>
						<?php
							if($_SESSION['cooshopid'] == 1) { 
								$prepared_query = 'SELECT * FROM cooshops WHERE shop_hier > 1';
							} else {
								$prepared_query = 'SELECT * FROM cooshops WHERE shop_id=:shop_id';
							}
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							if($_SESSION['cooshopid'] == 1) {
								$query->execute();
							} else {
								$query->execute(array(
									'shop_id' => $_SESSION['cooshopid']
								));
							}
							if($query->rowCount() == 0) {
								//
							} else if( $query->rowCount() == 1) {
								//
							} else {
								// 
							}
							while(($data = $query->fetch()) != false)
							{
								$Bok_productproperty = false;
								if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) )
								{
									echo "<option value=\"".$data['shop_id']."\" selected=\"selected\">".$data['name']."</option>";
								} else {
									echo "<option value=\"".$data['shop_id']."\">".$data['name']."</option>";
								}
							}
						?>
					</select>
				</span>
			</td>
		</tr>

		<script type="text/javascript">
			function selectShop() {
				$(document).ready(function(){
					$("#shop_select_cboShopSelect").change({
						debug: false,
						rules: {
						},
						messages: {
						},
						submitHandler: function(form) {
							$.post('modules/product/shopselected.php', $("#shop_select_cboShopSelect").serialize(), function(data) {
							});
						}
					});
				});
			}
		</script>		
		
	</form>
	
	<div>&nbsp;</div>
	
	<div id="newShopDiv" class="newShopDiv">
		<form method="post" id="newShopForm" name="newShopForm" enctype="multipart/form-data">
			<tr class="newShopDiv">
				<td><label><?php give_translation('edit_level.new_shop.shop_name', '', $config_showtranslationcode); ?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>"><input id="cooshopName" name="cooshopName" size="40" maxlength="40" type="text" required="required" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>"/></td>
			</tr>
			<tr class="newShopDiv">
				<td><label><?php give_translation('edit_level.new_shop.shop_URL', '', $config_showtranslationcode); ?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>"><input id="cooshopURL" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>" name="cooshopURL" size="40" maxlength="40" type="text" value="<?php echo "Shop URL...";?>" required="required" /></td>
			</tr>
			
			<tr class="newShopDiv">
				<td><label><?php give_translation('edit_level.new_shop.shop_hierarcy', '', $config_showtranslationcode); ?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>"><select id="cooshopHier" name="cooshopHier">
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
					</select>
				</td>
			</tr>
			
			<tr class="newShopDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="cooshopStatusNew" name="cooshopStatusNew" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
						<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?> </option>
						<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>
			</tr>
			
			<tr class="newShopDiv">
				<td colspan="3" style="border-top: 1px solid lightgrey;text-align:center;">
					<input id="bt_cboNewShopSelect" type="submit" name="bt_cboNewShopSelect" value="<?php give_translation('#*Register New Shop', $echo, $config_showtranslationcode);?>" onclick=""></input><div id="newShopResults"></div>
				</td>
			</tr>

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
							if(data == 0) {
								$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.shop_added_successfully', '', $config_showtranslationcode);?>");
							} else {
								$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.please_fill_in_all_the_info', '', $config_showtranslationcode);?>");
							}
							//$('#shop_select_cboProductShopSelect').load(window.location.href + ' #shop_select_cboProductShopSelect');
							$(".newShopDiv").fadeOut("slow");
							$(".newShopDiv").fadeIn("slow");
						});
					}
				});
			});
		</script>
	</div>
	
	<div id="editShopDiv" class="editShopDiv">
		<form id="editShopForm" name="editShopForm">
			<tr class="editShopDiv">
			  <td><label><?php give_translation('edit_level.edit_shop.shop_name', '', $config_showtranslationcode); ?>:</label></td>
			  <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>"><input id="cooshopNameEdit" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>" name="cooshopNameEdit" size="30" required="required" maxlength="30" value="<?php $prepared_query = 'SELECT name FROM cooshops WHERE shop_id=:shop_id';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute(array('shop_id' => $_SESSION['product_management_cboShopSelect']));if(($data = $query->fetch()) != false) {echo $data['name'];}?>"/>
			  </td>
			</tr>
			<tr class="editShopDiv">
				<td>
					<label><?php give_translation('edit_level.edit_shop.shop_URL', '', $config_showtranslationcode); ?></label>
				</td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<input id="cooshopURLEdit" name="cooshopURLEdit" required="required" size="30" maxlength="30" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>" value="<?php /*$prepared_query = 'SELECT url FROM cooshops WHERE shop_id=:shop_id';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute(array('shop_id' => $_SESSION['product_management_cboShopSelect']));if(($data = $query->fetch()) != false) {echo $data['url'];}*/echo "Shop URL...";?>"/>
				</td>
			</tr class="editShopDiv">
			<tr class="editShopDiv">
			  <td><label><?php give_translation('main.edit_level.edit_shop.hierarcy', '', $config_showtranslationcode); ?></label></td>
			  <td colspan="2"><select id="cooshopHierEdit" name="cooshopHierEdit" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
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
			<tr class="editShopDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2">
					<select id="cooshopStatusEdit" name="cooshopStatusEdit">
						<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>
			</tr>
			<tr class="editShopDiv">
				<td colspan="3" style="border-top: 1px solid lightgrey;text-align:center;">
					<input id="bt_cboEditShopSelect" type="submit" name="bt_cboEditShopSelect" value="<?php give_translation('#*Modify', $echo, $config_showtranslationcode);?>" onclick="editShop();"></input>
					<input id="bt_cboEditShopSelectDelete" type="submit" name="bt_cboEditShopSelectDelete" value="<?php give_translation('#*Delete Shop', $echo, $config_showtranslationcode);?>" onclick="deleteShop();"></input><div id="editShopResults"></div>
				</td>
			</tr>
		</form>

		<script type="text/javascript">
			function editShop() {
				$(document).ready(function(){
					$("#editShopForm").validate({
						debug: false,
						rules: {
							cooshopNameEdit: "required",
							cooshopURLEdit: {
								required: true,
							},
							cooshopHierEdit: "required",
							cooshopStatusEdit: "required"
						},
						messages: {
							cooshopNameEdit: "*",
							cooshopURLEdit:  "*",
							cooshopHierEdit: "*",
							cooshopStatusEdit: "required"
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/editexistingshop.php', $("#editShopForm").serialize(), function(data) {
								if(data == 0) {
									$('#editShopResults').html(data); // TO ADD: translation
								} else {
									$('#editShopResults').html(data); // TO ADD: translation
								}
								//$('#shop_select_cboProductShopSelect').load(window.location.href + ' #shop_select_cboProductShopSelect');
							});
						}
					});
				});
			}
			
			function deleteShop() {
				$(document).ready(function(){
					$("#editShopForm").validate({
						debug: false,
						rules: {
							cooshopNameEdit: "required",
							cooshopURLEdit: {
								required: true,
							},
							cooshopHierEdit: "required",
							cooshopStatusEdit: "required"
						},
						messages: {
							cooshopNameEdit: "*",
							cooshopURLEdit:  "*",
							cooshopHierEdit: "*",
							cooshopStatusEdit: "required"
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/deleteexistingshop.php', $("#editShopForm").serialize(), function(data) {
								if(data == 0) {
									$('#editShopResults').html(data); // TO ADD: translation
								} else {
									$('#editShopResults').html(data); // TO ADD: translation
								}
							});
							//$('#shop_select_cboProductShopSelect').load(window.location.href + ' #shop_select_cboProductShopSelect');
						}
					});
				});			
			}
			
		</script>
	</div>
	
</table>

</div>

<!-- <div>&nbsp;</div> -->

<div id="shop_select_cboProductGroupSelectDiv" class="shop_select_cboProductGroupSelect">
	<table class="block_expandmain1" width="100%" border="0">	
		<tr>
		<td class="shop_select_cboProductGroupSelect">
			<?php give_translation('edit_level.product_management.select_group', '', $config_showtranslationcode).":"; ?>
		</td>
		<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
			<span class="font_subtitle">
			<select name="shop_select_cboProductGroupSelect" id="shop_select_cboProductGroupSelect" class="shop_select_cboProductGroupSelect">
			  <option value="select"><?php give_translation('edit_level.product_management.shop_select_cboGroupSelect.select_group', '', $config_showtranslationcode); ?></option>
			  <option value="new"><?php give_translation('edit_level.product_management.shop_select_cboGroupSelect.new_group', '', $config_showtranslationcode); ?></option>
			  <?php
						if($_SESSION['cooshopid'] == 1) { 
							$prepared_query = 'SELECT * FROM product_group';
						} else {
							$prepared_query = 'SELECT * FROM product_group WHERE product_shop_id=:this_shop_id';
						}
						if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
						$query = $connectData->prepare($prepared_query);
						if($_SESSION['cooshopid'] == 1) {
							$query->execute();
						} else {
							$query->execute(array(
								'this_shop_id' => $_SESSION['cooshopid']
							));
						}
						while(($data = $query->fetch()) != false)
						{
							if( ((!empty($_SESSION['product_management_cboGroupSelect'])) && (strcmp($_SESSION['product_management_cboGroupSelect'],$data['id_group_product'])==0) ) ) {
									echo "<option value=\"".$data['id_group_product']."\" selected=\"selected\">".$data['name_group_product_L1']."</option>";
								} else {
									echo "<option value=\"".$data['id_group_product']."\">".$data['name_group_product_L1']."</option>";
								}
						}
					?>
			</select>
			</span>
		</td>
		</tr>
<div>&nbsp;</div>
<div id="newProductGroupDiv" class="newProductGroupDiv">
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
		<form method="post" id="newProductGroupForm" name="newProductGroupForm" class="newProductGroupDiv" enctype="multipart/form-data">
			<?php
			
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				while(($data = $query->fetch()) != false)
				{
					echo '<tr class="newProductGroupDiv">';
					echo "<td><label>"; give_translation('#*Group Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
					echo '<td colspan="2" width="70%"><input id="newProductGroupName'.$data['code_language'].'" name="newProductGroupName'.$data['code_language'].'" size="30" maxlength="30" required="required" value="DUMMY DATA" type="text" /></td>';
					echo "</tr>";
				}
			
			?>

			<tr class="newProductGroupDiv">
				<td><?php give_translation('edit_level.product_management.select_shops', '', $config_showtranslationcode); ?></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
				<select name="shopsForProductGroup[]" multiple>
					<?php
						if($_SESSION['cooshopid'] == 1) { 
							$prepared_query = 'SELECT * FROM cooshops WHERE shop_hier > 1';
						} else {
							$prepared_query = 'SELECT * FROM cooshops WHERE shop_id=:shop_id';
						}
						if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
						$query = $connectData->prepare($prepared_query);
						if($_SESSION['cooshopid'] == 1) {
							$query->execute();
						} else {
							$query->execute(array(
								'shop_id' => $_SESSION['cooshopid']
							));
						}
						while(($data = $query->fetch()) != false)
						{
							$Bok_productproperty = false;
							if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
								echo "<option value=\"".$data['shop_id']."\" selected=\"selected\">".$data['name']."</option>";
							} else {
								echo "<option value=\"".$data['shop_id']."\">".$data['name']."</option>";
							}
						}
					?>
				</select>
				</td>			
			</tr>
			
			<tr class="newProductGroupDiv">
				<td>
					<label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label>
				</td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="productGroupStatusEdit" name="cooshopStatusEdit">
						<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>					
			</tr>

			<tr class="newProductGroupDiv">
				<td colspan="3" style="border-top: 1px solid lightgrey;text-align:center;"><input id="bt_cboNewGroupSelect" type="submit" name="bt_cboNewGroupSelect" value="<?php give_translation('#*Register New Group', $echo, $config_showtranslationcode);?>" onclick="newProductGroup();"></input><input id="bt_closeNewGroupSelect" name="bt_closeNewGroupSelect" type="submit" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" onclick="closeProductGroupNew();" /><div id="newProductGroupResults"></div></td>
			</tr>
		</form>
		<script type="text/javascript">
			function closeProductGroupNew() {
				$(document).ready(function(){
					$("#newProductGroupForm").validate({
						debug: false,
						rules: {
							productGroupStatusEdit: "required"
						},
						messages: {
							productGroupStatusEdit: "*",
						},
						submitHandler: function(form) {
							$(".shop_select_cboProductGroupSelect").fadeOut("slow");
							document.getElementById('shop_select_cboShopSelect').disabled=false;
							$(".editShopDiv").fadeIn("slow");
							setSelectedIndex(document.getElementById('shop_select_cboProductGroupSelect'),'select');
							$(".shop_select_cboProductGroupSelect").fadeIn("slow");
							$('.newProductGroupDiv').hide();
							$('.editProductGroupDiv').hide();
							$(".shop_select_cboProductTypeSelect").hide();
							$(".shop_select_cboProductClassSelect").hide();
						}
					});
				});
			}
			
			function newProductGroup() {
				$(document).ready(function(){
					$("#newProductGroupForm").validate({
						debug: false,
						rules: {
							productGroupStatusEdit: "required"
						},
						messages: {
							productGroupStatusEdit: "*",
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/newproductgroup.php', $("#newProductGroupForm").serialize(), function(data) {
								if(data == -1) {
									// Error occured
									$('#newProductGroupResults').html(data);
								} else {
									var tokens = data.split(",");
									var tokens2 = tokens[0].split("(");
									AddItem(tokens[1].substring(1, tokens[1].length-1),tokens2[1],'shop_select_cboProductGroupSelect');
									$('#newProductGroupResults').html("ADD SUCCESS MESSAGE");
								}
							});
						}
					});
				});			
			}
		</script>
	<!-- </table> -->
</div>

<div id="editProductGroupDiv" class="editProductGroupDiv">
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
		<form method="post" id="editProductGroupForm" name="editProductGroupForm" class="editProductGroupDiv" enctype="multipart/form-data">
			<?php
			
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				while(($data = $query->fetch()) != false)
				{
					echo '<tr class="editProductGroupDiv">';
					echo "<td><label>"; give_translation('#*Group Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
					echo '<td colspan="2" width="70%"><input id="editProductGroupName'.$data['code_language'].'" name="editProductGroupName'.$data['code_language'].'" size="40" maxlength="40" required="required" type="text" value="DUMMY DATA" /></td>';
					echo "</tr>";
				}
			
			?>
			
			<tr class="editProductGroupDiv">
				<td><?php give_translation('edit_level.product_management.select_shops', '', $config_showtranslationcode); ?></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
				<select name="shopsForProductGroup[]" multiple>
					<?php
						if($_SESSION['cooshopid'] == 1) { 
							$prepared_query = 'SELECT * FROM cooshops WHERE shop_hier > 1';
						} else {
							$prepared_query = 'SELECT * FROM cooshops WHERE shop_id=:shop_id';
						}
						if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
						$query = $connectData->prepare($prepared_query);
						if($_SESSION['cooshopid'] == 1) {
							$query->execute();
						} else {
							$query->execute(array(
								'shop_id' => $_SESSION['cooshopid']
							));
						}
						while(($data = $query->fetch()) != false)
						{
							$Bok_productproperty = false;
							if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
								echo "<option value=\"".$data['shop_id']."\" selected=\"selected\">".$data['name']."</option>";
							} else {
								echo "<option value=\"".$data['shop_id']."\">".$data['name']."</option>";
							}
						}
					?>
				</select>
				</td>			
			</tr>
			
			<tr class="editProductGroupDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="productGroupStatusEdit" name="productGroupStatusEdit">
						<option value="enabled"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="disabled"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>
			</tr>
			<tr class="editProductGroupDiv">
				<td colspan="3" style="text-align: center;border-top: 1px solid lightgrey;">
					<input id="bt_cboEditProductGroupSelect" type="submit" name="bt_cboEditProductGroupSelect" value="<?php give_translation('#*Modify', $echo, $config_showtranslationcode);?>" onclick="editProductGroup();"></input>
					<input id="bt_cboEditProductGroupSelectDelete" type="submit" name="bt_cboEditProductGroupSelectDelete" value="<?php give_translation('#*Delete', $echo, $config_showtranslationcode);?>" onclick="deleteProductGroup();"></input><input id="bt_closeEditGroupSelect" name="bt_closeEditGroupSelect" type="submit" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" onclick="closeProductGroupEdit();" /><div id="newProductGroupResults"><div id="editProductGroupResults"></div>
				</td>
			</tr>
		</form>
		<script type="text/javascript">
			function closeProductGroupEdit() {
				$(document).ready(function(){
					$("#editProductGroupForm").validate({
						debug: false,
						rules: {
							productGroupStatusEdit: "required"
						},
						messages: {
							productGroupStatusEdit: "required"
						},
						submitHandler: function(form) {
							$(".shop_select_cboProductGroupSelect").fadeOut("slow");
							$(".shop_select_cboProductTypeSelect").fadeOut("slow");
							document.getElementById('shop_select_cboShopSelect').disabled=false;
							$(".editShopDiv").fadeIn("slow");
							setSelectedIndex(document.getElementById('shop_select_cboProductGroupSelect'),'select');
							//$('editProductGroupDiv').find('editProductGroupForm')[0].reset();
							//$('newProductGroupDiv').fadeIn("slow");
							$(".shop_select_cboProductGroupSelect").fadeIn("slow");
							$('.newProductGroupDiv').hide();
							$('.editProductGroupDiv').hide();
							$(".shop_select_cboProductTypeSelect").hide();
							$(".shop_select_cboProductClassSelect").hide();
						}
					});
					
				});
			}
			
			function editProductGroup() {
				$(document).ready(function(){
					$("#editProductGroupForm").validate({
						debug: false,
						rules: {
							productGroupStatusEdit: "required"
						},
						messages: {
							productGroupStatusEdit: "required"
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/editproductgroup.php', $("#editProductGroupForm").serialize(), function(data) {
								alert(data);
								if(data == 0) {
									$('#editProductGroupResults').html("ADD SUCCESS MESSAGE"); // TODO: Replace with multilingual messages
								} else {
									$('#editProductGroupResults').html(data); // TODO: Replace with multilingual messages
								}
							});
						}
					});
				});			
			}

			function deleteProductGroup() {
				$(document).ready(function(){
					$("#editProductGroupForm").validate({
						debug: false,
						rules: {
							productGroupStatusEdit: "required"
						},
						messages: {
							productGroupStatusEdit: "required"
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/deleteproductgroup.php', $("#editProductGroupForm").serialize(), function(data) {
								if(data == 0) {
									$('#editProductGroupResults').html("ADD SUCCESS MESSAGE"); // TODO: Replace with multilingual messages
								} else {
									$('#editProductGroupResults').html(data); // TODO: Replace with multilingual messages
								}
							});
						}
					});
				});			
			}
		</script>
	<!-- </table> -->
</div>	
	</table>
	
</div>
	
<!-- <div>&nbsp;</div> -->
	
<div id="shop_select_cboProductTypeSelect" class="shop_select_cboProductTypeSelect">
	<table class="block_expandmain1" width="100%" border="0">
		<span class="font_subtitle">
			<tr class="shop_select_cboProductTypeSelect">
				<td>
					<?php give_translation('edit_level.product_management.select_type', '', $config_showtranslationcode).":"; ?>
				</td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select name="shop_select_cboTypeSelect" id="shop_select_cboTypeSelect" class="shop_select_cboTypeSelect">
					  <option value="select"><?php give_translation('edit_level.product_management.shop_select_cboTypeSelect.select_type', '', $config_showtranslationcode); ?></option>
					  <option value="new"><?php give_translation('edit_level.product_management.shop_select_cboTypeSelect.new_type', '', $config_showtranslationcode); ?></option>
					  <?php
								$prepared_query = 'SELECT * FROM product_type';
								if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
								$query = $connectData->prepare($prepared_query);
								$query->execute();
								while(($data = $query->fetch()) != false)
								{
									if( ((!empty($_SESSION['product_management_cboTypeSelect'])) && (strcmp($_SESSION['product_management_cboTypeSelect'],$data['id_type_product'])==0) ) ) {
											echo "<option value=\"".$data['id_type_product']."\" selected=\"selected\">".$data['name_type_product_L1']."</option>";
										} else {
											echo "<option value=\"".$data['id_type_product']."\">".$data['name_type_product_L1']."</option>";
										}
								}
							?>
					</select>
				</td>
			</tr>
		</span>
		
		<div>&nbsp;</div>

<div id="newProductTypeDiv" class="newProductTypeDiv">
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
		<form method="post" id="newProductTypeForm" name="newProductTypeForm" class="newProductTypeDiv" enctype="multipart/form-data">
			<?php
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				while(($data = $query->fetch()) != false)
				{
					echo '<tr class="newProductTypeDiv">';
					echo "<td><label>"; give_translation('#*Product Type Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
					echo '<td><input id="newProductTypeName'.$data['code_language'].'" name="newProductTypeName'.$data['code_language'].'" size="30" maxlength="30" required="required" value="DUMMY DATA" type="text" /></td>';
					echo "</tr>";
				}
			?>
			
			<tr class="newProductTypeDiv">
				<td><?php give_translation('#*Select Group', $echo, $config_showtranslationcode);?></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select name="groupsForProductType[]" multiple>
						<?php
							if($_SESSION['cooshopid'] == 1) { 
								$prepared_query = 'SELECT * FROM product_group';
							} else {
								$prepared_query = 'SELECT * FROM product_group WHERE product_shop_id LIKE %:shop_id%';
							}
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							if($_SESSION['cooshopid'] == 1) {
								$query->execute();
							} else {
								$query->execute(array(
									'shop_id' => $_SESSION['cooshopid']
								));
							}
							while(($data = $query->fetch()) != false)
							{
								$Bok_productproperty = false;
								if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
									echo "<option value=\"".$data['id_group_product']."\" selected=\"selected\">".$data['name_group_product_L1']."</option>";
								} else {
									echo "<option value=\"".$data['id_group_product']."\">".$data['name_group_product_L1']."</option>";
								}
							}
						?>
					</select>
				</td>
			</tr>
			
			<tr class="newProductTypeDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="productTypeStatusNew" name="productTypeStatusNew">
						<option value="enabled"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="disabled"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>
			</tr>
			
			<tr class="newProductTypeDiv">
				<td colspan="3" style="text-align: center;border-top: 1px solid lightgrey;">
					<input id="bt_cboNewProductTypeSelect" type="submit" name="bt_cboNewProductTypeSelect" value="<?php give_translation('#*Register New Type', $echo, $config_showtranslationcode);?>" onclick="newProductType();"></input>
					<input id="bt_cboNewProductTypeSelectClose" name="bt_cboNewProductTypeSelectClose" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" type="submit" onclick="newProductTypeClose();" /><div id="newProductTypeResults"></div>
				</td>
			</tr>
		</form>
		<script type="text/javascript">
			function newProductTypeClose() {
				$(document).ready(function(){
					$("#newProductTypeForm").validate({
						debug: false,
						rules: {
							productTypeStatusNew: "required"
						},
						messages: {
							productTypeStatusNew: "required"
						},
						submitHandler: function(form) {
							//$(".shop_select_cboProductGroupSelect").fadeOut("slow");
							$(".shop_select_cboProductClassSelect").fadeOut("slow");
							document.getElementById('shop_select_cboProductGroupSelect').disabled=false;
							$(".editProductGroupDiv").fadeIn("slow");
							setSelectedIndex(document.getElementById('shop_select_cboTypeSelect'),'select');
							//$('editProductGroupDiv').find('editProductGroupForm')[0].reset();
							//$('newProductGroupDiv').fadeIn("slow");
							$(".shop_select_cboProductTypeSelect").fadeIn("slow");
							$('.newProductTypeDiv').hide();
							$('.editProductTypeDiv').hide();
							//$(".shop_select_cboProductTypeSelect").hide();
							//$(".shop_select_cboProductClassSelect").hide();
						}
					});
				});
			}
			
			function newProductType() {
				$(document).ready(function(){
					$("#newProductTypeForm").validate({
						debug: false,
						rules: {
							productTypeStatusNew: "required"
						},
						messages: {
							productTypeStatusNew: "required"
						},
						submitHandler: function(form) {
							// do other stuff for a valid form
							$.post('modules/product/newproducttype.php', $("#newProductTypeForm").serialize(), function(data) {
								$('#newProductTypeResults').html(data);
							});
						}
					});
				});
			}
		</script>
	<!-- </table> -->
</div>

<div id="editProductTypeDiv" class="editProductTypeDiv">
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
		<form method="post" id="editProductTypeForm" name="editProductTypeForm" class="editProductTypeDiv" enctype="multipart/form-data">
		
			<?php
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				while(($data = $query->fetch()) != false)
				{
					echo '<tr class="editProductTypeDiv">';
					echo "<td><label>"; give_translation('#*Product Type Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
					echo '<td><input id="editProductTypeName'.$data['code_language'].'" name="editProductTypeName'.$data['code_language'].'" size="30" maxlength="30" required="required" value="DUMMY DATA" type="text" /></td>';
					echo "</tr>";
				}
			?>
			
			<tr class="editProductTypeDiv">
				<td><?php give_translation('#*Select Group', $echo, $config_showtranslationcode);?></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select name="groupsForProductType[]" multiple>
						<?php
							if($_SESSION['cooshopid'] == 1) { 
								$prepared_query = 'SELECT * FROM product_group';
							} else {
								$prepared_query = 'SELECT * FROM product_group WHERE product_shop_id LIKE %:shop_id%';
							}
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							if($_SESSION['cooshopid'] == 1) {
								$query->execute();
							} else {
								$query->execute(array(
									'shop_id' => $_SESSION['cooshopid']
								));
							}
							while(($data = $query->fetch()) != false)
							{
								$Bok_productproperty = false;
								if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
									echo "<option value=\"".$data['id_group_product']."\" selected=\"selected\">".$data['name_group_product_L1']."</option>";
								} else {
									echo "<option value=\"".$data['id_group_product']."\">".$data['name_group_product_L1']."</option>";
								}
							}
						?>
					</select>
				</td>
			</tr>
		
			<tr class="editProductTypeDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="productTypeStatusEdit" name="productTypeStatusEdit">
						<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>				
			</tr>
			<tr class="editProductTypeDiv">
				<td colspan="3" style="text-align: center;border-top: 1px solid lightgrey;">
					<input id="bt_cboEditProductTypeSelect" type="submit" name="bt_cboEditProductTypeSelect" value="<?php give_translation('#*Modify', $echo, $config_showtranslationcode);?>" onclick="editProductType();"></input>
					<input id="bt_cboEditProductTypeSelectDelete" type="submit" name="bt_cboEditProductTypeSelectDelete" value="<?php give_translation('#*Delete', $echo, $config_showtranslationcode);?>" onclick="deleteProductType();"></input>
					<input id="bt_cboEditProductTypeSelectClose" name="bt_cboEditProductTypeSelectClose" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" type="submit" onclick="editProductTypeClose();" />
					<div id="editProductTypeResults"></div>
				</td>
			</tr>
		</form>
		<script type="text/javascript">
			function editProductTypeClose() {
				$(document).ready(function(){
						$("#editProductTypeForm").validate({
							debug: false,
							rules: {
								productTypeStatusEdit: "required"
							},
							messages: {
								productTypeStatusEdit: "required"
							},
							submitHandler: function(form) {
								//$(".shop_select_cboProductGroupSelect").fadeOut("slow");
								$(".shop_select_cboProductClassSelect").fadeOut("slow");
								document.getElementById('shop_select_cboProductGroupSelect').disabled=false;
								$(".editProductGroupDiv").fadeIn("slow");
								setSelectedIndex(document.getElementById('shop_select_cboTypeSelect'),'select');
								$(".shop_select_cboProductTypeSelect").fadeIn("slow");
								$('.newProductTypeDiv').hide();
								$('.editProductTypeDiv').hide();
								//$(".shop_select_cboProductTypeSelect").hide();
								//$(".shop_select_cboProductClassSelect").hide();
							}
						});
					});
			}
			
			function editProductType() {
					$(document).ready(function(){
						$("#editProductTypeForm").validate({
							debug: false,
							rules: {
								productTypeStatusEdit: "required"
							},
							messages: {
								productTypeStatusEdit: "required"
							},
							submitHandler: function(form) {
								// do other stuff for a valid form
								$.post('modules/product/editproducttype.php', $("#editProductTypeForm").serialize(), function(data) {
									$('#editProductTypeResults').html(data);
								});
							}
						});
					});
			}

			function deleteProductType() {
					$(document).ready(function(){
						$("#editProductTypeForm").validate({
							debug: false,
							rules: {
								productTypeStatusEdit: "required"
							},
							messages: {
								productTypeStatusEdit: "required"
							},
							submitHandler: function(form) {
								// do other stuff for a valid form
								$.post('modules/product/deleteproducttype.php', $("#editProductTypeForm").serialize(), function(data) {
									$('#editProductTypeResults').html(data);
								});
							}
						});
					});
			}
		</script>
	<!-- </table> -->
</div>
	</table>

</div>

<!-- <div>&nbsp;</div> -->

<div id="shop_select_cboProductClassSelect" class="shop_select_cboProductClassSelect">
	<table class="block_expandmain1" width="100%" border="0">
		<tr class="shop_select_cboProductClassSelect">
			<td><?php give_translation('edit_level.product_management.select_class', '', $config_showtranslationcode).":"; ?></td>
			<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
				<select id="shop_select_cboClassSelect" name="shop_select_cboClassSelect" class="shop_select_cboProductClassSelect">
				<option value="select"><?php give_translation('edit_level.product_management.shop_select_cboClassSelect.select_class', '', $config_showtranslationcode); ?></option>
				<option value="new"><?php give_translation('edit_level.product_management.shop_select_cboClassSelect.new_class', '', $config_showtranslationcode); ?></option>
				<?php
					$prepared_query = 'SELECT * FROM product_class';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if( ((!empty($_SESSION['product_management_cboClassSelect'])) && (strcmp($_SESSION['product_management_cboClassSelect'],$data['id_class_product'])==0) ) ) {
							echo "<option value=\"".$data['id_class_product']."\" selected=\"selected\">".$data['name_class_product_L1']."</option>";
						} else {
							echo "<option value=\"".$data['id_class_product']."\">".$data['name_class_product_L1']."</option>";
						}
					}
				?>
				</select>
			</td>
		</tr>
		
		<div>&nbsp;</div>

<div id="newProductClassDiv" class="newProductClassDiv">		
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
			<form method="post" id="newProductClassForm" name="newProductClassForm" class="newProductClassDiv" enctype="multipart/form-data">
				
				<?php
					$prepared_query = 'SELECT * FROM language WHERE status_language=1';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						echo '<tr class="newProductClassDiv">';
						echo "<td><label>"; give_translation('#*Product Class Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
						echo '<td colspan="2" width="70%"><input id="newProductClassName'.$data['code_language'].'" name="newProductClassName'.$data['code_language'].'" size="30" maxlength="30" required="required" value="DUMMY DATA" type="text" /></td>';
						echo "</tr>";
					}
				?>
				
				<tr class="newProductClassDiv">
					<td><?php give_translation('#*Select Type', $echo, $config_showtranslationcode);?></td>
					<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
						<select name="typesForProductClass[]" multiple>
							<?php
								if($_SESSION['cooshopid'] == 1) { 
									$prepared_query = 'SELECT * FROM product_type';
								} else {
									$prepared_query = 'SELECT * FROM product_type WHERE product_shop_id LIKE %:shop_id%';
								}
								if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
								$query = $connectData->prepare($prepared_query);
								if($_SESSION['cooshopid'] == 1) {
									$query->execute();
								} else {
									$query->execute(array(
										'shop_id' => $_SESSION['cooshopid']
									));
								}
								while(($data = $query->fetch()) != false)
								{
									$Bok_productproperty = false;
									if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
										echo "<option value=\"".$data['id_type_product']."\" selected=\"selected\">".$data['name_type_product_L1']."</option>";
									} else {
										echo "<option value=\"".$data['id_type_product']."\">".$data['name_type_product_L1']."</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>

				<tr class="newProductClassDiv">
					<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
					<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
						<select id="productClassStatusNew" name="productClassStatusNew">
							<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
							<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
						</select>
					</td>
				</tr>

				<tr class="newProductClassDiv">
					<td colspan="3" style="text-align: center;border-top: 1px solid lightgrey;">
						<input id="bt_cboNewProductClassSelect" type="submit" name="bt_cboNewProductClassSelect" value="<?php give_translation('#*Register New Class', $echo, $config_showtranslationcode);?>" onclick="newProductClass();"></input><input id="bt_cboNewProductClassSelectClose" name="bt_cboNewProductClassSelectClose" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" type="submit" onclick="newProductClassClose();" /><div id="newProductClassResults"></div>
					</td>
				</tr>
			</form>
			<script type="text/javascript">
				function newProductClassClose() {
					$(document).ready(function(){
						$("#newProductClassForm").validate({
							debug: false,
							rules: {
								productClassStatusNew: "required"
							},
							messages: {
								productClassStatusNew: "required"
							},
							submitHandler: function(form) {
								document.getElementById('shop_select_cboProductTypeSelect').disabled=false;
								document.getElementById('shop_select_cboTypeSelect').disabled=false;
								//document.getElementById('shop_select_cboProductClassSelect').disabled=true;
								//document.getElementById('shop_select_cboClassSelect').disabled=true;
								$('.newProductClassDiv').hide();
								$('.editProductClassDiv').hide();
								$('.newProductTypeDiv').hide();
								$('.editProductTypeDiv').fadeIn("slow");
								$('.shop_select_cboProductClassSelect').fadeOut("slow");
								$('.shop_select_cboClassSelect').fadeOut("slow");
								setSelectedIndex(document.getElementById('shop_select_cboClassSelect'),'select');
								$(".shop_select_cboProductClassSelect").fadeIn("slow");
							}
						});
					});
				}
				
				function newProductClass() {
					$(document).ready(function(){
						$("#newProductClassForm").validate({
							debug: false,
							rules: {
								productClassStatusNew: "required"
							},
							messages: {
								productClassStatusNew: "required"
							},
							submitHandler: function(form) {
								// do other stuff for a valid form
								$.post('modules/product/newproductclass.php', $("#newProductClassForm").serialize(), function(data) {
									$('#newProductClassResults').html(data);
								});
							}
						});
					});
				}
			</script>
	<!-- </table> -->
</div>
	
<div id="editProductClassDiv" name="editProductClassDiv" class="editProductClassDiv">
	<!-- <table class="block_expandmain1" width="100%" border="0"> -->
		<form method="post" id="editProductClassForm" name="editProductClassForm" class="editProductClassDiv" enctype="multipart/form-data">
			<?php
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				while(($data = $query->fetch()) != false)
				{
					echo '<tr class="editProductClassDiv">';
					echo "<td><label>"; give_translation('#*Product Class Name', $echo, $config_showtranslationcode); echo " (".$data['code_language'].")</label></td>";
					echo '<td colspan="2" width="70%"><input id="editProductClassName'.$data['code_language'].'" name="editProductClassName'.$data['code_language'].'" size="30" maxlength="30" required="required" value="DUMMY DATA" type="text" /></td>';
					echo "</tr>";
				}
			?>
				
			<tr class="editProductClassDiv">
				<td><?php give_translation('#*Select Type', $echo, $config_showtranslationcode);?></td>
					<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
						<select name="typesForProductClass[]" multiple>
							<?php
								if($_SESSION['cooshopid'] == 1) { 
									$prepared_query = 'SELECT * FROM product_type';
								} else {
									$prepared_query = 'SELECT * FROM product_type WHERE product_group_id LIKE %:shop_id%';
								}
								if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
								$query = $connectData->prepare($prepared_query);
								if($_SESSION['cooshopid'] == 1) {
									$query->execute();
								} else {
									$query->execute(array(
										'shop_id' => $_SESSION['cooshopid']
									));
								}
								while(($data = $query->fetch()) != false)
								{
									$Bok_productproperty = false;
									if( ((!empty($_SESSION['product_management_cboShopSelect'])) && (strcmp($_SESSION['product_management_cboShopSelect'],$data['shop_id'])==0) ) ) {
										echo "<option value=\"".$data['id_type_product']."\" selected=\"selected\">".$data['name_type_product_L1']."</option>";
									} else {
										echo "<option value=\"".$data['id_type_product']."\">".$data['name_type_product_L1']."</option>";
									}
								}
							?>
						</select>
				</td>
			</tr>		
		
			<tr class="editProductClassDiv">
				<td><label><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></label></td>
				<td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select id="productClassStatusEdit" name="productClassStatusEdit">
						<option value="1"><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="0"><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
				</td>
			<tr>
			<tr class="editProductClassDiv">
				<td colspan="2" style="text-align: center;border-top: 1px solid lightgrey;">
					<input id="bt_cboEditProductClassSelect" name="bt_cboEditProductClassSelect" value="<?php give_translation('#*Modify', $echo, $config_showtranslationcode);?>" type="submit" onclick="editProductClass();" />
					<input id="bt_cboEditProductClassSelectDelete" name="bt_cboEditProductClassSelectDelete" value="<?php give_translation('#*Delete', $echo, $config_showtranslationcode);?>" type="submit" onclick="deleteProductClass();" />
					<input id="bt_cboEditProductClassSelectClose" name="bt_cboEditProductClassSelectClose" value="<?php give_translation('#*Close', $echo, $config_showtranslationcode);?>" type="submit" onclick="editProductClassClose();" />
					<div id="editProductClassResults"></div>
				</td>
			</tr>
		</form>
		<script type="text/javascript">
			function editProductClassClose() {
				$(document).ready(function(){
					$("#editProductClassForm").validate({
						debug: false,
						rules: {
							productClassStatusEdit: "required"
						},
						messages: {
							productClassStatusEdit: "required"
						},
						submitHandler: function(form) {
							document.getElementById('shop_select_cboProductTypeSelect').disabled=false;
							document.getElementById('shop_select_cboTypeSelect').disabled=false;
							//document.getElementById('shop_select_cboProductClassSelect').disabled=true;
							//document.getElementById('shop_select_cboClassSelect').disabled=true;
							$('.newProductClassDiv').hide();
							$('.editProductClassDiv').hide();
							$('.newProductTypeDiv').hide();
							$('.editProductTypeDiv').fadeIn("slow");
							$('.shop_select_cboProductClassSelect').fadeOut("slow");
							$('.shop_select_cboClassSelect').fadeOut("slow");
							setSelectedIndex(document.getElementById('shop_select_cboClassSelect'),'select');
							$(".shop_select_cboProductClassSelect").fadeIn("slow");
						}
					});
				});
			}
			
			function editProductClass() {
				$(document).ready(function(){
					$("#editProductClassForm").validate({
						debug: false,
						rules: {
							productClassStatusEdit: "required"
						},
						messages: {
							productClassStatusEdit: "required"
						},
						submitHandler: function(form) {
								// do other stuff for a valid form
							$.post('modules/product/editproductclass.php', $("#editProductClassForm").serialize(), function(data) {
								$('#editProductClassResults').html(data);
							});
						}
					});
				});
			}

			function deleteProductClass() {
				$(document).ready(function(){
					$("#editProductClassForm").validate({
						debug: false,
						rules: {
							productClassStatusEdit: "required"
						},
						messages: {
							productClassStatusEdit: "required"
						},
						submitHandler: function(form) {
								// do other stuff for a valid form
							$.post('modules/product/deleteproductclass.php', $("#editProductClassForm").serialize(), function(data) {
								$('#editProductClassResults').html(data);
							});
						}
					});
				});
			}
		</script>
	<!-- </table> -->
</div>

	</table>
</div>