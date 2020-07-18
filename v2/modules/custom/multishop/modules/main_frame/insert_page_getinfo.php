<?php
$prepared_query = 'SELECT displayvalue_script_template
                   FROM script_template
                   WHERE name_script_template = :template';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('template', $template_page);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $customgetinfo_displayvalue = $data[0];
}
$query->closeCursor();

$customgetinfo_displayvalue = split_string($customgetinfo_displayvalue, '$');

$prepared_query = 'SELECT * FROM immo_product
                   WHERE id_page = :page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('page', $id_page);
$query->execute();
if(($data = $query->fetch()) != false)
{
    #general
    $customgetinfo_offer = $data['offer_product_immo'];
    $customgetinfo_reference = $data['ref_product_immo'];
    $customgetinfo_type = $data['type_product_immo'];
    $customgetinfo_price = $data['price_product_immo'];
    $customgetinfo_currency = $data['currency_product_immo'];
    $customgetinfo_fee = $data['feeamount_product_immo'];
    $customgetinfo_feetype = $data['feetype_product_immo'];
    $customgetinfo_feeincex = $data['feeincex_product_immo'];
    $customgetinfo_surfacehab = $data['surfacehab_product_immo'];
    $customgetinfo_surfaceground = $data['surfaceground_product_immo'];
    $customgetinfo_surfacegroundmeasure = $data['surfacegroundmeasure_product_immo'];
    $customgetinfo_surfacecellar = $data['cellar_product_immo'];
    $customgetinfo_surfaceloft = $data['loft_product_immo'];
    $customgetinfo_numfloor = $data['levelnb_product_immo'];
    $customgetinfo_numrooms = $data['piecesnb_product_immo'];
    $customgetinfo_numsleeps = $data['sleepnb_product_immo'];
    $customgetinfo_numbath = $data['bathnb_product_immo'];
    $customgetinfo_numwc = $data['wcnb_product_immo'];
    $customgetinfo_numouthouses = $data['outhousesnb_product_immo'];
    $customgetinfo_condition = $data['condition_product_immo'];

    #energy
    $customgetinfo_dpe_energy = $data['dpe_product_immo'];
    $customgetinfo_ges_energy = $data['ges_product_immo'];
    $customgetinfo_heating_energy = $data['heating_product_immo'];
    $customgetinfo_heatingother_energy = $data['heatingother_product_immo'];
    $customgetinfo_isolation_energy = $data['insulation_product_immo'];
    $customgetinfo_window_energy = $data['window_product_immo'];

    #other
    $customgetinfo_water_other = $data['water_product_immo'];
    $customgetinfo_power_other = $data['power_product_immo'];
    $customgetinfo_phone_other = $data['phone_product_immo'];
    $customgetinfo_tv_other = $data['tv_product_immo'];
    $customgetinfo_internet_other = $data['internet_product_immo'];
    $customgetinfo_furnished_other = $data['furnished_product_immo'];

    #admin
    $customgetinfo_comdetails_admin = $data['comdetails_product_immo'];
    $customgetinfo_note_admin = $data['remarks_product_immo'];

    #situation
    $customgetinfo_city_situation = $data['city_product_immo'];
    $customgetinfo_zip_situation = $data['zip_product_immo'];
    $customgetinfo_district_situation = $data['district_product_immo'];
    $customgetinfo_department_situation = $data['department_product_immo'];
    $customgetinfo_region_situation = $data['region_product_immo'];
    $customgetinfo_country_situation = $data['country_product_immo'];
    $customgetinfo_longitude_situation = $data['longitude_product_immo'];
    $customgetinfo_latitude_situation = $data['latitude_product_immo'];
    $customgetinfo_location_situation = $data['location_product_immo'];
    $customgetinfo_locdetails_situation = $data['locdetails_product_immo'];
    $customgetinfo_facilitiesorder_situation = $data['facilitiesorder_product_immo'];
    $customgetinfo_facilities_situation = $data['facilities_product_immo'];
    $customgetinfo_facilitiesdistance_situation = $data['facilitiesdistance_product_immo'];

    #interior
    $customgetinfo_piecesin_interior = $data['interior_product_immo'];

    #exterior
    $customgetinfo_piecesout_exterior = $data['exterior_product_immo'];
    $customgetinfo_other_exterior = $data['exteriorother_product_immo'];
}
$query->closeCursor();

#next product link
$id_nextproduct = $id_page + 1;

$prepared_query = 'SELECT MAX(id_page) FROM page';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $customgetinfo_maxidpage = $data[0];
}
$customgetinfo_nextpage_bok_found = false;
while($customgetinfo_nextpage_bok_found === false)
{
    if($id_nextproduct > $customgetinfo_maxidpage)
    {
        $id_nextproduct = 1;
    }
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE family_page = "product"
                       AND family_page_translation = "rewritingF"
                       AND page.id_page = :page
                       AND status_page = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('page', $id_nextproduct);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_nextpage_rewritingF = $data[0];
        $customgetinfo_nextpage_bok_found = true;
    }
    else
    {
        $id_nextproduct++;
    } 
}
$query->closeCursor();
#previous product link
$id_previousproduct = $id_page - 1;
$customgetinfo_previouspage_bok_found = false;
while($customgetinfo_previouspage_bok_found === false)
{
    if($id_previousproduct <= 0)
    {
        $id_previousproduct = $customgetinfo_maxidpage;
    }
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE family_page = "product"
                       AND family_page_translation = "rewritingF"
                       AND page.id_page = :page
                       AND status_page = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('page', $id_previousproduct);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $customgetinfo_previouspage_rewritingF = $data[0];
        $customgetinfo_previouspage_bok_found = true;
    }
    else
    {
        $id_previousproduct--;
    } 
}
$query->closeCursor();
?>
