<?php
if(isset($_POST['bt_send_image_layout_bottom']))
{
    unset($_SESSION['msg_structure_edit_main_layout_bottom_txtNameImageBottom'], $_SESSION['msg_structure_edit_main_layout_upload_layout_bottom']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_layout_bottom = trim(htmlspecialchars($_POST['txtNameImageBottom'], ENT_QUOTES));
    $upload_layout_bottom = $_FILES['upload_layout_bottom']['name'];
    
    $width_image_layout_bottom = trim(htmlspecialchars($_POST['txtWidthImageBottom'], ENT_QUOTES));
    $height_image_layout_bottom = trim(htmlspecialchars($_POST['txtHeightImageBottom'], ENT_QUOTES));
    
    if(empty($width_image_layout_bottom))
    {
        $width_image_layout_bottom = 970;
    }
    
    if(empty($height_image_layout_bottom))
    {
        $height_image_layout_bottom = 500;
    }
    
    $id_image_layout_bottom = $_POST['rad_ImageLayoutBottom'];
    
    if(!empty($upload_layout_bottom))
    {
        $_SESSION['msg_structure_edit_main_layout_upload_layout_bottom'] = 
        upload_file('upload_layout_bottom',
                    $name_image_layout_bottom, 
                    5242880, 
                    $width_image_layout_bottom, 
                    $height_image_layout_bottom, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/layout/layout_bottom/original/', 
                    'graphics/background/layout/layout_bottom/thumb/',
                    'graphics/background/layout/layout_bottom/search/',
                    'id_layout_bottom', 
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
