<?php 
if($_SESSION['autorisation'] === true)
{
    $used_language = $_SESSION['lang'];
    
    if($_SESSION['index'] == 'index_backoffice.php')
    {
        include($backoffice_html_skeleton_part1);    
    }
    else
    {
        echo('<td>');
    }
    
    // <editor-fold defaultstate="collapsed" desc="Give products number which exists and existing group product">
    try
    {
        #Count total product which available stock is under the alert level
        $query = $connectData->prepare('SELECT COUNT(product.id_product)
                                        FROM product
                                        INNER JOIN product_stock
                                        ON product.id_product = product_stock.id_product
                                        WHERE quantity_stock <= alert_stock AND alert_stock <> 0
                                        AND status_product = 1');
                
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $count_list_alert = $data[0];
        }
        $query->closeCursor();
        
        #Gives id product which available stock is under the alert level
        $query = $connectData->prepare('SELECT product.id_product
                                        FROM product
                                        INNER JOIN product_stock
                                        ON product.id_product = product_stock.id_product
                                        WHERE quantity_stock <= alert_stock AND alert_stock <> 0
                                        AND status_product = 1');
                
        $query->execute();

        $i = 0;
        
        while($data = $query->fetch())
        {
            $id_product_alert[$i] = $data[0];
            $i++;
        }
        $query->closeCursor();
        
        #Gives existing group product
        $query = $connectData->prepare('SELECT code_group_product, name_group_product_'.$used_language.'
                                        FROM product_group
                                        WHERE status_group_product = 1');
                
        $query->execute();
        
        $i = 0;
        
        while($data = $query->fetch())
        {
            $group_code_product[$i] = $data[0];
            $group_name_product[$i] = $data[1];
            $i++;
        }
        $query->closeCursor();
        
        $j = 0;
        $x = 0;
        for($i = 0; $i < count($group_code_product); $i++)        
        {
            #Count products which are in concerned group
            $query = $connectData->prepare('SELECT COUNT(product.id_product)
                                            FROM product
                                            INNER JOIN (product_stock
                                            INNER JOIN product_details
                                            ON product_stock.id_product = product_details.id_product)
                                            ON product.id_product = product_stock.id_product
                                            WHERE status_product = 1 AND code_category_product = 900
                                            AND code_group_product = :group');

            $query->bindParam('group', htmlspecialchars($group_code_product[$i], ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $count_list_group[$j] = $data[0];
                $j++;
            }
            
            #Gives ids product which are in concerned group
            $query = $connectData->prepare('SELECT product.id_product
                                            FROM product
                                            INNER JOIN (product_stock
                                            INNER JOIN product_details
                                            ON product_stock.id_product = product_details.id_product)
                                            ON product.id_product = product_stock.id_product
                                            WHERE status_product = 1 AND code_category_product = 900
                                            AND code_group_product = :group
                                            ORDER BY priority_product, name_product_'.$used_language);

            $query->bindParam('group', htmlspecialchars($group_code_product[$i], ENT_QUOTES));
            $query->execute();
            
            while($data = $query->fetch())
            {
                $id_product_group[$i][$x] = $data[0];
                $x++;
            }
            $x = 0;
        }
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }// </editor-fold>
    
    if(isset($_POST['bt_alert_update']))
    {
        // <editor-fold defaultstate="collapsed" desc="Save Block Alert Information">
        for($i = 0; $i < $count_list_alert; $i++)
        {
            $available_stock_alert = trim(htmlspecialchars($_POST['txtStock'.$i], ENT_QUOTES));
            $available_alert_alert = trim(htmlspecialchars($_POST['txtAlert'.$i], ENT_QUOTES));
            $available_delay_alert = trim(htmlspecialchars($_POST['txtDelay'.$i], ENT_QUOTES));
            
            try
            {
                $query = $connectData->prepare('UPDATE product_stock
                                                SET quantity_stock = :qty,
                                                    alert_stock = :alert
                                                WHERE id_product = :id');
                $query->execute(array(
                                      'qty' => $available_stock_alert,
                                      'alert' => $available_alert_alert,  
                                      'id' => $id_product_alert[$i]
                                      ));
                $query->closeCursor();
                
                $query = $connectData->prepare('UPDATE product_details
                                                SET delivery_details = :delay
                                                WHERE id_product = :id');
                $query->execute(array(
                                      'delay' => $available_delay_alert,  
                                      'id' => $id_product_alert[$i]
                                      ));
                $query->closeCursor();
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
        }
        // </editor-fold>
    }
    
    for($i = 0; $i < count($group_code_product); $i++)
    {
        // <editor-fold defaultstate="collapsed" desc="Save Blocks Group Information">
        if(isset($_POST['bt_alert_group_update_'.$i]))
        {
            for($x = 0; $x < count($id_product_group[$i]); $x++)
            {
                $id_product_group_alert = $id_product_group[$i][$x];
                $available_stock_group_alert = trim(htmlspecialchars($_POST['txtGroupStock'.$x], ENT_QUOTES));
                $available_alert_group_alert = trim(htmlspecialchars($_POST['txtGroupAlert'.$x], ENT_QUOTES));
                $available_delay_group_alert = trim(htmlspecialchars($_POST['txtGroupDelay'.$x], ENT_QUOTES));
                
                try
                {
                    $query = $connectData->prepare('UPDATE product_stock
                                                    SET quantity_stock = :qty,
                                                        alert_stock = :alert
                                                    WHERE id_product = :id');
                    $query->execute(array(
                                          'qty' => $available_stock_group_alert,
                                          'alert' => $available_alert_group_alert,  
                                          'id' => $id_product_group_alert
                                          ));
                    $query->closeCursor();

                    $query = $connectData->prepare('UPDATE product_details
                                                    SET delivery_details = :delay
                                                    WHERE id_product = :id');
                    $query->execute(array(
                                          'delay' => $available_delay_group_alert,  
                                          'id' => $id_product_group_alert
                                          ));
                    $query->closeCursor(); 
                }
                catch(Exception $e)
                {
                    die('<br>Error: '.$e->getMessage());
                }                
            }
            
            $i = count($group_code_product);
        }// </editor-fold>
    }

?>

    <TABLE width="100%" border="0"><form method="post">
<?php
        if($_SESSION['index'] == 'index_backoffice.php')
        {
?>
            <td id="center_title">
                Gestion des stocks
            </td>

            <tr><td colspan="2"><hr></hr></td></tr>   

<?php
        }
/*------------------- Expand or Collapse Alert -------------------------------*/
        if(isset($_GET['expandAlert']))
        {
            if(isset($_GET['expandAlert']) && $_GET['expandAlert'] == 'true')
            {
               $_SESSION['stock_alert_edit_expandAlert'] = true;
            }
            else
            {
               $_SESSION['stock_alert_edit_expandAlert'] = false;
            }
        }
        else
        {
            if($_SESSION['stock_alert_edit_expandAlert'] == 'true')
            {
               $_SESSION['stock_alert_edit_expandAlert'] = true;
            }
            else
            {
               $_SESSION['stock_alert_edit_expandAlert'] = false;
            }
        }

/*------------------- END Expand or Collapse Alert ---------------------------*/        
        
        if($_SESSION['stock_alert_edit_expandAlert'] == false)
        {
?>
            <tr><td colspan="2"><hr></hr></td></tr>
        
            <td>               
                <a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expandAlert=true">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <!-- [if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expandAlert=false"><![endif]-->
                            <image style="vertical-align: inherit;" src="graphics/icons/plus16x16.png" alt="expand" title="Afficher"/>
                            <!-- [if IE]></a><![endif]-->
                        </td>
                        <td width="100%">
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Alertes</span>
                        </td>
                    </TABLE>
                </a>
            </td>
            
            <tr><td colspan="2"><hr></hr></td></tr>
<?php
        }
        else
        {
?>
           <tr><td colspan="2"><hr></hr></td></tr> 
            
           <td>    
                <a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expandAlert=false">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <!-- [if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expandAlert=true"><![endif]-->
                            <image style="vertical-align: inherit;" src="graphics/icons/minus16x16.png" alt="collapse" title="Masquer"/>
                            <!-- [if IE]></a><![endif]-->
                        </td>
                        <td width="100%">
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Alertes</span>
                        </td>
                    </TABLE>
                </a>
            </td>

            <tr></tr>


<?php
            try
            {


                $query = $connectData->prepare('SELECT product.*, product_details.*, product_stock.*
                                                FROM product
                                                INNER JOIN (product_stock
                                                INNER JOIN product_details
                                                ON product_stock.id_product = product_details.id_product)
                                                ON product.id_product = product_stock.id_product
                                                WHERE quantity_stock <= alert_stock AND alert_stock <> 0
                                                AND status_product = 1');

                $query->execute();

                $i = 0;

                if($count_list_alert > 7)
                {
                    echo('<td align="center">
                              <input type="submit" name="bt_alert_update" value="Sauvegarder"></input>
                          </td>
                            <tr></tr>');
                }

                while($data = $query->fetch())
                {
?>
                    <td>
                        <TABLE border="0" width="100%" style="<?php echo($list_box); ?>">

                            <td style="vertical-align: top;">
                                <img src="<?php echo($data['image_thumb_product']); ?>" style="width: 100px; border: 1px solid lightgray; cursor: pointer;" alt="<?php echo($data['name_product_'.$used_language]); ?>" title="<?php echo($data['name_product_'.$used_language]); ?>" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data['id_product']); ?>&pop=true', '600', '700')"></img>
                            </td>

                            <td width="100%" style="vertical-align: top;">
                                <TABLE width="100%" border="0">

                                    <td align="left" id="center_subtitle">
                                        <a href="#" id="other_link" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data['id_product']); ?>&pop=true', '600', '700')">
                                        <?php echo($data['name_product_'.$used_language]); ?>
                                        </a>
                                    </td>

                                    <tr></tr>

                                    <td align="left" id="center_text">
<?php                               if(strlen($data['introduction_product_'.$used_language]) > 150)
                                    {
                                        echo(substr($data['introduction_product_'.$used_language], 0, 150).'[...]');  
                                    }
                                    else
                                    {
                                        echo($data['introduction_product_'.$used_language]);   
                                    }
?>
                                    </td>

                                    <tr></tr>

                                    <td style="vertical-align: bottom;">
                                        <span id="center_subtitle">Stock</span>
                                        &nbsp;
                                        <input style="width: 50px; direction: rtl;" type="text" name="txtStock<?php echo($i); ?>" value="<?php echo($data['quantity_stock']); ?>"></input>
                                        &nbsp;
                                        <span id="center_subtitle">Seuil</span>
                                        &nbsp;
                                        <input style="width: 50px; direction: rtl;" type="text" name="txtAlert<?php echo($i); ?>" value="<?php echo($data['alert_stock']); ?>"></input>
                                        &nbsp;
                                        <span id="center_subtitle">Délais de livraison</span>
                                        &nbsp;
                                        <input style="width: 50px; direction: rtl;" type="text" name="txtDelay<?php echo($i); ?>" value="<?php echo($data['delivery_details']); ?>"></input>                                       
                                    </td>

                                </TABLE>    
                            </td>

                         </TABLE>
                    </td>

                    <tr></tr>
<?php           
                    $i++;
                }
                $query->closeCursor();
            }
            catch(Exception $e)
            {
                die('<br>Error: '.$e->getMessage());
            }
?>
                    <td align="center">
                        <input type="submit" name="bt_alert_update" value="Sauvegarder"></input>
                    </td>

                    <tr><td colspan="2"><hr></hr></td></tr>
                    
              
<?php
        }
            #Order product Alert order by Group and Priority
        try
        {
            for($i = 0; $i < count($group_code_product); $i++)
            {
                if(empty($_SESSION['stock_alert_edit_first_loading'.$i]))
                {
                    $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] == 'true';
                    $_SESSION['stock_alert_edit_first_loading'.$i] = false;
                }
/*---------------- Expand or Collapse Alert Group ----------------------------*/
                if(isset($_GET['expand'.$group_code_product[$i]]))
                {
                    if(isset($_GET['expand'.$group_code_product[$i]]) && $_GET['expand'.$group_code_product[$i]] == 'true')
                    {
                       $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] = true;
                    }
                    else
                    {
                       $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] = false;
                    }
                }
                else
                {
                    if(!empty($_SESSION['stock_alert_edit_expand'.$group_code_product[$i]]) && $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] == 'true')
                    {
                       $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] = true;
                    }
                    else
                    {
                       $_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] = false;
                    }
                }

/*---------------- END Expand or Collapse Alert Group ------------------------*/ 
                
                if($_SESSION['stock_alert_edit_expand'.$group_code_product[$i]] == false)
                {

?>
                        <td>               
                            <a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expand<?php echo($group_code_product[$i]); ?>=true">
                                <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                                    <td>
                                        <!-- [if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expand<?php echo($group_code_product[$i]); ?>=false"><![endif]-->
                                        <image style="vertical-align: inherit;" src="graphics/icons/plus16x16.png" alt="expand" title="Afficher"/>
                                        <!-- [if IE]></a><![endif]-->
                                    </td>
                                    <td width="100%">
                                        <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>"><?php echo($group_name_product[$i]); ?></span>
                                    </td>
                                </TABLE>
                            </a>
                        </td>

                        <tr></tr> 
<?php  


                }
                else
                {
?>
                        <td>               
                            <a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expand<?php echo($group_code_product[$i]); ?>=false">
                                <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                                    <td>
                                        <!-- [if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index']); ?>?page=<?php echo($_SESSION['redirect']); ?>&amp;expand<?php echo($group_code_product[$i]); ?>=false"><![endif]-->
                                        <image style="vertical-align: inherit;" src="graphics/icons/minus16x16.png" alt="collapse" title="Masquer"/>
                                        <!-- [if IE]></a><![endif]-->
                                    </td>
                                    <td width="100%">
                                        <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>"><?php echo($group_name_product[$i]); ?></span>
                                    </td>
                                </TABLE>
                            </a>
                        </td>

                        <tr></tr> 
<?php
                        if($count_list_group[$i] > 7)
                        {
?>
                        <td align="center">
                            <input type="submit" name="bt_alert_group_update_<?php echo($i); ?>" value="Sauvegarder"></input>
                        </td>

                        <tr></tr>
<?php   
                        }
                        
                        $BoK_priority = true;

                        $query = $connectData->prepare('SELECT product.*, product_details.*, product_stock.*
                                                        FROM product
                                                        INNER JOIN (product_stock
                                                        INNER JOIN product_details
                                                        ON product_stock.id_product = product_details.id_product)
                                                        ON product.id_product = product_stock.id_product
                                                        WHERE status_product = 1 AND code_category_product = 900
                                                        AND code_group_product = :group
                                                        ORDER BY priority_product, name_product_'.$used_language);

                        $query->bindParam('group', htmlspecialchars($group_code_product[$i], ENT_QUOTES));
                        $query->execute();
                        
                        $j = 0;
                        while($data = $query->fetch())
                        {                           
                            if($BoK_priority == true)
                            {
                                $priority_product_base = $data['priority_product'];
                                $BoK_priority = false;
                            }
                            
                            if($priority_product_base < $data['priority_product'])
                            {
?>
                                <tr>
                                    <td><TABLE width="100%" id="<?php echo($block_frontend_approach_result); ?>">

                                        <td align="center">
                                            <span id="<?php echo($text_frontend_approach_result); ?>"><?php echo('Priorité no. '.$data['priority_product']); ?></span>
                                        </td>

                                    </TABLE></td>
                                </tr>
<?php                        
                                $BoK_priority = true;
                            }
?>
                            <td>
                            <TABLE border="0" width="100%" style="<?php echo($list_box); ?>">

                                <td style="vertical-align: top;">
                                    <img src="<?php echo($data['image_thumb_product']); ?>" style="width: 100px; border: 1px solid lightgray; cursor: pointer;" alt="<?php echo($data['name_product_'.$used_language]); ?>" title="<?php echo($data['name_product_'.$used_language]); ?>" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data['id_product']); ?>&pop=true', '600', '700')"></img>
                                </td>

                                <td width="100%" style="vertical-align: top;">
                                    <TABLE width="100%" border="0">

                                        <td align="left" id="center_subtitle">
                                            <a href="#" id="other_link" onclick="popup('index_backoffice.php?page=product_edit&nbp=<?php echo($data['id_product']); ?>&pop=true', '600', '700')">
                                            <?php echo($data['name_product_'.$used_language]); ?>
                                            </a>
                                        </td>

                                        <tr></tr>

                                        <td align="left" id="center_text">
    <?php                               if(strlen($data['introduction_product_'.$used_language]) > 150)
                                        {
                                            echo(substr($data['introduction_product_'.$used_language], 0, 150).'[...]');  
                                        }
                                        else
                                        {
                                            echo($data['introduction_product_'.$used_language]);   
                                        }
    ?>
                                        </td>

                                        <tr></tr>

                                        <td style="vertical-align: bottom;">
                                            <span id="center_subtitle">Stock</span>
                                            &nbsp;
                                            <input style="width: 50px; direction: rtl;" type="text" name="txtGroupStock<?php echo($j); ?>" value="<?php echo($data['quantity_stock']); ?>"></input>
                                            &nbsp;
                                            <span id="center_subtitle">Seuil</span>
                                            &nbsp;
                                            <input style="width: 50px; direction: rtl;" type="text" name="txtGroupAlert<?php echo($j); ?>" value="<?php echo($data['alert_stock']); ?>"></input>
                                            &nbsp;
                                            <span id="center_subtitle">Délais de livraison</span>
                                            &nbsp;
                                            <input style="width: 50px; direction: rtl;" type="text" name="txtGroupDelay<?php echo($j); ?>" value="<?php echo($data['delivery_details']); ?>"></input>                                           
                                        </td>

                                    </TABLE>    
                                </td>

                             </TABLE>
                             </td>

                            <tr></tr>
<?php 
                            $j++;
                        }
  

?>
                            <td align="center">
                                <input type="submit" name="bt_alert_group_update_<?php echo($i); ?>" value="Sauvegarder"></input>
                            </td>

                            <tr></tr>
<?php               
                }
            }
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }
        
?>

        </form></TABLE>    

<?php

    if($_SESSION['index'] == 'index_backoffice.php')
    {   
        include($backoffice_html_skeleton_part2);
    }
    else
    {
        echo('</td>');
    }

}
else
{
    header('Location: '.$header.'index.php?page=frontend_main');
}

?>
