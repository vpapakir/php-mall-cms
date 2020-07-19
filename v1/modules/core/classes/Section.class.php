<?php
class SectionClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	var $_settings;
	var $_currentLevel;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function SectionClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$this->_currentLevel = 1;	
	}
	// PUBLIC METHODS
    /**
    * gets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getSections($input)
	{
		//get global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$manageMode = $input['manageMode'];
		$searchWord = $input['searchWord'];
		$orderMode = $input['orderMode'];
		$orderField = $input['orderField'];
				
		$entityID = $input['Section'.DTR.'SectionParentID'];
		if(empty($entityID)) {$entityID = $input['SectionParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		if(empty($entityID)) {$entityID = $input['Section'];}
		$entityAlias = $input['Section'.DTR.'SectionAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['SectionAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['section'];}
		$entityType = $input['Section'.DTR.'SectionType'];
		if(empty($entityType)) {$entityType = $input['SectionType'];}	
		//set filters
		//$filter = $DS->getAccessFilter($input,'SectionServer.adminSection');
		
		if(empty($entityID) && !empty($entityAlias))
		{
			$parentRS = $DS->query("SELECT SectionID AS \"SectionID\", SectionParentID AS \"SectionParentID\" FROM Section WHERE SectionAlias='$entityAlias'");
			$entityID = $parentRS[0]['SectionID'];
		}
		
		$filter .= " AND OwnerID = '$ownerID'";
		if(!empty($searchWord))
		{
			//$filter .= " AND (SectionAlias LIKE '%$searchWord%' OR SectionName LIKE '%$searchWord%' OR SectionContent LIKE '%$searchWord%' OR SectionIntroContent  LIKE '%$searchWord%' OR SectionTitle LIKE '%$searchWord%')";
			$filter .= " AND (SectionAlias LIKE '%$searchWord%' OR SectionName LIKE '%$searchWord%' OR SectionIntroContent  LIKE '%$searchWord%' OR SectionTitle LIKE '%$searchWord%')";
		}
		if(!empty($input['SectionGroupID']))
		{
			$filter .= " AND SectionGroupID='".$input['SectionGroupID']."' ";
		}
		if(!empty($entityAlias))
		{
			//$filter .= " AND SectionAlias='$entityAlias' ";
		}
		if(!empty($entityType))
		{
			$filter .= " AND SectionTypeID='$entityType' ";
		}
		
		if($clientType=='front')
		{
			$filter .= " AND PermAll='1'";
            //if(eregi("\|showInSearch\|",$config['PageViewOptions'])) 
            //{
                $filter .= " AND SectionShowInSearch='Y'";
            //}
		}

		//set queries
		if(!empty($entityID))
		{
			if(!empty($searchWord))
			{
				$parentFilter = " SectionID>0 ";
			}
			else
			{
				$parentFilter = " SectionParentID='$entityID' ";
			}		
			$query = "SELECT * FROM Section WHERE $parentFilter $filter ORDER BY SectionPosition"; 
		}
		else
		{
			if(!empty($searchWord))
			{
				$parentFilter = " SectionID>0 ";
				if(stristr($config['OwnerManagedElements'],"|sitemap|"))
				{
					$parentFilter .= " AND OwnerID='$ownerID' ";
				}
			}
			else
			{
				$parentFilter = " SectionParentID='top' ";
			}
			
			$query = "SELECT * FROM Section WHERE $parentFilter $filter ORDER BY SectionPosition"; 
		}		
		//get the content
		//echo $query;
		//$mode['Transformation']['Class']['Section'] = 'Section';
		//print_r($mode['Transformation']['Class']['Section']);
		//$mode['Transformation']['Field']['Section'.DTR.'SectionID']='getSubsections';
		//$mode['Transformation']['ResultType']['Section'.DTR.'SectionID']='root';
		//$mode['pagesMode']=$itemsPerPage;
		$result = $DS->query($query); 
		//print_r($result);
		$out['DB'] = $result;
		$SERVER->setDebug('SectionServer.getSections.End','End');
		return $result;
	}
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getSection($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.getSection.Start','Start');
		$DS = &$this->_DS;
		//print_r($input);
		$config = $this->_config;
		$user = $this->_user;
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Section'.DTR.'SectionID'];
		if(empty($entityID)) {$entityID = $input['Section'];}
		$entityAlias = $input['Section'.DTR.'SectionAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['SectionAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['section'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'SectionServer.adminSection');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			//$query = "Section[SectionID='$entityID' $filter]/";
			$query = "SELECT * FROM Section WHERE SectionID='$entityID' ";  
		}
		elseif(!empty($entityAlias))
		{
			//$query = "Section[SectionAlias='$entityAlias' $filter]/"; 
			$query = "SELECT * FROM Section WHERE SectionAlias='$entityAlias' "; 
		}
		//get the content
		//echo $query;
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			//$SERVER->setMessage('SectionServer.getSection.err.NoSectionID');
		}
		$SERVER->setDebug('SectionServer.getSection.End','End');		
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setSection($input)
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
		//set client side variables
		
		//$cacheInput['Module'] = 'core';
		//$cacheInput['Class'] = 'SectionServer';
		//$cacheInput['Method'] = 'getSectionsTree';
		//$Cache = new CacheServer(&$SERVER,&$DS);
		//$cacheRS = $Cache->deleteCache($cacheInput);
	
		$where['Section'] = "SectionID='".$input['Section'.DTR.'SectionID'] ."'";
		//print_r($input);
		if(empty($input['Section'.DTR.'SectionAlias']) && !empty($input['Section'.DTR.'SectionName']))
		{
			if(empty($input['Section'.DTR.'SectionID']))
			{
				$typeObject = new AliasDataType($SERVER);
				$langSectionTitle = $input['Section'.DTR.'SectionName']['en'];
				$currentLang = $config['lang'];
				if(empty($langSectionTitle))
				{
					$langSectionTitle = $input['Section'.DTR.'SectionName'][$currentLang];
				}
				if(empty($langSectionTitle)) { $lang = $config['lang']; $langSectionTitle = $input['Section'.DTR.'SectionName'][$lang];}
				$input['Section'.DTR.'SectionAlias'] = $typeObject->setDataType($langSectionTitle);
			}
		}	
		
		$oldRS=$DS->query("SELECT SectionAlias FROM Section WHERE SectionID='".$input['Section'.DTR.'SectionID']."'");
		if($oldRS[0]['SectionAlias']=='home' || $oldRS[0]['SectionAlias']=='loginform')
		{
			$input['Section'.DTR.'SectionAlias'] = $oldRS[0]['SectionAlias'];
		}
		
		if(!empty($input['Section'.DTR.'SectionAlias']))
		{
			if(stristr($config['OwnerManagedElements'],"|sitemap|")) {$ownerFilter = " AND OwnerID='$ownerID'";}
			$checkRS=$DS->query("SELECT SectionAlias FROM Section WHERE SectionAlias='".$input['Section'.DTR.'SectionAlias']."'".$ownerFilter);
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['Section'.DTR.'SectionAlias'] = $input['Section'.DTR.'SectionAlias'].date('Ymd-His');
				$SERVER->setMessage('Section.SectionClass.setSection.err.DuplicatedSection');
			}				
		}
        
        if(is_array($input['Section'.DTR.'SectionViewOptions'])){
            if(in_array("showInSearch",$input['Section'.DTR.'SectionViewOptions'])) 
            {
                    $input['Section'.DTR.'SectionShowInSearch'] = 'Y';
                    //echo '111';
            }
            else
            {
                $input['Section'.DTR.'SectionShowInSearch'] = 'N';
            }
        }
		
		$input['actionMode']='save';		
		if($input['Section'.DTR.'SectionParentID']=='top') {$input['Section'.DTR.'SectionParentID']=0;}
		$saveResult = $DS->save($input,$where);
		$entityID = $saveResult[0]['SectionID'];
		$input['Section'.DTR.'SectionID'] = $entityID;
		$this->updateSectionsPositions($input['Section'.DTR.'SectionID']);
			
		return $entityID;		
	}
		
	function updateSectionsPositions($sectionID)
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
		//$entityType = $input['Section'.DTR.'SectionType'];
		if(empty($entityType)) {$entityType = $input['SectionGroup'];}	
		if(empty($entityType)) {$entityType = $input['GroupID'];}			
		//set client side variables
		if(empty($sectionID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT SectionParentID AS \"SectionParentID\", SectionGroupID AS \"SectionGroupID\" FROM Section WHERE SectionID='$sectionID'");
		$sectionParentID = $checkRS[0]['SectionParentID'];
		if(empty($entityType)) {$entityType = $checkRS[0]['SectionGroupID'];}
		
		//if(!empty($sectionParentID))
		//{	
			if($sectionParentID==0 && !empty($entityType))
			{
				$filterType = " AND SectionGroupID='$entityType'";
			}
			$query = "SELECT SectionName, SectionID AS \"SectionID\" FROM Section  WHERE SectionParentID='$sectionParentID' $filterType ORDER BY SectionPosition ASC";			
			//echo $query ;
			$rs = $DS->query($query);
			$i=2;
			foreach($rs as $row)
			{
				$DS->query("UPDATE Section SET SectionPosition='$i' WHERE SectionID='".$row['SectionID']."'");
				$i = $i+2;
			}
		//}
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteSection($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.deleteSection.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Section'.DTR.'SectionID'];
		if(empty($entityID)) {$entityID = $input['SectionID'];}		
		
		$cacheInput['Module'] = 'core';
		$cacheInput['Class'] = 'SectionServer';
		$cacheInput['Method'] = 'getSectionsTree';
		$Cache = new CacheServer(&$SERVER,&$DS);
		$cacheRS = $Cache->deleteCache($cacheInput);		
		//set filters
		$filter = $DS->getAccessFilter($input,'SectionServer.adminSection');
		//set queries
		$input['actionMode']='delete';
		$where['Section'] = "SectionID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('SectionServer.deleteSection.msg.DataDeleted');
		$SERVER->setDebug('SectionServer.deleteSection.End','End');		
		return $result;		
	}	
	
	function getParentSections($input) {
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['Section'.DTR.'SectionID'])) 
		{
			$entityID = $input['Section'.DTR.'SectionID'];
		}
		if(empty($entityID)) {$entityID = $input['section'];}
		if(empty($entityID)) {$entityID = $input['Section'];}
		if(empty($entityID)) {$entityID = $input['SectionParentID'];}
		if(empty($entityID)) {$entityID = $input['SectionID'];}
		if(!empty($entityID))
		{
			$query = "SELECT SectionID AS \"SectionID\", SectionAlias AS \"SectionAlias\", SectionParentID AS \"SectionParentID\", SectionName AS \"SectionName\" FROM Section WHERE (SectionID='$entityID' OR SectionAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getLanguageFieldValue($current['sql'][0]['SectionName']);
			$currentCategoryID = $current['sql'][0]['SectionID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current['sql'][0]['SectionAlias'];
				if(empty($refEntityID)) {$refEntityID = $current['sql'][0]['SectionID'];}
				$SERVER->setRefItem('ParentSections',$refEntityID,$categoryName);					
			}
			$categoryParentID = $current['sql'][0]['SectionParentID'];
			//echo 'entid='.$entityID.'<br/>';			
			if(!empty($categoryParentID) && $categoryParentID!='top')
			{
				$in['Section'.DTR.'SectionID'] = $categoryParentID;
				$this->getParentSections($in);
			}
			else
			{
				$SERVER->reverseRef('ParentSections');
				return '';
			}
		}
	}	
	
	function getSectionsTree($input)
	{
		//get global variables
		global $sectionsTree, $treeIndex;
		
		$sectionsTree = ''; $treeIndex='';		
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$settings = $this->_settings;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$this->_currentLevel = 1;
		//set client side variables
		$manageMode = $input['manageMode'];
		$searchWord = $input['searchWord'];
		$orderMode  = $input['orderMode'];
		$orderField = $input['orderField'];
		$spacesMode = $input['spacesMode'];
		$remoteMode = $input['remoteMode'];
		$windowMode = $input['windowMode'];
		if($remoteMode=='Y')
		{
			if($windowMode!='remote')
			{
				return '';
			}
		}
		$entityID = $input['Section'.DTR.'SectionParentID'];
		if(empty($entityID)) {$entityID = $input['SectionParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		
		$entityAlias = $input['Section'.DTR.'SectionAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['SectionAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['section'];}
		if(empty($entityAlias)) {$entityAlias = $input['SID'];}		
		$entityType = $input['Section'.DTR.'SectionGroup'];
		if(empty($entityType)) {$entityType = $input['SectionGroup'];}	
		
		$sectionType = $input['SectionType'];
		
		//print_r($input);
		//echo 'SectionGroup-'.$entityType;
		$entityTypeAlias = $input['SectionGroupCode'];
		if(empty($entityType) && !empty($entityTypeAlias))
		{
			$entityTypeIDRS = $DS->query("SELECT SectionGroupID, SectionGroupType, SectionGroupViewOptions FROM SectionGroup WHERE SectionGroupCode='$entityTypeAlias'");
			$entityType = $entityTypeIDRS[0]['SectionGroupID'];
			$sectionGroupType = $entityTypeIDRS[0]['SectionGroupType'];
			$sectionGroupViewOptions = $entityTypeIDRS[0]['SectionGroupViewOptions'];
			$this->_sectionGroupCode = $entityTypeAlias;
		}
		
		if(stristr($config['OwnerManagedElements'],"|sitemap|"))
		{
			$settings['FilterSitemapForOwner'] = 'N';
			if(empty($sectionGroupType))
			{
				$sectionGroupTypeRS = $DS->query("SELECT SectionGroupType, SectionGroupViewOptions FROM SectionGroup WHERE SectionGroupCode='$entityTypeAlias' OR SectionGroupID='$entityType'");
				$sectionGroupType = $sectionGroupTypeRS[0]['SectionGroupType'];
				$sectionGroupViewOptions = $sectionGroupTypeRS[0]['SectionGroupViewOptions'];
			}
			if($sectionGroupType=='menu' && !stristr($sectionGroupViewOptions,"|allowners|"))
			{
				$settings['FilterSitemapForOwner'] = 'Y';
			}
			$this->_settings = $settings;
		}

		//set filters
		$upLevels = $input['upLevels'];
		$downLevels = $input['downLevels'];
		$startLevel = $input['startLevel'];
		$endLevel = $input['endLevel'];		
		$treeType = $input['treeType'];// =all - show all requested levels at once , =current - show requested levels only for current id: this is default
		
		//$treeType = 'expanded';
		//echo 'tttree='.$treeType.' group='.$entityType;
		$this->_upLevels = $upLevels;
		$this->_downLevels = $downLevels;
		$this->_startLevel = $startLevel;
		$this->_endLevel = $endLevel;		
		$this->_treeType = $treeType;
		//start get cache
		/*
		$cacheInput['Module'] = 'core';
		$cacheInput['Class'] = 'SectionServer';
		$cacheInput['Method'] = 'getSectionsTree';
		$cacheInput['Arguments'] = $entityType.'-'.$treeType.'-'.$downLevels.'-'.$startLevel.'-'.$endLevel;
		$Cache = new CacheServer(&$SERVER,&$DS);
		$cacheRS = $Cache->getCache($cacheInput);
		$cacheValue = $cacheRS['sql'][0]['Cache'.DTR.'Value'];
		
		//die ('$cacheValue='.$cacheValue);
		if(!empty($cacheValue)) {$retval['xml']=$cacheValue; return $retval;}
		//end get cache
		*/
		if(empty($entityID))
		{
			if(!empty($entityAlias))
			{   
                //echo "SELECT SectionID AS \"SectionID\", SectionParentID AS \"SectionParentID\" FROM Section WHERE SectionAlias='$entityAlias'";
				$parentRS = $DS->query("SELECT SectionID AS \"SectionID\", SectionParentID AS \"SectionParentID\" FROM Section WHERE SectionAlias='$entityAlias'");
				$entityID = $parentRS['sql'][0]['SectionID'];
				//$entityParentID = $parentRS['sql'][0]['SectionParentID'];
			}
		}
		if($treeType=='all')
		{
            //echo '111111';
			$entityID ='';
			$entityAlias='';
			$result = $this->getDownSectionsRecursive($entityID,$entityType,$path,$input); 
		}
		elseif($treeType=='expanded')
		{
            //echo '22222222';
			$entityID ='';
			$entityAlias='';
			$this->_downLevels=1;
			$path = $this->getSectionsPath($input);
			$result = $this->getDownSectionsRecursive($entityID,$entityType,$path,$input);
            //print_r($result);
		}		
		elseif(!empty($startLevel))
		{
            //echo '333333333333';
			$this->getStartLevelEntityID($entityID);
			$levels = $this->_levels;
			if(is_array($levels))
			{
				$levels = array_reverse($levels);
				$levelInArray = $startLevel-2;
				$entityID = $levels[$levelInArray];
			}	
			//echo 'entityID='.$entityID.'<br/>';
			if(!empty($entityID))		
			{
				$result = $this->getDownSectionsRecursive($entityID,$entityType,'',$input);
			}
		}
		else
		{
            //echo '4444444444';
			if(!empty($entityID))
			{
				$result = $this->getDownSectionsRecursive($entityID,$entityType,'',$input);
			}
		}
		//end set cache
		//$cacheInput['Value']=$result;
		//$Cache->setCache($cacheInput);
		//end set cache		
		//print_r($sectionsTree);		
		return $sectionsTree;
	}		
	
	function getStartLevelEntityID($entityID)
	{
		$DS = &$this->_DS;
		$levels = $this->_levels;
		if(!empty($entityID))
		{
			$query = "SELECT SectionID AS \"SectionID\", SectionParentID AS \"SectionParentID\" FROM Section WHERE SectionID='$entityID'";
			$current = $DS->query($query);
			$currentSectionID = $current[0]['SectionID'];
			$currentParentSectionID = $current[0]['SectionParentID'];
			$levels[]=$currentSectionID;
			$this->_levels = $levels;
			if(!empty($currentParentSectionID) && $currentParentSectionID!='top')
			{
				$this->getStartLevelEntityID($currentParentSectionID);				
			}
		}	
	}
	
	function getDownSectionsRecursive($entityID,$entityType,$path='',$input='')
	{
		global $sectionsTree, $treeIndex;
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$settings = $this->_settings;
				
		$user = $this->_user;
		$userID = $user['UserID'];
		$upLevels=$this->_upLevels;
		$downLevels=$this->_downLevels;
		$treeType=$this->_treeType;
		$currentLevel = $this->_currentLevel;
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		
		$sectionType = $input['SectionType'];
		$sectionViewType = $input['SectionViewType'];
		if(empty($treeIndex)) $treeIndex=0;

		if(!empty($sectionType))		
		{
			$filter .= " AND SectionType='$sectionType' ";
		}
		if(!empty($sectionViewType))		
		{
			$filter .= " AND SectionViewType='$sectionViewType' ";
		}
						
		if(!empty($entityType))		
		{
			$filter .= " AND SectionGroupID='$entityType' ";
		}
		if(empty($entityID) && empty($entityAlias))
		{
			$entityID='';
		}
		if($clientType!='admin' || $this->_sectionGroupCode=='adminmenu')
		{
			$filter .= $DS->getAccessFilter($input,'',array('mode'=>'groups'));
			//$filter .= " AND PermAll=1 AND (AccessGroups LIKE '%|all|%' OR AccessGroups LIKE '%|".$user['GroupID']."|%' OR AccessGroups='') ";
		}
		if($settings['FilterSitemapForOwner']=='Y') {
			$filter .= " AND OwnerID='$ownerID'";
		}
		//$filter .= " AND OwnerID='$ownerID' ";
		if(empty($entityID)) {$entityID=0;}
		$query = "SELECT * FROM Section WHERE SectionParentID='$entityID' $filter ORDER BY SectionPosition ";	
		$rs = $DS->query($query);
		//echo $query.' $treeType = '.$treeType.'<hr>';
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$sectionsTree[$treeIndex] = $row;
				$sectionsTree[$treeIndex]['SectionLevel'] = $currentLevel;
				//echo 'name: '.getValue($row['SectionName']).' index='.$treeIndex.' level='.$currentLevel.'<hr>';
				$query = "SELECT * FROM Section WHERE SectionParentID='".$row['SectionID']."'";	
				$IsLastRS = $DS->query($query);
				if(is_array($IsLastRS)) 
					$sectionsTree[$treeIndex]['IsLast'] = 1;
				else
					$sectionsTree[$treeIndex]['IsLast'] = 0;
					
				$treeIndex++;
				if($treeType=='expanded')
				{
					if(is_array($path))
					{
						$entityID = $row['SectionID'];
						$expandMode = 'N';
						foreach($path as $levelValues)
						{
							$selectedID = $levelValues['id'];
							if($selectedID == $entityID) {$expandMode = 'Y';}
						}
						//$currentLevelI = $currentLevel-1;
						//echo 'currentLevel='.$currentLevel.' selectedID = '.$selectedID.' entityID='.$entityID.'<hr>';
						if($expandMode == 'Y')
						{
							$sectionsTree[$treeIndex-1]['SectionIsExpanded'] = 'expanded';
							$this->_currentLevel = $currentLevel+1;
							$this->getDownSectionsRecursive($entityID,$entityType,$path,$input);
						}
					}
				}				
				if($downLevels=='all' || $currentLevel<$downLevels)
				{
					$this->_currentLevel = $currentLevel+1;
					$entityID = $row['SectionID'];
					$this->getDownSectionsRecursive($entityID,$entityType,$path,$input);
				}
				
			}
		}
		else
		{
			if($entityParentID!= 'top' && $entityID !='top')
			{
				//get current level sections if it was clicked an item in current level
				//$result .= $this->getDownSectionsRecursive($entityParentID,$entityAlias,$entityType);
			}
		}
				
		return $result;
	}

	function getSectionsPath($input)
	{
		global $parentSections;
		//set global variables
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['Section'.DTR.'SectionID'])) 
		{
			$entityID = $input['Section'.DTR.'SectionID'];
		}
		
		if(empty($entityID)) {$entityID = $input['resourceSection'];}
		if(empty($entityID)) {$entityID = $input['Section'];}
		if(empty($entityID)) {$entityID = $input['SectionParentID'];}
		if(empty($entityID)) {$entityID = $input['SectionID'];}
		if(empty($entityID)) {$entityID = $input['section'];}
		if(empty($entityID)) {$entityID = $input['SID'];}
		
		$prev_parent = $input['parent'];
		if(!empty($entityID))
		{
			$query = "SELECT SectionID AS \"SectionID\", SectionAlias AS \"SectionAlias\", SectionParentID AS \"SectionParentID\", SectionTitle AS \"SectionTitle\" FROM Section WHERE (SectionID='$entityID' OR SectionAlias='$entityID')";
            //echo $query.'<hr>';
			$current = $DS->query($query);
			//print_r($current);
			$sectionName = $SERVER->getValue($current[0]['SectionTitle']);
			$currentSectionID = $current[0]['SectionID'];
			if(!empty($currentSectionID))
			{
				$refEntityID = $current[0]['SectionAlias'];
				if(empty($refEntityID)) {$refEntityID = $current[0]['SectionID'];}
				$parentSections[$refEntityID] = $sectionName;
			}

			$parent[$entityID]['id'] = $currentSectionID;
			$parent[$entityID]['value'] = $sectionName;
			$in['parent']= arrayMerge ($prev_parent,$parent);
			$sectionParentID = $current[0]['SectionParentID'];
			if(!empty($sectionParentID))
			{
				$in['Section'.DTR.'SectionID'] = $sectionParentID;
				$newParent = $this->getSectionsPath($in,$mode);
			}
			else
			{
				if(is_array($parentSections))
				{
					$parentSections = array_reverse($parentSections);
				}
				$result= arrayMerge ($in['parent'],$newParent);
				return $result;
			}
			$result= arrayMerge ($in['parent'],$newParent);
			return $result;
		}
		return $result;		
	}
	
	function getSubsectionsListQuery($categoryID)
	{
		global $sectionsTree, $treeIndex;
		
		$sectionsTree = ''; $treeIndex='';
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$this->_currentLevel = 1;
		//set client side variables
		$entityID = $categoryID;
				
		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['SectionAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['Section'.DTR.'SectionAlias'];}
		$entityType = $input['Section'.DTR.'SectionGroup'];
		
		if(empty($entityType)) {$entityType = $input['SectionGroup'];}	
		
		//set filters
		$upLevels = 0;
		$downLevels = 'all';
		$startLevel = 0;
		$endLevel = 0;		
		$treeType = 'all';// =all - show all requested levels at once , =current - show requested levels only for current id: this is default
		//$treeType='expanded';
		$this->_upLevels = $upLevels;
		$this->_downLevels = $downLevels;
		$this->_startLevel = $startLevel;
		$this->_endLevel = $endLevel;		
		$this->_treeType = $treeType;
		//start get cache
		/*
		$cacheInput['Module'] = 'core';
		$cacheInput['Class'] = 'SectionServer';
		$cacheInput['Method'] = 'getSectionsTree';
		$cacheInput['Arguments'] = $entityType.'-'.$treeType.'-'.$downLevels.'-'.$startLevel.'-'.$endLevel;
		$Cache = new CacheServer(&$SERVER,&$DS);
		$cacheRS = $Cache->getCache($cacheInput);
		$cacheValue = $cacheRS['sql'][0]['Cache'.DTR.'Value'];
		
		//die ('$cacheValue='.$cacheValue);
		if(!empty($cacheValue)) {$retval['xml']=$cacheValue; return $retval;}
		//end get cache
		*/
		
		if(empty($entityID))
		{
			if(!empty($entityAlias))
			{
				$parentRS = $DS->query("SELECT SectionID AS \"SectionID\", SectionParentID AS \"SectionParentID\" FROM Section WHERE SectionAlias='$entityAlias'");
				$entityID = $parentRS[0]['SectionID'];
				//$entityParentID = $parentRS['sql'][0]['SectionParentID'];
			}
		}
		
		if(!empty($entityID))
		{
			$entityAlias='';
			$result = $this->getDownSectionsRecursive($entityID,$entityType,0);
		}
		
		if(is_array($sectionsTree))
		{
			$i=0;
			foreach ($sectionsTree as $row)
			{
				if($config['ResourceCategoriesMode']=='one')
				{
					$filter = " = '|".$row['SectionID']."|' ";
				}
				else
				{
					$filter = " LIKE '%|".$row['SectionID']."|%' ";
				}
				if($i==0)
				{
					$result = " ResourceCategories $filter ";
				}
				else
				{
					$result .= " OR ResourceCategories $filter ";
				}
				$i++;
			}
		}
		//echo $result;
		return $result;	
	}	
	
	function setIndexPage($input)
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
		//set client side variables
		$input['Content'] = stripslashes($input['Content']);
		$decode = html_entity_decode($input['Content']);
		$Content = $decode;
		
		if(!$handle = fopen("../index.html",'w'))
		{
			echo "Cannot open to file";
			exit;
		}
		
		$input['Content'] = stripslashes($input['Content']);
		//$decode = html_entity_decode($input['Content'], ENT_QUOTES);
		$decode = str_replace('&quot;','"',$input['Content']);
		$Content = $decode;
		
		$Meta = stripslashes($input['Meta']);
		
		$Content = "<html><head>".$Meta."</head><body>".$Content."</body></html>";
		
		if(fwrite($handle,$Content)===FALSE)
		{
			echo "Cannot write to file";
			exit;
		}
			else
			{ 
				//echo "write to file";
			}
		
		fclose($handle);
	}
} // end of SectionServer
?>