<?php
//XCMSPro: Web Service entity class
class DomainClass
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
	function DomainClass()
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
	function getDomains($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.getDomains.Start','Start');
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
		
		$DomainType = $input['DomainType'];
		$DomainLookForType = $input['DomainLookForType'];
		$DomainAge = $input['DomainAge'];
		$DomainFeaturedOption = $input['DomainFeaturedOption'];
		$permAll = $input['PermAll'];
		$DomainStatus = $input['DomainStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		if(!empty($locationAlias))
		{
			$locationIDRS = $DS->query("SELECT RegionID FROM Region WHERE RegionCode='$locationAlias'");
			$locationID = $locationIDRS[0]['RegionID'];
		}		
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		if(!empty($locationID))
		{
			$filter .= " AND DomainLocationID = '$locationID' ";
		}		
		if(!empty($DomainType))
		{
			$filter .= " AND DomainType='$DomainType' ";
		}
		if(!empty($DomainAge))//DomainAge
		{
			$filter .= " AND (DomainDateOfBirth<(NOW() - INTERVAL $DomainAge YEAR)) ";
		}	
		if(!empty($DomainLookForType))
		{
			$filter .= " AND DomainLookForType='$DomainLookForType' ";
		
		}
		if(!empty($DomainStatus))
		{
			$filter .= " AND DomainStatus='$DomainStatus' ";
		}			
		if(!empty($DomainFeaturedOption))
		{
			$filter .= " AND DomainFeaturedOptions LIKE '%|$DomainFeaturedOption|%' ";
		}	
		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		/*if(!empty($searchWord))
		{
			$filter .= " AND (DomainTitle LIKE '%$searchWord%' OR DomainLink LIKE '%$searchWord%' OR DomainReciprocalLink LIKE '%$searchWord%' OR DomainIntro LIKE '%$searchWord%' OR DomainContent LIKE '%$searchWord%' OR DomainKeywords LIKE '%$searchWord%' OR DomainAuthor LIKE '%$searchWord%' OR DomainLocation LIKE '%$searchWord%')  ";
		}*/
		if(!empty($searchWord))
		{
			$filter .= " AND (DomainName LIKE '%$searchWord%' OR DomainLink LIKE '%$searchWord%' OR DomainIntro LIKE '%$searchWord%' OR DomainContent LIKE '%$searchWord%' OR DomainKeywords LIKE '%$searchWord%' OR DomainLocation LIKE '%$searchWord%')  ";
		}	
		if(!empty($featuredMode))
		{
			$filter .= " AND DomainFeaturedOptions LIKE '%|$featuredMode|%' ";
		}		
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND PermAll='1' ";
			$filter .= " AND DomainStatus='active' ";
		}
		
		if($filterMode=='home')
		{
			$filter .= " AND DomainFeaturedOptions LIKE '%|$filterMode|%' ";
		}
		
		if(($userID!='admin' && $userID!='root') && ($TimeEndMode!='all'))
		{
			$filter .= "  AND (TimeEnd>'".date('Y-m-d H:m:s')."' OR TimeEnd='0000-00-00 00:00:00')";
		}	
		//echo 'manageMode='.$manageMode;
		if($ownerMode!='all')
		{
			$filter .= " AND OwnerID='$ownerID' ";
		}
		//search in Domain field
	
		$fieldsFilter = $this->getDomainFieldSearchFilter($input);
		
		if(empty($limit))
		{
			if(!empty($fieldsFilter))
			{		
				$pages = $DS->getPages(' Domain LEFT JOIN DomainField ON Domain.DomainID = DomainField.DomainID',"Domain.DomainID>0 $filter $fieldsFilter ",array('ItemsPerPage'=>$itemsPerPage));
			}
			else
			{
				$pages = $DS->getPages('Domain',"DomainID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			}
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		if(!empty($fieldsFilter))
		{
			//$query = "SELECT * FROM DomainTypeField LEFT JOIN DomainTypeOption ON DomainTypeField.DomainTypeFieldID = DomainTypeOption.DomainTypeFieldID WHERE DomainTypeField.DomainType = '$entityType' $filter ORDER BY DomainTypeFieldPosition, DomainTypeOptionPosition"; 
			$query = "SELECT *,Domain.DomainID AS DomainID FROM Domain LEFT JOIN DomainField ON Domain.DomainID = DomainField.DomainID  WHERE Domain.DomainID>0 $filter $fieldsFilter ORDER BY DomainID, TimeCreated $limit";
		}
		else
		{
			$query = "SELECT * FROM Domain 
					  WHERE DomainID>0 $filter ORDER BY  DomainName $limit";
			
		}
		//get the content
		$result['result'] = $DS->query($query); 
		//print_r($result['result']);
		$result['pages'] = $pages['pages'];
		$SERVER->setDebug('DomainClass.getDomains.End','End');
		return $result;
	}	
	
	function getDomainFieldSearchFilter($input)
	{
		$DS = &$this->_DS;
		$fieldsFilter = '';
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('DomainSearchField'.DTR,$fieldName))
			{
				//process Domainfield saving
				$fieldCode = str_replace('DomainSearchField'.DTR,'',$fieldName);
				//getDomain filed info 
				if(!empty($fieldCode) && !empty($fieldVale))
				{
					$DomainTypeInfoRS = $DS->query("SELECT DomainFieldType FROM DomainField WHERE DomainFieldAlias='$fieldCode' ");
					$fieldType = $DomainTypeInfoRS[0]['DomainFieldType'];
					if($fieldType == 'dropdown')
					{
						$fieldsFilter .= " AND (DomainFieldAlias='$fieldCode' AND DomainFieldValue = '$fieldVale' )";
					}
				}
			}
		}			
		
		return $fieldsFilter;
	}
	
	function getActiveDomainsFilter()
	{
		
	}
	
	function getDomainFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.getDomainFields.Start','Start');
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
		if(empty($entityType)) {$entityType = $input['DomainType'];}
		
		$entityID = $input['Domain'.DTR.'DomainID'];
		if(empty($entityID)) {$entityID = $input['DomainID'];}
		
		$entityAlias = $input['Domain'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Domain'.DTR.'DomainAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$DomainIDRS = $DS->query("SELECT DomainID FROM Domain WHERE DomainAlias='$entityAlias'");
			$entityID = $DomainIDRS[0]['DomainID'];
		}
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//$filter .= "OwnerID='$ownerID' ";
		
		
		$DomainTypeIDRS = $DS->query("SELECT DomainTypeID FROM DomainType WHERE DomainTypeAlias='$entityType'");
		$DomainTypeID = $DomainTypeIDRS[0]['DomainTypeID'];
		$query = "SELECT * FROM DomainTypeField LEFT JOIN DomainTypeOption ON DomainTypeField.DomainTypeFieldID = DomainTypeOption.DomainTypeFieldID WHERE (DomainTypeField.DomainType = '$entityType' OR DomainTypeField.DomainType = 'main') $filter ORDER BY DomainTypeFieldPosition, DomainTypeOptionPosition"; 
		//$query = "SELECT * FROM (DomainField LEFT JOIN DomainTypeField ON DomainField.DomainTypeFieldID = DomainTypeField.DomainTypeFieldID) LEFT JOIN DomainTypeOption ON DomainTypeField.DomainTypeFieldID = DomainTypeOption.DomainTypeFieldID WHERE DomainTypeField.DomainType = '$entityType' AND DomainID='$entityID' $filter ORDER BY DomainTypeFieldPosition, DomainTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['DomainTypeFieldAlias'];
				$fieldName = $row['DomainTypeFieldName'];
				$fieldType = $row['DomainTypeFieldType'];
				$fieldMode = $row['DomainTypeFieldMode'];
				$fieldPlaces = $row['DomainTypeFieldHidenPlaces'];
				$fieldOptionID = $row['DomainTypeOptionID'];
				$fieldOptionAlias = $row['DomainTypeOptionAlias'];
				$fieldOptionValue = $row['DomainTypeOptionName'];
				
				$fieldOptionPrice = $row['DomainTypeOptionPrice'];
				$fieldOptionPriceAction = $row['DomainTypeOptionPriceAction'];
				$fieldOptionWeight = $row['DomainTypeOptionWeight'];
				$fieldOptionWeightAction = $row['DomainTypeOptionWeightAction'];
				$fieldOptionPosition = $row['DomainTypeOptionPosition'];
				
				$result['DomainFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['DomainFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['DomainFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['DomainFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['DomainFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['DomainFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['DomainFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['DomainFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['DomainFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					if($fieldMode=='option')
					{
						$result['DomainFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;
						//$result['DomainFieldTypes'][$fieldCode]['options'][$i]['price'] = $fieldOptionPrice;
						//$result['DomainFieldTypes'][$fieldCode]['options'][$i]['priceaction'] = $fieldOptionPriceAction;
						//$result['DomainFieldTypes'][$fieldCode]['options'][$i]['weight'] = $fieldOptionWeight;
						//$result['DomainFieldTypes'][$fieldCode]['options'][$i]['weightaction'] = $fieldOptionWeightAction;

						$result['DomainOption'][$fieldOptionID]['DomainOptionPrice'] = $fieldOptionPrice;
						$result['DomainOption'][$fieldOptionID]['DomainOptionPriceAction'] = $fieldOptionPriceAction;
						$result['DomainOption'][$fieldOptionID]['DomainOptionWeight'] = $fieldOptionWeight;
						$result['DomainOption'][$fieldOptionID]['DomainOptionWeightAction'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		if(!empty($entityID))
		{
			$query = "SELECT * FROM DomainField LEFT JOIN DomainOption ON DomainField.DomainFieldID = DomainOption.DomainFieldID WHERE DomainID='$entityID' $filter ORDER BY DomainFieldPosition, DomainOptionPosition"; 
			//$query = "SELECT * FROM DomainField WHERE DomainID='$entityID' $filter ORDER BY DomainFieldPosition"; 
			$rs = $DS->query($query);
		}
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();

			foreach($rs as $row)
			{
				$fieldCode = $row['DomainFieldAlias'];
				$fieldType = $row['DomainFieldType'];
				
				$DomainFieldID = $row['DomainFieldID'];
				$fieldOptionID = $row['DomainOptionID'];
				
				$fieldTypeOptionID = $row['DomainTypeOptionID'];
				
				$fieldOptionStatus = $row['DomainOptionStatus'];
				$fieldOptionPrice = $row['DomainOptionPrice'];
				$fieldOptionPriceAction = $row['DomainOptionPriceAction'];
				$fieldOptionWeight = $row['DomainOptionWeight'];
				$fieldOptionWeightAction = $row['DomainOptionWeightAction'];
				
	
				if($row['DomainFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['DomainFieldValueTime'];
				}
				elseif($row['DomainFieldValueNumber']>0)
				{
					$fieldValue = $row['DomainFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['DomainFieldValue'];
				}									
				
				if(!empty($result['DomainFieldTypes'][$fieldCode]['code']))
				{
					$result['DomainFieldTypes'][$fieldCode]['status'] = $row['DomainFieldStatus'];
				}
				$result['DomainField'][0][$fieldCode] = $fieldValue;
				
				$result['DomainOption'][$fieldTypeOptionID]['DomainFieldID'] = $DomainFieldID;			
				
				if(!empty($fieldTypeOptionID))
				{
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionID'] = $fieldOptionID;
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionStatus'] = $fieldOptionStatus;	
					$result['DomainOption'][$fieldTypeOptionID]['DomainTypeOptionID'] = $fieldTypeOptionID;		
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionPrice'] = $fieldOptionPrice;
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionPriceAction'] = $fieldOptionPriceAction;
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionWeight'] = $fieldOptionWeight;
					$result['DomainOption'][$fieldTypeOptionID]['DomainOptionWeightAction'] = $fieldOptionWeightAction;
					//$result['DomainOption'][$fieldTypeOptionID]['DomainOptionWeightAction'] = $fieldOptionWeightAction;
				}
				
				if($viewMode=='viewDomain' && $result['DomainFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
				{
					foreach($result['DomainFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
					{
						if($fieldTypeOptionID==$result['DomainFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
						{
							if($fieldOptionStatus==2)
							{
								$result['DomainFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
								$result['DomainFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
							}
							else
							{
								$result['DomainFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value']='';
								foreach($languagesList['languageCodes'] as $langID=>$langCode) 
								{ 
									$result['DomainFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] .= '<'.$langCode.'>'.$SERVER->getValue($redefinVieldValue['value'],$langCode).' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'].'</'.$langCode.'>';
								}
							}
						}
					}
				}						
				
			}		
		}
		//print_r($result['DomainOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('DomainClass.getDomainFields.End','End');
		return $result;
	}	
	
	function getDomainFields($input)
	{
		$rs = $this->getDomainFieldsStructureAndValues($input);
		if(is_array($rs['DomainFieldTypes']))
		{
			foreach($rs['DomainFieldTypes'] as $DomainFieldCode=>$DomainFieldType)			
			{
				if(!empty($DomainFieldType['code']))
				{
					$result['DomainField'][$DomainFieldCode]['code']=$DomainFieldType['code'];
					$result['DomainField'][$DomainFieldCode]['name']=$DomainFieldType['name'];
					$result['DomainField'][$DomainFieldCode]['type']=$DomainFieldType['type'];
					$result['DomainField'][$DomainFieldCode]['mode']=$DomainFieldType['mode'];
					$result['DomainField'][$DomainFieldCode]['status']=$DomainFieldType['status'];
					$result['DomainField'][$DomainFieldCode]['places']=$DomainFieldType['places'];
					
					$result['DomainField'][$DomainFieldCode]['value']=$rs['DomainField'][0][$DomainFieldCode];
					if(is_array($DomainFieldType['options'])) {
						foreach($DomainFieldType['options'] as $id=>$DomainFieldOptions) { 
							$optionsTypeID = $DomainFieldOptions['id'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['id']=$DomainFieldOptions['id'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['value']=$DomainFieldOptions['value'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['position']=$DomainFieldOptions['position'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionID']=$rs['DomainOption'][$optionsTypeID]['DomainOptionID'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainFieldID']=$rs['DomainOption'][$optionsTypeID]['DomainFieldID'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionStatus']=$rs['DomainOption'][$optionsTypeID]['DomainOptionStatus'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainTypeOptionID']=$rs['DomainOption'][$optionsTypeID]['DomainTypeOptionID'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionPrice']=$rs['DomainOption'][$optionsTypeID]['DomainOptionPrice'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionPriceAction']=$rs['DomainOption'][$optionsTypeID]['DomainOptionPriceAction'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionWeight']=$rs['DomainOption'][$optionsTypeID]['DomainOptionWeight'];
							$result['DomainField'][$DomainFieldCode]['options'][$id]['DomainOptionWeightAction']=$rs['DomainOption'][$optionsTypeID]['DomainOptionWeightAction'];
						}//end of foreach($DomainFieldType['options'] as $id=>$DomainFieldOptions) 
					}//end of if(is_array($DomainFieldType['options']))
				}//end of if(!empty($DomainFieldType['code']) && !empty($rs['DomainField'][0][$DomainFieldCode]))
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
	function getDomain($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.getDomain.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$filterMode = $input['filterMode'];		
		//set client side variables
		$entityID = $input['DomainID'];
		if(empty($entityID)) {$entityID = $input['Domain'.DTR.'DomainID'];}
		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Domain'];}
		if(empty($entityAlias)) {$entityAlias = $input['DomainAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Domain'.DTR.'DomainAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries
		
		$query ='';
		if(!empty($entityID) || !empty($entityAlias) || $filterMode == 'user')
		{
			if(!empty($entityAlias))
			{
				$filter = " AND DomainAlias='$entityAlias' "; 
			}
			
			if(!empty($entityID))
			{
				$filter = " AND DomainID='$entityID' ";
			}
			if($filterMode == 'user')
			{
				$filter .= " AND UserID='$userID' ";
			}
			$query = "SELECT * FROM Domain WHERE DomainID>0 $filter"; 
			//get the content
			$result = $DS->query($query);	
			
			$DomainTypeObject = new DomainTypeClass();
			$DomainTemplate = $DomainTypeObject->getDomainTemplate($result[0]['DomainType']);
			$SERVER->setInputVar('DomainTemplate',$DomainTemplate);
			$SERVER->setInputVar('DomainType',$sectionRS[0]['DomainType']);
		}		
		$SERVER->setDebug('DomainClass.getDomain.End','End');		
		return $result;		
	}
	
	function getDomainField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.getDomainField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['DomainField'.DTR.'DomainFieldID'];
		if(empty($entityID)) {$entityID = $input['DomainFieldID'];}

		$entityAlias = $input['DomainField'];
		if(empty($entityAlias)) {$entityAlias = $input['DomainFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['DomainField'.DTR.'DomainFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " DomainFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " DomainFieldID='$entityID' ";
		}
		$query = "SELECT * FROM DomainField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('DomainClass.getDomainField.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setDomain($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.setDomain.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Domain'.DTR.'DomainID'];
		if(empty($entityID)) {$entityID = $input['DomainID'];}		
		if(empty($input['Domain'.DTR.'PermAll'])) {$input['Domain'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['Domain'.DTR.'PermAll']=4;}
		if($SERVER->hasRights('admin') && $input['Domain'.DTR.'PermAll']==1 && empty($input['Domain'.DTR.'DomainStatus'])) {$input['Domain'.DTR.'DomainStatus']='active';}
		if(empty($input['Domain'.DTR.'DomainStatus'])) {$input['Domain'.DTR.'DomainStatus']='new';}
		if(empty($input['Domain'.DTR.'DomainAuthor'])  && $clientType!='admin') {$input['Domain'.DTR.'DomainAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['Domain'.DTR.'DomainLink']) && $clientType!='admin') {$input['Domain'.DTR.'DomainLink']=$user['UserLink'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries	
		//if(is_array($input['Domain'.DTR.'DomainLanguages'])) {$input['Domain'.DTR.'DomainLanguages'] = '|'. implode("|",$input['Domain'.DTR.'DomainLanguages']).'|'; }
		//if(is_array($input['Domain'.DTR.'DomainCategories'])) {$input['Domain'.DTR.'DomainCategories'] = '|'. implode("|",$input['Domain'.DTR.'DomainCategories']).'|'; }
			
		//if(is_array($input['Domain'.DTR.'AccessGroups'])) {$input['Domain'.DTR.'AccessGroups'] = '|'. implode("|",$input['Domain'.DTR.'AccessGroups']).'|'; }
		$where['Domain'] = "DomainID = '".$entityID."'".$filter;
	/*
		if(!empty($input['Domain'.DTR.'DomainName']))
		{
			$checkRS=$DS->query("SELECT DomainAlias FROM Domain WHERE DomainAlias='".$input['Domain'.DTR.'DomainAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['Domain'.DTR.'DomainAlias'] = $input['Domain'.DTR.'DomainAlias'].date('Ymd-His');
				$SERVER->setMessage('dating.DomainClass.setDomain.err.DuplicatedDomain');
			}				
		}
		*/
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll, DomainStatus FROM Domain WHERE DomainID='".$entityID."'");
			
		}		
		//set visibility mode status
		if(!empty($input['Domain'.DTR.'DomainName']))
		{
			$checkRS = $DS->query("SELECT DomainID FROM Domain WHERE DomainName = '".$input['Domain'.DTR.'DomainName']."'");
			$DomainID = $checkRS[0]['DomainID'];
			if ($input['actionMode']=='add' && !empty($DomainID))
			{
				$err='Y';
			}
		}	

		if($err=='Y')
		{
			$SERVER->setMessage('DomainClass.setDomain.err.AlreadyExists');
		}
		else
		{
			if(!empty($input['Domain'.DTR.'DomainName']))
			{		
				$input['actionMode']='save';					
				$result = $DS->save($input,$where);
				$entityID = $result[0]['DomainID'];			
				$this->updateSerializedDomainFields($entityID,$input['Domain'.DTR.'DomainType']);
			}
			else
			{
				$SERVER->setMessage('DomainClass.setDomain.err.NoName');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('DomainClass.setDomain.msg.DataSaved');
		}
		//if(!empty($input['Domain'.DTR.'DomainAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Domain');
		//}
		$SERVER->setDebug('DomainClass.setDomain.End','End');		
		return $result;		
	}
	
	
	function updateSerializedDomainFields($DomainID,$DomainType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($DomainID))
		{
			$input['DomainID'] = $DomainID;
			$input['DomainType'] = $DomainType;
			$rs = $this->getDomainFields($input);
			$DomainFields = serialize($rs);
			$DomainFields = $SERVER->cleanString($DomainFields,'noquotes');
			$DS->query("UPDATE Domain SET DomainFields = '$DomainFields' WHERE DomainID='$DomainID'");
		}
	}

	function setDomainField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainFieldClass.setDomainField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Domain'.DTR.'DomainID'];
		if(empty($entityID)) {$entityID = $input['DomainID'];}	
			
		$entityType = $input['DomainType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['Domain'.DTR.'DomainType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainFieldServer.adminDomainField');
		//set queries	
		if(!empty($entityID))
		{
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('DomainField'.DTR,$fieldName))
				{
					//process Domainfield saving
					$fieldCode = str_replace('DomainField'.DTR,'',$fieldName);
					//get the field type
					//$entityType
					
					$fieldInfoRS = $DS->query("SELECT DomainTypeFieldID, DomainTypeFieldType, DomainTypeFieldPosition, DomainTypeFieldName, DomainTypeFieldAlias, DomainTypeFieldMode, DomainTypeFieldMode FROM DomainTypeField WHERE DomainTypeFieldAlias = '$fieldCode' AND DomainType='$entityType' ");
					$fieldType = $fieldInfoRS[0]['DomainTypeFieldType'];
					$fieldTypeID = $fieldInfoRS[0]['DomainTypeFieldID'];
					$fieldTypePosition = $fieldInfoRS[0]['DomainTypeFieldPosition'];
					$fieldTypeMode = $fieldInfoRS[0]['DomainTypeFieldMode'];
					$fieldTypeName = $fieldInfoRS[0]['DomainTypeFieldName'];
					$fieldTypeMode = $fieldInfoRS[0]['DomainTypeFieldMode'];
					
	
	
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
					$checkRS = $DS->query("SELECT DomainFieldID FROM DomainField WHERE DomainID='$entityID' AND DomainFieldAlias='$fieldCode'");
					$DomainFieldID = $checkRS[0]['DomainFieldID'];
	
					if($fieldType=='number' || $fieldType=='money')
					{
						$valueFieldName = 'DomainFieldValueNumber';
					}
					elseif($fieldType=='time' || $fieldType=='date')
					{
						$valueFieldName = 'DomainFieldValueTime';
					}
					else
					{
						$valueFieldName = 'DomainFieldValue';
					}
	
					if($fieldVale=='image' || $fieldVale=='file')
					{
						if(!empty($uploadRS[$fieldCode]['file']))
						{
							$fieldVale= $uploadRS[$fieldCode]['file'];
						}		
						else
						{
							$fileFieldRS = $DS->query("SELECT DomainFieldValue FROM DomainField WHERE DomainFieldID='$DomainFieldID'");
							$fieldVale=$fileFieldRS[0][$valueFieldName];
						}				
					}
					
					if($fieldVale=='deletefieldfile')
					{
						if(!empty($DomainFieldID))
						{
							$FM = new FilesManager();
							//$fileField =$input['fileField'];
							$fileFieldRS = $DS->query("SELECT DomainFieldValue FROM DomainField WHERE DomainFieldID='$DomainFieldID'");
							$SERVER->setInputVar('actionMode','deletefile');
							$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
							$fieldVale='';
							$input['DomainFieldStatus'][$fieldCode] = 1;
						}
					}				
					
					if($input['DomainFieldStatus'][$fieldCode]!=1)
					{
						$fieldStatus = 2;
					}
					else
					{
						$fieldStatus = 1;
					}
					//echo 'DomainFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';
	
					if(!empty($DomainFieldID))
					{
						//udpate
						$query = "UPDATE DomainField SET DomainID='$entityID',DomainFieldAlias='$fieldCode', DomainTypeFieldID='$fieldTypeID',DomainFieldType='$fieldType',DomainFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', DomainFieldStatus='$fieldStatus' WHERE DomainFieldID='$DomainFieldID'";
					}
					else
					{
						//insert
						$query = "INSERT INTO DomainField (DomainID,DomainFieldAlias,DomainTypeFieldID,DomainFieldType,DomainFieldPosition,$valueFieldName,DomainFieldStatus) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
					}
					
					//echo $query.'<br>';
					$DS->query($query);
					if(empty($DomainFieldID))
					{
						$DomainFieldID = $DS->dbLastID();	
					}
					
					if(is_array($input['DomainOption'.DTR.'DomainTypeOptionID']) && $fieldTypeMode=='option')
					{
						foreach($input['DomainOption'.DTR.'DomainTypeOptionID'] as $i=>$DomainTypeOptionID)
						{
							$inputSave['DomainOption'.DTR.'DomainTypeOptionID'] = $DomainTypeOptionID;
							$inputSave['DomainOption'.DTR.'DomainFieldID'] = $DomainFieldID;
							$inputSave['DomainOption'.DTR.'DomainOptionID'] = $input['DomainOption'.DTR.'DomainOptionID'][$i];
							$inputSave['DomainOption'.DTR.'DomainOptionPosition'] = $input['DomainOption'.DTR.'DomainOptionPosition'][$i];
							$inputSave['DomainOption'.DTR.'DomainOptionPrice'] = $input['DomainOption'.DTR.'DomainOptionPrice'][$i];
							$inputSave['DomainOption'.DTR.'DomainOptionPriceAction'] = $input['DomainOption'.DTR.'DomainOptionPriceAction'][$i];
							$inputSave['DomainOption'.DTR.'DomainOptionWeight'] = $input['DomainOption'.DTR.'DomainOptionWeight'][$i];
							$inputSave['DomainOption'.DTR.'DomainOptionWeightAction'] = $input['DomainOption'.DTR.'DomainOptionWeightAction'][$i];
							
							$inputSave['DomainOption'.DTR.'DomainOptionStatus'] = $input['DomainOption'.DTR.'DomainOptionStatus'][$i];
							
							if($inputSave['DomainOption'.DTR.'DomainOptionStatus']!=1)
							{
								$inputSave['DomainOption'.DTR.'DomainOptionStatus']=2;
							}
							else
							{
								$inputSave['DomainOption'.DTR.'DomainOptionStatus']=1;
							}
							//echo 'status='.$inputSave['DomainOption'.DTR.'DomainOptionStatus'];
							$inputSave['actionMode']='save';
		
							$where['DomainOption'] = "DomainOptionID = '".$inputSave['DomainOption'.DTR.'DomainOptionID']."'";
							$DS->save($inputSave,$where);	
						}
					}				
				}
			}
		}
		//if(!empty($input['DomainField'.DTR.'DomainFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'DomainField',$input['DomainField'.DTR.'DomainID'],'Domain');
		//}		
		$SERVER->setDebug('DomainFieldClass.setDomainField.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteDomain($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.deleteDomain.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Domain'.DTR.'DomainID'];
		//if(empty($entityID)) {$entityID = $input['DomainID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT DomainFieldID FROM DomainField WHERE DomainID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['DomainFieldID'];
			$DS->query("DELETE FROM Domain WHERE DomainID='$entityID'");
			$DS->query("DELETE FROM DomainField WHERE DomainID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM DomainOption WHERE DomainFieldID='$typeFieldID'");
			}
		}
		//$SERVER->setMessage('DomainClass.deleteDomain.msg.DataDeleted');
		$SERVER->setDebug('DomainClass.deleteDomain.End','End');		
		return $result;		
	}	
	
	function deleteDomainField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('DomainClass.deleteDomainField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['DomainField'.DTR.'DomainFieldID'];
		//if(empty($entityID)) {$entityID = $input['DomainID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainServer.adminDomain');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM DomainField WHERE DomainID='$entityID'");
			$DS->query("DELETE FROM DomainOption WHERE DomainFieldID='$entityID'");
		}
		$SERVER->setMessage('DomainClass.deleteDomainField.msg.DataDeleted');
		$SERVER->setDebug('DomainClass.deleteDomainField.End','End');		
		return $result;		
	}	

	
	function copyDomain($input)
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
		$DomainTemplateID = $input['selectedDomainID'];
		$DomainID = $input['DomainID'];
		if($DomainID==$DomainTemplateID) {return false;}
		//set client side variables
		if(!empty($DomainTemplateID) && !empty($DomainID))
		{
			//make Domain link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM DomainField WHERE DomainID='$DomainTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['DomainField'] = "DomainFieldID = ''";
			$inputNew['DomainField'.DTR.'DomainFieldID']='';
			$inputNew['DomainField'.DTR.'OwnerID']=$ownerID;
			$inputNew['DomainField'.DTR.'UserID']=$userID;
			$inputNew['DomainField'.DTR.'DomainID']=$DomainID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['DomainField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['DomainField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['DomainField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM DomainField WHERE BoxID='".$inputNew['DomainField'.DTR.'BoxID']."' AND DomainID='".$DomainID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Domain
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
		$DomainID= $input['DomainID'];
		if(empty($DomainID)) {$DomainID = $input['Domain'.DTR.'DomainID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'DomainBidServer.adminDomainBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if($viewMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		else
		{
			if($SERVER->hasRights('admin'))
			{
				$filter .= " AND DomainID='$DomainID' ";
			}
			else
			{
				$filter .= " AND UserID='$userID' AND DomainID='$DomainID' ";
			}
			
		}
		//set queries
		$query = "SELECT * FROM DomainBid WHERE DomainBidID>0 $filter  ORDER BY DomainBidID";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		//print_r($rs);
		return $result;
	}

	function buyDomain($input)
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
		$entityID = $input['Domain'.DTR.'DomainID'];
		if(empty($entityID)) {$entityID = $input['DomainID'];}		
					

		if(empty($entityID)) return false;
		
		
		if($input['paymentMethod']=='bank')
		{
			//print_r($input);
			$where['BillingOrder'] = "BillingOrderID = ' '";
			$inOrder['BillingOrder'.DTR.'OrderPaymentMethod'] = $input['paymentMethod'];
			$inOrder['BillingOrder'.DTR.'OrderPaymentStatus'] ='notpaid';
			$inOrder['BillingOrder'.DTR.'OrderStatus'] = 'new';
			$inOrder['BillingOrder'.DTR.'OrderCreatorID'] = $input['Domain'.DTR.'DomainID'];
			$inOrder['BillingOrder'.DTR.'OrderReturnURL'] = $input['BillingOrder'.DTR.'OrderReturnURL'];
			$inOrder['actionMode'] = 'save';
			$result = $DS->save($inOrder,$where);
			return $result;
			//$paymentResult = $SERVER->callService('doPaymentRequest','billingServer',$input);
		}
		else{
			$rs = $DS->query("SELECT * FROM Domain WHERE DomainID='$entityID'");
			
			$price = $rs[0]['DomainPrice'];
			if(empty($price)) {$price = $rs[0]['DomainMinPrice'];}
			$inBilling = $input;
			$inBilling['ServiceID']=$input['ServiceID'];
			$inBilling['actionMode']='buyService';
			$inBilling['TransactionCreator']=$entityID;
			$inBilling['BillingOrder'.DTR.'OrderReturnURL'] = $input['BillingOrder'.DTR.'OrderReturnURL'].'ServiceID/'.$inBilling['ServiceID'].'/';
			$SERVER->setInputVar('BillingOrder'.DTR.'OrderReturnURL',$inBilling['BillingOrder'.DTR.'OrderReturnURL']);
			$SERVER->setInputVar('BillingOrder'.DTR.'OrderCreatorID',$entityID.'dating');						
			$paymentResult = $SERVER->callService('doBillingPayment','billingServer',$inBilling);			
			//print_r($paymentResult);
			if($paymentResult['PaymentResult']=='OK')
			{
				$endTime = $paymentResult['PaymentTimeEnd'];
				$now = $SERVER->getNow();
				$paymentStatus = $paymentResult['PaymentStatus'];
				if(empty($paymentStatus)) {$paymentStatus ='paid';}
				
				if(!empty($entityID))
				{
					$query = "UPDATE Domain SET DomainPaymentStatus='$paymentStatus', DomainPaymentTime='$now', TimeEnd='$endTime' WHERE DomainID='$entityID' ";
					$DS->query($query);
				}
				//echo 'rrrwwqqq='.$query;
			}
		}
		return $paymentResult;		
	}
	

} // end of DomainServer
?>