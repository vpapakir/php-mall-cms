<?php
$prepared_query = 'SELECT * FROM immo_product
                   WHERE id_page = :id_page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id_page', $selected_product_selector);
$query->execute();

if(($data = $query->fetch()) != false)
{
    #general
    $_SESSION['Kprodimmo_general_cdreditor.offer_object'] = $data['offer_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoReferenceGeneral']= $data['ref_product_immo'];
    $_SESSION['Kprodimmo_general_cdreditor.type_object']= $data['type_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoPriceGeneral']= $data['price_product_immo'];
    $_SESSION['Kprodimmo_general_cboKprodimmoCurrencyGeneral']= $data['currency_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoFeeGeneral']= $data['feeamount_product_immo'];
    $_SESSION['Kprodimmo_general_cdreditor.feetype_object']= $data['feetype_product_immo'];
    $_SESSION['Kprodimmo_general_cdreditor.feeincex_object']= $data['feeincex_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoSurfaceHabGeneral']= $data['surfacehab_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoSurfaceGroundGeneral']= $data['surfaceground_product_immo'];
    $_SESSION['Kprodimmo_general_cdreditor.surfacetype_object']= $data['surfacegroundmeasure_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoSurfaceCellarGeneral']= $data['cellar_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoSurfaceLoftGeneral']= $data['loft_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumFloorGeneral']= $data['levelnb_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumRoomsGeneral']= $data['piecesnb_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumSleepsGeneral']= $data['sleepnb_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumBathGeneral']= $data['bathnb_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumWCGeneal']= $data['wcnb_product_immo'];
    $_SESSION['Kprodimmo_general_txtKprodimmoNumOutHousesGeneral']= $data['outhousesnb_product_immo'];
    $_SESSION['Kprodimmo_general_cdreditor.condition_object']= $data['condition_product_immo'];

    #energy
    $_SESSION['Kprodimmo_energy_txtKprodimmoDPE'] = $data['dpe_product_immo'];
    $_SESSION['Kprodimmo_energy_txtKprodimmoGES'] = $data['ges_product_immo'];
    $_SESSION['Kprodimmo_energy_cdreditor_isolation_energy'] = $data['insulation_product_immo'];
    $_SESSION['Kprodimmo_energy_cdreditor_window_energy'] = $data['window_product_immo'];
    $_SESSION['Kprodimmo_energy_cdreditor_heating_energy'] = $data['heating_product_immo'];
    $_SESSION['Kprodimmo_energy_cdreditor_heatingother_energy'] = $data['heatingother_product_immo'];

    #other
    $_SESSION['Kprodimmo_other_cdreditor_water_other'] = $data['water_product_immo'];
    $_SESSION['Kprodimmo_other_cdreditor_power_other'] = $data['power_product_immo'];
    $_SESSION['Kprodimmo_other_cdreditor_phone_other'] = $data['phone_product_immo'];
    $_SESSION['Kprodimmo_other_cdreditor_tv_other'] = $data['tv_product_immo'];
    $_SESSION['Kprodimmo_other_cdreditor_internet_other'] = $data['internet_product_immo'];
    $_SESSION['Kprodimmo_other_cdreditor_furnished_other'] = $data['furnished_product_immo'];

    #admin
    $_SESSION['Kprodimmo_admin_cdreditor_comdetails_admin'] = $data['comdetails_product_immo'];
    $_SESSION['Kprodimmo_admin_areaKprodimmoNoteAdmin'] = $data['remarks_product_immo'];

    #situation
    $kprodimmo_idcity_select = $data['city_product_immo'];
    
    $_SESSION['Kprodimmo_situation_cdreditor_location_situation'] = $data['location_product_immo'];
    $_SESSION['Kprodimmo_situation_cdreditor_locdetails_situation'] = $data['locdetails_product_immo'];
    $_SESSION['Kprodimmo_situation_txtKprodimmoSituationLat'] = $data['latitude_product_immo'];
    $_SESSION['Kprodimmo_situation_txtKprodimmoSituationLon'] = $data['longitude_product_immo'];
    $_SESSION['Kprodimmo_situation_cdreditor_facilities_situation'] = $data['facilities_product_immo'];
    $_SESSION['Kprodimmo_situation_txtcdreditor_facilities_situation'] = $data['facilitiesdistance_product_immo'];
    $_SESSION['Kprodimmo_situation_txtKprodimmoSituationFacilitiesGroup'] = $data['facilitiesgroup_product_immo'];

    #interior
    $_SESSION['Kprodimmo_interior_cdreditor_piecesin_interior'] = $data['interior_product_immo'];

    #exterior
    $_SESSION['Kprodimmo_exterior_cdreditor_piecesout_exterior'] = $data['exterior_product_immo'];
    $_SESSION['Kprodimmo_exterior_cdreditor_others_exterior'] = $data['exteriorother_product_immo'];
}
$query->closeCursor();


$prepared_query = 'SELECT L'.$main_id_language.'
                   FROM cdrgeo
                   WHERE id_cdrgeo = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $kprodimmo_idcity_select);
$query->execute();

if(($data = $query->fetch()) != false)
{
    $_SESSION['Kprodimmo_situation_txtKprodimmoCity'] = $data[0];
    $_SESSION['Kprodimmo_situation_CityInfo'] = $data[0];
}
$query->execute();


?>
