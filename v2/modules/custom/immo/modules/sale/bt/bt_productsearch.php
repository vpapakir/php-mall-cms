<?php
if(isset($_POST['bt_productsearch']))
{
    $_SESSION['SaleSearch_first_load'] = 'notempty';
    
    #unset session
    unset($_SESSION['SaleSearch_typeoffer']);
    unset($_SESSION['msg_quicksearch_offer'],
            $_SESSION['msg_quicksearch_price']);   
    
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
    
    #paging
    unset($_SESSION['paging_limitmin'],
            $_SESSION['paging_limitmax'],
            $_SESSION['paging_defaultdisplay'],
            $_SESSION['paging_selected_page']);
    
    
    
    if(!empty($_SESSION['quicksearch_done']) && $_SESSION['quicksearch_done'] == true)
    {
        $quicksearch_array = $_SESSION['quicksearch_resultQuicksearch'];
        $quicksearch_array = split_string($quicksearch_array, '#');
    }
    else
    {
        unset($_SESSION['quicksearch_resultQuicksearch']);
    }

    #getinfo
        #offer
    if(empty($quicksearch_array[0]))
    {
        $salesearch_offer = null;

        for($i = 0, $count = count($salesearch_id_offer); $i < $count; $i++)
        {
            if(!empty($_POST['cdreditor_offer_objectSaleSearch'.$salesearch_id_offer[$i]]))
            {
                if($salesearch_offer == null)
                {
                    $salesearch_offer = htmlspecialchars($_POST['cdreditor_offer_objectSaleSearch'.$salesearch_id_offer[$i]], ENT_QUOTES);
                }
                else
                {
                    $salesearch_offer .= '$'.htmlspecialchars($_POST['cdreditor_offer_objectSaleSearch'.$salesearch_id_offer[$i]], ENT_QUOTES);
                }       
            }
        }
    }
    else
    {
        $salesearch_offer = $quicksearch_array[0];
    }
    
        #currency
    if(empty($quicksearch_array[1]))
    {
        $salesearch_currency = htmlspecialchars($_POST['cboCurrencySaleSearch'], ENT_QUOTES);
    }
    else
    {
        $salesearch_currency = $quicksearch_array[1];
    }
    
        #pricemin
    if(empty($quicksearch_array[2]))
    {
        $salesearch_pricemin = trim(htmlspecialchars($_POST['txtPriceMinSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_pricemin = $quicksearch_array[2];
    }
    
        #pricemax
    if(empty($quicksearch_array[3]))
    {
        $salesearch_pricemax = trim(htmlspecialchars($_POST['txtPriceMaxSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_pricemax = $quicksearch_array[3];
    }
    
        #surfacehab
    if(empty($quicksearch_array[4]))
    {
        $salesearch_surfhab = trim(htmlspecialchars($_POST['txtSurfacehabSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_surfhab = $quicksearch_array[4];
    }
    
        #surfaceground
    if(empty($quicksearch_array[5]))
    {
        $salesearch_surfground = trim(htmlspecialchars($_POST['txtSurfacegroundSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_surfground = $quicksearch_array[5];
    }
    
        #sleepmin
    if(empty($quicksearch_array[6]))
    {
        $salesearch_sleepmin = trim(htmlspecialchars($_POST['txtNbSleepMinSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_sleepmin = $quicksearch_array[6];
    }
    
        #sleepmax
    if(empty($quicksearch_array[7]))
    {
        $salesearch_sleepmax = trim(htmlspecialchars($_POST['txtNbSleepMaxSaleSearch'], ENT_QUOTES));
    }
    else
    {
        $salesearch_sleepmax = $quicksearch_array[7];
    }
    
        #type object
    if(empty($quicksearch_array[8]))
    {
        $salesearch_typeobject = null;

        for($i = 0, $count = count($salesearch_id_typeobject); $i < $count; $i++)
        {
            if(!empty($_POST['cdreditor_type_objectSaleSearch'.$salesearch_id_typeobject[$i]]))
            {
                if($salesearch_typeobject == null)
                {
                    $salesearch_typeobject = htmlspecialchars($_POST['cdreditor_type_objectSaleSearch'.$salesearch_id_typeobject[$i]], ENT_QUOTES);
                }
                else
                {
                    $salesearch_typeobject .= '$'.htmlspecialchars($_POST['cdreditor_type_objectSaleSearch'.$salesearch_id_typeobject[$i]], ENT_QUOTES);
                }       
            }
        }
    }
    else
    {
        $salesearch_typeobject = $quicksearch_array[8];
    }
    
        #department
    if(empty($quicksearch_array[9]))
    {    
        $salesearch_department = $_POST['cdrgeo_department_situationSaleSearch'];

        if($salesearch_department[0] == 'select')
        {
           unset($salesearch_department); 
        }
    }
    else
    {
        $salesearch_department = $quicksearch_array[9];
    }
    
    if(empty($quicksearch_array[10]))
    {   
        $salesearch_district = null;

        for($i = 0, $count = count($salesearch_id_district); $i < $count; $i++)
        {
            if(!empty($_POST['cdrgeo_district_situation'.$salesearch_id_district[$i]]))
            {
                if($salesearch_district == null)
                {
                    $salesearch_district = htmlspecialchars($_POST['cdrgeo_district_situation'.$salesearch_id_district[$i]], ENT_QUOTES);
                }
                else
                {
                    $salesearch_district .= '$'.htmlspecialchars($_POST['cdrgeo_district_situation'.$salesearch_id_district[$i]], ENT_QUOTES);
                }       
            }
        }
    }
    else
    {
        $salesearch_district = $quicksearch_array[10];
    }
    
    if(empty($quicksearch_array[11]))
    {    
        $salesearch_location = null;

        for($i = 0, $count = count($salesearch_id_location); $i < $count; $i++)
        {
            if(!empty($_POST['cdreditor_location_situationSaleSearch'.$salesearch_id_location[$i]]))
            {
                if($salesearch_location == null)
                {
                    $salesearch_location = htmlspecialchars($_POST['cdreditor_location_situationSaleSearch'.$salesearch_id_location[$i]], ENT_QUOTES);
                }
                else
                {
                    $salesearch_location .= '$'.htmlspecialchars($_POST['cdreditor_location_situationSaleSearch'.$salesearch_id_location[$i]], ENT_QUOTES);
                }       
            }
        }
    }
    else 
    {
        $salesearch_location = $quicksearch_array[11];
    }
      
    if(empty($quicksearch_array[12]))
    {
        $salesearch_condition = null;

        for($i = 0, $count = count($salesearch_id_condition); $i < $count; $i++)
        {
            if(!empty($_POST['cdreditor_condition_objectSaleSearch'.$salesearch_id_condition[$i]]))
            {
                if($salesearch_condition == null)
                {
                    $salesearch_condition = htmlspecialchars($_POST['cdreditor_condition_objectSaleSearch'.$salesearch_id_condition[$i]], ENT_QUOTES);
                }
                else
                {
                    $salesearch_condition .= '$'.htmlspecialchars($_POST['cdreditor_condition_objectSaleSearch'.$salesearch_id_condition[$i]], ENT_QUOTES);
                }       
            }
        }
    }
    else
    {
        $salesearch_condition = $quicksearch_array[12];
    }
    
    $salesearch_orderobject = htmlspecialchars($_POST['cboObjectOrderSaleSearch'], ENT_QUOTES);
    
    if($salesearch_orderobject == 'RAND()')
    {
       $salesearch_orderobject = 'price_product_immo'; 
    }
    
    $salesearch_ordertype = htmlspecialchars($_POST['cboTypeOrderSaleSearch'], ENT_QUOTES);
    $salesearch_orderpage = htmlspecialchars($_POST['cboNrPageOrderSaleSearch'], ENT_QUOTES);
    
    #getinfo conditions    
        #price
    $salesearch_pricemin = str_replace(',', '.', $salesearch_pricemin);
    $salesearch_pricemax = str_replace(',', '.', $salesearch_pricemax);
    
    if(preg_match('#^0#', $salesearch_pricemin))
    {
        $salesearch_pricemin = 0;
    }
    
    if(preg_match('#^0#', $salesearch_pricemax))
    {
        $salesearch_pricemax = 0;
    }
    
    if(!empty($salesearch_pricemax))
    {
        while($salesearch_pricemin > $salesearch_pricemax)
        {
            $salesearch_pricemax .= 0;
        }
    }
    
    if(!is_numeric($salesearch_pricemin) || empty($salesearch_pricemin))
    {
        $salesearch_pricemin = 0;
    }
    
    if(!is_numeric($salesearch_pricemax) || empty($salesearch_pricemax))
    {
        $salesearch_pricemax = 0;
    }
    
    $salesearch_pricemin = number_format($salesearch_pricemin, 0, '.', '');
    $salesearch_pricemax = number_format($salesearch_pricemax, 0, '.', '');
    
        #surface
    if(!is_numeric($salesearch_surfhab) || empty($salesearch_surfhab))
    {
        $salesearch_surfhab = 0;
    }
    
    if(!is_numeric($salesearch_surfground) || empty($salesearch_surfground))
    {
        $salesearch_surfground = 0;
    }
        #sleep
    if(preg_match('#^0#', $salesearch_sleepmin))
    {
        $salesearch_sleepmin = 0;
    }
    
    if(preg_match('#^0#', $salesearch_sleepmax))
    {
        $salesearch_sleepmax = 0;
    }
    
    if(!is_numeric($salesearch_sleepmin) || empty($salesearch_sleepmin))
    {
        $salesearch_sleepmin = 0;
    }
    
    if(!is_numeric($salesearch_sleepmax) || empty($salesearch_sleepmax))
    {
        $salesearch_sleepmax = 0;
    }
    
    if($salesearch_sleepmin > $salesearch_sleepmax)
    {
        $salesearch_sleepmax = 0;
    }
    
    #keepsession
    $_SESSION['SaleSearch_cdreditor_offer_objectSaleSearch'] = $salesearch_offer;
    $_SESSION['SaleSearch_cboCurrencySaleSearch'] = $salesearch_currency;
    $_SESSION['SaleSearch_txtPriceMinSaleSearch'] = $salesearch_pricemin;
    $_SESSION['SaleSearch_txtPriceMaxSaleSearch'] = $salesearch_pricemax;
    $_SESSION['SaleSearch_txtSurfacehabSaleSearch'] = $salesearch_surfhab;
    $_SESSION['SaleSearch_txtSurfacegroundSaleSearch'] = $salesearch_surfground;
    $_SESSION['SaleSearch_txtNbSleepMinSaleSearch'] = $salesearch_sleepmin;
    $_SESSION['SaleSearch_txtNbSleepMaxSaleSearch'] = $salesearch_sleepmax;
    $_SESSION['SaleSearch_cdreditor_type_objectSaleSearch'] = $salesearch_typeobject;
    $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'] = $salesearch_department;
    $_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'] = $salesearch_district;
    $_SESSION['SaleSearch_cdreditor_location_situationSaleSearch'] = $salesearch_location;
    $_SESSION['SaleSearch_cdreditor_condition_objectSaleSearch'] = $salesearch_condition;
    
    $_SESSION['SaleSearch_cboObjectOrderSaleSearch'] = $salesearch_orderobject;
    $_SESSION['SaleSearch_cboTypeOrderSaleSearch'] = $salesearch_ordertype;
    $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] = $salesearch_orderpage;
    
    if(empty($quicksearch_array[9]))
    {
        $salesearch_department = join_string($salesearch_department, '$');
    }
    
    $_SESSION['quicksearch_resultSaleSearch'] = $salesearch_offer.'#'.$salesearch_currency.'#'.
            $salesearch_pricemin.'#'.$salesearch_pricemax.'#'.$salesearch_surfhab.'#'.$salesearch_surfground.'#'.
            $salesearch_sleepmin.'#'.$salesearch_sleepmax.'#'.$salesearch_typeobject.'#'.
            $salesearch_department.'#'.$salesearch_district.'#'.$salesearch_location.'#'.$salesearch_condition.'#'.
            $salesearch_orderobject.'#'.$salesearch_ordertype.'#'.$salesearch_orderpage;
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
