<?php
function manageUsers($input='')
{
	global $CORE;
	$DS = new DataSource('main');	
	if(empty($input)) $input = $CORE->getInput();
	
	$config = $CORE->getConfig();
	$ownerID = $config['OwnerID'];
	$USER = new UserClass();
	
	if($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['User'.DTR.'UserID']))
		{
			foreach($input['User'.DTR.'UserID'] as $id=>$value)
			{
				if($input['User'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['User'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['User'.DTR.'PermAll'] = 1;
					$oldRS = $DS->query("SELECT PermAll FROM User WHERE UserID='".$input['User'.DTR.'UserID'][$id]."'");
					if($$oldRS[0]['PermAll']=='4')
					{
						$USER->sendEmailToUser('validation',$input['User'.DTR.'UserID'][$id]);
					}
				}
				$inputSave['User'.DTR.'UserID'] = $input['User'.DTR.'UserID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['User'] = "UserID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Resource'.DTR.'ResourceID'].' perm='.$inputSave['Resource'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}
	elseif($input['actionMode']=='add')
	{
		//print_r($input);
		//print_r($_SERVER);
		if(!empty($input['UserField'.DTR.'FirstName']) || !empty($input['UserField'.DTR.'LastName'])){
			if (!empty($input['User'.DTR.'Email'])) 
			{
				$input['User'.DTR.'UserName'] = $input['User'.DTR.'Email'];
			}
			else 
			{
				$input['User'.DTR.'UserName'] = $input['UserField'.DTR.'LastName'].'.'.date('YmdHis').'@'.$_SERVER['HTTP_HOST'];
			}
			//$input['User'.DTR.'UserName'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];
			$ckUsr = $DS->query("SELECT UserID FROM User WHERE UserName = '".$input['User'.DTR.'UserName']."' ");
			//echo "_#_".$input['User'.DTR.'UserName']."_#_";
			if(!empty($ckUsr[0]['UserID']))
				$input['User'.DTR.'UserName'] = "";
			else
				$CORE->setInputVar('User'.DTR.'UserName',$input['User'.DTR.'UserName']);
		}
		
		if((!empty($input['User'.DTR.'Email']) && $input['registerMode']=='register') || (!empty($input['User'.DTR.'UserName']) && $config['ClientType']=='admin'))
		{
			$FM = new FilesManager();
			$uploadRS = $FM->uploadFile();
				
			$USERSession = new UserSession();
			$registerRS=$USERSession->checkUser($input['User'.DTR.'Email'],$input['User'.DTR.'UserName'],'register');
			$uid = $registerRS['UserID'];
			if(!empty($uid))
			{
				$input['UserID'] = $uid;
				$input['User'.DTR.'UserID'] = $uid;
				$input['actionMode']='save';
				
				$USER->setUser($input);
				$USER->setUserField($input,$uploadRS);	
				$userRS = $USER->getUser($input);
				$result['DB']['User'] = $userRS;	
				$result['UserID'] = $registerRS['UserID'];		
			}
			else
			{
				$CORE->setMessage('user.register.err.EmailOrLoginExists');
			}
		}

	}	
	elseif($input['actionMode']=='save')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
	
		$USER->setUser($input);
		$USER->setUserField($input,$uploadRS);
	}	
	elseif($input['actionMode']=='delete')
	{
		$USER->deleteUser($input);
	}	
	
	if($input['registerMode']!='register' &&  (!empty($input['UserID']) || !empty($input['User'.DTR.'UserID']) ))
	{
		$userRS = $USER->getUser($input);
		$result['DB']['User'] = $userRS;
		$input['GroupID']=$userRS[0]['GroupID'];
	}

	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	$rs = $USER->getUsers($input);
	
	$result['DB']['Users'] =$rs['result'];
	$result['pages']['Users'] = $rs['pages'];	
	
	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}


function getUsersByGroup()
{
	global $CORE;
	$DS = new DataSource('main');	
	$input = $CORE->getInput();
	
	$config = $CORE->getConfig();
	$ownerID = $config['OwnerID'];
	$USER = new UserClass();
	
	$inputGet['orderField'] = 'UserName';
	$inputGet['PermAll'] = '1';
	$inputGet['ItemsPerPage'] = '1000';
	if(!empty($input['Groups']))
	{
		$groups = explode(",",$input['Groups']);
		if(is_array($groups))
		{
			$i=0;
			foreach($groups as $group)
			{
				if(!empty($group))
				{
					$inputGet['GroupID'] = $group;
					$rs = $USER->getUsers($inputGet);
					$result['DB']['Users'][$group] = $rs['result'];
				}
			}
		}
	}	

	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	
	return $result;
}


function getUsersTree($in)
{
	global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$SERVER->setDebug('sgame.Users.Start','Start');
	$input = $SERVER->setInput($in,'fromUser');
	$where['User'] = "UserID = '".$input['User'.DTR.'UserID']."'";
	$saveResult = $DS->save($input,$where);	
	$config = $SERVER->getConfig();
	$ownerID = $config['OwnerID'];
	//$xcmsq = "User[TimeCreated > '2002-11-11' AND UserID LIKE '%2%']/";
	$searchWord = $input['searchWord'];


	$GROUP = new GroupServer(&$SERVER,&$DS);
	//$input['viewMode'] = 'OwnerRegistration';
	$GROUP->getGroupsRef($input);

	$UserServer = new UserServer(&$SERVER,&$DS);
	$retval = $UserServer->getUsersTree($input);
	$SERVER->setOutput($retval);
	
	//$refsResult = $DS->query('Status','','localRefs');
	//$SERVER->setRefs($refsResult['sql']);
	//$refsResult = $DS->query('PermAll','','localRefs');
	//$SERVER->setRefs($refsResult['sql']);	
		
	$retval = $SERVER->getOutput();
	$SERVER->setDebug('sgame.Users.End','End');
	return $retval;
}


function getUsers($in)
{
	global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$SERVER->setDebug('user.getUsers.Start','Start');
	$input = $SERVER->setInput($in);
	$searchWord = $input['searchWord'];
	$search = '';
	if(!empty($input['GroupID']))
	{
		$search .= " AND GroupID='".$input['GroupID']."' ";
	}
	if(!empty($input['searchWord']))
	{
		$search .= " AND (Email LIKE '%$searchWord%' OR UserName LIKE '%$searchWord%' OR FirstName LIKE '%$searchWord%' OR LastName LIKE '%$searchWord%')";
	}
	$xcmsq = "User[UserID>'1'".$search."]/";
	$dsResult = $DS->query($xcmsq,$searchIn);
	$retval = $dsResult['xml'];
	$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput();
	$SERVER->setDebug('user.getUsers.End','End');
	return $retval;
}

function getSubscribedUsers($in)
{
	global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$SERVER->setDebug('user.getSubscribedUsers.Start','Start');
	$input = $SERVER->setInput($in);
	$search = '';
	if($in['GroupID'])
	{
		$search .= " AND GroupID='".$input['GroupID']."' ";
	}
	$xcmsq = "User[select(UserID,Email,UserName,FirstName,LastName,SecondName,Gender,EmailFormat),UserID>'1' AND OptIn<>'N'".$search."]/";
	$searchIn['pagesMode'] = $input['pagesMode'];
	if(empty($searchIn['pagesMode'])) {$searchIn['pagesMode']=100;}
	$dsResult = $DS->query($xcmsq,$searchIn);
	$retval = $dsResult['xml'];
	$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput();
	$SERVER->setDebug('user.getSubscribedUsers.End','End');
	return $retval;
}

function getUsersByList($in)
{
	global $SERVER;
	$DS = new CoreDataSource('session','server');	
	$SERVER->setDebug('user.getSubscribedUsers.Start','Start');
	$input = $SERVER->setInput($in);
	$USER = new UserSessionServer(&$SERVER,&$DS);
	$result = $USER->getUsersByList($input);
	$retval = $result['xml'];
	//$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput($retval);
	$SERVER->setDebug('user.getSubscribedUsers.End','End');
	return $retval;
}

function manageUser($in)
{
	global $SERVER;
	$SERVER->setDebug('sgame.User.Start','Start');
	$input = $SERVER->setInput($in,'fromUser');
	$DS = new CoreDataSource('session','server');
	
	//print_r($input);
	$input['User'.DTR.'UserName']='';
	$input['User'.DTR.'GroupID']='';
	if(!empty($input['User'.DTR.'Password']))
	{
		$input['User'.DTR.'Password'] = md5($input['User'.DTR.'Password']);
	}		
	$where['User'] = "UserID = '".$input['User'.DTR.'UserID']."'";
	$saveResult = $DS->save($input,$where);
	if($saveResult and !$input['User'.DTR.'UserID'])	
	{
		$retval = $saveResult['xml'];
	}
	else
	{
		$UserID = $input['User'.DTR.'UserID'];
		$xcmsq = "User[UserID='$UserID']/";
		$dsResult = $DS->query($xcmsq,$input);
		$retval = $dsResult['xml'];
	}
	$refsResult = $DS->query('Status','','localRefs');
	$SERVER->setRefs($refsResult['sql']);
	
	$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput();
	//echo $retval;
	$SERVER->setDebug('sgame.User.End','End');
	return $retval;
}

function setUserLanguage($in)
{
	global $SERVER;
	$SERVER->setDebug('sgame.setUserLanguage.Start','Start');
	$input = $SERVER->setInput($in,'fromUser');
	$DS = new CoreDataSource('session','server');
	$USER = new UserSessionServer(&$SERVER,&$DS);
	$USER->setUserLanguage($input);	
	$retval = $SERVER->getOutput();
	//echo $retval;
	$SERVER->setDebug('sgame.setUserLanguage.End','End');
	return $retval;
}

function setUserStatus($in)
{
	global $SERVER;
	$SERVER->setDebug('sgame.setUserLanguage.Start','Start');
	$input = $SERVER->setInput($in,'fromUser');
	$DS = new CoreDataSource('session','server');
	$USER = new UserSessionServer(&$SERVER,&$DS);
	$USER->setUserStatus($input);	
	$retval = $SERVER->getOutput();
	//echo $retval;
	$SERVER->setDebug('sgame.setUserLanguage.End','End');
	return $retval;
}

function getProfile()
{
	global $CORE;
	$CORE->setDebug('sgame.User.Start','Start');
	$input = $CORE->getInput();
	$DS = new DataSource('main');	
	$USER = new UserClass();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//print_r($input);
	
	if($CORE->hasRights('admin'))
	{
		if(!empty($input['UserID']))
		{
			$input['User'.DTR.'UserID']=$input['UserID'];
		}
		elseif(!empty($input['ReceiverID']))
		{
			$input['User'.DTR.'UserID']=$input['ReceiverID'];
		}
		elseif(!empty($input['User'.DTR.'UserID']))
		{
			$input['User'.DTR.'UserID'] = $input['User'.DTR.'UserID'];
		}
		else
		{
			$input['User'.DTR.'UserID'] = $user['UserID'];
		}
	}
	else
	{
		$input['User'.DTR.'UserID']=$user['UserID'];
	}
	$input['User'.DTR.'UserName']='';
	$input['User'.DTR.'GroupID']='';	
	
	$userRS = $USER->getUser($input);
	$result['DB']['User'] = $userRS;
	$input['GroupID']=$userRS[0]['GroupID'];
	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	
	if($config['ClientType']=='admin')
	{
		$result['DB']['Administrators'] = $USER->getAdministratorsList($input);
	}	

	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	
	return $result;
}

function manageProfile()
{
	global $CORE;
	$CORE->setDebug('sgame.User.Start','Start');
	$input = $CORE->getInput();
	$DS = new DataSource('main');	
	$USER = new UserClass();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//print_r($input);
	if($CORE->hasRights('admin'))
	{
		$userID = $input['User'.DTR.'UserID'];
		if(empty($userID)) {$userID = $input['UserID'];}
	}	
	if(!empty($userID))
	{
		$input['User'.DTR.'UserID']=$userID;
	}
	else
	{
		if($input['registerMode']!='register')
		{
			$input['User'.DTR.'UserID']=$user['UserID'];
		}
	}
	//$input['User'.DTR.'UserName']='';
	$input['User'.DTR.'GroupID']='';
	
	if($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if($input['registerMode']=='register' && $input['actionMode']=='add')
		{
			$USERSession = new UserSession();
			$registerRS=$USERSession->checkUser($input['User'.DTR.'Email'],$input['User'.DTR.'UserName'],'register');
			$uid = $registerRS['UserID'];
			$input['User'.DTR.'UserID'] = $uid;
		}
		
		$USER->setUser($input);
		
		$USER->setUserField($input,$uploadRS);	
	}
	
	if($input['registerMode']!='register')
	{
		$userRS = $USER->getUser($input);
		$result['DB']['User'] = $userRS;
		$input['GroupID']=$userRS[0]['GroupID'];
	}
	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	
	$result['DB']['ReservationOrders'] = $USER->getReservationOrders($input);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if($config['ClientType']=='admin')
	{
		$result['DB']['Administrators'] = $USER->getAdministratorsList($input);
	}
	
	return $result;
}

function getUserData($in='')
{
	global $CORE;
	$CORE->setDebug('sgame.User.Start','Start');
	$input = $CORE->setInput($in,'fromUser');
	$DS = new DataSource('main');	
	$user = $CORE->getUser();
	$USER = new UserClass();
	$UserID = $input['UserID'];
	$userName = $input['UserName'];
	if(!empty($UserID))
	{
		$query = "SELECT UserID,Email,UserName,GroupID,PermAll FROM User WHERE UserID='$UserID'";
	}
	elseif(!empty($userName))
	{
		$query = "SELECT UserID,Email,UserName,GroupID,PermAll FROM User WHERE UserName='$userName'";		
	}
	$dsResult = $DS->query($query);
	
	$result['DB']['User'] = $dsResult;
	
	//$userFieldsRS = $USER->getUserFields($input);
	//$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	return $result;
}

function getUserDataField($input='')
{
	global $CORE;
	$CORE->setDebug('sgame.User.Start','Start');
	if(empty($input)) $input = $CORE->getInput();
	$DS = new DataSource('main');	
	$user = $CORE->getUser();
	$USER = new UserClass();
	$UserID = $input['UserID'];
	$userName = $input['UserName'];
	//print_r($input);
	if(!empty($UserID))
	{
		$query = "SELECT UserID,Email,UserName,GroupID,PermAll FROM User WHERE UserID='$UserID'";
	}
	elseif(!empty($userName))
	{
		$query = "SELECT UserID,Email,UserName,GroupID,PermAll FROM User WHERE UserName='$userName'";		
	}
	$dsResult = $DS->query($query);
	
	$result['DB']['User'] = $dsResult;
	
	$userFieldsRS = $USER->getUserFields($input);
	$result['DB']['UserField'] = $userFieldsRS['UserField'];
	
	return $result;
}

/**
* 
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/

function buyMembership($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('session.buyMembership.Start','Start');	
	$input = $SERVER->setInput($in,'fromUser');
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('session','server');
	$USER = new UserSessionServer(&$SERVER,&$DS);
	//get content
	$sessionServiceRS = $USER->buyMembership($input);
	//$SERVER->setOutput($datingProfileRS['xml']);	
	//get refs
	//get result
	$returnValue = $SERVER->getOutput($sessionServiceRS['xml']);
	$SERVER->setDebug('session.buyMembership.End','End');
	return $returnValue;
}

function sendRegistrationEmail($in)
{
	global $SERVER;
	$SERVER->setDebug('UserSession.sendRegistrationEmail.Start','Start');
	$input = $SERVER->setInput($in,'fromUser');
	$DS = new CoreDataSource('session','server');
	$USER = new UserSessionServer(&$SERVER,&$DS);
	if($input['actionMode']=='send')
	{
		if($USER->sendRegistrationEmail($input))
		{
			$SERVER->setVars('Result','true');
		}
		else
		{
			$SERVER->setVars('Result','false');	
			$SERVER->setMessage('session.sendRegistrationEmail.err.WrongEmail');
		}
	}
	$retval = $SERVER->getOutput();
	return $retval;
}

function getUserByEmail($input='')
{
	global $CORE;
	$DS = new DataSource('main');	
	$input = $CORE->getInput();
	
	if(!empty($input['User'.DTR.'Email'])){
		$query = "SELECT UserID,Email,UserName,GroupID,PermAll FROM User WHERE Email='".$input['User'.DTR.'Email']."'";
	}
	
	$result = $DS->query($query);
	return $result;
}

?>