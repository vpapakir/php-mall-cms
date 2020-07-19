<?php
#getinfo
include('modules/custom/immo/modules/contact/propose_property/propose_getinfo.php');
#bt
include('modules/custom/immo/modules/contact/propose_property/bt/bt_send_proposeproperty.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_form_proposep_done']))
{
    $_SESSION['unset_afterrefresh_form_proposep']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_form_proposep_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_form_proposep'] >= 2)
    {
        unset($_SESSION['msg_form_proposep_done']);
        unset($_SESSION['unset_afterrefresh_form_proposep']);
    }
}

    include('modules/custom/immo/modules/contact/propose_property/content/propose_info.php');
    include('modules/custom/immo/modules/contact/propose_property/content/propose_desc.php');
    include('modules/custom/immo/modules/contact/propose_property/content/propose_userinfo.php');
    include('modules/custom/immo/modules/contact/propose_property/content/propose_msg.php');
?>
</table></form>
