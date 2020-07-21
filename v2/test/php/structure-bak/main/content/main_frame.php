<?php
try
{
    $prepared_query = 'SELECT * FROM structure_frame
                       WHERE id_frame = :frame';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('frame', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_frame = $data['id_frame'];
        $name_frame = $data['name_frame'];
        
        $width_frame = $data['width_frame'];
        $height_frame = $data['height_frame'];
        $position_frame = $data['position_frame'];
        $margin_frame = $data['margin_frame'];
        $border_frame = $data['border_frame'];
        $bordercolor_frame = $data['bordercolor_frame'];
        $tablebg_frame = $data['tablebg_frame'];
        $cs_frame = $data['cs_frame'];
        $cp_frame  = $data['cp_frame'];
        
        $bgcolor_frame = $data['bgcolor_frame'];
        $bgimage_frame = $data['bgimg_frame'];
        $xrepeat_frame = $data['xrepeat_frame'];
        $yrepeat_frame = $data['yrepeat_frame'];
        
        $status_frame = $data['status_frame'];
        $type_frame = $data['type_frame'];
    }
    $query->closeCursor();
    
    $_SESSION['structure_edit_id_element'] = $id_frame;
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
            <?php give_translation('edit_structure.subtitle_name_frame', '', $config_showtranslationcode); ?>
        </td>
        <td width="60%">
            <input type="text" name="txtNameFrame" value="<?php echo($name_frame); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_frame_txtNameFrame']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_frame_txtNameFrame'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_width_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtWidthFrame" value="<?php echo($width_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_height_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtHeightFrame" value="<?php echo($height_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_position_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtPositionFrame" value="<?php echo($position_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_margin_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtMarginFrame" value="<?php echo($margin_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_border_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtBorderFrame" value="<?php echo($border_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bordercolor_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBordercolorFrame', 'BordercolorFrame');">
            <?php dropdown_color('cboBordercolorFrame', $bordercolor_frame, 'BordercolorFrame'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellcolor_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboTablebgFrame', 'TablebgFrame');">
            <?php dropdown_color('cboTablebgFrame', $tablebg_frame, 'TablebgFrame'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellspacing_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCsFrame" value="<?php echo($cs_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellpadding_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCpFrame" value="<?php echo($cp_frame); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorFrame', 'BgcolorFrame');">
            <?php dropdown_color('cboBgcolorFrame', $bgcolor_frame, 'BgcolorFrame'); ?>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_status_frame', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboStatusFrame">
                <option value="1" <?php if($status_frame == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.status_enabled_frame', '', $config_showtranslationcode); ?></option>
<?php
if($type_frame != 'main')
{
?>                
                <option value="0" <?php if($status_frame == 0){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.status_disabled_frame', '', $config_showtranslationcode); ?></option>
<?php
}
else
{
?>
                <option value="0" disabled="true"><?php give_translation('edit_structure.status_disabled_frame', '', $config_showtranslationcode); ?></option>
<?php
}
?>                
            </select>
        </td>
        
        <tr></tr>  
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_frame" value="<?php give_translation('edit_structure.main_bt_save_frame', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




