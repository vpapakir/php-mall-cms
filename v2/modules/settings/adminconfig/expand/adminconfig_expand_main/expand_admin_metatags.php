<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigMainMetatags"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigMainMetatags', 'img_adminconfig_main_metatags', 'expand_adminconfig_main_metatags', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigMainMetatags', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_main_metatags']) || $_SESSION['expand_adminconfig_main_metatags'] == 'false')
                        {
?>
                            <span id="img_adminconfig_main_metatags" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_main_metatags" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.main_title_metatags', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_main_metatags" style="display: none;" type="hidden" name="expand_adminconfig_main_metatags" value="<?php if(empty($_SESSION['expand_adminconfig_main_metatags']) || $_SESSION['expand_adminconfig_main_metatags'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigMainMetatags"
<?php
        if(empty($_SESSION['expand_adminconfig_main_metatags']) || $_SESSION['expand_adminconfig_main_metatags'] == 'false')
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
        include('modules/settings/adminconfig/content/expand_admin_main/meta/author.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/replyto.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/creationdate.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/revisitafter.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/robots.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/category.php');
        include('modules/settings/adminconfig/content/expand_admin_main/meta/publisher.php');     
?>
        </table></td>
    </tr>
    </table></td>
</tr>
