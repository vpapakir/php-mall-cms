<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['tour.manageTourOrdersLast'] = array(
	'name'=>'Manage tour Orders Last',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'getTourOrders',
	'template'=>'manageTourOrdersLast');
	
	$boxesDefinition['tour.manageTours'] = array(
	'name'=>'Manage tours',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'manageTours');

	$boxesDefinition['tour.manageLastTours'] = array(
	'name'=>'Admin last tours',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'manageTours',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['tour.manageTour'] = array(
	'name'=>'Manage tour',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'manageTour');		

	$boxesDefinition['tour.manageTourCategories'] = array(
	'name'=>'Manage tour categories',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourCategories',
	'template'=>'manageCategories');
	
	$boxesDefinition['tour.manageTourCategory'] = array(
	'name'=>'Manage service category',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourCategories',
	'template'=>'manageCategory');		

	$boxesDefinition['tour.manageTourTypes'] = array(
	'name'=>'Manage service types',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourTypes',
	'template'=>'manageTourTypes');
	
	$boxesDefinition['tour.manageTourFields'] = array(
	'name'=>'Manage service fields',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourFields',
	'template'=>'manageTourFields');	
	
	$boxesDefinition['tour.manageTourComments'] = array(
	'name'=>'Manage tour comments',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourComments',
	'template'=>'manageTourComments');	
	
	$boxesDefinition['tour.manageTourComment'] = array(
	'name'=>'Manage tour comment',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourComments',
	'template'=>'manageTourComment');
	
	$boxesDefinition['tour.manageLastComments'] = array(
	'name'=>'New tour comments for admin home',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'getTourComments',
	'template'=>'manageLastComments',
	'arguments'=>'mode/last');
	
	$boxesDefinition['tour.manageOrders'] = array(
	'name'=>'Manage tour orders',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourOrders',
	'template'=>'manageTourOrders');		
	
	$boxesDefinition['tour.checkoutEdit'] = array(
	'name'=>'Checkout tour',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'getTourOrder',
	'template'=>'order');
	
	$boxesDefinition['tour.checkoutlastAdmin'] = array(
	'name'=>'New tour orders',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'manageTourOrders',
	'template'=>'manageLastOrder',
	'arguments'=>'filterMode/last');
	
	$boxesDefinition['tour.viewShoppingCart'] = array(
	'name'=>'View Shopping Cart',
	'type'=>'admin',
	'module'=>'tour',
	'method'=>'getTourOrder',
	'template'=>'viewShoppingCart');
	
	
	//=================================== fron end boxes =======================================
	
	$boxesDefinition['tour.viewOrders'] = array(
	'name'=>'View tour orders',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourOrders',
	'template'=>'viewTourOrders');
	
	$boxesDefinition['tour.getCategoriesDropDwon'] = array(
	'name'=>'Categories tour drop down',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategoriesTree',
	'template'=>'viewCategoriesDropDown');
	
	$boxesDefinition['tour.getCategoriesBox'] = array(
	'name'=>'Categories tour box',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategories',
	'template'=>'viewCategoriesBox');	

	$boxesDefinition['tour.getTopCategoriesBox'] = array(
	'name'=>'Top tour categories box',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategories',
	'template'=>'viewTopCategoriesBox',
	'arguments'=>'filterMode/top');		
	
	$boxesDefinition['tour.getCategoriesTreeBox'] = array(
	'name'=>'Categoriestour tour tree box',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategoriesTree',
	'template'=>'viewCategoriesTreeBox',
	'arguments'=>'treeType/all');	
	
	$boxesDefinition['tour.getCategoriesTreeCenterBox'] = array(
	'name'=>'Categories tour tree center box',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategoriesTree',
	'template'=>'viewCategoriesTreeCenterBox',
	'arguments'=>'treeType/current');	
	
	$boxesDefinition['tour.getCategoryBox'] = array(
	'name'=>'Category tour info',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategory',
	'template'=>'viewCategory');
	
	$boxesDefinition['tour.getCategorySEOInfo'] = array(
	'name'=>'Category tour SEO info',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategorySEOInfo',
	'template'=>'getCategorySEOInfo');		
	
	$boxesDefinition['tour.getTours'] = array(
	'name'=>'Tours list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTours',
	'template'=>'viewTours');
	
	$boxesDefinition['tour.getToursByTypes'] = array(
	'name'=>'Tours list by types',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getToursByTypes',
	'template'=>'viewToursByTypes');

	$boxesDefinition['tour.getToursFeatured'] = array(
	'name'=>'Tours featured list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getToursFeatured',
	'template'=>'viewToursByTypes');	
	
	$boxesDefinition['tour.getLastTours'] = array(
	'name'=>'Tours last list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTours',
	'template'=>'viewToursList',
	'arguments'=>'filterMode/last1');
	
	$boxesDefinition['tour.getPromotionsTours'] = array(
	'name'=>'Tours promotions list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTours',
	'template'=>'viewToursList',
	'arguments'=>'filterMode/promotions');
		
	$boxesDefinition['tour.getToursBySelectedType'] = array(
	'name'=>'Tours list for selected type',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getToursByTypes',
	'template'=>'viewTours');		
	
	$boxesDefinition['tour.getTour'] = array(
	'name'=>'Tour info',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTour',
	'template'=>'viewTour');	
	
	$boxesDefinition['tour.getTourInfo'] = array(
	'name'=>'Tour Add info',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTour',
	'template'=>'viewTourInfo');
	
	$boxesDefinition['tour.getTourSEOInfo'] = array(
	'name'=>'Tour SEO info',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourSEOInfo',
	'template'=>'getTourSEOInfo');		
	
	$boxesDefinition['tour.getLastComments'] = array(
	'name'=>'Last tour comments list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourComments',
	'template'=>'viewLastComments',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['tour.getComments'] = array(
	'name'=>'Comments tour list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourComments',
	'template'=>'viewComments');
	
	$boxesDefinition['tour.getUserComments'] = array(
	'name'=>'Tour User Comments list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourComments',
	'template'=>'viewUserComments');
	
	$boxesDefinition['tour.editComments'] = array(
	'name'=>'Edit tour user comments',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourComments',
	'template'=>'editTourComments');	
	
	$boxesDefinition['tour.editComment'] = array(
	'name'=>'Add/Edit tour comment',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourComments',
	'template'=>'editTourComment');	

	$boxesDefinition['tour.getReviews'] = array(
	'name'=>'Tour reviews list',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourComments',
	'template'=>'manageTourReviews');			
		
	$boxesDefinition['tour.shoppingCart'] = array(
	'name'=>'Tour shopping cart',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourCartItems',
	'template'=>'shoppingCart');
	
	$boxesDefinition['tour.requestCart'] = array(
	'name'=>'Tour request cart',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageCartItems',
	'template'=>'requestCart');	
	
	$boxesDefinition['tour.checkout'] = array(
	'name'=>'Tour Checkout',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'addTourOrder',
	'template'=>'order');
	
	$boxesDefinition['tour.checkoutFront'] = array(
	'name'=>'Manage tour orders',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTourOrders',
	'template'=>'manageOrder');
	
	$boxesDefinition['tour.viewCheckout'] = array(
	'name'=>'View tour Order',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourOrder',
	'template'=>'viewOrder');
	
	$boxesDefinition['tour.bill'] = array(
	'name'=>'Tour Bill',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourOrder',
	'template'=>'bill');	
	
	$boxesDefinition['tour.request'] = array(
	'name'=>'Send tour request',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'addTourOrder',
	'template'=>'request');
	
	$boxesDefinition['tour.payment'] = array(
	'name'=>'Tour Payment system request',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'doPayment',
	'template'=>'doPayment');	

	$boxesDefinition['tour.editTours'] = array(
	'name'=>'Edit tours',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'editTours',
	'arguments'=>'manageMode/user');
	
	$boxesDefinition['tour.getLastUserTours'] = array(
	'name'=>'Get last user tours',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'lastUserTours',
	'arguments'=>'manageMode/user/filterMode/last');	
	
	$boxesDefinition['tour.editTour'] = array(
	'name'=>'Edit tour',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'manageTours',
	'template'=>'editTour');	
	
	$boxesDefinition['tour.addTour'] = array(
	'name'=>'Add tour',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'addTour',
	'template'=>'addTour');	
	
	$boxesDefinition['tour.tourCategoriesPath'] = array(
	'name'=>'Current tour categories path',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourCategoriesPath',
	'template'=>'viewTourCategoriesPath');			
	
	$boxesDefinition['tour.ToursSearchForm'] = array(
	'name'=>'Tours Search Form',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getToursSearchForm',
	'template'=>'viewToursSearchForm');
	
	$boxesDefinition['tour.viewUserShoppingCart'] = array(
	'name'=>'View User Shopping Cart',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'getTourOrder',
	'template'=>'viewShoppingCart');
	
	$boxesDefinition['tour.AddTourRate'] = array(
	'name'=>'Tour rating from users',
	'type'=>'front',
	'module'=>'tour',
	'method'=>'tourRatingUsers',
	'template'=>'AddTourRateUsers')
		
?>