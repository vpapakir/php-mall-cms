<?php
if(isset($_POST['bt_add_color']) || isset($_POST['bt_edit_color']) || isset($_POST['bt_delete_color']))
{
    #session
    unset($_SESSION['msg_color_done'], 
            $_SESSION['color_cboColor'],
            $_SESSION['color_txtCodeColor']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['color_txtNameColor'.$main_activatedidlang[$i]]);
    }
    #msg
    $msg_done_color_add = give_translation('messages.msg_done_color_add', 'false', $config_showtranslationcode);
    $msg_done_color_edit = give_translation('messages.msg_done_color_edit', 'false', $config_showtranslationcode);
    $msg_done_color_delete = give_translation('messages.msg_done_color_delete', 'false', $config_showtranslationcode);
    
    #callinfo
    $color_id = trim(htmlspecialchars($_POST['cboColor'], ENT_QUOTES));
    $color_code = '#'.trim(htmlspecialchars($_POST['txtCodeColor'], ENT_QUOTES));
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $color_name[$i] = trim(htmlspecialchars($_POST['txtNameColor'.$main_activatedidlang[$i]], ENT_QUOTES));
        if($main_activatedidlang[$i] == $main_id_language)
        {
            $color_selected_lang = $i;
        }
    }
    $color_oldcode = trim(htmlspecialchars($_POST['txtOldCodeColor'], ENT_QUOTES));
    
    #condition       
    if($color_code == '#000001')
    {
       $color_code = 'transparent';
    }
    
    for($i = 0, $count = count($color_name); $i < $count; $i++)
    {
        if(empty($color_name[$i]))
        {
           $color_name[$i] = str_replace('#', '', $color_code);
        }
    }
    
    if($color_oldcode == '#000001')
    {
       $color_oldcode = 'transparent'; 
    }
    
    #operation
    try
    {
        if(isset($_POST['bt_add_color']))
        {
            include('modules/color/button/bt_save_color/color_insert.php');
        }
        
        if(isset($_POST['bt_edit_color']))
        {
            include('modules/color/button/bt_save_color/color_update.php');
            include('modules/settings/css/font/font_main.php');
            include('modules/settings/css/block/block_main.php');
            include('modules/settings/css/button/button_main.php');
        }
        
        if(isset($_POST['bt_delete_color']))
        {
            include('modules/color/button/bt_save_color/color_delete.php');
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
            die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
        }
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
