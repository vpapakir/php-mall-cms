<tr>
    <td align="left" colspan="2">
        <table width="100%" cellpadding="0" cellspacing="1">
            <tr>
                <td align="left" width="25%" class="font_subtitle">
                    <LABEL style="cursor: pointer;" for="cboCurrencySaleSearch"><?php give_translation('immo.searchproperty_refine_pricein', $echo, $config_showtranslationcode); ?></LABEL>
                    <select id="cboCurrencySaleSearch" name="cboCurrencySaleSearch">
<?php
                    for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
                    {
?>
                        <option value="<?php echo($main_activatedidcurrency[$i]); ?>"
                            <?php if(!empty($_SESSION['SaleSearch_cboCurrencySaleSearch']) && $_SESSION['SaleSearch_cboCurrencySaleSearch'] == $main_activatedidcurrency[$i]){ echo('selected="selected"'); }else{ if(empty($_SESSION['SaleSearch_cboCurrencySaleSearch']) && $main_id_currency == $main_activatedidcurrency[$i]){ echo('selected="selected"'); }else{ echo(null); } } ?>    
                                ><?php echo($main_activatedcodecurrency[$i]) ?></option>    
<?php
                    }            
?>
                    </select>
                </td>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtPriceMinSaleSearch"><?php give_translation('immo.searchproperty_refine_minimum', $echo, $config_showtranslationcode); ?></LABEL>
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtPriceMinSaleSearch" type="text" name="txtPriceMinSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtPriceMinSaleSearch'])){ echo($_SESSION['SaleSearch_txtPriceMinSaleSearch']); }?>"/>
                            </td>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtPriceMaxSaleSearch"><?php give_translation('immo.searchproperty_refine_maximum', $echo, $config_showtranslationcode); ?></LABEL> 
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtPriceMaxSaleSearch" type="text" name="txtPriceMaxSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtPriceMaxSaleSearch'])){ echo($_SESSION['SaleSearch_txtPriceMaxSaleSearch']); }?>"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    </table>
    </td>
</tr>

