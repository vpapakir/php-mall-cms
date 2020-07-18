<?php
try
{
    include('modules/settings/urlrewriting/rewriting_getinfo.php');
    
    $prepared_query = 'SELECT COUNT(id_rewriting_url) FROM rewriting_url';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $lastid_rewritingurl = $data[0];
    }
    $query->closeCursor();
    
    include('modules/settings/urlrewriting/rewriting_createcontent.php');
    
    if($lastid_rewritingurl == 0)
    {
        include('modules/settings/urlrewriting/rewriting_insert.php');
    }
    else
    {
        include('modules/settings/urlrewriting/rewriting_update.php');
    }
    
    include('modules/settings/urlrewriting/rewriting_replaceht.php');
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
