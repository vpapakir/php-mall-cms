<tr>
    <td>
    <table width="100%" class="block_main1">
        <tr>
            <td align="left">
                <span class="font_subtitle"><?php give_translation('cdreditor.main_subtitle_item'); ?></span>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <select name="cboSelectCDReditor" onchange="OnChange('bt_cboSelectCDReditor');"> 
                    <option value="new" 
                        <?php if(empty($_SESSION['cdreditor_cboSelectCDReditor']) || $_SESSION['cdreditor_cboSelectCDReditor'] == 'new'){ echo('selected="selected"'); }else{ echo(null); } ?>
                            ><?php give_translation('cdreditor.main_dd_new'); ?></option>
<?php
                for($i = 0, $count = count($cdreditor_arraycode); $i < $count; $i++)
                {
?>
                    <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('cdreditor.'.$cdreditor_arraycode[$i]); ?>">    
<?php                    
                    try
                    {
                        $prepared_query = 'SELECT * FROM cdreditor
                                           WHERE code_cdreditor = :code
                                           ORDER BY L'.$main_id_language.'S';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('code', $cdreditor_arraycode[$i]);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>" style="background-color: <?php if($data['statusobject_cdreditor'] == 1){ echo('white'); }else{ echo('red'); } ?>;"
                                 <?php if(!empty($_SESSION['cdreditor_cboSelectCDReditor']) && $_SESSION['cdreditor_cboSelectCDReditor'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>   
                                    >
<?php 
                            if($data[0] == 93)
                            {
                                echo('Prio1 ');
                            }
                            
                            if($data[0] == 94)
                            {
                                echo('Prio2 ');
                            }
                            
                            if($data[0] == 95)
                            {
                                echo('Prio3 ');
                            }
                            
                            echo($data['L'.$main_id_language.'S']); 
?>
                            </option>
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
                    </optgroup>    
<?php                    
                }
?>
                </select>
                <input style="display: none;" hidden="hidden" id="bt_cboSelectCDReditor" type="submit" name="bt_cboSelectCDReditor"/>
            </td>
        </tr>
    </table>
    </td>
</tr>
