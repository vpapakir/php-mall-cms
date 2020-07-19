<tr>
    <td class="font_subtitle" width="25%"><?php give_translation('immo.searchproperty_result_urcriterias', $echo, $config_showtranslationcode); ?></td>
    <td class="font_subtitle" width="25%">
        <?php give_translation('immo.searchproperty_refine_offer', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
if(!empty($_SESSION['quicksearch_cdreditor_offer_objectQuicksearch']) || !empty($_SESSION['SaleSearch_cdreditor_offer_objectSaleSearch']))
{
    if(!empty($_SESSION['quicksearch_cdreditor_offer_objectQuicksearch']))
    {
        $resultsalesearch_offer = $_SESSION['quicksearch_cdreditor_offer_objectQuicksearch'];
    }
    else 
    {
        $resultsalesearch_offer = $_SESSION['SaleSearch_cdreditor_offer_objectSaleSearch'];
    }
    
    $resultsalesearch_offer = split_string($resultsalesearch_offer, '$');
    $count = count($resultsalesearch_offer);
    try
    {
        $prepared_query = 'SELECT * FROM cdreditor
                           WHERE ';
        for($i = 0; $i < $count; $i++)
        {
            if($i == ($count - 1))
            {
                $prepared_query .= 'id_cdreditor = '.$resultsalesearch_offer[$i];
            }
            else
            {
                $prepared_query .= 'id_cdreditor = '.$resultsalesearch_offer[$i].' OR ';
            }
        }
        
        $prepared_query .= ' ORDER BY position_cdreditor, L'.$main_id_language.'S';
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
