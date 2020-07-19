<tr>
    <td>
        <table class="block_main2" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td><table width="100%" style="margin-bottom: 10px;">
                    <td>
                        <span class="font_subtitle" style="margin-right: 10px;"><?php give_translation('edit_memo.subtitle_title', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td width="100%">
                        <input class="font_main" style="width: 100%;" type="text" name="txtTitleMemo" value="<?php if(!empty($_SESSION['memo_txtTitleMemo'])){ echo($_SESSION['memo_txtTitleMemo']); }; ?>"></input>
                    </td>
                    <td align="right">
                        <select style="margin-left: 10px;" name="cboStatusMemo">
                            <option value="1" <?php if(empty($_SESSION['memo_cboStatusMemo']) || $_SESSION['memo_cboStatusMemo'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_enabled', $echo, $config_showtranslationcode); ?></option>
                            <option value="9" <?php if(!empty($_SESSION['memo_cboStatusMemo']) && $_SESSION['memo_cboStatusMemo'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_closed', $echo, $config_showtranslationcode); ?></option>
                        </select>
                    </td>
                </table></td>
            </tr>
            <tr>
                <td colspan="3">
                    <textarea class="font_main" style="width: 99%; font-size: 12px; font-family: monospace, 'Courrier', 'Courrier New', 'American Typewriter', 'Fixedsys';" name="areaMemo" rows="30"><?php if(!empty($_SESSION['memo_areaMemo'])){ echo($_SESSION['memo_areaMemo']); }; ?></textarea>
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
                            <?php
                                        if(!empty($_SESSION['memo_view']) && $_SESSION['memo_view'] == true)
                                        {    
                            ?>
                                            <input type="submit" name="bt_edit_memo" value="<?php give_translation('main.bt_edit', $echo, $config_showtranslationcode); ?>"/>
                                            <input type="submit" name="bt_delete_memo" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"/>
                            <?php
                                        }
                                        else
                                        {
                            ?>
                                            <input type="submit" name="bt_save_memo" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>
                                            <input type="submit" name="bt_savenquit_memo" value="<?php give_translation('main.bt_savenquit', $echo, $config_showtranslationcode); ?>"/>   
                            <?php
                                        }
                            ?>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table>
    </td>
</tr>

