<?php
if($url_page == 'home_frontend')
{
    unset($_SESSION['msg_subscriptionform_emailsent']);
}

if($url_page == 'myaccount' && isset($_GET['user']))
{
    #registration confirmed by user
    include('modules/user/subscription/user_confirmedhisreg.php');
}

#CHECK & SET ONLINE STATUS
try
{
    $userlogged_time_afk = time() - $config_elapsedtime_afk;
    $userlogged_time_logout = time() - $config_elapsedtime_logout;
    #set AFK
    $prepared_query = 'UPDATE user
                       SET online_user = 2
                       WHERE current_timestamp_user < '.$userlogged_time_afk.'
                       AND current_timestamp_user > '.$userlogged_time_logout;
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $query->closeCursor();

    #set logout
    $prepared_query = 'UPDATE user
                       SET online_user = 9,
                       last_log_user = NOW()
                       WHERE current_timestamp_user < '.$userlogged_time_logout;
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $query->closeCursor();
    
    #set current time into statsonline
    $prepared_query = 'UPDATE stats_online
                       SET timestamp_statsonline = :time
                       WHERE sessionid_statsonline  = :sessionid';
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'time' => time(),
                          'sessionid' => session_id(),
                          ));
    $query->closeCursor();
    
    #set statusoffline into statsonline
    $statsonline_status_maxtime = time() - (5 * 60);
    $prepared_query = 'UPDATE stats_online
                       SET status_statsonline = 9
                       WHERE timestamp_statsonline < :maxtime';
    $query = $connectData->prepare($prepared_query);
    $query->execute(array('maxtime' => $statsonline_status_maxtime));
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

if(!empty($main_iduser_log))
{
    #change current online user status
    try
    {
        $prepared_query = 'UPDATE user
                           SET online_user = 1,
                           current_log_user = NOW(),
                           current_timestamp_user = :timestamp
                           WHERE id_user = :iduser';
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'timestamp' => time(),
                              'iduser' => $main_iduser_log
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
}

if(($url_page == 'home_frontend' && isset($_GET['logout']) && $_GET['logout'] == 'true') 
        || $main_onlinestatus_log == 9)
{
	/*setcookie( 'language', $_SESSION['current_language'], time() + 60*60*24*30*12,'/' );*/
	
    #destroy all sessions except stats
    #change user status
    try
    {
        $prepared_query = 'UPDATE user
                           SET online_user = 9,
                           last_log_user = NOW()
                           WHERE id_user = :iduser';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('iduser', $main_iduser_log);
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

    #destroy all sessions except...
    foreach($_SESSION as $key => $value)
    {
        if($key != 'stats_page_count' 
                && $key != 'stats_visit'
                && $key != 'current_language'
                && $key != 'current_currency')
        {
            unset($_SESSION[$key]);
        }
    }
	
	/*if (isset($_COOKIE["language"]))
	{
		$main_id_language = $_COOKIE["language"];
	} else {
		$main_id_language = $_SESSION['current_language'];
	}*/
	
	header('Location: '.$config_customheader.$main_home_rewritingF);   
}

if(empty($rewritingF_page))
{
    $rewritingF_page = 'index.php?page='.$url_page;
}

if(empty($rewritingB_page))
{
    $rewritingB_page = 'index_backoffice.php?page='.$url_page;
}

if($family_page == 'product')
{
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
        include('modules/custom/immo/modules/main_frame/insert_page_getinfo.php');
    }
}
?>
