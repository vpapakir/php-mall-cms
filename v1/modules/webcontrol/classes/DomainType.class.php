<?php
//XCMSPro: Web Service entity class
class DomainTypeClass
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
	function DomainTypeClass()
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
	function getDomainTypes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainTypes.Start','Start');
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
		$place = $input['DomainTypesPlace'];
		$permAll = $input['PermAll'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		if(!empty($searchWord))
		{
			//$filter .= " AND (DomainTypeName LIKE '{ls}%$searchWord%{le}' OR DomainTypeName LIKE '%$searchWord%' OR DomainTypeDescription LIKE '{ls}%$searchWord%{le}' OR DomainTypeDescription LIKE '%$searchWord%')";
		}
		if(!empty($place))		
		{		
			$filter .= " AND DomainTypeHiddenPlaces NOT LIKE '%|$place|%'";
		}
		if(!empty($permAll))
		{
			$filter .= " AND PermAll='$permAll' ";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM DomainType WHERE DomainTypeID>0 $filter ORDER BY DomainTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('DomainTypeClass.getDomainTypes.End','End');
		return $result;
	}	
	
	function getDomainTypeFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['DomainType'.DTR.'DomainTypeID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainType'];}
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['DomainType'.DTR.'DomainTypeAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$DomainTypeIDRS = $DS->query("SELECT DomainTypeID FROM DomainType WHERE DomainTypeAlias='$entityAlias'");
			$entityID = $DomainTypeIDRS[0]['DomainTypeID'];
		}
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		if(!empty($entityID))		
		{
			$filter .= " AND DomainTypeID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM DomainTypeField WHERE DomainTypeFieldID>0 $filter ORDER BY DomainTypeFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('DomainTypeClass.getDomainTypeFields.End','End');
		return $result;
	}	
	
	function getDomainTypeOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainTypeFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['DomainTypeField'.DTR.'DomainTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeFieldID'];}
		
		$entityAlias = $input['DomainField'];		
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeField'.DTR.'DomainTypeFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$DomainTypeIDRS = $DS->query("SELECT DomainTypeFieldID FROM DomainTypeField WHERE DomainTypeFieldAlias='$entityAlias'");
			$entityID = $DomainTypeIDRS[0]['DomainTypeFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM DomainTypeOption WHERE DomainTypeFieldID='$entityID' $filter ORDER BY DomainTypeOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('DomainTypeClass.getDomainTypeFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getDomainType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainType.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['DomainType'.DTR.'DomainTypeID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainType'];}
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['DomainType'.DTR.'DomainTypeAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " DomainTypeAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " DomainTypeID='$entityID' ";
		}
		$query = "SELECT * FROM DomainType WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('DomainTypeClass.getDomainType.End','End');		
		return $result;		
	}
	
	function getDomainTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainTypeField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['DomainTypeField'.DTR.'DomainTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeFieldID'];}

		$entityAlias = $input['DomainTypeField'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeField'.DTR.'DomainTypeFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " DomainTypeFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " DomainTypeFieldID='$entityID' ";
		}
		$query = "SELECT * FROM DomainTypeField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('DomainTypeClass.getDomainTypeField.End','End');		
		return $result;		
	}

	function getDomainTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.getDomainTypeOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['DomainTypeOption'.DTR.'DomainTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeOptionID'];}

		$entityAlias = $input['DomainTypeOption'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['DomainTypeOption'.DTR.'DomainTypeOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " DomainTypeOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " DomainTypeOptionID='$entityID' ";
		}
		$query = "SELECT * FROM DomainTypeOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('DomainTypeClass.getDomainTypeOption.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setDomainType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.setDomainType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['DomainType'.DTR.'DomainTypeID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries	
		//if(is_array($input['DomainType'.DTR.'AccessGroups'])) {$input['DomainType'.DTR.'AccessGroups'] = '|'. implode("|",$input['DomainType'.DTR.'AccessGroups']).'|'; }
		$where['DomainType'] = "DomainTypeID = '".$entityID."'".$filter;

		if(!empty($input['DomainType'.DTR.'DomainTypeAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT DomainTypeAlias FROM DomainType WHERE DomainTypeAlias='".$input['DomainType'.DTR.'DomainTypeAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['DomainType'.DTR.'DomainTypeAlias']) && !empty($input['DomainType'.DTR.'DomainTypeName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['DomainType'.DTR.'DomainTypeAlias']))
			{
				$SERVER->setMessage('DomainTypeClass.setDomainType.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('DomainTypeClass.setDomainType.msg.DataSaved');
		}
		if(!empty($input['DomainType'.DTR.'DomainTypeAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'DomainType');
			$DS->query("UPDATE DomainTypeField SET DomainType='".$input['DomainType'.DTR.'DomainTypeAlias']."' WHERE DomainTypeID='$entityID'");
		}
		$SERVER->setDebug('DomainTypeClass.setDomainType.End','End');		
		return $result;		
	}

	function setDomainTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeFieldClass.setDomainTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['DomainTypeField'.DTR.'DomainTypeFieldID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeFieldServer.adminDomainTypeField');
		//set queries	

		//if(is_array($input['DomainTypeField'.DTR.'AccessGroups'])) {$input['DomainTypeField'.DTR.'AccessGroups'] = '|'. implode("|",$input['DomainTypeField'.DTR.'AccessGroups']).'|'; }
		$where['DomainTypeField'] = "DomainTypeFieldID = '".$entityID."'".$filter;

		if(!empty($input['DomainTypeField'.DTR.'DomainTypeFieldAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT DomainTypeFieldAlias FROM DomainTypeField WHERE DomainTypeFieldAlias='".$input['DomainTypeField'.DTR.'DomainTypeFieldAlias']."' AND DomainType='".$input['DomainTypeField'.DTR.'DomainType']."'");
		}
		if(count($checkRS)<1 && !empty($input['DomainTypeField'.DTR.'DomainTypeFieldAlias']) && !empty($input['DomainTypeField'.DTR.'DomainTypeFieldName'])  && !empty($input['DomainTypeField'.DTR.'DomainTypeID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['DomainTypeField'.DTR.'DomainTypeFieldAlias']))
			{		
				$SERVER->setMessage('DomainTypeFieldClass.setDomainTypeField.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('DomainTypeFieldClass.setDomainTypeField.msg.DataSaved');
		}
		if(!empty($input['DomainTypeField'.DTR.'DomainTypeFieldAlias']))
		{
			$this->updateEntityPositions($entityID,'DomainTypeField',$input['DomainTypeField'.DTR.'DomainTypeID'],'DomainType');
		}		
		$SERVER->setDebug('DomainTypeFieldClass.setDomainTypeField.End','End');		
		return $result;		
	}
	
	function setDomainTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeOptionClass.setDomainTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['DomainTypeOption'.DTR.'DomainTypeOptionID'];
		if(empty($entityID)) {$entityID = $input['DomainTypeOptionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeOptionServer.adminDomainTypeOption');
		//set queries	
		//if(is_array($input['DomainTypeOption'.DTR.'AccessGroups'])) {$input['DomainTypeOption'.DTR.'AccessGroups'] = '|'. implode("|",$input['DomainTypeOption'.DTR.'AccessGroups']).'|'; }
		$where['DomainTypeOption'] = "DomainTypeOptionID = '".$entityID."'".$filter;

		if(!empty($input['DomainTypeOption'.DTR.'DomainTypeOptionAlias']) && empty($entityID))
		{
			$checkRS=$DS->query("SELECT DomainTypeOptionAlias FROM DomainTypeOption WHERE DomainTypeOptionAlias='".$input['DomainTypeOption'.DTR.'DomainTypeOptionAlias']."' AND DomainTypeFieldID='".$input['DomainTypeOption'.DTR.'DomainTypeFieldID']."'");
		}
		if(count($checkRS)<1 && !empty($input['DomainTypeOption'.DTR.'DomainTypeOptionAlias']) && !empty($input['DomainTypeOption'.DTR.'DomainTypeOptionName']) && !empty($input['DomainTypeOption'.DTR.'DomainTypeFieldID']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['DomainTypeOption'.DTR.'DomainTypeOptionAlias']))
			{				
				$SERVER->setMessage('DomainTypeOptionClass.setDomainTypeOption.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('DomainTypeOptionClass.setDomainTypeOption.msg.DataSaved');
		}
		if(!empty($input['DomainTypeOption'.DTR.'DomainTypeOptionAlias']))
		{		
			$this->updateEntityPositions($entityID,'DomainTypeOption',$input['DomainTypeOption'.DTR.'DomainTypeFieldID'],'DomainTypeField');
		}
		$SERVER->setDebug('DomainTypeOptionClass.setDomainTypeOption.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteDomainType($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.deleteDomainType.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['DomainType'.DTR.'DomainTypeID'];
		//if(empty($entityID)) {$entityID = $input['DomainTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT DomainTypeFieldID FROM DomainTypeField WHERE DomainTypeID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['DomainTypeFieldID'];
			$DS->query("DELETE FROM DomainType WHERE DomainTypeID='$entityID'");
			$DS->query("DELETE FROM DomainTypeField WHERE DomainTypeID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM DomainTypeOption WHERE DomainTypeFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('DomainTypeClass.deleteDomainType.msg.DataDeleted');
		$SERVER->setDebug('DomainTypeClass.deleteDomainType.End','End');		
		return $result;		
	}	
	
	function deleteDomainTypeField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.deleteDomainTypeField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['DomainTypeField'.DTR.'DomainTypeFieldID'];
		//if(empty($entityID)) {$entityID = $input['DomainTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM DomainTypeField WHERE DomainTypeFieldID='$entityID'");
			$DS->query("DELETE FROM DomainTypeOption WHERE DomainTypeFieldID='$entityID'");
		}
		$SERVER->setMessage('DomainTypeClass.deleteDomainTypeField.msg.DataDeleted');
		$SERVER->setDebug('DomainTypeClass.deleteDomainTypeField.End','End');		
		return $result;		
	}	
	
	function deleteDomainTypeOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainTypeClass.deleteDomainTypeOption.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['DomainTypeOption'.DTR.'DomainTypeOptionID'];
		//if(empty($entityID)) {$entityID = $input['DomainTypeID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainTypeServer.adminDomainType');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM DomainTypeOption WHERE DomainTypeOptionID='$entityID'");
		}
		$SERVER->setMessage('DomainTypeClass.deleteDomainTypeOption.msg.DataDeleted');
		$SERVER->setDebug('DomainTypeClass.deleteDomainTypeOption.End','End');		
		return $result;		
	}	
	
	function copyDomainType($input)
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
		$DomainTypeTemplateID = $input['selectedDomainTypeID'];
		$DomainTypeID = $input['DomainTypeID'];
		if($DomainTypeID==$DomainTypeTemplateID) {return false;}
		//set client side variables
		if(!empty($DomainTypeTemplateID) && !empty($DomainTypeID))
		{
			//make DomainType link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM DomainTypeField WHERE DomainTypeID='$DomainTypeTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['DomainTypeField'] = "DomainTypeFieldID = ''";
			$inputNew['DomainTypeField'.DTR.'DomainTypeFieldID']='';
			$inputNew['DomainTypeField'.DTR.'OwnerID']=$ownerID;
			$inputNew['DomainTypeField'.DTR.'UserID']=$userID;
			$inputNew['DomainTypeField'.DTR.'DomainTypeID']=$DomainTypeID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['DomainTypeField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['DomainTypeField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['DomainTypeField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM DomainTypeField WHERE BoxID='".$inputNew['DomainTypeField'.DTR.'BoxID']."' AND DomainTypeID='".$DomainTypeID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new DomainType
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
	
	function getDomainTemplate($DomainType,$DomainID='')
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
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries
		$query ='';
		if(!empty($DomainID))
		{
			$DomainTypeRS = $DS->query("SELECT DomainType FROM Domain WHERE DomainID='$DomainID'");
			$DomainType = $DomainTypeRS[0]['DomainType'];
		}
		
		if(!empty($DomainType))
		{
			$query = "SELECT DomainTemplate FROM DomainType WHERE DomainTypeAlias='$DomainType'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['DomainTemplate'];		
	}
		
} // end of DomainTypeServer
?>