<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseStatsvisitunknown"
<?php
                if(empty($_SESSION['expand_statsvisit_unknown']) || $_SESSION['expand_statsvisit_unknown'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseStatsvisitunknown', 'img_expand_collapseStatsvisitunknown', 'expand_statsvisit_unknown', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseStatsvisitunknown');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_statsvisit_unknown']) || $_SESSION['expand_statsvisit_unknown'] == 'false')
                        {
?>
                            <img id="img_expand_collapseStatsvisitunknown" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseStatsvisitunknown" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 10px;">
                        <?php echo($stats_visitview_blocktitle_unknown); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_statsvisit_unknown" style="display: none;" type="hidden" name="expand_statsvisit_unknown" value="<?php if(!empty($_SESSION['expand_statsvisit_unknown']) && $_SESSION['expand_statsvisit_unknown'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseStatsvisitunknown"
<?php
        if(empty($_SESSION['expand_statsvisit_unknown']) || $_SESSION['expand_statsvisit_unknown'] == 'false')
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
    <td align="left">
        <table width="100%" cellpadding="0" cellspacing="1" border="0">
            <tr>  
                <td align="center" class="block_main2" style="width: 13%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_visit.subtitle_visitdate', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 20%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_visit.subtitle_visitip', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 15%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_visit.subtitle_visitname', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 25%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_visit.subtitle_visitcountry', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 20%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_visit.subtitle_visittypeuser', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 7%;">
                    <div class="font_subtitle" style="text-align: center;"><input id="chk_statsvisit_unknown_all" type="checkbox" name="chk_statsvisit_unknown_all" value="1" onclick="check_all('chk_statsvisit_unknown_all', 'input', 'chk_statsvisit_unknown_individual');"></input></div>
                </td>                
            </tr>
        </table>
    </td>
</tr>
<?php
$stats_visitview_bok_listingstyle = true;
for($i = 0, $count = count($stats_visitview_unknown_idstatsvisit); $i < $count; $i++)
{ 
    if($stats_visitview_bok_listingstyle === true)
    {
        $stats_visitview_listingbgcolor = 'lightgrey'; 
        $stats_visitview_bok_listingstyle = false;
    }
    else
    {
        $stats_visitview_listingbgcolor = 'white'; 
        $stats_visitview_bok_listingstyle = true;
    }
    
    try
    {
        $stats_visitview_unknown_date[$i] = converto_timestamp($stats_visitview_unknown_date[$i]);
        $stats_visitview_unknown_date[$i] = date('d-m-Y', $stats_visitview_unknown_date[$i]);
//        $stats_visitview_currentpage_date = give_translation('stats_page.legend_currentpage_date', 'false', $config_showtranslationcode);
//        $stats_visitview_currentpage_date = str_replace('[#date_firstvisit]', $stats_visitview_currentpage_firstdate[$i], $stats_visitview_currentpage_date);
//        $stats_visitview_currentpage_date = str_replace('[#date_lastvisit]', $stats_visitview_currentpage_lastdate[$i], $stats_visitview_currentpage_date);
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
    <tr>
        <td align="left" style="background-color: <?php echo($stats_visitview_listingbgcolor); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($stats_visitview_listingbgcolor); ?>';">
            <table width="100%" cellpadding="0" cellspacing="1" border="0">
                <tr>
                    <td align="center" width="13%">
                        <span class="font_main">
                            <?php echo($stats_visitview_unknown_date[$i]); ?>
                        </span> 
                    </td>
                    <td align="left" width="20%">
                        <span class="font_main" style="margin-left: 4px;">
                            <?php echo($stats_visitview_unknown_ip[$i]); ?>
                        </span>
                    </td>
                    <td align="left" width="15%">
                        <span class="font_main" style="margin-left: 4px;">
                            <?php echo($stats_visitview_unknown_name[$i]); ?>
                        </span> 
                    </td>
                    <td align="left" width="25%">
                        <span class="font_main" style="margin-left: 4px;">
                            <?php echo($stats_visitview_unknown_country[$i]); ?>
                        </span> 
                    </td>
                    <td align="left" width="20%">
                        <span class="font_main" style="margin-left: 4px;" title="<?php echo($stats_visitview_unknown_browser[$i]); ?>">
                            <?php echo(cut_string($stats_visitview_unknown_browser[$i], 0, 10, '...')); ?>
                        </span> 
                    </td>
                    <td align="center" width="7%">
                        <input class="chk_statsvisit_unknown_individual" type="checkbox" name="chk_statsvisit_unknown_<?php echo($stats_visitview_unknown_idstatsvisit[$i]); ?>" value="1"></input>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>
<tr>
    <td colspan="2"><div style="height: 4px;"></div></td>
</tr>    
<tr>
    <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
</tr>
<tr>
    <td colspan="2"><table width="100%">
        <tr>        
            <td align="center" width="<?php echo($right_column_width); ?>">
                <span id="bt_reset_statsvisitview_unknown" class="link_input" style="padding: 4px;" onclick="yesno_button('bt_reset_statsvisitview_unknown', 'bt_reset_statsvisitview_unknown_asking');">
                    <?php give_translation('main.bt_reset_stats', '', $config_showtranslationcode); ?>
                </span>
                <span id="bt_reset_statsvisitview_unknown_asking" style="display: none;">
                    <span style="text-align: left;"><?php give_translation('main.ask_confirm_onhold', '', $config_showtranslationcode); ?></span>
                    
                    <input type="submit" name="bt_reset_statsvisitview_unknown" value="<?php give_translation('main.bt_yes', '', $config_showtranslationcode); ?>"/>
                    <span class="link_input" style="padding: 4px;" onclick="yesno_button('bt_reset_statsvisitview_unknown', 'bt_reset_statsvisitview_unknown_asking');">
                        <?php give_translation('main.bt_no', '', $config_showtranslationcode); ?>
                    </span>                    
                </span>
                &nbsp;
                <input type="submit" name="bt_removetostats_statsvisitview_unknown" value="<?php give_translation('main.bt_remove_statsvisit', '', $config_showtranslationcode); ?>"/>
            </td>
        </tr> 
    </table></td>
</tr>
            </table></td>
        </tr>
    </table></td>
</tr>

