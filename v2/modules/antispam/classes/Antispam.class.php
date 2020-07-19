<?php
//XCMSPro: Web Service entity class
class AntispamClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function AntispamClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	
	
	
	function validateCaptchaCode($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('AntispamClass.validateCaptchaCode.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		//session_start();
		$sessRS=$SERVER->getSession();
		//print_r($test);
		$sess=$sessRS['SessionID'];
	$userCode=$input['antispamUserCode'];
	$imageCodeRS=$DS->query("SELECT anti_code FROM antispam WHERE anti_session='$sess' ");
	$imageCode=$imageCodeRS[0]['anti_code'];
	if(empty($sess))
	{
		//echo "ERROR SESSION";
		return false;
	}
	if(!empty($imageCode) && $imageCode==$userCode)
	{
		return true;
	}
	else
	{
		return false;
	}
		//print_r($imageCode);
		$SERVER->setDebug('AntispamClass.validateCaptchaCode.End','End');
	return '';
	}
	

} 
?>