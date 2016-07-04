<?
class LocationDataType
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
	function LocationDataType($controller)
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
		$DS = new DataSource('main');

		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$mode = $options['mode'];
		if(empty($mode)) {$mode='all';}
		$value = str_replace("vvv","-",$value);
		$currentLocation = spliti("\|", $value);
		$currentLocation[1]='';
		$currentLocation[2]='';
		$value_Display='';
		if (is_array($currentLocation)){
			foreach ($currentLocation as $id=>$row){
				if (!empty($row)) 
				{
					if (!empty($row) && (substr($row, 0, 1)=='[' && substr($row, strlen($row)-1, 1)==']')){
					$value_Display .= substr($row, 1, strlen($row)-2);
					}elseif(!empty($row)){
						$locationName = $locationsCache[$row];
						if(empty($locationName))
						{
							$query = "SELECT * FROM Region WHERE RegionCode='".$row."'";
							$rsLoc = $DS->query($query);
							$locationName =  getValue($rsLoc[0]['RegionName']);
							$locationsCache[$row] = $locationName;
						}
						$value_Display .= $locationName;
					}
					if (count($currentLocation)==($id+1) || count($currentLocation)==($id+2)){
					$value_Display .= "";
					}else {
					$value_Display .= ", ";
					}
				}
			}
		}
		$result = $value_Display;

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
		$DS = new DataSource('main');
		//print_r($input);
		//add cointinent and region to location
		$value = substr($value,1);
		$country = str_replace("vvv","-",substr($value,0,strpos($value,"|")));
		
		//echo 'rrrrrrrrrr='.$country;
		//
		$query = "SELECT RegionCode, RegionParentID FROM Region WHERE RegionCode='".$country."'";
		$rs = $DS->query($query);
		$regionID =  $rs[0]['RegionParentID'];

		$query = "SELECT RegionCode, RegionParentID FROM Region WHERE RegionID='".$regionID."'";
		$rs = $DS->query($query);
		$region =  $rs[0]['RegionCode'];
		if(!empty($rs[0]['RegionParentID']))
		{
			$query = "SELECT RegionCode, RegionParentID FROM Region WHERE RegionID='".$rs[0]['RegionParentID']."'";
			$rs = $DS->query($query);
			$continent =  $rs[0]['RegionCode'];
		}
		//echo 'rrr='. $rs[0]['RegionCode'];
		//die('rrr');		
		$value = '|'.$value;
		if(!empty($region))
		{
			$value = '|'.str_replace("-","vvv",$region).$value;
		}
		if(!empty($continent))
		{
			$value = '|'.str_replace("-","vvv",$continent).$value;
		}		
							
		$result = str_replace("-","vvv",$value);
		return $result;
	}
	
	function formDataType($value,$options)
	{
		global $locationsCache;
		
		$DS = new DataSource('main');
		
		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$fieldSize = $options['fieldSize'];
		if(empty($fieldSize)) {$fieldSize = 80;}
		$mode = $options['mode'];
		if(empty($mode)) {$mode='all';}
		$value_Display = $this->getDataType($value,$options);
		//delete continent and region
		$value = str_replace("vvv","-",$value);
		$value = substr($value,1);
		$value = substr($value,strpos($value,"|"));
		$value = substr($value,1);
		$value = substr($value,strpos($value,"|"));
		
		$result = '<a href="javascript:popup(\''.setting('url').'locationSelector/formName/'.$formName.'/fieldName/'.$fieldName.'/mode/'.$mode.'/windowMode/popupselector/\',200,400)" title="'.lang('LocationSelectorIcon.core.tip').'"><img src="'.setting('layout').'images/icons/map.png" width="16" height="16" border="0" alt="'.lang('LocationSelectorIcon.core.tip').'" /></a>&nbsp;<input type="hidden" name="'.$fieldName.'" value="'.$value.'" /><input READONLY type="text" name="'.$fieldName.'_Display" value="'.$value_Display.'" size="'.$fieldSize.'" class="locationField" />';
		return $result;
	}		
}
?>