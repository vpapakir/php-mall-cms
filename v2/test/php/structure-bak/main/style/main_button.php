<?php
try
{
    $prepared_query = 'SELECT * FROM style_button
                       WHERE id_button = :button';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('button', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_button = $data['id_button'];
        
        $name_button = $data['name_button'];
        $family_button = $data['family_button'];
        $size_button = $data['size_button'];
        $weight_button = $data['weight_button'];
        $color_button = $data['color_button'];
        $align_button = $data['align_button'];
        $border_button = $data['border_button'];
        $bordercolor_button = $data['bordercolor_button'];
        $borderradius_lt_button = $data['borderradius_lt_button'];
        $borderradius_rt_button = $data['borderradius_rt_button'];
        $borderradius_rb_button = $data['borderradius_rb_button'];
        $borderradius_lb_button = $data['borderradius_lb_button'];
        $bgcolor_button = $data['bgcolor_button'];
        $width_button = $data['width_button'];
        $height_button = $data['height_button'];
        $padding_button = $data['padding_button'];
        $image_button = $data['image_button'];
    }
    $query->closeCursor();
    
    $family_button = split_string($family_button, '$');
    $size_button = split_string($size_button, '$');
    $weight_button = split_string($weight_button, '$');
    $color_button = split_string($color_button, '$');
    $align_button = split_string($align_button, '$');
    $border_button = split_string($border_button, '$');
    $bordercolor_button = split_string($bordercolor_button, '$');
    $borderradius_lt_button = split_string($borderradius_lt_button, '$');
    $borderradius_rt_button = split_string($borderradius_rt_button, '$');
    $borderradius_rb_button = split_string($borderradius_rb_button, '$');
    $borderradius_lb_button = split_string($borderradius_lb_button, '$');
    $bgcolor_button = split_string($bgcolor_button, '$');
    $width_button = split_string($width_button, '$');
    $height_button = split_string($height_button, '$');
    $padding_button = split_string($padding_button, '$');
    $image_button = split_string($image_button, '$');
    
    for($i = 0, $count = count($width_button); $i < $count; $i++)
    {
        if($width_button[$i] == 0)
        {
           $width_button[$i] = 'auto';
        }
        else
        {
           $width_button[$i] = $width_button[$i].'px'; 
        }
    }
    
    for($i = 0, $count = count($height_button); $i < $count; $i++)
    {
        if($height_button[$i] == 0)
        {
           $height_button[$i] = 'auto';
        }
        else
        {
           $height_button[$i] = $height_button[$i].'px'; 
        }
    }
    
    $_SESSION['structure_edit_id_element'] = $id_button;
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
            <?php give_translation('edit_structure.subtitle_name_element', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main" width="60%">
            <input type="text" name="txtNameButton" value="<?php echo($name_button); ?>"></input>
            <br clear="left">
            <div>
<?php 
                if(!empty($_SESSION['msg_structure_edit_main_button_txtNameButton']))
                { 
                    echo(check_session_input($_SESSION['msg_structure_edit_main_button_txtNameButton'])); 
                } 
?>
            </div>
        </td>
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_normal_button', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input style="font-family: <?php echo($family_button[0]); ?>;
                          font-size: <?php echo($size_button[0].'px'); ?>;
                          font-weight: <?php echo($weight_button[0]); ?>;
                          color: <?php echo($color_button[0]); ?>;
                          text-align: <?php echo($align_button[0]); ?>;
                          border: <?php echo($border_button[0].'px solid'); ?>;
                          border-color: <?php echo($bordercolor_button[0]); ?>;
                          border-radius: <?php echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;
                          -moz-border-radius: <?php echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;
                          -webkit-border-radius: <?php echo($borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px '.$borderradius_lt_button[0].'px'); ?>;
                          background-color: <?php echo($bgcolor_button[0]); ?>;
                          width: <?php echo($width_button[0]); ?>;
                          height: <?php echo($height_button[0]); ?>;
                          padding: <?php echo($padding_button[0]); ?>;
                          background-image: url('<?php echo($image_button[0]); ?>');
                          cursor: default;"
                          disabled="true" type="submit" name="preview_button" value="AaBbCcIi0123"></input>
        </td>    
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_hover_button', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input style="font-family: <?php echo($family_button[1]); ?>;
                          font-size: <?php echo($size_button[1].'px'); ?>;
                          font-weight: <?php echo($weight_button[1]); ?>;
                          color: <?php echo($color_button[1]); ?>;
                          text-align: <?php echo($align_button[1]); ?>;
                          border: <?php echo($border_button[1].'px solid'); ?>;
                          border-color: <?php echo($bordercolor_button[1]); ?>;
                          border-radius: <?php echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;
                          -moz-border-radius: <?php echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;
                          -webkit-border-radius: <?php echo($borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px '.$borderradius_lt_button[1].'px'); ?>;
                          background-color: <?php echo($bgcolor_button[1]); ?>;
                          width: <?php echo($width_button[1]); ?>;
                          height: <?php echo($height_button[1]); ?>;
                          padding: <?php echo($padding_button[1]); ?>;
                          background-image: url('<?php echo($image_button[1]); ?>');
                          cursor: default;"
                          disabled="true" type="submit" name="preview_button_hover" value="AaBbCcIi0123"></input>
        </td>    
        
        <tr></tr>
        
        <td class="font_subtitle">
            <?php give_translation('edit_structure.subtitle_active_button', '', $config_showtranslationcode); ?>
        </td>
        <td class="font_main">
            <input style="font-family: <?php echo($family_button[2]); ?>;
                          font-size: <?php echo($size_button[2].'px'); ?>;
                          font-weight: <?php echo($weight_button[2]); ?>;
                          color: <?php echo($color_button[2]); ?>;
                          text-align: <?php echo($align_button[2]); ?>;
                          border: <?php echo($border_button[2].'px solid'); ?>;
                          border-color: <?php echo($bordercolor_button[2]); ?>;
                          border-radius: <?php echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;
                          -moz-border-radius: <?php echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;
                          -webkit-border-radius: <?php echo($borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px '.$borderradius_lt_button[2].'px'); ?>;
                          background-color: <?php echo($bgcolor_button[2]); ?>;
                          width: <?php echo($width_button[2]); ?>;
                          height: <?php echo($height_button[2]); ?>;
                          padding: <?php echo($padding_button[2]); ?>;
                          background-image: url('<?php echo($image_button[2]); ?>');
                          cursor: default;"
                          disabled="true" type="submit" name="preview_button_active" value="AaBbCcIi0123"></input>
        </td>    
        
        <tr></tr>
        
        <td class="font_subtitle">
        
        </td>
        <td class="font_main">
            <input type="submit" name="bt_save_main_button" value="<?php give_translation('edit_structure.main_bt_use', '', $config_showtranslationcode); ?>"></input>
        </td>    
        
</table></td>
