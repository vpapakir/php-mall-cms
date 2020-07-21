<?php
#if((stats_page_checksession($_SESSION['stats_page_count'], $url_page)) === true)
#{
    try
    {
        unset($stats_page_count, $stats_page_id);
        $stats_page_bok_insert = true;

        $prepared_query = 'SELECT id_statspage, count_statspage FROM stats_page
                           WHERE id_page = :idpage';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('idpage', $id_page);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $stats_page_bok_insert = false;
            $stats_page_id = $data[0];
            $stats_page_count = $data[1];
        }
        $query->closeCursor();

        if($stats_page_bok_insert === true)
        {
            $stats_page_count = 1;
            $prepared_query = 'INSERT INTO stats_page
                               (id_page, firstdate_statspage, date_statspage, count_statspage)
                               VALUES
                               (:idpage, NOW(), NOW(), :count)';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'idpage' => $id_page,
                                  'count' => $stats_page_count
                                  ));
            $query->closeCursor();
        }
        else
        {
            $stats_page_count++;
            $prepared_query = 'UPDATE stats_page
                               SET `date_statspage` = NOW(),
                               `count_statspage` = :countpage
                               WHERE id_statspage = :idstatspage';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                  'countpage' => $stats_page_count,
                                  'idstatspage' => $stats_page_id
                                  ));
            $query->closeCursor();
        }
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        echo $_SESSION['error400_message'];
        /*if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$config_customheader.'Error/400'));
        }
        else
        {
            die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
        }*/
    }
#}
?>
