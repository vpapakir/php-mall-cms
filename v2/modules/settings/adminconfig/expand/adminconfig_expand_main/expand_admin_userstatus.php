<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigMainUserStatus"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigMainUserStatus', 'img_adminconfig_main_userstatus', 'expand_adminconfig_main_userstatus', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigMainUserStatus', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_main_userstatus']) || $_SESSION['expand_adminconfig_main_userstatus'] == 'false')
                        {
?>
                            <span id="img_adminconfig_main_userstatus" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_main_userstatus" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.main_title_userstatus', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_main_userstatus" style="display: none;" type="hidden" name="expand_adminconfig_main_userstatus" value="<?php if(empty($_SESSION['expand_adminconfig_main_userstatus']) || $_SESSION['expand_adminconfig_main_userstatus'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigMainUserStatus"
<?php
        if(empty($_SESSION['expand_adminconfig_main_userstatus']) || $_SESSION['expand_adminconfig_main_userstatus'] == 'false')
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
        include('modules/settings/adminconfig/content/expand_admin_main/userstatus/afk.php');
        include('modules/settings/adminconfig/content/expand_admin_main/userstatus/logout.php');
?>
        </table></td>
    </tr>
    </table></td>
</tr>
