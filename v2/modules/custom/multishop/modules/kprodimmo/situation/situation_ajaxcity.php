<?php session_start();
header('Access-Control-Allow-Origin: '.$myUrl1);
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache'); 

//unset($_SESSION['Kprodimmo_situation_CityInfo'],
//            $_SESSION['Kprodimmo_situation_txtKprodimmoCity']);
?>
<style>
.KprodimmoCityResultList
{
   cursor: pointer; 
}    
    
.KprodimmoCityResultList:hover
{
   background-color: lightblue; 
}
</style> 


<?php
if(!empty($_POST["txtKprodimmoCity"]))
{
    $database_host = 'localhost';
    $database_connect = 'dbname=dinxdev'; //database name
    $database_user = 'dinxdevdb';
    $database_pass = 'Kk2uZ7r5sQ7g7H4sN';
    
    
    
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
    
    $prepared_query = 'SELECT *
                       FROM `cdrgeo`
                       WHERE (`L'.$_SESSION['current_language'].'` LIKE "%'.$_POST["txtKprodimmoCity"].'%"
                       OR zip_cdrgeo LIKE "%'.$_POST["txtKprodimmoCity"].'%")
                       AND code_cdrgeo = "cdrgeo_city_situation"
                       ORDER BY `L'.$_SESSION['current_language'].'`
                       LIMIT 0, 10';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    
    if(($data = $query->fetch()) != false)
    {
        $query->execute();
        while($data = $query->fetch()) 
        {
?>
            <li class="KprodimmoCityResultList" onclick="CopyPasteDisappear('KprodimmoCityResultList<?php echo($i); ?>', 'txtKprodimmoCity', 'KprodimmoCityDIV', false); this.setAttribute('id', 'thisoption'); requestKprodimmoCityGetinfo();">
                <span class="font_main" style="cursor: pointer;">
                <span style="margin-left: 4px;"><?php echo($data['L'.$_SESSION['current_language'].'']); ?></span>
                &nbsp;
                <span>
                    <?php echo('('.$data['zip_cdrgeo'].')'); ?>
                </span>
                <input name="KprodimmoCityResultList" id="KprodimmoCityResultList<?php echo($i); ?>" style="display: none;" type="hidden" name="KprodimmoCityResultList" value="<?php echo($data['L'.$_SESSION['current_language'].'']); ?>"/>
                </span>
            </li>
<?php
            $i++;
        } 
    }
    else
    {
?>
            <li class="font_main" class="KprodimmoCityResultList" onclick="CopyPasteDisappear('KprodimmoCityResultList<?php echo($i); ?>', 'txtKprodimmoCity', 'KprodimmoCityDIV', true);">
                <span id="KprodimmoCityResultList<?php echo($i); ?>" style="margin-left: 4px;">Aucun résultat</span>
            </li>    
<?php            
    }
    $query->closeCursor();
}
?>