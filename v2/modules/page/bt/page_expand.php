<?php
if(isset($_POST['bt_save_page']) || isset($_POST['bt_add_edit_page'])
        || isset($_POST['bt_radPageContent']) || isset($_POST['bt_send_image_page'])
        || isset($_POST['bt_cboPageSelect']) || isset($_POST['bt_delete_image_page']))
{
    $_SESSION['expand_page_general'] = $_POST['expand_page_general'];
    $_SESSION['expand_page_image'] = $_POST['expand_page_image'];
    $_SESSION['expand_page_url'] = $_POST['expand_page_url'];
    
    if(empty($_SESSION['expand_page_general']) || $_SESSION['expand_page_general'] == 'false' ? $_SESSION['expand_page_general'] = 'false' : $_SESSION['expand_page_general'] = 'true');
    if(empty($_SESSION['expand_page_image']) || $_SESSION['expand_page_image'] == 'false' ? $_SESSION['expand_page_image'] = 'false' : $_SESSION['expand_page_image'] = 'true');
    if(empty($_SESSION['expand_page_url']) || $_SESSION['expand_page_url'] == 'false' ? $_SESSION['expand_page_url'] = 'false' : $_SESSION['expand_page_url'] = 'true');
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['expand_page_lang'.$main_activatedidlang[$i]] = $_POST['expand_page_lang'.$main_activatedidlang[$i]];
        if(empty($_SESSION['expand_page_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_page_lang'.$main_activatedidlang[$i]] == 'false' ? $_SESSION['expand_page_lang'.$main_activatedidlang[$i]] = 'false' : $_SESSION['expand_page_lang'.$main_activatedidlang[$i]] = 'true');
    }
}
?>
