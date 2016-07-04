<?
	//boxes defintion
	//================================ system boxes ====================================
	$boxesDefinition['session.doLogin'] = array(
	'name'=>'Login processing',
	'module'=>'session',
	'method'=>'doLogin',
	'template'=>'');
	
	$boxesDefinition['session.logout'] = array(
	'name'=>'Logout processing',
	'module'=>'session',
	'method'=>'logout',
	'template'=>'');	
	
	$boxesDefinition['session.Statistics'] = array(
	'name'=>'Statistics',
	'module'=>'session',
	'method'=>'getStatistics',
	'template'=>'statistics');

	$boxesDefinition['session.StatisticsMini'] = array(
	'name'=>'Statistics',
	'module'=>'session',
	'method'=>'getStatistics',
	'template'=>'statisticsmini');
	
		
	$boxesDefinition['session.login'] = array(
	'name'=>'Login form',
	'module'=>'session',
	'method'=>'login',
	'template'=>'login');		

	$boxesDefinition['session.passwordRemind'] = array(
	'name'=>'Password reminder',
	'module'=>'session',
	'method'=>'passwordReminder',
	'template'=>'passwordReminder');
	
	$boxesDefinition['session.loginWithUserID'] = array(
	'name'=>'login with userID',
	'module'=>'session',
	'method'=>'loginWithUserID',
	'template'=>'');
			
	//================================ admin panel boxes ====================================
	$boxesDefinition['session.manageUsers'] = array(
	'name'=>'Manage users',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageUsers',
	'template'=>'manageUsers');
	
	$boxesDefinition['session.manageLastUsers'] = array(
	'name'=>'Manage last users',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageUsers',
	'template'=>'manageLastUsers',
	'arguments'=>'GroupID/user');

	$boxesDefinition['session.manageUser'] = array(
	'name'=>'Manage user',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageProfile',
	'template'=>'manageUser');	
	
	$boxesDefinition['session.adminProfile'] = array(
	'name'=>'Administrator profile',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageProfile',
	'template'=>'manageProfile');	
	
	$boxesDefinition['session.manageUserGroups'] = array(
	'name'=>'User groups',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageUserGroups',
	'template'=>'manageUserGroups');
	
	$boxesDefinition['session.manageUserTypes'] = array(
	'name'=>'User profile forms builder',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'manageUserTypes',
	'template'=>'manageUserTypes');	
	
	$boxesDefinition['session.registrationFieldsFormFromAdmin'] = array(
	'name'=>'Registration fields form from admin',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'getUserFieldsRegister',
	'template'=>'registrationFieldsForm');
	
	$boxesDefinition['session.viewUser'] = array(
	'name'=>'view user info',
	'type'=>'admin',
	'module'=>'session',
	'method'=>'getProfile',
	'template'=>'viewUser');
		
	//=============================================== front end boxes =============================

	$boxesDefinition['session.userProfile'] = array(
	'name'=>'User profile',
	'type'=>'front',
	'module'=>'session',
	'method'=>'manageProfile',
	'template'=>'manageProfile');	
	
	$boxesDefinition['session.usersProfile'] = array(
	'name'=>'Users profile',
	'type'=>'front',
	'module'=>'session',
	'method'=>'getProfile',
	'template'=>'manageProfile');
	
	$boxesDefinition['session.registration'] = array(
	'name'=>'Registration form',
	'type'=>'front',
	'module'=>'session',
	'method'=>'register',
	'template'=>'registration');		
	
	$boxesDefinition['session.registrationFieldsForm'] = array(
	'name'=>'Registration fields form',
	'type'=>'front',
	'module'=>'session',
	'method'=>'register',
	'template'=>'registrationFieldsForm');		
	
	$boxesDefinition['session.loginBox'] = array(
	'name'=>'Login sidebox',
	'type'=>'front',
	'module'=>'session',
	'method'=>'login',
	'template'=>'loginbox');	
	
	$boxesDefinition['session.viewUserInfo3Cols'] = array(
	'name'=>'view User Info for 3 cols',
	'type'=>'front',
	'module'=>'session',
	'method'=>'getProfile',
	'template'=>'viewUser3Cols');
	
?>