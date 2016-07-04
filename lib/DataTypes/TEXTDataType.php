<?
class TEXTDataType
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
	function TEXTDataType($controller)
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
		$value = $this->_controller->getValue($value);
		$result = stripslashes($value);
		$result = str_replace('&quot;','"',$result);
		$result = str_replace('{url}',$config['url'],$result);
		$result = str_replace('{rooturl}',$config['rooturl'],$result);
		
		$result = nl2br($result);
		
		$result = $this->makeClickableLinks($result);
		
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
	
	function formDataType($value,$options)
	{
		$config = $this->_config;
		$user = $this->_user;
		
		$value = stripslashes($value);
		//$value = str_replace('"','&quot;',$value);
		$fieldName = $options['fieldName'];
		$editorHeight = $options['editorHeight'];
		if(empty($editorHeight)) {$editorHeight = 10;}
		$editorWidth = $options['editorWidth'];
		if(empty($editorWidth)) {$editorWidth = 60;}
		
		$value = str_replace("<br/>","\n",$value);
		$value = str_replace("<br />","\n",$value);
		$value = str_replace("<br>","\n",$value);
		$value = str_replace("<p>","\n",$value);
		$value = str_replace("</p>","",$value);
		//$value = strip_tags($value,);
		$result = '<textarea cols="'.$editorWidth.'" rows="'.$editorHeight.'" name="'.$fieldName.'">'.$value.'</textarea>';
		return $result;
	}	
		
	function makeClickableLinks($text) {
	
	  $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
		'<a href="\\1">\\1</a>', $text);
	  $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
		'\\1<a href="http://\\2">\\2</a>', $text);
	  $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
		'<a href="mailto:\\1">\\1</a>', $text);
	  
		return $text;
	
	}		
}
?>