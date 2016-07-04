<?php
//XCMSPro: Web Service entity class
class ResourceTypeClass
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
	function ResourceTypeClass()
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
	function getResourceTypes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceTypes.Start','Start');
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
		$place = $input['resourceTypesPlace'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		if(!empty($searchWord))
		{
			//$filter .= " AND (ResourceTypeName LIKE '{ls}%$searchWord%{le}' OR ResourceTypeName LIKE '%$searchWord%' OR ResourceTypeDescription LIKE '{ls}%$searchWord%{le}' OR ResourceTypeDescription LIKE '%$searchWord%')";
		}
		if(!empty($place))		
		{		
			$filter .= " AND ResourceTypeHiddenPlaces NOT LIKE '%|$place|%'";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM ResourceType WHERE ResourceTypeID>0 $filter ORDER BY ResourceTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceTypeClass.getResourceTypes.End','End');
		return $result;
	}	
	
	function getResourceTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceType'.DTR.'ResourceTypeID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceType'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceType'.DTR.'ResourceTypeAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$resourceTypeIDRS = $DS->query("SELECT ResourceTypeID FROM ResourceType WHERE ResourceTypeAlias='$entityAlias'");
			$entityID = $resourceTypeIDRS[0]['ResourceTypeID'];
		}
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		if(!empty($entityID))		
		{
			$filter .= " AND ResourceTypeID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ResourceTypeField WHERE ResourceTypeFieldID>0 $filter ORDER BY ResourceTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeFields.End','End');
		return $result;
	}	
	
	function getResourceTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceTypeField'.DTR.'ResourceTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeFieldID'];}
		
		$entityAlias = $input['ResourceField'];		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$resourceTypeIDRS = $DS->query("SELECT ResourceTypeFieldID FROM ResourceTypeField WHERE ResourceTypeFieldAlias='$entityAlias'");
			$entityID = $resourceTypeIDRS[0]['ResourceTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ResourceTypeOption WHERE ResourceTypeFieldID='$entityID' $filter ORDER BY ResourceTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getResourceType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceType.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceType'.DTR.'ResourceTypeID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceType'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceType'.DTR.'ResourceTypeAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceTypeAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceTypeID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceType WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('ResourceTypeClass.getResourceType.End','End');		
		return $result;		
	}
	
	function getResourceTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceTypeField'.DTR.'ResourceTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeFieldID'];}

		$entityAlias = $input['ResourceTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeField.End','End');		
		return $result;		
	}

	function getResourceTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeOptionID'];}

		$entityAlias = $input['ResourceTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ResourceTypeClass.getResourceTypeOption.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResourceType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.setResourceType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceType'.DTR.'ResourceTypeID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries	
		//if(is_array($input['ResourceType'.DTR.'AccessGroups'])) {$input['ResourceType'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceType'.DTR.'AccessGroups']).'|'; }
		$where['ResourceType'] = "ResourceTypeID = '".$entityID."'".$filter;
		if(empty($input['ResourceType'.DTR.'ResourceTypeAlias']) && !empty($input['ResourceType'.DTR.'ResourceTypeName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langResourceTypeName = $input['ResourceType'.DTR.'ResourceTypeName']['en'];
			if(empty($langResourceTypeName)) { $lang = $config['lang']; $langResourceTypeName = $input['ResourceType'.DTR.'ResourceTypeName'][$lang];}
			$input['ResourceType'.DTR.'ResourceTypeAlias'] = $typeObject->setDataType($langResourceTypeName);
		}	
		if(!empty($input['ResourceType'.DTR.'ResourceTypeAlias']))
		{
			$checkRS=$DS->query("SELECT ResourceTypeAlias FROM ResourceType WHERE ResourceTypeAlias='".$input['ResourceType'.DTR.'ResourceTypeAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ResourceType'.DTR.'ResourceTypeAlias'] = $input['ResourceType'.DTR.'ResourceTypeAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.ResourceTypeClass.setResourceType.err.DuplicatedResourceType');
			}				
		}

		if(!empty($input['ResourceType'.DTR.'ResourceTypeAlias']) && !empty($input['ResourceType'.DTR.'ResourceTypeName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ResourceType'.DTR.'ResourceTypeAlias']))
			{
				$SERVER->setMessage('ResourceTypeClass.setResourceType.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ResourceTypeClass.setResourceType.msg.DataSaved');
		}
		if(!empty($input['ResourceType'.DTR.'ResourceTypeAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'ResourceType');
			$DS->query("UPDATE ResourceTypeField SET ResourceType='".$input['ResourceType'.DTR.'ResourceTypeAlias']."' WHERE ResourceTypeID='$entityID'");
		}
		$SERVER->setDebug('ResourceTypeClass.setResourceType.End','End');		
		return $result;		
	}

	function setResourceTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeFieldClass.setResourceTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceTypeField'.DTR.'ResourceTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeFieldServer.adminResourceTypeField');
		//set queries	

		//if(is_array($input['ResourceTypeField'.DTR.'AccessGroups'])) {$input['ResourceTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceTypeField'.DTR.'AccessGroups']).'|'; }
		$where['ResourceTypeField'] = "ResourceTypeFieldID = '".$entityID."'".$filter;

		if(empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']) && !empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langResourceTypeFieldName = $input['ResourceTypeField'.DTR.'ResourceTypeFieldName']['en'];
			if(empty($langResourceTypeFieldName)) { $lang = $config['lang']; $langResourceTypeFieldName = $input['ResourceTypeField'.DTR.'ResourceTypeFieldName'][$lang];}
			$input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias'] = $typeObject->setDataType($langResourceTypeFieldName);
		}	
		if(!empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']))
		{
			$checkRS=$DS->query("SELECT ResourceTypeFieldAlias FROM ResourceTypeField WHERE ResourceTypeFieldAlias='".$input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']."' AND ResourceType='".$input['ResourceTypeField'.DTR.'ResourceType']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias'] = $input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.ResourceTypeFieldClass.setResourceTypeField.err.DuplicatedResourceTypeField');
			}				
		}
		if(!empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']) && !empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldName'])  && !empty($input['ResourceTypeField'.DTR.'ResourceTypeID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']))
			{		
				$SERVER->setMessage('ResourceTypeFieldClass.setResourceTypeField.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ResourceTypeFieldClass.setResourceTypeField.msg.DataSaved');
		}
		if(!empty($input['ResourceTypeField'.DTR.'ResourceTypeFieldAlias']))
		{
			$this->updateEntityPositions($entityID,'ResourceTypeField',$input['ResourceTypeField'.DTR.'ResourceTypeID'],'ResourceType');
		}		
		$SERVER->setDebug('ResourceTypeFieldClass.setResourceTypeField.End','End');		
		return $result;		
	}
	
	function setResourceTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeOptionClass.setResourceTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['ResourceTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeOptionServer.adminResourceTypeOption');
		//set queries	
		//if(is_array($input['ResourceTypeOption'.DTR.'AccessGroups'])) {$input['ResourceTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['ResourceTypeOption'] = "ResourceTypeOptionID = '".$entityID."'".$filter;
		if(empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']) && !empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langResourceTypeOptionName = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionName']['en'];
			if(empty($langResourceTypeOptionName)) { $lang = $config['lang']; $langResourceTypeOptionName = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionName'][$lang];}
			$input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias'] = $typeObject->setDataType($langResourceTypeOptionName);
echo 'rrrrrrrrrrrrrrrrr='.$input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias'];		
			
		}	
		
		if(!empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']))
		{
			$checkRS=$DS->query("SELECT ResourceTypeOptionAlias FROM ResourceTypeOption WHERE ResourceTypeOptionAlias='".$input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']."' AND ResourceTypeFieldID='".$input['ResourceTypeOption'.DTR.'ResourceTypeFieldID']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias'] = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.ResourceTypeOptionClass.setResourceTypeOption.err.DuplicatedResourceTypeOption');
			}				
		}
		
		if(!empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']) && !empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionName']) && !empty($input['ResourceTypeOption'.DTR.'ResourceTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']))
			{				
				$SERVER->setMessage('ResourceTypeOptionClass.setResourceTypeOption.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('ResourceTypeOptionClass.setResourceTypeOption.msg.DataSaved');
		}
		if(!empty($input['ResourceTypeOption'.DTR.'ResourceTypeOptionAlias']))
		{		
			$this->updateEntityPositions($entityID,'ResourceTypeOption',$input['ResourceTypeOption'.DTR.'ResourceTypeFieldID'],'ResourceTypeField');
		}
		$SERVER->setDebug('ResourceTypeOptionClass.setResourceTypeOption.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.deleteResourceType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceType'.DTR.'ResourceTypeID'];
		//if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ResourceTypeFieldID FROM ResourceTypeField WHERE ResourceTypeID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ResourceTypeFieldID'];
			$DS->query("DELETE FROM ResourceType WHERE ResourceTypeID='$entityID'");
			$DS->query("DELETE FROM ResourceTypeField WHERE ResourceTypeID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ResourceTypeOption WHERE ResourceTypeFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('ResourceTypeClass.deleteResourceType.msg.DataDeleted');
		$SERVER->setDebug('ResourceTypeClass.deleteResourceType.End','End');		
		return $result;		
	}	
	
	function deleteResourceTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.deleteResourceTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceTypeField'.DTR.'ResourceTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceTypeField WHERE ResourceTypeFieldID='$entityID'");
			$DS->query("DELETE FROM ResourceTypeOption WHERE ResourceTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('ResourceTypeClass.deleteResourceTypeField.msg.DataDeleted');
		$SERVER->setDebug('ResourceTypeClass.deleteResourceTypeField.End','End');		
		return $result;		
	}	
	
	function deleteResourceTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceTypeClass.deleteResourceTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceTypeOption'.DTR.'ResourceTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['ResourceTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceTypeServer.adminResourceType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceTypeOption WHERE ResourceTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('ResourceTypeClass.deleteResourceTypeOption.msg.DataDeleted');
		$SERVER->setDebug('ResourceTypeClass.deleteResourceTypeOption.End','End');		
		return $result;		
	}	
	
	function copyResourceType($input)
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
		$ResourceTypeTemplateID = $input['selectedResourceTypeID'];
		$ResourceTypeID = $input['ResourceTypeID'];
		if($ResourceTypeID==$ResourceTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($ResourceTypeTemplateID) && !empty($ResourceTypeID))
		{
			//make ResourceType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ResourceTypeField WHERE ResourceTypeID='$ResourceTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ResourceTypeField'] = "ResourceTypeFieldID = ''";
			$inputNew['ResourceTypeField'.DTR.'ResourceTypeFieldID']='';
			$inputNew['ResourceTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ResourceTypeField'.DTR.'UserID']=$userID;
			$inputNew['ResourceTypeField'.DTR.'ResourceTypeID']=$ResourceTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ResourceTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ResourceTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ResourceTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ResourceTypeField WHERE BoxID='".$inputNew['ResourceTypeField'.DTR.'BoxID']."' AND ResourceTypeID='".$ResourceTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new ResourceType
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
	
	function getResourceTemplate($resourceType,$resourceID='')
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
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		if(!empty($resourceID))
		{
			$resourceTypeRS = $DS->query("SELECT ResourceType FROM Resource WHERE ResourceID='$resourceID'");
			$resourceType = $resourceTypeRS[0]['ResourceType'];
		}
		
		if(!empty($resourceType))
		{
			$query = "SELECT ResourceTemplate FROM ResourceType WHERE ResourceTypeAlias='$resourceType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['ResourceTemplate'];		
	}
		
} // end of ResourceTypeServer
?>