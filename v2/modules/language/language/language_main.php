<?php
//if(empty($_SESSION['language_create_new']))
//{
//   nosubmit_form_historyback();
//}
#language select
include('modules/language/language/language_firstload.php');
include('modules/language/language/bt_language/bt_create_language.php');
include('modules/language/language/bt_language/bt_cboLanguage.php');
#language add
include('modules/language/language/bt_language/bt_save_create_language.php');
include('modules/language/language/bt_language/bt_cancel_create_language.php');
#language edit
include('modules/language/language/bt_language/bt_save_exist_language.php');
?>
<form action="" method="post" enctype="multipart/form-data"><table width="100%">
<?php  
if(!empty($_SESSION['msg_language_done']))
{
    $_SESSION['unset_afterrefresh_language_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_language_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_language_done'] >= 2)
    {
        unset($_SESSION['msg_language_done']);
        unset($_SESSION['unset_afterrefresh_language_done']);
    }
}
    include('modules/language/language/language_select.php');

    if(empty($_SESSION['language_create_new']))
    {
        include('modules/language/language/language_edit.php');
    }
    
    if(!empty($_SESSION['language_create_new']) && $_SESSION['language_create_new'] === true)
    {
        include('modules/language/language/language_add.php');
    }
?>            
</table></form>
