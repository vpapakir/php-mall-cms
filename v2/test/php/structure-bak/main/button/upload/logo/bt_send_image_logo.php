<?php
if(isset($_POST['bt_send_image_logo']))
{
    for($k = 0, $countk = count($main_activatedidlang); $k < $countk; $k++)
    {
        $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] = trim(htmlspecialchars($_POST['expand_structureedit_logo'.$main_activatedidlang[$k]], ENT_QUOTES));
    }
    
    unset($_SESSION['msg_structure_edit_main_logo_txtNameLogo'], $_SESSION['msg_structure_edit_main_logo_upload_logo']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_logo = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_logo = $_FILES['upload_logo']['name'];
    
    $id_image_logo = $_POST['rad_ImageLogo'];
    
    if(!empty($upload_logo))
    {
        $_SESSION['msg_structure_edit_main_logo_upload_logo'] = 
        upload_file('upload_logo',
                    $name_image_logo, 
                    5242880, 
                    600, 
                    1200, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/logo/original/', 
                    'graphics/background/logo/thumb/',
                    'graphics/background/logo/search/',
                    'id_logo', 
                    $id_element,
                    'structure_image');
    }
    
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
