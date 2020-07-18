<?
class DateDataType
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
	function DateDataType($controller)
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
	function getDataType($value,$options)
	{
		$config = $this->_config;
		//if($value=='0000-00-00')
		//echo $value;
		if($value=='0000-00-00 00:00:00' || $value=='0000-00-00' || empty($value))
		{
			$result ='';
		}
		else
		{
//			$result = @date('d-m-Y H:i',strtotime($value)+($config['TimeZone']*60*60));
			$result = @date('d-m-Y',strtotime($value)+($config['TimeZone']*60*60));
//			$result = @date('d-m-Y H:i:s',strtotime($value)+($config['TimeZone']*60*60));
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
		//print_r($input);
		//echo 'tableName='.$tableName,' fieldName='.$fieldName;
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
			if(!empty($valueTmp))
			{
				$value=$valueTmp;
			}
		}//end of if(!empty($tableName) && !empty($fieldName))
		//echo '$value='.$value;
		if($value=='0000-00-00' || $value=='0000-00-00 00:00:00')
		{
			$result ='';
		}
		else
		{
			$timeStamp = strtotime ($value) - ($config['TimeZone']*60*60);
			$result = date('Y-m-d', $timeStamp);
		}
		return $result;
	}
	
	function formDataType($value,$options)
	{
//die('asdfasdfasdfsadfert345');
		$config = $this->_config;
		$mode = $options['mode'];
		$delimiter = $options['delimiter'];
		$emptyMode = $options['emptyMode'];
		if(empty($delimiter)) {$delimiter = ' ';}
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		
		$value1=explode(' ',$value);
		$value=$value1[0];
		if(!empty($fieldName))
		{
			$yearFieldName = $fieldName.'_Year';
			$monthFieldName = $fieldName.'_Month';
			$dayFieldName = $fieldName.'_Day';
		}
		else
		{
			$yearFieldName = $options['yearFieldName'];
			$monthFieldName = $options['monthFieldName'];
			$dayFieldName = $options['dayFieldName'];
		}

		if($mode=='dropdowns')
		{
			$yearNow = date('Y');
			$monthNow = date('m');
			$dayNow = date('d');
		
			if(empty($emptyMode))
			{
				$year = substr($value,0,4);
				$month = substr($value,5,2);
				$day = substr($value,8,2);
				
				if($year<1){$year = $yearNow;}
				if($month<1){$month = $monthNow;}
				if($day<1){$day = $dayNow;}
				$startYear = $year-10;
				$endYear = $year+1;
			}
			else

			{
				$startYear = $yearNow-10;
				$endYear = $yearNow+1;
			}
			//get days
			$result .= '<select name="'.$dayFieldName.'">';
			if(!empty($emptyMode)) {$result .= '<option value="" >'.$emptyMode.'</option>';}
			for ($i = 1; $i <= 31 ;$i++)
			{
				if($i==$day) {$selected='selected';} else {$selected='';}
				$result .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			$result .= '</select>'.$delimiter;
			//get months
			$result .= '<select name="'.$monthFieldName.'">';
			if(!empty($emptyMode)) {$result .= '<option value="" >'.$emptyMode.'</option>';}
			for ($i = 1; $i <= 12 ;$i++)
			{
				if($i==$month) {$selected='selected';} else {$selected='';}
				$result .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			$result .= '</select>'.$delimiter;		
			//get years
			$result .= '<select name="'.$yearFieldName.'"> ';
			if(!empty($emptyMode)) {$result .= '<option value="" >'.$emptyMode.'</option>';}
			for ($i = $startYear; $i <= $endYear ;$i++)
			{
				if($i==$year) {$selected='selected';} else {$selected='';}
				$result .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			}
			$result .= '</select>'.$delimiter;					
		}
		else
			{
				$result = '<input type="text" name="'.$fieldName.'" value="'.$value.'" size="15" />&nbsp;<a href="javascript:openCalendar(\''.setting('rooturl').'templates/'.setting('ClientType').'/js/en/calendar/calendar.php?lang='.setting('lang').'\',\''.$formName.'\',\''.$fieldName.'\',\'date\')"><img src="'.setting('layout').'images/icons/calendar.png" width="16" height="16" border="0" /></a>';
			}
		return $result;
	}		
	
	function separateDataType($value,$options)
	{
		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$startYear = $options['startYear'];
		$endYear = $options['endYear'];
		$attributes = $options['attributes'];
		$monthLimit = $options['monthLimit'];
		
		$value1=explode(' ',$value);
		$value=$value1[0];
		$valueArray = explode('-',$value);
		$year= $valueArray[0];
		$month= $valueArray[1];
		$day= $valueArray[2];
		
		$optionsDay .= '<option value="" selected="selected">---</option>';
		for($d = 1; $d <= 31; $d++)
		{
		if($d < 10) $d = '0'.$d;
		if($d == $day)
		$optionsDay .= '<option value="'.$d.'" selected="selected">'.$d.'</option>';
		else
		$optionsDay .= '<option value="'.$d.'">'.$d.'</option>';
		}
		$result .= '<select name="'.$fieldName.'_day" '.$attributes.'>'.$optionsDay.'</select>/';
		
		
		if(!empty($monthLimit))
		{
			$maxMonthTime = time() + 60*60*24*30*$monthLimit;
			$minMonth = 1;
			$maxMonth = (int) date('m',$maxMonthTime);
			if($maxMonth<3) {$maxMonth=12;}
		}
		else
		{
			$minMonth = 1;
			$maxMonth = 12;
		}
		//echo 'min='.$minMonth.' max='.$maxMonth;
		//$minMonth 
		$optionsMonth = '<option value="" selected="selected">---</option>';
		for($m = $minMonth; $m <= $maxMonth; $m++)
		{
		if($m < 10) $m = '0'.$m;
		if($m == $month)
		$optionsMonth .= '<option value="'.$m.'" selected="selected">'.$m.'</option>';
		else
		$optionsMonth .= '<option value="'.$m.'">'.$m.'</option>';
		}
		$result .= '<select name="'.$fieldName.'_month" '.$attributes.'>'.$optionsMonth.'</select>/';
		
		if($options['typeSeparateDate'] == 'CardValidFrom'){
		$min_y = date("Y")-5; $max_y = date("Y");
		}
		else if($options['typeSeparateDate'] == 'CardExpirationDate'){
		$min_y = date("Y"); $max_y = date("Y")+5;
		}
		else {
		$min_y = date("Y")-65; $max_y = date("Y")-21;
		}
		
		if(!empty($startYear))
		{
			$min_y = $startYear;
		}
		if(!empty($endYear))
		{
			$max_y = $endYear;
		}
		$optionsYear = '<option value="" selected="selected">---</option>';
		for($y = $min_y; $y <= $max_y; $y++)
		{
		if($y == $year)
		$optionsYear .= '<option value="'.$y.'" selected="selected">'.$y.'</option>';
		else
		$optionsYear .= '<option value="'.$y.'">'.$y.'</option>';
		}
		$result .= '<select name="'.$fieldName.'_year" '.$attributes.'>'.$optionsYear.'</select>';
		//$result = '<input type="text" name="'.$fieldName.'" value="'.$value.'" size="15" />&nbsp;<a href="javascript:openCalendar(\''.setting('rooturl').'templates/'.setting('ClientType').'/js/en/calendar/calendar.php?lang='.setting('lang').'\',\''.$formName.'\',\''.$fieldName.'\',\'date\')"><img src="'.setting('layout').'images/icons/calendar.png" width="16" height="16" border="0" /></a>';
		return $result;
	}	
	
	function fromdatetoDataType($value,$options)
	{
		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$dateType = $options['dateType'];
		$value=explode(' ',$value);
		$value['from']=$value[1];
		$value['to']=$value[4];
		$value['ampm_from']=$value[2];
		$value['ampm_to']=$value[5];
		for($h = 1; $h <= 12; $h++)
		{
			if($h < 10) $h = '0'.$h;
			if($h == $value[$dateType])
			$optionsHour .= '<option value="'.$h.'" selected="selected">'.$h.'</option>';
			else
			$optionsHour .= '<option value="'.$h.'">'.$h.'</option>';
		}
		$result .= '<select name="'.$fieldName.'_'.$dateType.'" > <option value="">---</option> '.$optionsHour.'</select>';
		
		$typeHour = array('am' => 'AM', 'pm' => 'PM');
		while(list($optionKey, $optionValue) = each($typeHour))
		{
			if($optionKey == $value['ampm_'.$dateType])
			$optionsAMPM .= '<option value="'.$optionKey.'" selected="selected">'.$optionValue.'</option>';
			else
			$optionsAMPM .= '<option value="'.$optionKey.'">'.$optionValue.'</option>';
		}
		$result .= '&nbsp;<select name="'.$fieldName.'_ampm_'.$dateType.'" > <option value="">---</option> '.$optionsAMPM.'</select>';

		return $result;
	}	
}
?>