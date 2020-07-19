<?php
//XCMSPro: BillinTransaction entity WebService public methods

/**
* Gets balance. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
//$SERVER_SOAP->register('addTransaction');
function doBillingPayment($input='')
{
	global $CORE;
	
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$BillingTransaction = new BillingTransactionServer();
	$ServiceObject = new ServiceClass();

	if($input['actionMode']=='buyService')
	{
		if(!empty($input['paymentMethod']))
		{
			$result = doPaymentRequest($input);
		}	
		else
		{
			$result = $ServiceObject->buyService($input);
		}
	}	
	elseif($input['actionMode']=='directPayment')
	{
		//print_r($input);
		if(!empty($input['paymentMethod']))
		{
			$result = doPaymentRequest($input);
		}	
		else
		{
			$result = $BillingTransaction->doBillingPayment($input);
		}
	}	
	elseif(!empty($input['paymentMethod']))
	{
		$result = doPaymentRequest($input);
	}
	//echo 'tttt';
	//$result = $BillingTransaction->doBillingPayment($input);
	return $result;
}

function getBillingPaymentForm($input='')
{
	global $CORE;
	if(empty($input))
	{
		$input = $CORE->getInput();
	}	
	$BillingTransaction = new BillingTransactionServer();
	$PaymentMethod = new PaymentMethodSettingClass();
	$ServiceClass = new ServiceClass();
	//get balance
	$rs = $BillingTransaction->getBalance($input);
	$result['Balance'] = $rs;
	//get prices
	$servicesRS = $ServiceClass->getServices($input);
	$result['DB']['Services'] = $servicesRS['result'];
	//get payment methods
	$methodsRS = $PaymentMethod->getPaymentMethods($input);
	$result['DB']['PaymentMethods'] = $methodsRS;
	
	if(!empty($input['paymentMethod'])) {
		$CORE->setInputVar('ResourceTemplate',$input['paymentMethod']);
	}
	
	//print_r($result);
	return $result;
}

function getBillingPaymentStatus($input='')
{
	global $CORE;
	$input = $CORE->getInput($in);
	//$DS = new CoreDataSource('billing','server');	
	$BillingOrder = new BillingOrderServer();	
	$PaymentMethodSetting = new PaymentMethodSettingClass();	
	
	$input = $CORE->getInput();
	$rs = $BillingOrder->getOrder($input);
	$result['DB']['BillingOrder'] = $rs[0];
	$input['paymentMethod'] = $rs[0]['OrderPaymentMethod'];
	$rs2 = $PaymentMethodSetting->getPaymentMethod($input);
	$result['DB']['PaymentMethod'] = $rs2[0];
	//print_r($result['DB']['PaymentMethod']);
	return $result;
}

//$SERVER_SOAP->register('getBalance');
function getBalance($in='')
{
	global $CORE;
	$BillingTransaction = new BillingTransactionServer();
	$input = $CORE->getInput();
	$balance = $BillingTransaction->getBalance($input);
	$result['Balance'] = $balance;
	return $result;
}

//$SERVER_SOAP->register('getTransactions');
function getTransactions($in)
{
	global $CORE;
	$DS = new CoreDataSource('billing','server');	
	$BillingTransaction = new BillingTransactionServer(&$SERVER,&$DS);
	$SERVER->setDebug('billing.getTransactions.Start','Start');
	$input = $SERVER->setInput($in);
	
	$retval = $BillingTransaction->getTransactions($input);
	$SERVER->setOutput($retval);
	$refsResult = $DS->query('TransactionReason',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);

	$retval = $SERVER->getOutput();

	$SERVER->setDebug('billing.getTransactions.End','End');
	return $retval;
}

//$SERVER_SOAP->register('addTransaction');
function addTransaction($in)
{
	global $CORE;
	$DS = new CoreDataSource('billing','server');	
	$BillingTransaction = new BillingTransactionServer(&$SERVER,&$DS);	
	$SERVER->setDebug('billing.addTransaction.Start','Start');
	$input = $SERVER->setInput($in);
	
	$retval = $BillingTransaction->addTransaction($input);
	$SERVER->setOutput($retval['xml']);
	$retval = $SERVER->getOutput();
	
	$SERVER->setDebug('billing.addTransaction.End','End');
	return $retval;
}

//$SERVER_SOAP->register('transferMoney');
function transferMoney($in)
{
	global $CORE;
	$DS = new CoreDataSource('billing','server');	
	$BillingTransaction = new BillingTransactionServer(&$SERVER,&$DS);	
	$SERVER->setDebug('billing.addTransaction.Start','Start');
	$input = $SERVER->setInput($in);
	
	$retval = $BillingTransaction->transferMoney($input);
	$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput();
	
	$SERVER->setDebug('billing.addTransaction.End','End');
	return $retval;
}
?>