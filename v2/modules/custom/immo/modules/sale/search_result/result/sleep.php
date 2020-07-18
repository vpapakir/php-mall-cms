<tr>
    <td></td>
    <td style="vertical-align: top;" class="font_subtitle">
        <?php give_translation('immo.searchproperty_refine_nrofbedrooms', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
    if(!empty($_SESSION['quicksearch_txtNbSleepMinQuicksearch']) || !empty($_SESSION['quicksearch_txtNbSleepMaxQuicksearch'])
            || !empty($_SESSION['SaleSearch_txtNbSleepMinSaleSearch']) || !empty($_SESSION['SaleSearch_txtNbSleepMaxSaleSearch']))
    {
        if(!empty($_SESSION['quicksearch_txtNbSleepMinQuicksearch']))
        {
            $resultsalesearch_sleepmin = $_SESSION['quicksearch_txtNbSleepMinQuicksearch'];
        }
        else 
        {
            $resultsalesearch_sleepmin = $_SESSION['SaleSearch_txtNbSleepMinSaleSearch'];
        }
        
        if(!empty($_SESSION['quicksearch_txtNbSleepMaxQuicksearch']))
        {
            $resultsalesearch_sleepmax = $_SESSION['quicksearch_txtNbSleepMaxQuicksearch'];
        }
        else 
        {
            $resultsalesearch_sleepmax = $_SESSION['SaleSearch_txtNbSleepMaxSaleSearch'];
        }
        
        if(!empty($resultsalesearch_sleepmin) && !empty($resultsalesearch_sleepmax))
        {
            echo($resultsalesearch_sleepmin.' - '.$resultsalesearch_sleepmax);
        }
        else
        {
            if(!empty($resultsalesearch_sleepmin))
            {
                echo($resultsalesearch_sleepmin.' '); give_translation('immo.searchproperty_result_minimum', $echo, $config_showtranslationcode);
            }
            
            if(!empty($resultsalesearch_sleepmax))
            {
                echo($resultsalesearch_sleepmax.' '); give_translation('immo.searchproperty_result_maximum', $echo, $config_showtranslationcode);
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
