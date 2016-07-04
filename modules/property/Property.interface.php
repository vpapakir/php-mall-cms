<?php
function manageProperties()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();

	
	//$input2 = $CORE->getInput();
	//print_r($input);
//echo 'rrrrr='.$input['PropertyType'];
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['PropertyID'];
	$propertyObject = new PropertyClass();
	$propertyTypeObject = new PropertyTypeClass();

	if($input['actionMode']=='delete')
	{
		$propertyObject->deleteProperty($input);
		//$PropertyType->deletePropertyField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Property'.DTR.'PropertyID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Property WHERE PropertyID='".$input['Property'.DTR.'PropertyID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Property'.DTR.$fileField][$lang]=' ';}else{	$input['Property'.DTR.$fileField]=' ';}
			$input['Property'.DTR.$fileField]=' ';

			$input['actionMode']='save';
			$propertyObject->setProperty($input);
		}
	}
	elseif($input['actionMode']=='save')
	{
		//update list of items
	    if(is_array($input['Property'.DTR.'PropertyID']))
		{
			foreach($input['Property'.DTR.'PropertyID'] as $id=>$value)
			{
				$updateCats='N';
				if($clientType=='admin')
				{
					if($input['Property'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['Property'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['Property'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM Property WHERE PropertyID='".$input['Property'.DTR.'PropertyID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['Property'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['Property'.DTR.'PropertyStatus'][$id]!='active')
					{
						$inputSave['Property'.DTR.'PropertyStatus'] = 'hidden';
					}
					else
					{
						$inputSave['Property'.DTR.'PropertyStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT PropertyStatus FROM Property WHERE PropertyID='".$input['Property'.DTR.'PropertyID'][$id]."'");
					if($oldRS[0]['PropertyStatus']!=$inputSave['Property'.DTR.'PropertyStatus']) {$updateCats='Y';}
				}			
				$inputSave['Property'.DTR.'PropertyID'] = $input['Property'.DTR.'PropertyID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Property'] = "PropertyID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Property'.DTR.'PropertyID'].' perm='.$inputSave['Property'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1' || $input['actionMode']=='add1' || $input['actionMode']=='save2')
	{
	
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Property',array('previewFieldName'=>'PropertyImagePreview','fullFieldName'=>'PropertyImage'));	
		$saveRS = $propertyObject->setProperty($input);
		$entityID = $saveRS[0]['PropertyID'];
		$input['Property'.DTR.'PropertyID'] = $entityID;		
	}

	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $propertyObject->getProperty($input);
		$result['DB']['Property'] = $sectionRS;
		if(empty($input['PropertyType'])  && $config['CategoryUseType']!='N')
		{
			$input['PropertyType'] = $sectionRS[0]['PropertyType'];
		}
	}	
	else
	{
		$propertyTemplate = $propertyTypeObject->getPropertyTemplate($input['PropertyType']);	
		$CORE->setInputVar('ResourceTemplate',$propertyTemplate);	
	}

	if(!empty($input['PropertyType']))
	{
		$fieldsRS = $propertyObject->getPropertyFields($input);
		//$result['DB']['PropertyFieldTypes'] = $fieldsRS['PropertyFieldTypes'];
		$result['DB']['PropertyField'] = $fieldsRS['PropertyField'];
		//$result['DB']['PropertyOption'] = $fieldsRS['PropertyOption'];
		//print_r($result['DB']['PropertyOption']);		
	}

	//get properties 
	$entityRS = $propertyObject->getProperties($input);
	$result['DB']['Properties'] = $entityRS['result'];
	$result['pages']['Properties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
		
	$CORE->setInputVar('ReferenceCode','PropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	
	if(!empty($input['PropertyResource'.DTR.'PropertyResourceID']) || !empty($input['PropertyResourceID']))
	{
		$result['DB']['PropertyResource'] = $propertyObject->getPropertyResource($input);
	}
	
	$result['DB']['PropertyResourcies']= $propertyObject->getPropertyResourcies($input);
	
	if($clientType!='admin')
	{
		$input['propertyTypesPlace']='submit';
	}
	$result['DB']['PropertyTypes']= $propertyTypeObject->getPropertyTypes($input);

	//return result array
	return $result;
}

function manageProperty()
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
	
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['PropertyID'];
	$propertyObject = new PropertyClass();
	$propertyTypeObject = new PropertyTypeClass();
	
	//$section = new PropertyClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$propertyObject->deleteProperty($input);
		//$PropertyType->deletePropertyField($input);
	}
	elseif($input['actionMode']=='deleterelated')
	{
		$PropertyRelationObject = new PropertyRelationClass();
		$PropertyRelationObject->deletePropertyRelation($input);
	}	
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Property'.DTR.'PropertyID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Property WHERE PropertyID='".$input['Property'.DTR.'PropertyID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Property'.DTR.$fileField][$lang]=' ';}else{	$input['Property'.DTR.$fileField]=' ';}
			$input['Property'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$propertyObject->setProperty($input);
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();
		if(!empty($input['PropertyResource'.DTR.'PropertyResourceName'][$config['lang']]))
			{
				$input = $FM->getUploadedFields($input,'PropertyResource',array('previewFieldName'=>'PropertyResourceIcon','fullFieldName'=>'PropertyResourceImage'));
			}
				else
					{
						$input = $FM->getUploadedFields($input,'Property',array('previewFieldName'=>'PropertyImagePreview','fullFieldName'=>'PropertyImage'));	
					}
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $propertyObject->setProperty($input);
		$entityID = $saveRS[0]['PropertyID'];
		$input['Property'.DTR.'PropertyID'] = $entityID;	
	}		

	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $propertyObject->getProperty($input);
		$result['DB']['Property'] = $sectionRS;
		if(empty($input['PropertyType']))
		{
			$input['PropertyType'] = $sectionRS[0]['PropertyType'];
		}
		//$PropertyRelationObject = new PropertyRelationClass();
		//$result['DB']['PropertyRelations'] = $PropertyRelationObject->getPropertyRelations($input);
	}	
	else
	{
		$propertyTemplate = $propertyTypeObject->getPropertyTemplate($input['PropertyType']);	
		$CORE->setInputVar('PropertyTemplate',$propertyTemplate);	
	}

	if(!empty($input['PropertyType']))
	{
		$fieldsRS = $propertyObject->getPropertyFields($input);
		//$result['DB']['PropertyFieldTypes'] = $fieldsRS['PropertyFieldTypes'];
		$result['DB']['PropertyField'] = $fieldsRS['PropertyField'];
		//$result['DB']['PropertyOption'] = $fieldsRS['PropertyOption'];
		//print_r($result['DB']['PropertyOption']);		
	}

	//get properties 
	$entityRS = $propertyObject->getProperties($input);
	$result['DB']['Properties'] = $entityRS['result'];
	$result['pages']['Properties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	if($clientType!='admin')
	{
		$input['propertyTypesPlace']='submit';
	}
	$result['DB']['PropertyTypes']= $propertyTypeObject->getPropertyTypes($input);
	
	if(!empty($input['PropertyResource'.DTR.'PropertyResourceID']) || !empty($input['PropertyResourceID']))
	{
		$result['DB']['PropertyResource'] = $propertyObject->getPropertyResource($input);
	}
	
	
	$CORE->setInputVar('ReferenceCode','PropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];

	$result['DB']['PropertyResourcies']= $propertyObject->getPropertyResourcies($input);
	//return result array
	return $result;
}

function addProperty($input='')
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
	$entityID = $input['PropertyID'];
	$propertyObject = new PropertyClass();
	$propertyTypeObject = new PropertyTypeClass();
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
		$input = $FM->getUploadedFields($input,'Property',array('previewFieldName'=>'PropertyImagePreview','fullFieldName'=>'PropertyImage'));	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $propertyObject->setProperty($input);
		$entityID = $saveRS[0]['PropertyID'];
		$input['Property'.DTR.'PropertyID'] = $entityID;			
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
		$sectionRS = $propertyObject->getProperty($input);
		$result['DB']['Property'] = $sectionRS;
		if(empty($input['PropertyType']))
		{
			$input['PropertyType'] = $sectionRS[0]['PropertyType'];
		}
	}	
	else
	{
		$propertyTemplate = $propertyTypeObject->getPropertyTemplate($input['PropertyType']);	
		$CORE->setInputVar('PropertyTemplate',$propertyTemplate);	
	}
	if(!empty($input['PropertyType']))
	{
		$fieldsRS = $propertyObject->getPropertyFields($input);
		$result['DB']['PropertyField'] = $fieldsRS['PropertyField'];
	}
	//get properties 
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
		
	$input['propertyTypesPlace']='submit';
	$result['DB']['PropertyTypes']= $propertyTypeObject->getPropertyTypes($input);
	//return result array
	return $result;
}

function getProperties($input='')
{
	global $CORE;
	//get input
	if(empty($input))$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$propertyTypeObject = new PropertyTypeClass();
	$propertyObject1 = new PropertyClass();
	$rs=$propertyObject1->getProperties($input);
	$result['DB']['Properties']=$rs['result'];
	$result['pages']['Properties']['total']=count($rs['result']);
	
	//creat objects
	if($config['PageViewType']=='showproperties' && empty($input['category']))
	{
		$input['category'] = $input['SID'];
		$CORE->setInputVar('category',$input['category']);
	}
	if(!empty($input['category']) || !empty($input['searchWord']) || !empty($input['CategoryID'])  || !empty($input['PropertyType'])  || !empty($input['type']) || !empty($input['location']) || !empty($input['PropertyID']))
	{		
		if(!empty($input['featuredMode']))
		{
			$input['propertyTypesPlace'] = $input['featuredMode'];
		}	
		$propertyObject = new PropertyClass();
		$rs = $propertyObject->getProperties($input);
		$result['DB']['Properties'] = $rs['result']; 
		$result['pages']['Properties'] = $rs['pages'];
		if($config['PageViewType']=='showproperties')
		{
			$propertyType = $config['PagePropertyType'];
		}
		if(!empty($propertyType))
		{
			$propertyTypeObject = new PropertyTypeClass();
			$propertyTemplate = $propertyTypeObject->getPropertyTemplate($propertyType);	
			$CORE->setInputVar('PropertyTemplate',$propertyTemplate);	
		}							
	}
	
	$result['DB']['PropertyTypes']= $propertyTypeObject->getPropertyTypes($input);
	
	return $result;
}

function searchProperties()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$category = $input['category'];
	$propertyObject = new PropertyClass();
	$PropertyType = new PropertyTypeClass();
	$DS = new DataSource('main');
	$actionMode = $input['actionMode'];
	//creat objects
	if(!empty($category) || !empty($input['searchWord']) || !empty($input['CategoryID']))
	{			
	}
	if($actionMode=='search')
	{
		//$propertyObject = new PropertyClass();
		//$rs = $propertyObject->getProperties($input);
		//$result['DB']['Properties'] = $rs['result']; 
		//$result['pages']['Properties'] = $rs['pages'];
	}
	return $result;
}

function getPropertiesByTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	if(!empty($input['type']))
	{
		$CORE->setInputVar('PropertyType',$input['type']);	
		$input['PropertyType'] = $input['type'];
		$propertyTypeObject = new PropertyTypeClass();
		$propertyTemplate = $propertyTypeObject->getPropertyTemplate($input['type']);	
		$CORE->setInputVar('PropertyTemplate',$propertyTemplate);	
	}
	//creat objects
	if(!empty($input['category']) || !empty($input['type']) || !empty($input['PropertyType']))
	{			
		$propertyObject = new PropertyClass();
		
		if(!empty($input['type']))
		{
			$rs = $propertyObject->getProperties($input);
			$result['DB']['Properties'] = $rs['result']; 			
			$result['pages']['Properties'] = $rs['pages']; 	
		}
		else
		{
			if(is_array($typesRS))
			{
				foreach($typesRS as $row)
				{
					$input['ItemsPerPage'] = $config['CategoryTopPropertiesNumber'];
					if(empty($input['ItemsPerPage'])) {$input['ItemsPerPage']=10;}
					$typeCode = $row['PropertyTypeAlias'];
					$input['PropertyType'] = $typeCode;
					if($config['CategoryTopPropertyMode']=='topcheckbox')
					{
						$input['featuredMode']='top10';
					}
					elseif($config['CategoryTopPropertyMode']=='toplisting')
					{
					}
					else
					{
						$input['featuredMode']='top10';
					}
					$rs = $propertyObject->getProperties($input);
					$result['DB']['Properties'][$typeCode] = $rs['result'];
					$result['pages']['Properties'][$typeCode] = $rs['pages'];
					$result['DB']['PropertyTypeNames'][$typeCode] = $row['PropertyTypeName'];
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


function getPropertiesFeatured()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$PropertyType = new PropertyTypeClass();
	$propertyObject = new PropertyClass();
	
	//print_r($input);
	if(empty($input['featuredMode'])) {$input['featuredMode']='home';}
	
	$input['propertyTypesPlace'] = $input['featuredMode'];


	$typesRS = $PropertyType->getPropertyTypes($input);	
	$result['DB']['PropertyTypes'] = $typesRS;

	if(is_array($typesRS))
	{
		foreach($typesRS as $row)
		{
			$typeCode = $row['PropertyTypeAlias'];
			$input['ItemsPerPage']=10;
			$input['PropertyType'] = $typeCode;
			$rs = $propertyObject->getProperties($input);
			if(is_array($rs['result']))
			{
				$result['DB']['Properties'][$typeCode] = $rs['result'];
			}
			//$result['pages']['Properties'][$typeCode] = $rs['pages'];
			$result['DB']['PropertyTypeNames'][$typeCode] = $row['PropertyTypeName'];
		}
	}

	return $result;
}

function getProperty()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$propertyObject = new PropertyClass();
	$propertyTypeObject = new PropertyTypeClass();
	$rs = $propertyObject->getProperty($input);
	$result['DB']['Property'] = $rs[0];
	$input['PropertyType'] = $rs[0]['PropertyType'];
	$entityID = $input['PropertyID'];
	if(!empty($input['PropertyType']))
	{

		$input['viewMode']='viewproperty';
		$fieldsRS = $propertyObject->getPropertyFields($input);
		$result['DB']['PropertyFieldTypes'] = $fieldsRS['PropertyFieldTypes'];
		$result['DB']['PropertyField'] = $fieldsRS['PropertyField'];
		$result['DB']['PropertyOption'] = $fieldsRS['PropertyOption'];
		
		/*
		if($input['PropertyType']=='offers')
		{
			$propertyBid = new PropertyBidClass();
			$bidStat = $propertyBid->getPropertyBidStats($input);
			$result['Vars'] =$bidStat;
			
			$BidsUsers = $propertyObject->getBidsUsers($input);
			$result['DB']['BidUsers'] = $BidsUsers;
		}//*/
	}
	
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $propertyObject->getProperty($input);
		$result['DB']['Property'] = $sectionRS;
		if(empty($input['PropertyType']))
		{
			$input['PropertyType'] = $sectionRS[0]['PropertyType'];
		}
		//$PropertyRelationObject = new PropertyRelationClass();
		//$result['DB']['PropertyRelations'] = $PropertyRelationObject->getPropertyRelations($input);
	}	

	//get properties 
	$entityRS = $propertyObject->getProperties($input);
	$result['DB']['Properties'] = $entityRS['result'];
	$result['pages']['Properties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if(!empty($input['PropertyResource'.DTR.'PropertyResourceID']) || !empty($input['PropertyResourceID']))
	{
		$result['DB']['PropertyResource'] = $propertyObject->getPropertyResource($input);
	}
	
	$result['DB']['PropertyTypes']= $propertyTypeObject->getPropertyTypes($input);
	
	$CORE->setInputVar('ReferenceCode','PropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];

	$result['DB']['PropertyResourcies']= $propertyObject->getPropertyResourcies($input);
	
	return $result;
}


function getPropertySEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$propertyObject = new PropertyClass();
	$rs = $propertyObject->getProperty($input);
	$result['DB']['Property'] = $rs[0];
	return $result;
}

?>