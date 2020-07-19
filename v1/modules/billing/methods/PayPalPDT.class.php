<?php
class PayPalPDT
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
	function PayPalPDT($controller,$ds)
	{
		$this->_controller = &$controller;
		$this->_DS = &$ds;
		$this->_config = $this->_controller->getConfig();
	}
	
	// PUBLIC METHODS
	function doPayment($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config = $SERVER->getConfig();

		$mode = 'test';
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-synch';
		
		$tx_token = $input['tx'];
		if($mode=='test')
		{
			$auth_token = "eu2ShoP2kM13sKX-VWpSg3-U1Fmv7htBcge1unPf67xg8iypT6nHO3fSMTW";//sandbox
		}
		else
		{
			$auth_token = "xck2B1GzzJULfeagqx7pyp5asSJIdAdr42etaJW2turMEJN2OccBOatxaCi";//real
		}		
		
		$req .= "&tx=$tx_token&at=$auth_token";

		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		if($mode=='test')
		{
			$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
		}
		else
		{
			$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
		}
		// If possible, securely post back to paypal using HTTPS
		// Your PHP server will need to be SSL enabled
		// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		
		
		if (!$fp) 
		{
			// HTTP ERROR
			$SERVER->setMessage('BillingServer.doPayment.err.PaymentConnectionError');
		} 
		else 
		{
			
			fputs ($fp, $header . $req);
			// read the body data 
			$res = '';
			$headerdone = false;
			while (!feof($fp)) 
			{
				$line = fgets ($fp, 1024);
				if (strcmp($line, "\r\n") == 0) 
				{
					// read the header
					$headerdone = true;
				}
				else if ($headerdone)
				{
					// header has been read. now read the contents
					$res .= $line;
				}
			}
			//echo 'res='.$res;
			// parse the data
			$lines = explode("\n", $res);
			$keyarray = array();
			if (strcmp ($lines[0], "SUCCESS") == 0) 
			{
				for ($i=1; $i<count($lines);$i++)
				{
					list($key,$val) = explode("=", $lines[$i]);
					$keyarray[urldecode($key)] = urldecode($val);
				}
				// check the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your Primary PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment
				$firstname = $keyarray['first_name'];
				$lastname = $keyarray['last_name'];
				$itemname = $keyarray['item_name'];
				$amount = $keyarray['payment_gross'];
				$email = $keyarray['payer_email'];
				
				$item_number = $keyarray['item_number'];
				
				if (empty($amount)) {$amount = $keyarray['mc_gross'];}
				if (empty($amount)) {$amount = $input['amt'];}
				//echo ("<p><h3>Thank you for your purchase!</h3></p>");
				
				//echo ("<b>Payment Details</b><br>\n");
				//echo ("<li>Name: $firstname $lastname</li>\n");
				//echo ("<li>Item: $itemname</li>\n");
				//echo ("<li>Amount: $amount</li>\n");
				//echo ("<li>item_number: $item_number</li>\n");
				//echo ("");
				$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
				$resultIN['OrderID'] = $item_number;
				$resultIN['OrderAmount'] = $amount;
				$resultIN['OrderReasonDescription'] = 'PayPal deposit by '.$firstname.' '.$lastname;
				$resultIN['OrderPaymentDetails'] = $email;
				$BillingOrder->doOrderPayment($resultIN);
			}
			else if (strcmp ($lines[0], "FAIL") == 0) 
			{
				// log for manual investigation
				$SERVER->setMessage('BillingServer.doPayment.err.PaymentError');
			}
		}
		
		fclose ($fp);
		
		$retval = $saveResult['xml'];
		return $retval;		
	}
	
	function IPNOriginalCode()
	{
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-synch';
		
		$tx_token = $_GET['tx'];
		$auth_token = "GX_sTf5bW3wxRfFEbgofs88nQxvMQ7nsI8m21rzNESnl_79ccFTWj2aPgQ0";
		$req .= "&tx=$tx_token&at=$auth_token";
		
		// post back to PayPal system to validate
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
		// If possible, securely post back to paypal using HTTPS
		// Your PHP server will need to be SSL enabled
		// $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		
		if (!$fp) {
		// HTTP ERROR
		} else {
		fputs ($fp, $header . $req);
		// read the body data 
		$res = '';
		$headerdone = false;
		while (!feof($fp)) {
		$line = fgets ($fp, 1024);
		if (strcmp($line, "\r\n") == 0) {
		// read the header
		$headerdone = true;
		}
		else if ($headerdone)
		{
		// header has been read. now read the contents
		$res .= $line;
		}
		}
		
		// parse the data
		$lines = explode("\n", $res);
		$keyarray = array();
		if (strcmp ($lines[0], "SUCCESS") == 0) {
		for ($i=1; $i<count($lines);$i++){
		list($key,$val) = explode("=", $lines[$i]);
		$keyarray[urldecode($key)] = urldecode($val);
		}
		// check the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your Primary PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment
		$firstname = $keyarray['first_name'];
		$lastname = $keyarray['last_name'];
		$itemname = $keyarray['item_name'];
		$amount = $keyarray['payment_gross'];
		
		echo ("<p><h3>Thank you for your purchase!</h3></p>");
		
		echo ("<b>Payment Details</b><br>\n");
		echo ("<li>Name: $firstname $lastname</li>\n");
		echo ("<li>Item: $itemname</li>\n");
		echo ("<li>Amount: $amount</li>\n");
		echo ("");
		}
		else if (strcmp ($lines[0], "FAIL") == 0) {
		// log for manual investigation
		}
		
		}
		
		fclose ($fp);
	}
	
} // end of UserSession

?>