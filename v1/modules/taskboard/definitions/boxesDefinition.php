<?
	//boxes defintion
	//======================================== admin area boxes ==================================

	$boxesDefinition['taskboard.Taskboard'] = array(
	'name'=>'Main taskboard box',
	'type'=>'admin',
	'module'=>'taskboard',
	'template'=>'Taskboard');	
	


	$boxesDefinition['taskboard.manageTaskboards'] = array(
	'name'=>'Manage tasks',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'getTaskboards',
	'template'=>'manageTaskboards');
	
	$boxesDefinition['taskboard.manageTaskboardsToday'] = array(
	'name'=>'Manage tasks today',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'getTaskboards',
	'template'=>'manageTaskboardsToday',
	'arguments'=>'Today/1');
	
	$boxesDefinition['taskboard.manageTaskboard'] = array(
	'name'=>'Manage task',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'manageTaskboards',
	'template'=>'manageTaskboard',
	'arguments' => 'NameNoProject/Y');	
	
	$boxesDefinition['taskboard.manageProjects'] = array(
	'name'=>'Manage projects',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'manageProjects',
	'template'=>'manageProjects');	
	
	$boxesDefinition['taskboard.manageTaskboardRecords'] = array(
	'name'=>'Manage taskboard records',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'manageTaskboard',
	'template'=>'manageTaskboardRecords');		

	$boxesDefinition['taskboard.manageLastTaskboardRecords'] = array(
	'name'=>'New task records for admin home',
	'type'=>'admin',
	'module'=>'taskboard',
	'method'=>'getTaskboards',
	'template'=>'manageLastTaskboardRecords',
	'arguments'=>'filterMode/last');	
	


?>