<?php
if(isset($_POST['bt_send_image_page']))
{
    unset($_SESSION['msg_page_edit_upload']);
   
    $id_page_uploadpage = $_SESSION['page_select_cboPageSelect'];
    
    $name_image_uploadpage = trim(htmlspecialchars($_POST['txtPageNameImage'], ENT_QUOTES));
    $upload_page = $_FILES['upload_page']['name'];

    if(!empty($upload_page))
    {
        $_SESSION['msg_page_edit_upload'] = 
        upload_file('upload_page',
                    $name_image_uploadpage, 
                    5242880, 
                    600, 
                    1200, 
                    180, 
                    360,
                    100,
                    200,
                    'images/pages/original/', 
                    'images/pages/thumb/',
                    'images/pages/search/',
                    'id_page', 
                    $id_page_uploadpage,
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
