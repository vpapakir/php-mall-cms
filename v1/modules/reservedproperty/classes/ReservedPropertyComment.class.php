<?php
//XCMSPro: Web Service entity class
class ReservedPropertyCommentClass
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
	function ReservedPropertyCommentClass()
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
	function getReservedPropertyComments($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyCommentClass.getReservedPropertyComments.Start','Start');
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
		
		$reservedPropertyID = $input['ReservedPropertyID'];
		if(empty($reservedPropertyID)) {$reservedPropertyID = $input['ReservedPropertyComment'.DTR.'ReservedPropertyID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyCommentServer.adminReservedPropertyComment');
		if(!empty($searchWord))
		{
			$filter .= " AND (ReservedPropertyCommentTitle LIKE '%$searchWord%' OR ReservedPropertyCommentKeywords LIKE '%$searchWord%' OR ReservedPropertyCommentContent LIKE '%$searchWord%')";
		}

		if(!empty($reservedPropertyID))
		{
			$filter .= " AND ReservedPropertyID = '$reservedPropertyID' ";
		}	
		/*elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND ReservedPropertyID < 1 ";
		}
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND SectionID = '$sectionID' AND ReservedPropertyID < 1 ";
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
		$query = "SELECT * FROM ReservedPropertyComment WHERE ReservedPropertyCommentID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		//echo $query;
		//get the content
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM ReservedPropertyComment WHERE ReservedPropertyCommentID>0 AND UserID='$userID'  ORDER BY TimeCreated DESC ";
		}
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyCommentClass.getReservedPropertyComments.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservedPropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyCommentClass.getReservedPropertyComment.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyCommentID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyComment'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyCommentAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyCommentServer.adminReservedPropertyComment');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyCommentAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyCommentID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyComment WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('ReservedPropertyCommentClass.getReservedPropertyComment.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservedPropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyCommentClass.setReservedPropertyComment.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyCommentID'];}		
		if(empty($input['ReservedPropertyComment'.DTR.'PermAll'])) {$input['ReservedPropertyComment'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['ReservedPropertyComment'.DTR.'PermAll']=4;}
		
		//get reservedProperty, section, category or location
		$reservedPropertyID = $input['ReservedPropertyID'];
		if(empty($reservedPropertyID)) $reservedPropertyID = $input['ReservedPropertyComment'.DTR.'ReservedPropertyID'];
		$input['ReservedPropertyComment'.DTR.'ReservedPropertyID'] = $reservedPropertyID;
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyCommentServer.adminReservedPropertyComment');
		//set queries	
		//if(is_array($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentLanguages'])) {$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentLanguages'] = '|'. implode("|",$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentLanguages']).'|'; }
		//if(is_array($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentCategories'])) {$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentCategories'] = '|'. implode("|",$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentCategories']).'|'; }
			
		//if(is_array($input['ReservedPropertyComment'.DTR.'AccessGroups'])) {$input['ReservedPropertyComment'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedPropertyComment'.DTR.'AccessGroups']).'|'; }
		
		//check if this user already added a comment to this reservedProperty or if the reservedProperty is created by the user
		$saveError='N';
		if(!empty($reservedPropertyID))
		{
			$checkReservedPropertyRS = $DS->query("SELECT UserID FROM ReservedProperty WHERE ReservedPropertyID='$reservedPropertyID'");
			if($checkReservedPropertyRS[0]['UserID']==$userID)
			{
				$saveError = 'Y';
				$SERVER->setMessage('reservedProperty.ReservedPropertyCommentClass.setReservedPropertyComment.err.OwnReservedProperty');
			}
			else
			{
				$checkReservedPropertyCommentRS = $DS->query("SELECT ReservedPropertyCommentID FROM ReservedPropertyComment WHERE ReservedPropertyID='$reservedPropertyID' AND UserID='$userID'");
				if(count($checkReservedPropertyCommentRS)>0)
				{
					$saveError = 'Y';
					$SERVER->setMessage('reservedProperty.ReservedPropertyCommentClass.setReservedPropertyComment.err.AlreadyAdded');
				}		
			}
		}
		
		if($saveError!='Y')
		{
			$where['ReservedPropertyComment'] = "ReservedPropertyCommentID = '".$entityID."'".$filter;
	
			if(!empty($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentTitle']) && $input['actionMode']=='add')
			{
				//$checkRS=$DS->query("SELECT ReservedPropertyCommentAlias FROM ReservedPropertyComment WHERE ReservedPropertyCommentAlias='".$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentAlias']."'");
			}
			if(!empty($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentTitle']))
			{		
				$input['actionMode']='save';					
				$result = $DS->save($input,$where);
				$entityID = $result[0]['ReservedPropertyCommentID'];
			}
			else
			{
				if(!empty($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentTitle']))
				{
					$SERVER->setMessage('ReservedPropertyCommentClass.setReservedPropertyComment.err.AlreadyExists');
				}
			}
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('ReservedPropertyCommentClass.setReservedPropertyComment.msg.DataSaved');
			}
		}
		//if(!empty($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ReservedPropertyComment');
		//}
		$SERVER->setDebug('ReservedPropertyCommentClass.setReservedPropertyComment.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservedPropertyComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservedPropertyComment WHERE ReservedPropertyCommentID='$entityID'");
		}
		//$SERVER->setMessage('ReservedPropertyCommentClass.deleteReservedPropertyComment.msg.DataDeleted');
		return $result;		
	}	
} // end of ReservedPropertyCommentServer
?>