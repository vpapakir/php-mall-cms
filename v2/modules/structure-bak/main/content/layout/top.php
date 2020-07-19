<td colspan="2"><table class="block_main1" width="100%">
                
        <td colspan="2" class="font_main" align="center">
            <strong><?php give_translation('edit_structure.subtitle_layouttop_layout', '', $config_showtranslationcode); ?></strong>
        </td>

    <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.layouttop_addimage_layout', '', $config_showtranslationcode); ?>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <input type="file" name="upload_layout_top"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_layout_upload_layout_top']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_layout_upload_layout_top'])); 
                } 
?>
            </div>
        </td>
        
    <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.layouttop_addimage_width_layout', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtWidthImageTop"></input>
        </td>
        
    <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.layouttop_addimage_height_layout', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtHeightImageTop"></input>
        </td>    

    <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.layouttop_addimage_name_layout', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtNameImageTop"></input>
            &nbsp;
            <input type="submit" name="bt_send_image_layout_top" value="<?php give_translation('edit_structure.main_bt_sendimage_layout', '', $config_showtranslationcode); ?>"></input>
        </td>
        
<?php
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_layout_top = :id
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
                    <td colspan="2"><table width="100%">
                        <td><table width="100%">
                            <td style="vertical-align: middle;" align="right">
                                <input type="radio" name="rad_ImageLayoutTop" value="<?php echo($data[0]); ?>" <?php if($selected_image_layout_top == $data[0]){ echo('checked'); } ?>></input>
                            </td>
                            <td>
                                <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: 1px solid lightgray;"></img></a>
                            </td>
                        </table></td>
                        <td><table width="100%">
                            <td class="font_main" width="30%">
                                <?php give_translation('edit_structure.layouttop_addimage_name_layout', '', $config_showtranslationcode); ?>
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListNameImageTop<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.layouttop_addimage_alt_layout', '', $config_showtranslationcode); ?> 
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListAltImageTop<?php echo($data[0]); ?>" value="<?php echo($data['alt_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.layouttop_addimage_title_layout', '', $config_showtranslationcode); ?> 
                            </td>
                            <td class="font_main">
                                <input style="width: 100%;" type="text" name="txtListTitleImageTop<?php echo($data[0]); ?>" value="<?php echo($data['title_image']); ?>"></input>
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.layouttop_addimage_repeat_layout', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListRepeatImageTop<?php echo($data[0]); ?>">
                                    <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_repeat_none_layout', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_repeat_horizontal_layout', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_repeat_vertical_layout', '', $config_showtranslationcode); ?></option>
                                    <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_repeat_both_layout', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td class="font_main">
                                <?php give_translation('edit_structure.layouttop_addimage_attach_layout', '', $config_showtranslationcode); ?>
                            <td class="font_main">
                                <select name="cboListAttachImageTop<?php echo($data[0]); ?>">
                                    <option value="scroll" <?php if(empty($data['attachment_image']) || $data['attachment_image'] == 'scroll'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_attach_none_layout', '', $config_showtranslationcode); ?></option>
                                    <option value="fixed" <?php if(!empty($data['attachment_image']) && $data['attachment_image'] == 'fixed'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.layouttop_addimage_attach_sticky_layout', '', $config_showtranslationcode); ?></option>
                                </select>    
                            </td>
                            <tr></tr>
                            <td colspan="2" align="left">
                                <input type="submit" name="bt_delete_image_layout_top<?php echo($data[0]); ?>" value="<?php give_translation('edit_structure.main_bt_deleteimage_layout', '', $config_showtranslationcode); ?>"></input>
                            </td>
                        </table></td>

                    </table></td>
                    <tr></tr>
<?php                
                }
?>
                
                
                <tr></tr> 
                
                
                <td align="right">
                    <input type="checkbox" name="chk_UseImageLayoutTop" <?php if($selected_image_layout_top == 0){ echo('checked'); } ?>></input>
                </td>
                <td class="font_main" align="center">
                    <?php give_translation('edit_structure.layouttop_addimage_donotuse_layout', '', $config_showtranslationcode); ?>
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

        <td class="font_subtitle">
            <?php give_translation('edit_structure.layouttop_height_layout', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtHeightTop" value="<?php if(!empty($heightpart_layout[0])){ echo($heightpart_layout[0]); } ?>"></input>
        </td>    

</table></td>
