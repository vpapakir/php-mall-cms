<?php
//XCMSPro: Web Service entity class
class ResourceCommentClass
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
	function ResourceCommentClass()
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
	function getResourceComments($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceCommentClass.getResourceComments.Start','Start');
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
		//print_r($input);
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
		if(empty($resourceID)) {$resourceID = $input['ResourceComment'.DTR.'ResourceID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceCommentServer.adminResourceComment');
		if(!empty($searchWord))
		{
			$filter .= " AND (ResourceCommentTitle LIKE '%$searchWord%' OR ResourceCommentKeywords LIKE '%$searchWord%' OR ResourceCommentContent LIKE '%$searchWord%')";
		}

		if(!empty($resourceID))
		{
			$filter .= " AND ResourceID = '$resourceID' ";
		}	
		elseif(!empty($categoryID))
		{
			$filter .= " AND (ResourceCategoryID = '$categoryID') AND ResourceID < 1 ";
		}	
		/*elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}*/
		elseif($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND SectionID = '$sectionID' AND ResourceID < 1 ";
		}
		
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}
		else
		{
			if($filterMode!='last' && $clientType!='admin' && $manageMode!='user')
			{		
				//$filter .= " AND PermAll='1' ";
				$filter .= "AND ((TimeCreated>(NOW() - INTERVAL ".$config['guestbooktime']." DAY) AND PermAll='4') OR PermAll='1')";
			}
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		$query = "SELECT * FROM ResourceComment WHERE ResourceCommentID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		//echo $query;
		//get the content
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM ResourceComment WHERE ResourceCommentID>0 AND UserID='$userID'  ORDER BY TimeCreated DESC ";
		}
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceCommentClass.getResourceComments.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getResourceComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceCommentClass.getResourceComment.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceComment'.DTR.'ResourceCommentID'];
		if(empty($entityID)) {$entityID = $input['ResourceCommentID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceComment'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCommentAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceComment'.DTR.'ResourceCommentAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceCommentServer.adminResourceComment');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceCommentAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceCommentID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceComment WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('ResourceCommentClass.getResourceComment.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResourceComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceCommentClass.setResourceComment.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceComment'.DTR.'ResourceCommentID'];
		if(empty($entityID)) {$entityID = $input['ResourceCommentID'];}		
		if(empty($input['ResourceComment'.DTR.'PermAll'])) {$input['ResourceComment'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')){
			$input['ResourceComment'.DTR.'PermAll']=4;
		}else{
			$input['ResourceComment'.DTR.'PermAll']=1;
		}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['ResourceComment'.DTR.'ResourceID'];
		$input['ResourceComment'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['ResourceComment'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['ResourceComment'.DTR.'ResourceCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceCommentServer.adminResourceComment');
		//set queries	
		//if(is_array($input['ResourceComment'.DTR.'ResourceCommentLanguages'])) {$input['ResourceComment'.DTR.'ResourceCommentLanguages'] = '|'. implode("|",$input['ResourceComment'.DTR.'ResourceCommentLanguages']).'|'; }
		//if(is_array($input['ResourceComment'.DTR.'ResourceCommentCategories'])) {$input['ResourceComment'.DTR.'ResourceCommentCategories'] = '|'. implode("|",$input['ResourceComment'.DTR.'ResourceCommentCategories']).'|'; }
			
		//if(is_array($input['ResourceComment'.DTR.'AccessGroups'])) {$input['ResourceComment'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceComment'.DTR.'AccessGroups']).'|'; }
		
		//check if this user already added a comment to this resource or if the resource is created by the user
		$saveError='N';
		if(!empty($resourceID))
		{
			$checkResourceRS = $DS->query("SELECT UserID FROM Resource WHERE ResourceID='$resourceID'");
			if($checkResourceRS[0]['UserID']==$userID)
			{
				$saveError = 'Y';
				$SERVER->setMessage('resource.ResourceCommentClass.setResourceComment.err.OwnResource');
			}
			else
			{
				$checkResourceCommentRS = $DS->query("SELECT ResourceCommentID FROM ResourceComment WHERE ResourceID='$resourceID' AND UserID='$userID'");
				if(count($checkResourceCommentRS)>0)
				{
					$saveError = 'Y';
					$SERVER->setMessage('resource.ResourceCommentClass.setResourceComment.err.AlreadyAdded');
				}		
			}
		}
		
		if($saveError!='Y')
		{
			$where['ResourceComment'] = "ResourceCommentID = '".$entityID."'".$filter;
	
			if(!empty($input['ResourceComment'.DTR.'ResourceCommentTitle']) && $input['actionMode']=='add')
			{
				//$checkRS=$DS->query("SELECT ResourceCommentAlias FROM ResourceComment WHERE ResourceCommentAlias='".$input['ResourceComment'.DTR.'ResourceCommentAlias']."'");
			}
			if(!empty($input['ResourceComment'.DTR.'ResourceCommentTitle']))
			{		
				$input['ResourceComment'.DTR.'TimeCreated'] = '';
				$input['actionMode']='save';					
				if($input['insert'] == 'insert'){
					$result = $DS->save($input,$where,'insert');
				}else{
					$result = $DS->save($input,$where);
				}
				$entityID = $result[0]['ResourceCommentID'];
			}
			else
			{
				if(!empty($input['ResourceComment'.DTR.'ResourceCommentTitle']))
				{
					$SERVER->setMessage('ResourceCommentClass.setResourceComment.err.AlreadyExists');
				}
			}
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('ResourceCommentClass.setResourceComment.msg.DataSaved');
			}
		}
		//if(!empty($input['ResourceComment'.DTR.'ResourceCommentAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ResourceComment');
		//}
		$SERVER->setDebug('ResourceCommentClass.setResourceComment.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceComment'.DTR.'ResourceCommentID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceComment WHERE ResourceCommentID='$entityID'");
		}
		//$SERVER->setMessage('ResourceCommentClass.deleteResourceComment.msg.DataDeleted');
		return $result;		
	}	
} // end of ResourceCommentServer
?>