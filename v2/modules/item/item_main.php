<?php
nosubmit_form_historyback();
#select
include('modules/item/button/bt_cboAddItem.php');
include('modules/item/button/bt_cboSelectItem.php');
#button
include('modules/item/button/bt_save_add_item.php');
include('modules/item/button/bt_save_add_block.php');
include('modules/item/button/bt_save_edit_button.php');
include('modules/item/button/bt_save_edit_block.php');
?>

<form method="post"><table width="100%">
<?php
        if(!empty($_SESSION['msg_item_main_done']))
        {
?>
            <tr>
                <td align="left" colspan="2">
                    <table width="100%" class="block_msg1">
                        <tr>
                            <td align="center">
                                <span><?php echo($_SESSION['msg_item_main_done']); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php
        }

include('modules/item/item_select.php');   

if(!empty($_SESSION['item_main_edit_cboAddItem']) && $_SESSION['item_main_edit_cboAddItem'] != 'select')
{
?>
    <tr>
        <td colspan="2"><table width="100%" class="block_main1" border="0">        
<?php
            include('modules/item/item_operation.php'); 

            if(empty($_SESSION['item_main_edit_cboSelectItem']) || $_SESSION['item_main_edit_cboSelectItem'] == 'new')
            {          
                include('modules/item/item_add.php');
            }
            else
            {
                include('modules/item/item_edit.php');
            }
?>
        </table></td>
    </tr>
<?php
}
?>
    
</table></form>
