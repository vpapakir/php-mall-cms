<?php
try
{
    $prepared_query = 'SELECT L'.$main_id_language.'
                       FROM page_translation
                       WHERE id_page = 2
                       AND (family_page_translation = "rewritingF"
                       OR family_page_translation = "rewritingB")';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $link_newpage_sitemap[$i] = $data[0];
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
?>
