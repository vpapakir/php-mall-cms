<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_image_subtitle_ratio_x', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminImageRatioX" style="width: 15%; direction: rtl;" value="<?php if(!empty($adminconfig_image_ratio_x)){ echo($adminconfig_image_ratio_x); } ?>" />
    </td>
</tr>