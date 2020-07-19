<?php
//XCMSPro: Web Service entity class
class TabLinkClass
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
	function TabLinkClass()
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
	function getTabLinks($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TabLinkClass.getTabLinks.Start','Start');
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
		$entityAlias = $input['TabLinkAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['TabLink'.DTR.'TabLinkAlias'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TabLinkServer.adminTabLink');
		if(!empty($searchWord))
		{
			$filter .= " AND (TabLinkName LIKE '{ls}%$searchWord%{le}' OR TabLinkName LIKE '%$searchWord%' OR TabLinkDescription LIKE '{ls}%$searchWord%{le}' OR TabLinkDescription LIKE '%$searchWord%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM TabLink WHERE TabLinkAlias= '$entityAlias' $filter ORDER BY TabLinkPosition";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TabLinkClass.getTabLinks.End','End');
		return $result;
	}	
	/**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTabLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TabLinkClass.getTabLink.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TabLink'.DTR.'TabLinkID'];
		if(empty($entityID)) {$entityID = $input['TabLinkID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TabLink'];}
		if(empty($entityAlias)) {$entityAlias = $input['TabLinkAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TabLink'.DTR.'TabLinkAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TabLinkServer.adminTabLink');
		//set queries
		$query =='';
		//if(!empty($entityAlias))
		//{
			//$filter = " TabLinkAlias='$entityAlias' "; 
		//}
		//else
		//{
			
		//}
		$filter = " TabLinkID='$entityID' ";
		$query = "SELECT * FROM TabLink WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('TabLinkClass.getTabLink.End','End');		
		return $result;		
	}
		
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTabLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TabLinkClass.setTabLink.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TabLink'.DTR.'TabLinkID'];
		if(empty($entityID)) {$entityID = $input['TabLinkID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TabLinkServer.adminTabLink');
		//set queries	
		//if(is_array($input['TabLink'.DTR.'AccessGroups'])) {$input['TabLink'.DTR.'AccessGroups'] = '|'. implode("|",$input['TabLink'.DTR.'AccessGroups']).'|';}
		$where['TabLink'] = "TabLinkID = '".$entityID."'".$filter;

		if(!empty($input['TabLink'.DTR.'TabLinkValue']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT TabLinkValue FROM TabLink WHERE TabLinkValue='".$input['TabLink'.DTR.'TabLinkValue']."'");
		}
		if(count($checkRS)<1 && !empty($input['TabLink'.DTR.'TabLinkAlias']) && !empty($input['TabLink'.DTR.'TabLinkValue']) && !empty($input['TabLink'.DTR.'TabLinkName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['TabLink'.DTR.'TabLinkValue']))
			{
				$SERVER->setMessage('TabLinkClass.setTabLink.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TabLinkClass.setTabLink.msg.DataSaved');
		}
		if(!empty($input['TabLink'.DTR.'TabLinkValue']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'TabLink');
		}
		$SERVER->setDebug('TabLinkClass.setTabLink.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTabLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TabLinkClass.deleteTabLink.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TabLink'.DTR.'TabLinkID'];
		//if(empty($entityID)) {$entityID = $input['TabLinkID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TabLinkServer.adminTabLink');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TabLink WHERE TabLinkID='$entityID'");
		}
		$SERVER->setMessage('TabLinkClass.deleteTabLink.msg.DataDeleted');
		$SERVER->setDebug('TabLinkClass.deleteTabLink.End','End');		
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
} // end of TabLinkServer
?>