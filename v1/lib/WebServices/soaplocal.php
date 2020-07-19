<?
class SoapLocal
{
    // PRIVATE PROPERTIES
	var $_varname1 = array();
	// PRIVATE METHODS

	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	 
	function SoapLocal($service='')
	{
		
	}
	// PUBLIC METHODS
	
	function call($method,$in)
	{
		return false;
	}
	
	function register($methodName)
	{
		$methods = $this->_methods;
		$i = count($methods);
		$i++;
		$methods[$i] = $methodName;
		$this->_methods=$methods;
	}
	
	function getMethods()
	{
		return $this->_methods;
	}	
}// end of ClassName


?>