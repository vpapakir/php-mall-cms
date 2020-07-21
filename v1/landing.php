<?
/*
if(empty($loaderName))
{
	die ('<div align="center">Sorry, this website is under construction	</div>');
}
*/
global $HTTP_SERVER_VARS;
$HTTP_SERVER_VARS = $_SERVER;
$loaderRootPath = "/var/www/vhosts/vpapakir.eu/mymall.vpapakir.eu/mymall/v1/";
$HTTP_HOST=$_SERVER['HTTP_HOST'];
define('LB',"\n");
ini_set('display_errors','1');
ini_set('allow_call_time_pass_reference','1');
//get config for rootPath
$configFile = $loaderRootPath.'config.php';
if(is_file($configFile))
{
	include_once($configFile);
	$rootPath = $mainConfig['Settings']['RootPath'];
	$dtr=$mainConfig['Settings']['DTR'];
	define('DTR',$dtr);	
}
else
{
	die('<center><font color="red"><b>FATAL ERROR: config.php file was not found</b></font></center>');
}

if(!empty($loaderConfig))
{
	foreach ($loaderConfig['Settings'] as $loaderConfigCode=>$loaderConfigValue)
	{
		$mainConfig['Settings'][$loaderConfigCode] = $loaderConfigValue;
	}
}

include_once($rootPath.'lib/Loader.lib.php');
//get variables with /


if(!empty($loaderName))
{
	$request = $HTTP_SERVER_VARS["REQUEST_URI"];
	$request = str_replace("http://".$HTTP_HOST,"",$request);
	$request = strstr($request,"/".$loaderName);
	$request = str_replace("/$loaderName/","",$request);
	parseGetRequest($request);
}
else
{
	if(empty($HTTP_POST_VARS['SID']) && !empty($HTTP_GET_VARS) && empty($HTTP_GET_VARS['SID']))
	{
		$i=0;
		foreach ($HTTP_GET_VARS as $variableName=>$variableValue){
			if($i==0) {$request = $variableName; $i++;} 
		}
		parseGetRequest($request);
	}
}
if($mainConfig['Settings']['ClientType']=='admin') {$defaultHomeSID = 'homeadmin';} else {$defaultHomeSID = 'home';}
if(!empty($HTTP_GET_VARS['SID'])) $SID = $HTTP_GET_VARS['SID'];
if (empty($SID)) {$SID = $defaultHomeSID; $HTTP_GET_VARS['SID']=$SID;}//section ID
if(empty($HTTP_POST_VARS['SID']) && !empty($HTTP_POST_VARS))
{
	$HTTP_POST_VARS['SID']=$HTTP_GET_VARS['SID'];
}



include_once($rootPath.'lib/Cache.lib.php');
$caheController = new CacheController();
$caheController->getPage($HTTP_GET_VARS);

include_once($rootPath.'lib/Core.lib.php');
include_once($rootPath.'lib/Interface.lib.php');
include_once($rootPath.'lib/Loader.lib.php');
include_once($rootPath.'lib/Templates.lib.php');
include_once($rootPath.'lib/DataSource.lib.php');

include_once($rootPath.'lib/WebServices/soaplocal.php');
$SERVER_SOAP = new SoapLocal();

$CORE = new SystemInterface();

//header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
//header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");  
//header("Cache-Control: post-check=0, pre-check=0",false);  
//session_cache_limiter("must-revalidate");
if($loaderName == 'rss')
{
	header("Content-Type: text/xml; charset=UTF-8");
}
else
{
	header("Content-Type: text/html; charset=UTF-8");
}

ob_start("coresystemMessagesHandler");
$CORE->getSession();
$CORE->loadDefinitions();
$retval = $CORE->printOutput();
//timeTracking('End');
ob_end_flush();


?>
