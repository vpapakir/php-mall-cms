<?php
//include('modules/custom/'.$config_customfolder.'/modules/Kprodimmo/admin/admin_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodAdmin"
<?php
                if(empty($_SESSION['expand_Kprodimmo_admin']) || $_SESSION['expand_Kprodimmo_admin'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodAdmin', 'img_expand_collapseKprodAdmin', 'expand_Kprodimmo_admin', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodAdmin');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_admin']) || $_SESSION['expand_Kprodimmo_admin'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodAdmin" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodAdmin" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_admin_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_admin" style="display: none;" type="hidden" name="expand_Kprodimmo_admin" value="<?php if(empty($_SESSION['expand_Kprodimmo_admin']) || $_SESSION['expand_Kprodimmo_admin'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodAdmin"
<?php
        if(empty($_SESSION['expand_Kprodimmo_admin']) || $_SESSION['expand_Kprodimmo_admin'] == 'false')
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
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_agency_admin_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <span class="font_error1">clients type agence</span>    
                            </td>
                        </tr>
                    </table>
                </td>    
            </tr>    
                
<?php   

            #admin commercial details
            if($kprodimmo_status_comdetailsadmin == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_comdetails_admin_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_comdetailsadmin, $kprodimmo_nameS_comdetailsadmin, $kprodimmo_code_comdetailsadmin, $kprodimmo_statusobject_comdetailsadmin, $kprodimmo_id_comdetailsadmin, $_SESSION['Kprodimmo_admin_cdreditor_comdetails_admin'], false);                                      
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
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_remarks_admin_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" colspan="2">
                    <textarea style="width: 100%;" name="areaKprodimmoNoteAdmin"><?php if(!empty($_SESSION['Kprodimmo_admin_areaKprodimmoNoteAdmin'])){ echo($_SESSION['Kprodimmo_admin_areaKprodimmoNoteAdmin']); } ?></textarea>
                </td>
            </tr>
            
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
