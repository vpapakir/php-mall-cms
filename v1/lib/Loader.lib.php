<?php
//start PHP Session
$sessionHandler='cookies';
if($sessionHandler=='phpsession')
{
	session_name('xsid');
	$sessionCookieTimeout=$mainConfig['Settings']['CookieTimeout'];
	//$sessionApplicationDomain=trim($resultSettings[1]);
	$sessionCookieName=$mainConfig['Settings']['CookieName'];
	// set the session cookie parameters
	if($sessionCookieTimeout>0){
		$sessionCookieTime=time() + $sessionCookieTimeout;
	}else{
		$sessionCookieTime=0;
	}
	$endCookieTime = (int) $sessionCookieTime;
	//session_set_cookie_params($endCookieTime,'/','',0);
	ini_set('session.cookie_lifetime',(3600*24*365)); // makes cookie good for a year
	ini_set('url_rewriter.tags','');
	session_start();
	if (!session_is_registered($sessionCookieName)) {session_register($sessionCookieName);}
}
//recursive function to get all php files in a directory (including all subderictories)
function getLibFiles($dirPath,$files=[])
{
	$dir = $dirPath;
	if ($dp=@opendir($dir)) {
		while (false!==($file=readdir($dp))) {
			$filename = $dir.'/'.$file;
			if ($file!='.' && $file!='..' && is_file($filename)) {
				$files[]['File'] = $filename;
			}
			elseif($file!='.' && $file!='..' && is_dir($filename))
			{
				$rs = getLibFiles($filename,$files);
				if(is_array($files) && is_array($rs))
				{
					$files = arrayMerge($files,$rs);
				}
				elseif(!is_array($files))
				{
					$files = $rs;
				}
			}
		}
		closedir($dp);
	}
	return $files;
}

$libFiles = getLibFiles ($rootPath.'lib/CommonClasses');
foreach($libFiles as $libFile)
{
	include_once $libFile['File'];
}

$libFiles = getLibFiles ($rootPath.'lib/DataTypes');
foreach($libFiles as $libFile)
{
	include_once $libFile['File'];
}


//parse search engine friendly GET requests. Format of the request : url?sidname/variable1name/variable1value/variable2name/variable2value/variavle3name/v/value31/value32/value44/v/ ... array is not supported
function parseGetRequest($request)
{
	global $HTTP_GET_VARS, $mainConfig;
	//get the ConfigLoader string
	
	$loaderConfig = $mainConfig['LoaderConfig'];
	$loaderEnd = $loaderConfig['loaderend'];
	$loaderDelmiter = $loaderConfig['delimiter'];
	$loaderDefaultVariable = $loaderConfig['DefaultVariable'];
	$loaderVariables = $loaderConfig['Variables'];
	
	$loaderEndPos = strpos($request,$loaderEnd);
	$loaderString = substr($request,0,$loaderEndPos);
	if(!empty($loaderString))
	{
		//echo $loaderString;
		$request = substr($request,$loaderEndPos+1);	
		$mainConfig['Settings']['url'] = $mainConfig['Settings']['rooturl'].$mainConfig['Settings']['LoaderName'].'/'.$loaderString.$loaderEnd;
//		$mainConfig['Settings']['url'] = $mainConfig['Settings']['rooturl'].$mainConfig['Settings']['LoaderName'].'/';
		$mainConfig['Settings']['LoaderLink'] = $loaderString.$loaderEnd;
		$mainConfig['Settings']['adminurl'] = $mainConfig['Settings']['rooturl'].'adm/'.$mainConfig['Settings']['LoaderLink'];
		$mainConfig['Settings']['mainurl'] = $mainConfig['Settings']['rooturl'].'go/'.$mainConfig['Settings']['LoaderLink'];
		$mainConfig['Settings']['sslurl'] = str_replace('http://',"https://",$mainConfig['Settings']['url']);
		
		$loaderParts = explode($loaderDelmiter,$loaderString);
		if(is_array($loaderParts))
		{
			if(count($loaderParts)==1)
			{
				$mainConfig['Settings'][$loaderDefaultVariable] = $loaderParts[0];
				if($loaderDefaultVariable=='lang')
				{
					$mainConfig['Settings']['RequestedLanguage'] = $loaderParts[0];
				}				
			}
			else
			{
				$li=0;
				$loaderVariablesNumber = count($loaderVariables);
				foreach($loaderParts as $loaderItemID=>$loaderItemValue)
				{
					$currentLoaderVariableName = $loaderVariables[$loaderItemID];
					$mainConfig['Settings'][$currentLoaderVariableName] = $loaderItemValue;
					if($currentLoaderVariableName=='lang')
					{
						$mainConfig['Settings']['RequestedLanguage'] = $loaderItemValue;
					}
					if($loaderItemID>=$loaderVariablesNumber)
					{
						$li++;
						$loaderRequestedParts[$li] = $loaderItemValue;
					}
				}
			}
		}
	}
	//get requetsed variables from loader
	if(is_array($loaderRequestedParts))
	{
		$loaderRequestPartsNumber = count($loaderRequestedParts);
		for ($i = 1; $i <= $loaderRequestPartsNumber; $i=$i+2)
		{
			$loaderRequestValueNumber = $i+1;
			$loaderRequestVariableValue = $loaderRequestedParts[$loaderRequestValueNumber];
			$loaderRequestVariableName = $loaderRequestedParts[$i];
			$HTTP_GET_VARS[$loaderRequestVariableName] = $loaderRequestVariableValue;
		}
	}
	//print_r($mainConfig);
	//echo 'rrrr='.$loaderString;
	//echo '$request='.$request;
	//$requestParts1 = explode("?",$request);
	$requestParts = explode("--",$request);
	if(count($requestParts)>1)
	{
		$subRequestPartsNumber = count($requestParts)-1;
		$HTTP_GET_VARS['SID']=$requestParts[0];
		for ($i = 1; $i <= $subRequestPartsNumber; $i=$i+2)
		{
			$subRequestValueNumber = $i+1;
			$subRequestVariableValue = $requestParts[$subRequestValueNumber];
			$subRequestVariableName = $requestParts[$i];
			if($i == $subRequestPartsNumber)
			{
				$HTTP_GET_VARS[$subRequestVariableName] = $requestVariableValue;
			}
			else
			{
				$subRequestVariableName = $requestParts[$i];
				$HTTP_GET_VARS[$subRequestVariableName] = $subRequestVariableValue;
			}
		}		
	}
	else
	{
		//parse requests with /
		$requestParts = explode("/v/",$request);
		$requestPartsNumber = count($requestParts)-1;
		for ($i = 0; $i <= $requestPartsNumber; $i=$i+2)
		{
			$valueNumber=$i+1;
			$requestVariableValue = $requestParts[$valueNumber];
			$subRequest = $requestParts[$i];
			$subRequestParts = explode("/",$subRequest);
			$subRequestPartsNumber = count($subRequestParts)-1;
			if($i==0) {$subStart=1; $HTTP_GET_VARS['SID']=$subRequestParts[0];} else {$subStart=0;}
			for ($i2 = $subStart; $i2 <= $subRequestPartsNumber; $i2=$i2+2)
			{
				$subRequestValueNumber = $i2+1;
				$subRequestVariableValue = $subRequestParts[$subRequestValueNumber];
				$subRequestVariableName = $subRequestParts[$i2];
				if($i2 == $subRequestPartsNumber)
				{
					$HTTP_GET_VARS[$subRequestVariableName] = $requestVariableValue;
				}
				else
				{
					$subRequestVariableName = $subRequestParts[$i2];
					$HTTP_GET_VARS[$subRequestVariableName] = $subRequestVariableValue;
				}
			}
		}
	}
	//print_r($HTTP_GET_VARS);
}

function setVariableIntoSystemLoader($variables,$values)
{
	global $mainConfig;

	$loaderConfig = $mainConfig['LoaderConfig'];
	$loaderEnd = $loaderConfig['loaderend'];
	$loaderDelmiter = $loaderConfig['delimiter'];
	$loaderDefaultVariable = $loaderConfig['DefaultVariable'];
	$loaderVariables = $loaderConfig['Variables'];
	
	if(!empty($values))
	{
		if(is_array($variables))
		{
			foreach($variables as $id=>$variable)
			{
				$strinToAdd .= $variable.$loaderDelmiter.$values[$id];
			}
		}
		elseif(!empty($variables))
		{
			//check if this is standart variables
			
			$strinToAdd = $variables.$loaderDelmiter.$values;
		}
	}
	
	$requestedString = str_replace($mainConfig['Settings']['rooturl'],"",$mainConfig['Settings']['url']);
	$loaderString = str_replace($mainConfig['Settings']['LoaderName'].'/',"",$requestedString);
	$loaderString = str_replace('/',"",$loaderString);
	$loaderString = $loaderString.$loaderDelmiter.$strinToAdd.$loaderEnd;
	$mainConfig['Settings']['url'] = $mainConfig['Settings']['rooturl'].$mainConfig['Settings']['LoaderName'].'/'.$loaderString;
}

function timeTracking($name,$place='')
{
	global $timeTracking;
	$timeTrackingStart = $timeTracking[0]['value'];
	list($usec, $sec) = explode(" ",microtime()); 
	$microtime = ((float)$usec + (float)$sec);
	if(empty($timeTrackingStart))
	{
		$timeTracking[0]['value'] = $microtime;
		$timeTracking[0]['name'] = "Start";
	}
	else
	{
		$trackingsNumber = count($timeTracking)+1;
		$timeTracking[$trackingsNumber]['value'] = $microtime - $timeTrackingStart;
		$timeTracking[$trackingsNumber]['name'] = $name;		
	}

	if($name=='End')
	{
		$result = '<br><small><font color="999999">';
		foreach($timeTracking as $row)
		{
			if($row['name']!='Start')
			{
				$result .=$row['name'].': '.$row['value'].' <br> ';
			}
		}
		$result .= '</font></small>';		
		echo $result;
	}
			
}

function coresystemMessagesHandler($buffer)
{
	global $CORE, $caheController, $HTTP_GET_VARS;
	$systemMessages = $CORE->getMessages();
	
	$config = $CORE->getConfig();
	$layout = $config['Layout'];
	$clientType = $config['ClientType'];
	$templateFile = $config['RootPath']."templates/$clientType/layouts/$layout/systemMessages.tpl.php";
	if(is_file($templateFile))
	{
		include_once($templateFile);
	}
	/*
	if(eregi("Parse error", $buffer) or eregi("Warning", $buffer))
	{
		return 'HeHeHe!!!: you have an error';
	}
	else
	{
		return $buffer;
	}
	*/
	$result = str_replace('{SystemMessages}',$messages,$buffer);
	$result = $caheController->setPage($result,$HTTP_GET_VARS);
	return $result;
}

function arrayMerge($array1,$array2)
{
	 if(is_array($array1) && is_array($array2))
	 {
	 	$result = array_merge($array1,$array2);
	 }
	 elseif(is_array($array1))
	 {
	 	$result = $array1;
	 }
	 else
	 {
	 	$result = $array2;
	 }
	 
	 return $result;
}
?>
