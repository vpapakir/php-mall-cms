<?php
if(isset($_POST['bt_search_useredit']))
{
    $_SESSION['useredit_searchdone'] = 'done';
    
    unset($_SESSION['useredit_search_keyword'],
            $_SESSION['useredit_search_rights'],
            $_SESSION['useredit_search_status'],
            $_SESSION['useredit_search_type'],
            $_SESSION['useredit_search_order']);
    unset($_SESSION['paging_defaultdisplay'],
            $_SESSION['paging_limitmax'],
            $_SESSION['paging_limitmin']);
    unset($_SESSION['useredit_searchwithkeyword']);
    
    $useredit_search_keyword = trim(htmlspecialchars($_POST['txtSearchUserEdit'], ENT_QUOTES));
    $useredit_search_rights = htmlspecialchars($_POST['cboOrderRightsUserEdit'], ENT_QUOTES);
    $useredit_search_status = htmlspecialchars($_POST['cboOrderStatusUserEdit'], ENT_QUOTES);
    $useredit_search_type = htmlspecialchars($_POST['cboOrderTypeUserEdit'], ENT_QUOTES);
    $useredit_search_order = htmlspecialchars($_POST['cboOrderModeUserEdit'], ENT_QUOTES);
    
    $_SESSION['useredit_search_keyword'] = $useredit_search_keyword;
    
    $_SESSION['useredit_search_rights'] = $useredit_search_rights;
    $_SESSION['useredit_search_status'] = $useredit_search_status;
    $_SESSION['useredit_search_type'] = $useredit_search_type;
    $_SESSION['useredit_search_order'] = $useredit_search_order;
    
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
