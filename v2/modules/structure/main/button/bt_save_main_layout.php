<?php
if(isset($_POST['bt_save_main_layout']))
{  
    unset($_SESSION['msg_structure_edit_main_layout_txtNameLayout'],
            $_SESSION['msg_structure_edit_main_layout_upload_layout_top'],
            $_SESSION['msg_structure_edit_main_layout_upload_layout_middle'],
            $_SESSION['msg_structure_edit_main_layout_upload_layout_bottom']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_layout = trim(htmlspecialchars($_POST['txtNameLayout'], ENT_QUOTES));
    
    $width_layout = trim(htmlspecialchars($_POST['txtWidthLayout'], ENT_QUOTES));
    $height_layout = trim(htmlspecialchars($_POST['txtHeightLayout'], ENT_QUOTES));
    $position_layout = trim(htmlspecialchars($_POST['txtPositionLayout'], ENT_QUOTES));
    $margin_layout = trim(htmlspecialchars($_POST['txtMarginLayout'], ENT_QUOTES));
    $border_layout = trim(htmlspecialchars($_POST['txtBorderLayout'], ENT_QUOTES));
    $bordercolor_layout = trim(htmlspecialchars($_POST['cboBordercolorLayout'], ENT_QUOTES));
    $tablebg_layout = trim(htmlspecialchars($_POST['cboTablebgLayout'], ENT_QUOTES));
    $cs_layout = trim(htmlspecialchars($_POST['txtCsLayout'], ENT_QUOTES));
    $cp_layout  = trim(htmlspecialchars($_POST['txtCpLayout'], ENT_QUOTES));
    
    $bgcolor_layout = trim(htmlspecialchars($_POST['cboBgcolorLayout'], ENT_QUOTES));
    $bgimage_layout = trim(htmlspecialchars($_POST['txtBgimageLayout'], ENT_QUOTES));
    $xrepeat_layout = trim(htmlspecialchars($_POST['txtXrepeatLayout'], ENT_QUOTES));
    $yrepeat_layout = trim(htmlspecialchars($_POST['txtYrepeatLayout'], ENT_QUOTES));    

    $radius_lt_layout = trim(htmlspecialchars($_POST['txtBorderRadiusLTLayout'], ENT_QUOTES));
    $radius_rt_layout = trim(htmlspecialchars($_POST['txtBorderRadiusRTLayout'], ENT_QUOTES));
    $radius_rb_layout = trim(htmlspecialchars($_POST['txtBorderRadiusRBLayout'], ENT_QUOTES));
    $radius_lb_layout = trim(htmlspecialchars($_POST['txtBorderRadiusLBLayout'], ENT_QUOTES));
    
    if(empty($radius_lt_layout) ? $radius_lt_layout = 0 : $radius_lt_layout = $radius_lt_layout);
    if(empty($radius_rt_layout) ? $radius_rt_layout = 0 : $radius_rt_layout = $radius_rt_layout);
    if(empty($radius_rb_layout) ? $radius_rb_layout = 0 : $radius_rb_layout = $radius_rb_layout);
    if(empty($radius_lb_layout) ? $radius_lb_layout = 0 : $radius_lb_layout = $radius_lb_layout);
    
    $radius_section = $radius_lt_layout.'$'.$radius_rt_layout.'$'.$radius_rb_layout.'$'.$radius_lb_layout;
    
    $name_image_layout_top = trim(htmlspecialchars($_POST['txtNameImageTop'], ENT_QUOTES));
    $upload_layout_top = $_FILES['upload_layout_top']['name'];
    $id_image_layout_top = $_POST['rad_ImageLayoutTop'];
    $use_image_layout_top = $_POST['chk_UseImageLayoutTop'];
    $width_image_layout_top = trim(htmlspecialchars($_POST['txtWidthImageTop'], ENT_QUOTES));
    $height_image_layout_top = trim(htmlspecialchars($_POST['txtHeightImageTop'], ENT_QUOTES));
    $height_layout_top = trim(htmlspecialchars($_POST['txtHeightTop'], ENT_QUOTES));
    
    if(empty($width_image_layout_top))
    {
        $width_image_layout_top = 970;
    }
    
    if(empty($height_image_layout_top))
    {
        $height_image_layout_top = 500;
    }
    
    if($use_image_layout_top == 'on')
    {
        $id_image_layout_top = 0;
    }
    
    $name_image_layout_middle = trim(htmlspecialchars($_POST['txtNameImageMiddle'], ENT_QUOTES));
    $upload_layout_middle = $_FILES['upload_layout_middle']['name'];
    $id_image_layout_middle = $_POST['rad_ImageLayoutMiddle'];
    $use_image_layout_middle = $_POST['chk_UseImageLayoutMiddle'];
    $width_image_layout_middle = trim(htmlspecialchars($_POST['txtWidthImageMiddle'], ENT_QUOTES));
    $height_image_layout_middle = trim(htmlspecialchars($_POST['txtHeightImageMiddle'], ENT_QUOTES));
    $height_layout_middle = trim(htmlspecialchars($_POST['txtHeightMiddle'], ENT_QUOTES));
    
    
    if(empty($width_image_layout_middle))
    {
        $width_image_layout_middle = 970;
    }
    
    if(empty($height_image_layout_middle))
    {
        $height_image_layout_middle = 500;
    }
    
    if($use_image_layout_middle == 'on')
    {
        $id_image_layout_middle = 0;
    }
    
    $name_image_layout_bottom = trim(htmlspecialchars($_POST['txtNameImageBottom'], ENT_QUOTES));
    $upload_layout_bottom = $_FILES['upload_layout_bottom']['name'];
    $id_image_layout_bottom = $_POST['rad_ImageLayoutBottom'];
    $use_image_layout_bottom = $_POST['chk_UseImageLayoutBottom'];
    $width_image_layout_bottom = trim(htmlspecialchars($_POST['txtWidthImageBottom'], ENT_QUOTES));
    $height_image_layout_bottom = trim(htmlspecialchars($_POST['txtHeightImageBottom'], ENT_QUOTES));
    $height_layout_bottom = trim(htmlspecialchars($_POST['txtHeightBottom'], ENT_QUOTES));
    
    if(empty($width_image_layout_bottom))
    {
        $width_image_layout_bottom = 970;
    }
    
    if(empty($height_image_layout_bottom))
    {
        $height_image_layout_bottom = 500;
    }
    
    if($use_image_layout_bottom == 'on')
    {
        $id_image_layout_bottom = 0;
    }
    
    if(empty($height_layout_top) ? $height_layout_top = 0 : $height_layout_top = $height_layout_top);
    if(empty($height_layout_middle) ? $height_layout_middle = 0 : $height_layout_middle = $height_layout_middle);
    if(empty($height_layout_bottom) ? $height_layout_bottom = 0 : $height_layout_bottom = $height_layout_bottom);
    
    $heightpart_layout = $height_layout_top.'$'.$height_layout_middle.'$'.$height_layout_bottom;
    
    $BoK_name_layout = true;  
    
    if(empty($name_layout))
    {
       $_SESSION['msg_structure_edit_main_layout_txtNameLayout'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_layout = false; 
    }
    
    if($BoK_name_layout === true)
    {   
        if(!empty($upload_layout_top))
        {
            $_SESSION['msg_structure_edit_main_layout_upload_layout_top'] = 
            upload_file('upload_layout_top',
                        $name_image_layout_top, 
                        5242880, 
                        $width_image_layout_top, 
                        $height_image_layout_top, 
                        180, 
                        360,
                        100,
                        200,
                        'modules/custom/immo/graphic/layout/layout_top/original/', 
                        'modules/custom/immo/graphic/layout/layout_top/thumb/',
                        'modules/custom/immo/graphic/layout/layout_top/search/',
                        'id_layout_top', 
                        $id_element);
        }
        
        if(!empty($upload_layout_middle))
        {
            $_SESSION['msg_structure_edit_main_layout_upload_layout_middle'] = 
            upload_file('upload_layout_middle',
                        $name_image_layout_middle, 
                        5242880, 
                        $width_image_layout_middle, 
                        $height_image_layout_middle, 
                        180, 
                        360,
                        100,
                        200,
                        'modules/custom/immo/graphic/layout/layout_middle/original/', 
                        'modules/custom/immo/graphic/layout/layout_middle/thumb/',
                        'modules/custom/immo/graphic/layout/layout_middle/search/',
                        'id_layout_middle', 
                        $id_element);
        }
        
        if(!empty($upload_layout_bottom))
        {
            $_SESSION['msg_structure_edit_main_layout_upload_layout_bottom'] = 
            upload_file('upload_layout_bottom',
                        $name_image_layout_bottom, 
                        5242880, 
                        $width_image_layout_bottom, 
                        $height_image_layout_bottom, 
                        180, 
                        360,
                        100,
                        200,
                        'modules/custom/immo/graphic/layout/layout_bottom/original/', 
                        'modules/custom/immo/graphic/layout/layout_bottom/thumb/',
                        'modules/custom/immo/graphic/layout/layout_bottom/search/',
                        'id_layout_bottom', 
                        $id_element);
        }
        
        try
        {
            #top
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_layout_top = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_layout_top[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_layout_top); $i++)
            {
                $name_image_layout_top = trim(htmlspecialchars($_POST['txtListNameImageTop'.$array_id_image_layout_top[$i]], ENT_QUOTES));
                $alt_image_layout_top = trim(htmlspecialchars($_POST['txtListAltImageTop'.$array_id_image_layout_top[$i]], ENT_QUOTES));
                $title_image_layout_top = trim(htmlspecialchars($_POST['txtListTitleImageTop'.$array_id_image_layout_top[$i]], ENT_QUOTES));
                $repeat_image_layout_top = trim(htmlspecialchars($_POST['cboListRepeatImageTop'.$array_id_image_layout_top[$i]], ENT_QUOTES));
                $attach_image_layout_top = trim(htmlspecialchars($_POST['cboListAttachImageTop'.$array_id_image_layout_top[$i]], ENT_QUOTES));
                
                $prepared_query = 'UPDATE structure_image
                                   SET name_image = :name,
                                       alt_image = :alt,
                                       title_image = :title,
                                       repeat_image = :repeat,
                                       attachment_image = :attach
                                   WHERE id_image = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'name' => $name_image_layout_top,
                                      'alt' => $alt_image_layout_top,
                                      'title' => $title_image_layout_top,
                                      'repeat' => $repeat_image_layout_top,
                                      'attach' => $attach_image_layout_top,
                                      'id' => $array_id_image_layout_top[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            #middle
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_layout_middle = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_layout_middle[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_layout_middle); $i++)
            {
                $name_image_layout_middle = trim(htmlspecialchars($_POST['txtListNameImageMiddle'.$array_id_image_layout_middle[$i]], ENT_QUOTES));
                $alt_image_layout_middle = trim(htmlspecialchars($_POST['txtListAltImageMiddle'.$array_id_image_layout_middle[$i]], ENT_QUOTES));
                $title_image_layout_middle = trim(htmlspecialchars($_POST['txtListTitleImageMiddle'.$array_id_image_layout_middle[$i]], ENT_QUOTES));
                $repeat_image_layout_middle = trim(htmlspecialchars($_POST['cboListRepeatImageMiddle'.$array_id_image_layout_middle[$i]], ENT_QUOTES));
                $attach_image_layout_middle = trim(htmlspecialchars($_POST['cboListAttachImageMiddle'.$array_id_image_layout_middle[$i]], ENT_QUOTES));
                
                $prepared_query = 'UPDATE structure_image
                                   SET name_image = :name,
                                       alt_image = :alt,
                                       title_image = :title,
                                       repeat_image = :repeat,
                                       attachment_image = :attach
                                   WHERE id_image = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'name' => $name_image_layout_middle,
                                      'alt' => $alt_image_layout_middle,
                                      'title' => $title_image_layout_middle,
                                      'repeat' => $repeat_image_layout_middle,
                                      'attach' => $attach_image_layout_middle,
                                      'id' => $array_id_image_layout_middle[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            #bottom
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_layout_bottom = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_layout_bottom[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_layout_bottom); $i++)
            {
                $name_image_layout_bottom = trim(htmlspecialchars($_POST['txtListNameImageBottom'.$array_id_image_layout_bottom[$i]], ENT_QUOTES));
                $alt_image_layout_bottom = trim(htmlspecialchars($_POST['txtListAltImageBottom'.$array_id_image_layout_bottom[$i]], ENT_QUOTES));
                $title_image_layout_bottom = trim(htmlspecialchars($_POST['txtListTitleImageBottom'.$array_id_image_layout_bottom[$i]], ENT_QUOTES));
                $repeat_image_layout_bottom = trim(htmlspecialchars($_POST['cboListRepeatImageBottom'.$array_id_image_layout_bottom[$i]], ENT_QUOTES));
                $attach_image_layout_bottom = trim(htmlspecialchars($_POST['cboListAttachImageBottom'.$array_id_image_layout_bottom[$i]], ENT_QUOTES));
                
                $prepared_query = 'UPDATE structure_image
                                   SET name_image = :name,
                                       alt_image = :alt,
                                       title_image = :title,
                                       repeat_image = :repeat,
                                       attachment_image = :attach
                                   WHERE id_image = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'name' => $name_image_layout_bottom,
                                      'alt' => $alt_image_layout_bottom,
                                      'title' => $title_image_layout_bottom,
                                      'repeat' => $repeat_image_layout_bottom,
                                      'attach' => $attach_image_layout_bottom,
                                      'id' => $array_id_image_layout_bottom[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            $prepared_query = 'UPDATE structure_layout
                               SET name_layout = :name,
                                   width_layout = :width,
                                   height_layout = :height,
                                   position_layout = :position,
                                   margin_layout = :margin,
                                   border_layout = :border,
                                   bordercolor_layout = :bordercolor,
                                   tablebg_layout = :tablebg,
                                   cs_layout = :cs,
                                   cp_layout = :cp,
                                   bgcolor_layout = :bgcolor,
                                   bgimg_layout = :bgimage,
                                   xrepeat_layout = :xrepeat,
                                   yrepeat_layout = :yrepeat,
                                   radius_layout = :radius,
                                   id_image_top = :image_top,
                                   id_image_middle = :image_middle,
                                   id_image_bottom = :image_bottom,
                                   heightpart_layout = :heightpart
                               WHERE id_layout = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_layout,
                                  'width' => $width_layout,
                                  'height' => $height_layout,
                                  'position' => $position_layout,
                                  'margin' => $margin_layout,
                                  'border' => $border_layout,
                                  'bordercolor' => $bordercolor_layout,
                                  'tablebg' => $tablebg_layout,
                                  'cs' => $cs_layout,
                                  'cp' => $cp_layout,
                                  'bgcolor' => $bgcolor_layout,
                                  'bgimage' => $bgimage_layout,
                                  'xrepeat' => $xrepeat_layout,
                                  'yrepeat' => $yrepeat_layout,
                                  'radius' => $radius_section,
                                  'id' => $id_element,
                                  'image_top' => $id_image_layout_top,
                                  'image_middle' => $id_image_layout_middle,
                                  'image_bottom' => $id_image_layout_bottom,
                                  'heightpart' => $heightpart_layout
                                  ));
            $query->closeCursor();         
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
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }
}
?>
