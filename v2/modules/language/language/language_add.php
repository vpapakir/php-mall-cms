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
    
    if($count_language > 0)
    {
        $count_language++;
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
<tr>
<td><table class="block_main2" width="100%">
    <tr>  
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_code_language', '', $config_showtranslationcode); ?>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <select id="cboCodeAddLanguage" name="cboCodeAddLanguage" onchange="language_add('cboCodeAddLanguage', 'txtNameImageAddLanguage')">
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
                    <option style="background-color: lightgray;" value="<?php echo($data[0]); ?>" 
                    <?php if(!empty($_SESSION['language_add_cboCodeAddLanguage']) && $_SESSION['language_add_cboCodeAddLanguage'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
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
                    <?php if(!empty($_SESSION['language_add_cboCodeAddLanguage']) && $_SESSION['language_add_cboCodeAddLanguage'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
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
                    die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
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
                   <input type="text" name="txtAddNameL1" value="<?php if(!empty($_SESSION['language_add_txtAddNameL1'])){ echo($_SESSION['language_add_txtAddNameL1']); } ?>"></input>                 
<?php 
                if(!empty($_SESSION['msg_language_add_txtAddNameL1']))
                { 
?>
                   <br clear="left"/>
                   <div class="font_error1"><?php echo($_SESSION['msg_language_add_txtAddNameL1']); ?></div>
<?php
                } 
?>
                </td>
            </tr>
<?php        
        }
        else
        {
            for($i = 0, $count = count($main_activatedidlang) + 1; $i < $count; $i++)
            {
?>              
               <?php
               if($i == ($count - 1))
               {
?>
                   <tr>

                   <td class="font_subtitle">
                    <?php give_translation('edit_language.subtitle_namenew_language', '', $config_showtranslationcode); ?>
                   </td> 
                   <td>
                       <input type="text" name="txtAddNameL<?php echo($i); ?>" value="<?php if(!empty($_SESSION['language_add_txtAddNameL'.$i])){ echo($_SESSION['language_add_txtAddNameL'.$i]); } ?>"></input>
                   </td>
                   
                   </tr>
<?php                   
               }
               else
               {
?>
                   <tr>

                   <td class="font_subtitle">
                    <?php give_translation('edit_language.subtitle_name_language', '', $config_showtranslationcode); ?> <?php give_translation($main_activatedcodelang[$i], '', $config_showtranslationcode); ?>
                   </td> 
                   <td>
                       <input type="text" name="txtAddNameL<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['language_add_txtAddNameL'.$main_activatedidlang[$i]])){ echo($_SESSION['language_add_txtAddNameL'.$main_activatedidlang[$i]]); } ?>"></input>
<?php
                   if($i == 0)
                   {
                       if(!empty($_SESSION['msg_language_add_txtAddNameL1']))
                       { 
?>
                           <br clear="left"/>
                           <div class="font_error1"><?php echo($_SESSION['msg_language_add_txtAddNameL1']); ?></div>
<?php
                       } 
                   }
?>
                   </td>
                   
                   </tr>
<?php   
               }
            }
        }
?>
    <tr>             
        <td class="font_subtitle">
           <?php give_translation('edit_language.subtitle_imageselected_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
           <input type="file" name="upload_add_language[]"></input>
<?php 
           if(!empty($_SESSION['msg_language_upload_add_activated_language']))
           { 
?>
               <br clear="left"/>
               <div class="font_error1"><?php echo($_SESSION['msg_language_upload_add_activated_language']); ?></div>
<?php 
           } 
?>
        </td>
    </tr>    
    <tr>               
        <td class="font_subtitle">
           <?php give_translation('edit_language.subtitle_imageunselected_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input type="file" name="upload_add_language[]"></input>
<?php 
           if(!empty($_SESSION['msg_language_upload_add_disabled_language']))
           { 
?>
               <br clear="left"/>
               <div class="font_error1"><?php echo($_SESSION['msg_language_upload_add_disabled_language']); ?></div>
<?php 
           } 
?>
           </div>
        </td>
    </tr>            
    <tr> 
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_imagename_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input readonly="true" id="txtNameImageAddLanguage" type="text" name="txtNameImageAddLanguage" value="<?php if(!empty($_SESSION['language_add_txtNameImageAddLanguage'])){ echo($_SESSION['language_add_txtNameImageAddLanguage']); } ?>"></input>
        </td>
    </tr>    
    <tr> 
        <td></td>
        <td><table>
               <td>
                   <input id="chk_priority_add_language" type="checkbox" name="chk_priority_add_language" <?php if(!empty($_SESSION['language_add_chkpriority']) && $_SESSION['language_add_chkpriority'] == 1){ echo('checked'); }else{ echo(null); } ?>></input> 
               </td>
               <td class="font_subtitle">
                   <LABEL for="chk_priority_add_language">
                       <?php give_translation('edit_language.subtitle_default_language', '', $config_showtranslationcode); ?>
                   </LABEL>
               </td>
        </table></td>
    </tr>    
    <tr>        
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_position_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <input style="width: 50px;" type="text" name="txtPositionAddLanguage" value="<?php if(!empty($_SESSION['language_add_txtPositionAddLanguage'])){ echo($_SESSION['language_add_txtPositionAddLanguage']); } ?>"></input>
        </td>
    </tr>    
    <tr>     
        <td class="font_subtitle">
            <?php give_translation('edit_language.subtitle_status_language', '', $config_showtranslationcode); ?>
        </td>
        <td>
           <select name="cboStatusAddLanguage">
               <option value="1" <?php if(!empty($_SESSION['language_add_cboStatusAddLanguage']) && $_SESSION['language_add_cboStatusAddLanguage'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_enabled', '', $config_showtranslationcode); ?></option>
               <option value="0" <?php if(!empty($_SESSION['language_add_cboStatusAddLanguage']) && $_SESSION['language_add_cboStatusAddLanguage'] == 0){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_disabled', '', $config_showtranslationcode); ?></option>
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
                    <input type="submit" name="bt_save_create_language" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"></input>
                </td>
            </tr> 
        </table></td>
    </tr>
</table></td>
</tr>
