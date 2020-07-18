<?php
include('modules/user/box/login/bt_logme_loginbox.php');
?>

<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_done_forgottenpwd2'])) #when user forgot his pwd and changed it
{
    $_SESSION['unset_afterrefresh_forgottenpwd2']++;
?>
    <tr>
        <td align="left" colspan="2">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_done_forgottenpwd2']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_forgottenpwd2'] >= 2)
    {
        unset($_SESSION['msg_done_forgottenpwd2']);
        unset($_SESSION['unset_afterrefresh_forgottenpwd2']);
    }
}

if(!empty($config_module_immo) && $config_module_immo == 1)
{
    include('modules/user/login_subscribe/custom/immo/custom_immo.php');
} else {
    include('modules/user/login_subscribe/custom/multishop/custom_immo.php');
}
?>
<tr>
<?php
include('modules/user/login_subscribe/login/login_main.php');
include('modules/user/login_subscribe/subscribe/subscribe_main.php');
?> 
</tr>
</table></form>
