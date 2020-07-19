<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">





<html>
<div name="matrix_select_name" id="matrix_select_name">
	<form method="post" id="selectMatrixForm" name="selectMatrixForm" enctype="multipart/form-data">
	<table  width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td class="font_subtitle">#*Select Matrix</td>
			<td width="70%">
				<select name="matrix_select" id="matrix_select" onchange="showBlocks();">
					<option value="new">--- #* New Matrix</option>
					<option value="matrix1">Matrix Name 1</option>
					<option value="matrix2">Matrix Name 2</option>			
				</select>&nbsp
				<input type="submit" name="edit_matrix" id="edit_matrix" value="#*Edit Matrix">
			</td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>
	</table>

	<table  width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td class="font_subtitle">#*Name_L1</td>
			<td width="70%"><input type="text" name="matrix_name_L1" id="matrix_name_L1"</td>
		</tr>
		<tr>
			<td class="font_subtitle">#*Name_L2</td>
			<td width="70%"><input type="text" name="matrix_name_L2" id="matrix_name_L2"</td>
		</tr>
		<tr>
			<td class="font_subtitle">#*Name_L3</td>
			<td width="70%"><input type="text" name="matrix_name_L3" id="matrix_name_L3"</td>
		</tr>
		<tr>
			<td class="font_subtitle">#*Name_L4</td>
			<td width="70%"><input type="text" name="matrix_name_L4" id="matrix_name_L4"</td>
		</tr>
		<tr>
			<td class="font_subtitle">#*Name_L5</td>
			<td width="70%"><input type="text" name="matrix_name_L5" id="matrix_name_L5"</td>
		</tr>
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
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-1</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col1_name_L1" id="col1_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col1_name_L2" id="col1_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col1_name_L3" id="col1_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col1_name_L4" id="col1_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col1_name_L5" id="col1_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>

		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-2</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col2_name_L1" id="col2_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col2_name_L2" id="col2_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col2_name_L3" id="col2_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col2_name_L4" id="col2_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col2_name_L5" id="col2_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-3</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col3_name_L1" id="col3_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col3_name_L2" id="col3_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col3_name_L3" id="col3_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col3_name_L4" id="col3_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col3_name_L5" id="col3_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-4</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col4_name_L1" id="col4_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col4_name_L2" id="col4_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col4_name_L3" id="col4_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col4_name_L4" id="col4_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col4_name_L5" id="col4_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-5</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col5_name_L1" id="col5_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col5_name_L2" id="col5_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col5_name_L3" id="col5_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col5_name_L4" id="col5_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col5_name_L5" id="col5_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-6</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col6_name_L1" id="col6_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col6_name_L2" id="col6_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col6_name_L3" id="col6_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col6_name_L4" id="col6_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col6_name_L5" id="col6_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-7</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col7_name_L1" id="col7_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col7_name_L2" id="col7_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col7_name_L3" id="col7_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col7_name_L4" id="col7_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col7_name_L5" id="col7_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-8</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col1_name_L8" id="col8_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col8_name_L2" id="col8_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col8_name_L3" id="col8_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col8_name_L4" id="col8_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col8_name_L5" id="col8_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Col-9</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="col9_name_L1" id="col9_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="col9_name_L2" id="col9_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="col9_name_L3" id="col9_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="col9_name_L4" id="col9_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="col9_name_L5" id="col9_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>
		<tr>
			<td colspan="3" align="center"><input type="submit" name="save_matrix_horizontal" id="save_matrix_horizontal" value="#*Save"></td>
		</tr>
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
		<tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-1</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row1_name_L1" id="row1_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row1_name_L2" id="row1_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row1_name_L3" id="row1_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row1_name_L4" id="row1_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row1_name_L5" id="row1_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-2</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row2_name_L1" id="row2_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row2_name_L2" id="row2_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row2_name_L3" id="row2_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row2_name_L4" id="row2_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row2_name_L5" id="row2_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-3</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row3_name_L1" id="row3_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row3_name_L2" id="row3_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row3_name_L3" id="row3_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row3_name_L4" id="row3_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row3_name_L5" id="row3_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-4</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row4_name_L1" id="row4_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row4_name_L2" id="row4_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row4_name_L3" id="row4_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row4_name_L4" id="row4_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row4_name_L5" id="row4_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-5</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row5_name_L1" id="row5_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row5_name_L2" id="row5_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row5_name_L3" id="row5_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row5_name_L4" id="row5_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row5_name_L5" id="row5_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-6</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row6_name_L1" id="row6_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row6_name_L2" id="row6_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row6_name_L3" id="row6_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row6_name_L4" id="row6_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row6_name_L5" id="row6_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-7</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row7_name_L1" id="row7_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row7_name_L2" id="row7_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row7_name_L3" id="row7_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row7_name_L4" id="row7_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row7_name_L5" id="row7_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-8</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row1_name_L8" id="row8_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row8_name_L2" id="row8_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row8_name_L3" id="row8_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row8_name_L4" id="row8_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row8_name_L5" id="row8_name_L5"></td>
		</tr>
		<tr>
		<tr><td colspan="3" style="border-top: 1px dashed lightgrey;"></td></tr>
			<td width="30%" rowspan="5" valign="top" class="font_subtitle">#*Row-9</td>
			<td width="30%" class="text">#*Name_L1</td>
			<td width="40%"><input type="text" name="row9_name_L1" id="row9_name_L1"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L2</td>
			<td width="30%"><input type="text" name="row9_name_L2" id="row9_name_L2"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L3</td>
			<td width="30%"><input type="text" name="row9_name_L3" id="row9_name_L3"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L4</td>
			<td width="30%"><input type="text" name="row9_name_L4" id="row9_name_L4"></td>
		</tr>
		<tr>
			<td class="text">#*Name_L5</td>
			<td width="30%"><input type="text" name="row9_name_L5" id="row9_name_L5"></td>
		</tr>
		<tr><td colspan="3" style="border-top: 1px solid lightgrey;"></td></tr>
		<tr>
			<td colspan="3" align="center"><input type="submit" name="save_matrix_horizontal" id="save_matrix_horizontal" value="#*Save"></td>
		</tr>
	</table>


</td>
    </tr>
</table>
</div>

</form>

</html>