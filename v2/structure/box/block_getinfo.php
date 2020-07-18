<?php
try
{
    $Bok_include_path = false;
    $Bok_include_both = false;
    
    $prepared_query = 'SELECT * FROM structure_box
                       WHERE id_box = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_box_structure);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $blocktitle_box_structure = $data['blocktitle_box'];
        $blockcontent_box_structure = $data['blockcontent_box'];
		$script_path = $data['scriptpath_box'];
        $script_code = $data['scriptcode_box'];
        $default_font = $data['defaultfont_box'];
        $width_box = $data['width_box'].'px';
        $height_box = $data['height_box'].'px';
        $position_box = $data['position_box'];
        $margin_box = $data['margin_box'];
        $border_box = $data['border_box'].'px';
        $bordercolor_box = $data['bordercolor_box'];
        $tablebg_box = $data['tablebg_box'];
        $cs_box = $data['cs_box'];
        $cp_box = $data['cp_box'];
        $bgcolor_box = $data['bgcolor_box'];
        $bgimg_box = $data['bgimg_box'];
        $xrepeat_box = $data['xrepeat_box'];
        $yrepeat_box = $data['yrepeat_box'];
        $id_box_structure = $data['id_box'];
    }
    $query->closeCursor();
    
    if(empty($script_code) || $script_code == 0)
    {
        $include_script = $script_path;
        $Bok_include_path = true;
    }
    else
    {
        $include_script = $script_code;
    }
    
    if(!empty($script_code) && !empty($script_path))
    {
        $Bok_include_both = true;
        
        $include_path = $script_path;
        $include_code = $script_code;
    }
    
    $default_font = split_string($default_font, '$');
    
    if($width_box == '0px')
    {
       $width_box = '100%'; 
    }
     
    
    $prepared_query = 'SELECT * FROM style_block
                       WHERE id_block = :id';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $blocktitle_box_structure);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $border_blocktitle = $data['border_block'];
        $bordercolor_blocktitle = $data['bordercolor_block'];
        $borderradius_lt_blocktitle = $data['borderradius_lt_block'];
        $borderradius_rt_blocktitle = $data['borderradius_rt_block'];
        $borderradius_rb_blocktitle = $data['borderradius_rb_block'];
        $borderradius_lb_blocktitle = $data['borderradius_lb_block'];
        $bgcolor_blocktitle = $data['bgcolor_block'];
        $width_blocktitle = $data['width_block'];
        $height_blocktitle = $data['height_block'];
        $padding_blocktitle = $data['padding_block'];
        $image_blocktitle = $data['image_block'];
        $font_blocktitle = $data['font_block'];
    }
    $query->closeCursor();
    
    if(empty($width_blocktitle) || $width_blocktitle == 0 ? $width_blocktitle = 100 : $width_blocktitle = $width_blocktitle);
    if(empty($height_blocktitle) || $height_blocktitle == 0 ? $height_blocktitle = 'auto' : $height_blocktitle = $height_blocktitle);
    if(empty($padding_blocktitle) ? $padding_blocktitle = 0 : $padding_blocktitle = $padding_blocktitle);
    
    $prepared_query = 'SELECT * FROM style_block
                       WHERE id_block = :id';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $blockcontent_box_structure);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $border_blockcontent = $data['border_block'];
        $bordercolor_blockcontent = $data['bordercolor_block'];
        $borderradius_lt_blockcontent = $data['borderradius_lt_block'];
        $borderradius_rt_blockcontent = $data['borderradius_rt_block'];
        $borderradius_rb_blockcontent = $data['borderradius_rb_block'];
        $borderradius_lb_blockcontent = $data['borderradius_lb_block'];
        $bgcolor_blockcontent = $data['bgcolor_block'];
        $width_blockcontent = $data['width_block'];
        $height_blockcontent = $data['height_block'];
        $padding_blockcontent = $data['padding_block'];
        $image_blockcontent = $data['image_block'];
    }
    $query->closeCursor();
    
    if(empty($width_blockcontent) || $width_blockcontent == 0 ? $width_blockcontent = 100 : $width_blockcontent = $width_blockcontent);
    if(empty($height_blockcontent) || $height_blockcontent == 0 ? $height_blockcontent = 'auto' : $height_blockcontent = $height_blockcontent);
    if(empty($padding_blockcontent) ? $padding_blockcontent = 0 : $padding_blockcontent = $padding_blockcontent);
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

<STYLE>
.block_box_title<?php echo($id_box_structure); ?> , #block_box_title<?php echo($id_box_structure); ?>  
{
<?php
    if(!empty($border_blocktitle))
    {
?>
    border: <?php echo($border_blocktitle.'px solid'); ?>;
<?php
    }
    
    if(!empty($bordercolor_blocktitle))
    {
?>
    border-color: <?php echo($bordercolor_blocktitle); ?>;
<?php
    }
    
    if(!empty($borderradius_lt_blocktitle) 
            || !empty($borderradius_rt_blocktitle)
            || !empty($borderradius_rb_blocktitle)
            || !empty($borderradius_lb_blocktitle))
    {
        if(empty($borderradius_lt_blocktitle) ? $borderradius_lt_blocktitle = 0 : $borderradius_lt_blocktitle = $borderradius_lt_blocktitle);
        if(empty($borderradius_rt_blocktitle) ? $borderradius_rt_blocktitle = 0 : $borderradius_rt_blocktitle = $borderradius_rt_blocktitle);
        if(empty($borderradius_rb_blocktitle) ? $borderradius_rb_blocktitle = 0 : $borderradius_rb_blocktitle = $borderradius_rb_blocktitle);
        if(empty($borderradius_lb_blocktitle) ? $borderradius_lb_blocktitle = 0 : $borderradius_lb_blocktitle = $borderradius_lb_blocktitle);
?>
    border-radius: <?php echo($borderradius_lt_blocktitle.'px '.$borderradius_rt_blocktitle.'px '.$borderradius_rb_blocktitle.'px '.$borderradius_lb_blocktitle.'px'); ?>;
/*    -moz-border-radius: <?php //echo($borderradius_lt_blocktitle.'px '.$borderradius_rt_blocktitle.'px '.$borderradius_rb_blocktitle.'px '.$borderradius_lb_blocktitle.'px'); ?>;*/
    -webkit-border-radius: <?php echo($borderradius_lt_blocktitle.'px '.$borderradius_rt_blocktitle.'px '.$borderradius_rb_blocktitle.'px '.$borderradius_lb_blocktitle.'px'); ?>;
<?php
    }
    
    if(!empty($bgcolor_blocktitle))
    {
?>
    background-color: <?php echo($bgcolor_blocktitle); ?>;
<?php
    }
    
    if(!empty($width_blocktitle))
    {
?>
    width: <?php echo($width_blocktitle); if($width_blocktitle == 100){ echo('%'); }else{ echo('px'); }?>;
<?php
    }
    
    if(!empty($height_blocktitle))
    {
?>
    height: <?php if($height_blocktitle == 0 || $height_blocktitle == 'auto'){ echo('auto'); }else{ echo($height_blocktitle.'px'); }?>;
<?php
    }
    
    if(!empty($image_blocktitle))
    {
?>
        background-image: url('<?php echo($image_blocktitle); ?>');
<?php
    }
?>
    padding: <?php echo($padding_blocktitle); ?>px;
}

.block_box_content<?php echo($id_box_structure); ?>, #block_box_content<?php echo($id_box_structure); ?>  
{
<?php
    if(!empty($border_blockcontent))
    {
?>
    border: <?php echo($border_blockcontent.'px solid'); ?>;
<?php
    }
    
    if(!empty($bordercolor_blockcontent))
    {
?>
    border-color: <?php echo($bordercolor_blockcontent); ?>;
<?php
    }
    
    if(!empty($borderradius_lt_blockcontent) 
            || !empty($borderradius_rt_blockcontent)
            || !empty($borderradius_rb_blockcontent)
            || !empty($borderradius_lb_blockcontent))
    {
        if(empty($borderradius_lt_blockcontent) ? $borderradius_lt_blockcontent = 0 : $borderradius_lt_blockcontent = $borderradius_lt_blockcontent);
        if(empty($borderradius_rt_blockcontent) ? $borderradius_rt_blockcontent = 0 : $borderradius_rt_blockcontent = $borderradius_rt_blockcontent);
        if(empty($borderradius_rb_blockcontent) ? $borderradius_rb_blockcontent = 0 : $borderradius_rb_blockcontent = $borderradius_rb_blockcontent);
        if(empty($borderradius_lb_blockcontent) ? $borderradius_lb_blockcontent = 0 : $borderradius_lb_blockcontent = $borderradius_lb_blockcontent);
?>
    border-radius: <?php echo($borderradius_lt_blockcontent.'px '.$borderradius_rt_blockcontent.'px '.$borderradius_rb_blockcontent.'px '.$borderradius_lb_blockcontent.'px'); ?>;
/*    -moz-border-radius: <?php //echo($borderradius_lt_blockcontent.'px '.$borderradius_rt_blockcontent.'px '.$borderradius_rb_blockcontent.'px '.$borderradius_lb_blockcontent.'px'); ?>;*/
    -webkit-border-radius: <?php echo($borderradius_lt_blockcontent.'px '.$borderradius_rt_blockcontent.'px '.$borderradius_rb_blockcontent.'px '.$borderradius_lb_blockcontent.'px'); ?>;
<?php
    }
    
    if(!empty($bgcolor_blockcontent))
    {
?>
    background-color: <?php echo($bgcolor_blockcontent); ?>;
<?php
    }
    
    if(!empty($width_blockcontent))
    {
?>
    width: <?php echo($width_blockcontent); if($width_blockcontent == 100){ echo('%'); }else{ echo('px'); }?>;
<?php
    }
    
    if(!empty($height_blockcontent))
    {
?>
    height: <?php if($height_blockcontent == 0 || $height_blockcontent == 'auto'){ echo('auto'); }else{ echo($height_blockcontent.'px'); } ?>;
<?php
    }
    
    if(!empty($image_blockcontent))
    {
?>
        background-image: url('<?php echo($image_blockcontent); ?>');
<?php
    }
?>
    padding: <?php echo($padding_blockcontent); ?>px;
}
    
</STYLE>    
