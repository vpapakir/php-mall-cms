<?php
//XCMSPro: Web Service entity class
class TourClass
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
	function TourClass()
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
	function getTours($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.getTours.Start','Start');
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
		
		$tourType = $input['TourType'];
		$tourCountry = $input['TourCountry'];
		$tourFeaturedOption = $input['TourFeaturedOption'];
		$permAll = $input['PermAll'];
		$tourStatus = $input['TourStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		
		$SearchText = $input['SearchText'];
		$tourCountry = $input['TourCountry'];
		$tourRegion = $input['TourRegion'];
		//set filters
		$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		if(!empty($categoryAlias))
		{
			$categoryIDRS = $DS->query("SELECT TourCategoryID FROM TourCategory WHERE TourCategoryAlias='$categoryAlias'");
			$categoryID = $categoryIDRS[0]['TourCategoryID'];
		}
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		if($filterMode=='last1')
		{
			$limit = " LIMIT 10";
		}
		if(!empty($input['PermAll']))
		{
			$filter .= " AND PermAll='".$input['PermAll']."' ";
		}
		if(!empty($input['TourActionOptions']))
		{
			$filter .= " AND TourActionOptions LIKE '%".$input['TourActionOptions']."%' ";
		}
		/*if(!empty($categoryID))
		{
			$filter .= " AND TourCategories LIKE '%|$categoryID|%' ";
		}		*/
		if(!empty($tourType))
		{
			$filter .= " AND TourType='$tourType' ";
		}	
		if(!empty($tourCountry))
		{
			$filter .= " AND TourCountryID='$tourCountry' ";
		}
		if(!empty($tourRegion) && $input['viewMode'] != 'search')
		{
			$filter .= " AND  TourRegionID='$tourRegion' ";
		}
		/*if(!empty($tourStatus))
		{
			$filter .= " AND TourStatus='$tourStatus' ";
		}			
		if(!empty($tourFeaturedOption))
		{
			$filter .= " AND TourFeaturedOptions LIKE '%|$tourFeaturedOption|%' ";
		}	
		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}*/
		if($filterMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
//		echo 'fm='.$filterMode;
		if($filterMode=='promotion')
		{
			$filter .= " AND TourActionOptions LIKE '%promotion%' ";
		}
		if(!empty($SearchText))
		{
			$filter .= " AND (TourTitle LIKE '%$SearchText%' OR TourLink LIKE '%$SearchText%' OR TourReciprocalLink LIKE '%$SearchText%' OR TourIntro LIKE '%$SearchText%' OR TourContent LIKE '%$SearchText%' OR TourKeywords LIKE '%$SearchText%' OR TourAuthor LIKE '%$SearchText%' OR TourLocation LIKE '%$SearchText%')  ";
		}	
		/*if(!empty($featuredMode))
		{
			$filter .= " AND TourFeaturedOptions LIKE '%|$featuredMode|%' ";
		}		
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND PermAll='1' ";
		}	*/	
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		if($clientType!='admin')
		{
			$filter .= " AND PermAll='1' ";
		}
		if(empty($limit))
		{
			$pages = $DS->getpages('Tour',"TourID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		//$query = "SELECT * FROM Tour WHERE TourID>0 $filter ORDER BY TourPosition, TimeCreated $limit";
		//$query = "SELECT * FROM Tour ORDER BY TourPosition, TimeCreated";
		$query = "SELECT * FROM Tour WHERE TourID>0 $filter ORDER BY TourPosition, TimeCreated $limit";
		//echo $query;
		//get the content
		$result['result'] = $DS->query($query); 
		$result['pages'] = $pages['pages'];
		$SERVER->setDebug('TourClass.getTours.End','End');
		return $result;
	}	
	
	function getActiveToursFilter()
	{
		
	}
	
	function getTourFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.getTourFields.Start','Start');
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
		if(empty($entityType)) {$entityType = $input['TourType'];}
		
		$entityID = $input['Tour'.DTR.'TourID'];
		if(empty($entityID)) {$entityID = $input['TourID'];}
		
		$entityAlias = $input['Tour'];
		if(empty($entityAlias)) {$entityAlias = $input['TourAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Tour'.DTR.'TourAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$TourIDRS = $DS->query("SELECT TourID FROM Tour WHERE TourAlias='$entityAlias'");
			$entityID = $TourIDRS[0]['TourID'];
		}
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//$filter .= "OwnerID='$ownerID' ";

		$TourTypeIDRS = $DS->query("SELECT TourTypeID FROM TourType WHERE TourTypeAlias='$entityType'");
		$TourTypeID = $TourTypeIDRS[0]['TourTypeID'];
		$query = "SELECT * FROM TourTypeField LEFT JOIN TourTypeOption ON TourTypeField.TourTypeFieldID = TourTypeOption.TourTypeFieldID WHERE TourTypeField.TourType = '$entityType' $filter ORDER BY TourTypeFieldPosition, TourTypeOptionPosition"; 
		//$query = "SELECT * FROM (TourField LEFT JOIN TourTypeField ON TourField.TourTypeFieldID = TourTypeField.TourTypeFieldID) LEFT JOIN TourTypeOption ON TourTypeField.TourTypeFieldID = TourTypeOption.TourTypeFieldID WHERE TourTypeField.TourType = '$entityType' AND TourID='$entityID' $filter ORDER BY TourTypeFieldPosition, TourTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['TourTypeFieldAlias'];
				$fieldName = $row['TourTypeFieldName'];
				$fieldType = $row['TourTypeFieldType'];
				$fieldMode = $row['TourTypeFieldMode'];
				$fieldPlaces = $row['TourTypeFieldHidenPlaces'];
				$fieldOptionID = $row['TourTypeOptionID'];
				$fieldOptionAlias = $row['TourTypeOptionAlias'];
				$fieldOptionValue = $row['TourTypeOptionName'];
				
				$fieldOptionPrice = $row['TourTypeOptionPrice'];
				$fieldOptionPriceAction = $row['TourTypeOptionPriceAction'];
				$fieldOptionWeight = $row['TourTypeOptionWeight'];
				$fieldOptionWeightAction = $row['TourTypeOptionWeightAction'];
				$fieldOptionPosition = $row['TourTypeOptionPosition'];
				
				$result['TourFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['TourFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['TourFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['TourFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['TourFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['TourFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['code'] = $fieldOptionAlias;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					
					if($fieldMode=='option')
					{
						$result['TourFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;
						
						$result['TourOption'][$fieldOptionID]['TourOptionValue1'] = $fieldOptionPrice;
						$result['TourOption'][$fieldOptionID]['TourOptionValue2'] = $fieldOptionPriceAction;
						$result['TourOption'][$fieldOptionID]['TourOptionValue3'] = $fieldOptionWeight;
						$result['TourOption'][$fieldOptionID]['TourOptionValue4'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		$query = "SELECT * FROM TourField LEFT JOIN TourOption ON TourField.TourFieldID = TourOption.TourFieldID WHERE TourID='$entityID' $filter ORDER BY TourFieldPosition, TourOptionPosition"; 
		//$query = "SELECT * FROM TourField WHERE TourID='$entityID' $filter ORDER BY TourFieldPosition"; 
		$rs = $DS->query($query);
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();
			$i=0;
			foreach($rs as $row)
			{
				$fieldCode = $row['TourFieldAlias'];
				$fieldType = $row['TourFieldType'];
				
				$tourFieldID = $row['TourFieldID'];
				$fieldOptionID = $row['TourOptionID'];
				
				$fieldTypeOptionID = $row['TourTypeOptionID'];
				
				$fieldOptionStatus = $row['TourOptionStatus'];
				$fieldOptionValue1 = $row['TourOptionValue1'];
				$fieldOptionValue2 = $row['TourOptionValue2'];
				$fieldOptionValue3 = $row['TourOptionValue3'];
				$fieldOptionValue4 = $row['TourOptionValue4'];
				
				if($row['TourFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['TourFieldValueTime'];
				}
				elseif($row['TourFieldValueNumber']>0)
				{
					$fieldValue = $row['TourFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['TourFieldValue'];
				}									
				
				if(!empty($result['TourFieldTypes'][$fieldCode]['code']))
				{
					$result['TourFieldTypes'][$fieldCode]['status'] = $row['TourFieldStatus'];
				}
				$result['TourField'][0][$fieldCode] = $fieldValue;
				
				if(!empty($row['TourOptionID']))
				{
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['id'] = $row['TourOptionID'];				
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['code'] = '';
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue1;					
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['position'] = 0;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionID'] = $row['TourOptionID'];		
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionStatus'] = $fieldOptionStatus;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourTypeOptionID'] = $TourTypeOptionID;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionPosition'] = $row['TourOptionPosition'];
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionValue1'] = $fieldOptionValue1;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionValue2'] = $fieldOptionValue2;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionValue3'] = $fieldOptionValue3;
					$result['TourFieldTypes'][$fieldCode]['options'][$i]['TourOptionValue4'] = $fieldOptionValue4;
					
					$i++;
				}
			}		
		}
		//print_r($result);
		//set queries
		//echo $query;
		//get the content
		//print_r($result['TourOptionExtra']);
		$SERVER->setDebug('TourClass.getTourFields.End','End');
		return $result;
	}	
	
	function getTourFields($input)
	{
		$rs = $this->getTourFieldsStructureAndValues($input);
		
		if(is_array($rs['TourFieldTypes']))
		{
			foreach($rs['TourFieldTypes'] as $TourFieldCode=>$TourFieldType)			
			{
				if(!empty($TourFieldType['code']))
				{
					$result['TourField'][$TourFieldCode]['code']=$TourFieldType['code'];
					$result['TourField'][$TourFieldCode]['name']=$TourFieldType['name'];
					$result['TourField'][$TourFieldCode]['type']=$TourFieldType['type'];
					$result['TourField'][$TourFieldCode]['mode']=$TourFieldType['mode'];
					$result['TourField'][$TourFieldCode]['status']=$TourFieldType['status'];
					$result['TourField'][$TourFieldCode]['places']=$TourFieldType['places'];
					
					$result['TourField'][$TourFieldCode]['value']=$rs['TourField'][0][$TourFieldCode];

					if(is_array($TourFieldType['options'])) {
						foreach($TourFieldType['options'] as $id=>$tourFieldOptions) { 
							$optionsTypeID = $tourFieldOptions['id'];
							$result['TourField'][$TourFieldCode]['options'][$id]['id']=$tourFieldOptions['id'];
							$result['TourField'][$TourFieldCode]['options'][$id]['code']=$tourFieldOptions['code'];
							$result['TourField'][$TourFieldCode]['options'][$id]['value']=$tourFieldOptions['value'];
							$result['TourField'][$TourFieldCode]['options'][$id]['position']=$tourFieldOptions['position'];
							
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionID']=$tourFieldOptions['TourOptionID'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionStatus']=$tourFieldOptions['TourOptionStatus'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourTypeOptionID']=$tourFieldOptions['TourTypeOptionID'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionPosition']=$tourFieldOptions['TourOptionPosition'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionValue1']=$tourFieldOptions['TourOptionValue1'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionValue2']=$tourFieldOptions['TourOptionValue2'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionValue3']=$tourFieldOptions['TourOptionValue3'];
							$result['TourField'][$TourFieldCode]['options'][$id]['TourOptionValue4']=$tourFieldOptions['TourOptionValue4'];
						}//end of foreach($TourFieldType['options'] as $id=>$tourFieldOptions) 
					}//end of if(is_array($TourFieldType['options']))
					

				}//end of if(!empty($TourFieldType['code']) && !empty($rs['TourField'][0][$TourFieldCode]))
			}
		}
		//print_r($result);
		return $result;
	}
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTour($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.getTour.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Tour'.DTR.'TourID'];
		
		if(empty($entityID)) {$entityID = $input['TourID'];}
		
		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Tour'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Tour'.DTR.'TourAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " TourAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " TourID='$entityID' ";
			}
			$query = "SELECT * FROM Tour WHERE $filter";
//			echo $query; 
			//get the content
			$result = $DS->query($query);	
			
			
			
			$tourTypeObject = new TourTypeClass();
			$tourTemplate = $tourTypeObject->getTourTemplate($result[0]['TourType']);
			$SERVER->setInputVar('TourTemplate',$tourTemplate);
			$SERVER->setInputVar('TourType',$sectionRS[0]['TourType']);
		}		
		$SERVER->setDebug('TourClass.getTour.End','End');		
		
		return $result;		
	}
	
	function getTourField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.getTourField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourField'.DTR.'TourFieldID'];
		if(empty($entityID)) {$entityID = $input['TourFieldID'];}

		$entityAlias = $input['TourField'];
		if(empty($entityAlias)) {$entityAlias = $input['TourFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourField'.DTR.'TourFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourFieldID='$entityID' ";
		}
		$query = "SELECT * FROM TourField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('TourClass.getTourField.End','End');		
		return $result;		
	}

	function getTourRates($input)
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
		$manageMode = $input['manageMode'];
		
		$tourID = $input['TourID'];
		if(empty($tourID)) {$tourID = $input['Tour'.DTR.'TourID'];}
		if(empty($tourID)) { return false; }
		
		$query = "SELECT * FROM TourRate WHERE TourID=$tourID ORDER BY TourRateID";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		return $result;
	}		
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTour($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.setTour.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Tour'.DTR.'TourID'];
		if(empty($entityID)) {$entityID = $input['TourID'];}
		if(empty($input['Tour'.DTR.'PermAll'])) {$input['Tour'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['Tour'.DTR.'PermAll']=4;}
		if($SERVER->hasRights('admin') && $input['Tour'.DTR.'PermAll']==1 && empty($input['Tour'.DTR.'TourStatus'])) {$input['Tour'.DTR.'TourStatus']='active';}
		if(empty($input['Tour'.DTR.'TourStatus'])) {$input['Tour'.DTR.'TourStatus']='new';}
		if(empty($input['Tour'.DTR.'TourAuthor'])  && $clientType!='admin') {$input['Tour'.DTR.'TourAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['Tour'.DTR.'TourLink']) && $clientType!='admin') {$input['Tour'.DTR.'TourLink']=$user['UserLink'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries	
		//if(is_array($input['Tour'.DTR.'TourLanguages'])) {$input['Tour'.DTR.'TourLanguages'] = '|'. implode("|",$input['Tour'.DTR.'TourLanguages']).'|'; }
		//if(is_array($input['Tour'.DTR.'TourCategories'])) {$input['Tour'.DTR.'TourCategories'] = '|'. implode("|",$input['Tour'.DTR.'TourCategories']).'|'; }
			
		//if(is_array($input['Tour'.DTR.'AccessGroups'])) {$input['Tour'.DTR.'AccessGroups'] = '|'. implode("|",$input['Tour'.DTR.'AccessGroups']).'|'; }
		$where['Tour'] = "TourID = '".$entityID."'".$filter;

		if(!empty($input['Tour'.DTR.'TourAlias']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT TourAlias FROM Tour WHERE TourAlias='".$input['Tour'.DTR.'TourAlias']."'");
		}
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll, TourStatus FROM Tour WHERE TourID='".$entityID."'");
		}		
		//set visibility mode status	
		//if(!empty($input['Tour'.DTR.'TourTitle']))
		//{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['TourID'];
			$this->updateSerializedTourFields($entityID,$input['Tour'.DTR.'TourType']);
			$this->updateTourCategoryStats($entityID);
			
		//}
		//else
		//{
			if(!empty($input['Tour'.DTR.'TourAlias']))
			{
				$SERVER->setMessage('TourClass.setTour.err.AlreadyExists');
			}
		//}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('TourClass.setTour.msg.DataSaved');
		}
		//if(!empty($input['Tour'.DTR.'TourAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Tour');
		//}
		$SERVER->setDebug('TourClass.setTour.End','End');		
		return $result;		
	}
	
	function updateTourCategoryStats($tourID)
	{
		$DS = &$this->_DS;	
		if(!empty($tourID))
		{
			$catsObject = new TourCategoryClass();	
			$mode='';
			$rs = $DS->query("SELECT TourType, TourCategories, PermAll, TourStatus FROM Tour WHERE TourID='$tourID'");
			$tourCategoriesArray = explode("|",$rs[0]['TourCategories']);
			if(is_array($tourCategoriesArray))
			{
				foreach($tourCategoriesArray as $categoryID)
				{
					if(!empty($categoryID))
					{
						$countTotal = $this->getToursNumberInCategory($categoryID);
						$countType = $this->getToursNumberInCategory($categoryID,$rs[0]['TourType']);
						$catsObject->updateTourCategoryStat($categoryID,$rs[0]['TourType'],$countTotal,$countType);
					}
				}
			}
		}
	}
	
	function getToursNumberInCategory($categoryID,$tourType='')
	{
		$DS = &$this->_DS;	
		if(!empty($tourType)) {$filter = " AND TourType='$tourType' ";}
		$rs = $DS->query("SELECT COUNT(TourID) AS TourCount FROM Tour WHERE PermAll=1 AND TourStatus='active' AND TourCategories LIKE '%|$categoryID|%' $filter ");
		$result = $rs[0]['TourCount'];
		return $result;
	}
	
	function updateSerializedTourFields($tourID,$tourType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($tourID))
		{
			$input['TourID'] = $tourID;
			$input['TourType'] = $tourType;
			$rs = $this->getTourFields($input);
			$tourFields = serialize($rs);
			$tourFields = $SERVER->cleanString($tourFields,'noquotes');
			$DS->query("UPDATE Tour SET TourFields = '$tourFields' WHERE TourID='$tourID'");
		}
	}

	function setTourField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourFieldClass.setTourField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Tour'.DTR.'TourID'];
		if(empty($entityID)) {$entityID = $input['TourID'];}	
			
		$entityType = $input['TourType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['Tour'.DTR.'TourType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourFieldServer.adminTourField');
		//set queries	
			
		if(!empty($input['DeleteFieldOptionID']))
		{
			$DS->query("DELETE FROM TourOption WHERE TourOptionID = '".$input['DeleteFieldOptionID']."'");
		}

		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('TourField'.DTR,$fieldName))
			{
				//process tourfield saving
				$fieldCode = str_replace('TourField'.DTR,'',$fieldName);
				//get the field type
				//$entityType
				$fieldInfoRS = $DS->query("SELECT TourTypeFieldID, TourTypeFieldType, TourTypeFieldPosition, TourTypeFieldName, TourTypeFieldAlias, TourTypeFieldMode, TourTypeFieldMode FROM TourTypeField WHERE TourTypeFieldAlias = '$fieldCode' AND TourType='$entityType' ");
				$fieldType = $fieldInfoRS[0]['TourTypeFieldType'];
				$fieldTypeID = $fieldInfoRS[0]['TourTypeFieldID'];
				$fieldTypePosition = $fieldInfoRS[0]['TourTypeFieldPosition'];
				$fieldTypeMode = $fieldInfoRS[0]['TourTypeFieldMode'];
				$fieldTypeName = $fieldInfoRS[0]['TourTypeFieldName'];
				$fieldTypeMode = $fieldInfoRS[0]['TourTypeFieldMode'];
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
							if(!empty($itemValue))
							{
								$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
							}
						}
					}
					$fieldVale = $fieldValeResult;
				}
				//check if there is a value
				$checkRS = $DS->query("SELECT TourFieldID FROM TourField WHERE TourID='$entityID' AND TourFieldAlias='$fieldCode'");
				$tourFieldID = $checkRS[0]['TourFieldID'];

				if($fieldType=='number' || $fieldType=='money')
				{
					$valueFieldName = 'TourFieldValueNumber';
				}
				elseif($fieldType=='time' || $fieldType=='date')
				{
					$valueFieldName = 'TourFieldValueTime';
				}
				else
				{
					$valueFieldName = 'TourFieldValue';
				}

				if($fieldVale=='image' || $fieldVale=='file')
				{
					echo $uploadRS[$fieldCode]['file'];
					if(!empty($uploadRS[$fieldCode]['file']))
					{
						$fieldVale= $uploadRS[$fieldCode]['file'];
					}		
					else
					{
						$fileFieldRS = $DS->query("SELECT TourFieldValue FROM TourField WHERE TourFieldID='$tourFieldID'");
						$fieldVale=$fileFieldRS[0][$valueFieldName];
					}				
				}
				
				if($fieldVale=='deletefieldfile')
				{
					if(!empty($tourFieldID))
					{
						$FM = new FilesManager();
						//$fileField =$input['fileField'];
						$fileFieldRS = $DS->query("SELECT TourFieldValue FROM TourField WHERE TourFieldID='$tourFieldID'");
						$SERVER->setInputVar('actionMode','deletefile');
						$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
						$fieldVale='';
						$input['TourFieldStatus'][$fieldCode] = 1;
					}
				}				
				
				if($input['TourFieldStatus'][$fieldCode]!=1)
				{
					$fieldStatus = 2;
				}
				else
				{
					$fieldStatus = 1;
				}
				//echo 'TourFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';

				if(!empty($tourFieldID))
				{
					//udpate
					$query = "UPDATE TourField SET TourID='$entityID',TourFieldAlias='$fieldCode', TourTypeFieldID='$fieldTypeID',TourFieldType='$fieldType',TourFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', TourFieldStatus='$fieldStatus' WHERE TourFieldID='$tourFieldID'";
				}
				else
				{
					//insert
					$query = "INSERT INTO TourField (TourID,TourFieldAlias,TourTypeFieldID,TourFieldType,TourFieldPosition,$valueFieldName,TourFieldStatus) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
				}
				
				//echo $query.'<br>';
				$tourFieldSaveRS = $DS->query($query);
				if(empty($tourFieldID))
				{
					$tourFieldID = $tourFieldSaveRS[0]['TourFieldID'];	
				}
				//print_r($input);
				
				if($input['AddFieldOptionFieldCode']==$fieldCode && !empty($input['AddFieldOptions'][$fieldCode]))
				{
					for ($iss = 0; $iss < $input['AddFieldOptions'][$fieldCode]; $iss++) 
					{
						$inputAddOption['TourOption'.DTR.'TourTypeOptionID'] = $input['TourOption'.DTR.'TourTypeOptionID'][$ii];
						$inputAddOption['TourOption'.DTR.'TourFieldID'] = $tourFieldID;
						$inputAddOption['TourOption'.DTR.'TourOptionStatus']=2;
						$inputAddOption['actionMode']='save';
						$whereAddOption['TourOption'] = "TourOptionID = ''";
						$DS->save($inputAddOption,$whereAddOption);	
					}
				}
				//print_r($input);
				if(is_array($input['TourOption'.DTR.'TourTypeOptionID']) && $fieldTypeMode=='option')
				{
					foreach($input['TourOption'.DTR.'TourTypeOptionID'] as $i=>$TourTypeOptionID)
					{
						if($input['TourOptionFieldCode'][$i]==$fieldCode)
						{
							$inputSave='';
							$inputSave['TourOption'.DTR.'TourTypeOptionID'] = $TourTypeOptionID;
							$inputSave['TourOption'.DTR.'TourFieldID'] = $tourFieldID;
							$inputSave['TourOption'.DTR.'TourOptionID'] = $input['TourOption'.DTR.'TourOptionID'][$i];
							$inputSave['TourOption'.DTR.'TourOptionPosition'] = $input['TourOption'.DTR.'TourOptionPosition'][$i];
							$inputSave['TourOption'.DTR.'TourOptionValue1'] = $input['TourOption'.DTR.'TourOptionValue1'][$i];
							$inputSave['TourOption'.DTR.'TourOptionValue2'] = $input['TourOption'.DTR.'TourOptionValue2'][$i];
							$inputSave['TourOption'.DTR.'TourOptionValue3'] = $input['TourOption'.DTR.'TourOptionValue3'][$i];
							$inputSave['TourOption'.DTR.'TourOptionValue4'] = $input['TourOption'.DTR.'TourOptionValue4'][$i];
							
							$inputSave['TourOption'.DTR.'TourOptionStatus'] = $input['TourOption'.DTR.'TourOptionStatus'][$i];
							//echo 'ttttttt='.$tourFieldID.'<br>';
							//print_r($inputSave);
							//echo 'id='.$inputSave['TourOption'.DTR.'TourOptionID'].'===<br>';
							if($inputSave['TourOption'.DTR.'TourOptionStatus']!=1)
							{
								$inputSave['TourOption'.DTR.'TourOptionStatus']=2;
							}
							else
							{
								$inputSave['TourOption'.DTR.'TourOptionStatus']=1;
							}
							//echo 'status='.$inputSave['TourOption'.DTR.'TourOptionStatus'];
							$inputSave['actionMode']='save';
		
							$where['TourOption'] = "TourOptionID = '".$inputSave['TourOption'.DTR.'TourOptionID']."'";
							$DS->save($inputSave,$where);	
						}
					}
				}				
			}
		}
		//if(!empty($input['TourField'.DTR.'TourFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'TourField',$input['TourField'.DTR.'TourID'],'Tour');
		//}		
		$SERVER->setDebug('TourFieldClass.setTourField.End','End');		
		return $result;		
	}


	function setTourRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourFieldClass.setTourField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Tour'.DTR.'TourID'];
		if(empty($entityID)) {$entityID = $input['TourID'];}	
		//print_r($input);
		if(empty($entityID)) {return false;}
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourFieldServer.adminTourField');
		//set queries	
		if(is_array($input['TourRate'.DTR.'TourID']))
		{
			foreach($input['TourRate'.DTR.'TourID'] as $i=>$rateID)
			{
				$inputSave='';
				$inputSave['TourRate'.DTR.'TourRateID'] = $input['TourRate'.DTR.'TourRateID'][$i];
				$inputSave['TourRate'.DTR.'TourID'] = $input['TourRate'.DTR.'TourID'][$i];
				$inputSave['TourRate'.DTR.'ServiceType'] = $input['TourRate'.DTR.'ServiceType'][$i];
				$inputSave['TourRate'.DTR.'RoomType'] = $input['TourRate'.DTR.'RoomType'][$i];
				$inputSave['TourRate'.DTR.'SeasonType'] = $input['TourRate'.DTR.'SeasonType'][$i];
				$inputSave['TourRate'.DTR.'TourRatePrice'] = $input['TourRate'.DTR.'TourRatePrice'][$i];
				$inputSave['TourRate'.DTR.'TourRatePricePerPerson'] = $input['TourRate'.DTR.'TourRatePricePerPerson'][$i];
				$inputSave['TourRate'.DTR.'TourRateMinimumNights'] = $input['TourRate'.DTR.'TourRateMinimumNights'][$i];
				$inputSave['TourRate'.DTR.'TourRateComments'] = $input['TourRate'.DTR.'TourRateComments'][$i];
				if(empty($inputSave['TourRate'.DTR.'TourRatePrice'])) {$inputSave['TourRate'.DTR.'TourRatePrice']=' ';}
				
				$seasonTypeForActivation = $inputSave['TourRate'.DTR.'SeasonType'];
				$roomTypeForActivation = $inputSave['TourRate'.DTR.'RoomType'];
				if($input['TourRateActivation'][$seasonTypeForActivation.DTR.$roomTypeForActivation]!=1)
				{
					$inputSave['TourRate'.DTR.'PermAll']=4;
				}
				else
				{
					$inputSave['TourRate'.DTR.'PermAll']=1;
				}
				if(!empty($inputSave['TourRate'.DTR.'TourID']) && !empty($inputSave['TourRate'.DTR.'SeasonType']))
				{
					$inputSave['actionMode']='save';
					$where['TourRate'] = "TourRateID = '".$inputSave['TourRate'.DTR.'TourRateID']."'";
					$DS->save($inputSave,$where);	
				}
			}
		}
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTour($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.deleteTour.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Tour'.DTR.'TourID'];
		//if(empty($entityID)) {$entityID = $input['TourID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		
		//print_r($input);
		//echo 'eeee='.$entityID;
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT TourFieldID FROM TourField WHERE TourID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['TourFieldID'];
			$DS->query("DELETE FROM Tour WHERE TourID='$entityID'");
			$DS->query("DELETE FROM TourField WHERE TourID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM TourOption WHERE TourFieldID='$typeFieldID'");
			}
		}
		//$SERVER->setMessage('TourClass.deleteTour.msg.DataDeleted');
		$SERVER->setDebug('TourClass.deleteTour.End','End');		
		return $result;		
	}	
	
	function deleteTourField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourClass.deleteTourField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourField'.DTR.'TourFieldID'];
		//if(empty($entityID)) {$entityID = $input['TourID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourField WHERE TourID='$entityID'");
			$DS->query("DELETE FROM TourOption WHERE TourFieldID='$entityID'");
		}
		$SERVER->setMessage('TourClass.deleteTourField.msg.DataDeleted');
		$SERVER->setDebug('TourClass.deleteTourField.End','End');		
		return $result;		
	}	
	
	function copyTour($input)
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
		$TourTemplateID = $input['selectedTourID'];
		$TourID = $input['TourID'];
		if($TourID==$TourTemplateID) {return false;}
		//set client side variables
		if(!empty($TourTemplateID) && !empty($TourID))
		{
			//make Tour link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM TourField WHERE TourID='$TourTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['TourField'] = "TourFieldID = ''";
			$inputNew['TourField'.DTR.'TourFieldID']='';
			$inputNew['TourField'.DTR.'OwnerID']=$ownerID;
			$inputNew['TourField'.DTR.'UserID']=$userID;
			$inputNew['TourField'.DTR.'TourID']=$TourID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['TourField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['TourField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['TourField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM TourField WHERE BoxID='".$inputNew['TourField'.DTR.'BoxID']."' AND TourID='".$TourID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Tour
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
	
	function setTourRateUsers($input)
	{
		function getValRate($str)
		{
			if($str=='best'){return 6;}
			elseif($str=='verygod'){return 5;}
			elseif($str=='good'){return 4;}
			elseif($str=='acceptable'){return 3;}
			elseif($str=='notgood'){return 2;}
			elseif($str=='verybad'){return 1;}
		}//function fetValRate($str)
		$DS = &$this->_DS;
		$TourID = $input['TourID'];
		$Rate = $input['Rate'];
		$RateVal = getValRate($Rate);
		$user = $this->_user;
		$userID = $user['UserID'];
		$query = 'select * from TourRateUsers where TourRateTourID="'.$TourID.'" and TourRateUserID="'.$userID.'"';
		$res=$DS->query($query);
		$result = '';
		if (count($res)<1)
		{
			$query = 'insert into TourRateUsers(TourRateUserID,TourRateUsersValue,TourRateTourID)values(\''.$userID.'\',\''.$RateVal.'\',\''.$TourID.'\')';
//			echo 'q='.$query.'///';
			$res = $DS->query($query);
			$query = 'select * from Tour where TourID='.$TourID;
			$res = $DS->query($query);
			$oldRate = $res[0]['TourRateValue'];
			$oldCount = $res[0]['TourRateCount'];
			$oldSum = $oldRate*$oldCount;
			$newCount = $oldCount+1;
			$newSum = $oldSum+$RateVal;
			$newRate = bcdiv($newSum,$newCount,3);
			$query = 'update Tour set TourRateValue=\''.$newRate.'\',TourRateCount=\''.$newCount.'\'';
//			echo $query;
			$DS->query($query);
			$result = $newRate;
		}
		return $result;
//		echo 'UserID='.$userID;
//		$UserID = $inpu
	}//function setTourRateUsers()
	
	function getTourRateUsers($input)
	{
		function codeToStr($cod)
		{
//			echo '/cod='.$cod;
			if($cod==6){return 'best';}
			elseif($cod==5){$result = 'verygod';}
			elseif($cod==4){$result = 'good';}
			elseif($cod==3){$result = 'acceptable';}
			elseif($cod==2){$result = 'notgood';}
			elseif($cod==1){$result = 'verybad';}
			else{$result = 'Error';}
			return $result;
		}//function codeToStr($cod)
		$DS = &$this->_DS;
		$TourID = $input['TourID'];
		$query = 'select * from Tour where TourID='.$TourID;
		$result = $DS->query($query);
		$result=$result[0];
		if(count($result)>0)
		{
			$srRes = bcdiv($result['TourRateValue'],1,0);
//			echo $srRes;
			$result['TourRateCode']=codeToStr($srRes);
//			echo '/TourRateCode='.$result['TourRateCode='];
		}
		return $result;
	}//function getTourRate($input)
	

} // end of TourServer
?>