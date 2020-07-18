<?php
//XCMSPro: Web Service entity class
class PropertyCommentClass
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
	function PropertyCommentClass()
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
	function getPropertyComments($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyCommentClass.getPropertyComments.Start','Start');
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
		
				
		$sectionID = $input['SectionID'];
		if(empty($sectionID)) {$sectionID = $input['SID'];}
		
		$propertyID = $input['PropertyID'];
		if(empty($propertyID)) {$propertyID = $input['PropertyComment'.DTR.'PropertyID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyCommentServer.adminPropertyComment');
		if(!empty($searchWord))
		{
			$filter .= " AND (PropertyCommentTitle LIKE '%$searchWord%' OR PropertyCommentKeywords LIKE '%$searchWord%' OR PropertyCommentContent LIKE '%$searchWord%')";
		}

		if(!empty($propertyID))
		{
			$filter .= " AND PropertyID = '$propertyID' ";
		}	
		/*elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND PropertyID < 1 ";
		}
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND SectionID = '$sectionID' AND PropertyID < 1 ";
		}*/
		
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
				$filter .= " AND PermAll='1' ";
			}
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		$query = "SELECT * FROM PropertyComment WHERE PropertyCommentID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		//echo $query;
		//get the content
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM PropertyComment WHERE PropertyCommentID>0 AND UserID='$userID'  ORDER BY TimeCreated DESC ";
		}
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyCommentClass.getPropertyComments.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getPropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyCommentClass.getPropertyComment.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyComment'.DTR.'PropertyCommentID'];
		if(empty($entityID)) {$entityID = $input['PropertyCommentID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyComment'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyCommentAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyComment'.DTR.'PropertyCommentAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyCommentServer.adminPropertyComment');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyCommentAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyCommentID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyComment WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('PropertyCommentClass.getPropertyComment.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setPropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyCommentClass.setPropertyComment.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyComment'.DTR.'PropertyCommentID'];
		if(empty($entityID)) {$entityID = $input['PropertyCommentID'];}		
		if(empty($input['PropertyComment'.DTR.'PermAll'])) {$input['PropertyComment'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['PropertyComment'.DTR.'PermAll']=4;}
		
		//get property, section, category or location
		$propertyID = $input['PropertyID'];
		if(empty($propertyID)) $propertyID = $input['PropertyComment'.DTR.'PropertyID'];
		$input['PropertyComment'.DTR.'PropertyID'] = $propertyID;
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyCommentServer.adminPropertyComment');
		//set queries	
		//if(is_array($input['PropertyComment'.DTR.'PropertyCommentLanguages'])) {$input['PropertyComment'.DTR.'PropertyCommentLanguages'] = '|'. implode("|",$input['PropertyComment'.DTR.'PropertyCommentLanguages']).'|'; }
		//if(is_array($input['PropertyComment'.DTR.'PropertyCommentCategories'])) {$input['PropertyComment'.DTR.'PropertyCommentCategories'] = '|'. implode("|",$input['PropertyComment'.DTR.'PropertyCommentCategories']).'|'; }
			
		//if(is_array($input['PropertyComment'.DTR.'AccessGroups'])) {$input['PropertyComment'.DTR.'AccessGroups'] = '|'. implode("|",$input['PropertyComment'.DTR.'AccessGroups']).'|'; }
		
		//check if this user already added a comment to this property or if the property is created by the user
		$saveError='N';
		if(!empty($propertyID))
		{
			$checkPropertyRS = $DS->query("SELECT UserID FROM Property WHERE PropertyID='$propertyID'");
			if($checkPropertyRS[0]['UserID']==$userID)
			{
				$saveError = 'Y';
				$SERVER->setMessage('property.PropertyCommentClass.setPropertyComment.err.OwnProperty');
			}
			else
			{
				$checkPropertyCommentRS = $DS->query("SELECT PropertyCommentID FROM PropertyComment WHERE PropertyID='$propertyID' AND UserID='$userID'");
				if(count($checkPropertyCommentRS)>0)
				{
					$saveError = 'Y';
					$SERVER->setMessage('property.PropertyCommentClass.setPropertyComment.err.AlreadyAdded');
				}		
			}
		}
		
		if($saveError!='Y')
		{
			$where['PropertyComment'] = "PropertyCommentID = '".$entityID."'".$filter;
	
			if(!empty($input['PropertyComment'.DTR.'PropertyCommentTitle']) && $input['actionMode']=='add')
			{
				//$checkRS=$DS->query("SELECT PropertyCommentAlias FROM PropertyComment WHERE PropertyCommentAlias='".$input['PropertyComment'.DTR.'PropertyCommentAlias']."'");
			}
			if(!empty($input['PropertyComment'.DTR.'PropertyCommentTitle']))
			{		
				$input['actionMode']='save';					
				$result = $DS->save($input,$where);
				$entityID = $result[0]['PropertyCommentID'];
			}
			else
			{
				if(!empty($input['PropertyComment'.DTR.'PropertyCommentTitle']))
				{
					$SERVER->setMessage('PropertyCommentClass.setPropertyComment.err.AlreadyExists');
				}
			}
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('PropertyCommentClass.setPropertyComment.msg.DataSaved');
			}
		}
		//if(!empty($input['PropertyComment'.DTR.'PropertyCommentAlias']))
		//{
			//$this->updateEntityPositions($entityID,'PropertyComment');
		//}
		$SERVER->setDebug('PropertyCommentClass.setPropertyComment.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deletePropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyComment'.DTR.'PropertyCommentID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PropertyComment WHERE PropertyCommentID='$entityID'");
		}
		//$SERVER->setMessage('PropertyCommentClass.deletePropertyComment.msg.DataDeleted');
		return $result;		
	}	
} // end of PropertyCommentServer
?>