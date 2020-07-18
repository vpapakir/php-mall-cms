<?php
function manageResourceCategories()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//creat objects			
	$DS = new DataSource('main');
	$groupID = $input['GroupID'];
	if(empty($groupID)){$groupID=1;}
	$entityID = $input['ResourceCategoryID'];
	if(empty($entityID)) {$entityID = $input['ResourceCategory'.DTR.'ResourceCategoryID'];}
	$sectionsObject = new ResourceCategoryClass();	
	$resourceTypeObject = new ResourceTypeClass();
	
	//$section = new ResourceCategoryClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		if(!empty($input['ResourceCategory'.DTR.'ResourceCategoryID']))
		{
			$DS->query("DELETE FROM ResourceCategory WHERE ResourceCategoryID='".$input['ResourceCategory'.DTR.'ResourceCategoryID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ResourceCategory'.DTR.'ResourceCategoryID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ResourceCategory WHERE ResourceCategoryID='".$input['ResourceCategory'.DTR.'ResourceCategoryID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			if(!empty($lang))
			{
				$input['ResourceCategory'.DTR.$fileField][$lang]=' ';
			}
			else
			{
				$input['ResourceCategory'.DTR.$fileField]=' ';
			}
			$input['ResourceCategory'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$where['ResourceCategory'] = "ResourceCategoryID='".$input['ResourceCategory'.DTR.'ResourceCategoryID']."'";
			$saveResult = $DS->save($input,$where);
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
		if(is_array($input['ResourceCategory'.DTR.'ResourceCategoryID']))
		{
			foreach($input['ResourceCategory'.DTR.'ResourceCategoryID'] as $id=>$value)
			{
				if($input['ResourceCategory'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['ResourceCategory'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['ResourceCategory'.DTR.'PermAll'] = 1;
				}
				$inputSave['ResourceCategory'.DTR.'ResourceCategoryID'] = $input['ResourceCategory'.DTR.'ResourceCategoryID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['ResourceCategory'] = "ResourceCategoryID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['ResourceCategory'.DTR.'ResourceCategoryID'].' perm='.$inputSave['ResourceCategory'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//print_r($input);
		//add or update one item
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'ResourceCategory',array('previewFieldName'=>'ResourceCategoryImagePreview','fullFieldName'=>'ResourceCategoryImage'));
		
		if(empty($input['ResourceCategory'.DTR.'ResourceCategoryAlias']) && !empty($input['ResourceCategory'.DTR.'ResourceCategoryTitle']))
		{
			$typeObject = new AliasDataType($CORE);
			$langResourceTitle = $input['ResourceCategory'.DTR.'ResourceCategoryTitle']['en'];
			if(empty($langResourceTitle)) { $lang = $config['lang']; $langResourceTitle = $input['ResourceCategory'.DTR.'ResourceCategoryTitle'][$lang];}
			$input['ResourceCategory'.DTR.'ResourceCategoryAlias'] = $typeObject->setDataType($langResourceTitle);
		}	
		
		$where['ResourceCategory'] = "ResourceCategoryID='".$input['ResourceCategory'.DTR.'ResourceCategoryID'] ."'";
		//print_r($input);
		if(!empty($input['ResourceCategory'.DTR.'ResourceCategoryAlias']))
		{
			$checkRS=$DS->query("SELECT ResourceCategoryAlias FROM ResourceCategory WHERE ResourceCategoryAlias='".$input['ResourceCategory'.DTR.'ResourceCategoryAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ResourceCategory'.DTR.'ResourceCategoryAlias'] = $input['ResourceCategory'.DTR.'ResourceCategoryAlias'].date('Ymd-His');
				$CORE->setMessage('resource.manageResourceCategories.err.DuplicatedCategory');
			}				
		}
		$input['actionMode']='save';		
		$saveResult = $DS->save($input,$where);
		$sectionsObject->updateResourceCategoriesPositions($input['ResourceCategory'.DTR.'ResourceCategoryID']);			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $DS->query("SELECT * FROM ResourceCategory WHERE ResourceCategoryID='$entityID'");
		$result['DB']['ResourceCategory'] = $sectionRS;
	}	

	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','ResourceCategory'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);

	//get sections tree by selected group of sections
	//if(!empty($groupID))
	//{
		//$entityRS = $DS->query("SELECT * FROM ResourceCategory WHERE ResourceCategoryGroupID='$groupID'");
		//$entityRS = $DS->query("SELECT * FROM ResourceCategory");
		//$result['DB']['ResourceCategories'] = $entityRS;
		$input['treeType']='expanded';
		$input['downLevels']='all';
		//$input['ResourceCategoryGroup'] = $groupID;
		$entityRS = $sectionsObject->getResourceCategoriesTree($input);
		$result['DB']['ResourceCategories'] = $entityRS;
		
	//}
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	$result['DB']['ResourceTypes']= $resourceTypeObject->getResourceTypes($input);
	
	//format categories tree into a drop down
	$mode='';$inputValues='';
	$mode['name']='ResourceCategory'.DTR.'ResourceCategoryParentID';
	$inputValues[0]['id']=' ';	
	$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['ResourceCategoryLevel'])
			{
				$lastLevel = $row['ResourceCategoryLevel'];
				$treeString='';
				if($row['ResourceCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ResourceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['ResourceCategoryID']!=$entityID)
			{
				$inputValues[$k]['id']=$row['ResourceCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	if(!empty($sectionRS[0]['ResourceCategoryParentID']))
	{
		$parentID = $sectionRS[0]['ResourceCategoryParentID'];
	}
	else
	{
		$parentID = $input['ResourceCategoryParentID'];
	}
	$result['Refs']['ResourceCategoryParentID']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	
	//return result array
	return $result;
}

function getResourceCategoriesTree($input='')
{
	global $CORE;
	$catsObject = new ResourceCategoryClass();	
	$input = $CORE->getInput();
	//get categories reference
	//$input['treeType']='all';
	if(empty($input['treeType'])){$input['treeType']='all';}
	$input['downLevels']='all';
	$categoriesRS = $catsObject->getResourceCategoriesTree($input);
	
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('SelectCategoryDropDown.resource.option');	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['ResourceCategoryLevel'])
			{
				$lastLevel = $row['ResourceCategoryLevel'];
				$treeString='';
				if($row['ResourceCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ResourceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			//if($row['ResourceCategoryID']!=$input['ResourceCategoryID'])
			//{
				$inputValues[$k]['id']=$row['ResourceCategoryID'];	
				$inputValues[$k]['code']=$row['ResourceCategoryAlias'];
				$inputValues[$k]['place']=$row['ResourceCategoryHiddenPlaces'];
				$inputValues[$k]['type']=$row['ResourceType'];
				$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
				$k++;		
			//}
			//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['ResourceCategoriesList'] = $inputValues;
	$result['DB']['ResourceCategories'] = $categoriesRS;
	//echo 'ttttt<br>';//$result['Refs']['Categories']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	return $result;
}

function getResourceCategories()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$resourceCategory = new ResourceCategoryClass();
	$result['DB']['ResourceCategories'] = $resourceCategory->getResourceCategories($input);
	//print_r($result['DB']['ResourceCategories']);
	if(!empty($input['category']) || !empty($input['CategoryID']))
	{			
		$rs = $resourceCategory->getResourceCategory($input);		
		$result['DB']['ResourceCategory'] = $rs[0];								
	}	
	return $result;
}

function getResourceCategoriesPath()
{
	global $CORE, $parentResourceCategories;
	//get input
	$input = $CORE->getInput();
	//creat objects			
	$resourceCategory = new ResourceCategoryClass();
	$resourceCategory->getResourceCategoriesPath($input);
	$result['DB']['ResourceCategoriesPath'] = $parentResourceCategories;
	//echo '<textarea cols=70 rows=10>';
	//print_r($parentResourceCategories);
	//echo '</textarea>';
	return $result;
}


function getResourceCategory()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$resourceCategory = new ResourceCategoryClass();
	$rs = $resourceCategory->getResourceCategory($input);
	$result['DB']['ResourceCategory'] = $rs[0];
	return $result;
}

function getResourceCategorySEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	//creat objects			
	$resourceCategory = new ResourceCategoryClass();
	$rs = $resourceCategory->getResourceCategory($input);
	$result['DB']['ResourceCategory'] = $rs[0];
	return $result;
}

?>