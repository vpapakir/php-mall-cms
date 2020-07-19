<?php
if(isset($_POST['bt_search_product_edit']) || isset($_POST['bt_search_product_listing']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_listing');
}

if(isset($_POST['bt_save1']) || isset($_POST['bt_save2']))
{
    header('Location: '.$header.$_SESSION['index'].'?page=product_edit');
}

unset($_SESSION['product_add_refresh_edit'], $_SESSION['product_add_refresh_add']);
unset($_SESSION['product_link_selected_group'], $_SESSION['product_link_firstloading'], $_SESSION['product_link_selected'], $_SESSION['product_link_selected_array']);

if(isset($_GET['pop']))
{
    if(!empty($_GET['pop']) && $_GET['pop'] == true)
    {
        $_SESSION['product_edit_popup'] = true;
         
?>
        <HTML>
            <HEAD>
                <!-- display title at browser's tab -->
                <title>Gestion des Produits</title>


                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


                <!-- Import my <!CSS -->
                <link rel ="stylesheet" media ="screen, projection" type ="text/css"
                      title ="design" href ="css/main.css"/>
                
                <!--import FCKeditor -->
                <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        
                <script type="text/javascript">

                window.onload = function()
                {                  
                    oFCKeditor.Width = 150;
                }

                </script>
                
            </HEAD>
            
            <BODY>
        
                <div id="Main_Div_popup">
                    <TABLE cellspacing="0" cellpadding="0">
                        <td id="td_gapL1"></td>
                        <td><TABLE id="Main_Table_popup">
                                <td id="td_main" valign="top">
                                    
<?php
       
    }
}
else
{
   include($backoffice_html_skeleton_part1); 
}

               
if(!empty($_SESSION['product_edit_close_popup']) && $_SESSION['product_edit_close_popup'] == true)
{
    unset($_SESSION['product_edit_close_popup']);                  
    ?>
            <script type="text/javascript">
                window.close();                               
            </script>               
    <?php
}
?>



<!-- product_add.php -->

<!-- allows user to update a product Information into the database -->

<?php
$product_edit_title = create_translation_array('product_edit.title.text');

$product_listing_subtitle_search = create_translation_array('product_listing.subtitle_search.text');
$product_listing_button_search = create_translation_array('product_listing.search.button');

$subtitle_product_number = create_translation_array('product_add.product_number_label.text');//"Product number"
$subtitle_product_keyword = create_translation_array('product_add.product_key_word_label.text');//"Product Keywords"
$subtitle_product_introduction = create_translation_array('product_add.product_intro_label.text');//"Product Introduction"
$subtitle_product_description = create_translation_array('product_add.product_description_label.text');//"Product Description"
$subtitle_product_manual_tags = create_translation_array('product_add.product_manual_tags_label.text');//"Tags"
$subtitle_product_title = create_translation_array('product_edit.product_title_label.text');//"Product title"
$subtitle_product_generated_tags = create_translation_array('product_edit.product_generated_tags_label.text');//"Generated tags"



?>

<?php
    $used_language = $_SESSION['lang'];
    
    if(empty($_SESSION['select_lang_product_edit']))
    {
        $option_lang = $used_language;
    }
    else
    {
        $option_lang = $_SESSION['select_lang_product_edit'];
    }

    if(isset($_GET['nbp']))
    {
        unset($_SESSION['number_product']);
        unset($_SESSION['product_add_txtNameProd']);
        unset($_SESSION['product_add_txtCodeProd']);
        unset($_SESSION['product_add_txtIntroProd']);
        unset($_SESSION['product_add_txtDescriptProd']);
        unset($_SESSION['product_add_length']);
        unset($_SESSION['product_add_width']);
        unset($_SESSION['product_add_depth']);
        unset($_SESSION['product_add_weigth']);
        unset($_SESSION['product_add_price_public']);
        unset($_SESSION['product_add_price_promo']);
        unset($_SESSION['product_add_price_resale']);
        unset($_SESSION['product_add_price_ecotax']);
        
        unset($_SESSION['number_product_edit']);
        unset($_SESSION['product_edit_txtNameProd']);
        unset($_SESSION['product_edit_txtCodeProd']);
        unset($_SESSION['product_edit_txtIntroProd']);
        unset($_SESSION['product_edit_txtDescriptProd']);
        unset($_SESSION['product_edit_txtCodeUserProd']);
        unset($_SESSION['product_edit_cboPriority']);
        unset($_SESSION['product_edit_image']);
        unset($_SESSION['product_edit_cboGroup']);
        unset($_SESSION['product_edit_cboCateg']);
        unset($_SESSION['product_edit_cboCartType']);
        unset($_SESSION['product_edit_cboTransportFee']);
        
        unset($_SESSION['product_edit_length']);
        unset($_SESSION['product_edit_width']);
        unset($_SESSION['product_edit_depth']);
        unset($_SESSION['product_edit_weigth']);
        unset($_SESSION['product_edit_price_public']);
        unset($_SESSION['product_edit_price_promo']);
        unset($_SESSION['product_edit_price_resale']);
        unset($_SESSION['product_edit_price_ecotax']);
        
        unset($_SESSION['product_edit_available_stock']);
        unset($_SESSION['product_edit_name_stock']);
        unset($_SESSION['product_edit_alert_stock']);  
        unset($_SESSION['product_edit_delay_stock']);  
        
        unset($_SESSION['product_link_saved']);
        
        $link_number_product = htmlspecialchars($_GET['nbp'], ENT_QUOTES);
        
        $_SESSION['number_basic_product_edit'] = $link_number_product;
        
        if(!empty($link_number_product))
        {
            try
            {
                $query = $connectData->prepare('SELECT product.id_product,
                                                       status_product,
                                                       number_product,
                                                       code_product_'.$used_language.',
                                                       name_product_'.$used_language.',
                                                       introduction_product_'.$used_language.',
                                                       description_product_'.$used_language.',
                                                       code_group_product,
                                                       code_category_product,
                                                       id_option_product,
                                                       priority_product,
                                                       image_thumb_product,
                                                       cart_type_product,
                                                       transport_fee_product,
                                                       product.id_page,
                                                       product_details.*,
                                                       product_stock.*
                                                FROM product 
                                                INNER JOIN (product_details
                                                INNER JOIN product_stock 
                                                ON product_details.id_stock = product_stock.id_stock)
                                                ON product.id_product = product_details.id_product                                               
                                                WHERE product.id_product = :id');

                $query->bindParam('id', htmlspecialchars($link_number_product));
                
                $query->execute();
                
                
                
                if(($data = $query->fetch()) == false)#if id_stock and id_details haven't be created
                {                 
                    #Search Last id_stock value and add +1
                    $query = $connectData->query('SELECT id_stock FROM product_stock');
                    
                    while($data2 = $query->fetch())
                    {
                        $id_stock = $data2[0];
                    }
                    
                    $id_stock++;
                    
                    $query->closeCursor();                  
                    
                    #Insert a line into Product_details Table
                    $query = $connectData->prepare('INSERT INTO product_details
                                                    (id_product, id_stock)
                                                    VALUES (:id , :id_stock)');

                    $query->execute(array(
                                          'id' => $link_number_product,
                                          'id_stock' => $id_stock
                                          ));                   
                    $query->closeCursor();
                    
                    #Insert a line into Product_stock Table
                    $query = $connectData->prepare('INSERT INTO product_stock
                                                    (id_product)
                                                    VALUES (:id)');
                    
                    $query->bindParam('id', $link_number_product);
                    $query->execute();                   
                    $query->closeCursor();
                    
                    
                    $query = $connectData->prepare('SELECT product.id_product,
                                                       status_product,
                                                       number_product,
                                                       code_product_'.$used_language.',
                                                       name_product_'.$used_language.',
                                                       introduction_product_'.$used_language.',
                                                       description_product_'.$used_language.',
                                                       code_group_product,
                                                       code_category_product,
                                                       id_option_product,
                                                       priority_product,
                                                       image_thumb_product,
                                                       cart_type_product,
                                                       transport_fee_product,
                                                       product.id_page,
                                                       product_details.*,
                                                       product_stock.*
                                                FROM product 
                                                INNER JOIN (product_details
                                                INNER JOIN product_stock 
                                                ON product_details.id_stock = product_stock.id_stock)
                                                ON product.id_product = product_details.id_product                                               
                                                WHERE product.id_product = :id');

                    $query->bindParam('id', htmlspecialchars($link_number_product));

                    $query->execute();
              
                    while($data = $query->fetch())
                    {
                        $_SESSION['product_edit_status'] = $data[1];
                        $_SESSION['number_product_edit'] = $data[2];
                        $product_number = $data[2];
                        $_SESSION['product_edit_txtCodeProd'] = $data[3];
                        $_SESSION['product_edit_txtNameProd'] = $data[4];                   
                        $_SESSION['product_edit_txtIntroProd'] = $data[5];
                        $_SESSION['product_edit_txtDescriptProd'] = $data[6];
                        $_SESSION['product_edit_cboGroup'] = $data[7];
                        $_SESSION['product_edit_cboCateg'] = $data[8];
                        $temp_option = $data[9];
                        $_SESSION['product_edit_cboPriority'] = $data[10];
                        $image = $data[11];
                        $_SESSION['product_edit_cboCartType'] = $data[12];
                        $_SESSION['product_edit_cboTransportFee'] = $data[13];
                        $page_already_created = $data[14];
                        
                        $_SESSION['product_edit_length'] = $data[21];
                        $_SESSION['product_edit_width'] = $data[22];
                        $_SESSION['product_edit_depth'] = $data[23];
                        $_SESSION['product_edit_weigth'] = $data[24];
                        $_SESSION['product_edit_price_public'] = $data[25];
                        $_SESSION['product_edit_price_promo'] = $data[26];
                        $_SESSION['product_edit_price_resale'] = $data[27];
                        $_SESSION['product_edit_price_ecotax'] = $data[28];
                        $_SESSION['product_edit_delay_stock'] = $data[29];
                        
                        $_SESSION['product_edit_name_stock'] = $data[32];
                        $_SESSION['product_edit_available_stock'] = $data[33];
                        $_SESSION['product_edit_alert_stock'] = $data[34];            
                    }
                }
                else
                {
                    $query->execute();
         
                    while($data = $query->fetch())
                    {
                        $_SESSION['product_edit_status'] = $data[1];
                        $_SESSION['number_product_edit'] = $data[2];
                        $product_number = $data[2];
                        $_SESSION['product_edit_txtCodeProd'] = $data[3];
                        $_SESSION['product_edit_txtNameProd'] = $data[4];                   
                        $_SESSION['product_edit_txtIntroProd'] = $data[5];
                        $_SESSION['product_edit_txtDescriptProd'] = $data[6];
                        $_SESSION['product_edit_cboGroup'] = $data[7];
                        $_SESSION['product_edit_cboCateg'] = $data[8];
                        $temp_option = $data[9];
                        $_SESSION['product_edit_cboPriority'] = $data[10];
                        $image = $data[11];
                        $_SESSION['product_edit_cboCartType'] = $data[12];
                        $_SESSION['product_edit_cboTransportFee'] = $data[13];
                        $page_already_created = $data[14];
                        
                        $_SESSION['product_edit_length'] = $data[21];
                        $_SESSION['product_edit_width'] = $data[22];
                        $_SESSION['product_edit_depth'] = $data[23];
                        $_SESSION['product_edit_weigth'] = $data[24];
                        $_SESSION['product_edit_price_public'] = $data[25];
                        $_SESSION['product_edit_price_promo'] = $data[26];
                        $_SESSION['product_edit_price_resale'] = $data[27];
                        $_SESSION['product_edit_price_ecotax'] = $data[28];
                        $_SESSION['product_edit_delay_stock'] = $data[29];
                        
                        $_SESSION['product_edit_name_stock'] = $data[32];
                        $_SESSION['product_edit_available_stock'] = $data[33];
                        $_SESSION['product_edit_alert_stock'] = $data[34];  
                    }
                }
                
                    
                $generated_tags = $_SESSION['product_edit_txtCodeProd'];                
                $split_number = explode($_SESSION['number_product_edit'], $generated_tags);                
                $temp_replace_char = trim(str_replace_char($_SESSION['product_edit_txtNameProd']));
                $temp_replace_char = trim(str_replace_char($temp_replace_char));
                
                $split_name = explode($temp_replace_char, $split_number[0]);
                
                $_SESSION['product_edit_txtCodeUserProd'] = trim($split_name[1]);
                
                $product_number = trim(str_replace_char($product_number));                
                $product_number = trim(str_replace_char($product_number));
                
//                if(!preg_match('#.jpg$#', $image) || !preg_match('#.png$#', $image))
//                {
//                   $image .= '.jpg'; 
//                }
                if(empty($image))
                {
                    $image = 'images/photos/x.jpg';
                }
                
                //$_SESSION['product_edit_txtCodeProd'] = $product_number;
                $_SESSION['product_edit_image'] = $image;
                
                
                $temp_option = mb_split(',', $temp_option);
                $temp_array_option[] = 0;
                $j = 0;
                
                for($i = 0; $i < count($temp_option); $i++)
                {
                    if($temp_option[$i] == null)
                    {
                       $i++;
                    }
                    
                    if($i < count($temp_option))
                    {
                        $temp_array_option[$j] = $temp_option[$i]; 
                    }
                    
                    
                    $j++;
                }
                
                $_SESSION['chk_product_options'] = $temp_array_option;
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
        }
    }
?>
<!-- Table 1/1 -->
<TABLE width="100%" bgcolor="white">
        <!-- Table 1/2 -->
    <td><TABLE width="100%" border="0" id="form_product_edit">
        
            <td id="center_title" colspan="2"><?php echo(call_translation(@$_SESSION['translation'], find_word($product_edit_title))); ?></td>
            <tr><td colspan="2"><hr></hr></td></tr>
            
        <tr></tr>
            <!-- form to Search a product -->
            <form method="post">
                <?php
                if(!isset($_GET['pop']))
                {
                ?>
                <td colspan="2" align="center"><input style="width: auto;" id="center_text" type="text" name="txtSearch_product_edit"/> <!-- '&nbsp;' = whitespace -->
                                &nbsp;
                                <SELECT name="cboSearchGroup_edit">
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

                                              if(!empty($_SESSION['product_edit_cboGroup']))
                                              {
                                                  if($_SESSION['product_edit_cboGroup'] == $data[0])
                                                  {
                                                      echo('selected');
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
                                <input type="submit" name="bt_search_product_edit" value="<?php echo(call_translation(@$_SESSION['translation'], find_word($product_listing_subtitle_search))); ?>"/>
                                <br><span class="tooltip" id="tooltip_code"></span></td>              

            <!-- display a grey line -->
            <tr><td colspan="2"><hr></hr></td></tr>                                
            
        <tr></tr>
            <?php
                }
            ?>
            <!-- form to save typed Information in textfields and Dropdown -->
            
                <td></td>
                <td><?php
               
                    if(count($array_icon_language) > 1) #if only one language availabled, flags won't display
                    {
                    ?>
                    <select name="cboEditProduct1" onchange="OnChange('bt_save1')">
                    <?php
                    
                        dropdown_lang_edit();
                        
                    ?>
                    </select>
                    <input id="bt_save1" type="submit" name="bt_save1" hidden="true"></input>
                    <?php
                    }
                    else
                    {
                    ?>
                       <input type="submit" name="bt_save1" value="Sauvegarder"></input>
                    <?php
                    }
                    ?>
                    
                    <br clear="left">
                    <span id="msg_wrong"><?php echo(check_session_input(@$_SESSION['msg_product_edit'])); ?></span>
                </td>
                <tr><td colspan="2"><hr></hr></td></tr>
            
            
        <tr></tr>
         
            <td id="center_subtitle" width="25%">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_number))); 
                ?>
            </td>
            <td><input style="<?php echo($width_textfield); ?>" readonly style="width: auto;" type="text" name="txtNumProd" value="<?php if(!empty($_SESSION['number_product_edit'])){ unset($_SESSION['number_product']); echo($_SESSION['number_product_edit']); }else{ unset($_SESSION['number_product_edit']); } if(!empty($_SESSION['number_product'])){ echo($_SESSION['number_product']); }else{ unset($_SESSION['number_product']); } ?>"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_title))); 
                ?>
            </td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtNameProd" value="<?php if(!empty($_SESSION['product_edit_txtNameProd'])){ unset($_SESSION['product_add_txtNameProd']); echo($_SESSION['product_edit_txtNameProd']); }else{ unset($_SESSION['product_edit_txtNameProd']); } if(!empty($_SESSION['product_add_txtNameProd'])){ echo($_SESSION['product_add_txtNameProd']); }else{ unset($_SESSION['product_add_txtNameProd']); } ?>"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_generated_tags))); 
                ?>
            </td>
            <td><input style="<?php echo($width_textfield); ?>" readonly type="text" name="txtCodeProd" value="<?php if(!empty($_SESSION['product_edit_txtCodeProd'])){ unset($_SESSION['product_add_txtCodeProd']); echo($_SESSION['product_edit_txtCodeProd']); }else{ unset($_SESSION['product_edit_txtCodeProd']); } if(!empty($_SESSION['product_add_txtCodeProd'])){ echo($_SESSION['product_add_txtCodeProd']); }else{ unset($_SESSION['product_add_txtCodeProd']); } ?>"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_manual_tags))); 
                ?>
            </td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtCodeUserProd" value="<?php if(!empty($_SESSION['product_edit_txtCodeUserProd'])){ unset($_SESSION['product_add_txtCodeUserProd']); echo($_SESSION['product_edit_txtCodeUserProd']); }else{ unset($_SESSION['product_edit_txtCodeUserProd']); }  if(!empty($_SESSION['product_add_txtCodeUserProd'])){ echo($_SESSION['product_add_txtCodeUserProd']); }else{ unset($_SESSION['product_add_txtCodeUserProd']); } ?>"/></td>                          
        
        <tr></tr>
            
            <td id="center_subtitle">Groupe</td>
            <td><SELECT name="cboGroup">                   
                    <?php
                       try
                       {
                          $query = $connectData->query('SELECT code_group_product, name_group_product_'.$used_language.'
                                                        FROM product_group
                                                        ORDER BY name_group_product_'.$used_language); 
                          
                          while($data = $query->fetch())
                          {
                              echo('<option value="'.$data[0].'" ');
                              
                              if(!empty($_SESSION['product_edit_cboGroup']))
                              {
                                  if($_SESSION['product_edit_cboGroup'] == $data[0])
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
            </td>
            
        <tr></tr>
        
            <td id="center_subtitle">Catégorie</td>
            <td><SELECT name="cboCateg">
                    <?php
                       try
                       {
                          $query = $connectData->query('SELECT code_category_product, name_category_product_'.$used_language.'
                                                        FROM product_category
                                                        ORDER BY name_category_product_'.$used_language); 
                          
                          while($data = $query->fetch())
                          {
                              echo('<option value="'.$data[0].'" ');
                              
                              if(!empty($_SESSION['product_edit_cboCateg']))
                              {
                                  if($_SESSION['product_edit_cboCateg'] == $data[0])
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
            </td>
            
        <tr></tr>
        
            <td id="center_subtitle">Priorité</td>
            <td><SELECT name="cboPriority">
                    <?php
                    for($i = 1; $i < 10; $i++)
                    {
                        echo('<option value="'.$i.'" '); 
                        if(!empty($_SESSION['product_edit_cboPriority']))
                        {
                            if($_SESSION['product_edit_cboPriority'] == $i)
                            {
                               echo('selected'); 
                            }
                            else
                            {
                                echo(null);
                            }
                        }
                        echo(' >'.$i.'</option>');
                    }                   
                    ?>                    
                </SELECT>
            </td>    
            
        <tr></tr>    
        
            <td id="center_subtitle" colspan="2">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_introduction))); 
                ?>
            </td>
            
        <tr></tr> 
            
            <td colspan="2"><TEXTAREA class="ckeditor" <?php echo($textarea_rows.' '.$textarea_cols); ?> name="txtIntroProd" ><?php if(!empty($_SESSION['product_edit_txtIntroProd'])){ unset($_SESSION['product_add_txtIntroProd']); echo($_SESSION['product_edit_txtIntroProd']); }else{ unset($_SESSION['product_edit_txtIntroProd']); } if(!empty($_SESSION['product_add_txtIntroProd'])){ echo($_SESSION['product_add_txtIntroProd']); }else{ unset($_SESSION['product_add_txtIntroProd']); } ?></TEXTAREA></td>
            
        <tr></tr>
        
            <td id="center_subtitle" colspan="2">
                <?php 
                    echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_description))); 
                ?>
            </td>
            
        <tr></tr>
        
            <td colspan="2"><TEXTAREA class="ckeditor" <?php echo($textarea_rows.' '.$textarea_cols); ?> name="txtDescriptProd" ><?php if(!empty($_SESSION['product_edit_txtDescriptProd'])){ unset($_SESSION['product_add_txtDescriptProd']); echo($_SESSION['product_edit_txtDescriptProd']); }else{ unset($_SESSION['product_edit_txtDescriptProd']); } if(!empty($_SESSION['product_add_txtDescriptProd'])){ echo($_SESSION['product_add_txtDescriptProd']); }else{ unset($_SESSION['product_add_txtDescriptProd']); } ?></TEXTAREA></td>        
        
         <tr></tr>
        
            <td id="center_subtitle">Image</td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtImgUpload" value="<?php if(!empty($_SESSION['product_edit_image'])){ unset($_SESSION['product_add_image']); echo($_SESSION['product_edit_image']); }else{ unset($_SESSION['product_edit_image']); } if(!empty($_SESSION['product_add_image'])){ echo($_SESSION['product_add_image']); }else{ unset($_SESSION['product_add_image']); } ?>"></input></td>   
          
         <tr></tr>
        
            <td id="center_subtitle">Statut</td>
            <td>
                <SELECT name="cboStatus">
                    <option value="1" <?php if(!empty($_SESSION['product_edit_status']) && $_SESSION['product_edit_status'] === '1'){ unset($_SESSION['product_add_status']); echo('selected'); }else{ echo(null); } if(!empty($_SESSION['product_add_status']) && $_SESSION['product_add_status'] === 1){ echo('selected'); }else{ unset($_SESSION['product_add_status']); echo(null); }?>>Activé</option>
                    <option value="0" <?php if(empty($_SESSION['product_edit_status']) || $_SESSION['product_edit_status'] === '0'){ unset($_SESSION['product_add_status']); echo('selected'); }else{ echo(null); } if(!empty($_SESSION['product_add_status']) && $_SESSION['product_add_status'] === 0){ echo('selected'); }else{ unset($_SESSION['product_add_status']); echo(null); } ?>>Désactivé</option>
                    <option value="9" <?php if(!empty($_SESSION['product_edit_status']) && $_SESSION['product_edit_status'] === '9'){ unset($_SESSION['product_add_status']); echo('selected'); }else{ unset($_SESSION['product_add_status']); echo(null); } ?>>Invisible</option>
                </SELECT>
            </td>               
            
        <tr></tr>
            
            <td id="center_subtitle">Produits liés</td>
            <td>
                <div id="other_link" style="cursor: pointer; width: 40px; text-decoration: underline;" onclick="popup('index_backoffice.php?page=product_link', '600', '600')" ><img src="graphics/buttons/chooselink.gif" alt="Choisir" title="Choisir"></img></div>
<!--               <a id="other_link" href="index_backoffice.php?page=product_link" target="_blank">choisir</a> -->
                <?php
                if(!empty($_SESSION['product_link_saved']) && $_SESSION['product_link_saved'] == 'true')
                {
                ?>                
                    <span id="msg_wrong">Les produits liés ont été mis à jour</span>
                <?php
                }
                ?>
            </td>
            
        <tr></tr>
            
            <td id="center_subtitle">Type de caddie</td>
            <td>
                <SELECT name="cboCartType">
                    <option value="no" <?php if(!empty($_SESSION['product_edit_cboCartType']) && $_SESSION['product_edit_cboCartType'] === 'no'){ echo('selected'); }else{ echo(null); } ?>>Aucun</option>
                    <option value="outofprogram" <?php if(!empty($_SESSION['product_edit_cboCartType']) && $_SESSION['product_edit_cboCartType'] === 'outofprogram'){ echo('selected'); }else{ echo(null); } ?>>Plus en vente</option>
                    <option value="request" <?php if(!empty($_SESSION['product_edit_cboCartType']) && $_SESSION['product_edit_cboCartType'] === 'request'){ echo('selected'); }else{ echo(null); } ?>>Demande de devis</option>
                    <option value="shop" <?php if(empty($_SESSION['product_edit_cboCartType']) || $_SESSION['product_edit_cboCartType'] === 'shop'){ echo('selected'); }else{ echo(null); } ?>>Boutique</option>
                </SELECT>
            </td>
            
        <tr></tr>
            
            <td id="center_subtitle">Frais de transport</td>
            <td>
                <SELECT name="cboTransportFee">
                    <option value="paid" <?php if(empty($_SESSION['product_edit_cboTransportFee']) || $_SESSION['product_edit_cboTransportFee'] === 'paid'){ echo('selected'); }else{ echo(null); } ?>>Payant</option>
                    <option value="free" <?php if(empty($_SESSION['product_edit_cboTransportFee']) || $_SESSION['product_edit_cboTransportFee'] === 'free'){ echo('selected'); }else{ echo(null); } ?>>Gratuit</option>
                </SELECT>
            </td>

        <tr <?php if(!empty($page_already_created) && $page_already_created == 0){ echo(null); }else{ echo('hidden'); } ?>></tr>
        
            <td id="center_subtitle" <?php if(!empty($page_already_created) && $page_already_created == 0){ echo(null); }else{ echo('hidden'); } ?>>Créer une page ?</td>
            <td <?php if(!empty($page_already_created) && $page_already_created == 0){ echo(null); }else{ echo('hidden'); } ?>>
                <input checked type="radio" name="rad_product_page" value="yes"><span id="center_text">Oui</span></input>
                &nbsp;
                <input type="radio" name="rad_product_page" value="no"><span id="center_text">Non</span></input>
            </td>

            
         
                         
            <!-- display a grey line -->
            <tr><td colspan="2"><hr></hr></td></tr>
        </TABLE></td>
        
<!--    <tr></tr>-->
        <!-- Table 2/2 -->
<!--        <td><?php //include('product/product_options.php'); ?></td>-->
        
    <tr></tr>
    
        <td><?php include('product/product_details.php'); ?></td>
        
    <tr><td colspan="3"><hr></hr></td></tr>
    
        <td><TABLE width="100%">
        
            <!-- form to save typed Information in textfields and Dropdown -->
            
                <td width="25%"></td>
                <td colspan="2">
                    <?php
                    if(count($array_icon_language) > 1) #if only one language availabled, flags won't display
                    {
                    ?>
                    <SELECT name="cboEditProduct2" onchange="OnChange('bt_save2')">
                    <?php
                     dropdown_lang_edit();
                    ?>
                    </SELECT>
                    <input id="bt_save2" type="submit" name="bt_save2" hidden="true"></input>
                    <?php
                    }
                    else
                    {
                    ?>
                       <input type="submit" name="bt_save2" value="Sauvegarder"></input>
                    <?php
                    }
                    ?>


                </td>
            </form>    
                
    
        </TABLE></td>
    
</TABLE>

<?php
include('search.php');

if(isset($_GET['pop']))
{
    if(!empty($_GET['pop']) && $_GET['pop'] == true)
    {
        
?>
                <!--import my javascript-->

                <script type="text/javascript" src="script.js" lang="javascript"></script>
                                </td>
                </TABLE></td>
                    <td id="td_gapR1"></td>
                </TABLE>
            </div>     
                
            </BODY>

        </HTML>
<?php
    }
}
else
{
   include($backoffice_html_skeleton_part2); 
}

if(isset($_POST['bt_save1']) || isset($_POST['bt_save2']))
{
    // <editor-fold defaultstate="collapsed" desc="Save product Info into the Database">
    if(isset($_POST['bt_save1']) && !isset($_POST['bt_save2']))
    {
       if(count($array_icon_language) > 1) #if only one language availabled, flags won't display
       {
          $selected_lang = $_POST['cboEditProduct1']; 
       }
       else
       {
          $selected_lang = 'exit'.$used_language; 
       }        
    }
    
    if(!isset($_POST['bt_save1']) && isset($_POST['bt_save2']))
    {
       if(count($array_icon_language) > 1) #if only one language availabled, flags won't display
       {
          $selected_lang = $_POST['cboEditProduct2']; 
       }
       else
       {
          $selected_lang = 'exit'.$used_language; 
       }       
    }       

    unset($_SESSION['product_link_saved']);
    
    $array_chk_options[] = 0;
    $BoKinsert = true;

//        $txtNumProd = $_SESSION['number_basic_product_edit'];
    $txtNumProd = $_POST['txtNumProd'];

    $txtNameProd = $_POST['txtNameProd'];
    $txtCodeProd = $_POST['txtCodeProd'];
    $txtIntroProd = $_POST['txtIntroProd'];
    $txtDescriptProd = $_POST['txtDescriptProd'];
    $txtCodeUserProd = $_POST['txtCodeUserProd'];    
    $radio_page = $_POST['rad_product_page'];
    $priority = $_POST['cboPriority'];
    $image_upload = $_POST['txtImgUpload'];
    $status = $_POST['cboStatus'];
    $selected_group = $_POST['cboGroup'];
    $selected_category = $_POST['cboCateg'];
    $selected_group_link = $_POST['cboGroupLink'];
    $selected_cart_type = $_POST['cboCartType'];
    $selected_transport_fee = $_POST['cboTransportFee'];

    $txtCodeProd = trim(strtolower($txtCodeProd));

    $txtCodeUserProd = trim(strtolower($txtCodeUserProd));

    if(empty($txtCodeUserProd))
    {
        $txtCodeProd = strtolower($txtNameProd).' '.$txtNumProd;
    }
    else
    {
        $txtCodeProd = strtolower($txtNameProd.' '.$txtCodeUserProd.' '.$txtNumProd);
    }

    try
    {
        $query = $connectData->query('SELECT id_option_product FROM product_option');

        while($data = $query->fetch())
        {
            $count_option = $data[0];
        }
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    $query->closeCursor();

    $j = 0;               

    for($i = 1; $i <= $count_option; $i++)
    {
        $array_chk_options[$i] = $_POST['chk_type'.$i];

        if($array_chk_options[$i] == null)
        {
           $array_chk_options[$i] = null; 
        }
        else
        {
           $txtCodeProd .= ' '.strtolower($array_chk_options[$i]);
           if(empty($option))
           {
             $option = ','.$i.',';
             $array_option[$j] = $i;
             $j++;
           }
           else
           {                
             $option .= $i.',';
             $array_option[$j] = $i;
             $j++;
           }                
        }
    }

    $_SESSION['chk_product_options'] = $array_option;

    $txtCodeProd .= ' '.strtolower($txtIntroProd);

    $txtCodeProd = strip_tags($txtCodeProd);
    
    $txtCodeProd = str_replace_char($txtCodeProd);

    $txtCodeProd = str_replace_char($txtCodeProd);

    $original_name = $_SESSION['product_edit_txtNameProd'];
    /*---------------------------------------------------------------------*/
    switch ($selected_lang)             
    {
       // <editor-fold defaultstate="collapsed" desc="check dropdown_lang() value">

        case 'priority':  /*if selected option tag's value = 'priority'*/
            $selected_lang = null;  /*$selected_lang becomes empty*/
            $option_value = 'priority'; /*'priority' string included in $option_value variable*/
            break;

        case 'editL1':
            $selected_lang = $language_code_1;
            $option_value = 'editL1';
            $code_lang = $global_L1; /*'FR' value included in $code_lang*/
            break;

        case 'editL2':
            $selected_lang = $language_code_2;
            $option_value = 'editL2';
            $code_lang = $global_L2;
            break;

        case 'editL3':
            $selected_lang = $language_code_3;
            $option_value = 'editL3';
            $code_lang = $global_L3;
            break;

        case 'editL4':
            $selected_lang = $language_code_4;
            $option_value = 'editL4';
            $code_lang = $global_L4;
            break;

        case 'editL5':
            $selected_lang = $language_code_5;
            $option_value = 'editL5';
            $code_lang = $global_L5;
            break;

        case $language_code_1:
            $selected_lang = $language_code_1;
            $option_value = $language_code_1;
            $code_lang = $global_L1;
            break;

        case $language_code_2:
            $selected_lang = $language_code_2;
            $option_value = $language_code_2;
            $code_lang = $global_L2;
            break;

        case $language_code_3:
            $selected_lang = $language_code_3;
            $option_value = $language_code_3;
            $code_lang = $global_L3;
            break;

        case $language_code_4:
            $selected_lang = $language_code_4;
            $option_value = $language_code_4;
            $code_lang = $global_L4;
            break;

        case $language_code_5:
            $selected_lang = $language_code_5;
            $option_value = $language_code_5;
            $code_lang = $global_L5;
            break;

        case 'exitL1':
            $selected_lang = $language_code_1;
            $option_value = 'exitL1';
            $code_lang = $global_L1;
            break;

        case 'exitL2':
            $selected_lang = $language_code_2;
            $option_value = 'exitL2';
            $code_lang = $global_L2;
            break;

        case 'exitL3':
            $selected_lang = $language_code_3;
            $option_value = 'exitL3';
            $code_lang = $global_L3;
            break;

        case 'exitL4':
            $selected_lang = $language_code_4;
            $option_value = 'exitL4';
            $code_lang = $global_L4;
            break;

        case 'exitL5':
            $selected_lang = $language_code_5;
            $option_value = 'exitL5';
            $code_lang = $global_L5;
            break;// </editor-fold>
    }

    /*$code_lang value included in a used session at "dropdown_lang" function*/
    $_SESSION['function_page_add_code_lang'] = $code_lang;
    $_SESSION['select_lang_product_edit'] = $selected_lang;

    if($option_value == 'priority')/*if dropdown_lang() value is 'priority'*/
    {
        $BoKqueryInsert_Step1 = false; /*$BoKqueryInsert_Step1 is false*/

        /*'add' message deleted*/
        unset ($_SESSION['msg_product_add']);
    }
    else
    {
       $BoKqueryInsert_Step1 = true; 
    }

    if(empty($txtNameProd))
    {
        $_SESSION['msg_product_edit'] = "le champs nom produit est obligatoire";

        $_SESSION['product_edit_txtNameProd'] = $txtNameProd;
        $_SESSION['product_edit_txtCodeProd'] = $txtCodeProd;
        $_SESSION['product_edit_txtIntroProd'] = $txtIntroProd;
        $_SESSION['product_edit_txtDescriptProd'] = $txtDescriptProd;

        $BoKinsert = false;  
    }
    else
    {            
        $BoKinsert = true; 
    }    

    if($BoKinsert == true && $BoKqueryInsert_Step1 == true)
    {
        unset($_SESSION['msg_product_edit']);

        try
        {
            $query = $connectData->prepare('SELECT id_product, code_group_product, code_category_product
                                            FROM product
                                            WHERE number_product = :id');

            $query->bindParam('id', htmlspecialchars($txtNumProd));

            $query->execute();

            while($data = $query->fetch())
            {
                $id_product = $data[0];
//                $selected_group = $data[1];
//                $selected_category = $data[2];
            }

            $query->closeCursor();

            $query = $connectData->prepare('UPDATE product
                                            SET status_product = :status,
                                                number_product = :number,
                                                code_product_'.$selected_lang.' = :code,
                                                name_product_'.$selected_lang.' = :name,
                                                introduction_product_'.$selected_lang.' = :intro,
                                                description_product_'.$selected_lang.' = :desc,
                                                code_group_product = :group,
                                                code_category_product = :categ,
                                                id_option_product = :option,
                                                priority_product = :priority,
                                                image_thumb_product = :image,
                                                cart_type_product = :cart_type,
                                                transport_fee_product = :transport_fee
                                             WHERE id_product = :id');

            $query->execute(array(
                                  'status' => htmlspecialchars($status, ENT_QUOTES),
                                  'number' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                  'code' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
                                  'name' => htmlspecialchars($txtNameProd, ENT_QUOTES),
                                  'intro' => $txtIntroProd,
                                  'desc' => $txtDescriptProd,
                                  'group' => htmlspecialchars($selected_group, ENT_QUOTES),
                                  'categ' => htmlspecialchars($selected_category, ENT_QUOTES),
                                  'id' => htmlspecialchars($id_product, ENT_QUOTES),
                                  'option' => htmlspecialchars($option, ENT_QUOTES),
                                  'priority' => htmlspecialchars($priority, ENT_QUOTES),
                                  'image' => htmlspecialchars($image_upload, ENT_QUOTES),
                                  'cart_type' => htmlspecialchars($selected_cart_type, ENT_QUOTES),
                                  'transport_fee' => htmlspecialchars($selected_transport_fee, ENT_QUOTES)
                                  ));




            $_SESSION['product_edit_txtNumProd'] = $txtNumProd;
            $_SESSION['product_edit_txtCodeProd'] = $txtCodeProd;
            $_SESSION['product_edit_txtCodeUserProd'] = $txtCodeUserProd;
            $_SESSION['product_edit_txtNameProd'] = $txtNameProd;
            $_SESSION['product_edit_txtIntroProd'] = $txtIntroProd;
            $_SESSION['product_edit_txtDescriptProd'] = $txtDescriptProd;
            $_SESSION['product_edit_cboPriority'] = $priority;
            $_SESSION['product_edit_image'] = $image_upload;
            $_SESSION['rad_product_page'] = $radio_page;
            $_SESSION['product_edit_cboGroup'] = $selected_group;
            $_SESSION['product_edit_cboCateg'] = $selected_category;
            $_SESSION['product_edit_status'] = $status;
            $_SESSION['product_edit_cboGroupLink'] = $selected_group_link;
            $_SESSION['product_edit_cboCartType'] = $selected_cart_type;
            $_SESSION['product_edit_cboTransportFee'] = $selected_transport_fee;
            
            $_SESSION['msg_product_edit'] = 'Dernière opération: "'.$txtNameProd.'"';
        }
        catch(Exception $e)
        {
            die("Error : ".$e->getMessage());
        }
        $query->closeCursor();

        if($radio_page === 'yes')
        {

            try
            {
               $query = $connectData->prepare('SELECT id_page
                                             FROM product
                                             WHERE number_product = :number');

               $query->bindParam('number', htmlspecialchars($txtNumProd, ENT_QUOTES));

               $query->execute();

               while($data = $query->fetch())
               {
                   $id_page = $data[0];                                    
               }
               
               if($id_page == 0)
               {
                   $BoK_insert_page = true;
                   $BoK_insert_stats = true;
                   $BoK_insert_hierarchy = true;
               }
               else
               {
                   $BoK_insert_page = false;
                   $BoK_insert_stats = false;
                   $BoK_insert_hierarchy = false;
               }
               
               $query->closeCursor();
                              
               $query = $connectData->prepare('SELECT id_page
                                               FROM stats
                                               WHERE tags_page_L1 LIKE \'%'.$txtNumProd.'%\'');

               //$query->bindParam('id', htmlspecialchars($id_page, ENT_QUOTES));

               $query->execute();
               
               if(($data = $query->fetch()) != false)
               {
                   $query->execute();
                   while($data = $query->fetch())
                   {
                       $id_page_stats = $data[0];                                    
                   }
               }
               else
               {
                   $id_page_stats = 0;
               }

               if($id_page_stats == 0)
               {
                   $BoK_insert_stats = true;
               }
               else
               {
                   $BoK_insert_stats = false;
               }
               
               $query = $connectData->prepare('SELECT id_page
                                               FROM page
                                               WHERE url_page = :url');

               $query->bindParam('url', htmlspecialchars($txtNumProd, ENT_QUOTES));

               $query->execute();
               
               if(($data = $query->fetch()) != false)
               {
                   $query->execute();
                   while($data = $query->fetch())
                   {
                       $id_page_page = $data[0];                                    
                   }
               }
               else
               {
                   $id_page_page = 0;
               }

               if($id_page_page == 0)
               {
                   $BoK_insert_page = true;
               }
               else
               {                  
                   $BoK_insert_page = false;
               }
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            
            try
            {          
 #####               
                if($BoK_insert_page == true)
                {                 
                    $temp_url = $txtNameProd;

                    $temp_url = trim(strtolower($temp_url));

                    $temp_url = str_replace_char($temp_url);

                    $temp_url = preg_replace("#[ ']#", '', $temp_url);

                    $temp_url .= ' '.$txtNumProd;

                    $query = $connectData->prepare('INSERT INTO page 
                                                    (status_page, name_page_'.$selected_lang.',
                                                     title_page_'.$selected_lang.', 
                                                     introduction_page_'.$selected_lang.',
                                                     description_page_'.$selected_lang.',
                                                     tags_page_'.$selected_lang.',
                                                     url_page, image_thumb_page)
                                                    VALUES 
                                                    (:status, :name, :title,
                                                     :intro, :desc, :tags, 
                                                     :url, :image)');

                    $query->execute(array(
                                          'status' => htmlspecialchars($status, ENT_QUOTES),
                                          'name' => htmlspecialchars($txtNameProd, ENT_QUOTES),
                                          'title' => htmlspecialchars($txtNameProd, ENT_QUOTES),     
                                          'intro' => $txtIntroProd,
                                          'desc' => $txtDescriptProd,
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
                                          'url' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                          'image' => htmlspecialchars($image_upload, ENT_QUOTES)
                                          ));
                  
                    $query->closeCursor();
                    
  
                    $query = $connectData->prepare('SELECT COUNT(*) FROM page');
                    
                    $query->execute();
                    
                    if(($data = $query->fetch()) == 1)
                    {
                       $last_id_page = 1; 
                    }
                    else
                    {
                       $query = $connectData->prepare('SELECT id_page FROM page');
                    
                       $query->execute(); 
                       
                       while($data = $query->fetch())
                       {
                           $last_id_page = $data[0]; 
                       }
                    }
                              
                    $query->closeCursor();
                    
                    $query = $connectData->prepare('UPDATE product
                                                    SET id_page = :id_page
                                                    WHERE number_product = :number');

                    $query->execute(array(
                                          'id_page' => htmlspecialchars($last_id_page, ENT_QUOTES),
                                          'number' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                         ));

                    $query->closeCursor(); 
                                              
                }
                else
                {
//                    $query = $connectData->prepare('UPDATE page 
//                                                    SET status_page = :status, 
//                                                    name_page_'.$selected_lang.' = :name,
//                                                    title_page_'.$selected_lang.' = :title, 
//                                                    introduction_page_'.$selected_lang.' = :intro,
//                                                    description_page_'.$selected_lang.' = :desc,
//                                                    tags_page_'.$selected_lang.' = :tags, 
//                                                    image_thumb_page = :image
//                                                    WHERE id_page = :id');
                    
                    $query = $connectData->prepare('UPDATE page 
                                                    SET status_page = :status,
                                                    title_page_'.$selected_lang.' = :title, 
                                                    introduction_page_'.$selected_lang.' = :intro,
                                                    description_page_'.$selected_lang.' = :desc,
                                                    tags_page_'.$selected_lang.' = :tags, 
                                                    image_thumb_page = :image
                                                    WHERE id_page = :id');

//                    $query->execute(array(
//                                          'status' => htmlspecialchars($status, ENT_QUOTES),
//                                          'name' => htmlspecialchars($txtNameProd, ENT_QUOTES),
//                                          'title' => htmlspecialchars($txtNameProd, ENT_QUOTES),     
//                                          'intro' => htmlspecialchars($txtIntroProd, ENT_QUOTES),
//                                          'desc' => htmlspecialchars($txtDescriptProd, ENT_QUOTES),
//                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
//                                          'image' => htmlspecialchars($image_upload, ENT_QUOTES),
//                                          'id' => htmlspecialchars($id_page, ENT_QUOTES)
//                                          ));
                    $query->execute(array(
                                          'status' => htmlspecialchars($status, ENT_QUOTES),
                                          'title' => htmlspecialchars($txtNameProd, ENT_QUOTES),     
                                          'intro' => $txtIntroProd,
                                          'desc' => $txtDescriptProd,
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
                                          'image' => htmlspecialchars($image_upload, ENT_QUOTES),
                                          'id' => htmlspecialchars($id_page, ENT_QUOTES)
                                          ));

                    $query->closeCursor();
                }
              
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            

            try
            {                  
                if($BoK_insert_stats == true)
                {
                    $query = $connectData->prepare('SELECT id_page
                                                FROM page
                                                WHERE url_page = :id');

                    $query->bindParam('id', htmlspecialchars($txtNumProd, ENT_QUOTES));

                    $query->execute();
                    
                    while($data = $query->fetch())
                    {
                        $id_page_stats = $data[0];
                    }
                    
                    $query->closeCursor();    

                    $query = $connectData->prepare('INSERT INTO stats
                                                    (id_page, tags_page_'.$selected_lang.',
                                                     show_title_stats, show_intro_stats, show_desc_stats)
                                                    VALUES(:id, :tags, 1, 1, 1)');

                    $query->execute(array(
                                          'id' => htmlspecialchars($id_page_stats, ENT_QUOTES),
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES)
                                          ));
                    
                    $query->closeCursor();                
                }
                else
                {
                    $query = $connectData->prepare('UPDATE stats 
                                                SET tags_page_'.$selected_lang.' = :tags
                                                WHERE id_page = :id');

                    $query->execute(array(
                                          'id' => htmlspecialchars($id_page, ENT_QUOTES),
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES)                        
                                          ));                              

                    $query->closeCursor();
                }
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            
            try
            {                  
                if($BoK_insert_hierarchy == true)
                { 
                    $query = $connectData->prepare('INSERT INTO hierarchy 
                                                    (status_sitemap, id_page, url_page, name_sitemap_'.$selected_lang.')
                                                    VALUES (:status, :id_page, :url, :name)');

                    $query->execute(array(
                                          'status' => htmlspecialchars(0, ENT_QUOTES), 
                                          'id_page' => htmlspecialchars($last_id_page, ENT_QUOTES),
                                          'url' => htmlspecialchars($txtNumProd, ENT_QUOTES), 
                                          'name' => htmlspecialchars($txtNameProd, ENT_QUOTES)
                                          ));
                    
                    $query->closeCursor();                
                }
                else
                {
//                    $query = $connectData->prepare('SELECT status_sitemap FROM hierarchy
//                                                    WHERE id_page = :id');
//
//                    $query->bindParam('id', htmlspecialchars($id_page, ENT_QUOTES));
//                    $query->execute();
//                    
//                    while($data = $query->fetch())
//                    {
//                        $status_hierarchy = $data[0];
//                    }
//                    
//                    $query->closeCursor();
                    
                    if($status == 9)
                    {
                        #erase current invisible product everywhere it appears into number_link_product column
                        $i = 0;
                        $query = $connectData->prepare('SELECT * FROM product
                                                        WHERE MATCH (number_link_product)
                                                        AGAINST ('.$txtNumProd.')');
                        $query->execute();
                        
                        if(($data = $query->fetch()) != false)
                        {
                            $query->execute();
                            while($data = $query->fetch())
                            {
                                $array_id[$i] = $data[0];
                                $array_number_link[$i] = $data['number_link_product'];
                                $i++;
                            }
                            $query->closeCursor();
                        }
                        
                        $new_number_link_product = null;

                        for($i = 0; $i < count($array_id); $i++)
                        {
                            $array_splited_number_link = split_number_product($array_number_link[$i]);
                            
                            for($j = 0; $j < count($array_splited_number_link); $j++)
                            {
                                if($array_splited_number_link[$j] != $txtNumProd)
                                {
                                   if($new_number_link_product == null)
                                   {
                                       $new_number_link_product .= $array_splited_number_link[$j];
                                   }
                                   else
                                   {
                                       $new_number_link_product .= ','.$array_splited_number_link[$j];
                                   }
                                }
                            } 
                            
                            $query = $connectData->prepare('UPDATE product 
                                                            SET number_link_product = :number
                                                            WHERE id_product = :id');
                            $query->execute(array(
                                                  'number' => $new_number_link_product,
                                                  'id' => $array_id[$i]
                                                  ));
                            $query->closeCursor();
                            $new_number_link_product = null;
                        }
                        
                        $status = 0;
                    }                   
                    
                    $query = $connectData->prepare('UPDATE hierarchy 
                                                    SET status_sitemap = :status
                                                    WHERE id_page = :id');

                    $query->execute(array(
                                          'status' => htmlspecialchars($status, ENT_QUOTES),
                                          'id' => htmlspecialchars($id_page, ENT_QUOTES)
                                          ));
                    
                    $query->closeCursor(); 
                }
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            
    
        }
        
        $_SESSION['product_edit_close_popup'] = true;
    }// </editor-fold>     
}

if(isset($_POST['bt_save1']) || isset($_POST['bt_save2']))
{
    // <editor-fold defaultstate="collapsed" desc="Insert Product details AND Product stock">
    $price_public = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtPublic']), ENT_QUOTES));
    $price_promo = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtPromo']), ENT_QUOTES));
    $price_resale = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtResale']), ENT_QUOTES));
    $amount_ecotax = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtEcoTax']), ENT_QUOTES));  
    
    $product_length = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtLength']), ENT_QUOTES));  
    $product_width = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtWidth']), ENT_QUOTES));  
    $product_depth = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtDepth']), ENT_QUOTES));  
    $product_weigth = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtWeigth']), ENT_QUOTES));
    
    $delay_product = trim(htmlspecialchars($_POST['txtDelayStock'], ENT_QUOTES));
    
    $stock_name = trim(htmlspecialchars($_POST['txtNameStock'], ENT_QUOTES));  
    $stock_available = trim(htmlspecialchars($_POST['txtAvailableStock'], ENT_QUOTES));  
    $stock_alert = trim(htmlspecialchars($_POST['txtAlertStock'], ENT_QUOTES)); 
      
    
    $Bok_Insert_product_details = false;
    $Bok_query = true;
 
    try
    {
        $query = $connectData->prepare('SELECT id_product
                                        FROM product_details
                                        WHERE id_product = :id');
        
        $query->bindParam('id', $id_product);
        $query->execute();
        
        if(($data = $query->fetch()) == false)
        {
            $Bok_query = true;
            $Bok_Insert_product_details = true;
        }
        
        $query->closeCursor();
        
        if($Bok_query == true)
        {
            if($Bok_Insert_product_details == true)
            {
                $query = $connectData->prepare('INSERT INTO product_stock
                                                (id_product, name_stock, quantity_stock, alert_stock)
                                                VALUES (:id, :name_stock, :available, :alert)');

                $query->execute(array(
                                 'id' => $id_product,    
                                 'name_stock' => $stock_name,    
                                 'available' => $stock_available,
                                 'alert' => $stock_alert                              
                               ));

                $query->closeCursor();
                
                $query = $connectData->prepare('SELECT id_product FROM product_stock
                                                WHERE id_product = :id');

                $query->bindParam('id', $id_product);               
                $query->execute();
                
                while($data = $query->fetch())
                {
                    $id_stock = $data[0];
                }

                $query->closeCursor();
                
                $query = $connectData->prepare('INSERT INTO product_details
                                                (id_product, id_tax, id_stock, id_shipping,                                            
                                                 id_currency, length_details, width_details,
                                                 depth_details, weigth_details, price_public_details,
                                                 price_promo_details, price_resale_details,
                                                 price_ecotax_details, delivery_details)
                                                VALUES (:id, 0, :id_stock, 0, 0, :length, :width, :depth, :weigth,
                                                        :public, :promo, :resale, :ecotax, :delay)');

                $query->execute(array(
                                 'id' => $id_product,    
                                 'id_stock' => $id_stock,    
                                 'length' => $product_length,
                                 'width' => $product_width,
                                 'depth' => $product_depth,
                                 'weigth' => $product_weigth,
                                 'public' => $price_public,
                                 'promo' => $price_promo,
                                 'resale' => $price_resale,
                                 'ecotax' => $amount_ecotax,
                                 'delay' => $delay_product  
                               ));

                $query->closeCursor();
                
                


            }
            else
            {


                $query = $connectData->prepare('UPDATE product_details
                                                SET length_details = :length,
                                                width_details = :width,
                                                depth_details = :depth,
                                                weigth_details = :weigth,
                                                price_public_details = :public,
                                                price_promo_details = :promo,
                                                price_resale_details = :resale,
                                                price_ecotax_details = :ecotax,
                                                delivery_details = :delay
                                                WHERE id_product = :id');

                 $query->execute(array(
                                     'length' => $product_length,
                                     'width' => $product_width,
                                     'depth' => $product_depth,
                                     'weigth' => $product_weigth,
                                     'public' => $price_public,
                                     'promo' => $price_promo,
                                     'resale' => $price_resale,
                                     'ecotax' => $amount_ecotax,
                                     'delay' => $delay_product,
                                     'id' => $id_product         
                                   ));

                 $query->closeCursor();
                 
                 $query = $connectData->prepare('UPDATE product_stock
                                                SET name_stock = :name,
                                                quantity_stock = :available,
                                                alert_stock = :alert
                                                WHERE id_product = :id');

                 $query->execute(array(
                                     'name' => $stock_name,
                                     'available' => $stock_available,
                                     'alert' => $stock_alert,
                                     'id' => $id_product         
                                   ));

                 $query->closeCursor();
            }
            
            $_SESSION['product_edit_length'] = $product_length;
            $_SESSION['product_edit_width'] = $product_width;
            $_SESSION['product_edit_depth'] = $product_depth;
            $_SESSION['product_edit_weigth'] = $product_weigth;
            $_SESSION['product_edit_price_public'] = $price_public;
            $_SESSION['product_edit_price_promo'] = $price_promo;
            $_SESSION['product_edit_price_resale'] = $price_resale;
            $_SESSION['product_edit_price_ecotax'] = $amount_ecotax;
            
            $_SESSION['product_edit_name_stock'] = $stock_name;
            $_SESSION['product_edit_available_stock'] = $stock_available;
            $_SESSION['product_edit_alert_stock'] = $stock_alert;
            $_SESSION['product_edit_delay_stock'] = $delay_product;
        }
        
        
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    
    // </editor-fold>
}

?>
    

