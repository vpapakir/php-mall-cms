<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
<?php
            if((checkrights($main_rights_log, '8')) === true)
            {
?>
               <tr>
                   <td align="left">
                       <span class="font_subtitle">
                           <?php give_translation('user_edit.subtitle_modify_rights', $echo, $config_showtranslationcode); ?>
                       </span>
                   </td>
                   <td align="left" width="<?php echo($right_column_width); ?>">
                       <select name="cboRightsUserEdit"> 
<?php
                try
                {
                    $prepared_query = 'SELECT * FROM user_rights ';
                    if((checkrights($main_rights_log, '9', $redirection)) === true)
                    { 
                        $prepared_query .= 'WHERE level_rights <> -1
                                            ORDER BY level_rights';
                        $_SESSION['prepared_query'] = $prepared_query;                   
                    }
                    else
                    {
                        $prepared_query .= 'WHERE level_rights <> -1
                                            AND level_rights < 9
                                            ORDER BY level_rights';
                    }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    while($data = $query->fetch())
                    {
?>                          
                        <option value="<?php echo($data['level_rights']); ?>"
                            <?php if(!empty($_SESSION['useredit_cboRightsUserEdit']) && $_SESSION['useredit_cboRightsUserEdit'] == $data['level_rights']){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.'.$data['name_rights'], $echo, $config_showtranslationcode); ?></option>
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
                   </td>
               </tr>
<?php
            }
?>
            <tr>
                <td class="font_subtitle">
                    <?php give_translation('user_edit.subtitle_modify_status', $echo, $config_showtranslationcode); ?>
                </td> 
                <td>
                    <select name="cboStatusUserEdit">
                        <option value="1"
                            <?php if(empty($_SESSION['useredit_cboStatusUserEdit']) || $_SESSION['useredit_cboStatusUserEdit'] == 1){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_active', '', $config_showtranslationcode); ?></option>
                        <option value="2"
                            <?php if(!empty($_SESSION['useredit_cboStatusUserEdit']) && $_SESSION['useredit_cboStatusUserEdit'] == 2){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_onhold', '', $config_showtranslationcode); ?></option>
                        <option value="9"
                            <?php if(!empty($_SESSION['useredit_cboStatusUserEdit']) && $_SESSION['useredit_cboStatusUserEdit'] == 9){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_blocked', '', $config_showtranslationcode); ?></option>
                    </select>
                </td>     
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <textarea class="font_main" style="width: 99%;" name="areaRemarksUserEdit" rows="5"><?php if(empty($_SESSION['useredit_areaRemarksUserEdit'])){ give_translation('user_edit.subtitle_modify_remarks', $echo, $config_showtranslationcode); }else{ echo($_SESSION['useredit_areaRemarksUserEdit']); } ?></textarea>
                </td>     
            </tr>
            
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2"><table width="100%" style="">
                    <tr>        
                        <td align="center">
                            <input type="submit" name="bt_save_useredit" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_backtolisting_useredit" value="<?php give_translation('main.bt_back', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_new_useredit" value="<?php give_translation('main.bt_new_user', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table>
    </td>
</tr>
