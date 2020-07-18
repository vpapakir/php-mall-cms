<?php
//XCMSPro: Web Service entity class
class TaskboardRecordClass
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
	function TaskboardRecordClass()
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
	function getTaskboardRecords($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardRecordClass.getTaskboardRecords.Start','Start');
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
		$manageMode = $input['manageMode'];
		$filterMode = $input['filterMode'];
		
		$categoryAlias = $input['category'];
		$categoryID = $input['CategoryID'];
		if(!empty($categoryAlias) && empty($categoryID))
		{
			$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
			$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
		}
		
		$sectionID = $input['SectionID'];
		if(empty($sectionID)) {$sectionID = $input['SID'];}
		
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) {$resourceID = $input['TaskboardRecord'.DTR.'ResourceID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'TaskboardRecordServer.adminTaskboardRecord');
		if(!empty($searchWord))
		{
			$filter .= " AND (TaskboardRecordTitle LIKE '%$searchWord%' OR TaskboardRecordKeywords LIKE '%$searchWord%' OR TaskboardRecordContent LIKE '%$searchWord%')";
		}

		if(!empty($resourceID))
		{
			$filter .= " AND ResourceID = '$resourceID' ";
		}	
		if(!empty($input['TaskboardID']))
		{
			$filter .= "AND TaskboardID='".$input['TaskboardID']."'";
		}
		elseif($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		
		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			$filter .= " AND PermAll='$PermAll' ";
		}

		if($input['Timestamp'])
		{
			$filter .= " AND TaskboardRecordTimestamp>0 ";
		}
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
			$filter .= " AND PermAll='4' ";
		}
		
		$query = "SELECT r.*, u.UserName FROM TaskboardRecord r, User u  WHERE TaskboardRecordID>0 AND r.UserID=u.UserID $filter ORDER BY TimeCreated DESC ".$limit;
		
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM TaskboardRecord WHERE TaskboardRecordID>0 AND UserID='$userID' ORDER BY TimeCreated DESC ";
		}
		$result = $DS->query($query); 
		$SERVER->setDebug('TaskboardRecordClass.getTaskboardRecords.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTaskboardRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardRecordClass.getTaskboardRecord.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TaskboardRecord'.DTR.'TaskboardRecordID'];
		if(empty($entityID)) {$entityID = $input['TaskboardRecordID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TaskboardRecord'];}
		if(empty($entityAlias)) {$entityAlias = $input['TaskboardRecordAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TaskboardRecord'.DTR.'TaskboardRecordAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TaskboardRecordServer.adminTaskboardRecord');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " TaskboardRecordAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TaskboardRecordID='$entityID' ";
		}
		$query = "SELECT * FROM TaskboardRecord WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('TaskboardRecordClass.getTaskboardRecord.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTaskboardRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardRecordClass.setTaskboardRecord.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TaskboardRecord'.DTR.'TaskboardRecordID'];
		if(empty($entityID)) {$entityID = $input['TaskboardRecordID'];}		
		if(!$SERVER->hasRights('admin')) {$input['TaskboardRecord'.DTR.'PermAll']=4;}
		
		$where['TaskboardRecord'] = "TaskboardRecordID = '".$entityID."'".$filter;

		$input['actionMode']='save';					
//echo "<pre>";
//print_r($input);
//print_r($where);
//die();
		$result = $DS->save($input,$where);
		$entityID = $result[0]['TaskboardRecordID'];
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TaskboardRecordClass.setTaskboardRecord.msg.DataSaved');
		}
		$SERVER->setDebug('TaskboardRecordClass.setTaskboardRecord.End','End');		
		return $result;		
	}
	
	function setTaskboardRecordsRead($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardRecordClass.setTaskboardRecordsRead.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
//die('qewr');

		$taskID = $input['TaskboardID'];

		
		$query = "update TaskboardRecord set TaskboardSeenBy=concat(TaskboardSeenBy,'|$userID|') where TaskboardID='$taskID' and TaskboardSeenBy not like '%|$userID|%' ";
//die('asdf|'.$query);

		$result = $DS->query($query);
		$SERVER->setDebug('TaskboardRecordClass.setTaskboardRecord.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTaskboardRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TaskboardRecord'.DTR.'TaskboardRecordID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TaskboardRecord WHERE TaskboardRecordID='$entityID'");
		}
		//$SERVER->setMessage('TaskboardRecordClass.deleteTaskboardRecord.msg.DataDeleted');
		return $result;		
	}	
} // end of TaskboardRecordServer
?>