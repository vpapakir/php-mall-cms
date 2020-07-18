<tr>
<td><form method="post" enctype="multipart/form-data"><table class="block_main2" width="100%">
    <tr>        
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choice_element', '', $config_showtranslationcode); ?>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <select name="cboLevelx" onchange="OnChange('bt_cboLevelx')">
                <option value="new" <?php if(empty($_SESSION['sitemap_levelx_cboLevelx']) || $_SESSION['sitemap_levelx_cboLevelx'] == 'new'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_newelement', '', $config_showtranslationcode); ?></option>
    <?php
            if(!empty($_SESSION['sitemap_add_levelx']) && $_SESSION['sitemap_add_levelx'] === true)
            {
                try
                {
                    $prepared_query = 'SELECT id_hierarchy_box_content FROM hierarchy_box_content
                                       WHERE id_hierarchy_box = :box
                                       AND family_hierarchy_box_content = "main"';
                    if(empty($config_module_immo) || $config_module_immo == 9)
                    {
                        $prepared_query .= ' AND family_hierarchy_box_content = "main"';
                    }
                    else
                    {
                        $prepared_query .= ' AND (family_hierarchy_box_content = "main"';

                        if(!empty($config_module_immo) && $config_module_immo == 1)
                        {
                           $prepared_query .= ' OR family_hierarchy_box_content = "immo"';
                        }

                        $prepared_query .= ')';
                    }
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('box', htmlspecialchars($_SESSION['sitemap_box_cboBox'], ENT_QUOTES));
                    $query->execute();

                    $i = 0;

                    while($data = $query->fetch())
                    {
                        $id_levelx[$i] = $data[0];
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
                $id_levelx = $_SESSION['sitemap_levelx_idbox'];
            }


            if(!empty($id_levelx[0]) && $id_levelx[0] != null)
            {
                for($i = 0, $count = count($id_levelx); $i < $count; $i++)
                {
                    try
                    {
                        $prepared_query = 'SELECT * FROM hierarchy_box_content
                                           WHERE id_hierarchy_box_content = :levelx';
                        if(empty($config_module_immo) || $config_module_immo == 9)
                        {
                            $prepared_query .= ' AND family_hierarchy_box_content = "main"';
                        }
                        else
                        {
                            $prepared_query .= ' AND (family_hierarchy_box_content = "main"';

                            if(!empty($config_module_immo) && $config_module_immo == 1)
                            {
                               $prepared_query .= ' OR family_hierarchy_box_content = "immo"';
                            }

                            $prepared_query .= ')';
                        }
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('levelx', $id_levelx[$i]);
                        $query->execute();

                        if(($data = $query->fetch()) != false)
                        {                      
    ?>
                            <option value="<?php echo($data[0]); ?>" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelx']) && $_SESSION['sitemap_levelx_cboLevelx'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>
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
            }
    ?>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboLevelx" type="submit" name="bt_cboLevelx" value="Choix Level X"></input>
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_firstlevelattribution_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input style="width: 50px;" type="text" name="txtLevelxReference" value="<?php if(!empty($_SESSION['sitemap_levelx_txtLevelxReference'])){ echo($_SESSION['sitemap_levelx_txtLevelxReference']); } ?>"></input>
    <?php
            if(!empty($_SESSION['msg_sitemap_levelx_txtLevelxReference']))
            {
    ?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_levelx_txtLevelxReference']); ?></div>    
    <?php
            }
    ?>    
        </td> 
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_position_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <input style="width: 50px;" type="text" name="txtLevelxPosition" value="<?php if(!empty($_SESSION['sitemap_levelx_txtLevelxPosition'])){ echo($_SESSION['sitemap_levelx_txtLevelxPosition']); } ?>"></input>
    <?php
            if(!empty($_SESSION['msg_sitemap_levelx_txtLevelxPosition']))
            {
    ?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_levelx_txtLevelxPosition']); ?></div>    
    <?php
            }
    ?>    
        </td> 
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choicetype_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxType">
                <option value="select" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxType']) || $_SESSION['sitemap_levelx_cboLevelxType'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_choicetype_element', '', $config_showtranslationcode); ?></option>
                <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Bouton">
    <?php
                try
                {
                    $prepared_query = 'SELECT * FROM style_button 
                                       ORDER BY name_button';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();

                    while($data = $query->fetch())
                    {
    ?>
                        <option style="background-color: white;" value="button<?php echo($data[0]); ?>"
                        <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'button'.$data[0]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($data['name_button']); ?></option>
    <?php                    
                    }
                    $query->closeCursor();

    ?>
                    </optgroup>

                    <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Lien">
    <?php
    //                $prepared_query = 'SHOW COLUMNS FROM style_font';
    //                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    //                $query = $connectData->prepare($prepared_query);
    //                $query->execute();
    //                $i = 0;
    //    
    //                while($data = $query->fetch())
    //                {
    //                    if($i > 2)
    //                    {
    ?>
    <!--                        <option style="background-color: white;" value="<?php //echo($data[0]); ?>" <?php //if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == $data[0]){ echo('selected'); }else{ echo(null); } ?>><?php //echo($data[0]); ?></option>    -->
    <?php 
    //                    }
    //                    $i++;
    //                }
    //                $query->closeCursor();
    ?>
                        <option style="background-color: white;" value="link_title" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_title'){ echo('selected'); }else{ echo(null); } ?>>Titre</option>
                        <option style="background-color: white;" value="link_intro" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_intro'){ echo('selected'); }else{ echo(null); } ?>>Introduction</option>
                        <option style="background-color: white;" value="link_desc" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_desc'){ echo('selected'); }else{ echo(null); } ?>>Description</option>
                        <option style="background-color: white;" value="link_subtitle" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_subtitle'){ echo('selected'); }else{ echo(null); } ?>>Sous-titre</option>
                        <option style="background-color: white;" value="link_main" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_main'){ echo('selected'); }else{ echo(null); } ?>>Texte</option>
                        <option style="background-color: white;" value="link_comment" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_comment'){ echo('selected'); }else{ echo(null); } ?>>Commentaire</option>
                        <option style="background-color: white;" value="link_boxstyle1" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_boxstyle1'){ echo('selected'); }else{ echo(null); } ?>>BlockStyle1</option>
                        <option style="background-color: white;" value="link_boxstyle2" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_boxstyle2'){ echo('selected'); }else{ echo(null); } ?>>BlockStyle2</option>
                        <option style="background-color: white;" value="link_boxstyle3" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_boxstyle3'){ echo('selected'); }else{ echo(null); } ?>>BlockStyle3</option>
                        <option style="background-color: white;" value="link_error1" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_error1'){ echo('selected'); }else{ echo(null); } ?>>Error1</option>
                        <option style="background-color: white;" value="link_error2" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_error2'){ echo('selected'); }else{ echo(null); } ?>>Error2</option>
                        <option style="background-color: white;" value="link_error3" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_error3'){ echo('selected'); }else{ echo(null); } ?>>Error3</option>
                        <option style="background-color: white;" value="link_info1" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_info1'){ echo('selected'); }else{ echo(null); } ?>>Info1</option>
                        <option style="background-color: white;" value="link_info2" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_info2'){ echo('selected'); }else{ echo(null); } ?>>Info2</option>
                        <option style="background-color: white;" value="link_info3" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxType']) && $_SESSION['sitemap_levelx_cboLevelxType'] == 'link_info3'){ echo('selected'); }else{ echo(null); } ?>>Info3</option>
                    </optgroup>
    <?php                
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
            if(!empty($_SESSION['msg_sitemap_levelx_cboLevelxType']))
            {
    ?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_sitemap_levelx_cboLevelxType']); ?></div>    
    <?php
            }
    ?>
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choicefamily_levelx', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxFamily">
                <option value="main" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxFamily']) || $_SESSION['sitemap_levelx_cboLevelxFamily'] == 'main'){ echo('selected="selected"'); } ?>><?php give_translation('main.dd_hierarchy_family_main', '', $config_showtranslationcode); ?></option>
                <option value="---" disabled="disabled">---</option>
<?php
                if(!empty($config_module_immo) && $config_module_immo == 1)
                {
?>
                    <option value="immo" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxFamily']) && $_SESSION['sitemap_levelx_cboLevelxFamily'] == 'immo'){ echo('selected="selected"'); } ?>><?php give_translation('main.dd_hierarchy_family_immo', '', $config_showtranslationcode); ?></option>
<?php
                }
?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
<?php
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
?>
        <tr>
            <td align="left" colspan="2"><table class="block_expand_levelx<?php echo($main_activatedidlang[$i]) ?>" width="100%" border="0">
                <tr>
                    <td align="left">
                        <table id="collapse_levelx<?php echo($main_activatedidlang[$i]) ?>"
<?php
                            if(empty($_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]]) || $_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]] == 'false')
                            {
                                echo('class="block_collapsetitle1"');
                            }
                            else
                            {
                                echo('class="block_expandtitle1"');
                            }
?>
                             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_levelx<?php echo($main_activatedidlang[$i]) ?>', 'img_expand_levelx<?php echo($main_activatedidlang[$i]) ?>', 'expand_collapse_levelx<?php echo($main_activatedidlang[$i]) ?>', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapse_levelx<?php echo($main_activatedidlang[$i]) ?>');" style="cursor: pointer;">
                            <td align="left">                    
<?php
                                    if(empty($_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]]) || $_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]] == 'false')
                                    {
?>
                                        <img id="img_expand_levelx<?php echo($main_activatedidlang[$i]) ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                                    }
                                    else
                                    {
?>
                                        <img id="img_expand_levelx<?php echo($main_activatedidlang[$i]) ?>" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                                    }
?>                    
                            </td>
                            <td width="100%" align="left">
                                <span>
                                    &nbsp;<?php echo(give_translation($main_activatedcodelang[$i], $echo, $config_showtranslationcode)); ?>
                                </span>
                            </td>
                            <td align="left"></td>
                        </table>
                        <input id="expand_collapse_levelx<?php echo($main_activatedidlang[$i]) ?>" style="display: none;" type="hidden" name="expand_collapse_levelx<?php echo($main_activatedidlang[$i]) ?>" value="<?php if(empty($_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]]) || $_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
                    </td>
                </tr>
                <tr id="block_expand_levelx<?php echo($main_activatedidlang[$i]) ?>"
<?php
                    if(empty($_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]]) || $_SESSION['expand_collapse_levelx'.$main_activatedidlang[$i]] == 'false')
                    {
                        echo('style="display: none;"');
                    }
                    else
                    {
                        echo(null);
                    }
?>
                    >
                    <td align="left">
                        <table width="100%" cellpadding="0" cellspacing="1">
                            <tr>
                                <td align="left">
                                    <span class="font_subtitle"><?php give_translation('sitemap.subtitle_name_element', '', $config_showtranslationcode); ?></span>
                                </td>
                                <td align="left" width="<?php echo($right_column_width); ?>">
                                    <input type="text" name="txtLevelxTitle<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]])){ echo($_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]]); } ?>"></input>
        <?php
                                if(!empty($_SESSION['msg_sitemap_levelx_txtLevelxTitle']) && $i == 0)
                                {
        ?>
                                    <br clear="left"/>
                                    <div class="font_error1"><?php echo($_SESSION['msg_sitemap_levelx_txtLevelxTitle']); ?></div>    
        <?php
                                }
        ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2"  align="center" style="border-top: 1px dashed lightgrey;"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>
                            <tr>
                                <td class="font_subtitle">
                                   <span class="font_subtitle"><?php give_translation('sitemap.subtitle_image_normal', '', $config_showtranslationcode); ?></span>
                                </td>
                                <td>
                                   <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                                   <input type="file" name="upload_sitemap_content_normal_L<?php echo($main_activatedidlang[$i]); ?>"></input>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]]))
                            {
?>
                                   <input type="submit" name="bt_delete_levelx_imagelink_normal_L<?php echo($main_activatedidlang[$i]); ?>" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"/>
<?php
                            }
?>
                                   <br clear="left">
                                   <div class="font_info1">
<?php 
                                    if(!empty($_SESSION['msg_sitemap_upload_content_normal_L'.$main_activatedidlang[$i]]))
                                    { 
                                        echo($_SESSION['msg_sitemap_upload_content_normal_L'.$main_activatedidlang[$i]]); 
                                    } 
?>
                                    </div>
                                </td>
                            </tr>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]]))
                            {
?>
                                <tr>
                                    <td align="left" colspan="2">
                                        <img src="<?php echo($config_customheader.$_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]]) ?>" alt="<?php echo(str_replace('normal/', '', strstr($_SESSION['sitemap_levelx_imageNormal_L'.$main_activatedidlang[$i]], 'normal/'))); ?>"/>
                                    </td>
                                </tr>
<?php
                            }
?>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2"  align="center" style="border-top: 1px dashed lightgrey;"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>
                            <tr>
                                <td class="font_subtitle">
                                   <span class="font_subtitle"><?php give_translation('sitemap.subtitle_image_hover', '', $config_showtranslationcode); ?></span>
                                </td>
                                <td>
                                   <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                                   <input type="file" name="upload_sitemap_content_hover_L<?php echo($main_activatedidlang[$i]); ?>"></input>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]]))
                            {
?>
                                   <input type="submit" name="bt_delete_levelx_imagelink_hover_L<?php echo($main_activatedidlang[$i]); ?>" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"/>
<?php
                            }
?>
                                   <br clear="left">
                                   <div class="font_info1">
<?php 
                                    if(!empty($_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]]))
                                    { 
                                        echo($_SESSION['msg_sitemap_upload_content_hover_L'.$main_activatedidlang[$i]]); 
                                    } 
?>
                                    </div>
                                </td>
                            </tr>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]]))
                            {
?>
                                <tr>
                                    <td align="left" colspan="2">
                                        <img src="<?php echo($config_customheader.$_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]]) ?>" alt="<?php echo(str_replace('hover/', '', strstr($_SESSION['sitemap_levelx_imageHover_L'.$main_activatedidlang[$i]], 'hover/'))); ?>"/>                                       
                                    </td>
                                </tr>
<?php
                            }
?>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>    
                            <tr>
                                <td colspan="2"  align="center" style="border-top: 1px dashed lightgrey;"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="height: 4px;"></div></td>
                            </tr>
                            <tr>
                                <td class="font_subtitle">
                                   <span class="font_subtitle"><?php give_translation('sitemap.subtitle_image_active', '', $config_showtranslationcode); ?></span>
                                </td>
                                <td>
                                   <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                                   <input type="file" name="upload_sitemap_content_active_L<?php echo($main_activatedidlang[$i]); ?>"></input>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]]))
                            {
?>
                                   <input type="submit" name="bt_delete_levelx_imagelink_active_L<?php echo($main_activatedidlang[$i]); ?>" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"/>
<?php
                            }
?>
                                   <br clear="left">
                                   <div class="font_info1">
<?php 
                                    if(!empty($_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]]))
                                    { 
                                        echo($_SESSION['msg_sitemap_upload_content_active_L'.$main_activatedidlang[$i]]); 
                                    } 
?>
                                    </div>
                                </td>
                            </tr>
<?php
                            if(!empty($_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]]))
                            {
?>
                                <tr>
                                    <td align="left" colspan="2">
                                        <img src="<?php echo($config_customheader.$_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]]) ?>" alt="<?php echo(str_replace('active/', '', strstr($_SESSION['sitemap_levelx_imageActive_L'.$main_activatedidlang[$i]], 'active/'))); ?>"/>
                                    </td>
                                </tr>
<?php
                            }
?>
                        </table>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
<?php

    }

    if(!empty($_SESSION['sitemap_levelx_txtLevelxMargin']))
    {
        $margin_levelx = split_string($_SESSION['sitemap_levelx_txtLevelxMargin'], '$');
        
        if(empty($margin_levelx[0]) ? $margin_levelx[0] = 0 : $margin_levelx[0] = $margin_levelx[0]);
        if(empty($margin_levelx[1]) ? $margin_levelx[1] = 0 : $margin_levelx[1] = $margin_levelx[1]);
        if(empty($margin_levelx[2]) ? $margin_levelx[2] = 0 : $margin_levelx[2] = $margin_levelx[2]);
        if(empty($margin_levelx[3]) ? $margin_levelx[3] = 0 : $margin_levelx[3] = $margin_levelx[3]);
    }
    else
    {
        $margin_levelx[0] = 0;
        $margin_levelx[1] = 0;
        $margin_levelx[2] = 0;
        $margin_levelx[3] = 0;
    }
?>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_margin_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <span class="font_subtitle"><?php give_translation('sitemap.margin_left_element', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtLevelxMarginL" value="<?php if(!empty($margin_levelx[3])){ echo($margin_levelx[3]); } ?>"></input>&nbsp;
            <span class="font_subtitle"><?php give_translation('sitemap.margin_right_element', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtLevelxMarginR" value="<?php if(!empty($margin_levelx[1])){ echo($margin_levelx[1]); } ?>"></input>&nbsp;
            <span class="font_subtitle"><?php give_translation('sitemap.margin_top_element', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtLevelxMarginT" value="<?php if(!empty($margin_levelx[0])){ echo($margin_levelx[0]); } ?>"></input>&nbsp;      
            <span class="font_subtitle"><?php give_translation('sitemap.margin_bottom_element', '', $config_showtranslationcode); ?></span>&nbsp;<input style="width: 30px;" type="text" name="txtLevelxMarginB" value="<?php if(!empty($margin_levelx[2])){ echo($margin_levelx[2]); } ?>"></input>&nbsp;
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_aligntitle_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxTitleAlign">
                <option style="text-align: left;" value="left" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxTitleAlign']) || $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] == 'left'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_left_element', '', $config_showtranslationcode); ?></option>
                <option style="text-align: center;" value="center" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTitleAlign']) && $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] == 'center'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_center_element', '', $config_showtranslationcode); ?></option>
                <option style="text-align: right;" value="right" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTitleAlign']) && $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] == 'right'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_right_element', '', $config_showtranslationcode); ?></option>
                <option style="text-align: justify;" value="justify" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTitleAlign']) && $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] == 'justify'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.aligntitle_justify_element', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_link_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxTypeLink" onchange="OnChange('bt_cboLevelxTypeLink')">
                <option value="select" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) || $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_choicelink_element', '', $config_showtranslationcode); ?></option>
                <option value="page" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'page'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_page_element', '', $config_showtranslationcode); ?></option>
                <option value="script" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'script'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_script_element', '', $config_showtranslationcode); ?></option>
                <option value="url" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'url'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.link_url_element', '', $config_showtranslationcode); ?></option>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboLevelxTypeLink" type="submit" name="bt_cboLevelxTypeLink" value="Choix Type de lien levelx"></input>
        </td>
    </tr>
    
<?php
    if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'script')
    {
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkscriptpath_element', '', $config_showtranslationcode); ?>
            </td>
            <td>
                <input type="text" name="txtLevelxScriptPath" value="<?php if(!empty($_SESSION['sitemap_levelx_txtLevelxLink'])){ echo($_SESSION['sitemap_levelx_txtLevelxLink']); } ?>"></input>
            </td>       
        </tr>
<?php    
    }
    
    if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'url')
    {
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkurl_element', '', $config_showtranslationcode); ?>
            </td>
            <td>
                <input type="text" name="txtLevelxURL" value="<?php if(!empty($_SESSION['sitemap_levelx_txtLevelxLink'])){ echo($_SESSION['sitemap_levelx_txtLevelxLink']); } ?>"></input>
            </td>
        </tr>
<?php
    }
    
    if(!empty($_SESSION['sitemap_levelx_cboLevelxTypeLink']) && $_SESSION['sitemap_levelx_cboLevelxTypeLink'] == 'page')
    {        
?>
        <tr>
            <td class="font_subtitle">
                <?php give_translation('sitemap.subtitle_linkpage_element', '', $config_showtranslationcode); ?>
                &nbsp;
                [<a class="link_main" href="<?php echo($config_customheader); change_link($link_newpage_sitemap[0], $link_newpage_sitemap[1]) ?>"><?php give_translation('sitemap.linkpage_newpage_element', '', $config_showtranslationcode); ?></a>]
            </td>
            <td>
                <select name="cboLevelxPage">
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
                            $sitemap_name_listingpage_element = cut_string($data['L'.$main_id_language], 0, 20, '...');
                        }
    ?>
                        <option style="background-color: white;" value="<?php echo($data[0]); ?>" title="<?php echo($data['L'.$main_id_language]); ?>"
                        <?php if(!empty($_SESSION['sitemap_levelx_txtLevelxLink']) && $_SESSION['sitemap_levelx_txtLevelxLink'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>
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
            <?php give_translation('sitemap.subtitle_target_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxTarget">
                <option value="_self" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxTarget']) || $_SESSION['sitemap_levelx_cboLevelxTarget'] == '_self'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_samewindow_element', '', $config_showtranslationcode); ?></option>
                <option value="_blank" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTarget']) && $_SESSION['sitemap_levelx_cboLevelxTarget'] == '_blank'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_newtab_element', '', $config_showtranslationcode); ?></option>
                <option value="_top" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTarget']) && $_SESSION['sitemap_levelx_cboLevelxTarget'] == '_top'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_newwindow_element', '', $config_showtranslationcode); ?></option>
                <option value="_parent" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxTarget']) && $_SESSION['sitemap_levelx_cboLevelxTarget'] == '_parent'){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.target_parent_element', '', $config_showtranslationcode); ?></option>
            </select>
        </td>          
    </tr>
    <tr>
        <td align="left" style="vertical-align: top;">
            <span class="font_subtitle"><?php give_translation('sitemap.subtitle_userrights_property', '', $config_showtranslationcode); ?></span>
        </td>
        <td align="left">
            <select name="cboLevelxRights[]" multiple="multiple" size="5">
                <option value="all" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxRights']) || $_SESSION['sitemap_levelx_cboLevelxRights'] == 'all'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('main.multi_userrights_all', '', $config_showtranslationcode); ?></option>
<?php
            unset($sitemap_levelrights);
            if(!empty($_SESSION['sitemap_levelx_cboLevelxRights']) && $_SESSION['sitemap_levelx_cboLevelxRights'] != 'all')
            {
                $sitemap_levelrights = $_SESSION['sitemap_levelx_cboLevelxRights'];
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
            <?php give_translation('sitemap.subtitle_status_element', '', $config_showtranslationcode); ?>
        </td>
        <td>
            <select name="cboLevelxStatus">
                <option value="1" <?php if(empty($_SESSION['sitemap_levelx_cboLevelxStatus']) || $_SESSION['sitemap_levelx_cboLevelxStatus'] == 1){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.status_enabled_element', '', $config_showtranslationcode); ?></option>
                <option value="9" <?php if(!empty($_SESSION['sitemap_levelx_cboLevelxStatus']) && $_SESSION['sitemap_levelx_cboLevelxStatus'] == 9){ echo('selected'); }else{ echo(null); } ?>><?php give_translation('sitemap.status_disabled_element', '', $config_showtranslationcode); ?></option>
            </select>
        </td>
    </tr>    
    <tr>
        <td>

        </td>
        <td>
    <?php
        if(empty($_SESSION['sitemap_levelx_cboLevelx']) || $_SESSION['sitemap_levelx_cboLevelx'] == 'new')
        {
    ?>
            <input type="submit" name="bt_add_levelx" value="<?php give_translation('sitemap.main_bt_add', '', $config_showtranslationcode); ?>"></input>        
    <?php
        }
        else
        {
    ?>
            <input type="submit" name="bt_edit_levelx" value="<?php give_translation('sitemap.main_bt_edit', '', $config_showtranslationcode); ?>"></input>   
            <input type="submit" name="bt_delete_levelx" value="<?php give_translation('main.bt_delete', '', $config_showtranslationcode); ?>"></input>        
    <?php        
        }
    ?>

        </td>
    </tr>

</table></form></td>
</tr>
