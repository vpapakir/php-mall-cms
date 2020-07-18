<tr>
    <td></td>
    <td class="font_subtitle" style="vertical-align: top;">
        <?php give_translation('immo.searchproperty_refine_location', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
if(!empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch'])|| !empty($_SESSION['SaleSearch_cdreditor_location_situationSaleSearch']))
{
    if(!empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch']))
    {
        $resultsalesearch_location = $_SESSION['quicksearch_cdreditor_location_situationQuicksearch'];
    }
    else 
    {
        $resultsalesearch_location = $_SESSION['SaleSearch_cdreditor_location_situationSaleSearch'];
    }
    
    $resultsalesearch_location = split_string($resultsalesearch_location, '$');
    $count = count($resultsalesearch_location);
    try
    {
        $prepared_query = 'SELECT * FROM cdreditor
                           WHERE ';
        for($i = 0; $i < $count; $i++)
        {
            if($i == ($count - 1))
            {
                $prepared_query .= 'id_cdreditor = '.$resultsalesearch_location[$i];
            }
            else
            {
                $prepared_query .= 'id_cdreditor = '.$resultsalesearch_location[$i].' OR ';
            }
        }
        
        $prepared_query .= ' ORDER BY L'.$main_id_language.'S';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        $i = 0;
        while($data = $query->fetch())
        {
            if($i == ($count - 1))
            {
                echo($data['L'.$main_id_language.'S']);
            }
            else
            {
                echo($data['L'.$main_id_language.'S'].', ');
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
    
}
else
{
    echo('<I>'); give_translation('immo.searchproperty_result_notrequested', $echo, $config_showtranslationcode); echo('</I>'); 
}
?>
    </td>
</tr>
