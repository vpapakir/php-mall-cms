<?php
//include('modules/custom/immo/modules/Kprodimmo/exterior/exterior_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodExterior"
<?php
                if(empty($_SESSION['expand_Kprodimmo_exterior']) || $_SESSION['expand_Kprodimmo_exterior'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodExterior', 'img_expand_collapseKprodExterior', 'expand_Kprodimmo_exterior', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodExterior');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_exterior']) || $_SESSION['expand_Kprodimmo_exterior'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodExterior" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodExterior" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_exterior_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_exterior" style="display: none;" type="hidden" name="expand_Kprodimmo_exterior" value="<?php if(empty($_SESSION['expand_Kprodimmo_exterior']) || $_SESSION['expand_Kprodimmo_exterior'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodExterior"
<?php
        if(empty($_SESSION['expand_Kprodimmo_exterior']) || $_SESSION['expand_Kprodimmo_exterior'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td><table width="100%" cellpadding="0" cellspacing="1" border="0">
  
<?php
            if(empty($_SESSION['Kprodimmo_general_txtKprodimmoNumOutHousesGeneral']))
            {
?>
                <tr>
                    <td align="left" colspan="2"><table width="100%" cellpadding="0" cellspacing="1" id="ajax_incelement_KprodimmoExterior">
                            
                    </table></td>
                </tr>
<?php
            }
            else
            {
                $piecesout_exterior = split_string($_SESSION['Kprodimmo_exterior_cdreditor_piecesout_exterior'], '#');
                
                for($i = 0, $count = count($piecesout_exterior); $i < $count; $i++)
                {
                    $piecesout_exterior[$i] = split_string($piecesout_exterior[$i], '$');
                }
?>
                <tr>
                    <td align="left" colspan="2"><table width="100%" cellpadding="0" cellspacing="1" id="ajax_incelement_KprodimmoExterior">   
<?php                
                for($i = 1, $y = 0; $i <= $_SESSION['Kprodimmo_general_txtKprodimmoNumOutHousesGeneral']; $i++, $y++)
                {
                    #exterior pieces
                    if($kprodimmo_status_piecesoutexterior == 1 || $kprodimmo_status_piecesoutdetailsexterior == 1)
                    {
                        $kprodimmo_piecesoutexterior_bok_details_hide = true;
                        $kprodimmo_piecesoutexterior_details = split_string($piecesout_exterior[$y][5], '@');
                        $kprodimmo_piecesoutexterior_details_content = null;
                        for($x = 0, $countx = count($main_activatedidlang); $x < $countx; $x++)
                        {
                            $kprodimmo_piecesoutexterior_details_content[$x] = split_string($kprodimmo_piecesoutexterior_details[$x], '&');
                            if(!empty($kprodimmo_piecesoutexterior_details_content[$x][0]))
                            {
                                $kprodimmo_piecesoutexterior_bok_details_hide = 'false';
                            }
                        }
?>                      
                        <tr>
                            <td align="left" style="width: 25px;">
                                <span class="font_subtitle"><?php echo($i); ?>&nbsp;</span>
                            </td>
                            <td align="left" style="width: 50px;">
                                <span class="font_main">B:</span>
                                <input style="width: 20px;" type="text" name="txtKprodimmoBuildingOut<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesout_exterior[$y][0]) || $piecesout_exterior[$y][0] === '0'){ echo($piecesout_exterior[$y][0]); } ?>"/>
                            </td>
                            <td align="left" style="width: 50px;">
                                <span class="font_main">E:</span>
                                <input style="width: 20px;" type="text" name="txtKprodimmoFloorOut<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesout_exterior[$y][1]) || $piecesout_exterior[$y][1] === '0'){ echo($piecesout_exterior[$y][1]); } ?>"/>
                            </td>
                            <td align="left" style="width: 110px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left">
<?php            
                                        if($kprodimmo_status_piecesoutexterior == 1)
                                        {
                                            cdreditor($kprodimmo_type_piecesoutexterior, $kprodimmo_nameS_piecesoutexterior, $kprodimmo_code_piecesoutexterior.$i, $kprodimmo_statusobject_piecesoutexterior, $kprodimmo_id_piecesoutexterior, $piecesout_exterior[$y][2], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 8, '...');   
                                        }
?>                                            
                                        </td>
                                        <td align="center">
                                            <img id="piecesoutexterior<?php echo($i); ?>" style="cursor: pointer;" src="<?php echo($config_customheader.'graphics/icons/use/edit2.gif'); ?>" alt="edit.gif" title="<?php //give_translation('immo.kprod_interior_edit', $echo, $config_showtranslationcode); ?>" onclick="hideshow('piecesoutexterior_details<?php echo($i); ?>', 'piecesoutexterior<?php echo($i); ?>', '', '')"/>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td align="left" style="width: 60px;">
                                <input style="width: 30px;" type="text" name="txtKprodimmoSurfaceOut<?php echo($i); ?>" value="<?php if(!empty($piecesout_exterior[$y][3])){ echo($piecesout_exterior[$y][3]); } ?>"/>
                                <span class="font_main">m²</span>
                                &nbsp;
                            </td>
                            <td align="left" style="width: 110px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left">
<?php            
                                        if($kprodimmo_status_piecesoutdetailsexterior == 1)
                                        {
                                            cdreditor($kprodimmo_type_piecesoutdetailsexterior, $kprodimmo_nameS_piecesoutdetailsexterior, $kprodimmo_code_piecesoutdetailsexterior.$i, $kprodimmo_statusobject_piecesoutdetailsexterior, $kprodimmo_id_piecesoutdetailsexterior, $piecesout_exterior[$y][4], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 8, '...'); 
                                        }
?>                                            
                                        </td>
                                    </tr>
                                </table>
                            </td>                 
                        </tr>
                        <tr id="piecesoutexterior_details<?php echo($i); ?>" style="<?php if(empty($kprodimmo_piecesoutexterior_bok_details_hide) || $kprodimmo_piecesoutexterior_bok_details_hide === true){ echo('display: none;'); } ?>">
                            <td colspan="6">
                                <table width="100%" cellpadding="0" cellspacing="1">
<?php
                            for($x = 0, $countx = count($main_activatedidlang); $x < $countx; $x++)
                            {                               
?>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle">
                                            <?php give_translation($main_activatedcodelang[$x], $echo, $config_showtranslationcode); ?>
                                        </span>
                                    </td> 
                                    <td align="left" width="70%">
                                        <input type="text" name="txtKprodimmoDetailsOut<?php echo($i.'-'.$main_activatedidlang[$x]); ?>" style="width: 99%;" value="<?php if($kprodimmo_piecesoutexterior_details_content[$x][1] == $main_activatedidlang[$x]){ echo($kprodimmo_piecesoutexterior_details_content[$x][0]); } ?>"/>
                                    </td>
                                </tr>
<?php                              
                            }
?>
                                </table>
                            </td>
                        </tr>
<?php
                        unset($kprodimmo_piecesoutexterior_details_content);
                    }
                }
?>
                    </table></td>
                </tr>
<?php                        
            }
                
            #exterior others
            if($kprodimmo_status_othersexterior == 1)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_other_exterior_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="80%">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_othersexterior, $kprodimmo_nameS_othersexterior, $kprodimmo_code_othersexterior, $kprodimmo_statusobject_othersexterior, $kprodimmo_id_othersexterior, $_SESSION['Kprodimmo_exterior_cdreditor_others_exterior'], false);                                      
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
                <td colspan="2" align="center" style="border-top: 1px solid lightgrey;">   
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
