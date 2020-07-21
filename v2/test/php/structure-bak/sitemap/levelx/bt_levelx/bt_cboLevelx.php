<?php
if(isset($_POST['bt_cboLevelx']))
{
    unset($_SESSION['sitemap_levelx_cboLevelx'],
            $_SESSION['sitemap_levelx_cboLevelxType'],
            $_SESSION['sitemap_levelx_cboLevelxFamily'],
            $_SESSION['sitemap_levelx_cboLevelxTypeLink'],
            $_SESSION['sitemap_levelx_txtLevelxLink'],
            $_SESSION['sitemap_levelx_txtLevelxPosition'],
            $_SESSION['sitemap_levelx_txtLevelxReference'],
            $_SESSION['sitemap_levelx_cboLevelxRights'],
            $_SESSION['sitemap_levelx_cboLevelxStatus'],
            $_SESSION['sitemap_levelx_cboLevelxTarget'],
            $_SESSION['sitemap_add_levelx']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]],
                $_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]],
                $_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]],
                $_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]],
                $_SESSION['msg_sitemap_upload_content_normal_L'.$main_activatedidlang[$i]],
                $_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]],
                $_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]]);
    }
    
    unset($_SESSION['msg_sitemap_levelx_cboLevelxType'],
          $_SESSION['msg_sitemap_levelx_txtLevelxPosition'],
          $_SESSION['msg_sitemap_levelx_txtLevelxTitle'],
          $_SESSION['msg_sitemap_levelx_txtLevelxReference']);
    
    $selected_type_link = trim(htmlspecialchars($_POST['cboLevelx'], ENT_QUOTES));
    
    if($selected_type_link != 'new')
    {
        $_SESSION['sitemap_levelx_cboLevelx'] = $selected_type_link;
        
        $_SESSION['sitemap_levelx_hiddenbox'] = true;
        
        try
        {
            $prepared_query = 'SELECT * FROM hierarchy_box_content
                               WHERE id_hierarchy_box_content = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_type_link);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $type_levelx = $data['type_hierarchy_box_content'];
                $family_levelx = $data['family_hierarchy_box_content'];
                $title_levelx = $data['menutitle_hierarchy_box_content'];
                $typelink_levelx = $data['typelink_hierarchy_box_content'];
                $link_levelx = $data['link_hierarchy_box_content'];
                $position_levelx = $data['position_hierarchy_box_content'];
                $reference_levelx = $data['reference_hierarchy_box_content'];
                $userrights_levelx = $data['userrights_hierarchy_box_content'];
                $status_levelx = $data['status_hierarchy_box_content'];
                $target_levelx = $data['target_hierarchy_box_content'];
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $title_levelx[$i] = $data['L'.$main_activatedidlang[$i]];
                    $image_levelx[$i] = $data['L'.$main_activatedidlang[$i].'I'];
                }
                $margin_levelx = $data['margin_hierarchy_box_content'];
                $align_levelx = $data['align_hierarchy_box_content'];
                $id_levelx = $data['id_hierarchy_box_content'];
                
                //$parent_levelx = $data['id_parent_hierarchy_box_content'];
            }
            $query->closeCursor();

            
            $_SESSION['sitemap_levelx_cboLevelxType'] = $type_levelx;
            $_SESSION['sitemap_levelx_cboLevelxFamily'] = $family_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTypeLink'] = $typelink_levelx;
            $_SESSION['sitemap_levelx_txtLevelxLink'] = $link_levelx;
            $_SESSION['sitemap_levelx_txtLevelxPosition'] = $position_levelx;
            $_SESSION['sitemap_levelx_txtLevelxReference'] = $reference_levelx;
            $_SESSION['sitemap_levelx_cboLevelxRights'] = $userrights_levelx;
            $_SESSION['sitemap_levelx_cboLevelxStatus'] = $status_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTarget'] = $target_levelx;
            unset($currentimage_levelx);
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                $_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]] = $title_levelx[$i];
                $currentimage_levelx = split_string($image_levelx[$i], '$');                
                $_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]] = $currentimage_levelx[0];
                $_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]] = $currentimage_levelx[1];
                $_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]] = $currentimage_levelx[2];                
                unset($currentimage_levelx);
            }
            
            $_SESSION['sitemap_levelx_txtLevelxMargin'] = $margin_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] = $align_levelx;
            //$_SESSION['sitemap_levelx_cboLevelxLevel'] = $parent_levelx;
            
            
            
            $prepared_query = 'SELECT * FROM hierarchy_box_content
                               WHERE id_hierarchy_box_content = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_type_link);
            $query->execute();
            
            $i = 0;
            
            while($data = $query->fetch())
            {
                $id_levelx[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            $_SESSION['sitemap_levelx_idlevelx'] = $id_levelx;
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
            
        $_SESSION['sitemap_accesstolevelx'] = true;
        
    }
    else
    {
        unset($_SESSION['sitemap_levelx_cboLevelx'],
              $_SESSION['sitemap_levelx_hiddenbox']);
        $_SESSION['sitemap_levelx_cboLevelxLevel'] = 0;
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
