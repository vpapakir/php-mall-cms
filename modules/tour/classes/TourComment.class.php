<?php
//XCMSPro: Web Service entity class
class TourCommentClass
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
	function TourCommentClass()
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
	function getTourComments($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCommentClass.getTourComments.Start','Start');
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
			$categoryIDRS = $DS->query("SELECT TourCategoryID FROM TourCategory WHERE TourCategoryAlias='$categoryAlias'");
			$categoryID = $categoryIDRS[0]['TourCategoryID'];
		}
				
		$sectionID = $input['SectionID'];
		if(empty($sectionID)) {$sectionID = $input['SID'];}
		
		$tourID = $input['TourID'];
		if(empty($tourID)) {$tourID = $input['TourComment'.DTR.'TourID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCommentServer.adminTourComment');
		if(!empty($searchWord))
		{
			$filter .= " AND (TourCommentTitle LIKE '%$searchWord%' OR TourCommentKeywords LIKE '%$searchWord%' OR TourCommentContent LIKE '%$searchWord%')";
		}

		if(!empty($tourID))
		{
			$filter .= " AND TourID = '$tourID' ";
		}	
		elseif(!empty($categoryID))
		{
			$filter .= " AND (TourCategoryID = '$categoryID') AND TourID < 1 ";
		}		
		elseif(trim($input['SectionID']))
		{
			$filter .= " AND SectionID = '$sectionID' AND TourID < 1 ";
		}
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND SectionID = '$sectionID' AND TourID < 1 ";
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
		$query = "SELECT * FROM TourComment WHERE TourCommentID>0 $filter ORDER BY TimeCreated DESC ".$limit;
		//echo $query;
		//get the content
		if($sectionID=='myhome' || $sectionID=='myhomecomment' || $sectionID=='myhomelink')
		{
			$query = "SELECT * FROM TourComment WHERE TourCommentID>0 AND UserID='$userID'  ORDER BY TimeCreated DESC ";
		}
//		echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('TourCommentClass.getTourComments.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTourComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCommentClass.getTourComment.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourComment'.DTR.'TourCommentID'];
		if(empty($entityID)) {$entityID = $input['TourCommentID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourComment'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourCommentAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourComment'.DTR.'TourCommentAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCommentServer.adminTourComment');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " TourCommentAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourCommentID='$entityID' ";
		}
		$query = "SELECT * FROM TourComment WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('TourCommentClass.getTourComment.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTourComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCommentClass.setTourComment.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourComment'.DTR.'TourCommentID'];
		if(empty($entityID)) {$entityID = $input['TourCommentID'];}		
		if(empty($input['TourComment'.DTR.'PermAll'])) {$input['TourComment'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['TourComment'.DTR.'PermAll']=4;}
		
		//get tour, section, category or location
		$tourID = $input['TourID'];
		if(empty($tourID)) $tourID = $input['TourComment'.DTR.'TourID'];
		$input['TourComment'.DTR.'TourID'] = $tourID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['TourComment'.DTR.'TourCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT TourCategoryID FROM TourCategory WHERE TourCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['TourCategoryID'];
			}
		}
		$input['TourComment'.DTR.'TourCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCommentServer.adminTourComment');
		//set queries	
		//if(is_array($input['TourComment'.DTR.'TourCommentLanguages'])) {$input['TourComment'.DTR.'TourCommentLanguages'] = '|'. implode("|",$input['TourComment'.DTR.'TourCommentLanguages']).'|'; }
		//if(is_array($input['TourComment'.DTR.'TourCommentCategories'])) {$input['TourComment'.DTR.'TourCommentCategories'] = '|'. implode("|",$input['TourComment'.DTR.'TourCommentCategories']).'|'; }
			
		//if(is_array($input['TourComment'.DTR.'AccessGroups'])) {$input['TourComment'.DTR.'AccessGroups'] = '|'. implode("|",$input['TourComment'.DTR.'AccessGroups']).'|'; }
		
		//check if this user already added a comment to this tour or if the tour is created by the user
		$saveError='N';
		if(!empty($tourID))
		{
			$checkTourRS = $DS->query("SELECT UserID FROM Tour WHERE TourID='$tourID'");
			if($checkTourRS[0]['UserID']==$userID)
			{
				$saveError = 'Y';
				$SERVER->setMessage('tour.TourCommentClass.setTourComment.err.OwnTour');
			}
			else
			{
				$checkTourCommentRS = $DS->query("SELECT TourCommentID FROM TourComment WHERE TourID='$tourID' AND UserID='$userID'");
				if(count($checkTourCommentRS)>0)
				{
					$saveError = 'Y';
					$SERVER->setMessage('tour.TourCommentClass.setTourComment.err.AlreadyAdded');
				}		
			}
		}
		
		if($saveError!='Y')
		{
			$where['TourComment'] = "TourCommentID = '".$entityID."'".$filter;
	
			if(!empty($input['TourComment'.DTR.'TourCommentTitle']) && $input['actionMode']=='add')
			{
				//$checkRS=$DS->query("SELECT TourCommentAlias FROM TourComment WHERE TourCommentAlias='".$input['TourComment'.DTR.'TourCommentAlias']."'");
			}
			if(!empty($input['TourComment'.DTR.'TourCommentTitle']))
			{
//				if ($OwnerID!='1'){$OwnerID='1';}
				$input['actionMode']='save';					
				$result = $DS->save($input,$where,'insert');
				if(empty($entityID)) {$entityID=$DS->dbLastID();}
			}
			else
			{
				if(!empty($input['TourComment'.DTR.'TourCommentTitle']))
				{
					$SERVER->setMessage('TourCommentClass.setTourComment.err.AlreadyExists');
				}
			}
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('TourCommentClass.setTourComment.msg.DataSaved');
			}
		}
		//if(!empty($input['TourComment'.DTR.'TourCommentAlias']))
		//{
			//$this->updateEntityPositions($entityID,'TourComment');
		//}
		$SERVER->setDebug('TourCommentClass.setTourComment.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTourComment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourComment'.DTR.'TourCommentID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourComment WHERE TourCommentID='$entityID'");
		}
		//$SERVER->setMessage('TourCommentClass.deleteTourComment.msg.DataDeleted');
		return $result;		
	}	
} // end of TourCommentServer
?>