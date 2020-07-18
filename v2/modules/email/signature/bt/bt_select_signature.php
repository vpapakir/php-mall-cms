<?php
if(isset($_POST['bt_select_signature']))
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
    
    unset($_SESSION['signature_txtScriptpathSignature'],
            $_SESSION['signature_cboTemplateSignature']);
    unset($_SESSION['msg_signature_txtNameSignature'],
            $_SESSION['msg_signature_done']);
    
    $signature_selected = htmlspecialchars($_POST['cboTemplateSignature'], ENT_QUOTES);
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        unset($_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]],
                $_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]]);
    }
    
    if($signature_selected != 'new')
    {
        $_SESSION['signature_cboTemplateSignature'] = $signature_selected;
        
        try
        {
            $prepared_query = 'SELECT *
                               FROM `email_signature`
                               WHERE id_signature = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $signature_selected);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['signature_txtScriptpathSignature'] = $data['scriptpath_signature'];
                for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
                {
                    $_SESSION['signature_txtNameSignature'.$main_activatedidlang[$i]] = $data['L'.$main_activatedidlang[$i].'T'];
                    $_SESSION['signature_areaContentSignature'.$main_activatedidlang[$i]] = stripslashes($data['L'.$main_activatedidlang[$i].'S']);
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
    }   
}
?>
