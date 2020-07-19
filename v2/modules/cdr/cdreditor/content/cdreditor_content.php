<tr>
    <td>
    <table width="100%" class="block_main1">
<?php
        if(empty($_SESSION['cdreditor_cboSelectCDReditor']) || $_SESSION['cdreditor_cboSelectCDReditor'] == 'new')
        {
            $cdreditor_add_familydisabled = false;
        }
        else
        {
            $cdreditor_add_familydisabled = true;
        }
?>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('cdreditor.main_subtitle_family'); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select <?php if($cdreditor_add_familydisabled == true){ echo('disabled="disabled"'); } ?> name="cboFamilyCDReditor" onchange="OnChange('bt_cboFamilyCDReditor');">
                        <option value="select" 
                            <?php if(empty($_SESSION['cdreditor_add_cboFamilyCDReditor']) || $_SESSION['cdreditor_add_cboFamilyCDReditor'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                ><?php give_translation('cdreditor.main_dd_select'); ?></option>
<?php
                    for($i = 0, $count = count($cdreditor_arraycode); $i < $count; $i++)
                    {
?>
                        <option value="<?php echo($cdreditor_arraycode[$i]); ?>"
                               <?php if(!empty($_SESSION['cdreditor_add_cboFamilyCDReditor']) && $_SESSION['cdreditor_add_cboFamilyCDReditor'] == $cdreditor_arraycode[$i]){ echo('selected="selected"'); }else{ echo(null); } ?> 
                                ><?php echo($cdreditor_arraycode_translate[$i]); if(checkrights($main_rights_log, '9', $redirection) === true){ echo(' ('.$cdreditor_arraytype[$i].')'); } ?></option>
<?php
                    }
?>
                    </select>
                    <input id="bt_cboFamilyCDReditor" style="display: none;" hidden="hidden" type="submit" name="bt_cboFamilyCDReditor" value="Choice Family"/>
<?php 
                    if(!empty($_SESSION['msg_cdreditor_add_cboFamilyCDReditor']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_cdreditor_add_cboFamilyCDReditor']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
<?php
//        }

        if(!empty($_SESSION['cdreditor_add_displayFamilyOptions']))
        {
            $cdreditor_temp_familyoptions = $_SESSION['cdreditor_add_displayFamilyOptions'];
?>
            <tr>
                <td></td>
                <td align="left" class="font_main">
<?php
            for($i = 0, $count = count($cdreditor_temp_familyoptions); $i < $count; $i++)
            {
                unset($cdreditor_temp_familyoptions_display, $cdreditor_temp_familyoptions_displaycolor);
                $cdreditor_temp_familyoptions_display = split_string($cdreditor_temp_familyoptions[$i], '$');
                if($cdreditor_temp_familyoptions_display[2] == 9 || $cdreditor_temp_familyoptions_display[2] == 0)
                {
                    $cdreditor_temp_familyoptions_displaycolor = 'red';
                }
                else
                {
                    unset($cdreditor_temp_familyoptions_displaycolor);
                }
                
                $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                                   WHERE id_cdreditor = :id
                                   ORDER BY L'.$main_id_language.'S';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $cdreditor_temp_familyoptions_display[1]);
                $query->execute();
                if(($data = $query->fetch()) != false)
                {
                    $cdreditor_temp_familyoptions_display[0] = $data[0];
                }
                $query->closeCursor();
                
                if($i == ($count - 1))
                {
                    
                    echo('<a class="link_main" href="'.$config_customheader.'index.php?page='.$url_page.'&amp;cdr='.$cdreditor_temp_familyoptions_display[1].'" ');
                    if(!empty($cdreditor_temp_familyoptions_displaycolor))
                    {
                        echo('style="color: '.$cdreditor_temp_familyoptions_displaycolor.';"');
                    }
                    echo('>');
                    echo($cdreditor_temp_familyoptions_display[0]);    
                    echo('</a>');
                }
                else
                {
                    echo('<a class="link_main" href="'.$config_customheader.'index.php?page='.$url_page.'&amp;cdr='.$cdreditor_temp_familyoptions_display[1].'" ');
                    if(!empty($cdreditor_temp_familyoptions_displaycolor))
                    {
                        echo('style="color: '.$cdreditor_temp_familyoptions_displaycolor.';"');
                    }
                    echo('>');
                    echo($cdreditor_temp_familyoptions_display[0]);  
                    echo('</a><br clear="left"/>');
                } 
                unset($cdreditor_temp_familyoptions_display, $cdreditor_temp_familyoptions_displaycolor);
            }

            unset($cdreditor_temp_familyoptions);
?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
<?php
        }
        
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            if($i > 0)
            {
?>
                <tr>
                    <td colspan="2"><div style="height: 1px;"></div></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
                </tr>
                <tr>
                    <td colspan="2"><div style="height: 1px;"></div></td>
                </tr>            
<?php
            }
?>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation($main_activatedcodelang[$i]); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <table width="100%" cellpadding="0" cellspacing="1">
                        <tr>
                            <td align="left">
                                <span class="font_main"><?php give_translation('cdreditor.main_subtitle_singular'); ?></span>
                            </td>
                            <td align="left">
                                <input style="width: 99%;" type="text" name="txtNameL<?php echo($main_activatedidlang[$i]); ?>S" value="<?php if(!empty($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'])){ echo($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S']); } ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="font_main"><?php give_translation('cdreditor.main_subtitle_plural'); ?></span>
                            </td>
                            <td align="left">
                                <input style="width: 99%;" type="text" name="txtNameL<?php echo($main_activatedidlang[$i]); ?>P" value="<?php if(!empty($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P'])){ echo($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P']); } ?>"/>
                            </td>
                        </tr>
                    </table>                   
                </td>
            </tr>
<?php
        }
?>  
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 1px;"></div></td>
            </tr>
<?php
        if(checkrights($main_rights_log, '9', $redirection) === true)
        {
?>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('cdreditor.main_subtitle_mode'); ?></span>
                </td>
                <td align="left">
                    <select name="cboModeCDReditor">
                        <option value="select" 
                            <?php if(empty($_SESSION['cdreditor_add_cboModeCDReditor']) || $_SESSION['cdreditor_add_cboModeCDReditor'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                >--- Sélectionnez ---</option>
                        <option value="dropdown" 
                            <?php if(!empty($_SESSION['cdreditor_add_cboModeCDReditor']) && $_SESSION['cdreditor_add_cboModeCDReditor'] == 'dropdown'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                ><?php give_translation('cdreditor.main_dd_mode_dropdown'); ?></option>
                        <option value="checkbox"
                            <?php if(!empty($_SESSION['cdreditor_add_cboModeCDReditor']) && $_SESSION['cdreditor_add_cboModeCDReditor'] == 'checkbox'){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                ><?php give_translation('cdreditor.main_dd_mode_checkbox'); ?></option>
<!--                        <option value="radio">radio</option>-->
                        <option value="multi"
                            <?php if(!empty($_SESSION['cdreditor_add_cboModeCDReditor']) && $_SESSION['cdreditor_add_cboModeCDReditor'] == 'multi'){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                ><?php give_translation('cdreditor.main_dd_mode_multi'); ?></option>
                    </select>
                </td>
            </tr>
<?php
        }
?>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('cdreditor.main_subtitle_position'); ?></span>
                </td>
                <td align="left">
                    <input style="width: 50px;" type="text" name="txtPosCDReditor" value="<?php if(!empty($_SESSION['cdreditor_add_txtPosCDReditor'])){ echo($_SESSION['cdreditor_add_txtPosCDReditor']); }else{ echo('1010'); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_cdreditor_add_txtPosCDReditor']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_cdreditor_add_txtPosCDReditor']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('cdreditor.main_subtitle_status'); ?></span>
                </td>
                <td align="left">
                    <select name="cboStatusCDReditor">
                        <option value="1"
                            <?php if(empty($_SESSION['cdreditor_add_cboStatusCDReditor']) || $_SESSION['cdreditor_add_cboStatusCDReditor'] == 1){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                ><?php give_translation('cdreditor.main_dd_status_enabled'); ?></option>
                        <option value="9"
                            <?php if(!empty($_SESSION['cdreditor_add_cboStatusCDReditor']) && $_SESSION['cdreditor_add_cboStatusCDReditor'] == 9){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                ><?php give_translation('cdreditor.main_dd_status_disabled'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                    <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                        <tr>
                            <td align="center">
<?php
                            if(empty($_SESSION['cdreditor_cboSelectCDReditor']) || $_SESSION['cdreditor_cboSelectCDReditor'] == 'new')
                            {
?>
                                <input type="submit" name="bt_add_cdreditor" value="<?php give_translation('cdreditor.main_bt_add'); ?>"/>
<?php
                            }
                            else
                            {
?>
                                <input type="submit" name="bt_edit_cdreditor" value="<?php give_translation('cdreditor.main_bt_save'); ?>"/>
                                <input type="submit" name="bt_new_cdreditor" value="<?php give_translation('main.bt_new'); ?>"/>
<?php
                                try
                                {
                                    $prepared_query = 'SELECT COUNT(id_cdreditor) FROM cdreditor
                                                       WHERE code_cdreditor = :code';
                                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                    $query = $connectData->prepare($prepared_query);
                                    $query->bindParam('code', $_SESSION['cdreditor_cboSelectCodeCDReditor']);
                                    $query->execute();

                                    if(($data = $query->fetch()) != false)
                                    {
                                        $cdreditor_countfamilyoptions = $data[0];
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
                                
                                if($cdreditor_countfamilyoptions > 1 && (empty($_SESSION['cdreditor_add_cantdelete']) || $_SESSION['cdreditor_add_cantdelete'] != 1))
                                {
?>
                                    <input type="submit" name="bt_delete_cdreditor" value="<?php give_translation('main.bt_delete'); ?>"/>
<?php
                                }
                            }
?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>       
    </table>
    </td>
</tr>
