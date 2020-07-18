<?php
#getinfo
include('modules/form/contact/contact_getinfo.php');
#bt
include('modules/form/contact/bt/bt_refresh_captcha.php');
include('modules/form/contact/bt/bt_send_contactmain.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_form_contactmain_done']))
{
    $_SESSION['unset_afterrefresh_form_contactmain_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_form_contactmain_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_form_contactmain_done'] >= 2)
    {
        unset($_SESSION['msg_form_contactmain_done']);
        unset($_SESSION['unset_afterrefresh_form_contactmain_done']);
    }
}

    include('modules/form/contact/content/contact_userinfo.php');
    include('modules/form/contact/content/contact_captcha.php');
?>
</table></form>
