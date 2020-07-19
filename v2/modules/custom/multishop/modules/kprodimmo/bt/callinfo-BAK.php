<?php

#general
$kprodimmo_offer_general = htmlspecialchars($_POST['cdreditor_offer_object'], ENT_QUOTES);
$kprodimmo_reference_general = trim(htmlspecialchars($_POST['txtKprodimmoReferenceGeneral'], ENT_QUOTES));
$kprodimmo_type_general = htmlspecialchars($_POST['cdreditor_type_object'], ENT_QUOTES);
$kprodimmo_price_general = trim(htmlspecialchars($_POST['txtKprodimmoPriceGeneral'], ENT_QUOTES));
$kprodimmo_currency_general = htmlspecialchars($_POST['cboKprodimmoCurrencyGeneral'], ENT_QUOTES);
$kprodimmo_fee_general = trim(htmlspecialchars($_POST['txtKprodimmoFeeGeneral'], ENT_QUOTES));
$kprodimmo_feetype_general = htmlspecialchars($_POST['cdreditor_feetype_object'], ENT_QUOTES);
$kprodimmo_feeincex_general = htmlspecialchars($_POST['cdreditor_feeincex_object'], ENT_QUOTES);
$kprodimmo_surfacehab_general = trim(htmlspecialchars($_POST['txtKprodimmoSurfaceHabGeneral'], ENT_QUOTES));
$kprodimmo_surfaceground_general = trim(htmlspecialchars($_POST['txtKprodimmoSurfaceGroundGeneral'], ENT_QUOTES));
$kprodimmo_surfacetype_general = htmlspecialchars($_POST['cdreditor_surfacetype_object'], ENT_QUOTES);
$kprodimmo_surfacecellar_general = trim(htmlspecialchars($_POST['txtKprodimmoSurfaceCellarGeneral'], ENT_QUOTES));
$kprodimmo_surfaceloft_general = trim(htmlspecialchars($_POST['txtKprodimmoSurfaceLoftGeneral'], ENT_QUOTES));
$kprodimmo_numfloor_general = trim(htmlspecialchars($_POST['txtKprodimmoNumFloorGeneral'], ENT_QUOTES));
$kprodimmo_numrooms_general = trim(htmlspecialchars($_POST['txtKprodimmoNumRoomsGeneral'], ENT_QUOTES));
$kprodimmo_numsleeps_general = trim(htmlspecialchars($_POST['txtKprodimmoNumSleepsGeneral'], ENT_QUOTES));
$kprodimmo_numbath_general =trim( htmlspecialchars($_POST['txtKprodimmoNumBathGeneral'], ENT_QUOTES));
$kprodimmo_numwc_general = trim(htmlspecialchars($_POST['txtKprodimmoNumWCGeneal'], ENT_QUOTES));
$kprodimmo_numouthouses_general = trim(htmlspecialchars($_POST['txtKprodimmoNumOutHousesGeneral'], ENT_QUOTES));
$kprodimmo_condition_general = htmlspecialchars($_POST['cdreditor_condition_object'], ENT_QUOTES);

#energy
$kprodimmo_dpe_energy = trim(htmlspecialchars($_POST['txtKprodimmoDPE'], ENT_QUOTES));
$kprodimmo_ges_energy = trim(htmlspecialchars($_POST['txtKprodimmoGES'], ENT_QUOTES));

if(!empty($kprodimmo_dpe_energy) && !is_numeric($kprodimmo_dpe_energy))
{
    $kprodimmo_dpe_energy = 0;
}

if(!empty($kprodimmo_ges_energy) && !is_numeric($kprodimmo_ges_energy))
{
    $kprodimmo_ges_energy = 0;
}

$kprodimmo_heating_energy = null;
$kprodimmo_heatingother_energy = null;

for($i = 0, $count = count($kprodimmo_id_heatingenergy); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_heating_energy'.$kprodimmo_id_heatingenergy[$i]]))
    {
        if($kprodimmo_heating_energy == null)
        {
            $kprodimmo_heating_energy = htmlspecialchars($_POST['cdreditor_heating_energy'.$kprodimmo_id_heatingenergy[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_heating_energy .= '$'.htmlspecialchars($_POST['cdreditor_heating_energy'.$kprodimmo_id_heatingenergy[$i]], ENT_QUOTES);
        }       
    }
}

for($i = 0, $count = count($kprodimmo_id_heatingotherenergy); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_heatingother_energy'.$kprodimmo_id_heatingotherenergy[$i]]))
    {
        if($kprodimmo_heatingother_energy == null)
        {
            $kprodimmo_heatingother_energy = htmlspecialchars($_POST['cdreditor_heatingother_energy'.$kprodimmo_id_heatingotherenergy[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_heatingother_energy .= '$'.htmlspecialchars($_POST['cdreditor_heatingother_energy'.$kprodimmo_id_heatingotherenergy[$i]], ENT_QUOTES);
        }       
    }
}

$kprodimmo_isolation_energy = htmlspecialchars($_POST['cdreditor_isolation_energy'], ENT_QUOTES);
$kprodimmo_window_energy = htmlspecialchars($_POST['cdreditor_window_energy'], ENT_QUOTES);

#other
$kprodimmo_water_other = null;
$kprodimmo_power_other = null;

for($i = 0, $count = count($kprodimmo_id_waterother); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_water_other'.$kprodimmo_id_waterother[$i]]))
    {
        if($kprodimmo_water_other == null)
        {
            $kprodimmo_water_other = htmlspecialchars($_POST['cdreditor_water_other'.$kprodimmo_id_waterother[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_water_other .= '$'.htmlspecialchars($_POST['cdreditor_water_other'.$kprodimmo_id_waterother[$i]], ENT_QUOTES);
        }       
    }
}

for($i = 0, $count = count($kprodimmo_id_powerother); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_power_other'.$kprodimmo_id_powerother[$i]]))
    {
        if($kprodimmo_power_other == null)
        {
            $kprodimmo_power_other = htmlspecialchars($_POST['cdreditor_power_other'.$kprodimmo_id_powerother[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_power_other .= '$'.htmlspecialchars($_POST['cdreditor_power_other'.$kprodimmo_id_powerother[$i]], ENT_QUOTES);
        }       
    }
}

$kprodimmo_tv_other = null;

for($i = 0, $count = count($kprodimmo_id_tvother); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_tv_other'.$kprodimmo_id_tvother[$i]]))
    {
        if($kprodimmo_tv_other == null)
        {
            $kprodimmo_tv_other = htmlspecialchars($_POST['cdreditor_tv_other'.$kprodimmo_id_tvother[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_tv_other .= '$'.htmlspecialchars($_POST['cdreditor_tv_other'.$kprodimmo_id_tvother[$i]], ENT_QUOTES);
        }       
    }
}


$kprodimmo_phone_other = htmlspecialchars($_POST['cdreditor_phone_other'], ENT_QUOTES);
//$kprodimmo_tv_other = htmlspecialchars($_POST['cdreditor_tv_other'], ENT_QUOTES);
$kprodimmo_internet_other = htmlspecialchars($_POST['cdreditor_internet_other'], ENT_QUOTES);
$kprodimmo_furnished_other = htmlspecialchars($_POST['cdreditor_furnished_other'], ENT_QUOTES);

#admin
$kprodimmo_comdetails_admin = htmlspecialchars($_POST['cdreditor_comdetails_admin'], ENT_QUOTES);
$kprodimmo_note_admin = $_POST['areaKprodimmoNoteAdmin'];

#situation
$kprodimmo_city_situation = trim($_POST['txtKprodimmoCity']);

try
{
    $prepared_query = 'SELECT *
                       FROM `cdrgeo`
                       WHERE L'.$main_id_language.' = "'.$kprodimmo_city_situation.'"
                       AND parentdistrict_cdrgeo IS NOT NULL';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kprodimmo_district_situation = $data['parentdistrict_cdrgeo'];
        $Kprodimmo_idcity_situation = $data[0];
        $Kprodimmo_zipcity_situation = $data['zip_cdrgeo'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentdepartment_cdrgeo
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $kprodimmo_district_situation);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kprodimmo_department_situation = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentregion_cdrgeo
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $kprodimmo_department_situation);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kprodimmo_region_situation = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentcountry_cdrgeo
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $kprodimmo_region_situation);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $kprodimmo_country_situation = $data[0];
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

$kprodimmo_location_situation = htmlspecialchars($_POST['cdreditor_location_situation'], ENT_QUOTES);
$kprodimmo_locdetails_situation = htmlspecialchars($_POST['cdreditor_locdetails_situation'], ENT_QUOTES);
$kprodimmo_longitude_situation = trim(htmlspecialchars($_POST['txtKprodimmoSituationLat'], ENT_QUOTES));
$kprodimmo_latitude_situation = trim(htmlspecialchars($_POST['txtKprodimmoSituationLon'], ENT_QUOTES));

$kprodimmo_facilities_situation = null;
$kprodimmo_facilitiesdistance_situation = null;
$kprodimmo_facilitiesgroup_situation = null;
$kprodimmo_facilitiesorder_situation = null;
$kprodimmo_facilitiesorder_distance_situation = null;

for($i = 0, $count = count($kprodimmo_id_facilitiessituation); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]]))
    {
        if(empty($_POST['txtcdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]]))
        {
            $kprodimmo_facilitiesorder_distance_situation = '0.0';
        }
        else
        {
            $kprodimmo_facilitiesorder_distance_situation = str_replace(',', '.', trim(htmlspecialchars($_POST['txtcdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES)));
        }
        if($kprodimmo_facilitiesorder_situation == null)
        {
            $kprodimmo_facilitiesorder_situation = $kprodimmo_facilitiesorder_distance_situation.'$'.trim(htmlspecialchars($_POST['txtKprodimmoSituationFacilitiesGroup'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES)).'$'.htmlspecialchars($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_facilitiesorder_situation .= '#'.$kprodimmo_facilitiesorder_distance_situation.'$'.trim(htmlspecialchars($_POST['txtKprodimmoSituationFacilitiesGroup'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES)).'$'.htmlspecialchars($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES);
        }
    }
    
    if(!empty($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]]))
    {
        if($kprodimmo_facilities_situation == null)
        {
            $kprodimmo_facilities_situation = htmlspecialchars($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_facilities_situation .= '$'.htmlspecialchars($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES);
        }       
    }
    else
    {
        if($kprodimmo_facilities_situation == null)
        {
           $kprodimmo_facilities_situation = '0';
        }
        else
        {
           $kprodimmo_facilities_situation .= '$0'; 
        }
    }
    
    if(!empty($_POST['txtcdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]]) && !empty($_POST['cdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]]))
    {
        if($kprodimmo_facilitiesdistance_situation == null)
        {
            $kprodimmo_facilitiesdistance_situation = str_replace(',', '.', trim(htmlspecialchars($_POST['txtcdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES)));
        }
        else
        {
            $kprodimmo_facilitiesdistance_situation .= '$'.str_replace(',', '.', trim(htmlspecialchars($_POST['txtcdreditor_facilities_situation'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES)));
        }       
    }
    else
    {
        if($kprodimmo_facilitiesdistance_situation == null)
        {
           $kprodimmo_facilitiesdistance_situation = '0';
        }
        else
        {
           $kprodimmo_facilitiesdistance_situation .= '$0'; 
        }
    }
    
    if(!empty($_POST['txtKprodimmoSituationFacilitiesGroup'.$kprodimmo_id_facilitiessituation[$i]]))
    {
        if($kprodimmo_facilitiesgroup_situation == null)
        {
            $kprodimmo_facilitiesgroup_situation = trim(htmlspecialchars($_POST['txtKprodimmoSituationFacilitiesGroup'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES));
        }
        else
        {
            $kprodimmo_facilitiesgroup_situation .= '$'.trim(htmlspecialchars($_POST['txtKprodimmoSituationFacilitiesGroup'.$kprodimmo_id_facilitiessituation[$i]], ENT_QUOTES));
        }       
    }
    else
    {
        if($kprodimmo_facilitiesgroup_situation == null)
        {
           $kprodimmo_facilitiesgroup_situation = '0';
        }
        else
        {
           $kprodimmo_facilitiesgroup_situation .= '$0'; 
        }
    }
}

#interior
$kprodimmo_piecesin_interior = null;

for($i = 1, $count = $kprodimmo_numrooms_general; $i <= $count; $i++)
{
    if($i > 1)
    {
        $kprodimmo_piecesin_interior .= '#';
    }
    
    $kprodimmo_piecesin_interior .= str_replace(',', '', trim(htmlspecialchars($_POST['txtKprodimmoBuildingIn'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesin_interior .= str_replace(',', '', trim(htmlspecialchars($_POST['txtKprodimmoFloorIn'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesin_interior .= htmlspecialchars($_POST['cdreditor_piecesin_interior'.$i], ENT_QUOTES).'$';
    $kprodimmo_piecesin_interior .= str_replace(',', '.', trim(htmlspecialchars($_POST['txtKprodimmoSurfaceIn'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesin_interior .= htmlspecialchars($_POST['cdreditor_piecesindetails_interior'.$i], ENT_QUOTES).'$'; 
    for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
    {
        if($y > 0)
        {
            $kprodimmo_piecesin_interior .= '@';
        }
        
        $kprodimmo_piecesin_interior .= htmlspecialchars($_POST['txtKprodimmoDetailsIn'.$i.'-'.$main_activatedidlang[$y]], ENT_QUOTES).'&'.$main_activatedidlang[$y];
    }
}

#exterior
$kprodimmo_piecesout_exterior = null;

for($i = 1, $count = $kprodimmo_numouthouses_general; $i <= $count; $i++)
{
    if($i > 1)
    {
        $kprodimmo_piecesout_exterior .= '#';
    }
    
    $kprodimmo_piecesout_exterior .= str_replace(',', '', trim(htmlspecialchars($_POST['txtKprodimmoBuildingOut'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesout_exterior .= str_replace(',', '', trim(htmlspecialchars($_POST['txtKprodimmoFloorOut'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesout_exterior .= htmlspecialchars($_POST['cdreditor_piecesout_exterior'.$i], ENT_QUOTES).'$';
    $kprodimmo_piecesout_exterior .= str_replace(',', '.', trim(htmlspecialchars($_POST['txtKprodimmoSurfaceOut'.$i], ENT_QUOTES))).'$';
    $kprodimmo_piecesout_exterior .= htmlspecialchars($_POST['cdreditor_piecesoutdetails_exterior'.$i], ENT_QUOTES).'$';  
    for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
    {
        if($y > 0)
        {
            $kprodimmo_piecesout_exterior .= '@';
        }
        
        $kprodimmo_piecesout_exterior .= htmlspecialchars($_POST['txtKprodimmoDetailsOut'.$i.'-'.$main_activatedidlang[$y]], ENT_QUOTES).'&'.$main_activatedidlang[$y];
    }
}

$kprodimmo_other_exterior = null;

for($i = 0, $count = count($kprodimmo_id_othersexterior); $i < $count; $i++)
{
    if(!empty($_POST['cdreditor_others_exterior'.$kprodimmo_id_othersexterior[$i]]))
    {
        if($kprodimmo_other_exterior == null)
        {
            $kprodimmo_other_exterior = htmlspecialchars($_POST['cdreditor_others_exterior'.$kprodimmo_id_othersexterior[$i]], ENT_QUOTES);
        }
        else
        {
            $kprodimmo_other_exterior .= '$'.htmlspecialchars($_POST['cdreditor_others_exterior'.$kprodimmo_id_othersexterior[$i]], ENT_QUOTES);
        }       
    }
}

include('modules/custom/immo/modules/Kprodimmo/bt/callinfo_msg.php');
include('modules/custom/immo/modules/Kprodimmo/bt/callinfo_condition.php');

if($Bok_kprodimmo_general == false)
{
    $Bok_productproperty = false;
}
?>
