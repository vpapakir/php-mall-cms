<tr>
<td colspan="2"><table width="100%" id="show_preview_block" onmouseover="preview_show_hover('show_preview_block', 'cboBgColorHoverBlock');" onmouseout="preview_show_hover('show_preview_block', 'cboBgColorBlock');">
    <tr>
        <td class="font_main" name="show_span_block" style="text-align: center;">
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
    <tr>
        <td class="font_subtitle" width="40%">
            <?php give_translation('edit_item.subtitle_border_item', '', $config_showtranslationcode); ?>
        </td>
        <td width="60%">
            <input id="txtAddBordersizeBlock" type="text" name="txtAddBordersizeBlock" onkeyup="preview_button_show('show_preview_block', 'txtAddBordersizeBlock', 'border');"></input>
        </td>   
    </tr>
    
    <tr>   
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_bordercolor_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <?php dropdown_color_show_button('cboAddBordercolorBlock', '', 'AddBordercolorBlock', 'show_preview_block', 'bordercolor'); ?>
        </td>
    </tr> 
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_radius_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <span class="font_main"><?php give_translation('edit_item.radius_tl_item', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" id="txtAddBorderRadiusLTBlock" type="text" name="txtAddBorderRadiusLTBlock" onkeyup="preview_button_show_radius('show_preview_block', 'txtAddBorderRadiusLTBlock', 'txtAddBorderRadiusRTBlock', 'txtAddBorderRadiusRBBlock', 'txtAddBorderRadiusLBBlock');"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_item.radius_tr_item', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" id="txtAddBorderRadiusRTBlock" type="text" name="txtAddBorderRadiusRTBlock" onkeyup="preview_button_show_radius('show_preview_block', 'txtAddBorderRadiusLTBlock', 'txtAddBorderRadiusRTBlock', 'txtAddBorderRadiusRBBlock', 'txtAddBorderRadiusLBBlock');"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_item.radius_br_item', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" id="txtAddBorderRadiusRBBlock" type="text" name="txtAddBorderRadiusRBBlock" onkeyup="preview_button_show_radius('show_preview_block', 'txtAddBorderRadiusLTBlock', 'txtAddBorderRadiusRTBlock', 'txtAddBorderRadiusRBBlock', 'txtAddBorderRadiusLBBlock');"></input>
            &nbsp;
            <span class="font_main"><?php give_translation('edit_item.radius_bl_item', '', $config_showtranslationcode); ?></span>
            <input style="width: 30px;" id="txtAddBorderRadiusLBBlock" type="text" name="txtAddBorderRadiusLBBlock" onkeyup="preview_button_show_radius('show_preview_block', 'txtAddBorderRadiusLTBlock', 'txtAddBorderRadiusRTBlock', 'txtAddBorderRadiusRBBlock', 'txtAddBorderRadiusLBBlock');"></input>
        </td>
    </tr>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_bgcolor_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <?php dropdown_color_show_button('cboBgColorBlock', '', 'BgColorBlock', 'show_preview_block', 'bgcolor'); ?>
        </td>
    </tr>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_width_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input id="txtAddWidthBlock" type="text" name="txtAddWidthBlock" onkeyup="preview_button_show('show_preview_block', 'txtAddWidthBlock', 'width');"></input>
        </td>
    </tr>

    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_height_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input id="txtAddHeightBlock" type="text" name="txtAddHeightBlock" onkeyup="preview_button_show('show_preview_block', 'txtAddHeightBlock', 'height');"></input>
        </td>
    </tr>

    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_padding_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input id="txtAddPaddingBlock" type="text" name="txtAddPaddingBlock" onkeyup="preview_button_show('show_preview_block', 'txtAddPaddingBlock', 'padding');"></input>
        </td>
    </tr>

    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_image_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input class="font_main" type="text" name="txtAddImageBlock"></input>
        </td>
    </tr>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_font_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select id="cboAddFontBlock" name="cboAddFontBlock" onchange="preview_button_show('show_preview_block', 'cboAddFontBlock', 'fontblock', 'show_span_block');">
                <option value="font_main" class="font_main" style="background-color: lightgray;"><?php give_translation('edit_structure.main_text_font', '', $config_showtranslationcode); ?></option>
                <option value="font_title" class="font_title" style="background-color: lightgray;"><?php give_translation('edit_structure.main_title_font', '', $config_showtranslationcode); ?></option>
                <option value="font_intro" class="font_intro" style="background-color: lightgray;"><?php give_translation('edit_structure.main_intro_font', '', $config_showtranslationcode); ?></option>
                <option value="font_desc" class="font_desc" style="background-color: lightgray;"><?php give_translation('edit_structure.main_desc_font', '', $config_showtranslationcode); ?></option>
                <option value="font_subtitle" class="font_subtitle" style="background-color: lightgray;"><?php give_translation('edit_structure.main_subtitle_font', '', $config_showtranslationcode); ?></option>
                <option value="font_comment" class="font_comment" style="background-color: lightgray;"><?php give_translation('edit_structure.main_comment_font', '', $config_showtranslationcode); ?></option>   
                <option value="font_block1" class="font_block1" style="background-color: lightgray;"><?php give_translation('edit_structure.main_blockstyle1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_block2" class="font_block2" style="background-color: lightgray;"><?php give_translation('edit_structure.main_blockstyle2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_block3" class="font_block3" style="background-color: lightgray;"><?php give_translation('edit_structure.main_blockstyle3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error1" class="font_error1" style="background-color: lightgray;"><?php give_translation('edit_structure.main_error1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error2" class="font_error2" style="background-color: lightgray;"><?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_error3" class="font_error3" style="background-color: lightgray;"><?php give_translation('edit_structure.main_error3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info1" class="font_info1" style="background-color: lightgray;"><?php give_translation('edit_structure.main_info1_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info2" class="font_info2" style="background-color: lightgray;"><?php give_translation('edit_structure.main_info2_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info3" class="font_info3" style="background-color: lightgray;"><?php give_translation('edit_structure.main_info3_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info4" class="font_info4" style="background-color: lightgray;"><?php give_translation('edit_structure.main_info4_font', '', $config_showtranslationcode); ?></option>
                <option value="font_info5" class="font_info5" style="background-color: lightgray;"><?php give_translation('edit_structure.main_info5_font', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_bgcolorhover_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <?php dropdown_color('cboBgColorHoverBlock', '', 'BgColorHoverBlock'); ?>
        </td>
    </tr>
        
    
</table></td>
</tr>
