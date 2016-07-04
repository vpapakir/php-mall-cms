<?php 
function manageResources()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();


	//$input2 = $CORE->getInput();
	//print_r($input);
//echo 'rrrrr='.$input['ResourceType'];
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$categoryID = $input['CategoryID'];
	if(empty($categoryID)){	$categoryID = $input['Resource'.DTR.'ResourceCategoryID'];}
	if(empty($categoryID)){	$categoryID = $input['ResourceCategoryID'];}
	
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['ResourceID'];
	$sectionsObject = new ResourceCategoryClass();	
	$resourceObject = new ResourceClass();
	$resourceTypeObject = new ResourceTypeClass();

	if($input['actionMode']=='delete')
	{
		$resourceObject->deleteResource($input);
		//$ResourceType->deleteResourceField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Resource'.DTR.'ResourceID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Resource WHERE ResourceID='".$input['Resource'.DTR.'ResourceID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Resource'.DTR.$fileField][$lang]=' ';}else{	$input['Resource'.DTR.$fileField]=' ';}
			$input['Resource'.DTR.$fileField]=' ';

			$input['actionMode']='save';
			$resourceObject->setResource($input);
		}
	}
	elseif($input['actionMode']=='save')
	{
		//update list of items
	    if(is_array($input['Resource'.DTR.'ResourceID']))
		{
			foreach($input['Resource'.DTR.'ResourceID'] as $id=>$value)
			{
				$updateCats='N';
				if($clientType=='admin')
				{
					if($input['Resource'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['Resource'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['Resource'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM Resource WHERE ResourceID='".$input['Resource'.DTR.'ResourceID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['Resource'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['Resource'.DTR.'ResourceStatus'][$id]!='active')
					{
						$inputSave['Resource'.DTR.'ResourceStatus'] = 'hidden';
					}
					else
					{
						$inputSave['Resource'.DTR.'ResourceStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT ResourceStatus FROM Resource WHERE ResourceID='".$input['Resource'.DTR.'ResourceID'][$id]."'");
					if($oldRS[0]['ResourceStatus']!=$inputSave['Resource'.DTR.'ResourceStatus']) {$updateCats='Y';}
				}			
				$inputSave['Resource'.DTR.'ResourceID'] = $input['Resource'.DTR.'ResourceID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Resource'] = "ResourceID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Resource'.DTR.'ResourceID'].' perm='.$inputSave['Resource'.DTR.'PermAll'].'<hr>' ;

				$DS->save($inputSave,$whereSave); 
				if($updateCats=='Y')
				{
					$resourceObject->updateResourceCategoryStats($input['Resource'.DTR.'ResourceID'][$id]);
				}
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1' || $input['actionMode']=='add1' || $input['actionMode']=='save2')
	{
	
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Resource',array('previewFieldName'=>'ResourceImagePreview','fullFieldName'=>'ResourceImage'));	
		$saveRS = $resourceObject->setResource($input);
		$entityID = $saveRS[0]['ResourceID'];
		$input['Resource'.DTR.'ResourceID'] = $entityID;
	}

	if(!empty($categoryID))
	{
		$ResourceTypeRS = $DS->query("SELECT ResourceType FROM  ResourceCategory WHERE  ResourceCategoryID='".$categoryID."'");
		$result['DB']['ResourceType'] = $ResourceTypeRS;
		if(!empty($ResourceTypeRS[0]['ResourceType']) && $config['CategoryUseType']!='N')
		{
			$input['ResourceType'] = $ResourceTypeRS[0]['ResourceType'];
			$CORE->setInputVar('ResourceType',$input['ResourceType']);
		}
	}
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $resourceObject->getResource($input);
		$result['DB']['Resource'] = $sectionRS;
		if(empty($input['ResourceType'])  && $config['CategoryUseType']!='N')
		{
			$input['ResourceType'] = $sectionRS[0]['ResourceType'];
		}
	}	
	else
	{
		$resourceTemplate = $resourceTypeObject->getResourceTemplate($input['ResourceType']);	
		$CORE->setInputVar('ResourceTemplate',$resourceTemplate);	
	}


	if(!empty($input['ResourceType']))
	{
		$fieldsRS = $resourceObject->getResourceFields($input);
		//$result['DB']['ResourceFieldTypes'] = $fieldsRS['ResourceFieldTypes'];
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
		//$result['DB']['ResourceOption'] = $fieldsRS['ResourceOption'];
		//print_r($result['DB']['ResourceOption']);		
	}

	if($config['UseResourceCategories']=='N')
	{
		$input['treeType']='all';
		$input['downLevels']='all';
		$input['SectionType'] = 'front';
		$input['SectionViewType'] = 'resource.getResourcesOnPage';
		$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
		$inputValues = $sectionsRS['DB']['SectionsList'];
		//print_r($sectionsRS);
	}
	else
	{
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
		//$inputValues[0]['id']='';	
		//$inputValues[0]['value']=lang('-top');	
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
				if($row['ResourceCategoryID']!=$input['ResourceCategoryID'])
				{
					$inputValues[$k]['id']=$row['ResourceCategoryID'];	
					$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
					$k++;		
				}
				//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
			}
		}		
	}
	$result['DB']['ResourceCategories'] = $inputValues;
	//get resources 
	$entityRS = $resourceObject->getResources($input);
	$result['DB']['Resources'] = $entityRS['result'];
	$result['pages']['Resources'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if($clientType!='admin' && input('SID')!='adminProducts')
	{
		$input['resourceTypesPlace']='submit';
	}
	$result['DB']['ResourceTypes']= $resourceTypeObject->getResourceTypes($input);

	//return result array
	return $result;
}

function manageResource()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');

	$clientType = $config['ClientType'];
	$categoryID = $input['CategoryID'];
	if(empty($categoryID)){	$categoryID = $input['Resource'.DTR.'ResourceCategoryID'];}
	if(empty($categoryID)){	$categoryID = $input['ResourceCategoryID'];}
	
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['ResourceID'];
	$sectionsObject = new ResourceCategoryClass();	
	$resourceObject = new ResourceClass();
	$resourceTypeObject = new ResourceTypeClass();
	
	//$section = new ResourceClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$resourceObject->deleteResource($input);
		//$ResourceType->deleteResourceField($input);
	}
	elseif($input['actionMode']=='deleterelated')
	{
		$ResourceRelationObject = new ResourceRelationClass();
		$ResourceRelationObject->deleteResourceRelation($input);
	}	
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Resource'.DTR.'ResourceID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Resource WHERE ResourceID='".$input['Resource'.DTR.'ResourceID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Resource'.DTR.$fileField][$lang]=' ';}else{	$input['Resource'.DTR.$fileField]=' ';}
			$input['Resource'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$resourceObject->setResource($input);
		}
	}	
	elseif($input['actionMode']=='add1' || $input['actionMode']=='save2' || $input['actionMode']=='save1')
	{
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Resource',array('previewFieldName'=>'ResourceImagePreview','fullFieldName'=>'ResourceImage'));	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $resourceObject->setResource($input);
		$entityID = $saveRS[0]['ResourceID'];
		$input['Resource'.DTR.'ResourceID'] = $entityID;	
	}		

	if(!empty($categoryID))
	{
		$ResourceTypeRS = $DS->query("SELECT ResourceType FROM  ResourceCategory WHERE  ResourceCategoryID='".$categoryID."'");
		$result['DB']['ResourceType'] = $ResourceTypeRS;
		if(!empty($ResourceTypeRS[0]['ResourceType']) && $config['CategoryUseType']!='N')
		{
			$input['ResourceType'] = $ResourceTypeRS[0]['ResourceType'];
			$CORE->setInputVar('ResourceType',$input['ResourceType']);
		}
	}	
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $resourceObject->getResource($input);
		$result['DB']['Resource'] = $sectionRS;
		if(empty($input['ResourceType']))
		{
			$input['ResourceType'] = $sectionRS[0]['ResourceType'];
		}
		$ResourceRelationObject = new ResourceRelationClass();
		$result['DB']['ResourceRelations'] = $ResourceRelationObject->getResourceRelations($input);
	}	
	else
	{
		$resourceTemplate = $resourceTypeObject->getResourceTemplate($input['ResourceType']);	
		$CORE->setInputVar('ResourceTemplate',$resourceTemplate);	
	}

	if(!empty($input['ResourceType']))
	{
		$fieldsRS = $resourceObject->getResourceFields($input);
		//$result['DB']['ResourceFieldTypes'] = $fieldsRS['ResourceFieldTypes'];
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
		//$result['DB']['ResourceOption'] = $fieldsRS['ResourceOption'];
		//print_r($result['DB']['ResourceOption']);		
	}

	//get categories reference
	if($config['UseResourceCategories']=='N')
	{
		$input['treeType']='all';
		$input['downLevels']='all';
		$input['SectionType'] = 'front';
		$input['SectionViewType'] = 'resource.getResourcesOnPage';
		$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
		$inputValues = $sectionsRS['DB']['SectionsList'];
	}
	else
	{
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
		//$result['DB']['ResourceCategoriesType'] = $categoriesRS;

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
				if($row['ResourceCategoryID']!=$input['ResourceCategoryID'])
				{
					$inputValues[$k]['id']=$row['ResourceCategoryID'];	
					$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
					$k++;		
				}
				//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
			}
		}	
	}	
	$result['DB']['ResourceCategories'] = $inputValues;
	//get resources 
	$entityRS = $resourceObject->getResources($input);
	$result['DB']['Resources'] = $entityRS['result'];
	$result['pages']['Resources'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	if($clientType!='admin' && input('SID')!='manageResourceFrontAdmin')
	{
		$input['resourceTypesPlace']='submit';
	}
	$result['DB']['ResourceTypes']= $resourceTypeObject->getResourceTypes($input);
	
	$input['CountryID'] = 'top';
	$input['treeType'] = 'all';
	$regionsRS = $CORE->callService('getRegionsTree','coreServer',$input);
	$result['DB']['RegionsList'] = $regionsRS['DB']['RegionsList'];
	
	$input['CountryID'] = 'top';
	$input['treeType'] = 'all';
	$CORE->setInputVar('RegionActionType','geographical');
	$regionsRS = $CORE->callService('getRegionsTree','coreServer',$input);
	$result['DB']['RegionsGeoList'] = $regionsRS['DB']['RegionsList'];
	
	//return result array
	return $result;
}

function addResource($input='')
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$userID = $user['UserID'];
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$categoryID = $input['CategoryID'];
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['ResourceID'];
	$sectionsObject = new ResourceCategoryClass();	
	$resourceObject = new ResourceClass();
	$resourceTypeObject = new ResourceTypeClass();
	
	if($input['actionMode']=='add')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
		}
				
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Resource',array('previewFieldName'=>'ResourceImagePreview','fullFieldName'=>'ResourceImage'));	
    
  	//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $resourceObject->setResource($input);
		$entityID = $saveRS[0]['ResourceID'];
		$input['Resource'.DTR.'ResourceID'] = $entityID;			
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
	}	
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $resourceObject->getResource($input);
		$result['DB']['Resource'] = $sectionRS;
		if(empty($input['ResourceType']))
		{
			$input['ResourceType'] = $sectionRS[0]['ResourceType'];
		}
	}	
	else
	{
		$resourceTemplate = $resourceTypeObject->getResourceTemplate($input['ResourceType']);	
		$CORE->setInputVar('ResourceTemplate',$resourceTemplate);	
	}
	if(!empty($input['ResourceType']))
	{
		$fieldsRS = $resourceObject->getResourceFields($input);
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
	}
	if(!empty($categoryID))
	{
		$ResourceTypeRS = $DS->query("SELECT ResourceType FROM  ResourceCategory WHERE  ResourceCategoryID='".$categoryID."'");
 		//print_r($ResourceTypeRS);
		$result['DB']['ResourceType'] = $ResourceTypeRS;
		$input['ResourceType'] = $ResourceTypeRS[0]['ResourceType'];
		//print_r($result['DB']['ResourceType']);
		$fieldsRS = $resourceObject->getResourceFields($input);
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
	}
	if($config['UseResourceCategories']=='N')
	{
		$input['treeType']='all';
		$input['downLevels']='all';
		$input['SectionType'] = 'front';
		$input['SectionViewType'] = 'resource.getResourcesOnPage';
		$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
		$inputValues = $sectionsRS['DB']['SectionsList'];
		//print_r($sectionsRS);
	}
	else
	{
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
		//$result['DB']['ResourceCategoriesType'] = $categoriesRS;

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
				if($row['ResourceCategoryID']!=$input['ResourceCategoryID'])
				{
					$inputValues[$k]['id']=$row['ResourceCategoryID'];	
					$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
					$k++;		
				}
				//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
			}
		}	
	}

	$result['DB']['ResourceCategories'] = $inputValues;
	
	if(!empty($categoryID))
	{
		$ResourceTypeRS = $DS->query("SELECT ResourceType FROM  ResourceCategory WHERE  ResourceCategoryID='".$categoryID."'");
 		//print_r($ResourceTypeRS);
		$result['DB']['ResourceType'] = $ResourceTypeRS;
		$input['ResourceType'] = $ResourceTypeRS[0]['ResourceType'];
		$fieldsRS = $resourceObject->getResourceFields($input);
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
	}
	//get resources 
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	$input['resourceTypesPlace']='submit';
	$result['DB']['ResourceTypes']= $resourceTypeObject->getResourceTypes($input);
	//return result array
	return $result;
}

function getResources()
{  
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	 $DS = new DataSource('main');
    if($input['ResourceID'])
    {
        $imgTxt = $DS->query("SELECT * FROM ImageText WHERE ImageTextID=" . $input['ResourceID']);
        $result['DB']['ImageText'] = $imgTxt[0]['fullText'];

    }
  if($config['PageViewType']=='resource.getResourcesOnPage' && empty($input['category']))
	{
		$input['category'] = $input['SID'];
		$CORE->setInputVar('category',$input['category']);
	}
	if(!empty($input['category']) || !empty($input['searchWord']) || !empty($input['CategoryID'])  || !empty($input['ResourceType'])  || !empty($input['type']) || !empty($input['location']) || !empty($input['ResourceID']))
	{		
		if(!empty($input['featuredMode']))
		{
			$input['resourceTypesPlace'] = $input['featuredMode'];
		}	
		$resourceObject = new ResourceClass();
		$rs = $resourceObject->getResources($input);
		$result['DB']['Resources'] = $rs['result']; 
		$result['pages']['Resources'] = $rs['pages'];
		if(!empty($config['PageResourceType']))
		{
			$resourceType = $config['PageResourceType'];
		}
		elseif(!empty($input['ResourceType']))
		{
			$resourceType = $input['ResourceType'];
		}
		else
		{
			$resourceCategory = new ResourceCategoryClass();
			$rs = $resourceCategory->getResourceCategory($input);		
			$result['DB']['ResourceCategory'] = $rs[0];			
			$resourceType = $rs[0]['ResourceType'];
		}
		
		if(!empty($resourceType))
		{
			$resourceTypeObject = new ResourceTypeClass();
			$resourceTemplate = $resourceTypeObject->getResourceTemplate($resourceType);	
			$CORE->setInputVar('ResourceTemplate',$resourceTemplate);	
		}							
	}
//print_r($result);
	return $result;
}

function searchResources()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$category = $input['category'];
	$resourceObject = new ResourceClass();
	$DS = new DataSource('main');
	$actionMode = $input['actionMode'];
	//creat objects
	if(!empty($category) || !empty($input['searchWord']) || !empty($input['CategoryID']))
	{			
		if(!empty($category))
		{
			$ResourceTypeRS = $DS->query("SELECT ResourceType FROM  ResourceCategory WHERE  ResourceCategoryAlias='".$category."'");
			//print_r($ResourceTypeRS);
			$result['DB']['ResourceType'] = $ResourceTypeRS;
			$input['ResourceType'] = $ResourceTypeRS[0]['ResourceType'];
			$fieldsRS = $resourceObject->getResourceFields($input);
			$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
		}		
	}
	if($actionMode=='search')
	{
		//$resourceObject = new ResourceClass();
		//$rs = $resourceObject->getResources($input);
		//$result['DB']['Resources'] = $rs['result']; 
		//$result['pages']['Resources'] = $rs['pages'];
	}
	return $result;
}

function getResourcesByTypes()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	if(!empty($input['type']))
	{
		$CORE->setInputVar('ResourceType',$input['type']);	
		$input['ResourceType'] = $input['type'];
		$resourceTypeObject = new ResourceTypeClass();
		$resourceTemplate = $resourceTypeObject->getResourceTemplate($input['type']);	
		$CORE->setInputVar('ResourceTemplate',$resourceTemplate);	
	}
	//creat objects
	if(!empty($input['category']) || !empty($input['type']) || !empty($input['ResourceType']))
	{			
		$resourceObject = new ResourceClass();

		$resourceCategory = new ResourceCategoryClass();
		$rs = $resourceCategory->getResourceCategory($input);		
		$result['DB']['ResourceCategory'] = $rs[0];
		$categoryID = $rs[0]['ResourceCategoryID'];

		if(!empty($categoryID))
		{
			$input['CategoryID']=$categoryID;
			$typesRS = $resourceCategory->getResourceCategoryTypes($input);	
			//print_r($typesRS);
			if(is_array($typesRS))
			{
				foreach($typesRS as $typeRS)
				{
					$resourceTypeCurrent = $typeRS['ResourceType'];
					if(empty($typeCheck[$resourceTypeCurrent]))
					{
						$newTypesRS[] = $typeRS;
						$typeCheck[$resourceTypeCurrent]=1;
					}
				}
			}
			$typesRS = '';
			$typesRS = $newTypesRS;
			//print_r($typesRS);
			$result['DB']['ResourceCategoryTypes'] = $typesRS;
		}
		if(!empty($input['type']))
		{
			$rs = $resourceObject->getResources($input);
			$result['DB']['Resources'] = $rs['result']; 			
			$result['pages']['Resources'] = $rs['pages']; 	
		}
		else
		{
			if(is_array($typesRS))
			{
				foreach($typesRS as $row)
				{
					$input['ItemsPerPage'] = $config['CategoryTopResourcesNumber'];
					if(empty($input['ItemsPerPage'])) {$input['ItemsPerPage']=10;}
					$typeCode = $row['ResourceTypeAlias'];
					$input['ResourceType'] = $typeCode;
					if($config['CategoryTopResourceMode']=='topcheckbox')
					{
						$input['featuredMode']='top10';
					}
					elseif($config['CategoryTopResourceMode']=='toplisting')
					{
					}
					else
					{
						$input['featuredMode']='top10';
					}
					$rs='';
					$rs = $resourceObject->getResources($input);
					//echo '<hr>';
					$result['DB']['Resources'][$typeCode] = $rs['result'];
					$result['pages']['Resources'][$typeCode] = $rs['pages'];
					$result['DB']['ResourceTypeNames'][$typeCode] = $row['ResourceTypeName'];
				}
			}
		}
		/*
		$result['DB']['Tabs'][0]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][0]['TabLinkName'] = 'Top 10';
		$result['DB']['Tabs'][1]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][1]['TabLinkName'] = 'Featured';
		$result['DB']['Tabs'][2]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][2]['TabLinkName'] = 'Catalog';	
		$result['DB']['Tabs'][3]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][3]['TabLinkName'] = 'Classifieds';
		$result['DB']['Tabs'][4]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][4]['TabLinkName'] = 'Links';
		$result['DB']['Tabs'][5]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][5]['TabLinkName'] = 'News';	
		$result['DB']['Tabs'][6]['TabLinkValue'] = 'products';
		$result['DB']['Tabs'][6]['TabLinkName'] = 'Tips';										
		*/
	}

	return $result;
}


function getResourcesFeatured()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$ResourceType = new ResourceTypeClass();
	$resourceObject = new ResourceClass();
	
	//print_r($input);
	if(empty($input['featuredMode'])) {$input['featuredMode']='home';}
	
	$input['resourceTypesPlace'] = $input['featuredMode'];


	$typesRS = $ResourceType->getResourceTypes($input);	
	$result['DB']['ResourceTypes'] = $typesRS;

	if(is_array($typesRS))
	{
		foreach($typesRS as $row)
		{
			$typeCode = $row['ResourceTypeAlias'];
			$input['ItemsPerPage']=10;
			$input['ResourceType'] = $typeCode;
			$rs = $resourceObject->getResources($input);
			if(is_array($rs['result']))
			{
				$result['DB']['Resources'][$typeCode] = $rs['result'];
			}
			//$result['pages']['Resources'][$typeCode] = $rs['pages'];
			$result['DB']['ResourceTypeNames'][$typeCode] = $row['ResourceTypeName'];
		}
	}

	return $result;
}

function getResource()
{ 
	global $CORE;
	$DS = new DataSource('main');
 
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$resourceObject = new ResourceClass();
	$rs = $resourceObject->getResource($input);
	$result['DB']['Resource'] = $rs[0];
	$input['ResourceType'] = $rs[0]['ResourceType'];

  if(!empty($input['ResourceType']))
	{
		$resourceTypeObject = new ResourceTypeClass();
		$typeRS = $resourceTypeObject->getResourceType($input);
		$resourceTypeAction =$typeRS[0]['ResourceTypeAction'];
		$CORE->setInputVar('ResourceTypeAction',$resourceTypeAction);
		
		$input['viewMode']='viewresource';
		$fieldsRS = $resourceObject->getResourceFields($input);
		$result['DB']['ResourceFieldTypes'] = $fieldsRS['ResourceFieldTypes'];
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
		$result['DB']['ResourceOption'] = $fieldsRS['ResourceOption'];

    if($input['ResourceID'])
    {
        $imgTxt = $DS->query("SELECT * FROM ImageText WHERE ImageTextID=" . $input['ResourceID']);
        $result['DB']['ImageText'] = $imgTxt[0]['fullText'];
       
    }
		if($resourceTypeAction=='sellbid' || $resourceTypeAction=='buybid')
		{
			$resourceBid = new ResourceBidClass();
			$bidStat = $resourceBid->getResourceBidStats($input);
			$result['Vars'] =$bidStat;
			
			$BidsUsers = $resourceObject->getBidsUsers($input);
			$result['DB']['BidUsers'] = $BidsUsers;
		}
	}
	
	$resourceCategory = new ResourceCategoryClass();
	$CORE->setInputVar('ResourceType',$rs[0]['ResourceType']);	
		

	$CORE->setInputVar('type',$rs[0]['ResourceType']);
	$typesRS = $resourceCategory->getResourceCategoryTypes($input);	
	if(is_array($typesRS))
	{
		foreach($typesRS as $typeRS)
		{
			$resourceTypeCurrent = $typeRS['ResourceType'];
			if(empty($typeCheck[$resourceTypeCurrent]))
			{
				$newTypesRS[] = $typeRS;
				$typeCheck[$resourceTypeCurrent]=1;
			}
		}
	}
	$typesRS = '';
	$typesRS = $newTypesRS;
	$result['DB']['ResourceCategoryTypes'] = $typesRS;		

	$categories = $resourceCategory->getResourceCategory($input);
	$result['DB']['ResourceCategory'] = $categories[0];

	//print_r($result['DB']['ResourceCategoryDescription']);	
	return $result;
}


function getResourceSEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$resourceObject = new ResourceClass();
	$rs = $resourceObject->getResource($input);
	$result['DB']['Resource'] = $rs[0];
	return $result;
}

function updateAllResourceCategoryStats()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ResourceType = $input['ResourceType'];
	if(!empty($ResourceType))
	{
		$resourceObject = new ResourceClass();
		$rs = $resourceObject->updateAllResourceCategoryStats($ResourceType);
	}
	return $result;
}

?>
