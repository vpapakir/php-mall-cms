<?php
if(isset($_POST['bt_cboTemplateContent']))
{
    $id_template_content = trim(htmlspecialchars($_POST['cboTemplateContent'], ENT_QUOTES));
    
    $_SESSION['structure_template_cboTemplateContent'] = $id_template_content;
    
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
