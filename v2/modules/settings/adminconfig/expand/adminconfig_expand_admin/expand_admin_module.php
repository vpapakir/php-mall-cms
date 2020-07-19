<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigAdminModule"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigAdminModule', 'img_adminconfig_admin_module', 'expand_adminconfig_admin_module', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigAdminModule', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_admin_module']) || $_SESSION['expand_adminconfig_admin_module'] == 'false')
                        {
?>
                            <span id="img_adminconfig_admin_module" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_admin_module" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.admin_title_module', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_admin_module" style="display: none;" type="hidden" name="expand_adminconfig_admin_module" value="<?php if(empty($_SESSION['expand_adminconfig_admin_module']) || $_SESSION['expand_adminconfig_admin_module'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigAdminModule"
<?php
        if(empty($_SESSION['expand_adminconfig_admin_module']) || $_SESSION['expand_adminconfig_admin_module'] == 'false')
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
            include('modules/settings/adminconfig/content/expand_admin_sa/module/modules.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
