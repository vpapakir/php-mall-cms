<?php
try
{
    $prepared_query = 'SELECT * FROM style_button
                       WHERE id_button = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $_SESSION['item_main_edit_cboSelectItem']);
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
           $width_button_display[$i] = 'auto';
        }
        else
        {
           $width_button_display[$i] = $width_button[$i].'px'; 
        }
    }
    
    for($i = 0, $count = count($height_button); $i < $count; $i++)
    {
        if($height_button[$i] == 0)
        {
           $height_button_display[$i] = 'auto';
        }
        else
        {
           $height_button_display[$i] = $height_button[$i].'px'; 
        }
    }
    
    if(!empty($_SESSION['item_button_txtEditNameButton']))
    {
//        $name_button = $_SESSION['item_button_txtEditNameButton'];
//        
//        #normal
//        $family_button[0] = $_SESSION['item_button_cboEditFamilyButton'];
//        $size_button[0] = $_SESSION['item_button_txtEditSizeButton'];
//
//        $weight_button[0] = $_SESSION['item_button_cboEditWeightButton'];
//        $color_button[0] = $_SESSION['item_button_cboEditColorButton'];
//        $align_button[0] = $_SESSION['item_button_cboEditAlignButton'];
//        $border_button[0] = $_SESSION['item_button_txtEditSizeBorderButton'];
//        $bordercolor_button[0] = $_SESSION['item_button_cboBordercolorButton'];
//        $borderradius_lt_button[0] = $_SESSION['item_button_txtEditBorderRadiusLTButton'];
//        $borderradius_rt_button[0] = $_SESSION['item_button_txtEditBorderRadiusRTButton'];
//        $borderradius_rb_button[0] = $_SESSION['item_button_txtEditBorderRadiusRBButton'];
//        $borderradius_lb_button[0] = $_SESSION['item_button_txtEditBorderRadiusLBButton'];
//        $bgcolor_button[0] = $_SESSION['item_button_cboBgColorButton'];
//        $width_button[0] = $_SESSION['item_button_txtEditWidthButton'];
//        $height_button[0] = $_SESSION['item_button_txtEditHeightButton'];
//        $padding_button[0] = $_SESSION['item_button_txtEditPaddingButton'];
//        $image_button[0] = $_SESSION['item_button_txtEditImageButton'];
//        
//        #hover
//        $family_button[1] = $_SESSION['item_button_cboEditFamilyButtonHover'];
//        $size_button[1] = $_SESSION['item_button_txtEditSizeButtonHover'];
//
//        $weight_button[1] = $_SESSION['item_button_cboEditWeightButtonHover'];
//        $color_button[1] = $_SESSION['item_button_cboEditColorButtonHover'];
//        $align_button[1] = $_SESSION['item_button_cboEditAlignButtonHover'];
//        $border_button[1] = $_SESSION['item_button_txtEditSizeBorderButtonHover'];
//        $bordercolor_button[1] = $_SESSION['item_button_cboBordercolorButtonHover'];
//        $borderradius_lt_button[1] = $_SESSION['item_button_txtEditBorderRadiusLTButtonHover'];
//        $borderradius_rt_button[1] = $_SESSION['item_button_txtEditBorderRadiusRTButtonHover'];
//        $borderradius_rb_button[1] = $_SESSION['item_button_txtEditBorderRadiusRBButtonHover'];
//        $borderradius_lb_button[1] = $_SESSION['item_button_txtEditBorderRadiusLBButtonHover'];
//        $bgcolor_button[1] = $_SESSION['item_button_cboBgColorButtonHover'];
//        $width_button[1] = $_SESSION['item_button_txtEditWidthButtonHover'];
//        $height_button[1] = $_SESSION['item_button_txtEditHeightButtonHover'];
//        $padding_button[1] = $_SESSION['item_button_txtEditPaddingButtonHover'];
//        $image_button[1] = $_SESSION['item_button_txtEditImageButtonHover'];
//        
//        #active
//        $family_button[2] = $_SESSION['item_button_cboEditFamilyButtonActive'];
//        $size_button[2] = $_SESSION['item_button_txtEditSizeButtonActive'];
//
//        $weight_button[2] = $_SESSION['item_button_cboEditWeightButtonActive'];
//        $color_button[2] = $_SESSION['item_button_cboEditColorButtonActive'];
//        $align_button[2] = $_SESSION['item_button_cboEditAlignButtonActive'];
//        $border_button[2] = $_SESSION['item_button_txtEditSizeBorderButtonActive'];
//        $bordercolor_button[2] = $_SESSION['item_button_cboBordercolorButtonActive'];
//        $borderradius_lt_button[2] = $_SESSION['item_button_txtEditBorderRadiusLTButtonActive'];
//        $borderradius_rt_button[2] = $_SESSION['item_button_txtEditBorderRadiusRTButtonActive'];
//        $borderradius_rb_button[2] = $_SESSION['item_button_txtEditBorderRadiusRBButtonActive'];
//        $borderradius_lb_button[2] = $_SESSION['item_button_txtEditBorderRadiusLBButtonActive'];
//        $bgcolor_button[2] = $_SESSION['item_button_cboBgColorButtonActive'];
//        $width_button[2] = $_SESSION['item_button_txtEditWidthButtonActive'];
//        $height_button[2] = $_SESSION['item_button_txtEditHeightButtonActive'];
//        $padding_button[2] = $_SESSION['item_button_txtEditPaddingButtonActive'];
//        $image_button[2] = $_SESSION['item_button_txtEditImageButtonActive'];
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
