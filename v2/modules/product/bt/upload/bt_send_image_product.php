<?php
if(isset($_POST['bt_send_image_product']))
{
    unset($_SESSION['msg_product_edit_upload']);
   
    $id_product_uploadproduct = $_SESSION['product_select_cboProductSelect'];
    
    $name_image_uploadproduct = trim(htmlspecialchars($_POST['txtProductNameImage'], ENT_QUOTES));
    $upload_product = $_FILES['upload_product']['name'];

    if(!empty($upload_product))
    {
        $_SESSION['msg_product_edit_upload'] = 
        upload_file('upload_product',
                    $name_image_uploadproduct, 
                    5242880, 
                    600, 
                    1200, 
                    180, 
                    360,
                    100,
                    200,
                    'images/products/original/', 
                    'images/products/thumb/',
                    'images/products/search/',
                    'id_page', 
                    $id_product_uploadproduct,
                    'page_image',
                    true);
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
