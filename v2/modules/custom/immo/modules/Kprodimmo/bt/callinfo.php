<?php

#general
$product_number = trim(htmlspecialchars($_POST['number_product'], ENT_QUOTES));
$product_status = trim(htmlspecialchars($_POST['status_product'], ENT_QUOTES));
$product_code_L1 = trim(htmlspecialchars($_POST['code_product_L1'], ENT_QUOTES));
$product_code_L2 = trim(htmlspecialchars($_POST['code_product_L2'], ENT_QUOTES));
$product_code_L3 = trim(htmlspecialchars($_POST['code_product_L3'], ENT_QUOTES));
$product_code_L4 = trim(htmlspecialchars($_POST['code_product_L4'], ENT_QUOTES));
$product_code_L5 = trim(htmlspecialchars($_POST['code_product_L5'], ENT_QUOTES));
$product_name_L1 = trim(htmlspecialchars($_POST['name_product_L1'], ENT_QUOTES));
$product_name_L2 = trim(htmlspecialchars($_POST['name_product_L2'], ENT_QUOTES));
$product_name_L3 = trim(htmlspecialchars($_POST['name_product_L3'], ENT_QUOTES));
$product_name_L4 = trim(htmlspecialchars($_POST['name_product_L4'], ENT_QUOTES));
$product_name_L5 = trim(htmlspecialchars($_POST['name_product_L5'], ENT_QUOTES));
$product_introduction_L1 = trim(htmlspecialchars($_POST['introduction_product_L1'], ENT_QUOTES));
$product_introduction_L2 = trim(htmlspecialchars($_POST['introduction_product_L2'], ENT_QUOTES));
$product_introduction_L3 = trim(htmlspecialchars($_POST['introduction_product_L3'], ENT_QUOTES));
$product_introduction_L4 = trim(htmlspecialchars($_POST['introduction_product_L4'], ENT_QUOTES));
$product_introduction_L5 = trim(htmlspecialchars($_POST['introduction_product_L5'], ENT_QUOTES));
$product_description_L1 = trim(htmlspecialchars($_POST['description_product_L1'], ENT_QUOTES));
$product_description_L2 = trim(htmlspecialchars($_POST['description_product_L2'], ENT_QUOTES));
$product_description_L3 = trim(htmlspecialchars($_POST['description_product_L3'], ENT_QUOTES));
$product_description_L4 = trim(htmlspecialchars($_POST['description_product_L4'], ENT_QUOTES));
$product_description_L5 = trim(htmlspecialchars($_POST['description_product_L5'], ENT_QUOTES));
$product_group_code = trim(htmlspecialchars($_POST['code_group_product'], ENT_QUOTES));
$product_category_code = trim(htmlspecialchars($_POST['code_category_product'], ENT_QUOTES));
$product_option_id = trim(htmlspecialchars($_POST['id_option_product'], ENT_QUOTES));
$product_priority = trim(htmlspecialchars($_POST['priority_product'], ENT_QUOTES));
$product_image_thumb = trim(htmlspecialchars($_POST['image_thumb_product'], ENT_QUOTES));
$page_id = trim(htmlspecialchars($_POST['id_page'], ENT_QUOTES));
$product_link_number = trim(htmlspecialchars($_POST['number_link_product'], ENT_QUOTES));
$product_cart_type = trim(htmlspecialchars($_POST['cart_type_product'], ENT_QUOTES));
$product_transport_fee = trim(htmlspecialchars($_POST['transport_fee_product'], ENT_QUOTES));
$product_noticelink = trim(htmlspecialchars($_POST['noticelink_product'], ENT_QUOTES));
$cooshop_id = trim(htmlspecialchars($_POST['id_cooshop'], ENT_QUOTES));
$class_id_product = trim(htmlspecialchars($_POST['product_class_id'], ENT_QUOTES));

 

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


$prepared_query = 'SELECT * FROM config_module';
  if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
  $query = $connectData->prepare($prepared_query);
  $query->execute();
  while(($data = $query->fetch()) != false)
  {
   if($data['element_id'] == 'adminconfig_edit.module_immo') {
    if($data['immo_module'] == 1) { // If immo module is active
     include('modules/custom/immo/modules/Kprodimmo/bt/callinfo_msg.php');
    } else {
     include('modules/custom/multishop/modules/Kprodimmo/bt/callinfo_msg.php');
    }
   }
  }

  $prepared_query = 'SELECT * FROM config_module';
  if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
  $query = $connectData->prepare($prepared_query);
  $query->execute();
  while(($data = $query->fetch()) != false)
  {
   if($data['element_id'] == 'adminconfig_edit.module_immo') {
    if($data['immo_module'] == 1) { // If immo module is active
     include('modules/custom/immo/modules/Kprodimmo/bt/callinfo_condition.php');
    } else {
     include('modules/custom/multishop/modules/Kprodimmo/bt/callinfo_condition.php');
    }
   }
  }


if($Bok_kprodimmo_general == false)
{
    $Bok_productproperty = false;
}
?>
