<?
class ColorDataType
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
	function ColorDataType($controller)
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
		return $value;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$options)
	{
		return $value;
	}

	function formDataType($value,$options)
	{
		$config = $this->_config;
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$result = '<script language=JavaScript> TCPColorPickerRootURL = \''.$config['rooturl'].'templates/'.$config['ClientType'].'/js/en/color/\'; </script>';
		$result .= '<script language=JavaScript src="'.$config['rooturl'].'templates/'.$config['ClientType'].'/js/en/color/picker.js"></script>';
		$result .='<input type="text" size="10" name="'.$fieldName.'" value="'.$value.'">';
		$result .='<a href="javascript:TCP.popup(document.forms[\''.$formName.'\'].elements[\''.$fieldName.'\'], 1)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="'.$config['rooturl'].'templates/'.$config['ClientType'].'/js/en/color/img/sel.gif"></a>';
		return $result;
	}	
}
?>