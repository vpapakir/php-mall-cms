<?php
if(isset($_POST['bt_new_cdreditor']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['cdreditor_add_displayFamilyOptions']);
    
    unset($_SESSION['msg_cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['msg_cdreditor_add_txtPosCDReditor'],
            $_SESSION['msg_cdreditor_addedit_done']);
    
    unset($_SESSION['cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['cdreditor_add_cboModeCDReditor'],
            $_SESSION['cdreditor_add_txtPosCDReditor'],
            $_SESSION['cdreditor_add_cboStatusCDReditor'],
            $_SESSION['cdreditor_add_cantdelete']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'],
                $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P']);
    }
    
    unset($_SESSION['cdreditor_cboSelectCDReditor'],
                $_SESSION['cdreditor_cboSelectCodeCDReditor']);
}
?>
