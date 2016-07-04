<?php
//XCMSPro: TourCartItem entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageTourCartItems()
{
	global $CORE, $changeTourCartItemProcessStatus;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TourCartItemID'];
	$entityAlias = $input['TourCartItem'];
	//creat objects			
	$TourCartItem = new TourCartItemClass();
	$tourObject = new TourClass();
	$tourTypeObject = new TourTypeClass();
	//get content
	
	if($input['actionMode']=='delete')
	{
		$TourCartItem->deleteTourCartItem($input);
	}
	elseif($input['actionMode']=='add')
	{
		if($changeTourCartItemProcessStatus!='Y')
		{
			$TourCartItem->addTourCartItem($input);
			$changeTourCartItemProcessStatus = 'Y';
		}
	}
	elseif($input['actionMode']=='save')
	{
		if($changeTourCartItemProcessStatus!='Y')
		{		
			$TourCartItem->setTourCartItem($input);
			$changeTourCartItemProcessStatus = 'Y';
		}
	}
	elseif($input['actionMode']=='order')
	{
		$CORE->callService('addTourOrder','tourServer',$input);
	}
	$TourCartItemsRS = $TourCartItem->getTourCartItems($input);
	$result['DB']['TourCartItems'] = $TourCartItemsRS;

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
* Gets TourCartItems. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourCartItems($in)
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$TourCartItem = new TourCartItemClass();
	//get content
	
	$TourCartItemsRS = $TourCartItem->getTourCartItems($input);
	$result['DB']['TourCartItems'] = $TourCartItemsRS;

	return $result;
}
?>