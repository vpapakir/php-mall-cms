<?
class DateTimeDataType
{
    // PRIVATE PROPERTIES
	var $_config;
	var $_input;	
	var $_controller;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function DateTimeDataType($controller)
	{
		$this->_controller = &$controller;
		$this->_config = $controller->getConfig();
		$this->_input = $controller->getInput();
	}	
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value to show in output
 	*/	
	function getDataType($value)
	{
		$config = $this->_config;
		if($value=='0000-00-00 00:00:00')
		{
			$result ='';
		}
		else
		{
			$value = substr ($value,0,19);
			//$result = $value;
			$result = @date('d-m-Y H:i',strtotime($value)+($config['TimeZone']*60*60));
//			$result = @date('d-m-Y',strtotime($value)+($config['TimeZone']*60*60));
		}
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$tableName='',$fieldName='',$id='')
	{
		$config = $this->_config;
		$input = $this->_input;
		if(!empty($tableName) && !empty($fieldName))
		{
			if(!empty($input[$tableName.DTR.$fieldName.'_Year']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Year']))
				{
					$valueTmp=$input[$tableName.DTR.$fieldName.'_Year'][$id];
				}
				else
				{
					$valueTmp=$input[$tableName.DTR.$fieldName.'_Year'];
				}
			}
			if(!empty($input[$tableName.DTR.$fieldName.'_Month']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Month']))
				{
					$valueTmp.='-'.$input[$tableName.DTR.$fieldName.'_Month'][$id];
				}
				else
				{
					$valueTmp.='-'.$input[$tableName.DTR.$fieldName.'_Month'];
				}
			}
			elseif(!empty($input[$tableName.DTR.$fieldName.'_Year']))
			{
				$valueTmp.='-00';
			}		
			if(!empty($input[$tableName.DTR.$fieldName.'_Day']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Day']))
				{
					$valueTmp.='-'.$input[$tableName.DTR.$fieldName.'_Day'][$id];
				}
				else
				{
					$valueTmp.='-'.$input[$tableName.DTR.$fieldName.'_Day'];
				}
			}	
			elseif(!empty($input[$tableName.DTR.$fieldName.'_Year']) or !empty($input[$tableName.DTR.$fieldName.'_Month']))
			{
				$valueTmp.='-00';
			}					
			if(!empty($input[$tableName.DTR.$fieldName.'_Hour']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Hour']))
				{
					$valueTmp.=' '.$input[$tableName.DTR.$fieldName.'_Hour'][$id];
				}
				else
				{
					$valueTmp.=' '.$input[$tableName.DTR.$fieldName.'_Hour'];
				}
			}
			elseif(!empty($input[$tableName.DTR.$fieldName.'_Year']) or !empty($input[$tableName.DTR.$fieldName.'_Month']) or !empty($input[$tableName.DTR.$fieldName.'_Day']))
			{
				$valueTmp.=' 00';
			}					
			if(!empty($input[$tableName.DTR.$fieldName.'_Minute']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Minute']))
				{
					$valueTmp.=':'.$input[$tableName.DTR.$fieldName.'_Minute'][$id];
				}
				else
				{
					$valueTmp.=':'.$input[$tableName.DTR.$fieldName.'_Minute'];
				}
			}	
			elseif(!empty($input[$tableName.DTR.$fieldName.'_Year']) or !empty($input[$tableName.DTR.$fieldName.'_Month']) or !empty($input[$tableName.DTR.$fieldName.'_Day']) or !empty($input[$tableName.DTR.$fieldName.'_Hour']))
			{
				$valueTmp.=':00';
			}	
			if(!empty($input[$tableName.DTR.$fieldName.'_Second']))
			{
				if(is_array($input[$tableName.DTR.$fieldName.'_Second']))
				{
					$valueTmp.=':'.$input[$tableName.DTR.$fieldName.'_Second'][$id];
				}
				else
				{
					$valueTmp.=':'.$input[$tableName.DTR.$fieldName.'_Second'];
				}
			}	
			elseif(!empty($input[$tableName.DTR.$fieldName.'_Year']) or !empty($input[$tableName.DTR.$fieldName.'_Month']) or !empty($input[$tableName.DTR.$fieldName.'_Day']) or !empty($input[$tableName.DTR.$fieldName.'_Hour']) or !empty($input[$tableName.DTR.$fieldName.'_Minute']))
			{
				$valueTmp.=':00';
			}						
			//echo 'tmp='.$valueTmp;
			if(!empty($valueTmp))
			{
				$value=$valueTmp;
			}
		}//end of if(!empty($tableName) && !empty($fieldName))
		
		if($value=='0000-00-00 00:00:00')
		{
			$result ='';
		}
		else
		{
			$timeStamp = strtotime ($value) - ($config['TimeZone']*60*60);
			$result = date('Y-m-d H:i:s', $timeStamp);
			//$result = date('d-m-Y H:i:s', $timeStamp);
		}
		return $result;
	}

	function formDataType($value,$options)
	{
		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		 $result = '<input type="text" name="'.$fieldName.'" value="'.$value.'" size="20" />&nbsp;<a href="javascript:openCalendar(\''.setting('rooturl').'templates/'.setting('ClientType').'/js/en/calendar/calendar.php?lang='.setting('lang').'\',\''.$formName.'\',\''.$fieldName.'\',\'datetime\')"><img src="'.setting('layout').'images/icons/calendar.png" width="16" height="16" border="0" /></a>';
		return $result;
	}	

}
?>