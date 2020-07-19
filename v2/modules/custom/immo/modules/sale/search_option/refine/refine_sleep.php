<tr>
    <td align="left" colspan="2">
        <table width="100%" cellpadding="0" cellspacing="1">
            <tr>                                   
                <td align="left" width="25%" class="font_subtitle">
                    <LABEL style="cursor: pointer;" for="txtNbSleepMinSaleSearch"><?php give_translation('immo.searchproperty_refine_nrofbedrooms', $echo, $config_showtranslationcode); ?></LABEL>
                </td>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtNbSleepMinSaleSearch"><?php give_translation('immo.searchproperty_refine_minimum', $echo, $config_showtranslationcode); ?></LABEL>
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtNbSleepMinSaleSearch" type="text" name="txtNbSleepMinSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtNbSleepMinSaleSearch'])){ echo($_SESSION['SaleSearch_txtNbSleepMinSaleSearch']); }?>"/>
                            </td>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtNbSleepMaxSaleSearch"><?php give_translation('immo.searchproperty_refine_maximum', $echo, $config_showtranslationcode); ?></LABEL>
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtNbSleepMaxSaleSearch" type="text" name="txtNbSleepMaxSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtNbSleepMaxSaleSearch'])){ echo($_SESSION['SaleSearch_txtNbSleepMaxSaleSearch']); }?>"/>
                            </td>  
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
