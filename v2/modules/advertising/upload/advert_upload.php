<tr>
    <td align="left">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_upload', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
        <input type="file" name="upload_advert<?php echo($main_activatedidlang[$i]); ?>"></input>
<?php
        if(!empty($_SESSION['msg_advertedit_upload'.$main_activatedidlang[$i]]))
        {
?>
            <br clear="left"/>
            <div class="font_error1"><?php echo($_SESSION['msg_advertedit_upload'.$main_activatedidlang[$i]]); ?></div>
<?php
        }
?>
    </td>
</tr>

