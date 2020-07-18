<?php
try
{
    if(!empty($_SESSION['index']) && $_SESSION['index'] == 'index.php')
    {
         $prepared_query = 'SELECT * FROM page
                            INNER JOIN page_translation
                            ON page_translation.id_page = page.id_page
                            WHERE url_page = "home_frontend"
                            AND family_page_translation = "rewritingF"';
    }
    else
    {
         $prepared_query = 'SELECT * FROM page
                            INNER JOIN page_translation
                            ON page_translation.id_page = page.id_page
                            WHERE url_page = "home_backoffice"
                            AND family_page_translation = "rewritingF"';
    }
    
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $error404_redirection = $data[0];
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
<table width="100%">  
        <tr>
            <td align="center"><span class="font_main">La page n'existe pas ou plus, désolé pour la gêne occasionnée</span></td>
        </tr>
        <tr>
            <td align="center"><span class="font_main">Pour revenir à la page d'acceuil, <a class="link_main" href="<?php echo($config_customheader.$error404_redirection); ?>">Cliquez ici</a></span></td>
        </tr>
</table>
