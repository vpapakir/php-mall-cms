<tr>
<td colspan="2"><table style="border: <?php echo($border_block.'px solid'); ?>;
                        border-color: <?php echo($bordercolor_block); ?>;
                        border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
/*                        -moz-border-radius: <?php //echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;*/
                        -webkit-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                        background-color: <?php echo($bgcolor_block); ?>;
                        width: <?php echo($width_block_display); ?>;
                        height: <?php echo($height_block_display); ?>;
                        padding: <?php echo($padding_block.'px'); ?>;
                        background-image: url('<?php echo($image_block); ?>');"
                        width="100%" id="show_preview_block_edit"
                        onmouseover="preview_show_hover('show_preview_block_edit', 'cboBgColorHoverEditBlock');" 
                        onmouseout="preview_show_hover('show_preview_block_edit', 'cboBgColorEditBlock');">
    <tr>
        <td class="<?php echo($font_block); ?>" name="show_span_block_edit" style="text-align: center;">
            <?php give_translation('edit_item.subtitle_preview_item', '', $config_showtranslationcode); ?>
        </td>
    </tr>
</table></td>
</tr>
<tr>
    <td colspan="2" style="border-bottom: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
</tr>
<tr>
<td colspan="2"><table width="100%">
    
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
    </td>
    <td width="<?php echo($right_column_width); ?>">
        <input id="txtEditBordersizeBlock" type="text" name="txtEditBordersizeBlock" value="<?php echo($border_block); ?>" onkeyup="preview_button_show('show_preview_block_edit', 'txtEditBordersizeBlock', 'border');"></input>
    </td>   
        
    <tr></tr> 
    
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboEditBordercolorBlock', $bordercolor_block, 'EditBordercolorBlock', 'show_preview_block_edit', 'bordercolor'); ?>
    </td> 
    
    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLTBlock" type="text" name="txtEditBorderRadiusLTBlock" value="<?php echo($borderradius_lt_block); ?>" onkeyup="preview_button_show_radius('show_preview_block_edit', 'txtEditBorderRadiusLTBlock', 'txtEditBorderRadiusRTBlock', 'txtEditBorderRadiusRBBlock', 'txtEditBorderRadiusLBBlock');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRTBlock" type="text" name="txtEditBorderRadiusRTBlock" value="<?php echo($borderradius_rt_block); ?>" onkeyup="preview_button_show_radius('show_preview_block_edit', 'txtEditBorderRadiusLTBlock', 'txtEditBorderRadiusRTBlock', 'txtEditBorderRadiusRBBlock', 'txtEditBorderRadiusLBBlock');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusRBBlock" type="text" name="txtEditBorderRadiusRBBlock" value="<?php echo($borderradius_rb_block); ?>" onkeyup="preview_button_show_radius('show_preview_block_edit', 'txtEditBorderRadiusLTBlock', 'txtEditBorderRadiusRTBlock', 'txtEditBorderRadiusRBBlock', 'txtEditBorderRadiusLBBlock');"></input>
        &nbsp;
        <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
        <input style="width: 30px;" id="txtEditBorderRadiusLBBlock" type="text" name="txtEditBorderRadiusLBBlock" value="<?php echo($borderradius_lb_block); ?>" onkeyup="preview_button_show_radius('show_preview_block_edit', 'txtEditBorderRadiusLTBlock', 'txtEditBorderRadiusRTBlock', 'txtEditBorderRadiusRBBlock', 'txtEditBorderRadiusLBBlock');"></input>
    </td>
    
    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <?php dropdown_color_show_button('cboBgColorEditBlock', $bgcolor_block, 'BgColorEditBlock', 'show_preview_block_edit', 'bgcolor'); ?>
    </td>
    
    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditWidthBlock" type="text" name="txtEditWidthBlock" value="<?php echo($width_block); ?>" onkeyup="preview_button_show('show_preview_block_edit', 'txtEditWidthBlock', 'width');"></input>
    </td>

    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditHeightBlock" type="text" name="txtEditHeightBlock" value="<?php echo($height_block); ?>" onkeyup="preview_button_show('show_preview_block_edit', 'txtEditHeightBlock', 'height');"></input>
    </td>

    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input id="txtEditPaddingBlock" type="text" name="txtEditPaddingBlock" value="<?php echo($padding_block); ?>" onkeyup="preview_button_show('show_preview_block_edit', 'txtEditPaddingBlock', 'padding');"></input>
    </td>

    <tr></tr>

    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtEditImageBlock" value="<?php echo($image_block); ?>"></input>
    </td>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select id="cboEditFontBlock" name="cboEditFontBlock" onchange="preview_button_show('show_preview_block_edit', 'cboEditFontBlock', 'fontblock', 'show_span_block_edit');">
                <option value="font_main" class="font_main" style="background-color: lightgray;" <?php if(empty($font_block) || $font_block == 'font_main'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_text_font', '', $config_showtranslationcode); ?></option>
                <option value="font_title" class="font_title" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_title'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_title_font', '', $config_showtranslationcode); ?></option>
                <option value="font_intro" class="font_intro" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_intro'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?></option>
                <option value="font_desc" class="font_desc" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_desc'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_desc_font', '', $config_showtranslationcode); ?></option>
                <option value="font_subtitle" class="font_subtitle" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_subtitle'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_subtitle_font', '', $config_showtranslationcode); ?></option>
                <option value="font_comment" class="font_comment" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_comment'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_comment_font', '', $config_showtranslationcode); ?></option>   
                <option value="font_block1" class="font_block1" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_block1'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_blockstyle1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_block2" class="font_block2" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_block2'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_blockstyle2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_block3" class="font_block3" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_block3'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_blockstyle3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error1" class="font_error1" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_error1'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_error1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error2" class="font_error2" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_error2'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error3" class="font_error3" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_error3'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_error3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info1" class="font_info1" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_info1'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_info1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info2" class="font_info2" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_info2'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_info2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info3" class="font_info3" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_info3'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_info3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info4" class="font_info4" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_info4'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_info4_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info5" class="font_info5" style="background-color: lightgray;" <?php if(!empty($font_block) && $font_block == 'font_info5'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.main_info5_font', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_bgcolorhover_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <?php dropdown_color('cboBgColorHoverEditBlock', $bgcolorhover_block, 'BgColorHoverEditBlock'); ?>
        </td>
    </tr>
        
    
</table></td>
</tr>
