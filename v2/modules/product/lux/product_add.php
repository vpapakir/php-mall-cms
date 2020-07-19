<?php
if(isset($_POST['bt_save1']) || isset($_POST['bt_save2']))
{
    //<editor-fold defaultstate="collapsed" desc="add product into the Database">
    if(isset($_POST['txtNameProd']) || $_POST['txtNumProd'])
    {
        
        if(isset($_POST['bt_save1']) && !isset($_POST['bt_save2']))
        {
           $selected_lang = $_POST['cboAddProduct1'];  
        }
        
        if(!isset($_POST['bt_save1']) && isset($_POST['bt_save2']))
        {
           $selected_lang = $_POST['cboAddProduct2']; 
        }
        
        $selected_group = $_SESSION['selected_group'];

        $BoKinsert = true;
       
        $txtNumProd = $_POST['txtNumProd'];
        
        $txtNameProd = $_POST['txtNameProd'];
        $txtCodeProd = $_POST['txtCodeProd'];
        $txtCodeUserProd = $_POST['txtCodeUserProd'];
        $txtIntroProd = $_POST['txtIntroProd'];
        $txtDescriptProd = $_POST['txtDescriptProd'];
        $priority = $_POST['cboPriority'];
        $image = $_POST['txtImgUpload'];
        $status = $_POST['cboStatus'];
        $selected_cart_type = $_POST['cboCartType'];
        $selected_transport_fee = $_POST['cboTransportFee'];
        
        $radio_product_add = $_POST['rad_product_add_page'];
        
        $selected_group = $_POST['cboGroup'];
        $selected_category = $_POST['cboCateg'];
        
        if(empty($image) || $image === 'images/photos/x.jpg')
        {
            $image = $default_product_image;
        }
        
        $_SESSION['rad_product_add_page'] = $radio_product_add;
        
        unset($_SESSION['product_add_refresh_edit'], $_SESSION['product_add_refresh_add']);
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
        
        if($option_value == 'priority')/*if dropdown_lang() value is 'priority'*/
        {
            $BoKqueryInsert_Step1 = false; /*$BoKqueryInsert_Step1 is false*/

            /*'add' message deleted*/
            //unset ($_SESSION['msg_product_add']);
        }
        else
        {
           $BoKqueryInsert_Step1 = true; 
        }

        /*if dropdown_lang() value is 'exit..'*/          
        if($option_value == 'exitL1' || $option_value == 'exitL2'
           || $option_value == 'exitL3' || $option_value == 'exitL4'
               || $option_value == 'exitL5')
        {
            $BoKInsert_and_exit = true;/*$BoKInsert_and_exit is true*/
            $BoKInsert_and_edit = false;/*conversely $BoKInsert_and_edit is false*/
        }
        else
        {
            $BoKInsert_and_exit = false;
        }

        /*if dropdown_lang() value is 'edit..'*/  
        if($option_value == 'editL1' || $option_value == 'editL2'
           || $option_value == 'editL3' || $option_value == 'editL4'
               || $option_value == 'editL5')
        {
            $BoKInsert_and_exit = false; /*$BoKInsert_and_exit is false*/
            $BoKInsert_and_edit = true; /*and this time $BoKInsert_and_edit is true*/
        }
        else
        {
            $BoKInsert_and_edit = false;
        }
        
        
        $txtCodeProd = trim(strtolower($txtCodeProd));

        $txtCodeUserProd = trim($txtCodeUserProd);
        
        if(empty($txtCodeUserProd))
        {
            $txtCodeProd = strtolower($txtNameProd.' '.$txtNumProd.' '.$txtIntroProd);
        }
        else
        {
            $txtCodeProd = strtolower($txtNameProd.' '.$txtNumProd.' '.$txtCodeUserProd.' '.$txtIntroProd);
        }
        
        
        
        $txtCodeProd = str_replace_char($txtCodeProd);
        $txtCodeProd = str_replace_char($txtCodeProd);

        if(empty($txtNameProd) || empty($txtNumProd))
        {
            $_SESSION['msg_product_add'] = "les champs Groupe, Catégorie, Numéro et Nom produit sont obligatoires";
            
            $_SESSION['txtNameProd'] = $txtNameProd;
            $_SESSION['txtCodeProd'] = $txtCodeProd;
            $_SESSION['txtIntroProd'] = $txtIntroProd;
            $_SESSION['txtDescriptProd'] = $txtDescriptProd;
            $_SESSION['txtCodeUserProd'] = $txtCodeUserProd;
            
            $BoKinsert = false;  
        }
        else
        {            
            $BoKinsert = true; 
        }



        if(empty($txtNumProd))
        {
            $BoKinsert_check_number = false;
            $_SESSION['msg_product_add'] = "saisir un numéro produit";
        }
        else
        {
            if(preg_match('#[a-zA-z]#', $txtNumProd))
            {
               $BoKinsert_check_number = false;
               $_SESSION['msg_product_add'] = "saisir des chiffres pour le numéro produit"; 
            }
            else
            {
               $BoKinsert_check_number = true; 
            }
        }
        
        if($BoKinsert_check_number == true)
        {
            try
            {
                $query = $connectData->query('SELECT number_product FROM product
                                              WHERE number_product = \''.$txtNumProd.'\'');

                $data = $query->fetch();

                if($data == false)
                {
                    $BoKinsert_inall = true;
                }
                else
                {
                    $BoKinsert_inall = false;
                    $_SESSION['msg_product_add'] = "numéro \"".$txtNumProd."\" déjà existant";
                }
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }

            $query->closeCursor();
        }
        else
        {
           $BoKinsert_inall = false; 
        }
        


        if($BoKinsert == true && $BoKqueryInsert_Step1 == true && $BoKinsert_inall == true)
        {           
            try
            {
                $query = $connectData->prepare('INSERT INTO product
                                                (status_product, number_product, code_product_'.$selected_lang.',
                                                 name_product_'.$selected_lang.', introduction_product_'.$selected_lang.',
                                                 description_product_'.$selected_lang.', code_group_product,
                                                 code_category_product, priority_product, image_thumb_product,
                                                 cart_type_product, transport_fee_product)
                                                 VALUES (:status, :number, :code, :name, :intro, 
                                                         :desc, :group, :categ, :priority, :image,
                                                         :cart_type, :transport_fee)');
                
                $query->execute(array(
                                      'status' => htmlspecialchars($status, ENT_QUOTES),
                                      'number' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                      'code' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
                                      'name' => htmlspecialchars($txtNameProd, ENT_QUOTES),
                                      'intro' => htmlspecialchars($txtIntroProd, ENT_QUOTES),
                                      'desc' => htmlspecialchars($txtDescriptProd, ENT_QUOTES),
                                      'group' => htmlspecialchars($selected_group, ENT_QUOTES),
                                      'categ' => htmlspecialchars($selected_category, ENT_QUOTES),
                                      'priority' => htmlspecialchars($priority, ENT_QUOTES),
                                      'image' => htmlspecialchars($image, ENT_QUOTES),
                                      'cart_type' => htmlspecialchars($selected_cart_type, ENT_QUOTES),
                                      'transport_fee' => htmlspecialchars($selected_transport_fee, ENT_QUOTES)
                                      ));
                
                unset($_SESSION['product_edit_txtNumProd']);
                unset($_SESSION['product_edit_txtCodeProd']);
                unset($_SESSION['product_edit_txtNameProd']);
                unset($_SESSION['product_edit_txtIntroProd']);
                unset($_SESSION['product_edit_txtDescriptProd']);
                unset($_SESSION['product_edit_txtCodeUserProd']);
                unset($_SESSION['product_edit_image']);
                unset($_SESSION['product_edit_status']);
                unset($_SESSION['number_product_edit']);
                unset($_SESSION['product_edit_cboGroup']);
                unset($_SESSION['product_edit_cboCateg']);
                unset($_SESSION['product_edit_cboPriority']);
                unset($_SESSION['product_edit_cboCartType']);
                unset($_SESSION['product_edit_cboTransportFee']);
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
            $query->closeCursor();
            
            if($radio_product_add === 'yes')
            {
                try
                {                
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
                                          'url' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                          'intro' => htmlspecialchars($txtIntroProd, ENT_QUOTES),
                                          'desc' => htmlspecialchars($txtDescriptProd, ENT_QUOTES),
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES),
                                          'image' => htmlspecialchars($image, ENT_QUOTES)
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
                           
                    $query = $connectData->prepare('UPDATE product
                                                    SET id_page = :id_page
                                                    WHERE number_product = :number_product');

                    $query->execute(array(
                                          'id_page' => htmlspecialchars($last_id_page, ENT_QUOTES),
                                          'number_product' => htmlspecialchars($txtNumProd, ENT_QUOTES),
                                         ));

                    $query->closeCursor();
                }
                catch(Exception $e)
                {
                    die("Error : ".$e->getMessage());
                }
                $query->closeCursor();

                try
                {                
                    $query = $connectData->prepare('INSERT INTO stats 
                                                    (id_page, tags_page_'.$selected_lang.',
                                                     show_title_stats, show_intro_stats, show_desc_stats)
                                                    VALUES (:id, :tags, 1, 1, 1)');

                    $query->execute(array(
                                          'id' => htmlspecialchars($last_id_page, ENT_QUOTES),
                                          'tags' => htmlspecialchars($txtCodeProd, ENT_QUOTES)                        
                                          ));
                }
                catch(Exception $e)
                {
                    die("Error : ".$e->getMessage());
                }
                $query->closeCursor();
                
                try
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
                }
                catch(Exception $e)
                {
                    die("Error : ".$e->getMessage());
                }
                $query->closeCursor();
            }
            
            if($BoKInsert_and_edit == true)/*if $option_value is 'edit..'*/
            {
               /*'product_edit' page will load*/
               try
               {
                  $query = $connectData->prepare('SELECT id_product FROM product');
                  $query->execute();
                  
                  while($data = $query->fetch())
                  {
                      $last_id_product = $data[0];
                  }
                  $query->closeCursor();
               }
               catch(Exception $e)
               {
                   die("Error : ".$e->getMessage());
               }
                
               $_SESSION['product_add_txtNumProd'] = $txtNumProd;
               $_SESSION['product_add_txtCodeProd'] = $txtCodeProd;
               $_SESSION['product_add_txtNameProd'] = $txtNameProd;
               $_SESSION['product_add_txtIntroProd'] = $txtIntroProd;
               $_SESSION['product_add_txtDescriptProd'] = $txtDescriptProd;
               $_SESSION['product_add_txtCodeUserProd'] = $txtCodeUserProd;
               $_SESSION['product_add_image'] = $image;
               $_SESSION['product_add_status'] = $status;
               $_SESSION['product_add_cboCartType'] = $selected_cart_type;
               $_SESSION['product_add_cboTransportFee'] = $selected_transport_fee;
               $_SESSION['product_edit_cboPriority'] = $priority;
               $_SESSION['product_edit_cboGroup'] = $selected_group;
               $_SESSION['product_edit_cboCateg'] = $selected_category;              
               
               //$_SESSION['product_add_refresh_edit'] = true;
               
               header('Location: '.$header.$_SESSION['index'].'?page=product_edit&nbp='.$last_id_product);
            }

            if($BoKInsert_and_exit == true)/*if $option_value is 'exit..'*/
            {
               /*'product_add' page will load*/
               //$_SESSION['product_add_refresh_add'] = true; 
               $_SESSION['msg_product_add'] = 'Dernier produit créé: "'.$txtNameProd.'"';
               
               unset($_SESSION['product_add_txtNumProd']);
               unset($_SESSION['product_add_txtCodeProd']);
               unset($_SESSION['product_add_txtNameProd']);
               unset($_SESSION['product_add_txtIntroProd']);
               unset($_SESSION['product_add_txtDescriptProd']);
               unset($_SESSION['product_add_txtCodeUserProd']);
               unset($_SESSION['product_add_image']);
               unset($_SESSION['product_add_status']);
               
               header('Location: '.$header.$_SESSION['index'].'?page=product_add');
            }


        }
        
        if($BoKInsert_and_edit == false && $BoKInsert_and_exit == false)
        {
            //$_SESSION['product_add_refresh_add'] = true;
            $_SESSION['msg_product_add'] = 'Dernier produit créé: "'.$txtNameProd.'"';
            
            unset($_SESSION['product_add_txtNumProd']);
            unset($_SESSION['product_add_txtCodeProd']);
            unset($_SESSION['product_add_txtNameProd']);
            unset($_SESSION['product_add_txtIntroProd']);
            unset($_SESSION['product_add_txtDescriptProd']);
            unset($_SESSION['product_add_txtCodeUserProd']);
            unset($_SESSION['product_add_image']);
            unset($_SESSION['product_add_status']);
            unset($_SESSION['product_add_cboCartType']);
            unset($_SESSION['product_add_cboTransportFee']);
            
            header('Location: '.$header.$_SESSION['index'].'?page=product_add');
        }
    }// </editor-fold>
}

if((isset($_POST['bt_save1']) && $BoKinsert === true && $BoKqueryInsert_Step1 === true && $BoKinsert_inall === true) || (isset($_POST['bt_save2']) && $BoKinsert === true && $BoKqueryInsert_Step1 === true && $BoKinsert_inall === true))
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

    $product_delay = trim(htmlspecialchars($_POST['txtDelayStock']), ENT_QUOTES); 
    
    $stock_name = trim(htmlspecialchars($_POST['txtNameStock']), ENT_QUOTES);  
    $stock_available = trim(htmlspecialchars($_POST['txtAvailableStock']), ENT_QUOTES);  
    $stock_alert = trim(htmlspecialchars($_POST['txtAlertStock']), ENT_QUOTES);
    
    $Bok_Insert_product_details = false;
    $Bok_query = true;
    
    try
    {
        $query = $connectData->prepare('SELECT id_product FROM product
                                          WHERE number_product = :number');

        $query->bindParam('number', $txtNumProd);
        $query->execute();
        
        while($data = $query->fetch())
        {
            $id_product = $data[0];
        }
        
        $query->closeCursor();              
        
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

        $query->closeCursor();

        $query = $connectData->prepare('SELECT id_stock FROM product_stock
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
                         'delay' => $product_delay     
                       ));

        $query->closeCursor();

        if($BoKInsert_and_edit == true)/*if $option_value is 'edit..'*/
        {
            $_SESSION['product_add_length'] = $product_length;
            $_SESSION['product_add_width'] = $product_width;
            $_SESSION['product_add_depth'] = $product_depth;
            $_SESSION['product_add_weigth'] = $product_weigth;
            $_SESSION['product_add_price_public'] = $price_public;
            $_SESSION['product_add_price_promo'] = $price_promo;
            $_SESSION['product_add_price_resale'] = $price_resale;
            $_SESSION['product_add_price_ecotax'] = $amount_ecotax;

            $_SESSION['product_add_name_stock'] = $stock_name;
            $_SESSION['product_add_available_stock'] = $stock_available;
            $_SESSION['product_add_alert_stock'] = $stock_alert;
            $_SESSION['product_add_delay_stock'] = $product_delay;
        }
        else
        {
            unset($_SESSION['product_edit_length']);
            unset($_SESSION['product_edit_width']);
            unset($_SESSION['product_edit_depth']);
            unset($_SESSION['product_edit_weigth']);
            unset($_SESSION['product_edit_price_public']);
            unset($_SESSION['product_edit_price_promo']);
            unset($_SESSION['product_edit_price_resale']);
            unset($_SESSION['product_edit_price_ecotax']);
            unset($_SESSION['product_edit_name_stock']);
            unset($_SESSION['product_edit_available_stock']);
            unset($_SESSION['product_edit_alert_stock']);
            unset($_SESSION['product_edit_delay_stock']);

            unset($_SESSION['product_add_length']);
            unset($_SESSION['product_add_width']);
            unset($_SESSION['product_add_depth']);
            unset($_SESSION['product_add_weigth']);
            unset($_SESSION['product_add_price_public']);
            unset($_SESSION['product_add_price_promo']);
            unset($_SESSION['product_add_price_resale']);
            unset($_SESSION['product_add_price_ecotax']);
            unset($_SESSION['product_add_name_stock']);
            unset($_SESSION['product_add_available_stock']);
            unset($_SESSION['product_add_alert_stock']);
            unset($_SESSION['product_add_delay_stock']);
        }
           
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    
    // </editor-fold>
}

if(isset($_POST['bt_choosen_group']) || isset($_POST['bt_choosen_categ']))
{
    // <editor-fold defaultstate="collapsed" desc="Keep typed Info on memory">
    $selected_group = $_POST['cboGroup'];
    
    if($selected_group == 'select')
    {
        unset($_SESSION['check_selected']);
    }
    else
    {
        $_SESSION['check_selected'] = $selected_group; 
    }
    
    if(!isset($_POST['bt_save1']) || !isset($_POST['bt_save2']))
    {
        $txtNumProd = $_POST['txtNumProd'];        
        $txtNameProd = $_POST['txtNameProd'];
        $txtCodeProd = $_POST['txtCodeProd'];
        $txtCodeUserProd = $_POST['txtCodeUserProd'];
        $txtIntroProd = $_POST['txtIntroProd'];
        $txtDescriptProd = $_POST['txtDescriptProd'];
        $priority = $_POST['cboPriority'];
        $image = $_POST['txtImgUpload'];
        $status = $_POST['cboStatus'];
        $selected_cart_type = $_POST['cboCartType'];
        $selected_transport_fee = $_POST['cboTransportFee'];

        $price_public = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtPublic']), ENT_QUOTES));
        $price_promo = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtPromo']), ENT_QUOTES));
        $price_resale = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtResale']), ENT_QUOTES));
        $amount_ecotax = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtEcoTax']), ENT_QUOTES));     
        $product_length = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtLength']), ENT_QUOTES));  
        $product_width = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtWidth']), ENT_QUOTES));  
        $product_depth = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtDepth']), ENT_QUOTES));  
        $product_weigth = trim(htmlspecialchars(str_replace(',', '.', $_POST['txtWeigth']), ENT_QUOTES));
        $stock_name = trim(htmlspecialchars($_POST['txtNameStock']), ENT_QUOTES);  
        $stock_available = trim(htmlspecialchars($_POST['txtAvailableStock']), ENT_QUOTES);  
        $stock_alert = trim(htmlspecialchars($_POST['txtAlertStock']), ENT_QUOTES);

        $_SESSION['product_add_txtNumProd'] = $txtNumProd;
        $_SESSION['product_add_txtCodeProd'] = $txtCodeProd;
        $_SESSION['product_add_txtNameProd'] = $txtNameProd;
        $_SESSION['product_add_txtIntroProd'] = $txtIntroProd;
        $_SESSION['product_add_txtDescriptProd'] = $txtDescriptProd;
        $_SESSION['product_add_txtCodeUserProd'] = $txtCodeUserProd;
        $_SESSION['product_add_image'] = $image;
        $_SESSION['product_add_status'] = $status;
        $_SESSION['product_add_cboCartType'] = $selected_cart_type;
        $_SESSION['product_add_cboTransportFee'] = $selected_transport_fee;

        $_SESSION['product_add_length'] = $product_length;
        $_SESSION['product_add_width'] = $product_width;
        $_SESSION['product_add_depth'] = $product_depth;
        $_SESSION['product_add_weigth'] = $product_weigth;
        $_SESSION['product_add_price_public'] = $price_public;
        $_SESSION['product_add_price_promo'] = $price_promo;
        $_SESSION['product_add_price_resale'] = $price_resale;
        $_SESSION['product_add_price_ecotax'] = $amount_ecotax;

        $_SESSION['product_add_name_stock'] = $stock_name;
        $_SESSION['product_add_available_stock'] = $stock_available;
        $_SESSION['product_add_alert_stock'] = $stock_alert;
    }
    
    header('Location: '.$header.$_SESSION['index'].'?page=product_add');// </editor-fold>
}

include($backoffice_html_skeleton_part1); 
?>

<!-- product_add.php -->

<!-- allows user to add a product into the database -->

<?php
/*all translate variables are declared here*/
$product_add_title = create_translation_array('product_add.title.text');

$subtitle_search = create_translation_array('translation_edit.search_label.text');//"Search"

$subtitle_group = create_translation_array('product_add.group_label.text');//"Group"
$subtitle_category = create_translation_array('product_add.category_label.text');//"Category"
$subtitle_product_number = create_translation_array('product_add.product_number_label.text');//"Product number"
$subtitle_product_name = create_translation_array('product_add.product_name_label.text');//"Product name"
$subtitle_product_keyword = create_translation_array('product_add.product_key_word_label.text');//"Product Keywords"
$subtitle_product_introduction = create_translation_array('product_add.product_intro_label.text');//"Product Introduction"
$subtitle_product_description = create_translation_array('product_add.product_description_label.text');//"Product Description"
$subtitle_product_manual_tags = create_translation_array('product_add.product_manual_tags_label.text');//"Tags"

$dropdown_select_group = create_translation_array('product_add.select_group.dropdown');//"Select group"
$dropdown_select_category = create_translation_array('product_add.select_category.dropdown');//"Select category"

$image_title_add_group = create_translation_array('product_add.add_group.icon');//"Add group"
$image_title_add_category = create_translation_array('product_add.add_category.icon');//"Add category"

$used_language = $_SESSION['lang'];
?>

<!-- Table number 1 -->
<TABLE width="100%" bgcolor="white">
    
    <!-- Table number 2 -->
    <!-- form to save typed Information in textfields and Dropdown -->
    <form method="post">
    <td><TABLE width="100%" id="form_product_edit">
        
            <td id="center_title" colspan="2">
                <?php
                    echo(call_translation(@$_SESSION['translation'], find_word($product_add_title))); 
                ?>
            </td>
            <tr><td colspan="2"><hr></hr></td></tr>             
    
        <tr></tr>
            
                
                <td width="25%"></td>
                <td><SELECT name="cboAddProduct1" onchange="OnChange('bt_save1')">
                    <?php

                        dropdown_lang();

                    ?>                        
                    </SELECT>
                    <!-- an hidden button to use it when user selected a dropdown value -->
                    <input style="display: none;" id="bt_save1" type="submit" name="bt_save1" hidden="true"></input> 
                    <br clear="left">
                    <span id="msg_wrong"><?php echo(check_session_input(@$_SESSION['msg_product_add'])); ?></span>
                </td>                  
                <tr><td colspan="2"><hr></hr></td></tr>
        
        <tr></tr>
            <!-- form to choose a product according to it membership in a group  -->
            
                <td id="center_subtitle"><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_group))); ?></td>
                <td><select name="cboGroup" onchange="OnChange('bt_choosen_group');">
                        <!-- if session's value is null, display "selected" 
                        string at this option tag in order to keep this option 
                        value display when the page will reload -->
                        <option value="select" <?php if(empty($_SESSION['check_selected'])) { echo("selected"); }else { echo(""); }?>>-- <?php echo(call_translation(@$_SESSION['translation'], find_word($dropdown_select_group))); ?> --</option>
<?php

    $code_group_array[] = 0; //create an array
    $i = 0; //create an index   
    
    try//execute a query
    {              
        $query = $connectData->query('SELECT code_group_product, 
                                             name_group_product_'.$used_language.' 
                                        FROM product_group
                                        ORDER BY name_group_product_'.$used_language);
     
        /*"for" loop which goes through an array to insert values in it*/
        for($i = 0; $i < count($code_group_array); $i++)  
        {
            while($data = $query->fetch())//read the database according to the query result
            {
                /*display : <option value='data[0] value' selected="true or false">'data[1]</option>'*/
                echo("<option value='".$data[0]."'");

                //this session takes a value at line 142 when user selected a group at the dropdownlist
                if(!empty($_SESSION['check_selected']))
                {
                    //if $code_category value == $data[0]
                    if($_SESSION['check_selected'] == $data[0])
                    {
                        echo("selected"); //then display "selected" in the option tag
                    }
                    else
                    {
                        echo("");//else display nothing
                    }
                }

                echo(">".$data[1]."</option>");
                $code_group_array[$i] = $data[0]; //data[0] value included in array at $i index value
                $i++;
             }
         }

         //after the loop all value which are in $code_group_array included in a session
         $_SESSION['array_value_cboGroup'] = $code_group_array;           
    }
    catch (Exception $e)
    {
            die("<br>Error : ".$e->getMessage());
    }
    $query->closeCursor();//closed query
    
?>         
                    </select>
                    <!-- an hidden button to use it when user selected a dropdown value -->
                    <input style="display: none;" id="bt_choosen_group" type="submit" name="bt_choosen_group" hidden="true"></input>
                    &nbsp;
                    <a href="<?php echo($_SESSION['index']); ?>?page=product_group_add_edit" style="vertical-align: inherit;"><img src="graphics/icons/pen16x16.png" title="<?php echo(call_translation(@$_SESSION['translation'], find_word($image_title_add_group))); ?>" src="Add group"></img></a></td>                  
            
        
        <tr></tr>
            <!-- form to chose a product according to it membership in a category 
            and this form is hidden if user didn't select a group at above dropdownlist -->
            
                <td id="center_subtitle" <?php if(empty($_SESSION['check_selected'])) { echo("hidden style=\"display: none;\""); }else { echo(@$_SESSION['hidden']); } ?>><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_category))); ?></td>
                <td><select name="cboCateg" <?php if(empty($_SESSION['check_selected'])) { echo("hidden style=\"display: none;\""); }else { echo(@$_SESSION['hidden']); } ?> onchange="OnChange('bt_choosen_categ')">
                      
<?php

if(isset($_POST['bt_choosen_group']))//if user chose a group, javascript simulate a click's button 
{
    // <editor-fold defaultstate="collapsed" desc="display category dropdown">
    $_SESSION['categ_already_selected'] = false;
    $_SESSION['hidden'] = ""; //"hidden" session becomes empty
    $i = 0; //create an index
    $code_category = null; //create a variable
    $array_options_1[] = 0; //create 2 arrays for futur created option tags
    $array_options_2[] = 0;
    
    $selected_group = $_POST['cboGroup']; //'cboGroup' dropdown value included in a variable

    //$code_group_array value included in another array
    $array_value_cboGroup = $_SESSION['array_value_cboGroup']; 
    
    for($i = 0; $i < count($array_value_cboGroup); $i++)//goes through the "$array_value_cboGroup" array 
    {
       //if selected_group value is == to the $array_value_cboGroup at $i index
       if($selected_group == $array_value_cboGroup[$i]) 
       {
           //value at $i index included in $code_category variable
           $code_category = $array_value_cboGroup[$i]; 
           
           /*$i takes an higher value than index total number of 
            * $array_value_cboGroup + 1 to go out the loop*/
           $i = count($array_value_cboGroup) + 1;
       }            
    } 

    if($code_category == null)//if $code_category is empty
    {
        @$_SESSION['hidden'] = "hidden"; //"hidden" string included in hidden session 
    }
    
    $_SESSION['check_selected'] = $code_category; //$code_category value included in a session
    
    $_SESSION['selected_group'] = $selected_group; //$selected_group value included in a session
    
    try//try to execute another query
    {          
        $query = $connectData->query('SELECT code_category_product, name_category_product_'.$used_language.' 
                                        FROM product_category
                                        ORDER BY name_category_product_'.$used_language);
        
        $query->execute();
         
     //insert into $array_options_1 and 2 data's value at $i index   
     for($i = 0; $i < count($array_options_1); $i++)
     {
        while($data = $query->fetch())
        {          
            $array_options_1[$i] = $data[0];
            $array_options_2[$i] = $data[1];
            $i++;
        }
        
     }
     /*insert option's tag in sessions to display it after the page reloader 
      * without that cboCateg DropDown List will still stay empty*/   
     $_SESSION['add_options_cboCateg_1'] = $array_options_1;
     $_SESSION['add_options_cboCateg_2'] = $array_options_2;
    }
    catch (Exception $e)
    {
            die("<br>Error : ".$e->getMessage());
    }
    $query->closeCursor();// </editor-fold>
}

for($i = 0; $i < count(@$_SESSION['add_options_cboCateg_1']); $i++)
{
    // <editor-fold defaultstate="collapsed" desc="display option tags when the page has been reloaded">
    echo("<option value='".@$_SESSION['add_options_cboCateg_1'][$i]."' ");
    
    if(!empty($_SESSION['selected_categ']))
    {
        if($_SESSION['selected_categ'] == @$_SESSION['add_options_cboCateg_1'][$i])
        {
            echo("selected");
        }
        else
        {
            echo("");
        }
    }
    
    echo(">".@$_SESSION['add_options_cboCateg_2'][$i]."</option>");// </editor-fold>
}

?>  
                        
                    </select>                  
                    <a <?php if(empty($_SESSION['check_selected'])) { echo("hidden style=\"display: none;\""); }else { echo(@$_SESSION['hidden']); } ?> href="<?php echo($_SESSION['index']); ?>?page=product_category_add_edit" style="vertical-align: inherit;"><img src="graphics/icons/pen16x16.png" title="<?php echo(call_translation(@$_SESSION['translation'], find_word($image_title_add_category))); ?>" src="Add category"></img></a></td>
        
        <tr></tr>
            <!-- hidden textfield which will display when user will selected group -->
            <td id="center_subtitle" <?php if(empty($_SESSION['check_selected'])) { echo("hidden"); }else { echo(@$_SESSION['hidden']); } ?>><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_number))); ?></td>
            <td><input style="<?php echo($width_textfield); ?>" <?php if(empty($_SESSION['check_selected'])) { echo("hidden"); }else { echo(@$_SESSION['hidden']); } ?> type="text" name="txtNumProd" value="<?php echo(check_session_input(@$_SESSION['product_add_txtNumProd'])); ?>"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle"><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_name))); ?></td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtNameProd" value="<?php echo(check_session_input(@$_SESSION['product_add_txtNameProd'])); ?>"/></td>   
            
        <tr></tr>
        
            <td id="center_subtitle" hidden><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_keyword))); ?></td>
            <td hidden ><input style="<?php echo($width_textfield); ?>" type="text" name="txtCodeProd"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle"><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_manual_tags))); ?></td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtCodeUserProd" value="<?php echo(check_session_input(@$_SESSION['product_add_txtCodeUserProd'])); ?>"/></td>
            
        <tr></tr>
        
            <td id="center_subtitle">Priorité</td>
            <td><SELECT name="cboPriority">
                    <?php
                    for($i = 1; $i < 10; $i++)
                    {
                        echo('<option value="'.$i.'">'.$i.'</option>');
                    }                   
                    ?>                    
                </SELECT>
            </td>
            
        <tr></tr>
        
            <td id="center_subtitle" colspan="2"><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_introduction))); ?></td>
            
        <tr></tr>    
            
            <td colspan="2"><TEXTAREA class="ckeditor" <?php echo($textarea_rows.' '.$textarea_cols); ?> name="txtIntroProd" /><?php echo(check_session_input(@$_SESSION['product_add_txtIntroProd'])); ?></TEXTAREA></td>
            
        <tr></tr>
        
            <td id="center_subtitle" colspan="2"><?php echo(call_translation(@$_SESSION['translation'], find_word($subtitle_product_description))); ?></td>
            
        <tr></tr>
            
            <td colspan="2"><TEXTAREA class="ckeditor" <?php echo($textarea_rows.' '.$textarea_cols); ?> name="txtDescriptProd"/><?php echo(check_session_input(@$_SESSION['product_add_txtDescriptProd'])); ?></TEXTAREA></td> 
         
        <tr></tr>
        
            <td id="center_subtitle">Image</td>
            <td><input style="<?php echo($width_textfield); ?>" type="text" name="txtImgUpload" value="<?php if(check_session_input(@$_SESSION['product_add_image']) === null){ echo('images/photos/x.jpg'); }else{ echo($_SESSION['product_add_image']); } ?>"></input></td>   
         
<!--        <tr></tr>
            
            <td id="center_subtitle">Image Upload Test</td>
            <td>
                <div id="UploadDiv">
                    <input id="txtUpload" type="file" name="txtUploadReal" onchange="upload_insert_value('txt_upload', 'txtUpload')" onmouseout="upload_button_mouseout('bt_upload')" onmouseover="upload_button_mouseover('bt_upload');"></input>
                    <div id="ImageDiv">
                        <input id="txt_upload" style="width: auto;" type="text" name="txtUpload" readonly="readonly"/>
                        <input id="bt_upload" type="submit" name="bt_upload" value="Parcourir"/>
                    </div>
                    
                </div>
            </td>-->
            
        <tr></tr>
        
            <td id="center_subtitle">Statut</td>
            <td>
                <SELECT name="cboStatus">
                    <option value="1">Activé</option>
                    <option value="0">Désactivé</option>                 
                </SELECT>
            </td>
            
        <tr></tr>
            
            <td id="center_subtitle">Type de caddie</td>
            <td>
                <SELECT name="cboCartType">
                    <option value="no">Aucun</option>
                    <option value="outofprogram">Plus en vente</option>
                    <option value="request">Demande de devis</option>
                    <option value="shop" selected>Boutique</option>
                </SELECT>
            </td>
            
        <tr></tr>
            
            <td id="center_subtitle">Frais de transport</td>
            <td>
                <SELECT name="cboTransportFee">
                    <option value="paid" selected>Payant</option>
                    <option value="free">Gratuit</option>
                </SELECT>
            </td>
            
        <tr></tr>
        
            <td id="center_subtitle">
                Créer une page ?
            </td>
            <td>
                <input <?php if(empty($_SESSION['rad_product_add_page']) || !empty($_SESSION['rad_product_add_page']) && $_SESSION['rad_product_add_page'] === 'yes'){ echo('checked'); }else{ echo(null); } ?> type="radio" name="rad_product_add_page" value="yes"><span id="center_text">Oui</span></input>
                &nbsp;
                <input <?php if(!empty($_SESSION['rad_product_add_page']) && $_SESSION['rad_product_add_page'] === 'no'){ echo('checked'); }else{ echo(null); } ?> type="radio" name="rad_product_add_page" value="no"><span id="center_text">Non</span></input>
            </td>
        
        <tr></tr>
            <!-- form to save typed Information in textfields and Dropdown -->
                <tr><td colspan="2"><hr></hr></td></tr>
         
        </TABLE></td>  
        
    <tr></tr> 
    
                <td><?php include('product/product_details.php'); ?></td>
                
    <tr><td colspan="2"><hr></hr></td></tr>  
    
        <td><TABLE width="100%" border="0">
                
                <td width="25%"></td>
                <td colspan="2">
                    <SELECT name="cboAddProduct2" onchange="OnChange('bt_save2')">
                    <?php 

                      dropdown_lang();

                    ?>
                    </SELECT>
                    <input style="display: none;" id="bt_save2" type="submit" name="bt_save2" hidden></input>
                </td>
                       
                         
        
        </TABLE></td>
    </form>  
</TABLE>

<!--import my javascript-->

<script type="text/javascript" src="script.js"></script>

<?php include($backoffice_html_skeleton_part2); ?>


