<tr>
<td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <span class="font_subtitle">
                <?php give_translation('edit_color.subtitle_choice_color', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <select name="cboColor" onchange="OnChange('bt_cboColor');" style="font-family: monospace;">
                <option value="new" 
                        <?php if(empty($_SESSION['color_cboColor']) || $_SESSION['color_cboColor'] == 'new'){ echo('selected="selected"'); } ?>
                        ><?php give_translation('edit_color.dd_newcolor', $echo, $config_showtranslationcode); ?></option>
                <option value="---" disabled="disabled">---</option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM style_color
                                   ORDER BY name_color';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data[0]); ?>"
                        <?php if(!empty($_SESSION['color_cboColor']) && $_SESSION['color_cboColor'] == $data[0]){ echo('selected="selected"'); } ?>
                            ><?php echo(str_replace('#', '', $data['code_color']).' - '.$data['L'.$main_id_language]); ?></option>
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
                    die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                }
            }
?>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboColor" type="submit" name="bt_cboColor" value="Choix couleur"></input>
        </td>
    </tr>
    </table></td>
</tr>
