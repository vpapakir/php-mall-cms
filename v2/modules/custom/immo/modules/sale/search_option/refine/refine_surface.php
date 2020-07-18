<tr>
    <td align="left" colspan="2">
        <table width="100%" cellpadding="0" cellspacing="1">
            <tr>                                   
                <td align="left" width="25%" class="font_subtitle">
                    <LABEL style="cursor: pointer;" for="txtSurfacehabSaleSearch"><?php give_translation('immo.searchproperty_refine_surface', $echo, $config_showtranslationcode); ?></LABEL>
                </td>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtSurfacehabSaleSearch"><?php give_translation('immo.searchproperty_refine_surfacelivingspace', $echo, $config_showtranslationcode); ?></LABEL>
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtSurfacehabSaleSearch" type="text" name="txtSurfacehabSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtSurfacehabSaleSearch'])){ echo($_SESSION['SaleSearch_txtSurfacehabSaleSearch']); }?>"/>
                            </td>
                            <td align="left" width="25%">
                                <LABEL style="cursor: pointer;" for="txtSurfacegroundSaleSearch"><?php give_translation('immo.searchproperty_refine_surfaceground', $echo, $config_showtranslationcode); ?></LABEL>
                            </td>
                            <td align="left" width="25%">
                                <input style="width: 80px;" id="txtSurfacegroundSaleSearch" type="text" name="txtSurfacegroundSaleSearch" value="<?php if(!empty($_SESSION['SaleSearch_txtSurfacegroundSaleSearch'])){ echo($_SESSION['SaleSearch_txtSurfacegroundSaleSearch']); }?>"/>
                            </td>  
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
