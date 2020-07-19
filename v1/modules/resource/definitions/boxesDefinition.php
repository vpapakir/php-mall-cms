<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['resource.manageResources'] = array(
	'name'=>'Manage resources',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResources',
	'template'=>'manageResources');
	
	$boxesDefinition['resource.GSM'] = array(
	'name'=>'Google Site Map',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageGSM',
	'template'=>'googleSiteMap');

	$boxesDefinition['resource.manageLastResources'] = array(
	'name'=>'Admin last resources',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResources',
	'template'=>'manageResources',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['resource.manageResource'] = array(
	'name'=>'Manage resource',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResource',
	'template'=>'manageResource');		

	$boxesDefinition['resource.manageResourceCategories'] = array(
	'name'=>'Manage resource categories',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceCategories',
	'template'=>'manageCategories',
	'arguments'=>'treeType/expanded');	
	
	$boxesDefinition['resource.manageResourceCategory'] = array(
	'name'=>'Manage resource category',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceCategories',
	'template'=>'manageCategory');		

	$boxesDefinition['resource.manageResourceTypes'] = array(
	'name'=>'Manage resource types',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceTypes',
	'template'=>'manageResourceTypes');

	$boxesDefinition['resource.manageCurrencies'] = array(
	'name'=>'Manage currencies',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageCurrencies',
	'template'=>'manageCurrency');		
	
	$boxesDefinition['resource.manageShippingRates'] = array(
	'name'=>'Manage shipping rates',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageShippingRates',
	'template'=>'manageShippingRates');		

	$boxesDefinition['resource.manageResourceLinks'] = array(
	'name'=>'Manage links',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceLinks',
	'template'=>'manageResourceLinks');
	
	$boxesDefinition['resource.manageResourceLink'] = array(
	'name'=>'Manage link',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceLinks',
	'template'=>'manageResourceLink');			
	
	$boxesDefinition['resource.manageResourceComments'] = array(
	'name'=>'Manage comments',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceComments',
	'template'=>'manageResourceComments');	
	
	$boxesDefinition['resource.manageResourceComment'] = array(
	'name'=>'Manage comment',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceComments',
	'template'=>'manageResourceComment');
	
	$boxesDefinition['resource.manageLastComments'] = array(
	'name'=>'New comments for admin home',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'getResourceComments',
	'template'=>'manageLastComments',
	'arguments'=>'filterMode/last');
	
	$boxesDefinition['resource.manageLastLinks'] = array(
	'name'=>'New links for admin home',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'getResourceLinks',
	'template'=>'manageLastLinks',
	'arguments'=>'filterMode/last');
	
	$boxesDefinition['resource.manageOrders'] = array(
	'name'=>'Manage orders by admin',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'manageResourceOrders');		

	$boxesDefinition['resource.manageLastOrders'] = array(
	'name'=>'Last orders for admin home',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'manageLastResourceOrders',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['resource.checkoutEdit'] = array(
	'name'=>'Checkout',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'getResourceOrder',
	'template'=>'order');
	
	$boxesDefinition['resource.checkoutlastAdmin'] = array(
	'name'=>'New orders',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'manageLastOrder',
	'arguments'=>'filterMode/last');

	$boxesDefinition['resource.updateAllResourceCategoryStats'] = array(
	'name'=>'Update resources categories stats',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'updateAllResourceCategoryStats',
	'template'=>'updateAllResourceCategoryStats');	

	$boxesDefinition['resource.manageResourceRelations'] = array(
	'name'=>'Manage related resources',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'manageResourceRelations',
	'template'=>'manageResourceRelations');	

	$boxesDefinition['resource.viewAdminOrder'] = array(
	'name'=>'View Admin Order',
	'type'=>'admin',
	'module'=>'resource',
	'method'=>'getResourceOrder',
	'template'=>'viewResourceOrder');
	
	//================================ admin front boxes ====================================

	$boxesDefinition['resource.manageResourcesFront'] = array(
	'name'=>'Admin Front Manage resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResources',
	'template'=>'admin/manageResources');
	
	$boxesDefinition['resource.manageResourceFront'] = array(
	'name'=>'Admin Front Manage resource',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResource',
	'template'=>'admin/manageResource');		

	$boxesDefinition['resource.manageOrdersFront'] = array(
	'name'=>'Admin Front Manage orders',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'admin/manageResourceOrders');
	
	$boxesDefinition['resource.manageOrderFront'] = array(
	'name'=>'Admin Front Manage order',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'admin/manageResourceOrder');		

	$boxesDefinition['resource.manageLastOrders'] = array(
	'name'=>'Admin Front Last orders for admin home',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'admin/manageLastResourceOrders',
	'arguments'=>'filterMode/last');
		
	$boxesDefinition['resource.viewOrderAdminFront'] = array(
	'name'=>'Admin Front view oreder',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceOrder',
	'template'=>'admin/order');
	
	$boxesDefinition['resource.newOrdersAdminFront'] = array(
	'name'=>'New orders',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'admin/manageLastOrder',
	'arguments'=>'filterMode/last');

		
	//=================================== fron end boxes =======================================
	
	$boxesDefinition['resource.getCategoriesDropDwon'] = array(
	'name'=>'Categories drop down (full)',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesDropDown',
	'arguments'=>'treeType/all');
	
	$boxesDefinition['resource.getCategoriesBox'] = array(
	'name'=>'Categories box',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategories',
	'template'=>'viewCategoriesBox');	

	$boxesDefinition['resource.getTopCategoriesBox'] = array(
	'name'=>'Top categories box',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategories',
	'template'=>'viewTopCategoriesBox',
	'arguments'=>'filterMode/top');		
	
	$boxesDefinition['resource.getCategoriesTreeBox'] = array(
	'name'=>'Categories tree box (expanded)',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesTreeBox',
	'arguments'=>'treeType/expanded');	
	
	$boxesDefinition['resource.getCategoriesTreeBoxArrow'] = array(
	'name'=>'Categories tree box (Arrow)',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesTreeBoxArrow',
	'arguments'=>'treeType/all');

	$boxesDefinition['resource.getCategoriesTreeBoxFull'] = array(
	'name'=>'Categories tree box (full)',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesTreeBoxFull',
	'arguments'=>'treeType/all');	

	$boxesDefinition['resource.getCategoriesTreeBoxFullDHTML'] = array(
	'name'=>'Categories tree box (full in DHTML)',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesTreeBoxFullDHTML',
	'arguments'=>'treeType/all');
	
	$boxesDefinition['resource.getCategoriesTreeCenterBox'] = array(
	'name'=>'Categories tree center box',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesTree',
	'template'=>'viewCategoriesTreeCenterBox',
	'arguments'=>'treeType/current');	
	
	$boxesDefinition['resource.getCategoryBox'] = array(
	'name'=>'Category info',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategory',
	'template'=>'viewCategory');
	
	$boxesDefinition['resource.getCategorySEOInfo'] = array(
	'name'=>'Category SEO info',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategorySEOInfo',
	'template'=>'getCategorySEOInfo');		
	
	$boxesDefinition['resource.viewInfo'] = array(
	'name'=>'view Info',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResource',
	'template'=>'viewInfo');
	
	$boxesDefinition['resource.getResources'] = array(
	'name'=>'Resources list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResources',
	'template'=>'viewResources');
	
	$boxesDefinition['resource.getResourcesByTypes'] = array(
	'name'=>'Resources list by types',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesByTypes',
	'template'=>'viewResourcesByTypes');

	$boxesDefinition['resource.getResourcesFeatured'] = array(
	'name'=>'Resources featured list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesFeatured',
	'template'=>'viewResourcesByTypes');	
		

	$boxesDefinition['resource.getResourcesBySelectedType'] = array(
	'name'=>'Resources list for selected type',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesByTypes',
	'template'=>'viewResources');		
	
	$boxesDefinition['resource.getResource'] = array(
	'name'=>'Resource info',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResource',
	'template'=>'viewResource');	
	
	$boxesDefinition['resource.getResourceSEOInfo'] = array(
	'name'=>'Resource SEO info',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceSEOInfo',
	'template'=>'getResourceSEOInfo');		
	
	$boxesDefinition['resource.getLastComments'] = array(
	'name'=>'Last comments list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceComments',
	'template'=>'viewLastComments',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['resource.getComments'] = array(
	'name'=>'Comments list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceComments',
	'template'=>'viewResourceComments');
	
	$boxesDefinition['resource.getUserComments'] = array(
	'name'=>'User Comments list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceComments',
	'template'=>'viewUserComments');
	
	$boxesDefinition['resource.editComments'] = array(
	'name'=>'Edit user comments',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceComments',
	'template'=>'editResourceComments');	
	
	$boxesDefinition['resource.editComment'] = array(
	'name'=>'Add/Edit comment',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceComments',
	'template'=>'editResourceComment');	

	$boxesDefinition['resource.getReviews'] = array(
	'name'=>'Reviews list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceComments',
	'template'=>'manageResourceReviews');			

	$boxesDefinition['resource.getLastLinks'] = array(
	'name'=>'Last links list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceLinks',
	'template'=>'viewLastLinks',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['resource.getLinks'] = array(
	'name'=>'Links list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceLinks',
	'template'=>'viewLinks');	
	
	$boxesDefinition['resource.getUserLinks'] = array(
	'name'=>'Links User list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceLinks',
	'template'=>'viewUserLinks');	

	$boxesDefinition['resource.editLinks'] = array(
	'name'=>'Edit user links',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceLinks',
	'template'=>'editResourceLinks');	
	
	$boxesDefinition['resource.editLink'] = array(
	'name'=>'Add/Edit link',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceLinks',
	'template'=>'editResourceLink');		
	
	$boxesDefinition['resource.shoppingCart'] = array(
	'name'=>'Shopping cart',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageCartItems',
	'template'=>'shoppingCart');
	
	$boxesDefinition['resource.requestCart'] = array(
	'name'=>'Request cart',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageCartItems',
	'template'=>'requestCart');	
	
	$boxesDefinition['resource.checkout'] = array(
	'name'=>'Checkout',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResourceOrder',
	'template'=>'order');
	
	$boxesDefinition['resource.editUserOrders'] = array(
	'name'=>'Manage user orders',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'viewResourceOrders');

	$boxesDefinition['resource.editLastUserOrders'] = array(
	'name'=>'Last orders for user home',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResourceOrders',
	'template'=>'viewLastResourceOrders',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['resource.viewOrder'] = array(
	'name'=>'View Order',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceOrder',
	'template'=>'viewResourceOrder');
	
	$boxesDefinition['resource.bill'] = array(
	'name'=>'Bill',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceOrder',
	'template'=>'bill');	
	
	$boxesDefinition['resource.request'] = array(
	'name'=>'Send request',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResourceOrder',
	'template'=>'request');
	
	$boxesDefinition['resource.request'] = array(
	'name'=>'Add request',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResourceOrder',
	'template'=>'request');
	
	$boxesDefinition['resource.payment'] = array(
	'name'=>'Payment system request',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'doPayment',
	'template'=>'doPayment');	

	$boxesDefinition['resource.editResources'] = array(
	'name'=>'Edit resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResources',
	'template'=>'editResources',
	'arguments'=>'manageMode/user');
	
	$boxesDefinition['resource.getLastUserResources'] = array(
	'name'=>'Get last user resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResources',
	'template'=>'lastUserResources',
	'arguments'=>'manageMode/user/filterMode/last');	
	
	$boxesDefinition['resource.editResource'] = array(
	'name'=>'Edit resource',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'manageResource',
	'template'=>'editResource');	
	
	$boxesDefinition['resource.addResource'] = array(
	'name'=>'Edit resource',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResource',
	'template'=>'addResource');
	
	$boxesDefinition['resource.addResource'] = array(
	'name'=>'Add resource',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResource',
	'template'=>'addResource');	
		
	$boxesDefinition['resource.getUserBids'] = array(
	'name'=>'User bids list',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getUserBids',
	'template'=>'viewUserBids');	

	$boxesDefinition['resource.getResourceBids'] = array(
	'name'=>'Resource bids',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceBids',
	'template'=>'viewResourceBids');		

	$boxesDefinition['resource.addBid'] = array(
	'name'=>'Add bid',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'addResourceBid',
	'template'=>'bid');	
	
	$boxesDefinition['resource.resourceCategoriesPath'] = array(
	'name'=>'Current categories path',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceCategoriesPath',
	'template'=>'viewResourceCategoriesPath');	
	
	$boxesDefinition['resource.getResourceFeaturedType1'] = array(
	'name'=>'Featured resources type 1',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesFeatured',
	'template'=>'viewResourcesFeatured',
	'arguments'=>'featuredMode/type1');

	$boxesDefinition['resource.getResourceFeaturedType2'] = array(
	'name'=>'Featured resources type 2',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesFeatured',
	'template'=>'viewResourcesFeatured',
	'arguments'=>'featuredMode/type2');
	
	$boxesDefinition['resource.getResourceFeaturedType3'] = array(
	'name'=>'Featured resources type 3',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesFeatured',
	'template'=>'viewResourcesFeatured',
	'arguments'=>'featuredMode/type3');	

	$boxesDefinition['resource.getResourceFeaturedTypeHome'] = array(
	'name'=>'Homepage resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourcesFeatured',
	'template'=>'viewResourcesFeatured',
	'arguments'=>'featuredMode/home');			
	
	$boxesDefinition['resource.searchResources'] = array(
	'name'=>'Search resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'searchResources',
	'template'=>'searchResources');	
	
	$boxesDefinition['resource.searchResourcesSideBox'] = array(
	'name'=>'Search resources side box',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'searchResources',
	'template'=>'searchResourcesSideBox');	
	
	$boxesDefinition['resource.getResourceRelations'] = array(
	'name'=>'View related resources',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceRelations',
	'template'=>'viewRelatedResources');	

	$boxesDefinition['resource.getResourceRelation'] = array(
	'name'=>'View related resource',
	'type'=>'front',
	'module'=>'resource',
	'method'=>'getResourceRelation',
	'template'=>'viewRelatedResource');		

	//=================================== page boxes =======================================

	$boxesDefinition['resource.getResourcesOnPage'] = array(
	'name'=>'Show products, offers, articles',
	'type'=>'page',
	'module'=>'resource',
	'method'=>'getResources',
	'template'=>'viewResources');		
	
?>