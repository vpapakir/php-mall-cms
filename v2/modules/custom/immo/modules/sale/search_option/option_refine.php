<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td colspan="2" align="left">
            <table id="collapseRefineSearchSale" width="100%" cellpadding="0" cellspacing="0"
<?php
                if(empty($_SESSION['expand_collapseRefineSearchSale']) || $_SESSION['expand_collapseRefineSearchSale'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseRefineSearchSale', 'img_expand_collapseRefineSearchSale', 'expand_collapseRefineSearchSale', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseRefineSearchSale');" style="cursor: pointer;">
                <td align="left" style="vertical-align: top;">                    
<?php
                        if(empty($_SESSION['expand_collapseRefineSearchSale']) || $_SESSION['expand_collapseRefineSearchSale'] == 'false')
                        {
?>
                            <img id="img_expand_collapseRefineSearchSale" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseRefineSearchSale" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>   
                </td>
                <td width="100%">
                    &nbsp;<LABEL for="txtRefineSearchSale" style="cursor: pointer;"><?php give_translation('immo.searchproperty_title_refine', $echo, $config_showtranslationcode); ?></LABEL>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseRefineSearchSale" style="display: none;" type="hidden" name="expand_collapseRefineSearchSale" value="<?php if(empty($_SESSION['expand_collapseRefineSearchSale']) || $_SESSION['expand_collapseRefineSearchSale'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseRefineSearchSale"
<?php
        if(empty($_SESSION['expand_collapseRefineSearchSale']) || $_SESSION['expand_collapseRefineSearchSale'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        ><td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">                   
<?php
            if(empty($_SESSION['quicksearch_cdreditor_offer_objectQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_offer.php');
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>          
<?php
            }
            
            if(empty($_SESSION['quicksearch_txtPriceMinQuicksearch']) && empty($_SESSION['quicksearch_txtPriceMaxQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_price.php');
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>          
<?php
            }
            
            if(empty($_SESSION['quicksearch_txtSurfacehabQuicksearch']) && empty($_SESSION['quicksearch_txtSurfacegroundQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_surface.php');
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>          
<?php
            }
            
            if(empty($_SESSION['quicksearch_txtNbSleepMinQuicksearch']) && empty($_SESSION['quicksearch_txtNbSleepMaxQuicksearch']))
            {            
                include('modules/custom/immo/modules/sale/search_option/refine/refine_sleep.php');
?>

                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>          
<?php
            }
            
            if(empty($_SESSION['quicksearch_cdreditor_type_objectQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_typeobject.php');
?>            
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>    
<?php
            }

            include('modules/custom/immo/modules/sale/search_option/refine/refine_department.php');  

            if((empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch']) 
                        || empty($_SESSION['quicksearch_cdreditor_condition_objectQuicksearch'])) 
                        || (!empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0]) && $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0] != 'select'))
            {
?>
                
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
            </tr>    
<?php
            }
            
            if((!empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0]) && $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0] != 'select')
                    || (!empty($_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'][0]) && $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'][0] != 'select'))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_district.php');
                
                if((empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch']) 
                            || empty($_SESSION['quicksearch_cdreditor_condition_objectQuicksearch'])))
                {
?>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>    
                    <tr>
                        <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                    </tr>    
<?php
                }
            }
            
            if(empty($_SESSION['quicksearch_cdreditor_location_situationQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_location.php');                    
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>    
<?php
            }
            
            if(empty($_SESSION['quicksearch_cdreditor_condition_objectQuicksearch']))
            {
                include('modules/custom/immo/modules/sale/search_option/refine/refine_condition.php');                 
            }
?>
            <tr>
                <td><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                    <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                        <tr>
                            <td align="center">
                                <input type="submit" name="bt_productsearch" value="<?php give_translation('main.bt_search', $echo, $config_showtranslationcode); ?>"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        </table></td>
    </tr>
</table></td>
</tr>
