<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_favicon', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input type="text" name="txtAdminconfigAdminMainFavicon" style="width: 99%;" value="<?php if(!empty($adminconfig_main_favicon)){ echo($adminconfig_main_favicon); } ?>" />
    </td>
</tr>
<?php
if(!empty($adminconfig_main_favicon))
{
?>
    <tr>
        <td align="left" colspan="2">
            <img src="<?php echo($config_customheader.$adminconfig_main_favicon); ?>" alt="favicon.ico"/>
        </td>
    </tr>
<?php
}
?>