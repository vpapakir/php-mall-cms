<?php
try
{
    $id_element2 = $_SESSION['structure_edit_id_element'];
    $prepared_query = 'SELECT * FROM structure_image
                       WHERE id_layout_top = :id
                       ORDER BY date_image DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_element2);
    $query->execute();
    
    $i = 0;
    
    while($data = $query->fetch())
    {
        $array_id_image_layout_top[$i] = $data[0];
        $array_name_image_layout_top[$i] = $data['name_image'];
        $array_path_image_layout_top[$i] = $data['path_image'];
        $array_paththumb_image_layout_top[$i] = $data['paththumb_image'];
        $array_pathsearch_image_layout_top[$i] = $data['pathsearch_image'];
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

for($i = 0, $count = count($array_id_image_layout_top); $i < $count; $i++)
{
    if(isset($_POST['bt_delete_image_layout_top'.$array_id_image_layout_top[$i]]))
    {
        try
        {
            $_SESSION['msg_structure_edit_main_layout_upload_layout_top'] = destroy_image($array_path_image_layout_top[$i], $array_paththumb_image_layout_top[$i], $array_pathsearch_image_layout_top[$i], $array_name_image_layout_top[$i]);
            
            $prepared_query = 'DELETE FROM structure_image
                               WHERE id_image = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $array_id_image_layout_top[$i]);
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
