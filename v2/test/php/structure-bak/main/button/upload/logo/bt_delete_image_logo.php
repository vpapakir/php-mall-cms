<?php
try
{
    for($k = 0, $countk = count($main_activatedidlang); $k < $countk; $k++)
    {
        $_SESSION['expand_structureedit_logo'.$main_activatedidlang[$k]] = trim(htmlspecialchars($_POST['expand_structureedit_logo'.$main_activatedidlang[$k]], ENT_QUOTES));
    }
    
    $id_element2 = $_SESSION['structure_edit_id_element'];
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_logo = :id
                       ORDER BY date_image DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_element2);
    $query->execute();
    
    $i = 0;
    
    while($data = $query->fetch())
    {
        $array_id_image_logo[$i] = $data[0];
        $array_name_image_logo[$i] = $data['name_image'];
        $array_path_image_logo[$i] = $data['path_image'];
        $array_paththumb_image_logo[$i] = $data['paththumb_image'];
        $array_pathsearch_image_logo[$i] = $data['pathsearch_image'];
        $i++;
    }
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

for($i = 0, $count = count($array_id_image_logo); $i < $count; $i++)
{
    if(isset($_POST['bt_delete_image_logo'.$array_id_image_logo[$i]]))
    {
        try
        {
            $_SESSION['msg_structure_edit_main_logo_upload_logo'] = destroy_image($array_path_image_logo[$i], $array_paththumb_image_logo[$i], $array_pathsearch_image_logo[$i], $array_name_image_logo[$i]);
            
            $prepared_query = 'DELETE FROM structure_image
                               WHERE id_image = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $array_id_image_logo[$i]);
            $query->execute();
            $query->closeCursor();
            
            reallocate_table_id('id_image', 'structure_image');  
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
        
        $i = $count;
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.'Gestion/Structure');
        }
        else
        {
            header('Location: '.$config_customheader.'Backoffice/Gestion/Structure');
        }
    }
}
?>
