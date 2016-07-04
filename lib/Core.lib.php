<?
class SystemCore
{
    // PRIVATE PROPERTIES
	//configuration info
	var $_config = array();
	//temporary data 
	var $_input = array();// GET+POST data
	var $_cookie = array();//cookies data
	var $_session = array();//data stored in session
	var $_sessionID;
	var $_sessionIP;// remote IP address
	var $_messages = array();// system messages
	var $_messagesLang;//string the systemmessages language references
	var $_debug = array();// debugin messages
	var $_user = array();// user's persona; info
	var $_rights = array();// not used now
	var $_log = array();// not used now

	// PRIVATE METHODS
    /**
    * Deletes all unallowed HTML tags
    *
    * @param	string	$value	the value
    * @param	string	$mode	the mode ofclening: NULL - full clean, notags - do not delete tags, nocheckwords 
	* @return	string			cleaned string
    * @access 	private
    */		
	function _cleanUpString ($value, $mode='')
	{
		//refact2 : add the code for otehr modes
		//return addslashes($this->_checkHTML($this->_checkWords($value)));
		return addslashes(stripslashes($this->_checkWords($value)));		
	}
    /**
    * Deletes all unallowed HTML tags
    *
    * @param	string	$value	the value
	* @return	string			cleaned string
    * @access 	private
    */		
	function _checkHTML ($value)
	{
		//refact1 - make the function to work with the defined tags
		$str = stripslashes($value);
	    // Get rid of any newline characters
	    $str = preg_replace("/\n/","",$str);
		$str = strip_tags($str,$this->_config['AllowableHTML']);
		return $str;
	}		

	function _checkWords ($Message)
	{
	//refact3 : make the code better, test it and make it to work
		$EditedMessage = $Message;
		if ($this->_config["CensorList"] != 0) {
			if (is_array($this->_config["CensorList"])) {
				$Replacement = $this->_config["CensorList"];
				if ($this->_config["CensorMode"] == 1) { # Exact match
					$RegExPrefix   = '([^[:alpha:]]|^)';
					$RegExSuffix   = '([^[:alpha:]]|$)';
				} elseif ($this->_config["CensorMode"] == 2) {    # Word beginning
					$RegExPrefix   = '([^[:alpha:]]|^)';
					$RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]|$)';
				} elseif ($this->_config["CensorMode"] == 3) {    # Word fragment
					$RegExPrefix   = '([^[:alpha:]]*)[[:alpha:]]*';
					$RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]*)';
				}
				for ($i = 0; $i < count($this->_config["CensorList"]) && $RegExPrefix != ''; $i++) {
					$EditedMessage = eregi_replace($RegExPrefix.$this->_config["CensorList"][$i].$RegExSuffix,"\\1$Replacement\\2",$EditedMessage);
				}
			}
		}
		return ($EditedMessage);
	}
	
	function _cleanAllOutput ($value, $key)
	{
		return $this->_addSlashes($value);
	}

	function _loadConfig ()
	{
		global $mainConfig;
		$loaderName = $mainConfig['Settings']['LoaderName'];
		/*
		$request = $HTTP_SERVER_VARS["REQUEST_URI"];
		$pos = strpos($request,"?");
		if(!empty($pos))
		{
			$request = substr($request,0,$pos);
			$mainConfig['Settings']['rooturl'] = str_replace("index.php","",$request);
		}
		else
		{
			$pos = strpos($request,$loaderName);
			if(!empty($pos))
			{
				$request = substr($request,0,$pos);
				$mainConfig['Settings']['rooturl']  = $request;
			}
			else
			{
				$mainConfig['Settings']['rooturl']  = str_replace("index.php","",$request);
			}	
		}		
		*/
		$mainConfig['Settings']['layout'] = $mainConfig['Settings']['rooturl'].'templates/'.$mainConfig['Settings']['ClientType'].'/layouts/'.$mainConfig['Settings']['Layout'].'/';
		$mainConfig['Settings']['urlfiles'] = $mainConfig['Settings']['rooturl'].'content/';

		$this->_config = $mainConfig['Settings'];	
		$this->_dbConfig = $mainConfig['db'];	
		$this->_ftpConfig = $mainConfig['ftp'];	
	}		

	function _loadDatabaseDefinition ()
	{
		global $databaseDefinition;
		$config = $this->getConfig();
		$rootPath = $config['RootPath'];
		$dir = $rootPath.'modules';
		//load boxes definitions		
		if ($dp=@opendir($dir)) {
			while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_dir($filename)) {
					$boxesDefinitionsFile = "$filename/definitions/databaseDefinition.php";
					if(is_file($boxesDefinitionsFile)){include_once $boxesDefinitionsFile;}
				}
			}
			closedir($dp);
		}
		
		$this->_databaseDefinition = $boxesDefinition;
	}	

	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function SystemCore()
	{	 
		global $REMOTE_ADDR, $HTTP_POST_VARS, $HTTP_GET_VARS, $debugMode, $SERVER_ROOT, $HTTP_COOKIE_VARS;
		$this->_loadConfig();		
		$this->_remoteAddr = $REMOTE_ADDR;
		$this->_debugMode = $debugMode;
		$this->_SID = $SID;
		$this->_cookie = $HTTP_COOKIE_VARS;
		
		if(!empty($HTTP_POST_VARS))
		{
			$input=$HTTP_POST_VARS;
			//as 28.07.2006 
			/*if(is_array($HTTP_GET_VARS))
			{
				foreach($HTTP_GET_VARS as $variableName=>$variableValue)
				{
					if(empty($input[$variableName]))
					{
						if($variableName!='actionMode' && $variableName!='viewMode')
						{
							$input[$variableName]=$variableValue;
						}
					}
				}
			}*/
			//as 28.07.2006
		}
		else
		{
			$input=$HTTP_GET_VARS;			
		}
		//print_r($input);
		$this->setInput($input);//clean up input	
		$this->_loadDatabaseDefinition();	
	}
	
	// PUBLIC METHODS
    /**
    * Gets the config in array format
	* @access public
    *
    */	
	
	function callService($method,$serviceID,$input='',$mode='')
	{
		global $CORE, $SERVER_SOAP;
		$config = $this->_config;
		$serviceURL = $config[$serviceID];
		if(eregi('http',$serviceID))
		{
			$serviceURL = $serviceID;
		}
		if(!empty($serviceURL))
		{
			include_once($config['RootPath'].'lib/WebServices/nusoap.php');
			$client = new soapclient ($serviceURL);
			//$in = $this->encodeInput($in);
			if(empty($input))
			{
				$input = $this->_input;
			}
			$in['input']['ServerRequest'] = base64_encode (serialize($input));
			$result = $client->call($method,$in);
			//echo 'encoded result:';
			//print_r($result);
			//echo '<hr>';		
			if(!empty($result))
			{
				$result = @base64_decode($result);
				//echo 'decoded result:';
				//print_r($result);
				//echo '<hr>';
				$result = @unserialize($result);	
				//print_r($result);
			}
			return	$result;
		}
		else
		{
			$moduleName = str_replace("Server","",$serviceID);
			$moduleFile = $config['RootPath'].'modules/'.$moduleName.'/index.php';
			if(is_file($moduleFile))
			{
				include_once($moduleFile);
				//$methodString = "if(function_exists($method)) {\$result = $method(\$input); }"; eval($methodString); //jb 4.12.05 old bad
				if(function_exists($method)) {$result = $method($input);}//new jb 4.12.05
				return $result;
			}
		}
	}
	
	function loadDefinitions()
	{
		global $SESSION, $CORE, $HTTP_SESSION_VARS, $HTTP_HOST, $boxesDefinition, $SERVER_SOAP;
		
		$boxesDefinition = $this->_boxesDefinition;
		$websiteDefinition = $this->_websiteDefinition;
		
		$config = $this->getConfig();
		$input = $this->getInput();
		$user =  $this->getUser();
		$ownerID = $config['OwnerID'];
		$DS = new DataSource('main');
		
		$requestedLanguage = $config['RequestedLanguage'];
		
		$currentStyle = $config['DefaultStyle'];
		if(empty($currentStyle)) {$currentStyle='style1';}
		//get owner
		$requestURL = $_SERVER['HTTP_HOST'];
		$requestURL  = str_replace("http://","",$requestURL);		
		$requestURL  = str_replace("www.","",$requestURL);
		
		$ownerRS = $DS->query("SELECT OwnerID, OwnerCode, OwnerDomain, OwnerName, OwnerStyle, OwnerType, UserID FROM Owner WHERE OwnerDomain='$requestURL' OR OwnerCode='$ownerID'");
		if(is_array($ownerRS))
		{
			foreach($ownerRS as $ownerInfo)
			{
				//if(!empty($ownerInfo['OwnerDomain']))
				//{
					if($ownerInfo['OwnerID']!=$ownerID)
					{
						$config['OwnerName'] = $this->getValue($ownerInfo['OwnerName']);
						$config['OwnerID'] = $ownerInfo['OwnerCode'];
						$config['OwnerStyle'] = $ownerInfo['OwnerStyle'];
						$config['OwnerType'] = $ownerInfo['OwnerType'];
						$config['OwnerUserID'] = $ownerInfo['UserID'];
					}
				//}
			}
		}
		//print_r($ownerInfo);
		//get settings

		if($config['OwnerID']!=$config['DefaultOwner'])
		{
			$ownerFilter = " OwnerID='".$config['OwnerID']."' OR OwnerID='".$config['DefaultOwner']."' ";
		}
		else
		{
			$ownerFilter = " OwnerID='".$config['OwnerID']."' ";
		}
		$settingQuery = "SELECT SettingValue, SettingValueType, SettingVariableName FROM Setting WHERE $ownerFilter";
		//echo $settingQuery;
		$settingRS = $DS->query($settingQuery);
		//get current owner info if needed
		if($config['OwnerID']!=$config['DefaultOwner'])
		{
			if(is_array($settingRS))
			{
				$i=0;
				foreach($settingRS as $row)
				{
					if($row['OwnerID']==$config['OwnerID'])
					{
						$currentCode = $row['SettingVariableName'];
						$ownerRS[$currentCode] = $row;
					}
					else
					{
						$notOwnerRS[$i] = $row;
						$i++;
					}
				}
			}

			if(is_array($ownerRS))
			{
				$settingRS='';
				$i=0;
				$row='';
				foreach($notOwnerRS as $row)
				{
					$currentCode = $row['SettingVariableName'];
					if(!empty($ownerRS[$currentCode]))
					{
						$settingRS[$i] = $ownerRS[$currentCode];
					}
					else
					{
						$settingRS[$i] = $row;
					}
					$i++;
				}
			}
			else
			{
				//$entityRS = $ownerRS;
			}			
		}		

		if(is_array($settingRS))
		{
			foreach($settingRS as $row)
			{
				$settingValueType = $row['SettingValueType'];
				$settingName = $row['SettingVariableName'];
				$settingValue= $row['SettingValue'];
				
				if($settingValueType=='text')
				{
					$settingName = str_replace($currentStyle.".","",$settingName);  
					$config[$settingName]= $this->getValue($settingValue);
				}
				elseif(eregi($currentStyle."\.",$settingName))
				{
					$settingName = str_replace($currentStyle.".","",$settingName);
					$config[$settingName]= $settingValue;
				}
				else
				{
					$config[$settingName]= $settingValue;
				}
			}
		}
		
		//print_r($config);
		if($config['OwnerType']=='virtual')
		{
			$config['Layout'] = $config['VirtualWebsiteLayout'];
			$config['layout'] = $config['rooturl'].'templates/'.$config['ClientType'].'/layouts/'.$config['Layout'].'/';
			if($input['SID']=='home')
			{
				$this->setInputVar('SID','vhome');
				$input['SID'] = 'vhome';
			}
		}
		
		$result = $this->callService('getWebsiteDefinition','coreServer');
		$sectionID = $input['SID'];
		//print_r($result['DB']['Definition']);
		if(is_array($result['DB']['Definition']))
		{
			foreach($result['DB']['Definition'] as $row)
			{
				//print_r($row);
				$side = $row['BoxSide'];
				$currentBoxID = $row['BoxID'];
				$sectionBoxID = $row['SectionBox'];
				$sectionBoxStyle = $row['SectionBoxStyle'];
				$websiteDefinition[$sectionID][$side][$currentBoxID] = $boxesDefinition[$currentBoxID];
				$websiteDefinition[$sectionID][$side][$currentBoxID]['boxstyle'] = $row['BoxStyle'];		
				$websiteDefinition[$sectionID]['params']['AccessGroups'] = $row['AccessGroups'];
				$websiteDefinition[$sectionID]['params']['SectionArguments'] = $row['SectionArguments'];
				$websiteDefinition[$sectionID]['params']['SectionName'] = $this->getValue($row['SectionName']);
				$websiteDefinition[$sectionID]['params']['SectionButton'] = $row['SectionButton'];
				$websiteDefinition[$sectionID]['params']['SectionButtonHover'] = $row['SectionButtonHover'];
				$websiteDefinition[$sectionID]['params']['SectionIcon'] = $row['SectionIcon'];
				$config['PageID'] = $this->getValue($row['SectionID']);
				$config['PageName'] = $this->getValue($row['SectionName']);
				$config['PageTitle'] = $this->getValue($row['SectionTitle']);
				$config['PageDescription'] = $this->getValue($row['SectionDescription']);
				$config['PageKeywords'] = $this->getValue($row['SectionKeywords']);
				$config['PageHidden'] = $this->getValue($row['SectionHidden']);	
				$config['PageContent'] = $row['SectionContent'];
				$config['PageIntroContent'] = $row['SectionIntroContent'];
				$config['SectionListingText'] = $row['SectionListingText'];
				$config['PageViewOptions'] = $row['SectionViewOptions'];
				$config['PageViewType'] = $row['SectionViewType'];
				$config['PageResourceType'] = $row['SectionResourceType'];
				$config['PageCommentsOptions'] = $row['SectionCommentsOptions'];
				$config['PageActionOptions'] = $row['SectionActionOptions'];
				$config['PageLayout'] = $row['SectionLayout'];							
				$config['PageIcon'] = $row['SectionIcon'];	
				$config['PageImage'] = $row['SectionImage'];
				$config['PageTitleImage'] = $row['SectionTitleImage'];
				$config['PageButtonCurrent'] = $row['SectionButtonCurrent'];
				$config['PageButtonHover'] = $row['SectionButtonHover'];
				$config['PageButton'] = $row['SectionButton'];
				$config['PageGroupID'] = $row['SectionGroupID'];
				$config['PageManagementLink'] = $row['SectionManagementLink'];
				$config['PageAccessEditUsers'] = $row['AccessEditUsers'];
				
			}
			$websiteDefinition[$sectionID]['center'][$sectionBoxID] = $boxesDefinition[$sectionBoxID];
			$websiteDefinition[$sectionID]['center'][$sectionBoxID]['boxstyle'] = $sectionBoxStyle;
		}
		
		if(empty($websiteDefinition[$sectionID]['params']['AccessGroups']) || eregi("\|".$user['GroupID']."\|",$websiteDefinition[$sectionID]['params']['AccessGroups'])  || eregi("\|all\|",$websiteDefinition[$sectionID]['params']['AccessGroups']))
		{
			//print_r($websiteDefinition[$sectionID]);
			if(!empty($websiteDefinition[$sectionID]['params']['SectionArguments']))
			{
				$this->getArguments($websiteDefinition[$sectionID]['params']['SectionArguments']);
			}
			$this->_websiteDefinition = $websiteDefinition;
			if(!empty($requestedLanguage)) {
				$langTestQuery = "SELECT LanguageCode FROM Language WHERE LanguageCode='$requestedLanguage'";
				$langTestRS = $DS->query($langTestQuery);
				if(!empty($langTestRS[0]['LanguageCode']))
				{
					$config['lang']=$requestedLanguage;
				}
			}
			else
			{
				$config['url'] = $config['rooturl'].''.$config['LoaderName'].'/'.$config['lang'].'/';
				$config['adminurl'] = $config['rooturl'].'adm/'.$config['lang'].'/';
			}
			
			$this->_config = $config;
			//get page defintions
			
			return '';					
		}
		else
		{
			
			if(!empty($requestedLanguage)) {
				$langTestQuery = "SELECT LanguageCode FROM Language WHERE LanguageCode='$requestedLanguage'";
				$langTestRS = $DS->query($langTestQuery);
				if(!empty($langTestRS[0]['LanguageCode']))
				{
					$config['lang']=$requestedLanguage;
				}
			}
			else
			{
				$config['url'] = $config['rooturl'].''.$config['LoaderName'].'/'.$config['lang'].'/';
				$config['adminurl'] = $config['rooturl'].'adm/'.$config['lang'].'/';
			}
			$this->_config = $config;
			die($CORE->goLink('loginform/'));
		}		
	}
	
	function getConfig($mode='')
	{
		return 	$this->_config;
	}	
	
	function getDBConfig($dbID)
	{
		$config = $this->_dbConfig;
		return $config[$dbID];
	}		
	
	function getCookies()
	{
		return $this->_cookie;
	}


	function setConfigVar ($varname,$varvalue)
	{
		$config = $this->_config;
		$config[$varname]=$varvalue;
		$this->_config = $config;
		//refact3 : for the case when the varname is an array
		return $this->_config;
	}		
    /**
    * Cleans up the input data and set the $_input array
    *
    * @param  array $inarray input data
    * @param  string $mode the mode of cleaning: default - clean up, asis - no clean up, alltags - does not clean up tags
	* @return	array	
    * @access public
    */
	//torefact1 : think on how to use array walk .. or think on the possibility to clean unlimited depth arrays
	//torefact2: think on how to use XML input.. this is for Server side call of this method
	function setInput ($input,$mode='')
	{
		if (!empty($input))
		{
			while (list($column,$Value)= each($input)) 		
			{
				// if column is array
				if (is_array( ($Value)))
				{
					while (list($column1,$Value1)= each($Value)) 		
					{
						if ($mode == 'alltags')
						{
							$input[$column][$column1]=addslashes(stripslashes($Value1));		
						}
						else
						{
							$input[$column][$column1]=$this->_cleanUpString($Value1);
						}
						$input[$column][$column1] = str_replace ('"','&quot;',$input[$column][$column1]);
						//$input[$column][$column1] = ereg_replace ('>','&gt;',$input[$column][$column1]);
						//$input[$column][$column1] = ereg_replace ('<','&lt;',$input[$column][$column1]);
					}
					continue;
				}
				if ($mode == 'alltags')
				{
					$input[$column] = addslashes(stripslashes($Value));
				}
				else
				{
					$input[$column] = $this->_cleanUpString($Value);
				}
				$input[$column] = str_replace ('"','&quot;',$input[$column]);				   
				//$input[$column] = ereg_replace ('>','&gt;',$input[$column]);				
				//$input[$column] = ereg_replace ('<','&lt;',$input[$column]);				
			}
		}
			$this->_input=$input;
			//print_r($input);
			return $input;
	}

	function cleanString ($value, $mode='')
	{
		$value = $this->_cleanUpString($value);
		if($mode!='noquotes')
		{
			$value = str_replace ('"','&quot;',$value);
		}
		return $value;		
	}
		
	function setInputVar ($varname,$varvalue)
	{
		if(!empty($varname))
		{
			$input = $this->_input;
			$input[$varname]=$this->_cleanUpString($varvalue);
			$this->_input = $input;
			//refact3 : for the case when the varname is an array
		}
		return $this->_input;
	}	
    /**
    * Gets the $_input array
    *
	* @param	string	$mode	can be empty all 'xml'
	* @return	array
    * @access public
    */
	function getInput($input='')
	{
		if(!empty($input['ServerRequest']))
		{
			//make up the request from server
			$resultDecoded = base64_decode($input['ServerRequest']);
			$result = unserialize($resultDecoded);
		}
		elseif(!empty($input))
		{
			$result = $input;
		}
		else
		{
			$result = $this->_input;
		}		
		return $result;
	}		
	
	function getOutput($in)
	{
		$result =  base64_encode(serialize($in));
		return $result;
	}
	
	function getString ($value, $mode='')
	{
		return $this->_cleanUpString($value);
	}		
	
	function getArguments($request,$mode='')
	{
		$input = $this->_input;
		if(!empty($request))
		{
			$requestParts = explode("/v/",$request);
			$requestPartsNumber = count($requestParts)-1;
			for ($i = 0; $i <= $requestPartsNumber; $i=$i+2)
			{
				$valueNumber=$i+1;
				$requestVariableValue = $requestParts[$valueNumber];
				$subRequest = $requestParts[$i];
				$subRequestParts = explode("/",$subRequest);
				$subRequestPartsNumber = count($subRequestParts)-1;
				$subStart=0;
				for ($i2 = $subStart; $i2 <= $subRequestPartsNumber; $i2=$i2+2)
				{
					$subRequestValueNumber = $i2+1;
					$subRequestVariableValue = $subRequestParts[$subRequestValueNumber];
					$subRequestVariableName = $subRequestParts[$i2];
					if($i2 == $subRequestPartsNumber)
					{
						if($mode=='torestore')
						{
						 	$tempValue = $input[$subRequestVariableName];
							if(empty($tempValue)) {$tempValue='_';}
							$this->setTempInputVar($subRequestVariableName,$tempValue);
						}
						$this->setInputVar($subRequestVariableName,$requestVariableValue);
					}
					else
					{
						if($mode=='torestore')
						{
						 	$tempValue = $input[$subRequestVariableName];
							if(empty($tempValue)) {$tempValue='_';}
						 	$this->setTempInputVar($subRequestVariableName,$tempValue);
						}
						$subRequestVariableName = $subRequestParts[$i2];
						$this->setInputVar($subRequestVariableName,$subRequestVariableValue);				
					}
				}
				
			}
		}
	}
	
	function restoreArguments()
	{
		$tempInput = $this->_tempInput;
		//echo 'ggg';
		$input = $this->_input;
		if(is_array($tempInput))
		{
			foreach ($tempInput as $varName=>$varValue)
			{
				if(!empty($varName))
				{
					if($varValue=='_'){$varValue="";}
					$input[$varName]=$varValue;
				}
			}
		}
		$this->_tempInput='';
		$this->_input=$input;
	}	

	function setTempInputVar ($varname,$varvalue)
	{
		$tempInput = $this->_tempInput;
		$tempInput[$varname]=$this->_cleanUpString($varvalue);
		$this->_tempInput = $tempInput;
		return $this->_tempInput;
	}
	
	function setMessage($msgcode, $description='')
	{
		global $systemMessages;
		$messageClass = $this->_messages;
		//echo $msgcode.' : '.$description.'<hr>';
		if(is_array($systemMessages))
		{
			$message = arrayMerge($messageClass,$systemMessages);
		}
		else
		{
			$message= $messageClass;
		}
		if(empty($message[$msgcode]))
		{
			if ($description)
			{
				$messagesCount = count($message[$msgcode]);
				$messagesCountOld= $messagesCount;
				$messagesCount = $messagesCount + 1;
				if($message[$msgcode][$messagesCountOld] != $description)
				{
					$message[$msgcode][$messagesCount] = $description;
				}
			}
			else
			{
				$message[$msgcode] = $msgcode;
			}
			
		}	
		if(eregi("\.fatalerr\.",$msgcode)) 
		{
			die($code.': '.$description);
		}
		//print_r($message);
		$systemMessages=$message;
		$this->_messages = $message;
	}	
	
	function setDebug($msgcode, $description='')
	{
		
		//echo $msgcode.' : '.$description.'<hr>';
	}	
	
	function getMessages($mode='')
	{
		$messageClass = $this->_messages;
		if(is_array($GLOBALS['systemMessages']))
		{
			$messages = arrayMerge($messageClass,$GLOBALS['systemMessages']);
		}
		else
		{
			$messages= $messageClass;
		}		
		return 	$this->_messages;
	}
	
	function getUniqueID()
	{
		$config = $this->getConfig();
		$iteration = $this->_iteration;
		if($iteration<10)
		{
			$iteration++;
		}
		else
		{
			$iteration = 1;
		}
		$this->_iteration = $iteration;
		$uid .= abs(crc32(md5($config['ApplicationDomain'])));
    	$uid .= date("YmdHis");
	    srand((double)microtime()*1000000);
    	$uid .= rand(0,99);
		$simbol = rand(97,122);
		$uid .= chr($simbol);		
		$uid .= $iteration;
		$len = strlen($uid);
		if($len<30)
		{
			$i=30;
			while($i>$len)
			{
				$uid .= '1';
				$i--;
			}
		}
		return $uid;
	}	
	
	function hasRights($rights='')
	{
		$user = $this->_user;
		$config = $this->_config;
		$ownerID = $config['OwnerID'];
		//check if there is rights to this site
		if($user['GroupID'] == 'root')
		{
			//root admin
			return true;
		}
		/*
		if($config['ClientType']!='site' && $config['ClientType']!='front')
		{
			$ownerIDUser = $user['OwnerID'];
			//echo "<hr>$ownerIDUser  owners=".$config['SiteOwners'];			
			if(!empty($config['SiteOwners']))
			{
				if(!eregi("\|$ownerIDUser\|",$config['SiteOwners']))
				{
					return false;
				}
			}
		}	
		if($user['UserID']==$config['OwnerID'] && eregi("admin",$user['GroupRights']))
		{
			//root admin of a virtual site
			return true;
		}	
		*/	
		$urights = explode(',', $user['GroupRights']);
		while (list($right_number,$right_name)= each($urights))
		{
			$right_name = trim ($right_name);
			if ($rights == $right_name or $user['GroupName'] == 'root' )
			{
				return true;
			}
		}
		return false;
	}	
		
	
	function getLanguages($mode='')
	{
		$config=$this->_config ;

		$DB = new DataSource('main');
		if($mode=='all')
		{
			$query="SELECT LanguageID,LanguageCode,LanguageName FROM Language ORDER BY LanguageCode";		
		}
		else
		{
			$query="SELECT LanguageID,LanguageCode,LanguageName FROM Language WHERE PermAll='1' ORDER BY LanguageCode";
		}
		
		$rs = $DB->query($query);
		foreach($rs as $row)
		{
			$id = $row['LanguageID'];
			$code = $row['LanguageCode'];
			$name = $row['LanguageName'];
			$languageCodes[$id] = $code;
			$languageNames[$id] = $this->getValue($name);
		}
		$result['languageCodes'] = $languageCodes;
		$result['languageNames'] = $languageNames;
		return $result;
	}
	
	function getValue($elementValue,$lang='')
	{
		$config = $this->_config;
		if(empty($lang))
		{
			$lang = $config['lang'];
		}
		//$lang = 'en';
		//echo 'lang='.$lang;
		//$elementValueStart = $elementValue;
		$elementValue = str_replace("\n","||NL||",$elementValue);
		//echo $elementValue;
		preg_match ("/<".$lang.">(.*)<\/".$lang.">/i", $elementValue, $resultValue);
		//echo 'oooooooooo='.$elementValue.'<br>';
		//print_r($resultValue);
		if(!empty($resultValue[1]))
		{
			//echo 'ffffffff='.$resultValue[1].'<br>';
			$result = $resultValue[1];
		}
		else
		{
			//engish is default language .. so try to get for english first
			preg_match ("/<en>(.*)<\/en>/i", $elementValue, $resultValueEN);
			if(!empty($resultValueEN[1]))
			{
				//return english value
				$result = $resultValueEN[1];				
			}
			else
			{
			
				preg_match ("/<".$config['lang'].">(.*)<\/".$config['lang'].">/i", $elementValue, $resultValueEN);
				if(!empty($resultValueEN[1]))
				{
					//return english value
					$result = $resultValueEN[1];				
				}
				else
				{
			
				// no records for current language and for english .. so let check if there is at least a reoctd for other language
				/*
				preg_match ("/<([a-z]{2})>/i", $elementValue, $resultValueUnknown);
				if(!empty($resultValueUnknown[1]))
				{
					// ok we have a record for a language .. let's return an empty value becouse we have no records for current language and for english
					//torefact3: possible we need to return the value in the language we have found
					$recordLanguage = $resultValueUnknown[1];
					preg_match ("/<".$recordLanguage.">(.*)<\/".$recordLanguage.">/i", $elementValue, $resultValueRecordLang);
					$result = $resultValueRecordLang[1];
				}
				else
				{
					//ok .. we do not have a ny language set 
					$result = $elementValue;
				}
				*/
				$result = $elementValue;
				}
			}
		}//end of if(!empty($resultValue[1]))
		$result = str_replace("||NL||","\n",$result);
		//echo '<textarea cols=50 rows=20>';
		//echo 'lang='.$lang.' = START='.$elementValueStart.' SND '.$result;
		//echo '</textarea>';		
		return $result;
	}	
	//jb 5.12.05
	function setUserData($user)
	{
		$this->_user = $user;
	}
	
	function getSession($mode='')
	{
		global $SESSION, $CORE, $HTTP_SESSION_VARS;
		$config = $this->getConfig();
		$input = $this->getInput();
		$cookieName = $config['CookieName'];
		$sesid = $this->_cookie[$cookieName];
		$ip = $this->_remoteAddr;
		
		//$this->setMessage('sessionTill='.$sesid);
		if(empty($SESSION) || $mode == 'newSession' || $mode == 'update')
		{
			$rootPath = $config['RootPath'];
			$in['sessionID'] = $sesid;
			$in['remoteIP'] = $ip;
			$result = $this->callService('getSession','sessionServer',$in);
			$newSessionID = $result['SessionID'];
			$endCookieTime = (int) time() + $config['CookieTimeout'];
			//echo 'session='.$sesid.' = newsession = '.$newSessionID.'<br>';
			if($newSessionID != $sesid)		
			{
				//$HTTP_SESSION_VARS[$sessionName]='';
				//$HTTP_SESSION_VARS[$sessionName] = $newSessionID;
				setcookie($config['CookieName'],$newSessionID,$endCookieTime,'/','',0);			
			}
			//print_r($_SESSION);	
			//echo 'new='.$newSessionID;				
			//echo 'cookieSession='.$sesid.'<br>';
			//echo 'newSessionID='.$newSessionID.'<br>';			
			//$this->setMessage('sessionAfter='.$retval['xml']['SessionID']);
			$SESSION['Vars'] = $result['Vars'];
			$SESSION['User'] = $result['User'];
			$SESSION['SessionID'] = $result['SessionID'];
			$SESSION['SessionIP'] = $result['SessionIP'];
			//print_r($SESSION);
			$this->_session = $result['Vars'];
			$this->_user = $result['User'];
			$this->_sessionID = $result['SessionID'];			
			$this->_sessionIP = $result['SessionIP'];						
		}
		else
		{
			$this->_session = $SESSION['Vars'];
			$this->_user = $SESSION['User'];
			$this->_sessionID = $SESSION['SessionID'];		
			$this->_sessionIP = $SESSION['SessionIP'];	
		}	
		return $SESSION;					
	}
	
	function getRemoteIP()
	{
		return $this->_remoteAddr;
	}
	
	function getSessionData($mode='')
	{
		if ($mode=='xml')
		{
			$xml = $this->_arrayToXML($this->_session, 'Session');
			return 	$xml;
		}
		else
		{
			return 	$this->_session;
		}
	}
	
	function setSessionData($session)
	{
		$this->_session=$session;
	}
	function getCurrentSessionID()
	{
		return 	$this->_sessionID;
	}
	function getCurrentSessionIP()
	{
		return 	$this->_sessionIP;
	}	
	function setSessionID($sessionID)
	{
		$this->_sessionID = $sessionID;
	}		
	function setSessionVars($varName,$varValue='')
	{
		$session = $this->_session;
		if(is_array($varName))
		{
			$newSessionVars =arrayMerge($session,$varName);
			$input['SessionVars'] = $newSessionVars;
		}
		else
		{
			$vars[$varName] = $varValue;
			$newSessionVars = arrayMerge($session,$vars);
			$input['SessionVars'] = $newSessionVars;
		}
		$input['SessionID']=$this->_sessionID;
		$this->callService('setSessionVars','sessionServer',$input);
		$this->_session = $newSessionVars;
		return $newSessionVars;
	}
	function setSessionVar($varName,$varValue)
	{
		$this->setSessionVars($varName,$varValue);
	}	
	function getUser()
	{
		return $this->_user;
	}

	function getNow($time='')
	{
		return date('Y-m-d H:i:s',time());
	}
	function getTime($time='')
	{
		if(empty($time))
		{
			return date('Y-m-d H:i:s',time());
		}
		else
		{
			return date('Y-m-d H:i:s',$time);
		}
	}

	function XML2ARRAY($data, $WHITE=1) {
	
		$data = trim($data);
		if(!empty($data))
		{
			$vals = $index = $array = array();
			$parser = xml_parser_create();
			xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, $WHITE);
			if ( !xml_parse_into_struct($parser, $data, $vals, $index) )
			{
			$this->setDebug('CoreDataStore.XML2ARRAY.XMLError',xml_error_string(xml_get_error_code($parser)).' at line '.xml_get_current_line_number($parser));
			$this->setMessage('CoreDataStore.XML2ARRAY.err.XMLError',xml_error_string(xml_get_error_code($parser)).' at line '.xml_get_current_line_number($parser));
			return false;
			/*		die(sprintf("XML error: %s at line %d",
							xml_error_string(xml_get_error_code($parser)),
							xml_get_current_line_number($parser)));
			*/
			}
			xml_parser_free($parser);
		
			$i = 0; 
		
			$tagname = $vals[$i]['tag'];
			if ( isset ($vals[$i]['attributes'] ) )
			{
				$array[$tagname]['@'] = $vals[$i]['attributes'];
			} else {
				$array[$tagname]['@'] = array();
			}
		
			$array[$tagname]["#"] = $this->xmlDepth($vals, $i);
	
			return $array;
		}
		else
		{
			//$this->setMessage('CoreDataStore.XML2ARRAY.err.EmptyXML');			
						
			return false;
		}
	}
	
	/* 
	 *
	 * You don't need to do anything with this function, it's called by
	 * xmlize.  It's a recursive function, calling itself as it goes deeper
	 * into the xml levels.  If you make any improvements, please let me know.
	 *
	 *
	 */
	
	function xmlDepth($vals, &$i) { 
		$children = array(); 
	
		if ( isset($vals[$i]['value']) )
		{
			array_push($children, $vals[$i]['value']);
		}
	
		while (++$i < count($vals)) { 
	
			switch ($vals[$i]['type']) { 
	
			   case 'open': 
	
					if ( isset ( $vals[$i]['tag'] ) )
					{
						$tagname = $vals[$i]['tag'];
					} else {
						$tagname = '';
					}
	
					if ( isset ( $children[$tagname] ) )
					{
						$size = sizeof($children[$tagname]);
					} else {
						$size = 0;
					}
	
					if ( isset ( $vals[$i]['attributes'] ) ) {
						$children[$tagname][$size]['@'] = $vals[$i]["attributes"];
					}
	
					$children[$tagname][$size]['#'] = $this->xmlDepth($vals, $i);
	
				break; 
	
	
				case 'cdata':
					array_push($children, $vals[$i]['value']); 
				break; 
	
				case 'complete': 
					$tagname = $vals[$i]['tag'];
	
					if( isset ($children[$tagname]) )
					{
						$size = sizeof($children[$tagname]);
					} else {
						$size = 0;
					}
	
					if( isset ( $vals[$i]['value'] ) )
					{
						$children[$tagname][$size]["#"] = $vals[$i]['value'];
					} else {
						$children[$tagname][$size]["#"] = '';
					}
	
					if ( isset ($vals[$i]['attributes']) ) {
						$children[$tagname][$size]['@']
												 = $vals[$i]['attributes'];
					}			
	
				break; 
	
				case 'close':
					return $children; 
				break;
			} 
	
		} 

	
		return $children;
	
	}
		
		//jb 17.11.05
	/*
	* Adds new record in log file
    *
	* @param	string	$code	Debug codes namespace: classname.methodname.functionname
	* @return	array
    * @access public
    */
	function setLog($code,$descritpion='',$logFile='')
	{
		$config = $this->getConfig();
		if(ereg("\.err\.", $code))
		{
			$logFile='errorlog.log';
			$logType = 'error';					
		}
		else
		{
			if(empty($logFile)) {$logFile='messageslog.log';}
			else {$logFile=$logFile;}
			$logType = 'message';
		}
		$logPath = $config['LogPath'];
		//print_r($config);
		if(!empty($logPath))
		{
			if(!is_dir($logPath)){mkdir($logPath, 0755);}
			$logFilePath = $logPath.$logFile;
			if(is_file($logFilePath))
			{
				if(filesize($logFilePath)>102400)
				{
					copy($logFilePath, $logPath.date("Ymd-his")."-".$logFile);
					unlink($logFilePath);
				}
			}
			$fp = fopen($logFilePath,'a');
			$logResult = '<'.'LogRecord'.'>' . LB;
			$logResult .= '		<'.'Time'.'>'.date("Y/m/d h:i:s").'</'.'Time'.'>' . LB;
			$logResult .= '		<'.'Type'.'>'.$logType.'</'.'Type'.'>'.LB;			
			$logResult .= '		<'.'Code'.'>'.$code.'</'.'Code'.'>'.LB;
			$logResult .= '		<'.'Message'.'>'.trim($descritpion).'</'.'Message'.'>'.LB;			
			$logResult .= '</'.'LogRecord'.'>'.LB;
			//echo $logPath.$logFile.'  '.$logResult;
			fwrite($fp,$logResult);
			fclose($fp);
		}
		else
		{
			//!!!tmp cimmented $this->setMessage('CoreDataStore.setLog.err.noPathLogDefined');
		}
	}
	//jb 17.11.05
}

?>