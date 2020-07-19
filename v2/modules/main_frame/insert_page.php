<?php
if(isset($_GET['page']))
{
    $pageok = trim(htmlspecialchars($_GET['page'], ENT_QUOTES));

    try
    {
        include('modules/main_frame/insert_page/insert_page_getinfo.php');
    }
    catch (Exception $e)
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
    
    if(isset($_GET['block']))
    {
        if($_GET['block'] == 1)
        {
            include('modules/settings/css/block/block_main.php');
        }
    }

    if($Bok_error_404 == false)
    {
        if((checkrights($main_rights_log, $rights_page, $main_dispatcher_rewritingF)) === true)
        {
            if((checkrights($main_rights_log, '0,1,2,3,4,5', '', true)) === true)
            {
                include('modules/stats/page/page_main.php');
            }
            switch($template_page)
            {
                case 'default':
                    include('modules/main_frame/template/page/default.php');
                    break;
                case 'custom_immo_default':
                    include('modules/main_frame/template/page/custom_immo_default.php');
                    break;
                case 'custom_immo':
                    include('modules/main_frame/template/page/custom_immo.php');
                    break;
                case 'page_default':
                    include('modules/main_frame/template/page/page_default.php');
                    break;
                case 'home_default':
                    include('modules/main_frame/template/page/home_default.php');
                    break;

                default:
                    include('modules/main_frame/template/page/default.php');
                    break;
            }
        }
    }
    else
    {
        if(empty($_SESSION['index_fist_load']))
        {
            $_SESSION['index_fist_load'] = 'notempty';
            header('Location: '.$config_customheader.$main_home_rewritingF);
        }
        else
        {
            if($_SESSION['index'] == 'index.php')
            {
                header('Location: '.$config_customheader.'Error/404');
            }
            else
            {
                header('Location: '.$config_customheader.'Backoffice/Error/404');
            }    
        }
    }
}
else
{
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.'Accueil');
    }
    else
    {
        header('Location: '.$config_customheader.'Backoffice/Accueil');
    }
}

?>
