<?
	include_once('config.php');
	$DBConfig = $mainConfig['db']['main'];
	$config = $mainConfig['Settings'];
	$GMT_dif = $config['GMT']; // Difference from whre you live to GMT time
	//Initiate mySQL
	mysql_connect($DBConfig['host'],$DBConfig['user'],$DBConfig['password']) or die("Unable to connect to database");
	mysql_select_db($DBConfig['name']) or die("Database selection failed");
	//Prepare Variables for INSERT
	//Declare ARRAYS
	$os_search = array("Windows 2000", "Windows 98", "Windows 95", "Win95", "Win98", "Windows NT 4.0", "Windows NT 5.0", "Windows NT 5.1", "Windows XP", "Windows ME", "WinNT", "Mac_PowerPC", "Macintosh", "SunOS", "Linux");
	$os = array("Windows 2000", "Windows 98", "Windows 95", "Windows 95", "Windows 98", "Windows NT 4.0", "Windows NT 5.0", "Windows XP", "Windows XP", "Windows ME", "WinNT", "Macintosh", "Macintosh", "SunOS", "Linux");
	$browser_search = array("MSIE 6.0", "MSIE 5.5", "MSIE 5.0", "MSIE 4.0","Opera","Konqueror","Mozilla/5", "Mozilla/4", "Mozilla");
	$browser = array("Internet Explorer 6","Internet Explorer 5.5", "Internet Explorer 5", "Internet Explorer 4", "Opera","Konqueror","Netscape 6.x", "Netscape 4.x", "Netscape");
	// Search for OS
	$other = 1;
	while(list($key, $value) = each ($os_search)) {
		$pos = strpos ($HTTP_USER_AGENT, $value);
		if($pos !== false){
			$OPSYS = $os[$key];
			$other = 0;
			break 1;
		}
	}
	if($other != 0){ $OPSYS = "Other"; }
	// Search for BROWSER
	$other = 1;		
	while(list($key, $value) = each ($browser_search)) {
		$pos = strpos ($HTTP_USER_AGENT, $value);
		if($pos !== false){
			$IBROWSER = $browser[$key];
			$other = 0;
			break 1;
		}
	}
	if($other != "0"){ $IBROWSER = "Other"; }
	// Search for HOSTMASK		
	$HOSTMASK = gethostbyaddr($REMOTE_ADDR);
	// Obtain DATE and TIME date
	$time = mktime(gmdate("G")+$GMT_dif,gmdate("i"),gmdate("s"),gmdate("n"),gmdate("j"),gmdate("Y"));
	$MONTH = strftime ("%B", $time);
	$DAY_OF_MONTH = strftime ("%d", $time);
	$YEAR = strftime ("%G", $time);
	$HOUR = strftime ("%H", $time);
	$MINUTE = strftime ("%M", $time);
	$SECOND = strftime ("%S", $time);
	$DAY_OF_YEAR = strftime ("%j", $time);
	$DAY_OF_WEEK = strftime ("%A", $time);		
	// REFERRER
	$from_temp = explode("?", $from);
	if($from_temp[0] == ""){
		$from = "Direct Hit";
	}	else {
		$from = $from_temp[0];
	}
	$resource = addslashes($resource);
	if (eregi ("http://",$request))
	{
		$requestpage = spliti("PHPSESSID",$request);
		$request = $requestpage[0];
		// INSERT data into mySQL	
		$query = "INSERT INTO StatsRecord (website, ip, hostmask, user_agent, os, browser, res, max_res, colordepth, java, referrer, query, filename, year, month, day_of_month, day_of_year, day_of_week, hour, minute, second, resource) VALUES ('$website','$REMOTE_ADDR','$HOSTMASK','$HTTP_USER_AGENT','$OPSYS','$IBROWSER','$resol','$maxresol','$cDepth','$java','$from','$query','$request','$YEAR','$MONTH','$DAY_OF_MONTH','$DAY_OF_YEAR','$DAY_OF_WEEK','$HOUR','$MINUTE','$SECOND','$resource')";
	  	$result = mysql_query($query) or die("Error Inserting Stats");
	}
	Header("Location: content/root/en/images/icons/hit.gif");
?>