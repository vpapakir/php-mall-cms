<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['cashflow.manageCompany'] = array(
	'name'=>'Manage company',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowCompany',
	'template'=>'manageCompany');

	$boxesDefinition['cashflow.manageAccounts'] = array(
	'name'=>'Manage accounts',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowAccounts',
	'template'=>'manageAccounts');		
	
	$boxesDefinition['cashflow.viewAccounts'] = array(
	'name'=>'View accounts',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowAccounts',
	'template'=>'viewAccounts');
	
	$boxesDefinition['cashflow.homeCashflow'] = array(
	'name'=>'View home Cashflow',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowAccounts',
	'template'=>'viewCompany');	
			
	$boxesDefinition['cashflow.manageBills'] = array(
	'name'=>'Manage bills',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowBills',
	'template'=>'manageBills');	

	$boxesDefinition['cashflow.viewBills'] = array(
	'name'=>'View bills (show account)',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowBills',
	'template'=>'viewBills');	

	$boxesDefinition['cashflow.searchBills'] = array(
	'name'=>'Search bills',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'manageCashFlowBills',
	'template'=>'searchBills');	
	
	$boxesDefinition['cashflow.viewSummary'] = array(
	'name'=>'Summary (home)',
	'type'=>'admin',
	'module'=>'cashflow',
	'method'=>'getSummary',
	'template'=>'viewSummary');	

?>