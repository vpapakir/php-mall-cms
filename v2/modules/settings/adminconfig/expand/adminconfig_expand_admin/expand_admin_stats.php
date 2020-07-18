<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigAdminStats"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigAdminStats', 'img_adminconfig_admin_stats', 'expand_adminconfig_admin_stats', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigAdminStats', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_admin_stats']) || $_SESSION['expand_adminconfig_admin_stats'] == 'false')
                        {
?>
                            <span id="img_adminconfig_admin_stats" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_admin_stats" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.admin_title_stats', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_admin_stats" style="display: none;" type="hidden" name="expand_adminconfig_admin_stats" value="<?php if(empty($_SESSION['expand_adminconfig_admin_stats']) || $_SESSION['expand_adminconfig_admin_stats'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigAdminStats"
<?php
        if(empty($_SESSION['expand_adminconfig_admin_stats']) || $_SESSION['expand_adminconfig_admin_stats'] == 'false')
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
            include('modules/settings/adminconfig/content/expand_admin_sa/stats/pagecount.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
