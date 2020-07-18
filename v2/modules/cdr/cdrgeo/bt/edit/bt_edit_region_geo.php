<?php
if(isset($_POST['bt_edit_region_geo']))
{
    unset($_SESSION['msg_cdrgeo_done']);
    
    unset($_SESSION['msg_cdrgeo_cboCountryCDRgeoRegion'],
            $_SESSION['msg_cdrgeo_txtNameCDRgeoRegion'],
            $_SESSION['msg_cdrgeo_upload_region']);
    
    unset($_SESSION['cdrgeo_hiddenidCDRgeoRegion']);

    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoRegion'.$main_activatedidlang[$i]]); 
    }

    unset($_SESSION['cdrgeo_cboCountryCDRgeoRegion'],
            $_SESSION['cdrgeo_cboStatusCDRgeoRegion']);
    
    
    $Bok_cdrgeo_update = true;
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $cdrgeo_name_region[$i] = trim(htmlspecialchars(addslashes($_POST['txtNameCDRgeoRegion'.$main_activatedidlang[$i]]), ENT_QUOTES));
    }
    
    $cdrgeo_parent_region = htmlspecialchars($_POST['cboCountryCDRgeoRegion'], ENT_QUOTES);
    $cdrgeo_status_region = htmlspecialchars($_POST['cboStatusCDRgeoRegion'], ENT_QUOTES);
    $cdrgeo_id_region = htmlspecialchars($_POST['hiddenidCDRgeoRegion'], ENT_QUOTES);
    
    $upload_region = $_FILES['upload_cdrgeo_region']['name'];
    
    if($cdrgeo_parent_region == 'select')
    {
        $Bok_cdrgeo_update = false;
        $_SESSION['msg_cdrgeo_cboCountryCDRgeoRegion'] = 'sélectionnez un pays, si ce dernier n\'est pas dans la liste, veuillez en créer un';
    }
    
    
    
    for($i = 0, $count = count($cdrgeo_name_region); $i < $count; $i++)
    {
        if(empty($cdrgeo_name_region[0]))
        {
            $Bok_cdrgeo_update = false;
            $_SESSION['msg_cdrgeo_txtNameCDRgeoRegion'] = 'veuillez indiquer un nom pour cette langue';
        }
        else
        {       
            if($i > 0)
            {
                if(empty($cdrgeo_name_region[$i]))
                {
                    $cdrgeo_name_region[$i] = $cdrgeo_name_region[0];
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
            $query->bindParam('id', $cdrgeo_id_region);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $Bok_cdrgeo_imageupdate_region = 'true';
                $cdrgeo_idimage_region = $data[0];
            }
            else
            {
                $query->closeCursor();
                if(!empty($upload_region))
                {
                    $prepared_query = 'SELECT MAX(id_image) FROM cdrgeo_image';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    if(($data = $query->fetch()) != false)
                    {
                       $cdrgeo_idimage_region = $data[0]; 
                    }
                    $query->closeCursor();
                    $cdrgeo_idimage_region++;
                }
                else
                {
                    $cdrgeo_idimage_region = 0;
                }
                $Bok_cdrgeo_imageupdate_region = 'false';
                
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
        
        if(!empty($upload_region))
        {   
            $_SESSION['msg_cdrgeo_upload_region'] = 
            upload_file('upload_cdrgeo_region',
                        $cdrgeo_id_region.'region', 
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
                        $cdrgeo_id_region,
                        'cdrgeo_image',
                        null,
                        'false',
                        $Bok_cdrgeo_imageupdate_region,
                        $cdrgeo_idimage_region);
        }
        
        try
        {           
            $prepared_query = 'UPDATE cdrgeo
                               SET type_cdrgeo = :type,
                                   code_cdrgeo = :code, 
                                   position_cdrgeo = :position,
                                   status_cdrgeo = :status,
                                   statusobject_cdrgeo = :statusobject, 
                                   parentcountry_cdrgeo = :parent, 
                                   id_image = :image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$cdrgeo_name_region[$i].'"';
                }
                else
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].' = "'.$cdrgeo_name_region[$i].'", ';
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
                                  'code' => 'cdrgeo_region_situation',
                                  'position' => '1010',
                                  'status' => 1,
                                  'statusobject' => $cdrgeo_status_region,
                                  'parent' => $cdrgeo_parent_region,
                                  'image' => $cdrgeo_idimage_region,
                                  'id' => $cdrgeo_id_region
                                  )); 
            $query->closeCursor();           
            
            $_SESSION['cdrgeo_hiddenidCDRgeoRegion'] = $cdrgeo_id_region;
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoRegion'.$main_activatedidlang[$i]] = $cdrgeo_name_region[$i]; 
            }

            $_SESSION['cdrgeo_cboCountryCDRgeoRegion'] = $cdrgeo_parent_region;
            $_SESSION['cdrgeo_cboStatusCDRgeoRegion'] = $cdrgeo_status_region;
            
            $_SESSION['msg_cdrgeo_done'] = 'La région "'.$cdrgeo_name_region[$cdrgeo_selected_lang].'" a été modifiée';
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
        $_SESSION['cdrgeo_hiddenidCDRgeoRegion'] = $cdrgeo_id_region;
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
           $_SESSION['cdrgeo_txtNameCDRgeoRegion'.$main_activatedidlang[$i]] = $cdrgeo_name_region[$i]; 
        }

        $_SESSION['cdrgeo_cboCountryCDRgeoRegion'] = $cdrgeo_parent_region;
        $_SESSION['cdrgeo_cboStatusCDRgeoRegion'] = $cdrgeo_status_region;
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
