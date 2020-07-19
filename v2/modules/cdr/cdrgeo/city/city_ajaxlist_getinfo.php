<?php session_start();
header('Access-Control-Allow-Origin: '.$myUrl1);
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache'); 

if(!empty($_POST['SearchCDRgeoCityValue']))
{
    #city
    unset($_SESSION['cdrgeo_edit_button_city'],
            $_SESSION['cdrgeo_hiddenidCDRgeoCity'],
            $_SESSION['cdrgeo_txtSearchCDRgeoCity'],
            $_SESSION['cdrgeo_txtZipCDRgeoCity'],
            $_SESSION['msg_cdrgeo_upload_city']);

    for($i = 0, $count = count($id_language); $i < $count; $i++)
    {
       unset($_SESSION['cdrgeo_txtNameCDRgeoCity'.$id_language[$i]]); 
    }

    unset($_SESSION['cdrgeo_IDImageCDRgeoCity'],
            $_SESSION['cdrgeo_cboDistrictCDRgeoCity'],
            $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'],
            $_SESSION['cdrgeo_txtINSEECDRgeoCity'],
            $_SESSION['cdrgeo_txtPopulationCDRgeoCity'],
            $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'],
            $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'],
            $_SESSION['cdrgeo_areaRemarkCDRgeoCity'],
            $_SESSION['cdrgeo_cboStatusCDRgeoCity']);
    

//    #district
//    unset($_SESSION['cdrgeo_txtSearchCDRgeoDistrict']);
//
//    for($i = 0, $count = count($id_language); $i < $count; $i++)
//    {
//       unset($_SESSION['cdrgeo_txtNameCDRgeoDistrict'.$id_language[0]]); 
//    }
//
//    unset($_SESSION['cdrgeo_cboDepartmentCDRgeoDistrict'],
//            $_SESSION['cdrgeo_cboStatusCDRgeoDistrict']);
//
//    #department
//    unset($_SESSION['cdrgeo_txtSearchCDRgeoDepartment']);
//
//    for($i = 0, $count = count($id_language); $i < $count; $i++)
//    {
//       unset($_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$id_language[0]]); 
//    }
//
//    unset($_SESSION['cdrgeo_cboRegionCDRgeoDepartment'],
//            $_SESSION['cdrgeo_cboStatusCDRgeoDepartment']);
//
//    #region
//    unset($_SESSION['cdrgeo_txtSearchCDRgeoRegion']);
//
//    for($i = 0, $count = count($id_language); $i < $count; $i++)
//    {
//       unset($_SESSION['cdrgeo_txtNameCDRgeoRegion'.$id_language[0]]); 
//    }
//
//    unset($_SESSION['cdrgeo_cboCountryCDRgeoRegion'],
//            $_SESSION['cdrgeo_cboStatusCDRgeoRegion']);
//
//    #country
//    unset($_SESSION['cdrgeo_txtSearchCDRgeoCountry']);
//
//    for($i = 0, $count = count($id_language); $i < $count; $i++)
//    {
//       unset($_SESSION['cdrgeo_txtNameCDRgeoCountry'.$id_language[0]]); 
//    }
//
//    unset($_SESSION['cdrgeo_cboStatusCDRgeoCountry']);
    
    $database_host = 'localhost';
    $database_connect = 'dbname=dinx2.0'; //database name
    $database_user = 'dinx2.0db';
    $database_pass = 'R395DwZ6xGhjT';
    
    $config_customheader = $COOBOX_BASE_URL; 

    try
    {
       //connect to database
       $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
       $pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
       $connectData = new PDO('mysql:host='.$database_host.'; '.$database_connect.'', ''.$database_user.'',
                                ''.$database_pass.'', $pdo_options);

       $connectData->query('SET NAMES UTF8');
    }
    catch (Exception $e)
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
    
    $prepared_query = 'SELECT * FROM language
                       WHERE status_language = 1
                       ORDER BY priority_language DESC, position_language';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $id_language[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();
    
    
    if($_POST['SearchCDRgeoCityValue'] != 'new')
    {
        $prepared_query = 'SELECT L'.$_SESSION['current_language'].' FROM page
                           INNER JOIN page_translation
                           ON page.id_page = page_translation.id_page
                           WHERE url_page = "cdrgeo"
                           AND (family_page_translation = "rewritingF"
                           OR family_page_translation = "rewritingB")';
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;
        while($data = $query->fetch())
        {
            $rewriting[$i] = $data[0];
            $i++;
        }
        $query->closeCursor();               

        #expand city
        if(!empty($_POST['ExpandCDRgeoCityValue']) && $_POST['ExpandCDRgeoCityValue'] == 'false')
        {
            $_SESSION['expand_collapseCDRgeoCity'] = 'false';
        }
        else
        {
            $_SESSION['expand_collapseCDRgeoCity'] = 'true';
        }
        
        #expand district
        if(!empty($_POST['ExpandCDRgeoDistrictValue']) && $_POST['ExpandCDRgeoDistrictValue'] == 'false')
        {
            $_SESSION['expand_collapseCDRgeoDistrict'] = 'false';
        }
        else
        {
            $_SESSION['expand_collapseCDRgeoDistrict'] = 'true';
        }
        
        #expand department
        if(!empty($_POST['ExpandCDRgeoDepartmentValue']) && $_POST['ExpandCDRgeoDepartmentValue'] == 'false')
        {
            $_SESSION['expand_collapseCDRgeoDepartment'] = 'false';
        }
        else
        {
            $_SESSION['expand_collapseCDRgeoDepartment'] = 'true';
        }
        
        #expand region
        if(!empty($_POST['ExpandCDRgeoRegionValue']) && $_POST['ExpandCDRgeoRegionValue'] == 'false')
        {
            $_SESSION['expand_collapseCDRgeoRegion'] = 'false';
        }
        else
        {
            $_SESSION['expand_collapseCDRgeoRegion'] = 'true';
        }
        
        #expand country
        if(!empty($_POST['ExpandCDRgeoCountryValue']) && $_POST['ExpandCDRgeoCountryValue'] == 'false')
        {
            $_SESSION['expand_collapseCDRgeoCountry'] = 'false';
        }
        else
        {
            $_SESSION['expand_collapseCDRgeoCountry'] = 'true';
        }
        
        #city
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE id_cdrgeo = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $_POST['SearchCDRgeoCityValue']);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $_SESSION['cdrgeo_edit_button_city'] = true;
            $_SESSION['cdrgeo_hiddenidCDRgeoCity'] = $data[0];
            $_SESSION['cdrgeo_txtSearchCDRgeoCity'] = $data['L'.$_SESSION['current_language']];
            $_SESSION['cdrgeo_txtZipCDRgeoCity'] = $data['zip_cdrgeo'];
            for($i = 0, $count = count($id_language); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoCity'.$id_language[$i]] = stripslashes($data['L'.$id_language[$i]]); 
            }
            $_SESSION['cdrgeo_IDImageCDRgeoCity'] = $data['id_image'];
            $_SESSION['cdrgeo_cboDistrictCDRgeoCity'] = $data['parentdistrict_cdrgeo'];
            $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'] = $data['latitude_cdrgeo'];
            $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'] = $data['longitude_cdrgeo'];
            $_SESSION['cdrgeo_txtINSEECDRgeoCity'] = $data['insee_cdrgeo'];
            $_SESSION['cdrgeo_txtPopulationCDRgeoCity'] = $data['population_cdrgeo'];
            $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'] = $data['taxhab_cdrgeo'];
            $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'] = $data['typecity_cdrgeo'];
            $_SESSION['cdrgeo_areaRemarkCDRgeoCity'] = $data['remarks_cdrgeo'];
            $_SESSION['cdrgeo_cboStatusCDRgeoCity'] = $data['statusobject_cdrgeo'];
        }
        $query->closeCursor();
        
        #district
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE id_cdrgeo = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $_SESSION['cdrgeo_cboDistrictCDRgeoCity']);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $_SESSION['cdrgeo_edit_button_district'] = true;
            $_SESSION['cdrgeo_hiddenidCDRgeoDistrict'] = $data[0];
            $_SESSION['cdrgeo_txtSearchCDRgeoDistrict'] = $data['L'.$_SESSION['current_language']];
            for($i = 0, $count = count($id_language); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoDistrict'.$id_language[$i]] = stripslashes($data['L'.$id_language[$i]]); 
            }
            $_SESSION['cdrgeo_IDImageCDRgeoDistrict'] = $data['id_image'];
            $_SESSION['cdrgeo_cboDepartmentCDRgeoDistrict'] = $data['parentdepartment_cdrgeo'];
            $_SESSION['cdrgeo_cboSelectPageInfoCDRgeoDistrict'] = $data['pageinfo_cdrgeo'];
            $_SESSION['cdrgeo_cboStatusCDRgeoDistrict'] = $data['statusobject_cdrgeo'];
        }
        $query->closeCursor();
        
        #department
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE id_cdrgeo = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $_SESSION['cdrgeo_cboDepartmentCDRgeoDistrict']);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $_SESSION['cdrgeo_edit_button_department'] = true;
            $_SESSION['cdrgeo_hiddenidCDRgeoDepartment'] = $data[0];
            $_SESSION['cdrgeo_txtSearchCDRgeoDepartment'] = $data['L'.$_SESSION['current_language']];
            for($i = 0, $count = count($id_language); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoDepartment'.$id_language[$i]] = stripslashes($data['L'.$id_language[$i]]); 
            }
            $_SESSION['cdrgeo_IDImageCDRgeoDepartment'] = $data['id_image'];
            $_SESSION['cdrgeo_cboRegionCDRgeoDepartment'] = $data['parentregion_cdrgeo'];
            $_SESSION['cdrgeo_cboStatusCDRgeoDepartment'] = $data['statusobject_cdrgeo'];
        }
        $query->closeCursor();
        
        #region
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE id_cdrgeo = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $_SESSION['cdrgeo_cboRegionCDRgeoDepartment']);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $_SESSION['cdrgeo_edit_button_region'] = true;
            $_SESSION['cdrgeo_hiddenidCDRgeoRegion'] = $data[0];
            $_SESSION['cdrgeo_txtSearchCDRgeoRegion'] = $data['L'.$_SESSION['current_language']];
            for($i = 0, $count = count($id_language); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoRegion'.$id_language[$i]] = stripslashes($data['L'.$id_language[$i]]); 
            }
            $_SESSION['cdrgeo_IDImageCDRgeoRegion'] = $data['id_image'];
            $_SESSION['cdrgeo_cboCountryCDRgeoRegion'] = $data['parentcountry_cdrgeo'];
            $_SESSION['cdrgeo_cboStatusCDRgeoRegion'] = $data['statusobject_cdrgeo'];
        }
        $query->closeCursor();
        
        #country
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE id_cdrgeo = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $_SESSION['cdrgeo_cboCountryCDRgeoRegion']);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $_SESSION['cdrgeo_edit_button_country'] = true;
            $_SESSION['cdrgeo_hiddenidCDRgeoCountry'] = $data[0];
            $_SESSION['cdrgeo_txtSearchCDRgeoCountry'] = $data['L'.$_SESSION['current_language']];
            for($i = 0, $count = count($id_language); $i < $count; $i++)
            {
               $_SESSION['cdrgeo_txtNameCDRgeoCountry'.$id_language[$i]] = stripslashes($data['L'.$id_language[$i]]); 
            }
            $_SESSION['cdrgeo_IDImageCDRgeoCountry'] = $data['id_image'];
            $_SESSION['cdrgeo_cboStatusCDRgeoCountry'] = $data['statusobject_cdrgeo'];
        }
        $query->closeCursor();
    }
    else
    {
        #city
        unset($_SESSION['cdrgeo_edit_button_city'],
                $_SESSION['cdrgeo_hiddenidCDRgeoCity'],
                $_SESSION['cdrgeo_txtSearchCDRgeoCity'],
                $_SESSION['cdrgeo_txtZipCDRgeoCity']);

        for($i = 0, $count = count($id_language); $i < $count; $i++)
        {
           unset($_SESSION['cdrgeo_txtNameCDRgeoCity'.$id_language[$i]]); 
        }

        unset($_SESSION['cdrgeo_IDImageCDRgeoCity'],
                $_SESSION['cdrgeo_cboDistrictCDRgeoCity'],
                $_SESSION['cdrgeo_txtLatitudeCDRgeoCity'],
                $_SESSION['cdrgeo_txtLongitudeCDRgeoCity'],
                $_SESSION['cdrgeo_txtINSEECDRgeoCity'],
                $_SESSION['cdrgeo_txtPopulationCDRgeoCity'],
                $_SESSION['cdrgeo_txtTaxhabCDRgeoCity'],
                $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'],
                $_SESSION['cdrgeo_areaRemarkCDRgeoCity'],
                $_SESSION['cdrgeo_cboStatusCDRgeoCity']);
    }
}
?>
