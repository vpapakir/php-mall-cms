<?php
if(isset($_POST['bt_cboBox']))
{
    unset($_SESSION['sitemap_box_cboBox'],
            $_SESSION['sitemap_box_cboBoxType'],
            $_SESSION['sitemap_box_cboBoxFamily'],
            $_SESSION['sitemap_box_cboBoxTypeLink'],
            $_SESSION['sitemap_box_txtBoxLink'],
            $_SESSION['sitemap_box_txtBoxPosition'],
            $_SESSION['sitemap_box_cboBoxRights'],
            $_SESSION['sitemap_box_cboBoxStatus'],
            $_SESSION['sitemap_box_cboBoxTarget'],
            $_SESSION['sitemap_box_txtBoxMargin'],
            $_SESSION['sitemap_box_cboBoxTitleAlign'],
            $_SESSION['sitemap_box_cboBoxFrame'],
            $_SESSION['sitemap_accesstolevelx'],
            $_SESSION['sitemap_add_box'],
            $_SESSION['sitemap_levelx_cboLevelx']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]],
                $_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]]);
    }
    
    unset($_SESSION['msg_sitemap_box_cboBoxType'],
          $_SESSION['msg_sitemap_box_txtBoxPosition'],
          $_SESSION['msg_sitemap_box_txtBoxTitle']);
    
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
    
    unset($_SESSION['msg_sitemap_levelx_cboLevelxType'],
          $_SESSION['msg_sitemap_levelx_txtLevelxPosition'],
          $_SESSION['msg_sitemap_levelx_txtLevelxTitle'],
          $_SESSION['msg_sitemap_levelx_txtLevelxReference']);
    
    unset($_SESSION['sitemap_levelx_hiddenbox']);
    
    $selected_type_link = trim(htmlspecialchars($_POST['cboBox'], ENT_QUOTES));
    if($selected_type_link != 'new')
    {
        $_SESSION['sitemap_box_cboBox'] = $selected_type_link;
        
        try
        {
            $prepared_query = 'SELECT * FROM hierarchy_box
                               WHERE id_hierarchy_box = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_type_link);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $id_sitemap_box = $data[0];
                $type_box = $data['id_box'];
                $family_box = $data['family_hierarchy_box'];
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $title_box[$i] = $data['L'.$main_activatedidlang[$i]];
                }
                $typelink_box = $data['typelink_hierarchy_box'];
                $link_box = $data['link_hierarchy_box'];
                $position_box = $data['position_hierarchy_box'];
                $userrights_box = $data['userrights_hierarchy_box'];
                $status_box = $data['status_hierarchy_box'];
                $target_box = $data['target_hierarchy_box'];
                
                $titlemargin_box = $data['titlemargin_hierarchy_box'];
                $titlealign_box = $data['titlealign_hierarchy_box'];
                $id_frame_box = $data['id_frame'];
            }
            $query->closeCursor();
            
            $_SESSION['sitemap_box_cboBoxType'] = $type_box;
            $_SESSION['sitemap_box_cboBoxFamily'] = $family_box;
            $_SESSION['sitemap_box_cboBoxTypeLink'] = $typelink_box;
            $_SESSION['sitemap_box_txtBoxLink'] = $link_box;
            $_SESSION['sitemap_box_txtBoxPosition'] = $position_box;
            $_SESSION['sitemap_box_cboBoxStatus'] = $status_box;
            $_SESSION['sitemap_box_cboBoxTarget'] = $target_box;
            
            $_SESSION['sitemap_box_cboBoxRights'] = $userrights_box;
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                $_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]] = $title_box[$i];
            }
            
            $_SESSION['sitemap_box_txtBoxMargin'] = $titlemargin_box;
            $_SESSION['sitemap_box_cboBoxTitleAlign'] = $titlealign_box;
            $_SESSION['sitemap_box_cboBoxFrame'] = $id_frame_box;
            
            $_SESSION['sitemap_box_cboBox'] = $id_sitemap_box;
            
            $prepared_query = 'SELECT * FROM hierarchy_box_content
                               WHERE id_hierarchy_box = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_type_link);
            $query->execute();
            
            $i = 0;
            
            while($data = $query->fetch())
            {
                $id_box_levelx[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            $_SESSION['sitemap_levelx_idbox'] = $id_box_levelx;
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
        unset($_SESSION['sitemap_box_cboBox'],
              $_SESSION['sitemap_accesstolevelx']);
        
        $_SESSION['sitemap_box_cboBoxFrame'] = $_SESSION['sitemap_frame_cboSitemapFrame'];
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
