<?php
try
{
    $id_element2 = $_SESSION['structure_edit_id_element'];
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_skin = :id
                       ORDER BY date_image DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_element2);
    $query->execute();
    
    $i = 0;
    
    while($data = $query->fetch())
    {
        $array_id_image_skin[$i] = $data[0];
        $array_name_image_skin[$i] = $data['name_image'];
        $array_path_image_skin[$i] = $data['path_image'];
        $array_paththumb_image_skin[$i] = $data['paththumb_image'];
        $array_pathsearch_image_skin[$i] = $data['pathsearch_image'];
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    } 
}

for($i = 0, $count = count($array_id_image_skin); $i < $count; $i++)
{
    if(isset($_POST['bt_delete_image_skin'.$array_id_image_skin[$i]]))
    {
        try
        {
            $_SESSION['msg_structure_edit_main_skin_upload_skin'] = destroy_image($array_path_image_skin[$i], $array_paththumb_image_skin[$i], $array_pathsearch_image_skin[$i], $array_name_image_skin[$i]);
            
            $prepared_query = 'DELETE FROM structure_image
                               WHERE id_image = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $array_id_image_skin[$i]);
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
