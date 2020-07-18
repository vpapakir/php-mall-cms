<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_noimage_origin', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainNoimageOrigin" style="width: 99%;" value="<?php if(!empty($adminconfig_main_noimage_origin)){ echo($adminconfig_main_noimage_origin); } ?>" />
    </td>
</tr>
<?php
if(!empty($adminconfig_main_noimage_origin))
{
?>
    <tr>
        <td align="left" colspan="2">
            <img src="<?php echo($config_customheader.$adminconfig_main_noimage_origin); ?>" alt="noimage_origin"/>
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