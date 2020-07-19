<?php
if(!empty($_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'][0]))
{
?>
<tr>
    <td></td>
    <td class="font_subtitle" style="vertical-align: top;">
        <?php give_translation('immo.searchproperty_refine_district', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php   
    $resultsalesearch_district = $_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'];
    $resultsalesearch_district = split_string($resultsalesearch_district, '$');
    
    
    try
    {
        $prepared_query = 'SELECT * FROM cdrgeo
                           WHERE ';
        
        for($i = 0, $count = count($resultsalesearch_district); $i < $count; $i++)
        {
            if($i == ($count - 1))
            {
                $prepared_query .= 'id_cdrgeo = '.$resultsalesearch_district[$i].' ';
            }
            else
            {
                $prepared_query .= 'id_cdrgeo = '.$resultsalesearch_district[$i].' OR ';
            }
        }
        
        $prepared_query .= ' ORDER BY L'.$main_id_language;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        $i = 0;
        while($data = $query->fetch())
        {
            if($i == ($count - 1))
            {
                echo($data['L'.$main_id_language]);
            }
            else
            {
                echo($data['L'.$main_id_language].', ');
            }
            $i++;
        }
        $query->closeCursor();
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
    </td>
</tr>
<?php
}
?>
