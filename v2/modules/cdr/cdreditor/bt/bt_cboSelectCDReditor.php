<?php
if(isset($_POST['bt_cboSelectCDReditor']) || isset($_GET['cdr']))
{
    if(!isset($_GET['cdr']))
    {
        unset($_SESSION['cdreditor_add_displayFamilyOptions']);
    }
    unset($_SESSION['msg_cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['msg_cdreditor_add_txtPosCDReditor'],
            $_SESSION['msg_cdreditor_addedit_done']);
    
    unset($_SESSION['cdreditor_add_cboFamilyCDReditor'],
            $_SESSION['cdreditor_add_cboModeCDReditor'],
            $_SESSION['cdreditor_add_txtPosCDReditor'],
            $_SESSION['cdreditor_add_cboStatusCDReditor'],
            $_SESSION['cdreditor_add_cantdelete']);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'],
                $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P']);
    }
    
    if(!isset($_GET['cdr']))
    {    
        $selected_option_cdreditor = htmlspecialchars($_POST['cboSelectCDReditor'], ENT_QUOTES);
    }
    else
    {
        $selected_option_cdreditor = htmlspecialchars($_GET['cdr'], ENT_QUOTES);
    }
    
    
    if($selected_option_cdreditor == 'new')
    {
        unset($_SESSION['cdreditor_cboSelectCDReditor'],
                $_SESSION['cdreditor_cboSelectCodeCDReditor']);
    }
    else
    {
        $_SESSION['cdreditor_cboSelectCDReditor'] = $selected_option_cdreditor;
        
        try
        {
            $prepared_query = 'SELECT * FROM cdreditor
                               WHERE id_cdreditor = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $selected_option_cdreditor);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['cdreditor_add_cboFamilyCDReditor'] = $data['code_cdreditor'];
                $_SESSION['cdreditor_cboSelectCodeCDReditor'] = $data['code_cdreditor'];
                $_SESSION['cdreditor_add_cboModeCDReditor'] = $data['type_cdreditor'];
                $_SESSION['cdreditor_add_txtPosCDReditor'] = $data['position_cdreditor'];
                $_SESSION['cdreditor_add_cboStatusCDReditor'] = $data['statusobject_cdreditor'];
                $_SESSION['cdreditor_add_cantdelete'] = $data['cantdelete_cdreditor'];
                
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'S'] = $data['L'.$main_activatedidlang[$i].'S'];
                    $_SESSION['cdreditor_add_txtNameL'.$main_activatedidlang[$i].'P'] = $data['L'.$main_activatedidlang[$i].'P'];
                }
            }
            $query->closeCursor();
            
            $prepared_query = 'SELECT id_cdreditor, L'.$main_id_language.'S, statusobject_cdreditor FROM cdreditor
                               WHERE code_cdreditor = :code
                               ORDER BY L'.$main_id_language.'S';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('code', $_SESSION['cdreditor_add_cboFamilyCDReditor']);
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
