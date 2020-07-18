<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_robots', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainMetaRobots" style="width: 80%;" value="<?php if(!empty($adminconfig_main_meta_robots)){ echo($adminconfig_main_meta_robots); } ?>" />
    </td>
</tr>