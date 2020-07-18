<?php
if(isset($_POST['bt_save_edit_button']))
{
    unset($_SESSION['msg_item_main_done']);
    unset($_SESSION['item_button_cboEditFamilyButton'],
            $_SESSION['item_button_txtEditSizeButton'],   
            $_SESSION['item_button_cboEditWeightButton'],
            $_SESSION['item_button_cboEditColorButton'],
            $_SESSION['item_button_cboEditAlignButton'],
            $_SESSION['item_button_txtEditSizeBorderButton'],
            $_SESSION['item_button_cboBordercolorButton'],
            $_SESSION['item_button_txtEditBorderRadiusLTButton'],
            $_SESSION['item_button_txtEditBorderRadiusRTButton'],
            $_SESSION['item_button_txtEditBorderRadiusRBButton'],
            $_SESSION['item_button_txtEditBorderRadiusLBButton'],
            $_SESSION['item_button_cboBgColorButton'],
            $_SESSION['item_button_txtEditWidthButton'],
            $_SESSION['item_button_txtEditHeightButton'],
            $_SESSION['item_button_txtEditPaddingButton'],
            $_SESSION['item_button_txtEditImageButton']);
    unset($_SESSION['item_button_cboEditFamilyButtonHover'],
            $_SESSION['item_button_txtEditSizeButtonHover'],   
            $_SESSION['item_button_cboEditWeightButtonHover'],
            $_SESSION['item_button_cboEditColorButtonHover'],
            $_SESSION['item_button_cboEditAlignButtonHover'],
            $_SESSION['item_button_txtEditSizeBorderButtonHover'],
            $_SESSION['item_button_cboBordercolorButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusLTButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusRTButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusRBButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusLBButtonHover'],
            $_SESSION['item_button_cboBgColorButtonHover'],
            $_SESSION['item_button_txtEditWidthButtonHover'],
            $_SESSION['item_button_txtEditHeightButtonHover'],
            $_SESSION['item_button_txtEditPaddingButtonHover'],
            $_SESSION['item_button_txtEditImageButtonHover']);
    unset($_SESSION['item_button_cboEditFamilyButtonActive'],
            $_SESSION['item_button_txtEditSizeButtonActive'],   
            $_SESSION['item_button_cboEditWeightButtonActive'],
            $_SESSION['item_button_cboEditColorButtonActive'],
            $_SESSION['item_button_cboEditAlignButtonActive'],
            $_SESSION['item_button_txtEditSizeBorderButtonActive'],
            $_SESSION['item_button_cboBordercolorButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusLTButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusRTButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusRBButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusLBButtonActive'],
            $_SESSION['item_button_cboBgColorButtonActive'],
            $_SESSION['item_button_txtEditWidthButtonActive'],
            $_SESSION['item_button_txtEditHeightButtonActive'],
            $_SESSION['item_button_txtEditPaddingButtonActive'],
            $_SESSION['item_button_txtEditImageButtonActive']);
    
    $fontfamily_button = null;
    $fontfamily_button_hover = null;
    $fontfamily_button_active = null;
    
    $name_button = trim(htmlspecialchars($_POST['txtEditNameButton'], ENT_QUOTES));
    
    // <editor-fold defaultstate="collapsed" desc="Normal Button">
    $fontfamily_button = $_POST['cboEditFamilyButton'];
    $fontsize_button = trim(htmlspecialchars($_POST['txtEditSizeButton'], ENT_QUOTES));
    
    $fontweight_button = trim(htmlspecialchars($_POST['cboEditWeightButton'], ENT_QUOTES));
    $fontcolor_button = trim(htmlspecialchars($_POST['cboEditColorButton'], ENT_QUOTES));
    $fontalign_button = trim(htmlspecialchars($_POST['cboEditAlignButton'], ENT_QUOTES));
    $border_button = trim(htmlspecialchars($_POST['txtEditSizeBorderButton'], ENT_QUOTES));
    $bordercolor_button = trim(htmlspecialchars($_POST['cboBordercolorButton'], ENT_QUOTES));
    $borerradius_lt_button = trim(htmlspecialchars($_POST['txtEditBorderRadiusLTButton'], ENT_QUOTES));
    $borerradius_rt_button = trim(htmlspecialchars($_POST['txtEditBorderRadiusRTButton'], ENT_QUOTES));
    $borerradius_rb_button = trim(htmlspecialchars($_POST['txtEditBorderRadiusRBButton'], ENT_QUOTES));
    $borerradius_lb_button = trim(htmlspecialchars($_POST['txtEditBorderRadiusLBButton'], ENT_QUOTES));
    $bgcolor_button = trim(htmlspecialchars($_POST['cboBgColorButton'], ENT_QUOTES));
    $width_button = trim(htmlspecialchars($_POST['txtEditWidthButton'], ENT_QUOTES));
    $height_button = trim(htmlspecialchars($_POST['txtEditHeightButton'], ENT_QUOTES));
    $padding_button = trim(htmlspecialchars($_POST['txtEditPaddingButton'], ENT_QUOTES));
    $image_button = trim(htmlspecialchars($_POST['txtEditImageButton'], ENT_QUOTES));        
    
    if(empty($fontsize_button) ? $fontsize_button = 0 : $fontsize_button = $fontsize_button);
    if(empty($border_button) ? $border_button = 0 : $border_button = $border_button);
    if(empty($borerradius_lt_button) ? $borerradius_lt_button = 0 : $borerradius_lt_button = $borerradius_lt_button);
    if(empty($borerradius_rt_button) ? $borerradius_rt_button = 0 : $borerradius_rt_button = $borerradius_rt_button);
    if(empty($borerradius_rb_button) ? $borerradius_rb_button = 0 : $borerradius_rb_button = $borerradius_rb_button);
    if(empty($borerradius_lb_button) ? $borerradius_lb_button = 0 : $borerradius_lb_button = $borerradius_lb_button);
    if(empty($width_button) ? $width_button = 0 : $width_button = $width_button);   
    if(empty($height_button) ? $height_button = 0 : $height_button = $height_button); 
    if(empty($padding_button) ? $padding_button = 0 : $padding_button = $padding_button);  
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Hover Button">
    $fontfamily_button_hover = $_POST['cboEditFamilyButtonHover'];
    $fontsize_button_hover = trim(htmlspecialchars($_POST['txtEditSizeButtonHover'], ENT_QUOTES));
    
    $fontweight_button_hover = trim(htmlspecialchars($_POST['cboEditWeightButtonHover'], ENT_QUOTES));
    $fontcolor_button_hover = trim(htmlspecialchars($_POST['cboEditColorButtonHover'], ENT_QUOTES));
    $fontalign_button_hover = trim(htmlspecialchars($_POST['cboEditAlignButtonHover'], ENT_QUOTES));
    $border_button_hover = trim(htmlspecialchars($_POST['txtEditSizeBorderButtonHover'], ENT_QUOTES));
    $bordercolor_button_hover = trim(htmlspecialchars($_POST['cboBordercolorButtonHover'], ENT_QUOTES));
    $borerradius_lt_button_hover = trim(htmlspecialchars($_POST['txtEditBorderRadiusLTButtonHover'], ENT_QUOTES));
    $borerradius_rt_button_hover = trim(htmlspecialchars($_POST['txtEditBorderRadiusRTButtonHover'], ENT_QUOTES));
    $borerradius_rb_button_hover = trim(htmlspecialchars($_POST['txtEditBorderRadiusRBButtonHover'], ENT_QUOTES));
    $borerradius_lb_button_hover = trim(htmlspecialchars($_POST['txtEditBorderRadiusLBButtonHover'], ENT_QUOTES));
    $bgcolor_button_hover = trim(htmlspecialchars($_POST['cboBgColorButtonHover'], ENT_QUOTES));
    $width_button_hover = trim(htmlspecialchars($_POST['txtEditWidthButtonHover'], ENT_QUOTES));
    $height_button_hover = trim(htmlspecialchars($_POST['txtEditHeightButtonHover'], ENT_QUOTES));
    $padding_button_hover = trim(htmlspecialchars($_POST['txtEditPaddingButtonHover'], ENT_QUOTES));
    $image_button_hover = trim(htmlspecialchars($_POST['txtEditImageButtonHover'], ENT_QUOTES));
    
    if(empty($fontsize_button_hover) ? $fontsize_button_hover = 0 : $fontsize_button_hover = $fontsize_button_hover);
    if(empty($border_button_hover) ? $border_button_hover = 0 : $border_button_hover = $border_button_hover);
    if(empty($borerradius_lt_button_hover) ? $borerradius_lt_button_hover = 0 : $borerradius_lt_button_hover = $borerradius_lt_button_hover);
    if(empty($borerradius_rt_button_hover) ? $borerradius_rt_button_hover = 0 : $borerradius_rt_button_hover = $borerradius_rt_button_hover);
    if(empty($borerradius_rb_button_hover) ? $borerradius_rb_button_hover = 0 : $borerradius_rb_button_hover = $borerradius_rb_button_hover);
    if(empty($borerradius_lb_button_hover) ? $borerradius_lb_button_hover = 0 : $borerradius_lb_button_hover = $borerradius_lb_button_hover);
    if(empty($width_button_hover) ? $width_button_hover = 0 : $width_button_hover = $width_button_hover);    
    if(empty($height_button_hover) ? $height_button_hover = 0 : $height_button_hover = $height_button_hover);  
    if(empty($padding_button_hover) ? $padding_button_hover = 0 : $padding_button_hover = $padding_button_hover);  
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Active Button">
    $fontfamily_button_active = $_POST['cboEditFamilyButtonActive'];
    $fontsize_button_active = trim(htmlspecialchars($_POST['txtEditSizeButtonActive'], ENT_QUOTES));
    
    $fontweight_button_active = trim(htmlspecialchars($_POST['cboEditWeightButtonActive'], ENT_QUOTES));
    $fontcolor_button_active = trim(htmlspecialchars($_POST['cboEditColorButtonActive'], ENT_QUOTES));
    $fontalign_button_active = trim(htmlspecialchars($_POST['cboEditAlignButtonActive'], ENT_QUOTES));
    $border_button_active = trim(htmlspecialchars($_POST['txtEditSizeBorderButtonActive'], ENT_QUOTES));
    $bordercolor_button_active = trim(htmlspecialchars($_POST['cboBordercolorButtonActive'], ENT_QUOTES));
    $borerradius_lt_button_active = trim(htmlspecialchars($_POST['txtEditBorderRadiusLTButtonActive'], ENT_QUOTES));
    $borerradius_rt_button_active = trim(htmlspecialchars($_POST['txtEditBorderRadiusRTButtonActive'], ENT_QUOTES));
    $borerradius_rb_button_active = trim(htmlspecialchars($_POST['txtEditBorderRadiusRBButtonActive'], ENT_QUOTES));
    $borerradius_lb_button_active = trim(htmlspecialchars($_POST['txtEditBorderRadiusLBButtonActive'], ENT_QUOTES));
    $bgcolor_button_active = trim(htmlspecialchars($_POST['cboBgColorButtonActive'], ENT_QUOTES));
    $width_button_active = trim(htmlspecialchars($_POST['txtEditWidthButtonActive'], ENT_QUOTES));
    $height_button_active = trim(htmlspecialchars($_POST['txtEditHeightButtonActive'], ENT_QUOTES));
    $padding_button_active = trim(htmlspecialchars($_POST['txtEditPaddingButtonActive'], ENT_QUOTES));
    $image_button_active = trim(htmlspecialchars($_POST['txtEditImageButtonActive'], ENT_QUOTES));
    
    if(empty($fontsize_button_active) ? $fontsize_button_active = 0 : $fontsize_button_active = $fontsize_button);
    if(empty($border_button_active) ? $border_button_active = 0 : $border_button_active = $border_button);
    if(empty($borerradius_lt_button_active) ? $borerradius_lt_button_active = 0 : $borerradius_lt_button_active = $borerradius_lt_button_active);
    if(empty($borerradius_rt_button_active) ? $borerradius_rt_button_active = 0 : $borerradius_rt_button_active = $borerradius_rt_button_active);
    if(empty($borerradius_rb_button_active) ? $borerradius_rb_button_active = 0 : $borerradius_rb_button_active = $borerradius_rb_button_active);
    if(empty($borerradius_lb_button_active) ? $borerradius_lb_button_active = 0 : $borerradius_lb_button_active = $borerradius_lb_button_active);
    if(empty($width_button_active) ? $width_button_active = 0 : $width_button_active = $width_button_active);    
    if(empty($height_button_active) ? $height_button_active = 0 : $height_button_active = $height_button_active);  
    if(empty($padding_button_active) ? $padding_button_active = 0 : $padding_button_active = $padding_button_active);  
    // </editor-fold>

    try
    {
        $prepared_query = 'SELECT COUNT(id_button) FROM style_button';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $last_number_button = $data[0];
        }
        $query->closeCursor();
        
        if($last_number_button == 0)
        {
           $last_number_button = 1; 
        }
        else
        {
           $last_number_button++; 
        }
        
        if(empty($name_button))
        {
            $name_button = 'button'.$last_number_button;
        }
        
        $all_fontfamily_button = $fontfamily_button.'$'.$fontfamily_button_hover.'$'.$fontfamily_button_active;
        $all_fontsize_button = $fontsize_button.'$'.$fontsize_button_hover.'$'.$fontsize_button_active;
        $all_fontweight_button = $fontweight_button.'$'.$fontweight_button_hover.'$'.$fontweight_button_active;
        $all_fontcolor_button = $fontcolor_button.'$'.$fontcolor_button_hover.'$'.$fontcolor_button_active;
        $all_fontalign_button = $fontalign_button.'$'.$fontalign_button_hover.'$'.$fontalign_button_active;
        $all_border_button = $border_button.'$'.$border_button_hover.'$'.$border_button_active;
        $all_bordercolor_button = $bordercolor_button.'$'.$bordercolor_button_hover.'$'.$bordercolor_button_active;
        $all_borerradius_lt_button = $borerradius_lt_button.'$'.$borerradius_lt_button_hover.'$'.$borerradius_lt_button_active;
        $all_borerradius_rt_button = $borerradius_rt_button.'$'.$borerradius_rt_button_hover.'$'.$borerradius_rt_button_active;
        $all_borerradius_rb_button = $borerradius_rb_button.'$'.$borerradius_rb_button_hover.'$'.$borerradius_rb_button_active;
        $all_borerradius_lb_button = $borerradius_lb_button.'$'.$borerradius_lb_button_hover.'$'.$borerradius_lb_button_active;
        $all_bgcolor_button = $bgcolor_button.'$'.$bgcolor_button_hover.'$'.$bgcolor_button_active;
        $all_width_button = $width_button.'$'.$width_button_hover.'$'.$width_button_active;
        $all_height_button = $height_button.'$'.$height_button_hover.'$'.$height_button_active;
        $all_pEditing_button = $padding_button.'$'.$padding_button_hover.'$'.$padding_button_active;
        $all_image_button = $image_button.'$'.$image_button_hover.'$'.$image_button_active;        
        
        $prepared_query = 'UPDATE style_button
                           SET name_button = :name,
                               family_button = :family,
                               size_button = :size,
                               weight_button = :weight,
                               color_button = :color,
                               align_button = :align,
                               border_button = :border,
                               bordercolor_button = :bordercolor,
                               borderradius_lt_button = :radius_lt,
                               borderradius_rt_button = :radius_rt,
                               borderradius_rb_button = :radius_rb, 
                               borderradius_lb_button = :radius_lb,
                               bgcolor_button = :bgcolor,
                               width_button = :width,
                               height_button = :height,
                               padding_button = :padding, 
                               image_button = :image
                           WHERE id_button = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'name' => $name_button,
                              'family' => $all_fontfamily_button,
                              'size' => $all_fontsize_button,
                              'weight' => $all_fontweight_button,
                              'color' => $all_fontcolor_button,
                              'align' => $all_fontalign_button,
                              'border' => $all_border_button,
                              'bordercolor' => $all_bordercolor_button,
                              'radius_lt' => $all_borerradius_lt_button,
                              'radius_rt' => $all_borerradius_rt_button,
                              'radius_rb' => $all_borerradius_rb_button,
                              'radius_lb' => $all_borerradius_lb_button,
                              'bgcolor' => $all_bgcolor_button,
                              'width' => $all_width_button,
                              'height' => $all_height_button,
                              'padding' => $all_pEditing_button,
                              'image' => $all_image_button,
                              'id' => $_SESSION['item_main_edit_cboSelectItem']
                              ));
        $query->closeCursor();
        
        
//        unset($_SESSION['item_main_edit_cboAddItem']);
//        unset($_SESSION['item_main_edit_cboSelectItem']);
        $_SESSION['item_button_txtEditNameButton'] = $name_button;

        #normal
        $_SESSION['item_button_cboEditFamilyButton'] = $fontfamily_button;
        $_SESSION['item_button_txtEditSizeButton'] = $fontsize_button;   
        $_SESSION['item_button_cboEditWeightButton'] = $fontweight_button;
        $_SESSION['item_button_cboEditColorButton'] = $fontcolor_button;
        $_SESSION['item_button_cboEditAlignButton'] = $fontalign_button;
        $_SESSION['item_button_txtEditSizeBorderButton'] = $border_button;
        $_SESSION['item_button_cboBordercolorButton'] = $bordercolor_button;
        $_SESSION['item_button_txtEditBorderRadiusLTButton'] = $borerradius_lt_button;
        $_SESSION['item_button_txtEditBorderRadiusRTButton'] = $borerradius_rt_button;
        $_SESSION['item_button_txtEditBorderRadiusRBButton'] = $borerradius_rb_button;
        $_SESSION['item_button_txtEditBorderRadiusLBButton'] = $borerradius_lb_button;
        $_SESSION['item_button_cboBgColorButton'] = $bgcolor_button;
        $_SESSION['item_button_txtEditWidthButton'] = $width_button;
        $_SESSION['item_button_txtEditHeightButton'] = $height_button;
        $_SESSION['item_button_txtEditPaddingButton'] = $padding_button;
        $_SESSION['item_button_txtEditImageButton'] = $image_button;
        
        #hover
        $_SESSION['item_button_cboEditFamilyButtonHover'] = $fontfamily_button_hover;
        $_SESSION['item_button_txtEditSizeButtonHover'] = $fontsize_button_hover;   
        $_SESSION['item_button_cboEditWeightButtonHover'] = $fontweight_button_hover;
        $_SESSION['item_button_cboEditColorButtonHover'] = $fontcolor_button_hover;
        $_SESSION['item_button_cboEditAlignButtonHover'] = $fontalign_button_hover;
        $_SESSION['item_button_txtEditSizeBorderButtonHover'] = $border_button_hover;
        $_SESSION['item_button_cboBordercolorButtonHover'] = $bordercolor_button_hover;
        $_SESSION['item_button_txtEditBorderRadiusLTButtonHover'] = $borerradius_lt_button_hover;
        $_SESSION['item_button_txtEditBorderRadiusRTButtonHover'] = $borerradius_rt_button_hover;
        $_SESSION['item_button_txtEditBorderRadiusRBButtonHover'] = $borerradius_rb_button_hover;
        $_SESSION['item_button_txtEditBorderRadiusLBButtonHover'] = $borerradius_lb_button_hover;
        $_SESSION['item_button_cboBgColorButtonHover'] = $bgcolor_button_hover;
        $_SESSION['item_button_txtEditWidthButtonHover'] = $width_button_hover;
        $_SESSION['item_button_txtEditHeightButtonHover'] = $height_button_hover;
        $_SESSION['item_button_txtEditPaddingButtonHover'] = $padding_button_hover;
        $_SESSION['item_button_txtEditImageButtonHover'] = $image_button_hover;
        
        #active
        $_SESSION['item_button_cboEditFamilyButtonActive'] = $fontfamily_button_active;
        $_SESSION['item_button_txtEditSizeButtonActive'] = $fontsize_button_active;   
        $_SESSION['item_button_cboEditWeightButtonActive'] = $fontweight_button_active;
        $_SESSION['item_button_cboEditColorButtonActive'] = $fontcolor_button_active;
        $_SESSION['item_button_cboEditAlignButtonActive'] = $fontalign_button_active;
        $_SESSION['item_button_txtEditSizeBorderButtonActive'] = $border_button_active;
        $_SESSION['item_button_cboBordercolorButtonActive'] = $bordercolor_button_active;
        $_SESSION['item_button_txtEditBorderRadiusLTButtonActive'] = $borerradius_lt_button_active;
        $_SESSION['item_button_txtEditBorderRadiusRTButtonActive'] = $borerradius_rt_button_active;
        $_SESSION['item_button_txtEditBorderRadiusRBButtonActive'] = $borerradius_rb_button_active;
        $_SESSION['item_button_txtEditBorderRadiusLBButtonActive'] = $borerradius_lb_button_active;
        $_SESSION['item_button_cboBgColorButtonActive'] = $bgcolor_button_active;
        $_SESSION['item_button_txtEditWidthButtonActive'] = $width_button_active;
        $_SESSION['item_button_txtEditHeightButtonActive'] = $height_button_active;
        $_SESSION['item_button_txtEditPaddingButtonActive'] = $padding_button_active;
        $_SESSION['item_button_txtEditImageButtonActive'] = $image_button_active;
        
        $_SESSION['msg_item_main_done'] = 'Le bouton "'.$name_button.'" a été modifié';
        
        include('modules/settings/css/font/font_main.php');
        include('modules/settings/css/block/block_main.php');
        include('modules/settings/css/button/button_main.php');
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
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
