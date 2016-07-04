<?php
//XCMSPro: Web Service entity class
class PropertyClass
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
	function PropertyClass()
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
	function getProperties($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getProperties.Start','Start');
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
		
		$categoryAlias = $input['category'];
		$categoryID = $input['CategoryID'];
		$sectionID = $input['SID'];
		
		$locationAlias = $input['location'];
		$locationID = $input['LocationID'];
		$PropertyLocation = $input['PropertyLocation'];
		
		$propertyType = $input['PropertyType'];
		$propertyFeaturedOption = $input['PropertyFeaturedOption'];
		$permAll = $input['PermAll'];
		$propertyStatus = $input['PropertyStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		$PropertyPriceRange = $input['propertyPriceRange'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//as 17.04.2006
		/*if(!empty($locationAlias))
		{
			$locationIDRS = $DS->query("SELECT RegionID FROM Region WHERE RegionCode='$locationAlias'");
			$locationID = $locationIDRS[0]['RegionID'];
		}		
		if(!empty($locationID))
		{
			$filter .= " AND PropertyLocationID = '$locationID' ";
		}*/
		//as 17.04.2006		 
		if(!empty($PropertyPriceRange))
		{
			$PropertyPriceRange = explode("-",$PropertyPriceRange);
			$filter .= " AND (PropertyPrice > ".$PropertyPriceRange[0]." AND PropertyPrice < ".$PropertyPriceRange[1].")";
		}
		if(!empty($locationAlias))
		{
			$filter .= " AND(PropertyLocation LIKE '%|$locationAlias|%' OR PropertyLocation LIKE '%|[$locationAlias]|%')";
		}
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		if(!empty($propertyType))
		{
			$filter .= " AND PropertyType='$propertyType' ";
		}	
		if(!empty($propertyStatus))
		{
			$filter .= " AND PropertyStatus='$propertyStatus' ";
		}			
		if(!empty($propertyFeaturedOption))
		{
			$filter .= " AND PropertyFeaturedOptions LIKE '%|$propertyFeaturedOption|%' ";
		}	
		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		if(!empty($searchWord))
		{
			$filter .= " AND (PropertyTitle LIKE '%$searchWord%' OR PropertyIntro LIKE '%$searchWord%' OR PropertyContent LIKE '%$searchWord%' OR PropertyKeywords LIKE '%$searchWord%')  ";
		}	
		if(!empty($featuredMode))
		{
			if($config['PropertyFeaturedPlacesMode']=='one')
			{
				$filter .= " AND PropertyFeaturedOptions LIKE '|$featuredMode|' ";
			}
			else
			{
				$filter .= " AND PropertyFeaturedOptions LIKE '%|$featuredMode|%' ";
			}
		}		
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND PermAll='1' ";
			//$filter .= " AND PropertyStatus='active' ";
		}
		
		/*if($filterMode=='home')
		{
			if($config['PropertyFeaturedPlacesMode']=='one')
			{
				$filter .= " AND PropertyFeaturedOptions LIKE '|home|' ";
			}
			else
			{
				$filter .= " AND PropertyFeaturedOptions LIKE '%|home|%' ";
			}
		}*/
		
		if(($userID!='admin' && $userID!='root') && ($TimeEndMode!='all'))
		{
			$filter .= "  AND (TimeEnd>'".date('Y-m-d H:m:s')."' OR TimeEnd='0000-00-00 00:00:00')";
		}	
		
		//echo 'manageMode='.$manageMode;
		if($ownerMode!='all')
		{
			$filter .= " AND OwnerID='$ownerID' ";
		}
		//search in property field
	
		$fieldsFilter = $this->getPropertyFieldSearchFilter($input);
		
		if(empty($limit))
		{
			if(!empty($fieldsFilter))
			{		
				$pages = $DS->getPages(' Property LEFT JOIN PropertyField ON Property.PropertyID = PropertyField.PropertyID',"Property.PropertyID>0 $filter $fieldsFilter ",array('ItemsPerPage'=>$itemsPerPage));
			}
			else
			{
				$pages = $DS->getPages('Property',"PropertyID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			}
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		if(!empty($config['PropertiesDefaultOrder']))
		{
			if($config['PropertiesDefaultOrder']=='random')
			{
				$order = '';
			}
			else
			{
				$order = 'ORDER BY '.$config['PropertiesDefaultOrder'];
			}
		}
		else
		{
			$order = 'ORDER BY Property.PropertyAlias, Property.PropertyID ASC';
		}
		if(!empty($fieldsFilter))
		{
			//$query = "SELECT * FROM PropertyTypeField LEFT JOIN PropertyTypeOption ON PropertyTypeField.PropertyTypeFieldID = PropertyTypeOption.PropertyTypeFieldID WHERE PropertyTypeField.PropertyType = '$entityType' $filter ORDER BY PropertyTypeFieldPosition, PropertyTypeOptionPosition"; 
			$query = "SELECT *,Property.PropertyID AS PropertyID FROM Property LEFT JOIN PropertyField ON Property.PropertyID = PropertyField.PropertyID  WHERE Property.PropertyID>0 $filter $fieldsFilter $order $limit";
		}
		else
		{
			$query = "SELECT * FROM Property WHERE PropertyID>0 $filter $order $limit";
		}
				
		//get the content
		$result['result'] = $DS->query($query); 
		//print_r($result['result']);
		$result['pages'] = $pages['pages'];
		$SERVER->setDebug('PropertyClass.getProperties.End','End');
		return $result;
	}	
	
	function getPropertyFieldSearchFilter($input)
	{
		$DS = &$this->_DS;
		$fieldsFilter = '';
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('PropertySearchField'.DTR,$fieldName))
			{
				//process propertyfield saving
				$fieldCode = str_replace('PropertySearchField'.DTR,'',$fieldName);
				//getProperty filed info 
				if(!empty($fieldCode) && !empty($fieldVale) && ($fieldCode=='Quality_type3' || $fieldCode=='Situation_type1' || $fieldCode=='Bedrooms_type7'))
				{
					$propertyTypeInfoRS = $DS->query("SELECT PropertyFieldType FROM PropertyField WHERE PropertyFieldAlias='$fieldCode' ");
					$fieldType = $propertyTypeInfoRS[0]['PropertyFieldType'];
					if($fieldType == 'dropdown')
					{
						$fieldsFilter .= " AND (PropertyFieldAlias='$fieldCode' AND PropertyFieldValue = '$fieldVale' )";
					}
				}
			}
		}			
		
		return $fieldsFilter;
	}
	
	function getActivePropertiesFilter()
	{
		
	}
	
	function getPropertyFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getPropertyFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode = $input['viewMode'];
		//set client side variables
		$entityType = $input['SourceType'];
		if(empty($entityType)) {$entityType = $input['PropertyType'];}
		
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}
		
		$entityAlias = $input['Property'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Property'.DTR.'PropertyAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$PropertyIDRS = $DS->query("SELECT PropertyID FROM Property WHERE PropertyAlias='$entityAlias'");
			$entityID = $PropertyIDRS[0]['PropertyID'];
		}
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//$filter .= "OwnerID='$ownerID' ";

		$PropertyTypeIDRS = $DS->query("SELECT PropertyTypeID FROM PropertyType WHERE PropertyTypeAlias='$entityType'");
		$PropertyTypeID = $PropertyTypeIDRS[0]['PropertyTypeID'];
		$query = "SELECT * FROM PropertyTypeField LEFT JOIN PropertyTypeOption ON PropertyTypeField.PropertyTypeFieldID = PropertyTypeOption.PropertyTypeFieldID WHERE (PropertyTypeField.PropertyType = '$entityType' OR PropertyTypeField.PropertyTypeID = '1') $filter ORDER BY PropertyTypeFieldPosition, PropertyTypeOptionPosition"; 
		//$query = "SELECT * FROM (PropertyField LEFT JOIN PropertyTypeField ON PropertyField.PropertyTypeFieldID = PropertyTypeField.PropertyTypeFieldID) LEFT JOIN PropertyTypeOption ON PropertyTypeField.PropertyTypeFieldID = PropertyTypeOption.PropertyTypeFieldID WHERE PropertyTypeField.PropertyType = '$entityType' AND PropertyID='$entityID' $filter ORDER BY PropertyTypeFieldPosition, PropertyTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['PropertyTypeFieldAlias'];
				$fieldName = $row['PropertyTypeFieldName'];
				$fieldType = $row['PropertyTypeFieldType'];
				$fieldMode = $row['PropertyTypeFieldMode'];
				$fieldPlaces = $row['PropertyTypeFieldHidenPlaces'];
				$fieldOptionID = $row['PropertyTypeOptionID'];
				$fieldOptionAlias = $row['PropertyTypeOptionAlias'];
				$fieldOptionValue = $row['PropertyTypeOptionName'];
				
				$fieldOptionPrice = $row['PropertyTypeOptionPrice'];
				$fieldOptionPriceAction = $row['PropertyTypeOptionPriceAction'];
				$fieldOptionWeight = $row['PropertyTypeOptionWeight'];
				$fieldOptionWeightAction = $row['PropertyTypeOptionWeightAction'];
				$fieldOptionPosition = $row['PropertyTypeOptionPosition'];
				
				$result['PropertyFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['PropertyFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['PropertyFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['PropertyFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['PropertyFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					if($fieldMode=='option')
					{
						$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;

						//$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['price'] = $fieldOptionPrice;
						//$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['priceaction'] = $fieldOptionPriceAction;
						//$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['weight'] = $fieldOptionWeight;
						//$result['PropertyFieldTypes'][$fieldCode]['options'][$i]['weightaction'] = $fieldOptionWeightAction;

						$result['PropertyOption'][$fieldOptionID]['PropertyOptionPrice'] = $fieldOptionPrice;
						$result['PropertyOption'][$fieldOptionID]['PropertyOptionPriceAction'] = $fieldOptionPriceAction;
						$result['PropertyOption'][$fieldOptionID]['PropertyOptionWeight'] = $fieldOptionWeight;
						$result['PropertyOption'][$fieldOptionID]['PropertyOptionWeightAction'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		if(!empty($entityID))
		{
			$query = "SELECT * FROM PropertyField LEFT JOIN PropertyOption ON PropertyField.PropertyFieldID = PropertyOption.PropertyFieldID WHERE PropertyID='$entityID' $filter ORDER BY PropertyFieldPosition, PropertyOptionPosition"; 
			//$query = "SELECT * FROM PropertyField WHERE PropertyID='$entityID' $filter ORDER BY PropertyFieldPosition"; 
			$rs = $DS->query($query);
		}
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();

			foreach($rs as $row)
			{
				$fieldCode = $row['PropertyFieldAlias'];
				$fieldType = $row['PropertyFieldType'];
				
				$propertyFieldID = $row['PropertyFieldID'];
				$fieldOptionID = $row['PropertyOptionID'];
				
				$fieldTypeOptionID = $row['PropertyTypeOptionID'];
				
				$fieldOptionStatus = $row['PropertyOptionStatus'];
				$fieldOptionPrice = $row['PropertyOptionPrice'];
				$fieldOptionPriceAction = $row['PropertyOptionPriceAction'];
				$fieldOptionWeight = $row['PropertyOptionWeight'];
				$fieldOptionWeightAction = $row['PropertyOptionWeightAction'];
				
	
				if($row['PropertyFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['PropertyFieldValueTime'];
				}
				elseif($row['PropertyFieldValueNumber']>0)
				{
					$fieldValue = $row['PropertyFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['PropertyFieldValue'];
				}									
				
				if(!empty($result['PropertyFieldTypes'][$fieldCode]['code']))
				{
					$result['PropertyFieldTypes'][$fieldCode]['status'] = $row['PropertyFieldStatus'];
				}
				$result['PropertyField'][0][$fieldCode] = $fieldValue;
				
				$result['PropertyOption'][$fieldTypeOptionID]['PropertyFieldID'] = $propertyFieldID;			
				
				if(!empty($fieldTypeOptionID))
				{
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionID'] = $fieldOptionID;
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionStatus'] = $fieldOptionStatus;	
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyTypeOptionID'] = $fieldTypeOptionID;		
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionPrice'] = $fieldOptionPrice;
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionPriceAction'] = $fieldOptionPriceAction;
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionWeight'] = $fieldOptionWeight;
					$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionWeightAction'] = $fieldOptionWeightAction;
					//$result['PropertyOption'][$fieldTypeOptionID]['PropertyOptionWeightAction'] = $fieldOptionWeightAction;
				}
				
				if($viewMode=='viewproperty' && $result['PropertyFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
				{
					foreach($result['PropertyFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
					{
						if($fieldTypeOptionID==$result['PropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
						{
							if($fieldOptionStatus==2)
							{
								$result['PropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
								$result['PropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
							}
							else
							{
								$result['PropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value']='';
								foreach($languagesList['languageCodes'] as $langID=>$langCode) 
								{ 
									$result['PropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] .= '<'.$langCode.'>'.$SERVER->getValue($redefinVieldValue['value'],$langCode).' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'].'</'.$langCode.'>';
								}
							}
						}
					}
				}						
				
			}		
		}
		//print_r($result['PropertyOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('PropertyClass.getPropertyFields.End','End');
		return $result;
	}	
	
	function getPropertyFields($input)
	{
		$rs = $this->getPropertyFieldsStructureAndValues($input);
		if(is_array($rs['PropertyFieldTypes']))
		{
			foreach($rs['PropertyFieldTypes'] as $PropertyFieldCode=>$PropertyFieldType)			
			{
				if(!empty($PropertyFieldType['code']))
				{
					$result['PropertyField'][$PropertyFieldCode]['code']=$PropertyFieldType['code'];
					$result['PropertyField'][$PropertyFieldCode]['name']=$PropertyFieldType['name'];
					$result['PropertyField'][$PropertyFieldCode]['type']=$PropertyFieldType['type'];
					$result['PropertyField'][$PropertyFieldCode]['mode']=$PropertyFieldType['mode'];
					$result['PropertyField'][$PropertyFieldCode]['status']=$PropertyFieldType['status'];
					$result['PropertyField'][$PropertyFieldCode]['places']=$PropertyFieldType['places'];
					
					$result['PropertyField'][$PropertyFieldCode]['value']=$rs['PropertyField'][0][$PropertyFieldCode];
					if(is_array($PropertyFieldType['options'])) {
						foreach($PropertyFieldType['options'] as $id=>$propertyFieldOptions) { 
							$optionsTypeID = $propertyFieldOptions['id'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['id']=$propertyFieldOptions['id'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['value']=$propertyFieldOptions['value'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['position']=$propertyFieldOptions['position'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionID']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionID'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyFieldID']=$rs['PropertyOption'][$optionsTypeID]['PropertyFieldID'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionStatus']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionStatus'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyTypeOptionID']=$rs['PropertyOption'][$optionsTypeID]['PropertyTypeOptionID'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionPrice']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionPrice'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionPriceAction']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionPriceAction'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionWeight']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionWeight'];
							$result['PropertyField'][$PropertyFieldCode]['options'][$id]['PropertyOptionWeightAction']=$rs['PropertyOption'][$optionsTypeID]['PropertyOptionWeightAction'];
						}//end of foreach($PropertyFieldType['options'] as $id=>$propertyFieldOptions) 
					}//end of if(is_array($PropertyFieldType['options']))
				}//end of if(!empty($PropertyFieldType['code']) && !empty($rs['PropertyField'][0][$PropertyFieldCode]))
			}
		}
		//echo '<textarea cols=50 rows=20>';
		//print_r($result);
		//echo '</textarea>';
		return $result;
	}
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getProperty.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Property'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Property'.DTR.'PropertyAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " PropertyAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " PropertyID='$entityID' ";
			}
			$query = "SELECT * FROM Property WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
	
			$propertyTypeObject = new PropertyTypeClass();
			$propertyTemplate = $propertyTypeObject->getPropertyTemplate($result[0]['PropertyType']);
			$SERVER->setInputVar('PropertyTemplate',$propertyTemplate);
			$SERVER->setInputVar('PropertyType',$result[0]['PropertyType']);
		}		
		$SERVER->setDebug('PropertyClass.getProperty.End','End');		
		return $result;		
	}
	
	function getPropertyField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getPropertyField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyField'.DTR.'PropertyFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyFieldID'];}

		$entityAlias = $input['PropertyField'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyField'.DTR.'PropertyFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyFieldID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PropertyClass.getPropertyField.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.setProperty.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}		
		if(empty($input['Property'.DTR.'PermAll'])) {$input['Property'.DTR.'PermAll']=4;}
		
		
		if($config['PropertyValidationMode']=='N')
		{
			$input['Property'.DTR.'PermAll']=1;
		}
		else
		{
			if(!$SERVER->hasRights('admin')) {$input['Property'.DTR.'PermAll']=4;}
		}
		
		if($SERVER->hasRights('admin') && $input['Property'.DTR.'PermAll']==1 && empty($input['Property'.DTR.'PropertyStatus'])) {$input['Property'.DTR.'PropertyStatus']='active';}
					
		if(empty($input['Property'.DTR.'PropertyStatus'])) {$input['Property'.DTR.'PropertyStatus']='new';}
		if(empty($input['Property'.DTR.'PropertyAuthor'])  && $clientType!='admin') {$input['Property'.DTR.'PropertyAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['Property'.DTR.'PropertyLink']) && $clientType!='admin') {$input['Property'.DTR.'PropertyLink']=$user['UserLink'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries	
		//if(is_array($input['Property'.DTR.'PropertyLanguages'])) {$input['Property'.DTR.'PropertyLanguages'] = '|'. implode("|",$input['Property'.DTR.'PropertyLanguages']).'|'; }
			
		//if(is_array($input['Property'.DTR.'AccessGroups'])) {$input['Property'.DTR.'AccessGroups'] = '|'. implode("|",$input['Property'.DTR.'AccessGroups']).'|'; }
		$where['Property'] = "PropertyID = '".$entityID."'".$filter;
//		print_r($input);
		if(empty($input['Property'.DTR.'PropertyAlias']) && !empty($input['Property'.DTR.'PropertyTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPropertyTitle = $input['Property'.DTR.'PropertyTitle']['en'];
			if(empty($langPropertyTitle)) { $lang = $config['lang']; $langPropertyTitle = $input['Property'.DTR.'PropertyTitle'][$lang];}
			$input['Property'.DTR.'PropertyAlias'] = $typeObject->setDataType($langPropertyTitle);
		}	
		
		/*if(!empty($input['Property'.DTR.'PropertyAlias']))
		{
			$checkRS=$DS->query("SELECT PropertyAlias FROM Property WHERE PropertyAlias='".$input['Property'.DTR.'PropertyAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['Property'.DTR.'PropertyAlias'] = $input['Property'.DTR.'PropertyAlias'].date('Ymd-His');
				$SERVER->setMessage('property.PropertyClass.setProperty.err.DuplicatedProperty');
			}				
		}*/
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll, PropertyStatus FROM Property WHERE PropertyID='".$entityID."'");
		}		
		//set visibility mode status	
		if(!empty($input['Property'.DTR.'PropertyTitle']))
		{		
			if(!empty($input['PropertyResource'.DTR.'PropertyResourceName'][$config['lang']]))
			{
				$result['PropertyResource'] = $this->setPropertyResource($input);
			}
			$input['actionMode']='save';
			$result = $DS->save($input,$where);
			$entityID = $result[0]['PropertyID'];			
			$input['Property'.DTR.'PropertyID'] = $entityID;
			if(!empty($input['Property'.DTR.'PropertyID']))	
			{
				$this->setPropertyField($input,$uploadRS);	
			}				
			$this->updateSerializedPropertyFields($entityID,$input['Property'.DTR.'PropertyType']);
		}
		else
		{
			if(!empty($input['Property'.DTR.'PropertyAlias']))
			{
				$SERVER->setMessage('PropertyClass.setProperty.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('PropertyClass.setProperty.msg.DataSaved');
		}
		//if(!empty($input['Property'.DTR.'PropertyAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Property');
		//}
		$SERVER->setDebug('PropertyClass.setProperty.End','End');		
		return $result;		
	}
	
	function setPropertyResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.setPropertyResource.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}		
		if(empty($input['Property'.DTR.'PermAll'])) {$input['Property'.DTR.'PermAll']=4;}

		$where['PropertyResource'] = "PropertyResourceID = '".$input['PropertyResource'.DTR.'PropertyResourceID']."'".$filter;
		
		$input['PropertyResource'.DTR.'PropertyID'] = $entityID;
		$input['actionMode']='save';
		$result = $DS->save($input,$where);
		
		$SERVER->setDebug('PropertyClass.setPropertyResource.End','End');
		return $result;
	}
	
	function getPropertyResourcies($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getPropertyResourcies.Start','Start');
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
		
		$categoryAlias = $input['category'];
		$categoryID = $input['CategoryID'];
		$sectionID = $input['SID'];
		
		$locationAlias = $input['location'];
		$locationID = $input['LocationID'];
		
		$propertyType = $input['PropertyType'];
		$propertyFeaturedOption = $input['PropertyFeaturedOption'];
		$permAll = $input['PermAll'];
		$propertyStatus = $input['PropertyStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}	
		//set filters
		if(!empty($permAll))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if(!empty($entityID))
		{
			$filter .= " AND PropertyID='$entityID' ";
		}
		//set queries
		foreach($input['DB']['Reference'] as $value)
		{
			$query = "SELECT * FROM PropertyResource WHERE PropertyResourceID>0 $filter AND PropertyResourceType = '".$value['OptionCode']."' ORDER BY PropertyResourcePosition ";
			$result[$value['OptionCode']] = $DS->query($query); 
		}		
		//get the content
		//echo $query;
		
		$SERVER->setDebug('PropertyClass.getPropertyResourcies.End','End');
		return $result;
	}
	
	function getPropertyResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.getPropertyResource.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyResource'.DTR.'PropertyResourceID'];
		if(empty($entityID)) {$entityID = $input['PropertyResourceID'];}

		//set filters
		
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		$query ='';
		if(!empty($entityID))
		{
			$filter = " PropertyResourceID='$entityID' ";

			$query = "SELECT * FROM PropertyResource WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
			
		}		
		$SERVER->setDebug('PropertyClass.getPropertyResource.End','End');		
		return $result;		
	}
	
	function updateSerializedPropertyFields($propertyID,$propertyType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($propertyID))
		{
			$input['PropertyID'] = $propertyID;
			$input['PropertyType'] = $propertyType;
			$rs = $this->getPropertyFields($input);
			$propertyFields = serialize($rs);
			$propertyFields = $SERVER->cleanString($propertyFields,'noquotes');
			$DS->query("UPDATE Property SET PropertyFields = '$propertyFields' WHERE PropertyID='$propertyID'");
		}
	}

	function setPropertyField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyFieldClass.setPropertyField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Property'.DTR.'PropertyID'];
		if(empty($entityID)) {$entityID = $input['PropertyID'];}	
			
		$entityType = $input['PropertyType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['Property'.DTR.'PropertyType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyFieldServer.adminPropertyField');
		//set queries	
		if(!empty($entityID))
		{
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('PropertyField'.DTR,$fieldName))
				{
					//process propertyfield saving
					$fieldCode = str_replace('PropertyField'.DTR,'',$fieldName);
					//get the field type
					//$entityType
					
					$fieldInfoRS = $DS->query("SELECT PropertyTypeFieldID, PropertyTypeFieldType, PropertyTypeFieldPosition, PropertyTypeFieldName, PropertyTypeFieldAlias, PropertyTypeFieldMode, PropertyTypeFieldMode FROM PropertyTypeField WHERE PropertyTypeFieldAlias = '$fieldCode' AND PropertyType='$entityType' ");
					$fieldType = $fieldInfoRS[0]['PropertyTypeFieldType'];
					$fieldTypeID = $fieldInfoRS[0]['PropertyTypeFieldID'];
					$fieldTypePosition = $fieldInfoRS[0]['PropertyTypeFieldPosition'];
					$fieldTypeMode = $fieldInfoRS[0]['PropertyTypeFieldMode'];
					$fieldTypeName = $fieldInfoRS[0]['PropertyTypeFieldName'];
					$fieldTypeMode = $fieldInfoRS[0]['PropertyTypeFieldMode'];
					
	
	
					//format the field for respective field type
					if(is_array($fieldVale))
					{
						//transfrom for checkboxes or language field
						$k=1;
						$fieldValeResult='';
						foreach($fieldVale as $itemCode=>$itemValue)
						{
							if($fieldType=='checkboxes')
							{
								if($k==1)
								{
									$fieldValeResult .= "|$itemValue|";
									$k++;
								}
								else
								{
									$fieldValeResult .= "$itemValue|";
								}
							}
							elseif($fieldType=='text' || $fieldType=='input')
							{
								$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
							}
						}
						$fieldVale = $fieldValeResult;
					}
					//check if there is a value
					$checkRS = $DS->query("SELECT PropertyFieldID FROM PropertyField WHERE PropertyID='$entityID' AND PropertyFieldAlias='$fieldCode'");
					$propertyFieldID = $checkRS[0]['PropertyFieldID'];
	
					if($fieldType=='number' || $fieldType=='money')
					{
						$valueFieldName = 'PropertyFieldValueNumber';
					}
					elseif($fieldType=='time' || $fieldType=='date')
					{
						$valueFieldName = 'PropertyFieldValueTime';
					}
					else
					{
						$valueFieldName = 'PropertyFieldValue';
					}
	
					if($fieldVale=='image' || $fieldVale=='file')
					{
						if(!empty($uploadRS[$fieldCode]['file']))
						{
							$fieldVale= $uploadRS[$fieldCode]['file'];
						}		
						else
						{
							$fileFieldRS = $DS->query("SELECT PropertyFieldValue FROM PropertyField WHERE PropertyFieldID='$propertyFieldID'");
							$fieldVale=$fileFieldRS[0][$valueFieldName];
						}				
					}
					
					if($fieldVale=='deletefieldfile')
					{
						if(!empty($propertyFieldID))
						{
							$FM = new FilesManager();
							//$fileField =$input['fileField'];
							$fileFieldRS = $DS->query("SELECT PropertyFieldValue FROM PropertyField WHERE PropertyFieldID='$propertyFieldID'");
							$SERVER->setInputVar('actionMode','deletefile');
							$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
							$fieldVale='';
							$input['PropertyFieldStatus'][$fieldCode] = 1;
						}
					}				
					
					if($input['PropertyFieldStatus'][$fieldCode]!=1)
					{
						$fieldStatus = 2;
					}
					else
					{
						$fieldStatus = 1;
					}
					//echo 'PropertyFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';
	
					if(!empty($propertyFieldID))
					{
						//udpate
						$query = "UPDATE PropertyField SET PropertyID='$entityID',PropertyFieldAlias='$fieldCode', PropertyTypeFieldID='$fieldTypeID',PropertyFieldType='$fieldType',PropertyFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', PropertyFieldStatus='$fieldStatus' WHERE PropertyFieldID='$propertyFieldID'";
					}
					else
					{
						//insert
						$query = "INSERT INTO PropertyField (PropertyID,PropertyFieldAlias,PropertyTypeFieldID,PropertyFieldType,PropertyFieldPosition,$valueFieldName,PropertyFieldStatus) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
					}
					
					//echo $query.'<br>';
					$DS->query($query);
					if(empty($propertyFieldID))
					{
						$propertyFieldID = $DS->dbLastID();	
					}
					
					if(is_array($input['PropertyOptionFieldCode']) && $fieldTypeMode=='option')
					{
						foreach($input['PropertyOptionFieldCode'] as $i=>$propertyOptionFieldCode)
						{
							if($propertyOptionFieldCode==$fieldCode)
							{
								$inputSave['PropertyOption'.DTR.'PropertyTypeOptionID'] = $input['PropertyOption'.DTR.'PropertyTypeOptionID'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyFieldID'] = $propertyFieldID;
								$inputSave['PropertyOption'.DTR.'PropertyOptionID'] = $input['PropertyOption'.DTR.'PropertyOptionID'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyOptionPosition'] = $input['PropertyOption'.DTR.'PropertyOptionPosition'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyOptionPrice'] = $input['PropertyOption'.DTR.'PropertyOptionPrice'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyOptionPriceAction'] = $input['PropertyOption'.DTR.'PropertyOptionPriceAction'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyOptionWeight'] = $input['PropertyOption'.DTR.'PropertyOptionWeight'][$i];
								$inputSave['PropertyOption'.DTR.'PropertyOptionWeightAction'] = $input['PropertyOption'.DTR.'PropertyOptionWeightAction'][$i];
								
								$inputSave['PropertyOption'.DTR.'PropertyOptionStatus'] = $input['PropertyOption'.DTR.'PropertyOptionStatus'][$i];
								
								if($inputSave['PropertyOption'.DTR.'PropertyOptionStatus']!=1)
								{
									$inputSave['PropertyOption'.DTR.'PropertyOptionStatus']=2;
								}
								else
								{
									$inputSave['PropertyOption'.DTR.'PropertyOptionStatus']=1;
								}
								//echo 'status='.$inputSave['PropertyOption'.DTR.'PropertyOptionStatus'];
								$inputSave['actionMode']='save';
			
								$where['PropertyOption'] = "PropertyOptionID = '".$inputSave['PropertyOption'.DTR.'PropertyOptionID']."'";
								$DS->save($inputSave,$where);	
							}
						}
					}				
				}
			}
		}
		//if(!empty($input['PropertyField'.DTR.'PropertyFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'PropertyField',$input['PropertyField'.DTR.'PropertyID'],'Property');
		//}		
		$SERVER->setDebug('PropertyFieldClass.setPropertyField.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.deleteProperty.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Property'.DTR.'PropertyID'];
		//if(empty($entityID)) {$entityID = $input['PropertyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT PropertyFieldID FROM PropertyField WHERE PropertyID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['PropertyFieldID'];
			$DS->query("DELETE FROM Property WHERE PropertyID='$entityID'");
			$DS->query("DELETE FROM PropertyField WHERE PropertyID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM PropertyOption WHERE PropertyFieldID='$typeFieldID'");
			}
		}
		//$SERVER->setMessage('PropertyClass.deleteProperty.msg.DataDeleted');
		$SERVER->setDebug('PropertyClass.deleteProperty.End','End');		
		return $result;		
	}	
	
	function deletePropertyField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyClass.deletePropertyField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyField'.DTR.'PropertyFieldID'];
		//if(empty($entityID)) {$entityID = $input['PropertyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyServer.adminProperty');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PropertyField WHERE PropertyID='$entityID'");
			$DS->query("DELETE FROM PropertyOption WHERE PropertyFieldID='$entityID'");
		}
		$SERVER->setMessage('PropertyClass.deletePropertyField.msg.DataDeleted');
		$SERVER->setDebug('PropertyClass.deletePropertyField.End','End');		
		return $result;		
	}	
	
	function copyProperty($input)
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
		$PropertyTemplateID = $input['selectedPropertyID'];
		$PropertyID = $input['PropertyID'];
		if($PropertyID==$PropertyTemplateID) {return false;}
		//set client side variables
		if(!empty($PropertyTemplateID) && !empty($PropertyID))
		{
			//make Property link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM PropertyField WHERE PropertyID='$PropertyTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['PropertyField'] = "PropertyFieldID = ''";
			$inputNew['PropertyField'.DTR.'PropertyFieldID']='';
			$inputNew['PropertyField'.DTR.'OwnerID']=$ownerID;
			$inputNew['PropertyField'.DTR.'UserID']=$userID;
			$inputNew['PropertyField'.DTR.'PropertyID']=$PropertyID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['PropertyField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['PropertyField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['PropertyField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM PropertyField WHERE BoxID='".$inputNew['PropertyField'.DTR.'BoxID']."' AND PropertyID='".$PropertyID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Property
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
	
	function getBidsUsers($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode= $input['viewMode'];
		$propertyID= $input['PropertyID'];
		if(empty($propertyID)) {$propertyID = $input['Property'.DTR.'PropertyID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyBidServer.adminPropertyBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if($viewMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		else
		{
			if($SERVER->hasRights('admin'))
			{
				$filter .= " AND PropertyID='$propertyID' ";
			}
			else
			{
				$filter .= " AND UserID='$userID' AND PropertyID='$propertyID' ";
			}
			
		}
		//set queries
		$query = "SELECT * FROM PropertyBid WHERE PropertyBidID>0 $filter  ORDER BY PropertyBidID";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		//print_r($rs);
		return $result;
	}

} // end of PropertyServer
?>