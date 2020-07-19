<?php
//XCMSPro: Web Service entity class
class BlogRecordClass
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
	function BlogRecordClass()
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
	function getBlogRecords($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogRecordClass.getBlogRecords.Start','Start');
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
		if(empty($resourceID)) {$resourceID = $input['BlogRecord'.DTR.'ResourceID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogRecordServer.adminBlogRecord');
		if(!empty($searchWord))
		{
			$filter .= " AND (BlogRecordTitle LIKE '%$searchWord%' OR BlogRecordKeywords LIKE '%$searchWord%' OR BlogRecordContent LIKE '%$searchWord%')";
		}

		if(!empty($resourceID))
		{
			$filter .= " AND ResourceID = '$resourceID' ";
		}	
		/*elseif(!empty($categoryID))
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
		*/
		if(!empty($input['BlogID']))
		{
			$filter .= "AND BlogID='".$input['BlogID']."'";
		}
		elseif($clientType!='admin' && $manageMode=='user')
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
		
		$query = "SELECT * FROM BlogRecord WHERE BlogRecordID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM BlogRecord WHERE BlogRecordID>0 AND UserID='$userID' ORDER BY TimeCreated DESC ";
		}
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('BlogRecordClass.getBlogRecords.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getBlogRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogRecordClass.getBlogRecord.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['BlogRecord'.DTR.'BlogRecordID'];
		if(empty($entityID)) {$entityID = $input['BlogRecordID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['BlogRecord'];}
		if(empty($entityAlias)) {$entityAlias = $input['BlogRecordAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['BlogRecord'.DTR.'BlogRecordAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogRecordServer.adminBlogRecord');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " BlogRecordAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " BlogRecordID='$entityID' ";
		}
		$query = "SELECT * FROM BlogRecord WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('BlogRecordClass.getBlogRecord.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setBlogRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BlogRecordClass.setBlogRecord.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['BlogRecord'.DTR.'BlogRecordID'];
		if(empty($entityID)) {$entityID = $input['BlogRecordID'];}		
		if(empty($input['BlogRecord'.DTR.'PermAll'])) {$input['BlogRecord'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['BlogRecord'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['BlogRecord'.DTR.'ResourceID'];
		$input['BlogRecord'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['BlogRecord'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['BlogRecord'.DTR.'ResourceCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'BlogRecordServer.adminBlogRecord');
		//set queries	
		//if(is_array($input['BlogRecord'.DTR.'BlogRecordLanguages'])) {$input['BlogRecord'.DTR.'BlogRecordLanguages'] = '|'. implode("|",$input['BlogRecord'.DTR.'BlogRecordLanguages']).'|'; }
		//if(is_array($input['BlogRecord'.DTR.'BlogRecordCategories'])) {$input['BlogRecord'.DTR.'BlogRecordCategories'] = '|'. implode("|",$input['BlogRecord'.DTR.'BlogRecordCategories']).'|'; }
			
		//if(is_array($input['BlogRecord'.DTR.'AccessGroups'])) {$input['BlogRecord'.DTR.'AccessGroups'] = '|'. implode("|",$input['BlogRecord'.DTR.'AccessGroups']).'|'; }
		$where['BlogRecord'] = "BlogRecordID = '".$entityID."'".$filter;

		if(!empty($input['BlogRecord'.DTR.'BlogRecordTitle']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT BlogRecordAlias FROM BlogRecord WHERE BlogRecordAlias='".$input['BlogRecord'.DTR.'BlogRecordAlias']."'");
		}
		if(!empty($input['BlogRecord'.DTR.'BlogRecordTitle']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['BlogRecordID'];
		}
		else
		{
			if(!empty($input['BlogRecord'.DTR.'BlogRecordTitle']))
			{
				$SERVER->setMessage('BlogRecordClass.setBlogRecord.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('BlogRecordClass.setBlogRecord.msg.DataSaved');
		}
		//if(!empty($input['BlogRecord'.DTR.'BlogRecordAlias']))
		//{
			//$this->updateEntityPositions($entityID,'BlogRecord');
		//}
		$SERVER->setDebug('BlogRecordClass.setBlogRecord.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteBlogRecord($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['BlogRecord'.DTR.'BlogRecordID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM BlogRecord WHERE BlogRecordID='$entityID'");
		}
		//$SERVER->setMessage('BlogRecordClass.deleteBlogRecord.msg.DataDeleted');
		return $result;		
	}	
} // end of BlogRecordServer
?>