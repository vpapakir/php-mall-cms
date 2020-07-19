<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('edit_memo.subtitle_choice_memo', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="right" width="75%">
                    <select name="cboMemo" onchange="OnChange('bt_select_memo');">
                        <option value="new" <?php if(empty($_SESSION['memo_cboMemo']) || $_SESSION['memo_cboMemo'] == 'new'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_new', $echo, $config_showtranslationcode); ?></option>
                        <option value="---" disabled="disabled">---</option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT * FROM memo
                                           WHERE status_memo = 1
                                           ORDER BY dateupdate_memo DESC, title_memo';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();

                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>" title="<?php echo($data['title_memo']); ?>"
                                <?php if(!empty($_SESSION['memo_cboMemo']) && $_SESSION['memo_cboMemo'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                                    ><?php echo(cut_string($data['title_memo'], 0, 20, '...')); ?></option>
<?php            
                        }
                        $query->closeCursor();

                        $prepared_query = 'SELECT * FROM memo
                                           WHERE status_memo = 9
                                           ORDER BY dateupdate_memo DESC, title_memo';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();

                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>" style="background-color: lightgrey;" title="<?php echo($data['title_memo']); ?>"
                                <?php if(!empty($_SESSION['memo_cboMemo']) && $_SESSION['memo_cboMemo'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                                    ><?php echo(cut_string($data['title_memo'], 0, 20, '...')); ?></option>
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
                    <input id="bt_select_memo" style="display: none;" hidden="true" type="submit" name="bt_select_memo" value="select"/>
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
<?php
                    }
?>
                </td>
            </tr>
        </table>
    </td>
</tr>
