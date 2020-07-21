<?php

function stats_page_checksession($session, $url_page, $allowstatsurl)
{
    if(!empty($allowstatsurl) && $allowstatsurl == 9)
    {
        return false;      
    }
    
    $bok_insertstatspage = true; 
    
    if(empty($_SESSION['stats_page_count']))
    {
        $lastkey = 0;
        $_SESSION['stats_page_count'] = array(0 => $url_page);
        return true;
    }
    else
    {
        $lastkey = count($_SESSION['stats_page_count']);
        for($i = 0, $count = count($_SESSION['stats_page_count']); $i < $count; $i++)
        {
            if($_SESSION['stats_page_count'][$i] == $url_page)
            {
                $bok_insertstatspage = false;
                $i = $count;
            }
        }

        if($bok_insertstatspage === true)
        {
            $_SESSION['stats_page_count'][$lastkey] = $url_page;
            return true;
        } 
        else
        {
            return false;
        }
    }  
}

function give_prioritylangcontent($content, $idpage, $family)
{
    $header = $_SERVER['REQUEST_URI'];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');

    try
    {
        $prepared_query = 'SELECT id_language FROM language
                           WHERE priority_language = 1';
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $function_language_idpriority = $data[0];
        }
        $query->closeCursor();
        
        if(!empty($content))
        {
            $function_language_idpriority = $_SESSION['current_language'];
        }

        $prepared_query = 'SELECT L'.$function_language_idpriority.'
                           FROM page_translation
                           WHERE id_page = :page
                           AND family_page_translation = "'.$family.'"';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('page', $idpage);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $content = $data[0];
        } 

        return $content;
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }   
}

function checkrights($actualrights = 0, $arrayauthrights, $redirection, $excludeSA = true)
{
    $header =  "//";
    
    if(empty($actualrights))
    {
        $actualrights = 0;
    }
    
    if(!empty($excludeSA) && $excludeSA == true)
    {
        $rights_exclude_superad = true;
    }
    else
    {
        $rights_exclude_superad = false;
    }

    if(($arrayauthrights == 'all' || ($actualrights == 9 && $rights_exclude_superad == false)))
    {
        $bok_authorized_rights = true;         
    }
    else
    {
        if(is_numeric($arrayauthrights) && $arrayauthrights >= 0 && $arrayauthrights < 10)
        {
            if($actualrights == $arrayauthrights)
            {
                $bok_authorized_rights = true;         
            }
            else
            {
                $bok_authorized_rights = false;
            }
        }
        else
        {
            $arrayauthrights = split_string($arrayauthrights, ',');

            for($i = 0, $count = count($arrayauthrights); $i < $count; $i++)
            {
                if($arrayauthrights[$i] == $actualrights)
                {
                    $i = $count;
                    $bok_authorized_rights = true;               
                }
                else
                {
                    $bok_authorized_rights = false;
                }
            }
        }
    }
    
    if($bok_authorized_rights === true)
    {
        return true;
    }
    else
    {
        if(!empty($redirection))
        {
            header('Location: '.$header.$redirection);
        }
        else
        {
            return false;
        }
    }
}

function give_randomstr($strsearch, $min, $max, $onlynumber)
{
    $randomstr = null;
    if(empty($strsearch))
    {
        $strsearch = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    
    if(!empty($onlynumber) && $onlynumber == 'true')
    {
        for($i = $min; $i < $max; $i++)
        {
            $randomstr .= rand(0, 9);
        }
    }
    else
    {
        $strarraylength = strlen($strsearch);
        for($i = $min; $i < $max; $i++)
        {
            $randomstr .= $strsearch[rand(0, $strarraylength)];
        }
    }
    
    return $randomstr;
}

function check_date($date)
{
    $bok_date_work = true;
    $date = split_string($date, '-');
    
    switch($date[1])
    {
        case 02:
            if($date[2] > 29)
            {
                $bok_date_work = false;
            }
            break;
            
        case 04:
            if($date[2] > 30)
            {
                $bok_date_work = false;
            }
            break;
            
        case 06:
            if($date[2] > 30)
            {
                $bok_date_work = false;
            }
            break;
            
        case "09":
            if($date[2] > 30)
            {
                $bok_date_work = false;
            }
            break;
          
        case 11:
            if($date[2] > 30)
            {
                $bok_date_work = false;
            }
            break;     
    }
    
    return $bok_date_work;
}

function birthday($day, $month, $year, $sessionday, $sessionmonth, $sessionyear, $yearmin, $yearmax, $language)
{
    if(!empty($day))
    {
        echo('<select name="'.$day.'">
                        <option value="select" ');
        if(empty($sessionday) || $sessionday == 'select')
        {
            echo('selected="selected"');
        }
        echo('>'); 
        give_translation('main.dd_day', $echo, $config_showtranslationcode); 
        echo('</option>');

        for($i = 1; $i <= 31; $i++)
        {
            if($i < 10)
            {

                echo('<option value="0'.$i.'" ');
                if(!empty($sessionday) && $sessionday == $i)
                {
                    echo('selected="selected"');
                }
                echo('>0'.$i.'</option>');

            }
            else
            {

                echo('<option value="'.$i.'" ');
                if(!empty($sessionday) && $sessionday == $i)
                {
                    echo('selected="selected"');
                }
                echo('>'.$i.'</option>');

            }
        }

        echo('</select>');
    }
    
    if(!empty($month))
    {
        echo('&nbsp;');            
        echo('<select name="'.$month.'">
            <option value="select" ');
        if(empty($sessionmonth) || $sessionmonth == 'select')
        {
            echo('selected="selected"');
        }
        echo('>'); 
        give_translation('main.dd_month', $echo, $config_showtranslationcode);
        echo('</option>');

        for($i = 1; $i <= 12; $i++)
        {
            if($i < 10)
            {

                echo('<option value="0'.$i.'" ');
                if(!empty($sessionmonth) && $sessionmonth == $i)
                {
                    echo('selected="selected"');
                }
                echo('>0'.$i.'</option>');

            }
            else
            {

                echo('<option value="'.$i.'" ');
                if(!empty($sessionmonth) && $sessionmonth == $i)
                {
                    echo('selected="selected"');
                }
                echo('>'.$i.'</option>');

            }
        }

        echo('</select>');
    }
    
    if(!empty($year))
    {
        echo('&nbsp;');
        echo('<select name="'.$year.'">
            <option value="select" ');
        if(empty($sessionyear) || $sessionyear == 'select')
        {
            echo('selected="selected"');
        }
        echo('>');
        give_translation('main.dd_year', $echo, $config_showtranslationcode);
        echo('</option>');

        for($i = $yearmax; $i >= $yearmin; $i--)
        {

            echo('<option value="'.$i.'" ');
            if(!empty($sessionyear) && $sessionyear == $i)
                {
                    echo('selected="selected"');
                }
            echo('>'.$i.'</option>');

        }

        echo('</select>');
    }
}

function paging_number_page($result, $limit_by_page)
{
    if($result == $limit_by_page)
    {
        $page_number = 0;
    }
    else
    {
        if($result == ($limit_by_page + 1))
        {
            $page_number = 1.1;
        }
        else
        {
            $page_number = $result / $limit_by_page;
        }
    }
    $page_number = number_format($page_number, 1, '.', '');

    if(!preg_match('#.0$#', $page_number))
    {
       $page_number++;
    }

    $page_number = preg_replace('#.[0-9]$#', '', $page_number);
    
    return $page_number;
}

function givePagePathImage($id_page, $pathcolumn, $noimagetype)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    try
    {
        $prepared_query = 'SELECT *
                           FROM page_image
                           WHERE id_page = :id
                           AND position_image = 1';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_page);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $pagepathimage_result = $data[$pathcolumn];
            $pagealtimage_result = $data['alt_image'];
        }
        else
        {
            if(empty($noimagetype))
            {
               $noimagetype = 'original'; 
            }
            $pagepathimage_result = 'images/noimage/product/'.$noimagetype.'/noimage.gif';
            $pagealtimage_result = 'noimage.gif';
        }
        $query->closeCursor();
        
        $pageimage_result = array(0 => $pagepathimage_result, 1 => $pagealtimage_result);
        
        return $pageimage_result; 
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
}

function giveCDRvalue($id_cdr, $typecdr, $current_language)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    if($typecdr == 'cdreditor')
    {
        $langsuffix = 'S';
    }
    else
    {
        $langsuffix = null;
    }
    
    try
    {
        $prepared_query = 'SELECT L'.$current_language.$langsuffix.'
                           FROM '.$typecdr.'
                           WHERE id_'.$typecdr.' = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_cdr);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $cdr_result = $data[0];
        }
        $query->closeCursor();
        
        return $cdr_result; 
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
}

function givePageTranslation($id_page, $family, $current_language)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    try
    {
        $prepared_query = 'SELECT L'.$current_language.'
                           FROM page_translation
                           WHERE id_page = :id
                           AND family_page_translation = :family';
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'id' => $id_page,
                              'family' => $family
                              ));

        if(($data = $query->fetch()) != false)
        {
            $pagetranslation_result = $data[0];
        }
        $query->closeCursor();
        
        return $pagetranslation_result; 
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
}

#22 options
function cdrgeo($type, $valueP, $code, $status, $id, $selected, $isfirstoption, $insertinput, $zipcode, $js, $inputstyle, $inputtype, $inputname, $inputother, $inputsession, $quicksearch, $chknrtd, $displaydecimal, $sizemulti, $showresult, $datacolumn, $dataoperator)
{
    if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
    {
        $header = ["REQUEST_URI"];
        $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
        $main_customfolder = 'immo';
        include('modules/dbconnect/dinxdev/dbconnect.php');
    }
    
    $count_id_product = null;
    
    switch ($type)
    {
        case 'dropdown':
            
//            echo('<td>');
//            echo('<table width="100%" cellpadding="0" cellspacing="0" border="1">');
            
            if(!empty($insertinput))
            {
                echo($insertinput.'&nbsp;');
            }
            
            if($isfirstoption == false)
            { 
                $x = 0;
                echo('<select name="'.$code.'">');
                echo('<option value="select" ');

                if(empty($selected) || $selected == 'select')
                {
                    echo('selected="selected"');
                }
                else
                {
                    echo(null);
                }

                echo(' >'.give_translation('cdreditor.main_dd_select', 'false').'</option>');
            }
            else
            {
                $x = 1;
                echo('<select name="'.$code.'" '.$js.'>');
                echo('<option value="'.$id[0].'" ');

                if(empty($selected) || $selected == $id[0])
                {
                    echo('selected="selected"');
                }
                else
                {
                    echo(null);
                }
                
                if(!empty($zipcode[0]))
                {
                    echo(' >'.$valueP[0].' ('.$zipcode[0].')</option>');
                }
                else
                {
                    echo(' >'.$valueP[0].'</option>');
                }
            }
            
            for($i = $x, $counti = count($valueP); $i < $counti; $i++)
            {
                if($status[$i] == 1)
                {
                    echo('<option value="'.$id[$i].'" ');

                    if(!empty($selected) && $selected == $id[$i])
                    {
                        echo('selected="selected"');
                    }
                    else
                    {
                        echo(null);
                    }

                    if(!empty($zipcode[$i]))
                    {
                        echo(' >'.$valueP[$i].' ('.$zipcode[$i].')</option>');
                    }
                    else
                    {
                        echo(' >'.$valueP[$i].'</option>');
                    }
                }
            }
            
            echo('</select>');

//            echo('</table>');
//            echo('</td>');
            echo('&nbsp;');
            
            break;
            
       case 'multi':
           
            if(empty($sizemulti))
            {
                $sizemulti = 5;
            }
           
            if(!empty($insertinput))
            {
                echo($insertinput.'&nbsp;');
            }
            
            if($isfirstoption == false)
            { 
                $x = 0;
                echo('<select name="'.$code.'[]" multiple="multiple" size="'.$sizemulti.'">');
                echo('<option value="select" ');
                
                for($z = 0, $countz = count($selected); $z < $countz; $z++)
                {
                    if(empty($selected[$z]) || $selected[$z] == 'select')
                    {
                        echo('selected="selected"');
                    }
                    else
                    {
                        echo(null);
                    }
                }
                
                

                echo(' >'.give_translation('cdreditor.main_dd_select', 'false').'</option>');
            }
            else
            {
                if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                {
                    try
                    {
                        $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                           FROM product_'.$main_customfolder.'
                                           INNER JOIN page
                                           ON page.id_page = product_'.$main_customfolder.'.id_page
                                           WHERE status_page = 1
                                           AND '.$datacolumn.' '.$dataoperator.' :value';
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('value', $id[0]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            if($data[0] > 0)
                            {
                                $count_id_product = ' ('.$data[0].')';
                            }
                            else
                            {
                                $count_id_product = null;
                            }
                        }
                        $query->closeCursor();
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                
                
                $x = 1;
                if(!empty($count_id_product) || empty($showresult) || empty($datacolumn) || empty($dataoperator))
                {
                    echo('<select name="'.$code.'" '.$js.'>');
                    echo('<option value="'.$id[0].'" ');

                    for($z = 0, $countz = count($selected); $z < $countz; $z++)
                    {
                        if(empty($selected[$z]) || $selected[$z] == $id[0])
                        {
                            echo('selected="selected"');
                        }
                        else
                        {
                            echo(null);
                        }
                    }

                    if(!empty($zipcode[0]))
                    {
                        echo(' >'.$valueP[0].' ('.$zipcode[0].')'.$count_id_product.'</option>');
                    }
                    else
                    {
                        echo(' >'.$valueP[0].$count_id_product.'</option>');
                    }
                }
            }
            
            for($i = $x, $counti = count($valueP); $i < $counti; $i++)
            {
                if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                {
                    try
                    {
                        $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                           FROM product_'.$main_customfolder.'
                                           INNER JOIN page
                                           ON page.id_page = product_'.$main_customfolder.'.id_page
                                           WHERE status_page = 1
                                           AND '.$datacolumn.' '.$dataoperator.' :value';
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('value', $id[$i]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            if($data[0] > 0)
                            {
                                $count_id_product = ' ('.$data[0].')';
                            }
                            else
                            {
                                $count_id_product = null;
                            }
                        }
                        $query->closeCursor();
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                
                if(($status[$i] == 1 && !empty($count_id_product)) || empty($showresult) || empty($datacolumn) || empty($dataoperator))
                {
                    echo('<option value="'.$id[$i].'" ');

                    for($z = 0, $countz = count($selected); $z < $countz; $z++)
                    {
                        if(!empty($selected[$z]) && $selected[$z] == $id[$i])
                        {
                            echo('selected="selected"');
                        }
                        else
                        {
                            echo(null);
                        }
                    }
                    
                    if(!empty($zipcode[$i]))
                    {
                        echo(' >'.$valueP[$i].' ('.$zipcode[$i].')'.$count_id_product.'</option>');
                    }
                    else
                    {
                        echo(' >'.$valueP[$i].$count_id_product.'</option>');
                    }
                }
            }
            
            echo('</select>');

//            echo('</table>');
//            echo('</td>');
            echo('&nbsp;');
           
            break;
            
       case 'checkbox':
           
            if(empty($chknrtd) || $chknrtd == 0)
            {
                $chknrtd = 2;
                $totaloptions = count($valueP);
                $totaloptions_part1 = number_format($totaloptions/$chknrtd, 0, '.', '');
                $width = 100/$chknrtd;
                $width = number_format($width, 0, '.', '');
            }
            else
            {
                if(empty($displaydecimal))
                {
                    $displaydecimal = 0;
                }
                    
                $totaloptions = count($valueP);
                $totaloptions_part1 = $totaloptions/$chknrtd;
                if(preg_match('#.[0-9]{1,}$#', $totaloptions_part1))
                {
                    $decimal = preg_replace('#^[0-9]{1,}.#', '0.', $totaloptions_part1);
                    $decimal = $decimal * $chknrtd;
                    $decimal = round($decimal, 0);
                }
                else
                {
                    $decimal = 0;
                }
                $width = 100/$chknrtd;
                $width = round($width, 0, PHP_ROUND_HALF_EVEN);
                
                $totaloptions_part1 = number_format($totaloptions_part1, 0, '.', '');
            }
            
            $selected = split_string($selected, '$');
            
            $style = null;
            $type = null;
            $name = null;
            $other = null;
            $input = null;
            $inputsession = split_string($inputsession, '$');
           
            if(empty($quicksearch) || $quicksearch == 'false')
            {
                echo('<table width="100%" cellpadding="0" cellspacing="0" border="0">');
                echo('<tr>');
                $z = 0;
                for($x = 0, $countx = $chknrtd; $x < $countx; $x++)
                {
                    echo('<td width="'.$width.'%" style="vertical-align: top;">');                 
                    echo('<table width="100%" cellpadding="0" cellspacing="1">');

                    if($x == $displaydecimal && $decimal > 0)
                    {
                        $totaloptions_part1 += $decimal;
                        $totaloptions_part1 = number_format($totaloptions_part1, 0, '.', '');
                    }

                    for($i = $z, $counti = $totaloptions_part1; $i < $counti; $i++)
                    {
                        if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                        {
                            try
                            {
                                $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                                   FROM product_'.$main_customfolder.'
                                                   INNER JOIN page
                                                   ON page.id_page = product_'.$main_customfolder.'.id_page
                                                   WHERE status_page = 1
                                                   AND '.$datacolumn.' '.$dataoperator.' :value';
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('value', $id[$i]);
                                $query->execute();

                                if(($data = $query->fetch()) != false)
                                {
                                    if($data[0] > 0)
                                    {
                                        $count_id_product = ' ('.$data[0].')';
                                    }
                                    else
                                    {
                                        $count_id_product = null;
                                    }
                                }
                                $query->closeCursor();
                            }
                            catch(Exception $e)
                            {
                                $_SESSION['error400_message'] = $e->getMessage();
                                if($_SESSION['index'] == 'index.php')
                                {
                                    die(header('Location: '.$header.'Error/400'));
                                }
                                else
                                {
                                    die(header('Location: '.$header.'Backoffice/Error/400'));
                                } 
                            }
                        }
                        
                        if(($status[$i] == 1 && !empty($count_id_product)) || empty($showresult) || empty($datacolumn) || empty($dataoperator))
                        {
                            echo('<tr>
                                    <td>'); 

                            echo('<input type="checkbox" id="'.$code.$id[$i].'" name="'.$code.$id[$i].'" value="'.$id[$i].'" ');

                            for($y = 0, $county = count($selected); $y < $county; $y++)
                            {
                                if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                {
                                    echo('checked="checked"');
                                }
                                else
                                {
                                    echo(null);
                                }
                            }

                            echo(' />');
                            
                            echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.$valueP[$i].$count_id_product.'</span></label>');

                            echo('</td>');

                            if(!empty($insertinput) && $insertinput != true)
                            {
                                echo('<td>');
                                echo('&nbsp;'.$insertinput);
                                echo('</td>');
                            }
                            else
                            {
                                if($insertinput == true)
                                {
                                    $input = '<input ';

                                    if(!empty($inputstyle))
                                    {
                                        $style = 'style="'.$inputstyle.'"';
                                    }

                                    if(!empty($inputtype))
                                    {
                                        $type = ' type="'.$inputtype.'"';
                                    }
                                    else
                                    {
                                        $type = ' type="text"';
                                    }

                                    if(!empty($inputname))
                                    {
                                        $name = ' name="'.$inputname.'"';
                                    }
                                    else
                                    {
                                        $name = ' name="txt'.$code.$id[$i].'"';
                                    }

                                    if(!empty($inputother))
                                    {
                                        $other = $inputother;
                                    }
                                    else
                                    {
                                        $other = ' />';
                                    }

                                    $input .= $style.$type.$name;

                                    if(!empty($inputsession[$i]))
                                    {
                                       $value = ' value="'.$inputsession[$i].'"';                           
                                    }
                                    else
                                    {
                                       $value = null;
                                    }

                                    $input .= $value.$other;

                                    echo('<td>');
                                    echo('&nbsp;'.$input);
                                    echo('</td>');
                                }
                            }   

                            echo('</tr>');
                        }



                        if($i == ($totaloptions_part1 - 1))
                        {
                            $totaloptions_part1 += $totaloptions_part1;
                            $i = $totaloptions_part1;
                        }

                        $z++;
                    }

                    echo('</table>');
                    echo('</td>'); 
                }
                
                echo('</tr>');
                //echo('<tr><td>'.var_dump($selected).'</td></tr>');
                echo('</table>');
            }
            else
            {
                for($i = 0, $y = 0, $counti = $totaloptions; $i < $counti; $i++, $y++)
                {
                    if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                    {
                        try
                        {
                            $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                               FROM product_'.$main_customfolder.'
                                               INNER JOIN page
                                               ON page.id_page = product_'.$main_customfolder.'.id_page
                                               WHERE status_page = 1
                                               AND '.$datacolumn.' '.$dataoperator.' :value';
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('value', $id[$i]);
                            $query->execute();

                            if(($data = $query->fetch()) != false)
                            {
                                if($data[0] > 0)
                                {
                                    $count_id_product = ' ('.$data[0].')';
                                }
                                else
                                {
                                    $count_id_product = null;
                                }
                            }
                            $query->closeCursor();
                        }
                        catch(Exception $e)
                        {
                            $_SESSION['error400_message'] = $e->getMessage();
                            if($_SESSION['index'] == 'index.php')
                            {
                                die(header('Location: '.$header.'Error/400'));
                            }
                            else
                            {
                                die(header('Location: '.$header.'Backoffice/Error/400'));
                            } 
                        }
                    }
                    
                    if(($status[$i] == 1 && !empty($count_id_product)) || empty($showresult) || empty($datacolumn) || empty($dataoperator))
                    {
                        echo('<input type="checkbox" id="'.$code.$id[$i].'" name="'.$code.$id[$i].'" value="'.$id[$i].'" ');

                        for($y = 0, $county = count($selected); $y < $county; $y++)
                        {
                            if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                            {
                                echo('checked="checked"');
                            }
                            else
                            {
                                echo(null);
                            }
                        }

                        echo(' />');
                        echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.$valueP[$i].$count_id_product.'</span></label>');

                        if(!empty($insertinput) && $insertinput != true)
                        {
                            echo('&nbsp;'.$insertinput);
                        }
                        else
                        {
                            if($insertinput == true)
                            {
                                $input = '<input ';

                                if(!empty($inputstyle))
                                {
                                    $style = 'style="'.$inputstyle.'"';
                                }

                                if(!empty($inputtype))
                                {
                                    $type = ' type="'.$inputtype.'"';
                                }
                                else
                                {
                                    $type = ' type="text"';
                                }

                                if(!empty($inputname))
                                {
                                    $name = ' name="'.$inputname.'"';
                                }
                                else
                                {
                                    $name = ' name="txt'.$code.$id[$i].'"';
                                }

                                if(!empty($inputother))
                                {
                                    $other = $inputother;
                                }
                                else
                                {
                                    $other = ' />';
                                }

                                $input .= $style.$type.$name;

                                if(!empty($inputsession[$i]))
                                {
                                   $value = ' value="'.$inputsession[$i].'"';                           
                                }
                                else
                                {
                                   $value = null;
                                }

                                $input .= $value.$other;
                                echo('&nbsp;'.$input);
                            }
                        }   
                        echo('<br clear="left"/>');    
                    }
                }
            }
//            echo('</td>');
            
            break;     
    }
}

#28 options          1       2       3       4       5      6             7             8             9          10           11           12           13               14         15        16               17           18            19            20          21            22         23    24            25         26          27              28
function cdreditor($type, $valueP, $code, $status, $id, $selected, $isfirstoption, $insertinput, $inputstyle, $inputtype, $inputname, $inputother, $inputsession, $quicksearch, $chknrtd, $displaydecimal, $showresult, $datacolumn, $dataoperator, $cutstring, $cutcount, $cutpunctuation, $js, $fontclass, $fontstyle, $addinput, $codeaddinput, $sessionaddinput)
{
    if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
    {
        $header = ["REQUEST_URI"];
        $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
        $main_customfolder = 'immo';
        include('modules/dbconnect/dinxdev/dbconnect.php');
    }
    
    if(empty($fontclass) ? $fontclass = 'font_main' : $fontclass = $fontclass)   
    $count_id_product = null;
    
    switch ($type)
    {
        case 'dropdown':
            
//            echo('<td>');
//            echo('<table width="100%" cellpadding="0" cellspacing="0" border="1">');
            
            if(!empty($insertinput) && $insertinput == 'true')
            {
                //echo($insertinput.'&nbsp;');
            }
            
            if($isfirstoption == false)
            { 
                $x = 0;
                echo('<select id="'.$code.'" name='.$code.' ');
                if(!empty($js))
                {
                    echo($js);
                }
                echo('>');
                echo('<option value="select" ');

                if(empty($selected) || $selected == 'select')
                {
                    echo('selected="selected"');
                }
                else
                {
                    echo(null);
                }

                echo(' >'.give_translation('cdreditor.main_dd_select', 'false').'</option>');
            }
            else
            {
                if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                {
                    try
                    {
                        $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                           FROM product_'.$main_customfolder.'
                                           INNER JOIN page
                                           ON page.id_page = product_'.$main_customfolder.'.id_page
                                           WHERE status_page = 1
                                           AND '.$datacolumn.' '.$dataoperator.' :value';
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('value', $id[0]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            if($data[0] > 0)
                            {
                                $count_id_product = ' ('.$data[0].')';
                            }
                            else
                            {
                                $count_id_product = null;
                            }
                        }
                        $query->closeCursor();
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }                       
                }
                $x = 1;
                
                if(!empty($count_id_product) || empty($showresult) || empty($datacolumn) || empty($dataoperator))
                {
                    echo('<select name='.$code.'>');
                    echo('<option value="'.$id[0].'" ');

                    if(empty($selected) || $selected == $id[0])
                    {
                        echo('selected="selected"');
                    }
                    else
                    {
                        echo(null);
                    }
                    
                    if(!empty($cutstring) && $cutstring == 'true')
                    {
                        echo(' title="'.$valueP[0].'">'.cut_string($valueP[0], 0 , $cutcount, $cutpunctuation).$count_id_product.'</option>');
                    }
                    else
                    {
                        echo(' title="'.$valueP[0].'">'.$valueP[0].$count_id_product.'</option>');
                    }
                }
            }
            
            for($i = $x, $counti = count($valueP); $i < $counti; $i++)
            {
                if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                {
                    try
                    {
                        $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                           FROM product_'.$main_customfolder.'
                                           INNER JOIN page
                                           ON page.id_page = product_'.$main_customfolder.'.id_page
                                           WHERE status_page = 1
                                           AND '.$datacolumn.' '.$dataoperator.' :value';
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('value', $id[$i]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {
                            if($data[0] > 0)
                            {
                                $count_id_product = ' ('.$data[0].')';
                            }
                            else
                            {
                                $count_id_product = null;
                            }
                        }
                        $query->closeCursor();
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                
                if(($status[$i] == 1 && !empty($count_id_product)) || ($status[$i] == 1 && empty($showresult)) || ($status[$i] == 1 && empty($datacolumn)) || ($status[$i] == 1 && empty($dataoperator)))
                {
                    echo('<option value="'.$id[$i].'" ');

                    if(!empty($selected) && $selected == $id[$i])
                    {
                        echo('selected="selected"');
                    }
                    else
                    {
                        echo(null);
                    }
                    
                    if(!empty($cutstring) && $cutstring == 'true')
                    {
                        echo(' title="'.$valueP[$i].'">'.cut_string($valueP[$i], 0 , $cutcount, $cutpunctuation).$count_id_product.'</option>');
                    }
                    else
                    {
                        echo(' title="'.$valueP[$i].'">'.$valueP[$i].$count_id_product.'</option>');
                    }
                }
            }
            
            echo('</select>');

//            echo('</table>');
//            echo('</td>');
            echo('&nbsp;');
            
            break;
            
       case 'checkbox':
      
            if(empty($chknrtd) || $chknrtd == 0)
            {
//                $chknrtd = 2;
//                $totaloptions = count($valueP);
//                $totaloptions_part1 = number_format($totaloptions/$chknrtd, 0, '.', '');
//                $width = 100/$chknrtd;
//                $width = number_format($width, 0, '.', '');
                $chknrtd = 1;
                $totaloptions = count($valueP);
                $totaloptions_part1 = number_format($totaloptions, 0, '.', '');
                $width = 100;
                $width = number_format($width, 0, '.', '');
            }
            else
            {
                if(empty($displaydecimal))
                {
                    $displaydecimal = 0;
                }
                    
                $totaloptions = count($valueP);
                $totaloptions_part1 = $totaloptions/$chknrtd;
                if(preg_match('#.[0-9]{1,}$#', $totaloptions_part1))
                {
                    $decimal = preg_replace('#^[0-9]{1,}.#', '0.', $totaloptions_part1);
                    $decimal = $decimal * $chknrtd;
                    $decimal = round($decimal, 0);
                }
                else
                {
                    $decimal = 0;
                }
                $width = 100/$chknrtd;
                $width = round($width, 0, PHP_ROUND_HALF_EVEN);
                
                $totaloptions_part1 = number_format($totaloptions_part1, 0, '.', '');
            }
            
            $selected = split_string($selected, '$');
            
            $style = null;
            $type = null;
            $name = null;
            $other = null;
            $input = null;
            $inputsession = split_string($inputsession, '$');
           
            if(empty($quicksearch) || $quicksearch == 'false')
            {
                echo('<table width="100%" cellpadding="0" cellspacing="0" border="0">');
                //echo('<tr><td>'.var_dump($totaloptions_part1).'</td></tr>');
                echo('<tr>');
                $z = 0;
                for($x = 0, $countx = $chknrtd; $x < $countx; $x++)
                {
                    echo('<td width="'.$width.'%" style="vertical-align: top;">');
                    echo('<table width="100%" cellpadding="0" cellspacing="1" class="'.$fontclass.'" style="'.$fontstyle.'">');

                    if($x == $displaydecimal && $decimal > 0)
                    {
                        $totaloptions_part1 += $decimal;
                        $totaloptions_part1 = number_format($totaloptions_part1, 0, '.', '');
                    }

                    for($i = $z, $counti = $totaloptions_part1; $i < $counti; $i++)
                    {
                        if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                        {
                            try
                            {
                                $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                                   FROM product_'.$main_customfolder.'
                                                   INNER JOIN page
                                                   ON page.id_page = product_'.$main_customfolder.'.id_page
                                                   WHERE status_page = 1
                                                   AND '.$datacolumn.' '.$dataoperator.' :value';
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('value', $id[$i]);
                                $query->execute();

                                if(($data = $query->fetch()) != false)
                                {
                                    if($data[0] > 0)
                                    {
                                        $count_id_product = ' ('.$data[0].')';
                                    }
                                    else
                                    {
                                        $count_id_product = null;
                                    }
                                }
                                $query->closeCursor();
                            }
                            catch(Exception $e)
                            {
                                $_SESSION['error400_message'] = $e->getMessage();
                                if($_SESSION['index'] == 'index.php')
                                {
                                    die(header('Location: '.$header.'Error/400'));
                                }
                                else
                                {
                                    die(header('Location: '.$header.'Backoffice/Error/400'));
                                } 
                            }
                        }
                        
                        if(($status[$i] == 1 && !empty($count_id_product)) || ($status[$i] == 1 && empty($showresult)) || ($status[$i] == 1 && empty($datacolumn)) || ($status[$i] == 1 && empty($dataoperator)))
                        {
                            echo('<tr>
                                    <td>'); 

                            echo('<input type="checkbox" id="'.$code.$id[$i].'" name="'.$code.$id[$i].'" value="'.$id[$i].'" ');

                            for($y = 0, $county = count($selected); $y < $county; $y++)
                            {
                                if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                {
                                    echo('checked="checked"');
                                }
                                else
                                {
                                    echo(null);
                                }
                            }

                            echo(' />');
                            if(!empty($cutstring) && $cutstring == 'true')
                            {
                                echo('<label for="'.$code.$id[$i].'" title="'.$valueP[$i].'"><span class="'.$fontclass.'" style="margin-left: 2px; cursor: pointer; '.$fontstyle.'">'.cut_string($valueP[$i], 0 , $cutcount, $cutpunctuation).$count_id_product.'</span></label>');
                            }
                            else
                            {
                                echo('<label for="'.$code.$id[$i].'"><span class="'.$fontclass.'" style="margin-left: 2px; cursor: pointer; '.$fontstyle.'">'.$valueP[$i].$count_id_product.'</span></label>');
                            }
                            echo('</td>');

                            if(!empty($insertinput) && $insertinput != true)
                            {
                                echo('<td>');
                                echo('&nbsp;'.$insertinput);
                                echo('</td>');
                            }
                            else
                            {
                                if($insertinput == true)
                                {
                                    $input = '<input ';

                                    if(!empty($inputstyle))
                                    {
                                        $style = 'style="'.$inputstyle.'"';
                                    }

                                    if(!empty($inputtype))
                                    {
                                        $type = ' type="'.$inputtype.'"';
                                    }
                                    else
                                    {
                                        $type = ' type="text"';
                                    }

                                    if(!empty($inputname))
                                    {
                                        $name = ' name="'.$inputname.'"';
                                    }
                                    else
                                    {
                                        $name = ' name="txt'.$code.$id[$i].'"';
                                    }

                                    if(!empty($inputother))
                                    {
                                        $other = $inputother;
                                    }
                                    else
                                    {
                                        $other = ' />';
                                    }

                                    $input .= $style.$type.$name;

                                    for($y = 0, $county = count($selected); $y < $county; $y++)
                                    {
                                       if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                       {
                                           if(empty($inputsession[$y]))
                                           {
                                               $inputsession[$y] = null;
                                           }
                                           $value = ' value="'.$inputsession[$y].'"'; 
                                           $y = count($selected);
                                       }
                                       else
                                       {
                                           $value = null;
                                       }
                                    }

                                    $input .= $value.$other;

                                    echo('<td>');
                                    echo('&nbsp;'.$input);
                                    echo('</td>');
                                } 
                            }  
                            
                            if(!empty($addinput) && $addinput == 'true' && !empty($codeaddinput))
                            {
                                $echocodeaddinput = null;
                                $echocodeaddinput = str_replace('[#nameindex]', $id[$i], $codeaddinput);
                                for($y = 0, $county = count($selected); $y < $county; $y++)
                                {
                                    if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                    {
                                        if(empty($sessionaddinput[$y]))
                                        {
                                            $sessionaddinput[$y] = null;
                                        }
                                        $echocodeaddinput .= ' value="'.$sessionaddinput[$y].'"';  
                                        $y = count($selected);
                                    }
                                    else
                                    {
                                        $echocodeaddinput .= '';
                                    }
                                }
                                $echocodeaddinput .= '/>';

                                echo('<td>');
                                echo('&nbsp;'.$echocodeaddinput);
                                echo('</td>');
                            }
                            echo('</tr>');
                        }



                        if($i == ($totaloptions_part1 - 1))
                        {
                            $totaloptions_part1 += $totaloptions_part1;
                            $i = $totaloptions_part1;
                        }

                        $z++;
                    }

                    echo('</table>');
                    echo('</td>'); 
                }
                
                echo('</tr>');
                //echo('<tr><td>'.var_dump($selected).'</td></tr>');
                echo('</table>');               
            }
            else
            {
                for($i = 0, $y = 0, $counti = $totaloptions; $i < $counti; $i++, $y++)
                {
                    if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
                    {
                        try
                        {
                            $prepared_query = 'SELECT COUNT(id_product_'.$main_customfolder.')
                                               FROM product_'.$main_customfolder.'
                                               INNER JOIN page
                                               ON page.id_page = product_'.$main_customfolder.'.id_page
                                               WHERE status_page = 1
                                               AND '.$datacolumn.' '.$dataoperator.' :value';
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('value', $id[$i]);
                            $query->execute();

                            if(($data = $query->fetch()) != false)
                            {
                                if($data[0] > 0)
                                {
                                    $count_id_product = ' ('.$data[0].')';
                                }
                                else
                                {
                                    $count_id_product = null;
                                }
                            }
                            $query->closeCursor();
                        }
                        catch(Exception $e)
                        {
                            $_SESSION['error400_message'] = $e->getMessage();
                            if($_SESSION['index'] == 'index.php')
                            {
                                die(header('Location: '.$header.'Error/400'));
                            }
                            else
                            {
                                die(header('Location: '.$header.'Backoffice/Error/400'));
                            } 
                        }
                    }
                    
                    if(($status[$i] == 1 && !empty($count_id_product)) || ($status[$i] == 1 && empty($showresult)) || ($status[$i] == 1 && empty($datacolumn)) || ($status[$i] == 1 && empty($dataoperator)))
                    {
                        echo('<input type="checkbox" id="'.$code.$id[$i].'" name="'.$code.$id[$i].'" value="'.$id[$i].'" ');

                        for($y = 0, $county = count($selected); $y < $county; $y++)
                        {
                            if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                            {
                                echo('checked="checked"');
                            }
                            else
                            {
                                echo(null);
                            }
                        }

                        echo(' />');
                        if(!empty($cutstring) && $cutstring == 'true')
                        {
                            echo('<label for="'.$code.$id[$i].'" title="'.$valueP[$i].'"><span class="'.$fontclass.'" style="margin-left: 2px; cursor: pointer; '.$fontstyle.'">'.cut_string($valueP[$i], 0 , $cutcount, $cutpunctuation).$count_id_product.'</span></label>');
                        }
                        else
                        {
                            echo('<label for="'.$code.$id[$i].'"><span class="'.$fontclass.'" style="margin-left: 2px; cursor: pointer; '.$fontstyle.'">'.$valueP[$i].$count_id_product.'</span></label>');
                        }                       

                        if(!empty($insertinput) && $insertinput != true)
                        {
                            echo('&nbsp;'.$insertinput);
                        }
                        else
                        {
                            if($insertinput == true)
                            {
                                $input = '<input ';

                                if(!empty($inputstyle))
                                {
                                    $style = 'style="'.$inputstyle.'"';
                                }

                                if(!empty($inputtype))
                                {
                                    $type = ' type="'.$inputtype.'"';
                                }
                                else
                                {
                                    $type = ' type="text"';
                                }

                                if(!empty($inputname))
                                {
                                    $name = ' name="'.$inputname.'"';
                                }
                                else
                                {
                                    $name = ' name="txt'.$code.$id[$i].'"';
                                }

                                if(!empty($inputother))
                                {
                                    $other = $inputother;
                                }
                                else
                                {
                                    $other = ' />';
                                }

                                $input .= $style.$type.$name;

                                for($y = 0, $county = count($selected); $y < $county; $y++)
                                {
                                   if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                   {
                                       if(empty($inputsession[$y]))
                                       {
                                           $inputsession[$y] = null;
                                       }
                                       $value = ' value="'.$inputsession[$y].'"'; 
                                       $y = count($selected);
                                   }
                                   else
                                   {
                                       $value = null;
                                   }
                                }

                                $input .= $value.$other;
                                echo('&nbsp;'.$input);
                            }  
                        }  
                        
                        if(!empty($addinput) && $addinput == 'true' && !empty($codeaddinput))
                        {
                            $echocodeaddinput = null;
                            $echocodeaddinput = str_replace('[#nameindex]', $id[$i], $codeaddinput);
                            for($y = 0, $county = count($selected); $y < $county; $y++)
                            {
                                if(!empty($selected[$y]) && $selected[$y] == $id[$i])
                                {
                                    if(empty($sessionaddinput[$y]))
                                    {
                                        $sessionaddinput[$y] = null;
                                    }
                                    $echocodeaddinput .= ' value="'.$sessionaddinput[$y].'"';  
                                    $y = count($selected);
                                }
                                else
                                {
                                    $echocodeaddinput .= '';
                                }
                            }
                            $echocodeaddinput .= '/>';
                            echo('&nbsp;'.$echocodeaddinput);
                        }
                        echo('<br clear="left"/>');    
                    }
                }
            }
//            echo('</td>');
            
            break;     
    }
}

function join_string($array, $arg, $argnext)
{
    for($i = 0, $count = count($array); $i < $count; $i++)
    {
        if($i == 0)
        {
            $result_string .= $array[$i].$argnext;
        }
        else
        {
            $result_string .= $arg.$array[$i].$argnext;
        }
    }
    
    return $result_string;
}

function join_2variablestring($arrayfinal, $array, $arg, $argnext, $index)
{
    for($index = 0, $count = count($array); $index < $count; $index++)
    {
        if($index == 0)
        {
            $arrayfinal .= $array[$index].$argnext;
        }
        else
        {
            $arrayfinal .= $arg.$array[$index].$argnext;
        }
    }
    
    return $arrayfinal;
}

function create_pdf()
{
    
}

function give_translation($code, $echo, $showtranslationcode)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    $current_language = $_SESSION['current_language'];
    $translate_sentence = null;
    $Bok_exist_translation = false;
    
    try
    {       
        $prepared_query = 'SELECT id_translation, L'.$current_language.' FROM translation
                           WHERE code_translation = :code';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
	$code_1 = $code;
	$code_2 = htmlspecialchars($code_1, ENT_QUOTES);
	$code_3 = trim($code_2);
        $query->bindParam('code', $code_3);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $Bok_exist_translation = true;
            $translate_id = $data[0];
            $translate_sentence = $data[1];
        } else {
        	if($_SESSION['current_log_rightsuser'] < 7) {
			
        	}
        }
        
        //$href_edit = '<a class="link_main" href="'.$header.'Gestion/Traductions/'.$translate_id.'#translation_main" style="text-decoration: none;" onclick="return hs.htmlExpand(this, { contentId: \'translation_main\',
        //                    objectType: \'ajax\', width: 200, height: 200 } )">#</a>';
        
        //$href_new = '<a class="link_main" href="'.$header.'Gestion/Traductions#translation_main" style="text-decoration: none;" onclick="return hs.htmlExpand(this, { contentId: \'translation_main\',
        //                    objectType: \'ajax\', width: 200, height: 200 } )">#?</a>';
        if(!empty($echo) && $echo == 'false')
        {
            return $translate_sentence;
        }
        else
        {
			if($_SESSION['current_log_rightsuser'] > 7) {
				$href_edit = '<a class="link_error1" href="'.$header.'Gestion/Traductions/'.$translate_id.'" target="_blank" title="Edit - '.$code.'">[#]</a>&nbsp;';
				$href_new = '<a class="link_error1" href="'.$header.'Gestion/Traductions" target="_blank" title="New - '.$code.'">[#?]</a>&nbsp;';
			
				if((empty($translate_sentence) && $Bok_exist_translation == false) || (!empty($showtranslationcode) && $showtranslationcode == 'true'))
				{
					$translate_sentence = $href_new.'<span class="font_main" title="'.$code.'" style="cursor: help;">'.cut_string($code, 0 , 50, '...').'</span>';
				}
				else
				{
					if((empty($translate_sentence) && $Bok_exist_translation == true)  || (!empty($showtranslationcode) && $showtranslationcode == 'true'))
					{
						$translate_sentence = $href_edit.'<span class="font_main" title="'.$code.'" style="cursor: help;">'.cut_string($code, 0 , 50, '...').'</span>';
					}           
				}
				echo($translate_sentence);
			} else {
				try {
					$prepared_query_2 = 'SELECT id_translation, L1 FROM translation WHERE code_translation = :code';
					$query_2 = $connectData->prepare($prepared_query_2);
					$query_2->bindParam('code', trim(htmlspecialchars($code, ENT_QUOTES)));
					$query_2->execute();
					if(($data = $query_2->fetch()) != false) {
						$Bok_exist_translation = true;
						$translate_id = $data[0];
						$translate_sentence = $data[1];
					}
					echo($translate_sentence);
				} catch(Exception $e2) {
					$_SESSION['error400_message'] = $e2->getMessage();
					if($_SESSION['index'] == 'index.php')
					{
						die(header('Location: '.$header.'Error/400'));
					}
					else
					{
						die(header('Location: '.$header.'Backoffice/Error/400'));
					} 
				}
			}
        }
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
}

function destroy_image($pathoriginal, $paththumb, $pathsearch, $nameimg)
{
    $original = './'.$pathoriginal;
    $thumb = './'.$paththumb;
    $search = './'.$pathsearch;
    
    if(!unlink($original))
    {
        $message = 'Erreur lors de la suppression du fichier "'.$nameimg.'"';
    }
    
    if(!unlink($thumb))
    {
        $message = 'Erreur lors de la suppression du fichier "'.$nameimg.'"';
    }
    else
    {
        $message = 'le fichier "'.$nameimg.'" a été supprimé';
    }
    
    if(!unlink($search))
    {
        $message = 'Erreur lors de la suppression du fichier "'.$nameimg.'"';
    }
    else
    {
        $message = 'le fichier "'.$nameimg.'" a été supprimé';
    }
    
    return $message;
}

function upload_advert($input, $nameimg, $maxsize, $originwidth, $originheight, $filedestination, $idadvert, $idlang)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    $message = null;
    $Bok_upload_size = true;
    $Bok_upload_type = true;
    
    $nameimg = $_FILES[$input]['name'];
    
    if($_FILES[$input]['size'] > $maxsize)
    {
        $message = 'le fichier ne doit pas dépasser '.$maxsize.' octets';
        $Bok_upload_size = false;
    }
    
    if($Bok_upload_size === true)
    {   
        $extension = strrchr($_FILES[$input]['name'], '.');
        $namewithoutextension = str_replace($extension, '', $_FILES[$input]['name']);
        
        if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG' || $extension == '.png' || $extension == '.gif')
        {
            $Bok_upload_type = true;
        }
        else
        {
            $message = 'veuillez sélectionner un fichier de type: jpg, jpeg, png ou gif';
            $Bok_upload_type = false;
        }
        
        if($Bok_upload_type === true)
        {
            $name = $idadvert.'L'.$idlang.$extension;
            
            $path = $_FILES[$input]['tmp_name'];                                            
            
            $path_original = './'.$filedestination.$name;

            if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
            {
                $original_img = imagecreatefromjpeg($path);
            }

            if($extension == '.png')
            {
                $original_img = imagecreatefrompng($path);
            }

            if($extension == '.gif')
            {
                $original_img = imagecreatefromgif($path);
            }
            
            $Bok_copysample = true;
            
            $original_size = getimagesize($path);
            
            $original_ratio = $original_size[0]/$original_size[1];
            if($original_size[0]/$original_size[1] > $original_ratio)
            {
                $originwidth = $originheight * $original_ratio;
            }
            else
            {
                $originheight = $originwidth / $original_ratio;
            }

            $original_truecolor = imagecreatetruecolor($originwidth, $originheight);
            if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
            {
                $message = 'Erreur définition image original "'.$nameimg.'"';
                $Bok_copysample = false;
            }
            else
            {
                imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
            }
            
            if($Bok_copysample === true)
            {
                $Bok_thumb = true;

                if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
                {
                    if(!imagejpeg($original_truecolor, $path_original, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($original_truecolor, $path_original, 70);
                    }
                }

                if($extension == '.png')
                {
                    if(!imagepng($original_truecolor, $path_original, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($original_truecolor, true);
                        $color_original = imagecolorallocatealpha($original_truecolor,0x00,0x00,0x00,127);
                        imagefill($original_truecolor, 0, 0, $color); 
                        imagepng($original_truecolor, $path_original, 6);
                    }
                }

                if($extension == '.gif')
                {
                    if(!imagegif($original_img, $path_original))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                }

                if($Bok_thumb === true)
                {       
                    move_uploaded_file($_FILES[$input]['tmp_name'], $path_original);
                    try
                    {
                        $path = $filedestination.$name;
                        
                        $prepared_query = 'UPDATE advertising
                                           SET path_advertising_L'.$idlang.' = :pathadvert
                                           WHERE id_advertising = :idadvert';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute(array(
                                              'pathadvert' => $path,
                                              'idadvert' => $idadvert
                                              ));
                        $query->closeCursor();
                        imagedestroy($original_truecolor);

                        $message = 'Le fichier "'.$nameimg.'" a été transféré';
                        return $message;
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                else
                {
                    return $message;
                }
            }
            else
            {
                return $message;
            }
        }
        else
        {
            return $message;
        }
    }
    else
    {
        return $message;
    } 
}

function ImgTransparent($x, $y) {

$imageOut = imagecreate($x, $y);

$colourBlack = imagecolorallocate($imageOut, 0, 0, 0);

imagecolortransparent($imageOut, $colourBlack);

return $imageOut;

}

function upload_file_body($input, $nameimg, $maxsize, $originwidth, $originheight, $thumbwidth, $thumbheight, $searchwidth, $searchheight, $filedestination, $filedestination_thumb, $filedestination_search, $id_type, $id, $table, $ispage, $randomname, $update, $id_image)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    $message = null;
    $Bok_upload_size = true;
    $Bok_upload_type = true;
    
    if($_FILES[$input]['size'] > $maxsize)
    {
        $message = 'le fichier ne doit pas dépasser '.$maxsize.' octets';
        $Bok_upload_size = false;
    }
    
    if($Bok_upload_size === true)
    {   
        $extension = strrchr($_FILES[$input]['name'], '.');
        $namewithoutextension = str_replace($extension, '', $_FILES[$input]['name']);
        
        if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG' || $extension == '.png' || $extension == '.PNG' || $extension == '.GIF' || $extension == '.gif')
        {
            $Bok_upload_type = true;
        }
        else
        {
            $message = 'veuillez sélectionner un fichier de type: jpg, jpeg, png ou gif';
            $Bok_upload_type = false;
        }
        
        if($Bok_upload_type === true)
        {
            if(empty($randomname) || $randomname == 'true')
            {
                $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $_FILES[$input]['name']);

                $name = null;

                for($z = 0; $z < 8; $z++)
                {
                    $name .= mt_rand(0, 9);
                }

                $name .= '-'.$filename;
            }
            else
            {
                $name = $nameimg.$extension;
            }
            
            $path = $_FILES[$input]['tmp_name'];                                            
            
            $path_original = './'.$filedestination.$name;
            $path_thumb = './'.$filedestination_thumb.$name;
            $path_search = './'.$filedestination_search.$name;
            
            if(empty($nameimg))
            {
                $nameimg = $namewithoutextension;
            }

            if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
            {
                $thumb_img = imagecreatefromjpeg($path);
                $original_img = imagecreatefromjpeg($path);
                $search_img = imagecreatefromjpeg($path);
            }

            if($extension == '.png' || $extension == '.PNG')
            {
                $thumb_img = imagecreatefrompng($path);
                $original_img = imagecreatefrompng($path);
                $search_img = imagecreatefrompng($path);
            }

            if($extension == '.gif' || $extension == '.GIF')
            {
                $thumb_img = imagecreatefromgif($path);
                $original_img = imagecreatefromgif($path);
                $search_img = imagecreatefromgif($path);
            }
            
            $Bok_copysample = true;
            $original_size = getimagesize($path);
            
			$original_ratio = $original_size[0]/$original_size[1];
			if($original_size[0]/$original_size[1] > $original_ratio)
            {
                $originwidth = $originheight * $original_ratio;
            }
            else
            {
                $originheight = $originwidth / $original_ratio;
            }

            $original_truecolor = imagecreatetruecolor($originwidth, $originheight);
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($original_truecolor, imagecolorallocatealpha($original_truecolor, 0, 0, 0, 127));
    			imagealphablending($original_truecolor, false);
   				imagesavealpha($original_truecolor, true);
				
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
				//$original_truecolor = $original_img;
            } else {
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
			}
            
            $thumb_size = getimagesize($path);
            $thumb_ratio = $thumb_size[0]/$thumb_size[1];
            if($thumb_size[0]/$thumb_size[1] > $thumb_ratio)
            {
                $thumbwidth = $thumbheight * $thumb_ratio;
            }
            else
            {
                $thumbheight = $thumbwidth / $thumb_ratio;
            }
            $thumb_truecolor = imagecreatetruecolor($thumbwidth, $thumbheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($thumb_truecolor, imagecolorallocatealpha($thumb_truecolor, 0, 0, 0, 127));
    			imagealphablending($thumb_truecolor, false);
   				imagesavealpha($thumb_truecolor, true);
				
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
				//$thumb_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
			}
            
            $search_size = getimagesize($path);
            $search_ratio = $search_size[0]/$search_size[1];
            if($search_size[0]/$search_size[1] > $search_ratio)
            {
                $searchwidth = $searchheight * $search_ratio;
            }
            else
            {
                $searchheight = $searchwidth / $search_ratio;
            }
            $search_truecolor = imagecreatetruecolor($searchwidth, $searchheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($search_truecolor, imagecolorallocatealpha($search_truecolor, 0, 0, 0, 127));
    			imagealphablending($search_truecolor, false);
   				imagesavealpha($search_truecolor, true);
				
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
				//$search_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
			}
            
            if($Bok_copysample === true)
            {
                $Bok_thumb = true;

                if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
                {
                    if(!imagejpeg($original_truecolor, $path_original, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($original_truecolor, $path_original, 70);
                    }

                    if(!imagejpeg($thumb_truecolor, $path_thumb, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    } 
                    else
                    {
                        imagejpeg($thumb_truecolor, $path_thumb, 70);
                    }

                    if(!imagejpeg($search_truecolor, $path_search, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($search_truecolor, $path_search, 70);
                    }
                }

                if($extension == '.png' || $extension == '.PNG')
                {
                    if(!imagepng($original_truecolor, $path_original, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($original_truecolor, true);
                        $color_original = imagecolorallocatealpha($original_truecolor,0x00,0x00,0x00,127);
                        imagefill($original_truecolor, 0, 0, $color); 
                        imagepng($original_truecolor, $path_original, 6);
                    }

                    if(!imagepng($thumb_truecolor, $path_thumb, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($thumb_truecolor, true);
                        $color_thumb = imagecolorallocatealpha($thumb_truecolor,0x00,0x00,0x00,127);
                        imagefill($thumb_truecolor, 0, 0, $color_thumb); 
                        imagepng($thumb_truecolor, $path_thumb, 6);
                    }

                    if(!imagepng($search_truecolor, $path_search, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($search_truecolor, true);
                        $color_search = imagecolorallocatealpha($search_truecolor,0x00,0x00,0x00,127);
                        imagefill($search_truecolor, 0, 0, $color_search); 
                        imagepng($search_truecolor, $path_search, 6);
                    }
                }

                if($extension == '.gif' || $extension == '.GIF')
                {
                    if(!imagegif($original_img, $path_original))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($thumb_truecolor, $path_thumb))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($search_truecolor, $path_search))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                }

                if($Bok_thumb === true)
                {              
                    try
                    {
                        $path_thumb = $filedestination_thumb.$name;
                        $path = $filedestination.$name;
                        $path_search = $filedestination_search.$name;
                        $alt_upload = strtolower($nameimg).$extension;
                        
                        if(empty($update) || $update == 'false')
                        {
                            if(!empty($ispage) && $ispage === true)
                            {
                                $prepared_query = 'SELECT COUNT(id_image) FROM page_image
                                                   WHERE id_page = :id';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('id', $id);
                                $query->execute();
                                if(($data = $query->fetch()) != false)
                                {
                                    $lastposition_image = $data[0];
                                }
                                $query->closeCursor();

                                $lastposition_image++;

                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image, position_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt, :position)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload,
                                                      'position' => $lastposition_image
                                                      ));
                                $query->closeCursor();
                            }
                            else
                            {
                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload
                                                      ));
                                $query->closeCursor();
                            }
                        }
                        else
                        {
                            $prepared_query = 'UPDATE '.$table.'
                                               SET name_image = :name,
                                                   path_image = :path,
                                                   paththumb_image = :thumb,
                                                   pathsearch_image = :search,
                                                   date_image = NOW(),
                                                   '.$id_type.' = :id,
                                                   alt_image = :alt
                                               WHERE id_image = :id_image';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'name' => $nameimg,
                                                  'path' => $path,
                                                  'thumb' => $path_thumb,
                                                  'search' => $path_search,
                                                  'id' => $id,
                                                  'alt' => $alt_upload,
                                                  'id_image' => $id_image
                                                  ));
                            $query->closeCursor();
                        }

                        imagedestroy($original_truecolor);
                        imagedestroy($thumb_truecolor);
                        imagedestroy($search_truecolor);

                        $message = 'Le fichier "'.$nameimg.'" a été transféré';
                        return $message;
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                else
                {
                    return $message;
                }
            }
            else
            {
                return $message;
            }
        }
        else
        {
            return $message;
        }
    }
    else
    {
        return $message;
    } 
}

function upload_file_skin($input, $nameimg, $maxsize, $originwidth, $originheight, $thumbwidth, $thumbheight, $searchwidth, $searchheight, $filedestination, $filedestination_thumb, $filedestination_search, $id_type, $id, $table, $ispage, $randomname, $update, $id_image)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    $message = null;
    $Bok_upload_size = true;
    $Bok_upload_type = true;
    
    if($_FILES[$input]['size'] > $maxsize)
    {
        $message = 'le fichier ne doit pas dépasser '.$maxsize.' octets';
        $Bok_upload_size = false;
    }
    
    if($Bok_upload_size === true)
    {   
        $extension = strrchr($_FILES[$input]['name'], '.');
        $namewithoutextension = str_replace($extension, '', $_FILES[$input]['name']);
        
        if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG' || $extension == '.png' || $extension == '.PNG' || $extension == '.GIF' || $extension == '.gif')
        {
            $Bok_upload_type = true;
        }
        else
        {
            $message = 'veuillez sélectionner un fichier de type: jpg, jpeg, png ou gif';
            $Bok_upload_type = false;
        }
        
        if($Bok_upload_type === true)
        {
            if(empty($randomname) || $randomname == 'true')
            {
                $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $_FILES[$input]['name']);

                $name = null;

                for($z = 0; $z < 8; $z++)
                {
                    $name .= mt_rand(0, 9);
                }

                $name .= '-'.$filename;
            }
            else
            {
                $name = $nameimg.$extension;
            }
            
            $path = $_FILES[$input]['tmp_name'];                                            
            
            $path_original = './'.$filedestination.$name;
            $path_thumb = './'.$filedestination_thumb.$name;
            $path_search = './'.$filedestination_search.$name;
            
            if(empty($nameimg))
            {
                $nameimg = $namewithoutextension;
            }

            if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
            {
                $thumb_img = imagecreatefromjpeg($path);
                $original_img = imagecreatefromjpeg($path);
                $search_img = imagecreatefromjpeg($path);
            }

            if($extension == '.png' || $extension == '.PNG')
            {
                $thumb_img = imagecreatefrompng($path);
                $original_img = imagecreatefrompng($path);
                $search_img = imagecreatefrompng($path);
            }

            if($extension == '.gif' || $extension == '.GIF')
            {
                $thumb_img = imagecreatefromgif($path);
                $original_img = imagecreatefromgif($path);
                $search_img = imagecreatefromgif($path);
            }
            
            $Bok_copysample = true;
            $original_size = getimagesize($path);
            
			$original_ratio = $original_size[0]/$original_size[1];
			if($original_size[0]/$original_size[1] > $original_ratio)
            {
                $originwidth = $originheight * $original_ratio;
            }
            else
            {
                $originheight = $originwidth / $original_ratio;
            }

            $original_truecolor = imagecreatetruecolor($originwidth, $originheight);
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($original_truecolor, imagecolorallocatealpha($original_truecolor, 0, 0, 0, 127));
    			imagealphablending($original_truecolor, false);
   				imagesavealpha($original_truecolor, true);
				
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
				//$original_truecolor = $original_img;
            } else {
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
			}
            
            $thumb_size = getimagesize($path);
            $thumb_ratio = $thumb_size[0]/$thumb_size[1];
            if($thumb_size[0]/$thumb_size[1] > $thumb_ratio)
            {
                $thumbwidth = $thumbheight * $thumb_ratio;
            }
            else
            {
                $thumbheight = $thumbwidth / $thumb_ratio;
            }
            $thumb_truecolor = imagecreatetruecolor($thumbwidth, $thumbheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($thumb_truecolor, imagecolorallocatealpha($thumb_truecolor, 0, 0, 0, 127));
    			imagealphablending($thumb_truecolor, false);
   				imagesavealpha($thumb_truecolor, true);
				
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
				//$thumb_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
			}
            
            $search_size = getimagesize($path);
            $search_ratio = $search_size[0]/$search_size[1];
            if($search_size[0]/$search_size[1] > $search_ratio)
            {
                $searchwidth = $searchheight * $search_ratio;
            }
            else
            {
                $searchheight = $searchwidth / $search_ratio;
            }
            $search_truecolor = imagecreatetruecolor($searchwidth, $searchheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($search_truecolor, imagecolorallocatealpha($search_truecolor, 0, 0, 0, 127));
    			imagealphablending($search_truecolor, false);
   				imagesavealpha($search_truecolor, true);
				
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
				//$search_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
			}
            
            if($Bok_copysample === true)
            {
                $Bok_thumb = true;

                if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
                {
                    if(!imagejpeg($original_truecolor, $path_original, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($original_truecolor, $path_original, 70);
                    }

                    if(!imagejpeg($thumb_truecolor, $path_thumb, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    } 
                    else
                    {
                        imagejpeg($thumb_truecolor, $path_thumb, 70);
                    }

                    if(!imagejpeg($search_truecolor, $path_search, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($search_truecolor, $path_search, 70);
                    }
                }

                if($extension == '.png' || $extension == '.PNG')
                {
                    if(!imagepng($original_truecolor, $path_original, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($original_truecolor, true);
                        $color_original = imagecolorallocatealpha($original_truecolor,0x00,0x00,0x00,127);
                        imagefill($original_truecolor, 0, 0, $color); 
                        imagepng($original_truecolor, $path_original, 6);
                    }

                    if(!imagepng($thumb_truecolor, $path_thumb, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($thumb_truecolor, true);
                        $color_thumb = imagecolorallocatealpha($thumb_truecolor,0x00,0x00,0x00,127);
                        imagefill($thumb_truecolor, 0, 0, $color_thumb); 
                        imagepng($thumb_truecolor, $path_thumb, 6);
                    }

                    if(!imagepng($search_truecolor, $path_search, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($search_truecolor, true);
                        $color_search = imagecolorallocatealpha($search_truecolor,0x00,0x00,0x00,127);
                        imagefill($search_truecolor, 0, 0, $color_search); 
                        imagepng($search_truecolor, $path_search, 6);
                    }
                }

                if($extension == '.gif' || $extension == '.GIF')
                {
                    if(!imagegif($original_img, $path_original))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($thumb_truecolor, $path_thumb))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($search_truecolor, $path_search))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                }

                if($Bok_thumb === true)
                {              
                    try
                    {
                        $path_thumb = $filedestination_thumb.$name;
                        $path = $filedestination.$name;
                        $path_search = $filedestination_search.$name;
                        $alt_upload = strtolower($nameimg).$extension;
                        
                        if(empty($update) || $update == 'false')
                        {
                            if(!empty($ispage) && $ispage === true)
                            {
                                $prepared_query = 'SELECT COUNT(id_image) FROM page_image
                                                   WHERE id_page = :id';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('id', $id);
                                $query->execute();
                                if(($data = $query->fetch()) != false)
                                {
                                    $lastposition_image = $data[0];
                                }
                                $query->closeCursor();

                                $lastposition_image++;

                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image, position_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt, :position)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload,
                                                      'position' => $lastposition_image
                                                      ));
                                $query->closeCursor();
                            }
                            else
                            {
                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload
                                                      ));
                                $query->closeCursor();
                            }
                        }
                        else
                        {
                            $prepared_query = 'UPDATE '.$table.'
                                               SET name_image = :name,
                                                   path_image = :path,
                                                   paththumb_image = :thumb,
                                                   pathsearch_image = :search,
                                                   date_image = NOW(),
                                                   '.$id_type.' = :id,
                                                   alt_image = :alt
                                               WHERE id_image = :id_image';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'name' => $nameimg,
                                                  'path' => $path,
                                                  'thumb' => $path_thumb,
                                                  'search' => $path_search,
                                                  'id' => $id,
                                                  'alt' => $alt_upload,
                                                  'id_image' => $id_image
                                                  ));
                            $query->closeCursor();
                        }

                        imagedestroy($original_truecolor);
                        imagedestroy($thumb_truecolor);
                        imagedestroy($search_truecolor);

                        $message = 'Le fichier "'.$nameimg.'" a été transféré';
                        return $message;
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                else
                {
                    return $message;
                }
            }
            else
            {
                return $message;
            }
        }
        else
        {
            return $message;
        }
    }
    else
    {
        return $message;
    } 
}

function upload_file($input, $nameimg, $maxsize, $originwidth, $originheight, $thumbwidth, $thumbheight, $searchwidth, $searchheight, $filedestination, $filedestination_thumb, $filedestination_search, $id_type, $id, $table, $ispage, $randomname, $update, $id_image)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    $message = null;
    $Bok_upload_size = true;
    $Bok_upload_type = true;
    
    if($_FILES[$input]['size'] > $maxsize)
    {
        $message = 'le fichier ne doit pas dépasser '.$maxsize.' octets';
        $Bok_upload_size = false;
    }
    
    if($Bok_upload_size === true)
    {   
        $extension = strrchr($_FILES[$input]['name'], '.');
        $namewithoutextension = str_replace($extension, '', $_FILES[$input]['name']);
        
        if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG' || $extension == '.png' || $extension == '.PNG' || $extension == '.GIF' || $extension == '.gif')
        {
            $Bok_upload_type = true;
        }
        else
        {
            $message = 'veuillez sélectionner un fichier de type: jpg, jpeg, png ou gif';
            $Bok_upload_type = false;
        }
        
        if($Bok_upload_type === true)
        {
            if(empty($randomname) || $randomname == 'true')
            {
                $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $_FILES[$input]['name']);

                $name = null;

                for($z = 0; $z < 8; $z++)
                {
                    $name .= mt_rand(0, 9);
                }

                $name .= '-'.$filename;
            }
            else
            {
                $name = $nameimg.$extension;
            }
            
            $path = $_FILES[$input]['tmp_name'];                                            
            
            $path_original = './'.$filedestination.$name;
            $path_thumb = './'.$filedestination_thumb.$name;
            $path_search = './'.$filedestination_search.$name;
            
            if(empty($nameimg))
            {
                $nameimg = $namewithoutextension;
            }

            if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
            {
                $thumb_img = imagecreatefromjpeg($path);
                $original_img = imagecreatefromjpeg($path);
                $search_img = imagecreatefromjpeg($path);
            }

            if($extension == '.png' || $extension == '.PNG')
            {
                $thumb_img = imagecreatefrompng($path);
                $original_img = imagecreatefrompng($path);
                $search_img = imagecreatefrompng($path);
            }

            if($extension == '.gif' || $extension == '.GIF')
            {
                $thumb_img = imagecreatefromgif($path);
                $original_img = imagecreatefromgif($path);
                $search_img = imagecreatefromgif($path);
            }
            
            $Bok_copysample = true;
            $original_size = getimagesize($path);
            
			$original_ratio = $original_size[0]/$original_size[1];
			if($original_size[0]/$original_size[1] > $original_ratio)
            {
                $originwidth = $originheight * $original_ratio;
            }
            else
            {
                $originheight = $originwidth / $original_ratio;
            }

            $original_truecolor = imagecreatetruecolor($originwidth, $originheight);
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($original_truecolor, imagecolorallocatealpha($original_truecolor, 0, 0, 0, 127));
    			imagealphablending($original_truecolor, false);
   				imagesavealpha($original_truecolor, true);
				
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
				//$original_truecolor = $original_img;
            } else {
				if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
				{
					$message = 'Erreur définition image original "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
				}
			}
            
            $thumb_size = getimagesize($path);
            $thumb_ratio = $thumb_size[0]/$thumb_size[1];
            if($thumb_size[0]/$thumb_size[1] > $thumb_ratio)
            {
                $thumbwidth = $thumbheight * $thumb_ratio;
            }
            else
            {
                $thumbheight = $thumbwidth / $thumb_ratio;
            }
            $thumb_truecolor = imagecreatetruecolor($thumbwidth, $thumbheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($thumb_truecolor, imagecolorallocatealpha($thumb_truecolor, 0, 0, 0, 127));
    			imagealphablending($thumb_truecolor, false);
   				imagesavealpha($thumb_truecolor, true);
				
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
				//$thumb_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]))
				{
					$message = 'Erreur définition image vignette "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($thumb_truecolor, $thumb_img, 0, 0, 0, 0, $thumbwidth, $thumbheight, $thumb_size[0], $thumb_size[1]);
				}
			}
            
            $search_size = getimagesize($path);
            $search_ratio = $search_size[0]/$search_size[1];
            if($search_size[0]/$search_size[1] > $search_ratio)
            {
                $searchwidth = $searchheight * $search_ratio;
            }
            else
            {
                $searchheight = $searchwidth / $search_ratio;
            }
            $search_truecolor = imagecreatetruecolor($searchwidth, $searchheight);
            
			if($extension == '.png' || $extension == '.PNG') {
				
				imagecolortransparent($search_truecolor, imagecolorallocatealpha($search_truecolor, 0, 0, 0, 127));
    			imagealphablending($search_truecolor, false);
   				imagesavealpha($search_truecolor, true);
				
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
				//$search_truecolor = $thumb_img;
			} else {
				if(!imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]))
				{
					$message = 'Erreur définition image recherche "'.$nameimg.'"';
					$Bok_copysample = false;
				}
				else
				{
					imagecopyresampled($search_truecolor, $thumb_img, 0, 0, 0, 0, $searchwidth, $searchheight, $search_size[0], $search_size[1]);
				}
			}
            
            if($Bok_copysample === true)
            {
                $Bok_thumb = true;

                if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.JPEG')
                {
                    if(!imagejpeg($original_truecolor, $path_original, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($original_truecolor, $path_original, 70);
                    }

                    if(!imagejpeg($thumb_truecolor, $path_thumb, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    } 
                    else
                    {
                        imagejpeg($thumb_truecolor, $path_thumb, 70);
                    }

                    if(!imagejpeg($search_truecolor, $path_search, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($search_truecolor, $path_search, 70);
                    }
                }

                if($extension == '.png' || $extension == '.PNG')
                {
                    if(!imagepng($original_truecolor, $path_original, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($original_truecolor, true);
                        $color_original = imagecolorallocatealpha($original_truecolor,0x00,0x00,0x00,127);
                        imagefill($original_truecolor, 0, 0, $color); 
                        imagepng($original_truecolor, $path_original, 6);
                    }

                    if(!imagepng($thumb_truecolor, $path_thumb, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($thumb_truecolor, true);
                        $color_thumb = imagecolorallocatealpha($thumb_truecolor,0x00,0x00,0x00,127);
                        imagefill($thumb_truecolor, 0, 0, $color_thumb); 
                        imagepng($thumb_truecolor, $path_thumb, 6);
                    }

                    if(!imagepng($search_truecolor, $path_search, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($search_truecolor, true);
                        $color_search = imagecolorallocatealpha($search_truecolor,0x00,0x00,0x00,127);
                        imagefill($search_truecolor, 0, 0, $color_search); 
                        imagepng($search_truecolor, $path_search, 6);
                    }
                }

                if($extension == '.gif' || $extension == '.GIF')
                {
                    if(!imagegif($original_img, $path_original))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($thumb_truecolor, $path_thumb))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }

                    if(!imagegif($search_truecolor, $path_search))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'image de recherche "'.$nameimg.'"';
                        $Bok_thumb = false;
                        return $message;
                    }
                }

                if($Bok_thumb === true)
                {              
                    try
                    {
                        $path_thumb = $filedestination_thumb.$name;
                        $path = $filedestination.$name;
                        $path_search = $filedestination_search.$name;
                        $alt_upload = strtolower($nameimg).$extension;
                        
                        if(empty($update) || $update == 'false')
                        {
                            if(!empty($ispage) && $ispage === true)
                            {
                                $prepared_query = 'SELECT COUNT(id_image) FROM page_image
                                                   WHERE id_page = :id';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('id', $id);
                                $query->execute();
                                if(($data = $query->fetch()) != false)
                                {
                                    $lastposition_image = $data[0];
                                }
                                $query->closeCursor();

                                $lastposition_image++;

                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image, position_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt, :position)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload,
                                                      'position' => $lastposition_image
                                                      ));
                                $query->closeCursor();
                            }
                            else
                            {
                                $prepared_query = 'INSERT INTO '.$table.'
                                                   (name_image, path_image, paththumb_image, pathsearch_image, date_image, '.$id_type.', alt_image)
                                                   VALUES
                                                   (:name, :path, :thumb, :search, NOW(), :id, :alt)';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute(array(
                                                      'name' => $nameimg,
                                                      'path' => $path,
                                                      'thumb' => $path_thumb,
                                                      'search' => $path_search,
                                                      'id' => $id,
                                                      'alt' => $alt_upload
                                                      ));
                                $query->closeCursor();
                            }
                        }
                        else
                        {
                            $prepared_query = 'UPDATE '.$table.'
                                               SET name_image = :name,
                                                   path_image = :path,
                                                   paththumb_image = :thumb,
                                                   pathsearch_image = :search,
                                                   date_image = NOW(),
                                                   '.$id_type.' = :id,
                                                   alt_image = :alt
                                               WHERE id_image = :id_image';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'name' => $nameimg,
                                                  'path' => $path,
                                                  'thumb' => $path_thumb,
                                                  'search' => $path_search,
                                                  'id' => $id,
                                                  'alt' => $alt_upload,
                                                  'id_image' => $id_image
                                                  ));
                            $query->closeCursor();
                        }

                        imagedestroy($original_truecolor);
                        imagedestroy($thumb_truecolor);
                        imagedestroy($search_truecolor);

                        $message = 'Le fichier "'.$nameimg.'" a été transféré';
                        return $message;
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                else
                {
                    return $message;
                }
            }
            else
            {
                return $message;
            }
        }
        else
        {
            return $message;
        }
    }
    else
    {
        return $message;
    } 
}

function upload_file_language($input, $input_index, $nameimg, $maxsize, $originwidth, $originheight, $iconwidth, $iconheight, $filedestination, $filedestination_icon, $id, $status, $insert_data, $tablename, $id_column_name)
{
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    $message = null;
    $Bok_upload_size = true;
    $Bok_upload_type = true;
    $status_image = $status;
    
    
    
    if($_FILES[$input]['size'][$input_index] > $maxsize)
    {
        $message = 'le fichier ne doit pas dépasser '.$maxsize.' octets';
        $Bok_upload_size = false;
    }
    
    if($Bok_upload_size === true)
    {   
        $extension = strrchr($_FILES[$input]['name'][$input_index], '.');
        
        if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg' || $extension == '.png' || $extension == '.PNG' || $extension == '.gif' || $extension == '.GIF')
        {
            $Bok_upload_type = true;
        }
        else
        {
            $message = 'veuillez sélectionner un fichier de type: jpg, jpeg, png ou gif';
            $Bok_upload_type = false;
        }
        
        if($Bok_upload_type === true)
        {
            $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $_FILES[$input]['name'][$input_index]);
            $name = $filename;
            
            $path = $_FILES[$input]['tmp_name'][$input_index];                                            
            
            if(empty($nameimg))
            {
                $nameimg = $name;
            }
            else
            {
                $name = $nameimg.$extension;
                $nameimg = $nameimg.$extension;
            }
            
            $path_original = './'.$filedestination.$nameimg;
            $path_icon = './'.$filedestination_icon.$nameimg;
            
            

            if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg')
            {
                $icon_img = imagecreatefromjpeg($path);
                $original_img = imagecreatefromjpeg($path);
            }

            if($extension == '.png' || $extension == '.PNG')
            {
                $icon_img = imagecreatefrompng($path);
                $original_img = imagecreatefrompng($path);
            }

            if($extension == '.gif' || $extension == '.GIF')
            {
                $icon_img = imagecreatefromgif($path);
                $original_img = imagecreatefromgif($path);
            }
            
            $Bok_copysample = true;
            
            $original_size = getimagesize($path);
            
            $original_ratio = $original_size[0]/$original_size[1];
            if($original_size[0]/$original_size[1] > $original_ratio)
            {
                $originwidth = $originheight * $original_ratio;
            }
            else
            {
                $originheight = $originwidth / $original_ratio;
            }

            $original_truecolor = imagecreatetruecolor($originwidth, $originheight);
            if(!imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]))
            {
                $message = 'Erreur définition image original "'.$nameimg.'"';
                $Bok_copysample = false;
            }
            else
            {
                imagecopyresampled($original_truecolor, $original_img, 0, 0, 0, 0, $originwidth, $originheight, $original_size[0], $original_size[1]);
            }
                    
            
            $icon_size = getimagesize($path);
            $icon_ratio = $icon_size[0]/$icon_size[1];
            if($icon_size[0]/$icon_size[1] > $icon_ratio)
            {
                $iconwidth = $iconheight * $icon_ratio;
            }
            else
            {
                $iconheight = $iconwidth / $icon_ratio;
            }
            $icon_truecolor = imagecreatetruecolor($iconwidth, $iconheight);
            
            if(!imagecopyresampled($icon_truecolor, $icon_img, 0, 0, 0, 0, $iconwidth, $iconheight, $icon_size[0], $icon_size[1]))
            {
                $message = 'Erreur définition image vignette "'.$nameimg.'"';
                $Bok_copysample = false;
            }
            else
            {
                imagecopyresampled($icon_truecolor, $icon_img, 0, 0, 0, 0, $iconwidth, $iconheight, $icon_size[0], $icon_size[1]);
            }
            
            if($Bok_copysample === true)
            {
                $Bok_icon = true;

                if($extension == '.jpg' || $extension == '.JPG' || $extension == '.jpeg')
                {
                    if(!imagejpeg($original_truecolor, $path_original, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    }
                    else
                    {
                        imagejpeg($original_truecolor, $path_original, 70);
                    }

                    if(!imagejpeg($icon_truecolor, $path_icon, 70))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    } 
                    else
                    {
                        imagejpeg($icon_truecolor, $path_icon, 70);
                    }
                    
                }

                if($extension == '.png' || $extension == '.PNG')
                {
                    if(!imagepng($original_truecolor, $path_original, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($original_truecolor, true);
                        $color_original = imagecolorallocatealpha($original_truecolor,0x00,0x00,0x00,127);
                        imagefill($original_truecolor, 0, 0, $color); 
                        imagepng($original_truecolor, $path_original, 6);
                    }

                    if(!imagepng($icon_truecolor, $path_icon, 6))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    }
                    else
                    {
                        imagesavealpha($icon_truecolor, true);
                        $color_icon = imagecolorallocatealpha($icon_truecolor,0x00,0x00,0x00,127);
                        imagefill($icon_truecolor, 0, 0, $color_icon); 
                        imagepng($icon_truecolor, $path_icon, 6);
                    }
                }

                if($extension == '.gif' || $extension == '.GIF')
                {
                    if(!imagegif($original_img, $path_original))
                    {
                        $message = 'Une erreur est survenue lors de la création de l\'original "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    }

                    if(!imagegif($icon_img, $path_icon))
                    {
                        $message = 'Une erreur est survenue lors de la création de la vignette "'.$nameimg.'"';
                        $Bok_icon = false;
                        return $message;
                    }
                }



                if($Bok_icon === true)
                {              
                    try
                    {
                        $path_icon = $filedestination_icon.$nameimg;
                        $path = $filedestination.$nameimg;

                        if($insert_data == true)
                        {
                        
                            $prepared_query = 'INSERT INTO '.$tablename.'
                                               (name_image, path_image, paththumb_image, date_image, '.$id_column_name.', status_image)
                                               VALUES
                                               (:name, :path, :thumb, NOW(), :id, :status)';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'name' => $nameimg,
                                                  'path' => $path,
                                                  'thumb' => $path_icon,
                                                  'id' => $id,
                                                  'status' => $status_image
                                                  ));
                            $query->closeCursor();
                        }
                        else
                        {                           
                            $prepared_query = 'UPDATE '.$tablename.'
                                               SET name_image = :name,
                                                   path_image = :path,
                                                   paththumb_image = :thumb,
                                                   date_image = NOW()
                                               WHERE '.$id_column_name.' = :id
                                               AND status_image = :status';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute(array(
                                                  'name' => $nameimg,
                                                  'path' => $path,
                                                  'thumb' => $path_icon,
                                                  'id' => $id,
                                                  'status' => $status_image
                                                  ));
                            $query->closeCursor();
                        }

                        imagedestroy($original_truecolor);
                        imagedestroy($icon_truecolor);

                        $message = 'Le fichier "'.$nameimg.'" a été transféré';
                        return $message;
                    }
                    catch(Exception $e)
                    {
                        $_SESSION['error400_message'] = $e->getMessage();
                        if($_SESSION['index'] == 'index.php')
                        {
                            die(header('Location: '.$header.'Error/400'));
                        }
                        else
                        {
                            die(header('Location: '.$header.'Backoffice/Error/400'));
                        } 
                    }
                }
                else
                {
                    return $message;
                }
            }
            else
            {
                return $message;
            }
        }
        else
        {
            return $message;
        }
    }
    else
    {
        return $message;
    } 
}

function giveme_country_name($id_country)
{
    include('dbconnect.php');
    
    try
    {
        $prepared_query = 'SELECT name_country_L1 FROM country
                           WHERE id_country = :id';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_country);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $name_country = $data[0];
        }
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
    
    return $name_country;
}

function dropdown_color($select, $current_value, $span)
{
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    echo('<select id="'.$select.'" name="'.$select.'" onchange="onchange_color(\''.$select.'\', \''.$span.'\');">');

    try
    {
        if(empty($current_value) && $current_value == null)
        {
            $Bok_first_option = true;
            
            $prepared_query = 'SELECT * FROM style_color
                                   ORDER BY name_color';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $current_value = $data['code_color'];
            }
            $query->closeCursor();
        }
        else
        {
            $Bok_first_option = false;
        }
        
        $prepared_query = 'SELECT * FROM style_color
                           ORDER BY name_color';
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        $i = 0;
        
        while($data = $query->fetch())
        {
            if($Bok_first_option == false)
            {
                echo('<option value="'.$data['code_color'].'" ');

                if(!empty($current_value) && $current_value == $data['code_color'])
                {
                    echo('selected');
                }
                else
                {
                    echo(null);
                }

                echo('>'.$data['name_color'].'</option>');
            }
            else
            {
                echo('<option value="'.$data['code_color'].'" ');

                if($i == 0)
                {
                    echo('selected');
                }
                else
                {
                    echo(null);
                }
                    
                echo('>'.$data['name_color'].'</option>');
                
                $i++;
            }
        }
        $query->closeCursor();
        
        echo('</select>');
        
        echo('&nbsp;<span id="'.$span.'" style="background-color: '.$current_value.'; padding: 2px; width: 60px; border: 1px solid lightgrey; border-radius: 6px 0px 6px 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
    
    return $name_country;
}

function dropdown_color_show_button($select, $current_value, $span, $button, $style)
{
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    echo('<select id="'.$select.'" name="'.$select.'" onchange="onchange_color(\''.$select.'\', \''.$span.'\'); preview_button_show(\''.$button.'\', \''.$select.'\', \''.$style.'\');">');

    try
    {
        if(empty($current_value) && $current_value == null)
        {
            $Bok_first_option = true;
            
            $prepared_query = 'SELECT * FROM style_color
                                   ORDER BY name_color';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $current_value = $data['code_color'];
            }
            $query->closeCursor();
        }
        else
        {
            $Bok_first_option = false;
        }
        
        $prepared_query = 'SELECT * FROM style_color
                           ORDER BY name_color';
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        $i = 0;
        
        while($data = $query->fetch())
        {
            if($Bok_first_option == false)
            {
                echo('<option value="'.$data['code_color'].'" ');

                if(!empty($current_value) && $current_value == $data['code_color'])
                {
                    echo('selected');
                }
                else
                {
                    echo(null);
                }

                echo('>'.$data['name_color'].'</option>');
            }
            else
            {
                echo('<option value="'.$data['code_color'].'" ');

                if($i == 0)
                {
                    echo('selected');
                }
                else
                {
                    echo(null);
                }
                    
                echo('>'.$data['name_color'].'</option>');
                
                $i++;
            }
        }
        $query->closeCursor();
        
        echo('</select>');
        
        echo('&nbsp;<span id="'.$span.'" style="background-color: '.$current_value.'; padding: 2px; width: 60px; border: 1px solid lightgrey; border-radius: 6px 0px 6px 0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
    
    return $name_country;
}

function company_to_name($company, $firstname, $lastname, $title)
{    
    $string_return = null;
    
    if(!empty($company))
    {
        $string_return = upper_firstchar($company);
        
        return $string_return;
    }
    else
    {
        $string_return = $lastname.' ';
        
        if(!empty($title) && $title == 'yes')
        {
            $string_return .= $firstname;
        }
        else
        {
            $string_return .= upper_firstchar(cut_string($firstname, 0, 1, '.'));
        }
        
        return $string_return;
    }
}

function give_user_id($count, $filter)
{
    include('dbconnect.php');
    
    $Bok_add_filter = false;    
    
    if(!empty($count) && $count == 'yes')
    {
        if($filter != null)
        {
            $Bok_add_filter = true;
        }
        
        try
        {
            $prepared_query = 'SELECT COUNT(user.id_user) FROM user
                               INNER JOIN user_real
                               ON user.id_user = user_real.id_user';
            
            if($Bok_add_filter == true)
            {
                $prepared_query .= ' WHERE type_real =\''.$filter.'\'';
            }
            
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $user_id_result = $data[0]; 
            }
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }
    }
    else
    {
        if($filter != null)
        {
            $Bok_add_filter = true;
        }
        
        try
        {
            $i = 0;
            
            $prepared_query = 'SELECT user.id_user FROM user
                               INNER JOIN user_real
                               ON user.id_user = user_real.id_user';
            
            if($Bok_add_filter == true)
            {
                $prepared_query .= ' WHERE type_real =\''.$filter.'\'';
            }
            
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            while($data = $query->fetch())
            {
                $user_id_result[$i] = $data[0]; 
                $i++;
            }
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }
    }
    
    return $user_id_result;
}

function generate_code($nb_char_max)
{
    $generated_code = null;
    
    for($i = 0; $i <= $nb_char_max; $i++)
    {
       $generated_code .= md5(mt_rand());
    }
    
    return $generated_code;
}

//function expand_menu_left($get, $session_block, $session_image, $expandML_url)
//{
//    if(isset($get))
//    {
//        if(isset($get) && $get == 'true')
//        {
//           $session_block = true;
//           $session_image = 'graphics/icons/minus16x16.png';
//           $expandML_url = 'false';
//        }
//        else
//        {
//           $session_block = false;
//           $session_image = 'graphics/icons/plus16x16.png';
//           $expandML_url = 'true';
//        }
//    }
//    else
//    {
//        if(empty($session_block) || $session_block == false)
//        {
//           $session_block = false;
//           $session_image = 'graphics/icons/plus16x16.png';
//           $expandML_url = 'true';
//        }
//        else
//        {
//           $session_block = true;
//           $session_image = 'graphics/icons/minus16x16.png';
//           $expandML_url = 'false';
//        }   
//    }
//}
//
//function check_backoffice_skeleton_part1()
//{
//    include('config.php');
//    
//    if($_SESSION['index'] == 'index_backoffice.php')
//    {
//        return include($backoffice_html_skeleton_part1);
//    }
//    else
//    {
//        return '<td>';
//    }
//}

//function check_backoffice_skeleton_part2()
//{
//    include('config.php');
//    
//    if($_SESSION['index'] == 'index_backoffice.php')
//    {
//        return include($backoffice_html_skeleton_part2);
//    }
//    else
//    {
//        return '</td>';
//    }
//}

function cut_string($string, $start, $end, $punctuation, $forcecut = false)
{
    if(strlen($string) > $end)
    {
        if(empty($forcecut) || $forcecut != 'true')
        {
            for($i = $end; $i <= strlen($string); $i++)
            {
                if(preg_match('#[ ]#', $string[$i]) == true || $i == strlen($string))
                {
                    $end = $i;
                    if($i == strlen($string))
                    {
                        $punctuation = null;
                    }
                    $i = strlen($string) + 1;
                }
            }
        }
        $cutted_string = substr($string, $start, $end).$punctuation;
    }
    else
    {
        $cutted_string = $string;
    }
    
    return $cutted_string;
}

function converto_timestamp($datetime)
{
    $hour = substr($datetime, 11, 13);
    $minute = substr($datetime, 14, 16);
    $second = substr($datetime, 17, 19);
    $month = substr($datetime, 5, 7);
    $day = substr($datetime, 8, 10);
    $year = substr($datetime, 0, 4);
    
    return mktime($hour, $minute, $second, $month, $day, $year);
}


function check_code_bonus($code_bonus)
{
    include('dbconnect.php');
    
    $current_time = time();
    
    try
    {
        $query = $connectData->prepare('SELECT * FROM bonus WHERE code_bonus = :bonus
                                        AND status_bonus = 1 AND expiration_bonus > '.$current_time);
        
        $query->bindParam('bonus', $code_bonus);
        $query->execute();
        
        $bonus_info[] = null;
        $i = 0;
        
        if(($data = $query->fetch()) != false)
        {
            $bonus_info[$i] = true;
            $i++;
            $bonus_info[$i] = $data[0];
            $i++;
            $bonus_info[$i] = $data[2];
            $i++;
            $bonus_info[$i] = $data[3];
            $i++;
            $bonus_info[$i] = $data[4];
            $i++;
            $bonus_info[$i] = $data[5];
            $i++;
        }
        else
        {
            $bonus_info[$i] = false;
        }
        
        $query->closeCursor();
        
        return $bonus_info;
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
}

function change_link($frontend_link, $backoffice_link, $echo = "link")
{
    if(!empty($_SESSION['index']) && $_SESSION['index'] == 'index.php')
    {
        if(empty($echo) || $echo == 'true')
        {
            echo($frontend_link);
        }
        else
        {
            return $frontend_link;
        }
    }
    else
    {
        if(empty($echo) || $echo == 'true')
        {
            echo($backoffice_link);
        }
        else
        {
            return $backoffice_link;
        }
    }
}

function ordinal_display($string)
{
    $string = preg_replace('#ère#', '<span style="font-size: 9px; vertical-align: top;">ère</span>', $string);
    $string = preg_replace('#sde#', '<span style="font-size: 9px; vertical-align: top;">de</span>', $string);
    $string = preg_replace('#ème#', '<span style="font-size: 9px; vertical-align: top;">ème</span>', $string);
    
    return $string;
}

function convert_to_kilo($number)
{
//    if($number >= 1000)
//    {
//        $number = number_format(($number / 1000), 2).' kg';
//        
//        if((substr($number, 1) == '00 kg') || (substr($number, 2) == '00 kg') || (substr($number, 3) == '00 kg'))
//        {
//           $number = round($number).' kg'; 
//        }
//    }
//    else
//    {
//        $number = $number.' gr';
//    }
    
    $number = number_format(($number / 1000), 3).' kg';
    
//    if((substr($number, 1) == '000 kg') || (substr($number, 2) == '000 kg') || (substr($number, 3) == '000 kg'))
//    {
//       $number = round($number).' kg'; 
//    }
    
    return $number;
}

/*Reallocate ids and autoincrement when we deleted any rows from a table*/
function reallocate_table_id($name_column_id, $name_concerned_table)
{
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    $query = $connectData->prepare('SELECT '.$name_column_id.' FROM '.$name_concerned_table);
    $query->execute();

    $b = 0;
    $n = 1;
    $v = 0;
    $m = 1;
    $count_row = 0;

    while($data = $query->fetch())
    {
        $array_old_id[$b] = $data[0];
        $count_row += $m; 
        $b++;
    }
    
    if(!empty($array_old_id[0]))
    {
        $count_row++;
        for($v = 0; $v < count($array_old_id); $v++)
        {
            $array_new_id[$v] =  $n;
            $n++;               
        }

        for($v = 0; $v < count($array_old_id); $v++)
        {
            $query = $connectData->prepare('UPDATE '.$name_concerned_table.'
                                            SET '.$name_column_id.' = :id
                                            WHERE '.$name_column_id.' = :id_old');
            $query->execute(array(
                                  'id' => $array_new_id[$v],
                                  'id_old' => $array_old_id[$v]
                                  ));
            $query->closeCursor(); 
        }

        
    }
    else
    {
       $count_row = 1; 
    }
    
    $query = $connectData->prepare('ALTER TABLE '.$name_concerned_table.' AUTO_INCREMENT ='.$count_row);
    $query->execute();
    $query->closeCursor();
    
    unset($b, $n, $v, $m, $count_row);
}

/*Reallocate ids and autoincrement when we deleted any rows from a table*/
function reallocate_table_id_special($name_column_id, $name_concerned_table, $special_column, $order_by)
{
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    $query = $connectData->prepare('SELECT '.$name_column_id.', '.$special_column.' FROM '.$name_concerned_table.'
                                    ORDER BY '.$order_by);
    $query->execute();

    $b = 0;
    $n = 1;
    $v = 0;
    $m = 1;
    $count_row = 0;

    while($data = $query->fetch())
    {
        $array_old_id[$b] = $data[0];
        $array_old_special[$b] = $data[1];
        $count_row += $m; 
        $b++;
    }
    
    if(!empty($array_old_id[0]))
    {
        $count_row++;
        for($v = 0; $v < count($array_old_id); $v++)
        {
            $array_new_id[$v] =  $n;
            if($n == 1)
            {
                $array_new_special[$v] =  preg_replace('#[0-9]#', $n, $array_old_special[$v]);
            }
            else
            {
               if($n == 2)
               {
                  $array_new_special[$v] =  preg_replace('#[0-9]#', $n, $array_old_special[$v]); 
               }
               else
               {
                  $array_new_special[$v] =  preg_replace('#[0-9]#', $n, $array_old_special[$v]); 
               }
            }
            $n++;               
        }

        for($v = 0; $v < count($array_old_id); $v++)
        {
            $query = $connectData->prepare('UPDATE '.$name_concerned_table.'
                                            SET '.$name_column_id.' = :id,
                                                '.$special_column.' = :part
                                            WHERE '.$name_column_id.' = :id_old');
            $query->execute(array(
                                  'id' => $array_new_id[$v],
                                  'part' => $array_new_special[$v],
                                  'id_old' => $array_old_id[$v]
                                  ));
            $query->closeCursor(); 
        }

        
    }
    else
    {
       $count_row = 1; 
    }
    
    $query = $connectData->prepare('ALTER TABLE '.$name_concerned_table.' AUTO_INCREMENT ='.$count_row);
    $query->execute();
    $query->closeCursor();
    
    unset($b, $n, $v, $m, $count_row);
}

function upper_firstchar($string)
{
    $string = strtoupper(substr($string, 0, 1)).strtolower(substr($string, 1));
    
    return $string;
}

function nosubmit_form_historyback() 
{
   if(!empty($_POST))
   {
       $_SESSION['save_search_POST'] = $_POST; #Save POST values in current script into a session
       $current_script = $_SERVER['PHP_SELF']; #Save script name in a variable
       if(!empty($_SERVER['QUERY_STRING'])) #if there are values in URL, we add them into previous variable
       {
           $current_script .= '?'.$_SERVER['QUERY_STRING'];
       }

       header('Location: '.$current_script); #refresh current page
       exit;
   }

   if(isset($_SESSION['save_search_POST'])) #put 
   {
       $_POST = $_SESSION['save_search_POST'];
       unset($_SESSION['save_search_POST']);
   } 
}

function crypt_pwd($pass)
{
    define('PREFIX', 'Aep4N81lz90');
    define('SUFFIX', 'VoN1a5Ii3qG');
    
    $pass = md5(sha1(PREFIX).sha1($pass).sha1(SUFFIX));
    
    return $pass;
}
/*----------------------------------------------------------------------------*/
function file_perms($file, $octal = false)
{
    if(!file_exists($file)) return false;

    $perms = fileperms($file);

    $cut = $octal ? 2 : 3;

    return substr(decoct($perms), $cut);
}
/*----------------------------------------------------------------------------*/
function convert_to_cent($amount)
{
   $coef = 100.00;
   
   //$amount = floatval($amount);
   $result = ($amount*$coef);
   //$amount = strval($result);
   //$amount = $result;
   return $result;
}
/*----------------------------------------------------------------------------*/
function check_session_input($session)
{
    if(!empty($session) && $session != 'null' && $session != null)
    {
        return $session;
    }
    else
    {
        return null;
    }
}
/*----------------------------------------------------------------------------*/
function no_cache()
{
    header('Pragma: no-cache');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    //header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-cache, must-revalidate');    
}

//function wd_remove_accents($str, $charset='utf-8')
//{
//    $str = htmlentities($str, ENT_NOQUOTES, $charset);
//    
//    $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
//    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
//    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caract�res
//    
//    return $str;
//}


function create_link($page_name)
{
//    $index = $_SESSION['index'];
//    
//    $strpage = "?page=";
    
}

function check_page_edit_array($array, $array_temp)
{
    $j = 0;
    $i = 0;

    for($i = 0; $i < count($array); $i++)
    {
        if($array[$i] == 'select')
        {   
            $i++;

            $array_temp[$j] = $array[$i];
            $j++;
        }
        else
        {
            $array_temp[$j] = $array[$i];
            $j++;
        }
    }

    $array = $array_temp;
    
    return $array;
}

function get_dropdown_elements($dropdown, $array_temp, $data)
{
    if(strlen($data) >= 4 && $data != '0')/*Dropdown Category*/
    {
        $j = 0;             
        $array_temp = mb_split(",", $data);

        for($i = 0; $i < count($array_temp); $i++)
        {
            if(!empty($array_temp[$i]))
            {
                $dropdown[$j] = $array_temp[$i];
                $j++;
            }
            else
            {
                $j = 0;
            }
        }
        
        return $dropdown;
    }
    else
    {
        $dropdown = $data;
        
        return $dropdown;
    }
}

function replace_dirtyword($string, $current_language, $search, $keyword, $comment, $comreplacechar)
{     
    unset($array_unmodified_char, $array_modified_char);
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    if(empty($current_language))
    {
       $prepared_query = 'SELECT id_language FROM language
                          WHERE priority_language = 1';
       $query = $connectData->prepare($prepared_query);
       $query->execute();
       if(($data = $query->fetch()) != false)
       {
           $current_language = $data[0];
       }
       $query->closeCursor();
    }
    
    $string = ' '.$string.' ';
    
    try
    {      
       if(!empty($comment) && $comment === true)
       {
           $prepared_query = 'SELECT * FROM replace_value
                              WHERE statusL'.$current_language.' = 1
                              AND commentL'.$current_language.' = 1
                              ORDER BY sourceL'.$current_language;
           
           $query = $connectData->prepare($prepared_query);
           $query->execute();
           $i = 0;
           while($data = $query->fetch())
           {   
               /*Insert request values in arrays*/
               $array_unmodified_char[$i] = $data['sourceL'.$current_language];
               
               if(!empty($comreplacechar))
               {
                   $length_unmodifiedchar = strlen($data['sourceL'.$current_language]);
                   unset($modifiedchar); 
                   for($j = 0; $j < $length_unmodifiedchar; $j++)
                   {
                       if($j == 0)
                       {
                           $modifiedchar = $comreplacechar;
                       }
                       else
                       {
                           $modifiedchar .= $comreplacechar;
                       }
                   }
                   $array_modified_char[$i] = $modifiedchar;
               }
               else
               {
                   $array_modified_char[$i] = $data['replaceL'.$current_language];
               }
               $i++;
           }
           $query->closeCursor();
       }
       else
       {
           if(!empty($keyword) && $keyword === true)
           {
               $type_replace = 'keywordL'.$current_language;
           }
           else
           {
               $type_replace = 'searchL'.$current_language;
           }
           
           $prepared_query = 'SELECT * FROM replace_value
                              WHERE statusL'.$current_language.' = 1
                              AND '.$type_replace.' = 1
                              ORDER BY sourceL'.$current_language;
           
           $query = $connectData->prepare($prepared_query);
           $query->execute();
           $i = 0;
           while($data = $query->fetch())
           {   
               /*Insert request values in arrays*/
               $array_unmodified_char[$i] = $data['sourceL'.$current_language];
               $array_modified_char[$i] = $data['replaceL'.$current_language];
               $i++;
           }
           $query->closeCursor();
       }
       $testbok = false;
       for($i = 0, $count = count($array_unmodified_char); $i < $count; $i++)
       {
           $k = 0;
           $flag = 0;
           $nexty = 0;
           $length_unmodified = strlen($array_unmodified_char[$i]);
           unset($keepyindex, $create_dirty);
           $length_string = strlen($string);
           
           for($y = 0, $county = $length_string; $y < $county; $y++)
           {
               if($string[$y] == $array_unmodified_char[$i][$k])
               {
                   $keepyindex[$flag] = $y;
		   if(isset($create_dirty)) {
                   	$create_dirty .= $array_unmodified_char[$i][$k];
		   } else {
			$create_dirty = $array_unmodified_char[$i][$k];
		   }
                   $flag++;
                   $k++;
                   
                   if($create_dirty == $array_unmodified_char[$i])
                   {
                       $previousy = $y - $length_unmodified;
                       $nexty = $y+1;
                       $current_char = $string[$nexty];
                       $first_char = $string[$previousy];
 
                       if((empty($current_char) && empty($first_char)) 
                               || ($current_char == ' ' && $first_char == ' '))
                       {
                           for($x = 0, $countx = count($keepyindex); $x < $countx; $x++)
                           {
                              $string[$keepyindex[$x]] = str_replace($string[$keepyindex[$x]], ' ', $string[$keepyindex[$x]]); 
                              if($x == ($countx - 1) && !empty($array_modified_char[$i]))
                              {
                                  $string_code = ' #'.$i.' ';
                                  $string_part1 = substr($string, 0, $keepyindex[($x-1)]);
                                  $string_part2 = substr($string, $keepyindex[$x]);
                                  $string = $string_part1.$string_code.$string_part2;                           
                              }
                           }

                           $string = str_replace('#'.$i, $array_modified_char[$i], $string);

                           unset($keepyindex,$create_dirty);
                           $nexty = 0;
                           $flag = 0;
                           $k = 0;
                           $y = 0;
                           $i = 0;
                           $string = preg_replace('#[ ]{2,}#', ' ', $string);
                           $length_string = strlen($string);
                       }
                       else
                       {
                           unset($keepyindex,$create_dirty);
                           $nexty = 0;
                           $flag = 0;
                           $k = 0;
                           $length_string = strlen($string);
                       }
                   }                  
               }
               else
               {
                   if(!empty($keepyindex[0]))
                   {
                       unset($keepyindex,$create_dirty);
                       $nexty = 0;
                       $flag = 0;
                       $k = 0;
                       $length_string = strlen($string);
                   }
               }
           }
       }
       if(empty($comment) || $comment != true)
       {
           $string = strtolower($string);
       } 
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
    $string = trim(preg_replace('#[ ]{2,}#', ' ', $string));
    return $string;
}

function str_replace_char($string, $current_language, $search, $keyword, $comment, $comreplacechar)
{     
    unset($array_unmodified_char, $array_modified_char);
    $header = ["REQUEST_URI"];
    $include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
    include('modules/dbconnect/dinxdev/dbconnect.php');
    
    if(empty($current_language))
    {
       $prepared_query = 'SELECT id_language FROM language
                          WHERE priority_language = 1';
       $query = $connectData->prepare($prepared_query);
       $query->execute();
       if(($data = $query->fetch()) != false)
       {
           $current_language = $data[0];
       }
       $query->closeCursor();
    }
    
    try
    {      
       if(!empty($comment) && $comment === true)
       {
           $prepared_query = 'SELECT * FROM replace_char
                              WHERE statusL'.$current_language.' = 1
                              AND commentL'.$current_language.' = 1
                              ORDER BY sourceL'.$current_language;
           
           $query = $connectData->prepare($prepared_query);
           $query->execute();
           $i = 0;
           while($data = $query->fetch())
           {   
               /*Insert request values in arrays*/
               $array_unmodified_char[$i] = $data['sourceL'.$current_language];
               
               if(!empty($comreplacechar))
               {
                   $length_unmodifiedchar = strlen($data['sourceL'.$current_language]);
                   unset($modifiedchar); 
                   for($j = 0; $j < $length_unmodifiedchar; $j++)
                   {
                       if($j == 0)
                       {
                           $modifiedchar = $comreplacechar;
                       }
                       else
                       {
                           $modifiedchar .= $comreplacechar;
                       }
                   }
                   $array_modified_char[$i] = $modifiedchar;
               }
               else
               {
                   $array_modified_char[$i] = $data['replaceL'.$current_language];
               }
               $i++;
           }
           $query->closeCursor();
       }
       else
       {
           if(!empty($keyword) && $keyword === true)
           {
               $type_replace = 'keywordL'.$current_language;
           }
           else
           {
               $type_replace = 'searchL'.$current_language;
           }
           
           $prepared_query = 'SELECT * FROM replace_char
                              WHERE statusL'.$current_language.' = 1
                              AND '.$type_replace.' = 1
                              ORDER BY sourceL'.$current_language;
           
           $query = $connectData->prepare($prepared_query);
           $query->execute();
           $i = 0;
           while($data = $query->fetch())
           {   
               /*Insert request values in arrays*/
               $array_unmodified_char[$i] = $data['sourceL'.$current_language];
               $array_modified_char[$i] = $data['replaceL'.$current_language];
               $i++;
           }
           $query->closeCursor();
       }
       
       $string = str_replace($array_unmodified_char, $array_modified_char, $string);
       
       if(empty($comment) || $comment != true)
       {
           $string = strtolower($string);
       }
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$header.'Error/400'));
        }
        else
        {
            die(header('Location: '.$header.'Backoffice/Error/400'));
        } 
    }
    $string = preg_replace('#[ ]{2,}#', ' ', $string);
    return $string;
}

function split_number($array)
{
    $splited_array = explode(',', $array);
    
    return $splited_array; 
}

function split_string($array, $arg)
{
    $splited_array = explode($arg, $array);
    
    return $splited_array; 
}

function split_priority_product($array)
{
    $splited_array = explode('#', $array);
    
    return $splited_array;
    
    
}

function split_comboard($text)
{
    
    $temp_text = null;
    $jump_ligne = false;
    $jump_ligne_next = false;
    
    
    $exploded_text = explode("\n", $text);
       
    $k = 0;
    
    for($j = 0; $j < count($exploded_text); $j++)
    {
        $count_text = strlen($exploded_text[$j]);
        $text = str_replace("\n", '', $exploded_text[$j]);
        
        if($count_text > 89 && $count_text != 90)
        {
            for($i = 0; $i < $count_text; $i++)
            {
               $temp_text .= $text[$i];
               if($k == 89 || $jump_ligne_next == true)
               {
                   if($text[$i] == ' ')
                   {
                       $temp_text .= "\n";
                       $jump_ligne = true;
                       $jump_ligne_next = false;
                       $k = 0;
                   }
                   else
                   {
                       $jump_ligne_next = true;
                       $jump_ligne = false;
                   }                                
               }
               else
               {
                  $jump_ligne = false;
                  $jump_ligne_next = false;
               }

               if($jump_ligne == false)
               {
                  $k++;
               }
            }
        }
        else
        {
            $temp_text .= $exploded_text[$j]."\n";
        }
    }
    
    $text = $temp_text;
    
    return $text;
}
?>
