<?php session_start();
ob_start("ob_gzhandler");

$include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
include('modules/dbconnect/dinxdev/dbconnect.php');
include('modules/functions/function.php');
include('config/config_admin.php');
include('config/config_main.php');
include('config/config_image.php');
$_SESSION['index'] = 'index_backoffice.php';
$user_language = 'L1'; /*'lang' Session value included in a variable*/
//$config_customheader = $COOBOX_BASE_URL; //$myUrl1 defined in config_main.php

if(isset($_GET['page']) && empty($_GET['page']))
{
    if(empty($_SESSION['index_backoffice_first_load']))
    {
        $pageok = 'home_backoffice';
        $_SESSION['index_backoffice_first_load'] = 'notempty';
    } 
}

include('structure/config_structure.php');
//include('structure/sitemap.php');
include('modules/language/language/language_switch.php');
include('modules/finance/currency/currency_switch.php');

$_SESSION['current_page'] = trim(htmlspecialchars($_GET['page'], ENT_QUOTES));
$main_id_language = $_SESSION['current_currency'];
$main_id_currency = $_SESSION['current_currency'];
$main_coef_currency = $_SESSION['current_coef_currency'];
$main_rate_currency = $_SESSION['current_rate_currency'];
$main_code_currency = $_SESSION['current_code_currency'];
$main_selectedcode_currency = $_SESSION['current_selectedcode_currency'];
$main_selectedsymbol_currency = $_SESSION['current_selectedsymbol_currency'];
$main_priority_currency = $_SESSION['current_priority_currency'];
$main_iduser_log = $_SESSION['current_log_iduser'];
$main_rights_log = $_SESSION['current_log_rightsuser'];
$main_onlinestatus_log = $_SESSION['current_log_onlinestatususer'];
include('config/config_valuerelated.php');
//include('modules/header_refresh/refresh_main.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/block.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/font.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/button.css"/>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>modules/javascript/script.js"></script>
<?php
        if(!empty($config_scriptajax_page[0]))
        {
?>
            <script type="text/javascript" src="<?php echo($config_customheader); ?>modules/ajax/XHTobject.js"></script>
<?php
            for($i = 0, $count = count($config_scriptajax_page); $i < $count; $i++)
            {
?>
                <script type="text/javascript" src="<?php echo($config_customheader.$config_scriptajax_page[$i]); ?>"></script>
<?php  
            }
        }
?>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/jquery/jquery.js" ></script>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/jscolor/jscolor.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/wysiwyg/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/wysiwyg/tinymce/jscripts/tiny_mce/basic_config.js"></script>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide-with-html.js"></script>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.config.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>external_modules/popup/highslide/highslide.css"/>      
        
        <?php
            //include('modules/css/font.php');
            //include('modules/css/button.php');
            //include('modules/css/block.php');
        ?>
        
        <title><?php echo($main_browsertitle); ?></title>
    </head>       
        
        <?php       
        include('structure/body/body1.php');
        ?>
            
</html>
