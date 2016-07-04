<?
class SystemInterface extends SystemCore 
{
    // PRIVATE PROPERTIES
	//configuration info
	var $_config = array();
	//temporary data 
	var $_input = array();// GET+POST data
	// PRIVATE METHODS
    /**
    * Deletes all unallowed HTML tags
    *
    * @param	string	$value	the value
    * @param	string	$mode	the mode ofclening: NULL - full clean, notags - do not delete tags, nocheckwords 
	* @return	string			cleaned string
    * @access 	private
    */		
	function _loadWebsiteDefinition ()
	{
		global $websiteDefinition;
		$config = $this->getConfig();
		$rootPath = $config['RootPath'];
		$dir = $rootPath.'modules';
		//load boxes definitions		
		if ($dp=@opendir($dir)) {
			while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_dir($filename)) {
					$boxesDefinitionsFile = "$filename/definitions/boxesDefinition.php";
					if(is_file($boxesDefinitionsFile)){include_once $boxesDefinitionsFile;}
				}
			}
			closedir($dp);
		}
		$this->_boxesDefinition = $boxesDefinition;
		//load layouts definition and global website sections definition	
		$websiteDefinitionFile = $rootPath.'websiteDefinition.php';
		if(is_file($websiteDefinitionFile)){include_once $websiteDefinitionFile;}
		$this->_layoutsDefinition = $layoutsDefinition;		
		//load modules definition
		if ($dp=@opendir($dir)) {
			while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_dir($filename)) {
					$moduleDefinitionsFile = "$filename/definitions/moduleDefinition.php";
					if(is_file($moduleDefinitionsFile)){include_once $moduleDefinitionsFile;}
				}
			}
			closedir($dp);
		}
		$websiteDefinition = arrayMerge($websiteDefinition,$moduleDefinition);	
		//print_r($websiteDefinition);
		$this->_websiteDefinition = $websiteDefinition;
	}
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function SystemInterface()
	{	 
		global $REMOTE_ADDR, $debugMode, $SERVER_ROOT, $mainConfig;
		$this->SystemCore();
		$this->_remoteAddr = $REMOTE_ADDR;
		$this->_debugMode = $debugMode;
		$this->_loadWebsiteDefinition();
	}
	
	// PUBLIC METHODS
	function getBoxesDefinition($options='')
	{
		$boxesDefnition = $this->_boxesDefinition;
		$type = $options['type'];
		if(!empty($type))
		{
			if(is_array($boxesDefnition))
			{
				foreach($boxesDefnition as $code=>$box)
				{
					if($box['type']==$type)
					{
						$result[$code] = $box;
					}
				}
			}
		}
		else
		{
			$result = $boxesDefnition;
		}
		return $result;
	}
	
	function getLayoutsDefinition()
	{
		$DB = new DataSource('main');
		$rs = $DB->query("SELECT ViewAlias, ViewName FROM View");
		return $rs;
	}	
	
	function getWebsiteDefinition()
	{
		return $this->_websiteDefinition;
	}
	
	function getDatabaseDefinition()
	{
		global $databaseDefinition;
		return $databaseDefinition;
	}			
    /**
    * Gets drop downs, checkboxes and radioboxes lists
	* @access public
    *
    */	
	function printOutput()
	{
		$config = $this->_config;
		$input=$this->getInput();
		$layout = $config['Layout'];
		//print_r($input);
		$clientType = $config['ClientType'];
		$windowMode = $input['windowMode'];
		if(empty($input['windowMode']))
		{
			$layoutPath = $config['RootPath']."templates/$clientType/layouts/$layout/main.tpl.php";
		}
		else
		{
			$layoutPath = $config['RootPath']."templates/$clientType/layouts/$layout/$windowMode.tpl.php";
		}
		if(is_file($layoutPath))
		{
			include_once($layoutPath);
		}
	}
	
	function goLink($url,$type='')
	{
		$this->setSessionVars('backURL',$this->_refVarsURL);
		$config=$this->getConfig();
		$input=$this->getInput();
		if(!empty($input['windowMode']))
		{
			$varsString = '&windowMode='.$input['windowMode'];
			$varsStringSE = '/windowMode/'.$input['windowMode'];
		}
		$clientType = $config['ClientType'];
		if($clientType=='front' || $clientType=='site')
		{
			//$urlRoot=$config['SiteRootURL'];
		}
		else
		{
			//$urlRoot=$config['SiteAdminRootURL'];
		}
		//$urlRoot = $config['RootURL'];
		if($type=='urlse') {$url =  $config['url'] . $url . $varsStringSE;}
		if(empty($type)) {$url = $config['url']. $url . $varsString;}
		header("Location: $url");
		exit;
	}
		
	function getLists($input,$current,$mode,$lang='')
	{
		global $CORE;
		$CC = &$CORE;
		$type = $mode['type'];
		$name = $mode['name'];
		$action = $mode['action'];
		$sort = $mode['sort'];
		$style = $mode['style'];
		$idName = $mode['id'];
		$valueName = $mode['value'];
		$delimiter = $mode['delimiter'];
		$extraOptions = $mode['options'];
		$attributes = $mode['attributes'];

		if(empty($delimiter))
		{
			$delimiter='<br>';
		}	
		$i=0;
		if(!empty($extraOptions))
		{
			$options = $extraOptions;
			$i=count($extraOptions);
		}
		if(!empty($idName))
		{
			//generate from DB
			if(is_array($input))
			{
			foreach($input as $row)
			{
				$options[$i]['id']=$row[$idName];
				//old $options[$i]['value']=$row[$valueName];
				//jb 16.11.05 new. show as valuename several field separated by space
				if(is_array($valueName)) { 
					$multiValue = '';
					foreach($valueName as $Field) {
						if(!empty($row[$Field])) {$multiValue .= ' '.$row[$Field];}
					}
					$options[$i]['value'] = $multiValue;
				} else {
					$options[$i]['value']=$row[$valueName];
				  }
				//jb 16.11.05
				$i++;
			}
			}
		}
		else
		{
			$options = $input;
		}
		if($type=='checkboxes')
		{
			if(is_array($options))
			{
				$result .= '<input type="hidden" name="'.$name.'[]" value=" ">';
				foreach($options as $option)
				{
					if(!empty($option['value']))
					{				
						if(!empty($lang))
						{
							$value = $CC->getValue($option['value'],$lang);
						}
						else
						{
							$value=$option['value'];
						}
		
						if(ereg("\|".$option['id']."\|",$current))
						{
							$result .= '<input type="checkbox" name="'.$name.'[]" value="'.$option['id'].'" checked>'.$value.$delimiter;
						}
						else
						{
							$result .= '<input type="checkbox" name="'.$name.'[]" value="'.$option['id'].'">'.$value.$delimiter;
						}
					}
				}		
			}	
		}
		elseif($type=='radioboxes')
		{
			if(is_array($options))
			{
				foreach($options as $option)
				{
					if(!empty($option['value']))
					{			
						if(!empty($lang))
						{
							$value = $CC->getValue($option['value'],$lang);
						}
						else
						{
							$value=$option['value'];
						}
						if($current==$option['id'])
						{
							$result .= '<input type="radio" name="'.$name.'" value="'.$option['id'].'" '.$attributes.' checked>'.$value.$delimiter;
						}
						else
						{
							$result .= '<input type="radio" name="'.$name.'" value="'.$option['id'].'" '.$attributes.'>'.$value.$delimiter;
						}
					}
				}			
			}
		}		
		elseif($type=='multiple' || $type=='multipledropdown')
		{
			if(!empty($action))
			{
				$actionAttribute = ' onChange="'.$action.'" ';
			}
			if(!empty($style))
			{
				$styleAttribute = ' style="'.$style.'" ';
			}
			if(!empty($attributes	))
			{
				$attributesAttribute = ' '.$attributes.' ';
			}			
			
			if($type=='multiple')  {$multipleAttribute = ' multiple="multiple"';} else {$multipleAttribute='';}
			$result = '<select name="'.$name.'[]"'.$actionAttribute.$styleAttribute.$attributesAttribute.$multipleAttribute.'>';
			
			if(is_array($options))
			{
				foreach($options as $option)
				{
					if(!empty($option['value']))
					{				
						if(!empty($lang))
						{
							$value = $CC->getValue($option['value'],$lang);
						}
						else
						{
							$value=$option['value'];
						}					
						if(eregi("\|".$option['id']."\|",$current))
						{
							$result .= '<option value="'.$option['id'].'" selected>'.$value.'</option>';
						}
						else
						{
							$result .= '<option value="'.$option['id'].'">'.$value.'</option>';
						}
					}
				}
			}
			$result .= '</select>';
		}
		elseif($type=='array')
		{
			return $options;
		}		
		else
		{
			if(!empty($action))
			{
				$actionAttribute = ' onChange="'.$action.'" ';
			}
			if(!empty($style))
			{
				$styleAttribute = ' style="'.$style.'" ';
			}			
			
			$result = '<select name="'.$name.'"'.$actionAttribute.$styleAttribute.' '.$attributes.'>';
			
			if(is_array($options))
			{
				foreach($options as $option)
				{
					if(!empty($option['value']))
					{
						if(!empty($lang))
						{
							$value = $CC->getValue($option['value'],$lang);
						}
						else
						{
							$value=$option['value'];
						}					
						if($current==$option['id'])
						{
							$result .= '<option value="'.$option['id'].'" selected>'.$value.'</option>';
						}
						else
						{
							$result .= '<option value="'.$option['id'].'">'.$value.'</option>';
						}
					}
				}
			}
			$result .= '</select>';
		}
		
		return 	$result;
	}
		
	function getType($typeName,$fieldName,$currentValue='',$lang='',$mode='',$reflection='')
	{
		$config=$this->_config ;
		$DB = new DataSource('main');
		$result = $DB->query("SELECT * FROM Reference WHERE ReferenceCode='$typeName'");
		if ($reflection=='hidden')
		{
		    $resultValues = $DB->query("SELECT * FROM ReferenceOption WHERE ReferenceID='".$result[0]['ReferenceID']."' AND OptionReflection!='hidden' ORDER BY OptionPosition");			
		}
		else
		{
			$resultValues = $DB->query("SELECT * FROM ReferenceOption WHERE ReferenceID='".$result[0]['ReferenceID']."' ORDER BY OptionPosition");
		}
		$mode['name']=$fieldName;
		$mode['id']='id';
		$mode['value']='name';
		if(empty($mode['type']))
		{
			$mode['type'] = $result[0]['ReferenceType'];
		}
		//$mode['action']='submit();';
		//jb 22.11.05 added  && $mode['isEmptyValue']=='Y' in if() expression
		if(empty($mode['options'][0]['value']) && $mode['type']=='dropdown' && $mode['isEmptyValue']!='Y')
		{
			$mode['options'][0]['id']=' ';	
			$mode['options'][0]['value']='---';
		}
		if($mode['code']=='Y')
		{
			if(is_array($resultValues))
			{
				foreach($resultValues as $tmpID=>$row)
				if(!(!$row['OptionCode'] and $mode['skipEmpty']))
					{
						$tmpValues[$tmpID]['id'] = $row['OptionCode'];
						$tmpValues[$tmpID]['name'] = getValue($row['OptionName']);
					}
			}
			$resultValues = $tmpValues;
		}
		else
		{
			if(is_array($resultValues))
			{
				foreach($resultValues as $tmpID=>$row)
				if(!(!$row['ReferenceOptionID'] and $mode['skipEmpty']))
					{
						$tmpValues[$tmpID]['id'] = $row['ReferenceOptionID'];
						$tmpValues[$tmpID]['name'] = getValue($row['OptionName']);
					}
			}
			$resultValues = $tmpValues;			
		}
		//print_r($resultValues);
		return $this->getLists($resultValues,$currentValue,$mode,$config['lang']);		
	}
	
	function getSettingsType($typeName,$fieldName,$currentValue='',$lang='',$mode='')
	{
		$config=$this->_config ;
		$DB = new DataSource('main');
		$resultValues = $DB->query("SELECT * FROM Setting WHERE  SettingVariableName LIKE '%.color.%' AND SettingGroup = '11365480442006051812025318f111' ");
		$mode['name']=$fieldName;
		$mode['id']='id';
		$mode['value']='name';
		if(empty($mode['type']))
		{
			$mode['type'] = $result[0]['ReferenceType'];
		}
		//$mode['action']='submit();';
		//jb 22.11.05 added  && $mode['isEmptyValue']=='Y' in if() expression
		$mode['options'][0]['id']='none';	
		$mode['options'][0]['value']='none';
		
		if($mode['code']=='Y')
		{
			$i = 1;
			if(is_array($resultValues))
			{
				foreach($resultValues as $tmpID=>$row)
				{
					$tmpValues[$i]['id'] = $row['SettingValue'];
					$tmpValues[$i]['name'] = getValue($row['SettingName']);
					$i++;
				}
			}
			$resultValues = $tmpValues;
		}
		else
		{
			if(is_array($resultValues))
			{
				foreach($resultValues as $tmpID=>$row)
				{
					$tmpValues[$tmpID]['id'] = $row['ReferenceOptionID'];
					$tmpValues[$tmpID]['name'] = getValue($row['OptionName']);
				}
			}
			$resultValues = $tmpValues;			
		}
		//print_r($resultValues);
		return $this->getLists($resultValues,$currentValue,$mode,$config['lang']);		
	}
	
	//jb 21.11.05
	function getReferenceValue($typeName,$currentValue,$lang='',$mode='')
	{
		global $CORE;
		$config=$this->_config;
		$DB = new DataSource('main');
		$valuesArray = explode("|",$currentValue);
		if(is_array($valuesArray) && count($valuesArray)>1)
		{
			$isCheckbox = 'Y';
			$i=0;
			$filter = " (";
			foreach($valuesArray as $value)
			{
				if($i>0) {$filter .= ' OR ';}
				$filter .= " ReferenceOption.OptionCode='".$value."' ";
				$i++;
			}
			$filter .= ") ";
		}
		else
		{
			$filter = " ReferenceOption.OptionCode='".$currentValue."' ";
		}
		
		$sql = "SELECT ReferenceOption.OptionName, Reference.ReferenceType
				FROM ReferenceOption,Reference 
				WHERE ReferenceOption.ReferenceID=Reference.ReferenceID 
					AND Reference.ReferenceCode='".$typeName."'
					AND ".$filter;
		
		$result = $DB->query($sql);
		if(is_array($result)) {
			if($isCheckbox == 'Y')
			{
				$i=0;
				foreach($result as $row)
				{
					if($i>0) {$retval .= ', ';}
					$retval .= $CORE->getValue($row['OptionName'], $lang);
					$i++;
				}
			}
			else
			{
				$retval = $CORE->getValue($result[0]['OptionName'], $lang);
			}
		}
		
		return $retval;
	}
	
	function getTypeValue($id,$lang='',$mode='')
	{
		global $CORE;
		$config=$this->_config;
		$delimiter = $mode['delimiter'];
		$DB = new DataSource('main');
		//$id = $id.'|3|';
		$idsArray = explode("|",$id);
		if(is_array($idsArray))
		{
			$countOptions = count($idsArray);
		}
		if($countOptions>1)
		{
			//get checkboxes values list
			//print_r($idsArray);
			$i=1;
			foreach($idsArray as $curID)
			{
				if(!empty($curID))
				{
					if($i==1)
					{
						$sqlFilter = " (ReferenceOptionID = '$curID' OR OptionCode = '$curID') ";
						$i++;
					}
					else
					{
						$sqlFilter .= " OR (ReferenceOptionID = '$curID' OR OptionCode = '$curID') " ;
					}
				}
			}
			if(!empty($sqlFilter))
			{
				//echo $sqlFilter;
				$result = $DB->query("SELECT * FROM ReferenceOption WHERE $sqlFilter ORDER BY OptionPosition");
				$i=1;
				foreach($result as $row)
				{
					if($i==1)
					{
						$retval = $CORE->getValue($row['OptionName']);
						$i++;
					}
					else
					{
						$retval .= $delimiter." ".$CORE->getValue($row['OptionName']);
					}					
				}
			}
		}
		else
		{
			$result = $DB->query("SELECT * FROM ReferenceOption WHERE ReferenceOptionID='$id' OR OptionCode='$id'");
			$retval = $CORE->getValue($result[0]['OptionName']);
		}
		return $retval;
	}	

	function getTypeName($typeName,$lang='')
	{
		global $CORE;
		$config=$this->_config ;
		$DB = new DataSource('main');
		$result = $DB->query("SELECT ReferenceName FROM Reference WHERE ReferenceCode='$typeName'");
		return $CORE->getValue($result[0]['ReferenceName'],$lang);
	}
	
	
	function getBoxesList()
	{
		$boxesDefinition = $this->_boxesDefinition;
		foreach($boxesDefinition as $code=>$value)
		{
			$result[$code]['id'] = $code;
			$result[$code]['value'] = $value['name'];
		}
		return $result;
	}
	
}
?>
