<?php
if(isset($_POST['bt_resetlisting_useredit']))
{
    unset($_SESSION['useredit_searchdone']);
    unset($_SESSION['useredit_search_keyword'],
            $_SESSION['useredit_search_rights'],
            $_SESSION['useredit_search_status'],
            $_SESSION['useredit_search_type'],
            $_SESSION['useredit_search_order']);
    unset($_SESSION['paging_defaultdisplay'],
            $_SESSION['paging_limitmax'],
            $_SESSION['paging_limitmin']);
    unset($_SESSION['useredit_searchwithkeyword']);
    
    unset($_SESSION['useredit_chkall']);
    for($i = 1, $count = $useredit_totalregistereduser; $i <= $count; $i++)
    {
        unset($_SESSION['useredit_chk'.$i]);
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
