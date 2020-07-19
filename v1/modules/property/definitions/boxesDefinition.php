<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['property.manageProperties'] = array(
	'name'=>'Manage properties',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'manageProperties',
	'template'=>'manageProperties');

	$boxesDefinition['property.manageLastProperties'] = array(
	'name'=>'Admin last properties',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'manageProperties',
	'template'=>'manageProperties',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['property.manageProperty'] = array(
	'name'=>'Manage property',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'manageProperty',
	'template'=>'manageProperty');		
	
	$boxesDefinition['property.viewProperty'] = array(
	'name'=>'View property',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'manageProperty',
	'template'=>'viewProperty');
	
	$boxesDefinition['property.managePropertyTypes'] = array(
	'name'=>'Manage property types',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyTypes',
	'template'=>'managePropertyTypes');

	$boxesDefinition['property.managePropertyFields'] = array(
	'name'=>'Manage property fields',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyFields',
	'template'=>'managePropertyFields');	
			
	$boxesDefinition['property.managePropertyComments'] = array(
	'name'=>'Manage comments',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyComments',
	'template'=>'managePropertyComments');	
	
	$boxesDefinition['property.managePropertyComment'] = array(
	'name'=>'Manage comment',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyComments',
	'template'=>'managePropertyComment');
	
	$boxesDefinition['property.manageLastComments'] = array(
	'name'=>'New comments for admin home',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'getPropertyComments',
	'template'=>'manageLastComments',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['property.manageOrders'] = array(
	'name'=>'Manage orders by admin',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'managePropertyOrders');		

	$boxesDefinition['property.manageLastOrders'] = array(
	'name'=>'Last orders for admin home',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'manageLastPropertyOrders',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['property.manageOrder'] = array(
	'name'=>'Manage order',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'managePropertyOrder');
	
	$boxesDefinition['property.lastOrders'] = array(
	'name'=>'New orders',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'manageLastOrder',
	'arguments'=>'filterMode/last');

	$boxesDefinition['property.managePropertyRelations'] = array(
	'name'=>'Manage related properties',
	'type'=>'admin',
	'module'=>'property',
	'method'=>'managePropertyRelations',
	'template'=>'managePropertyRelations');	
		
	//=================================== fron end boxes =======================================
									
	$boxesDefinition['property.viewPropertyInfo'] = array(
	'name'=>'View property full info',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getProperty',
	'template'=>'viewInfo');
	
	$boxesDefinition['property.getProperties'] = array(
	'name'=>'Properties list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getProperties',
	'template'=>'viewProperties');
	
	$boxesDefinition['property.getPropertiesFeatured'] = array(
	'name'=>'Properties featured list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getProperties',
	'template'=>'viewProperties',
	'arguments'=>'PropertyFeaturedOption/home');	
	
	$boxesDefinition['property.getProperty'] = array(
	'name'=>'Property info',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getProperty',
	'template'=>'viewProperty');	
	
	$boxesDefinition['property.getPropertySEOInfo'] = array(
	'name'=>'Property SEO info',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertySEOInfo',
	'template'=>'getPropertySEOInfo');		
	
	$boxesDefinition['property.getLastComments'] = array(
	'name'=>'Last comments list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyComments',
	'template'=>'viewLastComments',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['property.getComments'] = array(
	'name'=>'Comments list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyComments',
	'template'=>'viewComments');
	
	$boxesDefinition['property.getUserComments'] = array(
	'name'=>'User Comments list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyComments',
	'template'=>'viewUserComments');
	
	$boxesDefinition['property.editComments'] = array(
	'name'=>'Edit user comments',
	'type'=>'front',
	'module'=>'property',
	'method'=>'managePropertyComments',
	'template'=>'editPropertyComments');	
	
	$boxesDefinition['property.editComment'] = array(
	'name'=>'Add/Edit comment',
	'type'=>'front',
	'module'=>'property',
	'method'=>'managePropertyComments',
	'template'=>'editPropertyComment');	

	$boxesDefinition['property.getReviews'] = array(
	'name'=>'Reviews list',
	'type'=>'front',
	'module'=>'property',
	'method'=>'managePropertyComments',
	'template'=>'managePropertyReviews');			
		
	$boxesDefinition['property.shoppingCart'] = array(
	'name'=>'Property shopping cart',
	'type'=>'front',
	'module'=>'property',
	'method'=>'manageCartItemsProperty',
	'template'=>'shoppingCart');
	
	$boxesDefinition['property.requestCart'] = array(
	'name'=>'Property request cart',
	'type'=>'front',
	'module'=>'property',
	'method'=>'manageCartItems',
	'template'=>'requestCart');	
	
	$boxesDefinition['property.addOrder'] = array(
	'name'=>'Checkout (add order)',
	'type'=>'front',
	'module'=>'property',
	'method'=>'addPropertyOrder',
	'template'=>'order');
	
	$boxesDefinition['property.editUserOrders'] = array(
	'name'=>'Manage user orders',
	'type'=>'front',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'viewPropertyOrders');

	$boxesDefinition['property.editLastUserOrders'] = array(
	'name'=>'Last orders for user home',
	'type'=>'front',
	'module'=>'property',
	'method'=>'managePropertyOrders',
	'template'=>'viewLastPropertyOrders',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['property.viewOrder'] = array(
	'name'=>'View Order',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyOrder',
	'template'=>'viewPropertyOrder');
		
	$boxesDefinition['property.payment'] = array(
	'name'=>'Payment system request',
	'type'=>'front',
	'module'=>'property',
	'method'=>'doPayment',
	'template'=>'doPayment');	

	$boxesDefinition['property.editProperties'] = array(
	'name'=>'Edit properties',
	'type'=>'front',
	'module'=>'property',
	'method'=>'manageProperties',
	'template'=>'editProperties',
	'arguments'=>'manageMode/user');
	
	$boxesDefinition['property.getLastUserProperties'] = array(
	'name'=>'Get last user properties',
	'type'=>'front',
	'module'=>'property',
	'method'=>'manageProperties',
	'template'=>'lastUserProperties',
	'arguments'=>'manageMode/user/filterMode/last');	
	
	$boxesDefinition['property.editProperty'] = array(
	'name'=>'Edit property',
	'type'=>'front',
	'module'=>'property',
	'method'=>'manageProperty',
	'template'=>'editProperty');	
	
	$boxesDefinition['property.addProperty'] = array(
	'name'=>'Add/Edit property',
	'type'=>'front',
	'module'=>'property',
	'method'=>'addProperty',
	'template'=>'addProperty');
					
	$boxesDefinition['property.searchProperties'] = array(
	'name'=>'Search properties',
	'type'=>'front',
	'module'=>'property',
	'method'=>'searchProperties',
	'template'=>'searchProperties');	
	
	$boxesDefinition['property.getPropertyRelations'] = array(
	'name'=>'View related properties',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyRelations',
	'template'=>'viewRelatedProperties');	

	$boxesDefinition['property.getPropertyRelation'] = array(
	'name'=>'View related property',
	'type'=>'front',
	'module'=>'property',
	'method'=>'getPropertyRelation',
	'template'=>'viewRelatedProperty');		
	
	//=================================== page listing boxes =======================================

	$boxesDefinition['property.getPropertiesOnPage'] = array(
	'name'=>'Show properties',
	'type'=>'page',
	'module'=>'property',
	'method'=>'getProperties',
	'template'=>'viewProperties');
	
	
?>