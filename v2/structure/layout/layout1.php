<?php
try
{ 
    
    $prepared_query = 'SELECT * FROM structure_layout
                       WHERE id_layout = :id_layout';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_layout', $id_layout);   
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_layout = $data['name_layout'];
        $width_layout = $data['width_layout'].'px';
        $height_layout = $data['height_layout'].'px';
        $position_layout = $data['position_layout'];
        $margin_layout = $data['margin_layout'];
        $border_layout = $data['border_layout'].'px';
        $bordercolor_layout = $data['bordercolor_layout'];
        $tablebg_layout = $data['tablebg_layout'];
        $cs_layout = $data['cs_layout'];
        $cp_layout = $data['cp_layout'];
        $bgcolor_layout = $data['bgcolor_layout'];
        $bgimg_layout = $data['bgimg_layout'];
        $xrepeat_layout = $data['xrepeat_layout'];
        $yrepeat_layout = $data['yrepeat_layout'];
        $radius_layout = $data['radius_layout'];
        $id_frame = $data['id_frame'];
        
        $heightpart_layout = $data['heightpart_layout'];
        
        $id_image_layout_top = $data['id_image_top'];
        $id_image_layout_middle = $data['id_image_middle'];
        $id_image_layout_bottom = $data['id_image_bottom'];
    }
    $query->closeCursor();
    
    $heightpart_layout = split_string($heightpart_layout, '$');
    
    $height_layout_top = $heightpart_layout[0];
    $height_layout_middle = $heightpart_layout[1];
    $height_layout_bottom = $heightpart_layout[2];
    
    #top
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_layout_top);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_layout_top = $data['path_image'];
       $alt_layout_top = $data['alt_image'];
       $title_layout_top = $data['title_image'];
       $repeat_layout_top = $data['repeat_image'];
       $attachment_layout_top = $data['attachment_image'];
    }
    $query->closeCursor();
    
    #middle
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_layout_middle);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_layout_middle = $data['path_image'];
       $alt_layout_middle = $data['alt_image'];
       $title_layout_middle = $data['title_image'];
       $repeat_layout_middle = $data['repeat_image'];
       $attachment_layout_middle = $data['attachment_image'];
    }
    $query->closeCursor();
    
    #bottom
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_layout_bottom);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_layout_bottom = $data['path_image'];
       $alt_layout_bottom = $data['alt_image'];
       $title_layout_bottom = $data['title_image'];
       $repeat_layout_bottom = $data['repeat_image'];
       $attachment_layout_bottom = $data['attachment_image'];
    }
    $query->closeCursor();
    
    if($width_layout == '0px')
    {
        $width_layout = '100%';
    }
    
    if($height_layout == '0px')
    {
        $height_layout = '100%';
    }
    
    if($bgcolor_layout == null)
    {
       $bgcolor_layout = 'white'; 
    }
    
    if($position_layout == 0)
    {
       $position_layout = 'relative'; 
    }
    
    if($margin_layout == 0)
    {
        $margin_layout = 'auto';
    }
    
    $radius_layout = split_string($radius_layout, '$');
    $array_id_frame = split_number($id_frame);
    
    $prepared_query = 'SELECT status_frame, type_frame FROM structure_frame
                       WHERE id_layout = :id_layout';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_layout', $id_layout);   
    $query->execute();
    
    $i= 0;
    
    while($data = $query->fetch())
    {
        $status_frame_layout[$i] = $data[0];
        $i++;
    }
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
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
<table id="tbl_layout_01" style="width: <?php echo($width_layout); ?>; height: <?php echo($height_layout); ?>; 
       border: <?php echo($border_layout.' solid '.$bordercolor_layout); ?>;
       position: <?php echo($position_layout); ?>; margin: <?php echo($margin_layout); ?>;
       <?php if(!empty($bgcolor_layout)){ ?>background-color: <?php echo($bgcolor_layout); ?>;<?php } ?>
       border-radius: <?php echo($radius_layout[0].'px '.$radius_layout[1].'px '.$radius_layout[2].'px '.$radius_layout[3].'px'); ?>;
       -webkit-border-radius: <?php echo($radius_layout[0].'px '.$radius_layout[1].'px '.$radius_layout[2].'px '.$radius_layout[3].'px'); ?>;" 
       cellpadding="<?php echo($cp_layout); ?>" cellspacing="<?php echo($cs_layout); ?>" border="0">
        
        <tr>
        <td colspan="3" style="height: <?php echo($height_layout_top); ?>px;
                               <?php if(!empty($repeat_layout_top)){ ?>background-repeat: <?php echo($repeat_layout_top); ?>;<?php } ?>
                               <?php if(!empty($attachment_layout_top)){ ?>background-attachment: <?php echo($attachment_layout_top); ?>;<?php } ?>"></td>
        </tr>
        
        <tr>       
        <td><table width="100%" style="height: <?php echo($height_layout_middle); ?>px;
                                       <?php if(!empty($attachment_layout_middle)){ ?>background-attachment: <?php echo($attachment_layout_middle); ?>;<?php } ?>" cellpadding="0" cellspacing="0">

<?php
    if($status_frame_layout[1] == 1)
    {
?>
        <tr>        
        <td colspan="3" style="vertical-align: top;">
<?php
            include('structure/frame/header/header1.php');
?>
        </td>
    
        </tr>
    
<?php
    }
    
    if($status_frame_layout[2] == 1)
    {
?>
        <tr>
        <td id="structure/frame/navbar/navbar1.php" colspan="3" style="vertical-align: top;">
<?php
            include('structure/frame/navbar/navbar1.php');
?>        
        </td>

        </tr>
    
<?php
    }
?>
        <tr>
<?php        
    if($status_frame_layout[3] == 1)
    {
?>    
        
        <td id="structure/frame/left/left1.php" style="vertical-align: top;">
<?php
            include('structure/frame/left/left1.php');
?>
        </td>
    
<?php
    }
    
    if($status_frame_layout[0] == 1)
    {
?>     
        <td id="structure/frame/main/main1.php" style="vertical-align: top;">
<?php
            include('structure/frame/main/main1.php');
?>
        </td>   
<?php
    }
    
    if($status_frame_layout[4] == 1)
    {
?>    
        
        <td id="structure/frame/right/right1.php" style="vertical-align: top;">
<?php
            include('structure/frame/right/right1.php');
?>
        </td>
<?php
    }
?>
        </tr>
    </table></td>   
    </tr>
    
    <tr>
    <td colspan="3" style="height: <?php echo($height_layout_bottom); ?>px;
                           <?php if(!empty($attachment_layout_bottom)){ ?>background-attachment: <?php echo($attachment_layout_bottom); ?>;<?php } ?>"></td>   
    </tr>
</table>       
