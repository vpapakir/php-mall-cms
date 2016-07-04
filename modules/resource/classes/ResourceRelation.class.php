<?php
//XCMSPro: Web Service entity class
class ResourceRelationClass
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
	function ResourceRelationClass()
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
	function getResourceRelations($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceRelationClass.getResourceRelations.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$manageMode = $input['manageMode'];
		$filterMode = $input['filterMode'];
		$entityID = $input['ResourceID'];
		if(empty($entityID)) {$entityID = $input['Resource'.DTR.'ResourceID'];}
		
		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			//$filter .= " AND ResourceRelation.PermAll='$PermAll' ";
		}
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT *,Resource.ResourceID FROM Resource, ResourceRelation WHERE Resource.ResourceID=ResourceRelation.ResourceRelatedID AND ResourceRelation.ResourceID='$entityID' $filter ORDER BY ResourceRelationPosition, ResourceRelationID ASC ";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		return $result;
	}	

	function searchResourceRelations($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$manageMode = $input['manageMode'];
		$searchWord = $input['searchWord'];
		$searchCode = $input['searchCode'];
		$filterMode = $input['filterMode'];
		$entityID = $input['ResourceID'];
		
		$categoryID = $input['SearchCategoryID'];
		$resourceType = $input['SearchResourceType'];
		if(empty($entityID)) {$entityID = $input['Resource'.DTR.'ResourceID'];}

		if(!empty($searchCode))
		{
			$filter .= " AND (ResourceAlias LIKE '%$searchWord%')  ";
		}
		if(!empty($categoryID))
		{
			$filter .= " AND (ResourceCategories LIKE '%|$categoryID|%')  ";
		}		
		if(!empty($resourceType))
		{
			$filter .= " AND (ResourceType='$resourceType')  ";
		}			
		
		if(!empty($searchWord))
		{
			$filter .= " AND (ResourceTitle LIKE '%$searchWord%' OR ResourceLink LIKE '%$searchWord%' OR ResourceReciprocalLink LIKE '%$searchWord%' OR ResourceIntro LIKE '%$searchWord%' OR ResourceContent LIKE '%$searchWord%' OR ResourceKeywords LIKE '%$searchWord%' OR ResourceAuthor LIKE '%$searchWord%' OR ResourceLocation LIKE '%$searchWord%')  ";
		}	
		
		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			//$filter .= " AND ResourceRelation.PermAll='$PermAll' ";
		}
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT *,Resource.ResourceID FROM Resource LEFT JOIN ResourceRelation ON Resource.ResourceID=ResourceRelation.ResourceRelatedID WHERE Resource.ResourceID>0 $filter ORDER BY Resource.ResourceID ASC LIMIT 0,200 ";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		return $result;
	}	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResourceRelation($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceRelationClass.setResourceRelation.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceRelation'.DTR.'ResourceRelationID'];
		if(empty($entityID)) {$entityID = $input['ResourceRelationID'];}		
		if(empty($input['ResourceRelation'.DTR.'PermAll'])) {$input['ResourceRelation'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['ResourceRelation'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['Resource'.DTR.'ResourceID'];
		$input['ResourceRelation'.DTR.'ResourceID'] = $resourceID;
		 
		$resourceRelatedID = $input['ResourceRelatedID'];
		$input['ResourceRelation'.DTR.'ResourceRelatedID'] = $resourceRelatedID;
		$process = 'N';
		if(!empty($entityID)){	$process = 'Y';	}
		elseif(!empty($resourceID) && !empty($resourceRelatedID)){$process = 'Y';}
		
		if(!empty($resourceID) && !empty($resourceRelatedID) && empty($entityID))
		{
			$checkRS = $DS->query("SELECT ResourceRelationID FROM ResourceRelation WHERE ResourceID='$resourceID' AND ResourceRelatedID='$resourceRelatedID'");
			if(count($checkRS)>0)
			{
				$process = 'N';
				$SERVER->setMessage('resource.ResourceRelationClass.setResourceRelation.err.Exists');
			}
		}
		if($process == 'Y')
		{
			$filter='';
			$where['ResourceRelation'] = "ResourceRelationID = '".$entityID."'".$filter;
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);		
		}
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceRelation($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceRelation'.DTR.'ResourceRelationID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceRelation WHERE ResourceRelationID='$entityID'");
		}
		//$SERVER->setMessage('ResourceRelationClass.deleteResourceRelation.msg.DataDeleted');
		return $result;		
	}	
} // end of ResourceRelationServer
?>