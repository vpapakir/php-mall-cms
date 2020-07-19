<?php
try
{     
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {     
        if(isset($_POST['bt_delete_levelx_imagelink_normal_L'.$main_activatedidlang[$i]])
                || isset($_POST['bt_delete_levelx_imagelink_hover_L'.$main_activatedidlang[$i]])
                || isset($_POST['bt_delete_levelx_imagelink_active_L'.$main_activatedidlang[$i]]))
        {
            $selected_levelx = trim(htmlspecialchars($_POST['cboLevelx'], ENT_QUOTES));
            
            $prepared_query = 'SELECT L'.$main_activatedidlang[$i].'I FROM hierarchy_box_content
                               WHERE id_hierarchy_box_content = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_levelx);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $levelx_image_link = $data[0];
            }
            $query->closeCursor();
            
            $levelx_image_link = split_string($levelx_image_link, '$');
            
            if(isset($_POST['bt_delete_levelx_imagelink_normal_L'.$main_activatedidlang[$i]]))
            {
                unset($_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]]);
                $levelx_image_name = str_replace('normal/', '', strstr($levelx_image_link[0], 'normal/'));
                $_SESSION['msg_sitemap_upload_content_normal_L'.$main_activatedidlang[$i]] = 
                        destroy_image($levelx_image_link[0], $paththumb, $pathsearch, $levelx_image_name);
                $levelx_image_link[0] = null;   
                
            }
            
            if(isset($_POST['bt_delete_levelx_imagelink_hover_L'.$main_activatedidlang[$i]]))
            {
                unset($_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]]);
                $levelx_image_name = str_replace('hover/', '', strstr($levelx_image_link[0], 'hover/'));
                $_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]] = 
                        destroy_image($levelx_image_link[1], $paththumb, $pathsearch, $levelx_image_name);
                $levelx_image_link[1] = null;   
            }
            
            if(isset($_POST['bt_delete_levelx_imagelink_active_L'.$main_activatedidlang[$i]]))
            {
                unset($_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]]);
                $levelx_image_name = str_replace('active/', '', strstr($levelx_image_link[0], 'active/'));
                $_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]] = 
                        destroy_image($levelx_image_link[2], $paththumb, $pathsearch, $levelx_image_name);
                $levelx_image_link[2] = null;   
            }  
            
            $levelx_image_link = join_string($levelx_image_link, '$', $argnext);
            
            if($levelx_image_link == '$$')
            {
                $levelx_image_link = null;
            }
            
            $prepared_query = 'UPDATE hierarchy_box_content
                               SET L'.$main_activatedidlang[$i].'I = :imagelink
                               WHERE id_hierarchy_box_content = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'imagelink' => $levelx_image_link,
                                  'id' => $selected_levelx              
            ));
            $query->closeCursor();
            $i = $count;
            
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
?>