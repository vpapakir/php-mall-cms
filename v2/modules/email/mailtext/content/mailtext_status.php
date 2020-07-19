<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_status_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboStatusMailtext">
                        <option value="1"
                            <?php if(empty($_SESSION['mailtext_cboStatusMailtext']) || $_SESSION['mailtext_cboStatusMailtext'] == 1){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_enabled', '', $config_showtranslationcode) ?></option>
                        <option value="9"
                            <?php if(!empty($_SESSION['mailtext_cboStatusMailtext']) && $_SESSION['mailtext_cboStatusMailtext'] == 9){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_disabled', '', $config_showtranslationcode) ?></option>
                    </select>
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
                            <a href="#mailtext_popup_preview" style="text-decoration: none;" onclick="return hs.htmlExpand(this, { contentId: 'mailtext_popup_preview',
                                objectType: 'ajax', width: 550, height: 'auto', outlineType: 'rounded-white', align: 'center', wrapperClassName: 'draggable-header'} );">
                                <span class="link_input" style="padding: 4px;"/><?php give_translation('main.bt_preview', '', $config_showtranslationcode); ?></span>
                            </a>
                            <div class="highslide-html-content" id="mailtext_popup_preview">
                                <div class="highslide-body">
                                    <?php include('modules/email/mailtext/content/mailtext_popup_preview.php'); ?>
                                </div>
                                <div class="highslide-footer"><div>
                                    <span class="highslide-resize" title="<?php give_translation('main.legend_resize', $echo, $config_showtranslationcode); ?>"></span>
                                </div></div>
                            </div>
                        </td>
                    </tr> 
                </table></td>
            </tr>
    </table></td>
</tr>
