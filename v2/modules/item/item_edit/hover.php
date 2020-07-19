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
        <input style="font-family: <?php echo($family_button[1]); ?>;
                        font-size: <?php echo($size_button[1].'px'); ?>;
                        font-weight: <?php echo($weight_button[1]); ?>;
                        color: <?php echo($color_button[1]); ?>;
                        text-align: <?php echo($align_button[1]); ?>;
                        border: <?php echo($border_button[1].'px solid'); ?>;
                        border-color: <?php echo($bordercolor_button[1]); ?>;
                        border-radius: <?php echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;
/*                        -moz-border-radius: <?php //echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;*/
                        -webkit-border-radius: <?php echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;
                        background-color: <?php echo($bgcolor_button[1]); ?>;
                        width: <?php echo($width_button_display[1]); ?>;
                        height: <?php echo($height_button_display[1]); ?>;
                        padding: <?php echo($padding_button[1].'px'); ?>;
                        background-image: url('<?php echo($image_button[1]); ?>');"
                        disabled="true" id="show_preview_button_hover_edit" type="submit" name="preview_button_edit_hover" value="AaBbCcIi0123"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditFamilyButtonHover" name="cboEditFamilyButtonHover" onclick="preview_button_show('show_preview_button_hover_edit', 'cboEditFamilyButtonHover', 'fontfamily');">
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
                        <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>" <?php if($family_button[1] == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
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
        <input id="txtEditSizeButtonHover" type="text" name="txtEditSizeButtonHover" value="<?php echo($size_button[1]); ?>" onkeyup="preview_button_show('show_preview_button_hover_edit', 'txtEditSizeButtonHover', 'fontsize');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_weight_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditWeightButtonHover" name="cboEditWeightButtonHover" onchange="preview_button_show('show_preview_button_hover_edit', 'cboEditWeightButtonHover', 'fontweight');">
            <option style="font-weight: normal;" value="normal" <?php if($weight_button[1] == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
            <option style="font-weight: bold;" value="bold" <?php if($weight_button[1] == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_color_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboEditColorButtonHover', $color_button[1], 'EditColorButtonHover', 'show_preview_button_hover_edit', 'fontcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_align_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <select id="cboEditAlignButtonHover" name="cboEditAlignButtonHover" onchange="preview_button_show('show_preview_button_hover_edit', 'cboEditAlignButtonHover', 'textalign');">
            <option style="text-align: left;" value="left" <?php if($align_button[1] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
            <option style="text-align: center;" value="center" <?php if($align_button[1] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
            <option style="text-align: right;" value="right" <?php if($align_button[1] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
            <option style="text-align: justify;" value="justify" <?php if($align_button[1] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditSizeBorderButtonHover" type="text" name="txtEditSizeBorderButtonHover" value="<?php echo($border_button[1]); ?>" onkeyup="preview_button_show('show_preview_button_hover_edit', 'txtEditSizeBorderButtonHover', 'border');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBordercolorButtonHover', $bordercolor_button[1], 'BordercolorButtonHover', 'show_preview_button_hover_edit', 'bordercolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLTButtonHover" type="text" name="txtEditBorderRadiusLTButtonHover" value="<?php echo($borderradius_lt_button[1]); ?>" onkeyup="preview_button_show_radius('show_preview_button_hover_edit', 'txtEditBorderRadiusLTButtonHover', 'txtEditBorderRadiusRTButtonHover', 'txtEditBorderRadiusRBButtonHover', 'txtEditBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRTButtonHover" type="text" name="txtEditBorderRadiusRTButtonHover" value="<?php echo($borderradius_rt_button[1]); ?>" onkeyup="preview_button_show_radius('show_preview_button_hover_edit', 'txtEditBorderRadiusLTButtonHover', 'txtEditBorderRadiusRTButtonHover', 'txtEditBorderRadiusRBButtonHover', 'txtEditBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRBButtonHover" type="text" name="txtEditBorderRadiusRBButtonHover" value="<?php echo($borderradius_rb_button[1]); ?>" onkeyup="preview_button_show_radius('show_preview_button_hover_edit', 'txtEditBorderRadiusLTButtonHover', 'txtEditBorderRadiusRTButtonHover', 'txtEditBorderRadiusRBButtonHover', 'txtEditBorderRadiusLBButtonHover');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLBButtonHover" type="text" name="txtEditBorderRadiusLBButtonHover" value="<?php echo($borderradius_lb_button[1]); ?>" onkeyup="preview_button_show_radius('show_preview_button_hover_edit', 'txtEditBorderRadiusLTButtonHover', 'txtEditBorderRadiusRTButtonHover', 'txtEditBorderRadiusRBButtonHover', 'txtEditBorderRadiusLBButtonHover');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorButtonHover', $bgcolor_button[1], 'BgColorButtonHover', 'show_preview_button_hover_edit', 'bgcolor'); ?>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditWidthButtonHover" type="text" name="txtEditWidthButtonHover" value="<?php echo($width_button[1]); ?>" onkeyup="preview_button_show('show_preview_button_hover_edit', 'txtEditWidthButtonHover', 'width');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditHeightButtonHover" type="text" name="txtEditHeightButtonHover" value="<?php echo($height_button[1]); ?>" onkeyup="preview_button_show('show_preview_button_hover_edit', 'txtEditHeightButtonHover', 'height');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td> 
    <td>
        <input id="txtEditPaddingButtonHover" type="text" name="txtEditPaddingButtonHover" value="<?php echo($padding_button[1]); ?>" onkeyup="preview_button_show('show_preview_button_hover_edit', 'txtEditPaddingButtonHover', 'padding');"></input>
    </td>
</tr>
<tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtEditImageButtonHover" value="<?php echo($image_button[1]); ?>"></input>
    </td>
</tr>
