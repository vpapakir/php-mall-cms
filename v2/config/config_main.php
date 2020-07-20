<?php
try
{
    $prepared_query = 'SELECT * FROM config_main
                       WHERE id_config_main = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $config_email_sendername = $data['custom_email_sendername'];
        $config_email_senderemail = $data['custom_email_senderemail'];
        $config_email_bcc = $data['custom_email_bcc'];
        $config_noimage_origin = $data['custom_noimage_origin'];
        $config_noimage_search = $data['custom_noimage_search'];
        $config_elapsedtime_afk = $data['custom_elapsedtime_afk'] * 60;
        $config_elapsedtime_logout = $data['custom_elapsedtime_logout'] * 60;
        $config_meta_author = $data['custom_meta_author'];
        $config_meta_replyto = $data['custom_meta_replyto'];
        $config_meta_creationdate = $data['custom_meta_creationdate'];
        $config_meta_revisitafter = $data['custom_meta_revisitafter'];
        $config_meta_robots = $data['custom_meta_robots'];
        $config_meta_category = $data['custom_meta_category'];
        $config_meta_publisher = $data['custom_meta_publisher'];
        $config_link_icopath = $data['custom_link_icopath'];
    }
    
    if(isset($_GET['page']))
    {
        $prepared_query = 'SELECT family_page, ajaxpath_page FROM page
                           WHERE url_page = :page';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('page', trim(htmlspecialchars($_GET['page'], ENT_QUOTES)));
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $config_family_page = $data[0];
            $config_scriptajax_page = $data[1];
        }
        
        $config_scriptajax_page = split_string($config_scriptajax_page, '$');
    }
    
    $timestamp_day = 3600 * 24;
    $day_maxday = 7;
    
    $config_birthday_maxyear = (date('Y', time())) - 18;
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
