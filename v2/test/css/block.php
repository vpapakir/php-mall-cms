<?php
try
{
    $prepared_query = 'SELECT * 
                       FROM style_block AS block
                       INNER JOIN structure_template AS temp
                       ON block.id_template = temp.id_template
                       WHERE status_template = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
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
    }
    $query->closeCursor();

    if($width_block == 0 || empty($width_block))
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
    
    if(empty($padding_block))
    {
        $padding_block = '0px';
    }
    else
    {
        $padding_block = $padding_block.'px';
    }
    
}
catch(Exception $e)
{
    $_SESSION['error4_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/4'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/4'));
    }
}

?>
<STYLE type="text/css">
.block, .block_result, #block, #block_result
{
    border: <?php echo($border_block.'px solid'); ?>;
    border-color: <?php echo($bordercolor_block); ?>;
    border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    background-color: <?php echo($bgcolor_block); ?>;
    width: <?php echo($width_block); ?>;
    height: <?php echo($height_block); ?>;
    padding: <?php echo($padding_block); ?>;
<?php
    if(!empty($image_block))
    {
?>
    background-image: url('<?php echo($image_block); ?>');
<?php
    }
?>
}

.block_result:hover, #block_result:hover
{
    border: <?php echo($border_block.'px solid'); ?>;
    border-color: <?php echo($bordercolor_block); ?>;
    border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    -moz-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    -webkit-border-radius: <?php echo($borderradius_lt_block.'px '.$borderradius_rt_block.'px '.$borderradius_rb_block.'px '.$borderradius_lb_block.'px'); ?>;
    background-color: <?php echo('#E8EEFF'); ?>;
    width: <?php echo($width_block); ?>;
    height: <?php echo($height_block); ?>;
    padding: <?php echo($padding_block); ?>;
<?php
    if(!empty($image_block))
    {
?>
    background-image: url('<?php echo($image_block); ?>');
<?php
    }
?>       
}
</STYLE>
