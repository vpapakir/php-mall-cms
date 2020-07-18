<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_structure_subtitle_column_right', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminStructureColumnRight" style="width: 15%; direction: rtl;" value="<?php if(!empty($adminconfig_structure_column_width_right)){ echo($adminconfig_structure_column_width_right); } ?>" />
        &nbsp;%
    </td>
</tr>