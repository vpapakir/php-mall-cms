<?php
if(isset($_POST['bt_save_product']) || isset($_POST['bt_add_edit_product'])
        || isset($_POST['bt_radProductContent']) || isset($_POST['bt_send_image_product'])
        || isset($_POST['bt_cboProductSelect']))
{
    $_SESSION['expand_product_property'] = $_POST['expand_product_property'];
    $_SESSION['expand_product_image'] = $_POST['expand_product_image'];
    $_SESSION['expand_product_url'] = $_POST['expand_product_url'];
    
    if(empty($_SESSION['expand_product_property']) || $_SESSION['expand_product_property'] == 'false' ? $_SESSION['expand_product_property'] = 'false' : $_SESSION['expand_product_property'] = 'true');
    if(empty($_SESSION['expand_product_image']) || $_SESSION['expand_product_image'] == 'false' ? $_SESSION['expand_product_image'] = 'false' : $_SESSION['expand_product_image'] = 'true');
    if(empty($_SESSION['expand_product_url']) || $_SESSION['expand_product_url'] == 'false' ? $_SESSION['expand_product_url'] = 'false' : $_SESSION['expand_product_url'] = 'true');
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['expand_product_lang'.$main_activatedidlang[$i]] = $_POST['expand_product_lang'.$main_activatedidlang[$i]];
        if(empty($_SESSION['expand_product_lang'.$main_activatedidlang[$i]]) || $_SESSION['expand_product_lang'.$main_activatedidlang[$i]] == 'false' ? $_SESSION['expand_product_lang'.$main_activatedidlang[$i]] = 'false' : $_SESSION['expand_product_lang'.$main_activatedidlang[$i]] = 'true');
    }
    
    
    $_SESSION['expand_Kprodimmo_general'] = $_POST['expand_Kprodimmo_general'];
    $_SESSION['expand_Kprodimmo_energy'] = $_POST['expand_Kprodimmo_energy'];
    $_SESSION['expand_Kprodimmo_other'] = $_POST['expand_Kprodimmo_other'];
    $_SESSION['expand_Kprodimmo_admin'] = $_POST['expand_Kprodimmo_admin'];
    $_SESSION['expand_Kprodimmo_situation'] = $_POST['expand_Kprodimmo_situation'];
    $_SESSION['expand_Kprodimmo_interior'] = $_POST['expand_Kprodimmo_interior'];
    $_SESSION['expand_Kprodimmo_exterior'] = $_POST['expand_Kprodimmo_exterior'];
    
    if(empty($_SESSION['expand_Kprodimmo_general']) || $_SESSION['expand_Kprodimmo_general'] == 'false' ? $_SESSION['expand_Kprodimmo_general'] = 'false' : $_SESSION['expand_Kprodimmo_general'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_energy']) || $_SESSION['expand_Kprodimmo_energy'] == 'false' ? $_SESSION['expand_Kprodimmo_energy'] = 'false' : $_SESSION['expand_Kprodimmo_energy'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_other']) || $_SESSION['expand_Kprodimmo_other'] == 'false' ? $_SESSION['expand_Kprodimmo_other'] = 'false' : $_SESSION['expand_Kprodimmo_other'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_admin']) || $_SESSION['expand_Kprodimmo_admin'] == 'false' ? $_SESSION['expand_Kprodimmo_admin'] = 'false' : $_SESSION['expand_Kprodimmo_admin'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_situation']) || $_SESSION['expand_Kprodimmo_situation'] == 'false' ? $_SESSION['expand_Kprodimmo_situation'] = 'false' : $_SESSION['expand_Kprodimmo_situation'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_interior']) || $_SESSION['expand_Kprodimmo_interior'] == 'false' ? $_SESSION['expand_Kprodimmo_interior'] = 'false' : $_SESSION['expand_Kprodimmo_interior'] = 'true');
    if(empty($_SESSION['expand_Kprodimmo_exterior']) || $_SESSION['expand_Kprodimmo_exterior'] == 'false' ? $_SESSION['expand_Kprodimmo_exterior'] = 'false' : $_SESSION['expand_Kprodimmo_exterior'] = 'true');
}
?>
