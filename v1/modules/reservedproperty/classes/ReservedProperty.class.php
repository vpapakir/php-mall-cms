<?php
//XCMSPro: Web Service entity class
class ReservedPropertyClass
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
	function ReservedPropertyClass()
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
	function getReservedProperties($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.getReservedProperties.Start','Start');
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
		$ReservedPropertyLocation = $input['ReservedPropertyLocation'];
		
		$reservedPropertyType = $input['type'];
		if(empty($reservedPropertyType)) {$reservedPropertyType = $input['ReservedPropertyType'];}
		$reservedPropertyFeaturedOption = $input['ReservedPropertyFeaturedOption'];
		$permAll = $input['PermAll'];
		$reservedPropertyStatus = $input['ReservedPropertyStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		$ReservedPropertyPriceRange = $input['reservedPropertyPriceRange'];
		
		$actionType = $input['actionType'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//as 17.04.2006
		/*if(!empty($locationAlias))
		{
			$locationIDRS = $DS->query("SELECT RegionID FROM Region WHERE RegionCode='$locationAlias'");
			$locationID = $locationIDRS[0]['RegionID'];
		}		
		if(!empty($locationID))
		{
			$filter .= " AND ReservedPropertyLocationID = '$locationID' ";
		}*/
		//as 17.04.2006		 
		if(!empty($ReservedPropertyPriceRange))
		{
			$ReservedPropertyPriceRange = explode("-",$ReservedPropertyPriceRange);
			$filter .= " AND (ReservedPropertyPrice > ".$ReservedPropertyPriceRange[0]." AND ReservedPropertyPrice < ".$ReservedPropertyPriceRange[1].")";
		}
		if(!empty($locationAlias))
		{
			$locationAlias = str_replace('-',"vvv",$locationAlias);
			$filter .= " AND(ReservedPropertyLocation LIKE '%|$locationAlias|%' OR ReservedPropertyLocation LIKE '%|[$locationAlias]|%')";
		}
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
			$limitedMode='Y';
		}
		if($filterMode=='top')
		{
			$limit = " LIMIT 0,30";
			$limitedMode='Y';
		}		
		if(!empty($reservedPropertyType))
		{
			$filter .= " AND ReservedPropertyType='$reservedPropertyType' ";
		}	
		if(!empty($actionType))
		{
			if($actionType=='sell' || $actionType=='rent')
			{
				$filter .= " AND (ReservedPropertyActionType='$actionType' OR ReservedPropertyActionType='sell-rent') ";
			}
			else
			{
				$filter .= " AND ReservedPropertyActionType='$actionType' ";
			}
		}			

		if($config['OwnerType']!='root')
		{
			$filter .= " AND (ReservedPropertyActionType='sell' OR ReservedPropertyActionType='rent') ";
		}
		if(!empty($input['ReservedPropertyActionType']))
		{
			$filter .= " AND ReservedPropertyActionType='".$input['ReservedPropertyActionType']."' ";
		}	
		if(!empty($reservedPropertyStatus))
		{
			$filter .= " AND ReservedPropertyStatus='$reservedPropertyStatus' ";
		}			
		if(!empty($reservedPropertyFeaturedOption))
		{
			$filter .= " AND ReservedPropertyFeaturedOptions LIKE '%|$reservedPropertyFeaturedOption|%' ";
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
			$filter .= " AND (ReservedPropertyTitle LIKE '%$searchWord%' OR ReservedPropertyIntro LIKE '%$searchWord%' OR ReservedPropertyContent LIKE '%$searchWord%' OR ReservedPropertyKeywords LIKE '%$searchWord%')  ";
		}	
		if(!empty($featuredMode))
		{
			if($config['ReservedPropertyFeaturedPlacesMode']=='one')
			{
				$filter .= " AND ReservedPropertyFeaturedOptions LIKE '|$featuredMode|' ";
			}
			else
			{
				$filter .= " AND ReservedPropertyFeaturedOptions LIKE '%|$featuredMode|%' ";
			}
		}		
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			if($config['OwnerType']=='root')
			{
				$filter .= " AND PermAll='1' ";
			}
			$filter .= " AND ReservedPropertyStatus='active' ";
		}
		
		/*if($filterMode=='home')
		{
			if($config['ReservedPropertyFeaturedPlacesMode']=='one')
			{
				$filter .= " AND ReservedPropertyFeaturedOptions LIKE '|home|' ";
			}
			else
			{
				$filter .= " AND ReservedPropertyFeaturedOptions LIKE '%|home|%' ";
			}
		}*/
		
		if(($userID!='admin' && $userID!='root') && ($TimeEndMode!='all'))
		{
			if($config['OwnerType']=='root')
			{
				$filter .= "  AND (TimeEnd>'".date('Y-m-d H:m:s')."' OR TimeEnd='0000-00-00 00:00:00') AND ReservedPropertyPaymentStatus='paid' ";
			}
		}	
		
		//echo 'manageMode='.$manageMode;
		if($ownerMode!='all')
		{
			if($config['OwnerType']=='root')
			{		
				$filter .= " AND OwnerID='$ownerID' ";
			}
			else
			{
				$filter .= " AND (OwnerID='$ownerID' OR UserID = '".$config['OwnerUserID']."') ";
			}
		}
		//search in reservedProperty field
	
		$fieldsFilter = $this->getReservedPropertyFieldSearchFilter($input);
		
		if(empty($limit))
		{
			if(!empty($fieldsFilter))
			{		
				$pages = $DS->getPages(' ReservedProperty LEFT JOIN ReservedPropertyField ON ReservedProperty.ReservedPropertyID = ReservedPropertyField.ReservedPropertyID',"ReservedProperty.ReservedPropertyID>0 $filter $fieldsFilter ",array('ItemsPerPage'=>$itemsPerPage));
			}
			else
			{
				$pages = $DS->getPages('ReservedProperty',"ReservedPropertyID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			}
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		if(!empty($config['ReservedPropertiesDefaultOrder']))
		{
			if($config['ReservedPropertiesDefaultOrder']=='random')
			{
				$order = '';
			}
			else
			{
				$order = 'ORDER BY '.$config['ReservedPropertiesDefaultOrder'];
			}
		}
		else
		{
			$order = 'ORDER BY ReservedProperty.ReservedPropertyAlias, ReservedProperty.ReservedPropertyID ASC';
		}
		if(!empty($fieldsFilter))
		{
			//$query = "SELECT * FROM ReservedPropertyTypeField LEFT JOIN ReservedPropertyTypeOption ON ReservedPropertyTypeField.ReservedPropertyTypeFieldID = ReservedPropertyTypeOption.ReservedPropertyTypeFieldID WHERE ReservedPropertyTypeField.ReservedPropertyType = '$entityType' $filter ORDER BY ReservedPropertyTypeFieldPosition, ReservedPropertyTypeOptionPosition"; 
			$query = "SELECT *,ReservedProperty.ReservedPropertyID AS ReservedPropertyID FROM ReservedProperty LEFT JOIN ReservedPropertyField ON ReservedProperty.ReservedPropertyID = ReservedPropertyField.ReservedPropertyID  WHERE ReservedProperty.ReservedPropertyID>0 $filter $fieldsFilter $order $limit";
		}
		else
		{
			$query = "SELECT * FROM ReservedProperty WHERE ReservedPropertyID>0 $filter $order $limit";
		}
				
		//get the content
		//echo $query;
		$result['result'] = $DS->query($query); 
		if($limitedMode=='Y')
		{
			$result['pages']['total']=count($result['result']);
		}
		else
		{
			$result['pages'] = $pages['pages'];
		}
		//print_r($result['pages']);
		
		$SERVER->setDebug('ReservedPropertyClass.getReservedProperties.End','End');
		return $result;
	}	
	
	function getReservedPropertyFieldSearchFilter($input)
	{
		$DS = &$this->_DS;
		$fieldsFilter = '';
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('ReservedPropertySearchField'.DTR,$fieldName))
			{
				//process reservedPropertyfield saving
				$fieldCode = str_replace('ReservedPropertySearchField'.DTR,'',$fieldName);
				//getReservedProperty filed info 
				if(!empty($fieldCode) && !empty($fieldVale))
				{
					$reservedPropertyTypeInfoRS = $DS->query("SELECT ReservedPropertyFieldType FROM ReservedPropertyField WHERE ReservedPropertyFieldAlias='$fieldCode' ");
					$fieldType = $reservedPropertyTypeInfoRS[0]['ReservedPropertyFieldType'];
					if($fieldType == 'dropdown')
					{
						$fieldsFilter .= " AND (ReservedPropertyFieldAlias='$fieldCode' AND ReservedPropertyFieldValue = '$fieldVale' )";
					}
				}
			}
		}			
		
		return $fieldsFilter;
	}
	
	function getActiveReservedPropertiesFilter()
	{
		
	}
	
	function getReservedPropertyFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyFields.Start','Start');
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
		if(empty($entityType)) {$entityType = $input['ReservedPropertyType'];}
		
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}
		
		$entityAlias = $input['ReservedProperty'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedProperty'.DTR.'ReservedPropertyAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ReservedPropertyIDRS = $DS->query("SELECT ReservedPropertyID FROM ReservedProperty WHERE ReservedPropertyAlias='$entityAlias'");
			$entityID = $ReservedPropertyIDRS[0]['ReservedPropertyID'];
		}
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//$filter .= "OwnerID='$ownerID' ";

		$ReservedPropertyTypeIDRS = $DS->query("SELECT ReservedPropertyTypeID FROM ReservedPropertyType WHERE ReservedPropertyTypeAlias='$entityType'");
		$ReservedPropertyTypeID = $ReservedPropertyTypeIDRS[0]['ReservedPropertyTypeID'];
		$query = "SELECT * FROM ReservedPropertyTypeField LEFT JOIN ReservedPropertyTypeOption ON ReservedPropertyTypeField.ReservedPropertyTypeFieldID = ReservedPropertyTypeOption.ReservedPropertyTypeFieldID WHERE (ReservedPropertyTypeField.ReservedPropertyType = '$entityType' OR ReservedPropertyTypeField.ReservedPropertyTypeID = '1') $filter ORDER BY ReservedPropertyTypeFieldPosition, ReservedPropertyTypeOptionPosition"; 
		//$query = "SELECT * FROM (ReservedPropertyField LEFT JOIN ReservedPropertyTypeField ON ReservedPropertyField.ReservedPropertyTypeFieldID = ReservedPropertyTypeField.ReservedPropertyTypeFieldID) LEFT JOIN ReservedPropertyTypeOption ON ReservedPropertyTypeField.ReservedPropertyTypeFieldID = ReservedPropertyTypeOption.ReservedPropertyTypeFieldID WHERE ReservedPropertyTypeField.ReservedPropertyType = '$entityType' AND ReservedPropertyID='$entityID' $filter ORDER BY ReservedPropertyTypeFieldPosition, ReservedPropertyTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['ReservedPropertyTypeFieldAlias'];
				$fieldName = $row['ReservedPropertyTypeFieldName'];
				$fieldType = $row['ReservedPropertyTypeFieldType'];
				$fieldMode = $row['ReservedPropertyTypeFieldMode'];
				$fieldPlaces = $row['ReservedPropertyTypeFieldHidenPlaces'];
				$fieldOptionID = $row['ReservedPropertyTypeOptionID'];
				$fieldOptionAlias = $row['ReservedPropertyTypeOptionAlias'];
				$fieldOptionValue = $row['ReservedPropertyTypeOptionName'];
				$fieldParts = $row['ReservedPropertyTypeFieldParts'];
				
				
				$fieldOptionPrice = $row['ReservedPropertyTypeOptionPrice'];
				$fieldOptionPriceAction = $row['ReservedPropertyTypeOptionPriceAction'];
				$fieldOptionWeight = $row['ReservedPropertyTypeOptionWeight'];
				$fieldOptionWeightAction = $row['ReservedPropertyTypeOptionWeightAction'];
				$fieldOptionPosition = $row['ReservedPropertyTypeOptionPosition'];
				
				$result['ReservedPropertyFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['ReservedPropertyFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['ReservedPropertyFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['ReservedPropertyFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['ReservedPropertyFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				$result['ReservedPropertyFieldTypes'][$fieldCode]['parts'] = $fieldParts;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					if($fieldMode=='option')
					{
						$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;

						//$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['price'] = $fieldOptionPrice;
						//$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['priceaction'] = $fieldOptionPriceAction;
						//$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['weight'] = $fieldOptionWeight;
						//$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$i]['weightaction'] = $fieldOptionWeightAction;

						$result['ReservedPropertyOption'][$fieldOptionID]['ReservedPropertyOptionPrice'] = $fieldOptionPrice;
						$result['ReservedPropertyOption'][$fieldOptionID]['ReservedPropertyOptionPriceAction'] = $fieldOptionPriceAction;
						$result['ReservedPropertyOption'][$fieldOptionID]['ReservedPropertyOptionWeight'] = $fieldOptionWeight;
						$result['ReservedPropertyOption'][$fieldOptionID]['ReservedPropertyOptionWeightAction'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		if(!empty($entityID))
		{
			$query = "SELECT * FROM ReservedPropertyField LEFT JOIN ReservedPropertyOption ON ReservedPropertyField.ReservedPropertyFieldID = ReservedPropertyOption.ReservedPropertyFieldID WHERE ReservedPropertyID='$entityID' $filter ORDER BY ReservedPropertyFieldPosition, ReservedPropertyOptionPosition"; 
			//$query = "SELECT * FROM ReservedPropertyField WHERE ReservedPropertyID='$entityID' $filter ORDER BY ReservedPropertyFieldPosition"; 
			$rs = $DS->query($query);
		}
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();

			foreach($rs as $row)
			{
				$fieldCode = $row['ReservedPropertyFieldAlias'];
				$fieldType = $row['ReservedPropertyFieldType'];
				
				$reservedPropertyFieldID = $row['ReservedPropertyFieldID'];
				$fieldOptionID = $row['ReservedPropertyOptionID'];
				
				$fieldTypeOptionID = $row['ReservedPropertyTypeOptionID'];
				
				$fieldOptionStatus = $row['ReservedPropertyOptionStatus'];
				$fieldOptionPrice = $row['ReservedPropertyOptionPrice'];
				$fieldOptionPriceAction = $row['ReservedPropertyOptionPriceAction'];
				$fieldOptionWeight = $row['ReservedPropertyOptionWeight'];
				$fieldOptionWeightAction = $row['ReservedPropertyOptionWeightAction'];
				
	
				if($row['ReservedPropertyFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['ReservedPropertyFieldValueTime'];
				}
				elseif($row['ReservedPropertyFieldValueNumber']>0)
				{
					$fieldValue = $row['ReservedPropertyFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['ReservedPropertyFieldValue'];
				}									
				
				if(!empty($result['ReservedPropertyFieldTypes'][$fieldCode]['code']))
				{
					$result['ReservedPropertyFieldTypes'][$fieldCode]['status'] = $row['ReservedPropertyFieldStatus'];
				}
				$result['ReservedPropertyField'][0][$fieldCode] = $fieldValue;
				
				$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyFieldID'] = $reservedPropertyFieldID;			
				
				if(!empty($fieldTypeOptionID))
				{
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionID'] = $fieldOptionID;
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionStatus'] = $fieldOptionStatus;	
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyTypeOptionID'] = $fieldTypeOptionID;		
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionPrice'] = $fieldOptionPrice;
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionPriceAction'] = $fieldOptionPriceAction;
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionWeight'] = $fieldOptionWeight;
					$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionWeightAction'] = $fieldOptionWeightAction;
					//$result['ReservedPropertyOption'][$fieldTypeOptionID]['ReservedPropertyOptionWeightAction'] = $fieldOptionWeightAction;
				}
				
				if($viewMode=='viewreservedProperty' && $result['ReservedPropertyFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
				{
					foreach($result['ReservedPropertyFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
					{
						if($fieldTypeOptionID==$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
						{
							if($fieldOptionStatus==2)
							{
								$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
								$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
							}
							else
							{
								$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value']='';
								foreach($languagesList['languageCodes'] as $langID=>$langCode) 
								{ 
									$result['ReservedPropertyFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] .= '<'.$langCode.'>'.$SERVER->getValue($redefinVieldValue['value'],$langCode).' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'].'</'.$langCode.'>';
								}
							}
						}
					}
				}						
				
			}		
		}
		//print_r($result['ReservedPropertyOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyFields.End','End');
		return $result;
	}	
	
	function getReservedPropertyFields($input)
	{
		$rs = $this->getReservedPropertyFieldsStructureAndValues($input);
		if(is_array($rs['ReservedPropertyFieldTypes']))
		{
			foreach($rs['ReservedPropertyFieldTypes'] as $ReservedPropertyFieldCode=>$ReservedPropertyFieldType)			
			{
				if(!empty($ReservedPropertyFieldType['code']))
				{
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['code']=$ReservedPropertyFieldType['code'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['name']=$ReservedPropertyFieldType['name'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['type']=$ReservedPropertyFieldType['type'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['mode']=$ReservedPropertyFieldType['mode'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['status']=$ReservedPropertyFieldType['status'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['places']=$ReservedPropertyFieldType['places'];
					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['parts']=$ReservedPropertyFieldType['parts'];


					$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['value']=$rs['ReservedPropertyField'][0][$ReservedPropertyFieldCode];
					if(is_array($ReservedPropertyFieldType['options'])) {
						foreach($ReservedPropertyFieldType['options'] as $id=>$reservedPropertyFieldOptions) { 
							$optionsTypeID = $reservedPropertyFieldOptions['id'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['id']=$reservedPropertyFieldOptions['id'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['value']=$reservedPropertyFieldOptions['value'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['position']=$reservedPropertyFieldOptions['position'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionID']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionID'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyFieldID']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyFieldID'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionStatus']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionStatus'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyTypeOptionID']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyTypeOptionID'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionPrice']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionPrice'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionPriceAction']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionPriceAction'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionWeight']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionWeight'];
							$result['ReservedPropertyField'][$ReservedPropertyFieldCode]['options'][$id]['ReservedPropertyOptionWeightAction']=$rs['ReservedPropertyOption'][$optionsTypeID]['ReservedPropertyOptionWeightAction'];
						}//end of foreach($ReservedPropertyFieldType['options'] as $id=>$reservedPropertyFieldOptions) 
					}//end of if(is_array($ReservedPropertyFieldType['options']))
				}//end of if(!empty($ReservedPropertyFieldType['code']) && !empty($rs['ReservedPropertyField'][0][$ReservedPropertyFieldCode]))
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
	function getReservedProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.getReservedProperty.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedProperty'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedProperty'.DTR.'ReservedPropertyAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " ReservedPropertyAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " ReservedPropertyID='$entityID' ";
			}
			$query = "SELECT * FROM ReservedProperty WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
	
			$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
			$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($result[0]['ReservedPropertyType']);
			$SERVER->setInputVar('ReservedPropertyTemplate',$reservedPropertyTemplate);
			$SERVER->setInputVar('ReservedPropertyType',$result[0]['ReservedPropertyType']);
		}		
		$SERVER->setDebug('ReservedPropertyClass.getReservedProperty.End','End');		
		return $result;		
	}

	function getReservedPropertyResource($input)
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
		$entityID = $input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyResourceID'];}
		//set queries
		$query ='';
		if(!empty($entityID))
		{
			$filter = " ReservedPropertyResourceID='$entityID' ";
			$query = "SELECT * FROM ReservedPropertyResource WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
		}		
		return $result;		
	}
	
	function getReservedPropertyField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyField'.DTR.'ReservedPropertyFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyFieldID'];}

		$entityAlias = $input['ReservedPropertyField'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyField'.DTR.'ReservedPropertyFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyField.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservedProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.setReservedProperty.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		if(empty($input['ReservedProperty'.DTR.'PermAll'])) {$input['ReservedProperty'.DTR.'PermAll']=4;}
		if(!empty($entityID)) $input['ReservedProperty'.DTR.'ReservedPropertyID'] = $entityID;
		
		if($config['ReservedPropertyValidationMode']=='N')
		{
			$input['ReservedProperty'.DTR.'PermAll']=1;
		}
		else
		{
			//if(!$SERVER->hasRights('admin')) {$input['ReservedProperty'.DTR.'PermAll']=4;}
		}
		
		if($SERVER->hasRights('admin') && $input['ReservedProperty'.DTR.'PermAll']==1 && empty($input['ReservedProperty'.DTR.'ReservedPropertyStatus'])) {$input['ReservedProperty'.DTR.'ReservedPropertyStatus']='active';}
					
		if(empty($input['ReservedProperty'.DTR.'ReservedPropertyStatus'])) {$input['ReservedProperty'.DTR.'ReservedPropertyStatus']='new';}
		if(empty($input['ReservedProperty'.DTR.'ReservedPropertyAuthor'])  && $clientType!='admin') {$input['ReservedProperty'.DTR.'ReservedPropertyAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['ReservedProperty'.DTR.'ReservedPropertyLink']) && $clientType!='admin') {$input['ReservedProperty'.DTR.'ReservedPropertyLink']=$user['UserLink'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries	
		//if(is_array($input['ReservedProperty'.DTR.'ReservedPropertyLanguages'])) {$input['ReservedProperty'.DTR.'ReservedPropertyLanguages'] = '|'. implode("|",$input['ReservedProperty'.DTR.'ReservedPropertyLanguages']).'|'; }
			
		//if(is_array($input['ReservedProperty'.DTR.'AccessGroups'])) {$input['ReservedProperty'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedProperty'.DTR.'AccessGroups']).'|'; }
		$where['ReservedProperty'] = "ReservedPropertyID = '".$entityID."'".$filter;
//		print_r($input);
		if(empty($input['ReservedProperty'.DTR.'ReservedPropertyAlias']) && !empty($input['ReservedProperty'.DTR.'ReservedPropertyTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservedPropertyTitle = $input['ReservedProperty'.DTR.'ReservedPropertyTitle']['en'];
			if(empty($langReservedPropertyTitle)) { $lang = $config['lang']; $langReservedPropertyTitle = $input['ReservedProperty'.DTR.'ReservedPropertyTitle'][$lang];}
			$input['ReservedProperty'.DTR.'ReservedPropertyAlias'] = $typeObject->setDataType($langReservedPropertyTitle);
		}	
		
		/*if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyAlias']))
		{
			$checkRS=$DS->query("SELECT ReservedPropertyAlias FROM ReservedProperty WHERE ReservedPropertyAlias='".$input['ReservedProperty'.DTR.'ReservedPropertyAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservedProperty'.DTR.'ReservedPropertyAlias'] = $input['ReservedProperty'.DTR.'ReservedPropertyAlias'].date('Ymd-His');
				$SERVER->setMessage('reservedProperty.ReservedPropertyClass.setReservedProperty.err.DuplicatedReservedProperty');
			}				
		}*/
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll, ReservedPropertyStatus FROM ReservedProperty WHERE ReservedPropertyID='".$entityID."'");
		}		
		if(!$SERVER->hasRights('admin') && $oldRS[0]['PermAll']=='4') {$input['ReservedProperty'.DTR.'PermAll']=4;}
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyLocation']))
		{
			$input['ReservedProperty'.DTR.'ReservedPropertyLocation'] = str_replace("-","vvv",$input['ReservedProperty'.DTR.'ReservedPropertyLocation']);
		}
		$input['ReservedProperty'.DTR.'ReservedPropertyPrice'] = str_replace(",","",$input['ReservedProperty'.DTR.'ReservedPropertyPrice']);
		$input['ReservedProperty'.DTR.'ReservedPropertyMaxPrice'] = str_replace(",","",$input['ReservedProperty'.DTR.'ReservedPropertyMaxPrice']);
		
		//set visibility mode status	
		
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyTitle']))
		{		
			if(empty($input['ReservedProperty'.DTR.'ReservedPropertyID']))
			{
				$maxRS = $DS->query("SELECT MAX(ReservedPropertyIndex) AS MaxIndex FROM ReservedProperty");
				$input['ReservedProperty'.DTR.'ReservedPropertyIndex'] = $maxRS[0]['MaxIndex'] + 1;
				$input['ReservedProperty'.DTR.'ReservedPropertyPaidRate'] = 800;
				$endTime = time() + 60*60*24*90;
				$input['ReservedProperty'.DTR.'TimeEnd'] = date('Y-m-d H:i:s',$endTime);
				
				$emailIN['MailTo'] = $config['SiteMail'];
				$emailIN['MailToName'] = 'Admin';
				$emailIN['MailFrom'] ='reminder.'.$config['SiteMail'];
				$emailIN['MailFromName'] =$user['UserName'];
				$emailIN['MailTemplate'] = 'newReservedPropertyRemind';
				//print_r($emailIN);
				$SERVER->callService('sendMail','mailServer',$emailIN);				
			}
			$input['actionMode']='save';
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ReservedPropertyID'];			
			$input['ReservedProperty'.DTR.'ReservedPropertyID'] = $entityID;
			if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyID']))	
			{
				$this->setReservedPropertyField($input,$uploadRS);	
			}				
			$this->updateSerializedReservedPropertyFields($entityID,$input['ReservedProperty'.DTR.'ReservedPropertyType']);
		}
		else
		{
			if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyAlias']))
			{
				$SERVER->setMessage('ReservedPropertyClass.setReservedProperty.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservedPropertyClass.setReservedProperty.msg.DataSaved');
		}
		//if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ReservedProperty');
		//}
		$SERVER->setDebug('ReservedPropertyClass.setReservedProperty.End','End');		
		return $result;		
	}
	
	function setReservedPropertyResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.setReservedPropertyResource.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		if(empty($input['ReservedProperty'.DTR.'PermAll'])) {$input['ReservedProperty'.DTR.'PermAll']=4;}

		$where['ReservedPropertyResource'] = "ReservedPropertyResourceID = '".$input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']."'".$filter;
		
		$input['ReservedPropertyResource'.DTR.'ReservedPropertyID'] = $entityID;
		$input['actionMode']='save';
		$lang = $config['lang'];
		if(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceType']) && !empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyID']) && (!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceIcon']) || !empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceName'][$lang]) || $input['ReservedPropertyResource'.DTR.'ReservedPropertyResourcePosition']>1))
		{
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ReservedPropertyResourceID'];
			$this->updateReservedPropertyResourcePositions($entityID);
		}
		$SERVER->setDebug('ReservedPropertyClass.setReservedPropertyResource.End','End');
		return $result;
	}
	
	function setReservedPropertyResourcePosition($input)
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
		$entityID = $input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID'];
		if(!empty($entityID))
		{
			$DS->query("UPDATE ReservedPropertyResource SET ReservedPropertyResourcePosition='".$input['ReservedPropertyResource'.DTR.'ReservedPropertyResourcePosition']."' WHERE ReservedPropertyResourceID='$entityID'");
			$this->updateReservedPropertyResourcePositions($entityID);
		}
	}
		
	function deleteReservedPropertyResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedPropertyResource.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservedPropertyResource WHERE ReservedPropertyResourceID='$entityID'");
		}
		//$SERVER->setMessage('ReservedPropertyClass.deleteReservedProperty.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedPropertyResource.End','End');		
		return $result;		
	}
	
	function getReservedPropertyResourcies($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyResourcies.Start','Start');
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
		
		$reservedPropertyType = $input['ReservedPropertyType'];
		$reservedPropertyFeaturedOption = $input['ReservedPropertyFeaturedOption'];
		$permAll = $input['PermAll'];
		$reservedPropertyStatus = $input['ReservedPropertyStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}	
		//set filters
		if(!empty($permAll))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if(!empty($entityID))
		{
			$filter .= " AND ReservedPropertyID='$entityID' ";
		}
		//set queries
		if(is_array($input['DB']['Reference'])){
			foreach($input['DB']['Reference'] as $value){
				$query = "SELECT * FROM ReservedPropertyResource WHERE ReservedPropertyResourceID>0 $filter AND ReservedPropertyResourceType = '".$value['OptionCode']."' ORDER BY ReservedPropertyResourcePosition ";
				$rs = $DS->query($query); 
				if(count($rs)>0)
				{
					$result[$value['OptionCode']] = $rs;
				}
			}
		}		
		//get the content
		//echo $query;
		
		$SERVER->setDebug('ReservedPropertyClass.getReservedPropertyResourcies.End','End');
		return $result;
	}
	
	
	function updateSerializedReservedPropertyFields($reservedPropertyID,$reservedPropertyType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($reservedPropertyID))
		{
			$input['ReservedPropertyID'] = $reservedPropertyID;
			$input['ReservedPropertyType'] = $reservedPropertyType;
			$rs = $this->getReservedPropertyFields($input);
			$reservedPropertyFields = serialize($rs);
			$reservedPropertyFields = $SERVER->cleanString($reservedPropertyFields,'noquotes');
			$DS->query("UPDATE ReservedProperty SET ReservedPropertyFields = '$reservedPropertyFields' WHERE ReservedPropertyID='$reservedPropertyID'");
		}
	}

	function setReservedPropertyField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyFieldClass.setReservedPropertyField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}	
			
		$entityType = $input['ReservedPropertyType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['ReservedProperty'.DTR.'ReservedPropertyType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyFieldServer.adminReservedPropertyField');
		//set queries	
		if(!empty($entityID))
		{
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('ReservedPropertyField'.DTR,$fieldName))
				{
					//process reservedPropertyfield saving
					$fieldCode = str_replace('ReservedPropertyField'.DTR,'',$fieldName);
					//get the field type
					//$entityType
					
					$fieldInfoRS = $DS->query("SELECT ReservedPropertyTypeFieldID, ReservedPropertyTypeFieldType, ReservedPropertyTypeFieldPosition, ReservedPropertyTypeFieldName, ReservedPropertyTypeFieldAlias, ReservedPropertyTypeFieldMode, ReservedPropertyTypeFieldMode FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldAlias = '$fieldCode' AND (ReservedPropertyType='$entityType' OR  ReservedPropertyType='main') ");
					$fieldType = $fieldInfoRS[0]['ReservedPropertyTypeFieldType'];
					$fieldTypeID = $fieldInfoRS[0]['ReservedPropertyTypeFieldID'];
					$fieldTypePosition = $fieldInfoRS[0]['ReservedPropertyTypeFieldPosition'];
					$fieldTypeMode = $fieldInfoRS[0]['ReservedPropertyTypeFieldMode'];
					$fieldTypeName = $fieldInfoRS[0]['ReservedPropertyTypeFieldName'];
					$fieldTypeMode = $fieldInfoRS[0]['ReservedPropertyTypeFieldMode'];
	
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
					$checkRS = $DS->query("SELECT ReservedPropertyFieldID FROM ReservedPropertyField WHERE ReservedPropertyID='$entityID' AND ReservedPropertyFieldAlias='$fieldCode'");
					$reservedPropertyFieldID = $checkRS[0]['ReservedPropertyFieldID'];
	
					if($fieldType=='number' || $fieldType=='money')
					{
						$valueFieldName = 'ReservedPropertyFieldValueNumber';
					}
					elseif($fieldType=='time' || $fieldType=='date')
					{
						$valueFieldName = 'ReservedPropertyFieldValueTime';
					}
					else
					{
						$valueFieldName = 'ReservedPropertyFieldValue';
					}
	
					if($fieldVale=='image' || $fieldVale=='file')
					{
						if(!empty($uploadRS[$fieldCode]['file']))
						{
							$fieldVale= $uploadRS[$fieldCode]['file'];
						}		
						else
						{
							$fileFieldRS = $DS->query("SELECT ReservedPropertyFieldValue FROM ReservedPropertyField WHERE ReservedPropertyFieldID='$reservedPropertyFieldID'");
							$fieldVale=$fileFieldRS[0][$valueFieldName];
						}				
					}
					
					if($fieldVale=='deletefieldfile')
					{
						if(!empty($reservedPropertyFieldID))
						{
							$FM = new FilesManager();
							//$fileField =$input['fileField'];
							$fileFieldRS = $DS->query("SELECT ReservedPropertyFieldValue FROM ReservedPropertyField WHERE ReservedPropertyFieldID='$reservedPropertyFieldID'");
							$SERVER->setInputVar('actionMode','deletefile');
							$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
							$fieldVale='';
							$input['ReservedPropertyFieldStatus'][$fieldCode] = 1;
						}
					}				
					
					if($input['ReservedPropertyFieldStatus'][$fieldCode]!=1)
					{
						$fieldStatus = 2;
					}
					else
					{
						$fieldStatus = 1;
					}
					//echo 'ReservedPropertyFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';
	
					if(!empty($reservedPropertyFieldID))
					{
						//udpate
						$query = "UPDATE ReservedPropertyField SET ReservedPropertyID='$entityID',ReservedPropertyFieldAlias='$fieldCode', ReservedPropertyTypeFieldID='$fieldTypeID',ReservedPropertyFieldType='$fieldType',ReservedPropertyFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', ReservedPropertyFieldStatus='$fieldStatus' WHERE ReservedPropertyFieldID='$reservedPropertyFieldID'";
					}
					else
					{
						//insert
						$ReservedPropertyFieldID = $SERVER->getUniqueID();	
						$query = "INSERT INTO ReservedPropertyField (ReservedPropertyFieldID,ReservedPropertyID,ReservedPropertyFieldAlias,ReservedPropertyTypeFieldID,ReservedPropertyFieldType,ReservedPropertyFieldPosition,$valueFieldName,ReservedPropertyFieldStatus) VALUES ('$ReservedPropertyFieldID','$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
					}
					
					//echo $query.'<br>';
					$DS->query($query);
					if(empty($reservedPropertyFieldID))
					{
						$reservedPropertyFieldID = $DS->dbLastID();	
					}
					
					if(is_array($input['ReservedPropertyOptionFieldCode']) && $fieldTypeMode=='option')
					{
						foreach($input['ReservedPropertyOptionFieldCode'] as $i=>$reservedPropertyOptionFieldCode)
						{
							if($reservedPropertyOptionFieldCode==$fieldCode)
							{
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyTypeOptionID'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyTypeOptionID'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyFieldID'] = $reservedPropertyFieldID;
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionID'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionID'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPosition'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPosition'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPrice'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPrice'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPriceAction'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionPriceAction'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionWeight'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionWeight'][$i];
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionWeightAction'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionWeightAction'][$i];
								
								$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus'] = $input['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus'][$i];
								
								if($inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus']!=1)
								{
									$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus']=2;
								}
								else
								{
									$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus']=1;
								}
								//echo 'status='.$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionStatus'];
								$inputSave['actionMode']='save';
			
								$where['ReservedPropertyOption'] = "ReservedPropertyOptionID = '".$inputSave['ReservedPropertyOption'.DTR.'ReservedPropertyOptionID']."'";
								$DS->save($inputSave,$where);	
							}
						}
					}				
				}
			}
		}
		//if(!empty($input['ReservedPropertyField'.DTR.'ReservedPropertyFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ReservedPropertyField',$input['ReservedPropertyField'.DTR.'ReservedPropertyID'],'ReservedProperty');
		//}		
		$SERVER->setDebug('ReservedPropertyFieldClass.setReservedPropertyField.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservedProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedProperty.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ReservedPropertyFieldID FROM ReservedPropertyField WHERE ReservedPropertyID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ReservedPropertyFieldID'];
			$DS->query("DELETE FROM ReservedProperty WHERE ReservedPropertyID='$entityID'");
			$DS->query("DELETE FROM ReservedPropertyField WHERE ReservedPropertyID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ReservedPropertyOption WHERE ReservedPropertyFieldID='$typeFieldID'");
			}
		}
		//$SERVER->setMessage('ReservedPropertyClass.deleteReservedProperty.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedProperty.End','End');		
		return $result;		
	}	
	
	function deleteReservedPropertyField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedPropertyField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyField'.DTR.'ReservedPropertyFieldID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyServer.adminReservedProperty');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ReservedPropertyField WHERE ReservedPropertyID='$entityID'");
			$DS->query("DELETE FROM ReservedPropertyOption WHERE ReservedPropertyFieldID='$entityID'");
		}
		$SERVER->setMessage('ReservedPropertyClass.deleteReservedPropertyField.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyClass.deleteReservedPropertyField.End','End');		
		return $result;		
	}	
	
	function copyReservedProperty($input)
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
		$ReservedPropertyTemplateID = $input['selectedReservedPropertyID'];
		$ReservedPropertyID = $input['ReservedPropertyID'];
		if($ReservedPropertyID==$ReservedPropertyTemplateID) {return false;}
		//set client side variables
		if(!empty($ReservedPropertyTemplateID) && !empty($ReservedPropertyID))
		{
			//make ReservedProperty link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ReservedPropertyField WHERE ReservedPropertyID='$ReservedPropertyTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ReservedPropertyField'] = "ReservedPropertyFieldID = ''";
			$inputNew['ReservedPropertyField'.DTR.'ReservedPropertyFieldID']='';
			$inputNew['ReservedPropertyField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ReservedPropertyField'.DTR.'UserID']=$userID;
			$inputNew['ReservedPropertyField'.DTR.'ReservedPropertyID']=$ReservedPropertyID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ReservedPropertyField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ReservedPropertyField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ReservedPropertyField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ReservedPropertyField WHERE BoxID='".$inputNew['ReservedPropertyField'.DTR.'BoxID']."' AND ReservedPropertyID='".$ReservedPropertyID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new ReservedProperty
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
	
	function updateReservedPropertyResourcePositions($entityID)
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
		$query = "SELECT ReservedPropertyResourceType, ReservedPropertyID FROM ReservedPropertyResource WHERE ReservedPropertyResourceID='$entityID'";
		$rsInfo = $DS->query($query);
		$query = "SELECT ReservedPropertyResourceID, ReservedPropertyResourcePosition FROM ReservedPropertyResource WHERE ReservedPropertyResourceType='".$rsInfo[0]['ReservedPropertyResourceType']."' AND ReservedPropertyID='".$rsInfo[0]['ReservedPropertyID']."' ORDER BY ReservedPropertyResourcePosition ASC";
		$rs = $DS->query($query);
		$i=2;
		foreach($rs as $row)
		{
			$DS->query("UPDATE ReservedPropertyResource SET ReservedPropertyResourcePosition='$i' WHERE ReservedPropertyResourceID='".$row['ReservedPropertyResourceID']."'");
			//echo "UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'<br>";
			$i = $i+2;
		}
		//return $result;		
	}			
	
	
	function buyReservedProperty($input)
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
		$entityID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyID'];}		
		
		if(empty($entityID)) return false;
		
		$rs = $DS->query("SELECT * FROM ReservedProperty WHERE ReservedPropertyID='$entityID'");
		
		$price = $rs[0]['ReservedPropertyPrice'];
		if(empty($price)) {$price = $rs[0]['ReservedPropertyMaxPrice'];}
		$inBilling = $input;
		//$inBilling['PriceRange']=$price;
		//$inBilling['ServiceCategory']='offers-rates';

					
		
		$inBilling['ServiceID']=$input['ServiceID'];
		$inBilling['actionMode']='buyService';
		$inBilling['TransactionCreator']=$entityID;
		$inBilling['BillingOrder'.DTR.'OrderReturnURL'] = $input['BillingOrder'.DTR.'OrderReturnURL'].'ServiceID/'.$inBilling['ServiceID'].'/';
		$SERVER->setInputVar('BillingOrder'.DTR.'OrderReturnURL',$inBilling['BillingOrder'.DTR.'OrderReturnURL']);
		$SERVER->setInputVar('BillingOrder'.DTR.'OrderCreatorID',$entityID);
		//$inBilling['BillingOrder'.DTR.'OrderCreatorID'] = $entityID;
		//print_r($inBilling);
		
		$serviceRS = $SERVER->callService('manageServices','billingServer',$inBilling);

		$serviceAlias = $serviceRS['DB']['Service'][0]['ServiceAlias'];
		if(eregi('reservedProperty-basic',$serviceAlias))
		{
			$paidRate = 500;
		}
		elseif(eregi('reservedProperty-gold',$serviceAlias))
		{
			$paidRate = 1000;
		}	
		elseif(eregi('reservedProperty-platinum',$serviceAlias))
		{
			$paidRate = 1500;
		}			
		//$query = "UPDATE ReservedProperty SET ReservedPropertyPaymentStatus='notpaid', ReservedPropertyPaidRate='$paidRate' WHERE ReservedPropertyID='$entityID' ";
		//echo $query;
		//die('tttt');
		//$DS->query($query);

		$paymentResult = $SERVER->callService('doBillingPayment','billingServer',$inBilling);			

		if($paymentResult['PaymentResult']=='OK')
		{
			$endTime = $paymentResult['PaymentTimeEnd'];
			$now = $SERVER->getNow();
			$paymentStatus = $paymentResult['PaymentStatus'];
			if(empty($paymentStatus)) {$paymentStatus ='paid';}
			if(!empty($entityID))
			{
				$query = "UPDATE ReservedProperty SET ReservedPropertyPaidRate='$paidRate', ReservedPropertyPaymentStatus='$paymentStatus', ReservedPropertyPaymentTime='$now', TimeEnd='$endTime' WHERE ReservedPropertyID='$entityID' ";
				$DS->query($query);
			}
		}
		return $paymentResult;		
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
		$reservedPropertyID= $input['ReservedPropertyID'];
		if(empty($reservedPropertyID)) {$reservedPropertyID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyBidServer.adminReservedPropertyBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if($viewMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		else
		{
			if($SERVER->hasRights('admin'))
			{
				$filter .= " AND ReservedPropertyID='$reservedPropertyID' ";
			}
			else
			{
				$filter .= " AND UserID='$userID' AND ReservedPropertyID='$reservedPropertyID' ";
			}
			
		}
		//set queries
		$query = "SELECT * FROM ReservedPropertyBid WHERE ReservedPropertyBidID>0 $filter  ORDER BY ReservedPropertyBidID";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		//print_r($rs);
		return $result;
	}

} // end of ReservedPropertyServer
?>