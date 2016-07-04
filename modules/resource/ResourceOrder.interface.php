<?php
//XCMSPro: ResourceOrder entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageResourceOrders()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ResourceOrderID'];
	$entityAlias = $input['ResourceOrder'];
	$entityFieldID = $input['ResourceOrderFieldID'];
	$entityOptionID = $input['ResourceOrderOptionID'];
	//creat objects			
	$ResourceOrder = new ResourceOrderClass();
	//get content
	if($input['actionMode']=='savelist')
	{
		$ResourceOrder->setResourceOrders($input);
	}
	if($input['actionMode']=='delete')
	{
		$ResourceOrder->deleteResourceOrder($input);
		//$ResourceOrder->deleteResourceOrderField($input);
		//$ResourceOrder->deleteResourceOrderOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ResourceOrder->setResourceOrder($input);
		//$ResourceOrder->setResourceOrderField($input);		
		//$ResourceOrder->setResourceOrderOption($input);
		//$ResourceOrder->updateBoxPositions($input['ResourceOrderBox'.DTR.'ResourceOrderBoxID']);		
	}
	elseif($input['actionMode']=='copyResourceOrder')
	{
		$ResourceOrder->copyResourceOrder($input);
	}	

	$ResourceOrdersRS = $ResourceOrder->getResourceOrders($input);
	$result['DB']['ResourceOrders'] = $ResourceOrdersRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['ResourceOrder'] = $ResourceOrder->getResourceOrder($input);
		//$result['DB']['ResourceOrderFields'] = $ResourceOrder->getResourceOrderFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['ResourceOrderField'] = $ResourceOrder->getResourceOrderField($input);
			$result['DB']['ResourceOrderOptions'] = $ResourceOrder->getResourceOrderOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['ResourceOrderOption'] = $ResourceOrder->getResourceOrderOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}


function addResourceOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ResourceOrderID'];
	$entityAlias = $input['ResourceOrder'];
	$entityFieldID = $input['ResourceOrderFieldID'];
	$entityOptionID = $input['ResourceOrderOptionID'];
	//creat objects			
	$ResourceOrder = new ResourceOrderClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode']=='add')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['ResourceOrder'.DTR.'ResourceOrderFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['ResourceOrder'.DTR.'ResourceOrderLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address1',$input['ResourceOrder'.DTR.'ResourceOrderAddress1']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['ResourceOrder'.DTR.'ResourceOrderCity']);
			$CORE->setInputVar('UserField'.DTR.'Region',$input['ResourceOrder'.DTR.'ResourceOrderRegion']);
			$CORE->setInputVar('UserField'.DTR.'PostCode',$input['ResourceOrder'.DTR.'ResourceOrderPostCode']);
			$CORE->setInputVar('UserField'.DTR.'CountryID',$input['ResourceOrder'.DTR.'ResourceOrderCountryID']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['ResourceOrder'.DTR.'ResourceOrderPhone']);
			$CORE->setInputVar('User'.DTR.'Email',$input['ResourceOrder'.DTR.'ResourceOrderEmail']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$ResourceOrder = new ResourceOrderClass();		
		}
		$result['DB'] = $ResourceOrder->addResourceOrder($input);
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		$totals = $ResourceOrder->getOrderTotals($input);
		$result['Vars']['OrderTotals'] = $totals;
	}

	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	return $result;
}

function getResourceOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ResourceOrderID'];
	$entityAlias = $input['ResourceOrder'];
	$entityFieldID = $input['ResourceOrderFieldID'];
	$entityOptionID = $input['ResourceOrderOptionID'];
	//creat objects			
	$ResourceOrder = new ResourceOrderClass();
	$userID = $user['UserID'];
	//get content	
	
	if($input['actionMode'] == 'save')
	{
		$ResourceOrder->updateResourceOrder($input);
	}
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['ResourceOrder'] = $ResourceOrder->getResourceOrder($input);
		//$result['DB']['ResourceOrderFields'] = $ResourceOrder->getResourceOrderFields($input);
		$result['DB']['ResourceOrderItem'] = $ResourceOrder->getResourceOrderItem($input);
	}
	return $result;
}


/**
* Gets ResourceOrders. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceOrders($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ResourceOrder.getResourceOrders.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ResourceOrder = new ResourceOrderServer(&$SERVER,&$DS);
	//get content
	$ResourceOrdersRS = $ResourceOrder->getResourceOrders($input);
	$SERVER->setOutput($ResourceOrdersRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ResourceOrder.getResourceOrders.End','End');
	return $returnValue;
}
/**
* Gets ResourceOrder. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*function getResourceOrder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ResourceOrder.getResourceOrder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ResourceOrder = new ResourceOrderServer(&$SERVER,&$DS);
	//get content
	$ResourceOrderRS = $ResourceOrder->getResourceOrder($input);
	$SERVER->setOutput($ResourceOrderRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ResourceOrder.getResourceOrder.End','End');
	return $returnValue;
}*/

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*function manageResourceOrder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ResourceOrder.manageResourceOrder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$ResourceOrder = new ResourceOrderServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$ResourceOrder->setResourceOrder($input);
		$ResourceOrder->setResourceOrderBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$ResourceOrder->deleteResourceOrder($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$ResourceOrder->deleteResourceOrderBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$ResourceOrder->setResourceOrderBox($input);
	}	

	if($input['actionMode']=='copyResourceOrder')
	{	
		$ResourceOrder->copyResourceOrder($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $ResourceOrder->setResourceOrder($input);
	}
	else
	{
		$contentRS = $ResourceOrder->getResourceOrder($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $ResourceOrder->getResourceOrderBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('ResourceOrderType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$ResourceOrder->getResourceOrdersRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ResourceOrder.manageResourceOrder.End','End');
	return $returnValue;
}*/

/**
* Get the references used in ResourceOrder. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceOrderRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getResourceOrderRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getResourceOrderRefs.End','End');
	return $returnValue;
}
?>