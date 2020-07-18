<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseProdProperty"
<?php
                if(empty($_SESSION['expand_product_property']) || $_SESSION['expand_product_property'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseProdProperty', 'img_expand_collapseProdProperty', 'expand_product_property', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseProdProperty');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_product_property']) || $_SESSION['expand_product_property'] == 'false')
                        {
?>
                            <img id="img_expand_collapseProdProperty" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseProdProperty" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
<?php
                    if(!empty($_SESSION['product_edit_display_content']) && $_SESSION['product_edit_display_content'] === true)
                    {
                        //give_translation('edit_product.block_generaltitle_property', $echo, $config_showtranslationcode);
						give_translation('#*Page-Information', $echo, $config_showtranslationcode);
                    }
                    else
                    {
                        give_translation('#*Page-Information', $echo, $config_showtranslationcode);
                    }
?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_product_property" style="display: none;" type="hidden" name="expand_product_property" value="<?php if(empty($_SESSION['expand_product_property']) || $_SESSION['expand_product_property'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseProdProperty"
<?php
        if(empty($_SESSION['expand_product_property']) || $_SESSION['expand_product_property'] == 'false')
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
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_code_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td align="right">
            <image style="cursor: help;" src="<?php echo($config_customheader); ?>graphics/icons/help/help16x16.png" alt="help.png" title="Caractères autorisés: 0-9, a-z, A-Z, et remplacer les espaces par des _ - ."></image>
        </td>
        <td  width="<?php echo($right_column_width); ?>">
            <input id="txtProductCode" type="text" name="txtProductCode" onkeyup="onkeyup_set('txtProductCode', 'txtProductURL')" value="<?php if(!empty($_SESSION['product_property_txtProductCode'])){ echo($_SESSION['product_property_txtProductCode']); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_product_property_txtProductCode']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_product_property_txtProductCode']); ?></div>    
<?php
            }
?>            
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_family_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboProductFamily">
                <option value="product" <?php if(empty($_SESSION['product_property_cboProductFamily']) || $_SESSION['product_property_cboProductFamily'] == 'product'){ echo('selected'); }else{ echo(null); }; ?>><?php give_translation('edit_product.product_property.cboProductFamily.product', $echo, $config_showtranslationcode); ?></option>
                <option value="content" <?php if(!empty($_SESSION['product_property_cboProductFamily']) && $_SESSION['product_property_cboProductFamily'] == 'content'){ echo('selected'); }else{ echo(null); }; ?>><?php give_translation('edit_product.product_property.cboProductFamily.contents', $echo, $config_showtranslationcode); ?></option>
                <option value="admin" <?php if(!empty($_SESSION['product_property_cboProductFamily']) && $_SESSION['product_property_cboProductFamily'] == 'admin'){ echo('selected'); }else{ echo(null); }; ?>><?php give_translation('edit_product.product_property.cboProductFamily.administration', $echo, $config_showtranslationcode); ?></option>
                <option value="---" disabled="disabled">---</option>
<?php
                if(!empty($config_module_immo) && $config_module_immo == 1)
                {
?>
                    <option value="immo" <?php if(!empty($_SESSION['product_property_cboProductFamily']) && $_SESSION['product_property_cboProductFamily'] == 'immo'){ echo('selected="selected"'); } ?>><?php give_translation('immo.page_immo', $echo, $config_showtranslationcode); ?></option>
                    <option value="immo_product" <?php if(!empty($_SESSION['product_property_cboProductFamily']) && $_SESSION['product_property_cboProductFamily'] == 'immo_product'){ echo('selected="selected"'); } ?>><?php give_translation('immo.page_immo_product', $echo, $config_showtranslationcode); ?></option>
<?php
                }
?>
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_url_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <input id="txtProductURL" type="text" name="txtProductURL" value="<?php if(!empty($_SESSION['product_property_txtProductURL'])){ echo($_SESSION['product_property_txtProductURL']); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_product_property_txtProductURL']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_product_property_txtProductURL']); ?></div>    
<?php
            }
?>            
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_scriptpath_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <input style="width: 100%;" type="text" name="txtProductScriptPath" value="<?php if(!empty($_SESSION['product_property_txtProductScriptPath'])){ echo($_SESSION['product_property_txtProductScriptPath']); } ?>"></input>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_scriptajaxjspath_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <textarea style="width: 100%;" name="areaProductScriptAjaxPath"><?php if(!empty($_SESSION['product_property_areaProductScriptAjaxPath'])){ echo($_SESSION['product_property_areaProductScriptAjaxPath']); } ?></textarea>
        </td>
    </tr>
<?php
    include('modules/product/property/product_property/listing.php');
?>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_template_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboProductTemplate">
<?php
                try
                {
                    $prepared_query = 'SELECT name_script_template, transcode_script_template 
                                       FROM script_template
                                       WHERE status_script_template = 1
                                       ORDER BY position_script_template';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    $i = 0;
                    while($data = $query->fetch())
                    {
                        if($i == 0)
                        {
?>
                            <option value="<?php echo($data[0]); ?>" <?php if(empty($_SESSION['product_property_cboProductTemplate']) || $_SESSION['product_property_cboProductTemplate'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation($data[1]); ?></option>
<?php                            
                        }
                        else
                        {
?>
                            <option value="<?php echo($data[0]); ?>" <?php if(!empty($_SESSION['product_property_cboProductTemplate']) && $_SESSION['product_property_cboProductTemplate'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation($data[1]); ?></option>
<?php 
                        }
                        $i++;
                    }
                    $query->closeCursor();
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
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_typecontent_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%">
                        <input type="radio" 
                               value="text" 
                               name="radProductContent" 
                               onclick="OnChange('bt_radProductContent');"
                               <?php if(empty($_SESSION['product_property_radProductContent']) || $_SESSION['product_property_radProductContent'] == 'text'){ echo('checked'); }else{ echo(null); } ?>/>  
                    </td>
                    <td align="left" width="20%">        
                        <span class="font_subtitle"><?php give_translation('edit_product.typecontent_text_product', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td width="10%">    
                        <input type="radio" 
                               value="html" 
                               name="radProductContent" 
                               onclick="OnChange('bt_radProductContent');"
                               <?php if(!empty($_SESSION['product_property_radProductContent']) && $_SESSION['product_property_radProductContent'] == 'html'){ echo('checked'); }else{ echo(null); } ?>/>    
                    </td>
                    <td align="left" width="100%">
                        <span class="font_subtitle"><?php give_translation('edit_product.typecontent_html_product', $echo, $config_showtranslationcode); ?></span> 
                        <input type="submit" style="display: none;" hidden="true" id="bt_radProductContent" name="bt_radProductContent" value="<?php give_translation('edit_product.product_property.bt_radProductContent', $echo, $config_showtranslationcode); ?>"></input>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_showinsearch_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%">
                        <input type="radio" 
                               value="1" 
                               name="radProductSearch"
                               <?php if(empty($_SESSION['product_property_radProductSearch']) || $_SESSION['product_property_radProductSearch'] == 1){ echo('checked'); }else{ echo(null); } ?>/>  
                    </td>
                    <td align="left" width="20%">        
                        <span class="font_subtitle"><?php give_translation('main.dd_yes', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td width="10%">    
                        <input type="radio" 
                               value="9" 
                               name="radProductSearch" 
                               <?php if(!empty($_SESSION['product_property_radProductSearch']) && $_SESSION['product_property_radProductSearch'] == 9){ echo('checked'); }else{ echo(null); } ?>/>    
                    </td>
                    <td align="left" width="100%">
                        <span class="font_subtitle"><?php give_translation('main.dd_no', $echo, $config_showtranslationcode); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
if(empty($_SESSION['product_edit_display_content']) || $_SESSION['product_edit_display_content'] === false)
{
    include('modules/product/property/product_property/sitemap.php');
}
?> 
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_userrights_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboProductRights[]" multiple="multiple" size="5">
                <option value="all" <?php if(empty($_SESSION['product_property_cboProductRights']) || $_SESSION['product_property_cboProductRights'] == 'all'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('edit_product.userrights_all_product', $echo, $config_showtranslationcode); ?></option>
<?php

            if(!empty($_SESSION['product_property_cboProductRights']) && $_SESSION['product_property_cboProductRights'] != 'all')
            {
                $levelrights_productproperty = $_SESSION['product_property_cboProductRights'];
                $levelrights_productproperty = str_replace(',9', '', $levelrights_productproperty);
                $levelrights_productproperty = split_string($levelrights_productproperty, ',');
            }

            try
            {
                $prepared_query = 'SELECT * FROM user_rights
                                   WHERE level_rights <> 9
                                   ORDER BY level_rights';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <option value="<?php echo($data['level_rights']); ?>"
<?php
                            for($i = 0, $count = count($levelrights_productproperty); $i < $count; $i++)
                            {
                                if($levelrights_productproperty[$i] == $data['level_rights'])
                                {
                                    echo('selected="selected" ');
                                }
                                else
                                {
                                    echo(null);
                                }
                            }
?>                          
                            ><?php give_translation('main.'.$data['name_rights']); ?></option>
<?php                
                }
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
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_allowstats_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboProductAllowstats">
                <option value="1" <?php if(empty($_SESSION['product_property_cboProductAllowstats']) || $_SESSION['product_property_cboProductAllowstats'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_enabled_property', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['product_property_cboProductAllowstats']) && $_SESSION['product_property_cboProductAllowstats'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_disabled_property', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('edit_product.subtitle_status_product', $echo, $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboProductStatus">
                <option value="1" <?php if(empty($_SESSION['product_property_cboProductStatus']) || $_SESSION['product_property_cboProductStatus'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_product.product_property.cboProductStatus.enabled', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['product_property_cboProductStatus']) && $_SESSION['product_property_cboProductStatus'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('edit_product.subtitle_allowstats_property.disabled', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr> 
    <tr>        
        <td colspan="3" style="border-top: 1px solid lightgrey;"><table width="100%" style="margin-top: 4px;">
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