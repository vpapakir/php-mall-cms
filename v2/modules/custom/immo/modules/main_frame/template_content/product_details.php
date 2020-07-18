<?php
try
{
    $custom_1column_width = '40%';
    
    include('modules/custom/immo/modules/main_frame/template_content/content/price.php');
?>
    <tr>
        <td align="left"><table class="block_expandmain1" width="100%" border="0">
        <tr>
        <td align="left">
            <table id="collapseCustom1Proddetails"
<?php
                if(empty($_SESSION['expand_collapseCustom1Proddetails']) || $_SESSION['expand_collapseCustom1Proddetails'] == 'true')
                {
                    echo('class="block_expandtitle1"');
                }
                else
                {
                    echo('class="block_collapsetitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseCustom1Proddetails', 'img_expand_collapseCustom1Proddetails', 'expand_collapseCustom1Proddetails', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseCustom1Proddetails');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseCustom1Proddetails']) || $_SESSION['expand_collapseCustom1Proddetails'] == 'true')
                        {
?>
                            <img id="img_expand_collapseCustom1Proddetails" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>                            
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseCustom1Proddetails" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        Informations détaillées
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseCustom1Proddetails" style="display: none;" type="hidden" name="expand_collapseCustom1Proddetails" value="<?php if(empty($_SESSION['expand_collapseCustom1Proddetails']) || $_SESSION['expand_collapseCustom1Proddetails'] == 'true'){ echo('true'); }else{ echo('false'); } ?>" />
        </td>
        </tr>
        <tr id="block_expand_collapseCustom1Proddetails"
<?php
        if(empty($_SESSION['expand_collapseCustom1Proddetails']) || $_SESSION['expand_collapseCustom1Proddetails'] == 'true')
        {
            echo(null);
        }
        else
        {
            echo('style="display: none;"');
        }
?>
        > 
    <td><table width="100%" style="margin: 0px 0px 4px 0px;">
        <tr>    
        <td><table width="100%" cellspacing="1" cellpadding="0" style="margin: 0px 0px 4px 0px;">
<?php
            include('modules/custom/immo/modules/main_frame/template_content/content/offer.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/reference.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/city.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/district.php');
//            include('modules/custom/immo/modules/main_frame/template_content/content/department.php');
//            include('modules/custom/immo/modules/main_frame/template_content/content/region.php');
//            include('modules/custom/immo/modules/main_frame/template_content/content/country.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/location.php'); 
            include('modules/custom/immo/modules/main_frame/template_content/content/condition.php'); 
?>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
<?php
            include('modules/custom/immo/modules/main_frame/template_content/content/type.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/surfacehab.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/surfaceground.php');
            //include('modules/custom/immo/modules/main_frame/template_content/content/floor.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/furnished.php');
?>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
<?php
            include('modules/custom/immo/modules/main_frame/template_content/content/repartition.php');
//            include('modules/custom/immo/modules/main_frame/template_content/content/sleeps.php');
//            include('modules/custom/immo/modules/main_frame/template_content/content/bathrooms.php');  
//            include('modules/custom/immo/modules/main_frame/template_content/content/toilets.php'); 

            include('modules/custom/immo/modules/main_frame/template_content/content/rooms.php');

            include('modules/custom/immo/modules/main_frame/template_content/content/outhouses.php');

            include('modules/custom/immo/modules/main_frame/template_content/content/outhousesother.php');
            
            if((($count_totalouthouses > 0 || $customgetinfo_numouthouses > 0) && $customgetinfo_displayvalue[18] == 1) 
                    || (!empty($customgetinfo_other_exterior) && $customgetinfo_displayvalue[49] == 1)
                    || ($customgetinfo_numsleeps > 0 && $customgetinfo_displayvalue[16] == 1)
                    || ($customgetinfo_numbath > 0 && $customgetinfo_displayvalue[17] == 1)
                    || ($customgetinfo_numwc > 0 && $customgetinfo_displayvalue[18] == 1))
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
            
            include('modules/custom/immo/modules/main_frame/template_content/content/heating.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/heatingother.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/insulation.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/windows.php');
            
            if((!empty($customgetinfo_heating_energy) && $customgetinfo_displayvalue[22] == 1) 
                    || (!empty($customgetinfo_heatingother_energy) && $customgetinfo_displayvalue[23] == 1)
                    || ($customgetinfo_isolation_energy != 'select' && $customgetinfo_displayvalue[24] == 1) 
                    || ($customgetinfo_window_energy != 'select' && $customgetinfo_displayvalue[25] == 1))
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
            
            include('modules/custom/immo/modules/main_frame/template_content/content/water.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/power.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/phone.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/tv.php');
            include('modules/custom/immo/modules/main_frame/template_content/content/internet.php');   
            include('modules/custom/immo/modules/main_frame/template_content/content/facilities.php');

?>
        </table></td>
        </tr>
    </table></td>
    </tr>
        </table></td>
    </tr>
<?php
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
?>
