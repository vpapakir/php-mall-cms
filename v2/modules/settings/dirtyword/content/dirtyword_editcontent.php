<tr>
    <td align="left">
        <table class="block_main2" width="100%">
            
<?php
        for($i = 0, $count = count($dirtyword_source); $i < $count; $i++)
        {
            if($i == 0)
            {
?>
                <tr>
                    <td align="left"><table width="100%">
                        <tr>        
                            <td align="center">
                                <input type="submit" name="bt_save_dirtyword" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                            </td>
                        </tr> 
                    </table></td>
                </tr>
                <tr>
                    <td><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td align="left">
                        <table width="100%" cellpadding="0" cellspacing="1" border="0">
                            <tr>  
                                <td align="center" class="block_main2" style="width: 40%;">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_preview', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 20%;">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_source', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 20%;">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_replace', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 5%; cursor: help;" title="<?php give_translation('dirtyword_edit.title_column_status', $echo, $config_showtranslationcode); ?>">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_shortstatus', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 5%; cursor: help;" title="<?php give_translation('dirtyword_edit.title_column_comment', $echo, $config_showtranslationcode); ?>">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_shortcomment', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 5%; cursor: help;" title="<?php give_translation('dirtyword_edit.title_column_search', $echo, $config_showtranslationcode); ?>">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_shortsearch', $echo, $config_showtranslationcode); ?></div>
                                </td>
                                <td align="center" class="block_main2" style="width: 5%; cursor: help;" title="<?php give_translation('dirtyword_edit.title_column_keyword', $echo, $config_showtranslationcode); ?>">
                                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('dirtyword_edit.title_column_shortkeyword', $echo, $config_showtranslationcode); ?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
<?php
            }
?>
            <tr>
                <td align="left">
                    <table width="100%" cellpadding="0" cellspacing="1" border="0" onmouseover="this.style.backgroundColor= 'lightblue';" onmouseout="this.style.backgroundColor= 'white';">
                    <tr>
                        <td align="left" width="40%">
                            <span style="">
                                <?php if(!empty($dirtyword_source[$i])){ echo('"<span style="font-weight: bold;">'.$dirtyword_source[$i].'</span>" = '); }?> 
                                 
                                <span id="PreviewDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" style="background-color: yellow; font-weight: bold;"><?php if(!empty($dirtyword_replace[$i])) { echo($dirtyword_replace[$i]); }else{ echo('<span class="font_main" style="font-style: italic; background-color: white;">'); give_translation('dirtyword_edit.preview_value_none', '', $config_showtranslationcode); echo('</span>'); } ?></span> 
                                
                            </span>
                        </td>
                        <td align="center" width="20%">
                            <input type="text" style="width: 90px;" name="txtSourceDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="<?php echo($dirtyword_source[$i]); ?>"/>
<?php
                            if(!empty($_SESSION['msg_dirtyword_txtSourceDirtyword'.$dirtyword_idreplace[$i]]))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1"><?php echo($_SESSION['msg_dirtyword_txtSourceDirtyword'.$dirtyword_idreplace[$i]]); ?></div>
<?php
                            }
?>
                        </td>
                        <td align="center" width="20%">
                            <input id="txtReplaceDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" style="width: 90px;" type="text" name="txtReplaceDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="<?php echo($dirtyword_replace[$i]); ?>" onkeyup="copyandpaste('txtReplaceDirtyword<?php echo($dirtyword_idreplace[$i]); ?>', 'PreviewDirtyword<?php echo($dirtyword_idreplace[$i]); ?>', null, null, null, 'true');"/>
                        </td>
                        <td align="center" width="5%" title="<?php give_translation('dirtyword_edit.title_column_status', $echo, $config_showtranslationcode); ?>">
                            <input type="checkbox" name="chkStatusDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="1" <?php if($dirtyword_status[$i] == 1){ echo('checked="checked"'); } ?>/>
                        </td>
                        <td align="center" width="5%" title="<?php give_translation('dirtyword_edit.title_column_comment', $echo, $config_showtranslationcode); ?>">
                            <input type="checkbox" name="chkCommentDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="1" <?php if($dirtyword_comment[$i] == 1){ echo('checked="checked"'); } ?>/>
                        </td>
                        <td align="center" width="5%" title="<?php give_translation('dirtyword_edit.title_column_search', $echo, $config_showtranslationcode); ?>">
                            <input type="checkbox" name="chkSearchDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="1" <?php if($dirtyword_search[$i] == 1){ echo('checked="checked"'); } ?>/>
                        </td>
                        <td align="center" width="5%" title="<?php give_translation('dirtyword_edit.title_column_keyword', $echo, $config_showtranslationcode); ?>">
                            <input type="checkbox" name="chkKeywordDirtyword<?php echo($dirtyword_idreplace[$i]); ?>" value="1" <?php if($dirtyword_keyword[$i] == 1){ echo('checked="checked"'); } ?>/>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            
<?php
        }
?>
            <tr>
                <td><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td><table width="100%">
                    <tr>        
                        <td align="center">
                            <input type="submit" name="bt_save_dirtyword" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table>
    </td>
</tr>
