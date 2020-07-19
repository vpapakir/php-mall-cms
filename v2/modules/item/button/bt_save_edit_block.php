<?php
if(isset($_POST['bt_save_edit_block']))
{
    unset($_SESSION['msg_item_main_done']);
    
    unset($_SESSION['item_block_txtEditNameBlock'],
            $_SESSION['item_block_txtEditBordersizeBlock'],
            $_SESSION['item_block_cboEditBordercolorBlock'],
            $_SESSION['item_block_txtEditBorderRadiusLTBlock'],
            $_SESSION['item_block_txtEditBorderRadiusRTBlock'],
            $_SESSION['item_block_txtEditBorderRadiusRBBlock'],
            $_SESSION['item_block_txtEditBorderRadiusLBBlock'],
            $_SESSION['item_block_cboBgColorEditBlock'],
            $_SESSION['item_block_txtEditWidthBlock'],
            $_SESSION['item_block_txtEditHeightBlock'],
            $_SESSION['item_block_txtEditPaddingBlock'],
            $_SESSION['item_block_txtEditImageBlock'],
            $_SESSION['item_block_cboEditFontBlock'],
            $_SESSION['item_block_cboBgColorHoverEditBlock']);
    
    $name_block = trim(htmlspecialchars($_POST['txtEditNameBlock'], ENT_QUOTES));
    
    // <editor-fold defaultstate="collapsed" desc="Normal block">
    $border_block = trim(htmlspecialchars($_POST['txtEditBordersizeBlock'], ENT_QUOTES));
    $bordercolor_block = trim(htmlspecialchars($_POST['cboEditBordercolorBlock'], ENT_QUOTES));
    $borerradius_lt_block = trim(htmlspecialchars($_POST['txtEditBorderRadiusLTBlock'], ENT_QUOTES));
    $borerradius_rt_block = trim(htmlspecialchars($_POST['txtEditBorderRadiusRTBlock'], ENT_QUOTES));
    $borerradius_rb_block = trim(htmlspecialchars($_POST['txtEditBorderRadiusRBBlock'], ENT_QUOTES));
    $borerradius_lb_block = trim(htmlspecialchars($_POST['txtEditBorderRadiusLBBlock'], ENT_QUOTES));
    $bgcolor_block = trim(htmlspecialchars($_POST['cboBgColorEditBlock'], ENT_QUOTES));
    $width_block = trim(htmlspecialchars($_POST['txtEditWidthBlock'], ENT_QUOTES));
    $height_block = trim(htmlspecialchars($_POST['txtEditHeightBlock'], ENT_QUOTES));
    $padding_block = trim(htmlspecialchars($_POST['txtEditPaddingBlock'], ENT_QUOTES));
    $image_block = trim(htmlspecialchars($_POST['txtEditImageBlock'], ENT_QUOTES)); 
    $font_block = trim(htmlspecialchars($_POST['cboEditFontBlock'], ENT_QUOTES));
    $bgcolorhover_block = trim(htmlspecialchars($_POST['cboBgColorHoverEditBlock'], ENT_QUOTES));
    
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
        
        $prepared_query = 'UPDATE style_block
                           SET name_block = :name,
                               border_block = :border,
                               bordercolor_block = :bordercolor,
                               borderradius_lt_block = :radius_lt,
                               borderradius_rt_block = :radius_rt,
                               borderradius_rb_block = :radius_rb, 
                               borderradius_lb_block = :radius_lb,
                               bgcolor_block = :bgcolor,
                               width_block = :width,
                               height_block = :height,
                               padding_block = :padding, 
                               image_block = :image,
                               bgcolorhover_block = :bgcolorhover,
                               font_block = :font
                           WHERE id_block = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
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
                              'image' => $image_block,
                              'bgcolorhover' => $bgcolorhover_block,
                              'font' => $font_block,
                              'id' => $_SESSION['item_main_edit_cboSelectItem']
                              ));
        $query->closeCursor();
        
        
//        unset($_SESSION['item_main_edit_cboAddItem']);
//        unset($_SESSION['item_main_edit_cboSelectItem']);
        $_SESSION['item_block_txtEditNameBlock'] = $name_block;
        $_SESSION['item_block_txtEditBordersizeBlock'] = $border_block;
        $_SESSION['item_block_cboEditBordercolorBlock'] = $bordercolor_block;
        $_SESSION['item_block_txtEditBorderRadiusLTBlock'] = $borerradius_lt_block;
        $_SESSION['item_block_txtEditBorderRadiusRTBlock'] = $borerradius_rt_block;
        $_SESSION['item_block_txtEditBorderRadiusRBBlock'] = $borerradius_rb_block;
        $_SESSION['item_block_txtEditBorderRadiusLBBlock'] = $borerradius_lb_block;
        $_SESSION['item_block_cboBgColorEditBlock'] = $bgcolor_block;
        $_SESSION['item_block_txtEditWidthBlock'] = $width_block;
        $_SESSION['item_block_txtEditHeightBlock'] = $height_block;
        $_SESSION['item_block_txtEditPaddingBlock'] = $padding_block;
        $_SESSION['item_block_txtEditImageBlock'] = $image_block; 
        $_SESSION['item_block_cboEditFontBlock'] = $font_block;
        $_SESSION['item_block_cboBgColorHoverEditBlock'] = $bgcolorhover_block;
        
        
        $_SESSION['msg_item_main_done'] = 'Le block "'.$name_block.'" a été modifié';
        
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
