<tr>
    <td align="left"><table width="100%" style="margin-bottom: 4px;">
        <tr>
            <td><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>       
            <td align="center">
                <?php
                if(!empty($_SESSION['mailtext_cboTemplateMailtext']) && $_SESSION['mailtext_cboTemplateMailtext'] != 'new')
                {
?>
                    <input type="submit" name="bt_edit_mailtext" value="<?php give_translation('main.bt_edit', '', $config_showtranslationcode); ?>"/>
<?php
                }
                else
                {
?>
                    <input type="submit" name="bt_add_mailtext" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
<?php
                }
?>
            </td>
        </tr>
    </table></td>
</tr>
