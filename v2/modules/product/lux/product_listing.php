<?php


if(isset($_POST['bt_search_product_edit']) || isset($_POST['bt_search_product_listing'])
        || isset($_POST['bt_product_list_order_type']) || isset($_POST['bt_product_list_order_mode']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_listing');
}

if(isset($_POST['bt_product_search_noresult']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_add');
}

if(!empty($_SESSION['search_product_edit_result']))
{
    $array_listing_product_edit_result = $_SESSION['search_product_edit_result'];

    for($i = 0; $i < count($array_listing_product_edit_result); $i++)
    {
        if(isset($_POST['img_disabled'.$i.'_x']))
        {
            $query = $connectData->prepare('UPDATE product SET status_product = 1
                                            WHERE id_product = :id');       
            $query->bindParam('id', htmlspecialchars($array_listing_product_edit_result[$i]), ENT_QUOTES);        
            $query->execute();       
            $query->closeCursor();

            $query = $connectData->prepare('UPDATE page SET status_page = 1
                                            WHERE id_page = :id');       
            $query->bindParam('id', htmlspecialchars($array_listing_product_edit_result[$i]), ENT_QUOTES);        
            $query->execute();       
            $query->closeCursor();

            $i = count($array_listing_product_edit_result) + 1;
        }

        if(isset($_POST['img_active'.$i.'_x']))
        {
            $query = $connectData->prepare('UPDATE product SET status_product = 0
                                            WHERE id_product = :id');       
            $query->bindParam('id', htmlspecialchars($array_listing_product_edit_result[$i]), ENT_QUOTES);        
            $query->execute();       
            $query->closeCursor();

            $query = $connectData->prepare('UPDATE page SET status_page = 0
                                            WHERE id_page = :id');       
            $query->bindParam('id', htmlspecialchars($array_listing_product_edit_result[$i]), ENT_QUOTES);        
            $query->execute();       
            $query->closeCursor();

            $i = count($array_listing_product_edit_result) + 1;
        }
    }
}



include($backoffice_html_skeleton_part1); 
?>

<?php
$product_listing_title = create_translation_array('product_listing.title.text');
$product_listing_subtitle_search = create_translation_array('product_listing.subtitle_search.text');
$product_listing_button_search = create_translation_array('product_listing.search.button');

$product_listing_sentence_result = create_translation_array('product_listing.sentence_search.text');
$product_listing_sentence_result_s = create_translation_array('product_listing.sentence_search_s.text');
$product_listing_sentence_result_for = create_translation_array('product_listing.sentence_search_for.text');

$product_listing_new_link = create_translation_array('product_listing.new_product.link');

$used_language = $_SESSION['lang'];

$dropdown_name = 'name_product_'.$used_language;
$dropdown_number = 'number_product';

$line_color = 1;
?>

<TABLE width="100%" bgcolor="white">
    
        <td><TABLE width="100%" border="0">

                <form method="post">
                
                    <td id="center_title">
                        <?php 
                            echo(call_translation(@$_SESSION['translation'], find_word($product_listing_title))); 
                        ?>
                    </td>
                    <tr><td colspan="2"><hr></hr></td></tr>
                   
                    <td colspan="2" align="center">
                        <input type="text" name="txtSearch_product_listing" value="<?php echo(check_session_input(@$_SESSION['sentence_product_edit_result'])); ?>"></input>
                        &nbsp;
                        <SELECT name="cboSearchGroup_list">
                            <option value="all">Dans tous les produits</option>                   
                            <?php
                               try
                               {
                                  $query = $connectData->query('SELECT code_group_product, name_group_product_'.$used_language.'
                                                                FROM product_group
                                                                ORDER BY name_group_product_'.$used_language); 

                                  while($data = $query->fetch())
                                  {
                                      echo('<option value="'.$data[0].'" ');

                                      if(!empty($_SESSION['search_product_list_edit_cboGroup']))
                                      {
                                          if($_SESSION['search_product_list_edit_cboGroup'] == $data[0])
                                          {
                                              echo('selected');
                                              $temp_group = $data[1];
                                          }
                                          else
                                          {
                                              echo(null);
                                          }
                                      }

                                      echo('>'.substr($data[1], 0, 20).'...</option>');                                      
                                  }
                               }
                               catch(Exception $e)
                               {
                                   die("Error : ".$e->getMessage());
                               }   
                               $query->closeCursor();
                            ?>                    
                        </SELECT>
                        &nbsp;
                        <input type="submit" name="bt_search_product_listing" value="<?php echo(call_translation(@$_SESSION['translation'], find_word($product_listing_button_search))); ?>"></input>
                    </td>
                    <tr><td colspan="2"><hr></hr></td></tr>
                
                
                
            </TABLE></td>
        
    <tr></tr>
    
        <td><TABLE width="100%" border="0">
                
            
<?php
if(!empty($_SESSION['search_product_edit_result']))
{
     $count_result = $_SESSION['count_product_edit_result'];
     $sentence = $_SESSION['sentence_product_edit_result'];
     $group = $_SESSION['search_product_list_edit_cboGroup'];
     
     $group_sentence_part1 = ' dans ';
         
     if($group === 'all')
     {
         $group_sentence_part2 = 'tous les produits';
     }
     else
     {
         $group_sentence_part2 = $temp_group; 
     }
     
     if($count_result == 0)
     {
         $result = call_translation(@$_SESSION['translation'], find_word($product_listing_sentence_result));
?>
          <td id="center_text" colspan="3" align="center"><?php echo($result.' '.call_translation(@$_SESSION['translation'], find_word($product_listing_sentence_result_for)).' '); ?><span style="font-weight: bold;"><?php echo($sentence); ?></span><span><?php echo($group_sentence_part1); ?></span><span style="font-weight: bold;"><?php echo($group_sentence_part2); ?></span>              
          </td>
          <tr></tr>          
          <td align="center"><input type="submit" name="bt_product_search_noresult" value="Créer un nouveau produit"></input></td>
          <tr><td colspan="3"><hr></hr></td></tr>                   
<?php        
     }
     else
     {
         $result = call_translation(@$_SESSION['translation'], find_word($product_listing_sentence_result_s));
         
         
         if(empty($sentence))
         {           
?>             
             <td id="center_text" colspan="3" align="center"><?php echo($count_result.' '.$result.' au total '); ?><span style="font-weight: bold;"><?php echo(null); ?></span><span><?php echo($group_sentence_part1); ?></span><span style="font-weight: bold;"><?php echo($group_sentence_part2); ?></span></td>
<?php        
         }
         else
         {
?>       
             <td id="center_text" colspan="3" align="center"><?php echo($count_result.' '.$result.' '.call_translation(@$_SESSION['translation'], find_word($product_listing_sentence_result_for)).' '); ?><span style="font-weight: bold;"><?php echo($sentence); ?></span><span><?php echo($group_sentence_part1); ?></span><span style="font-weight: bold;"><?php echo($group_sentence_part2); ?></span></td> 
<?php
         }            
?>                               
            <tr></tr>
                
                <td id="center_text" colspan="3" align="center">Trier par
                    &nbsp;
                    <SELECT name="cboOrderType" onchange="OnChange('bt_product_list_order_type')">
                        <option value="<?php echo($dropdown_name); ?>" <?php if(empty($_SESSION['search_product_list_edit_cboOrderType']) || $_SESSION['search_product_list_edit_cboOrderType'] === $dropdown_name){ echo('selected'); }else{ echo(null); } ?>>Nom</option>
                        <option value="<?php echo($dropdown_number); ?>" <?php if(!empty($_SESSION['search_product_list_edit_cboOrderType']) && $_SESSION['search_product_list_edit_cboOrderType'] === $dropdown_number){ echo('selected'); }else{ echo(null); } ?>>Numéro</option>                 
                    </SELECT>
                    &nbsp;                   
                    <SELECT name="cboOrderMode" onchange="OnChange('bt_product_list_order_mode')">
                        <option value="ASC" <?php if(empty($_SESSION['search_product_list_edit_cboOrderMode']) || $_SESSION['search_product_list_edit_cboOrderMode'] === 'ASC'){ echo('selected'); }else{ echo(null); } ?>>Croissant</option>
                        <option value="DESC" <?php if(empty($_SESSION['search_product_list_edit_cboOrderMode']) || $_SESSION['search_product_list_edit_cboOrderMode'] === 'DESC'){ echo('selected'); }else{ echo(null); } ?>>Décroissant</option>                        
                    </SELECT>                 
                </td>
                
            <tr><td colspan="3"><hr></hr></td></tr>
<?php

        

        for($i = 0; $i < count($array_listing_product_edit_result); $i++)
        {
            if($array_listing_product_edit_result[$i] != 'and' && $array_listing_product_edit_result[$i] != 'or')
            {
                try
                {
                   $query = $connectData->prepare('SELECT id_product,
                                                          name_product_'.$used_language.',
                                                          introduction_product_'.$used_language.',
                                                          description_product_'.$used_language.',
                                                          number_product,
                                                          code_group_product,
                                                          code_category_product,
                                                          status_product
                                                   FROM product
                                                   WHERE id_product = :id');

                   $query->bindParam('id', htmlspecialchars($array_listing_product_edit_result[$i], ENT_QUOTES));

                   $query->execute();

                   while($data = $query->fetch())
                   {                    
                       if($line_color === 1)
                       {
                           $style = ' style="background-color: lightgrey;" ';
                           $line_color = 2;
                       }
                       else
                       {
                           $style = null;
                           $line_color = 1;
                       }
                       
                       if($data[7] == 1)
                       {
?>                          
                            <td width="12px"<?php echo($style);  ?>>
                                <span style="vertical-align: inherit;"><input type="image" src="graphics/icons/circle_green16x16.png" name="img_active<?php echo($i); ?>" alt="Activé" title="Activé"></input></span>
                            </td>
                            <td id="center_text" <?php echo($style);  ?>>                              
                                <a id="product_list" href="index_backoffice.php?page=product_edit&nbp=<?php echo($data[0]); ?>"><?php echo($data[1]); ?></a>                               
                            </td>
                            <td id="center_text" align="right" <?php echo($style);  ?>><span id="product_list" style="cursor: pointer;" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data[0]); ?>&pop=true', '600', '700')"><?php echo($data[4]); ?></span></td>                                

                    <tr></tr>
<?php
                       }
                       else
                       {
?>                          
                            <td width="12px"<?php echo($style);  ?>>
                                <span style="vertical-align: inherit;"><input type="image" src="graphics/icons/circle_red16x16.png" name="img_disabled<?php echo($i); ?>" alt="Désactivé" title="Désactivé"></input></span>
                            </td>
                            <td id="center_text" <?php echo($style);  ?>>                           
                                <a id="product_list" href="index_backoffice.php?page=product_edit&nbp=<?php echo($data[0]); ?>"><?php echo($data[1]); ?></a>                               
                            </td>
                            <td id="center_text" align="right" <?php echo($style);  ?>><span id="product_list" style="cursor: pointer;" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data[0]); ?>&pop=true', '600', '700')"><?php echo($data[4]); ?></span></td>                               

                    <tr></tr>                      
<?php                      
                       }
                   }
                }
                catch (Exception $e)
                {
                   die("<br>Error : ".$e->getMessage());
                }
                $query->closeCursor();
            }
        }
     }
    
}

?>                    
            <td colspan="3">
                <input style="display: none;" id="bt_product_list_order_type" type="submit" name="bt_product_list_order_type" value="Changer Type" hidden="hidden"></input>
                <input style="display: none;" id="bt_product_list_order_mode" type="submit" name="bt_product_list_order_mode" value="Changer Ordre" hidden="hidden"></input>
            </td>
            </form>              
            </TABLE></td>
    
</TABLE>


<?php
include($backoffice_html_skeleton_part2);
include('search.php');



?>

<!--import my javascript-->

<script type="text/javascript" src="script.js"></script>