<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_family_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboFamilyMailtext">
                        <option value="select"
                            <?php if(empty($_SESSION['mailtext_cboFamilyMailtext']) || $_SESSION['mailtext_cboFamilyMailtext'] == 'new'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_select', '', $config_showtranslationcode) ?></option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT code_family
                                           FROM `email_family`
                                           WHERE status_family = 1';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>"
                            <?php if(!empty($_SESSION['mailtext_cboFamilyMailtext']) && $_SESSION['mailtext_cboFamilyMailtext'] == $data[0]){ echo('selected="selected"'); } ?>
                                ><?php give_translation('mail_edit.dd_family_'.$data[0], '', $config_showtranslationcode) ?></option>
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
                    if(!empty($_SESSION['msg_mailtext_cboFamilyMailtext']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_mailtext_cboFamilyMailtext']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_sendername_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left">
                    <input style="width: 99%;" type="text" name="txtSendernameMailtext" value="<?php if(empty($_SESSION['mailtext_txtSendernameMailtext'])){ echo($config_email_sendername); }else{ echo($_SESSION['mailtext_txtSendernameMailtext']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_mailtext_txtSendernameMailtext']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_mailtext_txtSendernameMailtext']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_senderemail_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left">
                    <input style="width: 99%;" type="text" name="txtSenderemailMailtext" value="<?php if(empty($_SESSION['mailtext_txtSenderemailMailtext'])){ echo($config_email_senderemail); }else{ echo($_SESSION['mailtext_txtSenderemailMailtext']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_mailtext_txtSenderemailMailtext']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_mailtext_txtSenderemailMailtext']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_bcc_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left">
                    <input style="width: 99%;" type="text" name="txtBccMailtext" value="<?php if(empty($_SESSION['mailtext_txtBccMailtext'])){ echo($config_email_bcc); }else{ echo($_SESSION['mailtext_txtBccMailtext']); } ?>"/>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_middle_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left">
                    <input style="width: 99%;" type="text" name="txtScriptpathMailtext" value="<?php if(!empty($_SESSION['mailtext_txtScriptpathMailtext'])){ echo($_SESSION['mailtext_txtScriptpathMailtext']); }  ?>"/>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_signature_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboSignatureMailtext">
                        <option value="select"
                            <?php if(empty($_SESSION['mailtext_cboSignatureMailtext']) || $_SESSION['mailtext_cboSignatureMailtext'] == 'select' || $_SESSION['mailtext_cboSignatureMailtext'] == 0){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_select', '', $config_showtranslationcode) ?></option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT id_signature, L'.$main_id_language.'T
                                           FROM `email_signature`
                                           ORDER BY L'.$main_id_language.'T';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>"
                                <?php if(!empty($_SESSION['mailtext_cboSignatureMailtext']) && $_SESSION['mailtext_cboSignatureMailtext'] == $data[0]){ echo('selected="selected"'); } ?>
                                    ><?php echo($data[1]); ?></option>
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
    </table></td>
</tr>
