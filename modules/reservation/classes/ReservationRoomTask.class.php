<?php
//XCMSPro: Web Service entity class
class ReservationRoomTaskClass
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
	function ReservationRoomTaskClass()
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
	function getReservationRoomTasks($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomTaskClass.getReservationRoomTasks.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$ReservationRoomTaskCategoryID = $input['ReservationRoomTaskCategoryID'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationRoomTaskServer.adminReservationRoomTask');
		if(!empty($searchWord))
		{
			$filter .= " AND (ReservationRoomTaskTitle LIKE '{ls}%$searchWord%{le}' OR ReservationRoomTaskTitle LIKE '%$searchWord%' OR ReservationRoomTaskIntro LIKE '{ls}%$searchWord%{le}' OR ReservationRoomTaskIntro LIKE '%$searchWord%' OR ReservationRoomTaskContent LIKE '{ls}%$searchWord%{le}' OR ReservationRoomTaskContent LIKE '%$searchWord%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		if(!empty($input['ReservationRoomTaskType']))
		{
			$filter .= " AND ReservationRoomTaskType='".$input['ReservationRoomTaskType']."' ";
		}
		/*if($input['ReservationRoomTaskType']=='tips')
		{
			$filter .= " AND ReservationRoomTaskType='tips' ";
		}
		else
		{
			$filter .= " AND ReservationRoomTaskType!='tips' ";
		}*/
		if(!empty($ReservationRoomTaskCategoryID))
		{
			$filter .= " AND ReservationRoomTaskCategories LIKE '%|$ReservationRoomTaskCategoryID|%' ";
		}
		if(!empty($input['ReservationRoomTaskClientType']))
		{
			$filter .= " AND ReservationRoomTaskClientType = '".$input['ReservationRoomTaskClientType']."' ";
		}
		//set queries
		$query = "SELECT * FROM ReservationRoomTask WHERE ReservationRoomTaskID>0 $filter ORDER BY ReservationRoomTaskID DESC";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservationRoomTaskClass.getReservationRoomTasks.End','End');
		return $result;
	}	
	

    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservationRoomTask($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomTaskClass.getReservationRoomTask.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskID'];
		if(empty($entityID)) {$entityID = $input['ReservationRoomTaskID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservationRoomTask'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservationRoomTaskAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TipCode'];}
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationRoomTaskServer.adminReservationRoomTask');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$filter = " ReservationRoomTaskID='$entityID' ";
		}
		elseif(!empty($entityAlias))
		{
			$filter = " ReservationRoomTaskAlias='$entityAlias' "; 
		}
		elseif($input['ReservationRoomTaskType']=='tips')
		{	
			if(!empty($input['TipSection']))
			{
				$filter = " ReservationRoomTaskSections='|".$input['TipSection']."|' ";
			}
			else
			{
				$filter = " ReservationRoomTaskSections='|".$input['SID']."|' "; 
			}
		}		
		if(!empty($filter))
		{
			$query = "SELECT * FROM ReservationRoomTask WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	

		}
		//echo $query;
		//$SERVER->setDebug('ReservationRoomTaskClass.getReservationRoomTask.End','End');	
		return $result;		
	}
	
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservationRoomTask($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomTaskClass.setReservationRoomTask.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		//print_r($input);
		$entityID = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskID'];
		if(empty($entityID)) {$entityID = $input['ReservationRoomTaskID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationRoomTaskServer.adminReservationRoomTask');
		//set queries			
		//if(is_array($input['ReservationRoomTask'.DTR.'ReservationRoomTaskSections'])) {$input['ReservationRoomTask'.DTR.'ReservationRoomTaskSections'] = '|'. implode("|",$input['ReservationRoomTask'.DTR.'ReservationRoomTaskSections']).'|'; }
		$where['ReservationRoomTask'] = "ReservationRoomTaskID = '".$entityID."'".$filter;
		
		$checkAdd = $DS->query("SELECT * FROM ReservationRoomTask WHERE 
                    ReservationRoomTaskTaskName = '".$input['ReservationRoomTask'.DTR.'ReservationRoomTaskTaskName']."' AND ReservationRoomTaskRoomID = '".$input['ReservationRoomTask'.DTR.'ReservationRoomTaskRoomID']."'");

		if(empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias']) && !empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservationRoomTaskTitle = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskTitle']['en'];
			if(empty($langReservationRoomTaskTitle)) { $lang = $config['lang']; $langReservationRoomTaskTitle = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskTitle'][$lang];}
			$input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias'] = $typeObject->setDataType($langReservationRoomTaskTitle);
		}
		if(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias']))
		{
			$checkRS=$DS->query("SELECT ReservationRoomTaskAlias FROM ReservationRoomTask WHERE ReservationRoomTaskAlias='".$input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias'] = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias'].date('Ymd-His');
				$SERVER->setMessage('ReservationRoomTask.ReservationRoomTaskClass.setReservationRoomTask.err.DuplicatedReservationRoomTaskCode');
			}				
		}
        $separateDateField = 'ReservationRoomTask'.DTR.'ReservationRoomTaskArrival'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
        $separateDateField = 'ReservationRoomTask'.DTR.'ReservationRoomTaskDeparture'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
		if(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskTaskName']) && !empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskRoomDescription']) && empty($checkAdd) && $input['actionMode']=='add' && !empty($userID))
		{
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
		}
		elseif(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskTaskName']) && !empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskRoomDescription']) && $input['actionMode']=='save' && !empty($userID))
		{
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
		}
		else
		{
			if (!empty($checkAdd))
			{
                $SERVER->setMessage('Error - you can not add task with this name');
			}
			if(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskAlias']))
			{
				$SERVER->setMessage('ReservationRoomTaskClass.setReservationRoomTask.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationRoomTaskClass.setReservationRoomTask.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationRoomTaskClass.setReservationRoomTask.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservationRoomTask($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomTaskClass.deleteReservationRoomTask.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservationRoomTask'.DTR.'ReservationRoomTaskID'];
		//if(empty($entityID)) {$entityID = $input['ReservationRoomTaskID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationRoomTaskServer.adminReservationRoomTask');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservationRoomTask WHERE ReservationRoomTaskID='$entityID'");
		}
		$SERVER->setMessage('ReservationRoomTaskClass.deleteReservationRoomTask.msg.DataDeleted');
		$SERVER->setDebug('ReservationRoomTaskClass.deleteReservationRoomTask.End','End');		
		return $result;		
	}	


	function copyReservationRoomTask($input)
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
		$ReservationRoomTaskTemplateID = $input['selectedReservationRoomTaskID'];
		$ReservationRoomTaskID = $input['ReservationRoomTaskID'];
		if($ReservationRoomTaskID==$ReservationRoomTaskTemplateID) {return false;}
		//set client side variables
		if(!empty($ReservationRoomTaskTemplateID) && !empty($ReservationRoomTaskID))
		{
			//make ReservationRoomTask link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ReservationRoomTaskField WHERE ReservationRoomTaskID='$ReservationRoomTaskTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ReservationRoomTaskField'] = "ReservationRoomTaskFieldID = ''";
			$inputNew['ReservationRoomTaskField'.DTR.'ReservationRoomTaskFieldID']='';
			$inputNew['ReservationRoomTaskField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ReservationRoomTaskField'.DTR.'UserID']=$userID;
			$inputNew['ReservationRoomTaskField'.DTR.'ReservationRoomTaskID']=$ReservationRoomTaskID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ReservationRoomTaskField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ReservationRoomTaskField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ReservationRoomTaskField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ReservationRoomTaskField WHERE BoxID='".$inputNew['ReservationRoomTaskField'.DTR.'BoxID']."' AND ReservationRoomTaskID='".$ReservationRoomTaskID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new ReservationRoomTask
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
} // end of ReservationRoomTaskServer
?>