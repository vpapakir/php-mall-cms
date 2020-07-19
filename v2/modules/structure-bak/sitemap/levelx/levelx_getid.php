<?php
if(!isset($_POST['bt_cboSitemapFrame']) && !isset($_POST['bt_show_box']) && !isset($_POST['bt_cboBox'])
         && !isset($_POST['bt_cboBoxTypeLink']) && !isset($_POST['bt_edit_box'])
         && !isset($_POST['bt_add_box']) && !isset($_POST['bt_cboLevelx'])
         && !isset($_POST['bt_cboLevelxTypeLink']) && !isset($_POST['bt_edit_levelx'])
         && !isset($_POST['bt_add_levelx']))
{
    if(isset($_GET['levelx']))
    {
        $get_id_levelx = trim(htmlspecialchars($_GET['levelx'], ENT_QUOTES));

        $_SESSION['sitemap_levelx_hiddenbox'] = true;
        $_SESSION['sitemap_accesstolevelx'] = true;
        //$_SESSION['sitemap_add_box'] = true;

        try
        {
            #get box content Info
            $prepared_query = 'SELECT * FROM hierarchy_box_content
                               WHERE id_hierarchy_box_content = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $get_id_levelx);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $get_type_levelx = $data['type_hierarchy_box_content'];
                $get_family_levelx = $data['family_hierarchy_box_content'];
                $get_menutitle_levelx = $data['menutitle_hierarchy_box_content'];
                $get_typelink_levelx = $data['typelink_hierarchy_box_content'];
                $get_link_levelx = $data['link_hierarchy_box_content'];
                $get_position_levelx = $data['position_hierarchy_box_content'];
                $get_reference_levelx = $data['reference_hierarchy_box_content'];
                $get_userrights_levelx = $data['userrights_hierarchy_box_content'];
                $get_status_levelx = $data['status_hierarchy_box_content'];
                $get_target_levelx = $data['target_hierarchy_box_content'];
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $get_title_levelx[$i] = $data['L'.$main_activatedidlang[$i]];
                    $get_image_levelx[$i] = $data['L'.$main_activatedidlang[$i].'I'];
                }
                $get_margin_levelx = $data['margin_hierarchy_box_content'];
                $get_align_levelx = $data['align_hierarchy_box_content'];
                $get_id_levelx = $data['id_hierarchy_box_content'];
                $get_id_box = $data['id_hierarchy_box'];
            }
            $query->closeCursor();

            $_SESSION['sitemap_levelx_cboLevelxType'] = $get_type_levelx;
            $_SESSION['sitemap_levelx_cboLevelxFamily'] = $get_family_levelx;
            $_SESSION['sitemap_levelx_txtLevelxTitle'] = $get_menutitle_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTypeLink'] = $get_typelink_levelx;
            $_SESSION['sitemap_levelx_txtLevelxLink'] = $get_link_levelx;
            $_SESSION['sitemap_levelx_txtLevelxPosition'] = $get_position_levelx;
            $_SESSION['sitemap_levelx_txtLevelxReference'] = $get_reference_levelx;
            $_SESSION['sitemap_levelx_cboLevelxRights'] = $get_userrights_levelx;
            $_SESSION['sitemap_levelx_cboLevelxStatus'] = $get_status_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTarget'] = $get_target_levelx;
            
            unset($get_currentimage_levelx);
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                $_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]] = $get_title_levelx[$i];
                $get_currentimage_levelx = split_string($get_image_levelx[$i], '$');                
                $_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]] = $get_currentimage_levelx[0];
                $_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]] = $get_currentimage_levelx[1];
                $_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]] = $get_currentimage_levelx[2];                
                unset($get_currentimage_levelx);
            }
            $_SESSION['sitemap_levelx_txtLevelxMargin'] = $get_margin_levelx;
            $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] = $get_align_levelx;

            $_SESSION['sitemap_levelx_cboLevelx'] = $get_id_levelx;

            #get box Info
            $prepared_query = 'SELECT * FROM hierarchy_box
                               WHERE id_hierarchy_box = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $get_id_box);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $get_id_sitemap_box = $data[0];
                $get_type_box = $data['id_box'];
                $get_family_box = $data['family_hierarchy_box'];
                $get_menutitle_box = $data['menutitle_hierarchy_box'];
                $get_typelink_box = $data['typelink_hierarchy_box'];
                $get_link_box = $data['link_hierarchy_box'];
                $get_position_box = $data['position_hierarchy_box'];
                $get_userrights_box = $data['userrights_hierarchy_box'];
                $get_status_box = $data['status_hierarchy_box'];
                $get_target_box = $data['target_hierarchy_box'];
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $get_title_box[$i] = $data['L'.$main_activatedidlang[$i]];
                }
                $get_titlemargin_box = $data['titlemargin_hierarchy_box'];
                $get_titlealign_box = $data['titlealign_hierarchy_box'];
                $get_id_frame_box = $data['id_frame'];
            }
            $query->closeCursor();

            $_SESSION['sitemap_box_cboBoxType'] = $get_type_box;
            $_SESSION['sitemap_box_cboBoxFamily'] = $get_family_box;
            $_SESSION['sitemap_box_txtBoxTitle'] = $get_menutitle_box;
            $_SESSION['sitemap_box_cboBoxTypeLink'] = $get_typelink_box;
            $_SESSION['sitemap_box_txtBoxLink'] = $get_link_box;
            $_SESSION['sitemap_box_txtBoxPosition'] = $get_position_box;
            $_SESSION['sitemap_box_cboBoxRights'] = $get_userrights_box;
            $_SESSION['sitemap_box_cboBoxStatus'] = $get_status_box;
            $_SESSION['sitemap_box_cboBoxTarget'] = $get_target_box;
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
                $_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]] = $get_title_box[$i];
            }
            $_SESSION['sitemap_box_txtBoxMargin'] = $get_titlemargin_box;
            $_SESSION['sitemap_box_cboBoxTitleAlign'] = $get_titlealign_box;
            $_SESSION['sitemap_box_cboBoxFrame'] = $get_id_frame_box;

            $_SESSION['sitemap_box_cboBox'] = $get_id_sitemap_box;
            
            $_SESSION['sitemap_frame_cboSitemapFrame'] = $get_id_frame_box;
            
            $prepared_query = 'SELECT id_hierarchy_box FROM hierarchy_box
                               WHERE id_frame = :frame';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('frame', $get_id_frame_box);
            $query->execute();

            $i = 0;
            
            while($data = $query->fetch())
            {
                $array_get_id_sitemap_box[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();

            $_SESSION['sitemap_frame_idbox'] = $array_get_id_sitemap_box;
            
            $prepared_query = 'SELECT * FROM hierarchy_box_content
                               WHERE id_hierarchy_box = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $get_id_sitemap_box);
            $query->execute();
            
            $i = 0;
            
            while($data = $query->fetch())
            {
                $array_get_id_box_levelx[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();
            
            $_SESSION['sitemap_levelx_idbox'] = $array_get_id_box_levelx;
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
}
?>
