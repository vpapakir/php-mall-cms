<tr>
    <td align="left">
        <table width="100%" cellpadding="0" cellspacing="1" border="0">
            <tr>  
                <td align="center" class="block_main2" style="width: 60%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_page.subtitle_pagetitle', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 25%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_page.subtitle_pagelink', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 10%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('stats_page.subtitle_pagecount', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 5%;">
                    <div class="font_subtitle" style="text-align: center;"><input id="chk_statspage_all" type="checkbox" name="chk_statspage_all" value="1" onclick="check_all('chk_statspage_all', 'input', 'chk_statspage_individual');"></input></div>
                </td>
            </tr>
        </table>
    </td>
</tr>
<?php
unset($stats_pageview_title, $stats_pageview_rewritingF, $stats_pageview_intro);
$stats_pageview_bok_listingstyle = true;
for($i = 0, $count = count($stats_pageview_idpage); $i < $count; $i++)
{ 
    if($stats_pageview_bok_listingstyle === true)
    {
        $stats_pageview_listingbgcolor = 'lightgrey'; 
        $stats_pageview_bok_listingstyle = false;
    }
    else
    {
        $stats_pageview_listingbgcolor = 'white'; 
        $stats_pageview_bok_listingstyle = true;
    }
    try
    {
        #title
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE page.id_page = :idpage
                           AND family_page_translation = "title"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idpage', $stats_pageview_idpage[$i]);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $stats_pageview_title = stripslashes($data[0]);
        }
        $query->closeCursor();

        #intro
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE page.id_page = :idpage
                           AND family_page_translation = "intro"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idpage', $stats_pageview_idpage[$i]);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $stats_pageview_intro = trim(strip_tags(stripslashes($data[0])));
        }
        $query->closeCursor();

        #rewritingF
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE page.id_page = :idpage
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idpage', $stats_pageview_idpage[$i]);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $stats_pageview_rewritingF = $data[0];
        }
        $query->closeCursor();
        
        $stats_pageview_currentpage_firstdate[$i] = converto_timestamp($stats_pageview_currentpage_firstdate[$i]);
        $stats_pageview_currentpage_firstdate[$i] = date('d-m-Y', $stats_pageview_currentpage_firstdate[$i]);
        $stats_pageview_currentpage_lastdate[$i] = converto_timestamp($stats_pageview_currentpage_lastdate[$i]);
        $stats_pageview_currentpage_lastdate[$i] = date('d-m-Y', $stats_pageview_currentpage_lastdate[$i]);
        
        $stats_pageview_currentpage_date = give_translation('stats_page.legend_currentpage_date', 'false', $config_showtranslationcode);
        $stats_pageview_currentpage_date = str_replace('[#date_firstvisit]', $stats_pageview_currentpage_firstdate[$i], $stats_pageview_currentpage_date);
        $stats_pageview_currentpage_date = str_replace('[#date_lastvisit]', $stats_pageview_currentpage_lastdate[$i], $stats_pageview_currentpage_date);
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
        <td align="left" class="tooltip" title="<?php echo($stats_pageview_intro); ?>" style="background-color: <?php echo($stats_pageview_listingbgcolor); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($stats_pageview_listingbgcolor); ?>';">
            <table width="100%" cellpadding="0" cellspacing="1" border="0">
                <tr>
                    <td class="tooltip" align="left" title="<?php echo($stats_pageview_title); ?>" width="60%">
                        <span class="font_main" style="margin-left: 4px;">
                            <?php echo(cut_string($stats_pageview_title, 0, 35, '...')); ?>
                        </span> 
                    </td>
                    <td align="left" width="25%">
                        <a href="<?php echo($config_customheader.$stats_pageview_rewritingF); ?>" class="link_main" style="margin-left: 4px;">
                            <?php echo($stats_pageview_rewritingF); ?>
                        </a> 
                    </td>
                    <td align="right" class="tooltip" width="10%" title="<?php echo($stats_pageview_currentpage_date); ?>">
                        <span class="font_subtitle" style="margin-right: 4px;">
                            <?php echo(number_format($stats_pageview_currentpage_count[$i], 0, ',', '.')); ?>
                        </span> 
                    </td>
                    <td align="center" width="5%">
                        <input class="chk_statspage_individual" type="checkbox" name="chk_statspage_page<?php echo($stats_pageview_idpage[$i]); ?>" value="1"></input>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    unset($stats_pageview_title, $stats_pageview_rewritingF, $stats_pageview_intro);
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
                <input type="submit" name="bt_reset_statspageview" value="<?php give_translation('main.bt_reset_stats', '', $config_showtranslationcode); ?>"/>
                <input type="submit" name="bt_removetostats_statspageview" value="<?php give_translation('main.bt_remove_statspage', '', $config_showtranslationcode); ?>"/>
            </td>
        </tr> 
    </table></td>
</tr>

