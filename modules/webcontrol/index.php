<?
//XCMSPro: Web Service Server
$modulePath = dirname(ereg_replace("\\\\","/",__FILE__));
//Classes loader
$libFiles = getLibFiles ("$modulePath/classes");
foreach($libFiles as $libFile)
{
	include_once $libFile['File'];
}
//Interfaces loader
if ($dp=@opendir($modulePath)) {
	while (false!==($file=readdir($dp))) {
		$filename = $modulePath.'/'.$file;
		if ($file!='.' && $file!='..' && is_file($filename) && eregi("\.php",$file) && $file!='index.php') {
			include_once($filename);
		}
	}
	closedir($dp);
}

?>