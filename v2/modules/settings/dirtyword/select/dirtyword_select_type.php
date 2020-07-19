<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('dirtyword_edit.subtitle_choicetype', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboSelectTypeDirtyword" onchange="OnChange('bt_cboSelectTypeDirtyword');">
                        <option value="select"
                            <?php if(empty($_SESSION['dirtyword_cboSelectTypeDirtyword']) || $_SESSION['dirtyword_cboSelectTypeDirtyword'] == 'select'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_select', $echo, $config_showtranslationcode); ?></option>
                        <option value="replace_char"
                            <?php if(!empty($_SESSION['dirtyword_cboSelectTypeDirtyword']) && $_SESSION['dirtyword_cboSelectTypeDirtyword'] == 'replace_char'){ echo('selected="selected"'); } ?>    
                                ><?php give_translation('dirtyword_edit.dd_replacechar', $echo, $config_showtranslationcode); ?></option>
                        <option value="replace_value"
                            <?php if(!empty($_SESSION['dirtyword_cboSelectTypeDirtyword']) && $_SESSION['dirtyword_cboSelectTypeDirtyword'] == 'replace_value'){ echo('selected="selected"'); } ?>    
                                ><?php give_translation('dirtyword_edit.dd_replacevalue', $echo, $config_showtranslationcode); ?></option>
                    </select>  
                    <input id="bt_cboSelectTypeDirtyword" style="display: none;" hidden="hidden" type="submit" name="bt_cboSelectTypeDirtyword" value="select"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
