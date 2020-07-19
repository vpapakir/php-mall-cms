<?php
try
{
    #ENERGY HEATING
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_heating_energy"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_heatingenergy[$i] = $data['id_cdreditor'];
        $kprodimmo_code_heatingenergy = $data['code_cdreditor'];
        $kprodimmo_status_heatingenergy = $data['status_cdreditor'];
        $kprodimmo_statusobject_heatingenergy[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_heatingenergy = $data['type_cdreditor'];
        $kprodimmo_nameS_heatingenergy[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_heatingenergy[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #ENERGY ISOLATION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_isolation_energy"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_isolationenergy[$i] = $data['id_cdreditor'];
        $kprodimmo_code_isolationenergy = $data['code_cdreditor'];
        $kprodimmo_status_isolationenergy = $data['status_cdreditor'];
        $kprodimmo_statusobject_isolationenergy[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_isolationenergy = $data['type_cdreditor'];
        $kprodimmo_nameS_isolationenergy[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_isolationenergy[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #ENERGY WINDOW
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_window_energy"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_windowenergy[$i] = $data['id_cdreditor'];
        $kprodimmo_code_windowenergy = $data['code_cdreditor'];
        $kprodimmo_status_windowenergy = $data['status_cdreditor'];
        $kprodimmo_statusobject_windowenergy[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_windowenergy = $data['type_cdreditor'];
        $kprodimmo_nameS_windowenergy[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_windowenergy[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #ENERGY HEATING OTHER
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_heatingother_energy"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_heatingotherenergy[$i] = $data['id_cdreditor'];
        $kprodimmo_code_heatingotherenergy = $data['code_cdreditor'];
        $kprodimmo_status_heatingotherenergy = $data['status_cdreditor'];
        $kprodimmo_statusobject_heatingotherenergy[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_heatingotherenergy = $data['type_cdreditor'];
        $kprodimmo_nameS_heatingotherenergy[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_heatingotherenergy[$i] = $data['L'.$main_id_language.'P'];
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
