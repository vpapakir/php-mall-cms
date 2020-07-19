<?php
include('modules/color/button/bt_save_color.php');
include('modules/color/button/bt_delete_color.php');
include('modules/color/button/bt_cboColor.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_color_done']))
{
    $_SESSION['unset_afterrefresh_color']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_color_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_color'] >= 2)
    {
        unset($_SESSION['msg_color_done']);
        unset($_SESSION['unset_afterrefresh_color']);
    }
}

    include('modules/color/color_select.php');
    include('modules/color/color_addedit.php');
?>
    
</table></form>


