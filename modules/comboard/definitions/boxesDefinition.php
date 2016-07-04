<?
	//boxes defintion
	//======================================== admin area boxes ==================================	
	$boxesDefinition['comboard.comboard'] = array(
	'name'=>'Summary',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'ComboardMessages');	
	
	$boxesDefinition['comboard.period'] = array(
	'name'=>'period',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'',
	'template'=>'periodComboardMessages');
	
	$boxesDefinition['comboard.manageComboardMessages'] = array(
	'name'=>'Manage comboard messages',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'manageComboardMessages');	
	
	$boxesDefinition['comboard.manageComboardMessage'] = array(
	'name'=>'Manage comboard message',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessage',
	'template'=>'manageComboardMessage');
	
	$boxesDefinition['comboard.viewComboardMessages'] = array(
	'name'=>'View comboard messages',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'viewComboardMessages');	
	
	$boxesDefinition['comboard.viewComboardMessages1'] = array(
	'name'=>'View comboard messages1',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'getComboardMessages',
	'template'=>'viewComboardMessages1');
	
	$boxesDefinition['comboard.viewLastComboardMessages'] = array(
	'name'=>'View last comboard messages',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'viewLastComboardMessages');
	
	$boxesDefinition['comboard.threadComboardMessages'] = array(
	'name'=>'Reply on comboard message(s)',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'threadComboardMessages');	
	
	$boxesDefinition['comboard.threadComboardMessages1'] = array(
	'name'=>'Reply on comboard message(s)1',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessage',
	'template'=>'threadComboardMessages1');
	
	$boxesDefinition['comboard.memoComboardMessages'] = array(
	'name'=>'Add memo',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'manageComboardMessages',
	'template'=>'memoComboardMessages');	
	
	$boxesDefinition['comboard.3BoxComboardMessages'] = array(
	'name'=>'view 3box comboard messages',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'',
	'template'=>'3BoxComboardMessages');

	$boxesDefinition['comboard.remindComboardMessages'] = array(
	'name'=>'Send reminding email',
	'type'=>'admin',
	'module'=>'comboard',
	'method'=>'remindComboardMessage');	
	

?>