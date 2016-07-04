<?
class HTMLDataType
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
	function HTMLDataType($controller)
	{
		//global $CORE;
		$this->_controller = &$controller;
		$this->_config = $controller->getConfig();
		$this->_input = $controller->getInput();
		$this->_user = $controller->getUser();
	}	
	/**
	* @return 	unknown
	* @param 	$value unknown
	* @desc 	Gets transformed value to show in output
 	*/	
	function getDataType($value,$options)
	{
		$config = $this->_config;
		$value = getValue($value);
		$result = stripslashes($value);
		$result = str_replace('&quot;','"',$result);
		$result = str_replace('&gt;','>',$result);
		$result = str_replace('&lt;','<',$result);
		$result = str_replace('{url}',$config['url'],$result);
		$result = str_replace('{rooturl}',$config['rooturl'],$result);
		if(!eregi("<br",$result) && !eregi("<td",$result))
		{
			$result = nl2br($result);
		}
		if(!eregi("<a|<img|<form|<object|<embed",$result))
		{
			$result = $this->makeClickableLinks($result);
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
		$config = $this->_config;
		$result = $value;
		return $result;
	}

	function formDataType($value,$options)
	{
		$config = $this->_config;
		$user = $this->_user;
		
		$value = stripslashes($value);
		$value = str_replace('"','&quot;',$value);
		//$value = getValue($value);
		$fieldName = $options['fieldName'];
		//die('<textarea>'.$value.'</textarea>');
		$editorName = $options['editorName'];
		if(empty($editorName)) {$editorName = 'FCKeditor1';}
		$editorWidth = $options['editorWidth'];
		if(empty($editorWidth)) {$editorWidth = $config['HTMLEditorWidth'];}
		if(empty($editorWidth)) {$editorWidth = 650;}
		$editorHeight = $options['editorHeight'];
		if(empty($editorHeight)) {$editorHeight = $config['HTMLEditorHeight'];}		
		if(empty($editorHeight)) {$editorHeight = 400;}		
		$editorToolbar = $options['editorToolbar'];
		if(empty($editorToolbar)) {$editorToolbar = $config['HTMLEditorButtons'];}
		if(empty($editorToolbar)) {$editorToolbar = 'Default';}	
		
		$layout = $config['Layout'];
		$clientType = $config['ClientType'];
		$layout = 'default';
		$clientType = 'front';
		$editorRootURL = $config['rooturl'].'templates/'.$config['ClientType'].'/js/editor/';
		
		if(!empty($options['userFolder'])) {$userFolder = $options['userFolder'];}
		elseif($config['ClientType']=='admin' || $this->_controller->hasRights('admin') || $this->_controller->hasRights('owner')) {$userFolder=$config['OwnerID'];}
		elseif(!empty($user['UserName'])) {$userFolder=$user['UserName'];}
		else{$userFolder='visitor';}

		$serverPath = $config['WebFolder'].'content/'.$userFolder.'/';
		$serverFullPath  = $config['RootPath'].'content/'.$userFolder.'/';
		if(!is_dir($config['RootPath'].'content/'.$userFolder.'/'))
		{
			$oldumask = umask(0) ;		
			mkdir($config['RootPath'].'content/'.$userFolder.'/',0777);
			umask( $oldumask ) ;
		}
		if(!is_dir($config['RootPath'].'content/'.$userFolder.'/Image/'))
		{
			$oldumask = umask(0) ;
			mkdir($config['RootPath'].'content/'.$userFolder.'/Image/',0777);
			umask( $oldumask ) ;
		}		
		if(!is_dir($config['RootPath'].'content/'.$userFolder.'/Flash/'))
		{
			$oldumask = umask(0) ;
			mkdir($config['RootPath'].'content/'.$userFolder.'/Flash/',0777);
			umask( $oldumask ) ;
		}		
		if(!is_dir($config['RootPath'].'content/'.$userFolder.'/Media/'))
		{
			$oldumask = umask(0) ;
			mkdir($config['RootPath'].'content/'.$userFolder.'/Media/',0777);
			umask( $oldumask ) ;
		}		
		if(!is_dir($config['RootPath'].'content/'.$userFolder.'/File/'))
		{
			$oldumask = umask(0) ;
			mkdir($config['RootPath'].'content/'.$userFolder.'/File/',0777);
			umask( $oldumask ) ;
		}		
		
		if($config['HTMLEditorMode']=='N')
		{
			$result = '<textarea cols="80" rows="15" name="'.$fieldName.'">'.$value.'</textarea>';
		}
		else
		{
		  $result = '<div> 
			<input type="hidden" id="'.$editorName.'" name="'.$fieldName.'" value="'.$value.'" /> 
			<input type="hidden" id="'.$editorName.'___Config" value="AutoDetectLanguage=true&DefaultLanguage=en" /> 
			<iframe id="'.$editorName.'___Frame" src="'.$editorRootURL.'fckeditor.html?InstanceName='.$editorName.'&Toolbar='.$editorToolbar.'&ClientType='.$clientType.'&Layout='.$layout.'&ServerPath='.$serverPath.'" width="'.$editorWidth.'" height="'.$editorHeight.'" frameborder="no" scrolling="no"></iframe> 
		  </div>';
		} 
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