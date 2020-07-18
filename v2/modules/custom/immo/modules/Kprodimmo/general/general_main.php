<?php
//include('modules/custom/immo/modules/Kprodimmo/general/general_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodGeneral"
<?php
                if(empty($_SESSION['expand_Kprodimmo_general']) || $_SESSION['expand_Kprodimmo_general'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodGeneral', 'img_expand_collapseKprodGeneral', 'expand_Kprodimmo_general', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodGeneral');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_general']) || $_SESSION['expand_Kprodimmo_general'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodGeneral" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodGeneral" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php /*give_translation('immo.block_title_main_kproduct', $echo, $config_showtranslationcode);*/give_translation('#*Product-Details', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_general" style="display: none;" type="hidden" name="expand_Kprodimmo_general" value="<?php if(empty($_SESSION['expand_Kprodimmo_general']) || $_SESSION['expand_Kprodimmo_general'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodGeneral"
<?php
        if(empty($_SESSION['expand_Kprodimmo_general']) || $_SESSION['expand_Kprodimmo_general'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td><table width="100%" border="0">
<?php            
            #object offer
            if($kprodimmo_status_offerobject == 1)
            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_offer_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                            cdreditor($kprodimmo_type_offerobject, $kprodimmo_nameS_offerobject, $kprodimmo_code_offerobject, $kprodimmo_statusobject_offerobject, $kprodimmo_id_offerobject, $_SESSION['Kprodimmo_general_cdreditor.offer_object'], false);                                      

                                if(!empty($_SESSION['msg_Kprodimmo_general_cdreditor.offer_object']))
                                {
?>
                                    <br clear="left"/>
                                    <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_cdreditor.offer_object']); ?></span>
<?php
                                }
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
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Product-Number', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                    <input type="text" name="number_product" value="<?php if(!empty($_SESSION['number_product'])){ echo($_SESSION['number_product']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Status', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                    <select name="status_product">
						<option value="1" <?php if(empty($_SESSION['status_product']) || $_SESSION['status_product'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('#*Enabled', $echo, $config_showtranslationcode);?></option>
						<option value="9" <?php if(!empty($_SESSION['status_product']) && $_SESSION['status_product'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('#*Disabled', $echo, $config_showtranslationcode);?></option>
					</select>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>   


			<tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Priority', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
					<select>
						<option>-----</option>
					</select>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
			
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Caddy Type', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                    <select>
						<option>-----</option>
					</select>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Matrix', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                    <select>
						<option>-----</option>
					</select>
					&nbsp;
					<input type="submit" value="<?php give_translation('#*Open', $echo, $config_showtranslationcode);?>" />
					<a href="http://fp-distribution.com/matrix_page.php">Link to Matrix Page</a>
					
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Related-Products', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                    <input type="submit" name="bt_RelatedProducts" value="<?php /*if(!empty($_SESSION['code_product_L4'])){ echo($_SESSION['code_product_L4']); }*/ /*echo "Open";*/ give_translation('#*Open', $echo, $config_showtranslationcode); ?>"/>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
			
			<tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Supplier', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td>
                    <select>
						<option>-----</option>
					</select>
<?php
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoReferenceGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td></td>
            </tr>
            
<?php
            #object type
            if($kprodimmo_status_typeobject == 1)
            {
?>
                
<?php
            }
            
            #object currency
//            if($kprodimmo_status_currencyobject == 1)
//            {
?>
                
<?php
//            }
            
            #object feetype
            if($kprodimmo_status_feetypeobject == 1 || $kprodimmo_status_feeincexobject == 1)
            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_fee_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2" width="<?php $prepared_query = 'SELECT * FROM config_structure';if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }$query = $connectData->prepare($prepared_query);$query->execute();while(($data = $query->fetch()) != false){echo $data['right_column_width'];} ?>">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <input style="width: 90px;" type="text" name="txtKprodimmoFeeGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoFeeGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoFeeGeneral']); } ?>"/>
                                
<?php   
                    if($kprodimmo_status_feetypeobject == 1)
                    {
                        cdreditor($kprodimmo_type_feetypeobject, $kprodimmo_nameS_feetypeobject, $kprodimmo_code_feetypeobject, $kprodimmo_statusobject_feetypeobject, $kprodimmo_id_feetypeobject, $_SESSION['Kprodimmo_general_cdreditor.feetype_object'], false);   
                    }
                    
                    if($kprodimmo_status_feeincexobject == 1)
                    {
                        cdreditor($kprodimmo_type_feeincexobject, $kprodimmo_nameS_feeincexobject, $kprodimmo_code_feeincexobject, $kprodimmo_statusobject_feeincexobject, $kprodimmo_id_feeincexobject, $_SESSION['Kprodimmo_general_cdreditor.feeincex_object'], false);   
                    }
?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
<?php
            }
?>
          
      
          
        
            
<?php
            #object condition
            if($kprodimmo_status_conditionobject == 1)
            {
?>
                
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

