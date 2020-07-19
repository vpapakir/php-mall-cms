<?php
class OwnerClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	var $_currentLevel;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function OwnerClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getOwners($input)
	{
		//get global variables
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
		$orderMode = $input['orderMode'];
		$orderField = $input['orderField'];
		$permAll = $input['PermAll'];

		if(!empty($permAll))
		{
			$filter .= " AND PermAll='$permAll' ";
		}
		//set queries
		$query = "SELECT * FROM Owner WHERE OwnerID>0 $filter ORDER BY OwnerCode"; 		
		//get the content
		//echo $query;
		$result = $DS->query($query,$mode); 
		return $result;
	}
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getOwner($input)
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
		$entityID = $input['Owner'.DTR.'OwnerID'];
		if(empty($entityID)) {$entityID = $input['Owner'];}
		$entityAlias = $input['Owner'.DTR.'OwnerAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['OwnerAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['Owner'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'OwnerServer.adminOwner');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			//$query = "SELECT * FROM Owner WHERE OwnerID='$entityID' $filter"; 
		}
		elseif(!empty($entityAlias))
		{
			//$query = "Owner[OwnerAlias='$entityAlias' $filter]/"; 
		}
		else
		{
			
		}
		$query = "SELECT * FROM Owner WHERE UserID='$userID'";
		//get the content
		//echo $query;
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			//$SERVER->setMessage('OwnerServer.getOwner.err.NoOwnerID');
		}
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setOwner($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('OwnerServer.setOwner.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Owner'.DTR.'OwnerID'];
		if(empty($entityID)) {$entityID = $input['OwnerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'OwnerServer.adminOwner');
		//set queries
		$where['Owner'] = "OwnerID='".$input['Owner'.DTR.'OwnerID']."'";
		$input['actionMode']='save';
		
		//print_r($input);
		$saveResult = $DS->save($input,$where);
		$SERVER->setDebug('OwnerServer.setOwner.End','End');		
		return $result;		
	}
	
	function addOwner($input)
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
		$entityID = $input['Owner'.DTR.'OwnerID'];
		if(empty($entityID)) {$entityID = $input['OwnerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'OwnerServer.adminOwner');
		//set queries
		
		$len =  strlen($input['Owner'.DTR.'OwnerCode']);
		if($len>3)
		{

			$typeObject = new AliasDataType($SERVER);
			$ownerCode = $typeObject->setDataType($input['Owner'.DTR.'OwnerCode']);
		
			$testQuery = "SELECT OwnerID FROM Owner WHERE OwnerCode='".$input['Owner'.DTR.'OwnerCode']."'";
			$testRS = $DS->query($testQuery);
			
			$testQuery2 = "SELECT RegionID FROM Region WHERE RegionCode='".$input['Owner'.DTR.'OwnerCode']."'";
			$testRS2 = $DS->query($testQuery2);
			
			if(count($testRS)>0 || count($testRS2)>0)
			{
				$SERVER->setMessage('Owner.addOwner.err.OwnerNameTaken');
			}
			else
			{
				if(empty($input['Owner'.DTR.'OwnerDomain']))
				{
					$rootUrl = $config['rooturl'];
					$rootUrl = str_replace("http://","",$rootUrl);
					$rootUrl = str_replace("www.","",$rootUrl);
					$rootUrl = str_replace("/","",$rootUrl);
					$input['Owner'.DTR.'OwnerDomain'] = $ownerCode.'.'.$rootUrl;
				}
				//echo 'rrrrr='.$input['Owner'.DTR.'OwnerDomain'] ;
				//die('rrrr');
				if(empty($input['Owner'.DTR.'OwnerName']))
				{
					$input['Owner'.DTR.'OwnerName']['en'] = $input['Owner'.DTR.'OwnerCode'];
				}

				if(empty($input['Owner'.DTR.'OwnerType']))
				{
					$input['Owner'.DTR.'OwnerType'] = 'virtual';
				}				
				 
				//print_r($input);
				$where['Owner'] = "OwnerID=''";
				$input['actionMode']='save';
				//print_r($input);
				$saveResult = $DS->save($input,$where,'insert');
				
				//generate main sections
				
				if($config['OwnerGenerateSectionsMode']=='Y')
				{
					$now = $SERVER->getNow();
					$virtualSectionsGroupRS = $DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='virtual' ");
					
					$mainSectionsGroupRS = $DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='top' ");
					
					$virtualSectionsRS = $DS->query("SELECT * FROM Section WHERE SectionGroupID='".$virtualSectionsGroupRS[0]['SectionGroupID']."' ");
					
					foreach($virtualSectionsRS as $row)
					{
						$i=0;
						$names='';
						$values='';
						foreach($row as $fieldName=>$fieldValue)
						{
							$i++;
							if($fieldName=='SectionID')
							{
								$fieldValue = $SERVER->getUniqueID();
							}
							if($fieldName=='OwnerID')
							{
								$fieldValue = $ownerCode;
							}
							if($fieldName=='SectionGroupID')
							{
								$fieldValue = $mainSectionsGroupRS[0]['SectionGroupID'];
							}							
							if($fieldName=='UserID')
							{
								$fieldValue = $userID;
							}					
							if($fieldName=='TimeCreated')
							{
								$fieldValue = $now;
							}									
							if($fieldName=='TimeSaved')
							{
								$fieldValue = $now;
							}									
							if($i==1)
							{
								$names = $fieldName;
								$values = "'".addslashes($fieldValue)."'";
							}
							else
							{
								$names .= ",".$fieldName;
								$values .= ",'".addslashes($fieldValue)."'";
							}
							
						}
						
						$insertQuery = "INSERT INTO Section ($names) VALUES ($values)";
						//echo $insertQuery.'<br>';
						$DS->query($insertQuery);
					}
					
				}
				//die('rrr');
			}
		}
		else
		{
			$SERVER->setMessage('Owner.addOwner.err.OwnerNameShort');
		}
		return $saveResult;		
	}	
} // end of OwnerServer
?>