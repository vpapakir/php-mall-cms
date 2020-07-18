<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_image_subtitle_status_away', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminImageStatusAway" style="width: 99%;" value="<?php if(!empty($adminconfig_image_status_away)){ echo($adminconfig_image_status_away); } ?>" />
    </td>
</tr>
<?php
if(!empty($adminconfig_image_status_away))
{
?>
    <tr>
        <td align="left" colspan="2">
            <img src="<?php echo($config_customheader.$adminconfig_image_status_away); ?>" alt="status_away"/>
        </td>
    </tr>
<?php
}
?>