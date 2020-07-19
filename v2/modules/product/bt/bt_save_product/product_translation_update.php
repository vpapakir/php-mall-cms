<?php
#- menu, browser, title, intro, desc, tags, URLrewriting -

#title
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_title_productcontent[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_title_productcontent[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "title"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();


#intro                
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_intro_productcontent[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_intro_productcontent[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "intro"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();

#desc
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_desc_productcontent[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_desc_productcontent[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "desc"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();

#browser
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_browser_productcontent[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_browser_productcontent[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "browser"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();

#tags
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_tags_productcontent[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_tags_productcontent[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "tags"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();

#rewriting backoffice
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_urlrewritingB_producturl[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_urlrewritingB_producturl[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "rewritingB"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();

#rewriting frontend
$prepared_query = 'UPDATE page_translation
                   SET ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_urlrewritingF_producturl[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$array_urlrewritingF_producturl[$i].'\' ';
    }
}

$prepared_query .= 'WHERE id_page = :id AND family_page_translation = "rewritingF"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $selected_product);
$query->execute();
$query->closeCursor();
#- menu, browser, title, intro, desc, tags, URLrewriting -
?>
