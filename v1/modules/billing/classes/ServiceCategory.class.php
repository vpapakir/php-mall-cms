<?php
class ServiceCategoryClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	var $_currentLevel;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function ServiceCategoryClass()
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

	function updateServiceCategoriesPositions($sectionID)
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
		$entityType = $input['ServiceCategory'.DTR.'ServiceCategoryType'];
		if(empty($entityType)) {$entityType = $input['ServiceCategoryGroup'];}	
		if(empty($entityType)) {$entityType = $input['GroupID'];}			
		//set client side variables
		if(empty($sectionID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT ServiceCategoryParentID AS \"ServiceCategoryParentID\" FROM ServiceCategory WHERE ServiceCategoryID='$sectionID'");
		$sectionParentID = $checkRS[0]['ServiceCategoryParentID'];
		
		//if(!empty($sectionParentID))
		//{	
			if($sectionParentID=='top' && !empty($entityType))
			{
				$filterType = " AND ServiceCategoryGroupID='$entityType'";
			}
			$query = "SELECT ServiceCategoryTitle, ServiceCategoryID AS \"ServiceCategoryID\" FROM ServiceCategory  WHERE ServiceCategoryParentID='$sectionParentID' $filterType ORDER BY ServiceCategoryPosition ASC";			
			$rs = $DS->query($query);
			$i=2;
			foreach($rs as $row)
			{
				$DS->query("UPDATE ServiceCategory SET ServiceCategoryPosition='$i' WHERE ServiceCategoryID='".$row['ServiceCategoryID']."'");
				$i = $i+2;
			}
		//}
		return $result;		
	}	
	
	function getParentServiceCategories($input) {
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['ServiceCategory'.DTR.'ServiceCategoryID'])) 
		{
			$entityID = $input['ServiceCategory'.DTR.'ServiceCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['section'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategory'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategoryID'];}
		if(!empty($entityID))
		{
			$query = "SELECT ServiceCategoryID AS \"ServiceCategoryID\", ServiceCategoryAlias AS \"ServiceCategoryAlias\", ServiceCategoryParentID AS \"ServiceCategoryParentID\", ServiceCategoryTitle AS \"ServiceCategoryTitle\" FROM ServiceCategory WHERE (ServiceCategoryID='$entityID' OR ServiceCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getLanguageFieldValue($current['sql'][0]['ServiceCategoryTitle']);
			$currentCategoryID = $current['sql'][0]['ServiceCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current['sql'][0]['ServiceCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current['sql'][0]['ServiceCategoryID'];}
				$SERVER->setRefItem('ParentServiceCategories',$refEntityID,$categoryName);					
			}
			$categoryParentID = $current['sql'][0]['ServiceCategoryParentID'];
			//echo 'entid='.$entityID.'<br/>';			
			if(!empty($categoryParentID) && $categoryParentID!='top')
			{
				$in['ServiceCategory'.DTR.'ServiceCategoryID'] = $categoryParentID;
				$this->getParentServiceCategories($in);
			}
			else
			{
				$SERVER->reverseRef('ParentServiceCategories');
				return '';
			}
		}
	}	
	
	function getServiceCategoriesTree($input)
	{
		//get global variables
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
		$entityID = $input['ServiceCategory'.DTR.'ServiceCategoryParentID'];
		if(empty($entityID)) {$entityID = $input['ServiceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		
		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategoryAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategory'.DTR.'ServiceCategoryAlias'];}
		$entityType = $input['ServiceCategory'.DTR.'ServiceCategoryGroup'];
		if(empty($entityType)) {$entityType = $input['ServiceCategoryGroup'];}	
		
		//set filters
		$upLevels = $input['upLevels'];
		$downLevels = $input['downLevels'];
		$startLevel = $input['startLevel'];
		$endLevel = $input['endLevel'];		
		$treeType = $input['treeType'];// =all - show all requested levels at once , =current - show requested levels only for current id: this is default
		$this->_upLevels = $upLevels;
		$this->_downLevels = $downLevels;
		$this->_startLevel = $startLevel;
		$this->_endLevel = $endLevel;		
		$this->_treeType = $treeType;
		//start get cache
		/*
		$cacheInput['Module'] = 'core';
		$cacheInput['Class'] = 'ServiceCategoryServer';
		$cacheInput['Method'] = 'getServiceCategoriesTree';
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
				$parentRS = $DS->query("SELECT ServiceCategoryID AS \"ServiceCategoryID\", ServiceCategoryParentID AS \"ServiceCategoryParentID\" FROM ServiceCategory WHERE ServiceCategoryAlias='$entityAlias'");
				$entityID = $parentRS[0]['ServiceCategoryID'];
				//$entityParentID = $parentRS['sql'][0]['ServiceCategoryParentID'];
			}
		}
		if($treeType=='all')
		{
			$entityID ='';
			$entityAlias='';
			$result = $this->getDownServiceCategoriesRecursive($entityID,$entityType,0); 
		}
		elseif(!empty($startLevel))
		{
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
				$result = $this->getDownServiceCategoriesRecursive($entityID,$entityType,$spacesMode);
			}
		}
		else
		{
			if(!empty($entityID))
			{
				$result = $this->getDownServiceCategoriesRecursive($entityID,$entityType,$spacesMode);
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
			$query = "SELECT ServiceCategoryID AS \"ServiceCategoryID\", ServiceCategoryParentID AS \"ServiceCategoryParentID\" FROM ServiceCategory WHERE ServiceCategoryID='$entityID'";
			$current = $DS->query($query);
			$currentServiceCategoryID = $current[0]['ServiceCategoryID'];
			$currentParentServiceCategoryID = $current[0]['ServiceCategoryParentID'];
			$levels[]=$currentServiceCategoryID;
			$this->_levels = $levels;
			if(!empty($currentParentServiceCategoryID) && $currentParentServiceCategoryID!='top')
			{
				$this->getStartLevelEntityID($currentParentServiceCategoryID);				
			}
		}	
	}
	
	function getDownServiceCategoriesRecursive($entityID,$entityType)
	{
		global $sectionsTree, $treeIndex;
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$upLevels=$this->_upLevels;
		$downLevels=$this->_downLevels;
		$treeType=$this->_treeType;
		$currentLevel = $this->_currentLevel;
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		if(empty($treeIndex)) $treeIndex=0;
		if(!empty($entityType))		
		{
			$filter .= " AND ServiceCategoryGroupID='$entityType' ";
		}
		if(empty($entityID) && empty($entityAlias))
		{
			$entityID='';
		}
		if($clientType!='admin')
		{
			//$filter .= " AND PermAll=1 ";
		}
		//$filter .= " AND OwnerID='$ownerID' ";
		if(empty($entityID)) {$entityID=0;}
		$query = "SELECT * FROM ServiceCategory WHERE ServiceCategoryParentID='$entityID' $filter ORDER BY ServiceCategoryPosition ";	
		$rs = $DS->query($query);
		//echo $query .'<hr>';
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$sectionsTree[$treeIndex] = $row;
				$sectionsTree[$treeIndex]['ServiceCategoryLevel'] = $currentLevel;
				//echo 'name: '.getValue($row['ServiceCategoryTitle']).' index='.$treeIndex.' level='.$currentLevel.'<hr>';
				$treeIndex++;
				if($downLevels=='all' || $currentLevel<$downLevels)
				{
					$this->_currentLevel = $currentLevel+1;
					$entityID = $row['ServiceCategoryID'];
					$this->getDownServiceCategoriesRecursive($entityID,$entityAlias,$entityType);
				}
				
			}
		}
		else
		{
			if($entityParentID!= 'top' && $entityID !='top')
			{
				//get current level sections if it was clicked an item in current level
				//$result .= $this->getDownServiceCategoriesRecursive($entityParentID,$entityAlias,$entityType);
			}
		}
				
		return $result;
	}

	function getServiceCategory($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.getService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['ServiceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategory'.DTR.'ServiceCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategory'.DTR.'ServiceCategoryAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " ServiceCategoryAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ServiceCategoryID='$entityID' ";
		}
		$query = "SELECT * FROM ServiceCategory WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	
		return $result;		
	}

	function getServiceCategoryTypes($input)
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
		$entityID = $input['CategoryID'];
		$entityAlias = $input['category'];
		if(empty($entityID) && !empty($entityAlias))
		{
			$rs = $DS->query("SELECT ServiceCategoryID FROM ServiceCategory WHERE ServiceCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['ServiceCategoryID'];
		}		
		$query = "SELECT * FROM ServiceCategoryStat, ServiceType WHERE ServiceCategoryStat.ServiceType=ServiceType.ServiceTypeAlias AND ServiceCategoryStatItems>0 AND ServiceCategoryID='$entityID' ORDER BY ServiceTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}
		
	function updateServiceCategoryStat($categoryID,$serviceType,$countTotal,$countType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($serviceType))
		{
			$query = "UPDATE ServiceCategory SET ServiceCategoryItems=$countTotal WHERE ServiceCategoryID ='$categoryID' ";
			$DS->query($query);
			
			$query = "SELECT ServiceCategoryStatID, ServiceCategoryStatItems FROM ServiceCategoryStat WHERE ServiceCategoryID='$categoryID' AND ServiceType = '$serviceType' ";
			$statRS = $DS->query($query);
			$serviceCategoryStatID = $statRS[0]['ServiceCategoryStatID'];	
			if(!empty($serviceCategoryStatID))
			{
				$query = "UPDATE ServiceCategoryStat SET ServiceCategoryStatItems=$countType WHERE ServiceCategoryStatID='$serviceCategoryStatID'";
			}
			else
			{
				$query = "INSERT INTO ServiceCategoryStat (ServiceCategoryID, ServiceType, ServiceCategoryStatItems) VALUES ('$categoryID','$serviceType',$countType)";
			}	
			$DS->query($query);
			$this->updateServiceCategoryStatRecursive($categoryID,$serviceType);
		}
	}
	
	function updateServiceCategoryStatRecursive($categoryID,$serviceType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($serviceType))
		{
			$query = "SELECT ServiceCategoryID, ServiceCategoryParentID, ServiceCategoryChildren  FROM ServiceCategory WHERE ServiceCategoryID ='$categoryID' ";
			$rs = $DS->query($query);
			$parentID = $rs[0]['ServiceCategoryParentID'];
			if(!empty($parentID))
			{
				//update general counts
				$query = "SELECT SUM(ServiceCategoryChildren) AS ServiceCategoryChildrenSum,  SUM(ServiceCategoryItems) AS ServiceCategoryItemsSum FROM ServiceCategory WHERE ServiceCategoryParentID ='$parentID' ";		
				$rs = $DS->query($query);
				$childrenTotal = $rs[0]['ServiceCategoryChildrenSum'] + $rs[0]['ServiceCategoryItemsSum'];
				$query = "UPDATE ServiceCategory SET ServiceCategoryChildren=$childrenTotal WHERE ServiceCategoryID ='$parentID' ";
				$DS->query($query);
				//update per type counts
				//todo
				$this->updateServiceCategoryStatRecursive($parentID,$serviceType);
			}
		}
		
	}

	
	function getServiceCategories($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.getService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$filterMode = $input['filterMode'];
		//set client side variables
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['ServiceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategory'.DTR.'ServiceCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ServiceCategory'.DTR.'ServiceCategoryAlias'];}

		if(empty($entityID) && !empty($entityAlias))
		{
			$rs = $DS->query("SELECT ServiceCategoryID FROM ServiceCategory WHERE ServiceCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['ServiceCategoryID'];
		}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query ='';
		if(!empty($entityID) && $filterMode!='top')
		{
			$filter = " ServiceCategoryParentID='$entityID' "; 
		}
		else
		{
			$filter = " ServiceCategoryParentID=0 ";
		}
		
		 
		if($clientType!='admin') {
			$filter .= " AND PermAll=1 "; 
			//$filter .= " AND (ServiceCategoryItems>0 OR ServiceCategoryChildren>0) ";
		}
		
		$query = "SELECT * FROM ServiceCategory WHERE $filter ORDER BY ServiceCategoryPosition"; 
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}		
	
	
	function getServiceCategoriesPath($input)
	{
		global $parentServiceCategories;
		//set global variables
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['ServiceCategory'.DTR.'ServiceCategoryID'])) 
		{
			$entityID = $input['ServiceCategory'.DTR.'ServiceCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['serviceCategory'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategory'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ServiceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['category'];}
		
		$prev_parent = $input['parent'];
		if(!empty($entityID))
		{
			$query = "SELECT ServiceCategoryID AS \"ServiceCategoryID\", ServiceCategoryAlias AS \"ServiceCategoryAlias\", ServiceCategoryParentID AS \"ServiceCategoryParentID\", ServiceCategoryTitle AS \"ServiceCategoryTitle\" FROM ServiceCategory WHERE (ServiceCategoryID='$entityID' OR ServiceCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getValue($current[0]['ServiceCategoryTitle']);
			$currentCategoryID = $current[0]['ServiceCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current[0]['ServiceCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current[0]['ServiceCategoryID'];}
				$parentServiceCategories[$refEntityID] = $categoryName;
			}

			$parent[$entityID]['id'] = $currentCategoryID;
			$parent[$entityID]['value'] = $categoryName;
			$in['parent']= arrayMerge ($prev_parent,$parent);
			$categoryParentID = $current[0]['ServiceCategoryParentID'];
			if(!empty($categoryParentID))
			{
				$in['ServiceCategory'.DTR.'ServiceCategoryID'] = $categoryParentID;
				$newParent = $this->getServiceCategoriesPath($in,$mode);
			}
			else
			{
				$parentServiceCategories = array_reverse($parentServiceCategories);
				$result= arrayMerge ($in['parent'],$newParent);
				return $result;
			}
			$result= arrayMerge ($in['parent'],$newParent);
			return $result;
		}
		return $result;		
	}
		
} // end of ServiceCategoryServer
?>