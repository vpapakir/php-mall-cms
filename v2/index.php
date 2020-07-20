<?php 

session_start();
ob_start("ob_gzhandler");

$COOBOX_BASE_URL = $_SERVER['REQUEST_URI'];
$_SESSION['index'] = 'index.php';
$main_browsertitle = "";
if (isset($_COOKIE["language"]))
{
	if($_SESSION['current_language'] != $_COOKIE["language"]) {
		$_SESSION['current_language'] = $_COOKIE["language"];
	}
}

$include_dbconnect_info = "modules/dbconnect/dinxdev/dbconnect_info.php";
try {
	include('modules/dbconnect/dinxdev/dbconnect.php');
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
include('modules/functions/function.php');


if (isset($_SESSION['current_log_iduser'])) {
	$main_iduser_log = $_SESSION['current_log_iduser'];
} else {
	$main_iduser_log = "";
}

if (isset($_SESSION['current_log_rightsuser'])) {
	$main_rights_log = $_SESSION['current_log_rightsuser'];
} else {
	$main_rights_log = "";
}
if (isset($_SESSION['current_language'])) {
	$main_id_language = $_SESSION['current_language'];
} else {
	$main_id_language = 1;
}
$redirection = false;
include('config/config_main.php');
include('config/config_admin.php');
include('config/config_image.php');
include('modules/pdf/pdf.php');
include('structure/config_structure.php');
include('modules/language/language/language_switch.php');
include('modules/finance/currency/currency_switch.php');
include('modules/stats/visit/statsvisit_main.php');
include('config/config_valuerelated.php');

#$_SESSION['current_page'] = trim(htmlspecialchars($_GET['page'], ENT_QUOTES));
#$main_id_currency = $_SESSION['current_currency'];
#$main_coef_currency = $_SESSION['current_coef_currency'];
#$main_rate_currency = $_SESSION['current_rate_currency'];
#$main_code_currency = $_SESSION['current_code_currency'];
#$main_selectedcode_currency = $_SESSION['current_selectedcode_currency'];
#$main_selectedsymbol_currency = $_SESSION['current_selectedsymbol_currency'];
#$main_priority_currency = $_SESSION['current_priority_currency'];
#$main_onlinestatus_log = $_SESSION['current_log_onlinestatususer'];
#$blocktitle_box_structure = 21;
#$blockcontent_box_structure = 22;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
    <head>
        <title><?php echo($main_browsertitle); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="Title" content="<?php //echo($main_currentpage_title); ?>">
        <meta name="Description" content="<?php //echo($main_currentpage_intro); ?>">
        <meta name="Keywords" content="<?php //echo(cut_string($main_currentpage_tags, 0, 256, '')); ?>">
        <meta name="Author" content="<?php echo($config_meta_author); ?>">
        <meta NAME="Publisher" content="<?php echo($config_meta_publisher); ?>">
        <meta name="Copyright" content="<?php //echo($config_meta_author.' - '.$main_currentpage_browser); ?>">
        <meta http-equiv="Reply-To" content="<?php echo($config_meta_replyto); ?>">
        <meta http-equiv="Content-Language" content="<?php echo(strtolower($main_meta_currentlangcode)); ?>">       
        <meta name="Robots" content="<?php echo($config_meta_robots); ?>">
        <meta name="Creation_Date" content="<?php echo($config_meta_creationdate); ?>">
        <meta name="Revisit-After" content="<?php echo($config_meta_revisitafter.' days'); ?>">
<?php
        if(!empty($config_meta_category))
        {
?>        
            <meta name="Category" content="<?php echo($config_meta_category); ?>">
<?php
        }
        
        if(!empty($config_link_icopath))
        {
?>        
            <link rel="shortcut icon" href="<?php echo($config_customheader.$config_link_icopath); ?>">
<?php
        }
?>
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
    </head>             
        <?php 
		//get language cookie            
		include('structure/body/body1.php');
        ?>
</html>
