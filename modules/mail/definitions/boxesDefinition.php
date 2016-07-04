<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	
	$boxesDefinition['mail.3cols'] = array(
	'type'=>'admin',
	'name'=>'Main 3c template',
	'module'=>'mail',
	'template'=>'3cols');
	
	$boxesDefinition['mail.contactForm'] = array(
	'type'=>'admin',
	'name'=>'Contact form',
	'module'=>'mail',
	'method'=>'contactForm',
	'template'=>'contactForm');
	
	$boxesDefinition['mail.manageMessages'] = array(
	'name'=>'Mailbox',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'manageMessages');	
	
	$boxesDefinition['mail.newMessage'] = array(
	'name'=>'Mailbox',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'newMessage');	
	
	$boxesDefinition['mail.newClientsMessage'] = array(
	'name'=>'new clients message',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'newClientsMessage');
	
	$boxesDefinition['mail.viewClients'] = array(
	'name'=>'view clients',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'getClients',
	'template'=>'viewClients');	
	
	$boxesDefinition['mail.sendClientsMessage'] = array(
	'name'=>'send clients message',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'',
	'template'=>'sendClientsMessage');	
	
	$boxesDefinition['mail.viewLastMessages'] = array(
	'name'=>'last messages',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'getLastAdminMessages',
	'template'=>'viewLastMessages');	
	
	$boxesDefinition['mail.viewLastMessage'] = array(
	'name'=>'last message',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'viewLastMessage');	
	
	$boxesDefinition['mail.newMessages'] = array(
	'name'=>'New messages',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'newMessages',
	'arguments'=>''
	);		

	$boxesDefinition['mail.clientMessages'] = array(
	'name'=>'Client messages',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'getClientMessages',
	'template'=>'clientMessages',
	'arguments'=>'messagesFilterMode/clientmessages'
	);		

	$boxesDefinition['mail.sendMailQueue'] = array(
	'name'=>'Send mail queue',
	'type'=>'admin',
	'module'=>'mail',
	'method'=>'sendMailQueue',
	'template'=>''
	);	
		

	//=================================== fron end boxes =======================================

	$boxesDefinition['mail.userMailbox'] = array(
	'name'=>'User area mailbox',
	'type'=>'front',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'mailbox');			
	
	$boxesDefinition['mail.userMailbox'] = array(
	'name'=>'User area mailbox',
	'type'=>'front',
	'module'=>'mail',
	'method'=>'manageMessages',
	'template'=>'mailbox');	
	
	$boxesDefinition['mail.contactForm'] = array(
	'name'=>'Contact Form',
	'type'=>'front',
	'module'=>'mail',
	'method'=>'contactF',
	'template'=>'contactForm');

	$boxesDefinition['mail.sendContactForm'] = array(
	'name'=>'Send static contact form',
	'type'=>'front',
	'module'=>'mail',
	'method'=>'sendContactForm',
	'template'=>'sendContactForm');	
	
	$boxesDefinition['mail.message'] = array(
	'name'=>'message',
	'type'=>'front',
	'module'=>'mail',
	'method'=>'manageMessage',
	'template'=>'message');	

?>