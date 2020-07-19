<?php
$prepared_query = 'SELECT MAX(id_page) FROM page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $last_id_pageproperty = $data[0];
}
$query->closeCursor();

#- browser, title, intro, desc, tags, URLrewriting -

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].') ';
    }
}
$prepared_query .= 'VALUES
                   (:code, :family, :content, :id_page, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= '\''.$code_pageproperty.'\', ';
    }
    else
    {
        $prepared_query .= '\''.$code_pageproperty.'\')';
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.browser',
                      'family' => 'browser',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page)
                   VALUES
                   (:code, :family, :content, :id_page)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.title',
                      'family' => 'title',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page)
                   VALUES
                   (:code, :family, :content, :id_page)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.intro',
                      'family' => 'intro',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page)
                   VALUES
                   (:code, :family, :content, :id_page)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.desc',
                      'family' => 'desc',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page)
                   VALUES
                   (:code, :family, :content, :id_page)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.tags',
                      'family' => 'tags',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].') ';
    }
}

$prepared_query .= 'VALUES
                   (:code, :family, :content, :id_page, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= '\''.$array_urlrewritingF_pageurl[$i].'\', ';
    }
    else
    {
        $prepared_query .= '\''.$array_urlrewritingF_pageurl[$i].'\')';
    }
}
                
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.rewritingF',
                      'family' => 'rewritingF',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();

$prepared_query = 'INSERT INTO page_translation
                   (code_page_translation, family_page_translation, 
                    typecontent_page_translation, id_page, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].') ';
    }
}

$prepared_query .= 'VALUES
                   (:code, :family, :content, :id_page, ';

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= '\''.$array_urlrewritingB_pageurl[$i].'\', ';
    }
    else
    {
        $prepared_query .= '\''.$array_urlrewritingB_pageurl[$i].'\')';
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_pageproperty.'.rewritingB',
                      'family' => 'rewritingB',
                      'content' => $typecontent_pageproperty,
                      'id_page' => $last_id_pageproperty
                      ));
$query->closeCursor();
#- menu, browser, title, intro, desc, tags, URLrewriting -
?>
