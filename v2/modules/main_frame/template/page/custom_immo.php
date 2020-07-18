<?php
#add portfolio
include('modules/custom/multishop/modules/myaccount/portfolio/portfolio_add.php');
?>
<tr>        
<td><table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
        <td>
        <div class="highslide-body">

            <table width="100%" cellpadding="0" cellspacing="0" border="1">
<?php
                if(!empty($title_page) || !empty($customgetinfo_reference))
                {    
?>    
                    <tr>
                        <td colspan="2" width="100%"><table class="block_title3" width="100%" border="1" style="margin-bottom: 2px;">   
                             <tr>
                                <td align="left" style="vertical-align: top;">
                                    &nbsp;<a class="link_title" style="color: white;" href="<?php echo($config_customheader.$customgetinfo_previouspage_rewritingF); ?>" title="<?php give_translation('immo.block_maintitle_previous', $echo, $config_showtranslationcode); ?>"><</a>&nbsp;
                                </td>
                                <td>                           
                                    <div>
<?php 
                                    if(!empty($title_page))
                                    {
                                        echo($title_page); 
                                    }
                                    else
                                    {
                                        echo($customgetinfo_reference); 
                                    }
?>
                                    </div>
                                </td>
                                <td align="right" style="vertical-align: top;">
                                    &nbsp;<a class="link_title" style="color: white;" href="<?php echo($config_customheader.$customgetinfo_nextpage_rewritingF); ?>" title="<?php give_translation('immo.block_maintitle_next', $echo, $config_showtranslationcode); ?>">></a>&nbsp;
                                </td>
                             </tr>
                        </table></td>
                    </tr>   
<?php   
                }
?>                    
                    
                <tr>
                <td><table class="block_main1" width="100%" border="0">  
<?php
                #portfolio message
                if(!empty($_SESSION['msg_portfolioadd']))
                {
                    $_SESSION['unset_afterrefresh_portfolioadd']++;
?>
                    <tr>
                        <td align="left">
                            <table width="100%" class="block_msg1">
                                <tr>
                                    <td align="center">
                                        <span><?php echo($_SESSION['msg_portfolioadd']); ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
<?php
                    if($_SESSION['unset_afterrefresh_portfolioadd'] == 2)
                    {
                        unset($_SESSION['msg_portfolioadd']);
                        unset($_SESSION['unset_afterrefresh_portfolioadd']);
                    }
                }

                if(!empty($intro_page))
                {    
?>    
                    <tr>
                        <td>                           
                            <h2 class="font_intro" style="margin: 0px 4px 0px 4px;"><?php echo($intro_page); ?></h2>
                        </td>
                    </tr>   
<?php   
                }
                
                if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                {
                    $custom2_mainimage_width = $widthmax_frame_image;
                    $custom2_mainimage_height = ($custom2_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                }
?>
                    <tr>
                        <td><table class="block_main5" width="100%" border="0">
                            <tr>
                                <td><table width="100%" cellpadding="0" cellspacing="0">                           
                                    <tr>
                                    <td style="vertical-align: top;" align="center">
                                        <a class="highslide" href="<?php echo($config_customheader.$path_origin_page[0]); ?>" onclick="return hs.expand(this);">
                                            <img src="<?php echo($config_customheader.$path_origin_page[0]); ?>" alt="<?php echo($alt_image_page[0]); ?>" style="border: none;<?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($custom2_mainimage_width); ?>px; height: <?php echo($custom2_mainimage_height); ?>px;<?php } ?>" <?php if(empty($config_image_ratio_x) || empty($config_image_ratio_y)){ ?>width="<?php echo($widthmax_frame_image); ?>"<?php } ?>/> 
                                        </a>
                                    </td>
                                    </tr>
<?php
                                    if(!empty($legend_image_page[0]))
                                    {
?>
                                        <tr>
                                            <td align="center">
                                                <span class="font_main" style="margin: 0px 3px 0px 3px; font-size: 10px;"><?php echo($legend_image_page[0]); ?></span>
                                            </td>
                                        </tr>
<?php
                                    }
?>
                                </table></td>
                            </tr>
                        </table></td>
                    </tr>
                    
                    <tr>
                        <td style="vertical-align: top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">    
                            <tr>
                                <td style="vertical-align: top;"><table width="100%"  cellspacing="0" cellpadding="0">                                  
<?php
                                #com details
                                if($customgetinfo_displayvalue[33] == 1)
                                {
                                    $positiondefault_comdetails_admin = null;
                                    
                                    $prepared_query = 'SELECT datecreate_product_immo 
                                                       FROM immo_product
                                                       WHERE id_page = :id';
                                    $query = $connectData->prepare($prepared_query);
                                    $query->bindParam('id', $id_page);
                                    $query->execute();
                                    
                                    if(($data = $query->fetch()) != false)
                                    {
                                        $datecreate_kprod = $data[0];
                                    }
                                    $query->closeCursor();
                                    
                                    $maxelapsedtime = $timestamp_day * $day_maxday;
                                    
                                    $datenow_kprod = time();
                                    $datecreate_kprod = converto_timestamp($datecreate_kprod);
                                    $dateelapsed_kprod = $datenow_kprod - $datecreate_kprod;
                                    
                                    $check_comdetails_admin = $customgetinfo_comdetails_admin;
                                    
                                    if($customgetinfo_comdetails_admin == 'select')
                                    {
                                        $positiondefault_comdetails_admin = ' OR position_cdreditor = 1000';
                                    }

                                    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                                                       WHERE id_cdreditor = :id'.$positiondefault_comdetails_admin;
                                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                    $query = $connectData->prepare($prepared_query);
                                    $query->bindParam('id', $customgetinfo_comdetails_admin);
                                    $query->execute();

                                    if(($data = $query->fetch()) != false)
                                    {
                                        $customgetinfo_comdetails_admin = $data[0];
                                    }
                                    $query->closeCursor();
                                    
                                    if(($check_comdetails_admin != 'select' && !empty($customgetinfo_comdetails_admin)) || ($dateelapsed_kprod < $maxelapsedtime))
                                    {
?>
                                        <tr>
                                            <td><table width="100%" cellpadding="0" cellspacing="0" style="margin: 0px 0px 4px 0px;">
                                                <tr>
                                                    <td><table width="100%" cellpadding="0" cellspacing="0" style="background-image: url('<?php echo($config_customheader.'modules/custom/multishop/graphic/product/bgoption.gif');?>'); height: 60px; background-repeat: no-repeat;">
                                                        <tr>
                                                            <td><div style="width: 20px;"></div></td>
                                                            <td class="font_info3">
                                                                <span>
                                                                    <?php 
                                                                    echo($customgetinfo_comdetails_admin); ?>
                                                                </span>
                                                            </td>
                                                            <td><div style="width: 20px;"></div></td>
                                                        </tr>
                                                    </table></td>
                                                </tr>
                                            </table></td>
                                        </tr>   
<?php
                                    }
                                }
                                
                                include('modules/custom/multishop/modules/main_frame/template_content/box/navbox.php');
                                include('modules/custom/multishop/modules/main_frame/template_content/box/info.php');
                                
                                #display district map
                                if(!empty($customgetinfo_district_situation) && $customgetinfo_district_situation > 0)
                                {
                                    try 
                                    {
                                        $prepared_query = 'SELECT * FROM cdrgeo_image
                                                           WHERE id_cdrgeo = :id';
                                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                        $query = $connectData->prepare($prepared_query);
                                        $query->bindParam('id', $customgetinfo_district_situation);
                                        $query->execute();
                                        if(($data = $query->fetch()) != false)
                                        {
                                            unset($href_district_situation);
                                            
                                            #link page related
                                            $prepared_query = 'SELECT cdrgeo.pageinfo_cdrgeo, page_translation.L'.$main_id_language.' 
                                                               FROM `cdrgeo`
                                                               INNER JOIN `page`
                                                               ON page.id_page = cdrgeo.pageinfo_cdrgeo
                                                               INNER JOIN `page_translation`
                                                               ON page_translation.id_page = page.id_page
                                                               WHERE family_page_translation = "rewritingF"
                                                               AND id_cdrgeo = :id';
                                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                            $query_district_situation = $connectData->prepare($prepared_query);
                                            $query_district_situation->bindParam('id', $customgetinfo_district_situation);
                                            $query_district_situation->execute();
                                            
                                            if(($data_district_situation = $query_district_situation->fetch()) != false)
                                            {
                                                $href_district_situation = $data_district_situation[1];
                                            }
                                            $query_district_situation->closeCursor();
                                            unset($query_district_situation);
?>
                                            <tr>
                                                <td><table class="block_main5" width="100%" style="margin: 0px 0px 4px 0px;">
                                                    <tr>
                                                        <td><table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td style="vertical-align: top;" align="center" title="<?php give_translation('main.legend_productmap', $echo, $config_showtranslationcode); ?>">
                                                                    <a href="<?php echo($config_customheader.$href_district_situation); ?>">
                                                                        <img style="border: none;" src="<?php echo($config_customheader.$data['paththumb_image']); ?>" alt="<?php echo($data['alt_image']); ?>"/>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: top;" align="left">                                                                   
                                                                    <div class="font_main" style="margin: 0px 3px 0px 3px; font-size: 10px;"><?php give_translation('main.legend_productmap', $echo, $config_showtranslationcode); ?></div>
                                                                </td>
                                                            </tr>
                                                        </table></td>
                                                    </tr>
                                                </table></td>
                                            </tr>
<?php                                             
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
                                }

                                for($i = 1, $count = count($id_image_page); $i < $count; $i++)
                                {
                                    if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                                    {
                                        $custom2_mainimage_width = 180;
                                        $custom2_mainimage_height = ($custom2_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                                    }
?>
                                    <tr>
                                        <td><table class="block_main5" width="100%" style="margin: 0px 0px 4px 0px;">
                                            <tr>
                                                <td><table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="vertical-align: top;" align="center">
                                                            <a class="highslide" href="<?php echo($config_customheader.$path_origin_page[$i]); ?>" onclick="return hs.expand(this);">
                                                                <img src="<?php echo($config_customheader.$path_thumb_page[$i]); ?>" alt="<?php echo($alt_image_page[$i]); ?>" style="border: none; <?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($custom2_mainimage_width); ?>px; height: <?php echo($custom2_mainimage_height); ?>px;<?php } ?>"/>
                                                            </a>
<?php
                                                            if(!empty($legend_image_page[$i]))
                                                            {
?>
                                                                <div class="highslide-caption">
                                                                   <span class="font_main" style="margin: 0px 3px 0px 3px;" style="font-size: 10px;"><?php echo($legend_image_page[$i]); ?></span>
                                                                </div>
<?php
                                                            }
?>
                                                        </td>
                                                    </tr>
                                                </table></td>
                                            </tr>
                                        </table></td>
                                    </tr>
<?php
                                }
?>
                        
                                    </table></td>

                                    <td><div style="width: 4px;"></div></td>

                                    <td width="100%" style="vertical-align: top;">
                                        <table style="margin: 0px 0px 0px 0px;" width="100%" cellpadding="0" cellspacing="0">
                                            
                                            
<?php
                                            include('modules/custom/multishop/modules/main_frame/template_content/product_details.php');
                                            
                                            if(!empty($desc_page))
                                            {    
?>    
                                                <tr>
                                                    <td>                           
                                                        <h3 class="font_desc" style="margin: 4px 4px 4px 4px;"><?php echo($desc_page); ?></h3>
                                                    </td>
                                                </tr>   
<?php   
                                            }
                                            else
                                            {
?>    
                                                <tr>
                                                    <td>                           
                                                        <div style="margin: 4px 4px 4px 4px;"></div>
                                                    </td>
                                                </tr>   
<?php                                                
                                            }
                                            
                                            if($customgetinfo_displayvalue[20] == 1 && $customgetinfo_dpe_energy > 0)
                                            {
?>
                                                
                                                <tr>
                                                    <td><table class="block_main2" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">

                                                        <td>
                                                            <?php
                                                               include('modules/custom/multishop/energy/dpe.php');
                                                            ?>
                                                        </td>

                                                    </table></td>
                                                </tr>
<?php   
                                            }
                                            
                                            if($customgetinfo_displayvalue[21] == 1 && $customgetinfo_ges_energy > 0)
                                            {
?>                                                
                                            
                                                <tr>
                                                    <td><table class="block_main2" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">

                                                        <td>
                                                            <?php
                                                               include('modules/custom/multishop/energy/ges.php');
                                                            ?>
                                                        </td>

                                                    </table></td>
                                                </tr>
<?php   
                                            }
?>                                            
                                
                                        </table>                   
                                    </td>
                                    </tr>
                            
                            </table></td> 
                        </tr>
                    
                    </table></td>
                </tr>

            </table>

        </div>            
        </td>
    </tr>
    
    </table>
</td>
</tr>
