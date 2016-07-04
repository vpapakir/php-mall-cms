<?php
function manageReservedProperties()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();

	
	//$input2 = $CORE->getInput();
	//print_r($input);
//echo 'rrrrr='.$input['ReservedPropertyType'];
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['ReservedPropertyID'];
	$reservedPropertyObject = new ReservedPropertyClass();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	
	if($input['actionMode']=='delete')
	{
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyID']))
		{
			$reservedPropertyObject->deleteReservedProperty($input);
		}
			elseif(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']))
				{
					$reservedPropertyObject->deleteReservedProperty($input);
				}
		
		//$ReservedPropertyType->deleteReservedPropertyField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservedProperty WHERE ReservedPropertyID='".$input['ReservedProperty'.DTR.'ReservedPropertyID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['ReservedProperty'.DTR.$fileField][$lang]=' ';}else{	$input['ReservedProperty'.DTR.$fileField]=' ';}
			$input['ReservedProperty'.DTR.$fileField]=' ';

			$input['actionMode']='save';
			$reservedPropertyObject->setReservedProperty($input);
		}
		elseif(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservedPropertyResource WHERE ReservedPropertyResourceID='".$input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['ReservedProperty'.DTR.$fileField][$lang]=' ';}else{	$input['ReservedProperty'.DTR.$fileField]=' ';}
			$input['ReservedPropertyResource'.DTR.$fileField]=' ';
			
			
			
			$input['actionMode']='save';
			$reservedPropertyObject->setReservedPropertyResource($input);
		}
	}
	elseif($input['actionMode']=='save')
	{
		//update list of items
	    if(is_array($input['ReservedProperty'.DTR.'ReservedPropertyID']))
		{
			foreach($input['ReservedProperty'.DTR.'ReservedPropertyID'] as $id=>$value)
			{
				$updateCats='N';
				if($clientType=='admin')
				{
					if($input['ReservedProperty'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['ReservedProperty'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['ReservedProperty'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM ReservedProperty WHERE ReservedPropertyID='".$input['ReservedProperty'.DTR.'ReservedPropertyID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['ReservedProperty'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['ReservedProperty'.DTR.'ReservedPropertyStatus'][$id]!='active')
					{
						$inputSave['ReservedProperty'.DTR.'ReservedPropertyStatus'] = 'hidden';
					}
					else
					{
						$inputSave['ReservedProperty'.DTR.'ReservedPropertyStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT ReservedPropertyStatus FROM ReservedProperty WHERE ReservedPropertyID='".$input['ReservedProperty'.DTR.'ReservedPropertyID'][$id]."'");
					if($oldRS[0]['ReservedPropertyStatus']!=$inputSave['ReservedProperty'.DTR.'ReservedPropertyStatus']) {$updateCats='Y';}
				}			
				$inputSave['ReservedProperty'.DTR.'ReservedPropertyID'] = $input['ReservedProperty'.DTR.'ReservedPropertyID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['ReservedProperty'] = "ReservedPropertyID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['ReservedProperty'.DTR.'ReservedPropertyID'].' perm='.$inputSave['ReservedProperty'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1' || $input['actionMode']=='add1' || $input['actionMode']=='save2')
	{
	
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'ReservedProperty',array('previewFieldName'=>'ReservedPropertyImagePreview','fullFieldName'=>'ReservedPropertyImage'));	
		$saveRS = $reservedPropertyObject->setReservedProperty($input);
		$entityID = $saveRS[0]['ReservedPropertyID'];
		$input['ReservedProperty'.DTR.'ReservedPropertyID'] = $entityID;		
	}
	elseif($input['actionMode']=='update')
	{
		$saveRS = $reservedPropertyObject->updateReservedPropertyResourcePosition($input);
	}
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $reservedPropertyObject->getReservedProperty($input);
		$result['DB']['ReservedProperty'] = $sectionRS;
		if(empty($input['ReservedPropertyType'])  && $config['CategoryUseType']!='N')
		{
			$input['ReservedPropertyType'] = $sectionRS[0]['ReservedPropertyType'];
		}
	}	
	else
	{
		$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($input['ReservedPropertyType']);	
		$CORE->setInputVar('ResourceTemplate',$reservedPropertyTemplate);	
	}

	$fieldsRS = $reservedPropertyObject->getReservedPropertyFields($input);
	$result['DB']['ReservedPropertyField'] = $fieldsRS['ReservedPropertyField'];

	//get reservedProperties 
	$entityRS = $reservedPropertyObject->getReservedProperties($input);
	$result['DB']['ReservedProperties'] = $entityRS['result'];
	$result['pages']['ReservedProperties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
		
	$CORE->setInputVar('ReferenceCode','ReservedPropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	
	if(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']) || !empty($input['ReservedPropertyResourceID']))
	{
		$result['DB']['ReservedPropertyResource'] = $reservedPropertyObject->getReservedPropertyResource($input);
	}
	
	$result['DB']['ReservedPropertyResourcies']= $reservedPropertyObject->getReservedPropertyResourcies($input);
	
	if($clientType!='admin')
	{
		$input['reservedPropertyTypesPlace']='submit';
	}
	$result['DB']['ReservedPropertyTypes']= $reservedPropertyTypeObject->getReservedPropertyTypes($input);

	//return result array
	return $result;
}

function manageReservedProperty()
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
	$entityID = $input['ReservedPropertyID'];
	$reservedPropertyObject = new ReservedPropertyClass();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	//print_r($input);
	
	//$section = new ReservedPropertyClass();
	//delete item
	
	if($input['actionMode']=='delete')
	{
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyID']))
		{
			$reservedPropertyObject->deleteReservedProperty($input);
		}
			elseif(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']))
				{
					$reservedPropertyObject->deleteReservedPropertyResource($input);
				}
		
		//$ReservedPropertyType->deleteReservedPropertyField($input);
	}
	elseif($input['actionMode']=='pay')
	{
		$paymentResult = $reservedPropertyObject->buyReservedProperty($input);
		$result['Payment'] = $paymentResult;
	}		
	elseif($input['actionMode']=='deletefile')
	{
		
		if(!empty($input['ReservedProperty'.DTR.'ReservedPropertyID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservedProperty WHERE ReservedPropertyID='".$input['ReservedProperty'.DTR.'ReservedPropertyID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['ReservedProperty'.DTR.$fileField][$lang]=' ';}else{	$input['ReservedProperty'.DTR.$fileField]=' ';}
			$input['ReservedProperty'.DTR.$fileField]=' ';

			$input['actionMode']='save';
			$reservedPropertyObject->setReservedProperty($input);
		}
			elseif(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']) && !empty($input['fileField']))
			{
				$FM = new FilesManager();
				$fileField =$input['fileField'];
				$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservedPropertyResource WHERE ReservedPropertyResourceID='".$input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']."'");
				$lang = $input['lang'];
				$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
				$FM->deleteFile($filePath);
				//if(!empty($lang)){	$input['ReservedProperty'.DTR.$fileField][$lang]=' ';}else{	$input['ReservedProperty'.DTR.$fileField]=' ';}
				$input['ReservedPropertyResource'.DTR.$fileField]=' ';
				
				$input['actionMode']='save';
				$reservedPropertyObject->setReservedPropertyResource($input);
			}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();

		$uploadFile = $input['uploadFile'];
		if($input['viewMode']=='resources' && !empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourcePosition']))
		{
			$input = $FM->getUploadedFields($input,'ReservedPropertyResource',array('previewFieldName'=>'ReservedPropertyResourcePreviewImage','fullFieldName'=>'ReservedPropertyResourceImage'));
		}
		else
		{
			$input = $FM->getUploadedFields($input,'ReservedProperty',array('previewFieldName'=>'ReservedPropertyImagePreview','fullFieldName'=>'ReservedPropertyImage'));	
		}
		
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $reservedPropertyObject->setReservedProperty($input);
		if(!empty($saveRS[0]['ReservedPropertyID']))
		{
			$entityID = $saveRS[0]['ReservedPropertyID'];
			$input['ReservedProperty'.DTR.'ReservedPropertyID'] = $entityID;	
		}
		$reservedPropertyObject->setReservedPropertyResource($input);
	}		
	elseif($input['actionMode']=='updateposition')
	{
		$reservedPropertyObject->setReservedPropertyResourcePosition($input);
	}
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $reservedPropertyObject->getReservedProperty($input);
		$result['DB']['ReservedProperty'] = $sectionRS;
		if(empty($input['ReservedPropertyType']))
		{
			$input['ReservedPropertyType'] = $sectionRS[0]['ReservedPropertyType'];
		}
		//$ReservedPropertyRelationObject = new ReservedPropertyRelationClass();
		//$result['DB']['ReservedPropertyRelations'] = $ReservedPropertyRelationObject->getReservedPropertyRelations($input);
	}	
	else
	{
		$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($input['ReservedPropertyType']);	
		$CORE->setInputVar('ReservedPropertyTemplate',$reservedPropertyTemplate);	
	}

	$fieldsRS = $reservedPropertyObject->getReservedPropertyFields($input);
	$result['DB']['ReservedPropertyField'] = $fieldsRS['ReservedPropertyField'];

	//get reservedProperties 
	$entityRS = $reservedPropertyObject->getReservedProperties($input);
	$result['DB']['ReservedProperties'] = $entityRS['result'];
	$result['pages']['ReservedProperties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	if($clientType!='admin')
	{
		$input['reservedPropertyTypesPlace']='submit';
	}
	$result['DB']['ReservedPropertyTypes']= $reservedPropertyTypeObject->getReservedPropertyTypes($input);
	
	if(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']) || !empty($input['ReservedPropertyResourceID']))
	{
		$result['DB']['ReservedPropertyResource'] = $reservedPropertyObject->getReservedPropertyResource($input);
	}
	
	
	$CORE->setInputVar('ReferenceCode','ReservedPropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];

	$result['DB']['ReservedPropertyResourcies']= $reservedPropertyObject->getReservedPropertyResourcies($input);
	//return result array
	//print_r($result);
	return $result;
}

function addReservedProperty($input='')
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
	$entityID = $input['ReservedPropertyID'];
	$reservedPropertyObject = new ReservedPropertyClass();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	
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
		$input = $FM->getUploadedFields($input,'ReservedProperty',array('previewFieldName'=>'ReservedPropertyImagePreview','fullFieldName'=>'ReservedPropertyImage'));	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $reservedPropertyObject->setReservedProperty($input);
		$entityID = $saveRS[0]['ReservedPropertyID'];
		$input['ReservedProperty'.DTR.'ReservedPropertyID'] = $entityID;			
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
		$sectionRS = $reservedPropertyObject->getReservedProperty($input);
		$result['DB']['ReservedProperty'] = $sectionRS;
		if(empty($input['ReservedPropertyType']))
		{
			$input['ReservedPropertyType'] = $sectionRS[0]['ReservedPropertyType'];
		}
	}	
	else
	{
		$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($input['ReservedPropertyType']);	
		$CORE->setInputVar('ReservedPropertyTemplate',$reservedPropertyTemplate);	
	}
	
	$fieldsRS = $reservedPropertyObject->getReservedPropertyFields($input);
	$result['DB']['ReservedPropertyField'] = $fieldsRS['ReservedPropertyField'];
	//get reservedProperties 
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
		
	$input['reservedPropertyTypesPlace']='submit';
	$result['DB']['ReservedPropertyTypes']= $reservedPropertyTypeObject->getReservedPropertyTypes($input);
	//return result array
	return $result;
}

function getReservedProperties($input='')
{
	global $CORE;
	//get input

	if(empty($input))$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	$reservedPropertyObject1 = new ReservedPropertyClass();
	
	//$rs=$reservedPropertyObject1->getReservedProperties($input);
	//$result['DB']['ReservedProperties']=$rs['result'];
	//$result['pages']['ReservedProperties']['total']=count($rs['result']);
	//creat objects
	//die('');
	if(!empty($input['featuredMode']) || !empty($input['searchWord']) || !empty($input['ReservedPropertyType'])  || !empty($input['type']) || !empty($input['location']) || !empty($input['ReservedPropertyID']))
	{		
		
	}
	else
	{
		$input['filterMode']='top';
	}
	if(!empty($input['featuredMode']))
	{
		$input['reservedPropertyTypesPlace'] = $input['featuredMode'];
	}	
	$reservedPropertyObject = new ReservedPropertyClass();
	$rs = $reservedPropertyObject->getReservedProperties($input);
	$result['DB']['ReservedProperties'] = $rs['result']; 
	$result['pages']['ReservedProperties'] = $rs['pages'];
	
	if($config['PageViewType']=='showreservedProperties')
	{
		$reservedPropertyType = $config['PageReservedPropertyType'];
	}
	if(!empty($reservedPropertyType))
	{
		$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
		$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($reservedPropertyType);	
		$CORE->setInputVar('ReservedPropertyTemplate',$reservedPropertyTemplate);	
	}							
	$result['DB']['ReservedPropertyTypes']= $reservedPropertyTypeObject->getReservedPropertyTypes($input);
	
	return $result;
}

function searchReservedProperties()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$category = $input['category'];
	$reservedPropertyObject = new ReservedPropertyClass();
	$ReservedPropertyType = new ReservedPropertyTypeClass();
	$DS = new DataSource('main');
	$actionMode = $input['actionMode'];
	//creat objects
	
	if(!empty($category) || !empty($input['searchWord']) || !empty($input['CategoryID']))
	{			
	}
	if($actionMode=='search')
	{
		//$reservedPropertyObject = new ReservedPropertyClass();
		//$rs = $reservedPropertyObject->getReservedProperties($input);
		//$result['DB']['ReservedProperties'] = $rs['result']; 
		//$result['pages']['ReservedProperties'] = $rs['pages'];
	}
	return $result;
}

function getReservedPropertiesByTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	
	
	if(!empty($input['type']))
	{
		$CORE->setInputVar('ReservedPropertyType',$input['type']);	
		$input['ReservedPropertyType'] = $input['type'];
		$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
		$reservedPropertyTemplate = $reservedPropertyTypeObject->getReservedPropertyTemplate($input['type']);	
		$CORE->setInputVar('ReservedPropertyTemplate',$reservedPropertyTemplate);	
	}
	//creat objects
	if(!empty($input['category']) || !empty($input['type']) || !empty($input['ReservedPropertyType']))
	{			
		$reservedPropertyObject = new ReservedPropertyClass();
		
		if(!empty($input['type']))
		{
			$rs = $reservedPropertyObject->getReservedProperties($input);
			$result['DB']['ReservedProperties'] = $rs['result']; 			
			$result['pages']['ReservedProperties'] = $rs['pages']; 	
		}
		else
		{
			if(is_array($typesRS))
			{
				foreach($typesRS as $row)
				{
					$input['ItemsPerPage'] = $config['CategoryTopReservedPropertiesNumber'];
					if(empty($input['ItemsPerPage'])) {$input['ItemsPerPage']=10;}
					$typeCode = $row['ReservedPropertyTypeAlias'];
					$input['ReservedPropertyType'] = $typeCode;
					if($config['CategoryTopReservedPropertyMode']=='topcheckbox')
					{
						$input['featuredMode']='top10';
					}
					elseif($config['CategoryTopReservedPropertyMode']=='toplisting')
					{
					}
					else
					{
						$input['featuredMode']='top10';
					}
					$rs = $reservedPropertyObject->getReservedProperties($input);
					$result['DB']['ReservedProperties'][$typeCode] = $rs['result'];
					$result['pages']['ReservedProperties'][$typeCode] = $rs['pages'];
					$result['DB']['ReservedPropertyTypeNames'][$typeCode] = $row['ReservedPropertyTypeName'];
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


function getReservedPropertiesFeatured()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	

	$ReservedPropertyType = new ReservedPropertyTypeClass();
	$reservedPropertyObject = new ReservedPropertyClass();
	
	//print_r($input);
	if(empty($input['featuredMode'])) {$input['featuredMode']='home';}
	
	$input['reservedPropertyTypesPlace'] = $input['featuredMode'];


	$typesRS = $ReservedPropertyType->getReservedPropertyTypes($input);	
	$result['DB']['ReservedPropertyTypes'] = $typesRS;

	if(is_array($typesRS))
	{
		foreach($typesRS as $row)
		{
			$typeCode = $row['ReservedPropertyTypeAlias'];
			$input['ItemsPerPage']=10;
			$input['ReservedPropertyType'] = $typeCode;
			$rs = $reservedPropertyObject->getReservedProperties($input);
			if(is_array($rs['result']))
			{
				$result['DB']['ReservedProperties'][$typeCode] = $rs['result'];
			}
			//$result['pages']['ReservedProperties'][$typeCode] = $rs['pages'];
			$result['DB']['ReservedPropertyTypeNames'][$typeCode] = $row['ReservedPropertyTypeName'];
		}
	}

	return $result;
}

function getReservedProperty()
{
	global $CORE;
	//get input
	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$reservedPropertyObject = new ReservedPropertyClass();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	$rs = $reservedPropertyObject->getReservedProperty($input);
	$result['DB']['ReservedProperty'] = $rs[0];
	$input['ReservedPropertyType'] = $rs[0]['ReservedPropertyType'];
	$entityID = $input['ReservedPropertyID'];
	if(!empty($input['ReservedPropertyType']))
	{

		$input['viewMode']='viewreservedProperty';
		$fieldsRS = $reservedPropertyObject->getReservedPropertyFields($input);
		$result['DB']['ReservedPropertyFieldTypes'] = $fieldsRS['ReservedPropertyFieldTypes'];
		$result['DB']['ReservedPropertyField'] = $fieldsRS['ReservedPropertyField'];
		$result['DB']['ReservedPropertyOption'] = $fieldsRS['ReservedPropertyOption'];
		
		/*
		if($input['ReservedPropertyType']=='offers')
		{
			$reservedPropertyBid = new ReservedPropertyBidClass();
			$bidStat = $reservedPropertyBid->getReservedPropertyBidStats($input);
			$result['Vars'] =$bidStat;
			
			$BidsUsers = $reservedPropertyObject->getBidsUsers($input);
			$result['DB']['BidUsers'] = $BidsUsers;
		}//*/
	}
	
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $reservedPropertyObject->getReservedProperty($input);
		$result['DB']['ReservedProperty'] = $sectionRS;
		if(empty($input['ReservedPropertyType']))
		{
			$input['ReservedPropertyType'] = $sectionRS[0]['ReservedPropertyType'];
		}
		//$ReservedPropertyRelationObject = new ReservedPropertyRelationClass();
		//$result['DB']['ReservedPropertyRelations'] = $ReservedPropertyRelationObject->getReservedPropertyRelations($input);
	}	

	//get reservedProperties 
	$entityRS = $reservedPropertyObject->getReservedProperties($input);
	$result['DB']['ReservedProperties'] = $entityRS['result'];
	$result['pages']['ReservedProperties'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if(!empty($input['ReservedPropertyResource'.DTR.'ReservedPropertyResourceID']) || !empty($input['ReservedPropertyResourceID']))
	{
		$result['DB']['ReservedPropertyResource'] = $reservedPropertyObject->getReservedPropertyResource($input);
	}
	
	$result['DB']['ReservedPropertyTypes']= $reservedPropertyTypeObject->getReservedPropertyTypes($input);
	
	//$methodsRS = $CORE->callService('managePayments','billingServer',$input);
	//$result['DB']['PaymentMethods'] = $methodsRS['DB']['PaymentMethods'];	
	
	$CORE->setInputVar('ReferenceCode','ReservedPropertyResourceType');
	$ReferenceRS = $CORE->callService('manageReferences','coreServer');
	$result['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];
	$input['DB']['Reference'] = $ReferenceRS['DB']['ReferenceOptions'];

	$result['DB']['ReservedPropertyResourcies']= $reservedPropertyObject->getReservedPropertyResourcies($input);
	
	return $result;
}


function getReservedPropertyResource()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$reservedPropertyObject = new ReservedPropertyClass();
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	$rs = $reservedPropertyObject->getReservedPropertyResource($input);
	$result['DB']['ReservedPropertyResource'] = $rs;
	
	return $result;
}
function getReservedPropertySEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$reservedPropertyObject = new ReservedPropertyClass();
	$rs = $reservedPropertyObject->getReservedProperty($input);
	$result['DB']['ReservedProperty'] = $rs[0];
	return $result;
}

?>