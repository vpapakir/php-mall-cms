<?php
include('modules/search/searchmain/searchmain_getinfo.php');
?>
<form method="post">
    <table width="100%">
        <tr>
            <td align="center" id="SearchMainPaging">
                <span class="font_main"><?php echo($msg_info_searchmain_result); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 2px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 2px;"></div></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 2px;"></div></td>
        </tr>
<?php
        if($paging_resultperpage < $searchmain_count_result)
        {
?>            
            <tr>
                <td align="center"><table width="100%" cellpadding="0" cellspacing="0">
<?php
                $paging_urlscript = $url_page;
                $paging_anchor_id = '#SearchMainPaging';
                include('modules/search/paging/paging_display.php');
?>
                </table></td>
            </tr>
<?php
        }
        
        unset($searchmain_listing_title,$searchmain_listing_intro,$searchmain_listing_legend_intro,$searchmain_listing_rewritingF,
                $searchmain_listing_rewritingB,$searchmain_listing_familypage,$searchmain_listing_pathimage,
                $searchmain_listing_altimage);
        unset($searchmain_listing_product_price,$searchmain_listing_product_reference,
                $searchmain_listing_product_comdetails,$searchmain_listing_product_typeobject,
                $searchmain_listing_product_surfhab,$searchmain_listing_product_location,
                $searchmain_listing_product_locdetails,$searchmain_listing_product_offer);
        
        for($i = $ipaging, $count = $ipagingmax; $i < $ipagingmax; $i++)
        {
            try
            {
                #title
                $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                   WHERE id_page = :idpage
                                   AND family_page_translation = "title"';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_title = $data[0];
                    $searchmain_listing_title = give_prioritylangcontent($searchmain_listing_title, $searchmain_listing_result[$i], 'title');
                }
                $query->closeCursor();
                
                #intro
                $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                   WHERE id_page = :idpage
                                   AND family_page_translation = "intro"';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_intro = cut_string($data[0], 0, 120, '...');
                    $searchmain_listing_intro = cut_string(give_prioritylangcontent($searchmain_listing_intro, $searchmain_listing_result[$i], 'intro'), 0, 120, '...');
                    $searchmain_listing_legend_intro = $data[0];
                    $searchmain_listing_legend_intro = give_prioritylangcontent($searchmain_listing_legend_intro, $searchmain_listing_result[$i], 'intro');
                }
                $query->closeCursor();
                
                #rewritingF
                $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                   WHERE id_page = :idpage
                                   AND family_page_translation = "rewritingF"';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_rewritingF = $data[0];
                }
                $query->closeCursor();
                
                #rewritingB
                $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                   WHERE id_page = :idpage
                                   AND family_page_translation = "rewritingB"';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_rewritingB = $data[0];
                }
                $query->closeCursor();
                
                #pageinfo
                $prepared_query = 'SELECT family_page FROM page
                                   WHERE id_page = :idpage';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_familypage = $data[0];
                }
                $query->closeCursor();
                
                #if product
                if($searchmain_listing_familypage == 'product')
                {
                    $prepared_query = 'SELECT * FROM immo_product
                                       WHERE id_page = :idpage';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('idpage', $searchmain_listing_result[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $searchmain_listing_product_price = $data['price_product_immo'];
                        $searchmain_listing_product_reference = $data['ref_product_immo'];
                        $searchmain_listing_product_comdetails = $data['comdetails_product_immo'];
                        $searchmain_listing_product_typeobject = $data['type_product_immo'];
                        $searchmain_listing_product_surfhab = $data['surfacehab_product_immo'];
                        $searchmain_listing_product_condition = $data['condition_product_immo'];
                        $searchmain_listing_product_location = $data['location_product_immo'];
                        $searchmain_listing_product_locdetails = $data['locdetails_product_immo'];
                        $searchmain_listing_product_offer = $data['offer_product_immo'];
                    }
                    $query->closeCursor();
                    
                    $searchmain_listing_product_comdetails = giveCDRvalue($searchmain_listing_product_comdetails, 'cdreditor', $main_id_language);
                    $searchmain_listing_product_typeobject = giveCDRvalue($searchmain_listing_product_typeobject, 'cdreditor', $main_id_language);
                    $searchmain_listing_product_condition = giveCDRvalue($searchmain_listing_product_condition, 'cdreditor', $main_id_language);
                    $searchmain_listing_product_location = giveCDRvalue($searchmain_listing_product_location, 'cdreditor', $main_id_language);
                    $searchmain_listing_product_locdetails = giveCDRvalue($searchmain_listing_product_locdetails, 'cdreditor', $main_id_language);
                    $searchmain_listing_product_offer = giveCDRvalue($searchmain_listing_product_offer, 'cdreditor', $main_id_language);
                }
                
                #image
                $prepared_query = 'SELECT * FROM page_image
                                   WHERE id_page = :idpage
                                   AND position_image = 1';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $searchmain_listing_result[$i]);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $searchmain_listing_pathimage = $data['pathsearch_image'];
                    $searchmain_listing_altimage = $data['alt_image'];
                }
                else
                {
                    $searchmain_listing_pathimage = $config_noimage_search;
                    $searchmain_listing_altimage = 'noimage.gif';
                }
                $query->closeCursor();
                
                $searchmain_listing_bgcolor = 'lightgreen';
                
                for($k = 0, $countk = count($searchmain_keywords); $k < $countk; $k++)
                {   
                    $searchmain_listing_title = str_replace($searchmain_keywords[$k], '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.$searchmain_keywords[$k].'</span>', $searchmain_listing_title);
                    $searchmain_listing_title = str_replace(strtoupper($searchmain_keywords[$k]), '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.strtoupper($searchmain_keywords[$k]).'</span>', $searchmain_listing_title);
                    $searchmain_listing_title = str_replace(ucfirst($searchmain_keywords[$k]), '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.ucfirst($searchmain_keywords[$k]).'</span>', $searchmain_listing_title);
                    $searchmain_listing_intro = str_replace($searchmain_keywords[$k], '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.$searchmain_keywords[$k].'</span>', $searchmain_listing_intro);
                    $searchmain_listing_intro = str_replace(strtoupper($searchmain_keywords[$k]), '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.strtoupper($searchmain_keywords[$k]).'</span>', $searchmain_listing_intro);
                    $searchmain_listing_intro = str_replace(ucfirst($searchmain_keywords[$k]), '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.ucfirst($searchmain_keywords[$k]).'</span>', $searchmain_listing_intro);
                    $searchmain_listing_product_reference = str_replace($searchmain_keywords[$k], '<span style="background-color: '.$searchmain_listing_bgcolor.';">'.$searchmain_keywords[$k].'</span>', $searchmain_listing_product_reference);                    
                }
                
                if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                {
                    $searchmain_mainimage_width = 100;
                    $searchmain_mainimage_height = ($searchmain_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                }

?>
                <tr>                        
                    <td>
                        <a href="<?php echo($config_customheader); ?><?php change_link($searchmain_listing_rewritingF, $searchmain_listing_rewritingB) ?>" class="font_main" title="<?php echo($searchmain_listing_legend_intro); ?>">
                            <table class="block_listing2" width="100%" onmouseover="this.style.backgroundColor = 'lightgrey';" onmouseout="this.style.backgroundColor = '';" >
                            <tr>
                                <td colspan="3"><table class="block_title2" width="100%">
                                    <tr>
                                        <td align="left" style="vertical-align: top;">
                                            <div>
                                                <a href="<?php echo($config_customheader); ?><?php change_link($searchmain_listing_rewritingF, $searchmain_listing_rewritingB) ?>" class="link_subtitle">
<?php 
                                                echo($searchmain_listing_title);
                                                
?>
                                                </a>
<?php
                                                
                                                if($searchmain_listing_familypage == 'product')
                                                {
                                                    echo('<br clear="left"/>');
?>
                                                    <span class="font_main">
<?php
                                                    if(!empty($searchmain_listing_product_location) || !empty($searchmain_listing_product_locdetails))
                                                    {
                                                        if(!empty($searchmain_listing_product_location) && !empty($searchmain_listing_product_locdetails))
                                                        {
                                                            echo($searchmain_listing_product_location.', '.$searchmain_listing_product_locdetails);
                                                        }
                                                        else
                                                        {
                                                            if(!empty($searchmain_listing_product_location))
                                                            {
                                                                echo($searchmain_listing_product_location);
                                                            }

                                                            if(!empty($searchmain_listing_product_locdetails))
                                                            {
                                                                echo($searchmain_listing_product_locdetails);
                                                            }
                                                        }
                                                    }
?>
                                                    </span>
<?php
                                                }
?>                                                
                                            </div>
                                        </td>
<?php
                                        if($searchmain_listing_familypage == 'product')
                                        {
?>
                                            <td align="right" width="29%" style="vertical-align: top;">
                                                <span class="font_subtitle">
<?php 
                                                echo($searchmain_listing_product_offer.'<br clear="right"/>');
                                                if(!empty($searchmain_listing_product_price))
                                                {
                                                    echo(number_format($searchmain_listing_product_price, 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency);
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
<?php
                                        }
?>
                                    </tr>
                                </table></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <a href="<?php echo($config_customheader); ?><?php change_link($searchmain_listing_rewritingF, $searchmain_listing_rewritingB) ?>">
                                        <img style="border: 1px solid lightgrey; <?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($searchmain_mainimage_width); ?>px; height: <?php echo($searchmain_mainimage_height); ?>px;<?php } ?>" src="<?php echo($config_customheader.$searchmain_listing_pathimage); ?>" alt="<?php echo($searchmain_listing_altimage); ?>">
                                    </a>
                                </td>
                                <td align="left" style="vertical-align: top;" <?php if($searchmain_listing_familypage == 'product'){ echo('width="52%"'); }else{ echo('width="100%"'); } ?>>
                                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="left">
                                                <div>
<?php
                                                echo($searchmain_listing_intro);
?>
                                                </div>
                                            </td>
                                        </tr>
<?php
                                        if($searchmain_listing_familypage == 'product')
                                        {
?>
                                            <tr>
                                                <td align="left">
                                                    <span>Ref: <?php echo($searchmain_listing_product_reference); ?></span> <span class="font_info2"><?php echo($searchmain_listing_product_comdetails); ?></span>
                                                </td>
                                            </tr>
<?php
                                        }
?>
                                    </table>
                                </td>
<?php
                                if($searchmain_listing_familypage == 'product')
                                {
?>
                                <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="right">
                                                <?php echo($searchmain_listing_product_typeobject); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">
<?php 
                                                if(!empty($searchmain_listing_product_surfhab))
                                                {
                                                    echo($searchmain_listing_product_surfhab.'m² '); give_translation('imos_rent_main.surfacehab', $echo, $config_showtranslationcode); 
                                                }
?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">
                                                <?php echo($searchmain_listing_product_condition); ?>
                                            </td>
                                        </tr>
<?php
                                        if((checkrights($main_rights_log, '6,7,8', $redirection, $excludeSA)) === true)
                                        {
                                            if(!empty($config_module_immo) && $config_module_immo == 1)
                                            {
?>
                                                <tr>
                                                    <td align="right">
                                                        <a class="link_main" href="<?php echo($config_customheader.'edition/product/'.$searchmain_listing_result[$i]); ?>"><?php give_translation('immo.admin_goto_pagedit', $echo, $config_showtranslationcode); ?></a>
                                                    </td>
                                                </tr>
<?php
                                            }
                                        }
?>
                                    </table>
                                </td> 
<?php
                                }
?>
                            </tr>
                        </table>
                        </a>
                    </td>
                </tr>
<?php                    
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
            
            unset($searchmain_listing_title,$searchmain_listing_intro,$searchmain_listing_legend_intro,$searchmain_listing_rewritingF,
                $searchmain_listing_rewritingB,$searchmain_listing_familypage,$searchmain_listing_pathimage,
                $searchmain_listing_altimage);
            unset($searchmain_listing_product_price,$searchmain_listing_product_reference,
                    $searchmain_listing_product_comdetails,$searchmain_listing_product_typeobject,
                    $searchmain_listing_product_surfhab,$searchmain_listing_product_location,
                    $searchmain_listing_product_locdetails,$searchmain_listing_product_offer);
        }
        
        if($paging_resultperpage < $searchmain_count_result)
        {
?>            
            <tr>
                <td align="center"><table width="100%" cellpadding="0" cellspacing="0">
<?php
                $paging_urlscript = $url_page;
                $paging_anchor_id = '#SearchMainPaging';
                include('modules/search/paging/paging_display.php');
?>
                </table></td>
            </tr>
<?php
        }
?>
            
    </table>
</form>
