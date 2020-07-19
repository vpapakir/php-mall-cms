<?php
if(isset($_POST['bt_cboSelectSiteAdminconfig']))
{
    unset($_SESSION['adminconfig_cboSelectSiteAdminconfig'],
            $_SESSION['adminconfig_cboSelectSiteAdminconfig_new']);
    
    unset($_SESSION['msg_adminconfig_creationdate'],
            $_SESSION['msg_adminconfig_txtAddNameConfigAdmin'],
            $_SESSION['msg_adminconfig_done']);
    
    $adminconfig_selected_site = htmlspecialchars($_POST['cboSelectSiteAdminconfig'], ENT_QUOTES);
    
    if($adminconfig_selected_site != 'select')
    {
        if($adminconfig_selected_site != 'new')
        {
            $_SESSION['adminconfig_cboSelectSiteAdminconfig'] = $adminconfig_selected_site;
        }
        else
        {
            $_SESSION['adminconfig_cboSelectSiteAdminconfig_new'] = true;
            $_SESSION['adminconfig_cboSelectSiteAdminconfig'] = $adminconfig_selected_site;
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
