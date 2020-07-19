<?php
//XCMSPro: Service entity WebService public methods

/**
* Gets services. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('getServices');
function getServices($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.getServices.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	$servicesRS = $Service->getServices($input);
	$SERVER->setOutput($servicesRS['xml']);	
	//get refs
	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.getServices.End','End');
	return $returnValue;
}
/**
* Gets service. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('getService');
function getService($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.getService.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	$serviceRS = $Service->getService($input);
	$SERVER->setOutput($serviceRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.getService.End','End');
	return $returnValue;
}
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('manageServices');
function manageServices($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.manageServices.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	if($input['actionMode']=='delete')
	{
		$Service->deleteService($input);
	}
	elseif($input['actionMode']=='save')
	{
		$Service->setService($input);
	}
	$servicesRS = $Service->getServices($input);
	$SERVER->setOutput($servicesRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.manageServices.End','End');
	return $returnValue;
}
/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('manageService');
function manageService($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.manageService.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$Service->setService($input);
	}
	if($input['actionMode']=='delete')
	{
		$Service->deleteService($input);
	}
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $Service->setService($input);
	}
	else
	{
		$contentRS = $Service->getService($input);
	}
	$SERVER->setOutput($contentRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('ServiceStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('ServiceType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('PermAll',$in,'localRefs');	
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query("Category[CategoryType='internalServices']",'','Categories');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.manageService.End','End');
	return $returnValue;
}

/**
* This method withdraw money from user's balance for selected service
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('buyService');
function buyService($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.getService.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	$serviceRS = $Service->buyService($input);
	$SERVER->setOutput($serviceRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.getService.End','End');
	return $returnValue;
}

/**
* This method to add a new buy sercie order
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('requestService');
function requestService($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.getService.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	$serviceRS = $Service->requestService($input);
	$SERVER->setOutput($serviceRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.getService.End','End');
	return $returnValue;
}

/**
* This method adds a transfer order from user's account to site owner account
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('orderService');
function orderService($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('service.getService.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('service','server');
	$Service = new ServiceServer(&$SERVER,&$DS);
	//get content
	$serviceRS = $Service->orderService($input);
	$SERVER->setOutput($serviceRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('service.getService.End','End');
	return $returnValue;
}

?>