<?php
$used_language = $_SESSION['lang'];
$selected_product_id = $_SESSION['number_basic_product_edit'];

if(empty($_SESSION['product_link_firstloading']))
{
    try
    {
        $query = $connectData->prepare('SELECT number_link_product, name_product_'.$used_language.', number_product, code_category_product, code_group_product FROM product
                                       WHERE id_product = :id AND status_product = 1');

        $query->bindParam('id', htmlspecialchars($selected_product_id, ENT_QUOTES));
        $query->execute();

        while($data = $query->fetch())
        {
            $number_link = $data[0];
            $name_link = $data[1];
            $number_edited_product = $data[2];
            $code_category_product = $data[3];
            $code_group_product = $data[4];
        }

        $query->closeCursor();

        if(preg_match('#[,]{1,}#', $number_link))
        {
            $array_selected_product_link = explode(',', $number_link);
            $_SESSION['product_link_selected_array'] = $array_selected_product_link;
        }
        else
        {
            $_SESSION['product_link_selected_array'][0] = $number_link;
        }
        
        $_SESSION['product_link_selected'] = $number_link;       

        $_SESSION['product_link_firstloading'] = 'notempty';

        if(!empty($_SESSION['product_link_selected_group']))
        {
            $_SESSION['product_link_cboGroup'] = $_SESSION['product_link_selected_group'];

        }
        else
        {
            $_SESSION['product_link_cboGroup'] = $code_group_product;
        }

        //$_SESSION['test321'] = $array_selected_product_link;
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
}
else
{
    try
    {
        $query = $connectData->prepare('SELECT number_link_product, name_product_'.$used_language.', number_product, code_category_product, code_group_product FROM product
                                       WHERE id_product = :id AND status_product = 1');
        $query->bindParam('id', htmlspecialchars($selected_product_id, ENT_QUOTES));
        $query->execute();
        while($data = $query->fetch())
        {
            $number_link = $data[0];
            $name_link = $data[1];
            $number_edited_product = $data[2];
            $code_category_product = $data[3];
            $code_group_product = $data[4];
        }
        $query->closeCursor();
      

        $_SESSION['product_link_firstloading'] = 'notempty';
        if(!empty($_SESSION['product_link_selected_group']))
        {
            $_SESSION['product_link_cboGroup'] = $_SESSION['product_link_selected_group'];

        }
        else
        {
            $_SESSION['product_link_cboGroup'] = $code_group_product;
        }
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
}

if(isset($_POST['bt_selected_group']))
{
    // <editor-fold defaultstate="collapsed" desc="show linked product and save products which have been already selected">
    header('Location: '.$header.$_SESSION['index'].'?page=product_link');
    
    $insert_product_link = null;
    
    $selected_group = $_POST['cboGroup'];
    $selected_product_link = $_POST['multisel_product'];
    
    $_SESSION['product_link_cboGroup'] = $selected_group;

    if(!empty($_SESSION['product_link_selected']))
    {
        $insert_product_link = $_SESSION['product_link_selected'];
    }
    
    for($i = 0; $i < count($selected_product_link); $i++)
    {
       if(empty($insert_product_link))
       {
          $insert_product_link .= $selected_product_link[$i]; 
       }
       else
       {
          $insert_product_link .= ','.$selected_product_link[$i]; 
       }           
    }
      
    if(preg_match('#[,]{1,}#', $insert_product_link))
    {
        $array_selected_product_link = explode(',', $insert_product_link);
        $count_duplicate_value = array_count_values($array_selected_product_link);

        /*this function delete all doublons into an array*/
        $array_selected_product_link = array_unique($array_selected_product_link);

        $j = 0;
        $k = 0;

        /*the purpose of this loop is to delete index where its value is null*/
        for($i = 0; $i < count($array_selected_product_link); $i++)
        {
          if($array_selected_product_link[$k] == null)/*if value at $k index is null*/
          {
             $k++;/*we advance to next index*/                   
          }

          /*if value at $k index isn't null*/
          if($array_selected_product_link[$k] != null)
          {
              /*value included in a temporary array*/
              $temp[$j] = $array_selected_product_link[$k]; 

              $j++;
              $k++;
          }                          
        }
        /*$temp values re-enter into $array_listing_result*/
        $array_selected_product_link = $temp;
        $_SESSION['product_link_selected_array'] = $array_selected_product_link;
    }
    else
    {
        $_SESSION['product_link_selected_array'][0] = $insert_product_link; 
    }
    $_SESSION['product_link_selected'] = $insert_product_link;   
    $_SESSION['product_link_selected_group'] = $selected_group;
    
// </editor-fold>
}

if(isset($_POST['bt_save_product_link']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_link');
    
    $selected_group = $_POST['cboGroup'];
    $selected_product_link = $_POST['multisel_product'];
    $bok_add_number = true;
    
    
    if(!empty($_SESSION['product_link_selected_array']) && $_SESSION['product_link_selected_array'][0] != null)
    {
        $selected_product_link = array_merge($selected_product_link, $_SESSION['product_link_selected_array']);       
    }
    
    
    
    /*-------------------------- DELETE DOUBLONS -----------------------------*/
    /*this function counts doublons into an array (useless here)*/
    $count_duplicate_value = array_count_values($selected_product_link);

    /*this function delete all doublons into an array*/
    $selected_product_link = array_unique($selected_product_link);
    
    $j = 0;
    $k = 0;

    /*the purpose of this loop is to delete index where its value is null*/
    for($i = 0; $i < count($selected_product_link); $i++)
    {
      if($selected_product_link[$k] == null)/*if value at $k index is null*/
      {
         $k++;/*we advance to next index*/                   
      }

      /*if value at $k index isn't null*/
      if($selected_product_link[$k] != null)
      {
          /*value included in a temporary array*/
          $temp[$j] = $selected_product_link[$k]; 

          $j++;
          $k++;
      }                          
    }
    /*$temp values re-enter into $array_listing_result*/
    $selected_product_link = $temp;
    /*------------------------ END DELETE DOUBLONS ---------------------------*/
    
    $prepared_query = 'SELECT number_product, priority_product FROM product
                          WHERE status_product = 1'; 
    
    for($i = 0, $count = count($selected_product_link); $i < $count; $i++)
    {
        if($i == 0)
        {
            $prepared_query .= ' AND (number_product ='.$selected_product_link[$i].' ';
        }
        else
        {
            $prepared_query .= 'OR number_product ='.$selected_product_link[$i].' ';
        }
        
        if($i == ($count - 1))
        {
           $prepared_query .= ') ORDER BY priority_product';
        }
    }
    
    for($i = 0; $i < count($selected_product_link); $i++)
    {
       try #link edited product at this list
       {
           $query = $connectData->prepare('SELECT number_link_product, priority_product FROM product
                                           WHERE number_product = :number AND status_product = 1');
           
           $query->bindParam('number', htmlspecialchars($selected_product_link[$i], ENT_QUOTES));
           $query->execute();
           
           if(($data = $query->fetch()) != false)
           {
              $number_current_link = $data[0];
           }
           else
           {
              $query = $connectData->prepare('UPDATE product
                                          SET number_link_product = :number_list
                                          WHERE number_product = :number');

              $query->execute(array(
                                    'number_list' => htmlspecialchars($number_edited_product, ENT_QUOTES),
                                    'number' => htmlspecialchars($selected_product_link[$i], ENT_QUOTES)     
                                     ));

              $query->closeCursor(); 
           }
           
           if(preg_match('#[,]{1,}#', $number_current_link))
           {
               $temp_array_number_link = explode(',', $number_current_link);
           }
           else
           {
               $temp_array_number_link[0] = $number_current_link;
           }
           
           
           if($number_current_link == null)
           {
              $number_current_link = $number_edited_product; 
           }
           else
           {
              for($p = 0; $p < count($temp_array_number_link); $p++)
              {
                 if($temp_array_number_link[$p] == $number_edited_product)
                 {
                     $bok_add_number = false;
                     $p = count($temp_array_number_link);
                 }
                 else
                 {
                     $bok_add_number = true;
                 }
              }
              
              if($bok_add_number == true)
              {
                  $number_current_link .= ','.$number_edited_product;
              }
           }
           
           $query = $connectData->prepare('UPDATE product
                                          SET number_link_product = :number_list
                                          WHERE number_product = :number');

           $query->execute(array(
                                'number_list' => htmlspecialchars($number_current_link, ENT_QUOTES),
                                'number' => htmlspecialchars($selected_product_link[$i], ENT_QUOTES)     
                                 ));

           $query->closeCursor();          
          
       }
       catch (Exception $e)
       {
           die("<br>Error : ".$e->getMessage());
       }
        
//       if($i === 0)
//       {
//          $insert_product_link .= $selected_product_link[$i]; 
//       }
//       else
//       {
//          $insert_product_link .= ','.$selected_product_link[$i]; 
//       }           
    }

    try
    {
        $insert_product_link = null;
        $priority = null;
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $y = 0;
        while($data = $query->fetch())
        {
           if($y == 0)
           {
              $insert_product_link .= $data[0];
              $priority .= $data[1];
           }
           else
           {
              $insert_product_link .= ','.$data[0];
              $priority .= ','.$data[1];
           }
           $y++;             
        }
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
       

    if($code_category_product != 900)
    {
        try
        {
           $query = $connectData->prepare('UPDATE product
                                           SET number_link_product = :number_list
                                           WHERE id_product = :id');
           $query->execute(array(
                                 'number_list' => htmlspecialchars($insert_product_link, ENT_QUOTES),
                                 'id' => htmlspecialchars($selected_product_id, ENT_QUOTES)     
                                  ));
           $query->closeCursor();
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }
    }
    else
    {
        for($i = 0; $i < count($selected_product_link); $i++)
        {
            if($i == 0)
            {
                $productlink_str_list = $selected_product_link[$i];
            }
            else
            {
                $productlink_str_list .= ','.$selected_product_link[$i];
            }         
        }
        
        try
        {
           $query = $connectData->prepare('UPDATE product
                                           SET number_link_product = :number_list
                                           WHERE id_product = :id');
           $query->execute(array(
                                 'number_list' => htmlspecialchars($productlink_str_list, ENT_QUOTES),
                                 'id' => htmlspecialchars($selected_product_id, ENT_QUOTES)     
                                  ));
           $query->closeCursor();
        }
        catch (Exception $e)
        {
            die("<br>Error : ".$e->getMessage());
        }
    }
    
    $_SESSION['product_link_saved'] = 'true';
    
    //unset($_SESSION['product_link_selected'], $_SESSION['product_link_selected_array']);
    if($code_category_product != 900)
    {
        $array_selected_product_link = split_number_product($insert_product_link);
        $_SESSION['product_link_selected'] = $insert_product_link;
        $_SESSION['product_link_selected_array'] = $array_selected_product_link;
    }
    else
    {
        $array_selected_product_link = split_number_product($number_current_link);
        $_SESSION['product_link_selected'] = $number_current_link;
        $_SESSION['product_link_selected_array'] = $array_selected_product_link;
    }
    
    unset($_SESSION['product_link_selected_group'], $_SESSION['product_link_firstloading'], $_SESSION['product_link_selected'], $_SESSION['product_link_selected_array']);
    
    
}

if(isset($_POST['remove_product_link']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_link');
    
    $productlink_remove_selected_numberlink = null;
    $productlink_keepremove_selected_numberlink = null;
    $productlink_remove_numberlink = explode(',', $number_link);
    
    $y = 0;
    for($i = 0, $count = count($productlink_remove_numberlink); $i < $count; $i++)
    {
        if(trim(htmlspecialchars($_POST['chk_product_link'.$productlink_remove_numberlink[$i]])) == 1)
        {
            $productlink_remove_selected_numberlink[$y] = $productlink_remove_numberlink[$i];
            $y++;
        }
        else
        {
            if(empty($productlink_keepremove_selected_numberlink))
            {
                $productlink_keepremove_selected_numberlink = $productlink_remove_numberlink[$i];
            }
            else
            {
                $productlink_keepremove_selected_numberlink = ','.$productlink_remove_numberlink[$i];
            }
        }
    }
    
    try
    {
        $productlink_remove_listperproduct = null;
        $productlink_remove_str_listperproduct = null;
        for($i = 0, $count = count($productlink_remove_selected_numberlink); $i < $count; $i++)
        {
            
            
            $prepared_query = 'SELECT number_link_product FROM product
                               WHERE number_product = :number AND status_product = 1';
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('number', $productlink_remove_selected_numberlink[$i]);
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $productlink_remove_listperproduct = $data[0];
            }
            $query->closeCursor();
            
            if(preg_match('#[,]{1,}#', $productlink_remove_listperproduct))
            {
                $productlink_remove_listperproduct = explode(',', $productlink_remove_listperproduct);
            }
            else
            {
                $productlink_remove_listperproduct[0] = $productlink_remove_listperproduct;
            }
            
            for($y = 0, $county = count($productlink_remove_listperproduct); $y < $county; $y++)
            {
                if($productlink_remove_listperproduct[$y] != $number_edited_product)
                {
                    if(empty($productlink_remove_str_listperproduct))
                    {
                        $productlink_remove_str_listperproduct = $productlink_remove_listperproduct[$y];
                    }
                    else
                    {
                        $productlink_remove_str_listperproduct .= ','.$productlink_remove_listperproduct[$y];
                    }
                }
            }
            
            $query = $connectData->prepare('UPDATE product
                                           SET number_link_product = "'.$productlink_remove_str_listperproduct.'"
                                           WHERE number_product = :id AND status_product = 1');
            $query->execute(array(
                                 'id' => htmlspecialchars($productlink_remove_selected_numberlink[$i], ENT_QUOTES)     
                                  ));
            $query->closeCursor();
            
            unset($productlink_remove_listperproduct, $productlink_remove_str_listperproduct);
        }
        
        
        
       $query = $connectData->prepare('UPDATE product
                                       SET number_link_product = "'.$productlink_keepremove_selected_numberlink.'"
                                       WHERE id_product = :id');
       $query->execute(array(
                             'id' => htmlspecialchars($selected_product_id, ENT_QUOTES)     
                              ));
       $query->closeCursor();
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
    
    unset($_SESSION['product_link_selected_group'], $_SESSION['product_link_firstloading'], $_SESSION['product_link_selected'], $_SESSION['product_link_selected_array']);
}
?>

<HTML>
    <HEAD>
        <!-- display title at browser's tab -->
        <title>Produits liés</title>


        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


        <!-- Import my <!CSS -->
        <link rel ="stylesheet" media ="screen, projection" type ="text/css"
              title ="design" href ="css/main.css"/>
        
        <!--import my javascript-->

        <script type="text/javascript" src="script.js" lang="javascript"></script>
    </HEAD>

    <BODY>

        <div id="Main_Div_popup">
            <TABLE cellspacing="0" cellpadding="0">
                <td id="td_gapL1"></td>
                <td>
                    <form method="post"><TABLE id="Main_Table_popup">
                        <td id="td_main" valign="top">
                            <TABLE width="100%">                              
                                    <td id="center_title" colspan="2">Produits liés pour "<?php echo($name_link); ?>"</td>
                                <tr><td colspan="2"><hr></hr></td></tr>
                                    
                                        
                                <?php
                                if(!empty($_SESSION['product_link_selected_array']) && $_SESSION['product_link_selected_array'][0] != null)
                                {
                                    $array_selected_product_link = $_SESSION['product_link_selected_array'];
                                ?>
                                    <td colspan="2">
                                        <TABLE width="100%" border="0">
                                            <td>
                                            <?php
                                            for($i = 0; $i < count($array_selected_product_link); $i++)
                                            {
                                            ?>                                 
                                                    
                                                        <input type="checkbox" name="chk_product_link<?php echo($array_selected_product_link[$i]);  ?>" style="vertical-align: inherit;" value="1"/>
                
                                                        <span id="center_text">
                                                        <?php 
                                                        try
                                                        {
                                                           $query = $connectData->prepare('SELECT name_product_'.$used_language.', number_product
                                                                                           FROM product
                                                                                           WHERE number_product = :number AND status_product = 1');
                                                           
                                                           $query->bindParam('number', htmlspecialchars($array_selected_product_link[$i], ENT_QUOTES));
                                                           $query->execute();
                                                           
                                                           while($data = $query->fetch())
                                                           {
                                                               echo($data[1].' - '.$data[0]);
                                                           }
                                                           
                                                           $query->closeCursor();
                                                        }
                                                        catch (Exception $e)
                                                        {
                                                            die("<br>Error : ".$e->getMessage());
                                                        }
                                                        ?>
                                                        </span>
                                                        
                                                    
                                            <?php
                                                if($i != count($array_selected_product_link))
                                                {
                                                   echo('<br clear="left">'); 
                                                }
                                            }
                                            ?>
                                            </td>
                                            
                                        <tr></tr>
                                        
                                            <td>
                                                <input type="submit" name="remove_product_link" value="Retirer les produits sélectionnés"></input>
                                            </td>
                                            
                                        </TABLE>                                      
                                    </td>   
                                <?php
                                }
                                else
                                {
?>
                                    <td colspan="2" align="center">
                                        <span id="center_subtitle">Aucun produit n'est actuellement lié</span>
                                    </td>
<?php
                                }
                                ?>
                                
                                <tr><td colspan="2"><hr></hr></td></tr>
                                        
                                    <td id="center_subtitle" colspan="2">Groupe</td>
                                    
                                <tr></tr>
                                
                                    <td colspan="2">
                                        <SELECT name="cboGroup" onchange="OnChange('bt_selected_group')"> 
                                            <option <?php if(empty($_SESSION['product_link_cboGroup']) || $_SESSION['product_link_cboGroup'] === 'select') ?>value="select">-- Sélectionnez un groupe --</option>
                                            <?php                                         
                                               try
                                               {
                                                  $query = $connectData->query('SELECT code_group_product, name_group_product_'.$used_language.'
                                                                                FROM product_group
                                                                                WHERE status_group_product = 1
                                                                                ORDER BY name_group_product_'.$used_language); 

                                                  while($data = $query->fetch())
                                                  {
                                                      echo('<option value="'.$data[0].'" ');

                                                      if(!empty($_SESSION['product_link_cboGroup']))
                                                      {
                                                          if($_SESSION['product_link_cboGroup'] == $data[0])
                                                          {
                                                              echo('selected');
                                                          }
                                                          else
                                                          {
                                                              echo(null);
                                                          }
                                                      }

                                                      echo('>'.$data[1].'</option>');
                                                  }
                                               }
                                               catch(Exception $e)
                                               {
                                                   die("Error : ".$e->getMessage());
                                               }   
                                               $query->closeCursor();
                                            ?>                    
                                        </SELECT>
                                        <input id="bt_selected_group" type="submit" name="bt_selected_group" hidden></input>
                                    </td>
                                <?php 
                                if(!empty($_SESSION['product_link_cboGroup']) && $_SESSION['product_link_cboGroup'] != 'select')
                                {
                                ?>
                                
                                <tr></tr>
                                
                                    <td id="center_subtitle" colspan="2">Produits</td>
                                    
                                <tr></tr>
                                
                                    <td colspan="2">
                                        <SELECT style="width: 100%;" size="20" multiple name="multisel_product[]">
                                            <?php                                    
                                               
                                               try
                                               {
                                                  $query = $connectData->query('SELECT number_product, name_product_'.$used_language.'
                                                                                FROM product
                                                                                WHERE code_group_product = '.$_SESSION['product_link_cboGroup'].' AND status_product = 1
                                                                                AND id_product <> '.$selected_product_id.'
                                                                                ORDER BY number_product'); 

                                                  while($data = $query->fetch())
                                                  {
                                                      echo('<option value="'.$data[0].'" ');
                                                      if(!empty($_SESSION['product_link_selected_array']))
                                                      {
                                                          for($k = 0; $k < count($_SESSION['product_link_selected_array']); $k++)
                                                          {
                                                              if($_SESSION['product_link_selected_array'][$k] == $data[0])
                                                              {
                                                                  echo('selected ');
                                                                  $k = count($_SESSION['product_link_selected_array']) + 1;
                                                              }
                                                              else
                                                              {
                                                                  echo(null);
                                                              }
                                                          }
                                                      }
                                                                                     
                                                      
                                                      if(strlen($data[1]) > 40) 
                                                      {
                                                         echo('title="'.$data[1].'" >'.$data[0].' -> '.substr($data[1], 0, '40').'...'.'</option>'); 
                                                      }
                                                      else
                                                      {
                                                         echo('title="'.$data[1].'" >'.$data[0].' -> '.$data[1].'</option>'); 
                                                      }
                                                    
                                                  }
                                               }
                                               catch(Exception $e)
                                               {
                                                   die("Error : ".$e->getMessage());
                                               }   
                                               $query->closeCursor();
                                            ?>
                                        </SELECT>
                                    </td>
                                
                                <tr></tr>
                                
                                    
                                    <td colspan="2"><input type="submit" name="bt_save_product_link" value="Enregistrer"></input></td>    
                                    
                                <tr></tr>
                                    
                                    <td colspan="2"><div><span><pre id="center_text" style="font-size: 10px;">Maintenez la touche: 
- 'Ctrl' + click gauche souris afin de sélectionner plusieurs articles
   un par un
- 'Shift' + click gauche souris afin de sélectionner plusieurs articles 
   en une fois
- click gauche souris enfoncé afin de sélectionner plusieurs articles
- les 3 fonctions peuvent être utilisées conjointement</pre></span></div>
                                    </td>
               
                                <?php
                                }
                                ?>
                                    
                                
                             
                            </TABLE>
                            
                        </td>
                    </TABLE></form>                  
                </td>
            <td id="td_gapR1"></td>
        </TABLE>
    </div>     
    
    </BODY>
</HTML>




