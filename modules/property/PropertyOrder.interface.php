<?php
//XCMSPro: PropertyOrder entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function managePropertyOrders()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['PropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('PropertyOrderID',$entityID);}
	$entityAlias = $input['PropertyOrder'];
	$entityFieldID = $input['PropertyOrderFieldID'];
	$entityOptionID = $input['PropertyOrderOptionID'];
	//creat objects			
	$PropertyOrder = new PropertyOrderClass();
	//get content
	if($input['actionMode']=='savelist')
	{
		$PropertyOrder->setPropertyOrders($input);
	}
	if($input['actionMode']=='delete')
	{
		$PropertyOrder->deletePropertyOrder($input);
		//$PropertyOrder->deletePropertyOrderField($input);
		//$PropertyOrder->deletePropertyOrderOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$PropertyOrder->setPropertyOrder($input);
		//$PropertyOrder->setPropertyOrderField($input);		
		//$PropertyOrder->setPropertyOrderOption($input);
		//$PropertyOrder->updateBoxPositions($input['PropertyOrderBox'.DTR.'PropertyOrderBoxID']);		
	}
	elseif($input['actionMode']=='copyPropertyOrder')
	{
		$PropertyOrder->copyPropertyOrder($input);
	}	

	$PropertyOrdersRS = $PropertyOrder->getPropertyOrders($input);
	$result['DB']['PropertyOrders'] = $PropertyOrdersRS['result'];
	$result['pages']['PropertyOrders'] = $PropertyOrdersRS['pages'];	
	if(!empty($entityID) || !empty($entityAlias))
	{
		
		$result['DB']['PropertyOrder'] = $PropertyOrder->getPropertyOrder($input);
		$result['DB']['PropertyOrderItem'] = $PropertyOrder->getPropertyOrderItem($input);
		
		//$result['DB']['PropertyOrderFields'] = $PropertyOrder->getPropertyOrderFields($input);
		/*
		if(!empty($entityFieldID))
		{
			$result['DB']['PropertyOrderField'] = $PropertyOrder->getPropertyOrderField($input);
			$result['DB']['PropertyOrderOptions'] = $PropertyOrder->getPropertyOrderOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['PropertyOrderOption'] = $PropertyOrder->getPropertyOrderOption($input);
			}			
		}
		*/
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}


function addPropertyOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['PropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('PropertyOrderID',$entityID);}
	
	$entityAlias = $input['PropertyOrder'];
	$entityFieldID = $input['PropertyOrderFieldID'];
	$entityOptionID = $input['PropertyOrderOptionID'];
	//creat objects			
	$PropertyOrder = new PropertyOrderClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode']=='save')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['PropertyOrder'.DTR.'PropertyOrderFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['PropertyOrder'.DTR.'PropertyOrderLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address1',$input['PropertyOrder'.DTR.'PropertyOrderAddress1']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['PropertyOrder'.DTR.'PropertyOrderCity']);
			$CORE->setInputVar('UserField'.DTR.'Region',$input['PropertyOrder'.DTR.'PropertyOrderRegion']);
			$CORE->setInputVar('UserField'.DTR.'PostCode',$input['PropertyOrder'.DTR.'PropertyOrderPostCode']);
			$CORE->setInputVar('UserField'.DTR.'CountryID',$input['PropertyOrder'.DTR.'PropertyOrderCountryID']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['PropertyOrder'.DTR.'PropertyOrderPhone']);
			$CORE->setInputVar('User'.DTR.'Email',$input['PropertyOrder'.DTR.'PropertyOrderEmail']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$PropertyOrder = new PropertyOrderClass();		
		}
		$result['DB'] = $PropertyOrder->addPropertyOrder($input);
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		$totals = $PropertyOrder->getOrderTotals($input);
		$result['Vars']['OrderTotals'] = $totals;
	}

	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	return $result;
}

function getPropertyOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['PropertyOrderID'];
	if(empty($entityID)) {$entityID = $input['OrderID']; $CORE->setInputVar('PropertyOrderID',$entityID);}
	$entityAlias = $input['PropertyOrder'];
	$entityFieldID = $input['PropertyOrderFieldID'];
	$entityOptionID = $input['PropertyOrderOptionID'];
	//creat objects			
	$PropertyOrder = new PropertyOrderClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode'] == 'save')
	{
		$PropertyOrder->updatePropertyOrder($input);
	}
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['PropertyOrder'] = $PropertyOrder->getPropertyOrder($input);
		//$result['DB']['PropertyOrderFields'] = $PropertyOrder->getPropertyOrderFields($input);
		$result['DB']['PropertyOrderItem'] = $PropertyOrder->getPropertyOrderItem($input);
	}
	return $result;
}


/**
* Gets PropertyOrders. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getPropertyOrders($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('PropertyOrder.getPropertyOrders.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$PropertyOrder = new PropertyOrderServer(&$SERVER,&$DS);
	//get content
	$PropertyOrdersRS = $PropertyOrder->getPropertyOrders($input);
	$SERVER->setOutput($PropertyOrdersRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('PropertyOrder.getPropertyOrders.End','End');
	return $returnValue;
}

?>