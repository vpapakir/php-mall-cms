<?php
function manageTours()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$categoryID = $input['CategoryID'];
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['TourID'];
	if(empty($entityID)) {$entityID = $input['Tour'.DTR.'TourID'];}
	$sectionsObject = new TourCategoryClass();	
	$tourObject = new TourClass();
	$tourTypeObject = new TourTypeClass();
	//$section = new TourClass();
	//print_r($input);
	//delete item
	if($input['actionMode']=='delete')
	{
		$tourObject->deleteTour($input);
		//$TourType->deleteTourField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['TourID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Tour WHERE TourID='".$input['TourID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Tour SET ".$fileField."='' WHERE TourID='".$input['TourID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
	    if(is_array($input['Tour'.DTR.'TourID']))
		{
			foreach($input['Tour'.DTR.'TourID'] as $id=>$value)
			{
				$updateCats='N';
				if($clientType=='admin')
				{
					if($input['Tour'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['Tour'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['Tour'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM Tour WHERE TourID='".$input['Tour'.DTR.'TourID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['Tour'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['Tour'.DTR.'TourStatus'][$id]!='active')
					{
						$inputSave['Tour'.DTR.'TourStatus'] = 'hidden';
					}
					else
					{
						$inputSave['Tour'.DTR.'TourStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT TourStatus FROM Tour WHERE TourID='".$input['Tour'.DTR.'TourID'][$id]."'");
					if($oldRS[0]['TourStatus']!=$inputSave['Tour'.DTR.'TourStatus']) {$updateCats='Y';}
				}			
				$inputSave['Tour'.DTR.'TourID'] = $input['Tour'.DTR.'TourID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Tour'] = "TourID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Tour'.DTR.'TourID'].' perm='.$inputSave['Tour'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);
				if($updateCats=='Y')
				{
					$tourObject->updateTourCategoryStats($input['Tour'.DTR.'TourID'][$id]);
				}
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1' || $input['actionMode']=='addoption')
	{
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Tour',array('previewFieldName'=>'TourIcon','fullFieldName'=>'TourIcon'));	
//		print_r($input);
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$saveRS = $tourObject->setTour($input);		
		$entityID = $saveRS[0]['TourID'];
		$input['Tour'.DTR.'TourID'] = $entityID;			
		$tourObject->setTourField($input,$uploadRS);	
		$tourObject->setTourRate($input);
	}		
	
	//get 1 item details
	if(!empty($entityID) && !is_array($entityID))
	{
		$tourRS = $tourObject->getTour($input);
		$result['DB']['Tour'] = $tourRS;
		$input['Tour'.DTR.'TourCountryID'] = $tourRS[0]['TourCountryID'];
		$input['Tour'.DTR.'TourRegionID'] = $tourRS[0]['TourRegionID'];
		$input['Tour'.DTR.'TourCityID'] = $tourRS[0]['TourCityID'];
		
		$tourRatesRS = $tourObject->getTourRates($input);
		$result['DB']['TourRates'] = $tourRatesRS;
		//if(empty($input['TourType']))
		//{
			//$input['TourType'] = $sectionRS[0]['TourType'];
		//}
	}	
	else
	{
		//$tourTemplate = $tourTypeObject->getTourTemplate($input['TourType']);	
		//$CORE->setInputVar('TourTemplate',$tourTemplate);	
	}

	//if(!empty($input['TourType']))
	//{
		$fieldsRS = $tourObject->getTourFields($input);
		$result['DB']['TourFieldTypes'] = $fieldsRS['TourFieldTypes'];
		$result['DB']['TourField'] = $fieldsRS['TourField'];
		$result['DB']['TourOption'] = $fieldsRS['TourOption'];
		//print_r($result['DB']['TourField']);		
	//}
	
	//get categories reference
	/*
	$input['treeType']='all';
	$input['downLevels']='all';
	$categoriesRS = $sectionsObject->getTourCategoriesTree($input);
	
	//$inputValues[0]['id']='';	
	//$inputValues[0]['value']=lang('-top');	
	$k=1;		
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
		if($row['TourCategoryID']!=$input['TourCategoryID'])
		{
			$inputValues[$k]['id']=$row['TourCategoryID'];	
			$inputValues[$k]['value']=$treeString.getValue($row['TourCategoryTitle']);
			$k++;		
		}
		//echo 'i= '.$i.' id= '.$row['TourCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
	}
	$result['DB']['TourCategories'] = $inputValues;
	*/
	//get tours 
	$entityRS = $tourObject->getTours($input);
	$result['DB']['Tours'] = $entityRS['result'];
	$result['pages']['Tours'] = $entityRS['pages'];
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	if($clientType!='admin')
	{
		$input['tourTypesPlace']='submit';
	}
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	//return result array

	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	//echo 'ttttt';
	//print_r($input);
	if(!empty($tourRS[0]['TourCountryID'])) {$input['Tour'.DTR.'TourCountryID'] = $tourRS[0]['TourCountryID'];}
	if(!empty($input['Tour'.DTR.'TourCountryID']))
	{
		$inputRegion['CountryID'] = $input['Tour'.DTR.'TourCountryID'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
		//echo 'regions=';
		//print_r($result['DB']['Regions']);
		
		if(!empty($tourRS[0]['TourRegionID'])) {$input['Tour'.DTR.'TourRegionID'] = $tourRS[0]['TourRegionID'];}
		if(!empty($input['Tour'.DTR.'TourRegionID']))
		{
			//echo 'tttt='. $input['Tour'.DTR.'TourRegionID'];
			$inputRegion['RegionID'] = $input['Tour'.DTR.'TourRegionID'];
			$regionsRS = $CORE->callService('getCities','coreServer',$inputRegion);
			$result['DB']['Cities'] = $regionsRS['DB']['Cities'];			
		}		
	}
	return $result;
}


function addTour($input='')
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
	$entityID = $input['TourID'];
	$sectionsObject = new TourCategoryClass();	
	$tourObject = new TourClass();
	$tourTypeObject = new TourTypeClass();
	
	if($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['Tour'.DTR.'TourContactFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['Tour'.DTR.'TourContactLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address1',$input['Tour'.DTR.'TourContactAddress']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['Tour'.DTR.'TourContactCity']);
			$CORE->setInputVar('UserField'.DTR.'Region',$input['Tour'.DTR.'TourContactRegionID']);
			$CORE->setInputVar('UserField'.DTR.'PostCode',$input['Tour'.DTR.'TourContactPostCode']);
			$CORE->setInputVar('UserField'.DTR.'CountryID',$input['Tour'.DTR.'TourContactCountryID']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['Tour'.DTR.'TourContactPhone']);
			$CORE->setInputVar('UserField'.DTR.'Fax',$input['Tour'.DTR.'TourContactFax']);
			$CORE->setInputVar('UserField'.DTR.'ICQ',$input['Tour'.DTR.'TourContactICQ']);
			$CORE->setInputVar('UserField'.DTR.'Skype',$input['Tour'.DTR.'TourContactSkype']);
			$CORE->setInputVar('UserField'.DTR.'Website',$input['Tour'.DTR.'TourContactWebsite']);
			$CORE->setInputVar('UserField'.DTR.'Comments',$input['Tour'.DTR.'TourContactComments']);

			$CORE->setInputVar('User'.DTR.'Email',$input['Tour'.DTR.'TourContactEmail']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$TourOrder = new TourOrderClass();		
		}
				
		$FM = new FilesManager();
		//$uploadRS = $FM->uploadFile();
		$input = $FM->getUploadedFields($input,'Tour',array('previewFieldName'=>'TourIcon','fullFieldName'=>'TourIcon'));	
		//print_r($input);
		
		/*if(!empty($uploadRS['TourImage']['file']))
		{
			$input['Tour'.DTR.'TourImage']= $uploadRS['TourImage']['file'];
			//$input['Tour'.DTR.'TourIcon'] = $uploadRS['TourImage']['preview'];
		}	
		if(!empty($uploadRS['TourImage1']['file']))
		{
			$input['Tour'.DTR.'TourImage1']= $uploadRS['TourImage1']['file'];
			//$input['Tour'.DTR.'TourIcon'] = $uploadRS['TourImage']['preview'];
		}	
		if(!empty($uploadRS['TourImage2']['file']))
		{
			$input['Tour'.DTR.'TourImage2']= $uploadRS['TourImage2']['file'];
			//$input['Tour'.DTR.'TourIcon'] = $uploadRS['TourImage']['preview'];
		}	
		if(!empty($uploadRS['TourImage3']['file']))
		{
			$input['Tour'.DTR.'TourImage3']= $uploadRS['TourImage3']['file'];
			//$input['Tour'.DTR.'TourIcon'] = $uploadRS['TourImage']['preview'];
		}	
		if(!empty($uploadRS['TourIcon']['file']))
		{
			$input['Tour'.DTR.'TourIcon']= $uploadRS['TourIcon']['icon'];
		}	*/
		
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		
		$resultRS = $tourObject->setTour($input);
		if($input['actionMode']=='add')
		{
			//$entityID = $DS->dbLastID();
			$entityID = $resultRS[0]['TourID'];	
			
			/*if($input['actionStep']=='3') 
			{ 
				$CORE->setInputVar('Tour'.DTR.'TourID',$entityID);
				$CORE->setInputVar('TourID',$entityID);
			}*/
			
			$input['Tour'.DTR.'TourID'] = $entityID;
			$input['TourID'] = $entityID;
		}			
		$tourObject->setTourField($input,$uploadRS);
			
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
		$sectionRS = $tourObject->getTour($input);
		
		$result['DB']['Tour'] = $sectionRS[0];
		if(empty($input['TourType']))
		{
			$input['TourType'] = $sectionRS[0]['TourType'];
		}
	}	
	else
	{
		$tourTemplate = $tourTypeObject->getTourTemplate($input['TourType']);	
		$CORE->setInputVar('TourTemplate',$tourTemplate);	
	}
	if(!empty($input['TourType']))
	{
		$fieldsRS = $tourObject->getTourFields($input);
		$result['DB']['TourField'] = $fieldsRS['TourField'];
	}
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	
	if(!empty($tourRS[0]['TourCountryID'])) {$input['Tour'.DTR.'TourCountryID'] = $tourRS[0]['TourCountryID'];}
	if(!empty($input['Tour'.DTR.'TourCountryID']))
	{
		$inputRegion['CountryID'] = $input['Tour'.DTR.'TourCountryID'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
		//echo 'regions=';
		//print_r($result['DB']['Regions']);
		
		if(!empty($tourRS[0]['TourRegionID'])) {$input['Tour'.DTR.'TourRegionID'] = $tourRS[0]['TourRegionID'];}
		if(!empty($input['Tour'.DTR.'TourRegionID']))
		{
			//echo 'tttt='. $input['Tour'.DTR.'TourRegionID'];
			$inputRegion['RegionID'] = $input['Tour'.DTR.'TourRegionID'];
			$regionsRS = $CORE->callService('getCities','coreServer',$inputRegion);
			$result['DB']['Cities'] = $regionsRS['DB']['Cities'];			
		}		
	}
	/*
	//get categories reference
	$input['treeType']='all';
	$input['downLevels']='all';
	$categoriesRS = $sectionsObject->getTourCategoriesTree($input);
	
	//$inputValues[0]['id']='';	
	//$inputValues[0]['value']=lang('-top');	
	$k=1;		
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
		if($row['TourCategoryID']!=$input['TourCategoryID'])
		{
			$inputValues[$k]['id']=$row['TourCategoryID'];	
			$inputValues[$k]['value']=$treeString.getValue($row['TourCategoryTitle']);
			$k++;		
		}
		//echo 'i= '.$i.' id= '.$row['TourCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
	}
	$result['DB']['TourCategories'] = $inputValues;
	*/
	//get tours 
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	$input['tourTypesPlace']='submit';
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	
	//print_r($result['DB']['Tour']);	
	//return result array
	return $result;
}

function getTours()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$tourTypeObject = new TourTypeClass();
	//creat objects
	if(1)//!empty($input['category']))
	{			
		$tourObject = new TourClass();
		$rs = $tourObject->getTours($input);
		$result['DB']['Tours'] = $rs['result']; 
		$result['pages']['Tours'] = $rs['pages'];
		$tourCategory = new TourCategoryClass();
		$rs = $tourCategory->getTourCategory($input);		
		$result['DB']['TourCategory'] = $rs[0];
	}
	
	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	
	if(!empty($tourRS[0]['TourCountryID'])) {$input['Tour'.DTR.'TourCountryID'] = $tourRS[0]['TourCountryID'];}
	if(!empty($input['Tour'.DTR.'TourCountryID']))
	{
		$inputRegion['CountryID'] = $input['Tour'.DTR.'TourCountryID'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
		//echo 'regions=';
		//print_r($result['DB']['Regions']);
		
		if(!empty($tourRS[0]['TourRegionID'])) {$input['Tour'.DTR.'TourRegionID'] = $tourRS[0]['TourRegionID'];}
		if(!empty($input['Tour'.DTR.'TourRegionID']))
		{
			//echo 'tttt='. $input['Tour'.DTR.'TourRegionID'];
			$inputRegion['RegionID'] = $input['Tour'.DTR.'TourRegionID'];
			$regionsRS = $CORE->callService('getCities','coreServer',$inputRegion);
			$result['DB']['Cities'] = $regionsRS['DB']['Cities'];			
		}		
	}
	
	return $result;
}

function getToursByTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	if(!empty($input['type']))
	{
		$CORE->setInputVar('TourType',$input['type']);	
		$input['TourType'] = $input['type'];
		$tourTypeObject = new TourTypeClass();
		$tourTemplate = $tourTypeObject->getTourTemplate($input['type']);	
		$CORE->setInputVar('TourTemplate',$tourTemplate);	
	}
	//creat objects
	if(!empty($input['category']))
	{			
		$tourObject = new TourClass();

		$tourCategory = new TourCategoryClass();
		$rs = $tourCategory->getTourCategory($input);		
		$result['DB']['TourCategory'] = $rs[0];
		$categoryID = $rs[0]['TourCategoryID'];
		if(!empty($categoryID))
		{
			$input['CategoryID']=$categoryID;
			$typesRS = $tourCategory->getTourCategoryTypes($input);	
			$result['DB']['TourCategoryTypes'] = $typesRS;
		}
		
		if(!empty($input['type']))
		{
			$rs = $tourObject->getTours($input);
			$result['DB']['Tours'] = $rs['result']; 			
			$result['pages']['Tours'] = $rs['pages']; 	
		}
		else
		{
			if(is_array($typesRS))
			{
				foreach($typesRS as $row)
				{
					$typeCode = $row['TourTypeAlias'];
					$input['ItemsPerPage']=10;
					$input['featuredMode']='top10';
					$input['TourType'] = $typeCode;
					$rs = $tourObject->getTours($input);
					$result['DB']['Tours'][$typeCode] = $rs['result'];
					$result['pages']['Tours'][$typeCode] = $rs['pages'];
					$result['DB']['TourTypeNames'][$typeCode] = $row['TourTypeName'];
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


function getToursFeatured()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$TourType = new TourTypeClass();
	$tourObject = new TourClass();
	
	if(empty($input['featuredMode'])) {$input['featuredMode']='home';}
	
	$input['tourTypesPlace'] = $input['featuredMode'];


	$typesRS = $TourType->getTourTypes($input);	
	$result['DB']['TourTypes'] = $typesRS;

	if(is_array($typesRS))
	{
		foreach($typesRS as $row)
		{
			$typeCode = $row['TourTypeAlias'];
			$input['ItemsPerPage']=10;
			$input['TourType'] = $typeCode;
			$rs = $tourObject->getTours($input);
			if(is_array($rs['result']))
			{
				$result['DB']['Tours'][$typeCode] = $rs['result'];
			}
			//$result['pages']['Tours'][$typeCode] = $rs['pages'];
			$result['DB']['TourTypeNames'][$typeCode] = $row['TourTypeName'];
		}
	}

	return $result;
}

function getTour()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
    $TourCommentObject = new TourCommentClass();
	$DS = new DataSource('main');
	
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$tourTypeObject = new TourTypeClass();
	//creat objects			
	$tourObject = new TourClass();
	//print_r($input);
	$rs = $tourObject->getTour($input);
	$result['DB']['Tour'] = $rs[0];
	$input['Tour'.DTR.'TourCountryID'] = $rs[0]['TourCountryID'];
	$input['Tour'.DTR.'TourRegionID'] = $rs[0]['TourRegionID'];
	$input['Tour'.DTR.'TourCityID'] = $rs[0]['TourCityID'];	
	//$input['viewMode']='viewtour';
	$fieldsRS = $tourObject->getTourFields($input);
	$result['DB']['TourFieldTypes'] = $fieldsRS['TourFieldTypes'];
	$result['DB']['TourField'] = $fieldsRS['TourField'];
	$result['DB']['TourOption'] = $fieldsRS['TourOption'];
	
	$tourRatesRS = $tourObject->getTourRates($input);
	//print_r($tourRatesRS);
	$result['DB']['TourRates'] = $tourRatesRS;	

	$regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	
	if($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
/*			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	//*/
			if(($input['UserField'.DTR.'FirstName']!='')and($input['UserField'.DTR.'LastName']!=''))
			{
			 $input['TourComment'.DTR.'TourCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];
			}
			if($input['User'.DTR.'Email']!='')
			{
			 $input['TourComment'.DTR.'TourCommentEmail']=$input['User'.DTR.'Email'];
			}
			if ($input['UserField'.DTR.'UserLink']!='')
			{
			 $input['TourComment'.DTR.'TourCommentLink'] = $input['UserField'.DTR.'UserLink'];
			}
			///*
//			$input['TourComment'.DTR.'TourCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];	
//			$input['TourComment'.DTR.'TourCommentEmail'] = $input['User'.DTR.'Email'];
			//$input['TourComment'.DTR.'TourCommentLink'] = $input['UserField'.DTR.'UserLink'];//*/
		}
//		print_r($input);	
		$TourCommentObject->setTourComment($input);
		if($input['actionMode']=='add')
		{
			$entityID = $DS->dbLastID();
				
			$input['TourComment'.DTR.'TourCommentID'] = $entityID;		
		}
//		print_r($input); 
//		header('Location: '.setting('url').'product/TourID/'.$input['TourComment'.DTR.'TourID'].'/windowMode/popup/');
	}
	
	
	//echo 'ttttt';
	//print_r($input);
	if(!empty($input['Tour'.DTR.'TourCountryID']))
	{
		$inputRegion['CountryID'] = $input['Tour'.DTR.'TourCountryID'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
		//echo 'regions=';
		//print_r($result['DB']['Regions']);

		if(!empty($input['Tour'.DTR.'TourRegionID']))
		{
			$inputRegion['RegionID'] = $input['Tour'.DTR.'TourRegionID'];
			$regionsRS = $CORE->callService('getCities','coreServer',$inputRegion);
			$result['DB']['Cities'] = $regionsRS['DB']['Cities'];			
		}		
	}
	$result['DB']['TourTypes']= $tourTypeObject->getTourTypes($input);
	
	//$tourCategory = new TourCategoryClass();
	//$CORE->setInputVar('TourType',$rs[0]['TourType']);	
	////$CORE->setInputVar('type',$rs[0]['TourType']);
	//$typesRS = $tourCategory->getTourCategoryTypes($input);	
	//$result['DB']['TourCategoryTypes'] = $typesRS;		
		
	return $result;
}


function getTourSEOInfo()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$tourObject = new TourClass();
	$rs = $tourObject->getTour($input);
	$result['DB']['Tour'] = $rs[0];
	return $result;
}

function getToursSearchForm()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$TourType = new TourTypeClass();

    $regionsRS = $CORE->callService('getCountries','coreServer',$input);
	$result['DB']['Countries'] = $regionsRS['DB']['Countries'];
	
	if(!empty($input['TourCountry']))
	{
		$inputRegion['CountryID'] = $input['TourCountry'];
		$regionsRS = $CORE->callService('getRegions','coreServer',$inputRegion);
		$result['DB']['Regions'] = $regionsRS['DB']['Regions'];			
	}

	$typesRS = $TourType->getTourTypes($input);	
	$result['DB']['TourTypes'] = $typesRS;

	return $result;
}	

function TourRatingUsers($input='')
{
	global $CORE;
	if(empty($input)){$input=$CORE->getInput();}
	$tourObject = new TourClass();
	$tourObject->setTourRateUsers($input);
	$result = $tourObject->getTourRateUsers($input);
	return $result;
}//function TourRatingUsers


?>
