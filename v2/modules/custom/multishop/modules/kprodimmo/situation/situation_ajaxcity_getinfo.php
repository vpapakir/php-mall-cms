<?php session_start();
header('Access-Control-Allow-Origin: '.$myUrl1);
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache'); 

if(!empty($_POST['txtKprodimmoCityResultList']))
{
    
    $database_host = 'localhost';
    $database_connect = 'dbname=dinxdev'; //database name
    $database_user = 'dinxdevdb';
    $database_pass = 'Kk2uZ7r5sQ7g7H4sN';
    
    $ajaxcity_name_city = $_POST['txtKprodimmoCityResultList'];
    
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
    
?>
    
<?php
    
    $prepared_query = 'SELECT *
                       FROM `cdrgeo`
                       WHERE L'.$_SESSION['current_language'].' = "'.$ajaxcity_name_city.'"
                       AND parentdistrict_cdrgeo IS NOT NULL';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $ajaxcity_id_district = $data['parentdistrict_cdrgeo'];
        $ajaxcity_zip_city = $data['zip_cdrgeo'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentdepartment_cdrgeo, L'.$_SESSION['current_language'].'
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $ajaxcity_id_district);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $ajaxcity_name_district = $data[1];
        $ajaxcity_id_department = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentregion_cdrgeo, L'.$_SESSION['current_language'].'
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $ajaxcity_id_department);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $ajaxcity_name_department = $data[1];
        $ajaxcity_id_region = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT parentcountry_cdrgeo, L'.$_SESSION['current_language'].'
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $ajaxcity_id_region);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $ajaxcity_name_region = $data[1];
        $ajaxcity_id_country = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT L'.$_SESSION['current_language'].'
                       FROM `cdrgeo`
                       WHERE id_cdrgeo = :id';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $ajaxcity_id_country);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $ajaxcity_name_country = $data[0];
    }
    $query->closeCursor();
    
    if(empty($ajaxcity_zip_city) ? $ajaxcity_zip_city = '<i>inconnu</i>': $ajaxcity_zip_city);
    if(empty($ajaxcity_name_district) ? $ajaxcity_name_district = '<i>inconnu</i>': $ajaxcity_name_district);
    if(empty($ajaxcity_name_department) ? $ajaxcity_name_department = '<i>inconnu</i>': $ajaxcity_name_department);
    if(empty($ajaxcity_name_region) ? $ajaxcity_name_region = '<i>inconnu</i>': $ajaxcity_name_region);
    if(empty($ajaxcity_name_country) ? $ajaxcity_name_country = '<i>inconnu</i>': $ajaxcity_name_country);
?>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">        
            <tr>
                <td align="left">
                    <span class="font_subtitle">Code Postal</span>
                </td>
                <td align="left" width="70%">
                    <span class="font_main"><?php echo($ajaxcity_zip_city); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">Arrondissement</span>
                </td>
                <td align="left">
                    <span class="font_main"><?php echo($ajaxcity_name_district); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">Département</span>
                </td>
                <td align="left">
                    <span class="font_main"><?php echo($ajaxcity_name_department); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">Région</span>
                </td>
                <td align="left">
                    <span class="font_main"><?php echo($ajaxcity_name_region); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">Pays</span>
                </td>
                <td align="left">
                    <span class="font_main"><?php echo($ajaxcity_name_country); ?></span>
                </td>
            </tr>                                         
        </table>
        
<?php        
}
?>
