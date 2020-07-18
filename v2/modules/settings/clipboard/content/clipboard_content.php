<tr>
    <td align="left">
        <textarea style="width: 100%;" rows="30" name="areaClipboard"><?php echo($clipboard_content); ?></textarea>
    </td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
</tr>
<tr>
    <td colspan="2"><table width="100%" style="">
        <tr>        
            <td align="center">
                <input type="submit" name="bt_save_clipboard" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                <input type="submit" name="bt_truncate_clipboard" value="<?php give_translation('main.bt_truncate', '', $config_showtranslationcode); ?>"/>
            </td>
        </tr> 
    </table></td>
</tr>
