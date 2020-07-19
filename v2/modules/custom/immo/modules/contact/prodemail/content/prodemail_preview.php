<tr>                        
    <td align="left">
        <a href="<?php echo($config_customheader.$kformprodemail_product_rewritingF); ?>" class="font_main">
            <table class="block_listing2" width="100%" <?php if(!empty($searchlisting_priority_blockstyle)){ echo('style="background-color: '.$searchlisting_priority_blockstyle.';"'); } ?> onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.backgroundColor = '<?php echo($searchlisting_priority_blockstyle); ?>';" style="margin-bottom: 4px;" title="<?php echo($kformprodemail_product_intro); ?>">
            <tr>
                <td colspan="3"><table class="block_title2" width="100%">
                    <tr>
                        <td align="left">
                            <a href="<?php echo($config_customheader.$kformprodemail_product_rewritingF); ?>" class="link_subtitle">
<?php 
                            echo($kformprodemail_product_title.'<br clear="left"/>');                                          
?>
                            </a>
                            <span class="font_main"/>
<?php
                                if(!empty($kformprodemail_product_location) || !empty($kformprodemail_product_locdetails))
                                {
                                    if(!empty($kformprodemail_product_location) && !empty($kformprodemail_product_locdetails))
                                    {
                                        echo($kformprodemail_product_location.', '.$kformprodemail_product_locdetails);
                                    }
                                    else
                                    {
                                        if(!empty($kformprodemail_product_location))
                                        {
                                            echo($kformprodemail_product_location);
                                        }

                                        if(!empty($kformprodemail_product_locdetails))
                                        {
                                            echo($kformprodemail_product_locdetails);
                                        }
                                    }
                                }
?>
                            </span>
                        </td>
                        <td align="right" width="29%" style="vertical-align: top;">
                            <span class="font_subtitle">
<?php 
                            echo($kformprodemail_product_offer.'<br clear="right"/>');
                            if(!empty($kformprodemail_product_price))
                            {
                                echo(number_format($kformprodemail_product_price, 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency);
                                if($main_id_currency != $main_priority_currency)
                                {
                                    echo(' '); give_translation('kform_visit.listing_price_approx', $echo, $config_showtranslationcode);
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
                    <a href="<?php echo($config_customheader.$kformprodemail_product_rewritingF); ?>">
                        <img style="border: 1px solid lightgray;" src="<?php echo($config_customheader.$kformprodemail_product_pathimage); ?>" alt="<?php echo($kformprodemail_product_altimage); ?>">
                    </a>
                </td>
                <td style="vertical-align: top;" width="52%">
                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left">
                                <span>
<?php
                                echo(cut_string($kformprodemail_product_intro, 0, 120, '...'));
?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span>Ref: <?php echo($kformprodemail_product_reference); ?></span> <span class="font_info2"><?php echo($kformprodemail_product_comdetails); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="right">
                                <?php echo($kformprodemail_product_type); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
<?php 
                                if(!empty($kformprodemail_product_surfhab))
                                {
                                    echo($kformprodemail_product_surfhab.'m² habitable'); 
                                }
?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <?php echo($kformprodemail_product_condition); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
<?php
                                
?>
                            </td>
                        </tr>
                    </table>
                </td>              
            </tr>
            </table>
        </a>
    </td>
</tr>
