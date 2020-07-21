<?php
if(isset($_POST['bt_cboTemplate']))
{
    $id_template = trim(htmlspecialchars($_POST['cboTemplate'], ENT_QUOTES));
    
    $_SESSION['structure_template_cboTemplate'] = $id_template;
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }
}
?>
