<?php
#select
include('modules/email/mailtext/bt/bt_select_mailtext.php');
#expand
include('modules/email/mailtext/bt/keep_expandorcoll.php');
#add or edit
include('modules/email/mailtext/bt/bt_save_mailtext.php');
?>
<form method="post"><table width="100%">
<?php
    if(!empty($_SESSION['msg_mailtext_done']))
    {
?>
        <tr>
            <td align="left">
                <table width="100%" class="block_msg1">
                    <tr>
                        <td align="center">
                            <span><?php echo($_SESSION['msg_mailtext_done']); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    
    include('modules/email/mailtext/select/mailtext_select.php');
    include('modules/email/mailtext/content/mailtext_header.php');
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        include('modules/email/mailtext/content/mailtext_expand.php');
    }
    include('modules/email/mailtext/content/mailtext_status.php');
?>
</table></form>
