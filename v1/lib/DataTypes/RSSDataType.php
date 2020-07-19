<?
class RSSDataType
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
	function RSSDataType($controller)
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
		//$value = $this->_controller->getValue($value);
		$rss = new lastRSS; 
		$rss->cache_dir = $config['RootPath'].'cache'; 
		$rss->cache_time = 3600; // one hour
		if ($rs = $rss->get($value)) {
			$result = $rs;
		}
		else {
			//die ('Error: RSS file not found...');
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
		$result = $value;

		return $result;
	}
}
?>