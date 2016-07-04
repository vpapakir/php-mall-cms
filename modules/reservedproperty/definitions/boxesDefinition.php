<?
	//boxes defintion

	$boxesDefinition['reservedProperty.viewReservedPropertyResource'] = array(
	'name'=>'View reservedProperty resource (popup)',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyResource',
	'template'=>'viewReservedPropertyResource');
		
	//======================================== admin area boxes ==================================
	$boxesDefinition['reservedProperty.manageReservedProperties'] = array(
	'name'=>'Manage reservedProperties',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperties',
	'template'=>'manageReservedProperties');

	$boxesDefinition['reservedProperty.manageLastReservedProperties'] = array(
	'name'=>'Admin last reservedProperties',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperties',
	'template'=>'manageReservedProperties',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['reservedProperty.manageReservedProperty'] = array(
	'name'=>'Manage reservedProperty',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperty',
	'template'=>'manageReservedProperty');		
	
	$boxesDefinition['reservedProperty.viewReservedProperty'] = array(
	'name'=>'View reservedProperty',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperty',
	'template'=>'viewReservedProperty');
	
	$boxesDefinition['reservedProperty.manageReservedPropertyTypes'] = array(
	'name'=>'Manage reservedProperty types',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyTypes',
	'template'=>'manageReservedPropertyTypes');

	$boxesDefinition['reservedProperty.manageReservedPropertyFields'] = array(
	'name'=>'Manage reservedProperty fields',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyFields',
	'template'=>'manageReservedPropertyFields');	
			
	$boxesDefinition['reservedProperty.manageReservedPropertyComments'] = array(
	'name'=>'Manage comments',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyComments',
	'template'=>'manageReservedPropertyComments');	
	
	$boxesDefinition['reservedProperty.manageReservedPropertyComment'] = array(
	'name'=>'Manage comment',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyComments',
	'template'=>'manageReservedPropertyComment');
	
	$boxesDefinition['reservedProperty.manageLastComments'] = array(
	'name'=>'New comments for admin home',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyComments',
	'template'=>'manageLastComments',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['reservedProperty.manageOrders'] = array(
	'name'=>'Manage orders by admin',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'manageReservedPropertyOrders');		

	$boxesDefinition['reservedProperty.manageLastOrders'] = array(
	'name'=>'Last orders for admin home',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'manageLastReservedPropertyOrders',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['reservedProperty.manageOrder'] = array(
	'name'=>'Manage order',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'manageReservedPropertyOrder');
	
	$boxesDefinition['reservedProperty.lastOrders'] = array(
	'name'=>'New orders',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'manageLastOrder',
	'arguments'=>'filterMode/last');

	$boxesDefinition['reservedProperty.manageReservedPropertyRelations'] = array(
	'name'=>'Manage related reservedProperties',
	'type'=>'admin',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyRelations',
	'template'=>'manageReservedPropertyRelations');	
		
	//=================================== fron end boxes =======================================
									
	$boxesDefinition['reservedProperty.viewReservedPropertyInfo'] = array(
	'name'=>'View reservedProperty full info',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedProperty',
	'template'=>'viewInfo');
	
	$boxesDefinition['reservedProperty.getReservedProperties'] = array(
	'name'=>'ReservedProperties list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedProperties',
	'template'=>'viewReservedProperties');
	
	$boxesDefinition['reservedProperty.getReservedPropertiesFeatured'] = array(
	'name'=>'ReservedProperties featured list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedProperties',
	'template'=>'viewReservedProperties',
	'arguments'=>'ReservedPropertyFeaturedOption/home');	
	
	$boxesDefinition['reservedProperty.getReservedProperty'] = array(
	'name'=>'ReservedProperty info',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedProperty',
	'template'=>'viewReservedProperty');	
	
	$boxesDefinition['reservedProperty.getReservedPropertySEOInfo'] = array(
	'name'=>'ReservedProperty SEO info',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertySEOInfo',
	'template'=>'getReservedPropertySEOInfo');		
	
	$boxesDefinition['reservedProperty.getLastComments'] = array(
	'name'=>'Last comments list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyComments',
	'template'=>'viewLastComments',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['reservedProperty.getComments'] = array(
	'name'=>'Comments list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyComments',
	'template'=>'viewComments');
	
	$boxesDefinition['reservedProperty.getUserComments'] = array(
	'name'=>'User Comments list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyComments',
	'template'=>'viewUserComments');
	
	$boxesDefinition['reservedProperty.editComments'] = array(
	'name'=>'Edit user comments',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyComments',
	'template'=>'editReservedPropertyComments');	
	
	$boxesDefinition['reservedProperty.editComment'] = array(
	'name'=>'Add/Edit comment',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyComments',
	'template'=>'editReservedPropertyComment');	

	$boxesDefinition['reservedProperty.getReviews'] = array(
	'name'=>'Reviews list',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyComments',
	'template'=>'manageReservedPropertyReviews');			
		
	$boxesDefinition['reservedProperty.shoppingCart'] = array(
	'name'=>'ReservedProperty shopping cart',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageCartItemsReservedProperty',
	'template'=>'shoppingCart');
	
	$boxesDefinition['reservedProperty.requestCart'] = array(
	'name'=>'ReservedProperty request cart',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageCartItems',
	'template'=>'requestCart');	
	
	$boxesDefinition['reservedProperty.addOrder'] = array(
	'name'=>'Checkout (add order)',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'addReservedPropertyOrder',
	'template'=>'order');
	
	$boxesDefinition['reservedProperty.editUserOrders'] = array(
	'name'=>'Manage user orders',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'viewReservedPropertyOrders');

	$boxesDefinition['reservedProperty.editLastUserOrders'] = array(
	'name'=>'Last orders for user home',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedPropertyOrders',
	'template'=>'viewLastReservedPropertyOrders',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['reservedProperty.viewOrder'] = array(
	'name'=>'View Order',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyOrder',
	'template'=>'viewReservedPropertyOrder');
		
	$boxesDefinition['reservedProperty.payment'] = array(
	'name'=>'Payment system request',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'doPayment',
	'template'=>'doPayment');	

	$boxesDefinition['reservedProperty.editReservedProperties'] = array(
	'name'=>'Edit reservedProperties',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperties',
	'template'=>'editReservedProperties',
	'arguments'=>'manageMode/user');
	
	$boxesDefinition['reservedProperty.getLastUserReservedProperties'] = array(
	'name'=>'Get last user reservedProperties',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperties',
	'template'=>'lastUserReservedProperties',
	'arguments'=>'manageMode/user/filterMode/last');	
	
	$boxesDefinition['reservedProperty.editReservedProperty'] = array(
	'name'=>'Edit reservedProperty',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'manageReservedProperty',
	'template'=>'editReservedProperty');	
	
	$boxesDefinition['reservedProperty.addReservedProperty'] = array(
	'name'=>'Add/Edit reservedProperty',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'addReservedProperty',
	'template'=>'addReservedProperty');
					
	$boxesDefinition['reservedProperty.searchReservedProperties'] = array(
	'name'=>'Search reservedProperties',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'searchReservedProperties',
	'template'=>'searchReservedProperties');	
	
	$boxesDefinition['reservedProperty.getReservedPropertyRelations'] = array(
	'name'=>'View related reservedProperties',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyRelations',
	'template'=>'viewRelatedReservedProperties');	

	$boxesDefinition['reservedProperty.getReservedPropertyRelation'] = array(
	'name'=>'View related reservedProperty',
	'type'=>'front',
	'module'=>'reservedproperty',
	'method'=>'getReservedPropertyRelation',
	'template'=>'viewRelatedReservedProperty');		
	
	//=================================== page listing boxes =======================================

	$boxesDefinition['reservedProperty.getReservedPropertiesOnPage'] = array(
	'name'=>'Show reservedProperties',
	'type'=>'page',
	'module'=>'reservedproperty',
	'method'=>'getReservedProperties',
	'template'=>'viewReservedProperties');
	
	
?>