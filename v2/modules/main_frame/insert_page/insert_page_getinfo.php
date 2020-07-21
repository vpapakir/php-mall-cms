<?php
/*SELECT all colums values From PAGE where url_page column value
         *  = $page according to the selected language*/       
$prepared_query = 'SELECT *
                   FROM page p
                   WHERE p.url_page = :url
                   AND p.status_page = 1';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$url_to_select = htmlspecialchars($pageok, ENT_QUOTES);
$query->bindParam('url', $url_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $Bok_error_404 = false;
    $id_page = $data[0];
    $template_page = $data['template_page'];
    $url_page = $data['url_page'];
    $insert_script_page = $data['script_page'];
    $family_page = $data['family_page'];
    $listingrelated_page = $data['listingrelated_page'];
    $rights_page = $data['level_rights'];
}
else
{
    $Bok_error_404 = true;
}
$query->closeCursor();

#image
$prepared_query = 'SELECT *
                   FROM page_image
                   WHERE id_page = :id
                   ORDER BY position_image';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$id_to_select = htmlspecialchars($id_page, ENT_QUOTES);
$query->bindParam('id', $id_to_select);
$query->execute();

#unset($id_image_page,$legend_image_page,$path_image_page,$path_thumb_page,$alt_image_page[$i]);
if(($data = $query->fetch()) == false)
{
    
}
else
{
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $id_image_page[$i] = $data[0];
        $legend_image_page[$i] = $data['L'.$main_id_language];
        $path_origin_page[$i] = $data['path_image'];
        $path_thumb_page[$i] = $data['paththumb_image'];
        $alt_image_page[$i] = $data['alt_image'];
        $i++;
    } 
}
$query->closeCursor();

#title
$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM page_translation
                   WHERE id_page = :page
                   AND family_page_translation = "title"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$page_to_select = htmlspecialchars($id_page, ENT_QUOTES);
$query->bindParam('page', $page_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $title_page = $data[0];
    $title_page = give_prioritylangcontent($title_page, $id_page, 'title');
}

#intro
$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM page_translation
                   WHERE id_page = :page
                   AND family_page_translation = "intro"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$id_page_to_select = htmlspecialchars($id_page, ENT_QUOTES);
$query->bindParam('page', $id_page_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $intro_page = stripslashes($data[0]);
    $intro_page = stripslashes(give_prioritylangcontent($intro_page, $id_page, 'intro'));
}

#desc
$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM page_translation
                   WHERE id_page = :page
                   AND family_page_translation = "desc"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$id_page_to_select = htmlspecialchars($id_page, ENT_QUOTES);                                                                                             $query->bindParam('page', $id_page_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $desc_page = stripslashes($data[0]);
    $desc_page = stripslashes(give_prioritylangcontent($desc_page, $id_page, 'desc'));
}

#URL rewriting Frontend
$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM page_translation
                   WHERE id_page = :page
                   AND family_page_translation = "rewritingF"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$id_page_to_select = htmlspecialchars($id_page, ENT_QUOTES);
$query->bindParam('page', $id_page_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $rewritingF_page = $data[0];
    
}
$query->closeCursor();

#URL rewriting Backoffice
$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM page_translation
                   WHERE id_page = :page
                   AND family_page_translation = "rewritingB"';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$id_page_to_select = htmlspecialchars($id_page, ENT_QUOTES);
$query->bindParam('page', $id_page_to_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $rewritingB_page = $data[0];
}
$query->closeCursor();

#ADMIN INFO ONLY

#PAGE SPECIFICATION
include('modules/main_frame/insert_page/insert_page_specification.php');   
?>
