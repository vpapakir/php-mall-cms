<?php
//XCMSPro: ShippingRate entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageShippingRates()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ShippingRateTransport'];
	//creat objects			
	$ShippingRate = new ShippingRateClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ShippingRate->deleteShippingRate($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ShippingRate->setShippingRate($input);		
	}
	if(!empty($entityID))
	{
		$result['DB']['ShippingRates'] = $ShippingRate->getShippingRates($input);
	}
	$DS = new DataSource('main');
	$result['DB']['Regions'] = $DS->query("SELECT * FROM Region WHERE RegionParentID=0 ORDER BY RegionCode");
	//$languagesList = $CORE->getLanguages();
	//$result['DB']['Languages']= $languagesList;
	return $result;
}

/**
* Gets ShippingRates. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getShippingRates($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ShippingRate.getShippingRates.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ShippingRate = new ShippingRateserver(&$SERVER,&$DS);
	//get content
	$ShippingRatesRS = $ShippingRate->getShippingRates($input);
	$SERVER->setOutput($ShippingRatesRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ShippingRate.getShippingRates.End','End');
	return $returnValue;
}
/**
* Gets ShippingRate. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getShippingRate($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ShippingRate.getShippingRate.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ShippingRate = new ShippingRateserver(&$SERVER,&$DS);
	//get content
	$ShippingRateRS = $ShippingRate->getShippingRate($input);
	$SERVER->setOutput($ShippingRateRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ShippingRate.getShippingRate.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageShippingRate($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ShippingRate.manageShippingRate.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$ShippingRate = new ShippingRateserver(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$ShippingRate->setShippingRate($input);
		$ShippingRate->setShippingRateBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$ShippingRate->deleteShippingRate($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$ShippingRate->deleteShippingRateBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$ShippingRate->setShippingRateBox($input);
	}	

	if($input['actionMode']=='copyShippingRate')
	{	
		$ShippingRate->copyShippingRate($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $ShippingRate->setShippingRate($input);
	}
	else
	{
		$contentRS = $ShippingRate->getShippingRate($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $ShippingRate->getShippingRateBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('ShippingRateType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$ShippingRate->getShippingRatesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ShippingRate.manageShippingRate.End','End');
	return $returnValue;
}

/**
* Get the references used in ShippingRate. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getShippingRateRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getShippingRateRefs.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$DatingProfile = new DatingProfileServer(&$SERVER,&$DS);
	$refName = $input['RefName'];
	//get refs
	$refsResult = $DS->query($refName,$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('datingProfile.getShippingRateRefs.End','End');
	return $returnValue;
}
?>