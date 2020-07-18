<?php
if(isset($_POST['bt_cboSelectSiteAdminconfig'])
        || isset($_POST['bt_save_adminconfig']))
{
    $_SESSION['expand_adminconfig_admin'] = trim(htmlspecialchars($_POST['expand_adminconfig_admin'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_admin_website'] = trim(htmlspecialchars($_POST['expand_adminconfig_admin_website'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_admin_module'] = trim(htmlspecialchars($_POST['expand_adminconfig_admin_module'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_admin_stats'] = trim(htmlspecialchars($_POST['expand_adminconfig_admin_stats'], ENT_QUOTES));
    $_SESSION['expand_adminconfig_main'] = trim(htmlspecialchars($_POST['expand_adminconfig_main'], ENT_QUOTES));        
        $_SESSION['expand_adminconfig_main_email'] = trim(htmlspecialchars($_POST['expand_adminconfig_main_email'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_main_image'] = trim(htmlspecialchars($_POST['expand_adminconfig_main_image'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_main_userstatus'] = trim(htmlspecialchars($_POST['expand_adminconfig_main_userstatus'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_main_metatags'] = trim(htmlspecialchars($_POST['expand_adminconfig_main_metatags'], ENT_QUOTES));   
    $_SESSION['expand_adminconfig_structure'] = trim(htmlspecialchars($_POST['expand_adminconfig_structure'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_structure_table'] = trim(htmlspecialchars($_POST['expand_adminconfig_structure_table'], ENT_QUOTES));
    $_SESSION['expand_adminconfig_image'] = trim(htmlspecialchars($_POST['expand_adminconfig_image'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_image_ratio'] = trim(htmlspecialchars($_POST['expand_adminconfig_image_ratio'], ENT_QUOTES));
        $_SESSION['expand_adminconfig_image_status'] = trim(htmlspecialchars($_POST['expand_adminconfig_image_status'], ENT_QUOTES));
}
?>
