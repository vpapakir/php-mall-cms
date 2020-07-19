<?php
if(isset($_POST['bt_save_main_body']))
{  
    unset($_SESSION['msg_structure_edit_main_body_txtNameBody'], $_SESSION['msg_structure_edit_main_logo_upload_body']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_body = trim(htmlspecialchars($_POST['txtNameBody'], ENT_QUOTES));
    $bgcolor_body = trim(htmlspecialchars($_POST['cboBgcolorBody'], ENT_QUOTES)); 
    
    $name_image_body = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_body = $_FILES['upload_body']['name'];
    
    $id_image_body = $_POST['rad_ImageBody'];
    $use_image_body = $_POST['chk_UseImageBody'];
    
    if($use_image_body == 'on')
    {
        $id_image_body = 0;
    }

    $BoK_name_body = true;  
    
    if(empty($name_body))
    {
       $_SESSION['msg_structure_edit_main_body_txtNameBody'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_body = false; 
    }
    
    if($BoK_name_body === true)
    {        
        if(!empty($upload_body))
        {
            $_SESSION['msg_structure_edit_main_body_upload_body'] = 
            upload_file('upload_body',
                        $name_image_body, 
                        5242880, 
                        1400, 
                        800, 
                        180, 
                        360,
                        100,
                        200,
                        'modules/custom/immo/graphic/body/original/', 
                        'modules/custom/immo/graphic/body/thumb/',
                        'modules/custom/immo/graphic/body/search/',
                        'id_body', 
                        $id_element);
        }
        
        try
        {
            $prepared_query = 'SELECT * FROM structure_image
                               WHERE id_body = :id
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $id_element);
            $query->execute();

            $i = 0;

            while($data = $query->fetch())
            {
                $array_id_image_body[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            for($i = 0 ; $i < count($array_id_image_body); $i++)
            {
                $name_image_body = trim(htmlspecialchars($_POST['txtListNameImage'.$array_id_image_body[$i]], ENT_QUOTES));
                $alt_image_body = trim(htmlspecialchars($_POST['txtListAltImage'.$array_id_image_body[$i]], ENT_QUOTES));
                $title_image_body = trim(htmlspecialchars($_POST['txtListTitleImage'.$array_id_image_body[$i]], ENT_QUOTES));
                $repeat_image_body = trim(htmlspecialchars($_POST['cboListRepeatImage'.$array_id_image_body[$i]], ENT_QUOTES));
                $attach_image_body = trim(htmlspecialchars($_POST['cboListAttachImage'.$array_id_image_body[$i]], ENT_QUOTES));
                
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
                                      'name' => $name_image_body,
                                      'alt' => $alt_image_body,
                                      'title' => $title_image_body,
                                      'repeat' => $repeat_image_body,
                                      'attach' => $attach_image_body,
                                      'id' => $array_id_image_body[$i]
                                      ));
                $query->closeCursor(); 
            }
            
            $prepared_query = 'UPDATE structure_body
                               SET name_body = :name,
                                   bgcolor_body = :bgcolor,
                                   id_image = :id_image
                               WHERE id_body = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_body,
                                  'bgcolor' => $bgcolor_body,
                                  'id_image' => $id_image_body,
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
