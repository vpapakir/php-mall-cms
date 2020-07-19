<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseCDRgeoRegion"
<?php
                if(empty($_SESSION['expand_collapseCDRgeoRegion']) || $_SESSION['expand_collapseCDRgeoRegion'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseCDRgeoRegion', 'img_expand_collapseCDRgeoRegion', 'expand_collapseCDRgeoRegion', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseCDRgeoRegion');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseCDRgeoRegion']) || $_SESSION['expand_collapseCDRgeoRegion'] == 'false')
                        {
?>
                            <img id="img_expand_collapseCDRgeoRegion" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseCDRgeoRegion" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        Région
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseCDRgeoRegion" style="display: none;" type="hidden" name="expand_collapseCDRgeoRegion" value="<?php if(empty($_SESSION['expand_collapseCDRgeoRegion']) || $_SESSION['expand_collapseCDRgeoRegion'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseCDRgeoRegion"
<?php
        if(empty($_SESSION['expand_collapseCDRgeoRegion']) || $_SESSION['expand_collapseCDRgeoRegion'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        > 
        <td align="left"><table width="100%" border="0">
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Recherche - Région</span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <input id="txtSearchCDRgeoRegion" type="text" name="txtSearchCDRgeoRegion" onKeyUp="requestGEOEDITRegion();"/>
                        <span id="ajaxloaderCDRgeoRegion" style="display: none;">
                            <img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" />
                        </span>
                        <!--[if lte IE 7]>
                        <div id="SearchDIVCDRgeoRegion" style="position: relative; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoRegion" style="list-style-type: none;"></span>
                        </div>
                        <![endif]-->
                        <!--[if !IE]><!-->
                        <div id="SearchDIVCDRgeoRegion" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoRegion" style="list-style-type: none;"></span>
                        </div>
                         <!--<![endif]-->
                         <!--[if gte IE 8]>
                        <div id="SearchDIVCDRgeoRegion" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoRegion" style="list-style-type: none;"></span>
                        </div>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
<?php
            for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation($main_activatedcodelang[$i]); ?></span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtNameCDRgeoRegion<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['cdrgeo_txtNameCDRgeoRegion'.$main_activatedidlang[$i]])){ echo($_SESSION['cdrgeo_txtNameCDRgeoRegion'.$main_activatedidlang[$i]]); } ?>"/>
                    </td>
                </tr>              
<?php
            }
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td class="font_subtitle">
                       Image - Région
                    </td>
                    <td>
                       <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                       <input type="file" name="upload_cdrgeo_region"></input>
                       <br clear="left">
                       <div class="font_info1">
        <?php 
                        if(!empty($_SESSION['msg_cdrgeo_upload_region']))
                        { 
                            echo(check_session_input($_SESSION['msg_cdrgeo_upload_region'])); 
                        } 
        ?>
                        </div>
                    </td>
                </tr>

        <?php
                try
                {
                    $prepared_query = 'SELECT * FROM cdrgeo_image
                                       WHERE id_cdrgeo = :id
                                       ORDER BY date_image DESC';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $_SESSION['cdrgeo_hiddenidCDRgeoRegion']);
                    $query->execute(); 

                    if(($data = $query->fetch()) != false)
                    {
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
        ?>
                            <tr>
                            <td colspan="2"><table width="100%">
                                <tr>
                                    <td><table width="100%">
                                        <tr>    
                                        <td>

                                        </td>
                                        <td>
                                            <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: none;"></img></a>
                                        </td>
                                        </tr>
                                    </table></td>
                                
                                    <td width="<?php echo($right_column_width); ?>" style="vertical-align: top;"><table width="100%">
                                        <tr>
                                            <td class="font_main" width="30%">
                                                Nom
                                            </td>
                                            <td class="font_main">
                                                <input style="width: 100%;" type="text" name="txtActNameImageCDRgeoRegion" value="<?php echo($data['name_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font_main">
                                                Alt 
                                            </td>
                                            <td class="font_main">
                                                <input style="width: 100%;" type="text" name="txtActAltImageCDRgeoRegion" value="<?php echo($data['alt_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" name="bt_delete_image_region" value="Supprimer"/>
                                            </td>
                                        </tr>
                                    </table></td>
                                </tr>

                            </table></td>
                            </tr>
        <?php                
                        }
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
                        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                    }
                }
?>  
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Attribuer au pays</span>
                    </td>
                    <td align="left">
                        <select name="cboCountryCDRgeoRegion">
                            <option value="select" 
                                <?php if(empty($_SESSION['cdrgeo_cboCountryCDRgeoRegion']) || $_SESSION['cdrgeo_cboCountryCDRgeoRegion'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >--- sélectionner ---</option>
<?php
                    try
                        {
                            $prepared_query = 'SELECT id_cdrgeo, L'.$main_id_language.'
                                               FROM cdrgeo
                                               WHERE statusobject_cdrgeo = 1
                                               AND parentdistrict_cdrgeo IS NULL
                                               AND parentdepartment_cdrgeo IS NULL
                                               AND parentregion_cdrgeo IS NULL
                                               AND parentcountry_cdrgeo IS NULL
                                               ORDER BY cdrgeo.L'.$main_id_language;
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();

                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data[0]); ?>"
                                    <?php if(!empty($_SESSION['cdrgeo_cboCountryCDRgeoRegion']) && $_SESSION['cdrgeo_cboCountryCDRgeoRegion'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                        ><?php echo($data[1]); ?></option>
<?php
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
                    <td align="left">
                        <span class="font_subtitle">Statut</span>
                    </td>
                    <td align="left">
                        <select name="cboStatusCDRgeoRegion">
                            <option value="1"
                                <?php if(empty($_SESSION['cdrgeo_cboStatusCDRgeoRegion']) || $_SESSION['cdrgeo_cboStatusCDRgeoRegion'] == 1){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Activé</option>
                            <option value="9"
                                <?php if(!empty($_SESSION['cdrgeo_cboStatusCDRgeoRegion']) && $_SESSION['cdrgeo_cboStatusCDRgeoRegion'] == 9){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Désactivé</option>
                        </select>
                        <input type="hidden" name="hiddenidCDRgeoRegion" value="<?php if(!empty($_SESSION['cdrgeo_hiddenidCDRgeoRegion'])){ echo($_SESSION['cdrgeo_hiddenidCDRgeoRegion']); } ?>"/>
                    </td>
                </tr>
                <tr>
                    <td><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                        <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                            <tr>
                                <td align="center">
<?php
                                if(empty($_SESSION['cdrgeo_edit_button_region']))
                                {
?>
                                    <input type="submit" name="bt_add_region_geo" value="Ajouter"/>
<?php
                                }
                                else
                                {
?>
                                    <input type="submit" name="bt_edit_region_geo" value="Sauvegarder"/>
<?php
                                }
?>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
        </table></td>
    </tr>
</table></td>
</tr>
            
            
