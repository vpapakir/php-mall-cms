<tr>
    <td align="left"><table class="block_main2" width="100%">
        <tr>
            <td align="left">
                <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_selectadvert', $echo, $config_showtranslationcode); ?></span>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <select name="cboSelectAdvert" onchange="OnChange('bt_cboSelectAdvert');">
                    <option value="new"
                        <?php if(empty($_SESSION['advertedit_cboSelectAdvert']) || $_SESSION['advertedit_cboSelectAdvert'] == 'new'){ echo('selected="selected"'); } ?>
                            ><?php give_translation('main.dd_new_advert', $echo, $config_showtranslationcode); ?></option>
                    <option value="---" disabled="disabled"><?php echo('------'); ?></option>
<?php
                try
                {
                    $prepared_query = 'SELECT id_advertising, name_advertising_L'.$main_id_language.', status_advertising_L'.$main_id_language.' 
                                       FROM advertising
                                       ORDER BY name_advertising_L'.$main_id_language.', status_advertising_L'.$main_id_language;
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();

                    while($data = $query->fetch())
                    {
?>
                        <option value="<?php echo($data[0]); ?>" title="<?php echo($data['name_advertising_L'.$main_id_language]); ?>"
                            <?php if(!empty($_SESSION['advertedit_cboSelectAdvert']) && $_SESSION['advertedit_cboSelectAdvert'] == $data[0]){ echo('selected="selected"'); } ?>
                                ><?php echo($data['name_advertising_L'.$main_id_language]); ?></option>
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
                <input style="display: none;" hidden="hidden" type="submit" id="bt_cboSelectAdvert" name="bt_cboSelectAdvert" value="Choice Advert"/>
            </td>
        </tr>
    </table></td>
</tr>
