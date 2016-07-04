<?php
function manageDomains()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();

	
	//$input2 = $CORE->getInput();
	//print_r($input);
//echo 'rrrrr='.$input['DomainType'];
	
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['DomainID'];
	$DomainObject = new DomainClass();
	$DomainTypeObject = new DomainTypeClass();
	if($input['actionMode']=='delete')
	{
		$DomainObject->deleteDomain($input);
		//$DomainType->deleteDomainField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Domain'.DTR.'DomainID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Domain WHERE DomainID='".$input['Domain'.DTR.'DomainID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Domain'.DTR.$fileField][$lang]=' ';}else{	$input['Domain'.DTR.$fileField]=' ';}
			$input['Domain'.DTR.$fileField]=' ';

			$input['actionMode']='save';
			$DomainObject->setDomain($input);
		}
	}
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['Domain'.DTR.'DomainID']))
		{
			foreach($input['Domain'.DTR.'DomainID'] as $id=>$value)
			{
				if($clientType=='admin')
				{
					if($input['Domain'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['Domain'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['Domain'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM Domain WHERE DomainID='".$input['Domain'.DTR.'DomainID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['Domain'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['Domain'.DTR.'DomainStatus'][$id]!='active')
					{
						$inputSave['Domain'.DTR.'DomainStatus'] = 'hidden';
					}
					else
					{
						$inputSave['Domain'.DTR.'DomainStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT DomainStatus FROM Domain WHERE DomainID='".$input['Domain'.DTR.'DomainID'][$id]."'");
					if($oldRS[0]['DomainStatus']!=$inputSave['Domain'.DTR.'DomainStatus']) {$updateCats='Y';}
				}			
				$inputSave['Domain'.DTR.'DomainID'] = $input['Domain'.DTR.'DomainID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Domain'] = "DomainID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Domain'.DTR.'DomainID'].' perm='.$inputSave['Domain'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Domain',array('previewFieldName'=>'DomainImagePreview','fullFieldName'=>'DomainImage'));	
		$saveRS = $DomainObject->setDomain($input);
		$entityID = $saveRS[0]['DomainID'];
		$input['Domain'.DTR.'DomainID'] = $entityID;		
		if(!empty($input['Domain'.DTR.'DomainID']))	
		{
			$DomainObject->setDomainField($input,$uploadRS);	
		}
	}

	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $DomainObject->getDomain($input);
		$result['DB']['Domain'] = $sectionRS;
		if(empty($input['DomainType']))
		{
			$input['DomainType'] = $sectionRS[0]['DomainType'];
		}
	}	
	else
	{
		$DomainTemplate = $DomainTypeObject->getDomainTemplate($input['DomainType']);	
		$CORE->setInputVar('DomainTemplate',$DomainTemplate);	
	}

	
	if(!empty($input['DomainType']))
	{
		$fieldsRS = $DomainObject->getDomainFields($input);
		//$result['DB']['DomainFieldTypes'] = $fieldsRS['DomainFieldTypes'];
		$result['DB']['DomainField'] = $fieldsRS['DomainField'];
		
		//$result['DB']['DomainOption'] = $fieldsRS['DomainOption'];
		//print_r($result['DB']['DomainOption']);		
	}

	//get Domains 
	$entityRS = $DomainObject->getDomains($input);
	$result['DB']['Domains'] = $entityRS['result'];
	$result['pages']['Domains'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if($clientType!='admin')
	{
		$input['DomainTypesPlace']='submit';
	}
	$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
	//return result array
	return $result;
}

function manageDomain()
{ 
	global $CORE;
	//get input
	$CORE->setInputVar('DomainType','domain');
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	
	$DS = new DataSource('main');

	$clientType = $config['ClientType'];

	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['DomainID'];
	$DomainObject = new DomainClass();
	$DomainTypeObject = new DomainTypeClass();
	//$section = new DomainClass();
	//delete item
	//print_r($input);
	if($input['actionMode']=='delete')
	{
		$DomainObject->deleteDomain($input);
		//$DomainType->deleteDomainField($input);
	}
	elseif($input['actionMode']=='pay')
	{
		$paymentResult = $DomainObject->buyDomain($input);
		$result['Payment'] = $paymentResult;
		//print_r($paymentResult);
	}	
	elseif($input['actionMode']=='deleterelated')
	{
		$DomainRelationObject = new DomainRelationClass();
		$DomainRelationObject->deleteDomainRelation($input);
	}	
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Domain'.DTR.'DomainID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Domain WHERE DomainID='".$input['Domain'.DTR.'DomainID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Domain'.DTR.$fileField][$lang]=' ';}else{	$input['Domain'.DTR.$fileField]=' ';}
			$input['Domain'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$DomainObject->setDomain($input);
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Domain',array('previewFieldName'=>'DomainImagePreview','fullFieldName'=>'DomainImage'));	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $DomainObject->setDomain($input);
		$entityID = $saveRS[0]['DomainID'];
		$input['Domain'.DTR.'DomainID'] = $entityID;	
		if(!empty($input['Domain'.DTR.'DomainID']))
		{
			$DomainObject->setDomainField($input,$uploadRS);	
		}
	}	
	elseif($input['actionMode']=='pay')
	{
		$paymentResult = $DomainObject->buyDomain($input);
		$result['Payment'] = $paymentResult;
		//print_r($paymentResult);
	}	
	//get 1 item details
	if(!empty($entityID) || $clientType == 'front')
	{
		$sectionRS = $DomainObject->getDomain($input);
		$result['DB']['Domain'] = $sectionRS;
		if(empty($input['DomainType']))
		{
			$input['DomainType'] = $sectionRS[0]['DomainType'];
		}
	}	
	
	if(!empty($input['DomainType']))
	{
		$fieldsRS = $DomainObject->getDomainFields($input);
		//$result['DB']['DomainFieldTypes'] = $fieldsRS['DomainFieldTypes'];
		$result['DB']['DomainField'] = $fieldsRS['DomainField'];
		//$result['DB']['DomainOption'] = $fieldsRS['DomainOption'];
		//print_r($result['DB']['DomainOption']);		
	}
	//get categories reference
	//get Domains 
	//return '';
	$entityRS = $DomainObject->getDomains($input);
	$result['DB']['Domains'] = $entityRS['result'];
	$result['pages']['Domains'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if($clientType!='admin')
	{
		$input['DomainTypesPlace']='submit';
	}
	$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
	
	/*$DSClient = new DataSource('coorda');
	$clientRS = $DSClient->query('SELECT * FROM client');
	$result['DB']['Clients'] = $clientRS;
	*/
	//return result array
	return $result;
}

function addDomain($input='')
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
	$entityID = $input['DomainID'];
	$DomainObject = new DomainClass();
	$DomainTypeObject = new DomainTypeClass();
	
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
		$input = $FM->getUploadedFields($input,'Domain',array('previewFieldName'=>'DomainImagePreview','fullFieldName'=>'DomainImage'));	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $DomainObject->setDomain($input);
		$entityID = $saveRS[0]['DomainID'];
		$input['Domain'.DTR.'DomainID'] = $entityID;			
		$DomainObject->setDomainField($input,$uploadRS);	
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
		$sectionRS = $DomainObject->getDomain($input);
		$result['DB']['Domain'] = $sectionRS;
		if(empty($input['DomainType']))
		{
			$input['DomainType'] = $sectionRS[0]['DomainType'];
		}
	}	
	else
	{
		$DomainTemplate = $DomainTypeObject->getDomainTemplate($input['DomainType']);	
		$CORE->setInputVar('DomainTemplate',$DomainTemplate);	
	}
	if(!empty($input['DomainType']))
	{
		$fieldsRS = $DomainObject->getDomainFields($input);
		$result['DB']['DomainField'] = $fieldsRS['DomainField'];
	}
	//get Domains 
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	$input['DomainTypesPlace']='submit';
	$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
	foreach($result['DB']['DomainTypes'] as $id=>$value)
	{
		if($value['DomainTypeID']==1)
		{
			unset($result['DB']['DomainTypes'][$id]);
		}
	}
	//return result array
	return $result;
}

function getDomains()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	
	//creat objects
	//if(!empty($input['category']) || !empty($input['searchWord']) || !empty($input['CategoryID'])  || !empty($input['DomainType'])  || !empty($input['type']))
	//{			
		if(!empty($input['featuredMode']))
		{
			$input['DomainTypesPlace'] = $input['featuredMode'];
		}
		$DomainObject = new DomainClass();
		$rs = $DomainObject->getDomains($input);
		$DomainTypeObject = new DomainTypeClass();
		$result['DB']['Domains'] = $rs['result']; 
		$result['pages']['Domains'] = $rs['pages'];
		$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
	//}

	return $result;
}

function searchDomains()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$category = $input['category'];
	$DomainObject = new DomainClass();
	$DomainTypeObject = new DomainTypeClass();
	$DS = new DataSource('main');
	$actionMode = $input['actionMode'];
	//creat objects
	if(!empty($category) || !empty($input['searchWord']) || !empty($input['CategoryID']))
	{			
	
	}
	if($actionMode=='search')
	{
		//$DomainObject = new DomainClass();
		//$rs = $DomainObject->getDomains($input);
		//$result['DB']['Domains'] = $rs['result']; 
		//$result['pages']['Domains'] = $rs['pages'];
	}
	$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
	return $result;
}

function getDomainsByTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	if(!empty($input['type']))
	{
		$CORE->setInputVar('DomainType',$input['type']);	
		$input['DomainType'] = $input['type'];
		$DomainTypeObject = new DomainTypeClass();
		$DomainTemplate = $DomainTypeObject->getDomainTemplate($input['type']);	
		$CORE->setInputVar('DomainTemplate',$DomainTemplate);	
	}
	//creat objects
	if(!empty($input['category']) || !empty($input['type']) || !empty($input['DomainType']))
	{			
		$DomainObject = new DomainClass();
		
		if(!empty($input['type']))
		{
			$rs = $DomainObject->getDomains($input);
			$result['DB']['Domains'] = $rs['result']; 			
			$result['pages']['Domains'] = $rs['pages']; 	
		}
		else
		{
			if(is_array($typesRS))
			{
				foreach($typesRS as $row)
				{
					$typeCode = $row['DomainTypeAlias'];
					$input['ItemsPerPage']=10;
					$input['featuredMode']='top10';
					$input['DomainType'] = $typeCode;
					$rs = $DomainObject->getDomains($input);
					$result['DB']['Domains'][$typeCode] = $rs['result'];
					$result['pages']['Domains'][$typeCode] = $rs['pages'];
					$result['DB']['DomainTypeNames'][$typeCode] = $row['DomainTypeName'];
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


function getDomainsFeatured()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$DomainType = new DomainTypeClass();
	$DomainObject = new DomainClass();
	
	//print_r($input);
	if(empty($input['featuredMode'])) {$input['featuredMode']='home';}
	
	$input['DomainTypesPlace'] = $input['featuredMode'];


	$typesRS = $DomainType->getDomainTypes($input);	
	$result['DB']['DomainTypes'] = $typesRS;

	if(is_array($typesRS))
	{
		foreach($typesRS as $row)
		{
			$typeCode = $row['DomainTypeAlias'];
			$input['ItemsPerPage']=10;
			$input['DomainType'] = $typeCode;
			$rs = $DomainObject->getDomains($input);
			if(is_array($rs['result']))
			{
				$result['DB']['Domains'][$typeCode] = $rs['result'];
			}
			//$result['pages']['Domains'][$typeCode] = $rs['pages'];
			$result['DB']['DomainTypeNames'][$typeCode] = $row['DomainTypeName'];
		}
	}

	return $result;
}

function getDomain()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects		


	if(empty($userID) && $input['actionMode'] == 'login')
	{
		$CORE->setInputVar('redirectionMode','N');
		$CORE->callService('doLogin','sessionServer');	
	}
	$DomainObject = new DomainClass();
	if($input['actionMode']=='pay')
	{
		$paymentResult = $DomainObject->buyDomain($input);
		$result['Payment'] = $paymentResult;
		//print_r($paymentResult);
	}	
	$rs = $DomainObject->getDomain($input);
		
	$DomainTypeObject = new DomainTypeClass();
	$result['DB']['Domain'] = $rs[0];
	
	$input['DomainType'] = $rs[0]['DomainType'];
	
	if(!empty($input['DomainType']))
	{
		$input['DomainID'] = $rs[0]['DomainID'];
		
		$input['viewMode']='viewDomain';
		$fieldsRS = $DomainObject->getDomainFields($input);
		$result['DB']['DomainFieldTypes'] = $fieldsRS['DomainFieldTypes'];
		$result['DB']['DomainField'] = $fieldsRS['DomainField'];
		$result['DB']['DomainOption'] = $fieldsRS['DomainOption'];
		$result['DB']['DomainTypes']= $DomainTypeObject->getDomainTypes($input);
		//print_r($fieldsRS);
		//if($input['DomainType']=='offers')
		//{
			/*$DomainBid = new DomainBidClass();
			$bidStat = $DomainBid->getDomainBidStats($input);
			$result['Vars'] =$bidStat;
			
			$BidsUsers = $DomainObject->getBidsUsers($input);
			$result['DB']['BidUsers'] = $BidsUsers;*/
		//}
	}
	
	//print_r($result);	
	return $result;
}


function getDomainSEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DomainObject = new DomainClass();
	$rs = $DomainObject->getDomain($input);
	$result['DB']['Domain'] = $rs[0];
	return $result;
}


?>