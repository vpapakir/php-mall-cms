<tr>
    <td align="left"><table width="100%" style="margin-bottom: 4px;">  
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('signature_edit.subtitle_name_signature', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 99%;" type="text" name="txtNameSignature<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]])){ echo($_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]]); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_signature_txtNameSignature']) && $i == 0)
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_signature_txtNameSignature']); ?></div>
<?php
                    }
?>                
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <textarea name="areaContentSignature<?php echo($main_activatedidlang[$i]); ?>" style="width: 100%;" class="tinyMCE_editor"><?php if(!empty($_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]])){ echo($_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]]); } ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2"><table width="100%" style="">
                    <tr>        
                        <td align="center">
    <?php
                            if(!empty($_SESSION['signature_cboTemplateSignature']) && $_SESSION['signature_cboTemplateSignature'] != 'new')
                            {
    ?>
                                <input type="submit" name="bt_edit_signature" value="<?php give_translation('main.bt_edit', '', $config_showtranslationcode); ?>"/>
    <?php
                            }
                            else
                            {
    ?>
                                <input type="submit" name="bt_add_signature" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
    <?php
                            }
    ?>
                            <input type="submit" name="bt_preview_signature" value="<?php give_translation('main.bt_preview', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
    </table></td>
</tr>
