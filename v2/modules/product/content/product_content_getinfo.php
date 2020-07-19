<?php
try
{
    if(!empty($_SESSION['product_select_cboProductSelect']))
    {
        $prepared_query = 'SELECT * FROM page_image
                           WHERE id_page = :id
                           ORDER BY position_image';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', trim(htmlspecialchars($_SESSION['product_select_cboProductSelect'], ENT_QUOTES)));
        $query->execute();
        $i = 0;
        while($data = $query->fetch())
        {
            $idimage_saving_product[$i] = $data[0];
            $i++;
        }
        $query->closeCursor();
        
        $total_position_image_saving_product = count($idimage_saving_product);
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
?>
