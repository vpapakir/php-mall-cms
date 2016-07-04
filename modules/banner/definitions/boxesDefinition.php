<?
	//boxes defintion
	$boxesDefinition['banner.manageBanners'] = array(
	'name'=>'Manage Banners',
	'type'=>'admin',
	'module'=>'banner',
	'method'=>'manageBanners',
	'template'=>'manageBanners');		
	
	//================================ admin front boxes ====================================
	$boxesDefinition['banner.manageBannersFront'] = array(
	'name'=>'Admin Front Manage Banners',
	'type'=>'front',
	'module'=>'banner',
	'method'=>'manageBanners',
	'template'=>'admin/manageBanners');		
	
	//=================================== fron end boxes =======================================
	$boxesDefinition['banner.getLeftBanners'] = array(
	'name'=>'Banners box (left)',
	'type'=>'front',
	'module'=>'banner',
	'method'=>'getBanners',
	'template'=>'viewBanners',
	'arguments'=>'BannerPlace/left');	

	$boxesDefinition['banner.getCenterBanners'] = array(
	'name'=>'Banners box (center)',
	'type'=>'front',
	'module'=>'banner',
	'method'=>'getBanners',
	'template'=>'viewBanners',
	'arguments'=>'BannerPlace/center');			
		
	$boxesDefinition['banner.getRightBanners'] = array(
	'name'=>'Banners box (right)',
	'type'=>'front',
	'module'=>'banner',
	'method'=>'getBanners',
	'template'=>'viewBanners',
	'arguments'=>'BannerPlace/right');	
	
	$boxesDefinition['banner.addBanners'] = array(
	'name'=>'add Banners',
	'type'=>'front',
	'module'=>'banner',
	'method'=>'addBanner',
	'template'=>'addBanners');
			
?>