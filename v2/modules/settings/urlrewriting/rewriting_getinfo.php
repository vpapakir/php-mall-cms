<?php
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $prepared_query = 'SELECT * FROM page
                       INNER JOIN page_translation AS pagetrTitle
                       ON pagetrTitle.id_page = page.id_page
                       WHERE pagetrTitle.family_page_translation = "title"
                       ORDER BY page.family_page, page.id_page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $x = 0;
    while($data = $query->fetch())
    {
        if(empty($data['L'.$main_activatedidlang[$i]]))
        {
            $pagename_rewritingurl[$i][$x] = $data['code_page'];
        }
        else
        {
            $pagename_rewritingurl[$i][$x] = $data['L'.$main_activatedidlang[$i]];
        }
        
        $pageurl_rewritingurl[$i][$x] = $data['url_page'];      
        $x++;
    }
    $query->closeCursor();

    $prepared_query = 'SELECT * FROM page
                       INNER JOIN page_translation AS pagetrFrontend
                       ON pagetrFrontend.id_page = page.id_page
                       WHERE pagetrFrontend.family_page_translation = "rewritingF"
                       ORDER BY page.family_page, page.id_page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $x = 0;
    while($data = $query->fetch())
    {
        $pagefrontend_rewritingurl[$i][$x] = $data['L'.$main_activatedidlang[$i]];
        $x++;
    }
    $query->closeCursor();

    $prepared_query = 'SELECT * FROM page
                       INNER JOIN page_translation AS pagetrBackoffice
                       ON pagetrBackoffice.id_page = page.id_page
                       WHERE pagetrBackoffice.family_page_translation = "rewritingB"
                       ORDER BY page.family_page, page.id_page';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $x = 0;
    while($data = $query->fetch())
    {
        $pagebackoffice_rewritingurl[$i][$x] = $data['L'.$main_activatedidlang[$i]];
        $x++;
    }
    $query->closeCursor();
}
?>
