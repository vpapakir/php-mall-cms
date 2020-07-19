<?php
if(isset($_POST['bt_save_main_logo']))
{  
    for($k = 0, $countk = count($main_activatedidlang); $k < $countk; $k++)
    {
        $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] = trim(htmlspecialchars($_POST['expand_structureedit_logo'.$main_activatedidlang[$k]], ENT_QUOTES));
    }
    
    unset($_SESSION['msg_structure_edit_main_logo_txtNameLogo'], $_SESSION['msg_structure_edit_main_logo_upload_logo']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_logo = trim(htmlspecialchars($_POST['txtNameLogo'], ENT_QUOTES));     
    
    $text_logo = trim(htmlspecialchars($_POST['txtTextLogo'], ENT_QUOTES));
    $font_logo = trim($_POST['cboFontLogo']);
    $size_logo = trim(htmlspecialchars($_POST['txtFontSizeLogo'], ENT_QUOTES));
    $weight_logo = trim(htmlspecialchars($_POST['cboFontWeightLogo'], ENT_QUOTES));
    $align_logo = trim(htmlspecialchars($_POST['cboFontAlignLogo'], ENT_QUOTES));
    $color_logo = trim(htmlspecialchars($_POST['cboBgcolorLogo'], ENT_QUOTES)); 
    
    $marginl_logo = trim(htmlspecialchars($_POST['txtMarginLLogo'], ENT_QUOTES));
    $marginr_logo = trim(htmlspecialchars($_POST['txtMarginRLogo'], ENT_QUOTES));
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $scriptpath_logo[$i] = trim(htmlspecialchars($_POST['txtScriptPathLogo'.$main_activatedidlang[$i]], ENT_QUOTES));
        $scriptcode_logo[$i] = trim($_POST['areaScriptCodeLogo'.$main_activatedidlang[$i]]);
        $id_image_logo[$i] = $_POST['rad_ImageLogo'.$main_activatedidlang[$i]];
        $use_image_logo[$i] = $_POST['chk_UseImageLogo'.$main_activatedidlang[$i]];
        
        if($use_image_logo[$i] == 'on')
        {
            $id_image_logo[$i] = 0;
        }
    }
    
    $temp_scriptpath_logo = null;
    $temp_scriptcode_logo = null;
    $temp_id_image_logo = null;
    $id_language_logo = null;
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        if(empty($temp_id_image_logo))
        {
            $temp_id_image_logo = $id_image_logo[$i];
            $id_language_logo = $main_activatedidlang[$i];
            $temp_scriptpath_logo = $scriptpath_logo[$i];
            $temp_scriptcode_logo = $scriptcode_logo[$i];
        }
        else 
        {
            $temp_id_image_logo .= '$'.$id_image_logo[$i];
            $id_language_logo .= '$'.$main_activatedidlang[$i];
            $temp_scriptpath_logo .= '$'.$scriptpath_logo[$i];
            $temp_scriptcode_logo .= '$'.$scriptcode_logo[$i];
        }
    }
    
    $name_image_logo = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_logo = $_FILES['upload_logo']['name'];
    
    if(empty($marginl_logo) ? $marginl_logo = 0 : $marginl_logo = $marginl_logo);
    if(empty($marginr_logo) ? $marginr_logo = 0 : $marginr_logo = $marginr_logo);
    
    

    $BoK_name_logo = true;  
    
    if(empty($name_logo))
    {
       $_SESSION['msg_structure_edit_main_logo_txtNameLogo'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_logo = false; 
    }
    
    if($BoK_name_logo === true)
    { 
        if(!empty($upload_logo))
        {
            $_SESSION['msg_structure_edit_main_logo_upload_logo'] = upload_file('upload_logo',
                    $name_image_logo, 
                    5242880, 
                    600, 
                    1200, 
                    180, 
                    360,
                    100,
                    200,
                    'modules/custom/immo/graphic/logo/original/', 
                    'modules/custom/immo/graphic/logo/thumb/',
                    'modules/custom/immo/graphic/logo/search/',
                    'id_logo', 
                    $id_element);
        }
        
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_logo = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_logo[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_logo); $i++)
            {
                $name_image_logo = trim(htmlspecialchars($_POST['txtListNameImage'.$array_id_image_logo[$i]], ENT_QUOTES));
                $alt_image_logo = trim(htmlspecialchars($_POST['txtListAltImage'.$array_id_image_logo[$i]], ENT_QUOTES));
                $title_image_logo = trim(htmlspecialchars($_POST['txtListTitleImage'.$array_id_image_logo[$i]], ENT_QUOTES));
                $repeat_image_logo = trim(htmlspecialchars($_POST['cboListRepeatImage'.$array_id_image_logo[$i]], ENT_QUOTES));
                
                $prepared_query = 'UPDATE structure_image
                                   SET name_image = :name,
                                       alt_image = :alt,
                                       title_image = :title,
                                       repeat_image = :repeat
                                   WHERE id_image = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'name' => $name_image_logo,
                                      'alt' => $alt_image_logo,
                                      'title' => $title_image_logo,
                                      'repeat' => $repeat_image_logo,
                                      'id' => $array_id_image_logo[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            $prepared_query = 'UPDATE structure_logo
                               SET name_logo = :name,
                                   text_logo = :text,
                                   font_logo = :font,
                                   size_logo = :size,
                                   weight_logo = :weight,
                                   align_logo = :align,
                                   color_logo = :color,
                                   scriptpath_logo = :path,
                                   scriptcode_logo = :code,
                                   marginl_logo = :marginl,
                                   marginr_logo = :marginr,
                                   id_image = :image,
                                   id_language = :language
                               WHERE id_logo = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_logo,
                                  'text' => $text_logo,
                                  'font' => $font_logo,
                                  'size' => $size_logo,
                                  'weight' => $weight_logo,
                                  'align' => $align_logo,
                                  'color' => $color_logo,
                                  'path' => $temp_scriptpath_logo,
                                  'code' => $temp_scriptcode_logo,
                                  'image' => $temp_id_image_logo,
                                  'language' => $id_language_logo,
                                  'marginl' => $marginl_logo,
                                  'marginr' => $marginr_logo,
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
                die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
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
