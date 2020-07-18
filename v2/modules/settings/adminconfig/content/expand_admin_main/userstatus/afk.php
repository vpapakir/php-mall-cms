<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_userstatus_afk', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainUserstatusAFK" style="width: 30%;" value="<?php if(!empty($adminconfig_main_elapsedtime_afk)){ echo($adminconfig_main_elapsedtime_afk); } ?>" />
    </td>
</tr>