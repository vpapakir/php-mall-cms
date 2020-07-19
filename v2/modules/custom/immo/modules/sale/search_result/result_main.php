<?php
if((!empty($_SESSION['quicksearch_cdreditor_offer_objectQuicksearch'])
    || !empty($_SESSION['quicksearch_cboCurrencyQuicksearch'])
    || !empty($_SESSION['quicksearch_txtPriceMinQuicksearch'])
    || !empty($_SESSION['quicksearch_txtPriceMaxQuicksearch'])
    || !empty($_SESSION['quicksearch_txtSurfacehabQuicksearch'])
    || !empty($_SESSION['quicksearch_txtSurfacegroundQuicksearch'])
    || !empty($_SESSION['quicksearch_txtNbSleepMinQuicksearch'])
    || !empty($_SESSION['quicksearch_txtNbSleepMaxQuicksearch'])
    || !empty($_SESSION['quicksearch_cdreditor_type_objectQuicksearch'])
    || !empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'])
    || !empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch'])
    || !empty($_SESSION['quicksearch_cdreditor_condition_objectQuicksearch']))
        || (!empty($_SESSION['SaleSearch_cdreditor_offer_objectSaleSearch'])
            || !empty($_SESSION['SaleSearch_cboCurrencySaleSearch'])
            || !empty($_SESSION['SaleSearch_txtPriceMinSaleSearch'])
            || !empty($_SESSION['SaleSearch_txtPriceMaxSaleSearch'])
            || !empty($_SESSION['SaleSearch_txtSurfacehabSaleSearch'])
            || !empty($_SESSION['SaleSearch_txtSurfacegroundSaleSearch'])
            || !empty($_SESSION['SaleSearch_txtNbSleepMinSaleSearch'])
            || !empty($_SESSION['SaleSearch_txtNbSleepMaxSaleSearch'])
            || !empty($_SESSION['SaleSearch_cdreditor_type_objectSaleSearch'])
            || !empty($_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'])
            || !empty($_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'])
            || !empty($_SESSION['SaleSearch_cdreditor_location_situationSaleSearch'])
            || !empty($_SESSION['SaleSearch_cdreditor_condition_objectSaleSearch'])))
{
?>
    <tr>
        <td><table class="block_main2">
            <tr>
                <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
                    include('modules/custom/immo/modules/sale/search_result/result/offer.php');
                    include('modules/custom/immo/modules/sale/search_result/result/price.php');
                    include('modules/custom/immo/modules/sale/search_result/result/surface.php');
                    include('modules/custom/immo/modules/sale/search_result/result/sleep.php');
                    include('modules/custom/immo/modules/sale/search_result/result/typeobject.php');
                    include('modules/custom/immo/modules/sale/search_result/result/department.php');
                    include('modules/custom/immo/modules/sale/search_result/result/district.php');
                    include('modules/custom/immo/modules/sale/search_result/result/location.php');
                    include('modules/custom/immo/modules/sale/search_result/result/condition.php');
?>
                </table></td>
            </tr>
        </table></td>
    </tr>
<?php
}

?>