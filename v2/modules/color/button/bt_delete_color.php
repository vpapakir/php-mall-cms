<?php
if(isset($_POST['bt_delete_edit_color']))
{
    unset($_SESSION['msg_color_done'], 
            $_SESSION['color_cboColor'],
            $_SESSION['color_txtNameColor'],
            $_SESSION['color_txtCodeColor']);
    
    $color_id = trim(htmlspecialchars($_POST['cboColor'], ENT_QUOTES));
    
    try
    {
        
        
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$config_customheader.'Gestion/Couleur'));
        }
        else
        {
            die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Gestion/Couleur'));
        }      
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$config_customheader.'Error/400'));
        }
        else
        {
            die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
        }
    }
}
?>
