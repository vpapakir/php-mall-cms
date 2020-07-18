<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".matrix_select_name").show();
		$(".matrix_horizontal").show();
		$(".matrix_vartical").show();
		
		var e = document.getElementById("matrix_select");
		if(e.options.length > 2) {
			document.getElementById("edit_matrix").visible = false;
		}
		
	});
</script>

<style>

.matrix_select_name {
}

.matrix_horizontal {
}

.matrix_vertical {
}

</style>

<script type="text/javascript">
	function showBlocks() {
		alert("change!");
	}
	
	function addNewMatrix() {
		$(document).ready(function(){
			$("#selectMatrixForm").validate({
				debug: false,
				rules: {
					//matrix_status: "required"
				},
				messages: {
					//matrix_status: "*"
				},
				submitHandler: function(form) {
					// do other stuff for a valid form
					$.post('modules/product/addnewmatrix.php', $("#selectMatrixForm").serialize(), function(data) {
						if(data == 0) {
							//$('#newMatrixResults').html("<?php give_translation('edit_level.addnewmatrix.matrix_created_successfully', '', $config_showtranslationcode);?>");
							$('#newMatrixResults').html("OK");
						} else if (data == -1) {
							//$('#newMatrixResults').html("<?php give_translation('edit_level.addnewmatrix.error_while_creating_matrix', '', $config_showtranslationcode);?>");
							$('#newMatrixResults').html("NOT OK");
						} else {
							$('#newMatrixResults').html(data);
						}
					});
				}
			});
		});
	}
	
	function editExistingMatrix () {
		$(document).ready(function(){
			$("#selectMatrixForm").validate({
				debug: false,
				rules: {
				},
				messages: {
				},
				submitHandler: function(form) {
					// do other stuff for a valid form
					$.post('modules/product/editexistingmatrix.php', $("#selectMatrixForm").serialize(), function(data) {
					if(data == 0) {
						//$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.shop_added_successfully', '', $config_showtranslationcode);?>");
					} else {
						//$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.please_fill_in_all_the_info', '', $config_showtranslationcode);?>");
					}
					});
				}
			});
		});
	}
	
	function deleteExistingMatrix () {
		$(document).ready(function(){
			$("#selectMatrixForm").validate({
				debug: false,
				rules: {
				},
				messages: {
				},
				submitHandler: function(form) {
					$.post('modules/product/deleteexistingmatrix.php', $("#selectMatrixForm").serialize(), function(data) {
					if(data == 0) {
						//$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.shop_added_successfully', '', $config_showtranslationcode);?>");
					} else {
						//$('#newShopResults').html("<?php give_translation('edit_level.addnewshop.please_fill_in_all_the_info', '', $config_showtranslationcode);?>");
					}
					});
				}
			});
		});
	}
</script>

<div name="matrix_select_name" id="matrix_select_name" class="matrix_select_name">
	<form method="post" id="selectMatrixForm" name="selectMatrixForm" enctype="multipart/form-data">
		<table  width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td class="font_subtitle"><?php give_translation('#*Select Matrix', $echo, $config_showtranslationcode); ?></td>
				<td width="70%">
					<select name="matrix_select" id="matrix_select" onchange="showBlocks();">
						<?php // needs checking
							$main_id_language = $_SESSION['current_language'];
							$prepared_query = 'SELECT * FROM cdreditor
											   WHERE code_cdreditor = "cdreditor_activitycompany_userdata"
											   AND position_cdreditor = "9999"';
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							$query->execute();
							$i = 0;    
							while($data = $query->fetch())
							{
								$activitycompany_nameS_data = $data['L'.$main_id_language.'S'];
							}
							$query->closeCursor();
						?>
						<option value="new"><?php echo $activitycompany_nameS_data; /*needs improvement*/ ?></option>
						<?php 
						
							$prepared_query = "SELECT * FROM matrix";
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							$query->execute();
							while($data = $query->fetch()) {
								echo '<option value="'.$data['id_matrix'].'">'.$data['name_matrix_L'.$main_id_language].'</option>';
							}
						?>
					</select>&nbsp;<input type="submit" name="edit_matrix" style="display:none;" id="edit_matrix" value="<?php give_translation('#*Edit Matrix', $echo, $config_showtranslationcode); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="3" style="border-top: 1px solid lightgrey;">
				</td>
			</tr>
		</table>
		<table  width="100%" cellspacing="0" cellpadding="2">
			<?php //Gets language codes, translates them and shows them. textbox names and IDs resort to "matrix_name_Lx", where x = language id
				$prepared_query = 'SELECT * FROM language WHERE status_language=1';
				if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
				$query = $connectData->prepare($prepared_query);
				$query->execute();
				$i = 0;
				while(($data = $query->fetch()) != false)
				{
					echo '<tr>';
					echo '<td class="font_subtitle">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
					echo '<td width="70%"><input type="text" required="required" name="matrix_name_L'.$data['id_language'].'" id="matrix_name_L'.$data['id_language'].'" /></td>';
					echo '</tr>';
					$i++;
				}
				$count_currently_active_langs = $i;
				$query->closeCursor();
			?>
			<tr>
				<td class="font_subtitle"><?php give_translation('#*Status', $echo, $config_showtranslationcode); ?></td>
				<td width="70%">
					<select name="matrix_status" id="matrix_status">
						<?php // needs checking
							$main_id_language = $_SESSION['current_language'];
							$prepared_query = 'SELECT * FROM cdreditor
											   WHERE code_cdreditor = "cdreditor_activitycompany_userdata"
											   AND position_cdreditor = "9990"';
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							$query->execute();
							$i = 0;    
							while($data = $query->fetch())
							{
								$activitycompany_nameS_data = $data['L'.$main_id_language.'S'];
							}
							$query->closeCursor();
						?>
						<option value="1"><?php echo $activitycompany_nameS_data; /*needs improvement*/ ?></option>
						<?php // needs checking
							$main_id_language = $_SESSION['current_language'];
							$prepared_query = 'SELECT * FROM cdreditor
											   WHERE code_cdreditor = "cdreditor_activitycompany_userdata"
											   AND position_cdreditor = "9991"';
							if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
							$query = $connectData->prepare($prepared_query);
							$query->execute();
							$i = 0;    
							while($data = $query->fetch())
							{
								$activitycompany_nameS_data = $data['L'.$main_id_language.'S'];
							}
							$query->closeCursor();
						?>
						<option value="0"><?php echo $activitycompany_nameS_data; /*needs improvement*/ ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="border-top: 1px solid lightgrey;">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" name="create_matrix" onclick="addNewMatrix();" id="create_matrix" value="<?php give_translation('#*Create Matrix', $echo, $config_showtranslationcode); ?>">
					<input type="submit" name="modify_matrix" onclick="editExistingMatrix();" id="modify_matrix" value="<?php give_translation('#*Modify Matrix', $echo, $config_showtranslationcode); ?>">
					<input type="submit" name="delete_matrix" onclick="deleteExistingMatrix();" id="delete_matrix" value="<?php give_translation('#*Delete Matrix', $echo, $config_showtranslationcode); ?>">
					<div id="newMatrixResults"></div>
					<div id="editMatrixResults"></div>
					<div id="deleteMatrixResults"></div>
				</td>
			</tr>
		</table>
	</form>
</div>

<div name="matrix_horizontal" id="matrix_horizontal" class="matrix_horizontal">
<table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseHorizontal"
<?php
                if(empty($_SESSION['expand_collapseHorizontal']) || $_SESSION['expand_collapseHorizontal'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseHorizontal', 'img_expand_collapseHorizontal', 'expand_collapseHorizontal', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseHorizontal');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseHorizontal']) || $_SESSION['expand_collapseHorizontal'] == 'false')
                        {
?>
                            <img id="img_expand_collapseHorizontal" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseHorizontal" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('#*Horizontal', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseHorizontal" style="display: none;" type="hidden" name="expand_collapseHorizontal" value="<?php if(empty($_SESSION['expand_collapseHorizontal']) || $_SESSION['expand_collapseHorizontal'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseHorizontal"
<?php
        if(empty($_SESSION['expand_collapseHorizontal']) || $_SESSION['expand_collapseHorizontal'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td align="left">





<form method="post" id="horizontalMatrixForm" name="horizontalMatrixForm" enctype="multipart/form-data">
<table width="100%"  cellspacing="0" cellpadding="2">

<?php //Creates the columns HTML table. Gets language codes, translates them and shows them. textbox names and IDs resort to "colY_name_Lx", where x = language id, Y = column number
	$max_matrix_columns = 9;	//maybe sometime this will come from db
	for ($j = 1; $j <= $max_matrix_columns; $j++)
	{
		echo '<tr>';
		$prepared_query = 'SELECT * FROM language WHERE status_language=1';
		if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
		$query = $connectData->prepare($prepared_query);
		$query->execute();
		echo '<td width="30%" rowspan="'.$count_currently_active_langs.'" valign="top" class="font_subtitle">'; give_translation('#*Column', $echo, $config_showtranslationcode); echo '-'.$j.'</td>';
		$i = 0; 
		while(($data = $query->fetch()) != false)
		{
			if ($i != 0){echo '<tr>';} else {$i++;}  //needed for proper HTML table structure (rowspan)
			echo '<td width="30%" class="text">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
			echo '<td width="40%"><input type="text" name="col'.$j.'_name_L'.$data['id_language'].'" id="col'.$j.'_name_L'.$data['id_language'].'"</td>';
			echo '</tr>';
		}
	    $query->closeCursor();
		if ($j != $max_matrix_columns){echo '<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>';}
	}
	echo '<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>';
	echo '<tr>';
	echo '<td colspan="3" align="center"><input type="submit" name="save_matrix_vertical" id="save_matrix_vertical" value="'; give_translation('#*Save', $echo, $config_showtranslationcode); echo '"></td>';
	echo '</tr>';
?>
</table>
</form>


</td>
    </tr>
</table>
</div>

<div name="matrix_vertical" id="matrix_vertical" class="matrix_vertical">
<table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseVertical"
<?php
                if(empty($_SESSION['expand_collapseVertical']) || $_SESSION['expand_collapseVertical'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseVertical', 'img_expand_collapseVertical', 'expand_collapseVertical', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseVertical');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseVertical']) || $_SESSION['expand_collapseVertical'] == 'false')
                        {
?>
                            <img id="img_expand_collapseVertical" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseVertical" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('#*Vertical', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseVertical" style="display: none;" type="hidden" name="expand_collapseVertical" value="<?php if(empty($_SESSION['expand_collapseVertical']) || $_SESSION['expand_collapseVertical'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseVertical"
<?php
        if(empty($_SESSION['expand_collapseVertical']) || $_SESSION['expand_collapseVertical'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td align="left">


		
		

<form method="post" id="verticalMatrixForm" name="verticalMatrixForm" enctype="multipart/form-data">
<table width="100%"  cellspacing="0" cellpadding="2">
<?php //Creates the rows HTML table. Gets language codes, translates them and shows them. textbox names and IDs resort to "rowY_name_Lx", where x = language id, Y = row number
	$max_matrix_rows = 9; //maybe sometime this will come from db
	for ($j = 1; $j <= $max_matrix_rows; $j++)
	{
		echo '<tr>';
		$prepared_query = 'SELECT * FROM language WHERE status_language=1';
		if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
		$query = $connectData->prepare($prepared_query);
		$query->execute();
		echo '<td width="30%" rowspan="'.$count_currently_active_langs.'" valign="top" class="font_subtitle">'; give_translation('#*Row', $echo, $config_showtranslationcode); echo '-'.$j.'</td>';
		$i = 0;
		while(($data = $query->fetch()) != false)
		{
			if ($i != 0){echo '<tr>';} else {$i++;} //needed for proper HTML table structure (rowspan)
			echo '<td width="30%" class="text">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
			echo '<td width="40%"><input type="text" name="row'.$j.'_name_L'.$data['id_language'].'" id="row'.$j.'_name_L'.$data['id_language'].'"</td>';
			echo '</tr>';
		}
	    $query->closeCursor();
		if ($j != $max_matrix_rows){echo '<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>';}
	}
	echo '<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>';
	echo '<tr>';
	echo '<td colspan="3" align="center"><input type="submit" name="save_matrix_horizontal" id="save_matrix_horizontal" value="'; give_translation('#*Save', $echo, $config_showtranslationcode); echo '"></td>';
	echo '</tr>';
?>
</table>
</td>
    </tr>
</table>
</div>

</form>

