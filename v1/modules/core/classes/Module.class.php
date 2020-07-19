<?php
//XCMSPro: Web Service entity class
class ModuleClass
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
	function ModuleClass()
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
	function getModules($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ModuleClass.getModules.Start','Start');
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
		$entityAlias = $input['ModuleAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['Module'.DTR.'ModuleAlias'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ModuleServer.adminModule');
		if(!empty($searchWord))
		{
			$filter .= " AND (ModuleName LIKE '{ls}%$searchWord%{le}' OR ModuleName LIKE '%$searchWord%' OR ModuleDescription LIKE '{ls}%$searchWord%{le}' OR ModuleDescription LIKE '%$searchWord%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM Module ORDER BY ModuleAlias";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ModuleClass.getModules.End','End');
		return $result;
	}	
	
	function updateModulesList($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ModuleClass.getModules.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		
		$boxesDefinition = $SERVER->getBoxesDefinition();
		if(is_array($boxesDefinition))
		{
			foreach($boxesDefinition as $box)
			{
				$module = $box['module'];
				$boxModles[$module] = $module;
			}
		}
		
		$query = "SELECT * FROM Module ORDER BY ModuleAlias";
		$result = $DS->query($query);
		
		if(is_array($boxModles))
		{
			foreach($boxModles as $boxModuleName)
			{
				$exist = 'N';
				foreach($result as $row)
				{
					if($row['ModuleAlias']==$boxModuleName)
					{
						$exist = 'Y';
					}
				}
				if($exist == 'N')
				{
					$saveInput['Module'.DTR.'ModuleAlias'] = $boxModuleName;
					$saveInput['Module'.DTR.'ModuleName']['en'] = $boxModuleName;
					$saveInput['ationMode']='save';
					$this->setModule($saveInput);
				}
			}
		}

		return $result;
	}
	/**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getModule($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ModuleClass.getModule.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Module'.DTR.'ModuleID'];
		if(empty($entityID)) {$entityID = $input['ModuleID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Module'];}
		if(empty($entityAlias)) {$entityAlias = $input['ModuleAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Module'.DTR.'ModuleAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ModuleServer.adminModule');
		//set queries
		$query =='';
		//if(!empty($entityAlias))
		//{
			//$filter = " ModuleAlias='$entityAlias' "; 
		//}
		//else
		//{
			
		//}
		$filter = " ModuleID='$entityID' ";
		$query = "SELECT * FROM Module WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('ModuleClass.getModule.End','End');		
		return $result;		
	}
		
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setModule($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ModuleClass.setModule.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Module'.DTR.'ModuleID'];
		if(empty($entityID)) {$entityID = $input['ModuleID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ModuleServer.adminModule');
		//set queries	
			
		//if(is_array($input['Module'.DTR.'AccessGroups'])) {$input['Module'.DTR.'AccessGroups'] = '|'. implode("|",$input['Module'.DTR.'AccessGroups']).'|';}
		$where['Module'] = "ModuleID = '".$entityID."'".$filter;

		if(!empty($input['Module'.DTR.'ModuleAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT ModuleAlias FROM Module WHERE ModuleAlias='".$input['Module'.DTR.'ModuleAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['Module'.DTR.'ModuleAlias']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['Module'.DTR.'ModuleValue']))
			{
				$SERVER->setMessage('ModuleClass.setModule.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ModuleClass.setModule.msg.DataSaved');
		}
		if(!empty($input['Module'.DTR.'ModuleValue']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'Module');
		}
		$SERVER->setDebug('ModuleClass.setModule.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteModule($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ModuleClass.deleteModule.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Module'.DTR.'ModuleID'];
		//if(empty($entityID)) {$entityID = $input['ModuleID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ModuleServer.adminModule');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM Module WHERE ModuleID='$entityID'");
		}
		$SERVER->setMessage('ModuleClass.deleteModule.msg.DataDeleted');
		$SERVER->setDebug('ModuleClass.deleteModule.End','End');		
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
} // end of ModuleServer
?>