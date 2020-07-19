<tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
<?php
   if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
   {
       $featuredrand_mainimage_width = '172';
       $featuredrand_mainimage_height = ($featuredrand_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
   }
   
   try
   {
       $prepared_query = 'SELECT * FROM page
                          INNER JOIN immo_product
                          ON immo_product.id_page = page.id_page
                          WHERE family_page = "product"
                          AND comdetails_product_immo <> "select"
                          AND comdetails_product_immo <> ""
                          ORDER BY RAND()
                          LIMIT 0, 6';
       if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
       $query = $connectData->prepare($prepared_query);
       $query->execute();
       $i = 0;
       while($data = $query->fetch())
       {
           unset($featuredrand_mainimage_src, $featuredrand_mainimage_alt, $featuredrand_mainimage_legend, $featuredrand_rewriting, $featuredrand_intro);
           
           $prepared_query = 'SELECT * FROM page_image
                              WHERE id_page = :idpage
                              AND position_image = 1';
           if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
           $query_featuredrand_image = $connectData->prepare($prepared_query);
           $query_featuredrand_image->bindParam('idpage', $data['id_page']);
           $query_featuredrand_image->execute();
           if(($data_featuredrand_image = $query_featuredrand_image->fetch()) != false)
           {
               $featuredrand_mainimage_src = $data_featuredrand_image['paththumb_image'];
               $featuredrand_mainimage_alt = $data_featuredrand_image['alt_image'];
               $featuredrand_mainimage_legend = $data_featuredrand_image['L'.$main_id_language];
           }
           else
           {
               $featuredrand_mainimage_src = $config_noimage_origin;
               $featuredrand_mainimage_alt = 'noimage.gif';
           }
           $query_featuredrand_image->closeCursor();
          
//           $featuredrand_mainimage_width = getimagesize($featuredrand_mainimage_src);
//           $featuredrand_mainimage_height = ($featuredrand_mainimage_width[0]/4 * 3);
           
           $prepared_query = 'SELECT * FROM page_translation
                              WHERE id_page = :idpage
                              AND family_page_translation = "rewritingF"';
           if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
           $query_featuredrand_rewriting = $connectData->prepare($prepared_query);
           $query_featuredrand_rewriting->bindParam('idpage', $data['id_page']);
           $query_featuredrand_rewriting->execute();
           if(($data_featuredrand_rewriting = $query_featuredrand_rewriting->fetch()) != false)
           {
               $featuredrand_rewriting = $data_featuredrand_rewriting['L'.$main_id_language];
           }
           $query_featuredrand_rewriting->closeCursor();
           
           $prepared_query = 'SELECT * FROM page_translation
                              WHERE id_page = :idpage
                              AND family_page_translation = "intro"';
           if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
           $query_featuredrand_intro = $connectData->prepare($prepared_query);
           $query_featuredrand_intro->bindParam('idpage', $data['id_page']);
           $query_featuredrand_intro->execute();
           if(($data_featuredrand_intro = $query_featuredrand_intro->fetch()) != false)
           {
               $featuredrand_intro = $data_featuredrand_intro['L'.$main_id_language];
           }
           $query_featuredrand_intro->closeCursor();
           
           if(!empty($data['price_product_immo']))
           {
               $featuredrand_price_product = $data['price_product_immo'] * $main_rate_currency;
               $featuredrand_price_product = number_format($featuredrand_price_product, 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency;
           }
           else
           {
               $featuredrand_price_product = give_translation('home_frontend.subtitle_featuredrand_priceonrequest', 'false', $config_showtranslationcode);
           }
           
           if($i === 0)
           {
?>
                <tr>
<?php 
           }
?>
                <td align="center" width="33%"><table class="block_listing3" width="100%" title="<?php echo($featuredrand_intro); ?>" style="margin-bottom: 4px;" cellpadding="0" cellspacing="1">
                    <tr>
                        <td class="block_title1" align="center">
                            <?php echo(giveCDRvalue($data['type_product_immo'], 'cdreditor', $main_id_language)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="block_info1" align="center">
                            <?php echo(giveCDRvalue($data['comdetails_product_immo'], 'cdreditor', $main_id_language)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <a href="<?php echo($config_customheader.$featuredrand_rewriting); ?>"><img src="<?php echo($config_customheader.$featuredrand_mainimage_src); ?>" alt="<?php echo($featuredrand_mainimage_alt); ?>" title="<?php echo($featuredrand_mainimage_legend); ?>" style="<?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($featuredrand_mainimage_width); ?>px; height: <?php echo($featuredrand_mainimage_height); ?>px; <?php } ?>border: none;"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <span class="font_subtitle"><?php echo($featuredrand_price_product); ?></span>
                        </td>
                    </tr>
                </table></td>    
<?php
           
           if($i > 1)
           {
?>
               </tr>
<?php
               $i = 0;
           }
           else
           {
?>
               
               <td><div style="width: 4px;"></div></td>
               
<?php
               $i++;  
           }  
       }
       $query->closeCursor();
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
?>
    </table></td>
</tr>
