<?php
if(isset($_POST['bt_add_city_geo']) || isset($_POST['bt_add_district_geo'])
        || isset($_POST['bt_add_department_geo']) || isset($_POST['bt_add_region_geo'])
        || isset($_POST['bt_add_country_geo']) || isset($_POST['bt_edit_city_geo'])
        || isset($_POST['bt_edit_district_geo']) || isset($_POST['bt_edit_department_geo'])
        || isset($_POST['bt_edit_region_geo']) || isset($_POST['bt_edit_country_geo'])
        || isset($_POST['bt_delete_image_city']) || isset($_POST['bt_delete_image_district'])
        || isset($_POST['bt_delete_image_department']) || isset($_POST['bt_delete_image_region'])
        || isset($_POST['bt_delete_image_country']))
{
    #expand city
    if(!empty($_POST['expand_collapseCDRgeoCity']) && $_POST['expand_collapseCDRgeoCity'] == 'false')
    {
        $_SESSION['expand_collapseCDRgeoCity'] = 'false';
    }
    else
    {
        $_SESSION['expand_collapseCDRgeoCity'] = 'true';
    }

    #expand district
    if(!empty($_POST['expand_collapseCDRgeoDistrict']) && $_POST['expand_collapseCDRgeoDistrict'] == 'false')
    {
        $_SESSION['expand_collapseCDRgeoDistrict'] = 'false';
    }
    else
    {
        $_SESSION['expand_collapseCDRgeoDistrict'] = 'true';
    }

    #expand department
    if(!empty($_POST['expand_collapseCDRgeoDepartment']) && $_POST['expand_collapseCDRgeoDepartment'] == 'false')
    {
        $_SESSION['expand_collapseCDRgeoDepartment'] = 'false';
    }
    else
    {
        $_SESSION['expand_collapseCDRgeoDepartment'] = 'true';
    }

    #expand region
    if(!empty($_POST['expand_collapseCDRgeoRegion']) && $_POST['expand_collapseCDRgeoRegion'] == 'false')
    {
        $_SESSION['expand_collapseCDRgeoRegion'] = 'false';
    }
    else
    {
        $_SESSION['expand_collapseCDRgeoRegion'] = 'true';
    }

    #expand country
    if(!empty($_POST['expand_collapseCDRgeoCountry']) && $_POST['expand_collapseCDRgeoCountry'] == 'false')
    {
        $_SESSION['expand_collapseCDRgeoCountry'] = 'false';
    }
    else
    {
        $_SESSION['expand_collapseCDRgeoCountry'] = 'true';
    }
}
?>
