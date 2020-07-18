<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_userstatus_logout', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainUserstatusLogout" style="width: 30%;" value="<?php if(!empty($adminconfig_main_elapsedtime_logout)){ echo($adminconfig_main_elapsedtime_logout); } ?>" />
    </td>
</tr>