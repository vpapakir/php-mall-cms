<tr>
    <td align="center" colspan="2">
        <div class="block_title4"><?php give_translation('edit_item.subtitle_button_normal', '', $config_showtranslationcode); ?></div>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_preview_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="show_preview_button" type="submit" name="preview_button" value="AaBbCcIi0123"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddFamilyButton" name="cboAddFamilyButton" onclick="preview_button_show('show_preview_button', 'cboAddFamilyButton', 'fontfamily');">
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
        <input id="txtAddSizeButton" type="text" name="txtAddSizeButton"  onkeyup="preview_button_show('show_preview_button', 'txtAddSizeButton', 'fontsize');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddWeightButton" name="cboAddWeightButton" onchange="preview_button_show('show_preview_button', 'cboAddWeightButton', 'fontweight');">
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
        <?php dropdown_color_show_button('cboAddColorButton', '', 'AddColorButton', 'show_preview_button', 'fontcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboAddAlignButton" name="cboAddAlignButton" onchange="preview_button_show('show_preview_button', 'cboAddAlignButton', 'textalign');">
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
        <input id="txtAddSizeBorderButton" type="text" name="txtAddSizeBorderButton" onkeyup="preview_button_show('show_preview_button', 'txtAddSizeBorderButton', 'border');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBordercolorButton', '', 'BordercolorButton', 'show_preview_button', 'bordercolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusLTButton" type="text" name="txtAddBorderRadiusLTButton" onkeyup="preview_button_show_radius('show_preview_button', 'txtAddBorderRadiusLTButton', 'txtAddBorderRadiusRTButton', 'txtAddBorderRadiusRBButton', 'txtAddBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusRTButton" type="text" name="txtAddBorderRadiusRTButton" onkeyup="preview_button_show_radius('show_preview_button', 'txtAddBorderRadiusLTButton', 'txtAddBorderRadiusRTButton', 'txtAddBorderRadiusRBButton', 'txtAddBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusRBButton" type="text" name="txtAddBorderRadiusRBButton" onkeyup="preview_button_show_radius('show_preview_button', 'txtAddBorderRadiusLTButton', 'txtAddBorderRadiusRTButton', 'txtAddBorderRadiusRBButton', 'txtAddBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtAddBorderRadiusLBButton" type="text" name="txtAddBorderRadiusLBButton" onkeyup="preview_button_show_radius('show_preview_button', 'txtAddBorderRadiusLTButton', 'txtAddBorderRadiusRTButton', 'txtAddBorderRadiusRBButton', 'txtAddBorderRadiusLBButton');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorButton', '', 'BgColorButton', 'show_preview_button', 'bgcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddWidthButton" type="text" name="txtAddWidthButton" onkeyup="preview_button_show('show_preview_button', 'txtAddWidthButton', 'width');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddHeightButton" type="text" name="txtAddHeightButton" onkeyup="preview_button_show('show_preview_button', 'txtAddHeightButton', 'height');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtAddPaddingButton" type="text" name="txtAddPaddingButton" onkeyup="preview_button_show('show_preview_button', 'txtAddPaddingButton', 'padding');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtAddImageButton"></input>
    </td>
</tr>
