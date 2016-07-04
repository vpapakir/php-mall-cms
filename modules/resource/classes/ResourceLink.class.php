<?php
//XCMSPro: Web Service entity class
class ResourceLinkClass
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
	function ResourceLinkClass()
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
	function getResourceLinks($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceLinkClass.getResourceLinks.Start','Start');
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
		if(empty($resourceID)) {$resourceID = $input['ResourceLink'.DTR.'ResourceID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceLinkServer.adminResourceLink');
		if(!empty($searchWord))
		{
			$filter .= " AND (ResourceLinkTitle LIKE '%$searchWord%' OR ResourceLinkKeywords LIKE '%$searchWord%' OR ResourceLinkContent LIKE '%$searchWord%')";
		}

		if(!empty($resourceID))
		{
			$filter .= " AND ResourceID = '$resourceID' ";
		}	
		elseif(!empty($categoryID))
		{
			//$filter .= " AND (ResourceCategoryID = '$categoryID') AND ResourceID < 1 ";
			$filter .= " AND ResourceCategoryID = '$categoryID' ";
		}		
		elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}
		
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		
		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			$filter .= " AND PermAll='$PermAll' ";
		}
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
			$filter .= " AND PermAll='4' ";
		}
		
		$query = "SELECT * FROM ResourceLink WHERE ResourceLinkID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM ResourceLink WHERE ResourceLinkID>0 AND UserID='$userID' ORDER BY TimeCreated DESC ";
		}
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceLinkClass.getResourceLinks.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getResourceLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceLinkClass.getResourceLink.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceLink'.DTR.'ResourceLinkID'];
		if(empty($entityID)) {$entityID = $input['ResourceLinkID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceLink'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceLinkAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceLink'.DTR.'ResourceLinkAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceLinkServer.adminResourceLink');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceLinkAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceLinkID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceLink WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('ResourceLinkClass.getResourceLink.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResourceLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceLinkClass.setResourceLink.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceLink'.DTR.'ResourceLinkID'];
		if(empty($entityID)) {$entityID = $input['ResourceLinkID'];}		
		if(empty($input['ResourceLink'.DTR.'PermAll'])) {$input['ResourceLink'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['ResourceLink'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['ResourceLink'.DTR.'ResourceID'];
		$input['ResourceLink'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['ResourceLink'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['ResourceLink'.DTR.'ResourceCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceLinkServer.adminResourceLink');
		//set queries	
		//if(is_array($input['ResourceLink'.DTR.'ResourceLinkLanguages'])) {$input['ResourceLink'.DTR.'ResourceLinkLanguages'] = '|'. implode("|",$input['ResourceLink'.DTR.'ResourceLinkLanguages']).'|'; }
		//if(is_array($input['ResourceLink'.DTR.'ResourceLinkCategories'])) {$input['ResourceLink'.DTR.'ResourceLinkCategories'] = '|'. implode("|",$input['ResourceLink'.DTR.'ResourceLinkCategories']).'|'; }
			
		//if(is_array($input['ResourceLink'.DTR.'AccessGroups'])) {$input['ResourceLink'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceLink'.DTR.'AccessGroups']).'|'; }
		$where['ResourceLink'] = "ResourceLinkID = '".$entityID."'".$filter;

		if(!empty($input['ResourceLink'.DTR.'ResourceLinkTitle']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT ResourceLinkAlias FROM ResourceLink WHERE ResourceLinkAlias='".$input['ResourceLink'.DTR.'ResourceLinkAlias']."'");
		}
		if(!empty($input['ResourceLink'.DTR.'ResourceLinkTitle']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ResourceLinkID'];
		}
		else
		{
			if(!empty($input['ResourceLink'.DTR.'ResourceLinkTitle']))
			{
				$SERVER->setMessage('ResourceLinkClass.setResourceLink.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ResourceLinkClass.setResourceLink.msg.DataSaved');
		}
		//if(!empty($input['ResourceLink'.DTR.'ResourceLinkAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ResourceLink');
		//}
		$SERVER->setDebug('ResourceLinkClass.setResourceLink.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceLink($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceLink'.DTR.'ResourceLinkID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceLink WHERE ResourceLinkID='$entityID'");
		}
		//$SERVER->setMessage('ResourceLinkClass.deleteResourceLink.msg.DataDeleted');
		return $result;		
	}	
} // end of ResourceLinkServer
?>