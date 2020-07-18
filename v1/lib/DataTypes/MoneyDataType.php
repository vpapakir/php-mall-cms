<?
class MoneyDataType
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
	function MoneyDataType($controller)
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
		$result = number_format ($value,2);
		$currencyMode = $options['currencyMode'];
		$currencyValue = $options['currency'];
		//$result = round($value,2).' '.$config['currency'];
		if($config['UseMultipleCurrencies']=='Y' && !empty($currencyValue))
		{
			$currency = getReferenceValue('Currency',$currencyValue,array('code'=>'Y'));
		}
		else
		{
			$currency = $config['currency'];
		}	
			
		if(strlen($config['currency'])==1)
		{
			if($currencyMode!='noCurrency')
			{
				$result = $currency.' '.$result;
			}
		}
		else
		{
			if($currencyMode!='noCurrency')
			{
				$result =$result.' '.$currency;
			}			
		}
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$options)
	{
		$result = $value;
		return $result;	
	}
	
	function formDataType($value,$options)
	{
		$config = $this->_config;
		
		$fieldName = $options['fieldName'];
		$currencyValue = $options['currency'];
		$currencyMode = $options['currencyMode'];
		$currencyFieldName = $options['currencyFieldName'];

		if($config['UseMultipleCurrencies']!='N' && !empty($currencyFieldName))
		{
			$currency = getReference('Currency',$currencyFieldName,$currencyValue,array('code'=>'Y'));
		}
		else
		{
			$currency = $config['currency'];
		}
		
		$result = '<input type="text" name="'.$fieldName.'" value="'.$value.'" size="10" />';
		if($currencyMode!='noCurrency')
		{
			$result .= " ".$currency;
		}
		

		return $result;
	}		
}
?>