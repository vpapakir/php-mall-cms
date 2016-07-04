<?
	//boxes defintion
	//================================ common boxes ====================================
	
	$boxesDefinition['core.emptyBox'] = array(
	'name'=>'Empty box',
	'module'=>'core',
	'method'=>'',
	'template'=>'');	

	$boxesDefinition['core.page'] = array(
	'name'=>'Simple Page',
	'module'=>'core',
	'method'=>'staticPage',
	'template'=>'page');		

	$boxesDefinition['core.htmlEditorWindow'] = array(
	'name'=>'HTML editor window',
	'module'=>'core',
	'method'=>'staticPage',
	'template'=>'htmlEditorWindow');
	
	$boxesDefinition['core.languageSwitcher'] = array(
	'name'=>'Language switcher',
	'module'=>'core',
	'method'=>'getLanguages',
	'template'=>'languageSwitcher');

	$boxesDefinition['core.ownerSwitcher'] = array(
	'name'=>'Owner switcher',
	'module'=>'core',
	'method'=>'getOwners',
	'template'=>'ownerSwitcher');

	$boxesDefinition['core.locationSelector'] = array(
	'name'=>'Location selector',
	'module'=>'core',
	'method'=>'locationSelector',
	'template'=>'locationSelector');	
	

	$boxesDefinition['core.backupControl'] = array(
	'name'=>'Backup control',
	'module'=>'core',
	'method'=>'backupControl',
	'template'=>'backupControl');	

	$boxesDefinition['core.displayBackupList'] = array(
	'name'=>'Backup list',
	'module'=>'core',
	'method'=>'backupList',
	'template'=>'backupList');	

	$boxesDefinition['core.displayBackupDownloadList'] = array(
	'name'=>'Backup Download list',
	'module'=>'core',
	'method'=>'backupDownloadList',
	'template'=>'backupDownloadList');	

	$boxesDefinition['core.addBackupDownload'] = array(
	'name'=>'Add Backup Download',
	'module'=>'core',
	'method'=>'addBackupDownload',
	'template'=>'addBackupDownload');	

	$boxesDefinition['core.setCodeLang'] = array(
	'name'=>'set code lang',
	'module'=>'core',
	'method'=>'setCodeLang',
	'template'=>'setCodeLang');
	
	$boxesDefinition['core.setCodeLangSwitcher'] = array(
	'name'=>'set code lang switcher',
	'module'=>'core',
	'method'=>'',
	'template'=>'setCodeLangSwitcher');

	//================================ admin panel boxes ====================================
	$boxesDefinition['core.adminMenu'] = array(
	'name'=>'Administrator menu',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'getAdminMenu',
	'template'=>'viewAdminMenu');

	$boxesDefinition['core.adminShortcutsMenu'] = array(
	'name'=>'Administrator shortcuts menu',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'getAdminMenu',
	'template'=>'viewAdminShortcutsMenu',
	'arguments'=>'SectionGroupCode/adminmenushortcuts');		

	$boxesDefinition['core.manageIndexPage'] = array(
	'name'=>'Manage Index Page',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageIndexPage',
	'template'=>'manageIndexPage');
	
	$boxesDefinition['core.frontAdminController'] = array(
	'name'=>'Front-Admin swither',
	'type'=>'system',	
	'module'=>'core',
	'method'=>'frontAdminController',
	'template'=>'frontAdminController');	

	$boxesDefinition['core.manageSections'] = array(
	'name'=>'Manage sections',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'manageSections');			

	$boxesDefinition['core.manageSection'] = array(
	'name'=>'Manage section',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'manageSection');			

	$boxesDefinition['core.manageLangFields'] = array(
	'name'=>'Manage language fields',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageLangFields',
	'template'=>'manageLangFields');		
	
	$boxesDefinition['core.manageLanguages'] = array(
	'name'=>'Manage languages',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageLanguages',
	'template'=>'manageLanguages');	
	
	$boxesDefinition['core.manageSinhronizeReferences'] = array(
	'name'=>'Manage Sinhronize references',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSinhronizeReferences',
	'template'=>'manageSinhronizeReferences');
		
	$boxesDefinition['core.manageReferences'] = array(
	'name'=>'Manage references',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageReferences',
	'template'=>'manageReferences');	
	
	$boxesDefinition['core.manageReferenceGenerator'] = array(
	'name'=>'Manage reference generator',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageReferenceGenerator',
	'template'=>'manageReferenceGenerator');
	
	$boxesDefinition['core.manageSetting'] = array(
	'name'=>'Manage setting',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageSetting');

	$boxesDefinition['core.manageSettingFile'] = array(
	'name'=>'Manage setting file or image',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageSettingFile');	
	
	$boxesDefinition['core.manageSettingStyle'] = array(
	'name'=>'Manage setting style',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageSettingStyle');			
	
	$boxesDefinition['core.manageSettingText'] = array(
	'name'=>'Edit setting HTML fields',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageSettingHTML');		
	
	$boxesDefinition['core.manageSettings'] = array(
	'name'=>'Manage settings',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageSettings');		
	
	$boxesDefinition['core.manageSettingGroups'] = array(
	'name'=>'Manage setting groups',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSettingGroups',
	'template'=>'manageSettingGroups');		
	
	$boxesDefinition['core.manageSections'] = array(
	'name'=>'Manage sections',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'manageSections');		
	
	$boxesDefinition['core.manageSectionGroups'] = array(
	'name'=>'Manage section groups',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageSectionGroups',
	'template'=>'manageSectionGroups');		

	$boxesDefinition['core.manageRegions'] = array(
	'name'=>'Manage regions',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageRegions',
	'template'=>'manageRegions');	

	$boxesDefinition['core.manageRegion'] = array(
	'name'=>'Manage region',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageRegion',
	'template'=>'manageRegion');		
	
	$boxesDefinition['core.getRegionsDropDown'] = array(
	'name'=>'Regions drop down',
	'type'=>'front',
	'module'=>'core',
	'method'=>'getRegionsTree',
	'template'=>'viewRegionsDropDown',
	'arguments'=>'treeType/all');			

	$boxesDefinition['core.countriesSelector'] = array(
	'name'=>'Countries selector',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getCountries',
	'template'=>'countriesSelector');	
	
	$boxesDefinition['core.manageMailTemplates'] = array(
	'name'=>'Manage email templates',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageMailTemplates',
	'template'=>'manageMailTemplates');		
	
	$boxesDefinition['core.manageMailTemplateGroups'] = array(
	'name'=>'Manage email template groups',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageMailTemplateGroups',
	'template'=>'manageMailTemplateGroups');	

	$boxesDefinition['core.manageOwners'] = array(
	'name'=>'Manage groups',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageOwners',
	'template'=>'manageOwners');	
	
	$boxesDefinition['core.manageViews'] = array(
	'name'=>'Manage views',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageViews',
	'template'=>'manageViews');		

	$boxesDefinition['core.manageStyle'] = array(
	'name'=>'Edit style file',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageStyle',
	'template'=>'manageStyle');

	$boxesDefinition['core.manageTabLinks'] = array(
	'name'=>'Manage tab links',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageTabLinks',
	'template'=>'manageTabLinks');

	$boxesDefinition['core.manageModules'] = array(
	'name'=>'Manage modules',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'manageModules',
	'template'=>'manageModules');							
	
	$boxesDefinition['core.UpdatesCoorda'] = array(
	'name'=>'Updates from Coorda',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'',
	'template'=>'getUpdatesCoorda');
	
	$boxesDefinition['core.getSupportListAdm'] = array(
	'name'=>'message alert list in admin',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'getSupportList',
	'template'=>'getSupportList');
	
	$boxesDefinition['core.backoffice'] = array(
	'name'=>'Back office',
	'type'=>'admin',	
	'module'=>'core',
	'method'=>'',
	'template'=>'backoffice');
	
	//================================ admin front boxes ====================================
	
	$boxesDefinition['core.AdministratorStats'] = array(
	'name'=>'Front Administrator stats',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getStats',
	'template'=>'admin/adminStats');

	$boxesDefinition['core.manageSectionsFront'] = array(
	'name'=>'Front Administrator manage sections',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'admin/manageSections');			

	$boxesDefinition['core.manageSectionFront'] = array(
	'name'=>'Front Administrator manage section',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'admin/manageSection');			

	$boxesDefinition['core.manageLangFieldsFront'] = array(
	'name'=>'Front Administrator manage language fields',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageLangFields',
	'template'=>'admin/manageLangFields');		

	$boxesDefinition['core.manageLanguagesFront'] = array(
	'name'=>'Front Administrator Manage languages',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageLanguages',
	'template'=>'admin/manageLanguages');	

	$boxesDefinition['core.manageSettingFront'] = array(
	'name'=>' Front Administrator Manage setting',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'admin/manageSetting');

	$boxesDefinition['core.manageSettingFileFront'] = array(
	'name'=>'Front Administrator Manage setting file or image',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'admin/manageSettingFile');	
	
	$boxesDefinition['core.manageSettingStyleFront'] = array(
	'name'=>'Front Administrator Manage setting style',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'admin/manageSettingStyle');			
	
	$boxesDefinition['core.manageSettingTextFront'] = array(
	'name'=>'Front Administrator Edit setting HTML fields',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'admin/manageSettingHTML');		
	
	$boxesDefinition['core.manageSettingsFront'] = array(
	'name'=>'Front Administrator Manage settings',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'admin/manageSettings');		

	
	//=============================================== front end boxes =============================
	$boxesDefinition['core.adminMenuFront'] = array(
	'name'=>'Administrator menu',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'viewAdminMenu',
	'arguments'=>'SectionGroupCode/adminfront/treeType/all');	
	
	$boxesDefinition['core.leftSectionsBox'] = array(
	'name'=>'Sections left box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'leftSectionsBox',
	'arguments'=>'SectionGroupCode/main/treeType/expanded');
	
	$boxesDefinition['core.leftSectionsBox'] = array(
	'name'=>'Sections left box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'leftSectionsBox',
	'arguments'=>'SectionGroupCode/main/treeType/expanded');	

	$boxesDefinition['core.leftSectionsBoxFull'] = array(
	'name'=>'Sections left box (full tree)',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'leftSectionsBox',
	'arguments'=>'SectionGroupCode/main/treeType/all');

	$boxesDefinition['core.leftSectionsBoxFullDHTML'] = array(
	'name'=>'Sections left box (full tree)DHTML',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'leftSectionsBoxDHTML',
	'arguments'=>'SectionGroupCode/main/treeType/all');	
	
	$boxesDefinition['core.left2SectionsBox'] = array(
	'name'=>'Sections left2 box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'left2SectionsBox',
	'arguments'=>'SectionGroupCode/left2/treeType/all');
		
	$boxesDefinition['core.topSectionsBox'] = array(
	'name'=>'Top sections box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'topSectionsBox',
	'arguments'=>'SectionGroupCode/top');	

	$boxesDefinition['core.rightSectionsBox'] = array(
	'name'=>'Sections right box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'rightSectionsBox',
	'arguments'=>'SectionGroupCode/right/treeType/expanded');	

	$boxesDefinition['core.rightSectionsBoxFull'] = array(
	'name'=>'Sections right box (full tree)',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'rightSectionsBox',
	'arguments'=>'SectionGroupCode/right/treeType/all');
		
	$boxesDefinition['core.bottomSectionsBox'] = array(
	'name'=>'Bottom sections box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'bottomSectionsBox',
	'arguments'=>'SectionGroupCode/bottom');
		
	$boxesDefinition['core.userSectionsBox'] = array(
	'name'=>'User area sections box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsTree',
	'template'=>'userSectionsBox',
	'arguments'=>'SectionGroupCode/user');			

	$boxesDefinition['core.getSectionsList'] = array(
	'name'=>'Sections list (as list of articles)',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSectionsList',
	'template'=>'getSectionsList');	
			
	$boxesDefinition['core.getOwnersList'] = array(
	'name'=>'Groups list',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getOwners',
	'template'=>'ownersList');		
	
	$boxesDefinition['core.viewRegions'] = array(
	'name'=>'View regions',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getLocations',
	'template'=>'viewRegions');

	$boxesDefinition['core.viewTreeRegions'] = array(
	'name'=>'View regions tree',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getRegionsFullTree',
	'template'=>'viewTreeRegions');	
	
	$boxesDefinition['core.viewMyOwner'] = array(
	'name'=>'View my Owner',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getOwner',
	'template'=>'viewMyOwner');	
	
	$boxesDefinition['core.viewMyOwnerStatus'] = array(
	'name'=>'View my Owner status (for homepage)',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getOwner',
	'template'=>'viewMyOwnerStatus');		

	$boxesDefinition['core.registerOwner'] = array(
	'name'=>'Register Owner',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'addOwner',
	'template'=>'registerOwner');

	$boxesDefinition['core.editOwnerSettings'] = array(
	'name'=>'Owner settings',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'editOwnerSettings');	

	$boxesDefinition['core.editOwnerSitemap'] = array(
	'name'=>'Owner sitemap',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'editOwnerSitemap');	

	$boxesDefinition['core.editOwnerSection'] = array(
	'name'=>'Edit owner page',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSections',
	'template'=>'editOwnerSection');	
	
	$boxesDefinition['core.manageOwnerSettingFile'] = array(
	'name'=>'Manage setting file or image',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'manageSettings',
	'template'=>'manageOwnerSettingFile');		
	
	$boxesDefinition['core.getSupportList'] = array(
	'name'=>'message alert list',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSupportList',
	'template'=>'getSupportList');
	
	$boxesDefinition['core.getSupportRSS'] = array(
	'name'=>'message rss from coorda',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'getSupportList',
	'template'=>'getSupportRSS');
	
	$boxesDefinition['core.RSSNewsBox'] = array(
	'name'=>'rss news box',
	'type'=>'front',	
	'module'=>'core',
	'method'=>'',
	'template'=>'RSSNewsBox');
		
	//================================ synchronization boxes ====================================
	$boxesDefinition['core.synchronizationManager'] = array(
	'name'=>'Synchronization: manager',
	'type'=>'admin',
	'module'=>'core',
	'method'=>'synchronizationManager',
	'template'=>'synchronizationManager');
	
	$boxesDefinition['core.synchronizeLangFieldsClient'] = array(
	'name'=>'Synchronization: language fields',
	'type'=>'synchronization',
	'module'=>'core',
	'method'=>'synchronizeLangFieldsClient',
	'template'=>'synchronizeLangFields');

	$boxesDefinition['core.KeywordSearch'] = array(
	'name'=>'Search: Keyword search',
	'type'=>'front',
	'module'=>'core',
	'method'=>'',
	'template'=>'KeywordSearch');
	//================================ system boxes ==================================================
	$boxesDefinition['core.getRSSLinks'] = array(
	'name'=>'View RSS Links',
	'type'=>'system',
	'module'=>'core',
	'method'=>'',
	'template'=>'viewRSSLinks');	
	
	
?>