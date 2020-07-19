<?php
try
{
    $id_page_uploadpage = $_SESSION['page_select_cboPageSelect'];
    $prepared_query = 'SELECT * FROM page_image
                       WHERE id_page = :id
                       ORDER BY date_image DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $id_page_uploadpage);
    $query->execute();
    
    $i = 0;
    
    while($data = $query->fetch())
    {
        $array_id_image_page_uploadpage[$i] = $data[0];
        $array_name_image_page_uploadpage[$i] = $data['name_image'];
        $array_path_image_page_uploadpage[$i] = $data['path_image'];
        $array_paththumb_image_page_uploadpage[$i] = $data['paththumb_image'];
        $array_pathsearch_image_page_uploadpage[$i] = $data['pathsearch_image'];
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

for($i = 0, $count = count($array_id_image_page_uploadpage); $i < $count; $i++)
{
    if(isset($_POST['bt_delete_image_page'.$array_id_image_page_uploadpage[$i]]))
    {
        try
        {
            $_SESSION['msg_page_edit_upload'] = destroy_image($array_path_image_page_uploadpage[$i], $array_paththumb_image_page_uploadpage[$i], $array_pathsearch_image_page_uploadpage[$i], $array_name_image_page_uploadpage[$i]);
            
            $prepared_query = 'DELETE FROM page_image
                               WHERE id_image = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $array_id_image_page_uploadpage[$i]);
            $query->execute();
            $query->closeCursor();
            
            reallocate_table_id('id_image', 'page_image');  
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
        
        $i = $count;
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
    }
}
?>
