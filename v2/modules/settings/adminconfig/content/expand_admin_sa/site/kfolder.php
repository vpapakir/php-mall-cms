<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_kfolder', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainKFolder" style="width: 80%;" value="<?php if(!empty($adminconfig_main_foldername)){ echo($adminconfig_main_foldername); } ?>" />
    </td>
</tr>