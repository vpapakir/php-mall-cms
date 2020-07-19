<?php
function manageServiceCategories()
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
	$entityID = $input['ServiceCategoryID'];
	$sectionsObject = new ServiceCategoryClass();	
	//$section = new ServiceCategoryClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		if(!empty($input['ServiceCategory'.DTR.'ServiceCategoryID']))
		{
			$DS->query("DELETE FROM ServiceCategory WHERE ServiceCategoryID='".$input['ServiceCategory'.DTR.'ServiceCategoryID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ServiceCategoryID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ServiceCategory WHERE ServiceCategoryID='".$input['ServiceCategoryID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE ServiceCategory SET ".$fileField."='' WHERE ServiceCategoryID='".$input['ServiceCategoryID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
		foreach($input['ServiceCategory'.DTR.'ServiceCategoryID'] as $id=>$value)
		{
			if($input['ServiceCategory'.DTR.'PermAll'][$id]!='1')
			{
				$inputSave['ServiceCategory'.DTR.'PermAll'] = 4;
			}
			else
			{
				$inputSave['ServiceCategory'.DTR.'PermAll'] = 1;
			}
			$inputSave['ServiceCategory'.DTR.'ServiceCategoryID'] = $input['ServiceCategory'.DTR.'ServiceCategoryID'][$id];
			$inputSave['actionMode']='save';
			$whereSave['ServiceCategory'] = "ServiceCategoryID='".$value."'";
			//echo 'id='.$id. ' sid='.$inputSave['ServiceCategory'.DTR.'ServiceCategoryID'].' perm='.$inputSave['ServiceCategory'.DTR.'PermAll'].'<hr>' ;
			$DS->save($inputSave,$whereSave);			
		}		
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//print_r($input);
		//add or update one item
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['ServiceCategoryImage']['file']))
		{
			$input['ServiceCategory'.DTR.'ServiceCategoryImage']= $uploadRS['ServiceCategoryImage']['file'];
			//$input['Service'.DTR.'ServiceIcon'] = $uploadRS['ServiceImage']['preview'];
		}	
		if(!empty($uploadRS['ServiceCategoryIcon']['file']))
		{
			$input['ServiceCategory'.DTR.'ServiceCategoryIcon']= $uploadRS['ServiceCategoryIcon']['file'];
		}	
		if(!empty($uploadRS['ServiceCategoryImagePreview']['file']))
		{
			$input['ServiceCategory'.DTR.'ServiceCategoryImagePreview']= $uploadRS['ServiceCategoryImagePreview']['file'];
		}	
//		$serviceObject->setService($input);
//		$serviceObject->setServiceField($input);	


		//if(is_array($input['ServiceCategory'.DTR.'ServiceCategoryTypes'])) {$input['ServiceCategory'.DTR.'ServiceCategoryTypes'] = '|'. implode("|",$input['ServiceCategory'.DTR.'ServiceCategoryTypes']).'|'; }

		$where['ServiceCategory'] = "ServiceCategoryID='".$input['ServiceCategory'.DTR.'ServiceCategoryID'] ."'";
		//print_r($input);
		if(!empty($input['ServiceCategory'.DTR.'ServiceCategoryAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT ServiceCategoryAlias FROM ServiceCategory WHERE ServiceCategoryAlias='".$input['ServiceCategory'.DTR.'ServiceCategoryAlias']."'");
		}
		if(count($checkRS)<1)
		{		
			$input['actionMode']='save';		
			$saveResult = $DS->save($input,$where);
			$sectionsObject->updateServiceCategoriesPositions($input['ServiceCategory'.DTR.'ServiceCategoryID']);			
		}
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $DS->query("SELECT * FROM ServiceCategory WHERE ServiceCategoryID='$entityID'");
		$result['DB']['ServiceCategory'] = $sectionRS;
	}	

	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','ServiceCategory'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);

	//get sections tree by selected group of sections
	//if(!empty($groupID))
	//{
		//$entityRS = $DS->query("SELECT * FROM ServiceCategory WHERE ServiceCategoryGroupID='$groupID'");
		//$entityRS = $DS->query("SELECT * FROM ServiceCategory");
		//$result['DB']['ServiceCategories'] = $entityRS;
		$input['treeType']='all';
		$input['downLevels']='all';
		//$input['ServiceCategoryGroup'] = $groupID;
		$entityRS = $sectionsObject->getServiceCategoriesTree($input);
		$result['DB']['ServiceCategories'] = $entityRS;
		
	//}
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//format categories tree into a drop down
	$mode='';$inputValues='';
	$mode['name']='ServiceCategory'.DTR.'ServiceCategoryParentID';
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['ServiceCategoryLevel'])
			{
				$lastLevel = $row['ServiceCategoryLevel'];
				$treeString='';
				if($row['ServiceCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ServiceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['ServiceCategoryID']!=$input['ServiceCategoryID'])
			{
				$inputValues[$k]['id']=$row['ServiceCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['ServiceCategoryTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['ServiceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	if(!empty($sectionRS[0]['ServiceCategoryParentID']))
	{
		$parentID = $sectionRS[0]['ServiceCategoryParentID'];
	}
	else
	{
		$parentID = $input['ServiceCategoryParentID'];
	}
	$result['Refs']['ServiceCategoryParentID']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	
	//return result array
	return $result;
}

function getServiceCategoriesTree($input='')
{
	global $CORE;
	$catsObject = new ServiceCategoryClass();	
	$input = $CORE->getInput();
	//get categories reference
	//$input['treeType']='all';
	if(empty($input['treeType'])){$input['treeType']='all';}
	$input['downLevels']='all';
	$categoriesRS = $catsObject->getServiceCategoriesTree($input);
	
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('SelectCategoryDropDown.service.option');	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['ServiceCategoryLevel'])
			{
				$lastLevel = $row['ServiceCategoryLevel'];
				$treeString='';
				if($row['ServiceCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ServiceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			//if($row['ServiceCategoryID']!=$input['ServiceCategoryID'])
			//{
				$inputValues[$k]['id']=$row['ServiceCategoryID'];	
				$inputValues[$k]['code']=$row['ServiceCategoryAlias'];
				$inputValues[$k]['value']=$treeString.getValue($row['ServiceCategoryTitle']);
				$k++;		
			//}
			//echo 'i= '.$i.' id= '.$row['ServiceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['ServiceCategoriesList'] = $inputValues;
	$result['DB']['ServiceCategories'] = $categoriesRS;
	//echo 'ttttt<br>';//$result['Refs']['Categories']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	return $result;
}

function getServiceCategories()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$serviceCategory = new ServiceCategoryClass();
	$result['DB']['ServiceCategories'] = $serviceCategory->getServiceCategories($input);
	//print_r($result['DB']['ServiceCategories']);
	return $result;
}

function getServiceCategoriesPath()
{
	global $CORE, $parentServiceCategories;
	//get input
	$input = $CORE->getInput();
	//creat objects			
	$serviceCategory = new ServiceCategoryClass();
	$serviceCategory->getServiceCategoriesPath($input);
	$result['DB']['ServiceCategoriesPath'] = $parentServiceCategories;
	//echo '<textarea cols=70 rows=10>';
	//print_r($parentServiceCategories);
	//echo '</textarea>';
	return $result;
}


function getServiceCategory()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$serviceCategory = new ServiceCategoryClass();
	$rs = $serviceCategory->getServiceCategory($input);
	$result['DB']['ServiceCategory'] = $rs[0];
	return $result;
}

function getServiceCategorySEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	//creat objects			
	$serviceCategory = new ServiceCategoryClass();
	$rs = $serviceCategory->getServiceCategory($input);
	$result['DB']['ServiceCategory'] = $rs[0];
	return $result;
}

?>