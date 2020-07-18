<tr>
<td align="left"><table width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseAdminconfigMainEmail"
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseAdminconfigMainEmail', 'img_adminconfig_main_email', 'expand_adminconfig_main_email', null, null, '[+]', '[-]', 'Afficher', 'Cacher', '','', 'collapseAdminconfigMainEmail', 'MainAdminconfigAdminStats');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_adminconfig_main_email']) || $_SESSION['expand_adminconfig_main_email'] == 'false')
                        {
?>
                            <span id="img_adminconfig_main_email" style="font-family: monospace;">[+]</span>
<?php                        
                        }
                        else
                        {
?>
                            <span id="img_adminconfig_main_email" style="font-family: monospace;">[-]</span>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span class="link_subtitle" style="margin-left: 10px; font-size: 14px;">
                        <?php give_translation('adminconfig_edit.main_title_email', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_adminconfig_main_email" style="display: none;" type="hidden" name="expand_adminconfig_main_email" value="<?php if(empty($_SESSION['expand_adminconfig_main_email']) || $_SESSION['expand_adminconfig_main_email'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseAdminconfigMainEmail"
<?php
        if(empty($_SESSION['expand_adminconfig_main_email']) || $_SESSION['expand_adminconfig_main_email'] == 'false')
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
        include('modules/settings/adminconfig/content/expand_admin_main/email/sendername.php');
        include('modules/settings/adminconfig/content/expand_admin_main/email/senderemail.php');
        if((checkrights($main_rights_log, '9', $redirection, $excludeSA)) === true)
        {
            include('modules/settings/adminconfig/content/expand_admin_main/email/bcc.php');
        }
?>
        </table></td>
    </tr>
    </table></td>
</tr>
