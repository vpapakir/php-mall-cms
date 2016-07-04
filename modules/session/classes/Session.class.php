<?php
class UserSession
{

    // PRIVATE PROPERTIES
	var $_DS;
	var $_user = array();
	var $_session = array();
	var $_cookie;
	var $_controller;
	var $_remoteAddr;
	var $_config;
	var $_DBX;
	var $_sessionID;
	var $_remoteIP;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function UserSession()
	{
		global $CORE, $HTTP_COOKIE_VARS;
		$this->_controller = &$CORE;
		$this->_cookie = $CORE->getCookies();
		$this->_remoteAddr = $REMOTE_ADDR;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $this->_controller->getConfig();
		$this->_DBX = '';
	}
	
	function setSessionID($sessionID)
	{
		$this->_sessionID = $sessionID;
	}
	// PUBLIC METHODS
	function getSession($remoteIP='')
	{
		$this->_remoteIP = $remoteIP;
		$retval['SessionID'] = $this->sessionCheck();
		$retval['SessionIP'] = $remoteIP;
		$retval['User'] = $this->_user;
		$retval['Vars']	= $this->_session['Vars'];
		return $retval;
	}
	
    /**
	* The main session method. It runs for each client and service. It is used to check rights and permissions rights. 
	*
	* @return 	string 				
    * @access	public
    */	
	function sessionCheck($mode='')
	{
		$config = $this->_config;
		$sessionID = $this->_sessionID;
		$_USER = $this->_user;
		unset($_USER);
		//$expirytime = (string) (time() - $config['CookieTimeout']);
		//echo 'expire='.date('Y-m-d H:i:s',$expirytime);		
		//echo 'sessionin='.$sessionID;
		if (!empty($sessionID)) 
		{
			$sesid = $sessionID;
			if ($mode <>'login') 
			{
				$sessionVarsFieldValue = $this->getUserData($sesid);
				if(!empty($sessionVarsFieldValue) && $sessionVarsFieldValue!='OK')
				{
					$this->_session['Vars'] = $this->unserializeSessionVars($sessionVarsFieldValue);				
				 	$this->_user['SessionVars'] = $this->_session['Vars'];
				}
				if (!$sessionVarsFieldValue) // try to get $_USER and check if sesid exist in the database
				{
					$sesid = $this->sessionNew(); // session id is in cookie but it is not in databse .. so generate a new session id and save it in the database
					$this->_sessionID = $sesid;
					$sessionVarsFieldValue = $this->getUserData($sesid);
					if(!empty($sessionVarsFieldValue) && $sessionVarsFieldValue!='OK')
					{
						$this->_session['Vars'] = $this->unserializeSessionVars($sessionVarsFieldValue);				
						$this->_user['SessionVars'] = $this->_session['Vars'];
					}
					return $sesid;
				}
			}
			else
			{
				$this->_session['Vars'] = $this->getSessionVars();
				$this->_user['SessionVars'] = $this->_session['Vars'];
			}
		}
		else
		{
			//no cookie found
			$sesid = $this->sessionNew();
			$this->_sessionID = $sesid;
			$sessionVarsFieldValue = $this->getUserData($sesid);
			if(!empty($sessionVarsFieldValue) && $sessionVarsFieldValue!='OK')
			{			
				$this->_session['Vars'] = $this->unserializeSessionVars($sessionVarsFieldValue);
				$this->_user['SessionVars'] = $this->_session['Vars'];
			}
							
		}
		return $sesid;
	}
	
	// authorization function
	function sessionNew()
	{
		
		$DBX = $this->_DBX;
 		$config = $this->_config;
		$remoteIP = $this->_remoteIP;
		 mt_srand((double)microtime()*1000000);
		$sesid = mt_rand();
	
		if ($config['IPSessionID'] == 1) 
		{
			//$ip = str_replace('.','',$this->_remoteAddr);
			$sesid = date('YdmHis').md5($remoteIP + $sesid);
		} 
		else
		{
			$sesid = date('YdmHis').md5($sesid);
		}
			
		//start to cleane sessions
		$currtime = (string) (time());
		$expirytime = (string) (time() - $config['CookieTimeout']);
		$deleteSQL = "DELETE FROM ".$DBX."Session WHERE (StartTime < $expirytime) AND StartTime != 11111";//torefact1
		//echo $deleteSQL.' '.date('Y-m-d H:i:s',$expirytime).'<br>';
		$delresult = $this->_DS->query($deleteSQL);
		// end to cleane sessions
	
		//add new session
		$sql = "INSERT INTO ".$DBX."Session (SessionID, StartTime, RemoteIP, SessionUID) VALUES ('$sesid', '$currtime', '$remoteIP', 1)";
		$result = $this->_DS->query($sql);//torefact1
	
		//setcookie($config['CookieName'],$sesid,time() + $config['CookieTimeout']);
		$this->_sessionID = $sesid;
		return $sesid;
	}
	
	// get user data by session ID
	function getUserData($sesid)
	{
		$DBX = $this->_DBX;
		$sql = "SELECT SessionID as \"SessionID\", SessionVars as \"SessionVars\", SessionUID as \"SessionUID\" FROM ".$DBX."Session "
				. " WHERE SessionID='".$sesid."'";//torefact1
		//echo $sql;
		$result = $this->_DS->query($sql);//torefact1
		$B = $result;
		if (count($B) > 0)
		{
		
			if ($B[0]['SessionUID'] != '1')
			{
				$sql = 'SELECT SessionUID as "SessionUID", '.$DBX.'User.UserID as "UserID", '.$DBX.'User.OwnerID as "OwnerID", UserName as "UserName", Email as "Email", '.$DBX.'User.GroupID as "GroupID",
				Status as "Status", PermAll as "PermAll", GroupName as "GroupName", GroupRights  as "GroupRights", Owners  as "Owners", OwnerParentID  as "OwnerParentID" FROM '.$DBX."User, ".$DBX."Session, ".$DBX."UserGroup WHERE ".$DBX."User.GroupID=".$DBX."UserGroup.GroupID AND ".$DBX."Session.SessionUID=".$DBX."User.UserID AND ".$DBX."Session.SessionID='".$sesid."'";
				$result = $this->_DS->query($sql);
				$A = $result;
				//echo $sql;
				if ($A[0]['SessionUID'] != '1' && !empty($A[0]['SessionUID'])) 
				{
					$query = "SELECT * FROM UserFields WHERE UserID='".$A[0]['UserID']."'";
					$rs = $this->_DS->query($query);
					$user = $rs[0];
					$user['UserID']=trim($A[0]['UserID']);
					$user['UserName']=trim($A[0]['UserName']);
					$user['Email']=trim($A[0]['Email']);
					$user['GroupID']=trim($A[0]['GroupID']);
					$user['Status']=trim($A[0]['Status']);
					$user['Type']=trim($A[0]['Type']);
					$user['GroupName']=trim($A[0]['GroupName']);
					$user['GroupRights']=trim($A[0]['GroupRights']);
					$user['Owners']=trim($A[0]['Owners']);
					$user['OwnerParentID']=trim($A[0]['OwnerParentID']);
					$user['OwnerID']=trim($A[0]['OwnerID']);
					$user['PermAll']=trim($A[0]['PermAll']);
					
					/*
					//get User fields
					$query = "SELECT * FROM (UserField LEFT JOIN UserTypeField ON UserField.UserTypeFieldID = UserTypeField.UserTypeFieldID) LEFT JOIN UserTypeOption ON UserTypeField.UserTypeFieldID = UserTypeOption.UserTypeFieldID WHERE UserField.UserID='".$user['UserID']."'";
					$rs = $this->_DS->query($query);
					if(is_array($rs))
					{
						$rsRef = $rs;
						foreach($rs as $row)
						{
							$fieldCode=$row['UserFieldAlias'];
							if($row['UserTypeFieldType']=='checkboxes' || $row['UserTypeFieldType']=='multiple')
							{
								$user[$fieldCode] = $this->getListValue($rsRef,$row['UserFieldValue']);
							}
							elseif($row['UserTypeFieldType']=='radioboxes' || $row['UserTypeFieldType']=='dropdown')
							{
								$user[$fieldCode] = $this->getListValue($rsRef,$row['UserFieldValue']);
							}
							elseif($row['UserTypeFieldType']=='date' || $row['UserTypeFieldType']=='time')
							{
								$user[$fieldCode] = $row['UserFieldValueTime'];
							}		
							elseif($row['UserTypeFieldType']=='number')
							{
								$user[$fieldCode] = $row['UserFieldValueNumber'];
							}																	
							else
							{
								$user[$fieldCode] = $row['UserFieldValue'];
							}				
						}
					}
					*/
					
					$this->_user = $user; $this->_user['SessionVars'] = '';
				}
			}
			if (!empty($B[0]['SessionVars'])) 
			{
				return  $B[0]['SessionVars'];
			} 
			else 
			{
				return 'OK';
			}
		}
		else
		{
			return false;
		}
	
	}

	function getListValue($list,$value,$mode='')
	{
		foreach($list as $row)
		{
			if($mode=='multiple')
			{
				$valueCompare = '|'.$row['UserTypeOptionID'].'|';
				$valueCompare2 = '|'.$row['UserTypeOptionAlias'].'|';
				if(eregi($valueCompare,$value) || eregi($valueCompare2,$value))
				{
					$result['values'][] = $row['UserTypeOptionName'];
				}
			}
			else
			{
				if($row['UserTypeOptionID']==$value || $row['UserTypeOptionAlias']==$value)
				{
					$result = $row['UserTypeOptionName'];
				}
			}
		}
		return $result;
	}

	function getSessionVars()
	{
		$config = $this->_config;
		//$session_vars = $this->_session;
		$DBX = $this->_DBX;
		$sesid = $this->_sessionID;
		$sqlSelect = 'SELECT SessionVars as "SessionVars" FROM '.$DBX."Session WHERE SessionID='".$sesid."'";
		$sessionRS = $this->_DS->query($sqlSelect,'','session');
		$sessionVars = $sessionRS['sql'][0]['SessionVars'];
		//echo 'Sessionvars='.$sessionVars;
		$session_vars['xml'] = $sessionVars;
		//echo "<br>vsite_getsiteconfig<br>";
		$session_vars = $this->unserializeSessionVars($sessionVarsFieldValue);
		return $session_vars;
	}
	
	function serializeSessionVars($input)
	{
		return serialize($input);
	}
	function unserializeSessionVars($sessionVarsFieldValue)
	{
		return unserialize($sessionVarsFieldValue);
		$root = $this->_controller->XML2ARRAY($sessionVarsFieldValue);
		if(is_array($root['SessionVars']['#']))
		{
			foreach ($root['SessionVars']['#'] as $settingName=>$settingValue)
			{
				$settingName = trim($settingName);
				$settingValue = $settingValue[0]['#'];
				$result[$settingName]=$settingValue;
			}
		}
		return $result;
	}

	function sesSetVar($variables)
	{
		global $sesSetVarCount;
		//$this->getSessionVars();
		$DBX = $this->_DBX;
		$sesid = $this->_sessionID;
		//$toupdate = $this->updateSessionVarsXML($varname,$varvalue);
		if(!empty($variables))
		{
			//print_r($variables);
			$toupdate = $this->serializeSessionVars($variables);
			if (!empty($toupdate) && !empty($sesid))
			{
				$sesSetVarCount++;
				$sqlupdate = "UPDATE ".$DBX."Session SET SessionVars='".$toupdate."' WHERE SessionID='".$sesid."'";
				//echo $sqlupdate.'<br>';
				$this->_DS->query($sqlupdate);
			}
		}
	}

	function login($login,$password)
	{
		$DBX = $this->_DBX;
		$sesid = $this->_sessionID;
		$SERVER = &$this->_controller;
		$input = $SERVER->getInput();
		$config = $SERVER->getConfig();
		$loginMode= $input['loginMode'];
		
		if(empty($loginMode))
		{
			if($config['RegistrationIsValidationRequired']=='Y')
			{
				$loginMode = 'validationRequired';
			}
			if($config['RegistrationIsEmailConfirmationRequired']=='Y')
			{
				$loginMode = 'confirmationRequired';
			}
		}
	  if($sesid)
	  {
		$checkpass = md5($password);
		if($loginMode=='confirmationRequired')
		{
			$checksql = 'SELECT UserID as "UserID", UserName as "UserName", Status as "Status" FROM '.$DBX ."User WHERE (UserName='$login' OR Email='$login') AND Password='$checkpass' AND Status='2'";			
		}
		elseif($loginMode=='validationRequired')
		{
			$checksql = 'SELECT UserID as "UserID", UserName as "UserName", PermAll as "PermAll" FROM '.$DBX."User WHERE (UserName='$login' OR Email='$login') AND Password='$checkpass' AND PermAll='1'";			
		}		
		else
		{
			$checksql ='SELECT UserID as "UserID", UserName as "UserName" FROM '.$DBX ."User WHERE (UserName='$login' OR Email='$login') and Password='$checkpass'";
		}
		//echo $checksql;
		$result = $this->_DS->query($checksql);//torefact1
		//print_r($result);
		//echo $checksql;
		//echo 'status'.$result['sql'][0]['UserID'];
		if (count($result[0]) > 0)
		{
			$U = $result[0];
			$sqlupdate = "UPDATE ".$DBX."Session SET SessionUID='".$U['UserID']."' WHERE SessionID='$sesid'";
			//echo 'session='.$U['UserID']  ;		
			$this->_DS->query($sqlupdate);
			//$sesid = $this->sessionCheck();
			//last login update
			$now = $SERVER->getNow();
			$sqlupdateLast = "UPDATE ".$DBX."User SET TimeStart='".$now."' WHERE UserID='".$U['UserID']."'";
			$this->_DS->query($sqlupdateLast);			
			//$this->_controller->setMessage('session.login.msg.logged');
			return 'session.login.msg.logged';
		}
		else
		{
			if($loginMode=='confirmationRequired')
			{
				$checksql2 = 'SELECT UserID as "UserID", UserName as "UserName", Status as "Status" FROM '.$DBX ."User WHERE UserName='$login' AND Password='$checkpass'";									
				$result2 = $this->_DS->query($checksql2);
				if (count($result2)>0 && $result['sql'][0]['Status']!=2)
				{
					$this->_controller->setMessage('session.login.err.confirmationRequired');
					return 'session.login.err.confirmationRequired';
				}
				else
				{	
					$this->_controller->setMessage('session.login.err.wrongPasswordOrLogin');
					return 'session.login.err.wrongPasswordOrLogin';
				}
			}
			elseif($loginMode=='validationRequired')
			{
				$checksql2 = 'SELECT UserID as "UserID", UserName as "UserName", PermAll as "PermAll" FROM '.$DBX ."User WHERE UserName='$login' AND Password='$checkpass'";									
				$result2 = $this->_DS->query($checksql2);
				if (count($result2)>0 && $result2['sql'][0]['PermAll']!=1)
				{
					$this->_controller->setMessage('session.login.err.validationRequired');
					return 'session.login.err.validationRequired';
				}
				else
				{
					$this->_controller->setMessage('session.login.err.wrongPasswordOrLogin');
					return 'session.login.err.wrongPasswordOrLogin';
				}
			}			
			else
			{
				$this->_controller->setMessage('session.login.err.wrongPasswordOrLogin');
				return 'session.login.err.wrongPasswordOrLogin';
			}
			return false;
		}
	  }
	}
	
	function authorizeEvent($userID,$eventID)
	{
		$DBX = $this->_DBX;
		//get event session: check sessionid and if it does not exists make a new sessionid
		$this->_remoteIP= 'eventServer';
	  //	echo 'sessionidIN='.$this->_sessionID.'<br>';		
		$this->sessionCheck();
		$sesid = $this->_sessionID;
		//login event session
		  if(!empty($sesid))
		  {
		  	//echo 'sessionidAfterCheck='.$sesid.'<br>';
			//check eventID
			$inEvent['EventID'] = $eventID;
			$retvalUser = $this->_controller->callService('getEvent','eventServer',$inEvent,'array');
			$eventIDFromServer = $retvalUser['array']['ServiceResponse']['#']['Event'][0]['#']['EventID'][0]['#'];		
			//echo 'EVENTIDREQUEST_RESULT<br>';
			//print_r($retvalUser['array']);
			//echo 'eventIDIn:'.$eventID.'<br>';;
			//echo 'eventIDFromServer:'.$eventIDFromServer.'<br>';;			
			if($eventIDFromServer == $eventID)
			{
				//event is real .. so let's login event and get event's user data
				//echo 'USERID='.$userID.'<br>';
				$checksql = 'SELECT UserID as "UserID", UserName as "UserName" FROM '.$DBX ."User WHERE UserID='$userID'";
				$result = $this->_DS->query($checksql);//torefact1
				if (count($result['sql'][0]) > 0)
				{
					$U = $result['sql'][0];
					$sqlupdate = "UPDATE ".$DBX ."Session SET SessionUID='".$U['UserID']."' WHERE SessionID='$sesid'";
					//echo 'session='.$U['UserID']  ;		
					$this->_DS->query($sqlupdate);
					//$sesid = $this->sessionCheck();
					$this->_controller->setMessage('session.user.msg.loged');
					$this->sessionCheck();
					//echo 'sessionidAfterLogin='.$this->_sessionID.'<br>';
					$retval['SessionID']=$this->_sessionID;
					$retval['User'] = $this->_user;
					$retval['Vars'] = $this->getSessionVars();
					return $retval;					
				}
				else
				{
					$this->_controller->setMessage('session.user.msg.can_not_login');
					return false;
				}
			}//end of if($eventIDFromServer == $eventID)
		  }// end of if($sesid)
	}	
	
	function loginWithUserID($userID)
	{
		$DBX = $this->_DBX;
		$sesid = $this->_sessionID;
		$SERVER = &$this->_controller;
		if(empty($sesid)) $sesid = $SERVER->getSession();
		$sesid = $sesid['SessionID'];
		//$user = $this->_controller->getUser();
		//$this->_controller->setMessage('rights:'.$user['GroupRights'].$user['UserID']);
		//echo $sesid;
		// $U['UserID'] = $userID;
		  if($sesid)
		  {
			//if($this->_controller->hasRights('UserSession.loginWithUserID.loginWithUserID'))
			//{			
				$checksql = 'SELECT UserID as "UserID", UserName as "UserName" FROM '.$DBX ."User WHERE UserID='$userID' ";
				//echo $checksql;
				$result = $this->_DS->query($checksql);//torefact1
				
				if (count($result[0]) > 0)
				{
					$U = $result[0];
					$query = "UPDATE User SET PermAll = '1' WHERE UserID='".addslashes(stripslashes($U['UserID']))."'";
					$this->_DS->query($query);
					$sqlupdate = "UPDATE ".$DBX ."Session SET SessionUID='".addslashes(stripslashes($U['UserID']))."' WHERE SessionID='$sesid'";
					//echo 'session='.$U['UserID']  ;		
					$this->_DS->query($sqlupdate);
					//$sesid = $this->sessionCheck();
					//$this->_controller->setMessage('session.user.msg.loged');
					return $sesid;
				}
				else
				{
					//$this->_controller->setMessage('session.user.msg.can_not_login');
					return false;
				}
			}
		  //}
	}	

	function logout()
	{
		$DBX = $this->_DBX;
		unset ($this->_user);
		$sesid = $this->_sessionID;
		if($sesid)
		{
			$sqlupdate = "UPDATE ".$DBX."Session SET SessionUID='1' WHERE SessionID='".$sesid."'";
		}
		$this->_DS->query($sqlupdate);//torefact1
		//$this->_controller->setMessage('session.user.msg.logout');
	}

	function register($email,$login='',$type='')
	{
		$DBX = $this->_DBX;
		//$this->_controller->setDebug('UserSessionServer.register.Start','Start');		
		$input = $this->_controller->getInput();
		$config = $this->_controller->getConfig();
		$sessionIP = $this->_controller->getRemoteIP();
		$ownerID = $config['OwnerID'];
		//$owners = $this->getParentOwners($ownerID);
		if(empty($login)) {$login=$email;}
		//$core_systemmessage['session.user.msg.registered'] = 'session.user.msg.registered';
		$curtime = date("Y-m-d h:i:s");//torefact1
		$keyID = $this->_controller->getUniqueID();
		//echo 'tttttt='.$sessionIP;
			
		$query = "INSERT INTO User (UserID, UserName, Email, Type, GroupID, IPCreated, TimeCreated, OwnerID, AdminID, OwnerParentID, Owners, PermAll) VALUES ('$keyID','$login', '$email', 1, 1, '$sessionIP', '$curtime', '$ownerID', '$ownerID', '$ownerID', '$owners', 1)";
		$this->_DS->query($query);
		$password = $this->sendPassword($login,'register');// send email with login and password
		//$uid = $this->getUIDFromLogin($login);
		//$this->_controller->setDebug('UserSessionServer.register.End','End');	
		$result['UserID'] = $keyID;		
		$result['Password'] = $password;	
		$result['UserName'] = $login;
		$result['Email'] = $email;
		return $result;
	}

	//torefact1
	function sendPassword($username,$mode)
	{
		$DBX = $this->_DBX;
		$this->_controller->setDebug('UserSessionServer.sendPassword.Start','Start');		
		$input=$this->_controller->getInput();
		$config=$this->_controller->getConfig();
		
		$retval='';
		$result = $this->_DS->query('SELECT UserID as "UserID", UserName as "UserName", GroupID as "GroupID", Email as "Email" FROM '."User WHERE UserName = '$username'");
		$nrows = count($result);
		if ($nrows == 1) 
		{
			if($input['User'.DTR.'Password'] && $mode=='register')
			{
				$passwd2 = md5($input['User'.DTR.'Password']);
				$passwordToSend = $input['User'.DTR.'Password'];
			}
			else
			{
				srand((double)microtime()*1000000);
				$passwd = rand();
				$passwd = md5($passwd);
				$passwd = substr($passwd,1,8);
				$passwd2 = md5($passwd);
				$passwordToSend = $passwd;
			}
			$this->_DS->query("UPDATE ".$DBX."User SET Password='$passwd2' WHERE UserName = '$username'");        
			$email = $result['sql'][0]['Email'];
			$userID = $result['sql'][0]['UserID'];
			$groupID = $input['User'.DTR.'GroupID'];

			$userDataRS = $this->_DS->query("SELECT * FROM User WHERE UserName = '$username'");        
			if(empty($groupID))
			{
				$groupID = $userDataRS[0]['GroupID'];
			}
			
			$userData = $userDataRS[0];
			$userData['Password'] = $passwordToSend;
			
			if($mode=='register')
			{
				$this->_controller->setMessage('UserSession.sendPassword.msg.PasswordSent');								
			
				$emailInput['MailTemplate'] = 'registration.'.$groupID.'.session';
				$emailInputAdmin['MailTemplate'] = 'registrationAdmin.'.$groupID.'.session';
			}
			else
			{
				$emailInput['MailTemplate'] = 'passwordRemind.'.$groupID.'.session';
				$emailInputAdmin['MailTemplate'] = 'passwordRemindAdmin.'.$groupID.'.session';
			}
			
			$emailInput['MailFrom'] = $config['SiteMail'];
			$emailInput['MailFromName'] = $config['SiteName'];
			$emailInput['MailTo']	= $userData['Email'];

			$emailInputAdmin['MailFrom'] = $userData['Email'];
			$emailInputAdmin['MailTo']	= $config['SiteMail'];
			$emailInputAdmin['MailToName']	= $config['SiteName'];			

			//add config variables
			foreach($config as $confVarName=>$confVarValue)
			{
				$emailInput['MailData'][$confVarName] = $confVarValue;
				$emailInputAdmin['MailData'][$confVarName] = $confVarValue;
			}			
			//add user variables
			foreach($userData as $userVarName=>$userVarValue)
			{
				$emailInput['MailData'][$userVarName] = $userVarValue;
				$emailInputAdmin['MailData'][$userVarName] = $userVarValue;
			}	
			//add user fields variables from form or from database
			if($mode=='register')
			{			
				foreach($input as $fieldName=>$fieldVale)
				{
					if(eregi('UserField'.DTR,$fieldName))
					{
						//process Userfield saving
						$fieldCode = str_replace('UserField'.DTR,'',$fieldName);		
						if(!empty($fieldVale))	
						{
							$emailInput['MailData'][$fieldCode] = $fieldVale;
							$emailInputAdmin['MailData'][$fieldCode] = $fieldVale;			
						}
					}
				}
			}
			else
			{
				$userID = $userData['UserID'];
				$userFieldsDataRS = $this->_DS->query("SELECT * FROM UserField WHERE UserID = '$userID'");        
				if(is_array($userFieldsDataRS))
				{
					foreach($userFieldsDataRS as $row)
					{
						$fieldCode = $row['UserFieldAlias'];
						$fieldVale = $row['UserFieldValue'];
						if(empty($fieldVale) && $row['UserFieldValueNumber']!='0.00') {$fieldVale = $row['UserFieldValueNumber'];}
						elseif($row['UserFieldValueTime']!='0000-00-00 00:00:00') {$fieldVale = $row['UserFieldValueTime'];}
						if(!empty($fieldVale))
						{
							$emailInput['MailData'][$fieldCode] = $fieldVale;
							$emailInputAdmin['MailData'][$fieldCode] = $fieldVale;	
						}
					}
				}
			}
			
			$emailInput['MailToName']	= $emailInput['MailData']['FirstName'].' '.$emailInput['MailData']['LastName'];
			$emailInputAdmin['MailFromName'] = $emailInput['MailData']['FirstName'].' '.$emailInput['MailData']['LastName'];
			
			//print_r($emailInput);
			$this->_controller->callService('sendMail','mailServer',$emailInput);
			$this->_controller->callService('sendMail','mailServer',$emailInputAdmin);
		}
		//$this->_controller->setDebug('UserSessionServer.sendPassword.End','End');				
		return $passwordToSend;
	}
	//coreses_sendpassword('admin','register');

	function remindPassword($email)
	{
		$DBX = $this->_DBX;
		//check email
		$sql = 'SELECT UserName as "UserName" FROM User WHERE'." Email='$email'";
		$rs = $this->_DS->query($sql);
		if(!empty($rs[0]['UserName']))
		{
			$this->sendPassword($rs[0]['UserName'],'remindpassword');// send email with login and password
			return true;
		}
		else
		{
			//echo 'false';
			return false;
		}
	}

	function confirmRegistration($userID)
	{
		if($userID)
		{
			$sql = "SELECT UserID as \"UserID\" FROM {dbprefix}User WHERE UserID='$userID'";
			$rs = $this->_DS->query($sql);
			if(count($rs['sql'])>0)
			{
				$sql="UPDATE {dbprefix}User SET Status=2, TimeSaved='".date('Y-m-d H:i:s')."' WHERE UserID='$userID'";
				$this->_DS->query($sql);
				return true;
			}
			else
			{
				$this->_controller->setMessage('UserSessionServer.confirmRegistration.err.NoRecordForThisUser');
				return false;
			}
		}
		else
		{
			$this->_controller->setMessage('UserSessionServer.confirmRegistration.err.NoUserID');
			return false;
		}
	}
		
	function getUIDFromLogin($login,$mode='')
	{
		$DBX = $this->_DBX;
	   	$uid = $this->_DS->getItem($DBX."User","UserID","UserName = '".$login."'");
		if (!$uid)
		{
			if ($mode == 'register')
			{
				return $this->register($login,$login);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return $uid;
		}
	}
	
	function checkUser($email,$login='',$mode='')
	{
		$DBX = $this->_DBX;
		$config=$this->_controller->getConfig();
		$clientType = $config['ClientType'];
		// check username
		if(empty($login)) {$login=$email;}
		$checkUIDRS = $this->_DS->query("SELECT UserID FROM User WHERE UserName = '".$login."' ");
		$uid = $checkUIDRS[0]['UserID'];
		//echo $login;
		if (empty($uid))
		{
			//check email
			if($clientType!='admin' || !empty($email)){
				$checkEmailRS = $this->_DS->query("SELECT UserID FROM User WHERE Email = '".$email."' ");
				$uid_email = $checkEmailRS[0]['UserID'];
			}
			
			if (empty($uid_email))
			{		
				if ($mode == 'register')
				{
					return $this->register($email,$login);
				}
				else
				{
					return false;
				}
			}
			else
			{
				if ($mode == 'register')
				{
					return false;
				}
				else
				{
					return $uid_email;
				}				
			}
		}
		else
		{
			if ($mode == 'register')
			{
				return false;
			}
			else
			{
				return $uid;
			}
		}
	}

	function checkSite($email,$login='',$mode='')
	{
		$DBX = $this->_DBX;
		$DS = $this->_DS;
		// check username
		if(!$login) {$login=$email;}
		$rs = $DS->query("SELECT UserID AS \"UserID\" FROM {dbprefix}User WHERE UserName = '".$login."'");
		return $rs['sql'][0]['UserID'];
	}
	function registerSite($input)
	{
		$DS = $this->_DS;
		$input['actionMode']='save';
		$userName = $input['User'.DTR.'UserName'];
		$email = $input['User'.DTR.'Email'];
		$groupID = $input['User'.DTR.'GroupID'];
		$sessionIP = $input['RemoteIP'];
		$curtime = date("Y-m-d h:i:s");
		$config = $this->_config;
		$ownerID = $config['OwnerID'];		
		$owners = $this->getParentOwners($ownerID);
		$sql = "INSERT INTO {dbprefix}User (UserID, OwnerID, AdminID, UserName, Password, Status, Email, Type, GroupID, IPCreated, TimeCreated, OwnerParentID, Owners) VALUES ('$userName','$userName','$userName','$userName','1','1', '$email', 1, '$groupID', '$sessionIP', '$curtime', '$ownerID', '$owners')";		
		$DS->query($sql);
		$this->sendPassword($userName,'register');// send email with login and password
		$in['User'.DTR.'UserID'] = $userName;
		$rs = $this->getUser($in);
		return $rs;
	}
	
	function getParentOwners($userID,$result='')
	{
		$DS = $this->_DS;
		$config = $this->_config;
		$ownerID = $config['OwnerID'];
		if(empty($result))
		{
			$result = '|'.$userID.'|';
		}
	
		$sql = "SELECT UserID AS \"UserID\", OwnerParentID AS \"OwnerParentID\" FROM {dbprefix}User WHERE UserID='$userID'";
		$rs = $DS->query($sql);
		$newOwnerID = trim($rs['sql'][0]['OwnerParentID']);
		if(!empty($newOwnerID))
		{
			$result .= $newOwnerID.'|';
			return $this->getParentOwners($newOwnerID,$result);
		}
		else
		{
			return $result;
		}
		
	}
	/*
	in: keyid of changed record, userid from the form, email as login
	out: userid, rightsmode, insertmode, forminsert
	
	*/
	function loginEmail($keyid,$uidform,$emaillogin)
	{
		global $core_conf, $_USER, $session_vars, $core_systemmessage;
	
				//echo 'tt='.$keyid . ' ff='.$uidform . 'hhhh='.$session_vars[vars][insertid];
		// case 1: user is loged
		if ($_USER[uid])
		{
			$userid = $_USER[uid];
			if ($session_vars[vars][insertid])
			{
				coreses_setvar('insertid','');
				coreses_setvar('userid','');				
			}
			$retval[userid] =$userid;
			$retval[rightsmode] = '';
			$retval[insertmode] = '';		
			return $retval;
		}
		//case 2: the first insertion of unloged user
		elseif (!$keyid)
		{
			if ($emaillogin)
			{
				$userid = coreses_getuidfromlogin($emaillogin,'register'); // get uid or register and get uid
				coreses_setvar('userid',$userid); // put current id into session to allow to add images with image loader
				//echo 'set session='.$userid;
				//print_r($session_vars);
			}
			else
			{
				$core_systemmessage[editoffer_erremail] = 'offers.edit.err.noemail';
			}
				$retval[userid] =$userid;
				$retval[rightsmode] = 'all';
				$retval[insertmode] = 1;		
				return $retval;		
		}
		// case 3: the unloged user changes new inserted data. The user's id is sent from the form.
		// for secuirity reasons we need to check the edited record id. In this case the user can change only inserted record in previous page
		elseif ($uidform>0 and $session_vars[vars][insertid] == $keyid)
		{
	
			$retval[userid] =$uidform;
			$retval[rightsmode] = 'all';
			$retval[insertmode] = '';
			return $retval;
		}
		// case 4: the user is not login and email is not sent from the form
		else
		{
			//update mode and no session found
			$core_systemmessage[editoffer_err] = 'offers.edit.err.notloged';
		}	
	}
	
	function sendRegistrationEmail($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$SERVER->setDebug('UserSession.sendRegistrationEmail.Start','Start');
		$SERVER = &$this->_controller;
		$user=$SERVER->getUser();
		if(!empty($input['RegistrationEmail']))
		{
			$userIDbyEmailRS = $DS->query("SELECT UserID, UserName, GroupID, Email FROM {dbprefix}User WHERE Email='".$input['RegistrationEmail']."'"); 			
			$userID = $userIDbyEmailRS['sql'][0]['UserID'];
			$userName = $userIDbyEmailRS['sql'][0]['UserName'];
			$groupID = $userIDbyEmailRS['sql'][0]['GroupID'];
			$email = $userIDbyEmailRS['sql'][0]['Email'];
			if(empty($userID))
			{
				return false;
			}
		}
		else
		{
			$userID =$user['UserID'];
			$userName = $user['UserName'];
			$groupID = $user['GroupID'];
			$email = $user['Email'];			
		}
		if(!empty($userID))
		{
			if(empty($groupID)) {$groupID = 1;}
			$xml = '<'.'Content'.'>'  . LB;
			$xml .= '<'.'UserID'.'>'.'<![CDATA['.$userID.']]>'.'</'.'UserID'.'>' . LB;
			$xml .= '<'.'UserName'.'>'.'<![CDATA['.$userName.']]>'.'</'.'UserName'.'>' . LB;
			$xml .= '<'.'Password'.'>'.'<![CDATA[***]]>'.'</'.'Password'.'>' . LB;
			$xml .= '<'.'Email'.'>'.'<![CDATA['.$email.']]>'.'</Email'.'>' . LB;
			$xml .= '</'.'Content'.'>'  . LB;
			$mailIN['MailTemplate'] ='session/register'.$groupID; 
			$mailIN['MailTo'] = $email;
			$mailIN['MailToName'] = $userName;
			$mailIN['MailData'] =$xml; 
			$SERVER->callService('sendMail','mailServer',$mailIN);
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getStatistics()
	{
		 $SERVER = &$this->_controller;
		 $DS = &$this->_DS;
		 $SERVER->setDebug('UserSession.sendRegistrationEmail.Start','Start');
		 $query="SELECT count(SessionID) FROM Session,User where SessionUID!='1' and SessionUID=UserID";
		 $result=$DS->query($query);
		 $query="SELECT count(UserID)-1 FROM User";
		 $res=$DS->query($query);
		 //$SERVER->callService('sendMail','mailServer',$mailIN);
		 $rs['regCount']=$result[0]['count(SessionID)'];
		 $rs['regAll']=$res[0]['count(UserID)-1'];
		 return $rs;
	}//function getStatistics()

} // end of UserSession


?>