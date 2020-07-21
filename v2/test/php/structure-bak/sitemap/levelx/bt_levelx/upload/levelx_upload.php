<?php

if(isset($_POST['bt_add_levelx']))
{
    $prepared_query = 'SELECT MAX(id_hierarchy_box_content) FROM hierarchy_box_content';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $sitemap_selected_idlevelx = $data[0];
    }
    $query->closeCursor();
}
else
{
    $sitemap_selected_idlevelx = $selected_levelx;
}

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $sitemap_levelx_normal_upload[$i] = $_FILES['upload_sitemap_content_normal_L'.$main_activatedidlang[$i]]['name'];
    $sitemap_levelx_hover_upload[$i] = $_FILES['upload_sitemap_content_hover_L'.$main_activatedidlang[$i]]['name'];
    $sitemap_levelx_active_upload[$i] = $_FILES['upload_sitemap_content_active_L'.$main_activatedidlang[$i]]['name'];
    
    if($i > 0)
    {
        if(empty($sitemap_levelx_normal_upload[$i]))
        {
            $sitemap_levelx_normal_upload[$i] = $sitemap_levelx_normal_upload[0];
        }
        
        if(empty($sitemap_levelx_hover_upload[$i]))
        {
            $sitemap_levelx_hover_upload[$i] = $sitemap_levelx_hover_upload[0];
        }
        
        if(empty($sitemap_levelx_active_upload[$i]))
        {
            $sitemap_levelx_active_upload[$i] = $sitemap_levelx_active_upload[0];
        }
    }
    
    #[normal]
    if(!empty($sitemap_levelx_normal_upload[$i]))
    {
        $_SESSION['msg_sitemap_upload_content_normal_L'.$main_activatedidlang[$i]] = 
            upload_sitemap
            ('upload_sitemap_content_normal_L'.$main_activatedidlang[$i], 
              $title_levelx[$i].' - normal', 
              5242880, 
              256, 
              72, 
              'graphics/link/sitemap/normal/', 
              $sitemap_selected_idlevelx, 
              $main_activatedidlang[$i],
              'normal',
              'hierarchy_box_content');
    }
    
    #[hover]
    if(!empty($sitemap_levelx_hover_upload[$i]))
    {
        $_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]] = 
            upload_sitemap
            ('upload_sitemap_content_hover_L'.$main_activatedidlang[$i], 
              $title_levelx[$i].' - hover', 
              5242880, 
              256, 
              72, 
              'graphics/link/sitemap/hover/', 
              $sitemap_selected_idlevelx, 
              $main_activatedidlang[$i],
              'hover',
              'hierarchy_box_content');
    }
    else
    {
        if(!empty($sitemap_levelx_normal_upload[$i]))
        {
            $_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]] = 
                upload_sitemap
                ('upload_sitemap_content_normal_L'.$main_activatedidlang[$i], 
                  $title_levelx[$i].' - hover', 
                  5242880, 
                  256, 
                  72, 
                  'graphics/link/sitemap/hover/', 
                  $sitemap_selected_idlevelx, 
                  $main_activatedidlang[$i],
                  'hover',
                  'hierarchy_box_content');
        }
    }
    
    #[active]
    if(!empty($sitemap_levelx_active_upload[$i]))
    {
        $_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]] = 
            upload_sitemap
            ('upload_sitemap_content_active_L'.$main_activatedidlang[$i], 
              $title_levelx[$i].' - active', 
              5242880, 
              256, 
              72, 
              'graphics/link/sitemap/active/', 
              $sitemap_selected_idlevelx, 
              $main_activatedidlang[$i],
              'active',
              'hierarchy_box_content');
    }
    else
    {
        if(!empty($sitemap_levelx_hover_upload[$i]))
        {
            $_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]] = 
            upload_sitemap
            ('upload_sitemap_content_hover_L'.$main_activatedidlang[$i], 
              $title_levelx[$i].' - active', 
              5242880, 
              256, 
              72, 
              'graphics/link/sitemap/active/', 
              $sitemap_selected_idlevelx, 
              $main_activatedidlang[$i],
              'active',
              'hierarchy_box_content');
        }
        else
        {
            if(!empty($sitemap_levelx_normal_upload[$i]))
            {
                $_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]] = 
                upload_sitemap
                ('upload_sitemap_content_normal_L'.$main_activatedidlang[$i], 
                  $title_levelx[$i].' - active', 
                  5242880, 
                  256, 
                  72, 
                  'graphics/link/sitemap/active/', 
                  $sitemap_selected_idlevelx, 
                  $main_activatedidlang[$i],
                  'active',
                  'hierarchy_box_content');
            }
        }
    }
}

if(isset($_POST['bt_edit_levelx']))
{
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $prepared_query = 'SELECT L'.$main_activatedidlang[$i].'I FROM hierarchy_box_content
                           WHERE id_hierarchy_box_content = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $sitemap_selected_idlevelx);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $sitemap_image_link = $data[0];
        }
        $query->closeCursor();
        
        $sitemap_image_link = split_string($sitemap_image_link, '$');
        
        $_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]] = $sitemap_image_link[0];
        $_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]] = $sitemap_image_link[1];
        $_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]] = $sitemap_image_link[2];
        
        unset($sitemap_image_link);
    }
}
?>
