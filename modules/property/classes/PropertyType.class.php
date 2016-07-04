<?php
//XCMSPro: Web Service entity class
class PropertyTypeClass
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
	function PropertyTypeClass()
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
	function getPropertyTypes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypes.Start','Start');
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
		$place = $input['propertyTypesPlace'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		if(!empty($searchWord))
		{
			//$filter .= " AND (PropertyTypeName LIKE '{ls}%$searchWord%{le}' OR PropertyTypeName LIKE '%$searchWord%' OR PropertyTypeDescription LIKE '{ls}%$searchWord%{le}' OR PropertyTypeDescription LIKE '%$searchWord%')";
		}
		if(!empty($place))		
		{		
			$filter .= " AND PropertyTypeHiddenPlaces NOT LIKE '%|$place|%'";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM PropertyType WHERE PropertyTypeID>1 $filter ORDER BY PropertyTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypes.End','End');
		return $result;
	}	
	
	function getPropertyTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyType'.DTR.'PropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyType'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyType'.DTR.'PropertyTypeAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$propertyTypeIDRS = $DS->query("SELECT PropertyTypeID FROM PropertyType WHERE PropertyTypeAlias='$entityAlias'");
			$entityID = $propertyTypeIDRS[0]['PropertyTypeID'];
		}
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		if(!empty($entityID))		
		{
			$filter .= " AND PropertyTypeID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM PropertyTypeField WHERE PropertyTypeFieldID>0 $filter ORDER BY PropertyTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeFields.End','End');
		return $result;
	}	
	
	function getPropertyTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyTypeField'.DTR.'PropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeFieldID'];}
		
		$entityAlias = $input['PropertyField'];		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$propertyTypeIDRS = $DS->query("SELECT PropertyTypeFieldID FROM PropertyTypeField WHERE PropertyTypeFieldAlias='$entityAlias'");
			$entityID = $propertyTypeIDRS[0]['PropertyTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM PropertyTypeOption WHERE PropertyTypeFieldID='$entityID' $filter ORDER BY PropertyTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyType.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyType'.DTR.'PropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyType'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyType'.DTR.'PropertyTypeAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyTypeAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyTypeID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyType WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('PropertyTypeClass.getPropertyType.End','End');		
		return $result;		
	}
	
	function getPropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyTypeField'.DTR.'PropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeFieldID'];}

		$entityAlias = $input['PropertyTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeField.End','End');		
		return $result;		
	}

	function getPropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeOptionID'];}

		$entityAlias = $input['PropertyTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PropertyTypeClass.getPropertyTypeOption.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setPropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.setPropertyType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyType'.DTR.'PropertyTypeID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries	
		//if(is_array($input['PropertyType'.DTR.'AccessGroups'])) {$input['PropertyType'.DTR.'AccessGroups'] = '|'. implode("|",$input['PropertyType'.DTR.'AccessGroups']).'|'; }
		$where['PropertyType'] = "PropertyTypeID = '".$entityID."'".$filter;
		if(empty($input['PropertyType'.DTR.'PropertyTypeAlias']) && !empty($input['PropertyType'.DTR.'PropertyTypeName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPropertyTypeName = $input['PropertyType'.DTR.'PropertyTypeName']['en'];
			if(empty($langPropertyTypeName)) { $lang = $config['lang']; $langPropertyTypeName = $input['PropertyType'.DTR.'PropertyTypeName'][$lang];}
			$input['PropertyType'.DTR.'PropertyTypeAlias'] = $typeObject->setDataType($langPropertyTypeName);
		}	
		if(!empty($input['PropertyType'.DTR.'PropertyTypeAlias']))
		{
			$checkRS=$DS->query("SELECT PropertyTypeAlias FROM PropertyType WHERE PropertyTypeAlias='".$input['PropertyType'.DTR.'PropertyTypeAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['PropertyType'.DTR.'PropertyTypeAlias'] = $input['PropertyType'.DTR.'PropertyTypeAlias'].date('Ymd-His');
				$SERVER->setMessage('property.PropertyTypeClass.setPropertyType.err.DuplicatedPropertyType');
			}				
		}

		if(!empty($input['PropertyType'.DTR.'PropertyTypeAlias']) && !empty($input['PropertyType'.DTR.'PropertyTypeName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['PropertyType'.DTR.'PropertyTypeAlias']))
			{
				$SERVER->setMessage('PropertyTypeClass.setPropertyType.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('PropertyTypeClass.setPropertyType.msg.DataSaved');
		}
		if(!empty($input['PropertyType'.DTR.'PropertyTypeAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'PropertyType');
			$DS->query("UPDATE PropertyTypeField SET PropertyType='".$input['PropertyType'.DTR.'PropertyTypeAlias']."' WHERE PropertyTypeID='$entityID'");
		}
		$SERVER->setDebug('PropertyTypeClass.setPropertyType.End','End');		
		return $result;		
	}

	function setPropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeFieldClass.setPropertyTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyTypeField'.DTR.'PropertyTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeFieldServer.adminPropertyTypeField');
		//set queries	

		//if(is_array($input['PropertyTypeField'.DTR.'AccessGroups'])) {$input['PropertyTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['PropertyTypeField'.DTR.'AccessGroups']).'|'; }
		$where['PropertyTypeField'] = "PropertyTypeFieldID = '".$entityID."'".$filter;

		if(empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']) && !empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPropertyTypeFieldName = $input['PropertyTypeField'.DTR.'PropertyTypeFieldName']['en'];
			if(empty($langPropertyTypeFieldName)) { $lang = $config['lang']; $langPropertyTypeFieldName = $input['PropertyTypeField'.DTR.'PropertyTypeFieldName'][$lang];}
			$input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias'] = $typeObject->setDataType($langPropertyTypeFieldName);
		}	
		if(!empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']))
		{
			$checkRS=$DS->query("SELECT PropertyTypeFieldAlias FROM PropertyTypeField WHERE PropertyTypeFieldAlias='".$input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']."' AND PropertyType='".$input['PropertyTypeField'.DTR.'PropertyType']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias'] = $input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias'].date('Ymd-His');
				$SERVER->setMessage('property.PropertyTypeFieldClass.setPropertyTypeField.err.DuplicatedPropertyTypeField');
			}				
		}
		
		if(!empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']) && !empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldName'])  && !empty($input['PropertyTypeField'.DTR.'PropertyTypeID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']))
			{		
				$SERVER->setMessage('PropertyTypeFieldClass.setPropertyTypeField.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('PropertyTypeFieldClass.setPropertyTypeField.msg.DataSaved');
		}
		if(!empty($input['PropertyTypeField'.DTR.'PropertyTypeFieldAlias']))
		{
			$this->updateEntityPositions($entityID,'PropertyTypeField',$input['PropertyTypeField'.DTR.'PropertyTypeID'],'PropertyType');
		}		
		$SERVER->setDebug('PropertyTypeFieldClass.setPropertyTypeField.End','End');		
		return $result;		
	}
	
	function setPropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeOptionClass.setPropertyTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['PropertyTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeOptionServer.adminPropertyTypeOption');
		//set queries	
		//if(is_array($input['PropertyTypeOption'.DTR.'AccessGroups'])) {$input['PropertyTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['PropertyTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['PropertyTypeOption'] = "PropertyTypeOptionID = '".$entityID."'".$filter;
		if(empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']) && !empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPropertyTypeOptionName = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionName']['en'];
			if(empty($langPropertyTypeOptionName)) { $lang = $config['lang']; $langPropertyTypeOptionName = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionName'][$lang];}
			$input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias'] = $typeObject->setDataType($langPropertyTypeOptionName);
echo 'rrrrrrrrrrrrrrrrr='.$input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias'];		
			
		}	
		
		if(!empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']))
		{
			$checkRS=$DS->query("SELECT PropertyTypeOptionAlias FROM PropertyTypeOption WHERE PropertyTypeOptionAlias='".$input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']."' AND PropertyTypeFieldID='".$input['PropertyTypeOption'.DTR.'PropertyTypeFieldID']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias'] = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias'].date('Ymd-His');
				$SERVER->setMessage('property.PropertyTypeOptionClass.setPropertyTypeOption.err.DuplicatedPropertyTypeOption');
			}				
		}
		
		if(!empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']) && !empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionName']) && !empty($input['PropertyTypeOption'.DTR.'PropertyTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']))
			{				
				$SERVER->setMessage('PropertyTypeOptionClass.setPropertyTypeOption.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('PropertyTypeOptionClass.setPropertyTypeOption.msg.DataSaved');
		}
		if(!empty($input['PropertyTypeOption'.DTR.'PropertyTypeOptionAlias']))
		{		
			$this->updateEntityPositions($entityID,'PropertyTypeOption',$input['PropertyTypeOption'.DTR.'PropertyTypeFieldID'],'PropertyTypeField');
		}
		$SERVER->setDebug('PropertyTypeOptionClass.setPropertyTypeOption.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deletePropertyType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.deletePropertyType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyType'.DTR.'PropertyTypeID'];
		//if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT PropertyTypeFieldID FROM PropertyTypeField WHERE PropertyTypeID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['PropertyTypeFieldID'];
			$DS->query("DELETE FROM PropertyType WHERE PropertyTypeID='$entityID'");
			$DS->query("DELETE FROM PropertyTypeField WHERE PropertyTypeID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM PropertyTypeOption WHERE PropertyTypeFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('PropertyTypeClass.deletePropertyType.msg.DataDeleted');
		$SERVER->setDebug('PropertyTypeClass.deletePropertyType.End','End');		
		return $result;		
	}	
	
	function deletePropertyTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.deletePropertyTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyTypeField'.DTR.'PropertyTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PropertyTypeField WHERE PropertyTypeFieldID='$entityID'");
			$DS->query("DELETE FROM PropertyTypeOption WHERE PropertyTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('PropertyTypeClass.deletePropertyTypeField.msg.DataDeleted');
		$SERVER->setDebug('PropertyTypeClass.deletePropertyTypeField.End','End');		
		return $result;		
	}	
	
	function deletePropertyTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyTypeClass.deletePropertyTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyTypeOption'.DTR.'PropertyTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['PropertyTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyTypeServer.adminPropertyType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PropertyTypeOption WHERE PropertyTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('PropertyTypeClass.deletePropertyTypeOption.msg.DataDeleted');
		$SERVER->setDebug('PropertyTypeClass.deletePropertyTypeOption.End','End');		
		return $result;		
	}	
	
	function copyPropertyType($input)
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
		$PropertyTypeTemplateID = $input['selectedPropertyTypeID'];
		$PropertyTypeID = $input['PropertyTypeID'];
		if($PropertyTypeID==$PropertyTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($PropertyTypeTemplateID) && !empty($PropertyTypeID))
		{
			//make PropertyType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM PropertyTypeField WHERE PropertyTypeID='$PropertyTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['PropertyTypeField'] = "PropertyTypeFieldID = ''";
			$inputNew['PropertyTypeField'.DTR.'PropertyTypeFieldID']='';
			$inputNew['PropertyTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['PropertyTypeField'.DTR.'UserID']=$userID;
			$inputNew['PropertyTypeField'.DTR.'PropertyTypeID']=$PropertyTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['PropertyTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['PropertyTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['PropertyTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM PropertyTypeField WHERE BoxID='".$inputNew['PropertyTypeField'.DTR.'BoxID']."' AND PropertyTypeID='".$PropertyTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new PropertyType
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
	
	function getPropertyTemplate($propertyType,$propertyID='')
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
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		$query ='';
		if(!empty($propertyID))
		{
			$propertyTypeRS = $DS->query("SELECT PropertyType FROM Property WHERE PropertyID='$propertyID'");
			$propertyType = $propertyTypeRS[0]['PropertyType'];
		}
		
		if(!empty($propertyType))
		{
			$query = "SELECT PropertyTemplate FROM PropertyType WHERE PropertyTypeAlias='$propertyType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['PropertyTemplate'];		
	}
		
} // end of PropertyTypeServer
?>