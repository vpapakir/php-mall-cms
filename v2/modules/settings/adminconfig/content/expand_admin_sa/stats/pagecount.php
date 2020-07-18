<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_stats_subtitle_pagecount', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminStatsPageCount" value="<?php if(!empty($adminconfig_admin_statspagecount)){ echo($adminconfig_admin_statspagecount); } ?>" />
    </td>
</tr>