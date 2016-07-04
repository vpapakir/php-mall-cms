<?php
//XCMSPro: Web Service entity class
class UserGroupClass
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
	function UserGroupClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getUserGroups($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserGroupClass.getUserGroups.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserGroupServer.adminUserGroup');
		if(!empty($searchWord))
		{
			//$filter .= " AND (UserGroupName LIKE '{ls}%$searchWord%{le}' OR UserGroupName LIKE '%$searchWord%' OR UserGroupDescription LIKE '{ls}%$searchWord%{le}' OR UserGroupDescription LIKE '%$searchWord%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM UserGroup ORDER BY GroupPosition";
		//echo $query ;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('UserGroupClass.getUserGroups.End','End');
		return $result;
	}	
	

    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getUserGroup($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserGroupClass.getUserGroup.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['UserGroup'.DTR.'GroupID'];
		if(empty($entityID)) {$entityID = $input['GroupID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserGroupServer.adminUserGroup');
		//set queries
		$query = "SELECT * FROM UserGroup WHERE GroupID='$entityID'"; 
		//get the content
		$result = $DS->query($query);	
		$SERVER->setDebug('UserGroupClass.getUserGroup.End','End');		
		return $result;		
	}
	
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setUserGroup($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserGroupClass.setUserGroup.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['UserGroup'.DTR.'GroupID'];
		if(empty($entityID)) {$entityID = $input['GroupID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserGroupServer.adminUserGroup');
		//set queries	
		if(!empty($entityID))
		{
		 	if(is_array($input['UserGroup'.DTR.'GroupRights'])) {$input['UserGroup'.DTR.'GroupRights'] = implode(",",$input['UserGroup'.DTR.'GroupRights']).','; }
			if(!empty($input['UserGroup'.DTR.'GroupID']) && $input['actionMode']=='add')
			{
				$checkRS=$DS->query("SELECT GroupID FROM UserGroup WHERE GroupID='".$input['UserGroup'.DTR.'GroupID']."'");
				if(count($checkRS)<1 && !empty($input['UserGroup'.DTR.'GroupID']))
				{
					$DS->query("INSERT INTO UserGroup (GroupID) VALUES ('".$input['UserGroup'.DTR.'GroupID']."')");
				}
				else
				{
					$SERVER->setMessage('UserGroupClass.setUserGroup.err.AlreadyExists');
				}
			}

			$where['UserGroup'] = "GroupID = '".$entityID."'".$filter;
			$input['actionMode']='save';		
			//print_r($input);			
			$result = $DS->save($input,$where);	
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('UserGroupClass.setUserGroup.msg.DataSaved');
			}
		}
		//$SERVER->setDebug('UserGroupClass.setUserGroup.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteUserGroup($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('UserGroupClass.deleteUserGroup.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['UserGroup'.DTR.'GroupID'];
		//if(empty($entityID)) {$entityID = $input['GroupID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'UserGroupServer.adminUserGroup');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM UserGroup WHERE GroupID='$entityID'");
		}
		$SERVER->setMessage('UserGroupClass.deleteUserGroup.msg.DataDeleted');
		$SERVER->setDebug('UserGroupClass.deleteUserGroup.End','End');		
		return $result;		
	}	
	
	
	function copyUserGroup($input)
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
		$UserGroupTemplateID = $input['selectedGroupID'];
		$GroupID = $input['GroupID'];
		if($GroupID==$UserGroupTemplateID) {return false;}
		//set client side variables
		if(!empty($UserGroupTemplateID) && !empty($GroupID))
		{
			//make UserGroup link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM UserGroupField WHERE GroupID='$UserGroupTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['UserGroupField'] = "UserGroupFieldID = ''";
			$inputNew['UserGroupField'.DTR.'UserGroupFieldID']='';
			$inputNew['UserGroupField'.DTR.'OwnerID']=$ownerID;
			$inputNew['UserGroupField'.DTR.'UserID']=$userID;
			$inputNew['UserGroupField'.DTR.'GroupID']=$GroupID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['UserGroupField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['UserGroupField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['UserGroupField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM UserGroupField WHERE BoxID='".$inputNew['UserGroupField'.DTR.'BoxID']."' AND GroupID='".$GroupID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new UserGroup
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

	function getSystemRights()
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		
		//get functional rights
		
		$rootPath = $config['RootPath'];
		$dir = $rootPath.'modules';
		//load boxes definitions		
		if ($dp=@opendir($dir)) {
			while (false!==($file=readdir($dp))) {
				$filename = $dir.'/'.$file;
				if ($file!='.' && $file!='..' && is_dir($filename)) {
					$boxesDefinitionsFile = "$filename/definitions/rightsDefinition.php";
					if(is_file($boxesDefinitionsFile)){include_once $boxesDefinitionsFile;}
				}
			}
			closedir($dp);
		}
		
		//get database fields rigths
		$dbDefinitions = $SERVER->getDatabaseDefinition();
		foreach($dbDefinitions['t'] as $tableName=>$fields)
		{
			//echo 'table='.$tableName.'<br>';
			$rightsDefinition['DB'][$tableName.'.insert'] = array('name'=>'Insert rights for table: '.$tableName,'id'=>$tableName.'.insert');			
			$rightsDefinition['DB'][$tableName.'.update'] = array('name'=>'Update rights for table: '.$tableName,'id'=>$tableName.'.update');
			$rightsDefinition['DB'][$tableName.'.delete'] = array('name'=>'Delete rights for table: '.$tableName,'id'=>$tableName.'.delete');
		}
		
		//print_r($dbDefinitions);
		
		return $rightsDefinition;	
	}
} // end of UserGroupServer
?>