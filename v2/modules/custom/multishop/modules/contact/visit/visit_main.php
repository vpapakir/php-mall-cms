<?php
#getinfo
include('modules/custom/immo/modules/contact/visit/visit_getinfo.php');
#bt
include('modules/custom/immo/modules/contact/visit/bt/bt_send_visit.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_form_visit_done']))
{
    $_SESSION['unset_afterrefresh_form_visit']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_form_visit_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_form_visit'] >= 2)
    {
        unset($_SESSION['msg_form_visit_done']);
        unset($_SESSION['unset_afterrefresh_form_visit']);
    }
}

    include('modules/custom/immo/modules/contact/visit/content/visit_info.php');
    include('modules/custom/immo/modules/contact/visit/content/visit_userinfo.php');
    include('modules/custom/immo/modules/contact/visit/content/visit_msg.php');
?>
</table></form>
