<?php
if(isset($_POST['bt_edit_department_geo']))
{
    unset($_SESSION['msg_cdrgeo_done']);
    
    unset($_SESSION['msg_cdrgeo_cboRegionCDRgeoDepartment'],
            $_SESSION['msg_cdrgeo_txtNameCDRgeoDepartment'],
            $_SESSION['msg_cdrgeo_upload_department']);
    
    unset($_SESSION['cdrgeo_hiddenidCDRgeoDepartment']);

    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$main_activatedidlang[$i]]); 
    }

    unset($_SESSION['cdrgeo_cboRegionCDRgeoDepartment'],
            $_SESSION['cdrgeo_cboStatusCDRgeoDepartment']);
    
    
    $Bok_cdrgeo_update = true;
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $cdrgeo_name_department[$i] = trim(htmlspecialchars(addslashes($_POST['txtNameCDRgeoDepartment'.$main_activatedidlang[$i]]), ENT_QUOTES));
    }
    
    $cdrgeo_parent_department = htmlspecialchars($_POST['cboRegionCDRgeoDepartment'], ENT_QUOTES);
    $cdrgeo_status_department = htmlspecialchars($_POST['cboStatusCDRgeoDepartment'], ENT_QUOTES);
    $cdrgeo_id_department = htmlspecialchars($_POST['hiddenidCDRgeoDepartment'], ENT_QUOTES);
    
    $upload_department = $_FILES['upload_cdrgeo_department']['name'];
    
    if($cdrgeo_parent_department == 'select')
    {
        $Bok_cdrgeo_update = false;
        $_SESSION['msg_cdrgeo_cboRegionCDRgeoDepartment'] = 'sélectionnez une région, si cette dernière n\'est pas dans la liste, veuillez en créer une';
    }
    
    
    
    for($i = 0, $count = count($cdrgeo_name_department); $i < $count; $i++)
    {
        if(empty($cdrgeo_name_department[0]))
        {
            $Bok_cdrgeo_update = false;
            $_SESSION['msg_cdrgeo_txtNameCDRgeoDepartment'] = 'veuillez indiquer un nom pour cette langue';
        }
        else
        {       
            if($i > 0)
            {
                if(empty($cdrgeo_name_department[$i]))
                {
                    $cdrgeo_name_department[$i] = $cdrgeo_name_department[0];
                }
            }
        }
    }
    
    
    
    if($Bok_cdrgeo_update === true)
    {
        try
        {
            $prepared_query = 'SELECT id_image FROM cdrgeo_image
                               WHERE id_cdrgeo = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $cdrgeo_id_department);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $Bok_cdrgeo_imageupdate_department = 'true';
                $cdrgeo_idimage_department = $data[0];
            }
            else
            {
                $query->closeCursor();
                if(!empty($upload_department))
                {
                    $prepared_query = 'SELECT MAX(id_image) FROM cdrgeo_image';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    if(($data = $query->fetch()) != false)
                    {
                       $cdrgeo_idimage_department = $data[0]; 
                    }
                    $query->closeCursor();
                    $cdrgeo_idimage_department++;
                }
                else
                {
                    $cdrgeo_idimage_department = 0;
                }
                $Bok_cdrgeo_imageupdate_department = 'false';
                
            }
            
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
        
        if(!empty($upload_department))
        {   
            $_SESSION['msg_cdrgeo_upload_department'] = 
            upload_file('upload_cdrgeo_department',
                        $cdrgeo_id_department.'department', 
                        5242880, 
                        1400, 
                        800, 
                        180, 
                        360,
                        100,
                        200,
                        'images/cdrgeo/original/', 
                        'images/cdrgeo/thumb/',
                        'images/cdrgeo/search/',
                        'id_cdrgeo', 
                        $cdrgeo_id_department,
                        'cdrgeo_image',
                        null,
                        'false',
                        $Bok_cdrgeo_imageupdate_department,
                        $cdrgeo_idimage_department);
        }
        
        try
        {           
            $prepared_query = 'UPDATE cdrgeo
                               SET type_cdrgeo = :type,
                                   code_cdrgeo = :code, 
                                   position_cdrgeo = :position,
                                   status_cdrgeo = :status,
                                   statusobject_cdrgeo = :statusobject, 
                                   parentregion_cdrgeo = :parent, 
                                   id_image = :image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$cdrgeo_name_department[$i].'"';
                }
                else
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$cdrgeo_name_department[$i].'", ';
                }
                
                if($main_activatedidlang[$i] == $main_id_language)
                {
                    $cdrgeo_selected_lang = $i;
                }
            }

            $prepared_query .= ' WHERE id_cdrgeo = :id';                                
                               
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'type' => 'dropdown',
                                  'code' => 'cdrgeo_department_situation',
                                  'position' => '1010',
                                  'status' => 1,
                                  'statusobject' => $cdrgeo_status_department,
                                  'parent' => $cdrgeo_parent_department,
                                  'image' => $cdrgeo_idimage_department,
                                  'id' => $cdrgeo_id_department
                                  )); 
            $query->closeCursor();           
            
            $_SESSION['cdrgeo_hiddenidCDRgeoDepartment'] = $cdrgeo_id_department;
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$main_activatedidlang[$i]] = $cdrgeo_name_department[$i]; 
            }

            $_SESSION['cdrgeo_cboRegionCDRgeoDepartment'] = $cdrgeo_parent_department;
            $_SESSION['cdrgeo_cboStatusCDRgeoDepartment'] = $cdrgeo_status_department;
            
            $_SESSION['msg_cdrgeo_done'] = 'Le département "'.$cdrgeo_name_department[$cdrgeo_selected_lang].'" a été modifié';
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
    else
    {
        $_SESSION['cdrgeo_hiddenidCDRgeoDepartment'] = $cdrgeo_id_department;
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
           $_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$main_activatedidlang[$i]] = $cdrgeo_name_department[$i]; 
        }

        $_SESSION['cdrgeo_cboRegionCDRgeoDepartment'] = $cdrgeo_parent_department;
        $_SESSION['cdrgeo_cboStatusCDRgeoDepartment'] = $cdrgeo_status_department;
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
