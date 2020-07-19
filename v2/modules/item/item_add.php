<?php
if($_SESSION['item_main_edit_cboAddItem'] == 'button')
{
?>
    <tr>
    <td class="font_subtitle">
        <?php give_translation('edit_item.subtitle_name_item', '', $config_showtranslationcode); ?>
    </td>
    <td>
        <input class="font_main" type="text" name="txtAddNameButton"></input>
    </td>
    </tr>
<?php
        include('modules/item/item_add/normal.php');
        include('modules/item/item_add/hover.php');
        include('modules/item/item_add/active.php');
?>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
            <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                <tr>
                    <td align="center">
                        <input type="submit" name="bt_save_add_item" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
else
{
?>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_item.subtitle_name_item', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input class="font_main" type="text" name="txtAddNameBlock"></input>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
    </tr>
    
    <tr>
<?php
        include('modules/item/item_add/block.php');
?>       
    </tr>
    
    
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
            <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                <tr>
                    <td align="center">
                        <input type="submit" name="bt_save_add_block" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php        
}
?>
