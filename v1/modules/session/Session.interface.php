<?php
//XCMSPro: PromoReferral entity WebService public methods
function getSession($input)
{
	global $CORE;
	$sessionID = $input['sessionID'];
	$remoteIP = $input['remoteIP'];	
	$USER = new UserSession();
	$USER->setSessionID($sessionID);
	return $USER->getSession($remoteIP);
}

function setSessionVars($input)
{
	$USER = new UserSession();
	$USER->setSessionID($input['SessionID']);
	return $USER->sesSetVar($input['SessionVars']);
}
//type values: 
//1. empty (default) - takes an email, generates a password and sends it to the email for confirmation
//2. login - takes a login and email, generates a password and sends it for aprovement
//3. authorize - takes an email, generates a password, registers and aproves the user, authorizes the new user, sends an email with password to the user
//4. loginAuthoeize - like 3 but uses login and email
//5. allInfo - takes all user's info (including password), registers user and sends an email for aprovement
//6. allInfoAuthorize - takes all user's info (including password), registers user, authorize user, sends an email for information
function register()
{
	global $CORE;
	$CORE->setDebug('user.register.Start','Start');	
	$input = $CORE->getInput(); 
	$config = $CORE->getConfig(); 
	$DS = new DataSource('main');
	$USER = new UserClass();	
	
	//echo 'dddddddddd';
	if(!empty($input['User'.DTR.'Email']))
	{
		$USERSession = new UserSession();
		$registerRS=$USERSession->checkUser($input['User'.DTR.'Email'],$input['User'.DTR.'UserName'],'register');
		$uid = $registerRS['UserID'];
		if(!empty($uid))
		{	
			//update main user fields
			$input['actionMode']='save';
			$input['User'.DTR.'UserID'] = $uid;
			$input['User'.DTR.'Password'] = '';
			$input['User'.DTR.'UserName'] = '';
			$input['User'.DTR.'PermAll'] = '1';
			$where['User'] = "UserID = '".$uid."'";
			if(empty($input['User'.DTR.'UserName']))
			{
				if(!empty($input['UserField'.DTR.'FirstName']))
				{
					$input['User'.DTR.'UserName'] .= $input['UserField'.DTR.'FirstName'];
				}
				if(!empty($input['UserField'.DTR.'LastName']))
				{
					$input['User'.DTR.'UserName'] .= ' '.$input['UserField'.DTR.'LastName'];
				}
				if(!empty($input['UserField'.DTR.'City']))
				{
					$input['User'.DTR.'UserName'] .= ' ('.$input['UserField'.DTR.'City'].')';
				}
			}
			$dsResult = $DS->save($input,$where,'update');
			//print_r($dsResult);
			//login
			$inLogin['Password'] = $registerRS['Password'];
			//if($dsResult['GroupID']=='user')
				$inLogin['Login'] = $registerRS['Email'];
			//else	
			//	$inLogin['Login'] = $registerRS['UserName'];
			$inLogin['redirectionMode'] = 'N'; 
			$inLogin['registrationMode'] = 'N'; 
			
			$resultLogin = doLogin($inLogin);
			//update profile fields
			$user = $CORE->getUser(); 
			//echo 'user data=';
			//print_r($user);
			if(!empty($user['UserID']))
			{
				$FM = new FilesManager();
				$uploadRS = $FM->uploadFile();			
				$USER->setUserField($input,$uploadRS);
			}
			
			if($config['RegistrationIsValidationRequired']=='Y' || $config['RegistrationIsEmailConfirmationRequired']=='Y')
			{
				logout('registered');
				die('');
			}
		}
		else
		{
			if(!empty($input['User'.DTR.'UserName']) || !empty($input['User'.DTR.'Email']))
			{
				$result['Vars']['RegistrationResult'] = 'N';
				$CORE->setMessage('user.register.err.EmailOrLoginExists'); 
			}
		}
	}
	//$refsResult = $DS->query("Region[ParentRegionID='181']",'','Regions');
	//$SERVER->setRefs($refsResult['sql']);
	//if(empty())	
	//$input['GroupID']=$userRS[0]['GroupID'];
	if(empty($input['GroupID'])) {$input['GroupID']='user';}
	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

function getUserFieldsRegister()
{
	global $CORE;
	$CORE->setDebug('user.register.Start','Start');	
	$input = $CORE->getInput(); 
	$config = $CORE->getConfig(); 
	$DS = new DataSource('main');
	$USER = new UserClass();	
	//$refsResult = $DS->query("Region[ParentRegionID='181']",'','Regions');
	//$SERVER->setRefs($refsResult['sql']);
	//if(empty())	
	//$input['GroupID']=$userRS[0]['GroupID'];
	if(empty($input['GroupID'])) {$input['GroupID']='user';}
	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

//type values: 
//1. empty (default) - takes an email, generates a password and sends it to the email for confirmation
//2. login - takes a login and email, generates a password and sends it for aprovement
//3. authorize - takes an email, generates a password, registers and aproves the user, authorizes the new user, sends an email with password to the user
//4. loginAuthoeize - like 3 but uses login and email
//5. allInfo - takes all user's info (including password), registers user and sends an email for aprovement
//6. allInfoAuthorize - takes all user's info (including password), registers user, authorize user, sends an email for information
function registerSite($input)
{
	global $SERVER;
	$SERVER->setDebug('user.register.Start','Start');	
	$input = $SERVER->setInput($input); 
	$DS = new CoreDataSource('session','server');	
	if(!empty($input['User'.DTR.'Email']))
	{
		$USER = new UserSessionServer(&$SERVER,&$DS);
		$type = 'register';
		$uid=$USER->checkSite($input['User'.DTR.'Email'],$input['User'.DTR.'UserName'],$type);
		if(empty($uid))
		{
			$rs = $USER->registerSite($input);
			$retval = $rs['xml'];
		}
		else
		{
			if($input['User'.DTR.'UserName'])
			{
				$retval = '<User><Result>exist</Result></User>';
				$SERVER->setMessage('user.register.err.EmailOrLoginExists'); 
			}
		}
	}
	$config = $SERVER ->getConfig();
	//$USER = new UserSessionServer(&$SERVER,&$DS);
	//echo $USER->getParentOwners($config['OwnerID']);
	$GROUP = new GroupServer(&$SERVER,&$DS);
	$input['viewMode'] = 'OwnerRegistration';
	$GROUP->getGroupsRef($input);
	//$refsResult = $DS->query("Region[ParentRegionID='181']",'','Regions');
	//$SERVER->setRefs($refsResult['sql']);	
	$SERVER->setOutput($retval);
	$SERVER->setDebug('user.register.End','Start');
	return $SERVER->getOutput();
}

function getSiteOwners($input)
{
	global $SERVER;
	$SERVER->setDebug('user.register.Start','Start');	
	$input = $SERVER->setInput($input); 
	$config = $SERVER ->getConfig();
	$DS = new CoreDataSource('session','server');	

	$USER = new UserSessionServer(&$SERVER,&$DS);
	$rs = $USER->getParentOwners($input['SiteID']);

	//$SERVER->setOutput($retval);
	return $SERVER->getOutput("<Owners>".$rs."</Owners>");
}

function confirmRegistration($input)
{
	global $SERVER;
	//$SERVER->setDebug('user.confirmRegistration.Start','Start');	
	$input = $SERVER->setInput($input); 
	$DS = new CoreDataSource('session','server');
	if($input['code'])
	{
		$USER = new UserSessionServer(&$SERVER,&$DS);
		if($USER->confirmRegistration($input['code']))
		{
			$SERVER->setVars('Confirmed','yes');
		}
		else
		{
			$SERVER->setVars('Confirmed','no');
		}
	}
	else
	{
		$SERVER->setMessage('UserSessionServer.confirmRegistration.err.NoUserID');
	}
	$SERVER->setOutput($retval);
	//$SERVER->setDebug('user.confirmRegistration.End','Start');
	return $SERVER->getOutput();	
}

function login($input='')
{
	global $CORE;
	$USER = new UserSession();
	//$sessionID = $CORE->getCurrentSessionID();
	//$USER->setSessionID($sessionID);
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	return '';
}

function doLogin($input='')
{
	global $CORE;
	$USER = new UserSession();
	$sessionID = $CORE->getCurrentSessionID();
	$config = $CORE->getConfig();
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$USER->setSessionID($sessionID);

	if($input['registrationMode']=='Y')
	{
		return register();
	}
	if(!empty($input['Login']))
	{
		//echo "#".$input['Login']."#".$input['Password']."#<br/>";
		$resutl = $USER->login($input['Login'],$input['Password']);	
		//echo $resutl;
		if ($resutl=='session.login.msg.logged')
		{
			$CORE->getSession('update');
			$user = $CORE->getUser();
			//echo 'user';
			//print_r($user);
			if($input['redirectionMode']!='N')
			{
				if($config['ClientType']=='admin')
				{
					$CORE->goLink('homeadmin/');
				}
				elseif($user['GroupID']=='root' || $user['GroupID']=='admin' || $user['GroupID']=='owner')
				{
					$CORE->goLink('homeadminfront/');
				}				
				else
				{
					$CORE->goLink('myhome/');
				}
			}
			return $resutl;
		}
		else
		{
			return $resutl;
		}
	}
	elseif($input['SID']=='login')
	{
		if($config['ClientType']=='admin')
		{
			die($CORE->goLink('loginadmin/'));
		}
		elseif($user['GroupID']=='root' || $user['GroupID']=='admin' || $user['GroupID']=='owner')
		{
			$CORE->goLink('homeadminfront/');
		}				
		else
		{
			die($CORE->goLink('loginform/'));
		}
	}
	return '';
}

function logout($mode='')
{
	global $CORE;
	$config = $CORE->getConfig();
	$input = $CORE->getInput();
	if($mode=='registered')
	{
		$USER = new UserSession();
		$sessionID = $CORE->getCurrentSessionID();
		$USER->setSessionID($sessionID);	
		$USER->logout();	
	
		die($CORE->goLink('registered/'));
	}	
	if($input['actionMode']=='logout')	
	{
		$USER = new UserSession();
		$sessionID = $CORE->getCurrentSessionID();
		$USER->setSessionID($sessionID);	
	
		$USER->logout();	
	

		if($config['ClientType']=='admin')
		{
			//die($CORE->goLink('logoutadmin/'));
			die($CORE->goLink('homeadmin/'));
		}
		else
		{
			//die($CORE->goLink('logoutpage/'));
			//die($CORE->goLink('login/'));
			//die($CORE->goLink('', 'urlroot'));
			die(header('Location: '.setting('rooturl')));
		}		
	}
	return true;
}


function passwordReminder($in='')
{
	global $CORE;
	$input = $CORE->getInput($in);
	$USER = new UserSession();
	if(!empty($input['Email']))
	{
		if($USER->remindPassword($input['Email']))
		{
			$CORE->setMessage('user.remindPassword.msg.PasswordSent');
			$result['Vars']['Result'] = 'Y';
		}
		else
		{
			$CORE->setMessage('user.remindPassword.err.WrongEmail');
			$result['Vars']['Result'] = 'N';
		}
	}
	return $result;
}


function authorizeEvent($in)
{
	global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$USER = new UserSessionServer(&$SERVER,&$DS);
	$input = $SERVER->setInput($in,'fromUser');
	$USER->setSessionID($input['SessionID']);
	//echo 'user.authorizeEvent.eventID='.$input['EventID'].'<br>';
	//echo 'user.authorizeEvent.userID='.$input['UserID'].'<br>';
	if(!empty($input['EventID']))
	{
		$resutl = $USER->authorizeEvent($input['UserID'],$input['EventID']);	
		if ($resutl)
		{
			$retval = $resutl;
			//print_r($retval);
		}
		else
		{
			$retval = '<Result>false</Result>';
			//$SERVER->setMessage('user.login.err.WrongEmailOrPassword');		
		}
	}
	//$retval = '<Resutl>'.$input['Login'].'</Resutl>';
	//$SERVER->setOutput($retval);
	//return $SERVER->getOutput();
	return $retval;
}

function loginWithUserID($input='')
{
	global $CORE;
	$config = $CORE->getConfig();
	if(empty($input)) $input = $CORE->getInput();
	$USER = new UserSession();
	$user = $CORE->getUser();
	
	if($input['UserID'])
	{
		$result = $USER->loginWithUserID($input['UserID']);	
	}

	if(!empty($result) && $config['ClientType']!='admin'){
		if($input['MessageID'] || empty($user['UserID']) || $user['GroupID']=='user'){
			$CORE->goLink("myhomesummary/MessageID/".$input['MessageID']);
		}else{
			$CORE->setSessionVar('AdminID','');
			$url = $config['rooturl'].'adm/'.$config['lang']."/mailboxadm/";
			header("Location: $url");
		}
	}elseif(!empty($result) && $config['ClientType']=='admin'){
		if(!empty($input['MessageID']) || !empty($input['ReceiverID'])){	
			$CORE->goLink("mailboxadm/MessageID/".$input['MessageID']."/ReceiverID/".$input['ReceiverID']);
		}else{
			$CORE->setSessionVar('AdminID',$user['UserID']);
			$url = $config['rooturl'].'france/'.$config['lang']."/my-portfolio/";
			header("Location: $url");
		}
	}	
	return $result;
	/*global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$USER = new UserSessionServer(&$SERVER,&$DS);
	$input = $SERVER->setInput($input);
	$USER->setSessionID($input['SessionID']);
	if($input['UserID'])
	{
		$resutl = $USER->loginWithUserID($input['UserID']);	
		if ($resutl)
		{
			$retval = '<Result>true</Result>';
		}
		else
		{
			$retval = '<Result>false</Result>';
			//$SERVER->setMessage('user.login.err.WrongEmailOrPassword');		
		}
	}
	//$retval = '<Resutl>'.$input['Login'].'</Resutl>';
	$SERVER->setOutput($retval);
	return $SERVER->getOutput();*/
}

function getStatistics()
{
	global $CORE;
	$config = $CORE->getConfig();
	$input = $CORE->getInput();
	$USER = new UserSession();
	$result=$USER->getStatistics();
	return $result;
	
}//function getStatistics()
?>