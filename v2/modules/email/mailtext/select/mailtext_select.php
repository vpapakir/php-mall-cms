<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('mail_edit.subtitle_choicetemplate_mailtext', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboTemplateMailtext" onchange="OnChange('bt_select_mailtext');">
                        <option value="new"
                            <?php if(empty($_SESSION['mailtext_cboTemplateMailtext']) || $_SESSION['mailtext_cboTemplateMailtext'] == 'new'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('mail_edit.main_dd_newtemplate_mailtext', '', $config_showtranslationcode) ?></option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT id_mailtext, L'.$main_id_language.'T
                                           FROM `email_mailtext`
                                           ORDER BY L'.$main_id_language.'T';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>"
                                <?php if(!empty($_SESSION['mailtext_cboTemplateMailtext']) && $_SESSION['mailtext_cboTemplateMailtext'] == $data[0]){ echo('selected="selected"'); } ?>
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
                    <input type="submit" id="bt_select_mailtext" style="display: none;" hidden="hidden" name="bt_select_mailtext" value="Choice Mailtext"/>
                </td>
            </tr>         
    </table></td>
</tr>
