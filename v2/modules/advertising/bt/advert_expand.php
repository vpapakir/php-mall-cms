<?php
if(isset($_POST['bt_save_advert']) || isset($_POST['bt_modify_advert'])
        || isset($_POST['bt_cboSelectAdvert']))
{
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['expand_advertedit_lang'.$main_activatedidlang[$i]] = trim(htmlspecialchars($_POST['expand_advertedit_lang'.$main_activatedidlang[$i]], ENT_QUOTES));
    }
}
?>
