<td><table width="100%">
    
    <td width="40%"></td>
    <td width="60%">
        <select name="cboTemplate" onchange="OnChange('bt_cboTemplate');">
            <option value="select" 
                    <?php if(empty($_SESSION['structure_template_cboTemplate']) || $_SESSION['structure_template_cboTemplate'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                    ><?php give_translation('edit_structure.main_dd_choicetemplate', '', $config_showtranslationcode); ?></option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM structure_template';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
                    $name_template = $data['name_template'];
                    
?>
                    <option value="<?php echo($data[0]); ?>"
                            <?php if(!empty($_SESSION['structure_template_cboTemplate']) && $_SESSION['structure_template_cboTemplate'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                            ><?php echo($data['name_template']); ?></option>
<?php                    
                }
				//$_SESSION['current_template_name'] = $name_template;
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
        <input id="bt_cboTemplate" hidden="true" style="display: none;" type="submit" name="bt_cboTemplate" value="Choix Template"></input>
<?php
if(!empty($_SESSION['structure_template_cboTemplate']) && $_SESSION['structure_template_cboTemplate'] != 'select')
{
?>
        &nbsp;
        <select name="cboActionTemplate" onchange="OnChange('bt_cboActionTemplate');">
            <option value="select"><?php give_translation('edit_structure.cboActionTemplate_select', '', $config_showtranslationcode) ?></option>
            <option value="bt_use_template"><?php give_translation('edit_structure.cboActionTemplate_bt_use_template', '', $config_showtranslationcode) ?></option>
            <option value="bt_copy_template"><?php give_translation('edit_structure.cboActionTemplate_bt_copy_template', '', $config_showtranslationcode) ?></option>
            <option value="bt_delete_template"><?php give_translation('edit_structure.cboActionTemplate_bt_delete_template', '', $config_showtranslationcode) ?></option>       
        </select>
        <input id="bt_cboActionTemplate" style="display: none;" hidden="true" type="submit" name="bt_cboActionTemplate" value="Utiliser"></input>
<?php
}
?>        
    </td>
</table></td>

<tr></tr>
