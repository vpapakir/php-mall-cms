<?php
//XCMSPro: Web Service entity class
class BlogClass
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
	function BlogClass()
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
	function getBlogs($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogClass.getBlogs.Start','Start');
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
		if(empty($resourceID)) {$resourceID = $input['Blog'.DTR.'ResourceID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogServer.adminBlog');
		if(!empty($searchWord))
		{
			$filter .= " AND (BlogTitle LIKE '%$searchWord%' OR BlogKeywords LIKE '%$searchWord%' OR BlogContent LIKE '%$searchWord%')";
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
		/*elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}*/
		
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
		}
		
		$query = "SELECT * FROM Blog WHERE BlogID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM Blog WHERE BlogID>0 AND UserID='$userID' ORDER BY TimeCreated DESC ";
		}
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('BlogClass.getBlogs.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getBlog($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogClass.getBlog.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['Blog'.DTR.'BlogID'];
		if(empty($entityID)) {$entityID = $input['BlogID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Blog'];}
		if(empty($entityAlias)) {$entityAlias = $input['BlogAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Blog'.DTR.'BlogAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogServer.adminBlog');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " AND BlogAlias='$entityAlias' "; 
		}
		elseif(!empty($entityID))
		{
			$filter = " AND BlogID='$entityID' ";
		}
		
		if($manageMode=='user')
		{
			$filter = " AND UserID='$userID' ";
		}
		$query = "SELECT * FROM Blog WHERE BlogID>0 $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('BlogClass.getBlog.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setBlog($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogClass.setBlog.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Blog'.DTR.'BlogID'];
		if(empty($entityID)) {$entityID = $input['BlogID'];}		
		if(empty($input['Blog'.DTR.'PermAll'])) {$input['Blog'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['Blog'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['Blog'.DTR.'ResourceID'];
		$input['Blog'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['Blog'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['Blog'.DTR.'ResourceCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogServer.adminBlog');
		//set queries	
		//if(is_array($input['Blog'.DTR.'BlogLanguages'])) {$input['Blog'.DTR.'BlogLanguages'] = '|'. implode("|",$input['Blog'.DTR.'BlogLanguages']).'|'; }
		//if(is_array($input['Blog'.DTR.'BlogCategories'])) {$input['Blog'.DTR.'BlogCategories'] = '|'. implode("|",$input['Blog'.DTR.'BlogCategories']).'|'; }
			
		//if(is_array($input['Blog'.DTR.'AccessGroups'])) {$input['Blog'.DTR.'AccessGroups'] = '|'. implode("|",$input['Blog'.DTR.'AccessGroups']).'|'; }
		$where['Blog'] = "BlogID = '".$entityID."'".$filter;

		if(!empty($input['Blog'.DTR.'BlogTitle']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT BlogAlias FROM Blog WHERE BlogAlias='".$input['Blog'.DTR.'BlogAlias']."'");
		}
		if(!empty($input['Blog'.DTR.'BlogTitle']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['BlogID'];
		}
		else
		{
			if(!empty($input['Blog'.DTR.'BlogTitle']))
			{
				$SERVER->setMessage('BlogClass.setBlog.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('BlogClass.setBlog.msg.DataSaved');
		}
		//if(!empty($input['Blog'.DTR.'BlogAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Blog');
		//}
		$SERVER->setDebug('BlogClass.setBlog.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteBlog($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Blog'.DTR.'BlogID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM BlogRecord WHERE BlogID='$entityID'");
			$DS->query("DELETE FROM Blog WHERE BlogID='$entityID'");
		}
		//$SERVER->setMessage('BlogClass.deleteBlog.msg.DataDeleted');
		return $result;		
	}	
} // end of BlogServer
?>