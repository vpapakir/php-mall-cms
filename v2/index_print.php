<?php session_start();
ob_start("ob_gzhandler");

$include_dbconnect_info = 'modules/dbconnect/dinxdev/dbconnect_info.php';
include('modules/dbconnect/dinxdev/dbconnect.php');
include('modules/functions/function.php');
include('config/config_admin.php');
include('config/config_main.php');
include('config/config_image.php');
include('modules/pdf/pdf.php');
$_SESSION['index'] = 'index_print.php';

include('structure/config_structure.php');
include('modules/language/language/language_switch.php');
include('modules/finance/currency/currency_switch.php');
include('modules/stats/visit/statsvisit_main.php');

$_SESSION['current_page'] = trim(htmlspecialchars($_GET['page'], ENT_QUOTES));
$main_id_language = $_SESSION['current_language'];
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

if(isset($_GET['block']))
{
    if($_GET['block'] == 'true')
    {
        include('modules/settings/css/block/block_main.php');
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <title><?php echo($main_browsertitle); ?></title> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/block.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/font.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo($config_customheader); ?>modules/css/button.css"/>
        <script type="text/javascript" src="<?php echo($config_customheader); ?>modules/javascript/script.js"></script>       
        <script type="text/javascript" src="<?php echo($config_customheader); ?>external_modules/jquery/jquery.js" ></script>
        <script type="text/javascript">   
            window.onload = function()
            {                  
                window.print();
            }
        </script>
        
        <?php
            //include('modules/css/font.php');
            //include('modules/css/button.php');
            //include('modules/css/block.php');
        ?>        
    </head>       
<?php 
    include('modules/print/popup/body.php');
?>           
</html>