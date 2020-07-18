<?php
#select
include('modules/email/signature/bt/bt_select_signature.php');
#expand
include('modules/email/signature/bt/keep_expandorcoll.php');
#add or edit
include('modules/email/signature/bt/bt_save_signature.php');
?>
<form method="post"><table width="100%">
<?php
    if(!empty($_SESSION['msg_signature_done']))
    {
?>
        <tr>
            <td align="left">
                <table width="100%" class="block_msg1">
                    <tr>
                        <td align="center">
                            <span><?php echo($_SESSION['msg_signature_done']); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }

    include('modules/email/signature/select/signature_select.php');
    include('modules/email/signature/content/signature_script.php');
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        include('modules/email/signature/content/signature_expand.php');
    }
?>
</table></form>
