<?php
if(isset($_POST['bt_send_image_layout_middle']))
{
    unset($_SESSION['msg_structure_edit_main_layout_middle_txtNameImageMiddle'], $_SESSION['msg_structure_edit_main_layout_upload_layout_middle']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_layout_middle = trim(htmlspecialchars($_POST['txtNameImageMiddle'], ENT_QUOTES));
    $upload_layout_middle = $_FILES['upload_layout_middle']['name'];
    
    $width_image_layout_middle = trim(htmlspecialchars($_POST['txtWidthImageMiddle'], ENT_QUOTES));
    $height_image_layout_middle = trim(htmlspecialchars($_POST['txtHeightImageMiddle'], ENT_QUOTES));
    
    if(empty($width_image_layout_middle))
    {
        $width_image_layout_middle = 970;
    }
    
    if(empty($height_image_layout_middle))
    {
        $height_image_layout_middle = 500;
    }
    
    $id_image_layout_middle = $_POST['rad_ImageLayoutMiddle'];
    
    if(!empty($upload_layout_middle))
    {
        $_SESSION['msg_structure_edit_main_layout_upload_layout_middle'] = 
        upload_file('upload_layout_middle',
                    $name_image_layout_middle, 
                    5242880, 
                    $width_image_layout_middle, 
                    $height_image_layout_middle, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/layout/layout_middle/original/', 
                    'graphics/background/layout/layout_middle/thumb/',
                    'graphics/background/layout/layout_middle/search/',
                    'id_layout_middle', 
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
