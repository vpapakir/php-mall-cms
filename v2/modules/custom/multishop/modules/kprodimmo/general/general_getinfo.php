<?php
try
{
    #OBJECT OFFER
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_offer_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_offerobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_offerobject = $data['code_cdreditor'];
        $kprodimmo_status_offerobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_offerobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_offerobject = $data['type_cdreditor'];
        $kprodimmo_nameS_offerobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_offerobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT TYPE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_type_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_typeobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_typeobject = $data['code_cdreditor'];
        $kprodimmo_status_typeobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_typeobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_typeobject = $data['type_cdreditor'];
        $kprodimmo_nameS_typeobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_typeobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
//    #OBJECT CURRENCY
//    $prepared_query = 'SELECT * FROM cdreditor
//                       WHERE code_cdreditor = "cdreditor_currency_object"
//                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
//    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
//    $query = $connectData->prepare($prepared_query);
//    //$query->bindParam('code', 'cdreditor.type_object');
//    $query->execute();
//    $i = 0;
//    
//    while($data = $query->fetch())
//    {
//        $kprodimmo_id_currencyobject[$i] = $data['id_cdreditor'];
//        $kprodimmo_code_currencyobject = $data['code_cdreditor'];
//        $kprodimmo_status_currencyobject = $data['status_cdreditor'];
//        $kprodimmo_statusobject_currencyobject[$i] = $data['statusobject_cdreditor'];
//        $kprodimmo_type_currencyobject = $data['type_cdreditor'];
//        $kprodimmo_nameS_currencyobject[$i] = $data['L'.$main_id_language.'S'];
//        $kprodimmo_nameP_currencyobject[$i] = $data['L'.$main_id_language.'P'];
//        $i++;
//    }
//    $query->closeCursor();
    
    #OBJECT FEE TYPE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_feetype_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_feetypeobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_feetypeobject = $data['code_cdreditor'];
        $kprodimmo_status_feetypeobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_feetypeobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_feetypeobject = $data['type_cdreditor'];
        $kprodimmo_nameS_feetypeobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_feetypeobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT FEE INCLUDE || EXCLUDE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_feeincex_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_feeincexobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_feeincexobject = $data['code_cdreditor'];
        $kprodimmo_status_feeincexobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_feeincexobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_feeincexobject = $data['type_cdreditor'];
        $kprodimmo_nameS_feeincexobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_feeincexobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT TYPE SURFACE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_surfacetype_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_surfacetypeobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_surfacetypeobject = $data['code_cdreditor'];
        $kprodimmo_status_surfacetypeobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_surfacetypeobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_surfacetypeobject = $data['type_cdreditor'];
        $kprodimmo_nameS_surfacetypeobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_surfacetypeobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT CONDITION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_condition_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_conditionobject[$i] = $data['id_cdreditor'];
        $kprodimmo_code_conditionobject = $data['code_cdreditor'];
        $kprodimmo_status_conditionobject = $data['status_cdreditor'];
        $kprodimmo_statusobject_conditionobject[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_conditionobject = $data['type_cdreditor'];
        $kprodimmo_nameS_conditionobject[$i] = $data['L'.$main_id_language.'S'];
        $kprodimmo_nameP_conditionobject[$i] = $data['L'.$main_id_language.'P'];
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
