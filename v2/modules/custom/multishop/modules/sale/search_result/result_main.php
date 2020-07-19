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
					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/offer.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/price.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/surface.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/sleep.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/typeobject.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/department.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/district.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/location.php');
						}
					}

					$prepared_query = 'SELECT * FROM config_module';
					if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
					$query = $connectData->prepare($prepared_query);
					$query->execute();
					while(($data = $query->fetch()) != false)
					{
						if($data['immo_module'] == 1) { // select to include the appropriate module file
							include('modules/custom/multishop/modules/sale/search_result/result/condition.php');
						}
					}

?>
                </table></td>
            </tr>
        </table></td>
    </tr>
<?php
}

?>