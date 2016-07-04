<?php
//XCMSPro: Web Service entity class

class MessageFolderServer
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
	function MessageFolderServer($controller,$ds)
	{
		$this->_controller = &$controller;
		$this->_DS = &$ds;
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
	function getMessageFolders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CategoryServer.getCategories.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['MessageFolder'.DTR.'MessageFolderID'];
		if(empty($entityID)) {$entityID = $input['MessageFolderID'];}
		$entityAlias = $input['MessageFolder'.DTR.'MessageFolderAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['MessageFolderAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['messageFolder'];}
		$searchWord = $input['searchWord'];
		//set filters
		$filter = $DS->getAccessFilter($input,'MessageFolderServer.adminMessageFolder');
		if(!empty($searchWord))
		{
			$filter .= " AND (MessageFolderName LIKE '{ls}%$searchWord%{le}' OR MessageFolderName LIKE '%$searchWord%' OR MessageFolderDescription LIKE '{ls}%$searchWord%{le}' OR MessageFolderDescription LIKE '%$searchWord%' OR MessageFolderComments LIKE '%$searchWord%')";
		}		
		//set queries
		$query = "MessageFolder[1 $filter]/sortdesc(MessageFolder.TimeSaved)"; 
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('MessageFolderServer.getMessageFolders.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getMessageFolder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageFolderServer.getMessageFolder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['MessageFolder'.DTR.'MessageFolderID'];
		if(empty($entityID)) {$entityID = $input['MessageFolderID'];}
		$entityAlias = $input['MessageFolder'.DTR.'MessageFolderAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['MessageFolderAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['messageFolder'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'MessageFolderServer.adminMessageFolder');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "MessageFolder[MessageFolderID='$entityID' $filter]/"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "MessageFolder[MessageFolderAlias='$entityAlias' $filter]/"; 
		}
		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			$SERVER->setMessage('MessageFolderServer.getMessageFolder.err.NoMessageFolderID');
		}
		$SERVER->setDebug('MessageFolderServer.getMessageFolder.End','End');		
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setMessageFolder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageFolderServer.setMessageFolder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['MessageFolder'.DTR.'MessageFolderID'];
		if(empty($entityID)) {$entityID = $input['MessageFolderID'];}		
		//set filters
		$filter = $DS->getAccessFilter($input,'MessageFolderServer.adminMessageFolder');
		//set queries
		if(is_array($input['MessageFolder'.DTR.'MessageFolderID']))
		{
			while (list($fieldNimber,$fieldValue)= each($input['MessageFolder'.DTR.'MessageFolderID'])) 
			{
				$where['MessageFolder'][] = "MessageFolderID = '".$fieldValue."'".$filter;
			}
		}
		else
		{
			$where['MessageFolder'] = "MessageFolderID = '".$entityID."'".$filter;
		}		
		$result = $DS->save($input,$where);	
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('MessageFolderServer.setMessageFolder.msg.DataSaved');
		}
		$SERVER->setDebug('MessageFolderServer.setMessageFolder.End','End');		
		return $result;		
	}
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteMessageFolder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageFolderServer.deleteMessageFolder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['MessageFolder'.DTR.'MessageFolderID'];
		if(empty($entityID)) {$entityID = $input['MessageFolderID'];}		
		//set filters
		$filter = $DS->getAccessFilter($input,'MessageFolderServer.adminMessageFolder');
		//set queries
		$input['actionMode']='delete';
		$where['MessageFolder'] = "MessageFolderID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('MessageFolderServer.deleteMessageFolder.msg.DataDeleted');
		$SERVER->setDebug('MessageFolderServer.deleteMessageFolder.End','End');		
		return $result;		
	}	
	
	
} // end of MessageFolderServer
?>