<?php
if(isset($_POST['bt_add_district_geo']))
{
    unset($_SESSION['msg_cdrgeo_done']);
    
    unset($_SESSION['msg_cdrgeo_cboDepartmentCDRgeoDistrict'],
            $_SESSION['msg_cdrgeo_txtNameCDRgeoDistrict'],
            $_SESSION['msg_cdrgeo_upload_district']);
    
    unset($_SESSION['cdrgeo_hiddenidCDRgeoDistrict']);

    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoDistrict'.$main_activatedidlang[$i]]); 
    }

    unset($_SESSION['cdrgeo_cboDepartmentCDRgeoDistrict'],
            $_SESSION['cdrgeo_cboSelectPageInfoCDRgeoDistrict'],
            $_SESSION['cdrgeo_cboStatusCDRgeoDistrict']);
    
    
    $Bok_cdrgeo_insert = true;
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $cdrgeo_name_district[$i] = trim(htmlspecialchars(addslashes($_POST['txtNameCDRgeoDistrict'.$main_activatedidlang[$i]]), ENT_QUOTES));
    }
    
    $cdrgeo_parent_district = htmlspecialchars($_POST['cboDepartmentCDRgeoDistrict'], ENT_QUOTES);
    $cdrgeo_pageinfo_district = htmlspecialchars($_POST['cboSelectPageInfoCDRgeoDistrict'], ENT_QUOTES);
    $cdrgeo_status_district = htmlspecialchars($_POST['cboStatusCDRgeoDistrict'], ENT_QUOTES);  
    $cdrgeo_id_district = htmlspecialchars($_POST['hiddenidCDRgeoDistrict'], ENT_QUOTES);
    
    $upload_district = $_FILES['upload_cdrgeo_district']['name'];
    
    if($cdrgeo_pageinfo_district == 'select')
    {
        $cdrgeo_pageinfo_district = null;
    }
    
    if($cdrgeo_parent_district == 'select')
    {
        $Bok_cdrgeo_insert = false;
        $_SESSION['msg_cdrgeo_cboDepartmentCDRgeoDistrict'] = 'sélectionnez un département, si ce dernier n\'est pas dans la liste, veuillez en créer un';
    }
    
    for($i = 0, $count = count($cdrgeo_name_district); $i < $count; $i++)
    {
        if(empty($cdrgeo_name_district[0]))
        {
            $Bok_cdrgeo_insert = false;
            $_SESSION['msg_cdrgeo_txtNameCDRgeoDistrict'] = 'veuillez indiquer un nom pour cette langue';
            $i = $count;
        }
        
        if($i > 0)
        {
            if(empty($cdrgeo_name_district[$i]))
            {
                $cdrgeo_name_district[$i] = $cdrgeo_name_district[0];
            }
        }
    }
    
    if($Bok_cdrgeo_insert === true)
    {
        try
        {
            $prepared_query = 'SELECT MAX(id_cdrgeo) FROM cdrgeo';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $cdrgeo_id_district = $data[0];
            }

            $cdrgeo_id_district++;
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
        
        if(!empty($upload_district))
        {   
            $_SESSION['msg_cdrgeo_upload_district'] = 
            upload_file('upload_cdrgeo_district',
                        $cdrgeo_id_district.'district', 
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
                        $cdrgeo_id_district,
                        'cdrgeo_image',
                        null,
                        'false');
        }
        
        try
        {
            if(!empty($upload_district))
            {
                $prepared_query = 'SELECT id_image FROM cdrgeo_image
                                   WHERE id_cdrgeo = :id';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('id', $cdrgeo_id_district);
                $query->execute();
                
                if(($data = $query->fetch()) != false)
                {
                    $id_image_district = $data[0];
                }
                else
                {
                    $id_image_district = 0;
                }
            }
            
            $prepared_query = 'INSERT INTO cdrgeo
                               (type_cdrgeo, code_cdrgeo, position_cdrgeo, status_cdrgeo,
                                statusobject_cdrgeo, parentdepartment_cdrgeo, pageinfo_cdrgeo, 
                                id_image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].')';
                }
                else
                {
                    $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
                }
            }
            
            $prepared_query .= 'VALUES
                                (:type, :code, :position, :status, :statusobject,
                                 :parent, :pageinfo, :image, ';
            
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                if($i == ($count - 1))
                {
                    $prepared_query .= '"'.$cdrgeo_name_district[$i].'")';
                }
                else
                {
                    $prepared_query .= '"'.$cdrgeo_name_district[$i].'", ';
                }
                
                if($main_activatedidlang[$i] == $main_id_language)
                {
                    $cdrgeo_selected_lang = $i;
                }
            }
                                
                               
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'type' => 'dropdown',
                                  'code' => 'cdrgeo_district_situation',
                                  'position' => '1010',
                                  'status' => 1,
                                  'statusobject' => $cdrgeo_status_district,
                                  'parent' => $cdrgeo_parent_district,
                                  'pageinfo' => $cdrgeo_pageinfo_district,
                                  'image' => $id_image_district
                                  )); 
            $query->closeCursor();
            
            $_SESSION['msg_cdrgeo_done'] = 'L\'arrondissement "'.$cdrgeo_name_district[$cdrgeo_selected_lang].'" a été ajouté';
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
        $_SESSION['cdrgeo_hiddenidCDRgeoDistrict'] = $cdrgeo_id_district;
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
           $_SESSION['cdrgeo_txtNameCDRgeoDistrict'.$main_activatedidlang[$i]] = $cdrgeo_name_district[$i]; 
        }

        $_SESSION['cdrgeo_cboDepartmentCDRgeoDistrict'] = $cdrgeo_parent_district;
        $_SESSION['cdrgeo_cboSelectPageInfoCDRgeoDistrict'] = $cdrgeo_pageinfo_district;
        $_SESSION['cdrgeo_cboStatusCDRgeoDistrict'] = $cdrgeo_status_district;
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
