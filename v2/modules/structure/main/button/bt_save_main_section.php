<?php
if(isset($_POST['bt_save_main_section']))
{  
    unset($_SESSION['msg_structure_edit_main_section_txtNameSection']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_section = trim(htmlspecialchars($_POST['txtNameSection'], ENT_QUOTES));
    
    $width_section = trim(htmlspecialchars($_POST['txtWidthSection'], ENT_QUOTES));
    $height_section = trim(htmlspecialchars($_POST['txtHeightSection'], ENT_QUOTES));
    $position_section = trim(htmlspecialchars($_POST['txtPositionSection'], ENT_QUOTES));
    $margin_section = trim(htmlspecialchars($_POST['txtMarginSection'], ENT_QUOTES));
    $border_section = trim(htmlspecialchars($_POST['txtBorderSection'], ENT_QUOTES));
    $bordercolor_section = trim(htmlspecialchars($_POST['cboBordercolorSection'], ENT_QUOTES));
    $tablebg_section = trim(htmlspecialchars($_POST['cboTablebgSection'], ENT_QUOTES));
    $cs_section = trim(htmlspecialchars($_POST['txtCsSection'], ENT_QUOTES));
    $cp_section  = trim(htmlspecialchars($_POST['txtCpSection'], ENT_QUOTES));
    
    $bgcolor_section = trim(htmlspecialchars($_POST['cboBgcolorSection'], ENT_QUOTES));
    $bgimage_section = trim(htmlspecialchars($_POST['txtBgimageSection'], ENT_QUOTES));
    $xrepeat_section = trim(htmlspecialchars($_POST['txtXrepeatSection'], ENT_QUOTES));
    $yrepeat_section = trim(htmlspecialchars($_POST['txtYrepeatSection'], ENT_QUOTES));
    
    $radius_lt_section = trim(htmlspecialchars($_POST['txtBorderRadiusLTSection'], ENT_QUOTES));
    $radius_rt_section = trim(htmlspecialchars($_POST['txtBorderRadiusRTSection'], ENT_QUOTES));
    $radius_rb_section = trim(htmlspecialchars($_POST['txtBorderRadiusRBSection'], ENT_QUOTES));
    $radius_lb_section = trim(htmlspecialchars($_POST['txtBorderRadiusLBSection'], ENT_QUOTES));
    
    if(empty($radius_lt_section) ? $radius_lt_section = 0 : $radius_lt_section = $radius_lt_section);
    if(empty($radius_rt_section) ? $radius_rt_section = 0 : $radius_rt_section = $radius_rt_section);
    if(empty($radius_rb_section) ? $radius_rb_section = 0 : $radius_rb_section = $radius_rb_section);
    if(empty($radius_lb_section) ? $radius_lb_section = 0 : $radius_lb_section = $radius_lb_section);
    
    $radius_section = $radius_lt_section.'$'.$radius_rt_section.'$'.$radius_rb_section.'$'.$radius_lb_section;

    $BoK_name_section = true;  
    
    if(empty($name_section))
    {
       $_SESSION['msg_structure_edit_main_section_txtNameSection'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_section = false; 
    }
    
    if($BoK_name_section === true)
    {        
        try
        {
            $prepared_query = 'UPDATE structure_section
                               SET name_section = :name,
                                   width_section = :width,
                                   height_section = :height,
                                   position_section = :position,
                                   margin_section = :margin,
                                   border_section = :border,
                                   bordercolor_section = :bordercolor,
                                   tablebg_section = :tablebg,
                                   cs_section = :cs,
                                   cp_section = :cp,
                                   bgcolor_section = :bgcolor,
                                   bgimg_section = :bgimage,
                                   xrepeat_section = :xrepeat,
                                   yrepeat_section = :yrepeat,
                                   radius_section = :radius
                               WHERE id_section = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_section,
                                  'width' => $width_section,
                                  'height' => $height_section,
                                  'position' => $position_section,
                                  'margin' => $margin_section,
                                  'border' => $border_section,
                                  'bordercolor' => $bordercolor_section,
                                  'tablebg' => $tablebg_section,
                                  'cs' => $cs_section,
                                  'cp' => $cp_section,
                                  'bgcolor' => $bgcolor_section,
                                  'bgimage' => $bgimage_section,
                                  'xrepeat' => $xrepeat_section,
                                  'yrepeat' => $yrepeat_section,
                                  'radius' => $radius_section,
                                  'id' => $id_element
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
