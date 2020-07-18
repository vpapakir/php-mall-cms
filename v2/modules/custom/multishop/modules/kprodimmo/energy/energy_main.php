<?php
//include('modules/custom/immo/modules/Kprodimmo/energy/energy_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodEnergy"
<?php
                if(empty($_SESSION['expand_Kprodimmo_energy']) || $_SESSION['expand_Kprodimmo_energy'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodEnergy', 'img_expand_collapseKprodEnergy', 'expand_Kprodimmo_energy', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodEnergy');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_energy']) || $_SESSION['expand_Kprodimmo_energy'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodEnergy" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodEnergy" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_energy_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_energy" style="display: none;" type="hidden" name="expand_Kprodimmo_energy" value="<?php if(empty($_SESSION['expand_Kprodimmo_energy']) || $_SESSION['expand_Kprodimmo_energy'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodEnergy"
<?php
        if(empty($_SESSION['expand_Kprodimmo_energy']) || $_SESSION['expand_Kprodimmo_energy'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td><table width="100%">
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_dpe_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td width="35%">
                    <input style="width: 90px;" type="text" name="txtKprodimmoDPE" value="<?php if(!empty($_SESSION['Kprodimmo_energy_txtKprodimmoDPE'])){ echo($_SESSION['Kprodimmo_energy_txtKprodimmoDPE']); } ?>"/>
                    <image style="cursor: help;" src="<?php echo($config_customheader); ?>graphics/icons/help/help16x16.png" alt="help.png" title="<?php give_translation('immo.dpe_legend_kproduct', $echo, $config_showtranslationcode); ?>"></image>
                </td>
                <td align="left" width="35%"></td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_ges_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2" align="left">
                    <input style="width: 90px;" type="text" name="txtKprodimmoGES" value="<?php if(!empty($_SESSION['Kprodimmo_energy_txtKprodimmoGES'])){ echo($_SESSION['Kprodimmo_energy_txtKprodimmoGES']); } ?>"/>
                    <image style="cursor: help;" src="<?php echo($config_customheader); ?>graphics/icons/help/help16x16.png" alt="help.png" title="<?php give_translation('immo.ges_legend_kproduct', $echo, $config_showtranslationcode); ?>"></image>
                </td>
            </tr>
            <?php
            
            #energy heating
            if($kprodimmo_status_heatingenergy == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_heating_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                    cdreditor($kprodimmo_type_heatingenergy, $kprodimmo_nameS_heatingenergy, $kprodimmo_code_heatingenergy, $kprodimmo_statusobject_heatingenergy, $kprodimmo_id_heatingenergy, $_SESSION['Kprodimmo_energy_cdreditor_heating_energy'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #energy heating other
            if($kprodimmo_status_heatingotherenergy == 1)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_heatingother_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_heatingotherenergy, $kprodimmo_nameS_heatingotherenergy, $kprodimmo_code_heatingotherenergy, $kprodimmo_statusobject_heatingotherenergy, $kprodimmo_id_heatingotherenergy, $_SESSION['Kprodimmo_energy_cdreditor_heatingother_energy'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #energy isolation
            if($kprodimmo_status_isolationenergy == 1)
            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_insulation_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_isolationenergy, $kprodimmo_nameS_isolationenergy, $kprodimmo_code_isolationenergy, $kprodimmo_statusobject_isolationenergy, $kprodimmo_id_isolationenergy, $_SESSION['Kprodimmo_energy_cdreditor_isolation_energy'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #energy window
            if($kprodimmo_status_windowenergy == 1)
            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_window_energy_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_windowenergy, $kprodimmo_nameS_windowenergy, $kprodimmo_code_windowenergy, $kprodimmo_statusobject_windowenergy, $kprodimmo_id_windowenergy, $_SESSION['Kprodimmo_energy_cdreditor_window_energy'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
?>            
            
            <tr>        
                <td colspan="3" align="center" style="border-top: 1px solid lightgrey;">   
                    <table width="100%" style="margin-top: 4px;">
                        <td align="center">
<?php
                            if(empty($_SESSION['product_select_cboProductSelect']) || $_SESSION['product_select_cboProductSelect'] == 'new')
                            {
?>
                                <input type="submit" name="bt_save_product" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>
                                <input type="submit" name="bt_add_edit_product" value="<?php give_translation('main.bt_savenedit', $echo, $config_showtranslationcode); ?>"/>        
<?php
                            }
                            else
                            {
?>
                                <input type="submit" name="bt_save_product" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>
<?php
                            }
?>
                        </td>
                    </table>
                </td>
            </tr>
            
        </table></td>
    </tr>
</table></td>
</tr>
