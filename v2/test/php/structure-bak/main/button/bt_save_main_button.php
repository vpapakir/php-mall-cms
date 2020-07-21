<?php
if(isset($_POST['bt_save_main_button']))
{
    unset($_SESSION['msg_structure_edit_main_button_txtNameButton']);
    
    $selected_button = $_SESSION['structure_edit_id_element'];
    $selected_template = $_SESSION['structure_template_cboTemplate'];

    $name_button = trim(htmlspecialchars($_POST['txtNameButton'], ENT_QUOTES));
    
    $BoK_name_button = true;  

    if(empty($name_button))
    {
       $_SESSION['msg_structure_edit_main_button_txtNameButton'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_button = false; 
    }
    
    if($BoK_name_button === true)
    {     
        try
        {
            $prepared_query = 'UPDATE style_button 
                               SET id_template = :template,
                                   name_button = :name
                               WHERE id_button = :button';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'template' => $selected_template,
                                  'name' => $name_button,
                                  'button' => $selected_button
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
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Structure');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
    }
}
?>
