<?php
if($_SESSION['autorisation'] === true)
{
    $i = 0;
    $array_id_order[] = null;
    $array_id_user[] = null;
    try
    {
        $prepared_query = 'SELECT DISTINCT id_order, id_user FROM cart
                           ORDER BY date_cart DESC';
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        
        while($data = $query->fetch())
        {
            $array_id_order[$i] = $data[0];
            $array_id_user[$i] = $data[1];
            $i++;
        }
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
//    echo(var_dump($array_id_order));
//    echo('<br></br>');
//    echo(var_dump($array_id_user));
?>
    <td><TABLE width="100%">
        
            <td><TABLE width="100%">
                <td align="center">
                    <span id="center_subtitle">Historique panier des dernières <?php echo($elapsed_time_cart_hour); ?> heures</span>
                </td>
            </TABLE></td>
            
            <tr style="height: 6px;"></tr>  
<?php
$Bok_first_cart = true;
$BoK_style_order_history_cart = true;
if($array_id_order[0] != null)
{
    for($i = 0; $i < count($array_id_order); $i++)
    {
?>
        <td><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;">    
<?php            
        
        try
        {
            if($array_id_user[$i] < 9000000)
            {
                $prepared_query = 'SELECT * FROM cart
                                   INNER JOIN product
                                   ON cart.id_product = product.id_product
                                   INNER JOIN product_details
                                   ON product.id_product = product_details.id_product
                                   INNER JOIN user_real
                                   ON cart.id_user = user_real.id_user
                                   WHERE id_order = :order
                                   AND user_real.id_user = :user';
            }
            else
            {
                $prepared_query = 'SELECT * FROM cart
                                   INNER JOIN product
                                   ON cart.id_product = product.id_product
                                   INNER JOIN product_details
                                   ON product.id_product = product_details.id_product
                                   WHERE id_order = :order
                                   AND id_user = :user';
            }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'order' => $array_id_order[$i],
                                  'user' => $array_id_user[$i],
                                  ));
            
            while($data = $query->fetch())
            {
                if($Bok_first_cart === true)
                {
                    $date = converto_timestamp($data['date_cart']);

                    $total_hour_before_delete = $elapsed_time_cart_hour * 3600;
                    $futur_date_deleted = $total_hour_before_delete + $date;

                    $hour_rest_before_delete = $futur_date_deleted - time();

                    $hour_rest_before_delete = ($hour_rest_before_delete / 3600); 
                    $hour_rest_before_delete = number_format($hour_rest_before_delete, 0);

                    if($hour_rest_before_delete <= 1 ? $hour_sentence = 'heure' : $hour_sentence = 'heures')
                
?>
                    <td colspan="5"><TABLE width="100%" id="<?php echo($block_frontend_approach_result); ?>" cellpadding="0" cellspacing="0" style="cursor: help;" title="<?php echo('il reste environ '.$hour_rest_before_delete.' '.$hour_sentence.' avant la suppression automatique du panier'); ?>">
                            <td>
                                <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">
                                    <?php
                                    if($array_id_user[$i] < 9000000)
                                    {
                                        echo(upper_firstchar($data['title_real']).' '.upper_firstchar($data['first_name_real']).' '.upper_firstchar($data['name_real']).' le '.date('d/m/Y à H:i',$date).' '.'('.$hour_rest_before_delete.' '.$hour_sentence.' restantes)');
                                    }
                                    else
                                    {
                                        echo('Visiteur le '.date('d/m/Y à H:i',$date).' '.'('.$hour_rest_before_delete.' '.$hour_sentence.' restantes)');
                                    }
                                    ?> 
                                </span>
                            </td>
                    </TABLE></td> 
                    
                    <tr></tr>
                    
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>" style="cursor: help;" title="Nombre de produits mis dans le panier"><span id="<?php echo($text_general_subtitle); ?>">Qté</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>" style="cursor: help;" title="Numéro du produit"><span id="<?php echo($text_general_subtitle); ?>">No.&nbsp;produit</span></div></td>
                    <td width="50%" id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>" style="cursor: help;" title="Nom du produit tel qu'il apparaît dans le panier"><span id="<?php echo($text_general_subtitle); ?>">Libellé</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>" style="cursor: help;" title="Tarif Hors Taxes pour un revendeur sans bonus"><span id="<?php echo($text_general_subtitle); ?>">Tarif&nbsp;Revendeur</span></div></td>            
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>" style="cursor: help;" title="Tarif T.T.C. pour un particulier"><span id="<?php echo($text_general_subtitle); ?>">Tarif&nbsp;Public</span></div></td>
<?php  
                    $Bok_first_cart = false;
                }
                
                if($Bok_first_cart === false)
                {
                    if($BoK_style_order_history_cart == false)
                    {
                        $style_order_history_cart = 'style="background-color: white;"';
                        $BoK_style_order_history_cart = true;
                    }
                    else
                    {
                        $style_order_history_cart = 'style="background-color: #EEEEEE;"';
                        $BoK_style_order_history_cart = false;
                    }
?>
                    
                    
                    <tr></tr>
                    
                    <td <?php echo($style_order_history_cart); ?> align="right">
                        <span style="margin-right: 6px;" id="center_text"><?php echo($data['qty_product_cart']); ?></span>
                    </td>
                    <td <?php echo($style_order_history_cart); ?> align="right">
                        <a style="margin-right: 6px;" id="other_link" href="index.php?page=<?php echo($data['number_product']) ?>"><?php echo($data['number_product']); ?></a>
                    </td>
                    <td <?php echo($style_order_history_cart); ?> align="left" title="<?php echo($data['name_product_L1']) ?>">
                        <span id="center_text"><?php echo(cut_string($data['name_product_L1'], 0, 45, '...')); ?></span>
                    </td>
                    <td <?php echo($style_order_history_cart); ?> align="right">
                        <span style="margin-right: 6px;" id="center_text"><?php echo(number_format($data['price_resale_details'], 2, '.', '').'&nbsp;€'); ?></span>
                    </td>
                    <td <?php echo($style_order_history_cart); ?> align="right">
                        <span style="margin-right: 6px;" id="center_text"><?php echo(number_format($data['price_public_details'], 2, '.', '').'&nbsp;€'); ?></span>
                    </td>
<?php                    
                }
            }
            $query->closeCursor();
        }
        catch(Exception $e)
        {
            die('<br>Error: '.$e->getMessage());
        }

?>
        </TABLE></td>
<?php                
        if($i < (count($array_id_order) - 1))
        {
?>
            
            
            <tr style="height: 6px;"></tr>  
<?php            
        }
        
        $Bok_first_cart = true;
        $BoK_style_order_history_cart = true;
    }
}
else
{
?>
     <tr style="height: 6px;"></tr> 
     
     <td><TABLE width="100%">
          <td align="center">
              <span id="center_text">Aucun panier ne figure actuellement dans la base de données</span>
          </td>
     </TABLE></td>
            
             
<?php            
}
?>
        
            <tr style="height: 6px;"></tr>   
            
            <td align="center"> 
                <a style="text-decoration: none;" href="index.php?page=history_order"><span id="link_block_IE">Retour</span></a>                
            </td>
            
    </TABLE></td>
<?php
}
else
{
    header('Location: '.$header.'index.php?page=frontend_main');
}
?>
