<?
class FileDataType
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
	function FileDataType($controller)
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
		
		$mode = $options['mode'];
		if($mode=='link')
		{
			$result = '<a href="'.setting('urlfiles').$value.'">'.lang('-download').'</a><br/>';
		}
		else
		{
			$result = setting('urlfiles').$value;
		}
		return $result;
	}
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value ready to be saved in a data source
 	*/		
	function setDataType($value,$options='')
	{
		$test = trim($value);
		if(!empty($test))
		{
			$result = trim($value);
			$excludestring = "Á á Â â Æ æ À à Å å Ã ã Ä ä Ç ç © É é Ê ê È è Ð ð Ë ë Í é Î î Ì ì Ï ï Ñ ñ Ó ó Ô ô Œ œ Ò ò Õ õ Ö ö Š š Ú ú Û û Ù ù Ü ü Ý ý Ÿ ÿ ® ° ";
			$excludestring .= "' ’ & / \ * ^ \" ` ~ ) ( % $ # @ ! : ; = > < ? , | ] [ } {";
			$excludechars = explode(" ",$excludestring);
			foreach ($excludechars as $char)
			{
				$result = str_replace($char,"",$result);
			}			
			$result = str_replace(" ","-",$result);
			while(eregi("--",$result))
			{
				$result = str_replace("--","-",$result);
			}			
			//$result = strtolower($result);
		}
		else
		{
			$result = '';
		}	
		return $result;	
	}
	
	function formDataType($value,$options)
	{
		$config = $this->_config;
		//$value = getValue($value);
		$fieldName = $options['fieldName'];
		$formName = $options['formName'];
		$langCode = $options['langCode'];
		$langMode = $options['langMode'];
		$deleteLink = $options['deleteLink'];
		$deleteLinkOnClick = $options['deleteLinkOnClick'];
		
		$heightLimit = $options['heightLimit'];
		$widthLimit = $options['widthLimit'];
		
		$attributes = $options['attributes'];

		$result .= '<br/>';			
		if(!empty($value)) {
			$result .= $this->getDataType($value,array('mode'=>'link'));
			$result .= '<br/>';
			$result .= $deleteLink;
			$result .= '<br/>';
		}
		if(!empty($langCode))
		{			
			$result .= lang($langCode.'.'.$fieldName).':<br/>';
		}
		$result .= $limitsString;
		$result .= '<input size="22" type="file" name="uploadFile['.$fieldName.']" />';
		if(!empty($widthLimit))
		{
			$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'][ImageWidthLimit]" value="'.$widthLimit.'" />';
		}
		if(!empty($heightLimit))
		{
			$result .= '<input type="hidden" name="uploadFileSettings['.$fieldName.'][ImageHeightLimit]" value="'.$heightLimit.'" />';
		}		
		$result .= '<input type="hidden" name="oldUploadFile['.$fieldName.']" value="'.$value.'" />';
		$result .= '<br/><br/>';

		return $result;
	}	
	
}
?>