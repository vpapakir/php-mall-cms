<?
	//boxes defintion
	//================================ system boxes ====================================
	
	//================================ admin panel boxes ====================================
	$boxesDefinition['newsletter.manageNewsletterLists'] = array(
	'name'=>'Manage newsletter lists',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'manageNewsletterLists',
	'template'=>'manageLists');
	
	$boxesDefinition['newsletter.manageSubscribers'] = array(
	'name'=>'Manage subscribers',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'manageSubscribers',
	'template'=>'manageSubscribers');
	
	$boxesDefinition['newsletter.newsletters'] = array(
	'name'=>'Manage newsletters',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'manageNewsletters',
	'template'=>'manageNewsletters');
	
	$boxesDefinition['newsletter.sendNewsletter'] = array(
	'name'=>'Send newsletter',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'sendNewsletter',
	'template'=>'manageNewsletters');
	
	$boxesDefinition['newsletter.newsletterTemplates'] = array(
	'name'=>'Manage newsletters templates',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'manageNewsletters',
	'template'=>'manageNewsletterTemplates');
	
	$boxesDefinition['newsletter.importSubscribers'] = array(
	'name'=>'Import subscribers',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'importSubscribers',
	'template'=>'importSubscribers');
	
	$boxesDefinition['newsletter.exportSubscribersForm'] = array(
	'name'=>'Export subscribers',
	'type'=>'admin',
	'module'=>'newsletter',
	'method'=>'exportSubscribers',
	'template'=>'exportSubscribers');
	//=============================================== front end boxes =============================

	
?>