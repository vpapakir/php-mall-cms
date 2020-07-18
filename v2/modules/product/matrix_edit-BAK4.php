<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
<div name="matrix_select_name" id="matrix_select_name">
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
					<option value="matrix1">Matrix Name 1</option>
					<option value="matrix2">Matrix Name 2</option>			
				</select>&nbsp
				<input type="submit" name="edit_matrix" id="edit_matrix" value="#*Edit Matrix">
			</td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>
	</table>

	
	
	
	<table  width="100%" cellspacing="0" cellpadding="2">
<?php //Gets language codes, translates them and shows them. textbox names and IDs resort to "matrix_name_Lx", where x = language id
	$prepared_query = 'SELECT * FROM language WHERE status_language=1';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();
	while(($data = $query->fetch()) != false)
	{
		echo '<tr>';
		echo '<td class="font_subtitle">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
		echo '<td width="70%"><input type="text" name="matrix_name_L'.$data['id_language'].'" id="matrix_name_L'.$data['id_language'].'"</td>';
		echo '</tr>';
	}
    $query->closeCursor();
?>

		<tr>
			<td class="font_subtitle">#*Status</td>
			<td width="70%"><select name="matrix_status" id="matrix_status">
					<option>CDR Active</option>
					<option>CDR Disabled</option>
				 </select>
			</td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="create_matrix" id="create_matrix" value="#*Create Matrix"></td>
		</tr>
	</table>
</form>
</div>

<div name="matrix_horizontal" id="matrix_horizontal">
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
                        Horizontal
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
	$max_matrix_columns = 9;
	for ($j = 1; $j <= $max_matrix_columns; $j++)
	{
		echo '<tr>';
		echo '<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-'.$j.'</td>';
		$prepared_query = 'SELECT * FROM language WHERE status_language=1';
		if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
		$query = $connectData->prepare($prepared_query);
		$query->execute();
		$i = 0; //needed for proper HTML table structure (rowspan)
		while(($data = $query->fetch()) != false)
		{
			if ($i != 0){echo '<tr>';} else {$i++;}
			echo '<td width="30%" class="text">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
			echo '<td width="40%"><input type="text" name="col'.$j.'_name_L'.$data['id_language'].'" id="col'.$j.'_name_L'.$data['id_language'].'"</td>';
			echo '</tr>';
		}
	    $query->closeCursor();
		if ($j != $max_matrix_columns){echo '<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>';}
	}
	echo '<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>';
	echo '<tr>';
	echo '<td colspan="3" align="center"><input type="submit" name="save_matrix_vertical" id="save_matrix_vertical" value="#*Save"></td>';
	echo '</tr>';
?>
</table>
</form>


</td>
    </tr>
</table>
</div>

<div name="matrix_vertical" id="matrix_vertical">
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
                        Vertical
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
	$max_matrix_rows = 9;
	for ($j = 1; $j <= $max_matrix_rows; $j++)
	{
		echo '<tr>';
		echo '<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-'.$j.'</td>';
		$prepared_query = 'SELECT * FROM language WHERE status_language=1';
		if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
		$query = $connectData->prepare($prepared_query);
		$query->execute();
		$i = 0; //needed for proper HTML table structure (rowspan)
		while(($data = $query->fetch()) != false)
		{
			if ($i != 0){echo '<tr>';} else {$i++;}
			echo '<td width="30%" class="text">'; give_translation($data['code_language'], $echo, $config_showtranslationcode); echo '</td>';
			echo '<td width="40%"><input type="text" name="row'.$j.'_name_L'.$data['id_language'].'" id="row'.$j.'_name_L'.$data['id_language'].'"</td>';
			echo '</tr>';
		}
	    $query->closeCursor();
		if ($j != $max_matrix_rows){echo '<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>';}
	}
	echo '<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>';
	echo '<tr>';
	echo '<td colspan="3" align="center"><input type="submit" name="save_matrix_horizontal" id="save_matrix_horizontal" value="#*Save"></td>';
	echo '</tr>';
?>
</table>
</td>
    </tr>
</table>
</div>

</form>

</html>