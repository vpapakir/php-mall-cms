<?php
include('modules/custom/immo/modules/contact/prodemail/prodemail_getinfo.php');
#bt
include('modules/custom/immo/modules/contact/prodemail/bt/bt_refresh_captcha.php');
include('modules/custom/immo/modules/contact/prodemail/bt/bt_send_prodemail.php');
?>
<form method="post">
    <table width="100%">
<?php
if(!empty($_SESSION['msg_kform_prodemail_done']))
{
    $_SESSION['unset_afterrefresh_kform_prodemail']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_kform_prodemail_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_kform_prodemail'] >= 2)
    {
        unset($_SESSION['msg_kform_prodemail_done']);
        unset($_SESSION['unset_afterrefresh_kform_prodemail']);
    }
}
?>
<?php
    include('modules/custom/immo/modules/contact/prodemail/content/prodemail_preview.php');
    include('modules/custom/immo/modules/contact/prodemail/content/prodemail_email.php');
    include('modules/custom/immo/modules/contact/prodemail/content/prodemail_captcha.php');
?>
    </table>
</form>
