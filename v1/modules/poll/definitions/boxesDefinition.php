<?
	//boxes defintion
	//======================================== admin area boxes ==================================

	$boxesDefinition['poll.managePolls'] = array(
	'name'=>'Manage polls',
	'type'=>'admin',
	'module'=>'poll',
	'method'=>'managePollQuestions',
	'template'=>'managePolls');
	
	//=================================== fron end boxes =======================================
	
	$boxesDefinition['poll.viewPoll'] = array(
	'name'=>'View poll',
	'type'=>'front',
	'module'=>'poll',
	'method'=>'managePollQuestions',
	'template'=>'viewPoll');
?>