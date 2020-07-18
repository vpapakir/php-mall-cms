<tr>
    <td align="center" colspan="2">
        <div class="block_title4"><?php give_translation('edit_item.subtitle_button_active', '', $config_showtranslationcode); ?></div>
    </td>
</tr>
<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_preview_item', '', $config_showtranslationcode); ?> (Active)
</td>
<td>
    <input id="show_preview_button_active" type="submit" name="preview_button_active" value="AaBbCcIi0123"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <select id="cboAddFamilyButtonActive" name="cboAddFamilyButtonActive" onclick="preview_button_show('show_preview_button_active', 'cboAddFamilyButtonActive', 'fontfamily');">
<?php
            try
            {
                $prepared_query = 'SELECT * FROM fonts
                                   ORDER BY name_fonts';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                
                while($data = $query->fetch())
                {
?>
                    <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>"><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
<?php                     
                    
                }
                $query->closeCursor();
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
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_size_item', '', $config_showtranslationcode); ?>
</td> 
<td>
    <input id="txtAddSizeButtonActive" type="text" name="txtAddSizeButtonActive"  onkeyup="preview_button_show('show_preview_button_active', 'txtAddSizeButtonActive', 'fontsize');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <select id="cboAddWeightButtonActive" name="cboAddWeightButtonActive" onchange="preview_button_show('show_preview_button_active', 'cboAddWeightButtonActive', 'fontweight');">
        <option style="font-weight: normal;" value="normal"><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
        <option style="font-weight: bold;" value="bold"><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_color_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <?php dropdown_color_show_button('cboAddColorButtonActive', '', 'AddColorButtonActive', 'show_preview_button_active', 'fontcolor'); ?>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <select id="cboAddAlignButtonActive" name="cboAddAlignButtonActive" onchange="preview_button_show('show_preview_button_active', 'cboAddAlignButtonActive', 'textalign');">
        <option style="text-align: left;" value="left"><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
        <option style="text-align: center;" value="center"><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
        <option style="text-align: right;" value="right"><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
        <option style="text-align: justify;" value="justify"><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <input id="txtAddSizeBorderButtonActive" type="text" name="txtAddSizeBorderButtonActive" onkeyup="preview_button_show('show_preview_button_active', 'txtAddSizeBorderButtonActive', 'border');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <?php dropdown_color_show_button('cboBordercolorButtonActive', '', 'BordercolorButtonActive', 'show_preview_button_active', 'bordercolor'); ?>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
    <input style="width: 30px;" id="txtAddBorderRadiusLTButtonActive" type="text" name="txtAddBorderRadiusLTButtonActive" onkeyup="preview_button_show_radius('show_preview_button_active', 'txtAddBorderRadiusLTButtonActive', 'txtAddBorderRadiusRTButtonActive', 'txtAddBorderRadiusRBButtonActive', 'txtAddBorderRadiusLBButtonActive');"></input>
    &nbsp;
    <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
    <input style="width: 30px;" id="txtAddBorderRadiusRTButtonActive" type="text" name="txtAddBorderRadiusRTButtonActive" onkeyup="preview_button_show_radius('show_preview_button_active', 'txtAddBorderRadiusLTButtonActive', 'txtAddBorderRadiusRTButtonActive', 'txtAddBorderRadiusRBButtonActive', 'txtAddBorderRadiusLBButtonActive');"></input>
    &nbsp;
    <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
    <input style="width: 30px;" id="txtAddBorderRadiusRBButtonActive" type="text" name="txtAddBorderRadiusRBButtonActive" onkeyup="preview_button_show_radius('show_preview_button_active', 'txtAddBorderRadiusLTButtonActive', 'txtAddBorderRadiusRTButtonActive', 'txtAddBorderRadiusRBButtonActive', 'txtAddBorderRadiusLBButtonActive');"></input>
    &nbsp;
    <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
    <input style="width: 30px;" id="txtAddBorderRadiusLBButtonActive" type="text" name="txtAddBorderRadiusLBButtonActive" onkeyup="preview_button_show_radius('show_preview_button_active', 'txtAddBorderRadiusLTButtonActive', 'txtAddBorderRadiusRTButtonActive', 'txtAddBorderRadiusRBButtonActive', 'txtAddBorderRadiusLBButtonActive');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <?php dropdown_color_show_button('cboBgColorButtonActive', '', 'BgColorButtonActive', 'show_preview_button_active', 'bgcolor'); ?>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <input id="txtAddWidthButtonActive" type="text" name="txtAddWidthButtonActive" onkeyup="preview_button_show('show_preview_button_active', 'txtAddWidthButtonActive', 'width');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <input id="txtAddHeightButtonActive" type="text" name="txtAddHeightButtonActive" onkeyup="preview_button_show('show_preview_button_active', 'txtAddHeightButtonActive', 'height');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <input id="txtAddPaddingButtonActive" type="text" name="txtAddPaddingButtonActive" onkeyup="preview_button_show('show_preview_button_active', 'txtAddPaddingButtonActive', 'padding');"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
</td>
<td>
    <input class="font_main" type="text" name="txtAddImageButtonActive"></input>
</td>
