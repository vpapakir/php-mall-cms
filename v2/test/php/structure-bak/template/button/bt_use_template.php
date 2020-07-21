<?php
if(isset($_POST['bt_use_template']))
{
    $id_template = $_SESSION['structure_template_cboTemplate'];
    
    try
    {
        $prepared_query = 'UPDATE structure_template
                           SET status_template = 0';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $query->closeCursor();
        
        $prepared_query = 'UPDATE structure_template
                           SET status_template = 1
                           WHERE id_template = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_template);
        $query->execute();
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        include('modules/error/catch/catch400.php');
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
