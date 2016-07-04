<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	
	$boxesDefinition['stats.manageStatsReports'] = array(
	'name'=>'manage stats reports',
	'type'=>'admin',
	'module'=>'stats',
	'method'=>'manageStatsReports',
	'template'=>'manageStatsReports');
	
	$boxesDefinition['stats.getReport'] = array(
	'name'=>'View stats report',
	'type'=>'admin',
	'module'=>'stats',
	'method'=>'getReport',
	'template'=>'viewReports');

	$boxesDefinition['stats.makeReports'] = array(
	'name'=>'Generate reports',
	'type'=>'admin',
	'module'=>'stats',
	'method'=>'makeReports',
	'template'=>'makeReports');	
	
	//=================================== fron end boxes =======================================

?>