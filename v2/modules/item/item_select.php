<tr>
    <td colspan="2"><table width="100%" class="block_main1">
         <tr>
            <td class="font_subtitle">
                <?php give_translation('edit_item.subtitle_typeitem_item', '', $config_showtranslationcode); ?>
            </td>
            <td width="<?php echo($right_column_width); ?>">
                <select name="cboAddItem" onchange="OnChange('bt_cboAddItem');">
                    <option value="select" <?php if(empty($_SESSION['item_main_edit_cboAddItem']) || $_SESSION['item_main_edit_cboAddItem'] == 'select'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_item.main_dd_choice_item', '', $config_showtranslationcode); ?></option>
                    <option value="block" <?php if(!empty($_SESSION['item_main_edit_cboAddItem']) && $_SESSION['item_main_edit_cboAddItem'] == 'block'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_item.main_dd_block_item', '', $config_showtranslationcode); ?></option>
                    <option value="button" <?php if(!empty($_SESSION['item_main_edit_cboAddItem']) && $_SESSION['item_main_edit_cboAddItem'] == 'button'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_item.main_dd_button_item', '', $config_showtranslationcode); ?></option>
                </select> 
                <input id="bt_cboAddItem" style="display: none;" hidden="true" type="submit" name="bt_cboAddItem" value="Choix Item"></input>
            </td>
        </tr>   
    </table></td>
</tr>
