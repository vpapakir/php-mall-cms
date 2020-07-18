<?php
#expand
include('modules/advertising/bt/advert_expand.php');
#select
include('modules/advertising/bt/bt_cboSelectAdvert.php');
#bt
include('modules/advertising/bt/bt_save_advert.php');
?>
<form action="" method="post" enctype="multipart/form-data"><table width="100%">
<?php
if(!empty($_SESSION['msg_advertedit_done']))
{
    $_SESSION['unset_afterrefresh_adveredit_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_advertedit_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_adveredit_done'] >= 2)
    {
        unset($_SESSION['msg_advertedit_done']);
        unset($_SESSION['unset_afterrefresh_adveredit_done']);
    }
}

    include('modules/advertising/select/advert_select.php');
    include('modules/advertising/language/advert_language.php');
?>
</table></form>
