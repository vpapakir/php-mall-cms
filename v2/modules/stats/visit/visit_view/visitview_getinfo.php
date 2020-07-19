<?php
try
{
    unset($stats_visitview_totalpage,$stats_visitview_totalvisit,$stats_visitview_date,
            $stats_visitview_firstdate);
    #total visit
    $prepared_query = 'SELECT * FROM stats_visits
                       WHERE id_statsvisit = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $stats_visitview_totalvisit = $data['count_statsvisit'];
        $stats_visitview_date = $data['date_statsvisit'];
    }
    $query->closeCursor();
    #total page views
    $prepared_query = 'SELECT * FROM stats_page
                       WHERE count_statspage > 0
                       ORDER BY count_statspage DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $stats_visitview_totalpage += $data['count_statspage'];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM stats_online
                       ORDER BY date_statsonline DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $stats_visitview_firstdate = $data['date_statsonline'];
    }
    $query->closeCursor();
    
    #unknown user info
    $prepared_query = 'SELECT * FROM stats_online
                       WHERE id_user IS NULL';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    unset($stats_visitview_unknown_countvisit);
    while($data = $query->fetch())
    {
        $stats_visitview_unknown_countvisit++;
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM stats_online
                       WHERE id_user IS NULL
                       ORDER BY date_statsonline DESC
                       LIMIT 0, 50';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $stats_visitview_unknown_idstatsvisit[$i] = $data['id_statsonline'];
        $stats_visitview_unknown_date[$i] = $data['date_statsonline'];
        if($i == 0)
        {
            $stats_visitview_unknown_lastdate = $data['date_statsonline'];
        }
        $stats_visitview_unknown_ip[$i] = $data['ip_statsonline'];
        $stats_visitview_unknown_country[$i] = $data['country_statsonline'];
        $stats_visitview_unknown_browser[$i] = $data['browser_statsonline'];
        $stats_visitview_unknown_name[$i] = give_translation('stats_visit.name_unknown', 'false', $config_showtranslationcode);;
        $i++;
    }
    $query->closeCursor();
    
    #known user info
    $prepared_query = 'SELECT * FROM stats_online
                       WHERE id_user > 0';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    unset($stats_visitview_known_countvisit);
    while($data = $query->fetch())
    {
        $stats_visitview_known_countvisit++;
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM stats_online
                       INNER JOIN user
                       ON user.id_user = stats_online.id_user
                       INNER JOIN user_rights
                       ON user_rights.level_rights = user.rights_user
                       WHERE stats_online.id_user > 0
                       ORDER BY date_statsonline DESC
                       LIMIT 0, 50';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $stats_visitview_known_idstatsvisit[$i] = $data['id_statsonline'];
        if($i == 0)
        {
            $stats_visitview_known_lastdate = $data['date_statsonline'];
        }
        $stats_visitview_known_date[$i] = $data['date_statsonline'];
        $stats_visitview_known_ip[$i] = $data['ip_statsonline'];
        $stats_visitview_known_country[$i] = $data['country_statsonline'];
        $stats_visitview_known_rights[$i] = $data['name_rights'];
        $stats_visitview_known_legend_name[$i] = $data['firstname_user'].' '.$data['name_user'];
        
        if(!empty($data['namecompany_user']))
        {
            $stats_visitview_known_name[$i] = $data['namecompany_user'];
        }
        else
        {
            $stats_visitview_known_name[$i] = $data['firstname_user'].' '.$data['name_user'];
        }
        $i++;
    }
    $query->closeCursor();
    
    $stats_visitview_totalvisit = number_format($stats_visitview_totalvisit, 0, ',', '.');
    $stats_visitview_totalpage = number_format(($stats_visitview_totalpage + $configadmin_stats_page_count), 0, ',', '.');
    $stats_visitview_firstdate_sentence = converto_timestamp($stats_visitview_firstdate);
    $stats_visitview_firstdate_sentence = date('d-m-Y', $stats_visitview_firstdate_sentence);
    $stats_visitview_known_lastdate = converto_timestamp($stats_visitview_known_lastdate);
    $stats_visitview_known_lastdate = date('d-m-Y', $stats_visitview_known_lastdate);
    $stats_visitview_unknown_lastdate = converto_timestamp($stats_visitview_unknown_lastdate);
    $stats_visitview_unknown_lastdate = date('d-m-Y', $stats_visitview_unknown_lastdate);
    
    $stats_visitview_countvisitpage_sentence = give_translation('stats_page.subtitle_countvisitpage_sentence', 'false', $config_showtranslationcode);
    $stats_visitview_countvisitpage_sentence = str_replace('[#count_visit]', '<span class="font_subtitle">'.$stats_visitview_totalvisit.'</span>', $stats_visitview_countvisitpage_sentence);
    $stats_visitview_countvisitpage_sentence = str_replace('[#date_visit]', '<span class="font_subtitle">'.$stats_visitview_firstdate_sentence.'</span>', $stats_visitview_countvisitpage_sentence);
    $stats_visitview_countvisitpage_sentence = str_replace('[#count_page]', '<span class="font_subtitle">'.$stats_visitview_totalpage.'</span>', $stats_visitview_countvisitpage_sentence);
    
    $stats_visitview_blocktitle_known = give_translation('stats_visit.block_title_known', 'false', $config_showtranslationcode);
    $stats_visitview_blocktitle_known = str_replace('[#count_knownvisit]', $stats_visitview_known_countvisit, $stats_visitview_blocktitle_known);
    $stats_visitview_blocktitle_known = str_replace('[#date_knownvisit]', $stats_visitview_known_lastdate, $stats_visitview_blocktitle_known);
    $stats_visitview_blocktitle_known = str_replace('[#date_firstknownvisit]', $stats_visitview_firstdate_sentence, $stats_visitview_blocktitle_known);
    
    $stats_visitview_blocktitle_unknown = give_translation('stats_visit.block_title_unknown', 'false', $config_showtranslationcode);
    $stats_visitview_blocktitle_unknown = str_replace('[#count_knownvisit]', $stats_visitview_unknown_countvisit, $stats_visitview_blocktitle_unknown);
    $stats_visitview_blocktitle_unknown = str_replace('[#date_knownvisit]', $stats_visitview_unknown_lastdate, $stats_visitview_blocktitle_unknown);
    $stats_visitview_blocktitle_unknown = str_replace('[#date_firstknownvisit]', $stats_visitview_firstdate_sentence, $stats_visitview_blocktitle_unknown);
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
