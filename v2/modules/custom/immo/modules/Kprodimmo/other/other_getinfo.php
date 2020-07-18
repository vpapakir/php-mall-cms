<?php
try
{
    #OTHER WATER
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_water_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_waterother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_waterother = $data['code_cdreditor'];
        $kprodimmo_status_waterother = $data['status_cdreditor'];
        $kprodimmo_statusobject_waterother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_waterother = $data['type_cdreditor'];
        $kprodimmo_nameS_waterother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_waterother[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OTHER POWER
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_power_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_powerother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_powerother = $data['code_cdreditor'];
        $kprodimmo_status_powerother = $data['status_cdreditor'];
        $kprodimmo_statusobject_powerother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_powerother = $data['type_cdreditor'];
        $kprodimmo_nameS_powerother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_powerother[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OTHER PHONE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_phone_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_phoneother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_phoneother = $data['code_cdreditor'];
        $kprodimmo_status_phoneother = $data['status_cdreditor'];
        $kprodimmo_statusobject_phoneother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_phoneother = $data['type_cdreditor'];
        $kprodimmo_nameS_phoneother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_phoneother[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OTHER TV
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_tv_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_tvother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_tvother = $data['code_cdreditor'];
        $kprodimmo_status_tvother = $data['status_cdreditor'];
        $kprodimmo_statusobject_tvother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_tvother = $data['type_cdreditor'];
        $kprodimmo_nameS_tvother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_tvother[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OTHER INTERNET
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_internet_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_internetother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_internetother = $data['code_cdreditor'];
        $kprodimmo_status_internetother = $data['status_cdreditor'];
        $kprodimmo_statusobject_internetother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_internetother = $data['type_cdreditor'];
        $kprodimmo_nameS_internetother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_internetother[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OTHER FURNISHED
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_furnished_other"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_furnishedother[$i] = $data['id_cdreditor'];
        $kprodimmo_code_furnishedother = $data['code_cdreditor'];
        $kprodimmo_status_furnishedother = $data['status_cdreditor'];
        $kprodimmo_statusobject_furnishedother[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_furnishedother = $data['type_cdreditor'];
        $kprodimmo_nameS_furnishedother[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_furnishedother[$i] = $data['L'.$main_id_language.'P'];
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
