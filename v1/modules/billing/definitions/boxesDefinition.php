<?
	//boxes defintion
	//=================================== admin boxes =======================================
	
	$boxesDefinition['billing.manageBillingOrders'] = array(
	'name'=>'Manage Billing Orders',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'manageOrders',
	'template'=>'manageBillingOrders');
	
	$boxesDefinition['billing.managePayments'] = array(
	'name'=>'Manage payment types',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'managePayments',
	'template'=>'managePaymentMethodSettings');		
	
	$boxesDefinition['billing.managePaymentsSettings'] = array(
	'name'=>'Manage payment setting',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'managePaymentMethodSettings',
	'template'=>'managePaymentMethodSetting');
	
	$boxesDefinition['billing.manageService'] = array(
	'name'=>'Manage Service',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'manageServices',
	'template'=>'manageService');		
	
	$boxesDefinition['billing.manageServices'] = array(
	'name'=>'Manage Services',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'manageServices',
	'template'=>'manageServices');
	
	$boxesDefinition['billing.manageServiceCategories'] = array(
	'name'=>'Manage Service Categories',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'manageServiceCategories',
	'template'=>'manageCategories');		
	
	$boxesDefinition['billing.manageServiceCategory'] = array(
	'name'=>'Manage Service Category',
	'type'=>'admin',
	'module'=>'billing',
	'method'=>'manageServiceCategories',
	'template'=>'manageCategory');
	
	//=================================== fron end boxes =======================================
	$boxesDefinition['billing.doBillingPayment'] = array(
	'name'=>'Billing payment processing',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'doBillingPayment',
	'template'=>'');	
	
	$boxesDefinition['billing.getBillingPaymentForm'] = array(
	'name'=>'Billing payment form',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'getBillingPaymentForm',
	'template'=>'paymentForm');

	$boxesDefinition['billing.getBillingPaymentStatus'] = array(
	'name'=>'Billing order status',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'getBillingPaymentStatus',
	'template'=>'paymentStatus');		
	
	$boxesDefinition['billing.doPaymentRequest'] = array(
	'name'=>'Payment gateway request',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'doPaymentRequest',
	'template'=>'paymentForm');	
	
	$boxesDefinition['billing.doPayment'] = array(
	'name'=>'Payment processing',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'doPayment',
	'template'=>'paymentResult');		
	
	$boxesDefinition['billing.getPaymentResult'] = array(
	'name'=>'Payment result page',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'getPaymentResult',
	'template'=>'paymentResult');		

	$boxesDefinition['billing.getBalance'] = array(
	'name'=>'Get balance',
	'type'=>'front',
	'module'=>'billing',
	'method'=>'getBalance',
	'template'=>'');		
	
			
?>