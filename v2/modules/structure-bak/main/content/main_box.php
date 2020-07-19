<?php
try
{
    $prepared_query = 'SELECT * FROM structure_box
                       WHERE id_box = :box';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('box', $id_element);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $id_box = $data['id_box'];
        $name_box = $data['name_box'];
        
        $width_box = $data['width_box'];
        $height_box = $data['height_box'];
        $position_box = $data['position_box'];
        $margin_box = $data['margin_box'];
        $border_box = $data['border_box'];
        $bordercolor_box = $data['bordercolor_box'];
        $tablebg_box = $data['tablebg_box'];
        $cs_box = $data['cs_box'];
        $cp_box  = $data['cp_box'];
        
        $bgcolor_box = $data['bgcolor_box'];
        $bgimage_box = $data['bgimg_box'];
        $xrepeat_box = $data['xrepeat_box'];
        $yrepeat_box = $data['yrepeat_box'];
        
        $scriptpath_box = $data['scriptpath_box'];
        $scriptcode_box = $data['scriptcode_box'];
        $defaultfont_box = $data['defaultfont_box'];
        $blocktitle_box = $data['blocktitle_box'];
        $blockcontent_box = $data['blockcontent_box'];
    }
    $query->closeCursor();
    
    $_SESSION['structure_edit_id_element'] = $id_box;
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
            <?php give_translation('edit_structure.subtitle_name_box', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameBox" value="<?php echo($name_box); ?>"></input>
<!--            <input style="display: none;" hidden="true" type="text" name="txtOldNameBox" value="<?php //echo($name_box); ?>"></input>-->
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_box_txtNameBox']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_box_txtNameBox'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_width_box', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input type="text" name="txtWidthBox" value="<?php echo($width_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_height_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtHeightBox" value="<?php echo($height_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_position_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtPositionBox" value="<?php echo($position_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_margin_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtMarginBox" value="<?php echo($margin_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_border_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtBorderBox" value="<?php echo($border_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bordercolor_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>" onchange="onchange_color('cboBordercolorBox', 'BordercolorBox');">
            <?php dropdown_color('cboBordercolorBox', $bordercolor_box, 'BordercolorBox'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellcolor_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>" onchange="onchange_color('cboTablebgBox', 'TablebgBox');">
            <?php dropdown_color('cboTablebgBox', $tablebg_box, 'TablebgBox'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellspacing_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtCsBox" value="<?php echo($cs_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_cellpadding_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input type="text" name="txtCpBox" value="<?php echo($cp_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_bgcolor_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>" onchange="onchange_color('cboBgcolorBox', 'BgcolorBox');">
            <?php dropdown_color('cboBgcolorBox', $bgcolor_box, 'BgcolorBox'); ?>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_scriptpath_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <input style="width: 100%;" type="text" name="txtScriptPathBox" value="<?php echo($scriptpath_box); ?>"></input>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_scriptcode_box', '', $config_showtranslationcode); ?>
        </td>
        <td style="<?php echo($style_main_font); ?>">
            <textarea name="areaScriptCodeBox" style="width: 100%;" rows="10"><?php echo($scriptcode_box); ?></textarea>
        </td>

        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_font_box', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboStyleBox">
<?php
            try
            {
                $prepared_query = 'SELECT * FROM style_font
                                   WHERE id_template = :template';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('template', $id_template);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $title_font = $data['title_font'];
                    $intro_font = $data['intro_font'];
                    $desc_font = $data['desc_font'];
                    $subtitle_font = $data['subtitle_font'];
                    $main_font = $data['main_font'];
                    $com_font = $data['comment_font'];
                    $box1_font = $data['boxstyle1_font'];
                    $box2_font = $data['boxstyle2_font'];
                    $box3_font = $data['boxstyle3_font'];
                }
                $query->closeCursor();
                
                $array_title_font = split_string($title_font, '$');
                $array_intro_font = split_string($intro_font, '$');
                $array_desc_font = split_string($desc_font, '$');
                $array_subtitle_font = split_string($subtitle_font, '$');
                $array_main_font = split_string($main_font, '$');
                $array_com_font = split_string($com_font, '$');
                $array_box1_font = split_string($box1_font, '$');
                $array_box2_font = split_string($box2_font, '$');
                $array_box3_font = split_string($box3_font, '$');
                
?>
                <option value="<?php echo($title_font); ?>" <?php if($defaultfont_box == $title_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_title_font[0]); ?>;
                               font-weight: <?php echo($array_title_font[1]); ?>;
                               color: <?php echo($array_title_font[2]); ?>;
                               text-decoration: <?php echo($array_title_font[3]); ?>;
                               text-align: <?php echo($array_title_font[4]); ?>;
                               font-family: <?php echo($array_title_font[5]); ?>;">Titre</option>
                <option value="<?php echo($intro_font); ?>" <?php if($defaultfont_box == $intro_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_intro_font[0]); ?>;
                               font-weight: <?php echo($array_intro_font[1]); ?>;
                               color: <?php echo($array_intro_font[2]); ?>;
                               text-decoration: <?php echo($array_intro_font[3]); ?>;
                               text-align: <?php echo($array_intro_font[4]); ?>;
                               font-family: <?php echo($array_intro_font[5]); ?>;">Introduction</option>
                <option value="<?php echo($desc_font); ?>" <?php if($defaultfont_box == $desc_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_desc_font[0]); ?>;
                               font-weight: <?php echo($array_desc_font[1]); ?>;
                               color: <?php echo($array_desc_font[2]); ?>;
                               text-decoration: <?php echo($array_desc_font[3]); ?>;
                               text-align: <?php echo($array_desc_font[4]); ?>;
                               font-family: <?php echo($array_desc_font[5]); ?>;">Description</option>
                <option value="<?php echo($subtitle_font); ?>" <?php if($defaultfont_box == $subtitle_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_subtitle_font[0]); ?>;
                               font-weight: <?php echo($array_subtitle_font[1]); ?>;
                               color: <?php echo($array_subtitle_font[2]); ?>;
                               text-decoration: <?php echo($array_subtitle_font[3]); ?>;
                               text-align: <?php echo($array_subtitle_font[4]); ?>;
                               font-family: <?php echo($array_subtitle_font[5]); ?>;">Sous-titre</option>
                <option value="<?php echo($main_font); ?>" <?php if($defaultfont_box == $main_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_main_font[0]); ?>;
                               font-weight: <?php echo($array_main_font[1]); ?>;
                               color: <?php echo($array_main_font[2]); ?>;
                               text-decoration: <?php echo($array_main_font[3]); ?>;
                               text-align: <?php echo($array_main_font[4]); ?>;
                               font-family: <?php echo($array_main_font[5]); ?>;">Texte</option>
                <option value="<?php echo($com_font); ?>" <?php if($defaultfont_box == $com_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_com_font[0]); ?>;
                               font-weight: <?php echo($array_com_font[1]); ?>;
                               color: <?php echo($array_com_font[2]); ?>;
                               text-decoration: <?php echo($array_com_font[3]); ?>;
                               text-align: <?php echo($array_com_font[4]); ?>;
                               font-family: <?php echo($array_com_font[5]); ?>;">Commentaire</option>
                <option value="<?php echo($box1_font); ?>" <?php if($defaultfont_box == $box1_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_box1_font[0]); ?>;
                               font-weight: <?php echo($array_box1_font[1]); ?>;
                               color: <?php echo($array_box1_font[2]); ?>;
                               text-decoration: <?php echo($array_box1_font[3]); ?>;
                               text-align: <?php echo($array_box1_font[4]); ?>;
                               font-family: <?php echo($array_box1_font[5]); ?>;">Boxstyle1</option>
                <option value="<?php echo($box2_font); ?>" <?php if($defaultfont_box == $box2_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_box2_font[0]); ?>;
                               font-weight: <?php echo($array_box2_font[1]); ?>;
                               color: <?php echo($array_box2_font[2]); ?>;
                               text-decoration: <?php echo($array_box2_font[3]); ?>;
                               text-align: <?php echo($array_box2_font[4]); ?>;
                               font-family: <?php echo($array_box2_font[5]); ?>;">Boxstyle2</option>
                <option value="<?php echo($box3_font); ?>" <?php if($defaultfont_box == $box3_font){ echo('selected'); }else{ echo(null); } ?>
                        style="font-size: <?php echo($array_box3_font[0]); ?>;
                               font-weight: <?php echo($array_box3_font[1]); ?>;
                               color: <?php echo($array_box3_font[2]); ?>;
                               text-decoration: <?php echo($array_box3_font[3]); ?>;
                               text-align: <?php echo($array_box3_font[4]); ?>;
                               font-family: <?php echo($array_box3_font[5]); ?>;">Boxstyle3</option>
<?php                
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

        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_blocktitle_box', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboBlockTitleBox">
                <option value="" <?php if(empty($blocktitle_box)){ echo('selected'); }else{ echo(null); } ?>>Aucun</option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM style_block';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('template', $id_template);
                $query->execute();


                
                while($data = $query->fetch())
                {
                    $id_block = $data['id_block'];
        
                    $name_block = $data['name_block'];
                    $border_block = $data['border_block'];
                    $bordercolor_block = $data['bordercolor_block'];
                    $borderradius_lt_block = $data['borderradius_lt_block'];
                    $borderradius_rt_block = $data['borderradius_rt_block'];
                    $borderradius_rb_block = $data['borderradius_rb_block'];
                    $borderradius_lb_block = $data['borderradius_lb_block'];
                    $bgcolor_block = $data['bgcolor_block'];
                    $width_block = $data['width_block'];
                    $height_block = $data['height_block'];
                    $padding_block = $data['padding_block'];
                    $image_block = $data['image_block'];
                    
                    if($width_block == '0')
                    {
                       $width_block = '100%';
                    }
                    else
                    {
                       $width_block = $width_block.'px'; 
                    }

                    if($height_block == 0)
                    {
                       $height_block = 'auto';
                    }
                    else
                    {
                       $height_block = $height_block.'px'; 
                    }
                    
?>
                    <option value="<?php echo($id_block); ?>" <?php if($blocktitle_box == $id_block){ echo('selected'); }else{ echo(null); } ?>
                        style="border: <?php echo($border_block.'px solid'); ?>;
                               border-color: <?php echo($bordercolor_block); ?>;
                               border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               -moz-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               -webkit-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               background-color: <?php echo($bgcolor_block); ?>;
                               width: <?php echo($width_block); ?>;
                               height: <?php echo($height_block); ?>;
                               padding: <?php echo($padding_block); ?>;
                               background-image: url('<?php echo($image_block); ?>');"><?php echo($name_block); ?></option>
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
        
        <tr></tr>

        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_blockcontent_box', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <select name="cboBlockContentBox">
                <option value="" <?php if(empty($blockcontent_box)){ echo('selected'); }else{ echo(null); } ?>>Aucun</option>
<?php
            try
            {
                $prepared_query = 'SELECT * FROM style_block';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('template', $id_template);
                $query->execute();

                while($data = $query->fetch())
                {
                    $id_block = $data['id_block'];
        
                    $name_block = $data['name_block'];
                    $border_block = $data['border_block'];
                    $bordercolor_block = $data['bordercolor_block'];
                    $borderradius_lt_block = $data['borderradius_lt_block'];
                    $borderradius_rt_block = $data['borderradius_rt_block'];
                    $borderradius_rb_block = $data['borderradius_rb_block'];
                    $borderradius_lb_block = $data['borderradius_lb_block'];
                    $bgcolor_block = $data['bgcolor_block'];
                    $width_block = $data['width_block'];
                    $height_block = $data['height_block'];
                    $padding_block = $data['padding_block'];
                    $image_block = $data['image_block'];
                    
                    if($width_block == '0')
                    {
                       $width_block = '100%';
                    }
                    else
                    {
                       $width_block = $width_block.'px'; 
                    }

                    if($height_block == 0)
                    {
                       $height_block = 'auto';
                    }
                    else
                    {
                       $height_block = $height_block.'px'; 
                    }
                    
?>
                    <option value="<?php echo($id_block); ?>" <?php if($blockcontent_box == $id_block){ echo('selected'); }else{ echo(null); } ?>
                        style="border: <?php echo($border_block.'px solid'); ?>;
                               border-color: <?php echo($bordercolor_block); ?>;
                               border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               -moz-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               -webkit-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px '.$borderradius_lt_block.'px'); ?>;
                               background-color: <?php echo($bgcolor_block); ?>;
                               width: <?php echo($width_block); ?>;
                               height: <?php echo($height_block); ?>;
                               padding: <?php echo($padding_block); ?>;
                               background-image: url('<?php echo($image_block); ?>');"><?php echo($name_block); ?></option>
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
        
        <tr></tr>
        
        <td></td>
        <td>
            <input type="submit" name="bt_save_main_box" value="<?php give_translation('edit_structure.main_bt_save_box', '', $config_showtranslationcode); ?>"></input>
        </td>
        
</table></td>




