<?php
if(isset($_POST['bt_add_signature']) || isset($_POST['bt_edit_signature']) || isset($_POST['bt_select_signature']))
{
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['expand_signature'.$main_activatedidlang[$i]] = trim(htmlspecialchars($_POST['expand_signature'.$main_activatedidlang[$i]]), ENT_QUOTES);
    }
}
?>
