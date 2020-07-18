<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapsePageGeneral"
<?php
                if(empty($_SESSION['expand_page_general']) || $_SESSION['expand_page_general'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapsePageGeneral', 'img_expand_collapsePageGeneral', 'expand_page_general', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapsePageGeneral');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_page_general']) || $_SESSION['expand_page_general'] == 'false')
                        {
?>
                            <img id="img_expand_collapsePageGeneral" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapsePageGeneral" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('page_edit.block_title_property', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_page_general" style="display: none;" type="hidden" name="expand_page_general" value="<?php if(empty($_SESSION['expand_page_general']) || $_SESSION['expand_page_general'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapsePageGeneral"
<?php
        if(empty($_SESSION['expand_page_general']) || $_SESSION['expand_page_general'] == 'false')
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
            <div class="font_subtitle"><?php /*give_translation('page_edit.subtitle_code_property', '', $config_showtranslationcode);*/ give_translation('#*SOME_OTHER_THING', '', $config_showtranslationcode); ?></div>
        </td> 
        <td align="right">
            <image style="cursor: help;" src="<?php echo($config_customheader); ?>graphics/icons/help/help16x16.png" alt="help.png" title="Caractères autorisés: 0-9, a-z, A-Z, et remplacer les espaces par des _ - ."></image>
        </td>
        <td  width="<?php echo($right_column_width); ?>">
            <input id="txtPageCode" type="text" name="txtPageCode" onkeyup="onkeyup_set('txtPageCode', 'txtPageURL')" value="<?php if(!empty($_SESSION['page_property_txtPageCode'])){ echo($_SESSION['page_property_txtPageCode']); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_page_property_txtPageCode']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_page_property_txtPageCode']); ?></div>    
<?php
            }
?>            
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_family_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboPageFamily">
                <option value="content" <?php if(empty($_SESSION['page_property_cboPageFamily']) || $_SESSION['page_property_cboPageFamily'] == 'content'){ echo('selected'); }else{ echo(null); }; ?>>Contenu</option>
                <option value="product" <?php if(!empty($_SESSION['page_property_cboPageFamily']) && $_SESSION['page_property_cboPageFamily'] == 'product'){ echo('selected'); }else{ echo(null); }; ?>>Produit</option>
                <option value="information" <?php if(!empty($_SESSION['page_property_cboPageFamily']) && $_SESSION['page_property_cboPageFamily'] == 'information'){ echo('selected'); }else{ echo(null); }; ?>>Information</option>
                <option value="admin" <?php if(!empty($_SESSION['page_property_cboPageFamily']) && $_SESSION['page_property_cboPageFamily'] == 'admin'){ echo('selected'); }else{ echo(null); }; ?>>Administration</option>
                <option value="---" disabled="disabled">---</option>
<?php
                if(!empty($config_module_immo) && $config_module_immo == 1)
                {
?>
                    <option value="immo" <?php if(!empty($_SESSION['page_property_cboPageFamily']) && $_SESSION['page_property_cboPageFamily'] == 'immo'){ echo('selected="selected"'); } ?>><?php give_translation('immo.page_immo', $echo, $config_showtranslationcode); ?></option>
                    <option value="immo_product" <?php if(!empty($_SESSION['page_property_cboPageFamily']) && $_SESSION['page_property_cboPageFamily'] == 'immo_product'){ echo('selected="selected"'); } ?>><?php give_translation('immo.page_immo_product', $echo, $config_showtranslationcode); ?></option>
<?php
                }
?>
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_url_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <input id="txtPageURL" type="text" name="txtPageURL" value="<?php if(!empty($_SESSION['page_property_txtPageURL'])){ echo($_SESSION['page_property_txtPageURL']); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_page_property_txtPageURL']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_page_property_txtPageURL']); ?></div>    
<?php
            }
?>            
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_scriptpath_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <input style="width: 100%;" type="text" name="txtPageScriptPath" value="<?php if(!empty($_SESSION['page_property_txtPageScriptPath'])){ echo($_SESSION['page_property_txtPageScriptPath']); } ?>"></input>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_scriptajaxjspath_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <textarea style="width: 100%;" name="areaPageScriptAjaxPath"><?php if(!empty($_SESSION['page_property_areaPageScriptAjaxPath'])){ echo($_SESSION['page_property_areaPageScriptAjaxPath']); } ?></textarea>
        </td>
    </tr>
<?php
    include('modules/page/property/page_property/listing.php');
?>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_template_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboPageTemplate">
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
                            <option value="<?php echo($data[0]); ?>" <?php if(empty($_SESSION['page_property_cboPageTemplate']) || $_SESSION['page_property_cboPageTemplate'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation($data[1]); ?></option>
<?php                            
                        }
                        else
                        {
?>
                            <option value="<?php echo($data[0]); ?>" <?php if(!empty($_SESSION['page_property_cboPageTemplate']) && $_SESSION['page_property_cboPageTemplate'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation($data[1]); ?></option>
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
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_typecontent_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%">
                        <input type="radio" 
                               value="text" 
                               name="radPageContent" 
                               onclick="OnChange('bt_radPageContent');"
                               <?php if(empty($_SESSION['page_property_radPageContent']) || $_SESSION['page_property_radPageContent'] == 'text'){ echo('checked'); }else{ echo(null); } ?>/>  
                    </td>
                    <td align="left" width="20%">        
                        <span class="font_subtitle"><?php give_translation('page_edit.typecontent_text_property', '', $config_showtranslationcode); ?></span>
                    </td>
                    <td width="10%">    
                        <input type="radio" 
                               value="html" 
                               name="radPageContent" 
                               onclick="OnChange('bt_radPageContent');"
                               <?php if(!empty($_SESSION['page_property_radPageContent']) && $_SESSION['page_property_radPageContent'] == 'html'){ echo('checked'); }else{ echo(null); } ?>/>    
                    </td>
                    <td align="left" width="100%">
                        <span class="font_subtitle"><?php give_translation('page_edit.typecontent_html_property', '', $config_showtranslationcode); ?></span> 
                        <input type="submit" style="display: none;" hidden="true" id="bt_radPageContent" name="bt_radPageContent" value="Choix Contenu"></input>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_showinsearch_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%">
                        <input type="radio" 
                               value="1" 
                               name="radPageSearch"
                               <?php if(empty($_SESSION['page_property_radPageSearch']) || $_SESSION['page_property_radPageSearch'] == 1){ echo('checked'); }else{ echo(null); } ?>/>  
                    </td>
                    <td align="left" width="20%">        
                        <span class="font_subtitle"><?php give_translation('page_edit.showinsearch_yes_property', '', $config_showtranslationcode); ?></span>
                    </td>
                    <td width="10%">    
                        <input type="radio" 
                               value="9" 
                               name="radPageSearch" 
                               <?php if(!empty($_SESSION['page_property_radPageSearch']) && $_SESSION['page_property_radPageSearch'] == 9){ echo('checked'); }else{ echo(null); } ?>/>    
                    </td>
                    <td align="left" width="100%">
                        <span class="font_subtitle"><?php give_translation('page_edit.showinsearch_no_property', '', $config_showtranslationcode); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
if(empty($_SESSION['page_edit_display_content']) || $_SESSION['page_edit_display_content'] === false)
{
    include('modules/page/property/page_property/sitemap.php');
}
?> 
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_userrights_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboPageRights[]" multiple="multiple" size="5">
                <option value="all" <?php if(empty($_SESSION['page_property_cboPageRights']) || $_SESSION['page_property_cboPageRights'] == 'all'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('page_edit.userrights_all_property', '', $config_showtranslationcode); ?></option>
<?php

            if(!empty($_SESSION['page_property_cboPageRights']) && $_SESSION['page_property_cboPageRights'] != 'all')
            {
                $levelrights_pageproperty = $_SESSION['page_property_cboPageRights'];
                $levelrights_pageproperty = str_replace(',9', '', $levelrights_pageproperty);
                $levelrights_pageproperty = split_string($levelrights_pageproperty, ',');
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
                            for($i = 0, $count = count($levelrights_pageproperty); $i < $count; $i++)
                            {
                                if($levelrights_pageproperty[$i] == $data['level_rights'])
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
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_allowstats_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboPageAllowstats">
                <option value="1" <?php if(empty($_SESSION['page_property_cboPageAllowstats']) || $_SESSION['page_property_cboPageAllowstats'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_enabled_property', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['page_property_cboPageAllowstats']) && $_SESSION['page_property_cboPageAllowstats'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_disabled_property', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>        
        <td>
            <div class="font_subtitle"><?php give_translation('page_edit.subtitle_status_property', '', $config_showtranslationcode); ?></div>
        </td> 
        <td></td>
        <td>
            <select name="cboPageStatus">
                <option value="1" <?php if(empty($_SESSION['page_property_cboPageStatus']) || $_SESSION['page_property_cboPageStatus'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_enabled_property', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['page_property_cboPageStatus']) && $_SESSION['page_property_cboPageStatus'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('page_edit.status_disabled_property', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 1px solid lightgrey;"><table width="100%" style="margin-top: 4px;">
            <tr>        
                <td width="<?php echo($right_column_width); ?>" align="center">
<?php
            if(empty($_SESSION['page_select_cboPageSelect']) || $_SESSION['page_select_cboPageSelect'] == 'new')
            {
?>
                <input type="submit" name="bt_save_page" value="<?php give_translation('page_edit.main_bt_save', '', $config_showtranslationcode); ?>"/>
                <input type="submit" name="bt_add_edit_page" value="<?php give_translation('page_edit.main_bt_savenedit', '', $config_showtranslationcode); ?>"/>        
<?php
            }
            else
            {
?>
                <input type="submit" name="bt_save_page" value="<?php give_translation('page_edit.main_bt_save', '', $config_showtranslationcode); ?>"/>
<?php
            }
?>
                </td>
            </tr> 
        </table></td>
    </tr>
    </table></td>
    </tr>
        
        
</table></td>
</tr>