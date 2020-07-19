<?php
//XCMSPro: BillinTransaction entity WebService public methods

/**
* manage order. For admin interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/

//$SERVER_SOAP->register('manageOrder');
function manageOrder()
{
	global $CORE;
	$input = $CORE->getInput($in);
	//$DS = new CoreDataSource('billing','server');	
	$BillingOrder = new BillingOrderServer();	
	$err='';
	$CORE->setDebug('billing.manageOrder.Start','Start');
	$input = $CORE->getInput();

	$saveRetval = $BillingOrder->setOrder($input);
	if($saveRetval && !$input['BillingOrder'.DTR.'BillingOrderID'])	
	{
		$retval = $saveRetval;
	}
	else
	{
		$retval = $BillingOrder->getOrder($input);
	}

	return $retval;
}

//$SERVER_SOAP->register('manageOrders');
function manageOrders()
{
	global $CORE;
//	global $SERVER;
//	$input = $CORE->getInput($in);
	$BillingOrder = new BillingOrderServer();
//	$input = $SERVER->getInput();
	$input = $CORE->getInput();
//	$user= $SERVER->getUser();
	$user= $CORE->getUser();
//	print_r($input);
	if($input['actionMode']=='savelist')
	{
		$saveRetval = $BillingOrder->setOrders($input);
	}else
	{
		$saveRetval = $BillingOrder->setOrder($input);
		$retval = $BillingOrder->getOrders($input);
//		print_r($retval);
	}
	return $retval;
}


?>