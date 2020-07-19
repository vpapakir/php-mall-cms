<?php
try
{
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
        $userdata_id_title[$i] = $data['id_cdreditor'];
        $userdata_code_title = $data['code_cdreditor'];
        $userdata_status_title = $data['status_cdreditor'];
        $userdata_statusobject_title[$i] = $data['statusobject_cdreditor'];
        $userdata_type_title = $data['type_cdreditor'];
        $userdata_nameS_title[$i] = $data['L'.$main_id_language.'S'];
        $userdata_nameP_title[$i] = $data['L'.$main_id_language.'P'];
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
        $userdata_id_typecompany[$i] = $data['id_cdreditor'];
        $userdata_code_typecompany = $data['code_cdreditor'];
        $userdata_status_typecompany = $data['status_cdreditor'];
        $userdata_statusobject_typecompany[$i] = $data['statusobject_cdreditor'];
        $userdata_type_typecompany = $data['type_cdreditor'];
        $userdata_nameS_typecompany[$i] = $data['L'.$main_id_language.'S'];
        $userdata_nameP_typecompany[$i] = $data['L'.$main_id_language.'P'];
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
        $userdata_id_functioncompany[$i] = $data['id_cdreditor'];
        $userdata_code_functioncompany = $data['code_cdreditor'];
        $userdata_status_functioncompany = $data['status_cdreditor'];
        $userdata_statusobject_functioncompany[$i] = $data['statusobject_cdreditor'];
        $userdata_type_functioncompany = $data['type_cdreditor'];
        $userdata_nameS_functioncompany[$i] = $data['L'.$main_id_language.'S'];
        $userdata_nameP_functioncompany[$i] = $data['L'.$main_id_language.'P'];
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
        $userdata_id_activitycompany[$i] = $data['id_cdreditor'];
        $userdata_code_activitycompany = $data['code_cdreditor'];
        $userdata_status_activitycompany = $data['status_cdreditor'];
        $userdata_statusobject_activitycompany[$i] = $data['statusobject_cdreditor'];
        $userdata_type_activitycompany = $data['type_cdreditor'];
        $userdata_nameS_activitycompany[$i] = $data['L'.$main_id_language.'S'];
        $userdata_nameP_activitycompany[$i] = $data['L'.$main_id_language.'P'];
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
        $userdata_id_country[$i] = $data['id_cdrgeo'];
        $userdata_code_country = $data['code_cdrgeo'];
        $userdata_status_country = $data['status_cdrgeo'];
        $userdata_statusobject_country[$i] = $data['statusobject_cdrgeo'];
        $userdata_type_country = $data['type_cdrgeo'];
        $userdata_name_country[$i] = $data['L'.$main_id_language];
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
