<?php
if(isset($_POST['bt_send_image_skin']))
{
    unset($_SESSION['msg_structure_edit_main_skin_txtNameSkin'], $_SESSION['msg_structure_edit_main_skin_upload_skin']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_skin = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_skin = $_FILES['upload_skin']['name'];
    
    $id_image_skin = $_POST['rad_ImageSkin'];
    
    if(!empty($upload_skin))
    {
        $_SESSION['msg_structure_edit_main_skin_upload_skin'] = 
        upload_file_skin('upload_skin',
                    $name_image_skin, 
                    5242880, 
                    1400, 
                    800, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/skin/original/', 
                    'graphics/background/skin/thumb/',
                    'graphics/background/skin/search/',
                    'id_skin', 
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
