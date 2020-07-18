<tr>
    <td align="left"><table width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_name_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 99%;" type="text" name="txtNameMailtext<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]])){ echo($_SESSION['mailtext_txtNameMailtext'.$main_activatedidlang[$i]]); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_mailtext_txtNameMailtext']) && $i == 0)
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_mailtext_txtNameMailtext']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_subject_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left">
                    <input style="width: 99%;" type="text" name="txtSubjectMailtext<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]])){ echo($_SESSION['mailtext_txtSubjectMailtext'.$main_activatedidlang[$i]]); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_mailtext_txtSubjectMailtext']) && $i == 0)
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_mailtext_txtSubjectMailtext']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_top_mailtext', '', $config_showtranslationcode) ?>
                </td>
            </tr>  
            <tr>
                <td colspan="2" align="left">
                    <textarea name="areaTopMailtext<?php echo($main_activatedidlang[$i]); ?>" style="width: 100%;" class="tinyMCE_editor"><?php if(!empty($_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]])){ echo($_SESSION['mailtext_areaTopMailtext'.$main_activatedidlang[$i]]); } ?></textarea>
                </td>
            </tr>
    </table></td>
</tr>
