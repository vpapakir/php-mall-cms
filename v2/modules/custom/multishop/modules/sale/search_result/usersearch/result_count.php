<?php
$salesearch_count_result = null;
$salesearch_countotal_result = null;
if(empty($_SESSION['quicksearch_resultSaleSearch']))
{
    #count result without priority and new
    try
    {
        $prepared_query = 'SELECT COUNT(id_product_immo) FROM immo_product
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
            $prepared_query .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
        }
        $prepared_query .= 'ORDER BY RAND()';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $salesearch_count_result = $data[0];
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
    
    #count result with priority and new
    try
    {
        $prepared_query = 'SELECT COUNT(id_product_immo) FROM immo_product
                           INNER JOIN page
                           ON page.id_page = immo_product.id_page
                           WHERE status_page = 1 ';
        if(!empty($_SESSION['SaleSearch_typeoffer']))
        {
            $salesearch_typeoffer = split_string($_SESSION['SaleSearch_typeoffer'], '$');
            $prepared_query .= 'AND offer_product_immo '.$salesearch_typeoffer[1].' '.$salesearch_typeoffer[0].' ';
        }
        $prepared_query .= 'ORDER BY RAND()';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $salesearch_countotal_result = $data[0];
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
    
    $searchrefine_orderby_nrpage = 25;
}
else
{
    $searchrefine_array = $_SESSION['quicksearch_resultSaleSearch'];
    $searchrefine_array = split_string($searchrefine_array, '#');
    
    $searchrefine_array_offer = split_string($searchrefine_array[0], '$');
    $searchrefine_currency = $searchrefine_array[1];
    $searchrefine_pricemin = $searchrefine_array[2];
    $searchrefine_pricemax = $searchrefine_array[3];
    $searchrefine_surfhab = $searchrefine_array[4];
    $searchrefine_surfground = $searchrefine_array[5];
    $searchrefine_sleepmin = $searchrefine_array[6];
    $searchrefine_sleepmax = $searchrefine_array[7];
    $searchrefine_array_typeobject = split_string($searchrefine_array[8], '$');
    $searchrefine_array_department = split_string($searchrefine_array[9], '$');
    $searchrefine_array_district = split_string($searchrefine_array[10], '$');
    $searchrefine_array_location = split_string($searchrefine_array[11], '$');
    $searchrefine_array_condition = split_string($searchrefine_array[12], '$');
    
    $searchrefine_orderby_object = $searchrefine_array[13];
    $searchrefine_orderby_type = $searchrefine_array[14];
    $searchrefine_orderby_nrpage = $searchrefine_array[15];
    
    try
    {
        $prepared_query = 'SELECT shortname_currency FROM currency
                           WHERE id_currency = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $searchrefine_currency);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $searchrefine_currency = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT * FROM currency
                           WHERE priority_currency = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $searchfine_currency = $data[$searchrefine_currency];
        }
        $query->closeCursor();
        
        $searchfine_currency = 1/$searchfine_currency;
        $searchfine_currency = number_format($searchfine_currency, 5, '.', '');
        
        $searchrefine_pricemin = $searchrefine_pricemin * $searchfine_currency;
        $searchrefine_pricemax = $searchrefine_pricemax * $searchfine_currency;
        
        $searchrefine_pricemin = number_format($searchrefine_pricemin, 0, '', '');
        $searchrefine_pricemax = number_format($searchrefine_pricemax, 0, '', '');
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
        

    for($y = 0; $y < 2; $y++)
    {
        $array_countresult_prepared_query[$y] = 'SELECT COUNT(id_product_immo) FROM immo_product
                                               INNER JOIN page
                                               ON page.id_page = immo_product.id_page
                                               WHERE status_page = 1 ';
        
        if($y == 0)
        {
                $array_countresult_prepared_query[$y] .= 'AND comdetails_product_immo <> 93
                                                          AND comdetails_product_immo <> 94
                                                          AND comdetails_product_immo <> 95
                                                          AND comdetails_product_immo <> 86
                                                          AND comdetails_product_immo <> "select" '; 
        }

        #offer
        if($searchrefine_array_offer[0] > 0)
        {
            for($i = 0, $count = count($searchrefine_array_offer); $i < $count; $i++)
            {
                if($i == 0 && $i == ($count - 1))
                {
                    $array_countresult_prepared_query[$y] .= 'AND offer_product_immo = '.$searchrefine_array_offer[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (offer_product_immo = '.$searchrefine_array_offer[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR offer_product_immo = '.$searchrefine_array_offer[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR offer_product_immo = '.$searchrefine_array_offer[$i].' ';
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
               $array_countresult_prepared_query[$y] .= 'AND price_product_immo >= '.$searchrefine_pricemin.' 
                                                        AND price_product_immo <= '.$searchrefine_pricemax.' 
                                                        AND price_product_immo <> 0 '; 
            }
            else
            {
                if(!empty($searchrefine_pricemin) && empty($searchrefine_pricemax))
                {
                    $array_countresult_prepared_query[$y] .= 'AND price_product_immo >= '.$searchrefine_pricemin.' 
                                                              AND price_product_immo <> 0 '; 
                }
                else
                {
                    $array_countresult_prepared_query[$y] .= 'AND price_product_immo <= '.$searchrefine_pricemax.' 
                                                              AND price_product_immo <> 0 '; 
                }
            }
        }

        #surface hab
        if(!empty($searchrefine_surfhab))
        {
            $array_countresult_prepared_query[$y] .= 'AND surfacehab_product_immo >= '.$searchrefine_surfhab.' '; 
        }

        #surface ground
        if(!empty($searchrefine_surfground))
        { 
            $array_countresult_prepared_query[$y] .= 'AND surfacegroundm2_product_immo >= '.$searchrefine_surfground.' '; 
        }

        #sleep
        if($searchrefine_sleepmin > 0 || $searchrefine_sleepmax > 0)
        {
            if(!empty($searchrefine_sleepmin) && !empty($searchrefine_sleepmax))
            {
               $array_countresult_prepared_query[$y] .= 'AND sleepnb_product_immo >= '.$searchrefine_sleepmin.' 
                                            AND sleepnb_product_immo <= '.$searchrefine_sleepmax.' '; 
            }
            else
            {
                if(!empty($searchrefine_sleepmin) && empty($searchrefine_sleepmax))
                { 
                    $array_countresult_prepared_query[$y] .= 'AND sleepnb_product_immo >= '.$searchrefine_sleepmin.' '; 
                }
                else
                { 
                    $array_countresult_prepared_query[$y] .= 'AND sleepnb_product_immo <= '.$searchrefine_sleepmax.' '; 
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
                    $array_countresult_prepared_query[$y] .= 'AND type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR type_product_immo = '.$searchrefine_array_typeobject[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR type_product_immo = '.$searchrefine_array_typeobject[$i].' ';
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
                    $array_countresult_prepared_query[$y] .= 'AND department_product_immo = '.$searchrefine_array_department[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (department_product_immo = '.$searchrefine_array_department[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR department_product_immo = '.$searchrefine_array_department[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR department_product_immo = '.$searchrefine_array_department[$i].' ';
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
                    $array_countresult_prepared_query[$y] .= 'AND district_product_immo = '.$searchrefine_array_district[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (district_product_immo = '.$searchrefine_array_district[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR district_product_immo = '.$searchrefine_array_district[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR district_product_immo = '.$searchrefine_array_district[$i].' ';
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
                    $array_countresult_prepared_query[$y] .= 'AND location_product_immo = '.$searchrefine_array_location[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (location_product_immo = '.$searchrefine_array_location[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR location_product_immo = '.$searchrefine_array_location[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR location_product_immo = '.$searchrefine_array_location[$i].' ';
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
                    $array_countresult_prepared_query[$y] .= 'AND condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                }
                else
                {
                    if($i == 0)
                    {
                        $array_countresult_prepared_query[$y] .= 'AND (condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                    }
                    else
                    {
                        if($i == ($count - 1))
                        {
                            $array_countresult_prepared_query[$y] .= 'OR condition_product_immo = '.$searchrefine_array_condition[$i].') ';
                        }
                        else
                        {
                            $array_countresult_prepared_query[$y] .= 'OR condition_product_immo = '.$searchrefine_array_condition[$i].' ';
                        }
                    }
                }           
            }
        }

        
        try
        {

            $_SESSION['prepared_query'] = $array_countresult_prepared_query[$y];
            $query = $connectData->prepare($array_countresult_prepared_query[$y]);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                if($y == 0)
                {
                    $salesearch_count_result = $data[0];
                }
                else
                {
                    $salesearch_countotal_result = $data[0];
                }
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
    unset($array_countresult_prepared_query);    
}
?>
