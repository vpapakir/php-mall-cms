<?php
try
{
    $prepared_query = 'SELECT * FROM structure_layout
                       WHERE id_layout = :layout';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('layout', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_layout = $data['id_layout'];
        $name_layout = $data['name_layout'];
        
        $width_layout = $data['width_layout'];
        $height_layout = $data['height_layout'];
        $position_layout = $data['position_layout'];
        $margin_layout = $data['margin_layout'];
        $border_layout = $data['border_layout'];
        $bordercolor_layout = $data['bordercolor_layout'];
        $tablebg_layout = $data['tablebg_layout'];
        $cs_layout = $data['cs_layout'];
        $cp_layout  = $data['cp_layout'];
        
        $bgcolor_layout = $data['bgcolor_layout'];
        $bgimage_layout = $data['bgimg_layout'];
        $xrepeat_layout = $data['xrepeat_layout'];
        $yrepeat_layout = $data['yrepeat_layout'];
        
        $radius_layout = $data['radius_layout'];
        $heightpart_layout = $data['heightpart_layout'];
        
        $selected_image_layout_top = $data['id_image_top'];
        $selected_image_layout_middle = $data['id_image_middle'];
        $selected_image_layout_bottom = $data['id_image_bottom'];
    }
    $query->closeCursor();
    
    $radius_layout = split_string($radius_layout, '$');
    $heightpart_layout = split_string($heightpart_layout, '$');
    
    
    
    $_SESSION['structure_edit_id_element'] = $id_layout;
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
    }
}
?>

<td><table width="100%">
        
        <td class="font_subtitle" width="40%">
            <?php give_translation('edit_structure.subtitle_name_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="<?php echo($right_column_width); ?>">
            <input type="text" name="txtNameLayout" value="<?php echo($name_layout); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_layout_txtNameLayout']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_layout_txtNameLayout'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_width_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtWidthLayout" value="<?php echo($width_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_height_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtHeightLayout" value="<?php echo($height_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_position_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtPositionLayout" value="<?php echo($position_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_margin_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtMarginLayout" value="<?php echo($margin_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_border_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtBorderLayout" value="<?php echo($border_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bordercolor_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBordercolorLayout', 'BordercolorLayout');">
            <?php dropdown_color('cboBordercolorLayout', $bordercolor_layout, 'BordercolorLayout'); ?>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_borderradius_layout', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <span class="font_main"><?php give_translation('edit_structure.borderradius_tl_layout', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusLTLayout" value="<?php echo($radius_layout[0]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_tr_layout', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusRTLayout" value="<?php echo($radius_layout[1]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_br_layout', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusRBLayout" value="<?php echo($radius_layout[2]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_bl_layout', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusLBLayout" value="<?php echo($radius_layout[3]); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellcolor_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboTablebgLayout', 'TablebgLayout');">
            <?php dropdown_color('cboTablebgLayout', $tablebg_layout, 'TablebgLayout'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellspacing_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCsLayout" value="<?php echo($cs_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellpadding_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCpLayout" value="<?php echo($cp_layout); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_layout', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorLayout', 'BgcolorLayout');">
            <?php dropdown_color('cboBgcolorLayout', $bgcolor_layout, 'BgcolorLayout'); ?>
        </td>
        
        <tr></tr>
        
<?php
            include('modules/structure/main/content/layout/top.php');
?>
        
        <tr></tr>
        
<?php
            include('modules/structure/main/content/layout/middle.php');
?>        
        
        <tr></tr>
        
<?php
            include('modules/structure/main/content/layout/bottom.php');
?>        
        
        <tr></tr>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_layout" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




