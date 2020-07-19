<?php
    
    #search operation
    include('modules/custom/immo/modules/sale/search_result/usersearch/result_usersearch.php');
    
    if(empty($salesearch_countotal_result) || $salesearch_countotal_result == 0)
    {
        $salesearch_result_display = give_translation('immo.searchproperty_result_nosearch', 'false', $config_showtranslationcode);
    }
    else
    {
        if($salesearch_countotal_result == 1)
        {
            $salesearch_result_display = give_translation('immo.searchproperty_result_onesearch', 'false', $config_showtranslationcode);
            $salesearch_result_display = str_replace('[#search_result]', $salesearch_countotal_result, $salesearch_result_display);
        }
        else
        {
            if($salesearch_countotal_result > 1)
            {
                $salesearch_result_display = give_translation('immo.searchproperty_result_search', 'false', $config_showtranslationcode);
                $salesearch_result_display = str_replace('[#search_result]', $salesearch_countotal_result, $salesearch_result_display);
            }
        }
    }
?>
<tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <span class="font_subtitle"><?php echo($salesearch_result_display);  ?></span>
            </td>
        </tr>
    </table></td>
</tr>
<tr>
    <td><table class="block_collapsetitle1" id="SaleSearchPaging" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left">
                    <span style="margin-left: 4px;"><?php give_translation('imos_rent_main.subtitle_orderby', $echo, $config_showtranslationcode);  ?></span>
                </td>
                <td align="right">
                    <span style="margin-right: 4px;">
<?php
                        include('modules/custom/immo/modules/sale/search_option/option_order.php');
?>
                    </span>
                </td>
            </tr>            
    </table></td>
</tr>
<?php
if($paging_resultperpage < $salesearch_count_result)
{
?>
<tr>
    <td align="center"><table width="100%" cellpadding="0" cellspacing="0">
<?php
    $paging_urlscript = $url_page;
    $paging_anchor_id = '#SaleSearchPaging';
    include('modules/search/paging/paging_display.php');
    if($paging_selected_page > 1)
    {
        $m = 4;
    }
    else
    {
        if(empty($_SESSION['SaleSearch_first_load']))
        {
            $m = 0;  
        }
    }
?>
    </table></td>
</tr>
<?php
}
else
{
    $m = 0;
}

if(!empty($array_prepared_query[$m]))
{
    try
    {
         for($i = $m, $count = count($array_prepared_query); $i < $count; $i++)
         {
             $_SESSION['prepared_query'] = $array_prepared_query[$i];
             $query = $connectData->prepare($array_prepared_query[$i]);
             $query->execute();
             
             switch($i)
             {
                 case 0:
                     $searchlisting_priority_blockstyle = '#E3675C';
                     break;
                 case 1:
                     $searchlisting_priority_blockstyle = '#F1B2E1';
                     break;
                 case 2:
                     $searchlisting_priority_blockstyle = '#C2D985';
                     break;
                 case 3:
                     $searchlisting_priority_blockstyle = '#FFDE89';
                     break;
                 case 4:
                     $searchlisting_priority_blockstyle = '#FFFFFF';
                     break;
             }
             
             $y = 0;
            
             while($data = $query->fetch())
             {
                 $searchlisting_priority_idpage[$y] = $data['id_page'];
                 $searchlisting_priority_ref[$y] = $data['ref_product_immo'];
                 $searchlisting_priority_offer[$y] = $data['offer_product_immo'];
                 $searchlisting_priority_price[$y] = $data['price_product_immo'];
                 $searchlisting_priority_type[$y] = $data['type_product_immo'];
                 $searchlisting_priority_surfhab[$y] = $data['surfacehab_product_immo'];
                 $searchlisting_priority_condition[$y] = $data['condition_product_immo'];
                 $searchlisting_priority_comdetails[$y] = $data['comdetails_product_immo'];
                 $searchlisting_priority_location[$y] = $data['location_product_immo'];
                 $searchlisting_priority_locdetails[$y] = $data['locdetails_product_immo'];
                 
                 $y++;
             }
             $query->closeCursor();
             
             for($y = 0, $county = count($searchlisting_priority_idpage); $y < $county; $y++)
             {
                 $searchlisting_priority_offer[$y] = giveCDRvalue($searchlisting_priority_offer[$y], 'cdreditor', $main_id_language);
                 $searchlisting_priority_title = givePageTranslation($searchlisting_priority_idpage[$y], 'title', $main_id_language);
                 $searchlisting_priority_title = give_prioritylangcontent($searchlisting_priority_title, $searchlisting_priority_idpage[$y], 'title');
                 $searchlisting_priority_image = givePagePathImage($searchlisting_priority_idpage[$y], 'pathsearch_image', 'search');
                 $searchlisting_priority_price[$y] = $searchlisting_priority_price[$y] / $main_coef_currency;
                 $searchlisting_priority_intro = givePageTranslation($searchlisting_priority_idpage[$y], 'intro', $main_id_language);
                 $searchlisting_priority_intro = give_prioritylangcontent($searchlisting_priority_intro, $searchlisting_priority_idpage[$y], 'intro');
                 if($searchlisting_priority_comdetails[$y] == 'select')
                 {
                     $searchlisting_priority_comdetails[$y] = giveCDRvalue(86, 'cdreditor', $main_id_language);
                 }
                 else
                 {
                     $searchlisting_priority_comdetails[$y] = giveCDRvalue($searchlisting_priority_comdetails[$y], 'cdreditor', $main_id_language);
                 }
                 $searchlisting_priority_type[$y] = giveCDRvalue($searchlisting_priority_type[$y], 'cdreditor', $main_id_language);
                 $searchlisting_priority_condition[$y] = giveCDRvalue($searchlisting_priority_condition[$y], 'cdreditor', $main_id_language);
                 $searchlisting_priority_rewritingF = givePageTranslation($searchlisting_priority_idpage[$y], 'rewritingF', $main_id_language);
                 $searchlisting_priority_rewritingB = givePageTranslation($searchlisting_priority_idpage[$y], 'rewritingB', $main_id_language);
                 $searchlisting_priority_location[$y] = giveCDRvalue($searchlisting_priority_location[$y], 'cdreditor', $main_id_language);
                 $searchlisting_priority_locdetails[$y] = giveCDRvalue($searchlisting_priority_locdetails[$y], 'cdreditor', $main_id_language);
                 
//                 if(preg_match('#^((priority)|(new)|(select))#', $searchlisting_priority_comdetails[$y]))
//                 {
//                     if(preg_match('#^((new)|(select))#', $searchlisting_priority_comdetails[$y]))
//                     {
//                         $searchlisting_priority_comdetails[$y] = giveCDRvalue(86, 'cdreditor', $main_id_language);
//                     }
//                     else
//                     {
//                         $searchlisting_priority_comdetails[$y] = '';
//                     }        
//                 }
//                 else
//                 {
//                     $searchlisting_priority_comdetails[$y] = giveCDRvalue($searchlisting_priority_comdetails[$y], 'cdreditor', $main_id_language);
//                 }
                 
                 if(empty($searchlisting_priority_title))
                 {
                     $searchlisting_priority_title = give_translation('imos_rent_main.listing_emptytitle', 'false', $config_showtranslationcode);
                 }
                 
                 if(empty($searchlisting_priority_intro))
                 {
                     $searchlisting_priority_intro = give_translation('imos_rent_main.listing_emptyintro', 'false', $config_showtranslationcode);
                 }
                 
                 if(empty($searchlisting_priority_ref[$y]))
                 {
                     $searchlisting_priority_ref[$y] = '-';
                 }
                 
                 if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                 {
                     $searchlisting_mainimage_width = '100';
                     $searchlisting_mainimage_height = ($searchlisting_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                 }
?>
                 <tr>                        
                    <td>
                        <a href="<?php echo($config_customheader); ?><?php change_link($searchlisting_priority_rewritingF, $searchlisting_priority_rewritingB) ?>" class="font_main">
                            <table class="block_listing2" width="100%" <?php if(!empty($searchlisting_priority_blockstyle)){ echo('style="background-color: '.$searchlisting_priority_blockstyle.';"'); } ?> onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.backgroundColor = '<?php echo($searchlisting_priority_blockstyle); ?>';" >
                            <tr>
                                <td colspan="3"><table class="block_title2" width="100%">
                                    <tr>
                                        <td align="left" style="vertical-align: top;">
                                            <a href="<?php echo($config_customheader); ?><?php change_link($searchlisting_priority_rewritingF, $searchlisting_priority_rewritingB) ?>" class="link_subtitle">
<?php 
                                            echo($searchlisting_priority_title);  
?>
                                            </a>
                                            <br clear="right"/>
                                            <span class="font_main">    
<?php

                                            if(!empty($searchlisting_priority_location[$y]) || !empty($searchlisting_priority_locdetails[$y]))
                                            {
                                                if(!empty($searchlisting_priority_location[$y]) && !empty($searchlisting_priority_locdetails[$y]))
                                                {
                                                    echo($searchlisting_priority_location[$y].', '.$searchlisting_priority_locdetails[$y]);
                                                }
                                                else
                                                {
                                                    if(!empty($searchlisting_priority_location[$y]))
                                                    {
                                                        echo($searchlisting_priority_location[$y]);
                                                    }

                                                    if(!empty($searchlisting_priority_locdetails[$y]))
                                                    {
                                                        echo($searchlisting_priority_locdetails[$y]);
                                                    }
                                                }
                                            }
?>
                                            </span>

                                        </td>
                                        <td align="right" width="29%" style="vertical-align: top;">
                                            <span class="font_subtitle">
<?php 
                                            echo($searchlisting_priority_offer[$y].'<br clear="right"/>');
                                            if(!empty($searchlisting_priority_price[$y]))
                                            {
                                                echo(number_format($searchlisting_priority_price[$y], 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency);
                                                if($main_id_currency != $main_priority_currency)
                                                {
                                                    echo(' '); give_translation('imos_rent_main.listing_price_approx', $echo, $config_showtranslationcode);
                                                }
                                            }
                                            else
                                            {
                                                give_translation('imos_rent_main.listing_price_onrequest', $echo, $config_showtranslationcode);
                                            }
?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="2">
                                            
                                        </td>
                                    </tr>
                                </table></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <a href="<?php echo($config_customheader); ?><?php change_link($searchlisting_priority_rewritingF, $searchlisting_priority_rewritingB) ?>" class="font_main"><img src="<?php echo($config_customheader.$searchlisting_priority_image[0]); ?>" alt="<?php echo($searchlisting_priority_image[1]); ?>" style="<?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($searchlisting_mainimage_width); ?>px; height: <?php echo($searchlisting_mainimage_height); ?>px; <?php } ?>border: 1px solid lightgrey;"/></a>
                                </td>
                                <td style="vertical-align: top;" width="52%">
                                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="left">
                                                <span>
<?php
                                                echo(cut_string($searchlisting_priority_intro, 0, 120, '...'));
?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <span>Ref: <?php echo($searchlisting_priority_ref[$y]); ?></span> <span class="font_info2"><?php echo($searchlisting_priority_comdetails[$y]); ?></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="right">
                                                <?php echo($searchlisting_priority_type[$y]); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">
<?php 
                                                if(!empty($searchlisting_priority_surfhab[$y]))
                                                {
                                                    echo($searchlisting_priority_surfhab[$y].'m² '); give_translation('imos_rent_main.surfacehab', $echo, $config_showtranslationcode); 
                                                }
?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">
                                                <?php echo($searchlisting_priority_condition[$y]); ?>
                                            </td>
                                        </tr>
<?php
                                        if((checkrights($main_rights_log, '6,7,8', $redirection, $excludeSA)) === true)
                                        {
?>
                                            <tr>
                                                <td align="right">
                                                    <a class="link_main" href="<?php echo($config_customheader.'edition/product/'.$searchlisting_priority_idpage[$y]); ?>"><?php give_translation($config_customfolder.'.admin_goto_pagedit', $echo, $config_showtranslationcode); ?></a>
                                                </td>
                                            </tr>
<?php
                                        }
?>
                                    </table>
                                </td>              
                            </tr>
                        </table>
                        </a>
                    </td>
                </tr>   
<?php
             }
             
             unset($searchlisting_priority_idpage, $searchlisting_priority_ref, $searchlisting_priority_offer,
                   $searchlisting_priority_price, $searchlisting_priority_type, $searchlisting_priority_surfhab,
                   $searchlisting_priority_condition, $searchlisting_priority_comdetails, $array_prepared_query[$i]);
             

         }
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

if($paging_resultperpage < $salesearch_count_result)
{
?>
<tr>
    <td align="center"><table width="100%" cellpadding="0" cellspacing="0">
<?php
    include('modules/search/paging/paging_display.php');
?>
    </table></td>
</tr>
<?php
}
?>
