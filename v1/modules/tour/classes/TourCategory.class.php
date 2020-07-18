<?php
class TourCategoryClass
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
	function TourCategoryClass()
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

	function updateTourCategoriesPositions($sectionID)
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
		$entityType = $input['TourCategory'.DTR.'TourCategoryType'];
		if(empty($entityType)) {$entityType = $input['TourCategoryGroup'];}	
		if(empty($entityType)) {$entityType = $input['GroupID'];}			
		//set client side variables
		if(empty($sectionID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT TourCategoryParentID AS \"TourCategoryParentID\" FROM TourCategory WHERE TourCategoryID='$sectionID'");
		$sectionParentID = $checkRS[0]['TourCategoryParentID'];
		
		//if(!empty($sectionParentID))
		//{	
			if($sectionParentID=='top' && !empty($entityType))
			{
				$filterType = " AND TourCategoryGroupID='$entityType'";
			}
			$query = "SELECT TourCategoryTitle, TourCategoryID AS \"TourCategoryID\" FROM TourCategory  WHERE TourCategoryParentID='$sectionParentID' $filterType ORDER BY TourCategoryPosition ASC";			
			$rs = $DS->query($query);
			$i=2;
			foreach($rs as $row)
			{
				$DS->query("UPDATE TourCategory SET TourCategoryPosition='$i' WHERE TourCategoryID='".$row['TourCategoryID']."'");
				$i = $i+2;
			}
		//}
		return $result;		
	}	
	
	function getParentTourCategories($input) {
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['TourCategory'.DTR.'TourCategoryID'])) 
		{
			$entityID = $input['TourCategory'.DTR.'TourCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['section'];}
		if(empty($entityID)) {$entityID = $input['TourCategory'];}
		if(empty($entityID)) {$entityID = $input['TourCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['TourCategoryID'];}
		if(!empty($entityID))
		{
			$query = "SELECT TourCategoryID AS \"TourCategoryID\", TourCategoryAlias AS \"TourCategoryAlias\", TourCategoryParentID AS \"TourCategoryParentID\", TourCategoryTitle AS \"TourCategoryTitle\" FROM TourCategory WHERE (TourCategoryID='$entityID' OR TourCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getLanguageFieldValue($current['sql'][0]['TourCategoryTitle']);
			$currentCategoryID = $current['sql'][0]['TourCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current['sql'][0]['TourCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current['sql'][0]['TourCategoryID'];}
				$SERVER->setRefItem('ParentTourCategories',$refEntityID,$categoryName);					
			}
			$categoryParentID = $current['sql'][0]['TourCategoryParentID'];
			//echo 'entid='.$entityID.'<br/>';			
			if(!empty($categoryParentID) && $categoryParentID!='top')
			{
				$in['TourCategory'.DTR.'TourCategoryID'] = $categoryParentID;
				$this->getParentTourCategories($in);
			}
			else
			{
				$SERVER->reverseRef('ParentTourCategories');
				return '';
			}
		}
	}	
	
	function getTourCategoriesTree($input)
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
		$entityID = $input['TourCategory'.DTR.'TourCategoryParentID'];
		if(empty($entityID)) {$entityID = $input['TourCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		
		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['TourCategoryAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourCategory'.DTR.'TourCategoryAlias'];}
		$entityType = $input['TourCategory'.DTR.'TourCategoryGroup'];
		if(empty($entityType)) {$entityType = $input['TourCategoryGroup'];}	
		
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
		$cacheInput['Class'] = 'TourCategoryServer';
		$cacheInput['Method'] = 'getTourCategoriesTree';
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
				$parentRS = $DS->query("SELECT TourCategoryID AS \"TourCategoryID\", TourCategoryParentID AS \"TourCategoryParentID\" FROM TourCategory WHERE TourCategoryAlias='$entityAlias'");
				$entityID = $parentRS[0]['TourCategoryID'];
				//$entityParentID = $parentRS['sql'][0]['TourCategoryParentID'];
			}
		}
		if($treeType=='all')
		{
			$entityID ='';
			$entityAlias='';
			$result = $this->getDownTourCategoriesRecursive($entityID,$entityType,0); 
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
				$result = $this->getDownTourCategoriesRecursive($entityID,$entityType,$spacesMode);
			}
		}
		else
		{
			if(!empty($entityID))
			{
				$result = $this->getDownTourCategoriesRecursive($entityID,$entityType,$spacesMode);
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
			$query = "SELECT TourCategoryID AS \"TourCategoryID\", TourCategoryParentID AS \"TourCategoryParentID\" FROM TourCategory WHERE TourCategoryID='$entityID'";
			$current = $DS->query($query);
			$currentTourCategoryID = $current[0]['TourCategoryID'];
			$currentParentTourCategoryID = $current[0]['TourCategoryParentID'];
			$levels[]=$currentTourCategoryID;
			$this->_levels = $levels;
			if(!empty($currentParentTourCategoryID) && $currentParentTourCategoryID!='top')
			{
				$this->getStartLevelEntityID($currentParentTourCategoryID);				
			}
		}	
	}
	
	function getDownTourCategoriesRecursive($entityID,$entityType)
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
			$filter .= " AND TourCategoryGroupID='$entityType' ";
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
		$query = "SELECT * FROM TourCategory WHERE TourCategoryParentID='$entityID' $filter ORDER BY TourCategoryPosition ";	
		$rs = $DS->query($query);
		//echo $query .'<hr>';
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$sectionsTree[$treeIndex] = $row;
				$sectionsTree[$treeIndex]['TourCategoryLevel'] = $currentLevel;
				//echo 'name: '.getValue($row['TourCategoryTitle']).' index='.$treeIndex.' level='.$currentLevel.'<hr>';
				$treeIndex++;
				if($downLevels=='all' || $currentLevel<$downLevels)
				{
					$this->_currentLevel = $currentLevel+1;
					$entityID = $row['TourCategoryID'];
					$this->getDownTourCategoriesRecursive($entityID,$entityAlias,$entityType);
				}
				
			}
		}
		else
		{
			if($entityParentID!= 'top' && $entityID !='top')
			{
				//get current level sections if it was clicked an item in current level
				//$result .= $this->getDownTourCategoriesRecursive($entityParentID,$entityAlias,$entityType);
			}
		}
				
		return $result;
	}

	function getTourCategory($input)
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
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['TourCategoryID'];}
		if(empty($entityID)) {$entityID = $input['TourCategory'.DTR.'TourCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['TourCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourCategory'.DTR.'TourCategoryAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " TourCategoryAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourCategoryID='$entityID' ";
		}
		$query = "SELECT * FROM TourCategory WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	
		return $result;		
	}

	function getTourCategoryTypes($input)
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
			$rs = $DS->query("SELECT TourCategoryID FROM TourCategory WHERE TourCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['TourCategoryID'];
		}		
		$query = "SELECT * FROM TourCategoryStat, TourType WHERE TourCategoryStat.TourType=TourType.TourTypeAlias AND TourCategoryStatItems>0 AND TourCategoryID='$entityID' ORDER BY TourTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}
		
	function updateTourCategoryStat($categoryID,$tourType,$countTotal,$countType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($tourType))
		{
			$query = "UPDATE TourCategory SET TourCategoryItems=$countTotal WHERE TourCategoryID ='$categoryID' ";
			$DS->query($query);
			
			$query = "SELECT TourCategoryStatID, TourCategoryStatItems FROM TourCategoryStat WHERE TourCategoryID='$categoryID' AND TourType = '$tourType' ";
			$statRS = $DS->query($query);
			$tourCategoryStatID = $statRS[0]['TourCategoryStatID'];	
			if(!empty($tourCategoryStatID))
			{
				$query = "UPDATE TourCategoryStat SET TourCategoryStatItems=$countType WHERE TourCategoryStatID='$tourCategoryStatID'";
			}
			else
			{
				$query = "INSERT INTO TourCategoryStat (TourCategoryID, TourType, TourCategoryStatItems) VALUES ('$categoryID','$tourType',$countType)";
			}	
			$DS->query($query);
			$this->updateTourCategoryStatRecursive($categoryID,$tourType);
		}
	}
	
	function updateTourCategoryStatRecursive($categoryID,$tourType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($tourType))
		{
			$query = "SELECT TourCategoryID, TourCategoryParentID, TourCategoryChildren  FROM TourCategory WHERE TourCategoryID ='$categoryID' ";
			$rs = $DS->query($query);
			$parentID = $rs[0]['TourCategoryParentID'];
			if(!empty($parentID))
			{
				//update general counts
				$query = "SELECT SUM(TourCategoryChildren) AS TourCategoryChildrenSum,  SUM(TourCategoryItems) AS TourCategoryItemsSum FROM TourCategory WHERE TourCategoryParentID ='$parentID' ";		
				$rs = $DS->query($query);
				$childrenTotal = $rs[0]['TourCategoryChildrenSum'] + $rs[0]['TourCategoryItemsSum'];
				$query = "UPDATE TourCategory SET TourCategoryChildren=$childrenTotal WHERE TourCategoryID ='$parentID' ";
				$DS->query($query);
				//update per type counts
				//todo
				$this->updateTourCategoryStatRecursive($parentID,$tourType);
			}
		}
		
	}

	
	function getTourCategories($input)
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
		$filterMode = $input['filterMode'];
		//set client side variables
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['TourCategoryID'];}
		if(empty($entityID)) {$entityID = $input['TourCategory'.DTR.'TourCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['TourCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourCategory'.DTR.'TourCategoryAlias'];}

		if(empty($entityID) && !empty($entityAlias))
		{
			$rs = $DS->query("SELECT TourCategoryID FROM TourCategory WHERE TourCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['TourCategoryID'];
		}
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourServer.adminTour');
		//set queries
		$query ='';
		if(!empty($entityID) && $filterMode!='top')
		{
			$filter = " TourCategoryParentID='$entityID' "; 
		}
		else
		{
			$filter = " TourCategoryParentID=0 ";
		}
		
		 
		if($clientType!='admin') {
			$filter .= " AND PermAll=1 "; 
			//$filter .= " AND (TourCategoryItems>0 OR TourCategoryChildren>0) ";
		}
		
		$query = "SELECT * FROM TourCategory WHERE $filter ORDER BY TourCategoryPosition"; 
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}		
	
	
	function getTourCategoriesPath($input)
	{
		global $parentTourCategories;
		//set global variables
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['TourCategory'.DTR.'TourCategoryID'])) 
		{
			$entityID = $input['TourCategory'.DTR.'TourCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['tourCategory'];}
		if(empty($entityID)) {$entityID = $input['TourCategory'];}
		if(empty($entityID)) {$entityID = $input['TourCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['TourCategoryID'];}
		if(empty($entityID)) {$entityID = $input['category'];}
		
		$prev_parent = $input['parent'];
		if(!empty($entityID))
		{
			$query = "SELECT TourCategoryID AS \"TourCategoryID\", TourCategoryAlias AS \"TourCategoryAlias\", TourCategoryParentID AS \"TourCategoryParentID\", TourCategoryTitle AS \"TourCategoryTitle\" FROM TourCategory WHERE (TourCategoryID='$entityID' OR TourCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getValue($current[0]['TourCategoryTitle']);
			$currentCategoryID = $current[0]['TourCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current[0]['TourCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current[0]['TourCategoryID'];}
				$parentTourCategories[$refEntityID] = $categoryName;
			}

			$parent[$entityID]['id'] = $currentCategoryID;
			$parent[$entityID]['value'] = $categoryName;
			$in['parent']= arrayMerge ($prev_parent,$parent);
			$categoryParentID = $current[0]['TourCategoryParentID'];
			if(!empty($categoryParentID))
			{
				$in['TourCategory'.DTR.'TourCategoryID'] = $categoryParentID;
				$newParent = $this->getTourCategoriesPath($in,$mode);
			}
			else
			{
				$parentTourCategories = array_reverse($parentTourCategories);
				$result= arrayMerge ($in['parent'],$newParent);
				return $result;
			}
			$result= arrayMerge ($in['parent'],$newParent);
			return $result;
		}
		return $result;		
	}
		
} // end of TourCategoryServer
?>