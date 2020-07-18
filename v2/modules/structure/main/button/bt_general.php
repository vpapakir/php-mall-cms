<?php
if(isset($_POST['bt_save_main_body']) || isset($_POST['bt_save_main_skin']) 
        || isset($_POST['bt_save_main_section']) || isset($_POST['bt_save_main_layout'])
        || isset($_POST['bt_save_main_frame']) || isset($_POST['bt_save_main_box'])
        || isset($_POST['bt_save_main_font']) || isset($_POST['bt_save_main_button'])
        || isset($_POST['bt_save_main_block']) || isset($_POST['bt_save_main_logo']))
{
    unset($_SESSION['msg_structure_edit_template_txtNameTemplate']);
    
    $id_template = $_SESSION['structure_template_cboTemplate'];
    $name_template = trim(htmlspecialchars($_POST['txtNameTemplate'], ENT_QUOTES));
    
    $BoK_name_template = true;
    
    if(empty($name_template))
    {
       $_SESSION['msg_structure_edit_main_body_txtNameTemplate'] = 'Veuillez indiquer un nom pour ce template';
       $BoK_name_template = false;       
    }
    
    if($BoK_name_template === true)
    {
        try
        {
            $prepared_query = 'UPDATE structure_template
                               SET name_template = :name
                               WHERE id_template = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'name' => $name_template,
                                  'id' => $id_template,
                                  ));
            $query->closeCursor();
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
    
    include('modules/settings/css/font/font_main.php');
    include('modules/settings/css/block/block_main.php');
    include('modules/settings/css/button/button_main.php');
}
?>
