<?php
if(isset($_POST['bt_main_search']) || ($_SESSION['searchmain_search_result_count'] === 0 && $_SESSION['searchmain_search_loopcount'] <= 5))
{
    unset($array_result_sentence,$array_result_and,$array_result_or,
            $array_for_key,$array_listing_result,$temp_array_result_or,
            $temp_array_result_and,$temp_array_result_sentence, $keywords); /*arrays created*/
    unset($_SESSION['searchmain_txtMainSearch'],
            $_SESSION['searchmain_transformed_txtMainSearch']);
    unset($_SESSION['paging_defaultdisplay'],
            $_SESSION['paging_selected_page']);
    
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

    $_SESSION['searchmain_search_done'] = true;        
    
    $result = true; /*Booleans created*/
    $result_and = true;
    $result_or = true;
    $Bok_searchmain_search_noresult = false;
    
    /*Get typed words by user into the navbar textfield and erase whitespace 
     * front and behind the sentence*/
    
    if($_SESSION['searchmain_search_result_count'] === 0)
    {
        $sentence = $_SESSION['searchmain_search_txtsearchmainSearch_2'];
    }
    
    if(isset($_POST['bt_main_search']))
    {
        $sentence = trim(htmlspecialchars($_POST['txtMainSearch'], ENT_QUOTES));
        if($sentence == $searchmainbox_defaultvalue)
        {
            $sentence = null;
        }
        $_SESSION['searchmain_txtMainSearch'] = $sentence;
    }

    if(!empty($sentence) && strlen($sentence) > 2) /*if $sentence variable isn't empty*/
    {
        $Bok_search = true; /*$Bok_search becomes true*/
    }
    else
    {
        $Bok_search = false;
    }
    
    $sentence = preg_replace('#[ ]{2,}#', ' ', $sentence);
    
    if(isset($_POST['bt_main_search']))
    {
        $_SESSION['searchmain_search_txtsearchmainSearch_1'] = $sentence;
    }
    
    $length_sentence = strlen($sentence);
    
    if($_SESSION['searchmain_search_result_count'] === 0)
    {
        $sentence = substr($sentence, 0, ($length_sentence - 1));
        if(empty($sentence))
        {
            $Bok_search = false;
        }
        $_SESSION['searchmain_search_loopcount'] += 1;
    }
    
    $_SESSION['searchmain_search_txtsearchmainSearch_2'] = $sentence;
    
    $modified_sentence = str_replace_char($sentence, $main_id_language, true);
    $modified_sentence = replace_dirtyword($modified_sentence, $main_id_language, true);
    /*extract all separated words by whitespace and include them in an array*/
    $keywords = split_string($modified_sentence, ' ');

    if($Bok_search == true)/*if $Bok_search = true, program can continue*/
    {
        try
        {
            if($sentence != '*')
            {                
                /*----------First : search keywords one by one in PAGE table-------*/
                $query_string_or = 'SELECT DISTINCT page.id_page                                 
                                    FROM page
                                    INNER JOIN page_translation
                                    ON page.id_page = page_translation.id_page
                                    WHERE status_search_page = 1 
                                    AND status_page = 1 AND (family_page_translation = "title" 
                                    OR family_page_translation = "intro"
                                    OR family_page_translation = "tags") 
                                    AND (';

                for($i = 0, $count = count($keywords); $i < $count; $i++)
                {
                    $query_string_or .= 'L'.$main_id_language.' LIKE "%'.$keywords[$i].'%" ';

                    if($i == ($count - 1))
                    {
                       $query_string_or .= ') ORDER BY family_page DESC, L'.$main_id_language;
                    }
                    else
                    {
                       $query_string_or .= 'OR ';
                    }
                }

                $_SESSION['prepared_query'] = $query_string_or;
                $query_or = $connectData->prepare($query_string_or);
                $query_or->execute();
                $i = 0;
                /*put result in an array*/
//                for($i = 0; $i < count($array_result_or); $i++)
//                {
                    while($result_or = $query_or->fetch())
                    {
                        $array_result_or[$i] = $result_or[0];
                        $i++;
                    }
                    $query_or->closeCursor();
//                }



               /*--------------In second : search all keywords--------------------*/

                /*Same as above but 'AND' replace 'OR' in the request*/
                $query_string_and = 'SELECT DISTINCT page.id_page                                 
                                     FROM page
                                     INNER JOIN page_translation
                                     ON page.id_page = page_translation.id_page
                                     WHERE status_search_page = 1 
                                     AND status_page = 1 AND (family_page_translation = "title" 
                                     OR family_page_translation = "intro"
                                     OR family_page_translation = "tags")
                                     AND '; 

                for($i = 0, $count = count($keywords); $i < $count; $i++)
                {
                    $query_string_and .= 'L'.$main_id_language.' LIKE "%'.$keywords[$i].'%" ';

                    if($i == ($count - 1))/*if for loop doesn't finish add 'OR'*/
                    {
                       $query_string_and .= ' ORDER BY family_page DESC, L'.$main_id_language;
                    }
                    else /*at the end of the loop add 'Order by...'*/
                    {
                       $query_string_and .= 'AND ';
                    }
                }

                $i = 0;
                $_SESSION['prepared_query'] = $query_string_and;
                $query_and = $connectData->prepare($query_string_and);
                $query_and->execute();

                while($result_and = $query_and->fetch())
                {
                    $array_result_and[$i] = $result_and[0]; 
                    $i++;
                }
                $query_and->closeCursor();

                /*Finally : search sentence into tags_pages column according to the selected language*/

                $query_string_sentence = 'SELECT DISTINCT page.id_page                                 
                                          FROM page
                                          INNER JOIN page_translation
                                          ON page.id_page = page_translation.id_page
                                          WHERE status_search_page = 1 AND 
                                          status_page = 1 AND (family_page_translation = "title" 
                                          OR family_page_translation = "intro"
                                          OR family_page_translation = "tags")
                                          AND '; 


                $query_string_sentence .= 'L'.$main_id_language.' = "'.$_SESSION['searchmain_search_txtsearchmainSearch_1'].'" ';
                $query_string_sentence .= ' ORDER BY family_page DESC, L'.$main_id_language;  
                

                $_SESSION['prepared_query'] = $query_string_sentence;
                $query_sentence = $connectData->prepare($query_string_sentence);
                $query_sentence->execute();
                $i = 0;
                while($result_sentence = $query_sentence->fetch())
                {
                    $array_result_sentence[$i] = $result_sentence[0]; 
                    $i++;
                }
                $query_sentence->closeCursor();

            }
            else
            {
                $query_string_sentence = 'SELECT DISTINCT page.id_page                                 
                                          FROM page_translation
                                          INNER JOIN page
                                          ON page.id_page = page_translation.id_page
                                          WHERE status_search_page = 1
                                          AND status_page = 1
                                          AND family_page_translation ="title"'; 

                $query_string_sentence .= ' ORDER BY family_page DESC, L'.$main_id_language;  
                

                $_SESSION['prepared_query'] = $query_string_sentence;
                $query_sentence = $connectData->prepare($query_string_sentence);
                $query_sentence->execute();
                $i = 0;
                while($result_sentence = $query_sentence->fetch())
                {
                    $array_result_sentence[$i] = $result_sentence[0]; 
                    $i++;
                }
                $query_sentence->closeCursor();
            }


              /*-------------- Delete doublons ---------------------------*/
              $k = 0;
              $x = 0;
              $j = 0;
              $i = 0;
              
              if($array_result_sentence[0] != 0 && $array_result_sentence[0] != null)
              {
                  for($j = 0; $j < count($array_result_sentence); $j++)
                  {
                     $array_listing_result[$i] = $array_result_sentence[$j];
                     $i++;
                  }

                  if(count($array_result_sentence) > 1)
                  {
                     $i++;
                  }
              }

              //$array_listing_result[$i] = 'and';                   
              //$i++;

              /*Same as above With $array_result_and, request results with 'AND' include
               * in $array_listing following previous values*/
              if($array_result_and[0] != 0 && $array_result_and[0] != null)
              {
                  for($j = 0; $j < count($array_result_and); $j++)
                  {
                     $array_listing_result[$i] = $array_result_and[$j];
                     $i++;
                  }

                  if(count($array_result_and) > 1)
                  {
                     $i++;
                  }
              }
                  //$array_listing_result[$i] = 'or';          
                  //$i++;

              /*Finally request results with 'OR' added at the end*/    
              if($array_result_or[0] != 0 && $array_result_or[0] != null)
              {
                  for($j = 0; $j < count($array_result_or); $j++)
                  {
                     $array_listing_result[$i] = $array_result_or[$j]; 
                     $i++;
                  }
              }

              /*this function counts doublons into an array (useless here)*/
              $count_duplicate_value = array_count_values($array_listing_result);

              /*this function delete all doublons into an array*/
              $array_listing_result = array_unique($array_listing_result);

              /*but doublons become 'null' in the array*/
              $j = 0;
              $y = 0;

              /*the purpose of this loop is to delete index where its value is null*/
              for($i = 0; $i < count($array_listing_result); $i++)
              {
                  if(@$array_listing_result[$k] == null)/*if value at $k index is null*/
                  {
                     $k++;/*we advance to next index*/                   
                  }

                  /*if value at $k index isn't null AND != 'or' AND != 'and'*/
                  if(@$array_listing_result[$k] != null && @$array_listing_result[$k] != 'or' 
                          && @$array_listing_result[$k] != 'and')
                  {
                      /*values included in an array which will go to serve to 
                       * count number of search results*/
                      $array_for_key[$y] = $array_listing_result[$k];                  
                      $y++;
                  }
                  
                  if(@$array_listing_result[$k] === 'and' || @$array_listing_result[$k] === 'or')
                  {
                      $i--;
                  }


                  /*if value at $k index isn't null*/
                  if(@$array_listing_result[$k] != null)
                  {
                      /*value included in a temporary array*/
                      $temp[$j] = $array_listing_result[$k]; 

                      $j++;
                      $k++;
                  }                          
              }
             
              /*$temp values re-enter into $array_listing_result*/
              $array_listing_result = $temp;

              $k = 0;        

              /*if $array_for_key at 0 index is null, 
               * then the search doesn't found anything, thus result number = 0*/
              if($array_for_key[0] == null)
              {
                  $last_key = 0;
              }
              else
              {
                  /*we count number of index into the $array_for_key in order
                    to know the exact result number*/
                  $last_key = count($array_for_key);
              }
              

              /*--------------------------------------------------------------*/         

              /*includes result number in a Session to use it in another script*/
              $_SESSION['searchmain_search_result_count'] = $last_key;
              /*same as above but with the contents of $array_listing_result*/
              $_SESSION['searchmain_search_listing_result'] = $array_listing_result;
              $_SESSION['searchmain_search_keywords'] = $keywords;
              
              if($_SESSION['searchmain_search_result_count'] > 0 || $_SESSION['searchmain_search_loopcount'] > 5)
              {
                  unset($_SESSION['searchmain_search_loopcount']);
                  if($_SESSION['searchmain_search_result_count'] === 0)
                  {
                      $_SESSION['searchmain_search_result_count'] = 'null';
                  }
              }
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
    }
    else /*if $sentence variable is empty*/
    {
        /*destroys Session with sentence value*/
        unset($_SESSION['searchmain_search_txtsearchmainSearch']);
        /*and listing result value at first index becomes null*/
        $_SESSION['searchmain_search_listing_result'][0] = null;
        
        $_SESSION['searchmain_search_result_count'] = 0;
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
?>
