<?php
if(!empty($adminconfig_selected_template) && $adminconfig_selected_template == 'select')
{
    $prepared_query = 'SELECT name_configadmin FROM config_admin
                       WHERE status_configadmin = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $adminconfig_name_selectedtemplate = $data[0];
    }
    $query->closeCursor();
}
else
{
    $adminconfig_name_selectedtemplate = $adminconfig_selected_template;
}

#adminconfig
$prepared_query = 'UPDATE config_admin
                   SET stats_page_count = :stats_pagecount,
                       header_url = :website_headerurl,
                       sitename = :website_sitename';
if($adminconfig_selected_template == 'select')
{
    $prepared_query .= ' WHERE status_configadmin = 1';
}
else
{
    $prepared_query .= ' WHERE name_configadmin = "'.$adminconfig_selected_template.'"';
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'stats_pagecount' => $adminconfig_sa_stats_pagecount,
                      'website_headerurl' => $adminconfig_sa_website_headerurl,
                      'website_sitename' => $adminconfig_sa_website_sitename
                    ));
$query->closeCursor();

$prepared_query = 'UPDATE config_module
                   SET immo_module = :immo';
if($adminconfig_selected_template == 'select')
{
    $prepared_query .= ' WHERE status_configmodule = 1';
}
else
{
    $prepared_query .= ' WHERE name_configmodule = "'.$adminconfig_selected_template.'"';
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'immo' => $adminconfig_sa_module_immo
                    ));
$query->closeCursor();

#mainconfig
$prepared_query = 'UPDATE config_main
                   SET custom_email_sendername = :email_sendername,
                       custom_email_senderemail = :email_senderemail,
                       custom_email_bcc = :email_bcc,
                       custom_noimage_search = :noimagesearch,
                       custom_noimage_origin = :noimageorigin,
                       custom_elapsedtime_afk = :elapsedtime_afk,
                       custom_elapsedtime_logout = :elapsedtime_logout,
                       custom_meta_author = :meta_author,
                       custom_meta_replyto = :meta_replyto,
                       custom_meta_creationdate = :meta_creationdate,
                       custom_meta_revisitafter = :meta_revisitafter,
                       custom_meta_robots = :meta_robots,
                       custom_meta_category = :meta_category,
                       custom_meta_publisher = :meta_publisher,
                       custom_link_icopath = :meta_icopath';
if($adminconfig_selected_template == 'select')
{
    $prepared_query .= ' WHERE status_config_main = 1';
}
else
{
    $prepared_query .= ' WHERE name_config_main = "'.$adminconfig_selected_template.'"';
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'email_sendername' => $adminconfig_main_email_sendername,
                      'email_senderemail' => $adminconfig_main_email_senderemail,
                      'email_bcc' => $adminconfig_main_email_bcc,
                      'noimagesearch' => $adminconfig_main_image_noimage_search,
                      'noimageorigin' => $adminconfig_main_image_noimage_origin,
                      'elapsedtime_afk' => $adminconfig_main_userstatus_afk,
                      'elapsedtime_logout' => $adminconfig_main_userstatus_logout,
                      'meta_author' => $adminconfig_main_meta_author,
                      'meta_replyto' => $adminconfig_main_meta_replyto,
                      'meta_creationdate' => $adminconfig_main_meta_creationdate_data,
                      'meta_revisitafter' => $adminconfig_main_meta_revisitafter,
                      'meta_robots' => $adminconfig_main_meta_robots,
                      'meta_category' => $adminconfig_main_meta_category,
                      'meta_publisher' => $adminconfig_main_meta_publisher,
                      'meta_icopath' => $adminconfig_main_image_favicon
                    ));
$query->closeCursor();

#structure
$prepared_query = 'UPDATE config_structure
                   SET right_column_width = :table_column_right';
if($adminconfig_selected_template == 'select')
{
    $prepared_query .= ' WHERE status_config_structure = 1';
}
else
{
    $prepared_query .= ' WHERE name_config_structure = "'.$adminconfig_selected_template.'"';
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'table_column_right' => $adminconfig_structure_table_column_right
                    ));
$query->closeCursor();

#image
$prepared_query = 'UPDATE config_image
                   SET ratiox_image = :ratio_x,
                       ratioy_image = :ratio_y,
                       statusonline_image = :status_online,
                       statusaway_image = :status_away,
                       statusoffline_image = :status_offline';
if($adminconfig_selected_template == 'select')
{
    $prepared_query .= ' WHERE status_config_image = 1';
}
else
{
    $prepared_query .= ' WHERE name_config_image = "'.$adminconfig_selected_template.'"';
}

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'ratio_x' => $adminconfig_image_ratio_x,
                      'ratio_y' => $adminconfig_image_ratio_y,
                      'status_online' => $adminconfig_image_status_online,
                      'status_away' => $adminconfig_image_status_away,
                      'status_offline' => $adminconfig_image_status_offline
                    ));
$query->closeCursor();

#modules 
if(!empty($adminconfig_sa_module_immo))
{
    $prepared_query = 'UPDATE script_template
                       SET status_script_template = :status
                       WHERE family_script_template = "immo"';               

    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'status' => $adminconfig_sa_module_immo,
                        ));
    $query->closeCursor();
    
    $prepared_query = 'UPDATE page
                       SET status_page = :status
                       WHERE family_page = "immo"';               

    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'status' => $adminconfig_sa_module_immo,
                        ));
    $query->closeCursor();
}

$msg_adminconfig_done_edit = str_replace('[#name_adminconfig]', $adminconfig_name_selectedtemplate, $msg_adminconfig_done_edit);
$_SESSION['msg_adminconfig_done'] = $msg_adminconfig_done_edit;
?>
