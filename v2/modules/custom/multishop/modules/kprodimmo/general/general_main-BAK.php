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
                    <td colspan="2">
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
                <td>
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
                <td>
                    <select name="status_product">
						<option value="1" <?php if(empty($_SESSION['status_product']) || $_SESSION['status_product'] == 1){ echo('selected'); }else{ echo(null); } ?>>Enabled</option>
						<option value="9" <?php if(!empty($_SESSION['status_product']) && $_SESSION['status_product'] == 9){ echo('selected'); }else{ echo(null); } ?>>Disabled</option>
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
                    <span class="font_subtitle">Code Product L1</span>
                </td>
                <td>
                    <input type="text" name="code_product_L1" value="<?php if(!empty($_SESSION['code_product_L1'])){ echo($_SESSION['code_product_L1']); } ?>"/>
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
                <td>
                    <input type="text" name="code_product_L2" value="<?php if(!empty($_SESSION['code_product_L2'])){ echo($_SESSION['code_product_L2']); } ?>"/>
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
                    <span class="font_subtitle"><?php give_translation('#*Matrix Type', $echo, $config_showtranslationcode);?></span>
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
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('#*Related-Products', $echo, $config_showtranslationcode);?></span>
                </td>
                <td>
                    <input type="text" name="code_product_L4" value="<?php if(!empty($_SESSION['code_product_L4'])){ echo($_SESSION['code_product_L4']); } ?>"/>
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
			<tr>
                <td>
                    <span class="font_subtitle">Name Product L1</span>
                </td>
                <td>
                    <input type="text" name="name_product_L1" value="<?php if(!empty($_SESSION['name_product_L1'])){ echo($_SESSION['name_product_L1']); } ?>"/>
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
                    <span class="font_subtitle">Name Product L2</span>
                </td>
                <td>
                    <input type="text" name="name_product_L2" value="<?php if(!empty($_SESSION['name_product_L2'])){ echo($_SESSION['name_product_L2']); } ?>"/>
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
                    <span class="font_subtitle">Name Product L3</span>
                </td>
                <td>
                    <input type="text" name="name_product_L3" value="<?php if(!empty($_SESSION['name_product_L3'])){ echo($_SESSION['name_product_L3']); } ?>"/>
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
                    <span class="font_subtitle">Name Product L4</span>
                </td>
                <td>
                    <input type="text" name="name_product_L4" value="<?php if(!empty($_SESSION['name_product_L4'])){ echo($_SESSION['name_product_L4']); } ?>"/>
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
                    <span class="font_subtitle">Name Product L5</span>
                </td>
                <td>
                    <input type="text" name="name_product_L5" value="<?php if(!empty($_SESSION['name_product_L5'])){ echo($_SESSION['name_product_L5']); } ?>"/>
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
                    <span class="font_subtitle">Introduction Product L1</span>
                </td>
                <td>
                    <input type="text" name="introduction_product_L1" value="<?php if(!empty($_SESSION['introduction_product_L1'])){ echo($_SESSION['introduction_product_L1']); } ?>"/>
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
                    <span class="font_subtitle">Introduction Product L2</span>
                </td>
                <td>
                    <input type="text" name="introduction_product_L2" value="<?php if(!empty($_SESSION['introduction_product_L2'])){ echo($_SESSION['introduction_product_L2']); } ?>"/>
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
                    <span class="font_subtitle">Introduction Product L3</span>
                </td>
                <td>
                    <input type="text" name="introduction_product_L3" value="<?php if(!empty($_SESSION['introduction_product_L3'])){ echo($_SESSION['introduction_product_L3']); } ?>"/>
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
                    <span class="font_subtitle">Introduction Product L4</span>
                </td>
                <td>
                    <input type="text" name="introduction_product_L4" value="<?php if(!empty($_SESSION['introduction_product_L4'])){ echo($_SESSION['introduction_product_L4']); } ?>"/>
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
                    <span class="font_subtitle">Introduction Product L5</span>
                </td>
                <td>
                    <input type="text" name="introduction_product_L5" value="<?php if(!empty($_SESSION['introduction_product_L5'])){ echo($_SESSION['introduction_product_L5']); } ?>"/>
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
                    <span class="font_subtitle">Description Product L1</span>
                </td>
                <td>
                    <input type="text" name="description_product_L1" value="<?php if(!empty($_SESSION['description_product_L1'])){ echo($_SESSION['description_product_L1']); } ?>"/>
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
                    <span class="font_subtitle">Description Product L2</span>
                </td>
                <td>
                    <input type="text" name="description_product_L2" value="<?php if(!empty($_SESSION['description_product_L2'])){ echo($_SESSION['description_product_L2']); } ?>"/>
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
                    <span class="font_subtitle">Description Product L3</span>
                </td>
                <td>
                    <input type="text" name="description_product_L3" value="<?php if(!empty($_SESSION['code_product_L1'])){ echo($_SESSION['description_product_L3']); } ?>"/>
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
                    <span class="font_subtitle">Description Product L4</span>
                </td>
                <td>
                    <input type="text" name="description_product_L4" value="<?php if(!empty($_SESSION['description_product_L4'])){ echo($_SESSION['description_product_L4']); } ?>"/>
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
                    <span class="font_subtitle">Description Product L5</span>
                </td>
                <td>
                    <input type="text" name="description_product_L5" value="<?php if(!empty($_SESSION['description_product_L5'])){ echo($_SESSION['description_product_L5']); } ?>"/>
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
                    <span class="font_subtitle">Code Group Product</span>
                </td>
                <td>
                    <input type="text" name="code_group_product" value="<?php if(!empty($_SESSION['code_group_product'])){ echo($_SESSION['code_group_product']); } ?>"/>
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
                    <span class="font_subtitle">Code Category Product L1</span>
                </td>
                <td>
                    <input type="text" name="code_category_product" value="<?php if(!empty($_SESSION['code_category_product'])){ echo($_SESSION['code_category_product']); } ?>"/>
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
                    <span class="font_subtitle">ID Option Product</span>
                </td>
                <td>
                    <input type="text" name="id_option_product" value="<?php if(!empty($_SESSION['id_option_product'])){ echo($_SESSION['id_option_product']); } ?>"/>
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
                    <span class="font_subtitle"><?php give_translation('#Priority', $echo, $config_showtranslationcode);?></span>
                </td>
                <td colspan="2">
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
                    <span class="font_subtitle">Image Thumb Product</span>
                </td>
                <td>
                    <input type="text" name="image_thumb_product" value="<?php if(!empty($_SESSION['image_thumb_product'])){ echo($_SESSION['image_thumb_product']); } ?>"/>
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
                    <span class="font_subtitle">ID Page</span>
                </td>
                <td>
                    <input type="text" name="id_page" value="<?php if(!empty($_SESSION['id_page'])){ echo($_SESSION['id_page']); } ?>"/>
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
                    <span class="font_subtitle">Number Link Product</span>
                </td>
                <td>
                    <input type="text" name="number_link_product" value="<?php if(!empty($_SESSION['number_link_product'])){ echo($_SESSION['number_link_product']); } ?>"/>
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
                    <span class="font_subtitle">Cart Type Product</span>
                </td>
                <td>
                    <input type="text" name="cart_type_product" value="<?php if(!empty($_SESSION['cart_type_product'])){ echo($_SESSION['cart_type_product']); } ?>"/>
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
                    <span class="font_subtitle">Transport Fee Product</span>
                </td>
                <td>
                    <input type="text" name="transport_fee_product" value="<?php if(!empty($_SESSION['transport_fee_product'])){ echo($_SESSION['transport_fee_product']); } ?>"/>
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
                    <span class="font_subtitle">Noticelink Product</span>
                </td>
                <td>
                    <input type="text" name="noticelink_product" value="<?php if(!empty($_SESSION['noticelink_product'])){ echo($_SESSION['noticelink_product']); } ?>"/>
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
                    <span class="font_subtitle">ID Cooshop</span>
                </td>
                <td>
                    <input type="text" name="id_cooshop" value="<?php if(!empty($_SESSION['id_cooshop'])){ echo($_SESSION['id_cooshop']); } ?>"/>
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
                    <span class="font_subtitle">Product Class ID</span>
                </td>
                <td>
                    <input type="text" name="product_class_id" value="<?php if(!empty($_SESSION['product_class_id'])){ echo($_SESSION['product_class_id']); } ?>"/>
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
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_reference_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td>
                    <input type="text" name="txtKprodimmoReferenceGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoReferenceGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoReferenceGeneral']); } ?>"/>
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
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_typeobject_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                            cdreditor($kprodimmo_type_typeobject, $kprodimmo_nameS_typeobject, $kprodimmo_code_typeobject, $kprodimmo_statusobject_typeobject, $kprodimmo_id_typeobject, $_SESSION['Kprodimmo_general_cdreditor.type_object'], false);                                      

                                if(!empty($_SESSION['msg_Kprodimmo_general_cdreditor.type_object']))
                                {
?>
                                    <br clear="left"/>
                                    <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_cdreditor.type_object']); ?></span>
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
            
            #object currency
//            if($kprodimmo_status_currencyobject == 1)
//            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_price_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <input style="width: 90px;" type="text" name="txtKprodimmoPriceGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoPriceGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoPriceGeneral']); } ?>"/>                                    
                                    <select id="cboCurrencyQuicksearch" name="cboKprodimmoCurrencyGeneral">
<?php 
                                    for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
                                    {
?>
                                        <option value="<?php echo($main_activatedidcurrency[$i]); ?>"
                                            <?php if(!empty($_SESSION['Kprodimmo_general_cboKprodimmoCurrencyGeneral']) && $_SESSION['Kprodimmo_general_cboKprodimmoCurrencyGeneral'] == $main_activatedidcurrency[$i]){ echo('selected="selected"'); }else{ if(empty($_SESSION['Kprodimmo_general_cboKprodimmoCurrencyGeneral']) && $main_id_currency == $main_activatedidcurrency[$i]){ echo('selected="selected"'); }else{ echo(null); } } ?>
                                                ><?php echo($main_activatedcodecurrency[$i]) ?></option>    
<?php                                                
                                    }
?>
                                    </select>
<?php                                                          

                                    //cdreditor($kprodimmo_type_currencyobject, $kprodimmo_nameP_currencyobject, $kprodimmo_code_currencyobject, $kprodimmo_statusobject_currencyobject, $kprodimmo_id_currencyobject, $_SESSION['Kprodimmo_general_cdreditor.currency_object'], true); 
                                        
                                    
                                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoPriceGeneral']))
                                    {
?>
                                        <br clear="left"/>
                                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoPriceGeneral']); ?></span>
<?php
                                    }
                                    
                                    if(!empty($_SESSION['msg_Kprodimmo_general_cdreditor.currency_object']))
                                    {
?>
                                        <br clear="left"/>
                                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_cdreditor.currency_object']); ?></span>
<?php
                                    }
?>       
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
                    <td colspan="2">
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
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_surfacelivingspace_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoSurfaceHabGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceHabGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceHabGeneral']); } ?>"/>
                    &nbsp;
                    <span class="font_main">m²</span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_surfaceground_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoSurfaceGroundGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceGroundGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceGroundGeneral']); } ?>"/>
<?php
                    #object surface type
                    if($kprodimmo_status_surfacetypeobject == 1)
                    {                                      
                        cdreditor($kprodimmo_type_surfacetypeobject, $kprodimmo_nameS_surfacetypeobject, $kprodimmo_code_surfacetypeobject, $kprodimmo_statusobject_surfacetypeobject, $kprodimmo_id_surfacetypeobject, $_SESSION['Kprodimmo_general_cdreditor.surfacetype_object'], true);                                      
                    }
?>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_cellar_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoSurfaceCellarGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceCellarGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceCellarGeneral']); } ?>"/>
                    &nbsp;
                    <span class="font_main">m²</span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_loft_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoSurfaceLoftGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceLoftGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoSurfaceLoftGeneral']); } ?>"/>
                    &nbsp;
                    <span class="font_main">m²</span>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_floor_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoNumFloorGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumFloorGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumFloorGeneral']); } ?>"/>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_totalrooms_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" id="KprodimmoNumRooms" name="txtKprodimmoNumRoomsGeneral" onkeyup="request();" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumRoomsGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumRoomsGeneral']); } ?>"/>
                    <span id="ajaxloader" style="display: none;"><img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" /></span>
                    <div id="KprodimmoNumRoomsMSG" style="display: none;"><span class="font_error1">Valeur de type numérique attendue (ex: 12)</span></div>
<?php 
                    if(!empty($_SESSION['msg_Kprodimmo_general_txtKprodimmoNumRoomsGeneral']))
                    {
?>
                        <br clear="left"/>
                        <span class="font_error1"><?php echo($_SESSION['msg_Kprodimmo_general_txtKprodimmoNumRoomsGeneral']); ?></span>
<?php
                    }
?>
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_sleep_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoNumSleepsGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumSleepsGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumSleepsGeneral']); } ?>"/>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_bathroom_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoNumBathGeneral" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumBathGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumBathGeneral']); } ?>"/>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_toilet_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" name="txtKprodimmoNumWCGeneal" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumWCGeneal'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumWCGeneal']); } ?>"/>
                </td>
            </tr>
            
            <tr>
                <td>
                    <span class="font_subtitle"><?php give_translation('immo.subtitle_outhouses_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td colspan="2">
                    <input style="width: 90px;" type="text" id="txtKprodimmoNumOutHousesGeneral" name="txtKprodimmoNumOutHousesGeneral" onkeyup="requestKprodimmoPiecesOutGeneral();" value="<?php if(!empty($_SESSION['Kprodimmo_general_txtKprodimmoNumOutHousesGeneral'])){ echo($_SESSION['Kprodimmo_general_txtKprodimmoNumOutHousesGeneral']); } ?>"/>
                    <span id="ajaxloaderOutHousesGeneral" style="display: none;"><img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" /></span>
                    <div id="KprodimmoNumOutHousesGeneralMSG" style="display: none;"><span class="font_error1">Valeur de type numérique attendue (ex: 12)</span></div>
                </td>
            </tr>
<?php
            #object condition
            if($kprodimmo_status_conditionobject == 1)
            {
?>
                <tr>
                    <td>
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_condition_main_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td colspan="2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>                      
<?php                       
                                    cdreditor($kprodimmo_type_conditionobject, $kprodimmo_nameS_conditionobject, $kprodimmo_code_conditionobject, $kprodimmo_statusobject_conditionobject, $kprodimmo_id_conditionobject, $_SESSION['Kprodimmo_general_cdreditor.condition_object'], false);                                      
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

