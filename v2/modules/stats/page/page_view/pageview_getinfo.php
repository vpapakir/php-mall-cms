<?php
try
{
    unset($stats_pageview_totalpage,$stats_pageview_totalvisit,$stats_pageview_date,
            $stats_pageview_firstdate);
    $prepared_query = 'SELECT * FROM stats_visits
                       WHERE id_statsvisit = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_pageview_totalvisit = $data['count_statsvisit'];
        $stats_pageview_date = $data['date_statsvisit'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM stats_page
                       WHERE id_statspage = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_pageview_firstdate = $data['firstdate_statspage'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM stats_page
                       WHERE count_statspage > 0
                       ORDER BY count_statspage DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $stats_pageview_totalpage += $data['count_statspage'];
        $stats_pageview_idpage[$i] = $data['id_page'];
        $stats_pageview_currentpage_lastdate[$i] = $data['date_statspage'];
        $stats_pageview_currentpage_firstdate[$i] = $data['firstdate_statspage'];
        $stats_pageview_currentpage_count[$i] = $data['count_statspage'];
        $i++;
    }
    $query->closeCursor();
    
    $stats_pageview_totalvisit = number_format($stats_pageview_totalvisit, 0, ',', '.');
    $stats_pageview_totalpage = number_format(($stats_pageview_totalpage + $configadmin_stats_page_count), 0, ',', '.');
    $stats_pageview_firstdate_sentence = converto_timestamp($stats_pageview_firstdate);
    $stats_pageview_firstdate_sentence = date('d-m-Y', $stats_pageview_firstdate_sentence);
    
    $stats_pageview_countvisitpage_sentence = give_translation('stats_page.subtitle_countvisitpage_sentence', 'false', $config_showtranslationcode);
    $stats_pageview_countvisitpage_sentence = str_replace('[#count_visit]', '<span class="font_subtitle">'.$stats_pageview_totalvisit.'</span>', $stats_pageview_countvisitpage_sentence);
    $stats_pageview_countvisitpage_sentence = str_replace('[#date_visit]', '<span class="font_subtitle">'.$stats_pageview_firstdate_sentence.'</span>', $stats_pageview_countvisitpage_sentence);
    $stats_pageview_countvisitpage_sentence = str_replace('[#count_page]', '<span class="font_subtitle">'.$stats_pageview_totalpage.'</span>', $stats_pageview_countvisitpage_sentence);
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
