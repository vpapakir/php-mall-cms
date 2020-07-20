<?php
try
{ 
    
    $prepared_query = 'SELECT * FROM structure_frame
                               WHERE id_frame = :id_frame
                               AND id_layout = :id_layout';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'id_frame' => $array_id_frame[0],
                          'id_layout' => $id_layout
                          ));
    
    if(($data = $query->fetch()) != false)
    {
        $name_frame = $data['name_frame'];
        $width_frame = $data['width_frame'].'px';
        $height_frame = $data['height_frame'].'px';
        $position_frame = $data['position_frame'];
        $margin_frame = $data['margin_frame'];
        $border_frame = $data['border_frame'].'px';
        $bordercolor_frame = $data['bordercolor_frame'];
        $tablebg_frame = $data['tablebg_frame'];
        $cs_frame = $data['cs_frame'];
        $cp_frame = $data['cp_frame'];
        $bgcolor_frame = $data['bgcolor_frame'];
        $bgimg_frame = $data['bgimg_frame'];
        $xrepeat_frame = $data['xrepeat_frame'];
        $yrepeat_frame = $data['yrepeat_frame'];
        $id_layout = $data['id_layout'];
        $id_box = $data['id_box'];
    }
    $query->closeCursor();
    
    if($width_frame == '0px')
    {
        $width_frame = '100%';
    }
    
    if($height_frame == '0px')
    {
        $height_frame = '100%';
    }
    
    if($bgcolor_frame == null)
    {
       $bgcolor_frame = 'white'; 
    }
    
    if($position_frame == 0)
    {
       $position_frame = 'relative'; 
    }
    
    if($margin_frame == 0)
    {
        $margin_frame = 'auto';
    }
    
    if($width_frame != '0px')
    {
        $widthmax_frame_image = $width_frame - 32;
    }
    
    $array_box = split_number($id_box);
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
    /*if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
    }*/
}
?>


<?php
if($array_box[0] != null && $array_box[0] != 0)
{
    for($i = 0; $i < count($array_box); $i++)
    {
        
        
        if($i == 0)
        {
?>
           <table style="width: <?php echo($width_frame); ?>; height: <?php echo($height_frame); ?>; 
                  border: <?php echo($border_frame.' solid '.$bordercolor_frame); ?>;
                  position: <?php echo($position_frame); ?>; margin: <?php echo($margin_frame); ?>;" 
                  cellpadding="<?php echo($cp_frame); ?>" cellspacing="<?php echo($cs_frame); ?>">                 
<?php 
        }
        
        if($i > 0 && $i < count($array_box))
        {
?>
           <tr style="height: 4px;">
<?php           
        } 
        
        
        try
        { 

            $prepared_query = 'SELECT * FROM structure_box
                                   WHERE id_box = :id_box
                                   AND id_frame LIKE \'%'.$array_id_frame[0].'%\'';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id_box', $array_box[$i]);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $id_box = $data['id_box'];
                $name_box = $data['name_box'];
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
                //$id_layout = $data['id_frame'];
                //$id_box = $data['id_layout'];
            }
            $query->closeCursor();

            if($width_box == '0px')
            {
                $width_box = '100%';
            }

            if($height_box == '0px')
            {
                $height_box = '1px';
            }

            if($bgcolor_box == null)
            {
               $bgcolor_box = 'white'; 
            }

            if($position_box == 0)
            {
               $position_box = 'relative'; 
            }

            if($margin_box == 0)
            {
                $margin_box = 'auto';
            }

            //$array_box = split_number($id_box);
        }
        catch(Exception $e)
        {
            $_SESSION['error400_message'] = $e->getMessage();
            /*if($_SESSION['index'] == 'index.php')
            {
                die(header('Location: '.$config_customheader.'Error/400'));
            }
            else
            {
                die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
            }*/
        }
?> 
            <td style="background-color: <?php echo($tablebg_frame); ?>; vertical-align: top;">           
            <table style="width: <?php echo($width_box); ?>; height: <?php echo($height_box); ?>; 
                   border: <?php echo($border_box.' solid '.$bordercolor_box); ?>;
                   position: <?php echo($position_box); ?>; margin: <?php echo($margin_box); ?>;
                   background-color: <?php echo($tablebg_box); ?>" 
                   cellpadding="<?php echo($cp_box); ?>" cellspacing="<?php echo($cs_box); ?>">

<?php
                   include('structure/box/'.$id_box.'.php');
?>
            
            </table>
            </td>
           
        
<?php
        if($i >= (count($array_box) - 1))
        {
?>
           </tr> 
           </table>
<?php
        }
    }
}
?>
