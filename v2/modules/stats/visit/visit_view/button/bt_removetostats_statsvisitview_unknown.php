<?php
if(isset($_POST['bt_removetostats_statsvisitview_unknown']))
{
    unset($stats_visitview_chk);
    $stats_visitview_bok_reallocatetableid = false;
    for($i = 0, $count = count($stats_visitview_unknown_idstatsvisit); $i < $count; $i++)
    {
        $stats_visitview_chk = htmlspecialchars($_POST['chk_statsvisit_unknown_'.$stats_visitview_unknown_idstatsvisit[$i]], ENT_QUOTES);
        
        if($stats_visitview_chk == 1)
        {
            $stats_visitview_bok_reallocatetableid = true;
            try
            {
                $prepared_query = 'DELETE FROM stats_online
                                   WHERE id_statsonline = :idstatsonline';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idstatsonline', $stats_visitview_unknown_idstatsvisit[$i]);
                $query->execute();
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
        }
        
        unset($stats_visitview_chk);
    }
    
    if($stats_visitview_bok_reallocatetableid === true)
    {
        reallocate_table_id('id_statsonline', 'stats_online');
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
