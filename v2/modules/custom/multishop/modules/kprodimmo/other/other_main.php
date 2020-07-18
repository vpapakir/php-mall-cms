<?php
//include('modules/custom/immo/modules/Kprodimmo/other/other_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodOther"
<?php
                if(empty($_SESSION['expand_Kprodimmo_other']) || $_SESSION['expand_Kprodimmo_other'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodOther', 'img_expand_collapseKprodOther', 'expand_Kprodimmo_other', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodOther');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_other']) || $_SESSION['expand_Kprodimmo_other'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodOther" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodOther" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_others_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_other" style="display: none;" type="hidden" name="expand_Kprodimmo_other" value="<?php if(empty($_SESSION['expand_Kprodimmo_other']) || $_SESSION['expand_Kprodimmo_other'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodOther"
<?php
        if(empty($_SESSION['expand_Kprodimmo_other']) || $_SESSION['expand_Kprodimmo_other'] == 'false')
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
<?php                
            #other water
            if($kprodimmo_status_waterother == 1)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_water_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_waterother, $kprodimmo_nameS_waterother, $kprodimmo_code_waterother, $kprodimmo_statusobject_waterother, $kprodimmo_id_waterother, $_SESSION['Kprodimmo_other_cdreditor_water_other'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #other power
            if($kprodimmo_status_powerother == 1)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_power_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php    
                                if($kprodimmo_status_powerother == 1)
                                {
                                    cdreditor($kprodimmo_type_powerother, $kprodimmo_nameS_powerother, $kprodimmo_code_powerother, $kprodimmo_statusobject_powerother, $kprodimmo_id_powerother, $_SESSION['Kprodimmo_other_cdreditor_power_other'], true);
                                }                                
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #other phone
            if($kprodimmo_status_phoneother == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_phone_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_phoneother, $kprodimmo_nameS_phoneother, $kprodimmo_code_phoneother, $kprodimmo_statusobject_phoneother, $kprodimmo_id_phoneother, $_SESSION['Kprodimmo_other_cdreditor_phone_other'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #other TV
            if($kprodimmo_status_tvother == 1)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_tv_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_tvother, $kprodimmo_nameS_tvother, $kprodimmo_code_tvother, $kprodimmo_statusobject_tvother, $kprodimmo_id_tvother, $_SESSION['Kprodimmo_other_cdreditor_tv_other'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #other Internet
            if($kprodimmo_status_internetother == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_internet_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_internetother, $kprodimmo_nameS_internetother, $kprodimmo_code_internetother, $kprodimmo_statusobject_internetother, $kprodimmo_id_internetother, $_SESSION['Kprodimmo_other_cdreditor_internet_other'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #other furnished
            if($kprodimmo_status_furnishedother == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_furnished_others_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_furnishedother, $kprodimmo_nameS_furnishedother, $kprodimmo_code_furnishedother, $kprodimmo_statusobject_furnishedother, $kprodimmo_id_furnishedother, $_SESSION['Kprodimmo_other_cdreditor_furnished_other'], false);                                      
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
