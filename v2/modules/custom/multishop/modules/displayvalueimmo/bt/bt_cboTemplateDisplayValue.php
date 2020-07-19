<?php
if(isset($_POST['bt_cboTemplateDisplayValue']))
{
    unset($_SESSION['displayvalue_cboTemplateDisplayValue'],
            $_SESSION['displayvalue_checkbox'],
            $_SESSION['displayvalue_checkbox_all']);
    
    unset($_SESSION['msg_displayvalue_done']);
    
    $selected_template_displayvalue = htmlspecialchars($_POST['cboTemplateDisplayValue'], ENT_QUOTES);
    
    
    if($selected_template_displayvalue == 'select')
    {
        unset($_SESSION['displayvalue_cboTemplateDisplayValue']);
    }
    else
    {
        $_SESSION['displayvalue_cboTemplateDisplayValue'] = $selected_template_displayvalue;
        try
        {
            $prepared_query = 'SELECT displayvalue_script_template
                               FROM script_template
                               WHERE name_script_template = :name';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('name', $selected_template_displayvalue);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $_SESSION['displayvalue_checkbox'] = $data[0];
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
