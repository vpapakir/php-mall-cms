<?php
//XCMSPro: Web Service entity class
class TaskboardClass
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
	function TaskboardClass()
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
	function getTaskboards($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardClass.getTaskboards.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$groupID = $user['GroupID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$manageMode = $input['manageMode'];
		$filterMode = $input['filterMode'];
		
		
		$filter = " t.TaskboardID>0 and t.TaskboardFlag=o.OptionCode and t.TaskboardProject=p.TaskboardProjectID";
		$order = '';


		if($input['filterMode']=='last'){
//			$filter .= " AND r.TaskboardID=t.TaskboardID and r.TaskboardSeenBy not like '%|$userID|%' and UNIX_TIMESTAMP()<UNIX_TIMESTAMP(t.TaskboardDeadline)";
			$filter .= " AND r.TaskboardID=t.TaskboardID and r.TaskboardSeenBy not like '%|$userID|%' ";
		}
//echo "$filter<hr>";



		if($input['TaskboardShowOnly']){
			$filter .= " AND t.TaskboardStatus='".$input['TaskboardShowOnly']."' ";
		}elseif($input['filterMode']!='last' and !$input['Today']){
			$filter .= " AND t.TaskboardStatus!='Completed' ";
		}

		if($input['TaskboardShowOnlyType']){
			$filter .= " AND t.TaskboardType='".$input['TaskboardShowOnlyType']."' ";
		}

		$filter .= " AND (t.TaskboardUsers like '%|$userID|%' OR t.TaskboardGroups like '%|$groupID|%' OR t.UserID='$userID' OR t.TaskboardResponsable='$userID') ";
		if($input['Today']){
			$filter .= " AND UNIX_TIMESTAMP()>=UNIX_TIMESTAMP(t.TaskboardDeadline) AND t.TaskboardStatus not like 'Completed' ";
			$order_option = $input['ProjectsSortByToday'];
		}elseif($input['NameNoProject']){
			$order_option = 'NameNoProject';
//			$filter .= " AND r.TaskboardID=t.TaskboardID and r.TaskboardSeenBy not like '%|$userID|%' ";
		}else{
			$order_option = $input['ProjectsSortBy'];
		}
		if(!$order_option){
			if($input['Today'])
				$order_option = 'Priority';
			else
				$order_option = 'Name';	
		}


		switch($order_option){
			case 'Priority':
				$order = 'ORDER BY p.TaskboardProjectTitle , o.OptionPosition ';
			break;
			case 'Name':
				$order = 'ORDER BY p.TaskboardProjectTitle , t.TaskboardTitle ';
			break;
			case 'Date':
				$order = 'ORDER BY p.TaskboardProjectTitle , t.TimeCreated ';
			break;
			case 'TimeLeft':
				$order = 'ORDER BY p.TaskboardProjectTitle , time_left ';
			break;
			case 'NameNoProject':
				$order = 'ORDER BY t.TimeCreated desc ';
			break;
			default:
		}

		$sectionID = $input['SectionID'];
		if(empty($sectionID)) {$sectionID = $input['SID'];}
		
		
		
		if(!empty($input['PermAll'])){
			$PermAll = $input['PermAll'];
			$filter .= " AND t.PermAll='$PermAll' ";
		}

		
		$query = "SELECT t.*, (to_days(t.TaskboardDeadline)-to_days(now())) time_left, p.TaskboardProjectTitle TaskboardProject   FROM Taskboard t, ReferenceOption o,TaskboardProject p, TaskboardRecord r WHERE $filter GROUP BY t.TaskboardID ".$order;
//echo "<hr>$query<br>";
//echo "$filter<hr>";
		$result = $DS->query($query);
		if($result[0]['TaskboardID'] and $input['NameNoProject'])
			foreach($result as $k=>$v)
				$result[$k]['TaskboardTitle'] = substr($v['TaskboardTitle'],0,40);
		$SERVER->setDebug('TaskboardClass.getTaskboards.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTaskboard($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardClass.getTaskboard.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['Taskboard'.DTR.'TaskboardID'];
		if(empty($entityID)) {$entityID = $input['TaskboardID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Taskboard'];}
		if(empty($entityAlias)) {$entityAlias = $input['TaskboardAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Taskboard'.DTR.'TaskboardAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TaskboardServer.adminTaskboard');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " AND t.TaskboardAlias='$entityAlias' "; 
		}
		elseif(!empty($entityID))
		{
			$filter = " AND t.TaskboardID='$entityID' ";
		}
		
		if($manageMode=='user')
		{
			$filter = " AND t.UserID='$userID' ";
		}
		$query = "SELECT t.* ,sum(r.TaskboardRecordTimestamp) time_spent, p.TaskboardProjectTitle FROM Taskboard t, TaskboardRecord r, TaskboardProject p WHERE t.TaskboardID>0 and t.TaskboardID=r.TaskboardID and p.TaskboardProjectID=t.TaskboardProject $filter  group by t.TaskboardID"; 
//echo $query;
		//get the content
		$result = $DS->query($query);	
		if(!$result[0]['TaskboardID']){
			$query = "SELECT t.*, p.TaskboardProjectTitle  FROM Taskboard t, TaskboardProject p WHERE t.TaskboardID>0  and p.TaskboardProjectID=t.TaskboardProject $filter "; 
			$result = $DS->query($query);	
		}
		$result[0]['TaskboardDeadline'] = preg_replace('/^(\d{4})-(\d{2})-(\d{2})(.*)$/','\\3-\\2-\\1\\4',$result[0]['TaskboardDeadline']);

		$SERVER->setDebug('TaskboardClass.getTaskboard.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTaskboard($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardClass.setTaskboard.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Taskboard'.DTR.'TaskboardID'];
		if(empty($entityID)) {$entityID = $input['TaskboardID'];}		
		if(empty($input['Taskboard'.DTR.'PermAll'])) {$input['Taskboard'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['Taskboard'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['Taskboard'.DTR.'ResourceID'];
		$input['Taskboard'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['Taskboard'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['Taskboard'.DTR.'ResourceCategoryID'] = $categoryID;

		$where['Taskboard'] = "TaskboardID = '".$entityID."'".$filter;

		if(!empty($input['Taskboard'.DTR.'TaskboardTitle']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT TaskboardAlias FROM Taskboard WHERE TaskboardAlias='".$input['Taskboard'.DTR.'TaskboardAlias']."'");
		}


		$input['Taskboard'.DTR.'TaskboardDeadline'] = preg_replace('/^(\d{2})-(\d{2})-(\d{4})(.*)$/','\\3-\\2-\\1\\4',$input['Taskboard'.DTR.'TaskboardDeadline']);

		if(!empty($input['Taskboard'.DTR.'TaskboardTitle']))
		{		
			$input['actionMode']='save';					
//echo "<pre>";
//print_r($input);
//print_r($where);
//echo "</pre>";
//die();

			$result = $DS->save($input,$where);
			$entityID = $result[0]['TaskboardID'];
		}
		else
		{
			if(!empty($input['Taskboard'.DTR.'TaskboardTitle']))
			{
				$SERVER->setMessage('TaskboardClass.setTaskboard.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TaskboardClass.setTaskboard.msg.DataSaved');
		}
		//if(!empty($input['Taskboard'.DTR.'TaskboardAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Taskboard');
		//}
		$SERVER->setDebug('TaskboardClass.setTaskboard.End','End');		
//print_r($result);
//die();
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTaskboard($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Taskboard'.DTR.'TaskboardID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TaskboardRecord WHERE TaskboardID='$entityID'");
			$DS->query("DELETE FROM Taskboard WHERE TaskboardID='$entityID'");
		}
		//$SERVER->setMessage('TaskboardClass.deleteTaskboard.msg.DataDeleted');
		return $result;		
	}	






















	function getProject($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardClass.getProject.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['TaskboardProject'.DTR.'TaskboardProjectID'];
		if(empty($entityID)) 
			$entityID = $input['TaskboardProjectID'];
		if(empty($entityID)) 
			$entityID = $input['ProjectID'];

//echo "||$entityID||";
		if(isset($entityID))
		{
			$filter .= " AND t.TaskboardProjectID='$entityID' ";
		}
		if($user['GroupID']!='root'){		
			$filter .= " AND t.UserID='$userID' ";
		}

		$query = "SELECT t.* FROM TaskboardProject t WHERE t.TaskboardProjectID>0  $filter  "; 
		$result = $DS->query($query);	

		$SERVER->setDebug('TaskboardClass.getTaskboard.End','End');		
		return $result;		
	}


	function getProjects($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TaskboardClass.getProjects.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['TaskboardProject'.DTR.'TaskboardProjectID'];
		if(empty($entityID)) {$entityID = $input['TaskboardProjectID'];}


		if($user['GroupID']!='root'){		
			$filter = " AND t.UserID='$userID' ";
		}

		$query = "SELECT t.* FROM TaskboardProject t WHERE t.TaskboardProjectID>0  $filter  order by t.TaskboardProjectTitle"; 
		$result = $DS->query($query);	

		foreach($result as $k=>$v)
			$result[$k]['TaskboardProjectTitle'] = substr($v['TaskboardProjectTitle'],0,40);

		$SERVER->setDebug('TaskboardClass.getProjects.End','End');		
		return $result;		
	}



	function deleteProject($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$entityID = $input['TaskboardProject'.DTR.'TaskboardProjectID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TaskboardProject WHERE TaskboardProjectID='$entityID'");
			$result = $DS->query("select * FROM Taskboard WHERE TaskboardProject='$entityID'");
			foreach ($result as $value){
				$DS->query("DELETE FROM TaskboardRecord WHERE TaskboardID='".$value['TaskboardID']."'");
			}
			$DS->query("DELETE FROM Taskboard WHERE TaskboardID='$entityID'");
		}
		return $result;		
	}	


	function setProject($input){
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$entityID = $input['TaskboardProject'.DTR.'TaskboardProjectID'];

		$where['TaskboardProject']= ' TaskboardProjectID="'.$entityID.'"  ';


		if($input['TaskboardProject'.DTR.'TaskboardProjectTitle']){
			if(!$entityID){
				$query = "SELECT * FROM TaskboardProject WHERE TaskboardProjectTitle like '".$input['TaskboardProject'.DTR.'TaskboardProjectTitle']."'"; 
				$result = $DS->query($query);
//echo $query;
				if($result[0]['TaskboardProjectID']){
					$result[0]['TaskboardProjectExists']=true;
//die( 'asf');
					return $result;
				}
			}

			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['TaskboardProjectID'];
//print_r($result);
//die();
			return $result;
		}
	}








} // end of TaskboardServer
?>