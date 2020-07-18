<?php
nosubmit_form_historyback();

#content
include('modules/product/content/product_content_getinfo.php');
#main

//include('modules/product/bt/bt_radProductContent.php');
#upload
include('modules/product/bt/upload/bt_send_image_product.php');
include('modules/product/bt/upload/bt_delete_image_product.php');
#select
include('modules/product/select/bt_select/bt_cboProductSelect.php');
#expand
include('modules/product/bt/product_expand.php');

if( (isset($_POST['bt_cboShopSelect']) && isset($_POST['shop_select_cboShopSelect'])) )
{
	$_SESSION['product_management_cboShopSelect'] = $_POST['shop_select_cboShopSelect'];
} else {
	if(isset($_SESSION['product_management_cboShopSelect'])) {
		// Do nothing
	} else {
		$_SESSION['product_management_cboShopSelect'] = 'select';
	}
}

if( (isset($_POST['bt_cboTypeSelect']) && isset($_POST['shop_select_cboTypeSelect'])) )
{
	$_SESSION['product_management_cboTypeSelect'] = $_POST['shop_select_cboTypeSelect'];
} else {
	if(isset($_SESSION['product_management_cboTypeSelect'])) {
		// Do nothing
	} else {
		$_SESSION['product_management_cboTypeSelect'] = 'select';
	}
}

if( (isset($_POST['bt_cboGroupSelect']) && isset($_POST['shop_select_cboGroupSelect'])) )
{
	$_SESSION['product_management_cboGroupSelect'] = $_POST['shop_select_cboGroupSelect'];
} else {
	if(isset($_SESSION['product_management_cboGroupSelect'])) {
		// Do nothing
	} else {
		$_SESSION['product_management_cboGroupSelect'] = 'select';
	}
}

if( (isset($_POST['bt_cboClassSelect']) && isset($_POST['shop_select_cboClassSelect'])) )
{
	$_SESSION['product_management_cboClassSelect'] = $_POST['shop_select_cboClassSelect'];
} else {
	if(isset($_SESSION['product_management_cboClassSelect'])) {
		// Do nothing
	} else {
		$_SESSION['product_management_cboClassSelect'] = 'select';
	}
}
?>

<form method="post" enctype="multipart/form-data">
  <table width="100%">
    <tr>
      <td><?php give_translation('edit_level.product_management.select_shop', '', $config_showtranslationcode); ?>: </td>
      <td><select name="shop_select_cboShopSelect" id="shop_select_cboShopSelect" onchange="OnChange('bt_cboShopSelect');">
          <option value="select"><?php give_translation('edit_level.product_management.shop_select_cboShopSelect.select_shop', '', $config_showtranslationcode); ?></option>
          <option value="new"><?php give_translation('edit_level.product_management.shop_select_cboShopSelect.new_shop', '', $config_showtranslationcode); ?></option>
          <?php
					$prepared_query = 'SELECT * FROM cooshops WHERE shop_hier > 1';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
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
        <input id="bt_cboShopSelect" hidden="true" style="display: none;" type="submit" name="bt_cboShopSelect" value="Choix Shop">
        </input></td>
      <td><input id="bt_cboEditShopSelect" type="submit" name="bt_cboEditShopSelect" value="Edit Shop" onclick="OnChange('bt_cboEditShopSelect');">
        </input></td>
    </tr>
    <tr>
      <td><br /></td>
      <td><br /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?php
				if( isset($_POST['bt_cboShopSelect']) || isset($_POST['bt_cboGroupSelect']) || isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']) )
				{
					if(strcmp($_POST['shop_select_cboShopSelect'],'new') == 0) {
						// Do nothing
					} else {
						give_translation('edit_level.product_management.select_group', '', $config_showtranslationcode).":";
					}
				} else {
					// Do nothing!
				}
            ?></td>
      <td><?php				
				if( isset($_POST['bt_cboShopSelect']) || isset($_POST['bt_cboGroupSelect']) || isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']) )
				{
					if(strcmp($_POST['shop_select_cboShopSelect'],'new') == 0) {
						// Do nothing
					} else {
			?>
        <select name="shop_select_cboGroupSelect" onchange="OnChange('bt_cboGroupSelect');">
          <option value="select"><?php give_translation('edit_level.product_management.shop_select_cboGroupSelect.select_group', '', $config_showtranslationcode); ?></option>
          <option value="new"><?php give_translation('edit_level.product_management.shop_select_cboGroupSelect.new_group', '', $config_showtranslationcode); ?></option>
          <?php
					$prepared_query = 'SELECT * FROM product_group';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
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
        <input id="bt_cboGroupSelect" style="display: none;" hidden="true" type="submit" name="bt_cboGroupSelect" value="Select Group">
        </input>
        </td>
      <td><input id="bt_cboEditGroupSelect" type="submit" name="bt_cboEditGroupSelect" value="Edit Group" onclick="OnChange('bt_cboEditGroupSelect');">
        </input></td><?php
            	}
				} else {
					// Do nothing!
				}
            ?>
    </tr>
    <tr>
      <td><br /></td>
      <td><br /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?php
				if( isset($_POST['bt_cboGroupSelect']) || isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']) )
				{
					give_translation('edit_level.product_management.select_type', '', $config_showtranslationcode).":";
				} else {
					// Do nothing!
				}
            ?></td>
      <td><?php				
				if(isset($_POST['bt_cboGroupSelect']) || isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']))
				{
            ?>
        <select name="shop_select_cboTypeSelect" onchange="OnChange('bt_cboTypeSelect');">
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
        <input id="bt_cboTypeSelect" style="display: none;" hidden="true" type="submit" name="bt_cboTypeSelect" value="Select Type">
        </input></td>
      <td><input id="bt_cboEditTypeSelect" type="submit" name="bt_cboEditTypeSelect" value="Edit Type" onclick="OnChange('bt_cboEditTypeSelect');"></input>
        <?php
				}
            ?></td>
    </tr>
    <tr>
      <td><br /></td>
      <td><br /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?php
				if( isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']) )
				{
					give_translation('edit_level.product_management.select_class', '', $config_showtranslationcode).":";
				} else {
					// Do nothing!
				}
            ?></td>
      <td><?php				
				if(isset($_POST['bt_cboTypeSelect']) || isset($_POST['bt_cboClassSelect']))
				{
            ?>
        <select name="shop_select_cboClassSelect" onchange="OnChange('bt_cboClassSelect');">
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
        <input id="bt_cboClassSelect" style="display: none;" hidden="true" type="submit" name="bt_cboClassSelect" value="Select Class">
        </input></td>
      <td><input id="bt_cboEditClassSelect" type="submit" name="bt_cboEditClassSelect" value="Edit Class" onclick="OnChange('bt_cboEditClassSelect');">
        </input>
        <?php
				}
				/*unset($_SESSION['product_management_cboShopSelect']);
				unset($_SESSION['product_management_cboTypeSelect']);
				unset($_SESSION['product_management_cboGroupSelect']);
				unset($_SESSION['product_management_cboClassSelect']);*/
				
            ?></td>
    </tr>
    
    <tr>
    	<td></td>
    	<td>
        <?php				
				if(isset($_POST['bt_cboClassSelect']))
				{
         ?>
        <?php				
				}
         ?>
        </td>
    	<td>&nbsp;</td>
    </tr>
  </table>
</form>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

<?php				
	if(strcmp($_SESSION['product_management_cboShopSelect'],'new')==0) {
		include('new_shop.php');
	}

	if(strcmp($_SESSION['product_management_cboGroupSelect'],'new')==0) {
		include('new_product_group.php');
	}
	
	if(strcmp($_SESSION['product_management_cboTypeSelect'],'new')==0) {
		include('new_product_type.php');
	}
		
	if(strcmp($_SESSION['product_management_cboClassSelect'],'new')==0) {
		include('new_product_class.php');					
	}
		
	if( (isset($_POST['bt_cboEditShopSelect']) && isset($_POST['shop_select_cboShopSelect'])) )
	{
		include('edit_shop.php');
	}
		
	if( (isset($_POST['bt_cboEditGroupSelect']) && isset($_POST['shop_select_cboGroupSelect'])) )
	{
		include('edit_group.php');
	}
		
	if( (isset($_POST['bt_cboEditTypeSelect']) && isset($_POST['shop_select_cboTypeSelect'])) )
	{
		include('edit_type.php');
	}
		
	if( (isset($_POST['bt_cboEditClassSelect']) && isset($_POST['shop_select_cboClassSelect'])) )
	{
		include('edit_class.php');
	}
?>