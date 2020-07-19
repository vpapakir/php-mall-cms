<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['webcontrol.manageDomains'] = array(
	'name'=>'Manage webcontrol Domains',
	'type'=>'admin',
	'module'=>'webcontrol',
	'method'=>'manageDomains',
	'template'=>'manageDomains');

	$boxesDefinition['webcontrol.manageLastDomains'] = array(
	'name'=>'Admin last webcontrol Domains',
	'type'=>'admin',
	'module'=>'webcontrol',
	'method'=>'manageDomains',
	'template'=>'manageDomains',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['webcontrol.manageDomain'] = array(
	'name'=>'Manage webcontrol Domain',
	'type'=>'admin',
	'module'=>'webcontrol',
	'method'=>'manageDomain',
	'template'=>'manageDomain');		

	$boxesDefinition['webcontrol.manageDomainTypes'] = array(
	'name'=>'Manage webcontrol Domain types',
	'type'=>'admin',
	'module'=>'webcontrol',
	'method'=>'manageDomainTypes',
	'template'=>'manageDomainTypes');
	
	$boxesDefinition['webcontrol.manageDomainFields'] = array(
	'name'=>'Manage webcontrol Domain fields',
	'type'=>'admin',
	'module'=>'webcontrol',
	'method'=>'manageDomainTypes',
	'template'=>'manageDomainFields',
	'arguments'=>'DomainTypeID/1');
		
	//=================================== fron end boxes =======================================
	
	$boxesDefinition['webcontrol.getDomains'] = array(
	'name'=>'webcontrol Domains list',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'getDomains',
	'template'=>'viewDomains');
	
	$boxesDefinition['webcontrol.getDomainsFeatured'] = array(
	'name'=>'webcontrol Domains featured list',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'getDomainsFeatured',
	'template'=>'viewDomainsByTypes');	
	
	$boxesDefinition['webcontrol.getDomain'] = array(
	'name'=>'webcontrol Domain info',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'getDomain',
	'template'=>'viewDomain');	
	
	$boxesDefinition['webcontrol.getDomainSEOInfo'] = array(
	'name'=>'webcontrol Domain SEO info',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'getDomainSEOInfo',
	'template'=>'getDomainSEOInfo');		
	
	$boxesDefinition['webcontrol.getLastUserDomains'] = array(
	'name'=>'Get last user webcontrol Domains',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'manageDomains',
	'template'=>'lastUserDomains',
	'arguments'=>'manageMode/user/filterMode/last');	
	
	$boxesDefinition['webcontrol.editDomains'] = array(
	'name'=>'Edit webcontrol Domains',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'manageDomains',
	'template'=>'editDomains',
	'arguments'=>'manageMode/user');
		
	$boxesDefinition['webcontrol.editDomain'] = array(
	'name'=>'Edit webcontrol Domain',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'manageDomain',
	'template'=>'editDomain');	
	
	$boxesDefinition['webcontrol.addDomain'] = array(
	'name'=>'Add webcontrol Domain',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'addDomain',
	'template'=>'addDomain');	
	
	$boxesDefinition['webcontrol.searchDomains'] = array(
	'name'=>'Search webcontrol Domain',
	'type'=>'front',
	'module'=>'webcontrol',
	'method'=>'searchDomains',
	'template'=>'searchDomains');

?>