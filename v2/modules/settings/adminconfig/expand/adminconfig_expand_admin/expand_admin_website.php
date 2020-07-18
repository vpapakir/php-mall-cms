<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigAdminWebsite"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigAdminWebsite', 'img_adminconfig_admin_website', 'expand_adminconfig_admin_website', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigAdminWebsite', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_admin_website']) || $_SESSION['expand_adminconfig_admin_website'] == 'false')
                        {
?>
                            <span id="img_adminconfig_admin_website" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_admin_website" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.main_title_website', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_admin_website" style="display: none;" type="hidden" name="expand_adminconfig_admin_website" value="<?php if(empty($_SESSION['expand_adminconfig_admin_website']) || $_SESSION['expand_adminconfig_admin_website'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigAdminWebsite"
<?php
        if(empty($_SESSION['expand_adminconfig_admin_website']) || $_SESSION['expand_adminconfig_admin_website'] == 'false')
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
        //include('modules/settings/adminconfig/content/expand_admin_sa/site/kfolder.php');
        include('modules/settings/adminconfig/content/expand_admin_sa/site/headerurl.php');
        include('modules/settings/adminconfig/content/expand_admin_sa/site/sitename.php');        
?>
        </table></td>
    </tr>
    </table></td>
</tr>
