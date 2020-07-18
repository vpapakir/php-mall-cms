<?php
try
{
    if(empty($_SESSION['adminconfig_cboSelectSiteAdminconfig_new']))
    {
        if(!empty($_SESSION['adminconfig_cboSelectSiteAdminconfig']))
        {
            $adminconfig_selected_site = $_SESSION['adminconfig_cboSelectSiteAdminconfig'];
        }

        #[superadmin]
        if((checkrights($main_rights_log, '9', $redirection, $excludeSA)) === true)
        {
            $prepared_query = 'SELECT * FROM config_admin
                               WHERE status_configadmin = 1';
            if(!empty($adminconfig_selected_site))
            {
                $prepared_query .= ' AND name_configadmin = :name';
            }
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            if(!empty($adminconfig_selected_site))
            {
                $query->bindParam('name', $adminconfig_selected_site);
            }
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $adminconfig_admin_statspagecount = $data['stats_page_count'];
                $adminconfig_main_foldername = $data['folder_name'];
                $adminconfig_main_headerurl = $data['header_url'];
                $adminconfig_main_sitename = $data['sitename'];
            }
            $query->closeCursor();
        }
        
        if((checkrights($main_rights_log, '9', $redirection, $excludeSA)) === true)
        {
            $prepared_query = 'SELECT * FROM config_module
                               WHERE status_configmodule = 1';
            if(!empty($adminconfig_selected_site))
            {
                $prepared_query .= ' AND name_configmodule = :name';
            }
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            if(!empty($adminconfig_selected_site))
            {
                $query->bindParam('name', $adminconfig_selected_site);
            }
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $adminconfig_admin_module_immo = $data['immo_module'];
            }
            $query->closeCursor();
        }
        #[/superadmin]
        

        #[main]
        $prepared_query = 'SELECT * FROM config_main
                           WHERE status_config_main = 1';
        if(!empty($adminconfig_selected_site))
        {
            $prepared_query .= ' AND name_config_main = :name';
        }
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        if(!empty($adminconfig_selected_site))
        {
            $query->bindParam('name', $adminconfig_selected_site);
        }
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $adminconfig_main_email_sendername = $data['custom_email_sendername'];
            $adminconfig_main_email_senderemail = $data['custom_email_senderemail'];
            $adminconfig_main_email_bcc = $data['custom_email_bcc'];

            $adminconfig_main_noimage_search = $data['custom_noimage_search'];
            $adminconfig_main_noimage_origin = $data['custom_noimage_origin'];

            $adminconfig_main_elapsedtime_afk = $data['custom_elapsedtime_afk'];
            $adminconfig_main_elapsedtime_logout = $data['custom_elapsedtime_logout'];

            $adminconfig_main_meta_author = $data['custom_meta_author'];
            $adminconfig_main_meta_replyto = $data['custom_meta_replyto'];
            $adminconfig_main_meta_creationdate = $data['custom_meta_creationdate'];
            $adminconfig_main_meta_revisitafter = $data['custom_meta_revisitafter'];
            $adminconfig_main_meta_robots = $data['custom_meta_robots'];
            $adminconfig_main_meta_category = $data['custom_meta_category'];
            $adminconfig_main_meta_publisher = $data['custom_meta_publisher'];

            $adminconfig_main_favicon = $data['custom_link_icopath'];
        }
        $query->closeCursor();

        $adminconfig_main_meta_creationdate = split_string($adminconfig_main_meta_creationdate, '-');
        #[/main]

        #[structure]
        $prepared_query = 'SELECT * FROM config_structure
                           WHERE status_config_structure = 1';
        if(!empty($adminconfig_selected_site))
        {
            $prepared_query .= ' AND name_config_structure = :name';
        }
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        if(!empty($adminconfig_selected_site))
        {
            $query->bindParam('name', $adminconfig_selected_site);
        }
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $adminconfig_structure_column_width_right = $data['right_column_width'];
        }
        $query->closeCursor();

        $adminconfig_structure_column_width_right = str_replace('%', '', $adminconfig_structure_column_width_right);
        #[/structure]

        #[image]
        $prepared_query = 'SELECT * FROM config_image
                           WHERE status_config_image = 1';
        if(!empty($adminconfig_selected_site))
        {
            $prepared_query .= ' AND name_config_image = :name';
        }
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        if(!empty($adminconfig_selected_site))
        {
            $query->bindParam('name', $adminconfig_selected_site);
        }
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $adminconfig_image_ratio_x = $data['ratiox_image'];
            $adminconfig_image_ratio_y = $data['ratioy_image'];
            $adminconfig_image_status_online = $data['statusonline_image'];
            $adminconfig_image_status_away = $data['statusaway_image'];
            $adminconfig_image_status_offline = $data['statusoffline_image'];
        }
        $query->closeCursor();
        #[/image]
    }
    
    $prepared_query = 'SELECT id_configadmin FROM config_admin
                       WHERE status_configadmin = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $adminconfig_currentused_config = $data[0];
    }
    $query->closeCursor();
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
