<?php
#getinfo
include('modules/user/myaccount/edition/edit_userdata/edit_maininfo_getinfo.php');
#bt
include('modules/user/myaccount/edition/bt/bt_backto_myaccount.php');
include('modules/user/myaccount/edition/edit_userdata/bt/bt_save_newaddress.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_myaccount_useredition_done']))
{
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_myaccount_useredition_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}

include('modules/user/myaccount/edition/edit_userdata/edit_maininfo.php');
?> 
</table></form>
