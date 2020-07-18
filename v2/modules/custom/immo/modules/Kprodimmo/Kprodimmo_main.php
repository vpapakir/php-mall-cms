<?php
if(!empty($_SESSION['product_edit_display_content']) && $_SESSION['product_edit_display_content'] === true)
{
    include('modules/custom/immo/modules/Kprodimmo/situation/situation_main.php');
    include('modules/custom/immo/modules/Kprodimmo/interior/interior_main.php');
    include('modules/custom/immo/modules/Kprodimmo/exterior/exterior_main.php');
}
?>