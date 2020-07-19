<tr>
    <td align="left"><table width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_bottom_mailtext', '', $config_showtranslationcode) ?>
                </td>
            </tr>  
            <tr>
                <td align="left">
                    <textarea name="areaBottomMailtext<?php echo($main_activatedidlang[$i]); ?>" style="width: 100%;" class="tinyMCE_editor"><?php if(!empty($_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]])){ echo($_SESSION['mailtext_areaBottomMailtext'.$main_activatedidlang[$i]]); } ?></textarea>
                </td>
            </tr>
    </table></td>
</tr>
