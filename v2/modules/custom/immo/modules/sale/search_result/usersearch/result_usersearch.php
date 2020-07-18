<?php


include('modules/custom/immo/modules/sale/search_result/usersearch/result_count.php');

if(empty($searchrefine_orderby_nrpage))
{
    $searchrefine_orderby_nrpage = 25;
}
$paging_resultperpage = $searchrefine_orderby_nrpage;
$paging_page_max = 5;
$paging_countresult = $salesearch_count_result;
include('modules/search/paging/paging_getinfo.php');

if(empty($_SESSION['quicksearch_resultSaleSearch']))
{
    $array_prepared_query[0] = 'SELECT * FROM immo_product
                               INNER JOIN page
                               ON page.id_page = immo_product.id_page
                               WHERE status_page = 1
                               AND comdetails_product_immo = 93 ';
    if(!empty($_SESSION['SaleSearch_typeoffer']))
    {
        $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
        $array_prepared_query[0] .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
    }
    $array_prepared_query[0] .= 'ORDER BY RAND()';

    $array_prepared_query[1] = 'SELECT * FROM immo_product
                               INNER JOIN page
                               ON page.id_page = immo_product.id_page
                               WHERE status_page = 1
                               AND comdetails_product_immo = 94 ';
    if(!empty($_SESSION['SaleSearch_typeoffer']))
    {
        $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
        $array_prepared_query[1] .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
    }
    $array_prepared_query[1] .= 'ORDER BY RAND()';

    $array_prepared_query[2] = 'SELECT * FROM immo_product
                               INNER JOIN page
                               ON page.id_page = immo_product.id_page
                               WHERE status_page = 1
                               AND comdetails_product_immo = 95 ';
    if(!empty($_SESSION['SaleSearch_typeoffer']))
    {
        $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
        $array_prepared_query[2] .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
    }
    $array_prepared_query[2] .= 'ORDER BY RAND()';

    $array_prepared_query[3] = 'SELECT * FROM immo_product
                               INNER JOIN page
                               ON page.id_page = immo_product.id_page
                               WHERE status_page = 1
                               AND (comdetails_product_immo = 86
                               OR comdetails_product_immo = "select") ';
    if(!empty($_SESSION['SaleSearch_typeoffer']))
    {
        $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
        $array_prepared_query[3] .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
    }
    $array_prepared_query[3] .= 'ORDER BY RAND()';
    
    #paging
    $_SESSION['paging_defaultdisplay'] = 'false';

    if(empty($_SESSION['paging_limitmin']))
    {
        $searchrefine_limitmin = 0;
    }
    else
    {
        $searchrefine_limitmin = $_SESSION['paging_limitmin'];
    }

    if(empty($_SESSION['paging_limitmax']))
    {
        $searchrefine_limitmax = $paging_resultperpage;
    }
    else
    {
        $searchrefine_limitmax = $_SESSION['paging_limitmax'];
    }
    #end paging
    
    $array_prepared_query[4] = 'SELECT * FROM immo_product
                               INNER JOIN page
                               ON page.id_page = immo_product.id_page
                               WHERE status_page = 1
                               AND comdetails_product_immo <> 93
                               AND comdetails_product_immo <> 94
                               AND comdetails_product_immo <> 95
                               AND comdetails_product_immo <> 86
                               AND comdetails_product_immo <> "select" ';
    if(!empty($_SESSION['SaleSearch_typeoffer']))
    {
        $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
        $array_prepared_query[4] .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
    }
    $array_prepared_query[4] .= 'ORDER BY RAND() ';
    
    $array_prepared_query[4] .= 'LIMIT '.$searchrefine_limitmin.', '.$searchrefine_limitmax;
}
else
{
    #paging
    $_SESSION['paging_defaultdisplay'] = 'false';

    if(empty($_SESSION['paging_limitmin']))
    {
        $searchrefine_limitmin = 0;
    }
    else
    {
        $searchrefine_limitmin = $_SESSION['paging_limitmin'];
    }

//    if(empty($searchrefine_limitmin) || $searchrefine_limitmin === 0)
//    {
//        $m = 0;
//    }
//    else
//    {
//        $m = 4;      
//    }

    if(empty($_SESSION['paging_limitmax']))
    {
        $searchrefine_limitmax = $paging_resultperpage;
    }
    else
    {
        $searchrefine_limitmax = $_SESSION['paging_limitmax'];
    }
    #end paging
    $m = 0;
    for($y = $m; $y < 5; $y++)
    {
        
    
        $array_prepared_query[$y] = 'SELECT * FROM immo_product
                                   INNER JOIN page
                                   ON page.id_page = immo_product.id_page
                                   WHERE status_page = 1 ';

        switch($y)
        {
            case 0:
               $array_prepared_query[$y] .= 'AND comdetails_product_immo = 93 '; 
               
                break;
            case 1:
               $array_prepared_query[$y] .= 'AND comdetails_product_immo = 94 '; 
               
                break;
            case 2:
               $array_prepared_query[$y] .= 'AND comdetails_product_immo = 95 ';
               
                break;
            case 3:
               $array_prepared_query[$y] .= 'AND (comdetails_product_immo = 86 OR comdetails_product_immo = "select") ';  
                break;
            case 4:
               $array_prepared_query[$y] .= 'AND comdetails_product_immo <> 86 AND comdetails_product_immo <> 93
                                             AND comdetails_product_immo <> 94
                                             AND comdetails_product_immo <> 95 
                                             AND comdetails_product_immo <> "select" ';  
                break;
        }

        #offer
        if($searchrefine_array_offer[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_offer); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND offer_product_immo = '.$searchrefine_array_offer[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (offer_product_immo = '.$searchrefine_array_offer[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR offer_product_immo = '.$searchrefine_array_offer[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR offer_product_immo = '.$searchrefine_array_offer[$i].' ';
                        }
                    }
                }           
            }
        }

        #price
        if($searchrefine_pricemin > 0 || $searchrefine_pricemax > 0)
        {
            if(!empty($searchrefine_pricemin) && !empty($searchrefine_pricemax))
            {
               $array_prepared_query[$y] .= 'AND price_product_immo >= '.$searchrefine_pricemin.' 
                                            AND price_product_immo <= '.$searchrefine_pricemax.' 
                                            AND price_product_immo <> 0 '; 
            }
            else
            {
                if(!empty($searchrefine_pricemin) && empty($searchrefine_pricemax))
                {
                    $array_prepared_query[$y] .= 'AND price_product_immo >= '.$searchrefine_pricemin.' 
                                                  AND price_product_immo <> 0 '; 
                }
                else
                {
                    $array_prepared_query[$y] .= 'AND price_product_immo <= '.$searchrefine_pricemax.' 
                                                  AND price_product_immo <> 0 ';
                }
            }
        }

        #surface hab
        if(!empty($searchrefine_surfhab))
        {
            $array_prepared_query[$y] .= 'AND surfacehab_product_immo >= '.$searchrefine_surfhab.' '; 
        }

        #surface ground
        if(!empty($searchrefine_surfground))
        {
            $array_prepared_query[$y] .= 'AND surfacegroundm2_product_immo >= '.$searchrefine_surfground.' '; 
        }

        #sleep
        if($searchrefine_sleepmin > 0 || $searchrefine_sleepmax > 0)
        {
            if(!empty($searchrefine_sleepmin) && !empty($searchrefine_sleepmax))
            {
               $array_prepared_query[$y] .= 'AND sleepnb_product_immo >= '.$searchrefine_sleepmin.' 
                                            AND sleepnb_product_immo <= '.$searchrefine_sleepmax.' '; 
            }
            else
            {
                if(!empty($searchrefine_sleepmin) && empty($searchrefine_sleepmax))
                {
                    $array_prepared_query[$y] .= 'AND sleepnb_product_immo >= '.$searchrefine_sleepmin.' '; 
                }
                else
                {
                    $array_prepared_query[$y] .= 'AND sleepnb_product_immo <= '.$searchrefine_sleepmax.' ';  
                }
            }
        }

        #object type
        if($searchrefine_array_typeobject[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_typeobject); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR type_product_immo = '.$searchrefine_array_typeobject[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
                        }
                    }
                }           
            }
        }

        #department
        if($searchrefine_array_department[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_department); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND department_product_immo = '.$searchrefine_array_department[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (department_product_immo = '.$searchrefine_array_department[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR department_product_immo = '.$searchrefine_array_department[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR department_product_immo = '.$searchrefine_array_department[$i].' ';
                        }
                    }
                }           
            }
        }

        #district
        if($searchrefine_array_district[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_district); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND district_product_immo = '.$searchrefine_array_district[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (district_product_immo = '.$searchrefine_array_district[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR district_product_immo = '.$searchrefine_array_district[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR district_product_immo = '.$searchrefine_array_district[$i].' ';
                        }
                    }
                }           
            }
        }

        #location
        if($searchrefine_array_location[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_location); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND location_product_immo = '.$searchrefine_array_location[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (location_product_immo = '.$searchrefine_array_location[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR location_product_immo = '.$searchrefine_array_location[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR location_product_immo = '.$searchrefine_array_location[$i].' ';
                        }
                    }
                }           
            }
        }

        #condition
        if($searchrefine_array_condition[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_condition); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_prepared_query[$y] .= 'AND condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_prepared_query[$y] .= 'AND (condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_prepared_query[$y] .= 'OR condition_product_immo = '.$searchrefine_array_condition[$i].') ';
                        }
                        else
                        {
                            $array_prepared_query[$y] .= 'OR condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                        }
                    }
                }           
            }
        }


        if(!empty($searchrefine_orderby_object))
        {
            if($searchrefine_orderby_object == 'RAND()')
            {
                $searchrefine_orderby_type = null;
            }
            $array_prepared_query[$y] .= 'ORDER BY '.$searchrefine_orderby_object.' '.$searchrefine_orderby_type.' ';
        }
        
        if(!empty($searchrefine_limitmax))
        {
            if($y == 4)
            {
                $array_prepared_query[$y] .= 'LIMIT '.$searchrefine_limitmin.', '.$searchrefine_limitmax;
            }
        }
    }  
}
?>

