<?php
try
{
    #OBJECT OFFER
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_offer_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $proposep_id_offerobject[$i] = $data['id_cdreditor'];
        $proposep_code_offerobject = $data['code_cdreditor'];
        $proposep_status_offerobject = $data['status_cdreditor'];
        $proposep_statusobject_offerobject[$i] = $data['statusobject_cdreditor'];
        $proposep_type_offerobject = $data['type_cdreditor'];
        $proposep_nameS_offerobject[$i] = $data['L'.$main_id_language.'S'];
        $proposep_nameP_offerobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT TYPE
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_type_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $proposep_id_typeobject[$i] = $data['id_cdreditor'];
        $proposep_code_typeobject = $data['code_cdreditor'];
        $proposep_status_typeobject = $data['status_cdreditor'];
        $proposep_statusobject_typeobject[$i] = $data['statusobject_cdreditor'];
        $proposep_type_typeobject = $data['type_cdreditor'];
        $proposep_nameS_typeobject[$i] = $data['L'.$main_id_language.'S'];
        $proposep_nameP_typeobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT CONDITION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_condition_object"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $proposep_id_conditionobject[$i] = $data['id_cdreditor'];
        $proposep_code_conditionobject = $data['code_cdreditor'];
        $proposep_status_conditionobject = $data['status_cdreditor'];
        $proposep_statusobject_conditionobject[$i] = $data['statusobject_cdreditor'];
        $proposep_type_conditionobject = $data['type_cdreditor'];
        $proposep_nameS_conditionobject[$i] = $data['L'.$main_id_language.'S'];
        $proposep_nameP_conditionobject[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #OBJECT LOCATION
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_location_situation"
                       ORDER BY L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $proposep_id_locationsituation[$i] = $data['id_cdreditor'];
        $proposep_code_locationsituation = $data['code_cdreditor'];
        $proposep_status_locationsituation = $data['status_cdreditor'];
        $proposep_statusobject_locationsituation[$i] = $data['statusobject_cdreditor'];
        $proposep_type_locationsituation = $data['type_cdreditor'];
        $proposep_nameS_locationsituation[$i] = $data['L'.$main_id_language.'S'];
        $proposep_nameP_locationsituation[$i] = $data['L'.$main_id_language.'P'];
        $i++;
    }
    $query->closeCursor();
    
    #USER INFO
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = "myaccount"
                       AND family_page_translation = "rewritingF"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $rewritingF_myaccount_page = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM user
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $proposep_user_firstname = $data['firstname_user'];
        $proposep_user_lastname = $data['name_user'];
        $proposep_user_companyname = $data['namecompany_user'];
        $proposep_user_address1 = $data['address1_user'];
        $proposep_user_address2 = $data['address2_user'];
        $proposep_user_zip = $data['zip_user'];
        $proposep_user_city = $data['city_user'];
        $proposep_user_country = $data['country_user'];
        $proposep_user_landline = $data['landline_user'];
        $proposep_user_mobile = $data['mobile_user'];
        $proposep_user_fax = $data['fax_user'];
        $proposep_user_email = $data['email_user'];
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
