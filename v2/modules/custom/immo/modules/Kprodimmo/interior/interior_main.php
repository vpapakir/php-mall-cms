<?php
//include('modules/custom/immo/modules/Kprodimmo/interior/interior_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodInterior"
<?php
                if(empty($_SESSION['expand_Kprodimmo_interior']) || $_SESSION['expand_Kprodimmo_interior'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodInterior', 'img_expand_collapseKprodInterior', 'expand_Kprodimmo_interior', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodInterior');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_interior']) || $_SESSION['expand_Kprodimmo_interior'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodInterior" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodInterior" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_interior_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_interior" style="display: none;" type="hidden" name="expand_Kprodimmo_interior" value="<?php if(empty($_SESSION['expand_Kprodimmo_interior']) || $_SESSION['expand_Kprodimmo_interior'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodInterior"
<?php
        if(empty($_SESSION['expand_Kprodimmo_interior']) || $_SESSION['expand_Kprodimmo_interior'] == 'false')
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
            if(empty($_SESSION['Kprodimmo_general_txtKprodimmoNumRoomsGeneral']))
            {
?>
                <tr>
                    <td align="left" colspan="6"><table width="100%" cellpadding="0" cellspacing="1" id="ajax_incelement_KprodimmoInterior">
                            
                    </table></td>
                </tr>
<?php
            }
            else
            {
                $piecesin_interior = split_string($_SESSION['Kprodimmo_interior_cdreditor_piecesin_interior'], '#');
                
                for($i = 0, $count = count($piecesin_interior); $i < $count; $i++)
                {
                    $piecesin_interior[$i] = split_string($piecesin_interior[$i], '$');
                }
?>
                <tr>
                    <td align="left" colspan="6"><table width="100%" cellpadding="0" cellspacing="1" id="ajax_incelement_KprodimmoInterior">
<?php           
                for($i = 1, $y = 0; $i <= $_SESSION['Kprodimmo_general_txtKprodimmoNumRoomsGeneral']; $i++, $y++)
                {
                    #interior pieces in
                    if($kprodimmo_status_piecesininterior == 1 || $kprodimmo_status_piecesindetailsinterior == 1)
                    {
                        $kprodimmo_piecesininterior_bok_details_hide = true;
                        $kprodimmo_piecesininterior_details = split_string($piecesin_interior[$y][5], '@');
                        $kprodimmo_piecesininterior_details_content = null;
                        for($x = 0, $countx = count($main_activatedidlang); $x < $countx; $x++)
                        {
                            $kprodimmo_piecesininterior_details_content[$x] = split_string($kprodimmo_piecesininterior_details[$x], '&');
                            if(!empty($kprodimmo_piecesininterior_details_content[$x][0]))
                            {
                                $kprodimmo_piecesininterior_bok_details_hide = 'false';
                            }
                        }
?>                        
                        <tr>
                            <td align="left" style="width: 25px;">
                                <span class="font_subtitle"><?php echo($i); ?>&nbsp;</span>
                            </td>
                            <td align="left" style="width: 50px;">
                                <span class="font_main">B:</span>
                                <input style="width: 20px;" type="text" name="txtKprodimmoBuildingIn<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesin_interior[$y][0]) || $piecesin_interior[$y][0] === '0'){ echo($piecesin_interior[$y][0]); } ?>"/>
                            </td>
                            <td align="left" style="width: 50px;">
                                <span class="font_main">E:</span>
                                <input style="width: 20px;" type="text" name="txtKprodimmoFloorIn<?php echo($i); ?>" maxlength="3" size="3" value="<?php if(!empty($piecesin_interior[$y][1]) || $piecesin_interior[$y][1] === '0'){ echo($piecesin_interior[$y][1]); } ?>"/>
                            </td>
                            <td align="left" style="width: 110px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left">
<?php            
                                        if($kprodimmo_status_piecesininterior == 1)
                                        {
                                            cdreditor($kprodimmo_type_piecesininterior, $kprodimmo_nameS_piecesininterior, $kprodimmo_code_piecesininterior.$i, $kprodimmo_statusobject_piecesininterior, $kprodimmo_id_piecesininterior, $piecesin_interior[$y][2], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 6, '...');   
                                        }
?>                                                                                  
                                        </td>
                                        <td align="center">
                                            <img id="piecesininterior<?php echo($i); ?>" style="cursor: pointer;" src="<?php echo($config_customheader.'graphics/icons/use/edit2.gif'); ?>" alt="edit.gif" title="<?php //give_translation('immo.kprod_interior_edit', $echo, $config_showtranslationcode); ?>" onclick="hideshow('piecesininterior_details<?php echo($i); ?>', 'piecesininterior<?php echo($i); ?>', '', '')"/>
                                            &nbsp;
                                        </td>
                                    </tr>                                    
                                </table>
                            </td>
                            <td align="left" style="width: 60px;">
                                <input style="width: 30px;" type="text" name="txtKprodimmoSurfaceIn<?php echo($i); ?>" value="<?php if(!empty($piecesin_interior[$y][3])){ echo($piecesin_interior[$y][3]); } ?>"/>
                                <span class="font_main">m²</span>
                                &nbsp;
                            </td>
                            <td align="left" style="width: 110px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left">
<?php            
                                        if($kprodimmo_status_piecesindetailsinterior == 1)
                                        {
                                            cdreditor($kprodimmo_type_piecesindetailsinterior, $kprodimmo_nameS_piecesindetailsinterior, $kprodimmo_code_piecesindetailsinterior.$i, $kprodimmo_statusobject_piecesindetailsinterior, $kprodimmo_id_piecesindetailsinterior, $piecesin_interior[$y][4], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 8, '...'); 
                                        }
?>                                            
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr id="piecesininterior_details<?php echo($i); ?>" style="<?php if(empty($kprodimmo_piecesininterior_bok_details_hide) || $kprodimmo_piecesininterior_bok_details_hide === true){ echo('display: none;'); } ?>">
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
                                        <input type="text" name="txtKprodimmoDetailsIn<?php echo($i.'-'.$main_activatedidlang[$x]); ?>" style="width: 99%;" value="<?php if($kprodimmo_piecesininterior_details_content[$x][1] == $main_activatedidlang[$x]){ echo($kprodimmo_piecesininterior_details_content[$x][0]); } ?>"/>
                                    </td>
                                </tr>
<?php                              
                            }
?>
                                </table>
                            </td>
                        </tr>
<?php
                        unset($kprodimmo_piecesininterior_details_content);
                    }
                }
?>
                    </table></td>
                </tr>
<?php                        
            }
?>
            
            <tr>
            <td colspan="6" align="center" style="border-top: 1px solid lightgrey;">   
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
