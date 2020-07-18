<?php
if(!empty($_SESSION['advertedit_cboSelectAdvert']) && $_SESSION['advertedit_cboSelectAdvert'] != 'new')
{
    include('modules/advertising/preview/advert_preview.php');
}

if(!empty($_SESSION['msg_advertedit_AdvertScriptFile'.$main_activatedidlang[$i]]))
{
?>
    <tr>
        <td align="left" style="vertical-align: top;">

        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <div class="font_error1"><?php echo(nl2br($_SESSION['msg_advertedit_AdvertScriptFile'.$main_activatedidlang[$i]])); ?></div>
        </td>
    </tr>
<?php
}

include('modules/advertising/upload/advert_upload.php');
?>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_name', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <input style="width: 99%;" type="text" name="txtNameAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtNameAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtNameAdvert'.$main_activatedidlang[$i]]); } ?>"/>
<?php
        if(!empty($_SESSION['msg_advertedit_txtNameAdvert'.$main_activatedidlang[$i]]))
        {
?>
            <br clear="left"/>
            <div class="font_error1"><?php echo($_SESSION['msg_advertedit_txtNameAdvert'.$main_activatedidlang[$i]]); ?></div>
<?php
        }
?>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_userrights', '', $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <select name="cboRightsAdvert<?php echo($main_activatedidlang[$i]); ?>[]" multiple="multiple" size="5">
            <option value="all" <?php if(empty($_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]]) || $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]] == 'all'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('main.multi_userrights_all', '', $config_showtranslationcode); ?></option>
<?php
        unset($advertedit_levelrights);
        if(!empty($_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]]) && $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]] != 'all')
        {
            $advertedit_levelrights = $_SESSION['advertedit_cboRightsAdvert'.$main_activatedidlang[$i]];
            $advertedit_levelrights = str_replace(',9', '', $advertedit_levelrights);
            $advertedit_levelrights = split_string($advertedit_levelrights, ',');
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
                        for($y = 0, $county = count($advertedit_levelrights); $y < $county; $y++)
                        {
                            if($advertedit_levelrights[$y] == $data['level_rights'])
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
                <option value="9" <?php if(!empty($advertedit_levelrights[0]) && $advertedit_levelrights[0] == '9'){ echo('selected="selected"'); }else{ echo(null); } ?>><?php give_translation('main.rights_superadmin_only', '', $config_showtranslationcode); echo(' '); give_translation('main.rights_superadmin', '', $config_showtranslationcode); ?></option>
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
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_selectpage', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <select style="width: 99%;" name="cboPageAdvert<?php echo($main_activatedidlang[$i]); ?>[]" multiple="multiple" size="10">
            <option value="select" 
                <?php if(empty($_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]]) || $_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]] == 'select'){ echo('selected="selected"'); } ?>
                    ><?php give_translation('main.dd_select', $echo, $config_showtranslationcode); ?></option>
<?php
                $advertedit_pageadvert = $_SESSION['advertedit_cboPageAdvert'.$main_activatedidlang[$i]];
                $advertedit_pageadvert = split_string($advertedit_pageadvert, '$');
                try
                {
                    $prepared_query = 'SELECT DISTINCT(family_page) FROM page
                                       WHERE status_page = 1';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    $y = 0;
                    while($data = $query->fetch())
                    {
                        $advertedit_family_page[$y] = $data[0];
                        $y++;
                    }
                    $query->closeCursor();
                    
                    for($y = 0, $county = count($advertedit_family_page); $y < $county; $y++)
                    {
?>
                        <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('main.dd_family_'.$advertedit_family_page[$y], $echo, $config_showtranslationcode); ?>">
<?php
                        $prepared_query = 'SELECT * FROM page
                                           INNER JOIN page_translation
                                           ON page_translation.id_page = page.id_page
                                           WHERE page.id_page <> 0
                                           AND family_page = :family
                                           AND family_page_translation = "title"
                                           ORDER BY L'.$main_id_language;
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('family', $advertedit_family_page[$y]);
                        $query->execute();

                        while($data = $query->fetch())
                        {
                            if(empty($data['L'.$main_id_language]))
                            {
                                $advertedit_pagetitle = $data['url_page'];
                            }
                            else
                            {
                                $advertedit_pagetitle = cut_string($data['L'.$main_id_language], 0, 30, '...').' ('.$data['url_page'].')';
                            }
?>
                            <option  class="tooltip" style="background-color: white;" value="<?php echo($data[0]); ?>" title="<?php echo($data['url_page']."<br/>".$data['L'.$main_id_language]); ?>"
                                <?php 
                                for($x = 0, $countx = count($advertedit_pageadvert); $x < $countx; $x++)
                                {
                                    if($advertedit_pageadvert[$x] == $data[0])
                                    {
                                        echo('selected="selected" ');
                                    }
                                }
                                ?>
                                    ><?php echo($advertedit_pagetitle); ?></option>
<?php                   
                        }
                        $query->closeCursor();
?>
                        </optgroup>
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
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_keyword', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input style="width: 99%;" type="text" name="txtKeywordAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtKeywordAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtKeywordAdvert'.$main_activatedidlang[$i]]); } ?>"/>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_frame', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <select name="cboFrameAdvert<?php echo($main_activatedidlang[$i]); ?>">
            <option value="select"
                <?php if(empty($_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]]) || $_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]] == 'select'){ echo('selected="selected"'); } ?>
                    ><?php give_translation('main.dd_select', $echo, $config_showtranslationcode); ?></option>
<?php
            try
            {
                $prepared_query = 'SELECT id_frame FROM structure_template
                                   WHERE status_template = 1';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                if(($data = $query->fetch()) != false)
                {
                    $temp_id_frame = $data[0];
                }
                $query->closeCursor();

                $temp_id_frame = split_string($temp_id_frame, ',');

                $prepared_query = 'SELECT * FROM structure_frame
                                   WHERE ';

                for($y = 0, $county = count($temp_id_frame); $y < $county; $y++)
                {
                    if($y < ($county - 1))
                    {
                        $prepared_query .= 'id_frame = '.$temp_id_frame[$y].' OR ';
                    }
                    else
                    {
                        $prepared_query .= 'id_frame = '.$temp_id_frame[$y].' ORDER BY name_frame ASC';
                    }
                }


                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();

                $y = 0;

                while($data = $query->fetch())
                {
                    $id_frame_sitemap[$y] = $data[0];
                    $name_frame_sitemap[$y] = $data['name_frame'];
                    $y++;     
                }
                $query->closeCursor();

                for($y = 0, $county = count($id_frame_sitemap); $y < $county; $y++)
                {
?>
                    <option value="<?php echo($id_frame_sitemap[$y]); ?>" title="<?php echo($data['L'.$main_id_language]); ?>"
                         <?php if(!empty($_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]]) && $_SESSION['advertedit_cboFrameAdvert'.$main_activatedidlang[$i]] == $id_frame_sitemap[$y]){ echo('selected="selected"'); } ?>   
                            ><?php echo($name_frame_sitemap[$y]); ?></option>
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
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_alt', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input type="text" name="txtAltAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtAltAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtAltAdvert'.$main_activatedidlang[$i]]); } ?>"/>
<?php
        if(!empty($_SESSION['msg_advertedit_txtAltAdvert'.$main_activatedidlang[$i]]))
        {
?>
            <br clear="left"/>
            <div class="font_error1"><?php echo($_SESSION['msg_advertedit_txtAltAdvert'.$main_activatedidlang[$i]]); ?></div>
<?php
        }
?>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_legend', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <textarea style="width: 99%;" name="areaLegendAdvert<?php echo($main_activatedidlang[$i]); ?>"><?php if(!empty($_SESSION['advertedit_areaLegendAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_areaLegendAdvert'.$main_activatedidlang[$i]]); } ?></textarea>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_link', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input style="width: 99%;" type="text" name="txtLinkAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtLinkAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtLinkAdvert'.$main_activatedidlang[$i]]); } ?>"/>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_target', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <select name="cboTargetAdvert<?php echo($main_activatedidlang[$i]); ?>">
            <option value="_self"
                <?php if(empty($_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]]) || $_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]] == '_self'){ echo('selected="selected"'); } ?>
                    ><?php give_translation('main.dd_target_self', $echo, $config_showtranslationcode); ?></option>
            <option value="_blank"
                <?php if(!empty($_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]]) && $_SESSION['advertedit_cboTargetAdvert'.$main_activatedidlang[$i]] == '_blank'){ echo('selected="selected"'); } ?>
                    ><?php give_translation('main.dd_target_blank', $echo, $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_widthlimit', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input type="text" name="txtWidthlimitAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtWidthlimitAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtWidthlimitAdvert'.$main_activatedidlang[$i]]); } ?>"/>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_heightlimit', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input type="text" name="txtHeightlimitAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtHeightlimitAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtHeightlimitAdvert'.$main_activatedidlang[$i]]); } ?>"/>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_scriptpath', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input style="width: 99%;" type="text" name="txtScriptpathAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtScriptpathAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtScriptpathAdvert'.$main_activatedidlang[$i]]); } ?>"/>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_scriptcode', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <textarea style="width: 99%;" name="areaScriptcodeAdvert<?php echo($main_activatedidlang[$i]); ?>"><?php if(!empty($_SESSION['advertedit_areaScriptcodeAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_areaScriptcodeAdvert'.$main_activatedidlang[$i]]); } ?></textarea>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_position', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <input style="width: 50px;" type="text" name="txtPositionAdvert<?php echo($main_activatedidlang[$i]); ?>" value="<?php if(!empty($_SESSION['advertedit_txtPositionAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_txtPositionAdvert'.$main_activatedidlang[$i]]); }else{ echo('1010'); } ?>"/>
<?php
        if(!empty($_SESSION['msg_advertedit_txtPositionAdvert'.$main_activatedidlang[$i]]))
        {
?>
            <br clear="left"/>
            <div class="font_error1"><?php echo($_SESSION['msg_advertedit_txtPositionAdvert'.$main_activatedidlang[$i]]); ?></div>
<?php
        }
?>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_comment', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <textarea style="width: 99%;" name="areaCommentAdvert<?php echo($main_activatedidlang[$i]); ?>"><?php if(!empty($_SESSION['advertedit_areaCommentAdvert'.$main_activatedidlang[$i]])){ echo($_SESSION['advertedit_areaCommentAdvert'.$main_activatedidlang[$i]]); } ?></textarea>
    </td>
</tr>
<tr>
    <td align="left" style="vertical-align: top;">
        <span class="font_subtitle"><?php give_translation('advertising_edit.subtitle_status', $echo, $config_showtranslationcode); ?></span>
    </td>
    <td align="left">
        <select name="cboStatusAdvert<?php echo($main_activatedidlang[$i]); ?>">
            <option value="1"
                <?php if(empty($_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]]) || $_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]] == 1){ echo('selected="selected"'); } ?>
                    ><?php give_translation('main.dd_enabled', $echo, $config_showtranslationcode); ?></option>
            <option value="9"
                <?php if(!empty($_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]]) && $_SESSION['advertedit_cboStatusAdvert'.$main_activatedidlang[$i]] == 9){ echo('selected="selected"'); } ?>    
                    ><?php give_translation('main.dd_disabled', $echo, $config_showtranslationcode); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
</tr>
<tr>
    <td colspan="2"><table width="100%" style="">
        <tr>        
            <td align="center">               
<?php
                if(!empty($_SESSION['advertedit_cboSelectAdvert']) && $_SESSION['advertedit_cboSelectAdvert'] != 'new')
                {
?>
                    <input type="submit" name="bt_modify_advert" value="<?php give_translation('main.bt_modify', '', $config_showtranslationcode); ?>"/>
<?php
                }
                else
                {
?>
                    <input type="submit" name="bt_save_advert" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
<?php
                }
?>
            </td>
        </tr> 
    </table></td>
</tr>

