<?php
#adminconfig
$prepared_query = 'INSERT INTO config_admin
                   (status_configadmin, name_configadmin, stats_page_count, 
                    header_url, sitename)
                   VALUES
                   (9, :name, :stats_pagecount, :website_headerurl,
                    :website_sitename)';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $adminconfig_selected_template,
                      'stats_pagecount' => $adminconfig_sa_stats_pagecount,
                      'website_headerurl' => $adminconfig_sa_website_headerurl,
                      'website_sitename' => $adminconfig_sa_website_sitename
                    ));
$query->closeCursor();

$prepared_query = 'INSERT INTO config_module
                   (status_configmodule, name_configmodule, immo_module)
                   VALUES
                   (9, :name, :module_immo)';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $adminconfig_selected_template,
                      'module_immo' => $adminconfig_sa_module_immo
                    ));
$query->closeCursor();

#mainconfig
$prepared_query = 'INSERT INTO config_main
                   (status_config_main, name_config_main, custom_email_sendername, custom_email_senderemail,
                    custom_email_bcc, custom_noimage_search, custom_noimage_origin, custom_elapsedtime_afk,
                    custom_elapsedtime_logout, custom_meta_author, custom_meta_replyto, custom_meta_creationdate,
                    custom_meta_revisitafter, custom_meta_robots, custom_meta_category, custom_meta_publisher,
                    custom_link_icopath)
                   VALUES
                   (9, :name, :email_sendername, :email_senderemail, :email_bcc, :noimagesearch,
                    :noimageorigin, :elapsedtime_afk, :elapsedtime_logout, :meta_author, :meta_replyto,
                    :meta_creationdate, :meta_revisitafter, :meta_robots, :meta_category, :meta_publisher,
                    :meta_icopath)';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $adminconfig_selected_template,
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
$prepared_query = 'INSERT INTO config_structure
                   (status_config_structure, name_config_structure, right_column_width)
                   VALUES
                   (9, :name, :table_column_right)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $adminconfig_selected_template,
                      'table_column_right' => $adminconfig_structure_table_column_right
                    ));
$query->closeCursor();

#image
$prepared_query = 'INSERT INTO config_image
                   (status_config_image, name_config_image, ratiox_image, ratioy_image,
                    statusonline_image, statusaway_image, statusoffline_image)
                   VALUES
                   (9, :name, :ratio_x, :ratio_y, :status_online, :status_away, status_offline)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $adminconfig_selected_template,
                      'ratio_x' => $adminconfig_image_ratio_x,
                      'ratio_y' => $adminconfig_image_ratio_y,
                      'status_online' => $adminconfig_image_status_online,
                      'status_away' => $adminconfig_image_status_away,
                      'status_offline' => $adminconfig_image_status_offline
                    ));
$query->closeCursor();

$msg_adminconfig_done_add = str_replace('[#name_adminconfig]', $adminconfig_selected_template, $msg_adminconfig_done_add);
$_SESSION['msg_adminconfig_done'] = $msg_adminconfig_done_add;
?>
