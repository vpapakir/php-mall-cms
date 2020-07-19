<?php
$prepared_query = 'SELECT MAX(id_page) FROM page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $last_id_productproperty = $data[0];
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
        $prepared_query .= '\''.$code_productproperty.'\', ';
    }
    else
    {
        $prepared_query .= '\''.$code_productproperty.'\')';
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_productproperty.'.browser',
                      'family' => 'browser',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
                      'code' => $code_productproperty.'.title',
                      'family' => 'title',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
                      'code' => $code_productproperty.'.intro',
                      'family' => 'intro',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
                      'code' => $code_productproperty.'.desc',
                      'family' => 'desc',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
                      'code' => $code_productproperty.'.tags',
                      'family' => 'tags',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
        $prepared_query .= '\''.$array_urlrewritingF_producturl[$i].'\', ';
    }
    else
    {
        $prepared_query .= '\''.$array_urlrewritingF_producturl[$i].'\')';
    }
}
                
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_productproperty.'.rewritingF',
                      'family' => 'rewritingF',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
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
        $prepared_query .= '\''.$array_urlrewritingB_producturl[$i].'\', ';
    }
    else
    {
        $prepared_query .= '\''.$array_urlrewritingB_producturl[$i].'\')';
    }
}
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'code' => $code_productproperty.'.rewritingB',
                      'family' => 'rewritingB',
                      'content' => $typecontent_productproperty,
                      'id_page' => $last_id_productproperty
                      ));
$query->closeCursor();
#- menu, browser, title, intro, desc, tags, URLrewriting -
?>
