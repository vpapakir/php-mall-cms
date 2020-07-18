<?php
if(isset($_POST['bt_add_mailtext']) || isset($_POST['bt_edit_mailtext']) || isset($_POST['bt_select_mailtext']))
{
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['expand_mailtext'.$main_activatedidlang[$i]] = trim(htmlspecialchars($_POST['expand_mailtext'.$main_activatedidlang[$i]]), ENT_QUOTES);
    }
}
?>
