<?php
if(isset($_POST['bt_save_main_frame']))
{  
    unset($_SESSION['msg_structure_edit_main_frame_txtNameFrame']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_frame = trim(htmlspecialchars($_POST['txtNameFrame'], ENT_QUOTES));
    
    $width_frame = trim(htmlspecialchars($_POST['txtWidthFrame'], ENT_QUOTES));
    $height_frame = trim(htmlspecialchars($_POST['txtHeightFrame'], ENT_QUOTES));
    $position_frame = trim(htmlspecialchars($_POST['txtPositionFrame'], ENT_QUOTES));
    $margin_frame = trim(htmlspecialchars($_POST['txtMarginFrame'], ENT_QUOTES));
    $border_frame = trim(htmlspecialchars($_POST['txtBorderFrame'], ENT_QUOTES));
    $bordercolor_frame = trim(htmlspecialchars($_POST['cboBordercolorFrame'], ENT_QUOTES));
    $tablebg_frame = trim(htmlspecialchars($_POST['cboTablebgFrame'], ENT_QUOTES));
    $cs_frame = trim(htmlspecialchars($_POST['txtCsFrame'], ENT_QUOTES));
    $cp_frame  = trim(htmlspecialchars($_POST['txtCpFrame'], ENT_QUOTES));
    
    $bgcolor_frame = trim(htmlspecialchars($_POST['cboBgcolorFrame'], ENT_QUOTES));
    $bgimage_frame = trim(htmlspecialchars($_POST['txtBgimageFrame'], ENT_QUOTES));
    $xrepeat_frame = trim(htmlspecialchars($_POST['txtXrepeatFrame'], ENT_QUOTES));
    $yrepeat_frame = trim(htmlspecialchars($_POST['txtYrepeatFrame'], ENT_QUOTES));   
    $status_frame = trim(htmlspecialchars($_POST['cboStatusFrame'], ENT_QUOTES));   

    $BoK_name_frame = true;  
    
    if(empty($name_frame))
    {
       $_SESSION['msg_structure_edit_main_frame_txtNameFrame'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_frame = false; 
    }
    
    if($BoK_name_frame === true)
    {        
        try
        {
            $prepared_query = 'UPDATE structure_frame
                               SET name_frame = :name,
                                   width_frame = :width,
                                   height_frame = :height,
                                   position_frame = :position,
                                   margin_frame = :margin,
                                   border_frame = :border,
                                   bordercolor_frame = :bordercolor,
                                   tablebg_frame = :tablebg,
                                   cs_frame = :cs,
                                   cp_frame = :cp,
                                   bgcolor_frame = :bgcolor,
                                   bgimg_frame = :bgimage,
                                   xrepeat_frame = :xrepeat,
                                   yrepeat_frame = :yrepeat,
                                   status_frame = :status
                               WHERE id_frame = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_frame,
                                  'width' => $width_frame,
                                  'height' => $height_frame,
                                  'position' => $position_frame,
                                  'margin' => $margin_frame,
                                  'border' => $border_frame,
                                  'bordercolor' => $bordercolor_frame,
                                  'tablebg' => $tablebg_frame,
                                  'cs' => $cs_frame,
                                  'cp' => $cp_frame,
                                  'bgcolor' => $bgcolor_frame,
                                  'bgimage' => $bgimage_frame,
                                  'xrepeat' => $xrepeat_frame,
                                  'yrepeat' => $yrepeat_frame,
                                  'status' => $status_frame,
                                  'id' => $id_element,
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
