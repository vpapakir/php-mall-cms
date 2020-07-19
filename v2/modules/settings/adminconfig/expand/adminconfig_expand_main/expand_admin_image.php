<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigMainImage"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigMainImage', 'img_adminconfig_main_image', 'expand_adminconfig_main_image', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigMainImage', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_main_image']) || $_SESSION['expand_adminconfig_main_image'] == 'false')
                        {
?>
                            <span id="img_adminconfig_main_image" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_main_image" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.main_title_image', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_main_image" style="display: none;" type="hidden" name="expand_adminconfig_main_image" value="<?php if(empty($_SESSION['expand_adminconfig_main_image']) || $_SESSION['expand_adminconfig_main_image'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigMainImage"
<?php
        if(empty($_SESSION['expand_adminconfig_main_image']) || $_SESSION['expand_adminconfig_main_image'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td><table width="100%" style="border-left: 1px dotted black;">
<?php
        include('modules/settings/adminconfig/content/expand_admin_main/image/noimage_search.php');
        include('modules/settings/adminconfig/content/expand_admin_main/image/noimage_origin.php');
        include('modules/settings/adminconfig/content/expand_admin_main/image/favicon.php');        
?>
        </table></td>
    </tr>
    </table></td>
</tr>
