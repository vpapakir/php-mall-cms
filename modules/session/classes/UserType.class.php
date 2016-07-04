<?php
//XCMSPro: Web Service entity class
class UserTypeClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function UserTypeClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$this->userFieldsDataMode = 'tables';
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getUserTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.getUserTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['UserTypeField'.DTR.'UserGroupID'];
		if(empty($entityID)) {$entityID = $input['UserGroupID'];}
		$searchWord = $input['searchWord'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		if(!empty($entityID))		
		{
			$filter .= " AND UserGroupID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM UserTypeField WHERE UserTypeFieldID>0 $filter ORDER BY UserTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('UserTypeClass.getUserTypeFields.End','End');
		return $result;
	}	
	
	function getUserTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.getUserTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['UserTypeField'.DTR.'UserTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['UserTypeFieldID'];}
		
		$entityAlias = $input['UserField'];		
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeField'.DTR.'UserTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$UserTypeIDRS = $DS->query("SELECT UserTypeFieldID FROM UserTypeField WHERE UserTypeFieldAlias='$entityAlias'");
			$entityID = $UserTypeIDRS[0]['UserTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM UserTypeOption WHERE UserTypeFieldID='$entityID' $filter ORDER BY UserTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('UserTypeClass.getUserTypeFields.End','End');
		return $result;
	}	
	
	function getUserTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.getUserTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['UserTypeField'.DTR.'UserTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['UserTypeFieldID'];}

		$entityAlias = $input['UserTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeField'.DTR.'UserTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " UserTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " UserTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM UserTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('UserTypeClass.getUserTypeField.End','End');		
		return $result;		
	}

	function getUserTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.getUserTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['UserTypeOption'.DTR.'UserTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['UserTypeOptionID'];}

		$entityAlias = $input['UserTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['UserTypeOption'.DTR.'UserTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " UserTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " UserTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM UserTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('UserTypeClass.getUserTypeOption.End','End');		
		return $result;		
	}
	
	function setUserTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeFieldClass.setUserTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['UserTypeField'.DTR.'UserTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['UserTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeFieldServer.adminUserTypeField');
		//set queries	

		//if(is_array($input['UserTypeField'.DTR.'AccessGroups'])) {$input['UserTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['UserTypeField'.DTR.'AccessGroups']).'|'; }
		$where['UserTypeField'] = "UserTypeFieldID = '".$entityID."'".$filter;

		if(empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']) && !empty($input['UserTypeField'.DTR.'UserTypeFieldName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langUserTypeFieldName = $input['UserTypeField'.DTR.'UserTypeFieldName']['en'];
			if(empty($langUserTypeFieldName)) { $lang = $config['lang']; $langUserTypeFieldName = $input['UserTypeField'.DTR.'UserTypeFieldName'][$lang];}
			$input['UserTypeField'.DTR.'UserTypeFieldAlias'] = $typeObject->setDataType($langUserTypeFieldName);
		}
		if(!empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']))
		{
			$typeObject = new AliasDataType($SERVER);
			$input['UserTypeField'.DTR.'UserTypeFieldAlias'] = $typeObject->setDataType($input['UserTypeField'.DTR.'UserTypeFieldAlias']);
			$input['UserTypeField'.DTR.'UserTypeFieldAlias'] = str_replace("-","_",$input['UserTypeField'.DTR.'UserTypeFieldAlias']);
			
			$checkRS=$DS->query("SELECT UserTypeFieldAlias FROM UserTypeField WHERE UserTypeFieldAlias='".$input['UserTypeField'.DTR.'UserTypeFieldAlias']."' AND UserGroupID='".$input['UserTypeField'.DTR.'UserGroupID']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['UserTypeField'.DTR.'UserTypeFieldAlias'] = $input['UserTypeField'.DTR.'UserTypeFieldAlias'].date('Ymd-His');
				$SERVER->setMessage('session.UserTypeFieldClass.setUserTypeField.err.DuplicatedUserTypeField');
			}				
		}
		$input['UserTypeField'.DTR.'UserTypeFieldAlias'] = str_replace("-","_",$input['UserTypeField'.DTR.'UserTypeFieldAlias']);

		if($duplicated != 'Y' && !empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']) && !empty($input['UserTypeField'.DTR.'UserTypeFieldName'])  && !empty($input['UserTypeField'.DTR.'UserGroupID']))
		{		
			
			$userFieldsDataMode = $this->userFieldsDataMode;
			if($userFieldsDataMode=='tables')
			{
				//make DB tables and fields
				//get field info
				$currentFieldRS = $DS->query("SELECT * FROM UserTypeField WHERE UserTypeFieldID='".$input['UserTypeField'.DTR.'UserTypeFieldID']."' ");
				if(!empty($input['UserTypeField'.DTR.'UserGroupID']))
				{
					//create table if it does not exists
					$tableRS = $DS->query("CREATE TABLE IF NOT EXISTS UserFields (UserFieldsID CHAR( 30 ) NOT NULL PRIMARY KEY)  ENGINE = MYISAM");
					$DS->query("ALTER TABLE UserFields CHANGE UserFieldsID UserFieldsID VARCHAR( 30 ) CHARACTER SET utf8 NOT NULL ");
					$DS->query("ALTER TABLE UserFields DEFAULT CHARACTER SET = utf8");
					//create field
					if(!empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']))
					{
						$fieldsList = $DS->dbFields("UserFields");
						if(!in_array('UserID',$fieldsList))
						{
							$queryField = "ALTER TABLE UserFields ADD UserID CHAR( 30 ) NOT NULL ;";
							$DS->query($queryField);
							$queryField = "ALTER TABLE UserFields ADD INDEX (UserID);";
							$DS->query($queryField);
							$DS->query("ALTER TABLE UserFields ADD UserFieldMode CHAR( 1 ) DEFAULT 'R' NOT NULL AFTER UserID;");
							$DS->query("ALTER TABLE  UserFields ADD INDEX (UserFieldMode);");
						}
						if (!in_array($input['UserTypeField'.DTR.'UserTypeFieldAlias'], $fieldsList))
						{
							//find field type
							if($input['UserTypeField'.DTR.'UserTypeFieldType']=='input'){$fieldFormat = " TEXT NOT NULL ";}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='char'){$fieldFormat = " VARCHAR(255) NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='int'){$fieldFormat = " INT(11) NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='dropdown' || $input['UserTypeField'.DTR.'UserTypeFieldType']=='color'){$fieldFormat = " VARCHAR(30) NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='date'){$fieldFormat = " DATE NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='time'){$fieldFormat = " DATETIME NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='money' || $input['UserTypeField'.DTR.'UserTypeFieldType']=='number'){$fieldFormat = " DECIMAL( 10, 2 ) NOT NULL "; $indexMode='Y';}
							elseif($input['UserTypeField'.DTR.'UserTypeFieldType']=='boolean'){$fieldFormat = " VARCHAR(1) NOT NULL "; $indexMode='Y';}
							else {$fieldFormat = " TEXT NOT NULL ";}
							//no such field, check if the field was renamed
							if (in_array($currentFieldRS[0]['UserTypeFieldAlias'],$fieldsList))
							{
								//field exists .. need to rename
								$makeFieldQuery = "ALTER TABLE UserFields CHANGE ".$currentFieldRS[0]['UserTypeFieldAlias']." ".$input['UserTypeField'.DTR.'UserTypeFieldAlias']." ".$fieldFormat;
								if($indexMode=='Y')
								{
									$DS->query("ALTER TABLE UserFields DROP INDEX ".$currentFieldRS[0]['UserTypeFieldAlias']." ");
									$indexFieldQuery = "ALTER TABLE UserFields ADD INDEX (".$input['UserTypeField'.DTR.'UserTypeFieldAlias'].") ;";
								}
							}
							else
							{
								//no field found so lets create it
								$makeFieldQuery = "ALTER TABLE UserFields ADD ".$input['UserTypeField'.DTR.'UserTypeFieldAlias']." ".$fieldFormat;
								if($indexMode=='Y')
								{
									$indexFieldQuery = "ALTER TABLE UserFields ADD INDEX (".$input['UserTypeField'.DTR.'UserTypeFieldAlias'].") ;";
								}
							}
							$DS->query($makeFieldQuery);
							if(!empty($indexFieldQuery))
							{
								$DS->query($indexFieldQuery);
							}							
						}
					}//end of if(!empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']))
				}//end of if(!empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']))
			}
			
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
			if(empty($entityID)) {$entityID = $DS->dbLastID();}
			$this->updateEntityPositions($entityID,'UserTypeField',$input['UserTypeField'.DTR.'UserGroupID'],'UserGroup');
		}
		else
		{
			if(!empty($input['UserTypeField'.DTR.'UserTypeFieldAlias']))
			{		
				$SERVER->setMessage('UserTypeFieldClass.setUserTypeField.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('UserTypeFieldClass.setUserTypeField.msg.DataSaved');
		}
		
		$SERVER->setDebug('UserTypeFieldClass.setUserTypeField.End','End');		
		return $result;		
	}
	
	function setUserTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeOptionClass.setUserTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['UserTypeOption'.DTR.'UserTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['UserTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeOptionServer.adminUserTypeOption');
		//set queries	
		//if(is_array($input['UserTypeOption'.DTR.'AccessGroups'])) {$input['UserTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['UserTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['UserTypeOption'] = "UserTypeOptionID = '".$entityID."'".$filter;

		if(!empty($input['UserTypeOption'.DTR.'UserTypeOptionAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT UserTypeOptionAlias FROM UserTypeOption WHERE UserTypeOptionAlias='".$input['UserTypeOption'.DTR.'UserTypeOptionAlias']."' AND  UserTypeFieldID='".$input['UserTypeOption'.DTR.'UserTypeFieldID']."'");
		}
		if(count($checkRS)<1 && !empty($input['UserTypeOption'.DTR.'UserTypeOptionAlias']) && !empty($input['UserTypeOption'.DTR.'UserTypeOptionName']) && !empty($input['UserTypeOption'.DTR.'UserTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			if(empty($entityID)) {$entityID = $DS->dbLastID();}
			$this->updateEntityPositions($entityID,'UserTypeOption',$input['UserTypeOption'.DTR.'UserTypeFieldID'],'UserTypeField');
				
		}
		else
		{
			if(!empty($input['UserTypeOption'.DTR.'UserTypeOptionAlias']))
			{				
				$SERVER->setMessage('UserTypeOptionClass.setUserTypeOption.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('UserTypeOptionClass.setUserTypeOption.msg.DataSaved');
		}
		if(!empty($input['UserTypeOption'.DTR.'UserTypeOptionAlias']))
		{		
		}
		$SERVER->setDebug('UserTypeOptionClass.setUserTypeOption.End','End');		
		return $result;		
	}	

	
	function deleteUserTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.deleteUserTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['UserTypeField'.DTR.'UserTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['UserTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		//set queries
		if(!empty($entityID))
		{
			$userFieldsDataMode = $this->userFieldsDataMode;
			if($userFieldsDataMode=='tables')
			{
				//check if there is the same field in other groups
				$currentFieldRS = $DS->query("SELECT * FROM UserTypeField WHERE UserTypeFieldID='".$entityID."' ");
				$checkRS = $DS->query("SELECT UserTypeFieldAlias FROM UserTypeField WHERE UserTypeFieldAlias='".$currentFieldRS[0]['UserTypeFieldAlias']."'");
				if(count($checkRS)<2)
				{
					$DS->query("ALTER TABLE UserFields DROP INDEX ".$currentFieldRS[0]['UserTypeFieldAlias']." ");
					$DS->query("ALTER TABLE UserFields DROP ".$currentFieldRS[0]['UserTypeFieldAlias']." ");
				}
			}
		
			$DS->query("DELETE FROM UserTypeField WHERE UserTypeFieldID='$entityID'");
			$DS->query("DELETE FROM UserTypeOption WHERE UserTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('UserTypeClass.deleteUserTypeField.msg.DataDeleted');
		$SERVER->setDebug('UserTypeClass.deleteUserTypeField.End','End');		
		return $result;		
	}	
	
	function deleteUserTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserTypeClass.deleteUserTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['UserTypeOption'.DTR.'UserTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['UserTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserTypeServer.adminUserType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM UserTypeOption WHERE UserTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('UserTypeClass.deleteUserTypeOption.msg.DataDeleted');
		$SERVER->setDebug('UserTypeClass.deleteUserTypeOption.End','End');		
		return $result;		
	}	
	
	function copyUserType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.setSection.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	

		$ownerID = $config['OwnerID'];
		$ownerRootID = $config['OwnerRootID'];
		$UserTypeTemplateID = $input['selectedUserTypeID'];
		$UserTypeID = $input['UserTypeID'];
		if($UserTypeID==$UserTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($UserTypeTemplateID) && !empty($UserTypeID))
		{
			//make UserType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM UserTypeField WHERE UserTypeID='$UserTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['UserTypeField'] = "UserTypeFieldID = ''";
			$inputNew['UserTypeField'.DTR.'UserTypeFieldID']='';
			$inputNew['UserTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['UserTypeField'.DTR.'UserID']=$userID;
			$inputNew['UserTypeField'.DTR.'UserTypeID']=$UserTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['UserTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['UserTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['UserTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM UserTypeField WHERE BoxID='".$inputNew['UserTypeField'.DTR.'BoxID']."' AND UserTypeID='".$UserTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new UserType
					$newRS = $DS->save($inputNew,$where);	
				}
			}
		}
		//if(count($result['sql'])>0)	
		//{
			//$SERVER->setMessage('SectionServer.setSection.msg.DataSaved');
		//}
		$SERVER->setDebug('SectionServer.setSection.End','End');		
		return $result;		
	}

	function updateEntityPositions($entityID,$entityName,$entityParentID='',$entityParentName='')
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$input = $SERVER->getInput();
		//set client side variables
		if(empty($entityID))
		{
			return '';
		}
		if(!empty($entityParentID))
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName WHERE ".$entityParentName."ID='$entityParentID' ORDER BY ".$entityName."Position ASC";			
		}
		else
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName ORDER BY ".$entityName."Position ASC";			
		}
		//echo $query ;
		$rs = $DS->query($query);
		$i=2;
		
		foreach($rs as $row)
		{
			$DS->query("UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'");
			//echo "UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'<br>";
			$i = $i+2;
		}
		//return $result;		
	}	
	
	function getUserTemplate($UserType,$UserID='')
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserServer.adminUser');
		//set queries
		$query ='';
		if(!empty($UserID))
		{
			$UserTypeRS = $DS->query("SELECT UserType FROM User WHERE UserID='$UserID'");
			$UserType = $UserTypeRS[0]['UserType'];
		}
		
		if(!empty($UserType))
		{
			$query = "SELECT UserTemplate FROM UserType WHERE UserTypeAlias='$UserType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['UserTemplate'];		
	}
		
} // end of UserTypeServer
?>