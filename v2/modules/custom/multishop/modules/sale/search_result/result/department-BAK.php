<tr>
    <td></td>
    <td class="font_subtitle" style="vertical-align: top;">
        <?php give_translation('immo.searchproperty_refine_department', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
if((!empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0]) && $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0] != 'select')
        || !empty($_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'][0]) && $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'][0] != 'select')
{
    if(!empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch']))
    {
        $resultsalesearch_department = $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'];
    }
    else 
    {
        $resultsalesearch_department = $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'];
    }
    
    try
    {
        $prepared_query = 'SELECT * FROM cdrgeo
                           WHERE ';
        
        for($i = 0, $count = count($resultsalesearch_department); $i < $count; $i++)
        {
            if($i == ($count - 1))
            {
                $prepared_query .= 'id_cdrgeo = '.$resultsalesearch_department[$i].' ';
            }
            else
            {
                $prepared_query .= 'id_cdrgeo = '.$resultsalesearch_department[$i].' OR ';
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
}
else
{
    echo('<I>'); give_translation('immo.searchproperty_result_notrequested', $echo, $config_showtranslationcode); echo('</I>'); 
}
?>
    </td>
</tr>
