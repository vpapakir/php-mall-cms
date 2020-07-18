<?php
if(isset($_POST['bt_box_quicksearch']))
{
    $_SESSION['SaleSearch_first_load'] = 'notempty';
    
    #unset session refine
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
    #msg
    $msg_quicksearch_offer = give_translation('immo.msg_quicksearch_offer', 'false', $config_showtranslationcode);
    $msg_quicksearch_price = give_translation('immo.msg_quicksearch_price', 'false', $config_showtranslationcode);
    
    #other
    $quicksearch_bok_goto_page = true;
    $quicksearch_bok_expand_main = false;
    $quicksearch_bok_expand_surface = false;
    $quicksearch_bok_expand_sleep = false;
    $quicksearch_bok_expand_typeobject = false;
    $quicksearch_bok_expand_department = false;
    $quicksearch_bok_expand_location = false;
    $quicksearch_bok_expand_condition = false;
    
    #getinfo
    $quicksearch_offer = null;

    for($p = 0, $countp = count($quicksearch_id_offer); $p < $countp; $p++)
    {
        if(!empty($_POST['cdreditor_offer_objectQuicksearch'.$quicksearch_id_offer[$p]]))
        {
            if($quicksearch_offer == null)
            {
                $quicksearch_offer = htmlspecialchars($_POST['cdreditor_offer_objectQuicksearch'.$quicksearch_id_offer[$p]], ENT_QUOTES);
            }
            else
            {
                $quicksearch_offer .= '$'.htmlspecialchars($_POST['cdreditor_offer_objectQuicksearch'.$quicksearch_id_offer[$p]], ENT_QUOTES);
            }       
        }
    }
    
    $quicksearch_currency = htmlspecialchars($_POST['cboCurrencyQuicksearch'], ENT_QUOTES);
    $quicksearch_pricemin = trim(htmlspecialchars($_POST['txtPriceMinQuicksearch'], ENT_QUOTES));
    $quicksearch_pricemax = trim(htmlspecialchars($_POST['txtPriceMaxQuicksearch'], ENT_QUOTES));
    $quicksearch_surfhab = trim(htmlspecialchars($_POST['txtSurfacehabQuicksearch'], ENT_QUOTES));
    $quicksearch_surfground = trim(htmlspecialchars($_POST['txtSurfacegroundQuicksearch'], ENT_QUOTES));
    $quicksearch_sleepmin = trim(htmlspecialchars($_POST['txtNbSleepMinQuicksearch'], ENT_QUOTES));
    $quicksearch_sleepmax = trim(htmlspecialchars($_POST['txtNbSleepMaxQuicksearch'], ENT_QUOTES));
    
    $quicksearch_typeobject = null;

    for($p = 0, $countp = count($quicksearch_id_typeobject); $p < $countp; $p++)
    {
        if(!empty($_POST['cdreditor_type_objectQuicksearch'.$quicksearch_id_typeobject[$p]]))
        {
            if($quicksearch_typeobject == null)
            {
                $quicksearch_typeobject = htmlspecialchars($_POST['cdreditor_type_objectQuicksearch'.$quicksearch_id_typeobject[$p]], ENT_QUOTES);
                $quicksearch_bok_expand_typeobject = true;
            }
            else
            {
                $quicksearch_typeobject .= '$'.htmlspecialchars($_POST['cdreditor_type_objectQuicksearch'.$quicksearch_id_typeobject[$p]], ENT_QUOTES);
            }       
        }
    }
    
    $quicksearch_department = $_POST['cdrgeo_department_situationQuicksearch'];
    
    if($quicksearch_department[0] == 'select')
    {
       unset($quicksearch_department); 
    }
//    else
//    {   
//        for($p = 0, $countp = count($quicksearch_array_department); $p < $countp; $p++)
//        {
//            if($p == 0)
//            {
//                $quicksearch_department = $quicksearch_array_department[$p];
//            }
//            else
//            {
//                $quicksearch_department .= '$'.$quicksearch_array_department[$p];
//            }
//        }
//    }
   
    
    $quicksearch_location = null;

    for($p = 0, $countp = count($quicksearch_id_location); $p < $countp; $p++)
    {
        if(!empty($_POST['cdreditor_location_situationQuicksearch'.$quicksearch_id_location[$p]]))
        {
            if($quicksearch_location == null)
            {
                $quicksearch_location = htmlspecialchars($_POST['cdreditor_location_situationQuicksearch'.$quicksearch_id_location[$p]], ENT_QUOTES);
                $quicksearch_bok_expand_location = true;
            }
            else
            {
                $quicksearch_location .= '$'.htmlspecialchars($_POST['cdreditor_location_situationQuicksearch'.$quicksearch_id_location[$p]], ENT_QUOTES);
            }       
        }
    }
    
    $quicksearch_condition = null;

    for($p = 0, $countp = count($quicksearch_id_condition); $p < $countp; $p++)
    {
        if(!empty($_POST['cdreditor_condition_objectQuicksearch'.$quicksearch_id_condition[$p]]))
        {
            if($quicksearch_condition == null)
            {
                $quicksearch_condition = htmlspecialchars($_POST['cdreditor_condition_objectQuicksearch'.$quicksearch_id_condition[$p]], ENT_QUOTES);
                $quicksearch_bok_expand_condition = true;
            }
            else
            {
                $quicksearch_condition .= '$'.htmlspecialchars($_POST['cdreditor_condition_objectQuicksearch'.$quicksearch_id_condition[$p]], ENT_QUOTES);
            }       
        }
    }
    
    #getinfo conditions
        #offer
    if(empty($quicksearch_offer))
    {
        $quicksearch_bok_goto_page = false;
        $_SESSION['msg_quicksearch_offer'] = $msg_quicksearch_offer;
    }
    
        #price
    $quicksearch_pricemin = str_replace(',', '.', $quicksearch_pricemin);
    $quicksearch_pricemax = str_replace(',', '.', $quicksearch_pricemax);
    
    if(preg_match('#^0#', $quicksearch_pricemin))
    {
        $quicksearch_pricemin = 0;
    }
    
    if(preg_match('#^0#', $quicksearch_pricemax))
    {
        $quicksearch_pricemax = 0;
    }
    
    if(!empty($quicksearch_pricemax))
    {
        while($quicksearch_pricemin > $quicksearch_pricemax)
        {
            $quicksearch_pricemax .= 0;
        }
    }
    
    if(!is_numeric($quicksearch_pricemin) || empty($quicksearch_pricemin))
    {
        $quicksearch_pricemin = 0;
    }
    
    if(!is_numeric($quicksearch_pricemax) || empty($quicksearch_pricemax))
    {
        $quicksearch_pricemax = 0;
    }
    
    $quicksearch_pricemin = number_format($quicksearch_pricemin, 0, '.', '');
    $quicksearch_pricemax = number_format($quicksearch_pricemax, 0, '.', '');
    
    if(empty($quicksearch_pricemin) && empty($quicksearch_pricemax))
    {
        $quicksearch_bok_goto_page = false;
        $_SESSION['msg_quicksearch_price'] = $msg_quicksearch_price;
    }
    
        #surface
    if(!is_numeric($quicksearch_surfhab) || empty($quicksearch_surfhab))
    {
        $quicksearch_surfhab = 0;
    }
    else
    {
        $quicksearch_bok_expand_main = true;
        $quicksearch_bok_expand_surface = true;
    }
    
    if(!is_numeric($quicksearch_surfground) || empty($quicksearch_surfground))
    {
        $quicksearch_surfground = 0;
    }
    else
    {
        $quicksearch_bok_expand_main = true;
        $quicksearch_bok_expand_surface = true;
    }
        #sleep
    if(preg_match('#^0#', $quicksearch_sleepmin))
    {
        $quicksearch_sleepmin = 0;
    }
    
    if(preg_match('#^0#', $quicksearch_sleepmax))
    {
        $quicksearch_sleepmax = 0;
    }
    
    if(!is_numeric($quicksearch_sleepmin) || empty($quicksearch_sleepmin))
    {
        $quicksearch_sleepmin = 0;
    }
    else
    {
        $quicksearch_bok_expand_main = true;
        $quicksearch_bok_expand_sleep = true;
    }
    
    if(!is_numeric($quicksearch_sleepmax) || empty($quicksearch_sleepmax))
    {
        $quicksearch_sleepmax = 0;
    }
    else
    {
        $quicksearch_bok_expand_main = true;
        $quicksearch_bok_expand_sleep = true;
    }
    
    if($quicksearch_sleepmin > $quicksearch_sleepmax)
    {
        $quicksearch_sleepmax = 0;
    }
    
    if($quicksearch_department[0] != 'select')
    {
        $quicksearch_bok_expand_department = true;
    }
    
    
    #keepsession
    $_SESSION['quicksearch_cdreditor_offer_objectQuicksearch'] = $quicksearch_offer;
    $_SESSION['quicksearch_cboCurrencyQuicksearch'] = $quicksearch_currency;
    $_SESSION['quicksearch_txtPriceMinQuicksearch'] = $quicksearch_pricemin;
    $_SESSION['quicksearch_txtPriceMaxQuicksearch'] = $quicksearch_pricemax;
    $_SESSION['quicksearch_txtSurfacehabQuicksearch'] = $quicksearch_surfhab;
    $_SESSION['quicksearch_txtSurfacegroundQuicksearch'] = $quicksearch_surfground;
    $_SESSION['quicksearch_txtNbSleepMinQuicksearch'] = $quicksearch_sleepmin;
    $_SESSION['quicksearch_txtNbSleepMaxQuicksearch'] = $quicksearch_sleepmax;
    $_SESSION['quicksearch_cdreditor_type_objectQuicksearch'] = $quicksearch_typeobject;
    $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'] = $quicksearch_department;
    $_SESSION['quicksearch_cdreditor_location_situationQuicksearch'] = $quicksearch_location;
    $_SESSION['quicksearch_cdreditor_condition_objectQuicksearch'] = $quicksearch_condition;
    
    $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'] = $quicksearch_department;
    
    $quicksearch_department = join_string($quicksearch_department, '$');
    
    $_SESSION['quicksearch_resultSaleSearch'] = $quicksearch_offer.'#'.$quicksearch_currency.'#'.
            $quicksearch_pricemin.'#'.$quicksearch_pricemax.'#'.$quicksearch_surfhab.'#'.$quicksearch_surfground.'#'.
            $quicksearch_sleepmin.'#'.$quicksearch_sleepmax.'#'.$quicksearch_typeobject.'#'.
            $quicksearch_department.'##'.$quicksearch_location.'#'.$quicksearch_condition.'###';
    
    $_SESSION['quicksearch_done'] = true;
    $_SESSION['quicksearch_resultQuicksearch'] = $_SESSION['quicksearch_resultSaleSearch'];
    
    #expand
    if($quicksearch_bok_expand_main === true)
    {
        $_SESSION['quicksearch_expand_main'] = 'true';
    }
    
    if($quicksearch_bok_expand_surface === true)
    {
        $_SESSION['expand_collapseSurfacehabQuicksearch'] = 'true';
    }
    
    if($quicksearch_bok_expand_sleep === true)
    {
        $_SESSION['expand_collapseNbSleepMinQuicksearch'] = 'true';
    }
    
    if($quicksearch_bok_expand_typeobject === true)
    {
        $_SESSION['expand_collapseTypeobjectQuicksearch'] = 'true';
    }
    
    if($quicksearch_bok_expand_department === true)
    {
        $_SESSION['expand_collapseDepartmentQuicksearch'] = 'true';
    }
    
    if($quicksearch_bok_expand_location === true)
    {
        $_SESSION['expand_collapseLocationQuicksearch'] = 'true';
    }
    
    if($quicksearch_bok_expand_condition === true)
    {
        $_SESSION['expand_collapseConditionQuicksearch'] = 'true';
    }
    
    try
    {
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page.id_page = page_translation.id_page
                           WHERE family_page_translation = "rewritingF"
                           AND url_page = "imos_rent_main"';
        //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $rewritingF_quicksearch = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page.id_page = page_translation.id_page
                           WHERE family_page_translation = "rewritingB"
                           AND url_page = "imos_rent_main"';
        //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $rewritingB_quicksearch = $data[0];
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
    
    if($quicksearch_bok_goto_page === true)
    {
        if($_SESSION['index'] == 'index.php')
        {
            header('Location: '.$config_customheader.$rewritingF_quicksearch);
        }
        else
        {
            header('Location: '.$config_customheader.$rewritingB_quicksearch);
        }
    }
    else
    {
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
?>
