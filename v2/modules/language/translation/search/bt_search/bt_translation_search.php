<?php
if(isset($_POST['bt_translation_search']) || ($_SESSION['translation_search_result_count'] === 0 && $_SESSION['translation_search_loopcount'] <= 5))
{
    unset($_SESSION['msg_translation_edit_modify_done'],
            $_SESSION['msg_translation_code_error']);
    $_SESSION['translation_search_done'] = true;
    
    $array_result_sentence[] = 0; /*arrays created*/
    $array_result_and[] = 0;
    $array_result_or[] = 0;
    $array_for_key[] = 0;
    $array_listing_result = null;

    $temp_array_result_or[] = 0; /*temporary arrays created*/
    $temp_array_result_and[] = 0;
    $temp_array_result_sentence[] = 0;
        
    
    $result = true; /*Booleans created*/
    $result_and = true;
    $result_or = true;
    $Bok_translation_search_noresult = false;
    
    /*Get typed words by user into the navbar textfield and erase whitespace 
     * front and behind the sentence*/
    
    if($_SESSION['translation_search_result_count'] === 0)
    {
        $sentence = $_SESSION['translation_search_txtTranslationSearch_2'];
    }
    
    if(isset($_POST['bt_translation_search']))
    {
        $sentence = trim(htmlspecialchars($_POST['txtTranslationSearch'], ENT_QUOTES));  
    }

    if(!empty($sentence)) /*if $sentence variable isn't empty*/
    {
        $Bok_search = true; /*$Bok_search becomes true*/
    }
    else
    {
        $Bok_search = false;
    }
    
    $sentence = preg_replace('#[ ]{2,}#', ' ', $sentence);
    
    if(isset($_POST['bt_translation_search']))
    {
        $_SESSION['translation_search_txtTranslationSearch_1'] = $sentence;
    }
    
    $length_sentence = strlen($sentence);
    
    if($_SESSION['translation_search_result_count'] === 0)
    {
        $sentence = substr($sentence, 0, ($length_sentence - 1));
        if(empty($sentence))
        {
            $Bok_search = false;
        }
        $_SESSION['translation_search_loopcount'] += 1;
    }
    
    $_SESSION['translation_search_txtTranslationSearch_2'] = $sentence;
    
    /*extract all separated words by whitespace and include them in an array*/
    $keywords = explode(' ', $sentence);
    
    if($Bok_search == true)/*if $Bok_search = true, program can continue*/
    {
        try
        {
            if($sentence != '*')
            {
                if($sentence == '#*')
                {
                    
                    /*----------First : search keywords one by one in PAGE table-------*/
                    $query_string_or = 'SELECT *                                 
                                        FROM translation
                                        WHERE ';

                    /*makes so much loop as there is keywords*/
                    for($i = 0; $i < count($keywords); $i++)
                    {
                        $query_string_or .= 'code_translation = "" OR ';
                        /*add in $query_string_or variable a query string*/
                        for($y = 1; $y <= $countall_language; $y++)
                        {
                            $query_string_or .= 'L'.$y.' = "" ';

                            if($y < $countall_language)
                            {
                               $query_string_or .= 'OR ';
                            }
                        }

                        if($i != (count($keywords) - 1))/*if for loop doesn't finish add 'OR'*/
                        {
                           $query_string_or .= 'OR ';
                        }
                        else /*at the end of the loop add 'Order by...'*/
                        {
                           $query_string_or .= ' ORDER BY code_translation';
                        }

                    }

                    /*execute the query*/
                    $_SESSION['prepared_query'] = $query_string_or;
                    $query_or = $connectData->prepare($query_string_or);
                    $query_or->execute();
                    $i = 0;
                    /*put result in an array*/
                    while($result_or = $query_or->fetch())
                    {
                        $array_result_or[$i] = $result_or[0];
                        $i++;
                    }
                    $query_or->closeCursor();
                }
                else
                {
                        /*----------First : search keywords one by one in PAGE table-------*/
                    $query_string_or = 'SELECT *                                 
                                        FROM translation
                                        WHERE ';

                    /*makes so much loop as there is keywords*/
                    for($i = 0; $i < count($keywords); $i++)
                    {
                        $query_string_or .= 'code_translation LIKE "%'.$keywords[$i].'%" OR ';
                        /*add in $query_string_or variable a query string*/
                        for($y = 1; $y <= $countall_language; $y++)
                        {
                            $query_string_or .= 'L'.$y.' LIKE "%'.$keywords[$i].'%" ';

                            if($y < $countall_language)
                            {
                               $query_string_or .= 'OR ';
                            }
                        }

                        if($i != (count($keywords) - 1))/*if for loop doesn't finish add 'OR'*/
                        {
                           $query_string_or .= 'OR ';
                        }
                        else /*at the end of the loop add 'Order by...'*/
                        {
                           $query_string_or .= ' ORDER BY code_translation';
                        }

                    }

                    /*execute the query*/
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
                    $query_string_and = 'SELECT *                                 
                                         FROM translation
                                         WHERE '; 

                    for($i = 0; $i < count($keywords); $i++)
                    {
                        $query_string_and .= 'code_translation LIKE "%'.$keywords[$i].'%" AND ';

                        for($y = 1; $y <= $countall_language; $y++)
                        {
                            $query_string_and .= 'L'.$y.' LIKE "%'.$keywords[$i].'%" ';

                            if($y < $countall_language)
                            {
                               $query_string_and .= 'OR ';
                            }
                        }

                        if($i != (count($keywords) - 1))
                        {
                            $query_string_and .= 'AND ';
                        }
                        else
                        {
                            $query_string_and .= 'ORDER BY code_translation';
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
                
                    $query_string_sentence = 'SELECT *                                 
                                             FROM translation
                                             WHERE '; 

                    for($i = 0; $i < count($keywords); $i++)
                    {
                        $query_string_sentence .= 'code_translation = "'.$_SESSION['translation_search_txtTranslationSearch_1'].'" OR ';

                        for($y = 1; $y <= $countall_language; $y++)
                        {
                            $query_string_sentence .= 'L'.$y.' = "'.$_SESSION['translation_search_txtTranslationSearch_1'].'" ';

                            if($y < $countall_language)
                            {
                               $query_string_sentence .= 'OR ';
                            }
                        }

                        if($i != (count($keywords) - 1))
                        {
                            $query_string_sentence .= 'OR ';
                        }
                        else
                        {
                            $query_string_sentence .= 'ORDER BY code_translation';
                        }
                    }

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

              $array_listing_result[$i] = 'and';                   
              $i++;

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
                  $array_listing_result[$i] = 'or';          
                  $i++;

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
              $_SESSION['translation_search_result_count'] = $last_key;
              /*same as above but with the contents of $array_listing_result*/
              $_SESSION['translation_search_listing_result'] = $array_listing_result;
              $_SESSION['translation_search_keywords'] = $keywords;
              
              if($_SESSION['translation_search_result_count'] > 0 || $_SESSION['translation_search_loopcount'] > 5)
              {
                  unset($_SESSION['translation_search_loopcount']);
                  if($_SESSION['translation_search_result_count'] === 0)
                  {
                      $_SESSION['translation_search_result_count'] = 'null';
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
        unset($_SESSION['translation_search_txtTranslationSearch']);
        /*and listing result value at first index becomes null*/
        $_SESSION['translation_search_listing_result'][0] = null;
        
        $_SESSION['translation_search_result_count'] = 0;
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Gestion/Traductions');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Gestion/Traductions');
    }
}
?>
