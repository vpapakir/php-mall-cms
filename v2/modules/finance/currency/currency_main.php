<?php
#select
include('modules/finance/currency/bt/bt_cboSelectCurrency.php');
#add
include('modules/finance/currency/bt/bt_add_currency.php');
#edit
include('modules/finance/currency/bt/bt_edit_currency.php');
?>

<form method="post" enctype="multipart/form-data"><table width="100%">
<?php
if(!empty($_SESSION['msg_currency_done']))
{
    $_SESSION['unset_afterrefresh_currency_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_currency_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_currency_done'] >= 2)
    {
        unset($_SESSION['msg_currency_done']);
        unset($_SESSION['unset_afterrefresh_currency_done']);
    }
}   
    include('modules/finance/currency/select/currency_select.php');
    include('modules/finance/currency/content/currency_content.php');
    include('modules/finance/currency/content/currency_image.php');
    include('modules/finance/currency/content/currency_status.php');
?>
            
</table></form>
