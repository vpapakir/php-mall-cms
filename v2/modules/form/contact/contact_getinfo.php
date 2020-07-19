<?php
unset($fcontactmain_userinfo_email,$fcontactmain_userinfo_firstname,$fcontactmain_userinfo_lastname, 
        $fcontactmain_userinfo_namecompany,$fcontactmain_userinfo_landline,$fcontactmain_userinfo_mobile,
        $fcontactmain_userinfo_phone,$fcontactmain_userinfo_name);
if(!empty($main_iduser_log))
{
    try
    {
        $prepared_query = 'SELECT email_user, firstname_user, name_user, 
                           namecompany_user, landline_user, mobile_user
                           FROM user
                           WHERE id_user = :iduser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $main_iduser_log);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $fcontactmain_userinfo_email = $data['email_user'];
            $fcontactmain_userinfo_firstname = $data['firstname_user'];
            $fcontactmain_userinfo_lastname = $data['name_user'];
            $fcontactmain_userinfo_namecompany = $data['namecompany_user'];
            $fcontactmain_userinfo_landline = $data['landline_user'];
            $fcontactmain_userinfo_mobile = $data['mobile_user'];
        }
        $query->closeCursor();
        
        if(empty($fcontactmain_userinfo_landline))
        {
            $fcontactmain_userinfo_phone = $fcontactmain_userinfo_mobile;
        }
        else
        {
            $fcontactmain_userinfo_phone = $fcontactmain_userinfo_landline;
        }
        
        if(empty($fcontactmain_userinfo_namecompany))
        {
            $fcontactmain_userinfo_name = $fcontactmain_userinfo_firstname.' '.$fcontactmain_userinfo_lastname;
        }
        else
        {
            $fcontactmain_userinfo_name = $fcontactmain_userinfo_namecompany;
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

try
{
    #subject
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_formcontact_subject"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;    
    while($data = $query->fetch())
    {
        $fcontactmain_id_subject[$i] = $data['id_cdreditor'];
        $fcontactmain_code_subject = $data['code_cdreditor'];
        $fcontactmain_status_subject = $data['status_cdreditor'];
        $fcontactmain_statusobject_subject[$i] = $data['statusobject_cdreditor'];
        $fcontactmain_type_subject = $data['type_cdreditor'];
        $fcontactmain_nameS_subject[$i] = $data['L'.$main_id_language.'S'];
        $fcontactmain_nameP_subject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
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
?>
