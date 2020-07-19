<?php
//XCMSPro: TourOrder entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageTourOrders($input='')
{
	global $CORE;
	//get input
	if(empty($input)){$input = $CORE->getInput($in);}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TourOrderID'];
	$entityAlias = $input['TourOrder'];
	$entityFieldID = $input['TourOrderFieldID'];
	$entityOptionID = $input['TourOrderOptionID'];
	//creat objects
	//print_r($input);			
	
	
	$TourOrder = new TourOrderClass();
	//get content
	if($input['actionMode']=='savelist')
	{
		$TourOrder->setTourOrders($input);
	}
	if($input['actionMode']=='delete')
	{
		$TourOrder->deleteTourOrder($input);
		//$TourOrder->deleteTourOrderField($input);
		//$TourOrder->deleteTourOrderOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		//print_r($input);
		$TourOrder->setTourOrder($input);
		$TourOrder->addTourOrderProgram($input);
		
		if(is_array($input['TourParticipant'.DTR.'TourParticipantID']))
		{
			$TourOrder->setTourParticipants($input);
		}
		elseif(!empty($input['TourParticipant'.DTR.'TourParticipantPassport']))
		{
			$TourOrder->setTourParticipant($input);
		}

		if(is_array($input['TourProgram'.DTR.'TourProgramID']))
		{
			$TourOrder->setTourPrograms($input);
		}
		
		//$TourOrder->setTourOrderField($input);		
		//$TourOrder->setTourOrderOption($input);
		//$TourOrder->updateBoxPositions($input['TourOrderBox'.DTR.'TourOrderBoxID']);		
	}
	elseif($input['actionMode']=='add2')
	{
		$TourOrder->addTourParticipants($input);
	}
	elseif($input['actionMode']=='copyTourOrder')
	{
		$TourOrder->copyTourOrder($input);
	}	
	elseif($input['actionMode']=='delete1')
	{
		$TourOrder->deleteTourParticipant($input);
	}
	

	$TourOrdersRS = $TourOrder->getTourOrders($input);
	$result['DB']['TourOrders'] = $TourOrdersRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['TourOrder'] = $TourOrder->getTourOrder($input);
		//$result['DB']['TourOrderFields'] = $TourOrder->getTourOrderFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['TourOrderField'] = $TourOrder->getTourOrderField($input);
			$result['DB']['TourOrderOptions'] = $TourOrder->getTourOrderOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['TourOrderOption'] = $TourOrder->getTourOrderOption($input);
			}			
		}
		
		$TourParticipantsRS = $TourOrder->getTourParticipants($input);
		$result['DB']['TourParticipants'] = $TourParticipantsRS;
		
		$TourProgramsRS = $TourOrder->getTourOrderPrograms($input);
		$result['DB']['TourTourOrderPrograms'] = $TourProgramsRS;
		
		$result['TourMessages'] = $CORE->callService('getTourMessages','mailServer',$input);
	}
	
	//print_r($result);
	
	$PaymentMethods = $CORE->callService('managePaymentMethodSettings','billingServer',$input);
	$result['DB']['PaymentMethods'] = $PaymentMethods['DB']['PaymentMethods'];
	
	//print_r($result['DB']['PaymentMethods']);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}



function addTourOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TourOrderID'];
	$entityAlias = $input['TourOrder'];
	$entityFieldID = $input['TourOrderFieldID'];
	$entityOptionID = $input['TourOrderOptionID'];
	//creat objects			
	$TourOrder = new TourOrderClass();
	$userID = $user['UserID'];
	//get content	
	//print_r($input);
	if($input['actionMode']=='order')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['TourOrder'.DTR.'TourOrderFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['TourOrder'.DTR.'TourOrderLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address1',$input['TourOrder'.DTR.'TourOrderAddress1']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['TourOrder'.DTR.'TourOrderCity']);
			$CORE->setInputVar('UserField'.DTR.'Region',$input['TourOrder'.DTR.'TourOrderRegion']);
			$CORE->setInputVar('UserField'.DTR.'PostCode',$input['TourOrder'.DTR.'TourOrderPostCode']);
			$CORE->setInputVar('UserField'.DTR.'CountryID',$input['TourOrder'.DTR.'TourOrderCountryID']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['TourOrder'.DTR.'TourOrderPhone']);
			$CORE->setInputVar('User'.DTR.'Email',$input['TourOrder'.DTR.'TourOrderEmail']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$TourOrder = new TourOrderClass();		
		}
		$result['DB'] = $TourOrder->addTourOrder($input);
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		$totals = $TourOrder->getOrderTotals($input);
		$result['Vars']['OrderTotals'] = $totals;
	}

	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	//print_r($result);
		
	return $result;
}

function getTourOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TourOrderID'];
	$entityAlias = $input['TourOrder'];
	$entityFieldID = $input['TourOrderFieldID'];
	$entityOptionID = $input['TourOrderOptionID'];
	//creat objects			
	$tourObject = new TourClass();
	$TourOrder = new TourOrderClass();
	$tourTypeObject = new TourTypeClass();
	$userID = $user['UserID'];
	//get content	
	if($input['actionMode'] == 'save')
	{
		$TourOrder->updateTourOrder($input);
	}
	
	//$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	//$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['TourOrder'] = $TourOrder->getTourOrder($input);
		//$result['DB']['TourOrderFields'] = $TourOrder->getTourOrderFields($input);
		$result['DB']['TourOrderItem'] = $TourOrder->getTourOrderItem($input);
		//print_r($result);
	}
	
	$fieldsRS = $tourObject->getTourFields($input);
	$result['DB']['TourField'] = $fieldsRS['TourField'];
	//print_r($result['DB']['TourField']);
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($tourRS[0]['TourCountryID'])) {$input['Tour'.DTR.'TourCountryID'] = $tourRS[0]['TourCountryID'];}
	if(!empty($input['Tour'.DTR.'TourCountryID']))
	{
		$inputRegion['CountryID'] = $input['Tour'.DTR.'TourCountryID'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
		//echo 'regions=';
		//print_r($result['DB']['Regions']);
		
		if(!empty($tourRS[0]['TourRegionID'])) {$input['Tour'.DTR.'TourRegionID'] = $tourRS[0]['TourRegionID'];}
		if(!empty($input['Tour'.DTR.'TourRegionID']))
		{
			//echo 'tttt='. $input['Tour'.DTR.'TourRegionID'];
			$inputRegion['RegionID'] = $input['Tour'.DTR.'TourRegionID'];
			$regionsRS = $CORE->callService('getCities','coreServer',$inputRegion);
			$result['DB']['Cities'] = $regionsRS['DB']['Cities'];			
		}		
	}
	
	return $result;
}


/**
* Gets TourOrders. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourOrders()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TourOrderID'];
	$entityAlias = $input['TourOrder'];
	$entityFieldID = $input['TourOrderFieldID'];
	$entityOptionID = $input['TourOrderOptionID'];
	$TourOrder = new TourOrderClass();
	
	$TourOrdersRS = $TourOrder->getTourOrders($input);
	$result['DB']['TourOrders'] = $TourOrdersRS;
	
	return $result;
}
/**
* Gets TourOrder. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*function getTourOrder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('TourOrder.getTourOrder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$TourOrder = new TourOrderServer(&$SERVER,&$DS);
	//get content
	$TourOrderRS = $TourOrder->getTourOrder($input);
	$SERVER->setOutput($TourOrderRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('TourOrder.getTourOrder.End','End');
	return $returnValue;
}*/

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*function manageTourOrder($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('TourOrder.manageTourOrder.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$TourOrder = new TourOrderServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$TourOrder->setTourOrder($input);
		$TourOrder->setTourOrderBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$TourOrder->deleteTourOrder($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$TourOrder->deleteTourOrderBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$TourOrder->setTourOrderBox($input);
	}	

	if($input['actionMode']=='copyTourOrder')
	{	
		$TourOrder->copyTourOrder($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $TourOrder->setTourOrder($input);
	}
	else
	{
		$contentRS = $TourOrder->getTourOrder($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $TourOrder->getTourOrderBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('TourOrderType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$TourOrder->getTourOrdersRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('TourOrder.manageTourOrder.End','End');
	return $returnValue;
}*/

/**
* Get the references used in TourOrder. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourOrderRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getTourOrderRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getTourOrderRefs.End','End');
	return $returnValue;
}
?>