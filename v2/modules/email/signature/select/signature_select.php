<tr>
    <td align="left"><table class="block_main2" width="100%">
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('signature_edit.subtitle_choicetemplate_signature', '', $config_showtranslationcode) ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboTemplateSignature" onchange="OnChange('bt_select_signature');">
                        <option value="new"
                            <?php if(empty($_SESSION['signature_cboTemplateSignature']) || $_SESSION['signature_cboTemplateSignature'] == 'new'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('signature_edit.main_dd_newtemplate_signature', '', $config_showtranslationcode) ?></option>
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
                                <?php if(!empty($_SESSION['signature_cboTemplateSignature']) && $_SESSION['signature_cboTemplateSignature'] == $data[0]){ echo('selected="selected"'); } ?>
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
                    <input type="submit" id="bt_select_signature" style="display: none;" hidden="hidden" name="bt_select_signature" value="Choice Signature"/>
                </td>
            </tr>         
    </table></td>
</tr>
