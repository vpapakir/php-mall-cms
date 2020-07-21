<tr>
<td><form method="post"><table class="block_main2" width="100%">
    <tr>        
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choice_box', '', $config_showtranslationcode); ?>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <select name="cboBox" onchange="OnChange('bt_cboBox')">
                <option value="new" <?php if(empty($_SESSION['sitemap_box_cboBox']) || $_SESSION['sitemap_box_cboBox'] == 'new'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_newbox', '', $config_showtranslationcode); ?></option>
    <?php
            if(!empty($_SESSION['sitemap_add_box']) && $_SESSION['sitemap_add_box'] === true)
            {
			
				echo "OK";

                try
                {
                    $prepared_query = 'SELECT id_hierarchy_box FROM hierarchy_box
                                       WHERE id_frame = :frame';
                    if(empty($config_module_immo) || $config_module_immo == 9)
                    {
                        $prepared_query .= ' AND family_hierarchy_box = "main"';
                    }
                    else
                    {
                        $prepared_query .= ' AND (family_hierarchy_box = "main"';

                        if(!empty($config_module_immo) && $config_module_immo == 1)
                        {
                           $prepared_query .= ' OR family_hierarchy_box = "immo"';
                        }

                        $prepared_query .= ')';
                    }
					
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('frame', htmlspecialchars($_SESSION['sitemap_frame_cboSitemapFrame'], ENT_QUOTES));
                    $query->execute();

                    $i = 0;

                    while($data = $query->fetch())
                    {
                        $id_box[$i] = $data[0];
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

            }
            else
            {
				echo "NOT OK";
                $id_box = $_SESSION['sitemap_frame_idbox'];
            }

            for($i = 0, $count = count($id_box); $i < $count; $i++)
            {
                try
                {
                    $prepared_query = 'SELECT * FROM hierarchy_box
                                       WHERE id_hierarchy_box = :box';
                    if(empty($config_module_immo) || $config_module_immo == 9)
                    {
                        $prepared_query .= ' AND family_hierarchy_box = "main"';
                    }
                    else
                    {
                        $prepared_query .= ' AND (family_hierarchy_box = "main"';

                        if(!empty($config_module_immo) && $config_module_immo == 1)
                        {
                           $prepared_query .= ' OR family_hierarchy_box = "immo"';
                        }

                        $prepared_query .= ')';
                    }
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('box', $id_box[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
    ?>
                        <option value="<?php echo($data[0]); ?>" <?php if(!empty($_SESSION['sitemap_box_cboBox']) && $_SESSION['sitemap_box_cboBox'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($data['L'.$main_id_language]); ?></option>
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
            }
    ?>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboBox" type="submit" name="bt_cboBox" value="Choix Box"></input>
    <?php
            if(!empty($_SESSION['sitemap_levelx_hiddenbox']) && $_SESSION['sitemap_levelx_hiddenbox'] === true)
            {
    ?>
                <input type="submit" name="bt_show_box" value="+"></input>
    <?php   
            }
    ?>
        </td> 
    </tr>

<?php
    if(empty($_SESSION['sitemap_levelx_hiddenbox']))
    {
?>
    
    <tr>

        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choicetemplate_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxType">
                <option value="select" <?php if(empty($_SESSION['sitemap_box_cboBoxType']) || $_SESSION['sitemap_box_cboBoxType'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_choicebox', '', $config_showtranslationcode); ?></option>


    <?php
                try
                {
                    $prepared_query = 'SELECT * FROM structure_box 
                                       ORDER BY name_box';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();

                    while($data = $query->fetch())
                    {
    ?>
                        <option value="<?php echo($data[0]); ?>"
                        <?php if(!empty($_SESSION['sitemap_box_cboBoxType']) && $_SESSION['sitemap_box_cboBoxType'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($data['name_box']); ?></option>
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
    <?php
            if(!empty($_SESSION['msg_sitemap_box_cboBoxType']))
            {
    ?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_box_cboBoxType']); ?></div>    
    <?php
            }
    ?>
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choicefamily_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxFamily">
                <option value="main" <?php if(empty($_SESSION['sitemap_box_cboBoxFamily']) || $_SESSION['sitemap_box_cboBoxFamily'] == 'main'){ echo('selected="selected"'); } ?>><?php give_translation('main.dd_hierarchy_family_main', '', $config_showtranslationcode); ?></option>
                <option value="---" disabled="disabled">---</option>
<?php
                if(!empty($config_module_immo) && $config_module_immo == 1)
                {
?>
                    <option value="immo" <?php if(!empty($_SESSION['sitemap_box_cboBoxFamily']) && $_SESSION['sitemap_box_cboBoxFamily'] == 'immo'){ echo('selected="selected"'); } ?>><?php give_translation('main.dd_hierarchy_family_immo', '', $config_showtranslationcode); ?></option>
<?php
                }
?>
            </select>
        </td>
    </tr>
<?php
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
?>
        <tr>
            <td align="left">
                <span class="font_subtitle"><?php give_translation('sitemap.subtitle_name_box', '', $config_showtranslationcode); echo(' - '); give_translation($main_activatedcodelang[$i], '', $config_showtranslationcode); ?></span>
            </td>
            <td align="left">
                <input type="text" name="txtBoxTitle<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]])){ echo($_SESSION['sitemap_box_txtBoxTitle'.$main_activatedidlang[$i]]); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_sitemap_box_txtBoxTitle']) && $i == 0)
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_box_txtBoxTitle']); ?></div>    
<?php
            }
?>
            </td>
        </tr>
<?php

    }
?>

<?php
    if(!empty($_SESSION['sitemap_box_txtBoxMargin']))
    {
        $margin_box = split_string($_SESSION['sitemap_box_txtBoxMargin'], '$');
        
        if(empty($margin_box[0]) ? $margin_box[0] = 0 : $margin_box[0] = $margin_box[0]);
        if(empty($margin_box[1]) ? $margin_box[1] = 0 : $margin_box[1] = $margin_box[1]);
        if(empty($margin_box[2]) ? $margin_box[2] = 0 : $margin_box[2] = $margin_box[2]);
        if(empty($margin_box[3]) ? $margin_box[3] = 0 : $margin_box[3] = $margin_box[3]);
    }
    else
    {
        $margin_box[0] = 0;
        $margin_box[1] = 0;
        $margin_box[2] = 0;
        $margin_box[3] = 0;
    }
?>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_margin_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <span class="font_subtitle"><?php give_translation('sitemap.margin_left_box', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtBoxMarginL" value="<?php if(!empty($margin_box[3])){ echo($margin_box[3]); } ?>"></input>&nbsp;
            <span class="font_subtitle"><?php give_translation('sitemap.margin_right_box', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtBoxMarginR" value="<?php if(!empty($margin_box[1])){ echo($margin_box[1]); } ?>"></input>&nbsp;
            <span class="font_subtitle"><?php give_translation('sitemap.margin_top_box', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtBoxMarginT" value="<?php if(!empty($margin_box[0])){ echo($margin_box[0]); } ?>"></input>&nbsp;       
            <span class="font_subtitle"><?php give_translation('sitemap.margin_bottom_box', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtBoxMarginB" value="<?php if(!empty($margin_box[2])){ echo($margin_box[2]); } ?>"></input>&nbsp;
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_aligntitle_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxTitleAlign">
                <option style="text-align: left;" value="left" <?php if(!empty($_SESSION['sitemap_box_cboBoxTitleAlign']) && $_SESSION['sitemap_box_cboBoxTitleAlign'] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_left_box', '', $config_showtranslationcode); ?></option>
                <option style="text-align: center;" value="center" <?php if(empty($_SESSION['sitemap_box_cboBoxTitleAlign']) || $_SESSION['sitemap_box_cboBoxTitleAlign'] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_center_box', '', $config_showtranslationcode); ?></option>
                <option style="text-align: right;" value="right" <?php if(!empty($_SESSION['sitemap_box_cboBoxTitleAlign']) && $_SESSION['sitemap_box_cboBoxTitleAlign'] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_right_box', '', $config_showtranslationcode); ?></option>
                <option style="text-align: justify;" value="justify" <?php if(!empty($_SESSION['sitemap_box_cboBoxTitleAlign']) && $_SESSION['sitemap_box_cboBoxTitleAlign'] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_justify_box', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_link_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxTypeLink" onchange="OnChange('bt_cboBoxTypeLink')">
                <option value="select" <?php if(empty($_SESSION['sitemap_box_cboBoxTypeLink']) || $_SESSION['sitemap_box_cboBoxTypeLink'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_choicelink_box', '', $config_showtranslationcode); ?></option>
                <option value="page" <?php if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'page'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_page_box', '', $config_showtranslationcode); ?></option>
                <option value="script" <?php if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'script'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_script_box', '', $config_showtranslationcode); ?></option>
                <option value="url" <?php if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'url'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_url_box', '', $config_showtranslationcode); ?></option>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboBoxTypeLink" type="submit" name="bt_cboBoxTypeLink" value="Choix Type de lien box"></input>
        </td>
    </tr>
    
    
<?php
    if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'script')
    {
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkscriptpath_box', '', $config_showtranslationcode); ?>
            </td>
            <td>
                <input type="text" name="txtBoxScriptPath" value="<?php if(!empty($_SESSION['sitemap_box_txtBoxLink'])){ echo($_SESSION['sitemap_box_txtBoxLink']); } ?>"></input>
            </td>
        </tr>
<?php    
    }
    
    if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'url')
    {
?>
    
        <tr>
            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkurl_box', '', $config_showtranslationcode); ?>
            </td>
            <td>
                <input type="text" name="txtBoxURL" value="<?php if(!empty($_SESSION['sitemap_box_txtBoxLink'])){ echo($_SESSION['sitemap_box_txtBoxLink']); } ?>"></input>
            </td>
        </tr>
<?php
    }
    
    if(!empty($_SESSION['sitemap_box_cboBoxTypeLink']) && $_SESSION['sitemap_box_cboBoxTypeLink'] == 'page')
    {        
?>
        <tr>

            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkpage_box', '', $config_showtranslationcode); ?>
                &nbsp;
                [<a class="link_main" href="<?php echo($config_customheader); change_link($link_newpage_sitemap[0], $link_newpage_sitemap[1]) ?>"><?php give_translation('sitemap.linkpage_newpage_box', '', $config_showtranslationcode); ?></a>]
            </td>
            <td>
                <select name="cboBoxPage">
    <?php  
                try
                {
                    $prepared_query = 'SELECT * FROM page
                                       INNER JOIN page_translation
                                       ON page_translation.id_page = page.id_page
                                       WHERE family_page_translation = "title"
                                       ORDER BY family_page, L'.$main_id_language;
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    $i = 0;
                    while($data = $query->fetch())
                    {
                        if($i == 0)
                        {
                            $sitemap_listingpage_family = $data['family_page'];
    ?>
                            <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('main.dd_family_'.$sitemap_listingpage_family, $echo, $config_showtranslationcode); ?>">
    <?php
                        }
                        else
                        {
                            if($data['family_page'] != $sitemap_listingpage_family)
                            {
                                $sitemap_listingpage_family = $data['family_page'];
    ?>
                                <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('main.dd_family_'.$sitemap_listingpage_family, $echo, $config_showtranslationcode); ?>">
    <?php
                            }
                        }

                        if(empty($data['L'.$main_id_language]))
                        {
                            $sitemap_name_listingpage_element = $data['url_page'];
                        }
                        else
                        {
                            $sitemap_name_listingpage_element = cut_string($data['L'.$main_id_language], 0, 30, '...');
                        }
    ?>
                        <option style="background-color: white;" value="<?php echo($data[0]); ?>" title="<?php echo($data['L'.$main_id_language]); ?>"
                        <?php if(!empty($_SESSION['sitemap_levelx_txtLevelxLink']) && $_SESSION['sitemap_levelx_txtLevelxLink'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php if($sitemap_listingpage_family == 'product'){ echo($data['code_page'].' '.$sitemap_name_listingpage_element); }else{ echo($sitemap_name_listingpage_element); } ?></option>
    <?php                    
                        if($i == 0)
                        {
    ?>
                            </optgroup>
    <?php
                        }
                        else
                        {
                            if($data['family_page'] != $sitemap_listingpage_family)
                            {
    ?>
                                </optgroup>
    <?php
                            }
                        }
                        $i++;
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
<?php
    }
?> 
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_target_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxTarget">
                <option value="_self" <?php if(empty($_SESSION['sitemap_box_cboBoxTarget']) || $_SESSION['sitemap_box_cboBoxTarget'] == '_self'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_samewindow_box', '', $config_showtranslationcode); ?></option>
                <option value="_blank" <?php if(!empty($_SESSION['sitemap_box_cboBoxTarget']) && $_SESSION['sitemap_box_cboBoxTarget'] == '_blank'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_newtab_box', '', $config_showtranslationcode); ?></option>
                <option value="_top" <?php if(!empty($_SESSION['sitemap_box_cboBoxTarget']) && $_SESSION['sitemap_box_cboBoxTarget'] == '_top'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_newwindow_box', '', $config_showtranslationcode); ?></option>
                <option value="_parent" <?php if(!empty($_SESSION['sitemap_box_cboBoxTarget']) && $_SESSION['sitemap_box_cboBoxTarget'] == '_parent'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_parent_box', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
        
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_position_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input style="width: 50px;" type="text" name="txtBoxPosition" value="<?php if(!empty($_SESSION['sitemap_box_txtBoxPosition'])){ echo($_SESSION['sitemap_box_txtBoxPosition']); } ?>"></input>
    <?php
            if(!empty($_SESSION['msg_sitemap_box_txtBoxPosition']))
            {
    ?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_box_txtBoxPosition']); ?></div>    
    <?php
            }
    ?>    
        </td>
    </tr>
    <tr>   
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choiceframe_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxFrame">
    <?php
                for($i = 0, $count = count($id_frame_sitemap); $i < $count; $i++)
                {
    ?>
                    <option value="<?php echo($id_frame_sitemap[$i]); ?>" 
                    <?php if(!empty($_SESSION['sitemap_box_cboBoxFrame']) && $_SESSION['sitemap_box_cboBoxFrame'] == $id_frame_sitemap[$i]){ echo('selected'); }else{ echo(null); } ?>>
                    <?php echo($name_frame_sitemap[$i]); ?></option>
    <?php          
                }
    ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="left" style="vertical-align: top;">
            <span class="font_subtitle"><?php give_translation('sitemap.subtitle_userrights_property', '', $config_showtranslationcode); ?></span>
        </td>
        <td align="left">
            <select name="cboBoxRights[]" multiple="multiple" size="5">
                <option value="all" <?php if(empty($_SESSION['sitemap_box_cboBoxRights']) || $_SESSION['sitemap_box_cboBoxRights'] == 'all'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('main.multi_userrights_all', '', $config_showtranslationcode); ?></option>
<?php
            unset($sitemap_levelrights);
            if(!empty($_SESSION['sitemap_box_cboBoxRights']) && $_SESSION['sitemap_box_cboBoxRights'] != 'all')
            {
                $sitemap_levelrights = $_SESSION['sitemap_box_cboBoxRights'];
                $sitemap_levelrights = str_replace(',9', '', $sitemap_levelrights);
                $sitemap_levelrights = split_string($sitemap_levelrights, ',');
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
                            for($i = 0, $count = count($sitemap_levelrights); $i < $count; $i++)
                            {
                                if($sitemap_levelrights[$i] == $data['level_rights'])
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
                if(checkrights($main_rights_log, '9', $redirection) === true)
                {
?>
                    <option value="9" <?php if(!empty($sitemap_levelrights[0]) && $sitemap_levelrights[0] == '9'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('main.rights_superadmin_only', '', $config_showtranslationcode); echo(' '); give_translation('main.rights_superadmin', '', $config_showtranslationcode); ?></option>
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
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_status_box', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboBoxStatus">
                <option value="1" <?php if(empty($_SESSION['sitemap_box_cboBoxStatus']) || $_SESSION['sitemap_box_cboBoxStatus'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.status_enabled_box', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['sitemap_box_cboBoxStatus']) && $_SESSION['sitemap_box_cboBoxStatus'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.status_disabled_box', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td>

        </td>
        <td>
    <?php
        if(empty($_SESSION['sitemap_box_cboBox']) || $_SESSION['sitemap_box_cboBox'] == 'new')
        {
    ?>
            <input type="submit" name="bt_add_box" value="<?php give_translation('sitemap.main_bt_add', '', $config_showtranslationcode); ?>"></input>        
    <?php
        }
        else
        {
    ?>
            <input type="submit" name="bt_edit_box" value="<?php give_translation('sitemap.main_bt_edit', '', $config_showtranslationcode); ?>"></input>        
    <?php        
        }
    ?>

        </td>
    </tr>
    
<?php
    }
?>

</table></form></td>
</tr>
