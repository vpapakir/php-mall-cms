<?php
#getinfo
include('modules/custom/immo/modules/myaccount/portfolio/portfolio_getinfo.php');
#save
include('modules/custom/immo/modules/myaccount/portfolio/bt/bt_save_portfolio.php');
#delete
include('modules/custom/immo/modules/myaccount/portfolio/bt/bt_delete_portfolio.php');
#contact
include('modules/custom/immo/modules/myaccount/portfolio/bt/bt_request_portfolio.php');

if($url_page != 'portfolio_edit') #display expand tab
{
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseMyaccountPortfolio"
<?php
                if(empty($_SESSION['expand_myaccount_portfolio']) || $_SESSION['expand_myaccount_portfolio'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMyaccountPortfolio', 'img_expand_collapseMyaccountPortfolio', 'expand_myaccount_portfolio', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMyaccountPortfolio');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_myaccount_portfolio']) || $_SESSION['expand_myaccount_portfolio'] == 'false')
                        {
?>
                            <img id="img_expand_collapseMyaccountPortfolio" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMyaccountPortfolio" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php give_translation('myaccount.block_title_portfolio', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_myaccount_portfolio" style="display: none;" type="hidden" name="expand_myaccount_portfolio" value="<?php if(empty($_SESSION['expand_myaccount_portfolio']) || $_SESSION['expand_myaccount_portfolio'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMyaccountPortfolio"
<?php
        if(empty($_SESSION['expand_myaccount_portfolio']) || $_SESSION['expand_myaccount_portfolio'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td>
            <table width="100%" cellpadding="0" cellspacing="1">
                
<?php
}
else
{
?>
        <form method="post"><table width="100%" border="0">
<?php
}
                    try
                    {
                        #USER PORTFOLIO
                        $prepared_query = 'SELECT * FROM immo_portfolio
                                           WHERE id_user = :iduser
                                           ORDER BY priority_portfolio, dateadd_portfolio DESC';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('iduser', $main_iduser_log);
                        $query->execute();
                        
                        if(($data = $query->fetch()) != false)
                        {
                            $query->execute();
                            while($data = $query->fetch())
                            {
                                $myaccount_portfolio_dateadd = $data['dateadd_portfolio'];
                                $myaccount_portfolio_dateadd = converto_timestamp($myaccount_portfolio_dateadd);
                                $myaccount_portfolio_dateadd = date('d/m/Y', $myaccount_portfolio_dateadd);
                                $myaccount_portfolio_dateadd_sentence = give_translation('myaccount.portfolio_dateadd', 'false', $config_showtranslationcode);
                                $myaccount_portfolio_dateadd_sentence = str_replace('[#date]', $myaccount_portfolio_dateadd, $myaccount_portfolio_dateadd_sentence);
                                
                                $prepared_query = 'SELECT * FROM page
                                                   INNER JOIN immo_product
                                                   ON immo_product.id_page = page.id_page
                                                   WHERE page.id_page = :idpage
                                                   AND page.status_page = 1';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query_portfolio = $connectData->prepare($prepared_query);
                                $query_portfolio->bindParam('idpage', $data['id_page']);
                                $query_portfolio->execute();

                                if(($data_portfolio = $query_portfolio->fetch()) != false)
                                {
                                    $myaccount_portfolio_idpage = $data_portfolio['id_page'];
                                    $myaccount_portfolio_ref = $data_portfolio['ref_product_immo'];
                                    $myaccount_portfolio_offer = $data_portfolio['offer_product_immo'];
                                    $myaccount_portfolio_price = $data_portfolio['price_product_immo'];
                                    $myaccount_portfolio_type = $data_portfolio['type_product_immo'];
                                    $myaccount_portfolio_surfhab = $data_portfolio['surfacehab_product_immo'];
                                    $myaccount_portfolio_condition = $data_portfolio['condition_product_immo'];
                                    $myaccount_portfolio_comdetails = $data_portfolio['comdetails_product_immo'];
                                    $myaccount_portfolio_location = $data_portfolio['location_product_immo'];
                                    $myaccount_portfolio_locdetails = $data_portfolio['locdetails_product_immo'];

                                    $myaccount_portfolio_offer = giveCDRvalue($myaccount_portfolio_offer, 'cdreditor', $main_id_language);
                                    $myaccount_portfolio_title = givePageTranslation($myaccount_portfolio_idpage, 'title', $main_id_language);
                                    $myaccount_portfolio_image = givePagePathImage($myaccount_portfolio_idpage, 'pathsearch_image', 'search');
                                    $myaccount_portfolio_price = $myaccount_portfolio_price / $main_coef_currency;
                                    $myaccount_portfolio_intro = givePageTranslation($myaccount_portfolio_idpage, 'intro', $main_id_language);

                                    if($myaccount_portfolio_comdetails == 'select')
                                    {
                                        $myaccount_portfolio_comdetails = giveCDRvalue(86, 'cdreditor', $main_id_language);
                                    }
                                    else
                                    {
                                        $myaccount_portfolio_comdetails = giveCDRvalue($myaccount_portfolio_comdetails, 'cdreditor', $main_id_language);
                                    }
                                    $myaccount_portfolio_type = giveCDRvalue($myaccount_portfolio_type, 'cdreditor', $main_id_language);
                                    $myaccount_portfolio_condition = giveCDRvalue($myaccount_portfolio_condition, 'cdreditor', $main_id_language);
                                    $myaccount_portfolio_rewritingF = givePageTranslation($myaccount_portfolio_idpage, 'rewritingF', $main_id_language);
                                    $myaccount_portfolio_rewritingB = givePageTranslation($myaccount_portfolio_idpage, 'rewritingB', $main_id_language);
                                    $myaccount_portfolio_location = giveCDRvalue($myaccount_portfolio_location, 'cdreditor', $main_id_language);
                                    $myaccount_portfolio_locdetails = giveCDRvalue($myaccount_portfolio_locdetails, 'cdreditor', $main_id_language);

                                    $myaccount_portfolio_title = give_prioritylangcontent($myaccount_portfolio_title, $data['id_page'], 'title');
                                    $myaccount_portfolio_intro = give_prioritylangcontent($myaccount_portfolio_intro, $data['id_page'], 'intro');

                                    if(empty($myaccount_portfolio_ref))
                                    {
                                        $myaccount_portfolio_ref = '-';
                                    }
    ?>
                                    <tr>                        
                                        <td align="left">
                                            <table class="block_listing2" width="100%" style="margin-bottom: 4px;">
                                                <tr>
                                                    <td colspan="3"><table class="block_title2" width="100%">
                                                        <tr>
                                                            <td align="left">
                                                                <a href="<?php echo($config_customheader); ?><?php change_link($myaccount_portfolio_rewritingF, $myaccount_portfolio_rewritingB) ?>" class="link_subtitle">
<?php 
                                                                    echo($myaccount_portfolio_title);                                          
?>
                                                                </a>
                                                                <br clear="left"/>
                                                                <span class="font_main">
<?php
                                                                if(!empty($myaccount_portfolio_location) || !empty($myaccount_portfolio_locdetails))
                                                                {
                                                                    if(!empty($myaccount_portfolio_location) && !empty($myaccount_portfolio_locdetails))
                                                                    {
                                                                        echo($myaccount_portfolio_location.', '.$myaccount_portfolio_locdetails);
                                                                    }
                                                                    else
                                                                    {
                                                                        if(!empty($myaccount_portfolio_location))
                                                                        {
                                                                            echo($myaccount_portfolio_location);
                                                                        }

                                                                        if(!empty($myaccount_portfolio_locdetails))
                                                                        {
                                                                            echo($myaccount_portfolio_locdetails);
                                                                        }
                                                                    }
                                                                }
?>
                                                                </span>
                                                            </td>
                                                            <td align="right" width="29%" style="vertical-align: top;">
<?php                                       
                                                                echo($myaccount_portfolio_offer.'<br clear="right"/>');
                                                                if(!empty($myaccount_portfolio_price))
                                                                {
                                                                    echo(number_format($myaccount_portfolio_price, 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency);
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
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                        <a href="<?php echo($config_customheader); ?><?php change_link($myaccount_portfolio_rewritingF, $myaccount_portfolio_rewritingB) ?>" class="font_main"><img style="border: 1px solid lightgray;" src="<?php echo($config_customheader.$myaccount_portfolio_image[0]); ?>" alt="<?php echo($myaccount_portfolio_image[1]); ?>"></a>
                                                    </td>
                                                    <td style="vertical-align: top;" width="52%">
                                                        <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="left">
                                                                    <span>
                    <?php
                                                                    echo($myaccount_portfolio_intro);
                    ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                    <span>Ref: <?php echo($myaccount_portfolio_ref); ?></span> <span><?php echo($myaccount_portfolio_dateadd_sentence); ?></span> <span class="font_info2"><?php echo($myaccount_portfolio_comdetails); ?></span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                                                        <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="right">
                                                                    <?php echo($myaccount_portfolio_type); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="right">
                    <?php 
                                                                    if(!empty($myaccount_portfolio_surfhab))
                                                                    {
                                                                        echo($myaccount_portfolio_surfhab.'m² '); give_translation('imos_rent_main.surfacehab', $echo, $config_showtranslationcode);  
                                                                    }
                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="right">
                                                                    <?php echo($myaccount_portfolio_condition); ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>              
                                                </tr>
                                                <tr>
                                                    <td align="left" colspan="3">
                                                        <textarea style="width: 99%;" name="areaMyaccountPortfolioRemarks<?php echo($data['id_portfolio']); ?>" rows="5"><?php if(empty($data['remarks_portfolio'])){ give_translation('myaccount.subtitle_mycomment_portfolio', $echo, $config_showtranslationcode); }else{ echo($data['remarks_portfolio']); } ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="3">
                                                        <input type="submit" name="bt_save_portfolio" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>
                                                        <input type="submit" name="bt_request_portfolio" value="<?php give_translation('main.bt_sendemail', $echo, $config_showtranslationcode); ?>"/>
                                                        <input type="submit" name="bt_delete_portfolio<?php echo($data['id_portfolio']); ?>" value="<?php give_translation('main.bt_remove', $echo, $config_showtranslationcode); ?>"/>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>

    <?php
                                    unset($myaccount_portfolio_idpage, $myaccount_portfolio_ref, $myaccount_portfolio_offer,
                                           $myaccount_portfolio_price, $myaccount_portfolio_type, $myaccount_portfolio_surfhab,
                                           $myaccount_portfolio_condition, $myaccount_portfolio_comdetails);

                                }
                                $query_portfolio->closeCursor();
                            }
                            $query->closeCursor();
                        }
                        else
                        {
?>
                            <tr>
                                <td align="center">
                                    <span class="font_main"><?php give_translation('myaccount.subtitle_portfolio_empty', $echo, $config_showtranslationcode); ?></span>
                                </td>
                            </tr>
<?php
                        }
                        $query->closeCursor();
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

if($url_page != 'portfolio_edit') #display expand tab
{
?>
            </table></td>
        </tr>
    </table></td>
</tr>
<?php
}
else
{
?>
    </table></form>
<?php 
} 
?>

