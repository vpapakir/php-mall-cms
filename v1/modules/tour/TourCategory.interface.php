<?php
function manageTourCategories()
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
	$entityID = $input['TourCategoryID'];
	$sectionsObject = new TourCategoryClass();	
	//$section = new TourCategoryClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		if(!empty($input['TourCategory'.DTR.'TourCategoryID']))
		{
			$DS->query("DELETE FROM TourCategory WHERE TourCategoryID='".$input['TourCategory'.DTR.'TourCategoryID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['TourCategoryID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM TourCategory WHERE TourCategoryID='".$input['TourCategoryID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE TourCategory SET ".$fileField."='' WHERE TourCategoryID='".$input['TourCategoryID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
		foreach($input['TourCategory'.DTR.'TourCategoryID'] as $id=>$value)
		{
			if($input['TourCategory'.DTR.'PermAll'][$id]!='1')
			{
				$inputSave['TourCategory'.DTR.'PermAll'] = 4;
			}
			else
			{
				$inputSave['TourCategory'.DTR.'PermAll'] = 1;
			}
			$inputSave['TourCategory'.DTR.'TourCategoryID'] = $input['TourCategory'.DTR.'TourCategoryID'][$id];
			$inputSave['actionMode']='save';
			$whereSave['TourCategory'] = "TourCategoryID='".$value."'";
			//echo 'id='.$id. ' sid='.$inputSave['TourCategory'.DTR.'TourCategoryID'].' perm='.$inputSave['TourCategory'.DTR.'PermAll'].'<hr>' ;
			$DS->save($inputSave,$whereSave);			
		}		
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//print_r($input);
		//add or update one item
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['TourCategoryImage']['file']))
		{
			$input['TourCategory'.DTR.'TourCategoryImage']= $uploadRS['TourCategoryImage']['file'];
			//$input['Tour'.DTR.'TourIcon'] = $uploadRS['TourImage']['preview'];
		}	
		if(!empty($uploadRS['TourCategoryIcon']['file']))
		{
			$input['TourCategory'.DTR.'TourCategoryIcon']= $uploadRS['TourCategoryIcon']['file'];
		}	
		if(!empty($uploadRS['TourCategoryImagePreview']['file']))
		{
			$input['TourCategory'.DTR.'TourCategoryImagePreview']= $uploadRS['TourCategoryImagePreview']['file'];
		}	
//		$tourObject->setTour($input);
//		$tourObject->setTourField($input);	


		//if(is_array($input['TourCategory'.DTR.'TourCategoryTypes'])) {$input['TourCategory'.DTR.'TourCategoryTypes'] = '|'. implode("|",$input['TourCategory'.DTR.'TourCategoryTypes']).'|'; }

		$where['TourCategory'] = "TourCategoryID='".$input['TourCategory'.DTR.'TourCategoryID'] ."'";
		//print_r($input);
		if(!empty($input['TourCategory'.DTR.'TourCategoryAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT TourCategoryAlias FROM TourCategory WHERE TourCategoryAlias='".$input['TourCategory'.DTR.'TourCategoryAlias']."'");
		}
		if(count($checkRS)<1)
		{		
			$input['actionMode']='save';		
			$saveResult = $DS->save($input,$where);
			$sectionsObject->updateTourCategoriesPositions($input['TourCategory'.DTR.'TourCategoryID']);			
		}
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $DS->query("SELECT * FROM TourCategory WHERE TourCategoryID='$entityID'");
		$result['DB']['TourCategory'] = $sectionRS;
	}	

	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','TourCategory'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);

	//get sections tree by selected group of sections
	//if(!empty($groupID))
	//{
		//$entityRS = $DS->query("SELECT * FROM TourCategory WHERE TourCategoryGroupID='$groupID'");
		//$entityRS = $DS->query("SELECT * FROM TourCategory");
		//$result['DB']['TourCategories'] = $entityRS;
		$input['treeType']='all';
		$input['downLevels']='all';
		//$input['TourCategoryGroup'] = $groupID;
		$entityRS = $sectionsObject->getTourCategoriesTree($input);
		$result['DB']['TourCategories'] = $entityRS;
		
	//}
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//format categories tree into a drop down
	$mode='';$inputValues='';
	$mode['name']='TourCategory'.DTR.'TourCategoryParentID';
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['TourCategoryLevel'])
			{
				$lastLevel = $row['TourCategoryLevel'];
				$treeString='';
				if($row['TourCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['TourCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['TourCategoryID']!=$input['TourCategoryID'])
			{
				$inputValues[$k]['id']=$row['TourCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['TourCategoryTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['TourCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	if(!empty($sectionRS[0]['TourCategoryParentID']))
	{
		$parentID = $sectionRS[0]['TourCategoryParentID'];
	}
	else
	{
		$parentID = $input['TourCategoryParentID'];
	}
	$result['Refs']['TourCategoryParentID']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	
	//return result array
	return $result;
}

function getTourCategoriesTree($input='')
{
	global $CORE;
	$catsObject = new TourCategoryClass();	
	$input = $CORE->getInput();
	//get categories reference
	//$input['treeType']='all';
	if(empty($input['treeType'])){$input['treeType']='all';}
	$input['downLevels']='all';
	$categoriesRS = $catsObject->getTourCategoriesTree($input);
	
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('SelectCategoryDropDown.tour.option');	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['TourCategoryLevel'])
			{
				$lastLevel = $row['TourCategoryLevel'];
				$treeString='';
				if($row['TourCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['TourCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			//if($row['TourCategoryID']!=$input['TourCategoryID'])
			//{
				$inputValues[$k]['id']=$row['TourCategoryID'];	
				$inputValues[$k]['code']=$row['TourCategoryAlias'];
				$inputValues[$k]['value']=$treeString.getValue($row['TourCategoryTitle']);
				$k++;		
			//}
			//echo 'i= '.$i.' id= '.$row['TourCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['TourCategoriesList'] = $inputValues;
	$result['DB']['TourCategories'] = $categoriesRS;
	//echo 'ttttt<br>';//$result['Refs']['Categories']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	return $result;
}

function getTourCategories()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$tourCategory = new TourCategoryClass();
	$result['DB']['TourCategories'] = $tourCategory->getTourCategories($input);
	//print_r($result['DB']['TourCategories']);
	return $result;
}

function getTourCategoriesPath()
{
	global $CORE, $parentTourCategories;
	//get input
	$input = $CORE->getInput();
	//creat objects			
	$tourCategory = new TourCategoryClass();
	$tourCategory->getTourCategoriesPath($input);
	$result['DB']['TourCategoriesPath'] = $parentTourCategories;
	//echo '<textarea cols=70 rows=10>';
	//print_r($parentTourCategories);
	//echo '</textarea>';
	return $result;
}


function getTourCategory()
{

	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$tourCategory = new TourCategoryClass();
	$rs = $tourCategory->getTourCategory($input);
	$result['DB']['TourCategory'] = $rs[0];
	return $result;
}

function getTourCategorySEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	//creat objects			
	$tourCategory = new TourCategoryClass();
	$rs = $tourCategory->getTourCategory($input);
	$result['DB']['TourCategory'] = $rs[0];
	return $result;
}

?>