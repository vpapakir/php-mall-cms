<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="center" width="<?php echo($right_column_width); ?>">
                    <select name="cboSelectuserMsgEdit" onchange="OnChange('bt_cboSelectuserMsgEdit');">
                        <option value="all"
                            <?php if(empty($_SESSION['msgedit_cboSelectuserMsgEdit']) || $_SESSION['msgedit_cboSelectuserMsgEdit'] == 'all'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('message_edit.dd_all', '', $config_showtranslationcode); ?></option>
                        <option value="---" disabled="disabled">---</option>
<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM user
                                               ORDER BY COALESCE(namecompany_user, "z") ASC, COALESCE(name_user, "z") ASC';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            while($data = $query->fetch())
                            {   
                                if(!empty($data['namecompany_user']))
                                {
                                    $msgedit_select_sender = $data['namecompany_user'].' ('.$data['email_user'].')';
                                    $msgedit_select_sender_title = $data['namecompany_user']."\r\n".$data['firstname_user'].' '.$data['name_user']."\r\n".$data['email_user'];
                                }
                                else
                                {
                                    $msgedit_select_sender = $data['name_user'].' '.substr($data['firstname_user'], 0, 1).'. ('.$data['email_user'].')';
                                    $msgedit_select_sender_title = $data['firstname_user'].' '.$data['name_user']."\r\n".$data['email_user'];   
                                }
?>
                                <option value="<?php echo($data[0]); ?>" title="<?php echo($msgedit_select_sender_title); ?>"
                                    <?php if(!empty($_SESSION['msgedit_cboSelectuserMsgEdit']) && $_SESSION['msgedit_cboSelectuserMsgEdit'] == $data[0]){ echo('selected="selected"'); } ?>
                                        ><?php echo($msgedit_select_sender); ?></option>
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
                    <input id="bt_cboSelectuserMsgEdit" style="display: none;" hidden="hidden" type="submit" name="bt_cboSelectuserMsgEdit" value="select"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
