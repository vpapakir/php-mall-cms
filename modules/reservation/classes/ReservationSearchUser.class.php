<?php
//XCMSPro: Web Service entity class
class ReservationSearchUserClass
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
	function ReservationSearchUserClass()
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
	function getReservationSearchUsers($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationSearchUserClass.getReservationSearchUsers.Start','Start');
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
		$searchUser = $input['searchUser'];
		$ReservationSearchUserCategoryID = $input['ReservationSearchUserCategoryID'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationSearchUserServer.adminReservationSearchUser');
		if(!empty($searchUser))
		{
			$filter .= " AND (ReservationSearchUserTitle LIKE '{ls}%$searchUser%{le}' OR ReservationSearchUserTitle LIKE '%$searchUser%' OR ReservationSearchUserIntro LIKE '{ls}%$searchUser%{le}' OR ReservationSearchUserIntro LIKE '%$searchUser%' OR ReservationSearchUserContent LIKE '{ls}%$searchUser%{le}' OR ReservationSearchUserContent LIKE '%$searchUser%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		if(!empty($input['ReservationSearchUserType']))
		{
			$filter .= " AND ReservationSearchUserType='".$input['ReservationSearchUserType']."' ";
		}
		/*if($input['ReservationSearchUserType']=='tips')
		{
			$filter .= " AND ReservationSearchUserType='tips' ";
		}
		else
		{
			$filter .= " AND ReservationSearchUserType!='tips' ";
		}*/
		if(!empty($ReservationSearchUserCategoryID))
		{
			$filter .= " AND ReservationSearchUserCategories LIKE '%|$ReservationSearchUserCategoryID|%' ";
		}
		if(!empty($input['ReservationSearchUserClientType']))
		{
			$filter .= " AND ReservationSearchUserClientType = '".$input['ReservationSearchUserClientType']."' ";
		}
		//set queries
		$query = "SELECT * FROM ReservationSearchUser WHERE ReservationSearchUserID>0 $filter ORDER BY ReservationSearchUserID DESC";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservationSearchUserClass.getReservationSearchUsers.End','End');
		return $result;
	}	
	

    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservationSearchUser($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationSearchUserClass.getReservationSearchUser.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservationSearchUser'.DTR.'ReservationSearchUserID'];
		if(empty($entityID)) {$entityID = $input['ReservationSearchUserID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservationSearchUser'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservationSearchUserAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TipCode'];}
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationSearchUserServer.adminReservationSearchUser');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$filter = " ReservationSearchUserID='$entityID' ";
		}
		elseif(!empty($entityAlias))
		{
			$filter = " ReservationSearchUserAlias='$entityAlias' "; 
		}
		elseif($input['ReservationSearchUserType']=='tips')
		{	
			if(!empty($input['TipSection']))
			{
				$filter = " ReservationSearchUserSections='|".$input['TipSection']."|' ";
			}
			else
			{
				$filter = " ReservationSearchUserSections='|".$input['SID']."|' "; 
			}
		}		
		if(!empty($filter))
		{
			$query = "SELECT * FROM ReservationSearchUser WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	

		}
		//echo $query;
		//$SERVER->setDebug('ReservationSearchUserClass.getReservationSearchUser.End','End');	
		return $result;		
	}
	
	
	function getReservationUserFields($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    $result = $DS->query("SELECT * FROM UserFields WHERE FirstName LIKE '%".$input['searchUser']."%' OR LastName LIKE '%".$input['searchUser']."%'");
		
		return $result;
	}
	
	
	function getReservationSearchUserEmail($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    //$result = $DS->query("SELECT UserID, Email, UserName FROM User WHERE Email LIKE '%".$input['searchUser']."%'");
	    
	    $result = $DS->query("SELECT UserID, FirstName, LastName FROM UserFields WHERE UserID IN (SELECT UserID FROM User WHERE Email LIKE '%".$input['searchUser']."%')");
		
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
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservationSearchUser($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationSearchUserClass.setReservationSearchUser.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservationSearchUser'.DTR.'ReservationSearchUserID'];
		if(empty($entityID)) {$entityID = $input['ReservationSearchUserID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationSearchUserServer.adminReservationSearchUser');
		//set queries			
		//if(is_array($input['ReservationSearchUser'.DTR.'ReservationSearchUserSections'])) {$input['ReservationSearchUser'.DTR.'ReservationSearchUserSections'] = '|'. implode("|",$input['ReservationSearchUser'.DTR.'ReservationSearchUserSections']).'|'; }
		$where['ReservationSearchUser'] = "ReservationSearchUserID = '".$entityID."'".$filter;
		
		$checkAdd = $DS->query("SELECT * FROM ReservationSearchUser WHERE 
                    ReservationSearchUserTaskName = '".$input['ReservationSearchUser'.DTR.'ReservationSearchUserTaskName']."' AND ReservationSearchUserRoomID = '".$input['ReservationSearchUser'.DTR.'ReservationSearchUserRoomID']."'");

		if(empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias']) && !empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservationSearchUserTitle = $input['ReservationSearchUser'.DTR.'ReservationSearchUserTitle']['en'];
			if(empty($langReservationSearchUserTitle)) { $lang = $config['lang']; $langReservationSearchUserTitle = $input['ReservationSearchUser'.DTR.'ReservationSearchUserTitle'][$lang];}
			$input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias'] = $typeObject->setDataType($langReservationSearchUserTitle);
		}
		if(!empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias']))
		{
			$checkRS=$DS->query("SELECT ReservationSearchUserAlias FROM ReservationSearchUser WHERE ReservationSearchUserAlias='".$input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias'] = $input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias'].date('Ymd-His');
				$SERVER->setMessage('ReservationSearchUser.ReservationSearchUserClass.setReservationSearchUser.err.DuplicatedReservationSearchUserCode');
			}				
		}
        $separateDateField = 'ReservationSearchUser'.DTR.'ReservationSearchUserArrival'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
        $separateDateField = 'ReservationSearchUser'.DTR.'ReservationSearchUserDeparture'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
		if(!empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserTaskName']) && !empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserRoomDescription']) && empty($checkAdd) && $input['actionMode']=='add' && !empty($userID))
		{
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
		}
		elseif(!empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserTaskName']) && !empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserRoomDescription']) && $input['actionMode']=='save' && !empty($userID))
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
			if(!empty($input['ReservationSearchUser'.DTR.'ReservationSearchUserAlias']))
			{
				$SERVER->setMessage('ReservationSearchUserClass.setReservationSearchUser.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationSearchUserClass.setReservationSearchUser.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationSearchUserClass.setReservationSearchUser.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservationSearchUser($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationSearchUserClass.deleteReservationSearchUser.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservationSearchUser'.DTR.'ReservationSearchUserID'];
		//if(empty($entityID)) {$entityID = $input['ReservationSearchUserID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationSearchUserServer.adminReservationSearchUser');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservationSearchUser WHERE ReservationSearchUserID='$entityID'");
		}
		$SERVER->setMessage('ReservationSearchUserClass.deleteReservationSearchUser.msg.DataDeleted');
		$SERVER->setDebug('ReservationSearchUserClass.deleteReservationSearchUser.End','End');		
		return $result;		
	}	


	function copyReservationSearchUser($input)
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
		$ReservationSearchUserTemplateID = $input['selectedReservationSearchUserID'];
		$ReservationSearchUserID = $input['ReservationSearchUserID'];
		if($ReservationSearchUserID==$ReservationSearchUserTemplateID) {return false;}
		//set client side variables
		if(!empty($ReservationSearchUserTemplateID) && !empty($ReservationSearchUserID))
		{
			//make ReservationSearchUser link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ReservationSearchUserField WHERE ReservationSearchUserID='$ReservationSearchUserTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ReservationSearchUserField'] = "ReservationSearchUserFieldID = ''";
			$inputNew['ReservationSearchUserField'.DTR.'ReservationSearchUserFieldID']='';
			$inputNew['ReservationSearchUserField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ReservationSearchUserField'.DTR.'UserID']=$userID;
			$inputNew['ReservationSearchUserField'.DTR.'ReservationSearchUserID']=$ReservationSearchUserID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ReservationSearchUserField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ReservationSearchUserField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ReservationSearchUserField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ReservationSearchUserField WHERE BoxID='".$inputNew['ReservationSearchUserField'.DTR.'BoxID']."' AND ReservationSearchUserID='".$ReservationSearchUserID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new ReservationSearchUser
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
} // end of ReservationSearchUserServer
?>