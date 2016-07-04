<?php
//XCMSPro: ReservedPropertyOrder entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservedPropertyOrders()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservedPropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('ReservedPropertyOrderID',$entityID);}
	$entityAlias = $input['ReservedPropertyOrder'];
	$entityFieldID = $input['ReservedPropertyOrderFieldID'];
	$entityOptionID = $input['ReservedPropertyOrderOptionID'];
	//creat objects			
	$ReservedPropertyOrder = new ReservedPropertyOrderClass();
	//get content
	if($input['actionMode']=='savelist')
	{
		$ReservedPropertyOrder->setReservedPropertyOrders($input);
	}
	if($input['actionMode']=='delete')
	{
		$ReservedPropertyOrder->deleteReservedPropertyOrder($input);
		//$ReservedPropertyOrder->deleteReservedPropertyOrderField($input);
		//$ReservedPropertyOrder->deleteReservedPropertyOrderOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ReservedPropertyOrder->setReservedPropertyOrder($input);
		//$ReservedPropertyOrder->setReservedPropertyOrderField($input);		
		//$ReservedPropertyOrder->setReservedPropertyOrderOption($input);
		//$ReservedPropertyOrder->updateBoxPositions($input['ReservedPropertyOrderBox'.DTR.'ReservedPropertyOrderBoxID']);		
	}
	elseif($input['actionMode']=='copyReservedPropertyOrder')
	{
		$ReservedPropertyOrder->copyReservedPropertyOrder($input);
	}	

	$ReservedPropertyOrdersRS = $ReservedPropertyOrder->getReservedPropertyOrders($input);
	$result['DB']['ReservedPropertyOrders'] = $ReservedPropertyOrdersRS['result'];
	$result['pages']['ReservedPropertyOrders'] = $ReservedPropertyOrdersRS['pages'];	
	if(!empty($entityID) || !empty($entityAlias))
	{
		
		$result['DB']['ReservedPropertyOrder'] = $ReservedPropertyOrder->getReservedPropertyOrder($input);
		$result['DB']['ReservedPropertyOrderItem'] = $ReservedPropertyOrder->getReservedPropertyOrderItem($input);
		
		//$result['DB']['ReservedPropertyOrderFields'] = $ReservedPropertyOrder->getReservedPropertyOrderFields($input);
		/*
		if(!empty($entityFieldID))
		{
			$result['DB']['ReservedPropertyOrderField'] = $ReservedPropertyOrder->getReservedPropertyOrderField($input);
			$result['DB']['ReservedPropertyOrderOptions'] = $ReservedPropertyOrder->getReservedPropertyOrderOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['ReservedPropertyOrderOption'] = $ReservedPropertyOrder->getReservedPropertyOrderOption($input);
			}			
		}
		*/
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}


function addReservedPropertyOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservedPropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('ReservedPropertyOrderID',$entityID);}
	
	$entityAlias = $input['ReservedPropertyOrder'];
	$entityFieldID = $input['ReservedPropertyOrderFieldID'];
	$entityOptionID = $input['ReservedPropertyOrderOptionID'];
	//creat objects			
	$ReservedPropertyOrder = new ReservedPropertyOrderClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode']=='save')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address1',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAddress1']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderCity']);
			$CORE->setInputVar('UserField'.DTR.'Region',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderRegion']);
			$CORE->setInputVar('UserField'.DTR.'PostCode',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPostCode']);
			$CORE->setInputVar('UserField'.DTR.'CountryID',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderCountryID']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPhone']);
			$CORE->setInputVar('User'.DTR.'Email',$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderEmail']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$ReservedPropertyOrder = new ReservedPropertyOrderClass();		
		}
		$result['DB'] = $ReservedPropertyOrder->addReservedPropertyOrder($input);
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		//$totals = $ReservedPropertyOrder->getOrderTotals($input);
		//$result['Vars']['OrderTotals'] = $totals;
	}

	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	return $result;
}

function getReservedPropertyOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservedPropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('ReservedPropertyOrderID',$entityID);}
	$entityAlias = $input['ReservedPropertyOrder'];
	$entityFieldID = $input['ReservedPropertyOrderFieldID'];
	$entityOptionID = $input['ReservedPropertyOrderOptionID'];
	//creat objects			
	$ReservedPropertyOrder = new ReservedPropertyOrderClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode'] == 'save')
	{
		$ReservedPropertyOrder->updateReservedPropertyOrder($input);
	}
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['ReservedPropertyOrder'] = $ReservedPropertyOrder->getReservedPropertyOrder($input);
		//$result['DB']['ReservedPropertyOrderFields'] = $ReservedPropertyOrder->getReservedPropertyOrderFields($input);
		$result['DB']['ReservedPropertyOrderItem'] = $ReservedPropertyOrder->getReservedPropertyOrderItem($input);
	}
	return $result;
}


/**
* Gets ReservedPropertyOrders. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getReservedPropertyOrders($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ReservedPropertyOrder.getReservedPropertyOrders.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ReservedPropertyOrder = new ReservedPropertyOrderServer(&$SERVER,&$DS);
	//get content
	$ReservedPropertyOrdersRS = $ReservedPropertyOrder->getReservedPropertyOrders($input);
	$SERVER->setOutput($ReservedPropertyOrdersRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ReservedPropertyOrder.getReservedPropertyOrders.End','End');
	return $returnValue;
}

?>