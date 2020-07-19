<?php
if(empty($_SESSION['stats_visit']))
{
    try
    {
        #total visit
        $prepared_query = 'SELECT count_statsvisit FROM stats_visits
                           WHERE id_statsvisit = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $stats_visit_count = $data[0];
        }
        $query->closeCursor();
        if(empty($stats_visit_count))
        {
            $stats_visit_count = 1;
        }
        else
        {
            $stats_visit_count++;
        }
        
        $prepared_query = 'UPDATE stats_visits
                           SET `date_statsvisit` = NOW(),
                           `count_statsvisit` = :countvisit
                           WHERE id_statsvisit = 1';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('countvisit', $stats_visit_count);
        $query->execute();
        $query->closeCursor();
        
        #insert visitor  
        include('external_modules/geoloc/geoplugin.class.php');
        $statsonline_country_geoplugin = new geoPlugin();
        $statsonline_country_geoplugin->locate($_SERVER['REMOTE_ADDR']);
        $statsonline_country_geoplugin = $statsonline_country_geoplugin->countryName;
        
        $prepared_query = 'INSERT INTO stats_online
                           (date_statsonline, timestamp_statsonline, 
                            ip_statsonline, status_statsonline, 
                            sessionid_statsonline, browser_statsonline,
                            country_statsonline)
                           VALUES
                           (NOW(), :time, :ip, :status, :sessionid, :browser, :country)';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'time' => time(),
                              'ip' => $_SERVER['REMOTE_ADDR'],
                              'status' => 1,
                              'sessionid' => session_id(),
                              'browser' => $_SERVER['HTTP_USER_AGENT'],
                              'country' => $statsonline_country_geoplugin
                              ));
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
    
    unset($stats_visit_count);
    $_SESSION['stats_visit'] = 'alreadycount';
}
?>
