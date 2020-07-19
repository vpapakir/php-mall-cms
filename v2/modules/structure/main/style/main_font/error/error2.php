<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_font_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboError2FamilyFont">
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
                        <?php if($error2_font[5] == $data['family_fonts']){ echo('selected'); }else{ echo(null); } ?>
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
            die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
        } 
    }
?>                
    </select>
</td>

<tr></tr>         

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_size_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <input type="text" name="txtError2SizeFont" value="<?php echo($error2_font[0]); ?>"></input>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_weight_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboError2WeightFont">
        <option style="font-weight: normal;" value="normal" <?php if($error2_font[1] == 'normal'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_normal', '', $config_showtranslationcode); ?></option>
        <option style="font-weight: bold;" value="bold" <?php if($error2_font[1] == 'bold'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_weight_bold', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_color_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main" onchange="onchange_color('cboError2ColorFont', 'Error2ColorFont');">
    <?php dropdown_color('cboError2ColorFont', $error2_font[2], 'Error2ColorFont'); ?>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_underline_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboError2DecorationFont">
        <option style="text-decoration: none;" value="none" <?php if($error2_font[3] == 'none'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_no', '', $config_showtranslationcode); ?></option>
        <option style="text-decoration: underline;" value="underline" <?php if($error2_font[3] == 'underline'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_yes', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr></tr>

<td class="font_subtitle">
    <?php give_translation('edit_structure.main_error2_font', '', $config_showtranslationcode); ?> <?php give_translation('edit_structure.subtitle_align_font', '', $config_showtranslationcode); ?>
</td>
<td class="font_main">
    <select name="cboError2AlignFont">
        <option style="text-align: left;" value="left" <?php if($error2_font[4] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_left', '', $config_showtranslationcode); ?></option>
        <option style="text-align: center;" value="center" <?php if($error2_font[4] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_center', '', $config_showtranslationcode); ?></option>
        <option style="text-align: right;" value="right" <?php if($error2_font[4] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_right', '', $config_showtranslationcode); ?></option>
        <option style="text-align: justify;" value="justify" <?php if($error2_font[4] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('main.dd_textalign_justify', '', $config_showtranslationcode); ?></option>
    </select>
</td>

<tr><td colspan="2"><hr style="color: lightgray;"></hr></td></tr>
