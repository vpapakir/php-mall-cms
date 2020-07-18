<?php
class Bank
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
	function Bank()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$PaymentMethodSetting = new PaymentMethodSettingClass();
		$this->_settings = $PaymentMethodSetting->getPaymentMethodSettingsFormated('Bank');
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

		$orderID = $input['BillingOrder'.DTR.'BillingOrderID'];
		$userID = $user['UserID'];
		
		$result['OrderID'] = $orderID;
		$result['paymentResult']='ok';
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
			$resultIN['OrderReasonDescription'] = 'Bank payment request by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'BankPayment';
			$resultIN['OrderPaymentStatus'] = 'waiting';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN);												
		}

		return $retval;		
	}
	
	function getPaymentResult ($input)
	{
		
	}
		
} // end of UserSession

?>