<tr>
    <td align="left">
        <table class="block_main2" width="100%">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_reply', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left">                                               
                    <?php echo($data['reply_messages']); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2"><table width="100%">
                    <tr>        
                        <td align="center">
                            <input type="submit" name="bt_back_myaccountmsg" value="<?php give_translation('main.bt_backtolist', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table>
    </td>
</tr>