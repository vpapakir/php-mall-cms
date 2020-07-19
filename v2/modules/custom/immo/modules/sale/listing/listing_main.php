<?php
nosubmit_form_historyback();
if(isset($_POST['bt_main_search']))
{
    try
    {    
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "search_main"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $searchmain_rewritingF = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "search_main"
                           AND family_page_translation = "rewritingB"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $searchmain_rewritingB = $data[0];
        }
        $query->closeCursor();  
    }
    catch(Exception $e)
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
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$searchmain_rewritingF);
    }
    else
    {
        header('Location: '.$config_customheader.$searchmain_rewritingB);
    }
}

if(isset($_GET['unset']))
{
    if($_GET['unset'] == true)
    {
        unset($array_prepared_query);
        unset($_SESSION['SaleSearch_typeoffer']);
        unset($_SESSION['SaleSearch_cdreditor_offer_objectSaleSearch'],
                $_SESSION['SaleSearch_cboCurrencySaleSearch'],
                $_SESSION['SaleSearch_txtPriceMinSaleSearch'],
                $_SESSION['SaleSearch_txtPriceMaxSaleSearch'],
                $_SESSION['SaleSearch_txtSurfacehabSaleSearch'],
                $_SESSION['SaleSearch_txtSurfacegroundSaleSearch'],
                $_SESSION['SaleSearch_txtNbSleepMinSaleSearch'],
                $_SESSION['SaleSearch_txtNbSleepMaxSaleSearch'],
                $_SESSION['SaleSearch_cdreditor_type_objectSaleSearch'],
                $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'],
                $_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'],
                $_SESSION['SaleSearch_cdreditor_location_situationSaleSearch'],
                $_SESSION['SaleSearch_cdreditor_condition_objectSaleSearch']);

        unset($_SESSION['SaleSearch_cboObjectOrderSaleSearch'],
                $_SESSION['SaleSearch_cboTypeOrderSaleSearch'],
                $_SESSION['SaleSearch_cboNrPageOrderSaleSearch']);

        unset($_SESSION['quicksearch_resultSaleSearch']);

        #paging
        unset($_SESSION['paging_limitmin'],
                $_SESSION['paging_limitmax'],
                $_SESSION['paging_defaultdisplay'],
                $_SESSION['paging_selected_page']);

        #unset session
        unset($_SESSION['quicksearch_done']);

        unset($_SESSION['msg_quicksearch_offer'],
                $_SESSION['msg_quicksearch_price']);   

        unset($_SESSION['quicksearch_cdreditor_offer_objectQuicksearch'],
                $_SESSION['quicksearch_cboCurrencyQuicksearch'],
                $_SESSION['quicksearch_txtPriceMinQuicksearch'],
                $_SESSION['quicksearch_txtPriceMaxQuicksearch'],
                $_SESSION['quicksearch_txtSurfacehabQuicksearch'],
                $_SESSION['quicksearch_txtSurfacegroundQuicksearch'],
                $_SESSION['quicksearch_txtNbSleepMinQuicksearch'],
                $_SESSION['quicksearch_txtNbSleepMaxQuicksearch'],
                $_SESSION['quicksearch_cdreditor_type_objectQuicksearch'],
                $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'],
                $_SESSION['quicksearch_cdreditor_location_situationQuicksearch'],
                $_SESSION['quicksearch_cdreditor_condition_objectQuicksearch']);

        unset($_SESSION['quicksearch_expand_main'],
                $_SESSION['expand_collapseSurfacehabQuicksearch'],
                $_SESSION['expand_collapseNbSleepMinQuicksearch'],
                $_SESSION['expand_collapseTypeobjectQuicksearch'],
                $_SESSION['expand_collapseDepartmentQuicksearch'],
                $_SESSION['expand_collapseLocationQuicksearch'],
                $_SESSION['expand_collapseConditionQuicksearch']);

        unset($_SESSION['quicksearch_resultQuicksearch']);
        unset($_SESSION['SaleSearch_first_load']);
        
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_page);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_page);
        }
    }
}

if(isset($_GET['offer']))
{
    $_SESSION['SaleSearch_typeoffer'] = trim(htmlspecialchars($_GET['offer'], ENT_QUOTES));
    
    if($_SESSION['SaleSearch_typeoffer'] == 83)
    {
        $_SESSION['SaleSearch_typeoffer'] = '82$<>';
    }
    else
    {
        $_SESSION['SaleSearch_typeoffer'] = '82$=';
    }
}
?>

<form method="post"><table width="100%">
<?php
        include('modules/custom/immo/modules/sale/search_result/result_main.php');        
        include('modules/custom/immo/modules/sale/search_option/option_main.php');
        
        include('modules/custom/immo/modules/sale/bt/bt_productsearch.php');

        include('modules/custom/immo/modules/sale/search_result/priority/result_priority.php');
?>
        
</table></form>
