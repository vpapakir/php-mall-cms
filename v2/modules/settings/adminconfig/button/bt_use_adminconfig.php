<?php
if(isset($_POST['bt_use_adminconfig']))
{
    unset($_SESSION['msg_adminconfig_creationdate'],
            $_SESSION['msg_adminconfig_txtAddNameConfigAdmin'],
            $_SESSION['msg_adminconfig_done']);
    
    #msg
    $msg_adminconfig_done = give_translation('messages.msg_done_adminconfig_used', 'false', $config_showtranslationcode);

    #callinfo  
    $adminconfig_selected_template = htmlspecialchars($_POST['cboSelectSiteAdminconfig'], ENT_QUOTES);
    
    try
    {
            #adminconfig
            $prepared_query = 'UPDATE config_admin
                               SET status_configadmin = 9';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
        
            $prepared_query = 'UPDATE config_admin
                               SET status_configadmin = 1
                               WHERE name_configadmin = "'.$adminconfig_selected_template.'"';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            #adminconfig
            $prepared_query = 'UPDATE config_admin
                               SET status_configadmin = 9
                               WHERE name_configadmin = "'.$adminconfig_selected_template.'"';
            
            $prepared_query = 'UPDATE config_module
                               SET immo_module = :immo';
            if($adminconfig_selected_template == 'select')
            {
                $prepared_query .= ' WHERE status_configmodule = 1';
            }
            else
            {
                $prepared_query .= ' WHERE name_configmodule = "'.$adminconfig_selected_template.'"';
            }
            
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'immo' => $adminconfig_sa_module_immo
                                ));
            $query->closeCursor();
            
            #mainconfig
            $prepared_query = 'UPDATE config_main
                               SET status_config_main = 9';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
        
            $prepared_query = 'UPDATE config_main
                               SET status_config_main = 1
                               WHERE name_config_main = "'.$adminconfig_selected_template.'"';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            #structure
            $prepared_query = 'UPDATE config_structure
                               SET status_config_structure = 9';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
        
            $prepared_query = 'UPDATE config_structure
                               SET status_config_structure = 1
                               WHERE name_config_structure = "'.$adminconfig_selected_template.'"';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            #image
            $prepared_query = 'UPDATE config_image
                               SET status_config_image = 9';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
        
            $prepared_query = 'UPDATE config_image
                               SET status_config_image = 1
                               WHERE name_config_image = "'.$adminconfig_selected_template.'"';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            #modules 
            $prepared_query = 'UPDATE config_module
                               SET status_configmodule = 9';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
        
            $prepared_query = 'UPDATE config_module
                               SET status_configmodule = 1
                               WHERE name_configmodule = "'.$adminconfig_selected_template.'"';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $query->closeCursor();
            
            $prepared_query = 'SELECT * FROM config_module
                               WHERE status_configmodule = 1';        
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $adminconfig_sa_module_immo = $data['immo_module'];
            }
            $query->closeCursor();
            
            if(!empty($adminconfig_sa_module_immo))
            {
                $prepared_query = 'UPDATE script_template
                                   SET status_script_template = :status
                                   WHERE family_script_template = "immo"';               

                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'status' => $adminconfig_sa_module_immo,
                                    ));
                $query->closeCursor();
                
                $prepared_query = 'UPDATE page
                                   SET status_page = :status
                                   WHERE family_page = "immo"';               

                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute(array(
                                      'status' => $adminconfig_sa_module_immo,
                                    ));
                $query->closeCursor();
            }
            
            $msg_adminconfig_done = str_replace('[#name_adminconfig]', $adminconfig_selected_template, $msg_adminconfig_done);
            $_SESSION['msg_adminconfig_done'] = $msg_adminconfig_done;
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
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
