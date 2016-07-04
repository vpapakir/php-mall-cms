<?php
class UserClass
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
	function UserClass()
	{
		global $CORE, $HTTP_COOKIE_VARS;
		$this->_controller = &$CORE;
		$this->_cookie = $CORE->getCookies();
		$this->_remoteAddr = $REMOTE_ADDR;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $CORE->getConfig();
		$this->_user = $CORE->getUser();
		$this->_DBX = '';
		$this->userFieldsDataMode = 'tables';
	}

	function getUsersByList($input)
	{
		$DS = &$this->_DS;
		if(count($input['UsersRequest'])>1)
		{
			$usersIDs = implode("','", $input['UsersRequest']);
			$usersIDs = "'".$usersIDs."'";
		}
		elseif(count($input['UsersRequest'])==1)
		{
			$usersIDs = "'".$input['UsersRequest']."'";
		}
		$query = 'SELECT UserID as "User'.DTR.'UserID", UserName as "User'.DTR.'UserName", Email as "User'.DTR.'Email", Lang as "User'.DTR.'Lang", EmailFormat as "User'.DTR.'EmailFormat" '."  FROM {dbprefix}User WHERE UserID IN (".$usersIDs.")";
		$mode['resultMode'] = 'xml';
		$result = $DS->query($query,$mode);
		return $result;		
	}
	
    function getReservationOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrders.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
	
		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderID>0 $filter ORDER BY ReservationOrderID DESC";

		$result = $DS->query($query); 
		$SERVER->setDebug('ReservationOrderClass.getReservationOrders.End','End');
		return $result;
	}		
	
	function setUserLanguage($input)
	{
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		$lang = $input['Language'];
		if(!empty($userID))
		{
			$sql = "UPDATE {dbprefix}User SET Lang = '$lang' WHERE UserID='$userID'";
			$DS->query($sql);
		}
	}

	function setUserStatus($input)
	{
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser();
		$userID = $input['UserID'];
		$permAll = $input['PermAll'];
		$status = $input['Status'];		
		if(!empty($userID))
		{
			if(!empty($permAll))
			{
				$sql = "UPDATE {dbprefix}User SET PermAll = '$permAll' WHERE UserID='$userID'";
			}
			if(!empty($status))
			{
				$sql = "UPDATE {dbprefix}User SET Status = '$status' WHERE UserID='$userID'";
			}	
			if(!empty($sql))		
			{
				$DS->query($sql);
			}
		}
	}


	function setUser($input)
	{
		$DS = $this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser();
		//print_r($input);
		if($SERVER->hasRights('admin'))
		{
			$userID = $input['UserID'];
			if (empty($userID)) {$userID = $input['User'.DTR.'UserID'];}
		}
		if(empty($userID) && $input['registerMode']!='register')
		{
			$userID = $user['UserID'];
		}
		
		$oldEmailRS = $DS->query("SELECT Email as \"Email\" FROM User WHERE UserID='".$user['UserID']."'"); 
		if(!empty($input['User'.DTR.'Email']) && !$SERVER->hasRights('admin'))
		{
			if($input['User'.DTR.'Email']!=$oldEmailRS[0]['Email'])
			{
				$input['User'.DTR.'Status']=1;
				//$USER->sendRegistrationEmail($input);
				//$SERVER->setMessage('session.profile.msg.RegistrationEmailSent');
			}
		}
		if($oldEmailRS[0]['PermAll']==4 && $input['User'.DTR.'PermAll']==1)
		{
			$this->sendEmailToUser('validation',$userID);
		}
		
		$err='N';
				
		if(!empty($userID))
		{
			if(empty($input['User'.DTR.'Email'])){
				$checkRS = $DS->query("SELECT UserID FROM User WHERE UserName='".$input['User'.DTR.'UserName']."'");
			}else{
				$checkRS = $DS->query("SELECT UserID FROM User WHERE UserName='".$input['User'.DTR.'UserName']."' OR Email = '".$input['User'.DTR.'Email']."'");
			}
			
			$checkUserID = $checkRS[0]['UserID'];
			if(!empty($checkUserID))
			{
				//echo '$userID='.$userID.' $checkUserID='.$checkUserID ;
				
				if($input['actionMode']=='save')
				{
					//echo $userID."_#_".$checkUserID; 
					if($userID!=$checkUserID)
					{
						$err='Y';
						$SERVER->setMessage('UserClass.setUser.err.UserNameOrEmailAlreadyUsed');
					}
				}
				else
				{
					if(count($checkRS)>1)
					{
						$err='Y';
						$SERVER->setMessage('UserClass.setUser.err.UserNameOrEmailAlreadyUsed');
					}
				}
			}
		}
		
		if(!empty($userID) && $err=='Y'){
			$ckUsr = $DS->query("SELECT * FROM User WHERE UserID = '".$input['User'.DTR.'UserID']."' ");
			if($ckUsr[0]['UserName']==$input['User'.DTR.'UserName']) 
				$err = "N";
			else{
				$ckUsrName = $DS->query("SELECT * FROM User WHERE UserName = '".$input['User'.DTR.'UserName']."' ");
				if(empty($ckUsrName[0]['UserName'])){
					$err = "N";
				}else{
					$err = "Y";
					$SERVER->setMessage('UserClass.setUser.err.UserNameOrEmailAlreadyUsed');
				}
			}
				
		}
		
		if(!empty($input['User'.DTR.'Password']))
		{
			$input['User'.DTR.'Password'] = md5($input['User'.DTR.'Password']);
		}
		if($err!='Y')
		{
			//if($input['SID']==''){$input['User'.DTR.'GroupID'] = 'user';}
			//print_r($input);
			if(empty($input['User'.DTR.'GroupID'])){$input['User'.DTR.'GroupID'] = 'user';}
			
			
			$where['User'] = "UserID = '".$userID."'";
			$input['actionMode']='save';
			$saveResult = $DS->save($input,$where);
			//$this->updateSerializedUserFields($userID);
		}
		return $saveResult;
	}

	function updateSerializedUserFields($UserID)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($UserID))
		{
			$input['UserID'] = $UserID;
			$rs = $this->getUserFields($input);
			//echo '<textarea cols=50 rows=50>';
			//print_r($rs);
			//echo '</textarea>';
			$UserFields = serialize($rs);
			$UserFields = $SERVER->cleanString($UserFields,'noquotes');
			//echo "UPDATE User SET UserFields = '$UserFields' WHERE UserID='$UserID'";
			$DS->query("UPDATE User SET UserFields = '$UserFields' WHERE UserID='$UserID'");
		}
	}

	function setUserField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserClass.setUserField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['User'.DTR.'UserID'];
		if(empty($entityID)) {$entityID = $input['UserID'];}	
			
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserFieldServer.adminUserField');
		//set queries	
		
		$groupsIDRS = $DS->query("SELECT GroupID FROM User WHERE UserID = '$entityID' ");
		$groupID = $groupsIDRS[0]['GroupID'];
		
		if(!empty($entityID))
		{
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('UserField'.DTR,$fieldName))
				{
					//process propertyfield saving
					$fieldCode = str_replace('UserField'.DTR,'',$fieldName);
					//get the field type
					//$entityType
					
					$fieldInfoRS = $DS->query("SELECT UserGroupID,UserTypeFieldID, UserTypeFieldType, UserTypeFieldPosition, UserTypeFieldName, UserTypeFieldAlias FROM UserTypeField WHERE UserTypeFieldAlias = '$fieldCode' AND UserGroupID ='$groupID' ");
					$fieldType = $fieldInfoRS[0]['UserTypeFieldType'];
					$fieldTypeID = $fieldInfoRS[0]['UserTypeFieldID'];
					$fieldTypePosition = $fieldInfoRS[0]['UserTypeFieldPosition'];
					$fieldTypeMode = $fieldInfoRS[0]['UserTypeFieldMode'];
					$fieldTypeName = $fieldInfoRS[0]['UserTypeFieldName'];
					$fieldTypeMode = $fieldInfoRS[0]['UserTypeFieldMode'];
					$filedUserGroupID = $fieldInfoRS[0]['UserGroupID'];
					$filedTable = "UserFields";
	
					//format the field for respective field type
					if(is_array($fieldVale))
					{
						//transfrom for checkboxes or language field
						$k=1;
						$fieldValeResult='';
						foreach($fieldVale as $itemCode=>$itemValue)
						{
							if($fieldType=='checkboxes' && !empty($itemValue))
							{
								if($k==1)
								{
									$fieldValeResult .= "|$itemValue|";
									$k++;
								}
								else
								{
									$fieldValeResult .= "$itemValue|";
								}
							}
							elseif($fieldType=='text' || $fieldType=='input')
							{
								$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
							}
						}
						$fieldVale = $fieldValeResult;
					}
					//check if there is a record for this reource
					$keyFieldName = $filedTable.'ID';
					$checkRS = $DS->query("SELECT ".$keyFieldName."  FROM $filedTable WHERE UserID='$entityID'");
					$userFieldID = $checkRS[0][$keyFieldName];
					
					if(!empty($userFieldID))
					{
						//udpate
						$query = "UPDATE ".$filedTable." SET UserID='$entityID',".$fieldCode."='".$fieldVale."' WHERE ".$keyFieldName."='".$userFieldID."'";
					}
					else
					{
						//insert
						$keyFieldNewValue = $SERVER->getUniqueID();
						$query = "INSERT INTO ".$filedTable." (".$keyFieldName.",UserID,".$fieldCode.") VALUES ('".$keyFieldNewValue."','$entityID','".$fieldVale."')";					
					}
					//echo $query.'<br>';
					$DS->query($query);
					if(empty($userFieldID))
					{
						$userFieldID = $DS->dbLastID();	
					}
					
				}
			}
		}
		//if(!empty($input['UserField'.DTR.'UserFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'UserField',$input['UserField'.DTR.'UserID'],'User');
		//}		
		$SERVER->setDebug('UserClass.setUserField.End','End');		
		return $result;		
	}	

		
	function setUserFieldNoExtraTable($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserFieldClass.setUserField.Start','Start');
		$DS = &$this->_DS;	
		$config = $SERVER->getConfig();
		$user = $SERVER->getUser();
		//$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		
		if($SERVER->hasRights('root') || $SERVER->hasRights('admin'))
		{
			$userID = $input['UserID'];
			if(empty($userID)) {$userID = $input['User'.DTR.'UserID'];}	
		}
		if(empty($userID))
		{
			$userID = $user['UserID'];
		}
		$entityID = $userID;
		//echo 'userID='.$entityID;
		//print_r($user);
		//set queries	
		$groupsIDRS = $DS->query("SELECT GroupID FROM User WHERE UserID = '$entityID' ");
		$groupID = $groupsIDRS[0]['GroupID'];
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('UserField'.DTR,$fieldName))
			{
				//process Userfield saving
				$fieldCode = str_replace('UserField'.DTR,'',$fieldName);
				//get the field type
				//$entityType
				$fieldInfoRS = $DS->query("SELECT UserTypeFieldID, UserTypeFieldType, UserTypeFieldPosition, UserTypeFieldName, UserTypeFieldAlias FROM UserTypeField WHERE UserTypeFieldAlias = '$fieldCode' AND UserGroupID='$groupID' ");
				$fieldType = $fieldInfoRS[0]['UserTypeFieldType'];
				$fieldTypeID = $fieldInfoRS[0]['UserTypeFieldID'];
				$fieldTypePosition = $fieldInfoRS[0]['UserTypeFieldPosition'];
				//$fieldTypeMode = $fieldInfoRS[0]['UserTypeFieldMode'];
				$fieldTypeName = $fieldInfoRS[0]['UserTypeFieldName'];
				$fieldTypeMode = $fieldInfoRS[0]['UserTypeFieldMode'];
				//format the field for respective field type
				if(is_array($fieldVale))
				{
					//transfrom for checkboxes or language field
					$k=1;
					$fieldValeResult='';
					foreach($fieldVale as $itemCode=>$itemValue)
					{
						if($fieldType=='checkboxes')
						{
							if($k==1)
							{
								$fieldValeResult .= "|$itemValue|";
								$k++;
							}
							else
							{
								$fieldValeResult .= "$itemValue|";
							}
						}
						elseif($fieldType=='text')
						{
							$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
						}
					}
					$fieldVale = $fieldValeResult;
				}
				//check if there is a value
				$checkRS = $DS->query("SELECT UserFieldID FROM UserField WHERE UserID='$entityID' AND UserFieldAlias='$fieldCode'");
				$UserFieldID = $checkRS[0]['UserFieldID'];

				if($fieldType=='number')
				{
					$valueFieldName = 'UserFieldValueNumber';
				}
				elseif($fieldType=='time' || $fieldType=='date')
				{
					$valueFieldName = 'UserFieldValueTime';
				}
				else
				{
					$valueFieldName = 'UserFieldValue';
				}

				if($fieldVale=='image' || $fieldVale=='file')
				{
					if(!empty($uploadRS[$fieldCode]['file']))
					{
						$fieldVale= $uploadRS[$fieldCode]['file'];
					}		
					else
					{
						$fileFieldRS = $DS->query("SELECT UserFieldValue FROM UserField WHERE UserFieldID='$UserFieldID'");
						$fieldVale=$fileFieldRS[0][$valueFieldName];
					}				
				}
				
				if($fieldVale=='deletefieldfile')
				{
					if(!empty($UserFieldID))
					{
						$FM = new FilesManager();
						//$fileField =$input['fileField'];
						$fileFieldRS = $DS->query("SELECT UserFieldValue FROM UserField WHERE UserFieldID='$UserFieldID'");
						$SERVER->setInputVar('actionMode','deletefile');
						$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
						$fieldVale='';
						$input['UserFieldStatus'][$fieldCode] = 1;
					}
				}				
				
				if($input['UserFieldStatus'][$fieldCode]!=1)
				{
					$fieldStatus = 2;
				}
				else
				{
					$fieldStatus = 1;
				}
				//echo 'UserFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';

				if(!empty($UserFieldID))
				{
					//udpate
					$query = "UPDATE `UserField` SET `UserID`='$entityID',`UserFieldAlias`='$fieldCode', `UserTypeFieldID`='$fieldTypeID', `".$valueFieldName."` = '$fieldVale' WHERE `UserFieldID`='$UserFieldID'";
				}
				else
				{
					//insert
					$query = "INSERT INTO UserField (`UserID`,`UserFieldAlias`,`UserTypeFieldID`,`".$valueFieldName."`) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldVale')";					
				}
				if(!empty($entityID) && !empty($fieldTypeID) && !empty($fieldCode))
				{
					//echo $query.'<br>';
					$DS->query($query);
				}
			}
		}
		//if(!empty($input['UserField'.DTR.'UserFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'UserField',$input['UserField'.DTR.'UserID'],'User');
		//}		
		$SERVER->setDebug('UserFieldClass.setUserField.End','End');		
		return $result;		
	}
	
	

	
	function getUser($input)
	{
		$DS = $this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser();
		if($SERVER->hasRights('admin'))
		{
			$userID = $input['User'.DTR.'UserID'];
			if(empty($userID)) {$userID = $input['UserID'];}
		}
		if(empty($userID)) {$userID = $user['UserID'];}
		if(!empty($userID))
		{
			$query = " SELECT *  FROM User WHERE UserID='$userID'";
			$dsResult = $DS->query($query);
		}
		return $dsResult;
	}
	
	function deleteUser($input)
	{
		$DS = $this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser();
		if($SERVER->hasRights('admin'))
		{
			$userID = $input['User'.DTR.'UserID'];
			if(!empty($userID))
			{
				$query = " DELETE FROM User WHERE UserID='$userID'";
				$DS->query($query);
				$query = " DELETE FROM UserFields WHERE UserID='$userID'";
				$DS->query($query);
			}
		}
		return $dsResult;
	}
	
	function getUsers($input)
	{
		$DS = $this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser;
		$searchWord = $input['searchWord'];
		
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}

		$groupID = $input['GroupID'];
		
		if(!empty($input['searchWord']))
		{
			$search .= " AND (Email LIKE '%$searchWord%' OR UserName LIKE '%$searchWord%')";
		}		
		if(!empty($groupID))
		{
			$filter .= " AND GroupID='$groupID'";
		}
		if(!empty($input['Status']))
		{
			$filter .=" AND Status='".$input['Status']."' ";
		}		
		
		if(!empty($input['PermAll']))
		{
			$filter .=" AND PermAll='".$input['PermAll']."' ";
		}else{
				$filter .=" AND PermAll='1' ";
			 }	

		if(!empty($input['orderField']))
		{
			$order = " ORDER BY ".$input['orderField']." ASC ";
		}
		else
		{
			$order = " ORDER BY TimeCreated DESC ";
		}
		
		if($input['filterMode']=='last')
		{
			$filter .=" AND PermAll='0' ";
			$limit = " LIMIT 0,30";
		}
		if(empty($limit))
		{
			$pages = $DS->getPages('User',"UserID!='1' AND UserName!='superadmin' $filter",array('ItemsPerPage'=>$itemsPerPage));
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		$query = " SELECT UserID,UserName,Email,Status,GroupID,TimeCreated,TimeSaved,IPCreated,IPSaved,UserFields,LastVisit,PermAll FROM User WHERE UserID!='1' AND UserName!='superadmin' $filter $order $limit";
		//jb $query = " SELECT * FROM User WHERE UserID!='1' $filter ORDER BY TimeCreated DESC $limit";
		//echo $query.'<br/>';
		$result['result'] = $DS->query($query); 
		//print_r($result['result']);
		$result['pages'] = $pages['pages'];		
		return $result;
	}	
	
	
	function getAdministratorsList($input)
	{
		$DS = $this->_DS;
		$SERVER = &$this->_controller;
		$user = $SERVER->getUser;
		$searchWord = $input['searchWord'];
		$query = " SELECT UserID,UserName,Email,Status,GroupID,TimeCreated,TimeSaved,IPCreated,IPSaved,UserFields,LastVisit,PermAll FROM User WHERE UserID!='1' AND UserName!='superadmin' AND (GroupID='admin' OR GroupID='root' OR GroupID='content') ORDER BY UserName";
		$result = $DS->query($query); 
		return $result;
	}		
	
	
	function getUserFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserClass.getUserFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode = $input['viewMode'];
		//set client side variables
		//if($SERVER->hasRights('admin'))
		//{
			$userID = $input['UserID'];
			if(empty($userID)) {$userID = $input['User'.DTR.'UserID'];}	
		//}
		
		if(empty($userID))
		{
			if($input['registerMode']!='register')
			{
				$userID = $user['UserID'];
			}
		}
		
		$entityID = $userID;

		$entityAlias = $input['User'];
		if(empty($entityAlias)) {$entityAlias = $input['UserName'];}		
		if(empty($entityAlias)) {$entityAlias = $input['User'.DTR.'UserName'];}
		
		$groupID = $input['GroupID'];
		if(empty($groupID)) {$groupID = $input['UserGroupID'];}	
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$UserIDRS = $DS->query("SELECT UserID FROM User WHERE UserName='$entityAlias'");
			$entityID = $UserIDRS[0]['UserID'];
		}

		if(empty($groupID))
		{
			$UserGroupRS = $DS->query("SELECT GroupID FROM User WHERE UserID='$entityID'");
			$groupID = $UserGroupRS[0]['GroupID'];
		}
		$query = "SELECT * FROM UserTypeField LEFT JOIN UserTypeOption ON UserTypeField.UserTypeFieldID = UserTypeOption.UserTypeFieldID WHERE UserTypeField.UserGroupID = '$groupID' $filter ORDER BY UserTypeFieldPosition, UserTypeOptionPosition"; 
		//$query = "SELECT * FROM (UserField LEFT JOIN UserTypeField ON UserField.UserTypeFieldID = UserTypeField.UserTypeFieldID) LEFT JOIN UserTypeOption ON UserTypeField.UserTypeFieldID = UserTypeOption.UserTypeFieldID WHERE UserTypeField.UserType = '$entityType' AND UserID='$entityID' $filter ORDER BY UserTypeFieldPosition, UserTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		//print_r($rs);
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['UserTypeFieldAlias'];
				$fieldName = $row['UserTypeFieldName'];
				$fieldType = $row['UserTypeFieldType'];
				$fieldTypeGroups = $row['UserTypeFieldGroups'];
				
				$fieldPlaces = $row['UserTypeFieldHidenPlaces'];
				$fieldOptionID = $row['UserTypeOptionID'];
				$fieldOptionAlias = $row['UserTypeOptionAlias'];
				$fieldOptionValue = $row['UserTypeOptionName'];
				
				$result['UserFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['UserFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['UserFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['UserFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				$result['UserFieldTypes'][$fieldCode]['parts'] = $fieldTypeGroups;
				
				if(!empty($fieldOptionAlias))
				{
					$result['UserFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					//$result['UserFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['UserFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['UserFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;

					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}

		if($this->userFieldsDataMode=='tables')
		{
			$tableName = "UserFields";
			$keyFieldName = $tableName.'ID';
		
			if(!empty($entityID))
			{
				$query = "SELECT * FROM ".$tableName." WHERE UserID='$entityID' $filter"; 
				$rs = $DS->query($query);
			}
			if(is_array($rs))
			{
				$languagesList = $SERVER->getLanguages();
	
				foreach($rs as $row)
				{
					
					foreach($row as $fieldCode=>$fieldValue)
					{
						$result['UserField'][0][$fieldCode] = $fieldValue;
					}//end of foreach($row as $fieldTableCode=>$fieldTbaleValue)	
				}//end of foreach($rs as $row)
			}//end of if(is_array($rs))
			
			
		}
		else
		{		
			if(!empty($userID))
			{
				$query = "SELECT * FROM UserField WHERE UserID='$userID' $filter "; 
				//echo $query;
				$rs = $DS->query($query);
			}
			//print_r($rs);
			if(is_array($rs))
			{
				foreach($rs as $row)
				{
					$fieldCode = $row['UserFieldAlias'];
					
					$query = "SELECT * FROM `UserTypeField` WHERE `UserTypeFieldID` = '".$row['UserTypeFieldID']."'"; 
					$rsType = $DS->query($query);
					$fieldType = $rsType[0]['UserTypeFieldType'];
					//$fieldType = $row['UserFieldType'];
					
					$UserFieldID = $row['UserFieldID'];
					$fieldOptionID = $row['UserOptionID'];
					
					$fieldTypeOptionID = $row['UserTypeOptionID'];
					
					$fieldOptionStatus = $row['UserOptionStatus'];
		
					if($fieldType=='number')
					{
						$fieldValue = $row['UserFieldValueNumber'];
					}
					elseif($fieldType=='time' || $fieldType=='date')
					{
						$fieldValue = $row['UserFieldValueTime'];
					}
					else
					{
						$fieldValue = $row['UserFieldValue'];
					}
					
					/*
					if($row['UserFieldValueTime']!='0000-00-00 00:00:00')
					{
						$fieldValue = $row['UserFieldValueTime'];
					}
					elseif($row['UserFieldValueNumber']>0)
					{
						$fieldValue = $row['UserFieldValueNumber'];
					}	
					else
					{
						$fieldValue = $row['UserFieldValue'];
					}	
					*/										
					
					if(!empty($result['UserFieldTypes'][$fieldCode]['code']))
					{
						$result['UserFieldTypes'][$fieldCode]['status'] = $row['UserFieldStatus'];
					}
					$result['UserField'][0][$fieldCode] = $fieldValue;
					
					$result['UserOption'][$fieldTypeOptionID]['UserFieldID'] = $UserFieldID;			
					
					if(!empty($fieldTypeOptionID))
					{
						$result['UserOption'][$fieldTypeOptionID]['UserOptionID'] = $fieldOptionID;
						$result['UserOption'][$fieldTypeOptionID]['UserOptionStatus'] = $fieldOptionStatus;	
						$result['UserOption'][$fieldTypeOptionID]['UserTypeOptionID'] = $fieldTypeOptionID;		
					}
					
					if($viewMode=='viewUser' && $result['UserFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
					{
						foreach($result['UserFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
						{
							if($fieldTypeOptionID==$result['UserFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
							{
								if($fieldOptionStatus==2)
								{
									$result['UserFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
									$result['UserFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
								}
								else
								{
									$result['UserFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = $redefinVieldValue['value'].' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'];;
								}
							}
						}
					}						
					
				}		
			}
		}
		//print_r($result['UserOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('UserClass.getUserFields.End','End');
		return $result;
	}	
	
	function getUserFields($input)
	{
		$rs = $this->getUserFieldsStructureAndValues($input);
		//print_r($rs);
		if(is_array($rs['UserFieldTypes']))
		{
			foreach($rs['UserFieldTypes'] as $UserFieldCode=>$UserFieldType)			
			{
				if(!empty($UserFieldType['code']))
				{
					$result['UserField'][$UserFieldCode]['code']=$UserFieldType['code'];
					$result['UserField'][$UserFieldCode]['name']=$UserFieldType['name'];
					$result['UserField'][$UserFieldCode]['type']=$UserFieldType['type'];
					//$result['UserField'][$UserFieldCode]['mode']=$UserFieldType['mode'];
					$result['UserField'][$UserFieldCode]['status']=$UserFieldType['status'];
					$result['UserField'][$UserFieldCode]['parts']=$UserFieldType['parts'];
					$result['UserField'][$UserFieldCode]['places']=$UserFieldType['places'];
					
					$result['UserField'][$UserFieldCode]['value']=$rs['UserField'][0][$UserFieldCode];
					//echo "#".$rs['UserField'][0][$UserFieldCode]."#<br/>";
					if(is_array($UserFieldType['options'])) {
						foreach($UserFieldType['options'] as $id=>$UserFieldOptions) { 
							$optionsTypeID = $UserFieldOptions['id'];
							$result['UserField'][$UserFieldCode]['options'][$id]['id']=$UserFieldOptions['id'];
							$result['UserField'][$UserFieldCode]['options'][$id]['value']=$UserFieldOptions['value'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['position']=$UserFieldOptions['position'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionID']=$rs['UserOption'][$optionsTypeID]['UserOptionID'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserFieldID']=$rs['UserOption'][$optionsTypeID]['UserFieldID'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionStatus']=$rs['UserOption'][$optionsTypeID]['UserOptionStatus'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserTypeOptionID']=$rs['UserOption'][$optionsTypeID]['UserTypeOptionID'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionPrice']=$rs['UserOption'][$optionsTypeID]['UserOptionPrice'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionPriceAction']=$rs['UserOption'][$optionsTypeID]['UserOptionPriceAction'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionWeight']=$rs['UserOption'][$optionsTypeID]['UserOptionWeight'];
							//$result['UserField'][$UserFieldCode]['options'][$id]['UserOptionWeightAction']=$rs['UserOption'][$optionsTypeID]['UserOptionWeightAction'];
						}//end of foreach($UserFieldType['options'] as $id=>$UserFieldOptions) 
					}//end of if(is_array($UserFieldType['options']))
				}//end of if(!empty($UserFieldType['code']) && !empty($rs['UserField'][0][$UserFieldCode]))
			}
		}
		//echo '<textarea rows=30 cols=30>';
		//print_r($result);
		//echo '</textarea>';
		return $result;
		
	}	

	

    /**
    * pay for membership
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function buyMembership($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserSession.buyMembership.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		//$user = $this->_user;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$goupID = $config['GroupID'];
		//set client side variables
		if(!empty($userID))
		{
			$serviceInput['service'] = $input['service'];
			$serviceInput['Reason'] = $user['UserName'];
			$serviceInput['ResourceID'] = $user['UserID'];
			$serviceRS = $SERVER->callService('buyService','serviceServer',$serviceInput,'array');
		}
		$paymentResult = $serviceRS['array']['ServiceResponse']['#']['Vars'][0]['#']['PaymentResult'][0]['#'];
		$serviceType = $serviceRS['array']['ServiceResponse']['#']['Service'][0]['#']['ServiceAlias'][0]['#'];
		//print_r($serviceRS['array']);
		//echo $serviceRS['xml'];
		if($paymentResult=='OK')
		{
			if($serviceType=='vipmember1'){$endTime = time()+60*60*24*30;}
			elseif($serviceType=='vipmember6'){$endTime = time()+60*60*24*30*6;}
			elseif($serviceType=='vipmember12'){$endTime = time()+60*60*24*30*12;}
			$endTimeStr = $SERVER->getTime($endTime);
			$nowTimeStr = $SERVER->getNow();		
			$query = "UPDATE {dbprefix}User SET GroupID = 'client', TimeStart ='$nowTimeStr', TimeEnd='$endTimeStr' WHERE UserID='$userID'";
			//echo 'query='.$query;
			$DS->query($query);
		}
		$SERVER->setDebug('UserSession.buyMembership.End','End');		
		return $serviceRS;		
	}	
	
	function sendEmailToUser($userID,$template,$toAdmin='')
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		

		$userDataRS = $this->_DS->query("SELECT * FROM User WHERE UserID = '$userID'");        
		$groupID = $userDataRS[0]['GroupID'];
		
		$userData = $userDataRS[0];
		
		$emailInput['MailTemplate'] = $template.'.'.$groupID.'.session';
		$emailInputAdmin['MailTemplate'] = $template.'Admin.'.$groupID.'.session';
		
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
		
		$emailInput['MailToName']	= $emailInput['MailData']['FirstName'].' '.$emailInput['MailData']['LastName'];
		$emailInputAdmin['MailFromName'] = $emailInput['MailData']['FirstName'].' '.$emailInput['MailData']['LastName'];
		
		//print_r($emailInput);
		$SERVER->callService('sendMail','mailServer',$emailInput);
		if($toAdmin=='Y')
		{
			$SERVER->callService('sendMail','mailServer',$emailInputAdmin);
		}
		//$this->_controller->setDebug('UserSessionServer.sendPassword.End','End');				
		return true;
	}		

} // end of UserSession

?>