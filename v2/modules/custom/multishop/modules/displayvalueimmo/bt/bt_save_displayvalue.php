<?php
if(isset($_POST['bt_save_displayvalue']))
{  
    unset($_SESSION['displayvalue_cboTemplateDisplayValue'],
            $_SESSION['displayvalue_checkbox'],
            $_SESSION['displayvalue_checkbox_all']);
    
    unset($_SESSION['msg_displayvalue_done']);
    
    $selected_template_displayvalue = htmlspecialchars($_POST['cboTemplateDisplayValue'], ENT_QUOTES);
    
    try
    {
        $prepared_query = 'SELECT transcode_script_template
                           FROM script_template
                           WHERE name_script_template = :code';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('code', $selected_template_displayvalue);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $code_template_displayvalue = $data[0];
        }
        $query->closeCursor();    
        
        $prepared_query = 'SHOW COLUMNS FROM immo_product';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;
        $y = 0;
        
        $Bok_checked_all = true;
        
        while($data = $query->fetch())
        {
           if($i >= 4 && $i != 14) #14 = surfacegroundm2
           {
               if($_POST['chk_'.$data[0]] == null)
               {
                   $arraychecked_option_displayvalue[$y] = 9;
                   $Bok_checked_all = false;
               }
               else
               {
                   $arraychecked_option_displayvalue[$y] = 1;
                   
               }               
               $y++;
           }
           $i++;
        }
        $query->closeCursor();
        
        if($Bok_checked_all == true)
        {
            $_SESSION['displayvalue_checkbox_all'] = $Bok_checked_all;
        }
        
        $checked_option_displayvalue = join_string($arraychecked_option_displayvalue, '$');
        
        $prepared_query = 'UPDATE script_template
                           SET displayvalue_script_template = :value
                           WHERE name_script_template = :name';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'value' => $checked_option_displayvalue,
                              'name' => $selected_template_displayvalue
                              ));
        $query->closeCursor();
        
        $code_template_displayvalue = give_translation($code_template_displayvalue, 'false');
        
        $_SESSION['msg_displayvalue_done'] = 'Les préférences pour le template "'.$code_template_displayvalue.'" ont été sauvegardées';
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
    
    $_SESSION['displayvalue_cboTemplateDisplayValue'] = $selected_template_displayvalue;
    $_SESSION['displayvalue_checkbox'] = $checked_option_displayvalue;
}
?>
