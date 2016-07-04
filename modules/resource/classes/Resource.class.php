<?php
//XCMSPro: Web Service entity class
class ResourceClass
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
	function ResourceClass()
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
	function getResources($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.getResources.Start','Start');
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
		
		$resourceType = $input['ResourceType'];
		$resourceFeaturedOption = $input['ResourceFeaturedOption'];
		$permAll = $input['PermAll'];
		$resourceStatus = $input['ResourceStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		$ownerMode = $input['ownerMode'];
		$TimeEndMode = $input['TimeEndMode'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		if(!empty($categoryAlias))
		{
			if($config['PageViewType']=='showresources' || $config['UseResourceCategories']=='N')
			{
				$categoryIDRS = $DS->query("SELECT SectionID FROM Section WHERE SectionAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['SectionID'];
			}
			else
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
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
		if(!empty($categoryID) && empty($searchWord))
		{
			if($config['ResourceCategoriesMode']=='one')
			{
				$filterCurrentCat = " ResourceCategories = '|$categoryID|' ";
			}
			else
			{
				$filterCurrentCat = " ResourceCategories LIKE '%|$categoryID|%' ";
			}			
			if($config['ResourcesInSubcategoriesMode']=='Y')
			{
				if($config['PageViewType']=='showresources' || $config['UseResourceCategories']=='N')
				{
					$sectionObject = new SectionClass();
					$subsectionsQuery = $sectionObject->getSubsectionsListQuery($categoryID);
					//echo '$subsectionsQuery='.$subsectionsQuery;
					if(!empty($subsectionsQuery))
					{
						$filter .= " AND (".$filterCurrentCat." OR ".$subsectionsQuery.") ";
					}
					else
					{
						$filter .=  ' AND '.$filterCurrentCat;
					}
				}
				else
				{
					$categoryObject = new ResourceCategoryClass();
					$subcategoriesQuery = $categoryObject->getSubcategoriesListQuery($categoryID);
					if(!empty($subcategoriesQuery)) 
					{
						$filter .= " AND (".$filterCurrentCat." OR ".$subcategoriesQuery.") ";
					}
					else
					{
						$filter .=  ' AND '.$filterCurrentCat;
					}
				}
			}
			else
			{
				$filter .=  ' AND '.$filterCurrentCat;
			}			
		}		
		if(!empty($locationID))
		{
			$filter .= " AND ResourceLocationID = '$locationID' ";
		}		
		if(!empty($resourceType))
		{
			$filter .= " AND ResourceType='$resourceType' ";
		}	
		if(!empty($resourceStatus))
		{
			$filter .= " AND ResourceStatus='$resourceStatus' ";
		}			
		if(!empty($resourceFeaturedOption))
		{
			$filter .= " AND ResourceFeaturedOptions LIKE '%|$resourceFeaturedOption|%' ";
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
			$filter .= " AND (ResourceTitle LIKE '%$searchWord%' OR ResourceLink LIKE '%$searchWord%' OR ResourceIntro LIKE '%$searchWord%' OR ResourceContent LIKE '%$searchWord%' OR ResourceKeywords LIKE '%$searchWord%')  ";
			//$filter .= " AND ( MATCH (ResourceTitle) AGAINST ('$searchWord') OR MATCH (ResourceIntro) AGAINST ('$searchWord') OR MATCH (ResourceContent) AGAINST ('$searchWord') )"; 
			//$filter .= " AND ( MATCH (ResourceContent) AGAINST ('$searchWord') ) "; 
		}	
		if(!empty($featuredMode))
		{
			if($config['ResourceFeaturedPlacesMode']=='one')
			{
				$filter .= " AND ResourceFeaturedOptions LIKE '|$featuredMode|' ";
			}
			else
			{
				$filter .= " AND ResourceFeaturedOptions LIKE '%|$featuredMode|%' ";
			}
		}		
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND PermAll='1' ";
			$filter .= " AND ResourceStatus='active' ";
		}
		
		/*if($filterMode=='home')
		{
			if($config['ResourceFeaturedPlacesMode']=='one')
			{
				$filter .= " AND ResourceFeaturedOptions LIKE '|home|' ";
			}
			else
			{
				$filter .= " AND ResourceFeaturedOptions LIKE '%|home|%' ";
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
		//search in resource field
	
		$fieldsFilter = $this->getResourceFieldSearchFilter($input);
		
		if(empty($limit))
		{
			if(!empty($fieldsFilter))
			{		
				$pages = $DS->getPages(' Resource LEFT JOIN ResourceField ON Resource.ResourceID = ResourceField.ResourceID',"Resource.ResourceID>0 $filter $fieldsFilter ",array('ItemsPerPage'=>$itemsPerPage));
			}
			else
			{
				$pages = $DS->getPages('Resource',"ResourceID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			}
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		if(!empty($config['ResourcesDefaultOrder']))
		{
			if($config['ResourcesDefaultOrder']=='random')
			{
				$order = '';
			}
			else
			{
				$order = 'ORDER BY '.$config['ResourcesDefaultOrder'];
			}
		}
		else
		{
			$order = 'ORDER BY Resource.ResourceAlias, Resource.ResourceID ASC';
		}
		if(!empty($fieldsFilter))
		{
			//$query = "SELECT * FROM ResourceTypeField LEFT JOIN ResourceTypeOption ON ResourceTypeField.ResourceTypeFieldID = ResourceTypeOption.ResourceTypeFieldID WHERE ResourceTypeField.ResourceType = '$entityType' $filter ORDER BY ResourceTypeFieldPosition, ResourceTypeOptionPosition"; 
			$query = "SELECT *,Resource.ResourceID AS ResourceID FROM Resource LEFT JOIN ResourceField ON Resource.ResourceID = ResourceField.ResourceID  WHERE Resource.ResourceID>0 $filter $fieldsFilter $order $limit";
		}
		else
		{
			$query = "SELECT * FROM Resource WHERE ResourceID>0 $filter $order $limit";
		}
				
		//get the content
		//echo $query;
		$result['result'] = $DS->query($query); 
		//print_r($result['result']);
		$result['pages'] = $pages['pages'];
		$SERVER->setDebug('ResourceClass.getResources.End','End');
		return $result;
	}	
	
	function getResourceFieldSearchFilter($input)
	{
		$DS = &$this->_DS;
		$fieldsFilter = '';
		$i=0;
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('ResourceSearchField'.DTR,$fieldName))
			{
				
				//process resourcefield saving
				$fieldCode = str_replace('ResourceSearchField'.DTR,'',$fieldName);
				//getResource filed info 
				if(!empty($fieldCode) && !empty($fieldVale) && ($fieldVale != 34 && $fieldVale != 35 && $fieldVale != 36))
				{
					
					$resourceTypeInfoRS = $DS->query("SELECT ResourceFieldType FROM ResourceField WHERE ResourceFieldAlias='$fieldCode' ");
					$fieldType = $resourceTypeInfoRS[0]['ResourceFieldType'];
					if($fieldType == 'dropdown')
					{
						if($i==0)
							$fieldsFilter .= " (ResourceFieldAlias='$fieldCode' AND ResourceFieldValue = '$fieldVale' )";
						else
							$fieldsFilter .= " OR (ResourceFieldAlias='$fieldCode' AND ResourceFieldValue = '$fieldVale' )";
					}
						elseif($fieldType == 'checkboxes'){
								$fieldVale = explode("|",$fieldVale);
								unset($fieldVale[0]);
								unset($fieldVale[count($fieldVale)]);
								$fieldsFilter .= " AND (ResourceFieldAlias='$fieldCode' ";
								foreach($fieldVale as $value)
									$fieldsFilter .= " OR ResourceFieldValue = '$value' ";
								
								$fieldsFilter .= " }";
							}else
								{
									if($i==0)
										$fieldsFilter .= " (ResourceFieldAlias='$fieldCode' AND ResourceFieldValue = '$fieldVale' )";
									else
										$fieldsFilter .= " OR (ResourceFieldAlias='$fieldCode' AND ResourceFieldValue = '$fieldVale' )";
								}
					$i++;
				}
			}
		}			
		
		if(!empty($fieldsFilter))
		{
			$query = "SELECT ResourceID, ResourceFieldAlias, ResourceFieldValue	FROM ResourceField WHERE $fieldsFilter ";
			$result['result'] = $DS->query($query);
			
			$query = "SELECT ResourceID	FROM ResourceField WHERE $fieldsFilter GROUP BY ResourceID";
			$result['ResourceID'] = $DS->query($query);
			
			foreach($result['ResourceID'] as $ResourceID)
			{	
				$s = 0;
				foreach($result['result'] as $fkey=>$fvalue)
				{
					if($fvalue['ResourceID']==$ResourceID['ResourceID'])
					{
						if($fvalue['ResourceFieldValue'] == $input['ResourceSearchField'.DTR.$fvalue['ResourceFieldAlias']])
						{
							$s++;
							$rs[$ResourceID['ResourceID']] = $s;
						}
					}
				}
			}
			$fieldsFilter = "";
			
			$l=0;
			foreach($result['ResourceID'] as $ResourceID)
			{
				if($rs[$ResourceID['ResourceID']] == $i)
				{
					if($l==0)
						$fieldsFilter .= " ResourceID = '".$ResourceID['ResourceID']."'";
					else
						$fieldsFilter .= " OR ResourceID = '".$ResourceID['ResourceID']."'";
					$l++;
				}
				
			}
			
			if(!empty($fieldsFilter))
				$fieldsFilter = " AND ( ".$fieldsFilter." ) ";
			else
				$fieldsFilter = " AND ResourceID = ''";
				//$fieldsFilter .= " ) ";
				//echo $fieldsFilter;
		}
		
		return $fieldsFilter;
	}
	
	function getActiveResourcesFilter()
	{
		
	}
	
	function getResourceFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.getResourceFields.Start','Start');
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
		if(empty($entityType)) {$entityType = $input['ResourceType'];}
		
		$entityID = $input['Resource'.DTR.'ResourceID'];
		if(empty($entityID)) {$entityID = $input['ResourceID'];}
		
		$entityAlias = $input['Resource'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Resource'.DTR.'ResourceAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ResourceIDRS = $DS->query("SELECT ResourceID FROM Resource WHERE ResourceAlias='$entityAlias'");
			$entityID = $ResourceIDRS[0]['ResourceID'];
		}
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//$filter .= "OwnerID='$ownerID' ";

		$ResourceTypeIDRS = $DS->query("SELECT ResourceTypeID FROM ResourceType WHERE ResourceTypeAlias='$entityType'");
		$ResourceTypeID = $ResourceTypeIDRS[0]['ResourceTypeID'];
		$query = "SELECT * FROM ResourceTypeField LEFT JOIN ResourceTypeOption ON ResourceTypeField.ResourceTypeFieldID = ResourceTypeOption.ResourceTypeFieldID WHERE ResourceTypeField.ResourceType = '$entityType' $filter ORDER BY ResourceTypeFieldPosition, ResourceTypeOptionPosition"; 
		//$query = "SELECT * FROM (ResourceField LEFT JOIN ResourceTypeField ON ResourceField.ResourceTypeFieldID = ResourceTypeField.ResourceTypeFieldID) LEFT JOIN ResourceTypeOption ON ResourceTypeField.ResourceTypeFieldID = ResourceTypeOption.ResourceTypeFieldID WHERE ResourceTypeField.ResourceType = '$entityType' AND ResourceID='$entityID' $filter ORDER BY ResourceTypeFieldPosition, ResourceTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['ResourceTypeFieldAlias'];
				$fieldName = $row['ResourceTypeFieldName'];
				$fieldType = $row['ResourceTypeFieldType'];
				$fieldMode = $row['ResourceTypeFieldMode'];
				$fieldPlaces = $row['ResourceTypeFieldHidenPlaces'];
				$fieldOptionID = $row['ResourceTypeOptionID'];
				$fieldOptionAlias = $row['ResourceTypeOptionAlias'];
				$fieldOptionValue = $row['ResourceTypeOptionName'];
				
				$fieldOptionPrice = $row['ResourceTypeOptionPrice'];
				$fieldOptionPriceAction = $row['ResourceTypeOptionPriceAction'];
				$fieldOptionWeight = $row['ResourceTypeOptionWeight'];
				$fieldOptionWeightAction = $row['ResourceTypeOptionWeightAction'];
				$fieldOptionPosition = $row['ResourceTypeOptionPosition'];
				
				$result['ResourceFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['ResourceFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['ResourceFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['ResourceFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['ResourceFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					if($fieldMode=='option')
					{
						$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;

						//$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['price'] = $fieldOptionPrice;
						//$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['priceaction'] = $fieldOptionPriceAction;
						//$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['weight'] = $fieldOptionWeight;
						//$result['ResourceFieldTypes'][$fieldCode]['options'][$i]['weightaction'] = $fieldOptionWeightAction;

						$result['ResourceOption'][$fieldOptionID]['ResourceOptionPrice'] = $fieldOptionPrice;
						$result['ResourceOption'][$fieldOptionID]['ResourceOptionPriceAction'] = $fieldOptionPriceAction;
						$result['ResourceOption'][$fieldOptionID]['ResourceOptionWeight'] = $fieldOptionWeight;
						$result['ResourceOption'][$fieldOptionID]['ResourceOptionWeightAction'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		if(!empty($entityID))
		{
			$query = "SELECT * FROM ResourceField LEFT JOIN ResourceOption ON ResourceField.ResourceFieldID = ResourceOption.ResourceFieldID WHERE ResourceID='$entityID' $filter ORDER BY ResourceFieldPosition, ResourceOptionPosition"; 
			//$query = "SELECT * FROM ResourceField WHERE ResourceID='$entityID' $filter ORDER BY ResourceFieldPosition"; 
			$rs = $DS->query($query);
		}
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();

			foreach($rs as $row)
			{
				$fieldCode = $row['ResourceFieldAlias'];
				$fieldType = $row['ResourceFieldType'];
				
				$resourceFieldID = $row['ResourceFieldID'];
				$fieldOptionID = $row['ResourceOptionID'];
				
				$fieldTypeOptionID = $row['ResourceTypeOptionID'];
				
				$fieldOptionStatus = $row['ResourceOptionStatus'];
				$fieldOptionPrice = $row['ResourceOptionPrice'];
				$fieldOptionPriceAction = $row['ResourceOptionPriceAction'];
				$fieldOptionWeight = $row['ResourceOptionWeight'];
				$fieldOptionWeightAction = $row['ResourceOptionWeightAction'];
				
	
				if($row['ResourceFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['ResourceFieldValueTime'];
				}
				elseif($row['ResourceFieldValueNumber']>0)
				{
					$fieldValue = $row['ResourceFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['ResourceFieldValue'];
				}									
				
				if(!empty($result['ResourceFieldTypes'][$fieldCode]['code']))
				{
					$result['ResourceFieldTypes'][$fieldCode]['status'] = $row['ResourceFieldStatus'];
				}
				$result['ResourceField'][0][$fieldCode] = $fieldValue;
				
				$result['ResourceOption'][$fieldTypeOptionID]['ResourceFieldID'] = $resourceFieldID;			
				
				if(!empty($fieldTypeOptionID))
				{
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionID'] = $fieldOptionID;
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionStatus'] = $fieldOptionStatus;	
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceTypeOptionID'] = $fieldTypeOptionID;		
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionPrice'] = $fieldOptionPrice;
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionPriceAction'] = $fieldOptionPriceAction;
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionWeight'] = $fieldOptionWeight;
					$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionWeightAction'] = $fieldOptionWeightAction;
					//$result['ResourceOption'][$fieldTypeOptionID]['ResourceOptionWeightAction'] = $fieldOptionWeightAction;
				}
				
				if($viewMode=='viewresource' && $result['ResourceFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
				{
					foreach($result['ResourceFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
					{
						if($fieldTypeOptionID==$result['ResourceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
						{
							if($fieldOptionStatus==2)
							{
								$result['ResourceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
								$result['ResourceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
							}
							else
							{
								$result['ResourceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value']='';
								foreach($languagesList['languageCodes'] as $langID=>$langCode) 
								{ 
									$result['ResourceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] .= '<'.$langCode.'>'.$SERVER->getValue($redefinVieldValue['value'],$langCode).' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'].'</'.$langCode.'>';
								}
							}
						}
					}
				}						
				
			}		
		}
		//print_r($result['ResourceOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('ResourceClass.getResourceFields.End','End');
		return $result;
	}	
	
	function getResourceFields($input)
	{
		$rs = $this->getResourceFieldsStructureAndValues($input);
		if(is_array($rs['ResourceFieldTypes']))
		{
			foreach($rs['ResourceFieldTypes'] as $ResourceFieldCode=>$ResourceFieldType)			
			{
				if(!empty($ResourceFieldType['code']))
				{
					$result['ResourceField'][$ResourceFieldCode]['code']=$ResourceFieldType['code'];
					$result['ResourceField'][$ResourceFieldCode]['name']=$ResourceFieldType['name'];
					$result['ResourceField'][$ResourceFieldCode]['type']=$ResourceFieldType['type'];
					$result['ResourceField'][$ResourceFieldCode]['mode']=$ResourceFieldType['mode'];
					$result['ResourceField'][$ResourceFieldCode]['status']=$ResourceFieldType['status'];
					$result['ResourceField'][$ResourceFieldCode]['places']=$ResourceFieldType['places'];
					
					$result['ResourceField'][$ResourceFieldCode]['value']=$rs['ResourceField'][0][$ResourceFieldCode];
					if(is_array($ResourceFieldType['options'])) {
						foreach($ResourceFieldType['options'] as $id=>$resourceFieldOptions) { 
							$optionsTypeID = $resourceFieldOptions['id'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['id']=$resourceFieldOptions['id'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['value']=$resourceFieldOptions['value'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['position']=$resourceFieldOptions['position'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionID']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionID'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceFieldID']=$rs['ResourceOption'][$optionsTypeID]['ResourceFieldID'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionStatus']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionStatus'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceTypeOptionID']=$rs['ResourceOption'][$optionsTypeID]['ResourceTypeOptionID'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionPrice']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionPrice'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionPriceAction']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionPriceAction'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionWeight']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionWeight'];
							$result['ResourceField'][$ResourceFieldCode]['options'][$id]['ResourceOptionWeightAction']=$rs['ResourceOption'][$optionsTypeID]['ResourceOptionWeightAction'];
						}//end of foreach($ResourceFieldType['options'] as $id=>$resourceFieldOptions) 
					}//end of if(is_array($ResourceFieldType['options']))
				}//end of if(!empty($ResourceFieldType['code']) && !empty($rs['ResourceField'][0][$ResourceFieldCode]))
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
	function getResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.getResource.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Resource'.DTR.'ResourceID'];
		if(empty($entityID)) {$entityID = $input['ResourceID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Resource'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Resource'.DTR.'ResourceAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " ResourceAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " ResourceID='$entityID' ";
			}
			$query = "SELECT * FROM Resource WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
	
			$resourceTypeObject = new ResourceTypeClass();
			$resourceTemplate = $resourceTypeObject->getResourceTemplate($result[0]['ResourceType']);
			$SERVER->setInputVar('ResourceTemplate',$resourceTemplate);
			$SERVER->setInputVar('ResourceType',$result[0]['ResourceType']);
		}		
		$SERVER->setDebug('ResourceClass.getResource.End','End');		
		return $result;		
	}
	
	function getResourceField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.getResourceField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceField'.DTR.'ResourceFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceFieldID'];}

		$entityAlias = $input['ResourceField'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceField'.DTR.'ResourceFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ResourceClass.getResourceField.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.setResource.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Resource'.DTR.'ResourceID'];
		if(empty($entityID)) {$entityID = $input['ResourceID'];}		
		if(empty($input['Resource'.DTR.'PermAll'])) {$input['Resource'.DTR.'PermAll']=4;}
		
		if($config['ResourceValidationMode']=='N')
		{
			$input['Resource'.DTR.'PermAll']=1;
		}
		else
		{
			if(!$SERVER->hasRights('admin')) {$input['Resource'.DTR.'PermAll']=4;}
		}
		
		if($SERVER->hasRights('admin') && $input['Resource'.DTR.'PermAll']==1 && empty($input['Resource'.DTR.'ResourceStatus'])) {$input['Resource'.DTR.'ResourceStatus']='active';}
					
		if(empty($input['Resource'.DTR.'ResourceStatus'])) {$input['Resource'.DTR.'ResourceStatus']='new';}
		if(empty($input['Resource'.DTR.'ResourceAuthor'])  && $clientType!='admin') {$input['Resource'.DTR.'ResourceAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['Resource'.DTR.'ResourceLink']) && $clientType!='admin') {$input['Resource'.DTR.'ResourceLink']=$user['UserLink'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries	
		//if(is_array($input['Resource'.DTR.'ResourceLanguages'])) {$input['Resource'.DTR.'ResourceLanguages'] = '|'. implode("|",$input['Resource'.DTR.'ResourceLanguages']).'|'; }
		//if(is_array($input['Resource'.DTR.'ResourceCategories'])) {$input['Resource'.DTR.'ResourceCategories'] = '|'. implode("|",$input['Resource'.DTR.'ResourceCategories']).'|'; }
			
		//if(is_array($input['Resource'.DTR.'AccessGroups'])) {$input['Resource'.DTR.'AccessGroups'] = '|'. implode("|",$input['Resource'.DTR.'AccessGroups']).'|'; }
		$where['Resource'] = "ResourceID = '".$entityID."'".$filter;

		if(empty($input['Resource'.DTR.'ResourceAlias']) && !empty($input['Resource'.DTR.'ResourceTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langResourceTitle = $input['Resource'.DTR.'ResourceTitle']['en'];
			if(empty($langResourceTitle)) { $lang = $config['lang']; $langResourceTitle = $input['Resource'.DTR.'ResourceTitle'][$lang];}
			$input['Resource'.DTR.'ResourceAlias'] = $typeObject->setDataType($langResourceTitle);
		}	
		
		if(!empty($input['Resource'.DTR.'ResourceAlias']))
		{
			$checkRS=$DS->query("SELECT ResourceAlias FROM Resource WHERE ResourceAlias='".$input['Resource'.DTR.'ResourceAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['Resource'.DTR.'ResourceAlias'] = $input['Resource'.DTR.'ResourceAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.ResourceClass.setResource.err.DuplicatedResource');
			}				
		}
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll, ResourceStatus FROM Resource WHERE ResourceID='".$entityID."'");
		}		
		//set visibility mode status	
		if(!empty($input['Resource'.DTR.'ResourceTitle']))
		{		
			//echo "1111111";
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ResourceID'];			
			//echo $entityID;
			$input['Resource'.DTR.'ResourceID'] = $entityID;
			if(!empty($input['Resource'.DTR.'ResourceID']))	
			{
				$this->setResourceField($input,$uploadRS);	
			}				
			$this->updateSerializedResourceFields($entityID,$input['Resource'.DTR.'ResourceType']);
			$this->updateResourceCategoryStats($entityID);
		}
		else
		{
			if(!empty($input['Resource'.DTR.'ResourceAlias']))
			{
				$SERVER->setMessage('ResourceClass.setResource.err.AlreadyExists');
			}
		}
		
		if(count($result[0])>0)	
		{
			$SERVER->setMessage('ResourceClass.setResource.msg.DataSaved',$result[0]['ResourceTitle']);
		}
		
		/*if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ResourceClass.setResource.msg.DataSaved');
		}*/
		//if(!empty($input['Resource'.DTR.'ResourceAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Resource');
		//}
		$SERVER->setDebug('ResourceClass.setResource.End','End');		
		return $result;		
	}
	
	function updateResourceCategoryStats($resourceID)
	{
		$DS = &$this->_DS;	
		if(!empty($resourceID))
		{
			$catsObject = new ResourceCategoryClass();	
			$mode='';
			$rs = $DS->query("SELECT ResourceType, ResourceCategories, PermAll, ResourceStatus FROM Resource WHERE ResourceID='$resourceID'");
			$resourceCategoriesArray = explode("|",$rs[0]['ResourceCategories']);
			if(is_array($resourceCategoriesArray))
			{
				foreach($resourceCategoriesArray as $categoryID)
				{
					if(!empty($categoryID))
					{
						$countTotal = $this->getResourcesNumberInCategory($categoryID);
						$countType = $this->getResourcesNumberInCategory($categoryID,$rs[0]['ResourceType']);
						$catsObject->updateResourceCategoryStat($categoryID,$rs[0]['ResourceType'],$countTotal,$countType);
					}
				}
			}
		}
	}

	function updateAllResourceCategoryStats($resourceType)
	{
		$DS = &$this->_DS;	
		if(!empty($resourceType))
		{
			$catsObject = new ResourceCategoryClass();	
			$mode='';
			$rs = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory");
			if(is_array($rs))
			{
				foreach($rs as $row)
				{
					$categoryID = $row['ResourceCategoryID'];
					if(!empty($categoryID))
					{
						$countTotal = $this->getResourcesNumberInCategory($categoryID);
						$countType = $this->getResourcesNumberInCategory($categoryID,$resourceType);
						$catsObject->updateResourceCategoryStat($categoryID,$resourceType,$countTotal,$countType);
					}
				}
			}
		}
	}
		
	function getResourcesNumberInCategory($categoryID,$resourceType='')
	{
		$DS = &$this->_DS;	
		if(!empty($resourceType)) {$filter = " AND ResourceType='$resourceType' ";}
		$rs = $DS->query("SELECT COUNT(ResourceID) AS ResourceCount FROM Resource WHERE PermAll=1 AND ResourceStatus='active' AND ResourceCategories LIKE '%|$categoryID|%' $filter ");
		$result = $rs[0]['ResourceCount'];
		return $result;
	}
	
	function updateSerializedResourceFields($resourceID,$resourceType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($resourceID))
		{
			$input['ResourceID'] = $resourceID;
			$input['ResourceType'] = $resourceType;
			$rs = $this->getResourceFields($input);
			$resourceFields = serialize($rs);
			$resourceFields = $SERVER->cleanString($resourceFields,'noquotes');
			$DS->query("UPDATE Resource SET ResourceFields = '$resourceFields' WHERE ResourceID='$resourceID'");
		}
	}

	function setResourceField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceFieldClass.setResourceField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Resource'.DTR.'ResourceID'];
		if(empty($entityID)) {$entityID = $input['ResourceID'];}	
			
		$entityType = $input['ResourceType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['Resource'.DTR.'ResourceType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceFieldServer.adminResourceField');
		//set queries	
		if(!empty($entityID))
		{
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('ResourceField'.DTR,$fieldName))
				{
					//process resourcefield saving
					$fieldCode = str_replace('ResourceField'.DTR,'',$fieldName);
					//get the field type
					//$entityType
					
					$fieldInfoRS = $DS->query("SELECT ResourceTypeFieldID, ResourceTypeFieldType, ResourceTypeFieldPosition, ResourceTypeFieldName, ResourceTypeFieldAlias, ResourceTypeFieldMode, ResourceTypeFieldMode FROM ResourceTypeField WHERE ResourceTypeFieldAlias = '$fieldCode' AND ResourceType='$entityType' ");
					$fieldType = $fieldInfoRS[0]['ResourceTypeFieldType'];
					$fieldTypeID = $fieldInfoRS[0]['ResourceTypeFieldID'];
					$fieldTypePosition = $fieldInfoRS[0]['ResourceTypeFieldPosition'];
					$fieldTypeMode = $fieldInfoRS[0]['ResourceTypeFieldMode'];
					$fieldTypeName = $fieldInfoRS[0]['ResourceTypeFieldName'];
					$fieldTypeMode = $fieldInfoRS[0]['ResourceTypeFieldMode'];
					
	
	
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
								if(!empty($itemValue)){
									$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
								}
							}
						}
						$fieldVale = $fieldValeResult;
					}
					//check if there is a value
					$checkRS = $DS->query("SELECT ResourceFieldID FROM ResourceField WHERE ResourceID='$entityID' AND ResourceFieldAlias='$fieldCode'");
					$resourceFieldID = $checkRS[0]['ResourceFieldID'];
	
					if($fieldType=='number' || $fieldType=='money')
					{
						$valueFieldName = 'ResourceFieldValueNumber';
					}
					elseif($fieldType=='time' || $fieldType=='date')
					{
						$valueFieldName = 'ResourceFieldValueTime';
					}
					else
					{
						$valueFieldName = 'ResourceFieldValue';
					}
	
					if($fieldVale=='image' || $fieldVale=='file')
					{
						if(!empty($uploadRS[$fieldCode]['file']))
						{
							$fieldVale= $uploadRS[$fieldCode]['file'];
						}		
						else
						{
							$fileFieldRS = $DS->query("SELECT ResourceFieldValue FROM ResourceField WHERE ResourceFieldID='$resourceFieldID'");
							$fieldVale=$fileFieldRS[0][$valueFieldName];
						}				
					}
					
					if($fieldVale=='deletefieldfile')
					{
						if(!empty($resourceFieldID))
						{
							$FM = new FilesManager();
							//$fileField =$input['fileField'];
							$fileFieldRS = $DS->query("SELECT ResourceFieldValue FROM ResourceField WHERE ResourceFieldID='$resourceFieldID'");
							$SERVER->setInputVar('actionMode','deletefile');
							$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
							$fieldVale='';
							$input['ResourceFieldStatus'][$fieldCode] = 1;
						}
					}				
					
					if($input['ResourceFieldStatus'][$fieldCode]!=1)
					{
						$fieldStatus = 2;
					}
					else
					{
						$fieldStatus = 1;
					}
					//echo 'ResourceFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';
	
					if(!empty($resourceFieldID))
					{
						//udpate
						$query = "UPDATE ResourceField SET ResourceID='$entityID',ResourceFieldAlias='$fieldCode', ResourceTypeFieldID='$fieldTypeID',ResourceFieldType='$fieldType',ResourceFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', ResourceFieldStatus='$fieldStatus' WHERE ResourceFieldID='$resourceFieldID'";
					}
					else
					{
						//insert
						$query = "INSERT INTO ResourceField (ResourceID,ResourceFieldAlias,ResourceTypeFieldID,ResourceFieldType,ResourceFieldPosition,$valueFieldName,ResourceFieldStatus) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
					}
					
					//echo $query.'<br>';
					$DS->query($query);
					if(empty($resourceFieldID))
					{
						$resourceFieldID = $DS->dbLastID();	
					}
					
					if(is_array($input['ResourceOptionFieldCode']) && $fieldTypeMode=='option')
					{
						foreach($input['ResourceOptionFieldCode'] as $i=>$resourceOptionFieldCode)
						{
							if($resourceOptionFieldCode==$fieldCode)
							{
								$inputSave['ResourceOption'.DTR.'ResourceTypeOptionID'] = $input['ResourceOption'.DTR.'ResourceTypeOptionID'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceFieldID'] = $resourceFieldID;
								$inputSave['ResourceOption'.DTR.'ResourceOptionID'] = $input['ResourceOption'.DTR.'ResourceOptionID'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceOptionPosition'] = $input['ResourceOption'.DTR.'ResourceOptionPosition'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceOptionPrice'] = $input['ResourceOption'.DTR.'ResourceOptionPrice'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceOptionPriceAction'] = $input['ResourceOption'.DTR.'ResourceOptionPriceAction'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceOptionWeight'] = $input['ResourceOption'.DTR.'ResourceOptionWeight'][$i];
								$inputSave['ResourceOption'.DTR.'ResourceOptionWeightAction'] = $input['ResourceOption'.DTR.'ResourceOptionWeightAction'][$i];
								
								$inputSave['ResourceOption'.DTR.'ResourceOptionStatus'] = $input['ResourceOption'.DTR.'ResourceOptionStatus'][$i];
								
								if($inputSave['ResourceOption'.DTR.'ResourceOptionStatus']!=1)
								{
									$inputSave['ResourceOption'.DTR.'ResourceOptionStatus']=2;
								}
								else
								{
									$inputSave['ResourceOption'.DTR.'ResourceOptionStatus']=1;
								}
								//echo 'status='.$inputSave['ResourceOption'.DTR.'ResourceOptionStatus'];
								$inputSave['actionMode']='save';
			
								$where['ResourceOption'] = "ResourceOptionID = '".$inputSave['ResourceOption'.DTR.'ResourceOptionID']."'";
								$DS->save($inputSave,$where);	
							}
						}
					}				
				}
			}
		}
		//if(!empty($input['ResourceField'.DTR.'ResourceFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ResourceField',$input['ResourceField'.DTR.'ResourceID'],'Resource');
		//}		
		$SERVER->setDebug('ResourceFieldClass.setResourceField.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResource($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.deleteResource.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Resource'.DTR.'ResourceID'];
		//if(empty($entityID)) {$entityID = $input['ResourceID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ResourceFieldID FROM ResourceField WHERE ResourceID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ResourceFieldID'];
			$DS->query("DELETE FROM Resource WHERE ResourceID='$entityID'");
			$DS->query("DELETE FROM ResourceField WHERE ResourceID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ResourceOption WHERE ResourceFieldID='$typeFieldID'");
				$SERVER->setMessage('ResourceClass.deleteResource.msg.DataDeleted');
			}
		}
		//$SERVER->setMessage('ResourceClass.deleteResource.msg.DataDeleted');
		$SERVER->setDebug('ResourceClass.deleteResource.End','End');		
		return $result;		
	}	
	
	function deleteResourceField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceClass.deleteResourceField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceField'.DTR.'ResourceFieldID'];
		//if(empty($entityID)) {$entityID = $input['ResourceID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ResourceField WHERE ResourceID='$entityID'");
			$DS->query("DELETE FROM ResourceOption WHERE ResourceFieldID='$entityID'");
			$SERVER->setMessage('ResourceClass.deleteResourceField.msg.DataDeleted');
		}
		
		$SERVER->setDebug('ResourceClass.deleteResourceField.End','End');		
		return $result;		
	}	
	
	function copyResource($input)
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
		$ResourceTemplateID = $input['selectedResourceID'];
		$ResourceID = $input['ResourceID'];
		if($ResourceID==$ResourceTemplateID) {return false;}
		//set client side variables
		if(!empty($ResourceTemplateID) && !empty($ResourceID))
		{
			//make Resource link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ResourceField WHERE ResourceID='$ResourceTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ResourceField'] = "ResourceFieldID = ''";
			$inputNew['ResourceField'.DTR.'ResourceFieldID']='';
			$inputNew['ResourceField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ResourceField'.DTR.'UserID']=$userID;
			$inputNew['ResourceField'.DTR.'ResourceID']=$ResourceID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ResourceField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ResourceField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ResourceField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ResourceField WHERE BoxID='".$inputNew['ResourceField'.DTR.'BoxID']."' AND ResourceID='".$ResourceID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Resource
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
		$resourceID= $input['ResourceID'];
		if(empty($resourceID)) {$resourceID = $input['Resource'.DTR.'ResourceID'];}
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceBidServer.adminResourceBid');
		//$filter .= " AND OwnerID='$ownerID' ";
		if($viewMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		else
		{
			if($SERVER->hasRights('admin'))
			{
				$filter .= " AND ResourceID='$resourceID' ";
			}
			else
			{
				$filter .= " AND UserID='$userID' AND ResourceID='$resourceID' ";
			}
			
		}
		//set queries
		$query = "SELECT * FROM ResourceBid WHERE ResourceBidID>0 $filter  ORDER BY ResourceBidID";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		//print_r($rs);
		return $result;
	}

} // end of ResourceServer
?>