<?php
try
{
    $prepared_query = 'SELECT * FROM structure_section
                       WHERE id_section = :section';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('section', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_section = $data['id_section'];
        $name_section = $data['name_section'];
        
        $width_section = $data['width_section'];
        $height_section = $data['height_section'];
        $position_section = $data['position_section'];
        $margin_section = $data['margin_section'];
        $border_section = $data['border_section'];
        $bordercolor_section = $data['bordercolor_section'];
        $tablebg_section = $data['tablebg_section'];
        $cs_section = $data['cs_section'];
        $cp_section  = $data['cp_section'];
        
        $bgcolor_section = $data['bgcolor_section'];
        $bgimage_section = $data['bgimg_section'];
        $xrepeat_section = $data['xrepeat_section'];
        $yrepeat_section = $data['yrepeat_section'];
        
        $radius_section = $data['radius_section']; 
    }
    $query->closeCursor();
    
    $radius_section = split_string($radius_section, '$');
    
    $_SESSION['structure_edit_id_element'] = $id_section;
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
            <?php give_translation('edit_structure.subtitle_name_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameSection" value="<?php echo($name_section); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_section_txtNameSection']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_section_txtNameSection'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_width_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtWidthSection" value="<?php echo($width_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_height_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtHeightSection" value="<?php echo($height_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_position_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtPositionSection" value="<?php echo($position_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_margin_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtMarginSection" value="<?php echo($margin_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_border_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtBorderSection" value="<?php echo($border_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bordercolor_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBordercolorSection', 'BordercolorSection');">
            <?php dropdown_color('cboBordercolorSection', $bordercolor_section, 'BordercolorSection'); ?>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_borderradius_section', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <span class="font_main"><?php give_translation('edit_structure.borderradius_tl_section', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusLTSection" value="<?php echo($radius_section[0]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_tr_section', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusRTSection" value="<?php echo($radius_section[1]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_br_section', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusRBSection" value="<?php echo($radius_section[2]); ?>"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_structure.borderradius_bl_section', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" type="text" name="txtBorderRadiusLBSection" value="<?php echo($radius_section[3]); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellcolor_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboTablebgSection', 'TablebgSection');">
            <?php dropdown_color('cboTablebgSection', $tablebg_section, 'TablebgSection'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellspacing_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCsSection" value="<?php echo($cs_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellpadding_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCpSection" value="<?php echo($cp_section); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_section', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorSection', 'BgcolorSection');">
            <?php dropdown_color('cboBgcolorSection', $bgcolor_section, 'BgcolorSection'); ?>
        </td>
        
        <tr></tr>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_section" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




