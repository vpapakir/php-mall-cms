<tr>
    <td align="left"><table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="left" class="font_main" width="100%">
                <LABEL style="cursor: pointer;" for="cboCurrencyQuicksearch"><?php give_translation('immo.quicksearch_subtitle_pricein', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left">
                <select id="cboCurrencyQuicksearch" name="cboCurrencyQuicksearch">
<?php 
                    for($p = 0, $countp = count($main_activatedidcurrency); $p < $countp; $p++)
                    {
?>
                        <option value="<?php echo($main_activatedidcurrency[$p]); ?>"
                            <?php if(!empty($_SESSION['quicksearch_cboCurrencyQuicksearch']) && $_SESSION['quicksearch_cboCurrencyQuicksearch'] == $main_activatedidcurrency[$p]){ echo('selected="selected"'); }else{ if(empty($_SESSION['quicksearch_cboCurrencyQuicksearch']) && $main_id_currency == $main_activatedidcurrency[$p]){ echo('selected="selected"'); }else{ echo(null); } } ?>
                                ><?php echo($main_activatedcodecurrency[$p]) ?></option>    
<?php                                                
                    }
?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_main">
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtPriceMinQuicksearch"><?php give_translation('immo.quicksearch_subtitle_minimum', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left" class="font_main">
                <LABEL style="cursor: pointer; font-size: 10px;" for="txtPriceMaxQuicksearch"><?php give_translation('immo.quicksearch_subtitle_maximum', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
        </tr>
        <tr>
            <td align="left">
                <input style="width: 60px;" id="txtPriceMinQuicksearch" type="text" name="txtPriceMinQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtPriceMinQuicksearch'])){ echo($_SESSION['quicksearch_txtPriceMinQuicksearch']); } ?>"/>
            </td>
            <td align="left" class="font_main">
                <input style="width: 60px;" id="txtPriceMaxQuicksearch" type="text" name="txtPriceMaxQuicksearch" value="<?php if(!empty($_SESSION['quicksearch_txtPriceMaxQuicksearch'])){ echo($_SESSION['quicksearch_txtPriceMaxQuicksearch']); } ?>"/>
            </td>
        </tr>
<?php
        if(!empty($_SESSION['msg_quicksearch_price']))
        {
?>
            <tr>
                <td align="left" colspan="2">                        
                    <div class="font_error1"><?php echo($_SESSION['msg_quicksearch_price']); ?></div>
                </td>
            </tr>
<?php
        }
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr id="block_quicksearch_criteria" style="display: none;">
            <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
<?php
                    include('modules/custom/immo/modules/box/search/surface.php');
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php
                    include('modules/custom/immo/modules/box/search/sleep.php');
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php
                    include('modules/custom/immo/modules/box/search/typeobject.php');
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php
                    include('modules/custom/immo/modules/box/search/department.php');
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php
                    include('modules/custom/immo/modules/box/search/location.php');
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>
<?php
                    include('modules/custom/immo/modules/box/search/condition.php');
?>
                    
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>    
                    <tr>
                        <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                    </tr>
            </table></td>
        </tr>
        
        <tr>
            <td colspan="2" align="left"><table width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse('block_quicksearch_criteria', 'img_quicksearch_criteria', '', '', '', '<?php give_translation('immo.quicksearch_subtitle_more', $echo, $config_showtranslationcode); ?>', '<?php give_translation('immo.quicksearch_subtitle_less', $echo, $config_showtranslationcode); ?>');">
                <tr>
                    <td align="center">
                        <div class="link_main" style="cursor: pointer; text-align: center;">
                            <span id="img_quicksearch_criteria"><?php give_translation('immo.quicksearch_subtitle_more', $echo, $config_showtranslationcode); ?></span>
                            <span> <?php give_translation('immo.quicksearch_subtitle_criteria', $echo, $config_showtranslationcode); ?></span>
                        </div>
                    </td>
                </tr>
            </table></td>
        </tr>
    </table></td>
</tr>
