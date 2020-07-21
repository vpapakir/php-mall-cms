<?php
try
{ 
    $prepared_query = 'SELECT * FROM structure_skin
                            WHERE id_body = :id_body';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_body', $id_body);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $name_skin = $data['name_skin'];
        $width_skin = $data['width_skin'].'px';
        $height_skin = $data['height_skin'].'px';
        $position_skin = $data['position_skin'];
        $margin_skin = $data['margin_skin'];
        $border_skin = $data['border_skin'].'px';
        $bordercolor_skin = $data['bordercolor_skin'];
        $tablebg_skin = $data['tablebg_skin'];
        $cs_skin = $data['cs_skin'];
        $cp_skin = $data['cp_skin'];
        $bgcolor_skin = $data['bgcolor_skin'];
        $bgimg_skin = $data['bgimg_skin'];
        $xrepeat_skin = $data['xrepeat_skin'];
        $yrepeat_skin = $data['yrepeat_skin'];
        $id_section = $data['id_section'];
        $id_image_skin = $data['id_image'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_image = :id_image';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id_image', $id_image_skin);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
       $path_skin = $data['path_image'];
       $alt_skin = $data['alt_image'];
       $title_skin = $data['title_image'];
       $repeat_skin = $data['repeat_image'];
       $attachment_skin = $data['attachment_image'];
    }
    $query->closeCursor();
    
    if($width_skin == '0px')
    {
        $width_skin = '100%';
    }
    
    if($height_skin == '0px')
    {
        $height_skin = '100%';
    }
    
    if($bgcolor_skin == null)
    {
       $bgcolor_skin = 'white'; 
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>


<table id="tbl_skin_01" style="width: <?php echo($width_skin); ?>; height: <?php echo($height_skin); ?>; 
       border: <?php echo($border_skin.' solid '.$bordercolor_skin); ?>;
       position: <?php echo($position_skin); ?>; margin: <?php echo($margin_skin); ?>;
       <?php if(!empty($repeat_skin)){ ?>background-repeat: <?php echo($repeat_skin) ?>;<?php } ?>
       <?php if(!empty($attachment_skin)){ ?>background-attachment: <?php echo($attachment_skin) ?>;<?php } ?>" 
       cellpadding="<?php echo($cp_skin); ?>" cellspacing="<?php echo($cs_skin); ?>">
    
    <tr style="background-color: <?php echo($tablebg_skin); ?>;">
        <td align="center" style="vertical-align: top;">       
            <?php         
            	include('structure/section/section1.php');
            ?>
        </td>
    </tr>
    
</table>
