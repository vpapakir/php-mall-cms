<?php
//XCMSPro: Banner entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/

function validateCaptchaCode()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//creat objects			
	$Antispam = new AntispamClass();
	$result = $Antispam -> validateCaptchaCode($input);

return $result;
}
?>