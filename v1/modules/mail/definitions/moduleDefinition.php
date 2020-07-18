<?
	//module defintiion
	$moduleDefinition['contactForm']=$layoutsDefinition['main'];
	$moduleDefinition['contactForm']['center']['mail.contactForm'] = $boxesDefinition['mail.contactForm'];
	$moduleDefinition['contactForm']['SectionArguments'];
	$moduleDefinition['contactForm']['AccessRight'];
	
	$moduleDefinition['manageMessages']=$layoutsDefinition['admin'];
	$moduleDefinition['manageMessages']['center']['mail.manageMessages'] = $boxesDefinition['resource.manageMessages'];

	$moduleDefinition['mailbox']=$layoutsDefinition['admin'];
	$moduleDefinition['mailbox']['center']['mail.manageMessages'] = $boxesDefinition['mail.manageMessages'];

?>