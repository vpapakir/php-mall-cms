<?php
try
{
    $prepared_query = 'SELECT * FROM style_block
                       WHERE id_block = :id';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $_SESSION['item_main_edit_cboSelectItem']);
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
        $bgcolorhover_block = $data['bgcolorhover_block'];
        $font_block = $data['font_block'];
    }
    $query->closeCursor();

    if($width_block == 0)
    {
       $width_block_display = '100%';
    }
    else
    {
       $width_block_display = $width_block.'px'; 
    }
   
    if($height_block == 0)
    {
       $height_block_display = 'auto';
    }
    else
    {
       $height_block_display = $height_block.'px'; 
    }
    
    if(!empty($_SESSION['item_block_txtEditNameBlock']))
    {
//        $name_block = $_SESSION['item_block_txtEditNameBlock'];
//        $border_block = $_SESSION['item_block_txtEditBordersizeBlock'];
//        $bordercolor_block = $_SESSION['item_block_cboEditBordercolorBlock'];
//        $borerradius_lt_block = $_SESSION['item_block_txtEditBorderRadiusLTBlock'];
//        $borerradius_rt_block = $_SESSION['item_block_txtEditBorderRadiusRTBlock'];
//        $borerradius_rb_block = $_SESSION['item_block_txtEditBorderRadiusRBBlock'];
//        $borerradius_lb_block = $_SESSION['item_block_txtEditBorderRadiusLBBlock'];
//        $bgcolor_block = $_SESSION['item_block_cboBgColorEditBlock'];
//        $width_block = $_SESSION['item_block_txtEditWidthBlock'];
//        $height_block = $_SESSION['item_block_txtEditHeightBlock'];
//        $padding_block = $_SESSION['item_block_txtEditPaddingBlock'];
//        $image_block = $_SESSION['item_block_txtEditImageBlock']; 
//        $font_block = $_SESSION['item_block_cboEditFontBlock'];
//        $bgcolorhover_block = $_SESSION['item_block_cboBgColorHoverEditBlock'];
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    } 
}
?>
