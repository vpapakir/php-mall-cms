<?php
try
{
    $prepared_query = 'SELECT * FROM structure_logo
                       WHERE id_logo = :logo';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('logo', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_logo = $data['id_logo'];
        $name_logo = $data['name_logo'];
        $text_logo = $data['text_logo'];
        $font_logo = $data['font_logo'];
        $size_logo = $data['size_logo'];
        $weight_logo = $data['weight_logo'];
        $align_logo = $data['align_logo'];
        $color_logo = $data['color_logo'];
        $scriptpath_logo = $data['scriptpath_logo'];
        $scriptcode_logo = $data['scriptcode_logo'];
        $selected_image = $data['id_image'];
        $selected_language = $data['id_language'];
        $marginl_logo = $data['marginl_logo'];
        $marginr_logo = $data['marginr_logo'];
        
    }
    $query->closeCursor();
    
    $selected_image = split_string($selected_image, '$');
    $selected_language = split_string($selected_language, '$');
    $scriptpath_logo = split_string($scriptpath_logo, '$');
    $scriptcode_logo = split_string($scriptcode_logo, '$');
    
    $_SESSION['structure_edit_id_element'] = $id_logo;
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
        
        <tr>
        <td class="font_subtitle" width="40%">
            <?php give_translation('edit_structure.subtitle_name_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameLogo" value="<?php echo($name_logo); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_logo_txtNameLogo']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_logo_txtNameLogo'])); 
                } 
?>
            </div>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_text_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtTextLogo" value="<?php echo($text_logo); ?>"></input>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_textfont_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboFontLogo">
<?php
            try
            {
                $prepared_query = 'SELECT * FROM fonts
                                   ORDER BY name_fonts';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option style="font-family: <?php echo('\''.$data['name_fonts'].'\''); ?>;" value="<?php echo($data['family_fonts']); ?>"
                            <?php if($font_logo == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>
                            ><?php echo($data['name_fonts'].' - AaBbCcIi0123'); ?></option>
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
                    die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                } 
            }
?>                
            </select>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_textsize_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtFontSizeLogo" value="<?php echo($size_logo); ?>"></input>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_textweight_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboFontWeightLogo">
                <option style="font-weight: normal;" value="normal" <?php if($weight_logo == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textweight_normal_logo', '', $config_showtranslationcode); ?></option>
                <option style="font-weight: bold;" value="bold" <?php if($weight_logo == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textweight_bold_logo', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_textalign_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboFontAlignLogo">
                <option style="text-align: left;" value="left" <?php if($align_logo == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textalign_left_logo', '', $config_showtranslationcode); ?></option>
                <option style="text-align: center;" value="center" <?php if($align_logo == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textalign_center_logo', '', $config_showtranslationcode); ?></option>
                <option style="text-align: right;" value="right" <?php if($align_logo == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textalign_right_logo', '', $config_showtranslationcode); ?></option>
                <option style="text-align: justify;" value="justify" <?php if($align_logo == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_structure.textalign_justify_logo', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
        </tr>
     
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_textcolor_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" onchange="onchange_color('cboBgcolorLogo', 'BgcolorColorLogo');">
            <?php dropdown_color('cboBgcolorLogo', $color_logo, 'BgcolorColorLogo'); ?>
        </td>
        </tr>
        
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_marginleft_logo', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtMarginLLogo" value="<?php echo($marginl_logo); ?>"/>
        </td>
        </tr>
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_marginright_logo', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="text" name="txtMarginRLogo" value="<?php echo($marginr_logo); ?>"/>
        </td>
        </tr>
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_addimage_logo', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input type="file" name="upload_logo"></input>
            <br clear="left">
            <div class="font_error1">
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_logo_upload_logo']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_logo_upload_logo'])); 
                } 
?>
            </div>
        </td>
        </tr>
        <tr>
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_nameimage_logo', '', $config_showtranslationcode); ?>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <input type="text" name="txtNameImage"></input>
            &nbsp;
            <input type="submit" name="bt_send_image_logo" value="<?php give_translation('edit_structure.main_bt_sendimage', '', $config_showtranslationcode); ?>"></input>
        </td>
        </tr>
<?php
for($k = 0, $countk = count($main_activatedidlang); $k < $countk; $k++)
{
?>
        <tr>
<td align="left" colspan="2"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>"
<?php
                if(empty($_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]]) || $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>', 'img_expand_collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>', 'expand_structureedit_logo<?php echo($main_activatedidlang[$k]); ?>', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]]) || $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] == 'false')
                        {
?>
                            <img id="img_expand_collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span><?php give_translation($main_activatedcodelang[$k]); ?></span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_structureedit_logo<?php echo($main_activatedidlang[$k]); ?>" style="display: none;" type="hidden" name="expand_structureedit_logo<?php echo($main_activatedidlang[$k]); ?>" value="<?php if(empty($_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]]) || $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseStructureEditLogo<?php echo($main_activatedidlang[$k]); ?>"
<?php
        if(empty($_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]]) || $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
    <td><table width="100%">
<?php
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_logo = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();
            
            
            if(($data = $query->fetch()) != false)
            {
                $query->execute();
?>
                <tr>
               
                
<?php        
                while($data = $query->fetch())
                {
?>
                    <tr>
                    <td colspan="2"><table class="block_main1" width="100%">
                        <td><table width="100%">
                            <td style="vertical-align: middle;" align="right">
                                <input type="radio" name="rad_ImageLogo<?php echo($main_activatedidlang[$k]); ?>" value="<?php echo($data[0]); ?>" <?php if($selected_image[$k] == $data[0]){ echo('checked'); } ?>></input>
                            </td>
                            <td>
                                <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: 1px solid lightgray;"></img></a>
                            </td>
                        </table></td>
                        <td><table width="100%">
                            <tr>    
                                <td class="font_main" width="30%">
                                    <?php give_translation('edit_structure.addimage_name_logo', '', $config_showtranslationcode); ?>
                                </td>
                                <td class="font_main">
                                    <input style="width: 100%;" type="text" name="txtListNameImage<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="font_main">
                                    <?php give_translation('edit_structure.addimage_alt_logo', '', $config_showtranslationcode); ?> 
                                </td>
                                <td class="font_main">
                                    <input style="width: 100%;" type="text" name="txtListAltImage<?php echo($data[0]); ?>" value="<?php echo($data['alt_image']); ?>"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="font_main">
                                    <?php give_translation('edit_structure.addimage_title_logo', '', $config_showtranslationcode); ?> 
                                </td>
                                <td class="font_main">
                                    <input style="width: 100%;" type="text" name="txtListTitleImage<?php echo($data[0]); ?>" value="<?php echo($data['title_image']); ?>"></input>
                                </td>
                            </tr>
                            <tr>
                                <td class="font_main">
                                    <?php give_translation('edit_structure.addimage_repeat_logo', '', $config_showtranslationcode); ?>
                                <td class="font_main">
                                    <select name="cboListRepeatImage<?php echo($data[0]); ?>">
                                        <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>>Aucune</option>
                                        <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>>Horizontale</option>
                                        <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>>Verticale</option>
                                        <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>>Les deux</option>
                                    </select>    
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                    <input type="submit" name="bt_delete_image_logo<?php echo($data[0]); ?>" value="<?php give_translation('edit_structure.main_bt_deleteimage', '', $config_showtranslationcode); ?>"></input>
                                </td>
                            </tr>
                        </table></td>

                    </table></td>
                    </tr>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>    
                    <tr>
                        <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php                
                }
?>
                </tr> 
                
                <tr>
                <td align="right">
                    <input type="checkbox" name="chk_UseImageLogo<?php echo($main_activatedidlang[$k]); ?>" <?php if($selected_image == 0){ echo('checked'); } ?>></input>
                </td>
                <td class="font_main" align="center">
                    <?php give_translation('edit_structure.addimage_donotuse_logo', '', $config_showtranslationcode); ?>
                </td>
                </tr>
               
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
        
        <tr>        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_scriptpath_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_subtitle">
            <input style="width: 100%;" type="text" name="txtScriptPathLogo<?php echo($main_activatedidlang[$k]); ?>" value="<?php echo($scriptpath_logo[$k]); ?>"></input>
        </td>
        </tr>
        
        <tr>       
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_scriptcode_logo', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <textarea name="areaScriptCodeLogo<?php echo($main_activatedidlang[$k]); ?>" style="width: 100%;" rows="10"><?php echo($scriptcode_logo[$k]); ?></textarea>
        </td>
        </tr>
    </table></td>
</table></td>
</tr>
<?php
}
?>
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
                        <input type="submit" name="bt_save_main_logo" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
        
</table></td>




