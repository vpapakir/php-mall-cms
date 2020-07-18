<?php
if(isset($_POST['bt_cboFamilyCDReditor']))
{    
    unset($_SESSION['cdreditor_add_displayFamilyOptions']);
    
    $cdreditor_selected_family = htmlspecialchars($_POST['cboFamilyCDReditor'], ENT_QUOTES);
    
    $_SESSION['cdreditor_add_cboFamilyCDReditor'] = $cdreditor_selected_family;
    $_SESSION['cdreditor_add_cboModeCDReditor'] = htmlspecialchars($_POST['cboModeCDReditor'], ENT_QUOTES);
    $_SESSION['cdreditor_add_txtPosCDReditor'] = trim(htmlspecialchars($_POST['txtPosCDReditor'], ENT_QUOTES));
    $_SESSION['cdreditor_add_cboStatusCDReditor'] = htmlspecialchars($_POST['cboStatusCDReditor'], ENT_QUOTES);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'] = trim(htmlspecialchars($_POST['txtNameL'.$main_activatedidlang[$i].'S'], ENT_QUOTES));
        $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P'] = trim(htmlspecialchars($_POST['txtNameL'.$main_activatedidlang[$i].'P'], ENT_QUOTES));
    }

    if($cdreditor_selected_family != 'select')
    {
        
        try
        {
            $prepared_query = 'SELECT id_cdreditor, L'.$main_id_language.'S, statusobject_cdreditor FROM cdreditor
                               WHERE code_cdreditor = :code
                               ORDER BY L'.$main_id_language.'S';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('code', $cdreditor_selected_family);
            $query->execute();

            $i = 0;
            while($data = $query->fetch())
            {
                $cdreditor_temp_familyoptions[$i] = $data[1].'$'.$data[0].'$'.$data[2];
                $i++;
            }
            $query->closeCursor();
            
            $_SESSION['cdreditor_add_displayFamilyOptions'] = $cdreditor_temp_familyoptions;
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
