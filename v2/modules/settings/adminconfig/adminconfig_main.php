<?php
#expand
include('modules/settings/adminconfig/button/bt_expand_adminconfig.php');
#bt
include('modules/settings/adminconfig/button/bt_cboSelectSiteAdminconfig.php');
include('modules/settings/adminconfig/button/bt_save_adminconfig.php');
include('modules/settings/adminconfig/button/bt_use_adminconfig.php');
#getinfo
include('modules/settings/adminconfig/adminconfig_getinfo.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_adminconfig_done']))
{
    $_SESSION['unset_afterrefresh_adminconfig_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_adminconfig_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_adminconfig_done'] >= 2)
    {
        unset($_SESSION['msg_adminconfig_done']);
        unset($_SESSION['unset_afterrefresh_adminconfig_done']);
    }
}

    if((checkrights($main_rights_log, '9', $redirection, $excludeSA)) === true)
    {
        include('modules/settings/adminconfig/select/adminconfig_select.php');
        if(!empty($_SESSION['adminconfig_cboSelectSiteAdminconfig_new']) && $_SESSION['adminconfig_cboSelectSiteAdminconfig_new'] === true)
        {
            include('modules/settings/adminconfig/content/adminconfig_addname.php');
        }
        include('modules/settings/adminconfig/expand/adminconfig_expand_admin.php');
    }
    include('modules/settings/adminconfig/expand/adminconfig_expand_main.php');
    include('modules/settings/adminconfig/expand/adminconfig_expand_structure.php');
    include('modules/settings/adminconfig/expand/adminconfig_expand_image.php');
?>
</table></form>
