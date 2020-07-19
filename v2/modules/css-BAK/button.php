<?php
try
{
    $prepared_query = 'SELECT * 
                       FROM style_button AS button
                       INNER JOIN structure_template AS temp
                       ON button.id_template = temp.id_template
                       WHERE status_template = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_button_css = $data['id_button'];
        
        $name_button_css = $data['name_button'];
        $family_button_css = $data['family_button'];
        $size_button_css = $data['size_button'];
        $weight_button_css = $data['weight_button'];
        $color_button_css = $data['color_button'];
        $align_button_css = $data['align_button'];
        $border_button_css = $data['border_button'];
        $bordercolor_button_css = $data['bordercolor_button'];
        $borderradius_lt_button_css = $data['borderradius_lt_button'];
        $borderradius_rt_button_css = $data['borderradius_rt_button'];
        $borderradius_rb_button_css = $data['borderradius_rb_button'];
        $borderradius_lb_button_css = $data['borderradius_lb_button'];
        $bgcolor_button_css = $data['bgcolor_button'];
        $width_button_css = $data['width_button'];
        $height_button_css = $data['height_button'];
        $padding_button_css = $data['padding_button'];
        $image_button_css = $data['image_button'];
    }
    $query->closeCursor();
    
    $family_button_css = split_string($family_button_css, '$');
    $size_button_css = split_string($size_button_css, '$');
    $weight_button_css = split_string($weight_button_css, '$');
    $color_button_css = split_string($color_button_css, '$');
    $align_button_css = split_string($align_button_css, '$');
    $border_button_css = split_string($border_button_css, '$');
    $bordercolor_button_css = split_string($bordercolor_button_css, '$');
    $borderradius_lt_button_css = split_string($borderradius_lt_button_css, '$');
    $borderradius_rt_button_css = split_string($borderradius_rt_button_css, '$');
    $borderradius_rb_button_css = split_string($borderradius_rb_button_css, '$');
    $borderradius_lb_button_css = split_string($borderradius_lb_button_css, '$');
    $bgcolor_button_css = split_string($bgcolor_button_css, '$');
    $width_button_css = split_string($width_button_css, '$');
    $height_button_css = split_string($height_button_css, '$');
    $padding_button_css = split_string($padding_button_css, '$');
    $image_button_css = split_string($image_button_css, '$');
    
    for($i = 0, $count = count($width_button_css); $i < $count; $i++)
    {
        if($width_button_css[$i] == 0)
        {
           $width_button_css[$i] = 'auto';
        }
        else
        {
           $width_button_css[$i] = $width_button_css[$i].'px'; 
        }
    }
    
    for($i = 0, $count = count($height_button_css); $i < $count; $i++)
    {
        if($height_button_css[$i] == 0)
        {
           $height_button_css[$i] = 'auto';
        }
        else
        {
           $height_button_css[$i] = $height_button_css[$i].'px'; 
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
<STYLE type="text/css">
input[type=submit], .link_input, .navtab, #link_input, #navtab
{
    font-family: <?php echo($family_button_css[0]); ?>;
    font-size: <?php echo($size_button_css[0].'px'); ?>;
    font-weight: <?php echo($weight_button_css[0]); ?>;
    color: <?php echo($color_button_css[0]); ?>;
    text-align: <?php echo($align_button_css[0]); ?>;
    border: <?php echo($border_button_css[0].'px solid'); ?>;
    border-color: <?php echo($bordercolor_button_css[0]); ?>;
    border-radius: <?php echo($borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px '.$borderradius_lt_button_css[0].'px'); ?>;
    background-color: <?php echo($bgcolor_button_css[0]); ?>;
    width: <?php echo($width_button_css[0]); ?>;
    height: <?php echo($height_button_css[0]); ?>;
    padding: <?php echo($padding_button_css[0].'px'); ?>;
    background-image: url('<?php echo($image_button_css[0]); ?>');
    cursor: pointer;
}

input[type=submit]:hover, .link_input:hover, .navtab:hover, #link_input:hover, #navtab:hover
{
    font-family: <?php echo($family_button_css[1]); ?>;
    font-size: <?php echo($size_button_css[1].'px'); ?>;
    font-weight: <?php echo($weight_button_css[1]); ?>;
    color: <?php echo($color_button_css[1]); ?>;
    text-align: <?php echo($align_button_css[1]); ?>;
    border: <?php echo($border_button_css[1].'px solid'); ?>;
    border-color: <?php echo($bordercolor_button_css[1]); ?>;
    border-radius: <?php echo($borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px '.$borderradius_lt_button_css[1].'px'); ?>;
    background-color: <?php echo($bgcolor_button_css[1]); ?>;
    width: <?php echo($width_button_css[1]); ?>;
    height: <?php echo($height_button_css[1]); ?>;
    padding: <?php echo($padding_button_css[1].'px'); ?>;
    background-image: url('<?php echo($image_button_css[1]); ?>');
    cursor: pointer;
}

input[type=submit]:active, .link_input:active, .navtab:active, #link_input:active, #navtab:active, #navtab_selected
{
    font-family: <?php echo($family_button_css[2]); ?>;
    font-size: <?php echo($size_button_css[2].'px'); ?>;
    font-weight: <?php echo($weight_button_css[2]); ?>;
    color: <?php echo($color_button_css[2]); ?>;
    text-align: <?php echo($align_button_css[2]); ?>;
    border: <?php echo($border_button_css[2].'px solid'); ?>;
    border-color: <?php echo($bordercolor_button_css[2]); ?>;
    border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px'); ?>;
    background-color: <?php echo($bgcolor_button_css[2]); ?>;
    width: <?php echo($width_button_css[2]); ?>;
    height: <?php echo($height_button_css[2]); ?>;
    padding: <?php echo($padding_button_css[2].'px'); ?>;
    background-image: url('<?php echo($image_button_css[2]); ?>');
    cursor: pointer;
}

.navtab, .navtab:hover, .navtab:active, .navtab_selected, #navtab, #navtab:hover, #navtab:active, #navtab_selected
{
    border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px 0px 0px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px 0px 0px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_button_css[2].'px '.$borderradius_lt_button_css[2].'px 0px 0px'); ?>;
}

</STYLE>
