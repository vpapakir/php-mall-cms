<?php
if(!empty($_SESSION['msg_useredit_done']))
{
    $_SESSION['unset_afterrefresh_useredit_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_useredit_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_useredit_done'] >= 2)
    {
        unset($_SESSION['msg_useredit_done']);
        unset($_SESSION['unset_afterrefresh_useredit_done']);
    }
}
include('modules/user/edit/modify/content/usermodify_select.php');
include('modules/user/edit/modify/content/usermodify_maininfo.php');
include('modules/user/edit/modify/content/usermodify_address.php');
include('modules/user/edit/modify/content/usermodify_phone.php');
include('modules/user/edit/modify/content/usermodify_connectioninfo.php');
include('modules/user/edit/modify/content/usermodify_admin.php');
?>