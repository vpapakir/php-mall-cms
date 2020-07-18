<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('dirtyword_edit.subtitle_choicelang', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboSelectLangDirtyword" onchange="OnChange('bt_cboSelectLangDirtyword');">
                        <option value="select"
                            <?php if(empty($_SESSION['dirtyword_cboSelectLangDirtyword']) || $_SESSION['dirtyword_cboSelectLangDirtyword'] == 'select'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_select', $echo, $config_showtranslationcode); ?></option>
<?php
                    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                    {
?>
                        <option value="<?php echo($main_activatedidlang[$i]); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboSelectLangDirtyword']) && $_SESSION['dirtyword_cboSelectLangDirtyword'] == $main_activatedidlang[$i]){ echo('selected="selected"'); } ?>    
                                ><?php give_translation($main_activatedcodelang[$i], $echo, $config_showtranslationcode); ?></option>
<?php
                    }
?>
                    </select>  
                    <input id="bt_cboSelectLangDirtyword" style="display: none;" hidden="hidden" type="submit" name="bt_cboSelectLangDirtyword" value="select"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
