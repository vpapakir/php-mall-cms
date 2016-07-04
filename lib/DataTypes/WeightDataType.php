<?
class WeightDataType
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
	function WeightDataType($controller)
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
		$result = $value.' kg.';
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value)
	{
		$result = $value;
		return $result;	
	}
	
	function formDataType($value,$options)
	{
		$config = $this->_config;
		
		$fieldName = $options['fieldName'];
		$result = '<input type="text" name="'.$fieldName.'" value="'.$value.'" size="10" />'.' '.lang('kg');
		return $result;
	}	
}
?>