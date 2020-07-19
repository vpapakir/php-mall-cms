<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_image_subtitle_status_offline', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminImageStatusOffline" style="width: 99%;" value="<?php if(!empty($adminconfig_image_status_offline)){ echo($adminconfig_image_status_offline); } ?>" />
    </td>
</tr>
<?php
if(!empty($adminconfig_image_status_offline))
{
?>
    <tr>
        <td align="left" colspan="2">
            <img src="<?php echo($config_customheader.$adminconfig_image_status_offline); ?>" alt="status_offline"/>
        </td>
    </tr>
<?php
}
?>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>