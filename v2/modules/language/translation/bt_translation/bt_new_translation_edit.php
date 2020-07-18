<?php
if(isset($_POST['bt_new_translation_edit']))
{
    unset($_SESSION['msg_translation_edit_modify_done'],
            $_SESSION['msg_translation_code_error']);
    $_SESSION['translation_search_done'] = false;
    $readonly = false;
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Traductions');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Traductions');
    }
}
?>
