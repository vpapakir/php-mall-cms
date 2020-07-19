<tr>
    <td align="left"><form method="post"><table width="100%" cellpadding="0" cellspacing="0">
<?php
        include('modules/custom/immo/modules/box/search/offer.php');
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
<?php
        include('modules/custom/immo/modules/box/search/price.php');
?>
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                    <tr>
                        <td align="center">
                            <input type="submit" name="bt_box_quicksearch" value="<?php give_translation('main.bt_search', $echo, $config_showtranslationcode); ?>"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></form></td>   
</tr>


