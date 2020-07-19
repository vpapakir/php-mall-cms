<?php
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
            $myaccount_portfolio_title = give_prioritylangcontent($myaccount_portfolio_title, $data['id_page'], 'title');
            $myaccount_portfolio_image = givePagePathImage($myaccount_portfolio_idpage, 'pathsearch_image', 'search');
            $myaccount_portfolio_price = $myaccount_portfolio_price / $main_coef_currency;
            $myaccount_portfolio_intro = givePageTranslation($myaccount_portfolio_idpage, 'intro', $main_id_language);
            $myaccount_portfolio_intro = give_prioritylangcontent($myaccount_portfolio_intro, $data['id_page'], 'intro');

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

            
            if(empty($myaccount_portfolio_title))
            {
                $myaccount_portfolio_title = give_translation('imos_rent_main.listing_emptytitle', 'false', $config_showtranslationcode);
            }

            if(empty($myaccount_portfolio_intro))
            {
                $myaccount_portfolio_intro = give_translation('imos_rent_main.listing_emptyintro', 'false', $config_showtranslationcode);
            }

            if(empty($myaccount_portfolio_ref))
            {
                $myaccount_portfolio_ref = '-';
            }
?>
            <tr>  
                <td>
                    <input id="chk_requestpf<?php echo($data['id_portfolio']); ?>" type="checkbox" name="chk_requestpf<?php echo($data['id_portfolio']); ?>" value="1"/>
                </td>
                <td>
                    <LABEL for="chk_requestpf<?php echo($data['id_portfolio']); ?>" style="cursor: pointer;"><table class="block_listing2" width="100%" style="margin-bottom: 4px;">
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
                                        <span class="font_subtitle">
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
                                        </span>
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
                    </table></LABEL>
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

