<?php
//XCMSPro: ResourceBid entity WebService public methods

function addResourceBid()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$userID = $user['UserID'];
	$config = $CORE->getConfig();
	$entityID = $input['ResourceBidID'];
	$entityAlias = $input['ResourceBid'];
	//creat objects			
	$ResourceBid = new ResourceBidClass();
	//get content
	if($input['actionMode']=='add')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
		}
		if($input['ResourceMinPrice']<$input['ResourceBid'.DTR.'ResourceBidPrice'])
		{
			$ResourceBid->addResourceBid($input);
		}
		
	}
	return $result;
}


/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageResourceBids()
{
	global $CORE, $changeResourceBidProcessStatus;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ResourceBidID'];
	$entityAlias = $input['ResourceBid'];
	//creat objects			
	$ResourceBid = new ResourceBidClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ResourceBid->deleteResourceBid($input);
	}
	elseif($input['actionMode']=='add')
	{
		if($changeResourceBidProcessStatus!='Y')
		{
			$ResourceBid->addResourceBid($input);
			$changeResourceBidProcessStatus = 'Y';
		}
	}
	elseif($input['actionMode']=='save')
	{
		if($changeResourceBidProcessStatus!='Y')
		{		
			$ResourceBid->setResourceBid($input);
			$changeResourceBidProcessStatus = 'Y';
		}
	}

	$ResourceBidsRS = $ResourceBid->getResourceBids($input);
	$result['DB']['ResourceBids'] = $ResourceBidsRS;
	
	return $result;
}



/**
* Gets ResourceBids. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceBids($in='')
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ResourceBid = new ResourceBidClass();
	if($input['biddingMode']=='close')
	{
		$ResourceBid->closeBidding($input);
	}	
	//get content
	$ResourceBidsRS = $ResourceBid->getBids($input);
	$result['DB']['Bids'] = $ResourceBidsRS;

	return $result;
}

function getUserBids()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ResourceBid = new ResourceBidClass();
	//get content
	$input['viewMode']='user';
	$ResourceBidsRS = $ResourceBid->getBids($input);
	//print_r($ResourceBidsRS);
	$result['DB']['Bids'] = $ResourceBidsRS;

	return $result;
}
?>