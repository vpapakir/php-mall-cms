<tr>
    <td></td>
    <td width="<?php echo($right_column_width); ?>">
        <select name="cboSelectItem" onchange="OnChange('bt_cboSelectItem');">
            <option value="new" <?php if(empty($_SESSION['item_main_edit_cboSelectItem']) || $_SESSION['item_main_edit_cboSelectItem'] == 'new'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_item.main_dd_newitem', '', $config_showtranslationcode); ?></option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM style_'.$_SESSION['item_main_edit_cboAddItem'].'
                                   ORDER BY name_'.$_SESSION['item_main_edit_cboAddItem'];
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data[0]); ?>"
                        <?php if(!empty($_SESSION['item_main_edit_cboSelectItem']) && $_SESSION['item_main_edit_cboSelectItem'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>
                            ><?php echo($data['name_'.$_SESSION['item_main_edit_cboAddItem']]); ?></option>
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
        <input id="bt_cboSelectItem" style="display: none;" hidden="true" type="submit" name="bt_cboSelectItem" value="Choix Item"></input>
    </td>
</tr>
