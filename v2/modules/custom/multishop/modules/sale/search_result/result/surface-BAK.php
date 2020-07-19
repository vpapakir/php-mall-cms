<tr>
    <td></td>
    <td class="font_subtitle">
        <?php give_translation('immo.searchproperty_result_surfacelivingspace', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
if(!empty($_SESSION['quicksearch_txtSurfacehabQuicksearch']) || !empty($_SESSION['SaleSearch_txtSurfacehabSaleSearch']))
{
    if(!empty($_SESSION['quicksearch_txtSurfacehabQuicksearch']))
    {
        $resultsalesearch_surfacehab = $_SESSION['quicksearch_txtSurfacehabQuicksearch'];
    }
    else 
    {
        $resultsalesearch_surfacehab = $_SESSION['SaleSearch_txtSurfacehabSaleSearch'];
    }
    
    echo($resultsalesearch_surfacehab.'m²');
    
}
else
{
    echo('<I>'); give_translation('immo.searchproperty_result_notrequested', $echo, $config_showtranslationcode); echo('</I>'); 
}
?>
    </td>
</tr>
<tr>
    <td></td>
    <td class="font_subtitle">
        <?php give_translation('immo.searchproperty_result_surfaceground', $echo, $config_showtranslationcode); ?>
    </td>
    <td class="font_main">
<?php
if(!empty($_SESSION['quicksearch_txtSurfacegroundQuicksearch']) || !empty($_SESSION['SaleSearch_txtSurfacegroundSaleSearch']))
{
    if(!empty($_SESSION['quicksearch_txtSurfacegroundQuicksearch']))
    {
        $resultsalesearch_surfaceground = $_SESSION['quicksearch_txtSurfacegroundQuicksearch'];
    }
    else 
    {
        $resultsalesearch_surfaceground = $_SESSION['SaleSearch_txtSurfacegroundSaleSearch'];
    }
    
    echo($resultsalesearch_surfaceground.'m²');
    
}
else
{
    echo('<I>'); give_translation('immo.searchproperty_result_notrequested', $echo, $config_showtranslationcode); echo('</I>');
}
?>
    </td>
</tr>
