<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_revisitafter', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainMetaRevisitafter" style="width: 15%; direction: rtl;" value="<?php if(!empty($adminconfig_main_meta_revisitafter)){ echo($adminconfig_main_meta_revisitafter); } ?>" />
        <?php give_translation('adminconfig_edit.admin_main_subtitle_revisitafter_days', $echo, $config_showtranslationcode); ?>
    </td>
</tr>