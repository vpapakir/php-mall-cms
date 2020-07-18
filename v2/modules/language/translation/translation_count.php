<?php
try
{
    $prepared_query = 'SELECT COUNT(id_language) FROM language';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $countall_language = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT id_language FROM language
                       WHERE status_language = 1
                       ORDER BY priority_language DESC, position_language';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $countactivated_language[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT COUNT(id_language) FROM language
                       WHERE status_language = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()))
    {
        $count_lang = $data[0];
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
?>
