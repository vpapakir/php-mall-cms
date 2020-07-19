<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
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
            <tr>
                <td align="left">
                    <table width="100%" cellpadding="0" cellspacing="1" border="0">
                    <tr>
                        <td align="left" width="40%" style="vertical-align: top;">
                            <span style="">
                                <?php echo('[...] '); ?> 
                                <span id="PreviewDirtyword" style="background-color: yellow; font-weight: bold;"></span> 
                                <?php echo(' [...]'); ?> 
                            </span>
                        </td>
                        <td align="center" width="20%" style="vertical-align: top;">
                            <input type="text" style="width: 90px;" name="txtSourceDirtyword"/>
<?php
                            if(!empty($_SESSION['msg_dirtyword_txtSourceDirtyword']))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1"><?php echo($_SESSION['msg_dirtyword_txtSourceDirtyword']); ?></div>
<?php
                            }
?>
                        </td>
                        <td align="center" width="20%" style="vertical-align: top;">
                            <input id="txtReplaceDirtyword" style="width: 90px;" type="text" name="txtReplaceDirtyword" onkeyup="copyandpaste('txtReplaceDirtyword', 'PreviewDirtyword', null, null, null, 'true');"/>
                        </td>
                        <td align="center" width="5%" style="vertical-align: top;">
                            <input type="checkbox" name="chkStatusDirtyword" value="1" checked="checked"/>
                        </td>
                        <td align="center" width="5%" style="vertical-align: top;">
                            <input type="checkbox" name="chkCommentDirtyword" value="1"/>
                        </td>
                        <td align="center" width="5%" style="vertical-align: top;">
                            <input type="checkbox" name="chkSearchDirtyword" value="1" checked="checked"/>
                        </td>
                        <td align="center" width="5%" style="vertical-align: top;">
                            <input type="checkbox" name="chkKeywordDirtyword" value="1" checked="checked"/>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
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
                            <input type="submit" name="bt_add_dirtyword" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table>
    </td>
</tr>
