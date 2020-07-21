<?php
if(isset($_POST['bt_cboSitemapFrame']))
{
    $selected_frame = trim(htmlspecialchars($_POST['cboSitemapFrame'], ENT_QUOTES));
    
    unset($_SESSION['sitemap_box_cboBox'],
            $_SESSION['sitemap_box_cboBoxType'],
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
    
    unset($_SESSION['msg_sitemap_box_cboBoxType'],
          $_SESSION['msg_sitemap_box_txtBoxPosition'],
          $_SESSION['msg_sitemap_box_txtBoxTitle']);
    
    unset($_SESSION['sitemap_levelx_cboLevelx'],
            $_SESSION['sitemap_levelx_cboLevelxType'],
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
                $_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]]);
    }
    
    unset($_SESSION['msg_sitemap_levelx_cboLevelxType'],
          $_SESSION['msg_sitemap_levelx_txtLevelxPosition'],
          $_SESSION['msg_sitemap_levelx_txtLevelxTitle'],
          $_SESSION['msg_sitemap_levelx_txtLevelxReference']);
    
    unset($_SESSION['sitemap_levelx_hiddenbox']);
    
    if($selected_frame == 'select')
    {
        unset($_SESSION['sitemap_frame_cboSitemapFrame']);
    }
    else
    {
        $_SESSION['sitemap_frame_cboSitemapFrame'] = $selected_frame;
        $_SESSION['sitemap_box_cboBoxFrame'] = $selected_frame;
        
        try
        {
            $prepared_query = 'SELECT id_hierarchy_box FROM hierarchy_box
                               WHERE id_frame = :frame';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('frame', $selected_frame);
            $query->execute();

            $i = 0;
            
            while($data = $query->fetch())
            {
                $id_sitemap_box[$i] = $data[0];
                $i++;
            }
            $query->closeCursor();

            $_SESSION['sitemap_frame_idbox'] = $id_sitemap_box;
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
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
    }
}
?>
