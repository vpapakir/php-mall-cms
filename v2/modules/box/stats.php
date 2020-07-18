<?php
include('modules/stats/visit/statsvisit_getinfo.php');
include('modules/stats/page/page_getinfo.php');
include('modules/stats/member/member_getinfo.php');
include('modules/stats/online/online_getinfo.php');
if(!empty($main_iduser_log) && $main_iduser_log == 1 && (checkrights($main_rights_log, '9', $redirection, true) === true))
{
    //include('modules/stats/admin/admin_getinfo.php');
}
?>
<td style="background-color: <?php echo($tablebg_box); ?>;"><table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" width="100%">        
            <span class="font_main" style="font-size: 10px;">
<?php
                if(checkrights($main_rights_log, '6,7,8,9', $redirection, $excludeSA) === true)
                {
                    try
                    {
                        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                                           INNER JOIN page_translation
                                           ON page.id_page = page_translation.id_page
                                           WHERE family_page_translation = "rewritingF"
                                           AND url_page = "stats_visit"';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        if(($data = $query->fetch()) != false)
                        {
                            $stats_page_rewritingF = $data[0];
                        }
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
?>
                    <a href="<?php echo($config_customheader.$stats_page_rewritingF); ?>" class="link_main" style="font-size: 10px;">
                        <?php give_translation('main.statsbox_subtitle_visit', $echo, $config_showtranslationcode); ?>
                    </a>
<?php
                }
                else
                {
                    give_translation('main.statsbox_subtitle_visit', $echo, $config_showtranslationcode);
                }
?>                
            </span>
        </td>
        <td align="right">
            <span class="font_main" style="font-size: 10px;">
                <?php
                    echo($stats_boxvisit_count);
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" width="100%">        
            <span class="font_main" style="font-size: 10px;">
<?php
                if(checkrights($main_rights_log, '6,7,8,9', $redirection, $excludeSA) === true)
                {
                    try
                    {
                        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                                           INNER JOIN page_translation
                                           ON page.id_page = page_translation.id_page
                                           WHERE family_page_translation = "rewritingF"
                                           AND url_page = "stats_page"';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        if(($data = $query->fetch()) != false)
                        {
                            $stats_page_rewritingF = $data[0];
                        }
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
?>
                    <a href="<?php echo($config_customheader.$stats_page_rewritingF); ?>" class="link_main" style="font-size: 10px;">
                        <?php give_translation('main.statsbox_subtitle_page', $echo, $config_showtranslationcode); ?>
                    </a>
<?php
                }
                else
                {
                    give_translation('main.statsbox_subtitle_page', $echo, $config_showtranslationcode);
                }
?>
            </span>
        </td>
        <td align="right">
            <span class="font_main" style="font-size: 10px;">
                <?php
                    echo($stats_page_count);
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" width="100%">        
            <span class="font_main" style="font-size: 10px;">
                <?php give_translation('main.statsbox_subtitle_online', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="right">
            <span class="font_main" style="font-size: 10px;">
                <?php
                    echo($stats_online_count);
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" width="100%">        
            <span class="font_main" style="font-size: 10px;">
                <?php give_translation('main.statsbox_subtitle_member', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="right">
            <span class="font_main" style="font-size: 10px;">
                <?php
                    echo($stats_member_count);
                ?>
            </span>
        </td>
    </tr>
<?php
if(!empty($main_iduser_log) && $main_iduser_log == 1 && (checkrights($main_rights_log, '9', $redirection, true) === true) && !empty($stats_admin_useronline[0]))
{
?>
    <tr>
        <td colspan="2"><div style="height: 2px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 2px;"></div></td>
    </tr>
    <tr>
        <td align="left" colspan="2"><table width="100%" cellpadding="0" cellspacing="1">
<?php
    unset($stats_admin_onlineimage, $stats_admin_onlinealtimage, $stats_admin_onlinetitleimage);
    for($i = 0, $count = count($stats_admin_useronline); $i < $count; $i++)
    {
        switch ($stats_admin_useronline[$i])
        {
            case '1':
                $stats_admin_onlineimage = $config_image_status_online;
                $stats_admin_onlinealtimage = strrchr($config_image_status_online, '/');
                $stats_admin_onlinetitleimage = 'Online';
                break;
            case '2':
                $stats_admin_onlineimage = $config_image_status_away;
                $stats_admin_onlinealtimage = strrchr($config_image_status_away, '/');
                $stats_admin_onlinetitleimage = 'Away';
                break;
            case '9':
                $stats_admin_onlineimage = $config_image_status_offline;
                $stats_admin_onlinealtimage = strrchr($config_image_status_offline, '/');
                $stats_admin_onlinetitleimage = 'Offline';
                break;
        }
        $stats_admin_onlinealtimage = str_replace('/', '', $stats_admin_onlinealtimage);
?>
        <tr>
            <td align="left">
                <img src="<?php echo($stats_admin_onlineimage); ?>" alt="<?php echo($stats_admin_onlinealtimage); ?>" title="<?php echo($stats_admin_onlinetitleimage); ?>"></img>
            </td>
            <td align="left" width="100%">
                <span class="font_main" style="margin-left: 2px;">
                    <?php
                       echo($stats_admin_usernick[$i]);
                    ?>
                </span>
            </td>
        </tr>
<?php
        unset($stats_admin_onlineimage, $stats_admin_onlinealtimage, $stats_admin_onlinetitleimage);
    }
    
    unset($stats_admin_useronline, $stats_admin_usernick);
?>
        </table></td>
    </tr>
<?php
}
?>
</table></td>




