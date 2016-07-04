<?php
//XCMSPro: Web Service entity class
class ResourceBidClass
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
	function ResourceBidClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$this->_session = $this->_controller->getSessionData();
		$this->_sessionID = $this->_controller->getCurrentSessionID();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getResourceBids($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceBidClass.getResourceBids.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		if(empty($entityAlias)) {$entityAlias = $input['ResourceBid'.DTR.'ResourceBidAlias'];}	
		
		if(!empty($userID))
		{
			$sessionFilter = " UserID='".$userID."' ";
		}
		else
		{
			$sessionFilter = " SessionID='".$sessionID."' ";
		}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM ResourceBid LEFT JOIN ResourceBidField ON ResourceBid.ResourceBidID = ResourceBidField.ResourceBidID  WHERE $sessionFilter ORDER BY ResourceBid.ResourceBidID";
		//get the content
		$rs = $DS->query($query); 
		
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$resourceID = $row['ResourceID'];
				$ResourceBidID = $row['ResourceBidID'];
				$resourceFieldAlias = $row['ResourceFieldAlias'];
				foreach($row as $fieldName=>$fieldValue)
				{
					if(eregi("ResourceField",$fieldName))
					{
						$result[$ResourceBidID]['ResourceBidFields'][$resourceFieldAlias][$fieldName] = $fieldValue;
					}
					else
					{
						$result[$ResourceBidID][$fieldName] = $fieldValue;
					}
				}
			}
		}
		$SERVER->setDebug('ResourceBidClass.getResourceBids.End','End');
		
		//print_r($result);
		return $result;
	}
	
	function getBids($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode= $input['viewMode'];
		$resourceID= $input['ResourceID'];
		if(empty($resourceID)) {$resourceID = $input['Resource'.DTR.'ResourceID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if($viewMode=='user')
		{
			$filter .= " AND ResourceBid.UserID='$userID' ";
		}
		else
		{
			if($SERVER->hasRights('admin'))
			{
				$filter .= " AND Resource.ResourceID='$resourceID' ";
			}
			else
			{
				$filter .= " AND Resource.UserID='$userID' AND Resource.ResourceID='$resourceID' ";
			}
			
		}
		//set queries
		$query = "SELECT *, ResourceBid.TimeCreated as TimeCreated, ResourceBid.PermAll as PermAll, ResourceBid.UserID as UserID FROM ResourceBid, Resource WHERE ResourceBid.ResourceID=Resource.ResourceID $filter  ORDER BY ResourceBid.ResourceBidID";
		//get the content
		//echo $query;
		$rs = $DS->query($query); 
		//print_r($rs);
		return $rs;
	}	


	function getResourceBidStats($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode= $input['viewMode'];
		$resourceID= $input['ResourceID'];
		if(empty($resourceID)) {$resourceID = $input['Resource'.DTR.'ResourceID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if(!empty($resourceID))
		{
			//get minimum bid
			$rs = $DS->query("SELECT MIN(ResourceBidPrice) AS ResourceMinimumBid FROM ResourceBid WHERE ResourceID='$resourceID' ");
			$result['ResourceMinimumBid'] = $rs[0]['ResourceMinimumBid'];
			//get highes bid
			$rs = $DS->query("SELECT MAX(ResourceBidPrice) AS ResourceHighestBid FROM ResourceBid WHERE ResourceID='$resourceID' ");
			$result['ResourceHighestBid'] = $rs[0]['ResourceHighestBid'];			
			//get number of bids
			$rs = $DS->query("SELECT COUNT(ResourceBidID) AS ResourceNumberOfBids FROM ResourceBid WHERE ResourceID='$resourceID' ");
			$result['ResourceNumberOfBids'] = $rs[0]['ResourceNumberOfBids'];			
		}
		//print_r($rs);
		return $result;
	}
		
	/**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getResourceBid($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceBidClass.getResourceBid.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceBid'.DTR.'ResourceBidID'];
		if(empty($entityID)) {$entityID = $input['ResourceBidID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceBid'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceBidAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceBid'.DTR.'ResourceBidAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//set queries
		$query =='';
		//if(!empty($entityAlias))
		//{
			//$filter = " ResourceBidAlias='$entityAlias' "; 
		//}
		//else
		//{
			
		//}
		$filter = " ResourceBidID='$entityID' ";
		$query = "SELECT * FROM ResourceBid WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('ResourceBidClass.getResourceBid.End','End');		
		return $result;		
	}

	function addResourceBid($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceBidClass.setResourceBid.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceBid'.DTR.'ResourceBidID'];
		if(empty($entityID)) {$entityID = $input['ResourceBidID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//set queries	
		
		$resourceID = $input['ResourceBid'.DTR.'ResourceID'];
		if(!empty($resourceID) && !empty($input['ResourceBid'.DTR.'ResourceBidPrice']))
		{
			//check user has already added a bid to this resource
			$bidsQuery = "SELECT ResourceBidID FROM ResourceBid WHERE ResourceID='$resourceID' AND UserID='$userID' ";
			$bidsRS = $DS->query($bidsQuery);
			$bidID = $bidsRS[0]['ResourceBidID'];
			if(empty($bidID))
			{
				$input['ResourceBid'.DTR.'ResourceID'] = $resourceID;
				$input['ResourceBid'.DTR.'ResourceBidStatus'] = 'new';
				$input['ResourceBid'.DTR.'ResourceBidAuthor '] = $user['UserName'];
	
				$where['ResourceBid'] = "ResourceBidID = '".$entityID."'";
				$input['actionMode']='save';		
				//print_r($input);			
				$result = $DS->save($input,$where);				
				//$lastID = $DS->dbLastID();
				//$input['ResourceBidField'.DTR.'ResourceBidID']=$lastID;
			}
			else
			{
				$SERVER->setMessage('ResourceBidClass.err.alreadyAdded.End','End');	
			}
		}
		$SERVER->setDebug('ResourceBidClass.setResourceBid.End','End');	

		return $result;		
	}

    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResourceBid($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceBidClass.setResourceBid.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceBid'.DTR.'ResourceBidID'];
		if(empty($entityID)) {$entityID = $input['ResourceBidID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//set queries	
		//if(is_array($input['ResourceBid'.DTR.'AccessGroups'])) {$input['ResourceBid'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceBid'.DTR.'AccessGroups']).'|';}
		if(is_array($input['ResourceBid'.DTR.'ResourceBidID']))
		{
			foreach($input['ResourceBid'.DTR.'ResourceBidID'] as $id=>$ResourceBidID)
			{
				$inputSave['ResourceBid'.DTR.'ResourceBidID'] = $ResourceBidID; 
				$inputSave['ResourceBid'.DTR.'ResourceBidQuantity'] = $input['ResourceBid'.DTR.'ResourceBidQuantity'][$id]; 
				
				if(!empty($inputSave['ResourceBid'.DTR.'ResourceBidQuantity']))
				{
					$inputSave['actionMode']='save';					
					$where['ResourceBid'] = "ResourceBidID = '".$ResourceBidID."'";
					$result = $DS->save($inputSave,$where);					
				}
				elseif(!empty($ResourceBidID))
				{
					$this->deleteResourceBid($ResourceBidID);
				}
			}
		}
		$this->emptyExpiredCarts();
		return $result;		
	}
	
	function emptyCart()
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceBidClass.setResourceBid.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		if(!empty($userID))
		{
			$sessionFilter = " UserID='".$userID."' ";
		}
		else
		{
			$sessionFilter = " SessionID='".$sessionID."' ";
		}
		$ResourceBidsRS = $DS->query("SELECT ResourceBidID FROM ResourceBid WHERE $sessionFilter ");
		foreach($ResourceBidsRS as $row)
		{
			$this->deleteResourceBid($row['ResourceBidID']);
		}			
				
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceBid($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		//set client side variables
		if(is_array($input))
		{
			$entityID = $input['ResourceBid'.DTR.'ResourceBidID'];
		}
		else
		{
			$entityID = $input;
		}
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceBid WHERE ResourceBidID='$entityID'");
			$DS->query("DELETE FROM ResourceBidField WHERE ResourceBidID='$entityID'");
		}
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
	
	function closeBidding($input)
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
		$entityID = $input['Resource'.DTR.'ResourceID'];
		if(empty($entityID)) {$entityID = $input['ResourceID'];}
		
		if(!empty($entityID))
		{
			//get top prices bids
			$query = "SELECT * FROM ResourceBid WHERE ResourceID='$entityID' ORDER BY ResourceBidPrice LIMIT 0,5";
			$rs= $DS->query($query);
			
			if(is_array($rs))
			{
				foreach ($rs as $row)
				{
					$query = "UPDATE ResourceBid SET ResourceBidStatus='sold' WHERE ResourceBidID='".$row['ResourceBidID']."'";
					$DS->query($query);
					//echo $query.'<br>';
				}
			}
			
			$query = "UPDATE Resource SET ResourceStatus='closed', PermAll='4' WHERE ResourceID='".$entityID."'";
			$DS->query($query);
		}		
		//set filters

		return $result;		
	}	
} // end of ResourceBidServer
?>