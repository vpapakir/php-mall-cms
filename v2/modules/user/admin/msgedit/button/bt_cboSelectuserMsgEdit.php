<?php
if(isset($_POST['bt_cboSelectuserMsgEdit']))
{
    unset($_SESSION['msgedit_cboSelectuserMsgEdit']);
    
    $msgedit_select_iduser = htmlspecialchars($_POST['cboSelectuserMsgEdit'], ENT_QUOTES);
    
    if($msgedit_select_iduser != 'all')
    {
        $_SESSION['msgedit_cboSelectuserMsgEdit'] = $msgedit_select_iduser;
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
