<?php
if(isset($_POST['bt_save_add_item']))
{
    unset($_SESSION['msg_item_main_done']);
    
    $fontfamily_button = null;
    $fontfamily_button_hover = null;
    $fontfamily_button_active = null;
    
    $name_button = trim(htmlspecialchars($_POST['txtAddNameButton'], ENT_QUOTES));
    
    // <editor-fold defaultstate="collapsed" desc="Normal Button">
    $fontfamily_button = $_POST['cboAddFamilyButton'];
    $fontsize_button = trim(htmlspecialchars($_POST['txtAddSizeButton'], ENT_QUOTES));
    
    $fontweight_button = trim(htmlspecialchars($_POST['cboAddWeightButton'], ENT_QUOTES));
    $fontcolor_button = trim(htmlspecialchars($_POST['cboAddColorButton'], ENT_QUOTES));
    $fontalign_button = trim(htmlspecialchars($_POST['cboAddAlignButton'], ENT_QUOTES));
    $border_button = trim(htmlspecialchars($_POST['txtAddSizeBorderButton'], ENT_QUOTES));
    $bordercolor_button = trim(htmlspecialchars($_POST['cboBordercolorButton'], ENT_QUOTES));
    $borerradius_lt_button = trim(htmlspecialchars($_POST['txtAddBorderRadiusLTButton'], ENT_QUOTES));
    $borerradius_rt_button = trim(htmlspecialchars($_POST['txtAddBorderRadiusRTButton'], ENT_QUOTES));
    $borerradius_rb_button = trim(htmlspecialchars($_POST['txtAddBorderRadiusRBButton'], ENT_QUOTES));
    $borerradius_lb_button = trim(htmlspecialchars($_POST['txtAddBorderRadiusLBButton'], ENT_QUOTES));
    $bgcolor_button = trim(htmlspecialchars($_POST['cboBgColorButton'], ENT_QUOTES));
    $width_button = trim(htmlspecialchars($_POST['txtAddWidthButton'], ENT_QUOTES));
    $height_button = trim(htmlspecialchars($_POST['txtAddHeightButton'], ENT_QUOTES));
    $padding_button = trim(htmlspecialchars($_POST['txtAddPaddingButton'], ENT_QUOTES));
    $image_button = trim(htmlspecialchars($_POST['txtAddImageButton'], ENT_QUOTES));      
    
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
    $fontfamily_button_hover = $_POST['cboAddFamilyButtonHover'];
    $fontsize_button_hover = trim(htmlspecialchars($_POST['txtAddSizeButtonHover'], ENT_QUOTES));
    
    $fontweight_button_hover = trim(htmlspecialchars($_POST['cboAddWeightButtonHover'], ENT_QUOTES));
    $fontcolor_button_hover = trim(htmlspecialchars($_POST['cboAddColorButtonHover'], ENT_QUOTES));
    $fontalign_button_hover = trim(htmlspecialchars($_POST['cboAddAlignButtonHover'], ENT_QUOTES));
    $border_button_hover = trim(htmlspecialchars($_POST['txtAddSizeBorderButtonHover'], ENT_QUOTES));
    $bordercolor_button_hover = trim(htmlspecialchars($_POST['cboBordercolorButtonHover'], ENT_QUOTES));
    $borerradius_lt_button_hover = trim(htmlspecialchars($_POST['txtAddBorderRadiusLTButtonHover'], ENT_QUOTES));
    $borerradius_rt_button_hover = trim(htmlspecialchars($_POST['txtAddBorderRadiusRTButtonHover'], ENT_QUOTES));
    $borerradius_rb_button_hover = trim(htmlspecialchars($_POST['txtAddBorderRadiusRBButtonHover'], ENT_QUOTES));
    $borerradius_lb_button_hover = trim(htmlspecialchars($_POST['txtAddBorderRadiusLBButtonHover'], ENT_QUOTES));
    $bgcolor_button_hover = trim(htmlspecialchars($_POST['cboBgColorButtonHover'], ENT_QUOTES));
    $width_button_hover = trim(htmlspecialchars($_POST['txtAddWidthButtonHover'], ENT_QUOTES));
    $height_button_hover = trim(htmlspecialchars($_POST['txtAddHeightButtonHover'], ENT_QUOTES));
    $padding_button_hover = trim(htmlspecialchars($_POST['txtAddPaddingButtonHover'], ENT_QUOTES));
    $image_button_hover = trim(htmlspecialchars($_POST['txtAddImageButtonHover'], ENT_QUOTES));
    
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
    $fontfamily_button_active = $_POST['cboAddFamilyButtonActive'];
    $fontsize_button_active = trim(htmlspecialchars($_POST['txtAddSizeButtonActive'], ENT_QUOTES));
    
    $fontweight_button_active = trim(htmlspecialchars($_POST['cboAddWeightButtonActive'], ENT_QUOTES));
    $fontcolor_button_active = trim(htmlspecialchars($_POST['cboAddColorButtonActive'], ENT_QUOTES));
    $fontalign_button_active = trim(htmlspecialchars($_POST['cboAddAlignButtonActive'], ENT_QUOTES));
    $border_button_active = trim(htmlspecialchars($_POST['txtAddSizeBorderButtonActive'], ENT_QUOTES));
    $bordercolor_button_active = trim(htmlspecialchars($_POST['cboBordercolorButtonActive'], ENT_QUOTES));
    $borerradius_lt_button_active = trim(htmlspecialchars($_POST['txtAddBorderRadiusLTButtonActive'], ENT_QUOTES));
    $borerradius_rt_button_active = trim(htmlspecialchars($_POST['txtAddBorderRadiusRTButtonActive'], ENT_QUOTES));
    $borerradius_rb_button_active = trim(htmlspecialchars($_POST['txtAddBorderRadiusRBButtonActive'], ENT_QUOTES));
    $borerradius_lb_button_active = trim(htmlspecialchars($_POST['txtAddBorderRadiusLBButtonActive'], ENT_QUOTES));
    $bgcolor_button_active = trim(htmlspecialchars($_POST['cboBgColorButtonActive'], ENT_QUOTES));
    $width_button_active = trim(htmlspecialchars($_POST['txtAddWidthButtonActive'], ENT_QUOTES));
    $height_button_active = trim(htmlspecialchars($_POST['txtAddHeightButtonActive'], ENT_QUOTES));
    $padding_button_active = trim(htmlspecialchars($_POST['txtAddPaddingButtonActive'], ENT_QUOTES));
    $image_button_active = trim(htmlspecialchars($_POST['txtAddImageButtonActive'], ENT_QUOTES));
    
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
        $all_padding_button = $padding_button.'$'.$padding_button_hover.'$'.$padding_button_active;
        $all_image_button = $image_button.'$'.$image_button_hover.'$'.$image_button_active;
        
        
        
        $prepared_query = 'INSERT INTO style_button
                           (id_template, name_button, family_button, size_button,
                            weight_button, color_button, align_button, border_button,
                            bordercolor_button, borderradius_lt_button, borderradius_rt_button,
                            borderradius_rb_button, borderradius_lb_button,
                            bgcolor_button, width_button, height_button,
                            padding_button, image_button)
                           VALUES
                            (:template, :name, :family, :size, :weight, :color,
                             :align, :border, :bordercolor, :radius_lt, :radius_rt,
                             :radius_rb, :radius_lb, :bgcolor, :width, :height,
                             :padding, :image)';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'template' => 0,
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
                              'padding' => $all_padding_button,
                              'image' => $all_image_button
                              ));
        $query->closeCursor();
        
        
//        unset($_SESSION['item_main_edit_cboAddItem']);
//        unset($_SESSION['item_main_edit_cboSelectItem']);
        $_SESSION['msg_item_main_done'] = 'Le bouton "'.$name_button.'" a été créé';
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
