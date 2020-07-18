<?php
if(isset($_POST['bt_reset_statspageview']))
{
    unset($stats_pageview_chk);
    for($i = 0, $count = count($stats_pageview_idpage); $i < $count; $i++)
    {
        $stats_pageview_chk = htmlspecialchars($_POST['chk_statspage_page'.$stats_pageview_idpage[$i]], ENT_QUOTES);
        if($stats_pageview_chk == 1)
        {
            try
            {
                $prepared_query = 'UPDATE stats_page
                                   SET count_statspage = 0,
                                   firstdate_statspage = NOW(),
                                   date_statspage = NOW()
                                   WHERE id_page = :idpage';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->bindParam('idpage', $stats_pageview_idpage[$i]);
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
        
        unset($stats_pageview_chk);
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
