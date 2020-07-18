<tr>
    <td align="center" colspan="2">
        <div class="block_title4"><?php give_translation('edit_item.subtitle_button_hover', '', $config_showtranslationcode); ?></div>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_preview_item', '', $config_showtranslationcode); ?> (Hover)
    </td>
    <td>
        <input id="show_preview_button_hover" type="submit" name="preview_button_hover" value="AaBbCcIi0123"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddFamilyButtonHover" name="cboAddFamilyButtonHover" onclick="preview_button_show('show_preview_button_hover', 'cboAddFamilyButtonHover', 'fontfamily');">
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
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_size_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddSizeButtonHover" type="text" name="txtAddSizeButtonHover"  onkeyup="preview_button_show('show_preview_button_hover', 'txtAddSizeButtonHover', 'fontsize');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddWeightButtonHover" name="cboAddWeightButtonHover" onchange="preview_button_show('show_preview_button_hover', 'cboAddWeightButtonHover', 'fontweight');">
            <option style="font-weight: normal;" value="normal"><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
            <option style="font-weight: bold;" value="bold"><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_color_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboAddColorButtonHover', '', 'AddColorButtonHover', 'show_preview_button_hover', 'fontcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddAlignButtonHover" name="cboAddAlignButtonHover" onchange="preview_button_show('show_preview_button_hover', 'cboAddAlignButtonHover', 'textalign');">
            <option style="text-align: left;" value="left"><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
            <option style="text-align: center;" value="center"><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
            <option style="text-align: right;" value="right"><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
            <option style="text-align: justify;" value="justify"><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddSizeBorderButtonHover" type="text" name="txtAddSizeBorderButtonHover" onkeyup="preview_button_show('show_preview_button_hover', 'txtAddSizeBorderButtonHover', 'border');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBordercolorButtonHover', '', 'BordercolorButtonHover', 'show_preview_button_hover', 'bordercolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusLTButtonHover" type="text" name="txtAddBorderRadiusLTButtonHover" onkeyup="preview_button_show_radius('show_preview_button_hover', 'txtAddBorderRadiusLTButtonHover', 'txtAddBorderRadiusRTButtonHover', 'txtAddBorderRadiusRBButtonHover', 'txtAddBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusRTButtonHover" type="text" name="txtAddBorderRadiusRTButtonHover" onkeyup="preview_button_show_radius('show_preview_button_hover', 'txtAddBorderRadiusLTButtonHover', 'txtAddBorderRadiusRTButtonHover', 'txtAddBorderRadiusRBButtonHover', 'txtAddBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusRBButtonHover" type="text" name="txtAddBorderRadiusRBButtonHover" onkeyup="preview_button_show_radius('show_preview_button_hover', 'txtAddBorderRadiusLTButtonHover', 'txtAddBorderRadiusRTButtonHover', 'txtAddBorderRadiusRBButtonHover', 'txtAddBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusLBButtonHover" type="text" name="txtAddBorderRadiusLBButtonHover" onkeyup="preview_button_show_radius('show_preview_button_hover', 'txtAddBorderRadiusLTButtonHover', 'txtAddBorderRadiusRTButtonHover', 'txtAddBorderRadiusRBButtonHover', 'txtAddBorderRadiusLBButtonHover');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorButtonHover', '', 'BgColorButtonHover', 'show_preview_button_hover', 'bgcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddWidthButtonHover" type="text" name="txtAddWidthButtonHover" onkeyup="preview_button_show('show_preview_button_hover', 'txtAddWidthButtonHover', 'width');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddHeightButtonHover" type="text" name="txtAddHeightButtonHover" onkeyup="preview_button_show('show_preview_button_hover', 'txtAddHeightButtonHover', 'height');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddPaddingButtonHover" type="text" name="txtAddPaddingButtonHover" onkeyup="preview_button_show('show_preview_button_hover', 'txtAddPaddingButtonHover', 'padding');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtAddImageButtonHover"></input>
    </td>
</tr>
