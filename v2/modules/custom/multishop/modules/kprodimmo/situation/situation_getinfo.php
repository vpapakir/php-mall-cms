<?php
try
{
    #SITUATION COUNTRY
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE code_cdrgeo = "cdrgeo_country_situation"
                       ORDER BY position_cdrgeo, L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_countrysituation[$i] = $data['id_cdrgeo'];
        $kprodimmo_code_countrysituation = $data['code_cdrgeo'];
        $kprodimmo_status_countrysituation = $data['status_cdrgeo'];
        $kprodimmo_statusobject_countrysituation[$i] = $data['statusobject_cdrgeo'];
        $kprodimmo_type_countrysituation = $data['type_cdrgeo'];
        $kprodimmo_name_countrysituation[$i] = $data['L'.$main_id_language];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION REGION
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE code_cdrgeo = "cdrgeo_region_situation"
                       ORDER BY position_cdrgeo, L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_regionsituation[$i] = $data['id_cdrgeo'];
        $kprodimmo_code_regionsituation = $data['code_cdrgeo'];
        $kprodimmo_status_regionsituation = $data['status_cdrgeo'];
        $kprodimmo_statusobject_regionsituation[$i] = $data['statusobject_cdrgeo'];
        $kprodimmo_type_regionsituation = $data['type_cdrgeo'];
        $kprodimmo_name_regionsituation[$i] = $data['L'.$main_id_language];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION DEPARTMENT
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE code_cdrgeo = "cdrgeo_department_situation"
                       ORDER BY position_cdrgeo, L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_departmentsituation[$i] = $data['id_cdrgeo'];
        $kprodimmo_code_departmentsituation = $data['code_cdrgeo'];
        $kprodimmo_status_departmentsituation = $data['status_cdrgeo'];
        $kprodimmo_statusobject_departmentsituation[$i] = $data['statusobject_cdrgeo'];
        $kprodimmo_type_departmentsituation = $data['type_cdrgeo'];
        $kprodimmo_name_departmentsituation[$i] = $data['L'.$main_id_language];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION DISTRICT
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE code_cdrgeo = "cdrgeo_district_situation"
                       ORDER BY position_cdrgeo, L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_districtsituation[$i] = $data['id_cdrgeo'];
        $kprodimmo_code_districtsituation = $data['code_cdrgeo'];
        $kprodimmo_status_districtsituation = $data['status_cdrgeo'];
        $kprodimmo_statusobject_districtsituation[$i] = $data['statusobject_cdrgeo'];
        $kprodimmo_type_districtsituation = $data['type_cdrgeo'];
        $kprodimmo_name_districtsituation[$i] = $data['L'.$main_id_language];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION CITY
    $prepared_query = 'SELECT * FROM cdrgeo
                       WHERE code_cdrgeo = "cdrgeo_city_situation"
                       ORDER BY position_cdrgeo, L'.$main_id_language;
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_citysituation[$i] = $data['id_cdrgeo'];
        $kprodimmo_code_citysituation = $data['code_cdrgeo'];
        $kprodimmo_status_citysituation = $data['status_cdrgeo'];
        $kprodimmo_statusobject_citysituation[$i] = $data['statusobject_cdrgeo'];
        $kprodimmo_type_citysituation = $data['type_cdrgeo'];
        $kprodimmo_zip_citysituation[$i] = $data['zip_cdrgeo'];
        $kprodimmo_name_citysituation[$i] = $data['L'.$main_id_language];
        $i++;
    }
    $query->closeCursor();       
    
    #SITUATION LOCATION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_location_situation"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_locationsituation[$i] = $data['id_cdreditor'];
        $kprodimmo_code_locationsituation = $data['code_cdreditor'];
        $kprodimmo_status_locationsituation = $data['status_cdreditor'];
        $kprodimmo_statusobject_locationsituation[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_locationsituation = $data['type_cdreditor'];
        $kprodimmo_nameS_locationsituation[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_locationsituation[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION LOCATION DETAILS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_locdetails_situation"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_locdetailssituation[$i] = $data['id_cdreditor'];
        $kprodimmo_code_locdetailssituation = $data['code_cdreditor'];
        $kprodimmo_status_locdetailssituation = $data['status_cdreditor'];
        $kprodimmo_statusobject_locdetailssituation[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_locdetailssituation = $data['type_cdreditor'];
        $kprodimmo_nameS_locdetailssituation[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_locdetailssituation[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #SITUATION FACILITIES
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_facilities_situation"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_facilitiessituation[$i] = $data['id_cdreditor'];
        $kprodimmo_code_facilitiessituation = $data['code_cdreditor'];
        $kprodimmo_status_facilitiessituation = $data['status_cdreditor'];
        $kprodimmo_statusobject_facilitiessituation[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_facilitiessituation = $data['type_cdreditor'];
        $kprodimmo_nameS_facilitiessituation[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_facilitiessituation[$i] = $data['L'.$main_id_language.'P'];
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
