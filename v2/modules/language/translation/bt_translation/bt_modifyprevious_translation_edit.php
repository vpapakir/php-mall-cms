<?php
if(isset($_POST['bt_modifyprevious_translation_edit']))
{
    unset($_SESSION['msg_translation_edit_modify_done'],
            $_SESSION['msg_translation_code_error']);
    unset($_SESSION['translation_new_cboPageTranslation'],
            $_SESSION['translation_new_txtGroupCodeTranslation']);
    
    $id_translation_edit = trim(htmlspecialchars($_SESSION['translation_edit_id'], ENT_QUOTES));
    $selected_page_translation = trim(htmlspecialchars($_POST['cboPageTranslation'], ENT_QUOTES));
    $session_page_translation = $selected_page_translation;
    $code1_translation = trim(htmlspecialchars($_POST['txtGroupCodeTranslation'], ENT_QUOTES));
    $code2_translation = trim(htmlspecialchars($_POST['txtCodeTranslation'], ENT_QUOTES));
    $Bok_page_main = false;
    $Bok_code_country = false;
    $Bok_code_exist = false;
    $protectedcontent_translation = null;
    
    for($i = 0, $count = count($countactivated_language); $i < $count; $i++)
    {
        $area_translation[$i] = trim(htmlspecialchars($_POST['areaTranslationL'.$countactivated_language[$i]], ENT_QUOTES));
        if($i == 0)
        {
            $protectedcontent_translation = trim(htmlspecialchars($_POST['chk_ProtectedcontentTranslation'.$countactivated_language[$i]], ENT_QUOTES));
        }
        else
        {
            $protectedcontent_translation .= '$'.trim(htmlspecialchars($_POST['chk_ProtectedcontentTranslation'.$countactivated_language[$i]], ENT_QUOTES));
        }        
    }
    
    if($selected_page_translation == 'main')
    {
       $selected_page_translation = 0; 
       $Bok_page_main = true;
    }
    
    try
    {
        if($Bok_page_main === false)
        {
            $prepared_query = 'SELECT id_page FROM page
                               WHERE url_page = :url';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('url', $selected_page_translation);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $selected_page_translation = $data[0];
            }
            $query->closeCursor();
        }
        
        $prepared_query = 'SELECT code_country FROM country';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        while($data = $query->fetch())
        {
            if($code2_translation == $data[0])
            {
                $Bok_code_country = true;
            }
        }
        $query->closeCursor();
        
        if($Bok_code_country === true)
        {
            $code_translation_edit = $code2_translation;
        }
        else
        {
            $code_translation_edit = $code1_translation.$code2_translation;
        }
      
        $prepared_query = 'UPDATE translation
                           SET code_translation = :code,
                               protected_translation = :protected,
                               id_page = :page, ';
        for($i = 1, $y = 0; $i <= $count_lang; $i++, $y++)
        {
            if($i < $count_lang)
            {
                $prepared_query .= 'L'.$countactivated_language[$y].' = \''.$area_translation[$y].'\', ';
            }
            else
            {
                $prepared_query .= 'L'.$countactivated_language[$y].' = \''.$area_translation[$y].'\'';
            }
        }

        $prepared_query .= ' WHERE id_translation = :id';

        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'code' => $code_translation_edit,
                              'protected' => $protectedcontent_translation,
                              'page' => $selected_page_translation,
                              'id' => $id_translation_edit
                              ));
        $query->closeCursor();

        $_SESSION['msg_translation_edit_modify_done']  = '"'.$code_translation_edit.'" a été modifée';       
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

    try
    { 
        $prepared_query = 'SELECT MAX(id_translation) FROM translation';

        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $last_id_translation_edit = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT MIN(id_translation) FROM translation';

        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $first_id_translation_edit = $data[0];
        }
        $query->closeCursor();

        if($id_translation_edit == $first_id_translation_edit)
        {
           $id_translation_edit = $last_id_translation_edit; 
        }
        else
        {
           $id_translation_edit--;
        }
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

    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Traductions/'.$id_translation_edit);
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Traductions/'.$id_translation_edit);
    }
    
}
?>
