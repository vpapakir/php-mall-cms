<?php
try
{
    $prepared_query = 'SELECT * FROM structure_skin
                       WHERE id_skin = :skin';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('skin', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_skin = $data['id_skin'];
        $name_skin = $data['name_skin'];
        
        $width_skin = $data['width_skin'];
        $height_skin = $data['height_skin'];
        $position_skin = $data['position_skin'];
        $margin_skin = $data['margin_skin'];
        $border_skin = $data['border_skin'];
        $bordercolor_skin = $data['bordercolor_skin'];
        $tablebg_skin = $data['tablebg_skin'];
        $cs_skin = $data['cs_skin'];
        $cp_skin  = $data['cp_skin'];
        
        $bgcolor_skin = $data['bgcolor_skin'];
        $bgimage_skin = $data['bgimg_skin'];
        $xrepeat_skin = $data['xrepeat_skin'];
        $yrepeat_skin = $data['yrepeat_skin'];
        
        $selected_image_skin = $data['id_image'];
    }
    $query->closeCursor();
    
    $_SESSION['structure_edit_id_element'] = $id_skin;
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
            <?php give_translation('edit_structure.subtitle_name_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameSkin" value="<?php echo($name_skin); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_skin_txtNameSkin']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_skin_txtNameSkin'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_width_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtWidthSkin" value="<?php echo($width_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_height_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtHeightSkin" value="<?php echo($height_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_position_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtPositionSkin" value="<?php echo($position_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_margin_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtMarginSkin" value="<?php echo($margin_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_border_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtBorderSkin" value="<?php echo($border_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bordercolor_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBordercolorSkin', 'BordercolorSkin');">
            <?php dropdown_color('cboBordercolorSkin', $bordercolor_skin, 'BordercolorSkin'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellcolor_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboTablebgSkin', 'TablebgSkin');">
            <?php dropdown_color('cboTablebgSkin', $tablebg_skin, 'TablebgSkin'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellspacing_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCsSkin" value="<?php echo($cs_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellpadding_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtCpSkin" value="<?php echo($cp_skin); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_skin', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorSkin', 'BgcolorSkin');">
            <?php dropdown_color('cboBgcolorSkin', $bgcolor_skin, 'BgcolorSkin'); ?>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_addimage_skin', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="file" name="upload_skin"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_skin_upload_skin']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_skin_upload_skin'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_imagename_skin', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtNameImage"></input>
            &nbsp;
            <input type="submit" name="bt_send_image_skin" value="<?php give_translation('edit_structure.main_bt_sendimage_skin', '', $config_showtranslationcode); ?>"></input>
        </td>
        
<?php
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_skin = :id
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
?>
                    <td colspan="2"><table class="block_main1" width="100%">
                        <td><table width="100%">
                            <td style="vertical-align: middle;" align="right">
                                <input type="radio" name="rad_ImageSkin" value="<?php echo($data[0]); ?>" <?php if($selected_image_skin == $data[0]){ echo('checked'); } ?>></input>
                            </td>
                            <td>
                                <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: 1px solid lightgray;"></img></a>
                            </td>
                        </table></td>
                        <td><table width="100%">
                            <td class="font_main" width="30%">
                                <?php give_translation('edit_structure.addimage_name_skin', '', $config_showtranslationcode); ?>
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListNameImage<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_alt_skin', '', $config_showtranslationcode); ?> 
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListAltImage<?php echo($data[0]); ?>" value="<?php echo($data['alt_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_title_skin', '', $config_showtranslationcode); ?>
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListTitleImage<?php echo($data[0]); ?>" value="<?php echo($data['title_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_repeat_skin', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListRepeatImage<?php echo($data[0]); ?>">
                                    <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_none_skin', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_horizontal_skin', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_vertical_skin', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_repeat_both_skin', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.addimage_attach_skin', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListAttachImage<?php echo($data[0]); ?>">
                                    <option value="scroll" <?php if(empty($data['attachment_image']) || $data['attachment_image'] == 'scroll'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_attach_none_skin', '', $config_showtranslationcode); ?></option>
                                    <option value="fixed" <?php if(!empty($data['attachment_image']) && $data['attachment_image'] == 'fixed'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.addimage_attach_sticky_skin', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td colspan="2" align="left">
                                <input type="submit" name="bt_delete_image_skin<?php echo($data[0]); ?>" value="<?php give_translation('edit_structure.main_bt_deleteimage_skin', '', $config_showtranslationcode); ?>"></input>
                            </td>
                        </table></td>

                    </table></td>
                    <tr></tr>
<?php                
                }
?>
                
                
                <tr></tr> 
                
                
                <td align="right">
                    <input type="checkbox" name="chk_UseImageSkin" <?php if($selected_image_skin == 0){ echo('checked'); } ?>></input>
                </td>
                <td class="font_main" align="center">
                    <?php give_translation('edit_structure.addimage_donotuse_skin', '', $config_showtranslationcode); ?>
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
            <input type="submit" name="bt_save_main_skin" value="<?php give_translation('edit_structure.main_bt_save', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




