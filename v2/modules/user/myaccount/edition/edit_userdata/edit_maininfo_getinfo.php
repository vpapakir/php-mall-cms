<?php
try
{
    #USER INFO
    $prepared_query = 'SELECT * FROM user
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $_SESSION['myaccount_useredition_radUserEditionType'] = $data['type_user'];
        $_SESSION['myaccount_useredition_cdreditor_title_UserEdition'] = $data['title_user'];
        $_SESSION['myaccount_useredition_txtUserEditionFirstname'] = $data['firstname_user'];
        $_SESSION['myaccount_useredition_txtUserEditionLastname'] = $data['name_user'];
        $tempmyaccount_useraddress_birthday = $data['birthday_user'];
        $_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'] = $data['typecompany_user'];
        $_SESSION['myaccount_useredition_txtUserEditionNamecompany'] = $data['namecompany_user'];
        $_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'] = $data['activitycompany_user'];
        $_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'] = $data['functioncompany_user'];
        $_SESSION['myaccount_useredition_txtUserEditionSiretcompany'] = $data['siretcompany_user'];
        $_SESSION['myaccount_useredition_txtUserEditionVatintracompany'] = $data['vatcompany_user'];
        $_SESSION['myaccount_useredition_txtUserEditionAddress1'] = $data['address1_user'];
        $_SESSION['myaccount_useredition_txtUserEditionAddress2'] = $data['address2_user'];
        $_SESSION['myaccount_useredition_txtUserEditionZip'] = $data['zip_user'];
        $_SESSION['myaccount_useredition_txtUserEditionCity'] = $data['city_user'];
        $_SESSION['myaccount_useredition_cboUserEditionLanguage'] = $data['id_language'];
        $_SESSION['myaccount_useredition_cdrgeo_country_situation'] = $data['country_user'];
        $_SESSION['myaccount_useredition_txtUserEditionLandline'] = $data['landline_user'];
        $_SESSION['myaccount_useredition_txtUserEditionMobile'] = $data['mobile_user'];
        $_SESSION['myaccount_useredition_txtUserEditionFax'] = $data['fax_user'];
        $_SESSION['myaccount_useredition_txtUserEditionWebsite'] = $data['website_user'];
    }
    $query->closeCursor();
    
    $tempmyaccount_useraddress_birthday = split_string($tempmyaccount_useraddress_birthday, '-');
    
    $_SESSION['myaccount_useredition_cboUserEditionBirthDay'] = $tempmyaccount_useraddress_birthday[2];
    $_SESSION['myaccount_useredition_cboUserEditionBirthMonth'] = $tempmyaccount_useraddress_birthday[1];
    $_SESSION['myaccount_useredition_cboUserEditionBirthYear'] = $tempmyaccount_useraddress_birthday[0];
    unset($tempmyaccount_useraddress_birthday);
    
    #USER TITLE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_title_userdata"
                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $myaccountedit_id_title[$i] = $data['id_cdreditor'];
        $myaccountedit_code_title = $data['code_cdreditor'];
        $myaccountedit_status_title = $data['status_cdreditor'];
        $myaccountedit_statusobject_title[$i] = $data['statusobject_cdreditor'];
        $myaccountedit_type_title = $data['type_cdreditor'];
        $myaccountedit_nameS_title[$i] = $data['L'.$main_id_language.'S'];
        $myaccountedit_nameP_title[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #USER COMPANY TYPE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_typecompany_userdata"
                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $myaccountedit_id_typecompany[$i] = $data['id_cdreditor'];
        $myaccountedit_code_typecompany = $data['code_cdreditor'];
        $myaccountedit_status_typecompany = $data['status_cdreditor'];
        $myaccountedit_statusobject_typecompany[$i] = $data['statusobject_cdreditor'];
        $myaccountedit_type_typecompany = $data['type_cdreditor'];
        $myaccountedit_nameS_typecompany[$i] = $data['L'.$main_id_language.'S'];
        $myaccountedit_nameP_typecompany[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #USER COMPANY FUNCTION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_functioncompany_userdata"
                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $myaccountedit_id_functioncompany[$i] = $data['id_cdreditor'];
        $myaccountedit_code_functioncompany = $data['code_cdreditor'];
        $myaccountedit_status_functioncompany = $data['status_cdreditor'];
        $myaccountedit_statusobject_functioncompany[$i] = $data['statusobject_cdreditor'];
        $myaccountedit_type_functioncompany = $data['type_cdreditor'];
        $myaccountedit_nameS_functioncompany[$i] = $data['L'.$main_id_language.'S'];
        $myaccountedit_nameP_functioncompany[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #USER COMPANY ACTIVITY
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_activitycompany_userdata"
                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $myaccountedit_id_activitycompany[$i] = $data['id_cdreditor'];
        $myaccountedit_code_activitycompany = $data['code_cdreditor'];
        $myaccountedit_status_activitycompany = $data['status_cdreditor'];
        $myaccountedit_statusobject_activitycompany[$i] = $data['statusobject_cdreditor'];
        $myaccountedit_type_activitycompany = $data['type_cdreditor'];
        $myaccountedit_nameS_activitycompany[$i] = $data['L'.$main_id_language.'S'];
        $myaccountedit_nameP_activitycompany[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #USER COUNTRY
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE parentcountry_cdrgeo IS NULL
                       AND parentregion_cdrgeo IS NULL
                       AND parentdepartment_cdrgeo IS NULL
                       AND parentdistrict_cdrgeo IS NULL
                       ORDER BY L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $myaccountedit_id_country[$i] = $data['id_cdrgeo'];
        $myaccountedit_code_country = $data['code_cdrgeo'];
        $myaccountedit_status_country = $data['status_cdrgeo'];
        $myaccountedit_statusobject_country[$i] = $data['statusobject_cdrgeo'];
        $myaccountedit_type_country = $data['type_cdrgeo'];
        $myaccountedit_name_country[$i] = $data['L'.$main_id_language];
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
