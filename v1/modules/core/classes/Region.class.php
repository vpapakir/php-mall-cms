<?php
class RegionClass
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
	function RegionClass()
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
	
	function setRegion($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		
		if(empty($input['Region'.DTR.'RegionCode']))
		{
			$typeObject = new AliasDataType($SERVER);
			$lang = $config['lang'];
			$input['Region'.DTR.'RegionCode'] = $typeObject->setDataType($input['Region'.DTR.'RegionName'][$lang]);
		}
		
		$where['Region'] = "RegionID='".$input['Region'.DTR.'RegionID']."'";
		
		if(!empty($input['Region'.DTR.'RegionCode']))
		{
			$checkRS=$DS->query("SELECT RegionCode FROM Region WHERE RegionCode='".$input['Region'.DTR.'RegionCode']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['Region'.DTR.'RegionCode'] = $input['Region'.DTR.'RegionCode'].date('Ymd-His');
				$SERVER->setMessage('core.RegionClass.setRegion.err.DuplicatedRegion');
			}			
		}
		
		if($input['actionMode']=='save1')
		{
			if(!empty($input['Region'.DTR.'RegionID']))
			{
				$input['actionMode']='save';
				$entityID = $DS->save($input,$where);
				if(!empty($entityID))
					$SERVER->setMessage('core.RegionClass.setRegion.msg.RegionSaved');
			}
		}
		elseif($input['actionMode']=='add')
		{
				$where['Region'] = "RegionID=''";
				$input['actionMode']='save';		
				$entityID = $DS->save($input,$where);
				if(!empty($entityID))
					$SERVER->setMessage('core.RegionClass.setRegion.msg.RegionSaved');
				//$sectionsObject->updateRegionsPositions($input['Region'.DTR.'RegionID']);			
		}
		
	}
	
	
	function setRegions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];

		//update list of items
		foreach($input['Region'.DTR.'RegionID'] as $id=>$value)
		{
			if($input['Region'.DTR.'PermAll'][$id]!='1')
			{
				$inputSave['Region'.DTR.'PermAll'] = 4;
			}
			else
			{
				$inputSave['Region'.DTR.'PermAll'] = 1;
			}
			$inputSave['Region'.DTR.'RegionID'] = $input['Region'.DTR.'RegionID'][$id];
			$inputSave['actionMode']='save';
			$whereSave['Region'] = "RegionID='".$value."'";
			//echo 'id='.$id. ' sid='.$inputSave['Region'.DTR.'RegionID'].' perm='.$inputSave['Region'.DTR.'PermAll'].'<hr>' ;
			$DS->save($inputSave,$whereSave);			
		}
	}
	
	function deleteRegion($input)
	{
		//get global variables
		global $sectionsTree, $treeIndex;
		
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		
		if(!empty($input['RegionID']))
		{
			$DS->query("DELETE FROM Region WHERE RegionID='".$input['RegionID']."'");
		}
		
	}
	
	function getRegionsTree($input)
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
		$entityID = $input['Region'.DTR.'RegionParentID'];
		if(empty($entityID)) {$entityID = $input['RegionParentID'];}
		if(empty($entityID)) {$entityID = $input['ParentID'];}
		
		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['RegionCode'];}
		if(empty($entityAlias)) {$entityAlias = $input['Region'.DTR.'RegionCode'];}
		$entityType = $input['Region'.DTR.'RegionGroup'];
		if(empty($entityType)) {$entityType = $input['RegionGroup'];}	
		
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
		$cacheInput['Class'] = 'RegionServer';
		$cacheInput['Method'] = 'getRegionsTree';
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
				$parentRS = $DS->query("SELECT RegionID AS \"RegionID\", RegionParentID AS \"RegionParentID\" FROM Region WHERE RegionCode='$entityAlias'");
				$entityID = $parentRS[0]['RegionID'];
				//$entityParentID = $parentRS['sql'][0]['RegionParentID'];
			}
		}
		if($treeType=='all')
		{
			$entityID ='';
			$entityAlias='';
			$result = $this->getDownRegionsRecursive($entityID,$entityType,0); 
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
				$result = $this->getDownRegionsRecursive($entityID,$entityType,$spacesMode);
			}
		}
		else
		{
			if(!empty($entityID))
			{
				$result = $this->getDownRegionsRecursive($entityID,$entityType,$spacesMode);
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
			$query = "SELECT RegionID AS \"RegionID\", RegionParentID AS \"RegionParentID\" FROM Region WHERE RegionID='$entityID'";
			$current = $DS->query($query);
			$currentRegionID = $current[0]['RegionID'];
			$currentParentRegionID = $current[0]['RegionParentID'];
			$levels[]=$currentRegionID;
			$this->_levels = $levels;
			if(!empty($currentParentRegionID) && $currentParentRegionID!='top')
			{
				$this->getStartLevelEntityID($currentParentRegionID);				
			}
		}	
	}
	
	function getDownRegionsRecursive($entityID,$entityType)
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
		$input = $SERVER->getInput();
		if(empty($treeIndex)) $treeIndex=0;
		if(!empty($entityType))		
		{
			$filter .= " AND RegionGroupID='$entityType' ";
		}
		if(empty($entityID) && empty($entityAlias))
		{
			$entityID='';
		}
		//if($clientType!='admin')
		//{
			$filter .= " AND PermAll=1 ";
		//}
		if(empty($input['RegionActionType']))
		{
			$filter .= " AND RegionActionType = 'political' ";
		}else{
			$filter .= " AND RegionActionType = '".$input['RegionActionType']."' ";
		}
		//$filter .= " AND OwnerID='$ownerID' ";
		if(empty($entityID)) {$entityID=0;}
		$query = "SELECT * FROM Region WHERE RegionParentID='$entityID' $filter ORDER BY RegionCode ";	
		$rs = $DS->query($query);
		
		//echo $query .'<hr>';
		//print_r($rs);
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$sectionsTree[$treeIndex] = $row;
				$sectionsTree[$treeIndex]['RegionLevel'] = $currentLevel;
				//echo 'name: '.getValue($row['RegionTitle']).' index='.$treeIndex.' level='.$currentLevel.'<hr>';
				$treeIndex++;
				if($downLevels=='all' || $currentLevel<$downLevels)
				{
					$this->_currentLevel = $currentLevel+1;
					$entityID = $row['RegionID'];
					$this->getDownRegionsRecursive($entityID,$entityAlias,$entityType);
				}
				
			}
		}
		else
		{
			if($entityParentID!= 'top' && $entityID !='top')
			{
				//get current level sections if it was clicked an item in current level
				//$result .= $this->getDownRegionsRecursive($entityParentID,$entityAlias,$entityType);
			}
		}
				
		return $result;
	}

	function getRegion($input)
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
		if(empty($entityID)) {$entityID = $input['RegionID'];}
		if(empty($entityID)) {$entityID = $input['Region'.DTR.'RegionID'];}
		if(empty($entityID)) {$entityID = $input['RegionParentID'];}
		
		
		/*$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['Region'];}
		if(empty($entityAlias)) {$entityAlias = $input['RegionCode'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Region'.DTR.'RegionCode'];}*/

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		
		if(!empty($entityAlias))
		{
			$filter = " RegionCode='$entityAlias' "; 
		}
		else
		{
			$filter = " RegionID='$entityID' ";
		}
		
		$query = "SELECT * FROM Region WHERE $filter"; 
		//get the content
//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}

	function getRegions($input)
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
		$PermAll = $input['PermAll'];
		$searchWord = $input['searchWord'];
		$entityID = $input['CategoryID'];
		
		if(empty($entityID)) {$entityID = $input['RegionParentID'];}
		if(empty($entityID)) {$entityID = $input['Region'.DTR.'RegionParentID'];}
		if(empty($entityID)) {$entityID = $input['RegionID'];} 
		if(empty($entityID)) {$entityID = $input['Region'.DTR.'RegionID'];}

		$entityAlias = $input['category'];
		if(empty($entityAlias)) {$entityAlias = $input['Region'];}
		if(empty($entityAlias)) {$entityAlias = $input['RegionCode'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Region'.DTR.'RegionCode'];}
		
		$location = $input['location'];
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		
		if(!empty($location))
		{
			$query = "SELECT * FROM Region WHERE RegionCode = '$location' ORDER BY RegionCode";
			$RegionRS = $DS->query($query);
			$entityID = $RegionRS[0]['RegionID'];
		}
		
		$query ='';
		if(!empty($entityID) && $filterMode!='top')
		{
			$filter = " RegionParentID='$entityID' "; 
		}
		else
		{
			$filter = " RegionParentID=0 ";
		}
		
		if(empty($input['RegionActionType']))
		{
			$filter .= " AND RegionActionType = 'political' ";
		}else{
			$filter .= " AND RegionActionType = '".$input['RegionActionType']."' ";
		}
		 
		if($clientType!='admin') {
			$filter .= " AND PermAll=1 "; 
			//$filter .= " AND (RegionItems>0 OR RegionChildren>0) ";
		}
		
		if(!empty($searchWord))
		{
			$filter .= " AND (RegionName LIKE '%$searchWord%' OR RegionCode LIKE '%$searchWord%' OR  RegionDescription LIKE '%$searchWord%')";
		}
		if(!empty($PermAll))
		{
			$filter .= " AND PermAll='$PermAll' ";
		}
		else
		{
			$filter .= " AND PermAll='1' ";
		}
		
		$query = "SELECT * FROM Region WHERE $filter ORDER BY RegionCode"; 
		//get the content
		//echo $query;
		$result = $DS->query($query);	
		return $result;		
	}		
	
	function getRegionsPath($input,$mode='')
	{
		global $parentRegionsPath;
		//set global variables
		$DS = &$this->_DS;
		$SERVER = &$this->_controller;
		if(!is_array($input['Region'.DTR.'RegionID'])) 
		{
			$entityID = $input['Region'.DTR.'RegionID'];
		}
		if(empty($entityID)) {$entityID = $input['Region'];}
		if(empty($entityID)) {$entityID = $input['Region'];}
		//if(empty($entityID)) {$entityID = $input['RegionParentID'];}
		if(empty($entityID)) {$entityID = $input['RegionID'];}
		if(empty($mode))$mode = $input['mode'];
		$prev_parent = $input['parent'];
		if(!empty($entityID))
		{
			$query = "SELECT RegionID AS \"RegionID\", RegionCode AS \"RegionCode\", RegionParentID AS \"RegionParentID\", RegionName AS \"RegionName\" FROM Region WHERE (RegionID='$entityID' OR RegionCode='$entityID')";
			$current = $DS->query($query);
			//print_r($current);
			$categoryName = $SERVER->getValue($current[0]['RegionName']);
			$currentCategoryID = $current[0]['RegionID'];
			if(!empty($currentCategoryID))
			{
				if($mode=='id')
				{
					$refEntityID = $current[0]['RegionCode'];
				}
				else
				{
					$refEntityID = $currentCategoryID;
				}
				/*$refEntityID = $currentCategoryID;
				$refEntityID = $currentCategoryID;*/
				//if(empty($refEntityID)) {$refEntityID = $current[0]['RegionID'];}
				$parentRegionsPath[$refEntityID] = $categoryName;
				//echo 'ttt='.$refEntityID.' = '.$parentRegionsPath[$refEntityID].'<br>';
			}

			$parent[$entityID]['id'] = $currentCategoryID;
			$parent[$entityID]['value'] = $categoryName;
			$in['parent']= arrayMerge ($prev_parent,$parent);
			//print_r($in['parent']);
			$categoryParentID = $current[0]['RegionParentID'];
			if(!empty($categoryParentID))
			{
				$in['Region'.DTR.'RegionID'] = $categoryParentID;
				$newParent = $this->getRegionsPath($in,$mode);
			}
			else
			{
				if(is_array($parentRegionsPath))
				{
					//$parentRegionsPath = array_reverse($parentRegionsPath);
				}
				//$result= arrayMerge ($in['parent'],$newParent);
				return $parentRegionsPath;
			}
			//$result= arrayMerge ($in['parent'],$newParent);
			return $parentRegionsPath;
		}
		return $result;		
	}
		
	function updateRegionStat($categoryID,$resourceType,$countTotal,$countType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($resourceType))
		{
			$query = "UPDATE Region SET RegionItems=$countTotal WHERE RegionID ='$categoryID' ";
			$DS->query($query);
			
			$query = "SELECT RegionStatID, RegionStatItems FROM RegionStat WHERE RegionID='$categoryID' AND ResourceType = '$resourceType' ";
			$statRS = $DS->query($query);
			$RegionStatID = $statRS[0]['RegionStatID'];	
			if(!empty($RegionStatID))
			{
				$query = "UPDATE RegionStat SET RegionStatItems=$countType WHERE RegionStatID='$RegionStatID'";
			}
			else
			{
				$query = "INSERT INTO RegionStat (RegionID, ResourceType, RegionStatItems) VALUES ('$categoryID','$resourceType',$countType)";
			}	
			$DS->query($query);
			$this->updateRegionStatRecursive($categoryID,$resourceType);
		}
	}
	
	function updateRegionStatRecursive($categoryID,$resourceType)
	{
		$DS = &$this->_DS;
		if(!empty($categoryID) && !empty($resourceType))
		{
			$query = "SELECT RegionID, RegionParentID, RegionChildren  FROM Region WHERE RegionID ='$categoryID' ";
			$rs = $DS->query($query);
			$parentID = $rs[0]['RegionParentID'];
			if(!empty($parentID))
			{
				//update general counts
				$query = "SELECT SUM(RegionChildren) AS RegionChildrenSum,  SUM(RegionItems) AS RegionItemsSum FROM Region WHERE RegionParentID ='$parentID' ";		
				$rs = $DS->query($query);
				$childrenTotal = $rs[0]['RegionChildrenSum'] + $rs[0]['RegionItemsSum'];
				$query = "UPDATE Region SET RegionChildren=$childrenTotal WHERE RegionID ='$parentID' ";
				$DS->query($query);
				//update per type counts
				//todo
				$this->updateRegionStatRecursive($parentID,$resourceType);
			}
		}
		
	}
	
	function updateRegionsPositions($sectionID)
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
		$entityType = $input['Region'.DTR.'RegionType'];
		if(empty($entityType)) {$entityType = $input['RegionGroup'];}	
		if(empty($entityType)) {$entityType = $input['GroupID'];}			
		//set client side variables
		if(empty($sectionID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT RegionParentID AS \"RegionParentID\" FROM Region WHERE RegionID='$sectionID'");
		$sectionParentID = $checkRS[0]['RegionParentID'];
		
		//if(!empty($sectionParentID))
		//{	
			if($sectionParentID=='top' && !empty($entityType))
			{
				$filterType = " AND RegionGroupID='$entityType'";
			}
			$query = "SELECT RegionTitle, RegionID AS \"RegionID\" FROM Region  WHERE RegionParentID='$sectionParentID' $filterType ORDER BY RegionPosition ASC";			
			$rs = $DS->query($query);
			$i=2;
			foreach($rs as $row)
			{
				$DS->query("UPDATE Region SET RegionPosition='$i' WHERE RegionID='".$row['RegionID']."'");
				$i = $i+2;
			}
		//}
		return $result;		
	}

} // end of RegionServer
?>