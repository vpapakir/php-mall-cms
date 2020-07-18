<?php

#bt
include('modules/settings/dirtyword/button/bt_cboSelectLangDirtyword.php');
include('modules/settings/dirtyword/button/bt_add_dirtyword.php');
include('modules/settings/dirtyword/button/bt_save_dirtyword.php');
#getinfo
include('modules/settings/dirtyword/dirtyword_getinfo.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_dirtyword_done']))
{
    $_SESSION['unset_afterrefresh_dirtyword_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_dirtyword_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_dirtyword_done'] >= 2)
    {
        unset($_SESSION['msg_dirtyword_done']);
        unset($_SESSION['unset_afterrefresh_dirtyword_done']);
    }
}
    include('modules/settings/dirtyword/select/dirtyword_select_type.php');
    if(!empty($_SESSION['dirtyword_cboSelectTypeDirtyword']) && $_SESSION['dirtyword_cboSelectTypeDirtyword'] != 'select')
    {
        include('modules/settings/dirtyword/select/dirtyword_select_lang.php');
    
        if(!empty($_SESSION['dirtyword_cboSelectLangDirtyword']) && $_SESSION['dirtyword_cboSelectLangDirtyword'] != 'select')
        {
            include('modules/settings/dirtyword/content/dirtyword_addcontent.php');
            include('modules/settings/dirtyword/order/dirtyword_order.php');
            include('modules/settings/dirtyword/content/dirtyword_editcontent.php');
        }
    }
?>
</table></form>
