<?php
if(isset($_POST['bt_save_adminconfig']) || isset($_POST['bt_add_adminconfig']))
{
    unset($_SESSION['msg_adminconfig_creationdate'],
            $_SESSION['msg_adminconfig_txtAddNameConfigAdmin'],
            $_SESSION['msg_adminconfig_done']);
    
    #msg
    $msg_adminconfig_done_edit = give_translation('messages.msg_done_adminconfig_edit', 'false', $config_showtranslationcode);
    $msg_adminconfig_done_add = give_translation('messages.msg_done_adminconfig_add', 'false', $config_showtranslationcode);
    $msg_error_adminconfig_creationdate = give_translation('messages.msg_error_date', 'false', $config_showtranslationcode);
    $msg_error_adminconfig_name = give_translation('messages.msg_error_adminconfig_name', 'false', $config_showtranslationcode);
    #special
    $adminconfig_bok_update = true;
    
    #callinfo 
    if(isset($_POST['bt_add_adminconfig']))
    {
        $adminconfig_selected_template = trim(htmlspecialchars($_POST['txtAddNameConfigAdmin'], ENT_QUOTEST));
    }
    else 
    {
        $adminconfig_selected_template = htmlspecialchars($_POST['cboSelectSiteAdminconfig'], ENT_QUOTES);
    }
    
    #[SA]
    $adminconfig_sa_website_sitename = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainSitename'], ENT_QUOTES));
    $adminconfig_sa_website_headerurl = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainHeaderURL'], ENT_QUOTES));
    //$adminconfig_sa_website_kfolder = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainKFolder'], ENT_QUOTES));
    $adminconfig_sa_module_immo = htmlspecialchars($_POST['chkAdminconfigAdminModuleImmo'], ENT_QUOTES);
    
    $adminconfig_sa_stats_pagecount = trim(htmlspecialchars($_POST['txtAdminconfigAdminStatsPageCount'], ENT_QUOTES));
    
    #[Main]
    $adminconfig_main_email_bcc = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainBcc'], ENT_QUOTES));
    $adminconfig_main_email_senderemail = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainSenderEmail'], ENT_QUOTES));
    $adminconfig_main_email_sendername = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainSenderName'], ENT_QUOTES));
    
    $adminconfig_main_image_favicon = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainFavicon'], ENT_QUOTES));
    $adminconfig_main_image_noimage_origin = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainNoimageOrigin'], ENT_QUOTES));
    $adminconfig_main_image_noimage_search = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainNoimageSearch'], ENT_QUOTES));
    
    $adminconfig_main_meta_author = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaAuthor'], ENT_QUOTES));
    $adminconfig_main_meta_category = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaCategory'], ENT_QUOTES));
    $adminconfig_main_meta_creationdate_day = htmlspecialchars($_POST['cboAdminconfigAdminMainMetaCreationDateDay'], ENT_QUOTES);
    $adminconfig_main_meta_creationdate_month = htmlspecialchars($_POST['cboAdminconfigAdminMainMetaCreationDateMonth'], ENT_QUOTES);
    $adminconfig_main_meta_creationdate_year = htmlspecialchars($_POST['cboAdminconfigAdminMainMetaCreationDateYear'], ENT_QUOTES);
    $adminconfig_main_meta_publisher = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaPublisher'], ENT_QUOTES));
    $adminconfig_main_meta_replyto = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaReplyto'], ENT_QUOTES));
    $adminconfig_main_meta_revisitafter = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaRevisitafter'], ENT_QUOTES));
    $adminconfig_main_meta_robots = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainMetaRobots'], ENT_QUOTES));
    
    $adminconfig_main_userstatus_afk = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainUserstatusAFK'], ENT_QUOTES));
    $adminconfig_main_userstatus_logout = trim(htmlspecialchars($_POST['txtAdminconfigAdminMainUserstatusLogout'], ENT_QUOTES));
    
    #[Structure]
    $adminconfig_structure_table_column_right = trim(htmlspecialchars($_POST['txtAdminconfigAdminStructureColumnRight'], ENT_QUOTES));
    
    #[Image]
    $adminconfig_image_ratio_x = trim(htmlspecialchars($_POST['txtAdminconfigAdminImageRatioX'], ENT_QUOTES));
    $adminconfig_image_ratio_y = trim(htmlspecialchars($_POST['txtAdminconfigAdminImageRatioY'], ENT_QUOTES));
    
    $adminconfig_image_status_away = trim(htmlspecialchars($_POST['txtAdminconfigAdminImageStatusAway'], ENT_QUOTES));
    $adminconfig_image_status_online = trim(htmlspecialchars($_POST['txtAdminconfigAdminImageStatusOffline'], ENT_QUOTES));
    $adminconfig_image_status_offline = trim(htmlspecialchars($_POST['txtAdminconfigAdminImageStatusOnline'], ENT_QUOTES));
    
    #condition
    if(empty($adminconfig_selected_template) || strlen($adminconfig_selected_template)  < 4)
    {
        $adminconfig_bok_update = false;
        $_SESSION['msg_adminconfig_txtAddNameConfigAdmin'] = $msg_error_adminconfig_name;
    }
    
    if(empty($adminconfig_sa_module_immo) || $adminconfig_sa_module_immo != 1)
    {
        $adminconfig_sa_module_immo = 9;
    }
    
    if(!empty($adminconfig_structure_table_column_right))
    {
        $adminconfig_structure_table_column_right .= '%';
    }
    
    $adminconfig_main_meta_creationdate_data = $adminconfig_main_meta_creationdate_year.'-'.$adminconfig_main_meta_creationdate_month.'-'.$adminconfig_main_meta_creationdate_day;
    
    if($adminconfig_main_meta_creationdate_day != 'select' || $adminconfig_main_meta_creationdate_month != 'select' || $adminconfig_main_meta_creationdate_year != 'select')
    {
        if(($adminconfig_main_meta_creationdate_day == 'select' || $adminconfig_main_meta_creationdate_month == 'select' || $adminconfig_main_meta_creationdate_year == 'select')
                &&($adminconfig_main_meta_creationdate_day != 'select' || $adminconfig_main_meta_creationdate_month != 'select' || $adminconfig_main_meta_creationdate_year != 'select'))
        {
            $adminconfig_bok_update = false;
            $_SESSION['msg_adminconfig_creationdate'] = $msg_error_adminconfig_creationdate;
        }
        else
        {
            if((check_date($adminconfig_main_meta_creationdate_data)) == false)
            {
                $adminconfig_bok_update = false;
                $_SESSION['msg_adminconfig_creationdate'] = $msg_error_adminconfig_creationdate;
            }
        }
    }
    
    try
    {
        if($adminconfig_bok_update === true)
        {
            if(isset($_POST['bt_save_adminconfig']))
            {
                include('modules/settings/adminconfig/button/bt_save_adminconfig/update.php');
            }
            
            if(isset($_POST['bt_add_adminconfig']))
            {
                include('modules/settings/adminconfig/button/bt_save_adminconfig/insert.php');
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
