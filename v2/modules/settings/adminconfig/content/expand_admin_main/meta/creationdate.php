<tr>
    <td align="left">
        <span class="font_main">
            <?php give_translation('adminconfig_edit.admin_main_subtitle_creationdate', $echo, $config_showtranslationcode); ?>
        </span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
<?php
        birthday('cboAdminconfigAdminMainMetaCreationDateDay', 'cboAdminconfigAdminMainMetaCreationDateMonth', 'cboAdminconfigAdminMainMetaCreationDateYear', $adminconfig_main_meta_creationdate[2], $adminconfig_main_meta_creationdate[1], $adminconfig_main_meta_creationdate[0], 1995, date('Y', time()), $main_id_language)
?>
    </td>
</tr>