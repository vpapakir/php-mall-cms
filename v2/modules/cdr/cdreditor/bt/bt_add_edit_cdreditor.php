<?php
if(isset($_POST['bt_add_cdreditor']) || isset($_POST['bt_edit_cdreditor']))
{
    unset($_SESSION['msg_cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['msg_cdreditor_add_txtPosCDReditor'],
            $_SESSION['msg_cdreditor_addedit_done']);
    
    unset($_SESSION['cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['cdreditor_add_cboModeCDReditor'],
            $_SESSION['cdreditor_add_txtPosCDReditor'],
            $_SESSION['cdreditor_add_cboStatusCDReditor']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'],
                $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P']);
    }
    
    $msg_cdreditor_add_family = 'Veuillez sélectionner une famille';
    $msg_cdreditor_add_alreadyexist = 'L\'option existe déjà pour cette famille';
    $msg_cdreditor_add_position_length = 'La position doit être de 4 chiffres (ex: 1100, 2010, ...)';
    $msg_cdreditor_add_position_numeric = 'La position doit être de type numérique (ex: 1100, 2010, ...)';
    
    $selected_option_cdreditor = htmlspecialchars($_POST['cboSelectCDReditor'], ENT_QUOTES);
    
    if(isset($_POST['bt_add_cdreditor']))
    {
        $cdreditor_add_family = htmlspecialchars($_POST['cboFamilyCDReditor'], ENT_QUOTES);       
    }
    else
    {
        $prepared_query = 'SELECT code_cdreditor FROM cdreditor
                            WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $selected_option_cdreditor);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $cdreditor_add_family = $data[0];
        }
        $query->closeCursor();
    }
    
    
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $cdreditor_add_namelangS[$i] = trim(htmlspecialchars($_POST['txtNameL'.$main_activatedidlang[$i].'S'], ENT_QUOTES));
        $cdreditor_add_namelangP[$i] = trim(htmlspecialchars($_POST['txtNameL'.$main_activatedidlang[$i].'P'], ENT_QUOTES));
    }
    
    $cdreditor_add_mode = htmlspecialchars($_POST['cboModeCDReditor'], ENT_QUOTES);
    $cdreditor_add_position = trim(htmlspecialchars($_POST['txtPosCDReditor'], ENT_QUOTES));
    $cdreditor_add_status = htmlspecialchars($_POST['cboStatusCDReditor'], ENT_QUOTES);
    
    $Bok_cdreditor_add_insert = true;
    
    if($cdreditor_add_mode == 'select' || empty($cdreditor_add_mode))
    {
        try
        {
            $prepared_query = 'SELECT type_cdreditor 
                               FROM cdreditor
                               WHERE code_cdreditor = :code';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('code', $cdreditor_add_family);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $cdreditor_add_mode = $data[0];
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
    }
    
    if(isset($_POST['bt_add_cdreditor']))
    {
        if($cdreditor_add_family == 'select')
        {
            $Bok_cdreditor_add_insert = false;
            $_SESSION['msg_cdreditor_add_cboFamilyCDReditor'] = $msg_cdreditor_add_family;
        }
        else
        {       
            try
            {
                $prepared_query = 'SELECT id_cdreditor
                                   FROM cdreditor
                                   WHERE code_cdreditor = :code
                                   AND (L'.$main_id_language.'S = :currentlangS
                                   OR L'.$main_id_language.'P = :currentlangP)';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'code' => $cdreditor_add_family,
                                      'currentlangS' => $cdreditor_add_namelangS[0],
                                      'currentlangP' => $cdreditor_add_namelangP[0]
                                      ));

                if(($data = $query->fetch()) != false)
                {
                    $Bok_cdreditor_add_insert = false;
                    $_SESSION['msg_cdreditor_add_cboFamilyCDReditor'] = $msg_cdreditor_add_alreadyexist;
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
        }
    }
    
    if(strlen($cdreditor_add_position) != 4)
    {
        $Bok_cdreditor_add_insert = false;
        $_SESSION['msg_cdreditor_add_txtPosCDReditor'] = $msg_cdreditor_add_position_length;
    }
    
    if(!is_numeric($cdreditor_add_position))
    {
        $Bok_cdreditor_add_insert = false;
        $_SESSION['msg_cdreditor_add_txtPosCDReditor'] = $msg_cdreditor_add_position_numeric;
    }
    
    if(empty($cdreditor_add_position))
    {
        $cdreditor_add_position = 1010;
    }
    
    if($Bok_cdreditor_add_insert == true)
    {
        try
        {
            if(isset($_POST['bt_add_cdreditor']))
            {
                include('modules/cdr/cdreditor/bt/cdreditor_insert.php'); 
                
                $prepared_query = 'SELECT id_cdreditor, L'.$main_id_language.'S, statusobject_cdreditor FROM cdreditor
                                   WHERE code_cdreditor = :code
                                   ORDER BY L'.$main_id_language.'S';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('code', $cdreditor_add_family);
                $query->execute();

                $i = 0;
                while($data = $query->fetch())
                {
                    $cdreditor_temp_familyoptions[$i] = $data[1].'$'.$data[0].'$'.$data[2];
                    $i++;
                }
                $query->closeCursor();
            
                $_SESSION['cdreditor_add_cboFamilyCDReditor'] = $cdreditor_add_family;   
                $_SESSION['cdreditor_add_displayFamilyOptions'] = $cdreditor_temp_familyoptions;
            }

            if(isset($_POST['bt_edit_cdreditor']))
            {
                include('modules/cdr/cdreditor/bt/cdreditor_update.php'); 
                
                $prepared_query = 'SELECT id_cdreditor, L'.$main_id_language.'S, statusobject_cdreditor FROM cdreditor
                                   WHERE code_cdreditor = :code
                                   ORDER BY L'.$main_id_language.'S';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('code', $cdreditor_add_family);
                $query->execute();

                $i = 0;
                while($data = $query->fetch())
                {
                    $cdreditor_temp_familyoptions[$i] = $data[1].'$'.$data[0].'$'.$data[2];
                    $i++;
                }
                $query->closeCursor();
            
                $_SESSION['cdreditor_add_cboFamilyCDReditor'] = $cdreditor_add_family;   
                $_SESSION['cdreditor_add_displayFamilyOptions'] = $cdreditor_temp_familyoptions;
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
    }
    else
    {
        $_SESSION['cdreditor_add_cboFamilyCDReditor'] = $cdreditor_add_family;
        $_SESSION['cdreditor_add_cboModeCDReditor'] = $cdreditor_add_mode;
        $_SESSION['cdreditor_add_txtPosCDReditor'] = $cdreditor_add_position;
        $_SESSION['cdreditor_add_cboStatusCDReditor'] = $cdreditor_add_status;
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'] = $cdreditor_add_namelangS[$i];
            $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P'] = $cdreditor_add_namelangP[$i];
        }
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
