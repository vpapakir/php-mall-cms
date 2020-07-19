<?php
try
{
    #get current language code
    $prepared_query = 'SELECT code_language FROM language
                       WHERE id_language = :idlanguage';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idlanguage', $main_id_language);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_meta_currentlangcode = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT id_language FROM language
                       WHERE priority_language = 1';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_language_idpriority = $data[0];
    }
    $query->closeCursor();
    
    #get current page title
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = :url
                       AND family_page_translation = "title"';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('url', $_SESSION['current_page']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_currentpage_title = $data[0];
    }
    $query->closeCursor();
    
    #get current page intro
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = :url
                       AND family_page_translation = "intro"';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('url', $_SESSION['current_page']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_currentpage_intro = trim(strip_tags($data[0]));
    }
    $query->closeCursor();
    
    #get current page tags
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = :url
                       AND family_page_translation = "tags"';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('url', $_SESSION['current_page']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_currentpage_tags = $data[0];
        $main_currentpage_tags = trim(preg_replace('#[0-9]{4,}?#', '', $main_currentpage_tags));
        $main_currentpage_tags = str_replace_char($main_currentpage_tags, $main_id_language, true);
        $main_currentpage_tags = replace_dirtyword($main_currentpage_tags, $main_id_language, true);
    }
    $query->closeCursor();
    
    #get current page browser title
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = :url
                       AND family_page_translation = "browser"';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('url', $_SESSION['current_page']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $main_currentpage_browser = $data[0];
    }
    $query->closeCursor();
    
    #get home link
    $prepared_query = 'SELECT url_page, L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = "home_frontend"
                       AND family_page_translation = "rewritingF"';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(!empty($data[1]))
        {
            $main_home_rewritingF = $data[1];
        }
        else
        {
            $main_home_rewritingF = 'index.php?page='.$data['url_page'];
        }
    }
    $query->closeCursor();
    
    #get dispatcher link
    $prepared_query = 'SELECT url_page, L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = "login_subscribe"
                       AND family_page_translation = "rewritingF"';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(!empty($data[1]))
        {
            $main_dispatcher_rewritingF = $data[1];
        }
        else
        {
            $main_dispatcher_rewritingF = 'index.php?page='.$data['url_page'];
        }
    }
    $query->closeCursor();
    
    #get browser title
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = :url
                       AND family_page_translation = "browser"';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('url', $_SESSION['current_page']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(!empty($data[0]))
        {
            $main_browsertitle = $config_sitename.': '.$data[0];
        }
        else
        {
            $main_browsertitle = $config_sitename;
        }
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
