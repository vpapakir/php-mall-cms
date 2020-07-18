<?php
if(isset($_POST['bt_save_add_block']))
{
    unset($_SESSION['msg_item_main_done']);
    
    $name_block = trim(htmlspecialchars($_POST['txtAddNameBlock'], ENT_QUOTES));
    
    // <editor-fold defaultstate="collapsed" desc="Block values">
    $border_block = trim(htmlspecialchars($_POST['txtAddBordersizeBlock'], ENT_QUOTES));
    $bordercolor_block = trim(htmlspecialchars($_POST['cboAddBordercolorBlock'], ENT_QUOTES));
    $borerradius_lt_block = trim(htmlspecialchars($_POST['txtAddBorderRadiusLTBlock'], ENT_QUOTES));
    $borerradius_rt_block = trim(htmlspecialchars($_POST['txtAddBorderRadiusRTBlock'], ENT_QUOTES));
    $borerradius_rb_block = trim(htmlspecialchars($_POST['txtAddBorderRadiusRBBlock'], ENT_QUOTES));
    $borerradius_lb_block = trim(htmlspecialchars($_POST['txtAddBorderRadiusLBBlock'], ENT_QUOTES));
    $bgcolor_block = trim(htmlspecialchars($_POST['cboBgColorBlock'], ENT_QUOTES));
    $width_block = trim(htmlspecialchars($_POST['txtAddWidthBlock'], ENT_QUOTES));
    $height_block = trim(htmlspecialchars($_POST['txtAddHeightBlock'], ENT_QUOTES));
    $padding_block = trim(htmlspecialchars($_POST['txtAddPaddingBlock'], ENT_QUOTES));
    $image_block = trim(htmlspecialchars($_POST['txtAddImageBlock'], ENT_QUOTES)); 
    $font_block = trim(htmlspecialchars($_POST['cboAddFontBlock'], ENT_QUOTES));
    $bgcolorhover_block = trim(htmlspecialchars($_POST['cboBgColorHoverBlock'], ENT_QUOTES));
        
    if(empty($border_block) ? $border_block = 0 : $border_block = $border_block);
    if(empty($borerradius_lt_block) ? $borerradius_lt_block = 0 : $borerradius_lt_block = $borerradius_lt_block);
    if(empty($borerradius_rt_block) ? $borerradius_rt_block = 0 : $borerradius_rt_block = $borerradius_rt_block);
    if(empty($borerradius_rb_block) ? $borerradius_rb_block = 0 : $borerradius_rb_block = $borerradius_rb_block);
    if(empty($borerradius_lb_block) ? $borerradius_lb_block = 0 : $borerradius_lb_block = $borerradius_lb_block);
    if(empty($width_block) ? $width_block = 0 : $width_block = $width_block);   
    if(empty($height_block) ? $height_block = 0 : $height_block = $height_block); 
    if(empty($padding_block) ? $padding_block = 0 : $padding_block = $padding_block);  
    // </editor-fold>

    try
    {
        $prepared_query = 'SELECT COUNT(id_block) FROM style_block';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $last_number_block = $data[0];
        }
        $query->closeCursor();
        
        if($last_number_block == 0)
        {
           $last_number_block = 1; 
        }
        else
        {
           $last_number_block++; 
        }
        
        if(empty($name_block))
        {
            $name_block = 'block'.$last_number_block;
        }                
        
        $prepared_query = 'INSERT INTO style_block
                           (id_template, name_block, border_block,
                            bordercolor_block, borderradius_lt_block, borderradius_rt_block,
                            borderradius_rb_block, borderradius_lb_block,
                            bgcolor_block, width_block, height_block,
                            padding_block, image_block, bgcolorhover_block, font_block)
                           VALUES
                            (:template, :name, :border, :bordercolor, :radius_lt, :radius_rt,
                             :radius_rb, :radius_lb, :bgcolor, :width, :height,
                             :padding, :image, :bgcolorhover, :font)';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'template' => 0,
                              'name' => $name_block,
                              'border' => $border_block,
                              'bordercolor' => $bordercolor_block,
                              'radius_lt' => $borerradius_lt_block,
                              'radius_rt' => $borerradius_rt_block,
                              'radius_rb' => $borerradius_rb_block,
                              'radius_lb' => $borerradius_lb_block,
                              'bgcolor' => $bgcolor_block,
                              'width' => $width_block,
                              'height' => $height_block,
                              'padding' => $padding_block,
                              'bgcolorhover' => $bgcolorhover_block,
                              'font' => $font_block,
                              'image' => $image_block
                              ));
        $query->closeCursor();
        
        
//        unset($_SESSION['item_main_edit_cboAddItem']);
//        unset($_SESSION['item_main_edit_cboSelectItem']);
        $_SESSION['msg_item_main_done'] = 'Le block "'.$name_block.'" a été créé';
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
