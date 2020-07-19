<?php
class SecurePay
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
	function SecurePay()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$PaymentMethodSetting = new PaymentMethodSettingClass();
		$this->_settings = $PaymentMethodSetting->getPaymentMethodSettingsFormated('SecurePay');
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
		$merchantID = $setting['MerchantID'];
		$merchantPassword = $setting['MerchantPassword'];
		
		$currency = $setting['CurrencyCode'];
		$clientEmail = $user['Email'];


		$amount = '45';
		$amountPeriodic = 15;
		
		$orderID = $input['BillingOrder'.DTR.'BillingOrderID'];
		//$orderID = $user['UserName'];
		//$clientID = $orderID;
		$userID = $user['UserID'];
		//$clientID = substr($userID,11);
		$clientID = $orderID;
		$messageID = $orderID;
		$messageTimestamp = date('YdmHis').'111000+600';
		if($testMode=='Y')
		{
			//$messageID  = '8af793f9af34bea0ecd7eff71c94d6';
			//$cardNumber = '4242424242424242';
			$cardNumber = $input['cardNumber'];
			//$cvv = '123';
			$cvv = $input['cvv'];
			$expiryDate = $input['expiryDate'];
			if(empty($expiryDate))
			{
				$expiryDate = $input['expiryMonth'].'/'.$input['expiryYear'];
			}		
			//$expiryDate = '09/08';
			$apiLink = "/test/periodic";
		}
		else
		{
			$cardNumber = $input['cardNumber'];
			$cvv = $input['cvv'];
			$expiryDate = $input['expiryDate'];
			if(empty($expiryDate))
			{
				$expiryDate = $input['expiryMonth'].'/'.$input['expiryYear'];
			}			
			$apiLink = "/xmlapi/periodic";
		}
		
		$firstPaymentDay = date('Ymd'); 
		$PeriodicStamp = time() + 60*60*24*90;
		$periodicPaymentDay = date('Ymd',$PeriodicStamp);
		
		//first 3 months payment
		$clientFirstID = $clientID.'1';
		$request = '
			<SecurePayMessage>
				<MessageInfo>
					<messageID>'.$messageID.'</messageID>
					<messageTimestamp>'.$messageTimestamp.'</messageTimestamp>
					<timeoutValue>60</timeoutValue>
					<apiVersion>spxml-3.0</apiVersion>
				</MessageInfo>
				<MerchantInfo>
					<merchantID>'.$merchantID.'</merchantID>
					<password>'.$merchantPassword.'</password>
				</MerchantInfo>
				<RequestType>Periodic</RequestType>
				<Periodic>
					<PeriodicList count="1">
						<PeriodicItem ID="1">
							<actionType>add</actionType>
							<clientID>'.$clientFirstID.'</clientID>
							<CreditCardInfo>
								<cardNumber>'.$cardNumber.'</cardNumber>
								<cvv>'.$cvv.'</cvv>
								<expiryDate>'.$expiryDate.'</expiryDate>
							</CreditCardInfo>
							<amount>'.$amountPeriodic.'</amount>
							<periodicType>1</periodicType>
							<startDate>'.$firstPaymentDay.'</startDate>
						</PeriodicItem>
					</PeriodicList>
				</Periodic>
			</SecurePayMessage>		
		';
		$ret = $this->PostToSecurePay("www.securepay.com.au",$apiLink,80, $request);
		//periodic payment
		$request = '
			<SecurePayMessage>
				<MessageInfo>
					<messageID>'.$messageID.'</messageID>
					<messageTimestamp>'.$messageTimestamp.'</messageTimestamp>
					<timeoutValue>60</timeoutValue>
					<apiVersion>spxml-3.0</apiVersion>
				</MessageInfo>
				<MerchantInfo>
					<merchantID>'.$merchantID.'</merchantID>
					<password>'.$merchantPassword.'</password>
				</MerchantInfo>
				<RequestType>Periodic</RequestType>
				<Periodic>
					<PeriodicList count="1">
						<PeriodicItem ID="1">
							<actionType>add</actionType>
							<clientID>'.$clientID.'</clientID>
							<CreditCardInfo>
								<cardNumber>'.$cardNumber.'</cardNumber>
								<cvv>'.$cvv.'</cvv>
								<expiryDate>'.$expiryDate.'</expiryDate>
							</CreditCardInfo>
							<amount>'.$amountPeriodic.'</amount>
							<periodicType>3</periodicType>
							<paymentInterval>1</paymentInterval>
							<startDate>'.$periodicPaymentDay.'</startDate>
							<numberOfPayments>1000</numberOfPayments>
						</PeriodicItem>
					</PeriodicList>
				</Periodic>
			</SecurePayMessage>		
		';		
		
		$ret = $this->PostToSecurePay("www.securepay.com.au",$apiLink,80, $request);
		//echo "<textarea>$request</textarea><hr>";
		$paymentResult = $SERVER->XML2ARRAY($ret);
		//print_r($paymentResult);
		$statusResultCode = $paymentResult['SecurePayMessage']['#']['Status'][0]['#']['statusCode'][0]['#'];
		$statusResultDescription = $paymentResult['SecurePayMessage']['#']['Status'][0]['#']['statusDescription'][0]['#'];

		$itemResultCode = $paymentResult['SecurePayMessage']['#']['Periodic'][0]['#']['PeriodicList'][0]['#']['PeriodicItem'][0]['#']['responseCode'][0]['#'];
		$itemResultDescription = $paymentResult['SecurePayMessage']['#']['Periodic'][0]['#']['PeriodicList'][0]['#']['PeriodicItem'][0]['#']['responseText'][0]['#'];
		$itemResultIsOK = $paymentResult['SecurePayMessage']['#']['Periodic'][0]['#']['PeriodicList'][0]['#']['PeriodicItem'][0]['#']['successful'][0]['#'];

		//echo '$itemResultCode='.$itemResultCode.'<br>';
		//echo '$itemResultDescription='.$itemResultDescription.'<br>';
		//echo '$itemResultIsOK='.$itemResultIsOK.'<br>';

		//die('ttttt='.$input['NumberOfMonths']);	

		if(!empty($orderID))
		{
			$checkRS = $DS->query("SELECT BillingOrderID FROM BillingOrder WHERE BillingOrderID='$orderID' AND OrderPaymentStatus='notpaid'");
			if(!empty($checkRS[0]['BillingOrderID']))
			{
				if($itemResultIsOK=='yes')
				{
					$result['paymentResult']='ok';
					$result['OrderID']=$orderID;
				}	
				else
				{
					$result['paymentResult']='notok';
					$result['OrderID']=$orderID;
				}	
			}
		}
		$result['OrderAmount']=$amount;
		$this->doPayment($result);
	}
	
	function doPayment($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config = $SERVER->getConfig();
		global $_POST;

		$setting = $this->_settings;

		$testMode = $setting['TestMode'];
		$testMod = 'N';
		$orderID = $input['OrderID'];
		$paymentResult = $input['paymentResult'];
		$orderAmount = $input['OrderAmount'];
		$userName = $user['UserName'];

		if($paymentResult=='ok')
		{
			$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
			$resultIN['OrderID'] = $orderID;
			$resultIN['OrderAmount'] = $orderAmount;
			$resultIN['OrderReasonDescription'] = 'SecurePay deposit by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'SecurePayPaid';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN);												
		}
		else
		{
			$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
			$resultIN['OrderID'] = $orderID;
			$resultIN['OrderAmount'] = $orderAmount;
			$resultIN['OrderReasonDescription'] = 'Cancelled SecurePay deposit by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'SecurePayErrorPayment';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN,'cancelled');												
		}
print_r($resultIN);
		return $retval;		
	}
	
	
	function getPaymentResult ($input)
	{
		
	}
	
	function PostToSecurePay($host, $path, $port, $data_to_send)
	{
		$data_to_send = '<'.'?xml version="1.0" encoding="UTF-8"'.'?>'.$data_to_send;
		$ret = "";
		$fp = fsockopen($host,$port,$errno,$errstr,30);
		if($fp)
		{
			fputs($fp, "POST $path HTTP/1.0\n"); 
			fputs($fp, "Host: $host\n"); // write the hostname line of the header
			fputs($fp, "Content-type: application/x-www-form-urlencoded\n");		
			fputs($fp, "Content-length: " . strlen($data_to_send) . "\n"); // write the content-length of data to send
			fputs($fp, "Connection: close\n\n");
			fputs($fp, $data_to_send);
			while(!feof($fp))  
			{
				$ret .= fgets($fp, 128); 
			}
			fclose($fp); // close the "file"
			preg_match ("/<SecurePayMessage>(.*)<\/SecurePayMessage>/i", $ret, $resultValue);
			$ret = '<SecurePayMessage>'.$resultValue[1].'</SecurePayMessage>';
		}
		else
		{
			$ret = "Bad Connection ".$errno." [".$errstr."]";
		}
		return $ret;
	}	
		
} // end of UserSession

?>