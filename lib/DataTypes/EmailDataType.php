<?
class EmailDataType
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
	function EmailDataType($controller)
	{
		//global $CORE;
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
		$result = $value;
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$options)
	{
		$config = $this->_config;
		$result = $value;
		return $result;
	}

}
?>