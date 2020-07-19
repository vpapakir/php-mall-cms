<?php
//include('modules/custom/immo/modules/Kprodimmo/situation/situation_getinfo.php');
?>
<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseKprodSituation"
<?php
                if(empty($_SESSION['expand_Kprodimmo_situation']) || $_SESSION['expand_Kprodimmo_situation'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseKprodSituation', 'img_expand_collapseKprodSituation', 'expand_Kprodimmo_situation', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseKprodSituation');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_Kprodimmo_situation']) || $_SESSION['expand_Kprodimmo_situation'] == 'false')
                        {
?>
                            <img id="img_expand_collapseKprodSituation" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseKprodSituation" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('immo.block_title_situation_kproduct', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_Kprodimmo_situation" style="display: none;" type="hidden" name="expand_Kprodimmo_situation" value="<?php if(empty($_SESSION['expand_Kprodimmo_situation']) || $_SESSION['expand_Kprodimmo_situation'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseKprodSituation"
<?php
        if(empty($_SESSION['expand_Kprodimmo_situation']) || $_SESSION['expand_Kprodimmo_situation'] == 'false')
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
                      
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_city_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="70%">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <input id="txtKprodimmoCity" style="width: 200px;" type="text" name="txtKprodimmoCity" value="<?php if(!empty($_SESSION['Kprodimmo_situation_txtKprodimmoCity'])){ echo($_SESSION['Kprodimmo_situation_txtKprodimmoCity']); } ?>" onKeyUp="requestKprodimmoCity();"/><span id="ajaxloaderKprodimmoCity" style="display: none;"><img src="<?php echo($config_customheader); ?>graphics/ajaxloader/loader003.gif" alt="loader001.gif" /></span>
                                    <div id="KprodimmoCityDIV" style="position: absolute; z-index: 100; display: none; width: 200px; border: 1px solid lightgrey; padding: 1px; background-color: white;">
                                        <span id="KprodimmoCityResult" style="list-style-type: none;"></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>

<?php
                if(empty($_SESSION['Kprodimmo_situation_CityInfo']))
                {
?>
                    <tr>
                        <td colspan="2">
                            <div id="KprodimmoCityOtherInfo" style="display: none;"></div>
                        </td>
                    </tr>
<?php
                }
                else
                {
                    
                    $prepared_query = 'SELECT *
                                       FROM `cdrgeo`
                                       WHERE L'.$main_id_language.' = "'.$_SESSION['Kprodimmo_situation_CityInfo'].'"
                                       AND parentdistrict_cdrgeo IS NOT NULL';
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $ajaxcity_id_district = $data['parentdistrict_cdrgeo'];
                        $ajaxcity_zip_city = $data['zip_cdrgeo'];
                    }
                    $query->closeCursor();

                    $prepared_query = 'SELECT parentdepartment_cdrgeo, L'.$main_id_language.'
                                       FROM `cdrgeo`
                                       WHERE id_cdrgeo = :id';
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $ajaxcity_id_district);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $ajaxcity_name_district = $data[1];
                        $ajaxcity_id_department = $data[0];
                    }
                    $query->closeCursor();

                    $prepared_query = 'SELECT parentregion_cdrgeo, L'.$main_id_language.'
                                       FROM `cdrgeo`
                                       WHERE id_cdrgeo = :id';
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $ajaxcity_id_department);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $ajaxcity_name_department = $data[1];
                        $ajaxcity_id_region = $data[0];
                    }
                    $query->closeCursor();

                    $prepared_query = 'SELECT parentcountry_cdrgeo, L'.$main_id_language.'
                                       FROM `cdrgeo`
                                       WHERE id_cdrgeo = :id';
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $ajaxcity_id_region);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $ajaxcity_name_region = $data[1];
                        $ajaxcity_id_country = $data[0];
                    }
                    $query->closeCursor();

                    $prepared_query = 'SELECT L'.$main_id_language.'
                                       FROM `cdrgeo`
                                       WHERE id_cdrgeo = :id';
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $ajaxcity_id_country);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $ajaxcity_name_country = $data[0];
                    }
                    $query->closeCursor();

                    if(empty($ajaxcity_zip_city) ? $ajaxcity_zip_city = '<i>'.give_translation('immo.city_situation_unknown_kproduct', 'false', $config_showtranslationcode).'</i>': $ajaxcity_zip_city);
                    if(empty($ajaxcity_name_district) ? $ajaxcity_name_district = '<i>'.give_translation('immo.city_situation_unknown_kproduct', 'false', $config_showtranslationcode).'</i>': $ajaxcity_name_district);
                    if(empty($ajaxcity_name_department) ? $ajaxcity_name_department = '<i>'.give_translation('immo.city_situation_unknown_kproduct', 'false', $config_showtranslationcode).'</i>': $ajaxcity_name_department);
                    if(empty($ajaxcity_name_region) ? $ajaxcity_name_region = '<i>'.give_translation('immo.city_situation_unknown_kproduct', 'false', $config_showtranslationcode).'</i>': $ajaxcity_name_region);
                    if(empty($ajaxcity_name_country) ? $ajaxcity_name_country = '<i>'.give_translation('immo.city_situation_unknown_kproduct', 'false', $config_showtranslationcode).'</i>': $ajaxcity_name_country);
                ?>
                    <tr>
                        <td colspan="2">
                            <div id="KprodimmoCityOtherInfo">
                            <table width="100%" cellpadding="0" cellspacing="1" border="0">        
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle"><?php give_translation('immo.subtitle_zip_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                    <td align="left" width="70%">
                                        <span class="font_main"><?php echo($ajaxcity_zip_city); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle"><?php give_translation('immo.subtitle_district_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                    <td align="left">
                                        <span class="font_main"><?php echo($ajaxcity_name_district); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle"><?php give_translation('immo.subtitle_department_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                    <td align="left">
                                        <span class="font_main"><?php echo($ajaxcity_name_department); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle"><?php give_translation('immo.subtitle_region_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                    <td align="left">
                                        <span class="font_main"><?php echo($ajaxcity_name_region); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span class="font_subtitle"><?php give_translation('immo.subtitle_country_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                                    </td>
                                    <td align="left">
                                        <span class="font_main"><?php echo($ajaxcity_name_country); ?></span>
                                    </td>
                                </tr>                                         
                            </table>
                            </div>
                        </td>
                    </tr>
<?php
                }
            
            
            #situation location
            if($kprodimmo_status_locationsituation == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_location_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="70%">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_locationsituation, $kprodimmo_nameS_locationsituation, $kprodimmo_code_locationsituation, $kprodimmo_statusobject_locationsituation, $kprodimmo_id_locationsituation, $_SESSION['Kprodimmo_situation_cdreditor_location_situation'], false);                                      
?>
                                </td>
                            </tr>
                        </table>
                    </td>    
                </tr>
<?php
            }
            
            #situation location details
            if($kprodimmo_status_locdetailssituation == 1)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_locdetails_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="70%">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_locdetailssituation, $kprodimmo_nameS_locdetailssituation, $kprodimmo_code_locdetailssituation, $kprodimmo_statusobject_locdetailssituation, $kprodimmo_id_locdetailssituation, $_SESSION['Kprodimmo_situation_cdreditor_locdetails_situation'], false);                                      
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
                    <td align="left">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_geoloc_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="70%" style="vertical-align: top;">
                        <span class="font_main"><?php give_translation('immo.subtitle_latitude_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                        &nbsp;
                        <input style="width: 90px;" type="text" name="txtKprodimmoSituationLat" value="<?php if(!empty($_SESSION['Kprodimmo_situation_txtKprodimmoSituationLat'])){ echo($_SESSION['Kprodimmo_situation_txtKprodimmoSituationLat']); } ?>" />  
                        &nbsp;
                        <span class="font_main"><?php give_translation('immo.subtitle_longitude_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                        &nbsp;
                        <input style="width: 90px;" type="text" name="txtKprodimmoSituationLon" value="<?php if(!empty($_SESSION['Kprodimmo_situation_txtKprodimmoSituationLon'])){ echo($_SESSION['Kprodimmo_situation_txtKprodimmoSituationLon']); } ?>"/>
                    </td>
                </tr>
<?php                
            
            #situation facilities
            if($kprodimmo_status_facilitiessituation == 1)
            {
                $kprodimmo_facilitiesgroup_situation_session = split_string($_SESSION['Kprodimmo_situation_txtKprodimmoSituationFacilitiesGroup'], '$');
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle"><?php give_translation('immo.subtitle_facilities_situation_kproduct', $echo, $config_showtranslationcode); ?></span>
                    </td>
                    <td align="left" width="70%">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
<?php                       
                                cdreditor($kprodimmo_type_facilitiessituation, $kprodimmo_nameS_facilitiessituation, $kprodimmo_code_facilitiessituation, $kprodimmo_statusobject_facilitiessituation, $kprodimmo_id_facilitiessituation, $_SESSION['Kprodimmo_situation_cdreditor_facilities_situation'], false, true, 'width: 30px;', 'text', null, ' />&nbsp;<span class="font_main">km</span>', $_SESSION['Kprodimmo_situation_txtcdreditor_facilities_situation'], null, null, null, null, null, null, null, null, null, null, null, null, true, '<input style="width: 90px;" type="text" name="txtKprodimmoSituationFacilitiesGroup[#nameindex]"', $kprodimmo_facilitiesgroup_situation_session);                                      
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
