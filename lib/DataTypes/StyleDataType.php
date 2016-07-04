<?
class StyleDataType
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
	function StyleDataType($controller)
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
	function getDataType($value,$options='')
	{
		$config = $this->_config;
		$input = $this->_input;
		//print_r($value);
		$resultRS = explode("|",$value);
		//print_r($resultRS);
		if($options['name']=='fonts')$k=1;
		if($options['name']=='fontsizes')$k=2;
		if($options['name']=='fontweights')$k=3;
		if($options['name']=='color')$k=4;
		if($options['name']=='fontstyles')$k=5;
		if($options['name']=='fontdecorations')$k=6;
		if($options['name']=='linkcolor')$k=7;
		if($options['name']=='hovercolor')$k=8;
		if($options['name']=='topmargin')$k=9;
		if($options['name']=='leftmargin')$k=10;
		if($options['name']=='rightmargin')$k=11;
		if($options['name']=='bottommargin')$k=12;
		
		if($options['name']=='border')$k=1;
		if($options['name']=='outercellspacing')$k=2;
		if($options['name']=='outercellpadding')$k=3;
		if($options['name']=='innerborder')$k=4;
		if($options['name']=='innercellspacing')$k=5;
		if($options['name']=='innercellpadding')$k=6;
		if($options['name']=='boxfill')$k=7;
		
		if($options['name']=='titlefont')$k=8;
		if($options['name']=='titlefontside')$k=9;
		if($options['name']=='subtitlefont')$k=10;
		if($options['name']=='subtitlefontside')$k=11;
		if($options['name']=='introductionfont')$k=12;
		if($options['name']=='introductionfontside')$k=13;
		if($options['name']=='textfont')$k=14;
		if($options['name']=='textfontside')$k=15;
		if($options['name']=='listingfont')$k=16;
		if($options['name']=='listingfontside')$k=17;
		if($options['name']=='commentfont')$k=18;
		if($options['name']=='commentfontside')$k=19;
		if($options['name']=='messagefont')$k=20;
		if($options['name']=='messagefontside')$k=21;
		if($options['name']=='header')$k=22;
		if($options['name']=='fontsizesheader')$k=23;
		if($options['name']=='subtitlecell')$k=24;
		if($options['name']=='subtitlecellfontsizes')$k=25;
		if($options['name']=='messagecell')$k=26;
		if($options['name']=='messagecellfontsizes')$k=27;
		if($options['name']=='button')$k=28;
		if($options['name']=='buttonsizes')$k=29;
		if($options['name']=='buttonfont')$k=30;
		if($options['name']=='textareainputfont')$k=31;
		if($options['name']=='textareabackgroundcolor')$k=32;
		$result = $resultRS[$k];
		//print_r($config);
		//echo $result;
		if($config['ClientType']!='admin' && $input['SID']!='adminStyles'){ 
			$result = str_replace($config['OwnerStyle'].".","",$result);
		}
		//echo $result;
		return $result;
	}
	
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function formDataType($value,$options)
	{
		$config = $this->_config;
		
		$resultRS = explode("|",$value);
		if($options['name']=='color')$k=1;
		if($options['name']=='size')$k=2;
		if($options['name']=='fonts')$k=3;
		if($options['name']=='fontweights')$k=4;
		if($options['name']=='fontstyles')$k=5;
		//echo $option['name'];
		//print_r($resultRS);
		$result .= '<input type="text" name="Setting'.DTR.'SettingOptionStyle['.$options['name'].']" value="'.$resultRS[$k].'" size="10" /><br/>';
		//$result .= '<input type="text" name="Setting'.DTR.'SettingOptionStyle[]" value="'.$resultRS[1].'" size="10" /><br/>';
		//$result .= '<input type="text" name="Setting'.DTR.'SettingOptionStyle[]" value="'.$resultRS[2].'" size="10" /><br/>';
		//$result .= '<input type="text" name="Setting'.DTR.'SettingOptionStyle[]" value="'.$resultRS[3].'" size="10" />';
		return $result;
	}	
	function setDataType($value,$options='')
	{
		//print_r($value);
		$result = $value;
		return $result;	
	}
}
?>