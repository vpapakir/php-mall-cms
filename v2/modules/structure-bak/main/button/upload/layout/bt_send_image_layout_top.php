<?php
if(isset($_POST['bt_send_image_layout_top']))
{
    unset($_SESSION['msg_structure_edit_main_layout_top_txtNameImageTop'], $_SESSION['msg_structure_edit_main_layout_upload_layout_top']);
   
    $id_element = $_SESSION['structure_edit_id_element'];
    
    $name_image_layout_top = trim(htmlspecialchars($_POST['txtNameImageTop'], ENT_QUOTES));
    $upload_layout_top = $_FILES['upload_layout_top']['name'];
    
    $width_image_layout_top = trim(htmlspecialchars($_POST['txtWidthImageTop'], ENT_QUOTES));
    $height_image_layout_top = trim(htmlspecialchars($_POST['txtHeightImageTop'], ENT_QUOTES));
    
    if(empty($width_image_layout_top))
    {
        $width_image_layout_top = 970;
    }
    
    if(empty($height_image_layout_top))
    {
        $height_image_layout_top = 500;
    }
    
    $id_image_layout_top = $_POST['rad_ImageLayoutTop'];
    
    if(!empty($upload_layout_top))
    {
        $_SESSION['msg_structure_edit_main_layout_upload_layout_top'] = 
        upload_file('upload_layout_top',
                    $name_image_layout_top, 
                    5242880, 
                    $width_image_layout_top, 
                    $height_image_layout_top, 
                    180, 
                    360,
                    100,
                    200,
                    'graphics/background/layout/layout_top/original/', 
                    'graphics/background/layout/layout_top/thumb/',
                    'graphics/background/layout/layout_top/search/',
                    'id_layout_top', 
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
