<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_choicetypemsg', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input id="radTypeMsgUserMailing_new" type="radio" name="radTypeMsgUserMailing" value="new" <?php if(empty($_SESSION['usermailing_radTypeMsgUserMailing']) || $_SESSION['usermailing_radTypeMsgUserMailing'] == 'new'){ echo('checked="checked"'); } ?> onclick="OnChange('bt_select_typemsg');"/>
                    <label class="font_main" for="radTypeMsgUserMailing_new" style="cursor: pointer;"><?php give_translation('user_mailing.choicetypemsg_new', '', $config_showtranslationcode); ?></label>
                    <input id="radTypeMsgUserMailing_existing" type="radio" name="radTypeMsgUserMailing" value="existing" <?php if(!empty($_SESSION['usermailing_radTypeMsgUserMailing']) && $_SESSION['usermailing_radTypeMsgUserMailing'] == 'existing'){ echo('checked="checked"'); } ?> onclick="OnChange('bt_select_typemsg');"/>
                    <label class="font_main" for="radTypeMsgUserMailing_existing" style="cursor: pointer;"><?php give_translation('user_mailing.choicetypemsg_existing', '', $config_showtranslationcode); ?></label> 
                    <input id="bt_select_typemsg" style="display: none;" hidden="hidden" type="submit" name="bt_select_typemsg" value="select"/>
                </td>
            </tr>
<?php
            if(empty($_SESSION['usermailing_radTypeMsgUserMailing']))
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">
                            <?php give_translation('user_mailing.subtitle_choicesignature', '', $config_showtranslationcode); ?>
                        </span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <select name="cboSignatureUserMailing">
                            <option value="select"
                                <?php if(empty($_SESSION['usermailing_cboSignatureUserMailing']) || $_SESSION['usermailing_cboSignatureUserMailing'] == 'new'){ echo('selected="selected"'); } ?>
                                    ><?php give_translation('main.dd_select', '', $config_showtranslationcode); ?></option>
<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM email_signature
                                               ORDER BY L'.$main_id_language.'T';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data[0]); ?>"
                                    <?php if(!empty($_SESSION['usermailing_cboSignatureUserMailing']) && $_SESSION['usermailing_cboSignatureUserMailing'] == $data[0]){ echo('selected="selected"'); } ?>
                                        ><?php echo($data['L'.$main_id_language.'T']); ?></option>
<?php
                            }
                            $query->closeCursor();
                        }
                        catch(Exception $e)
                        {
                            $_SESSION['error400_message'] = $e->getMessage();
                            if($_SESSION['index'] == 'index.php')
                            {
                                die(header('Location: '.$config_customheader.'Error/400'));
                            }
                            else
                            {
                                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
                            }
                        }
?>                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2">
                        <textarea class="tinyMCE_editor" style="width: 99%;" name="areaMsgUserMailing"><?php if(!empty($_SESSION['usermailing_areaMsgUserMailing'])){ echo($_SESSION['usermailing_areaMsgUserMailing']); } ?></textarea>
<?php
                        if(!empty($_SESSION['msg_usermailing_areaMsgUserMailing']))
                        {
?>
                            <br clear="left"/>
                            <div class="font_error1"><?php echo($_SESSION['msg_usermailing_areaMsgUserMailing']); ?></div>
<?php
                        }
?>
                    </td>
                </tr>   
<?php
            }
            else
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">
                            <?php give_translation('user_mailing.subtitle_choicetemplate_email', '', $config_showtranslationcode); ?>
                        </span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <select name="cboTemplateUserMailing">
                            <option value="select"
                                <?php if(empty($_SESSION['usermailing_cboTemplateUserMailing']) || $_SESSION['usermailing_cboTemplateUserMailing'] == 'new'){ echo('selected="selected"'); } ?>
                                    ><?php give_translation('main.dd_select', '', $config_showtranslationcode); ?></option>
<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM email_mailtext
                                               WHERE family_mailtext = "mailing"
                                               ORDER BY L'.$main_id_language.'T';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data[0]); ?>"
                                    <?php if(!empty($_SESSION['usermailing_cboTemplateUserMailing']) && $_SESSION['usermailing_cboTemplateUserMailing'] == $data[0]){ echo('selected="selected"'); } ?>
                                        ><?php echo($data['L'.$main_id_language.'T']); ?></option>
<?php
                            }
                            $query->closeCursor();
                        }
                        catch(Exception $e)
                        {
                            $_SESSION['error400_message'] = $e->getMessage();
                            if($_SESSION['index'] == 'index.php')
                            {
                                die(header('Location: '.$config_customheader.'Error/400'));
                            }
                            else
                            {
                                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
                            }
                        }
?>                            
                        </select>
<?php
                        if(!empty($_SESSION['msg_usermailing_cboTemplateUserMailing']))
                        {
?>
                            <br clear="left"/>
                            <div class="font_error1"><?php echo($_SESSION['msg_usermailing_cboTemplateUserMailing']); ?></div>
<?php
                        }
?>
                    </td>
                </tr>
<?php
            }                
?>
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
                            <input type="submit" name="bt_send_testmail" value="<?php give_translation('main.bt_send_testmail', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_send_mailing" value="<?php give_translation('main.bt_send', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_backto_useredit" value="<?php give_translation('main.bt_back', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
    </table></td>
</tr>
