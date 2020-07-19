<?php
try
{
    $prepared_query = 'SELECT * FROM structure_body
                       WHERE id_body = :body';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('body', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_body = $data['id_body'];
        $name_body = $data['name_body'];
        $bgcolor_body = $data['bgcolor_body'];
        $bgimage_body = $data['bgimg_body '];
        $xrepeat_body = $data['xrepeat_body'];
        $yrepeat_body = $data['yrepeat_body'];
        $selected_image_body = $data['id_image'];
    }
    $query->closeCursor();
    
    $_SESSION['structure_edit_id_element'] = $id_body;
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

<td><table width="100%">
        
        <td class="font_subtitle" width="40%">
            <?php give_translation('edit_structure.subtitle_name_body', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameBody" value="<?php echo($name_body); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_body_txtNameBody']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_body_txtNameBody'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_body', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorBody', 'BgcolorColor');">
            <?php dropdown_color('cboBgcolorBody', $bgcolor_body, 'BgcolorColor'); ?>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_addimage_body', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="file" name="upload_body"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_body_upload_body']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_body_upload_body'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_nameimage_body', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtNameImage"></input>
            &nbsp;
            <input type="submit" name="bt_send_image_body" value="<?php give_translation('edit_structure.main_bt_sendimage_body', '', $config_showtranslationcode); ?>"></input>
        </td>
        
<?php
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_body = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();
            
            
            if(($data = $query->fetch()) != false)
            {
                $query->execute();
?>
                <tr></tr>
               
                
<?php        
                while($data = $query->fetch())
                {
                    if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                    {
                        $editstructure_body_mainimage_width = 160;
                        $editstructure_body_mainimage_height = ($editstructure_body_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                    }
?>
                    <td colspan="2"><table class="block_main1" width="100%">
                        <td><table width="100%">
                            <td style="vertical-align: middle;" align="right">
                                <input type="radio" name="rad_ImageBody" value="<?php echo($data[0]); ?>" <?php if($selected_image_body == $data[0]){ echo('checked'); } ?>></input>
                            </td>
                            <td>
                                <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: 1px solid lightgrey; <?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($editstructure_body_mainimage_width); ?>px; height: <?php echo($editstructure_body_mainimage_height); ?>px;<?php } ?>"></img></a>
                            </td>
                        </table></td>
                        <td><table width="100%">
                            <td class="font_main" width="30%">
                                <?php give_translation('edit_structure.addimage_name_body', '', $config_showtranslationcode); ?>
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListNameImage<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_alt_body', '', $config_showtranslationcode); ?> 
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListAltImage<?php echo($data[0]); ?>" value="<?php echo($data['alt_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_title_body', '', $config_showtranslationcode); ?> 
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListTitleImage<?php echo($data[0]); ?>" value="<?php echo($data['title_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_repeat_body', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListRepeatImage<?php echo($data[0]); ?>">
                                    <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_none_body', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_horizontal_body', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_vertical_body', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_both_body', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_attach_body', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListAttachImage<?php echo($data[0]); ?>">
                                    <option value="scroll" <?php if(empty($data['attachment_image']) || $data['attachment_image'] == 'scroll'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_attach_none_body', '', $config_showtranslationcode); ?></option>
                                    <option value="fixed" <?php if(!empty($data['attachment_image']) && $data['attachment_image'] == 'fixed'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_attach_sticky_body', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td colspan="2" align="left">
                                <input type="submit" name="bt_delete_image_body<?php echo($data[0]); ?>" value="<?php give_translation('edit_structure.main_bt_deleteimage_body', '', $config_showtranslationcode); ?>"></input>
                            </td>
                        </table></td>

                    </table></td>
                    <tr></tr>
<?php                
                }
?>
                
                
                <tr></tr> 
                
                
                <td align="right">
                    <input type="checkbox" name="chk_UseImageBody" <?php if($selected_image_body == 0){ echo('checked'); } ?>></input>
                </td>
                <td class="font_main" align="center">
                    <?php give_translation('edit_structure.addimage_donotuse_body', '', $config_showtranslationcode); ?>
                </td>
               
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
        
        <tr></tr>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_body" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




