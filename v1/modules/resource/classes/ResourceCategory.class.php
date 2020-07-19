<?php
class ResourceCategoryClass
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
	function ResourceCategoryClass()
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

	function updateResourceCategoriesPositions($sectionID)
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
		$entityType = $input['ResourceCategory'.DTR.'ResourceCategoryType'];
		if(empty($entityType)) {$entityType = $input['ResourceCategoryGroup'];}	
		if(empty($entityType)) {$entityType = $input['GroupID'];}			
		//set client side variables
		if(empty($sectionID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT ResourceCategoryParentID AS \"ResourceCategoryParentID\" FROM ResourceCategory WHERE ResourceCategoryID='$sectionID'");
		$sectionParentID = $checkRS[0]['ResourceCategoryParentID'];
		
		//if(!empty($sectionParentID))
		//{	
			if($sectionParentID=='top' && !empty($entityType))
			{
				$filterType = " AND ResourceCategoryGroupID='$entityType'";
			}
			$query = "SELECT ResourceCategoryTitle, ResourceCategoryID AS \"ResourceCategoryID\" FROM ResourceCategory  WHERE ResourceCategoryParentID='$sectionParentID' $filterType ORDER BY ResourceCategoryPosition ASC";			
			$rs = $DS->query($query);
			$i=2;
			foreach($rs as $row)
			{
				$DS->query("UPDATE ResourceCategory SET ResourceCategoryPosition='$i' WHERE ResourceCategoryID='".$row['ResourceCategoryID']."'");
				$i = $i+2;
			}
		//}
		return $result;		
	}	
	
	function getParentResourceCategories($input) {
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['ResourceCategory'.DTR.'ResourceCategoryID'])) 
		{
			$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['section'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategory'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategoryID'];}
		if(!empty($entityID))
		{
			$query = "SELECT ResourceCategoryID AS \"ResourceCategoryID\", ResourceCategoryAlias AS \"ResourceCategoryAlias\", ResourceCategoryParentID AS \"ResourceCategoryParentID\", ResourceCategoryTitle AS \"ResourceCategoryTitle\" FROM ResourceCategory WHERE (ResourceCategoryID='$entityID' OR ResourceCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getLanguageFieldValue($current['sql'][0]['ResourceCategoryTitle']);
			$currentCategoryID = $current['sql'][0]['ResourceCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current['sql'][0]['ResourceCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current['sql'][0]['ResourceCategoryID'];}
				$SERVER->setRefItem('ParentResourceCategories',$refEntityID,$categoryName);					
			}
			$categoryParentID = $current['sql'][0]['ResourceCategoryParentID'];
			//echo 'entid='.$entityID.'<br/>';			
			if(!empty($categoryParentID) && $categoryParentID!='top')
			{
				$in['ResourceCategory'.DTR.'ResourceCategoryID'] = $categoryParentID;
				$this->getParentResourceCategories($in);
			}
			else
			{
				$SERVER->reverseRef('ParentResourceCategories');
				return '';
			}
		}
	}	
	
	function getResourceCategoriesTree($input)
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
		//echo 'rrrrr';
		//print_r($input);
		//print_r($input);
		$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryParentID'];
		if(empty($entityID)) {$entityID = $input['ResourceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		
		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategoryAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'.DTR.'ResourceCategoryAlias'];}
		$entityType = $input['ResourceCategory'.DTR.'ResourceCategoryGroup'];
		if(empty($entityType)) {$entityType = $input['ResourceCategoryGroup'];}	
		
		
		//set filters
		$upLevels = $input['upLevels'];
		$downLevels = $input['downLevels'];
		$startLevel = $input['startLevel'];
		$endLevel = $input['endLevel'];		
		$treeType = $input['treeType'];// =all - show all requested levels at once , =current - show requested levels only for current id: this is default
		//$treeType='expanded';
		$this->_upLevels = $upLevels;
		$this->_downLevels = $downLevels;
		$this->_startLevel = $startLevel;
		$this->_endLevel = $endLevel;		
		$this->_treeType = $treeType;
		//start get cache
		/*
		$cacheInput['Module'] = 'core';
		$cacheInput['Class'] = 'ResourceCategoryServer';
		$cacheInput['Method'] = 'getResourceCategoriesTree';
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
				$parentRS = $DS->query("SELECT ResourceCategoryID AS \"ResourceCategoryID\", ResourceCategoryParentID AS \"ResourceCategoryParentID\" FROM ResourceCategory WHERE ResourceCategoryAlias='$entityAlias'");
				$entityID = $parentRS[0]['ResourceCategoryID'];
				//$entityParentID = $parentRS['sql'][0]['ResourceCategoryParentID'];
			}
		}
		if($treeType=='all')
		{
			$entityID ='';
			$entityAlias='';
			$result = $this->getDownResourceCategoriesRecursive($entityID,$entityType,0);
		}
		elseif($treeType=='expanded')
		{
			$entityID ='';
			$entityAlias='';
			$this->_downLevels=1;
			$path = $this->getResourceCategoriesPath($input);
			$result = $this->getDownResourceCategoriesRecursive($entityID,$entityType,$path);
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
				//echo "1";
				$result = $this->getDownResourceCategoriesRecursive($entityID,$entityType,$spacesMode);
			}
		}
		else
		{
			if(!empty($entityID))
			{
				//echo "2";
				$result = $this->getDownResourceCategoriesRecursive($entityID,$entityType,$spacesMode);
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
			$query = "SELECT ResourceCategoryID AS \"ResourceCategoryID\", ResourceCategoryParentID AS \"ResourceCategoryParentID\" FROM ResourceCategory WHERE ResourceCategoryID='$entityID'";
			$current = $DS->query($query);
			$currentResourceCategoryID = $current[0]['ResourceCategoryID'];
			$currentParentResourceCategoryID = $current[0]['ResourceCategoryParentID'];
			$levels[]=$currentResourceCategoryID;
			$this->_levels = $levels;
			if(!empty($currentParentResourceCategoryID) && $currentParentResourceCategoryID!='top')
			{
				$this->getStartLevelEntityID($currentParentResourceCategoryID);				
			}
		}	
	}
	
	function getDownResourceCategoriesRecursive($entityID,$entityType,$path='')
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
			$filter .= " AND ResourceCategoryGroupID='$entityType' ";
		}
		if(empty($entityID) && empty($entityAlias))
		{
			$entityID='';
		}
		if($clientType!='admin')
		{
			$filter .= " AND PermAll=1 ";
		}
		
		$filter .= " AND OwnerID='$ownerID' ";
		if(empty($entityID)) {$entityID=0;}
		if(!empty($config['ResourcesDefaultOrder']))
		{
			if($config['ResourceCategoriesDefaultOrder']=='random')
			{
				$order = '';
			}
			else
			{
				$order = 'ORDER BY '.$config['ResourceCategoriesDefaultOrder'];
			}
		}
		else
		{
			$order = 'ORDER BY ResourceCategoryPosition';
		}		
		$query = "SELECT * FROM ResourceCategory WHERE ResourceCategoryParentID='$entityID' $filter $order ";	
		$rs = $DS->query($query);
		//echo $query .'<hr>';
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$sectionsTree[$treeIndex] = $row;
				$sectionsTree[$treeIndex]['ResourceCategoryLevel'] = $currentLevel;
				//echo 'name: '.getValue($row['ResourceCategoryTitle']).' index='.$treeIndex.' level='.$currentLevel.'<hr>';
				$treeIndex++;
				if($treeType=='expanded')
				{
					//print_r($path);
					if(is_array($path))
					{
						$entityID = $row['ResourceCategoryID'];
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
							$this->_currentLevel = $currentLevel+1;
							$this->getDownResourceCategoriesRecursive($entityID,$entityType,$path);
						}
					}
				}
				elseif($downLevels=='all' || $currentLevel<$downLevels)
				{
					$this->_currentLevel = $currentLevel+1;
					$entityID = $row['ResourceCategoryID'];
					$this->getDownResourceCategoriesRecursive($entityID,$entityType);
				}
				
			}
		}
		else
		{
			if($entityParentID!= 'top' && $entityID !='top')
			{
				//get current level sections if it was clicked an item in current level
				//$result .= $this->getDownResourceCategoriesRecursive($entityParentID,$entityAlias,$entityType);
			}
		}
				
		return $result;
	}

	function getResourceCategory($input)
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
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['ResourceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'.DTR.'ResourceCategoryAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceCategoryAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceCategoryID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceCategory WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	
		return $result;		
	}

	function getResourceCategoryTypes($input)
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
			$rs = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['ResourceCategoryID'];
		}		
		
		if($config['ResourcesInSubcategoriesMode']=='Y')
		{
			$subcategoriesQuery = $this->getSubcategoriesListQuery($entityID,'ResourceCategoryID');
			if(!empty($subcategoriesQuery)) $filter .= " AND (ResourceCategoryID='$entityID' OR ".$subcategoriesQuery.") ";
			else {$filter .= "AND ResourceCategoryID='$entityID'";}
		}
		else
		{
			 $filter .= "AND ResourceCategoryID='$entityID'";
		}
					
		$query = "SELECT * FROM ResourceCategoryStat, ResourceType WHERE ResourceCategoryStat.ResourceType=ResourceType.ResourceTypeAlias AND ResourceCategoryStatItems>0 $filter ORDER BY ResourceTypePosition";
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}
		
	function updateResourceCategoryStat($categoryID,$resourceType,$countTotal,$countType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($resourceType))
		{
			$query = "UPDATE ResourceCategory SET ResourceCategoryItems=$countTotal WHERE ResourceCategoryID ='$categoryID' ";
			$DS->query($query);
			
			$query = "SELECT ResourceCategoryStatID, ResourceCategoryStatItems FROM ResourceCategoryStat WHERE ResourceCategoryID='$categoryID' AND ResourceType = '$resourceType' ";
			$statRS = $DS->query($query);
			$resourceCategoryStatID = $statRS[0]['ResourceCategoryStatID'];	
			if(!empty($resourceCategoryStatID))
			{
				$query = "UPDATE ResourceCategoryStat SET ResourceCategoryStatItems=$countType WHERE ResourceCategoryStatID='$resourceCategoryStatID'";
			}
			else
			{
				$query = "INSERT INTO ResourceCategoryStat (ResourceCategoryID, ResourceType, ResourceCategoryStatItems) VALUES ('$categoryID','$resourceType',$countType)";
			}	
			$DS->query($query);
			$this->updateResourceCategoryStatRecursive($categoryID,$resourceType);
		}
	}
	
	function updateResourceCategoryStatRecursive($categoryID,$resourceType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($resourceType))
		{
			$query = "SELECT ResourceCategoryID, ResourceCategoryParentID, ResourceCategoryChildren  FROM ResourceCategory WHERE ResourceCategoryID ='$categoryID' ";
			$rs = $DS->query($query);
			$parentID = $rs[0]['ResourceCategoryParentID'];
			if(!empty($parentID))
			{
				//update general counts
				$query = "SELECT SUM(ResourceCategoryChildren) AS ResourceCategoryChildrenSum,  SUM(ResourceCategoryItems) AS ResourceCategoryItemsSum FROM ResourceCategory WHERE ResourceCategoryParentID ='$parentID' ";		
				$rs = $DS->query($query);
				$childrenTotal = $rs[0]['ResourceCategoryChildrenSum'] + $rs[0]['ResourceCategoryItemsSum'];
				$query = "UPDATE ResourceCategory SET ResourceCategoryChildren=$childrenTotal WHERE ResourceCategoryID ='$parentID' ";
				$DS->query($query);
				//update per type counts
				//todo
				$this->updateResourceCategoryStatRecursive($parentID,$resourceType);
			}
		}
		
	}

	
	function getResourceCategories($input)
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
		$filterMode = $input['filterMode'];
		//set client side variables
		$entityID = $input['CategoryID'];
		if(empty($entityID)) {$entityID = $input['ResourceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategoryAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'.DTR.'ResourceCategoryAlias'];}

		if(empty($entityID) && !empty($entityAlias))
		{
			$rs = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias = '$entityAlias'");
			$entityID = $rs[0]['ResourceCategoryID'];
		}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		if(!empty($entityID) && $filterMode!='top')
		{
			$filter = " ResourceCategoryParentID='$entityID' "; 
		}
		else
		{
			$filter = " ResourceCategoryParentID=0 ";
		}
		
		 
		if($clientType!='admin') {
			$filter .= " AND PermAll=1 "; 
			//$filter .= " AND (ResourceCategoryItems>0 OR ResourceCategoryChildren>0) ";
		}
		$filter .= " AND OwnerID = '$ownerID' ";
		if(!empty($config['ResourcesDefaultOrder']))
		{
			if($config['ResourceCategoriesDefaultOrder']=='random')
			{
				$order = '';
			}
			else
			{
				$order = 'ORDER BY '.$config['ResourceCategoriesDefaultOrder'];
			}
		}
		else
		{
			$order = 'ORDER BY ResourceCategoryPosition';
		}			
		$query = "SELECT * FROM ResourceCategory WHERE $filter $order"; 
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}		
	
	
	function getResourceCategoriesPath($input)
	{
		global $parentResourceCategories;
		//set global variables
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['ResourceCategory'.DTR.'ResourceCategoryID'])) 
		{
			$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryID'];
		}
		if(empty($entityID)) {$entityID = $input['resourceCategory'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategory'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategoryParentID'];}
		if(empty($entityID)) {$entityID = $input['ResourceCategoryID'];}
		if(empty($entityID)) {$entityID = $input['category'];}
		
		$prev_parent = $input['parent'];
		if(!empty($entityID))
		{
			$query = "SELECT ResourceCategoryID AS \"ResourceCategoryID\", ResourceCategoryAlias AS \"ResourceCategoryAlias\", ResourceCategoryParentID AS \"ResourceCategoryParentID\", ResourceCategoryTitle AS \"ResourceCategoryTitle\" FROM ResourceCategory WHERE (ResourceCategoryID='$entityID' OR ResourceCategoryAlias='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getValue($current[0]['ResourceCategoryTitle']);
			$currentCategoryID = $current[0]['ResourceCategoryID'];
			if(!empty($currentCategoryID))
			{
				$refEntityID = $current[0]['ResourceCategoryAlias'];
				if(empty($refEntityID)) {$refEntityID = $current[0]['ResourceCategoryID'];}
				$parentResourceCategories[$refEntityID] = $categoryName;
			}

			$parent[$entityID]['id'] = $currentCategoryID;
			$parent[$entityID]['value'] = $categoryName;
			$in['parent']= arrayMerge ($prev_parent,$parent);
			$categoryParentID = $current[0]['ResourceCategoryParentID'];
			if(!empty($categoryParentID))
			{
				$in['ResourceCategory'.DTR.'ResourceCategoryID'] = $categoryParentID;
				$newParent = $this->getResourceCategoriesPath($in,$mode);
			}
			else
			{
				if(is_array($parentResourceCategories))
				{
					$parentResourceCategories = array_reverse($parentResourceCategories);
				}
				$result= arrayMerge ($in['parent'],$newParent);
				return $result;
			}
			$result= arrayMerge ($in['parent'],$newParent);
			return $result;
		}
		return $result;		
	}
	

	function getSubcategoriesListQuery($categoryID,$fieldName='')
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
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategoryAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceCategory'.DTR.'ResourceCategoryAlias'];}
		$entityType = $input['ResourceCategory'.DTR.'ResourceCategoryGroup'];
		
		if(empty($entityType)) {$entityType = $input['ResourceCategoryGroup'];}	
		
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
		$cacheInput['Class'] = 'ResourceCategoryServer';
		$cacheInput['Method'] = 'getResourceCategoriesTree';
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
				$parentRS = $DS->query("SELECT ResourceCategoryID AS \"ResourceCategoryID\", ResourceCategoryParentID AS \"ResourceCategoryParentID\" FROM ResourceCategory WHERE ResourceCategoryAlias='$entityAlias'");
				$entityID = $parentRS[0]['ResourceCategoryID'];
				//$entityParentID = $parentRS['sql'][0]['ResourceCategoryParentID'];
			}
		}
		
		if(!empty($entityID))
		{
			$entityAlias='';
			$result = $this->getDownResourceCategoriesRecursive($entityID,$entityType,0);
		}
		
		if(is_array($sectionsTree))
		{
			$i=0;
			foreach ($sectionsTree as $row)
			{
				if($fieldName=='ResourceCategoryID')
				{
					$filter = " = '".$row['ResourceCategoryID']."' ";
					if($i==0)
					{
						$result = " ResourceCategoryID $filter ";
					}
					else
					{
						$result .= " OR ResourceCategoryID $filter ";
					}					
				}
				else
				{
					if($config['ResourceCategoriesMode']=='one')
					{
						$filter = " = '|".$row['ResourceCategoryID']."|' ";
					}
					else
					{
						$filter = " LIKE '%|".$row['ResourceCategoryID']."|%' ";
					}
					if($i==0)
					{
						$result = " ResourceCategories $filter ";
					}
					else
					{
						$result .= " OR ResourceCategories $filter ";
					}
				}
				$i++;
			}
		}
		//echo $result;
		return $result;	
	}	
		
} // end of ResourceCategoryServer
?>