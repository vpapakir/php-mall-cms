<?php
if(isset($_POST['bt_save_main_skin']))
{  
    unset($_SESSION['msg_structure_edit_main_skin_txtNameSkin']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_skin = trim(htmlspecialchars($_POST['txtNameSkin'], ENT_QUOTES));
    
    $width_skin = trim(htmlspecialchars($_POST['txtWidthSkin'], ENT_QUOTES));
    $height_skin = trim(htmlspecialchars($_POST['txtHeightSkin'], ENT_QUOTES));
    $position_skin = trim(htmlspecialchars($_POST['txtPositionSkin'], ENT_QUOTES));
    $margin_skin = trim(htmlspecialchars($_POST['txtMarginSkin'], ENT_QUOTES));
    $border_skin = trim(htmlspecialchars($_POST['txtBorderSkin'], ENT_QUOTES));
    $bordercolor_skin = trim(htmlspecialchars($_POST['cboBordercolorSkin'], ENT_QUOTES));
    $tablebg_skin = trim(htmlspecialchars($_POST['cboTablebgSkin'], ENT_QUOTES));
    $cs_skin = trim(htmlspecialchars($_POST['txtCsSkin'], ENT_QUOTES));
    $cp_skin  = trim(htmlspecialchars($_POST['txtCpSkin'], ENT_QUOTES));
    
    $bgcolor_skin = trim(htmlspecialchars($_POST['cboBgcolorSkin'], ENT_QUOTES));
    $bgimage_skin = trim(htmlspecialchars($_POST['txtBgimageSkin'], ENT_QUOTES));
    $xrepeat_skin = trim(htmlspecialchars($_POST['txtXrepeatSkin'], ENT_QUOTES));
    $yrepeat_skin = trim(htmlspecialchars($_POST['txtYrepeatSkin'], ENT_QUOTES)); 
    
    $name_image_skin = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_skin = $_FILES['upload_skin']['name'];
    
    $id_image_skin = $_POST['rad_ImageSkin'];
    $use_image_skin = $_POST['chk_UseImageSkin'];
    
    if($use_image_skin == 'on')
    {
        $id_image_skin = 0;
    }

    $BoK_name_skin = true;  
    
    if(empty($name_skin))
    {
       $_SESSION['msg_structure_edit_main_skin_txtNameSkin'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_skin = false; 
    }
    
    if($BoK_name_skin === true)
    {
        if(!empty($upload_skin))
        {
            $_SESSION['msg_structure_edit_main_body_upload_body'] = 
            upload_file_skin('upload_skin',
                        $name_image_skin, 
                        5242880, 
                        1400, 
                        800, 
                        180, 
                        360,
                        100,
                        200,
                        'modules/custom/immo/graphic/skin/original/', 
                        'modules/custom/immo/graphic/skin/thumb/',
                        'modules/custom/immo/graphic/skin/search/',
                        'id_skin', 
                        $id_element);
        }
        
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_skin = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_skin[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_skin); $i++)
            {
                $name_image_skin = trim(htmlspecialchars($_POST['txtListNameImage'.$array_id_image_skin[$i]], ENT_QUOTES));
                $alt_image_skin = trim(htmlspecialchars($_POST['txtListAltImage'.$array_id_image_skin[$i]], ENT_QUOTES));
                $title_image_skin = trim(htmlspecialchars($_POST['txtListTitleImage'.$array_id_image_skin[$i]], ENT_QUOTES));
                $repeat_image_skin = trim(htmlspecialchars($_POST['cboListRepeatImage'.$array_id_image_skin[$i]], ENT_QUOTES));
                $attach_image_skin = trim(htmlspecialchars($_POST['cboListAttachImage'.$array_id_image_skin[$i]], ENT_QUOTES));
                
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
                                      'name' => $name_image_skin,
                                      'alt' => $alt_image_skin,
                                      'title' => $title_image_skin,
                                      'repeat' => $repeat_image_skin,
                                      'attach' => $attach_image_skin,
                                      'id' => $array_id_image_skin[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            $prepared_query = 'UPDATE structure_skin
                               SET name_skin = :name,
                                   width_skin = :width,
                                   height_skin = :height,
                                   position_skin = :position,
                                   margin_skin = :margin,
                                   border_skin = :border,
                                   bordercolor_skin = :bordercolor,
                                   tablebg_skin = :tablebg,
                                   cs_skin = :cs,
                                   cp_skin = :cp,
                                   bgcolor_skin = :bgcolor,
                                   bgimg_skin = :bgimage,
                                   xrepeat_skin = :xrepeat,
                                   yrepeat_skin = :yrepeat,
                                   id_image = :image
                               WHERE id_skin = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_skin,
                                  'width' => $width_skin,
                                  'height' => $height_skin,
                                  'position' => $position_skin,
                                  'margin' => $margin_skin,
                                  'border' => $border_skin,
                                  'bordercolor' => $bordercolor_skin,
                                  'tablebg' => $tablebg_skin,
                                  'cs' => $cs_skin,
                                  'cp' => $cp_skin,
                                  'bgcolor' => $bgcolor_skin,
                                  'bgimage' => $bgimage_skin,
                                  'xrepeat' => $xrepeat_skin,
                                  'yrepeat' => $yrepeat_skin,
                                  'image' => $id_image_skin,
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
