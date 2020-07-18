<?php
for($i = 0, $count = count($kformvisit_selectedid_property); $i < $count; $i++)
{
?>
<tr>                        
    <td align="left">
        <a href="<?php echo($config_customheader.$kformvisit_product_rewritingF[$i]); ?>" class="font_main">
            <table class="block_listing2" width="100%" <?php if(!empty($searchlisting_priority_blockstyle)){ echo('style="background-color: '.$searchlisting_priority_blockstyle.';"'); } ?> onmouseover="this.style.backgroundColor = '';" onmouseout="this.style.backgroundColor = '<?php echo($searchlisting_priority_blockstyle); ?>';" style="margin-bottom: 4px;">
            <tr>
                <td colspan="3"><table class="block_title2" width="100%">
                    <tr>
                        <td align="left">
                            <a href="<?php echo($config_customheader.$kformvisit_product_rewritingF[$i]); ?>" class="link_subtitle">
<?php 
                                echo($kformvisit_product_title[$i]);                                          
?>
                            </a>
                            <br clear="left"/>
                            <span class="font_main">
<?php
                                if(!empty($kformvisit_product_location[$i]) || !empty($kformvisit_product_locdetails[$i]))
                                {
                                    if(!empty($kformvisit_product_location[$i]) && !empty($kformvisit_product_locdetails[$i]))
                                    {
                                        echo($kformvisit_product_location[$i].', '.$kformvisit_product_locdetails[$i]);
                                    }
                                    else
                                    {
                                        if(!empty($kformvisit_product_location[$i]))
                                        {
                                            echo($kformvisit_product_location[$i]);
                                        }

                                        if(!empty($kformvisit_product_locdetails[$i]))
                                        {
                                            echo($kformvisit_product_locdetails[$i]);
                                        }
                                    }
                                }
?>
                            </span>
                        </td>
                        <td align="right" width="29%" style="vertical-align: top;">
                            <span class="font_subtitle">
<?php 
                            echo($kformvisit_product_offer[$i]);
                            echo('<br clear="left"/>');
                            if(!empty($kformvisit_product_price[$i]))
                            {
                                echo(number_format($kformvisit_product_price[$i], 0, '.', '.').'&nbsp;'.$main_selectedsymbol_currency);
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
                    <img style="border: 1px solid lightgray;" src="<?php echo($config_customheader.$kformvisit_product_pathimage[$i]); ?>" alt="<?php echo($kformvisit_product_altimage[$i]); ?>">
                </td>
                <td style="vertical-align: top;" width="52%">
                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left">
                                <span>
<?php
                                echo($kformvisit_product_intro[$i]);
?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span>Ref: <?php echo($kformvisit_product_reference[$i]); ?></span> <span class="font_info2"><?php echo($kformvisit_product_comdetails[$i]); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                    <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="right">
                                <?php echo($kformvisit_product_type[$i]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
<?php 
                                if(!empty($kformvisit_product_surfhab[$i]))
                                {
                                    echo($kformvisit_product_surfhab[$i].'m² habitable'); 
                                }
?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <?php echo($kformvisit_product_condition[$i]); ?>
                            </td>
                        </tr>
                    </table>
                </td>              
            </tr>
            </table>
        </a>
    </td>
</tr>  
<?php
}
?>
