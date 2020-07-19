<?php
#getinfo
include('modules/user/mailing/mailing_getinfo.php');
#bt
include('modules/user/mailing/button/bt_select_typemsg.php');
include('modules/user/mailing/button/bt_backto_useredit.php');
include('modules/user/mailing/button/bt_send_mailing.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_usermailing_done']))
{
    $_SESSION['unset_afterrefresh_usermailing_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_usermailing_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_usermailing_done'] >= 2)
    {
        unset($_SESSION['msg_usermailing_done']);
        unset($_SESSION['unset_afterrefresh_usermailing_done']);
    }
}
    include('modules/user/mailing/listing/mailing_listing.php');
    include('modules/user/mailing/content/mailing_testmail.php');
    include('modules/user/mailing/content/mailing_info.php');
    include('modules/user/mailing/content/mailing_msg.php');
?>
</table></form>
