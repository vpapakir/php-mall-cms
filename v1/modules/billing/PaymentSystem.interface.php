<?php
//XCMSPro: BillinTransaction entity WebService public methods

//$SERVER_SOAP->register('getPaymentForm');
/*
	There are 3 types of payments in the world:
	
	1. genarte the payment form - switch to payment gateway - redirect back to the system with payment result (analize payment result here)
	2. generate the payment form - switch to payment gateway - payment gateway makes a hidden back request and payemnt is registered (analize payment result here) - redirect back to website and show payment result
	3. generate an XML payment request - process the XML request, analize rezult, add trsnsactions , redirect to payment result page
	
	functions in interface
	1. doPaymentRequest() - generates the request to payment gateway
	2. doPayment() - checks the payment gateway resukt and process payment.
	3. getPaymentResult() - gets the order information and generates payment result array
		
	functions used in payment gateway classes
	1. doPaymentRequest - generates the request to payment gateway.
	2. doPayment  - checks the payment gateway resukt and process payment.
	3. getPaymentRequest - gets the order information and generates payment result array
	
	SIDs used in redirecs
	1. for doPaymentRequest() - paymentRequest OR any SID where the payment form box is shown 
	2. for doPayment - payment - used for type 2 for hidden request and as payment result processing in type 1
	3. for getPaymentResult - paymentResult - used for the type 2 only
	
	Sample of path of functions for PayPal (Type2)
	BillingTransaction.interface.php:doBillingPayment()
	->PaymentSystem.interface.php:doPaymentRequest()
	->methods/PayPalIPN.class.php:doPaymentRequest()
	->gateway
	->redirect to /go/payment/paymentMethod/PayPalIPN/OrderID/2/ (hidden request from gateway)
	->PaymentSystem.interface.php:doPayment()
	->methods/PayPalIPN.class.php:doPayment()
	->BillingOrderServer.class.php:doOrderPayment()
	->gateway redirect to /go/paymentResult/paymentMethod/PayPalIPN/OrderID/2/
	->PaymentSystem.interface.php:getPaymentResult()
	->BillingOrderServer.class.php:getOrderPaymentResult()
	->redirect to start payment URL OR to payment result page
	
	Type1 payment:
	BillingTransaction.interface.php:doBillingPayment()
	->PaymentSystem.interface.php:doPaymentRequest()
	->methods/Type1.class.php:doPaymentRequest()
	->gateway
	->redirect to /go/payment/paymentMethod/PayPalIPN/OrderID/2/ (hidden request from gateway)
	->PaymentSystem.interface.php:doPayment()
	->methods/PayPalIPN.class.php:doPayment()
	->BillingOrderServer.class.php:doOrderPayment()
	->methods/PayPalIPN.class.php:doPayment() redirect to /go/paymentResult/paymentMethod/PayPalIPN/OrderID/2/
	->PaymentSystem.interface.php:getPaymentResult()
	->BillingOrderServer.class.php:getOrderPaymentResult()
	->redirect to start payment URL OR to payment result page
	
*/

//starts the pricess of payment via an outside payment system
function doPaymentRequest($input='')
{
	global $CORE;
	$input = $CORE->getInput();
	$paymentMethod = $input['paymentMethod'];
	$paymentMode = $input['paymentMode'];
	//paymentMode = hidden - generate the link and redirect automatically to payment gateway
	//paymentMode = form - show the payment form
	$modulePath = dirname(ereg_replace("\\\\","/",__FILE__));
	$paymentClassPath = $modulePath.'/methods/'.$paymentMethod.'.class.php';


	if(empty($input['BillingOrder'.DTR.'OrderAmount']))
	{
		$ServiceObject = new ServiceClass();
		$serviceRS = $ServiceObject->getService($input);
		$input['BillingOrder'.DTR.'OrderAmount'] = $serviceRS[0]['ServicePrice'];
	}
	//print_r($input);
	//die('rrr');

	if($paymentMode=='form')
	{
		//the payment for is generated from tempplate
		//call this template to show the payment for to user
		if(!empty($paymentMethod))
		{
			$CORE->setInputVar("ResourceTemplate",$paymentMethod);
		}	
	}
	else
	{		
		//payment from is generated in the code and automatically filled out and sent
		if($input['actionMode']=='pay')
		{
			//add billing order and genearte the OrderID
			$input['actionMode'] ='save';
			$BillingOrder = new BillingOrderServer();
			$input['BillingOrder'.DTR.'OrderPaymentMethod'] = $paymentMethod;
			$billingOrderRS = $BillingOrder->setOrder($input);
			$input['BillingOrder'.DTR.'BillingOrderID'] = $billingOrderRS[0]['BillingOrderID'];
			$input['BillingOrder'.DTR.'OrderAmount'] = $billingOrderRS[0]['OrderAmount'];
		}	
		if(is_file($paymentClassPath) && !empty($input['BillingOrder'.DTR.'BillingOrderID']))
		{
			//include required payment method libraries
			include_once($paymentClassPath);
			eval('$paymentObject = new '.$paymentMethod.'();');
			$inputBilling['actionMode'] ='save';
			//process first payment step ... ggenerate the request to payment system and switch to it
			$rs=$paymentObject->doPaymentRequest($input);
		}
	}

	return $retval;
}

//$SERVER_SOAP->register('doPayment');
function doPayment($in='')
{
	global $CORE;
	$input = $CORE->getInput();
	//input format
	$paymentMethod = $input['paymentMethod'];
	$orderID = $input['OrderID'];
	$modulePath = dirname(ereg_replace("\\\\","/",__FILE__));
	$paymentClassPath = $modulePath.'/methods/'.$paymentMethod.'.class.php';
	if(is_file($paymentClassPath) && !empty($orderID))
	{
		//include required payment method libraries
		include_once($paymentClassPath);
		eval('$paymentObject = new '.$paymentMethod.'();');
		$rs=$paymentObject->doPayment($input);
	}
	
}

function getPaymentResult($input='')
{
	global $CORE;
	$input = $CORE->getInput();
	$paymentMethod = $input['paymentMethod'];

	if(!empty($paymentMethod))
	{
		//$CORE->setInputVars("ResourceTemplate",$paymentMethod);
	}
	if(!empty($input['OrderID']))
	{
		$BillingOrder = new BillingOrderServer();	
		$BillingOrder->getOrderPaymentResult($input);
	}
	return $retval;
}

function doPaymentOLd($in)
{
	global $CORE;
	$input = $CORE->getInput();
	$paymentType = $input['paymentType'];
	$paymentMethod = $input['paymentMethod'];

	if(!empty($paymentMethod))
	{
		$CORE->setInputVars("ResourceTemplate",$paymentMethod);
	}
		
	if($paymentType=='paypalipn')
	{
		$PayPalIPN = new PayPalIPN(&$SERVER,&$DS);	
		$PayPalIPN->doPayment($input);
	}
	elseif($paymentType=='paypalpdt')
	{
		$PayPalPDT = new PayPalPDT(&$SERVER,&$DS);	
		$PayPalPDT->doPayment($input);
	}	
	else
	{
		$orderID = $input['item_number'];
		//print_r($input);
		$orderRS = $DS->query("SELECT OrderPaymentStatus, OrderStatus, OrderAmount FROM {dbprefix}BillingOrder WHERE BillingOrderID='$orderID'");
		$result = '<PaymentResult>';
		$result .= '<OrderPaymentStatus>'.$orderRS['sql'][0]['OrderPaymentStatus'].'</OrderPaymentStatus>';
		$result .= '<OrderStatus>'.$orderRS['sql'][0]['OrderStatus'].'</OrderStatus>';
		$result .= '<OrderAmount>'.$orderRS['sql'][0]['OrderAmount'].'</OrderAmount>';
		$result .= '</PaymentResult>';
		
		$SERVER->setOutput($result);
		//$PayPalIPN = new PayPalIPN(&$SERVER,&$DS);	
		//$PayPalIPN->doPayment($input);	
		/*
		[payment_date] => 10:21:08 Jul 10, 2005 PDT
		[txn_type] => web_accept
		[last_name] => Chebotar
		[payment_gross] => 10.00
		[mc_currency] => USD
		[item_name] => Link Exchange Service
		[payment_type] => instant
		[business] => billing@lookforlinks.com
		[verify_sign] => ABEnRT6CKiqwyx8uy3zeShDY52KyAKzMVLDiZ5umCbz-a-KC.WWpQofW
		[payer_status] => unverified
		[test_ipn] => 1
		[payer_email] => test@abtsolutions.net
		[tax] => 0.00
		[txn_id] => 1HW71727G9741751D
		[first_name] => Aurel
		[quantity] => 1
		[receiver_email] => billing@lookforlinks.com
		[payer_id] => 2CEHDXACXW4P8
		[receiver_id] => 3YXGM42RRJ6JG
		[item_number] => 18693906092005071019422231h111
		[payment_status] => Completed
		[mc_fee] => 0.64
		[payment_fee] => 0.64
		[shipping] => 0.00
		[mc_gross] => 10.00
		[custom] => 
		[charset] => windows-1252
		[notify_version] => 1.7
		[SID] => paymentresult
		[OwnerID] => lookforlinks
		[RemoteIP] => 85.202.164.229
		[ApplicationDomain] => lookforlinks.com
		[SectionID] => paymentresult
		[SiteLang] => en
		[layoutMode] => database
		[paymentType] => system
		[SessionID] => 20051007165433622b6b82fd007043a613a1eade8c76f3
		[SectionType] => 
		[downLevels] => 
		[treeType] => 
		[remoteMode] => 
		[Config] => Array
			(
				[TimeZone] => 0
				[RootURL] => http://www.lookforlinks.com/
				[RootMainURL] => 
				[SiteRootURL] => 
				[URLSearchEngine] => go/
				[SSLURL] => https://www.lookforlinks.com/
				[UploadURL] => upload/
				[SectionID] => paymentresult
				[MailEncoding] => iso-8859-2
				[ClientType] => front
				[PromoMode] => active
				[ApplicationDomain] => lookforlinks.com
				[OwnerID] => lookforlinks
				[OwnerType] => common
				[SiteOwners] => 
				[RemoteOwnerID] => 
				[SiteMail] => info@lookforlinks.com
				[SiteName] => LookForLinks.com
				[SiteSlogan] => the ultimate automatic link exchange solution
			)
	
		[XCMSPromoCode] => 18693906092005050902033573n111
		[lookforlinks] => 20051007165433622b6b82fd007043a613a1eade8c76f3			
		*/
	}	

	return $retval;
}



?>