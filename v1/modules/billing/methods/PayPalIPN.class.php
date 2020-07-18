<?php
class PayPalIPN
{

    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function PayPalIPN()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$PaymentMethodSetting = new PaymentMethodSettingClass();
		$this->_settings = $PaymentMethodSetting->getPaymentMethodSettingsFormated('PayPalIPN');
	}
	
	// PUBLIC METHODS
	function doPaymentRequest ($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config = $SERVER->getConfig();
		$setting = $this->_settings;
		//$testMod = 'Y';
		$testMode = $setting['TestMode'];
		$accountEmail = $setting['AccountEmail'];
		$currency = $setting['CurrencyCode'];
		$itemName = $setting['ItemName'];
		//live mode
		//$this->_CLIENT->goLink("https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business=billing%40lookforlinks%2ecom&item_name=LookForLinks%20monthly%20fee&item_number=l4lmonth&no_shipping=1&no_note=1&currency_code=USD&a3=5%2e00&p3=1&t3=M&src=1&sra=1");
		//test mode
		//http://www.lookforlinks.com/go/paypalpdt
		//http://paypaltech.com/Paulam/content/PDTvsIPN.htm
		$orderAmount= round($input['BillingOrder'.DTR.'OrderAmount'],2);
		$orderID= $input['BillingOrder'.DTR.'BillingOrderID'];
		
		if($input['windowMode']=='remote')
		{
			$returnURL = $input['RemoteRootURL'].$input['RemoteURLSearchEngine'].'paymentResult/OrderID/'.$orderID.'/';
			$remoteMail= $input['RemoteSiteMail'];
			$remoteSiteName= $input['RemoteSiteName'];
		}
		else
		{
			$returnURL = $config['url'].'paymentResult/paymentMethod/PayPalIPN/OrderID/'.$orderID.'/';
		}				
		//$orderAmount = $orderAmount + $orderAmount*0.039 + 0.3;
		//$orderAmount= round($orderAmount,2);
		//$accountEmail = "billing%40lookforlinks%2ecom";
		//$accountEmail = "billing%40linkexchangesolution%2ecom";
		if($testMode=='Y')
		{
			$testMode = "&test_ipn=1&rm=2&return=".$returnURL;
			//$testMode = "&test_ipn=1&rm=2&return=http://www.lookforlinks.com/go/home&notify_url==http://www.lookforlinks.com/go/paypalipn";
			//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business=billing%40lookforlinks%2ecom&item_name=Links%20Echange%20Service&item_number=$orderID&no_shipping=1&no_note=1&currency_code=USD&a3=$orderAmount%2e00&p3=1&t3=M&src=1&sra=1".$returnURL.$testMode;									
			$url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&business=$accountEmail&item_name=$itemName&item_number=$orderID&no_shipping=1&no_note=1&currency_code=$currency&amount=$orderAmount".$testMode;									
		}
		else
		{
			$testMode = "&return=".$returnURL;
			$url = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=$accountEmail&item_name=$itemName&item_number=$orderID&no_shipping=1&no_note=1&currency_code=$currency&amount=$orderAmount".$testMode;									
		}
		//echo $url;
		header("Location: $url");
		die('');		
	}
	
	function doPayment($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config = $SERVER->getConfig();
		global $_POST;

		$setting = $this->_settings;

		//$testMod = 'Y';
		$testMode = $setting['TestMode'];
		
		$accountEmail = $setting['AccountEmail'];
		$currency = $setting['CurrencyCode'];
		$itemName = $setting['ItemName'];		
		
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			if($key!='SID' && $key!='windowMode' && $key!='RemoteRootURL' && $key!='RemoteSiteName' && $key!='RemoteOwnerID' && $key!='RemoteSiteSlogan' && $key!='RemoteSiteMail' && $key!='RemoteSiteLang' && $key!='RemoteURLSearchEngine'  && $key!='RemoteAffiliateCode' )
			{		
				$req .= "&$key=$value";
			}
		}
		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		if($testMode=='Y')
		{
			$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
		}
		else
		{
			$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
		}
		// assign posted variables to local variables
		$item_name = $input['item_name'];
		$item_number = $input['item_number'];
		$payment_status = $input['payment_status'];
		$payment_amount = $input['mc_gross'];
		$payment_currency = $input['mc_currency'];
		$txn_id = $input['txn_id'];
		$receiver_email = $input['receiver_email'];
		$payer_email = $input['payer_email'];
		
		$firstname = $input['first_name'];
		$lastname = $input['last_name'];
		$itemname = $input['item_name'];
		$amount = $input['amount3'];
		$email = $input['payer_email'];
		
		$item_number = $input['item_number'];	
		
		if (empty($amount)) {$amount = $input['mc_gross'];}
		if (empty($amount)) {$amount = $input['amt'];}			
		/*		
				<hr>Array
		(
			[txn_type] => subscr_signup
			[subscr_id] => S-50S69528GP454374B
			[last_name] => Chebotar
			[item_name] => Links Exchange Service
			[mc_currency] => USD
			[amount3] => 10.00
			[recurring] => 1
			[verify_sign] => AI4yAtbjPxMKfCsuQwyuCA0UL2WWARNGlScE6a1HVChsJuW0EqLvd-SY
			[payer_status] => unverified
			[test_ipn] => 1
			[payer_email] => test@abtsolutions.net
			[first_name] => Aurel
			[receiver_email] => billing@lookforlinks.com
			[payer_id] => 2CEHDXACXW4P8
			[reattempt] => 1
			[item_number] => 18693906092005071001560791g111
			[subscr_date] => 16:36:14 Jul 09, 2005 PDT
			[charset] => windows-1252
			[notify_version] => 1.7
			[period3] => 1 M
			[mc_amount3] => 10.00
			[SID] => paypalipn
		)
			*/
		if (!$fp)
		{
			// HTTP ERROR
			$SERVER->setMessage('BillingServer.doPayment.err.PaymentConnectionError');
			$BillingOrder = new BillingOrderServer();	
			$resultIN['OrderID'] = $item_number;
			$resultIN['OrderAmount'] = $amount;
			$resultIN['OrderReasonDescription'] = 'Connection Error PayPal deposit by '.$firstname.' '.$lastname;
			$resultIN['OrderPaymentDetails'] = $email;
			$BillingOrder->doOrderPayment($resultIN,'cancell');			
		} 
		else
		{
			fputs ($fp, $header . $req);
			while (!feof($fp)) 
			{
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) 
				{
					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					//payment_status = 'Pending';
					if($testMode=='Y')
					{					
						$fp111 = fopen('ipntest.txt','a+');
						fwrite($fp111,'VERIFIED = '.$req."\n");
						fclose($fp111);
					}			
							
					if($payment_status=='Completed' && $receiver_email==$accountEmail)
					{
						$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
						$resultIN['OrderID'] = $item_number;
						$resultIN['OrderAmount'] = $amount;
						$resultIN['OrderReasonDescription'] = 'PayPal deposit by '.$firstname.' '.$lastname;
						$resultIN['OrderPaymentDetails'] = $email;	
						$BillingOrder->doOrderPayment($resultIN);												
					}
					elseif($payment_status=='Pending' && $receiver_email==$accountEmail)
					{
						$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
						$resultIN['OrderID'] = $item_number;
						$resultIN['OrderAmount'] = $amount;
						$resultIN['OrderReasonDescription'] = 'Pending PayPal deposit by '.$firstname.' '.$lastname;
						$resultIN['OrderPaymentDetails'] = $email;
						$BillingOrder->doOrderPayment($resultIN,'pending');					
					}
					else
					{
						$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
						$resultIN['OrderID'] = $item_number;
						$resultIN['OrderAmount'] = $amount;
						$resultIN['OrderReasonDescription'] = 'Cancell (no status) PayPal deposit by '.$firstname.' '.$lastname;
						$resultIN['OrderPaymentDetails'] = $email;
						$BillingOrder->doOrderPayment($resultIN,'cancelled');					
					}					
				}
				else if (strcmp ($res, "INVALID") == 0) 
				{
					if($testMode=='Y')
					{	
						$fp111 = fopen('ipntest.txt','a+');
						fwrite($fp111,'INVALID = '.$req."\n");
						fclose($fp111);				
					}
					$SERVER->setMessage('BillingServer.doPayment.err.PaymentInvalid');
					$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
					$resultIN['OrderID'] = $item_number;
					$resultIN['OrderAmount'] = $amount;
					$resultIN['OrderReasonDescription'] = 'Invalid PayPal deposit by '.$firstname.' '.$lastname;
					$resultIN['OrderPaymentDetails'] = $email;
					$BillingOrder->doOrderPayment($resultIN,'cancelled');
				}
			}
			fclose ($fp);
		}
		$retval = $saveResult;
		return $retval;		
	}
	
	
	function getPaymentResult ($input)
	{
		
	}
	
		
	function IPNOriginalCode()
	{
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		
		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
		
		// assign posted variables to local variables
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		
		if (!$fp) {
		// HTTP ERROR
		} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your Primary PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment
		}
		else if (strcmp ($res, "INVALID") == 0) {
		// log for manual investigation
		}
		}
		fclose ($fp);
		}
	}
	
} // end of UserSession

?>