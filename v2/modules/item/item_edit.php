<tr>
<td align="left" colspan="2"><table width="100%">
        
<?php
    if(!empty($_SESSION['item_main_edit_cboAddItem']) && $_SESSION['item_main_edit_cboAddItem'] == 'button')
    {
        include('modules/item/item_edit/button_getinfo.php');
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('edit_item.subtitle_name_item', '', $config_showtranslationcode); ?>
            </td>
            <td width="<?php echo($right_column_width); ?>">
                <input class="font_main" type="text" name="txtEditNameButton" value="<?php echo($name_button); ?>"></input>
            </td>
        </tr>
<?php
            include('modules/item/item_edit/normal.php');
            include('modules/item/item_edit/hover.php');
            include('modules/item/item_edit/active.php');
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                    <tr>
                        <td align="center">
                            <input type="submit" name="bt_save_edit_button" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    else
    {
        include('modules/item/item_edit/block_getinfo.php');
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('edit_item.subtitle_name_item', '', $config_showtranslationcode); ?>
            </td>
            <td width="<?php echo($right_column_width); ?>">
                <input class="font_main" type="text" name="txtEditNameBlock" value="<?php echo($name_block); ?>"></input>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
<?php
            include('modules/item/item_edit/block.php');
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
                            <input type="submit" name="bt_save_edit_block" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php        
    }
?>

</table></td>
</tr>
