<?php
if(isset($_POST['bt_send_image_body']))
{
    unset($_SESSION['msg_structure_edit_main_body_txtNameBody'], $_SESSION['msg_structure_edit_main_body_upload_body']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_body = trim(htmlspecialchars($_POST['txtNameImage'], ENT_QUOTES));
    $upload_body = $_FILES['upload_body']['name'];
    
    $id_image_body = $_POST['rad_ImageBody'];
    
    if(!empty($upload_body))
    {
        $_SESSION['msg_structure_edit_main_body_upload_body'] = 
        upload_file_body('upload_body',
                    $name_image_body, 
                    5242880, 
                    1400, 
                    800, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/body/original/', 
                    'graphics/background/body/thumb/',
                    'graphics/background/body/search/',
                    'id_body', 
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
