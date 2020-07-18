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
        <input style="font-family: <?php echo($family_button[0]); ?>;
                        font-size: <?php echo($size_button[0].'px'); ?>;
                        font-weight: <?php echo($weight_button[0]); ?>;
                        color: <?php echo($color_button[0]); ?>;
                        text-align: <?php echo($align_button[0]); ?>;
                        border: <?php echo($border_button[0].'px solid'); ?>;
                        border-color: <?php echo($bordercolor_button[0]); ?>;
                        border-radius: <?php echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;
/*                        -moz-border-radius: <?php //echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;*/
                        -webkit-border-radius: <?php echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;
                        background-color: <?php echo($bgcolor_button[0]); ?>;
                        width: <?php echo($width_button_display[0]); ?>;
                        height: <?php echo($height_button_display[0]); ?>;
                        padding: <?php echo($padding_button[0].'px'); ?>;
                        background-image: url('<?php echo($image_button[0]); ?>');"
                        disabled="true" id="show_preview_button_edit" type="submit" name="preview_button_edit" value="AaBbCcIi0123"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditFamilyButton" name="cboEditFamilyButton" onclick="preview_button_show('show_preview_button_edit', 'cboEditFamilyButton', 'fontfamily');">
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
                            <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>" <?php if($family_button[0] == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
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
        <input id="txtEditSizeButton" type="text" name="txtEditSizeButton" value="<?php echo($size_button[0]); ?>" onkeyup="preview_button_show('show_preview_button_edit', 'txtEditSizeButton', 'fontsize');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditWeightButton" name="cboEditWeightButton" onchange="preview_button_show('show_preview_button_edit', 'cboEditWeightButton', 'fontweight');">
            <option style="font-weight: normal;" value="normal" <?php if($weight_button[0] == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
            <option style="font-weight: bold;" value="bold" <?php if($weight_button[0] == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>

<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_color_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboEditColorButton', $color_button[0], 'EditColorButton', 'show_preview_button_edit', 'fontcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditAlignButton" name="cboEditAlignButton" onchange="preview_button_show('show_preview_button_edit', 'cboEditAlignButton', 'textalign');">
            <option style="text-align: left;" value="left" <?php if($align_button[0] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
            <option style="text-align: center;" value="center" <?php if($align_button[0] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
            <option style="text-align: right;" value="right" <?php if($align_button[0] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
            <option style="text-align: justify;" value="justify" <?php if($align_button[0] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditSizeBorderButton" type="text" name="txtEditSizeBorderButton" value="<?php echo($border_button[0]); ?>" onkeyup="preview_button_show('show_preview_button_edit', 'txtEditSizeBorderButton', 'border');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBordercolorButton', $bordercolor_button[0], 'BordercolorButton', 'show_preview_button_edit', 'bordercolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLTButton" type="text" name="txtEditBorderRadiusLTButton" value="<?php echo($borderradius_lt_button[0]); ?>" onkeyup="preview_button_show_radius('show_preview_button_edit', 'txtEditBorderRadiusLTButton', 'txtEditBorderRadiusRTButton', 'txtEditBorderRadiusRBButton', 'txtEditBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRTButton" type="text" name="txtEditBorderRadiusRTButton" value="<?php echo($borderradius_rt_button[0]); ?>" onkeyup="preview_button_show_radius('show_preview_button_edit', 'txtEditBorderRadiusLTButton', 'txtEditBorderRadiusRTButton', 'txtEditBorderRadiusRBButton', 'txtEditBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRBButton" type="text" name="txtEditBorderRadiusRBButton" value="<?php echo($borderradius_rb_button[0]); ?>" onkeyup="preview_button_show_radius('show_preview_button_edit', 'txtEditBorderRadiusLTButton', 'txtEditBorderRadiusRTButton', 'txtEditBorderRadiusRBButton', 'txtEditBorderRadiusLBButton');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLBButton" type="text" name="txtEditBorderRadiusLBButton" value="<?php echo($borderradius_lb_button[0]); ?>" onkeyup="preview_button_show_radius('show_preview_button_edit', 'txtEditBorderRadiusLTButton', 'txtEditBorderRadiusRTButton', 'txtEditBorderRadiusRBButton', 'txtEditBorderRadiusLBButton');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorButton', $bgcolor_button[0], 'BgColorButton', 'show_preview_button_edit', 'bgcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditWidthButton" type="text" name="txtEditWidthButton" value="<?php echo($width_button[0]); ?>" onkeyup="preview_button_show('show_preview_button_edit', 'txtEditWidthButton', 'width');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditHeightButton" type="text" name="txtEditHeightButton" value="<?php echo($height_button[0]); ?>" onkeyup="preview_button_show('show_preview_button_edit', 'txtEditHeightButton', 'height');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditPaddingButton" type="text" name="txtEditPaddingButton" value="<?php echo($padding_button[0]); ?>" onkeyup="preview_button_show('show_preview_button_edit', 'txtEditPaddingButton', 'padding');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtEditImageButton" value="<?php echo($image_button[0]); ?>"></input>
    </td>
</tr>
