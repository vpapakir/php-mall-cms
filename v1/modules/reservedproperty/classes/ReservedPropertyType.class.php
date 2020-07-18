<?php
//XCMSPro: Web Service entity class
class ReservedPropertyTypeClass
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
	function ReservedPropertyTypeClass()
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
	function getReservedPropertyTypes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypes.Start','Start');
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
		$place = $input['reservedPropertyTypesPlace'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		if(!empty($searchWord))
		{
			//$filter .= " AND (ReservedPropertyTypeName LIKE '{ls}%$searchWord%{le}' OR ReservedPropertyTypeName LIKE '%$searchWord%' OR ReservedPropertyTypeDescription LIKE '{ls}%$searchWord%{le}' OR ReservedPropertyTypeDescription LIKE '%$searchWord%')";
		}
		if(!empty($place))		
		{		
			$filter .= " AND ReservedPropertyTypeHiddenPlaces NOT LIKE '%|$place|%'";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM ReservedPropertyType WHERE ReservedPropertyTypeID>1 $filter ORDER BY ReservedPropertyTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypes.End','End');
		return $result;
	}	
	
	function getReservedPropertyTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyType'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$reservedPropertyTypeIDRS = $DS->query("SELECT ReservedPropertyTypeID FROM ReservedPropertyType WHERE ReservedPropertyTypeAlias='$entityAlias'");
			$entityID = $reservedPropertyTypeIDRS[0]['ReservedPropertyTypeID'];
		}
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		if(!empty($entityID))		
		{
			$filter .= " AND ReservedPropertyTypeID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldID>0 $filter ORDER BY ReservedPropertyTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeFields.End','End');
		return $result;
	}	
	
	function getReservedPropertyTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeFieldID'];}
		
		$entityAlias = $input['ReservedPropertyField'];		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$reservedPropertyTypeIDRS = $DS->query("SELECT ReservedPropertyTypeFieldID FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldAlias='$entityAlias'");
			$entityID = $reservedPropertyTypeIDRS[0]['ReservedPropertyTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeFieldID='$entityID' $filter ORDER BY ReservedPropertyTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservedPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyType.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyType'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyTypeAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyTypeID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyType WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyType.End','End');		
		return $result;		
	}
	
	function getReservedPropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeFieldID'];}

		$entityAlias = $input['ReservedPropertyTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeField.End','End');		
		return $result;		
	}

	function getReservedPropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeOptionID'];}

		$entityAlias = $input['ReservedPropertyTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ReservedPropertyTypeClass.getReservedPropertyTypeOption.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservedPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.setReservedPropertyType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries	
		//if(is_array($input['ReservedPropertyType'.DTR.'AccessGroups'])) {$input['ReservedPropertyType'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedPropertyType'.DTR.'AccessGroups']).'|'; }
		$where['ReservedPropertyType'] = "ReservedPropertyTypeID = '".$entityID."'".$filter;
		if(empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']) && !empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservedPropertyTypeName = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeName']['en'];
			if(empty($langReservedPropertyTypeName)) { $lang = $config['lang']; $langReservedPropertyTypeName = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeName'][$lang];}
			$input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias'] = $typeObject->setDataType($langReservedPropertyTypeName);
		}	
		if(!empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']))
		{
			$checkRS=$DS->query("SELECT ReservedPropertyTypeAlias FROM ReservedPropertyType WHERE ReservedPropertyTypeAlias='".$input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias'] = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias'].date('Ymd-His');
				$SERVER->setMessage('reservedProperty.ReservedPropertyTypeClass.setReservedPropertyType.err.DuplicatedReservedPropertyType');
			}				
		}

		if(!empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']) && !empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']))
			{
				$SERVER->setMessage('ReservedPropertyTypeClass.setReservedPropertyType.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ReservedPropertyTypeClass.setReservedPropertyType.msg.DataSaved');
		}
		if(!empty($input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'ReservedPropertyType');
			$DS->query("UPDATE ReservedPropertyTypeField SET ReservedPropertyType='".$input['ReservedPropertyType'.DTR.'ReservedPropertyTypeAlias']."' WHERE ReservedPropertyTypeID='$entityID'");
		}
		$SERVER->setDebug('ReservedPropertyTypeClass.setReservedPropertyType.End','End');		
		return $result;		
	}

	function setReservedPropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeFieldClass.setReservedPropertyTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeFieldServer.adminReservedPropertyTypeField');
		//set queries	

		//if(is_array($input['ReservedPropertyTypeField'.DTR.'AccessGroups'])) {$input['ReservedPropertyTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedPropertyTypeField'.DTR.'AccessGroups']).'|'; }
		$where['ReservedPropertyTypeField'] = "ReservedPropertyTypeFieldID = '".$entityID."'".$filter;

		if(empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']) && !empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservedPropertyTypeFieldName = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldName']['en'];
			if(empty($langReservedPropertyTypeFieldName)) { $lang = $config['lang']; $langReservedPropertyTypeFieldName = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldName'][$lang];}
			$input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias'] = $typeObject->setDataType($langReservedPropertyTypeFieldName);
		}	
		if(!empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']))
		{
			$checkRS=$DS->query("SELECT ReservedPropertyTypeFieldAlias FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldAlias='".$input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']."' AND ReservedPropertyType='".$input['ReservedPropertyTypeField'.DTR.'ReservedPropertyType']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias'] = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias'].date('Ymd-His');
				$SERVER->setMessage('reservedProperty.ReservedPropertyTypeFieldClass.setReservedPropertyTypeField.err.DuplicatedReservedPropertyTypeField');
			}				
		}
		if(!empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']) && !empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldName'])  && !empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']))
			{		
				$SERVER->setMessage('ReservedPropertyTypeFieldClass.setReservedPropertyTypeField.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ReservedPropertyTypeFieldClass.setReservedPropertyTypeField.msg.DataSaved');
		}
		if(!empty($input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldAlias']))
		{
			$this->updateEntityPositions($entityID,'ReservedPropertyTypeField',$input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeID'],'ReservedPropertyType');
		}		
		$SERVER->setDebug('ReservedPropertyTypeFieldClass.setReservedPropertyTypeField.End','End');		
		return $result;		
	}
	
	function setReservedPropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeOptionClass.setReservedPropertyTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeOptionServer.adminReservedPropertyTypeOption');
		//set queries	
		//if(is_array($input['ReservedPropertyTypeOption'.DTR.'AccessGroups'])) {$input['ReservedPropertyTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedPropertyTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['ReservedPropertyTypeOption'] = "ReservedPropertyTypeOptionID = '".$entityID."'".$filter;
		if(empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']) && !empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservedPropertyTypeOptionName = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionName']['en'];
			if(empty($langReservedPropertyTypeOptionName)) { $lang = $config['lang']; $langReservedPropertyTypeOptionName = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionName'][$lang];}
			$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias'] = $typeObject->setDataType($langReservedPropertyTypeOptionName);
echo 'rrrrrrrrrrrrrrrrr='.$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias'];		
			
		}	
		
		if(!empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']))
		{
			$checkRS=$DS->query("SELECT ReservedPropertyTypeOptionAlias FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeOptionAlias='".$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']."' AND ReservedPropertyTypeFieldID='".$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeFieldID']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias'] = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias'].date('Ymd-His');
				$SERVER->setMessage('reservedProperty.ReservedPropertyTypeOptionClass.setReservedPropertyTypeOption.err.DuplicatedReservedPropertyTypeOption');
			}				
		}
		
		if(!empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']) && !empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionName']) && !empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']))
			{				
				$SERVER->setMessage('ReservedPropertyTypeOptionClass.setReservedPropertyTypeOption.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ReservedPropertyTypeOptionClass.setReservedPropertyTypeOption.msg.DataSaved');
		}
		if(!empty($input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionAlias']))
		{		
			$this->updateEntityPositions($entityID,'ReservedPropertyTypeOption',$input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeFieldID'],'ReservedPropertyTypeField');
		}
		$SERVER->setDebug('ReservedPropertyTypeOptionClass.setReservedPropertyTypeOption.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservedPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyType'.DTR.'ReservedPropertyTypeID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ReservedPropertyTypeFieldID FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ReservedPropertyTypeFieldID'];
			$DS->query("DELETE FROM ReservedPropertyType WHERE ReservedPropertyTypeID='$entityID'");
			$DS->query("DELETE FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('ReservedPropertyTypeClass.deleteReservedPropertyType.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyType.End','End');		
		return $result;		
	}	
	
	function deleteReservedPropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldID='$entityID'");
			$DS->query("DELETE FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('ReservedPropertyTypeClass.deleteReservedPropertyTypeField.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyTypeField.End','End');		
		return $result;		
	}	
	
	function deleteReservedPropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyTypeServer.adminReservedPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('ReservedPropertyTypeClass.deleteReservedPropertyTypeOption.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyTypeClass.deleteReservedPropertyTypeOption.End','End');		
		return $result;		
	}	
	
	function copyReservedPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.setSection.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	

		$ownerID = $config['OwnerID'];
		$ownerRootID = $config['OwnerRootID'];
		$ReservedPropertyTypeTemplateID = $input['selectedReservedPropertyTypeID'];
		$ReservedPropertyTypeID = $input['ReservedPropertyTypeID'];
		if($ReservedPropertyTypeID==$ReservedPropertyTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($ReservedPropertyTypeTemplateID) && !empty($ReservedPropertyTypeID))
		{
			//make ReservedPropertyType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeID='$ReservedPropertyTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ReservedPropertyTypeField'] = "ReservedPropertyTypeFieldID = ''";
			$inputNew['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldID']='';
			$inputNew['ReservedPropertyTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ReservedPropertyTypeField'.DTR.'UserID']=$userID;
			$inputNew['ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeID']=$ReservedPropertyTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ReservedPropertyTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ReservedPropertyTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ReservedPropertyTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ReservedPropertyTypeField WHERE BoxID='".$inputNew['ReservedPropertyTypeField'.DTR.'BoxID']."' AND ReservedPropertyTypeID='".$ReservedPropertyTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new ReservedPropertyType
					$newRS = $DS->save($inputNew,$where);	
				}
			}
		}
		//if(count($result['sql'])>0)	
		//{
			//$SERVER->setMessage('SectionServer.setSection.msg.DataSaved');
		//}
		$SERVER->setDebug('SectionServer.setSection.End','End');		
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
	
	function getReservedPropertyTemplate($reservedPropertyType,$reservedPropertyID='')
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
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		$query ='';
		if(!empty($reservedPropertyID))
		{
			$reservedPropertyTypeRS = $DS->query("SELECT ReservedPropertyType FROM ReservedProperty WHERE ReservedPropertyID='$reservedPropertyID'");
			$reservedPropertyType = $reservedPropertyTypeRS[0]['ReservedPropertyType'];
		}
		
		if(!empty($reservedPropertyType))
		{
			$query = "SELECT ReservedPropertyTemplate FROM ReservedPropertyType WHERE ReservedPropertyTypeAlias='$reservedPropertyType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['ReservedPropertyTemplate'];		
	}
		
} // end of ReservedPropertyTypeServer
?>