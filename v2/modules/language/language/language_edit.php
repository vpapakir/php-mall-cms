<?php
try
{
    $prepared_query = 'SELECT COUNT(id_language) FROM language
                   WHERE status_language = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $count_language = $data[0];
    }
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
<tr>
<td><table class="block_main2" width="100%">
<?php
if(!empty($_SESSION['msg_language_edit_done']))
{
    $_SESSION['unset_afterrefresh_language_edit_done']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_language_edit_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_language_edit_done'] >= 2)
    {
        unset($_SESSION['msg_language_edit_done']);
        unset($_SESSION['unset_afterrefresh_language_edit_done']);
    }
}
?>
       
        
    <tr>   
        <td></td>
        <td><table>
            <td>
               <input id="chk_priority_edit_language" type="checkbox" name="chk_priority_edit_language" <?php if(!empty($_SESSION['language_edit_chkpriority']) && $_SESSION['language_edit_chkpriority'] == 1){ echo('checked'); }else{ echo(null); } ?>></input> 
            </td>
            <td class="font_subtitle">
               <LABEL for="chk_priority_edit_language">
                   <?php give_translation('edit_language.subtitle_default_language', '', $config_showtranslationcode); ?>
               </LABLE>
            </td>
        </table></td>
    </tr>   
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_code_language', '', $config_showtranslationcode); ?>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <select id="cboCodeEditLanguage" name="cboCodeEditLanguage" onchange="language_add('cboCodeEditLanguage', 'txtNameImageEditLanguage')">
                <option value="select">---</option>
<?php
            try
            {
                $prepared_query = 'SELECT code_country FROM country
                                   WHERE status_country = 1 AND code_country <> \'\'
                                   AND used_code_country = 1
                                   ORDER BY used_code_country, code_country';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option style="background-color: lightblue;" value="<?php echo($data[0]); ?>" 
                    <?php if(!empty($_SESSION['language_edit_cboCodeEditLanguage']) && $_SESSION['language_edit_cboCodeEditLanguage'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                            ><?php echo($data[0]); ?></option>
<?php                
                }

                $prepared_query = 'SELECT code_country FROM country
                                   WHERE status_country = 1 AND code_country <> \'\'
                                   AND used_code_country = 0
                                   ORDER BY used_code_country, code_country';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data[0]); ?>" 
                    <?php if(!empty($_SESSION['language_edit_cboCodeEditLanguage']) && $_SESSION['language_edit_cboCodeEditLanguage'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                            ><?php echo($data[0]); ?></option>
<?php                
                }
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
<?php 
            if(!empty($_SESSION['msg_language_add_cboCodeAddLanguage']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_language_add_cboCodeAddLanguage']); ?></div>
<?php
            } 
?>            
        </td>
    </tr>        
<?php
        if($count_language == 0)
        {
?>
           <tr>      
           <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_namenew_language', '', $config_showtranslationcode); ?>
           </td> 
           <td>
               <input type="text" name="txtEditNameL1" value="<?php if(!empty($_SESSION['language_edit_txtEditNameL1'])){ echo($_SESSION['language_edit_txtEditNameL1']); } ?>"></input>
<?php 
            if(!empty($_SESSION['msg_language_edit_txtEditNameL1']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_language_edit_txtEditNameL1']); ?></div>
<?php
            }
?>
           </td>
           </tr>
<?php        
        }
        else
        {
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
?>
               <tr>
               <td class="font_subtitle">
                <?php give_translation('edit_language.subtitle_name_language', '', $config_showtranslationcode); ?> <?php give_translation($main_activatedcodelang[$i], '', $config_showtranslationcode); ?>
               </td> 
               <td>
                   <input type="text" name="txtEditNameL<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['language_edit_txtEditNameL'.$main_activatedidlang[$i]])){ echo($_SESSION['language_edit_txtEditNameL'.$main_activatedidlang[$i]]); } ?>"></input>
<?php
               if($i == 1)
               { 
                    if(!empty($_SESSION['msg_language_edit_txtEditNameL1']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_language_edit_txtEditNameL1']); ?></div>
<?php
                    }
               }
?>
               </td>
               </tr>
<?php                
            }
        }
?>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
    <tr>         
        <td class="font_subtitle">
           <?php give_translation('edit_language.subtitle_imageselected_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
           <input type="file" name="upload_edit_language[]"></input>
<?php 
            if(!empty($_SESSION['msg_language_upload_edit_activated_language']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_language_upload_edit_activated_language']); ?></div>
<?php
            } 
?>
        </td>
    </tr>
       
<?php
        try
        {
            $prepared_query = 'SELECT * FROM language_image
                               WHERE id_language = :id
                               AND status_image = 1
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $_SESSION['language_select_cboLanguage']);
            $query->execute(); 
            
            if(($data = $query->fetch()) != false)
            {
                $query->execute();
?>
                <tr></tr>         
<?php        
                while($data = $query->fetch())
                {
?>
                    <tr>
                        <td colspan="2"><table class="block_main1" width="100%">
                            <tr>
                            <td><table width="100%">
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: none;"></img></a>
                                    </td>
                                </tr>
                            </table></td>
                            <td width="<?php echo($right_column_width); ?>"><table width="100%">
                                <tr>
                                    <td class="font_main" width="30%">
                                        <?php give_translation('edit_language.imageselected_name_language', '', $config_showtranslationcode); ?>
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtActNameImageEditLanguage" value="<?php echo($data['name_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageselected_alt_language', '', $config_showtranslationcode); ?> 
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtActAltImageEditLanguage" value="<?php echo($data['alt_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageselected_title_language', '', $config_showtranslationcode); ?> 
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtActTitleImageEditLanguage" value="<?php echo($data['title_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageselected_repeat_language', '', $config_showtranslationcode); ?>
                                    <td class="font_main">
                                        <select name="cboActRepeatImageEditLanguage">
                                            <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_none', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_horizontal', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_vertical', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_both', '', $config_showtranslationcode); ?></option>
                                        </select>    
                                    </td>
                                </tr>
                            </table></td>
                            </tr>
                        </table></td>
                    </tr>
<?php                
                }
            }
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
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>  
    <tr>         
        <td class="font_subtitle">
           <?php give_translation('edit_language.subtitle_imageunselected_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input type="file" name="upload_edit_language[]"></input>
<?php 
            if(!empty($_SESSION['msg_language_upload_edit_disabled_language']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_language_upload_edit_disabled_language']); ?></div>
<?php
            } 
?>
           </div>
        </td>
    </tr>
       
<?php
        try
        {
            $prepared_query = 'SELECT * FROM language_image
                               WHERE id_language = :id
                               AND status_image = 9
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $_SESSION['language_select_cboLanguage']);
            $query->execute(); 
            
            if(($data = $query->fetch()) != false)
            {
                $query->execute();
        
                while($data = $query->fetch())
                {
?>
                    <tr>
                        <td colspan="2"><table class="block_main1" width="100%">
                            <tr>
                            <td><table width="100%">
                                <tr>
                                    <td style="vertical-align: middle;" align="right">

                                    </td>
                                    <td>
                                        <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: none;"></img></a>
                                    </td>
                                </tr>
                            </table></td>
                            <td width="<?php echo($right_column_width); ?>"><table width="100%">
                                <tr>
                                    <td class="font_main" width="30%">
                                        <?php give_translation('edit_language.imageunselected_name_language', '', $config_showtranslationcode); ?>
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisNameImageEditLanguage" value="<?php echo($data['name_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageunselected_alt_language', '', $config_showtranslationcode); ?> 
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisAltImageEditLanguage" value="<?php echo($data['alt_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageunselected_title_language', '', $config_showtranslationcode); ?> 
                                    </td>
                                    <td class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisTitleImageEditLanguage" value="<?php echo($data['title_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font_main">
                                        <?php give_translation('edit_language.imageunselected_repeat_language', '', $config_showtranslationcode); ?>
                                    <td class="font_main">
                                        <select name="cboDisRepeatImageEditLanguage">
                                            <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_none', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_horizontal', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_vertical', '', $config_showtranslationcode); ?></option>
                                            <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_imagerepeat_both', '', $config_showtranslationcode); ?></option>
                                        </select>    
                                    </td>
                                </tr>
                            </table></td>
                            </tr>
                        </table></td>
                    </tr>
<?php                
                }
            }
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
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_imagename_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input readonly="true" id="txtNameImageEditLanguage" type="text" name="txtNameImageEditLanguage" value="<?php if(!empty($_SESSION['language_edit_txtNameImageEditLanguage'])){ echo($_SESSION['language_edit_txtNameImageEditLanguage']); } ?>"></input>
        </td>
    </tr>   
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_position_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input style="width: 50px;" type="text" name="txtPositionEditLanguage" value="<?php if(!empty($_SESSION['language_edit_txtPositionEditLanguage'])){ echo($_SESSION['language_edit_txtPositionEditLanguage']); } ?>"></input>
        </td>
    </tr>   
    <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_status_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <select name="cboStatusEditLanguage">
               <option value="1" <?php if(!empty($_SESSION['language_edit_cboStatusEditLanguage']) && $_SESSION['language_edit_cboStatusEditLanguage'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_enabled', '', $config_showtranslationcode); ?></option>
               <option value="0" <?php if(empty($_SESSION['language_edit_cboStatusEditLanguage'])){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_disabled', '', $config_showtranslationcode); ?></option>
           </select>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%">
            <tr>        
                <td align="center">
                    <input type="submit" name="bt_save_exist_language" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"></input>
                </td>
            </tr> 
        </table></td>
    </tr>
</table></td>
</tr>