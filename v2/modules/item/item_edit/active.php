<tr>
    <td align="center" colspan="2">
        <div class="block_title4"><?php give_translation('edit_item.subtitle_button_active', '', $config_showtranslationcode); ?></div>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_preview_item', '', $config_showtranslationcode); ?> (Active)
    </td>
    <td>
        <input style="font-family: <?php echo($family_button[2]); ?>;
                        font-size: <?php echo($size_button[2].'px'); ?>;
                        font-weight: <?php echo($weight_button[2]); ?>;
                        color: <?php echo($color_button[2]); ?>;
                        text-align: <?php echo($align_button[2]); ?>;
                        border: <?php echo($border_button[2].'px solid'); ?>;
                        border-color: <?php echo($bordercolor_button[2]); ?>;
                        border-radius: <?php echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;
/*                        -moz-border-radius: <?php //echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;*/
                        -webkit-border-radius: <?php echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;
                        background-color: <?php echo($bgcolor_button[2]); ?>;
                        width: <?php echo($width_button_display[2]); ?>;
                        height: <?php echo($height_button_display[2]); ?>;
                        padding: <?php echo($padding_button[2].'px'); ?>;
                        background-image: url('<?php echo($image_button[2]); ?>');"
                        disabled="true" id="show_preview_button_active_edit" type="submit" name="preview_button_edit_active" value="AaBbCcIi0123"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditFamilyButtonActive" name="cboEditFamilyButtonActive" onclick="preview_button_show('show_preview_button_active_edit', 'cboEditFamilyButtonActive', 'fontfamily');">
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
                        <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>" <?php if($family_button[2] == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
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
        <input id="txtEditSizeButtonActive" type="text" name="txtEditSizeButtonActive" value="<?php echo($size_button[2]); ?>" onkeyup="preview_button_show('show_preview_button_active_edit', 'txtEditSizeButtonActive', 'fontsize');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditWeightButtonActive" name="cboEditWeightButtonActive" onchange="preview_button_show('show_preview_button_active_edit', 'cboEditWeightButtonActive', 'fontweight');">
            <option style="font-weight: normal;" value="normal" <?php if($weight_button[2] == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
            <option style="font-weight: bold;" value="bold" <?php if($weight_button[2] == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_color_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboEditColorButtonActive', $color_button[2], 'EditColorButtonActive', 'show_preview_button_active_edit', 'fontcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditAlignButtonActive" name="cboEditAlignButtonActive" onchange="preview_button_show('show_preview_button_active_edit', 'cboEditAlignButtonActive', 'textalign');">
            <option style="text-align: left;" value="left" <?php if($align_button[2] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
            <option style="text-align: center;" value="center" <?php if($align_button[2] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
            <option style="text-align: right;" value="right" <?php if($align_button[2] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
            <option style="text-align: justify;" value="justify" <?php if($align_button[2] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditSizeBorderButtonActive" type="text" name="txtEditSizeBorderButtonActive" value="<?php echo($border_button[2]); ?>" onkeyup="preview_button_show('show_preview_button_active_edit', 'txtEditSizeBorderButtonActive', 'border');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBordercolorButtonActive', $bordercolor_button[2], 'BordercolorButtonActive', 'show_preview_button_active_edit', 'bordercolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLTButtonActive" type="text" name="txtEditBorderRadiusLTButtonActive" value="<?php echo($borderradius_lt_button[2]); ?>" onkeyup="preview_button_show_radius('show_preview_button_active_edit', 'txtEditBorderRadiusLTButtonActive', 'txtEditBorderRadiusRTButtonActive', 'txtEditBorderRadiusRBButtonActive', 'txtEditBorderRadiusLBButtonActive');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRTButtonActive" type="text" name="txtEditBorderRadiusRTButtonActive" value="<?php echo($borderradius_rt_button[2]); ?>" onkeyup="preview_button_show_radius('show_preview_button_active_edit', 'txtEditBorderRadiusLTButtonActive', 'txtEditBorderRadiusRTButtonActive', 'txtEditBorderRadiusRBButtonActive', 'txtEditBorderRadiusLBButtonActive');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRBButtonActive" type="text" name="txtEditBorderRadiusRBButtonActive" value="<?php echo($borderradius_rb_button[2]); ?>" onkeyup="preview_button_show_radius('show_preview_button_active_edit', 'txtEditBorderRadiusLTButtonActive', 'txtEditBorderRadiusRTButtonActive', 'txtEditBorderRadiusRBButtonActive', 'txtEditBorderRadiusLBButtonActive');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLBButtonActive" type="text" name="txtEditBorderRadiusLBButtonActive" value="<?php echo($borderradius_lb_button[2]); ?>" onkeyup="preview_button_show_radius('show_preview_button_active_edit', 'txtEditBorderRadiusLTButtonActive', 'txtEditBorderRadiusRTButtonActive', 'txtEditBorderRadiusRBButtonActive', 'txtEditBorderRadiusLBButtonActive');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorButtonActive', $bgcolor_button[2], 'BgColorButtonActive', 'show_preview_button_active_edit', 'bgcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditWidthButtonActive" type="text" name="txtEditWidthButtonActive" value="<?php echo($width_button[2]); ?>" onkeyup="preview_button_show('show_preview_button_active_edit', 'txtEditWidthButtonActive', 'width');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditHeightButtonActive" type="text" name="txtEditHeightButtonActive" value="<?php echo($height_button[2]); ?>" onkeyup="preview_button_show('show_preview_button_active_edit', 'txtEditHeightButtonActive', 'height');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td> 
    <td>
        <input id="txtEditPaddingButtonActive" type="text" name="txtEditPaddingButtonActive" value="<?php echo($padding_button[2]); ?>" onkeyup="preview_button_show('show_preview_button_active_edit', 'txtEditPaddingButtonActive', 'padding');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtEditImageButtonActive" value="<?php echo($image_button[2]); ?>"></input>
    </td>
</tr>
