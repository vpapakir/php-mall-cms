<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('signature_edit.subtitle_script_signature', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 99%;" type="text" name="txtScriptpathSignature" value="<?php if(!empty($_SESSION['signature_txtScriptpathSignature'])){ echo($_SESSION['signature_txtScriptpathSignature']); } ?>"/>
                </td>
            </tr>  
    </table></td>
</tr>
