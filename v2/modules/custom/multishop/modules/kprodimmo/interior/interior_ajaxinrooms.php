<?php session_start();
header('Access-Control-Allow-Origin: '.$myUrl1);
header('Access-Control-Allow-Credentials: true');
header('Cache-Control: no-cache');

if(isset($_POST['nbrooms']))
{
    if(!empty($_POST['nbrooms']))
    { 
        $total_piecesininterior = trim(htmlspecialchars($_POST['nbrooms'], ENT_QUOTES)); 
    }
    else
    {
        $total_piecesininterior = 0;
    }   
    
    $database_host = 'localhost';
    $database_connect = 'dbname=dinxdev'; //database name
    $database_user = 'dinxdevdb';
    $database_pass = 'Kk2uZ7r5sQ7g7H4sN';
    $config_customheader = $COOBOX_BASE_URL;
    
    try
    {
       //connect to database
       $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
       $pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
       $connectData = new PDO('mysql:host='.$database_host.'; '.$database_connect.'', ''.$database_user.'',
                                ''.$database_pass.'', $pdo_options);

       $connectData->query('SET NAMES UTF8');
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
    
    #LANGUAGE
    $prepared_query = 'SELECT * FROM language
                      WHERE status_language = 1
                      ORDER BY priority_language DESC, position_language';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $main_activatedidlang[$i] = $data[0];
        $main_activatedcodelang[$i] = $data['code_language'];
        $i++;
    }
    $query->closeCursor();
    
    #INTERIOR PIECES IN
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesin_interior"
                       ORDER BY position_cdreditor, L'.$_SESSION['current_language'].'S';
    $_SESSION['prepared_query'] = $prepared_query;
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesininterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesininterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesininterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesininterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesininterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesininterior[$i] = $data['L'.$_SESSION['current_language'].'S'];
        $kprodimmo_nameP_piecesininterior[$i] = $data['L'.$_SESSION['current_language'].'P'];
        $i++;
    }
    $query->closeCursor();
    
    #INTERIOR PIECES IN DETAILS
    $prepared_query = 'SELECT * FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_piecesindetails_interior"
                       ORDER BY position_cdreditor, L'.$_SESSION['current_language'].'S';
    $_SESSION['prepared_query'] = $prepared_query;
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('code', 'cdreditor.type_object');
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $kprodimmo_id_piecesindetailsinterior[$i] = $data['id_cdreditor'];
        $kprodimmo_code_piecesindetailsinterior = $data['code_cdreditor'];
        $kprodimmo_status_piecesindetailsinterior = $data['status_cdreditor'];
        $kprodimmo_statusobject_piecesindetailsinterior[$i] = $data['statusobject_cdreditor'];
        $kprodimmo_type_piecesindetailsinterior = $data['type_cdreditor'];
        $kprodimmo_nameS_piecesindetailsinterior[$i] = $data['L'.$_SESSION['current_language'].'S'];
        $kprodimmo_nameP_piecesindetailsinterior[$i] = $data['L'.$_SESSION['current_language'].'P'];
        $i++;
    }
    $query->closeCursor();
    
    function split_string($array, $arg)
    {
        $splited_array = explode($arg, $array);

        return $splited_array; 
    }
    
    function cut_string($string, $start, $end, $punctuation)
    {
        if(strlen($string) > $end)
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
            $cutted_string = substr($string, $start, $end).$punctuation;
        }
        else
        {
            $cutted_string = $string;
        }

        return $cutted_string;
    }  
    
    function give_translation($code, $echo, $showtranslationcode)
    {
        $header = $COOBOX_BASE_URL;
        $database_host = 'localhost';
        $database_connect = 'dbname=dinxdev'; //database name
        $database_user = 'dinxdevdb';
        $database_pass = 'Kk2uZ7r5sQ7g7H4sN';
        $config_customheader = $COOBOX_BASE_URL;

        try
        {
           //connect to database
           $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
           $pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
           $connectData = new PDO('mysql:host='.$database_host.'; '.$database_connect.'', ''.$database_user.'',
                                    ''.$database_pass.'', $pdo_options);

           $connectData->query('SET NAMES UTF8');
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

        $current_language = $_SESSION['current_language'];
        $translate_sentence = null;
        $Bok_exist_translation = false;

        try
        {       
            $prepared_query = 'SELECT id_translation, L'.$current_language.' FROM translation
                               WHERE code_translation = :code';           
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('code', $code);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $Bok_exist_translation = true;
                $translate_id = $data[0];
                $translate_sentence = $data[1];
            }
            $query->CloseCursor();

            if(!empty($echo) && $echo == 'false')
            {
                return $translate_sentence;
            }
            else
            {  
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
    
    function cdreditor($type, $valueP, $code, $status, $id, $selected, $isfirstoption, $insertinput, $inputstyle, $inputtype, $inputname, $inputother, $inputsession, $quicksearch, $chknrtd, $displaydecimal, $showresult, $datacolumn, $dataoperator, $cutstring, $cutcount, $cutpunctuation, $js)
    {
        if(!empty($showresult) && $showresult == 'true' && !empty($datacolumn) && !empty($dataoperator))
        {
            $header = $COOBOX_BASE_URL;
            $database_host = 'localhost';
            $database_connect = 'dbname=dinxdev'; //database name
            $database_user = 'dinxdevdb';
            $database_pass = 'Kk2uZ7r5sQ7g7H4sN';
            $config_customheader = $COOBOX_BASE_URL;

            try
            {
               //connect to database
               $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
               $pdo_options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
               $connectData = new PDO('mysql:host='.$database_host.'; '.$database_connect.'', ''.$database_user.'',
                                        ''.$database_pass.'', $pdo_options);

               $connectData->query('SET NAMES UTF8');
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

                    echo(' >'.'---'.'</option>');
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
                                    echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.cut_string($valueP[$i], 0 , $cutcount, $cutpunctuation).$count_id_product.'</span></label>');
                                }
                                else
                                {
                                    echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.$valueP[$i].$count_id_product.'</span></label>');
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
                                echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.cut_string($valueP[$i], 0 , $cutcount, $cutpunctuation).$count_id_product.'</span></label>');
                            }
                            else
                            {
                                echo('<label for="'.$code.$id[$i].'"><span style="margin-left: 2px; cursor: pointer;" class="font_main">'.$valueP[$i].$count_id_product.'</span></label>');
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
    
    if(!empty($_SESSION['Kprodimmo_interior_cdreditor_piecesin_interior']))
    {

        $piecesin_interior = split_string($_SESSION['Kprodimmo_interior_cdreditor_piecesin_interior'], '#');

        for($i = 0, $count = count($piecesin_interior); $i < $count; $i++)
        {
            $piecesin_interior[$i] = split_string($piecesin_interior[$i], '$');
        }
    }    
    
    for($i = 1, $y = 0; $i <= $total_piecesininterior; $i++, $y++)
    {
        #interior pieces in
        if($kprodimmo_status_piecesininterior == 1 || $kprodimmo_status_piecesindetailsinterior == 1)
        {
            $kprodimmo_piecesininterior_bok_details_hide = true;
            $kprodimmo_piecesininterior_details = split_string($piecesin_interior[$y][5], '@');
            $kprodimmo_piecesininterior_details_content = null;
            for($x = 0, $countx = count($main_activatedidlang); $x < $countx; $x++)
            {
                $kprodimmo_piecesininterior_details_content[$x] = split_string($kprodimmo_piecesininterior_details[$x], '&');
                if(!empty($kprodimmo_piecesininterior_details_content[$x][0]))
                {
                    $kprodimmo_piecesininterior_bok_details_hide = 'false';
                }
            }
?>
        <tr>
            <td align="left" style="width: 25px;">
                <span class="font_subtitle"><?php echo($i); ?>&nbsp;</span>
            </td>
            <td align="left" style="width: 50px;">
                <span class="font_main">B:</span>
                <input style="width: 20px;" type="text" name="txtKprodimmoBuildingIn<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesin_interior[$y][0]) || $piecesin_interior[$y][0] === '0'){ echo($piecesin_interior[$y][0]); } ?>"/>
            </td>
            <td align="left" style="width: 50px;">
                <span class="font_main">E:</span>
                <input style="width: 20px;" type="text" name="txtKprodimmoFloorIn<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesin_interior[$y][1]) || $piecesin_interior[$y][1] === '0'){ echo($piecesin_interior[$y][1]); } ?>"/>
            </td>
            <td align="left" style="width: 110px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
    <?php            
                        if($kprodimmo_status_piecesininterior == 1)
                        {
                            cdreditor($kprodimmo_type_piecesininterior, $kprodimmo_nameS_piecesininterior, $kprodimmo_code_piecesininterior.$i, $kprodimmo_statusobject_piecesininterior, $kprodimmo_id_piecesininterior, $piecesin_interior[$y][2], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 6, '...');   
                        }
    ?>                                            
                        </td>
                        <td align="center">
                            <img id="piecesininterior<?php echo($i); ?>" style="cursor: pointer;" src="<?php echo($config_customheader.'graphics/icons/use/edit2.gif'); ?>" alt="edit.gif" title="<?php //give_translation('immo.kprod_interior_edit', $echo, $config_showtranslationcode); ?>" onclick="hideshow('piecesininterior_details<?php echo($i); ?>', 'piecesininterior<?php echo($i); ?>', '', '')"/>
                            &nbsp;
                        </td>
                    </tr>                                    
                </table>
            </td>
            <td align="left" style="width: 60px;">
                <input style="width: 30px;" type="text" name="txtKprodimmoSurfaceIn<?php echo($i); ?>" value="<?php if(!empty($piecesin_interior[$y][3])){ echo($piecesin_interior[$y][3]); } ?>"/>
                <span class="font_main">m²</span>
                &nbsp;
            </td>
            <td align="left" style="width: 110px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
<?php            
                        if($kprodimmo_status_piecesindetailsinterior == 1)
                        {
                            cdreditor($kprodimmo_type_piecesindetailsinterior, $kprodimmo_nameS_piecesindetailsinterior, $kprodimmo_code_piecesindetailsinterior.$i, $kprodimmo_statusobject_piecesindetailsinterior, $kprodimmo_id_piecesindetailsinterior, $piecesin_interior[$y][4], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 8, '...'); 
                        }
?>                                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr id="piecesininterior_details<?php echo($i); ?>" style="<?php if(empty($kprodimmo_piecesininterior_bok_details_hide) || $kprodimmo_piecesininterior_bok_details_hide === true){ echo('display: none;'); } ?>">
            <td colspan="6">               
                <table width="100%" cellpadding="0" cellspacing="1">
<?php
            for($x = 0, $countx = count($main_activatedidlang); $x < $countx; $x++)
            {                               
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">
                            <?php give_translation($main_activatedcodelang[$x], $echo, $config_showtranslationcode); ?>
                        </span>
                    </td> 
                    <td align="left" width="70%">
                        <input type="text" name="txtKprodimmoDetailsIn<?php echo($i.'-'.$main_activatedidlang[$x]); ?>" style="width: 99%;" value="<?php if($kprodimmo_piecesininterior_details_content[$x][1] == $main_activatedidlang[$x]){ echo($kprodimmo_piecesininterior_details_content[$x][0]); } ?>"/>
                    </td>
                </tr>
<?php                              
            }
?>
                </table>
            </td>
        </tr>
<?php
        unset($kprodimmo_piecesininterior_details_content);
        }
    }    
}
?>
