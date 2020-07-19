<?php
//XCMSPro: Web Service entity class
class TourTypeClass
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
	function TourTypeClass()
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
	function getTourTypes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourTypes.Start','Start');
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
		$place = $input['tourTypesPlace'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		if(!empty($searchWord))
		{
			//$filter .= " AND (TourTypeName LIKE '{ls}%$searchWord%{le}' OR TourTypeName LIKE '%$searchWord%' OR TourTypeDescription LIKE '{ls}%$searchWord%{le}' OR TourTypeDescription LIKE '%$searchWord%')";
		}
		if(!empty($place))		
		{		
			$filter .= " AND TourTypeHiddenPlaces NOT LIKE '%|$place|%'";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM TourType WHERE TourTypeID>0 $filter ORDER BY TourTypePosition";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourTypeClass.getTourTypes.End','End');
		return $result;
	}	
	
	function getTourTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourType'.DTR.'TourTypeID'];
		if(empty($entityID)) {$entityID = $input['TourTypeID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourType'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourType'.DTR.'TourTypeAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$tourTypeIDRS = $DS->query("SELECT TourTypeID FROM TourType WHERE TourTypeAlias='$entityAlias'");
			$entityID = $tourTypeIDRS[0]['TourTypeID'];
		}
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		if(!empty($entityID))		
		{
			$filter .= " AND TourTypeID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM TourTypeField WHERE TourTypeFieldID>0 $filter ORDER BY TourTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourTypeClass.getTourTypeFields.End','End');
		return $result;
	}	
	
	function getTourTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourTypeField'.DTR.'TourTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['TourTypeFieldID'];}
		
		$entityAlias = $input['TourField'];		
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeField'.DTR.'TourTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$tourTypeIDRS = $DS->query("SELECT TourTypeFieldID FROM TourTypeField WHERE TourTypeFieldAlias='$entityAlias'");
			$entityID = $tourTypeIDRS[0]['TourTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM TourTypeOption WHERE TourTypeFieldID='$entityID' $filter ORDER BY TourTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourTypeClass.getTourTypeFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTourType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourType.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourType'.DTR.'TourTypeID'];
		if(empty($entityID)) {$entityID = $input['TourTypeID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourType'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourType'.DTR.'TourTypeAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourTypeAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourTypeID='$entityID' ";
		}
		$query = "SELECT * FROM TourType WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('TourTypeClass.getTourType.End','End');		
		return $result;		
	}
	
	function getTourTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourTypeField'.DTR.'TourTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['TourTypeFieldID'];}

		$entityAlias = $input['TourTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeField'.DTR.'TourTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM TourTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('TourTypeClass.getTourTypeField.End','End');		
		return $result;		
	}

	function getTourTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.getTourTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourTypeOption'.DTR.'TourTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['TourTypeOptionID'];}

		$entityAlias = $input['TourTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourTypeOption'.DTR.'TourTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM TourTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('TourTypeClass.getTourTypeOption.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTourType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.setTourType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourType'.DTR.'TourTypeID'];
		if(empty($entityID)) {$entityID = $input['TourTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries	
		//if(is_array($input['TourType'.DTR.'AccessGroups'])) {$input['TourType'.DTR.'AccessGroups'] = '|'. implode("|",$input['TourType'.DTR.'AccessGroups']).'|'; }
		$where['TourType'] = "TourTypeID = '".$entityID."'".$filter;
		if(empty($input['TourType'.DTR.'TourTypeAlias']) && !empty($input['TourType'.DTR.'TourTypeName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langTourTypeTitle = $input['TourType'.DTR.'TourTypeName']['en'];
			if(empty($langTourTypeTitle)) { $lang = $config['lang']; $langTourTypeTitle = $input['TourType'.DTR.'TourTypeName'][$lang];}
			$input['TourType'.DTR.'TourTypeAlias'] = $typeObject->setDataType($langTourTypeTitle);
		}
		
		if(!empty($input['TourType'.DTR.'TourTypeAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT TourTypeAlias FROM TourType WHERE TourTypeAlias='".$input['TourType'.DTR.'TourTypeAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['TourType'.DTR.'TourTypeAlias']) && !empty($input['TourType'.DTR.'TourTypeName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['TourType'.DTR.'TourTypeAlias']))
			{
				$SERVER->setMessage('TourTypeClass.setTourType.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TourTypeClass.setTourType.msg.DataSaved');
		}
		if(!empty($input['TourType'.DTR.'TourTypeAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'TourType');
			$DS->query("UPDATE TourTypeField SET TourType='".$input['TourType'.DTR.'TourTypeAlias']."' WHERE TourTypeID='$entityID'");
		}
		$SERVER->setDebug('TourTypeClass.setTourType.End','End');		
		return $result;		
	}

	function setTourTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeFieldClass.setTourTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourTypeField'.DTR.'TourTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['TourTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeFieldServer.adminTourTypeField');
		//set queries	
		$input['TourTypeField'.DTR.'TourTypeID'] = 1;
		//if(is_array($input['TourTypeField'.DTR.'AccessGroups'])) {$input['TourTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['TourTypeField'.DTR.'AccessGroups']).'|'; }
		$where['TourTypeField'] = "TourTypeFieldID = '".$entityID."'".$filter;
		if(empty($input['TourTypeField'.DTR.'TourTypeFieldAlias']) && !empty($input['TourTypeField'.DTR.'TourTypeFieldName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langTourTypeFieldTitle = $input['TourTypeField'.DTR.'TourTypeFieldName']['en'];
			if(empty($langTourTypeFieldTitle)) { $lang = $config['lang']; $langTourTypeFieldTitle = $input['TourTypeField'.DTR.'TourTypeFieldName'][$lang];}
			$input['TourTypeField'.DTR.'TourTypeFieldAlias'] = $typeObject->setDataType($langTourTypeFieldTitle);
		}
		if(!empty($input['TourTypeField'.DTR.'TourTypeFieldAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT TourTypeFieldAlias FROM TourTypeField WHERE TourTypeFieldAlias='".$input['TourTypeField'.DTR.'TourTypeFieldAlias']."' AND TourType='".$input['TourTypeField'.DTR.'TourType']."'");
		}
		if(count($checkRS)<1 && !empty($input['TourTypeField'.DTR.'TourTypeFieldAlias']) && !empty($input['TourTypeField'.DTR.'TourTypeFieldName'])  && !empty($input['TourTypeField'.DTR.'TourTypeID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['TourTypeField'.DTR.'TourTypeFieldAlias']))
			{		
				$SERVER->setMessage('TourTypeFieldClass.setTourTypeField.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TourTypeFieldClass.setTourTypeField.msg.DataSaved');
		}
		if(!empty($input['TourTypeField'.DTR.'TourTypeFieldAlias']))
		{
			$this->updateEntityPositions($entityID,'TourTypeField',$input['TourTypeField'.DTR.'TourTypeID'],'TourType');
		}		
		$SERVER->setDebug('TourTypeFieldClass.setTourTypeField.End','End');		
		return $result;		
	}
	
	function setTourTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeOptionClass.setTourTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourTypeOption'.DTR.'TourTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['TourTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeOptionServer.adminTourTypeOption');
		//set queries	
		//if(is_array($input['TourTypeOption'.DTR.'AccessGroups'])) {$input['TourTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['TourTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['TourTypeOption'] = "TourTypeOptionID = '".$entityID."'".$filter;
		if(empty($input['TourTypeOption'.DTR.'TourTypeOptionAlias']) && !empty($input['TourTypeOption'.DTR.'TourTypeOptionName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langTourTypeOptionTitle = $input['TourTypeOption'.DTR.'TourTypeOptionName']['en'];
			if(empty($langTourTypeOptionTitle)) { $lang = $config['lang']; $langTourTypeOptionTitle = $input['TourTypeOption'.DTR.'TourTypeOptionName'][$lang];}
			$input['TourTypeOption'.DTR.'TourTypeOptionAlias'] = $typeObject->setDataType($langTourTypeOptionTitle);
		}
		if(!empty($input['TourTypeOption'.DTR.'TourTypeOptionAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT TourTypeOptionAlias FROM TourTypeOption WHERE TourTypeOptionAlias='".$input['TourTypeOption'.DTR.'TourTypeOptionAlias']."' AND TourTypeFieldID='".$input['TourTypeOption'.DTR.'TourTypeFieldID']."'");
		}
		if(count($checkRS)<1 && !empty($input['TourTypeOption'.DTR.'TourTypeOptionAlias']) && !empty($input['TourTypeOption'.DTR.'TourTypeOptionName']) && !empty($input['TourTypeOption'.DTR.'TourTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['TourTypeOption'.DTR.'TourTypeOptionAlias']))
			{				
				$SERVER->setMessage('TourTypeOptionClass.setTourTypeOption.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TourTypeOptionClass.setTourTypeOption.msg.DataSaved');
		}
		if(!empty($input['TourTypeOption'.DTR.'TourTypeOptionAlias']))
		{		
			$this->updateEntityPositions($entityID,'TourTypeOption',$input['TourTypeOption'.DTR.'TourTypeFieldID'],'TourTypeField');
		}
		$SERVER->setDebug('TourTypeOptionClass.setTourTypeOption.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTourType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.deleteTourType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourType'.DTR.'TourTypeID'];
		//if(empty($entityID)) {$entityID = $input['TourTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT TourTypeFieldID FROM TourTypeField WHERE TourTypeID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['TourTypeFieldID'];
			$DS->query("DELETE FROM TourType WHERE TourTypeID='$entityID'");
			$DS->query("DELETE FROM TourTypeField WHERE TourTypeID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM TourTypeOption WHERE TourTypeFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('TourTypeClass.deleteTourType.msg.DataDeleted');
		$SERVER->setDebug('TourTypeClass.deleteTourType.End','End');		
		return $result;		
	}	
	
	function deleteTourTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.deleteTourTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourTypeField'.DTR.'TourTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['TourTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourTypeField WHERE TourTypeFieldID='$entityID'");
			$DS->query("DELETE FROM TourTypeOption WHERE TourTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('TourTypeClass.deleteTourTypeField.msg.DataDeleted');
		$SERVER->setDebug('TourTypeClass.deleteTourTypeField.End','End');		
		return $result;		
	}	
	
	function deleteTourTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourTypeClass.deleteTourTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourTypeOption'.DTR.'TourTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['TourTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourTypeServer.adminTourType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourTypeOption WHERE TourTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('TourTypeClass.deleteTourTypeOption.msg.DataDeleted');
		$SERVER->setDebug('TourTypeClass.deleteTourTypeOption.End','End');		
		return $result;		
	}	
	
	function copyTourType($input)
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
		$TourTypeTemplateID = $input['selectedTourTypeID'];
		$TourTypeID = $input['TourTypeID'];
		if($TourTypeID==$TourTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($TourTypeTemplateID) && !empty($TourTypeID))
		{
			//make TourType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM TourTypeField WHERE TourTypeID='$TourTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['TourTypeField'] = "TourTypeFieldID = ''";
			$inputNew['TourTypeField'.DTR.'TourTypeFieldID']='';
			$inputNew['TourTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['TourTypeField'.DTR.'UserID']=$userID;
			$inputNew['TourTypeField'.DTR.'TourTypeID']=$TourTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['TourTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['TourTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['TourTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM TourTypeField WHERE BoxID='".$inputNew['TourTypeField'.DTR.'BoxID']."' AND TourTypeID='".$TourTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new TourType
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
	
	function getTourTemplate($tourType,$tourID='')
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
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		$query ='';
		if(!empty($tourID))
		{
			$tourTypeRS = $DS->query("SELECT TourType FROM Tour WHERE TourID='$tourID'");
			$tourType = $tourTypeRS[0]['TourType'];
		}
		
		if(!empty($tourType))
		{
			$query = "SELECT TourTemplate FROM TourType WHERE TourTypeAlias='$tourType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['TourTemplate'];		
	}
		
} // end of TourTypeServer
?>