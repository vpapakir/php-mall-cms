<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseCDRgeoCity"
<?php
                if(empty($_SESSION['expand_collapseCDRgeoCity']) || $_SESSION['expand_collapseCDRgeoCity'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseCDRgeoCity', 'img_expand_collapseCDRgeoCity', 'expand_collapseCDRgeoCity', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseCDRgeoCity');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_collapseCDRgeoCity']) || $_SESSION['expand_collapseCDRgeoCity'] == 'false')
                        {
?>
                            <img id="img_expand_collapseCDRgeoCity" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseCDRgeoCity" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        Ville/Code Postal
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_collapseCDRgeoCity" style="display: none;" type="hidden" name="expand_collapseCDRgeoCity" value="<?php if(empty($_SESSION['expand_collapseCDRgeoCity']) || $_SESSION['expand_collapseCDRgeoCity'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseCDRgeoCity"
<?php
        if(empty($_SESSION['expand_collapseCDRgeoCity']) || $_SESSION['expand_collapseCDRgeoCity'] == 'false')
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
                        <span class="font_subtitle">Recherche - Ville/CP</span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <input id="txtSearchCDRgeoCity" type="text" name="txtSearchCDRgeoCity" onKeyUp="requestGEOEDITCity();"/>
                        <span id="ajaxloaderCDRgeoCity" style="display: none;">
                            <img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" />
                        </span>
                        <!--[if lte IE 7]>
                        <div id="SearchDIVCDRgeoCity" style="position: relative; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoCity" style="list-style-type: none;"></span>
                        </div>
                        <![endif]-->
                        <!--[if !IE]><!-->
                        <div id="SearchDIVCDRgeoCity" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoCity" style="list-style-type: none;"></span>
                        </div>
                         <!--<![endif]-->
                         <!--[if gte IE 8]>
                        <div id="SearchDIVCDRgeoCity" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white; overflow: auto; -overflow-y: scroll;
                                                             -overflow-x:hidden; height: 100px;">
                            <span id="SearchResultCDRgeoCity" style="list-style-type: none;"></span>
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
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Code Postal</span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtZipCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtZipCDRgeoCity'])){ echo($_SESSION['cdrgeo_txtZipCDRgeoCity']); } ?>"/>
                    </td>
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
                        <input type="text" name="txtNameCDRgeoCity<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['cdrgeo_txtNameCDRgeoCity'.$main_activatedidlang[$i]])){ echo($_SESSION['cdrgeo_txtNameCDRgeoCity'.$main_activatedidlang[$i]]); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_cdrgeo_txtNameCDRgeoCity']) && $i == 0)
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_cdrgeo_txtNameCDRgeoCity']); ?></div>
<?php
                    }
?>                     
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
                       Image - ville
                    </td>
                    <td>
                       <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                       <input type="file" name="upload_cdrgeo_city"></input>
                       <br clear="left">
                       <div class="font_info1">
        <?php 
                        if(!empty($_SESSION['msg_cdrgeo_upload_city']))
                        { 
                            echo(check_session_input($_SESSION['msg_cdrgeo_upload_city'])); 
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
                    $query->bindParam('id', $_SESSION['cdrgeo_hiddenidCDRgeoCity']);
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
                                                <input style="width: 100%;" type="text" name="txtActNameImageCDRgeoCity" value="<?php echo($data['name_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font_main">
                                                Alt 
                                            </td>
                                            <td class="font_main">
                                                <input style="width: 100%;" type="text" name="txtActAltImageCDRgeoCity" value="<?php echo($data['alt_image']); ?>"></input>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" name="bt_delete_image_city" value="Supprimer"/>
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
                        <span class="font_subtitle">Attribuer à l'arrondissement</span>
                    </td>
                    <td align="left">
                        <select name="cboDistrictCDRgeoCity">
                            <option value="select" 
                                <?php if(empty($_SESSION['cdrgeo_cboDistrictCDRgeoCity']) || $_SESSION['cdrgeo_cboDistrictCDRgeoCity'] == 'select'){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >--- sélectionner ---</option>
<?php
                    try
                        {
                            $prepared_query = 'SELECT cdrgeo.id_cdrgeo, cdrgeo.L'.$main_id_language.', geo_dep.L'.$main_id_language.' FROM cdrgeo
                                               INNER JOIN cdrgeo AS geo_dep
                                               ON cdrgeo.parentdepartment_cdrgeo = geo_dep.id_cdrgeo
                                               WHERE cdrgeo.statusobject_cdrgeo = 1
                                               AND cdrgeo.parentdepartment_cdrgeo > 0
                                               ORDER BY cdrgeo.L'.$main_id_language;
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();

                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data[0]); ?>"
                                    <?php if(!empty($_SESSION['cdrgeo_cboDistrictCDRgeoCity']) && $_SESSION['cdrgeo_cboDistrictCDRgeoCity'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>    
                                        ><?php echo($data[1].' ('.$data[2].')'); ?></option>
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
<?php
                    if(!empty($_SESSION['msg_cdrgeo_cboDistrictCDRgeoCity']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_cdrgeo_cboDistrictCDRgeoCity']); ?></div>
<?php
                    }
?>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Geolocalisation</span>
                    </td>
                    <td align="left">
                        <span class="font_main">Lat.</span>
                        &nbsp;
                        <input style="width: 90px;" type="text" name="txtLatitudeCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtLatitudeCDRgeoCity'])){ echo($_SESSION['cdrgeo_txtLatitudeCDRgeoCity']); } ?>" />  
                        &nbsp;
                        <span class="font_main">Long.</span>
                        &nbsp;
                        <input style="width: 90px;" type="text" name="txtLongitudeCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtLongitudeCDRgeoCity'])){ echo($_SESSION['cdrgeo_txtLongitudeCDRgeoCity']); } ?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Code INSEE</span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtINSEECDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtINSEECDRgeoCity'])){ echo($_SESSION['cdrgeo_txtINSEECDRgeoCity']); } ?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Population</span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtPopulationCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtPopulationCDRgeoCity'])){ echo($_SESSION['cdrgeo_txtPopulationCDRgeoCity']); } ?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Taxe d'habitation</span>
                    </td>
                    <td align="left">
                        <input type="text" name="txtTaxhabCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_txtTaxhabCDRgeoCity'])){ echo($_SESSION['cdrgeo_txtTaxhabCDRgeoCity']); } ?>"/>
                    </td>
                </tr>
<?php   
            try
            {
                #TYPE CITY
                $prepared_query = 'SELECT * FROM cdreditor
                                   WHERE code_cdreditor = "cdreditor_typecity_cdrgeo"
                                   ORDER BY position_cdreditor, L'.$main_id_language.'S';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                //$query->bindParam('code', 'cdreditor.type_object');
                $query->execute();
                $i = 0;

                while($data = $query->fetch())
                {
                    $cdrgeo_id_typecity[$i] = $data['id_cdreditor'];
                    $cdrgeo_code_typecity = $data['code_cdreditor'];
                    $cdrgeo_status_typecity = $data['status_cdreditor'];
                    $cdrgeo_statusobject_typecity[$i] = $data['statusobject_cdreditor'];
                    $cdrgeo_type_typecity = $data['type_cdreditor'];
                    $cdrgeo_nameS_typecity[$i] = $data['L'.$main_id_language.'S'];
                    $cdrgeo_nameP_typecity[$i] = $data['L'.$main_id_language.'P'];
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

            #type city
            if($cdrgeo_status_typecity == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Type</span>
                    </td>
                    <td align="left">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($cdrgeo_type_typecity, $cdrgeo_nameS_typecity, $cdrgeo_code_typecity, $cdrgeo_statusobject_typecity, $cdrgeo_id_typecity, $_SESSION['cdrgeo_cdreditor_typecity_cdrgeo'], false);                                      
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
                        <span class="font_subtitle">Notes</span>
                    </td>
                    <td align="left">
                        <textarea style="width: 100%;" name="areaRemarkCDRgeoCity"><?php if(!empty($_SESSION['cdrgeo_areaRemarkCDRgeoCity'])){ echo($_SESSION['cdrgeo_areaRemarkCDRgeoCity']); } ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">Statut</span>
                    </td>
                    <td align="left">
                        <select name="cboStatusCDRgeoCity">
                            <option value="1"
                                <?php if(empty($_SESSION['cdrgeo_cboStatusCDRgeoCity']) || $_SESSION['cdrgeo_cboStatusCDRgeoCity'] == 1){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Activé</option>
                            <option value="9"
                                <?php if(!empty($_SESSION['cdrgeo_cboStatusCDRgeoCity']) && $_SESSION['cdrgeo_cboStatusCDRgeoCity'] == 9){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    >Désactivé</option>
                        </select>
                        <input style="display: none;" hidden="hidden" type="text" name="hiddenidCDRgeoCity" value="<?php if(!empty($_SESSION['cdrgeo_hiddenidCDRgeoCity'])){ echo($_SESSION['cdrgeo_hiddenidCDRgeoCity']); } ?>"/>
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
                                if(empty($_SESSION['cdrgeo_edit_button_city']))
                                {
?>
                                    <input type="submit" name="bt_add_city_geo" value="Ajouter"/>
<?php
                                }
                                else
                                {
?>
                                    <input type="submit" name="bt_edit_city_geo" value="Sauvegarder"/>
<?php
                                }
?>
<!--                                <input type="submit" name="bt_new_CDRgeoCity" value="Nouveau"/>-->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
        </table></td>
    </tr>
</table></td>
</tr>
            
            
