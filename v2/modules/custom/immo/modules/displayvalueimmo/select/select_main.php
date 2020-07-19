<?php
if(!empty($_SESSION['msg_displayvalue_done']))
{
?>
    <tr>
        <td>
            <table width="100%" class="block_main2" style="border: 1px solid red;">
                <tr>
                    <td align="center">
                        <span class="font_info1"><?php echo($_SESSION['msg_displayvalue_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>
<tr>
    <td>
    <table width="100%" class="block_main2">
        <tr>
            <td align="left">
                <span class="font_subtitle">Template</span>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <select name="cboTemplateDisplayValue" onchange="OnChange('bt_cboTemplateDisplayValue');"> 
                    <option value="select" 
                        <?php if(empty($_SESSION['displayvalue_cboTemplateDisplayValue']) || $_SESSION['displayvalue_cboTemplateDisplayValue'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                            >---</option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT * FROM script_template
                                           WHERE status_script_template = 1';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data['name_script_template']); ?>"
                                 <?php if(!empty($_SESSION['displayvalue_cboTemplateDisplayValue']) && $_SESSION['displayvalue_cboTemplateDisplayValue'] == $data['name_script_template']){ echo('selected="selected"'); }else{ echo(null); } ?>   
                                    ><?php give_translation($data['transcode_script_template']); ?></option>
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
                <input style="display: none;" hidden="hidden" id="bt_cboTemplateDisplayValue" type="submit" name="bt_cboTemplateDisplayValue"/>
            </td>
        </tr>
    </table>
    </td>
</tr>
