<?php
class PayBox
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
	function PayBox()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$PaymentMethodSetting = new PaymentMethodSettingClass();
		$this->_settings = $PaymentMethodSetting->getPaymentMethodSettingsFormated('PayBox');
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
		$siteID = $setting['SiteID'];
		$rang = $setting['Rang'];
		$identifier = $setting['Identifier'];
		$currency = $setting['CurrencyCode'];
		$clientEmail = $user['Email'];
		
		/*
		<FORM ACTION = ‘/cgi-bin/modulev2.cgi’ METHOD = post>
		<INPUT TYPE = hidden NAME = PBX_MODE VALUE = ‘1’>
		<INPUT TYPE = hidden NAME = PBX_SITE VALUE = ‘1999888’>
		<INPUT TYPE = hidden NAME = PBX_RANG VALUE = ‘99’>
		<INPUT TYPE = hidden NAME = PBX_IDENTIFIANT VALUE = ‘2’>
		<INPUT TYPE = hidden NAME = PBX_TOTAL VALUE = ‘1500’>
		<INPUT TYPE = hidden NAME = PBX_DEVISE VALUE = ‘978’>
		<INPUT TYPE = hidden NAME = PBX_CMD VALUE = ‘ma_reference_123456’>
		<INPUT TYPE = hidden NAME = PBX_PORTEUR VALUE = ‘client@test.com’>
		<INPUT TYPE = hidden NAME = PBX_RETOUR VALUE = ‘montant:M;ref:R;auto:A;trans:T’>
		<INPUT TYPE = hidden NAME = PBX_EFFECTUE VALUE = ‘http://www.commerce.fr/merci.html’>
		<INPUT TYPE = hidden NAME = PBX_REFUSE VALUE = ‘http://www.commerce.fr/regret.html’>
		<INPUT TYPE = hidden NAME = PBX_ANNULE VALUE = ‘http://www.commerce.fr/regret.html’>
		<INPUT TYPE = submit NAME = bouton_paiement VALUE = ‘paiement’>
		</FORM>		
		*/
		
		$orderAmount= round($input['BillingOrder'.DTR.'OrderAmount'],2);
		$orderAmount = $orderAmount*100;
		$orderID= $input['BillingOrder'.DTR.'BillingOrderID'];

		$paymentSID = 'payment';
		//$paymentSID = 'paymentResult';
		$returnURLOK = $config['url'].$paymentSID.'/paymentMethod/PayBox/OrderID/'.$orderID.'/paymentResult/ok/';
		$returnURLNotOK = $config['url'].$paymentSID.'/paymentMethod/PayBox/OrderID/'.$orderID.'/paymentResult/notok/';
		$returnURLCanceled = $config['url'].$paymentSID.'/paymentMethod/PayBox/OrderID/'.$orderID.'/paymentResult/canceled/';
		$actionURL = '/cgi-bin/modulev2_debian.cgi';

		if($testMode=='Y')
		{
			$testMode = "&test_ipn=1&rm=2&return=".$returnURL;
		}
		else
		{
			$testMode = "&return=".$returnURL;
		}
		$req = 'PBX_MODE=1&PBX_SITE='.$siteID.'&PBX_RANG='.$rang.'&PBX_IDENTIFIANT='.$identifier.'&PBX_TOTAL='.$orderAmount.'&PBX_DEVISE='.$currency.'&PBX_CMD='.$orderID.'&PBX_PORTEUR='.$clientEmail.'&PBX_RETOUR=OrderAmount:M;OrderID:R;auto:A;trans:T&PBX_EFFECTUE='.$returnURLOK.'&PBX_REFUSE='.$returnURLNotOK.'&PBX_ANNULE='.$returnURLCanceled;;
		$url =$actionURL.'?'.$req;
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
			$resultIN['OrderReasonDescription'] = 'PayBox deposit by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'PayBoxPaid';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN);												
		}
		elseif($paymentResult=='notok')
		{
			$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
			$resultIN['OrderID'] = $orderID;
			$resultIN['OrderAmount'] = $orderAmount;
			$resultIN['OrderReasonDescription'] = 'Cancelled PayBox deposit by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'PayBoxErrorPayment';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN,'cancelled');												
		}
		else
		{
			$BillingOrder = new BillingOrderServer(&$SERVER,&$DS);	
			$resultIN['OrderID'] = $orderID;
			$resultIN['OrderAmount'] = $orderAmount;
			$resultIN['OrderReasonDescription'] = 'Cancelled PayBox deposit by '.$userName;
			$resultIN['OrderPaymentDetails'] = 'PayBoxCancelled';
			$resultIN['redirectionMode'] = 'redirect';
			$BillingOrder->doOrderPayment($resultIN,'cancelled');												
		}

		return $retval;		
	}
	
	
	function getPaymentResult ($input)
	{
		
	}
	
		
} // end of UserSession

?>