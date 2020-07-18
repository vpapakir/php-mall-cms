<?php
if(isset($_POST['bt_delete_levelx']))
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
          $_SESSION['msg_sitemap_levelx_txtLevelxReference'],
          $_SESSION['sitemap_levelx_cboLevelx']);
    
    $selected_levelx = trim(htmlspecialchars($_POST['cboLevelx'], ENT_QUOTES));
    
    try
    {
        $prepared_query = 'DELETE FROM hierarchy_box_content
                           WHERE id_hierarchy_box_content = :idlevelx';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idlevelx', $selected_levelx);
        $query->execute();
        $query->closeCursor();
        
        reallocate_table_id('id_hierarchy_box_content', 'hierarchy_box_content');
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
?>
