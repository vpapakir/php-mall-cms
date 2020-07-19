<?php session_start();
header('Access-Control-Allow-Origin: '.$myUrl1);
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache'); 
?>
<style>
.SearchCDRgeoCountryResultList
{
   cursor: pointer; 
}    
    
.SearchCDRgeoCountryResultList:hover
{
   background-color: lightblue; 
}
</style> 
<?php
if(!empty($_POST["txtSearchCDRgeoCountry"]))
{
    $database_host = 'localhost';
    $database_connect = 'dbname=dinx2.0'; //database name
    $database_user = 'dinx2.0db';
    $database_pass = 'R395DwZ6xGhjT';
    
    $config_customheader = $COOBOX_BASE_URL; 
    $search_sentence = $_POST["txtSearchCDRgeoCountry"];
    
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
    
    if($search_sentence == '*')
    {
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE code_cdrgeo = "cdrgeo_country_situation"
                           ORDER BY statusobject_cdrgeo, `L'.$_SESSION['current_language'];
    }
    else
    {
        $prepared_query = 'SELECT *
                           FROM `cdrgeo`
                           WHERE `L'.$_SESSION['current_language'].'` LIKE "%'.$search_sentence.'%"
                           AND code_cdrgeo = "cdrgeo_country_situation"
                           ORDER BY statusobject_cdrgeo, `L'.$_SESSION['current_language'].'`
                           LIMIT 0, 10';
    }
    
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
?>
    <li class="SearchCDRgeoCountryResultList" style="cursor: pointer;" onclick="this.setAttribute('id', 'thisoption'); requestGEOEDITCountryGetinfo(); reloadPage();">
        <span class="font_main" style="margin-left: 4px;">Nouveau</span>
        <input name="SearchCDRgeoCountryResultListID" id="SearchCDRgeoCountryResultListID<?php echo($i); ?>" style="display: none;" type="hidden" value="new"/>
    </li>
<?php

    $i++;
    
    if(($data = $query->fetch()) != false)
    {
        $query->execute();
        while($data = $query->fetch()) 
        {
?>
            <li class="SearchCDRgeoCountryResultList" <?php if(empty($data['statusobject_cdrgeo']) || $data['statusobject_cdrgeo'] == 9){ echo('style="background-color: lightblue;"'); } ?> onclick="this.setAttribute('id', 'thisoption'); requestGEOEDITCountryGetinfo(); reloadPage();">
                <span class="font_main" style="cursor: pointer;">
                <span style="margin-left: 4px;"><?php echo($data['L'.$_SESSION['current_language']]); ?></span>
                <input name="SearchCDRgeoCountryResultList" id="SearchCDRgeoCountryResultList<?php echo($i); ?>" style="display: none;" type="hidden" value="<?php echo($data['L'.$_SESSION['current_language']]); ?>"/>
                <input name="SearchCDRgeoCountryResultListID" id="SearchCDRgeoCountryResultListID<?php echo($i); ?>" style="display: none;" type="hidden" value="<?php echo($data[0]); ?>"/>
                </span>
            </li>
<?php
            $i++;
        } 
    }
    $query->closeCursor();
}
?>
