<?
$dir = "css";
if ($dp=@opendir($dir)) {
	while (false!==($file=readdir($dp))) {
		$filename = $dir.'/'.$file;
		if ($file!='.' && $file!='..' && is_file($filename)) {
			$css .= join(file($filename),"\n");
		}
	}
	closedir($dp);
}
	$layout = $HTTP_GET_VARS['layout'];
	$css = str_replace("{layout}",$layout,$css);

	/*
	$browser = $_SERVER['HTTP_USER_AGENT'];
	if (stristr($browser, "MSIE") || stristr($browser, "Internet Explorer")) {
	 	//IE
	} 
	elseif (stristr($browser, "Opera")) 
	{
		//opera
	}
	elseif (stristr($browser, "Mozilla")) 
	{
		 //mozila
	}
	else 
	{
		//all
	}
	*/
	header("Content-Type: text/css");
	print($css);
?>