<?php
function manageSections()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$groupID = $input['GroupID'];
	//if(empty($groupID)){$groupID=1;}
	
	/*
	if(empty($groupID)){
		$SectionGroupCode =$input['SectionGroupCode'];
		if(empty($SectionGroupCode)) {$SectionGroupCode='main';}
		$defaultGoupRS = $DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='$SectionGroupCode'");
		$groupID = $defaultGoupRS[0]['SectionGroupID'];
		$input['GroupID'] = $groupID;
		$CORE->setInputVar("GroupID",$groupID);
	}
	*/
	$SectionGroupCode =$input['SectionGroupCode'];
	if(!empty($SectionGroupCode))
	{
		$defaultGoupRS = $DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='$SectionGroupCode'");
		$groupID = $defaultGoupRS[0]['SectionGroupID'];
		$input['GroupID'] = $groupID;
		$CORE->setInputVar("GroupID",$groupID);
	}

	if(!empty($input['SectionAlias']))
	{
		$sectionAliasRS = $DS->query("SELECT SectionID FROM Section WHERE SectionAlias='".$input['SectionAlias']."'");
		$input['SectionID'] = $sectionAliasRS[0]['SectionID'];	
		$CORE->setInputVar('SectionID',$input['SectionID']);	
	}		
		
	$entityID = $input['SectionID'];
	$sectionsObject = new SectionClass();	
	//$section = new SectionClass();
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	

	//delete item
	if($input['actionMode']=='delete')
	{
		if(!empty($input['Section'.DTR.'SectionID']))
		{
			$DS->query("DELETE FROM Section WHERE SectionID='".$input['Section'.DTR.'SectionID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['SectionID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Section WHERE SectionID='".$input['SectionID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if($FM->deleteFile($filePath))
			//{
				//$DS->query("UPDATE Section SET ".$fileField."='' WHERE SectionID='".$input['SectionID']."'");
				$inputSave['Section'.DTR.'SectionID']=$input['SectionID'];
				if(!empty($lang))
				{
					$inputSave['Section'.DTR.$fileField][$lang]=' ';
				}
				else
				{
					$inputSave['Section'.DTR.$fileField]=' ';
				}
				$inputSave['Section'.DTR.$fileField]=' ';
				$inputSave['actionMode']='save';
				//print_r($inputSave);
				$sectionsObject->setSection($inputSave);
			//}
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
		if(is_array($input['Section'.DTR.'SectionID']))
		{
			foreach($input['Section'.DTR.'SectionID'] as $id=>$value)
			{
				if($input['Section'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['Section'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['Section'.DTR.'PermAll'] = 1;
				}
				$inputSave['Section'.DTR.'SectionID'] = $input['Section'.DTR.'SectionID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Section'] = "SectionID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Section'.DTR.'SectionID'].' perm='.$inputSave['Section'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);	
			}	
		}	
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//add or update one item
		$CORE->setConfigVar("UseImageResize",'N');
		$CORE->setConfigVar("UseImagePreview",'N');		
		$CORE->setInputVar('File'.DTR.'FilePath','images/pages');
		
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		//print_r($uploadRS);
		//die('fff');
		if(is_array($uploadRS))
		{
			foreach($uploadRS as $fileFieldName=>$fielResultValue)
			{
				if(eregi("_lang_",$fileFieldName))
				{
					$pos = strrpos($fileFieldName, "_");
					$lang = substr($fileFieldName,$pos+1);
					$fileFieldNameDB = str_replace("_lang_".$lang,"",$fileFieldName);
					
					$input['Section'.DTR.$fileFieldNameDB][$lang]= $fielResultValue['file'];
				}
				else
				{	
					$input['Section'.DTR.$fileFieldName]= $fielResultValue['file'];
					if($fileFieldName=='SectionIcon')
					{
						$input['Section'.DTR.$fileFieldName]= $fielResultValue['icon'];
					}
				}
			}
		}
		/*
		if(is_array($uploadRS))
		{
			foreach($uploadRS as $fileFieldName=>$fielResultValue)
			{
				$input['Section'.DTR.$fileFieldName]= $fielResultValue['file'];
			}
		}		
		*/
		//print_r($input);
		$newEntityID = $sectionsObject->setSection($input);
		if(!empty($newEntityID))
		{
			$entityID = $newEntityID;
			$input['SectionID'] = $entityID;
			$input['Section'.DTR.'SectionID'] = $entityID;
		}

	}		
	//get 1 item details

	if(!empty($entityID) && ($input['SID']=='manageSection' || $input['SID']=='adminPage'))
	{
		$sectionRS = $DS->query("SELECT * FROM Section WHERE SectionID='$entityID'");
		$result['DB']['Section'] = $sectionRS;
	}	
	//get sections groups reference

	//$filter = $DS->getAccessFilter($input,'',array('mode'=>'groups'));
	$filter = " WHERE (AccessGroups LIKE '%|all|%' OR AccessGroups LIKE '%|".$user['GroupID']."|%' OR AccessGroups = '' OR AccessGroups IS NULL) ";
	//if(!empty($groupID) || empty($input['viewMode'])) {$filter .= " AND SectionGroupType!='menu' ";} else {$filter .= " AND SectionGroupType='menu' ";}
	$resultList = $DS->query("SELECT * FROM SectionGroup $filter ORDER BY SectionGroupPosition");
	$mode['name']='GroupID';
	$mode['id']='SectionGroupID';
	$mode['value']='SectionGroupName';
	$mode['action']='submit();';
	$groupsOptions[0]['id'] = '';
	$groupsOptions[0]['value'] = lang('SiteMap.core.tip');
	$mode['options']=$groupsOptions;
	$result['Refs']['SectionGroups']= $CORE->getLists($resultList,$input['GroupID'],$mode,$config['lang']);	

	//get sections groups reference for section details form
	$mode='';
	$mode['name']='Section'.DTR.'SectionGroupID';
	$mode['id']='SectionGroupID';
	$mode['value']='SectionGroupName';
	$groupttID = $sectionRS[0]['SectionGroupID'];
	if(empty($groupttID)) $groupttID = $input['RequestedGroupID'];
	//$input['GroupID'] = $groupID;
	//$CORE->setInputVar("GroupID",$groupID);	
	$result['Refs']['SectionGroup']= $CORE->getLists($resultList,$groupttID,$mode,$config['lang']);	

	//get activation status reference
	$mode='';
	$mode['code']='Y';
	if(empty($sectionRS[0]['PermAll'])) {$sectionRS[0]['PermAll']=1;}
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Section'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);

	//get sections tree by selected group of sections
	///if(!empty($groupID) || !empty($input['searchWord']))
	//{
		//$entityRS = $DS->query("SELECT * FROM Section WHERE SectionGroupID='$groupID'");
		//$entityRS = $DS->query("SELECT * FROM Section");
		//$result['DB']['Sections'] = $entityRS;
		if(!empty($input['searchWord']))		
		{
			$entityRS = $sectionsObject->getSections($input);
			$result['DB']['Sections'][0] = $entityRS;
		}
		elseif(!empty($groupID))
		{
            //echo '111111';
			$input['treeType']='expanded';
			$input['downLevels']='';
			$input['SectionGroup'] = $groupID;
			$entityRS = $sectionsObject->getSectionsTree($input);
			$sectionGroupCurrentID = $sectionGroupInfo['SectionGroupID'];
			$result['DB']['Sections'][0] = $entityRS;
		}
		else
		{
            //echo '22222222';
			$siteMapGroups = $DS->query("SELECT * FROM SectionGroup WHERE SectionGroupType='menu' ORDER BY SectionGroupPosition");
			foreach ($siteMapGroups as $sectionGroupInfo)
			{
				$sectionGroupCurrentID = $sectionGroupInfo['SectionGroupID'];
				$result['DB']['SectionGroups'][$sectionGroupCurrentID] = $sectionGroupInfo;
				$inputTree['treeType']='expanded';
				$inputTree['downLevels']='';
				$inputTree['SectionGroup'] = $sectionGroupCurrentID;
				$inputTree['SectionID'] = $input['SectionID'];
				$entityRS = $sectionsObject->getSectionsTree($inputTree);
				$result['DB']['Sections'][$sectionGroupCurrentID] = $entityRS;
				$entityRS = '';
			}
		}
	//}
	//print_r($siteMapGroups);
	//make a checkboxes list of languages for editing of a section 
	$mode['name']='Section'.DTR.'SectionLanguages';
	$mode['type'] = 'checkboxes';
	foreach($languagesList['languageNames'] as $langID=>$langName)
	{
		$inputValues[$langID]['id']=$languagesList['languageCodes'][$langID];	
		$inputValues[$langID]['value']=$langName;		
		if(empty($sectionRS[0]['SectionLanguages'])) {$defautLanguages.='|'.$inputValues[$langID]['id'];}
	}
	if(empty($sectionRS[0]['SectionLanguages'])) {$sectionRS[0]['SectionLanguages']=$defautLanguages.'|';}
	$result['Refs']['SectionLanguages']= $CORE->getLists($inputValues,$sectionRS[0]['SectionLanguages'],$mode,$config['lang']);	
	
	//get layouts list
	$mode='';$inputValues='';
	$mode['name']='Section'.DTR.'SectionLayout';
	$layoutsDefinition = $CORE->getLayoutsDefinition();
	foreach($layoutsDefinition as $id=>$row)
	{
		$inputValues[$id]['id'] = $row['ViewAlias'];
		$inputValues[$id]['value'] = getValue($row['ViewName']);
	}
	if(empty($sectionRS[0]['SectionLayout'])) {$sectionRS[0]['SectionLayout']='main';}
	$result['Refs']['SectionLayout']= $CORE->getLists($inputValues,$sectionRS[0]['SectionLayout'],$mode,$config['lang']);	

	//get boxes list
	//$mode='';$inputValues='';
	//$mode['name']='Section'.DTR.'SectionBox';
	$boxesDefinition = $CORE->getBoxesDefinition();
	//foreach($boxesDefinition as $code=>$value)
	//{
		//$inputValues[$code]['id'] = $code;
		////$inputValues[$code]['value'] = $value['name'];
	//}
	$result['DB']['BoxesDefinition']=$boxesDefinition;
	$result['DB']['SectionListingBoxes']=$CORE->getBoxesDefinition(array('type'=>'page'));
	//$result['Refs']['SectionBox']= $CORE->getLists($inputValues,$sectionRS[0]['SectionBox'],$mode,$config['lang']);	
	if(!empty($sectionRS) && ($input['SID']=='manageSection' || $input['SID']=='adminPage' ))
	{
		//format sections tree into a drop down
		
		$mode='';$inputValues='';
		$mode['name']='Section'.DTR.'SectionParentID';
		$inputValues[0]['id']='top';	
		$inputValues[0]['value']=lang('-top');	
		$k=1;		

		$inputList['treeType']='all';
		$inputList['downLevels']='all';
		$inputList['SectionGroup'] = $input['RequestedGroupID'];
		if(empty($inputList['SectionGroup'])) {$inputList['SectionGroup'] = $sectionRS[0]['SectionGroupID'];}
		$sectionListRS = $sectionsObject->getSectionsTree($inputList);
		//print_r($sectionListRS);
		$sectionGroupCurrentID = $sectionGroupInfo['SectionGroupID'];
		
		if(is_array($sectionListRS))
		{
			foreach($sectionListRS as $id=>$row)
			{
				if($lastLevel != $row['SectionLevel'])
				{
					$lastLevel = $row['SectionLevel'];
					$treeString='';
					if($row['SectionLevel']!=1)
					{
						for($i=2;$i<=$row['SectionLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
					}
				}
				if($row['SectionID']!=$input['SectionID'])
				{
					$inputValues[$k]['id']=$row['SectionID'];	
					$inputValues[$k]['value']=$treeString.getValue($row['SectionName']);
					$k++;		
				}
				//echo 'i= '.$i.' id= '.$row['SectionID'].' name='.$inputValues[$i]['value'].'<hr>';
			}
		}
		if(!empty($sectionRS[0]['SectionParentID']))
		{
			$parentID = $sectionRS[0]['SectionParentID'];
		}
		else
		{
			$parentID = $input['SectionParentID'];
		}
		$result['Refs']['SectionParentID']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	

		$userGroupsRS = $CORE->callService("getUserGroups",'sessionServer');
		$result['DB']['UserGroups'] = $userGroupsRS['DB']['UserGroups'];
	
		$accessEditUsers = $DS->query("SELECT UserID, UserName FROM User WHERE GroupID='member' ");
		$result['DB']['AccessEditUsers'] = $accessEditUsers;

	}
	
	$input['Level2GroupID'] = '11365480442006051812025318f111';
	$rsSettings = $DS->query("SELECT * FROM Setting WHERE SettingGroup='".$input['Level2GroupID']."' ORDER BY SettingPosition ASC");
	
	$result['DB']['Settings'][0]['SettingVariableName'] = " ";
	$result['DB']['Settings'][0]['SettingName'] = 'Default';
	$i=1;
	foreach($rsSettings as $key=>$value)
	{
		if(ereg('box',$value['SettingVariableName']))
			{
				$result['DB']['Settings'][$i] = $value;
				$i++;
			}
	}

	

	$modulesRS = getModules();
	$result['DB']['Modules'] = $modulesRS['DB']['Modules'];	

	$resourceTypesRS = $CORE->callService('getResourceTypes','resourceServer');
	$result['DB']['ResourceTypes'] = $resourceTypesRS['DB']['ResourceTypes'];
	
	//return result array
	return $result;
}



function getSectionsTree($input='')
{
	global  $CORE;
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$sectionsObject = new SectionClass();	

	if(empty($input['treeType'])) {$input['treeType']='all';}
	$input['downLevels']='all';
	$input['SectionGroup'] = $groupID;
	$entityRS = $sectionsObject->getSectionsTree($input);
	$result['DB']['Sections'] = $entityRS;	
	return $result;
}

function getSectionsList($input='')
{
	global  $CORE;
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$sectionsObject = new SectionClass();	
	$input['section']=$input['SID'];
	$entityRS = $sectionsObject->getSections($input);
	$result['DB']['Sections'] = $entityRS;	

	return $result;
}

function getSectionsTreeList($input='')
{
	global  $CORE;
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$sectionsObject = new SectionClass();	

	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['SectionGroup'] = $groupID;
	$entityRS = $sectionsObject->getSectionsTree($input);
	//$inputValues[0]['id']='';	
	//$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['SectionLevel'])
			{
				$lastLevel = $row['SectionLevel'];
				$treeString='';
				if($row['SectionLevel']!=1)
				{
					for($i=2;$i<=$row['SectionLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['SectionID']!=$input['SectionID'])
			{
				$inputValues[$k]['id']=$row['SectionID'];
				$inputValues[$k]['code']=$row['SectionAlias'];	
				$inputValues[$k]['value']=$treeString.getValue($row['SectionName']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['SectionID'].' name='.$inputValues[$i]['value'].'<hr>';
		}	
	}
	$result['DB']['SectionsList'] = $inputValues;	
	
	return $result;
}


function staticPage()
{
	global  $CORE;
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	$sectionsObject = new SectionClass();
	
	$result['DB']['Page']=$config['PageTitle'];
	if(hasRights('admin')  || eregi("\|".$user['UserID']."\|",$config['PageAccessEditUsers']))
	{
		if($input['actionMode']=='save')
		{
			$sectionsObject->setSection($input);
			$lang = $config['lang'];
			$newContent  = $input['Section'.DTR.'SectionContent'][$lang];
			if(!empty($newContent))
			{
				$CORE->setConfigVar('PageContent',$newContent);			
			}
			$newIntroContent  = $input['Section'.DTR.'SectionIntroContent'][$lang];
			if(!empty($newIntroContent))
			{
				$CORE->setConfigVar('PageIntroContent',$newIntroContent);			
			}
			
		}
		if($input['viewMode']=='edit')
		{
			$DS = new DataSource('main');
			$sectionRS = $DS->query("SELECT * FROM Section WHERE SectionAlias='".$input['SID']."'");
			$result['DB']['Section'] = $sectionRS;
		}
		$languagesList = $CORE->getLanguages();
		$result['DB']['Languages'] = $languagesList;
	}
	
	$input['SectionAlias'] = $input['SID'];
	$result['DB']['Section'] = $sectionsObject->getSection($input);
	
	return $result;
}


function synchronizeSectionsClient($input='')
{
	global $CORE;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	
	$in['SynchronizationService'] = 'coreServer';
	$in['SynchronizationMethod'] = 'synchronizeSectionsServer';
	$putCount = 0;
	if($input['SynchronizationType']=='put' || $input['SynchronizationType']=='all')
	{
		$now = $CORE->getNow();
		$rs = $DS->query("SELECT * FROM LangField WHERE LockMode !='l' AND LockMode!='p' AND (PutLanguages LIKE '%|%' OR TimeSaved>='".$input['LastTime']."') ORDER BY LangFieldID");
		$in['Fields']['DB'] = $rs;
		$putCount = count($rs);
	}
	$in['Fields']['SynchronizationType'] =$input['SynchronizationType'];
	$in['Fields']['LastTime'] =$input['LastTime'];
	//print_r($in);
	//echo '<hr>';
	//real
	$remoteRS = $CORE->callService("synchronizationServer",'synchronizationServerRemote',$in);
	//test
	//$remoteRS = $CORE->callService($in['SynchronizationMethod'],$in['SynchronizationService'],$in['Fields']);
	//$test = $remoteRS['DB']['TestResult'];
	if($remoteRS['Result']=='Y')
	{
		$getCount=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				if(!empty($row['LangFieldID']))
				{
					$DS->query("UPDATE LangField SET PutLanguages=''  WHERE LangFieldID = '".$row['LangFieldID']."'");
				}
			}
		}
		//get data from central
		if($input['SynchronizationType']=='get' || $input['SynchronizationType']=='all')
		{
			if(is_array($remoteRS['DB']))
			{
				foreach($remoteRS['DB'] as $row)
				{
					$code = $row['Code'];
					$inputSave = '';
					$rs = $DS->query("SELECT * FROM LangField WHERE Code='$code'");
					if($rs[0]['LockMode']!='l' && $rs[0]['LockMode']!='g')
					{
						//add new field or update
						$inputSave['LangField'.DTR.'LangFieldID'] = $rs[0]['LangFieldID'];
						$inputSave['LangField'.DTR.'Code'] = addslashes($row['Code']);
						$inputSave['LangField'.DTR.'TimeSaved'] = $row['TimeSaved'];
						$inputSave['LangField'.DTR.'UserID'] = $row['UserID'];
						$inputSave['LangField'.DTR.'OwnerID'] = $row['OwnerID'];
						$inputSave['LangField'.DTR.'PermAll'] = $row['PermAll'];
						$inputSave['LangField'.DTR.'Value'] = addslashes($row['Value']);
						//$inputSave['LangField'.DTR.'FileValue'] = addslashes($row['FileValue']);
						$inputSave['actionMode']='save';
						//print_r($inputSave);
						//echo '<hr>';
						$where['LangField'] = "LangFieldID='".$inputSave['LangField'.DTR.'LangFieldID']."'";
						if(!empty($inputSave['LangField'.DTR.'Code']))
						{
							$DS->save($inputSave,$where,'insert');				
							$getCount++;
						}
					}
				}
			}
		}		
	}
	$result['Result'] = $remoteRS['Result'];
	$result['Stats']['PutItems'] = $putCount;
	$result['Stats']['GetItems'] = $getCount;
	/*
	echo 'Query: <hr>';
	print_r($in['Fields']);
	echo '<hr>';
	echo 'Result: <hr>';
	print_r($remoteRS);
	echo '<hr>';
	*/
	return $result;
}


function synchronizeSectionsClientCheckStatus($input='')
{
	global $CORE;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	
	$in['SynchronizationService'] = 'coreServer';
	$in['SynchronizationMethod'] = 'synchronizerCheckStatusLangFieldsServer';
	$in['Fields']['SynchronizationType'] =$input['SynchronizationType'];
	$in['Fields']['LastTime'] =$input['LastTime'];
	//real
	$remoteRS = $CORE->callService("synchronizationServer",'synchronizationServerRemote',$in);
	//test
	//$remoteRS = $CORE->callService($in['SynchronizationMethod'],$in['SynchronizationService'],$in['Fields']);
	//$test = $remoteRS['DB']['TestResult'];
	$result['Result'] = $remoteRS['Result'];
	return $result;
}


function synchronizerCheckStatusSectionsServer($input='')
{
	global $CORE;
	//return $input;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	//update central DB
	$inputFields = $input['DB'];
	$lastTime = $input['LastTime'];
	$synchronizationType = $input['SynchronizationType'];
	
	$query = "SELECT * FROM LangField WHERE TimeSaved > '$lastTime' ";
	$rs = $DS->query($query);

	if(count($rs)>0)
	{
		$result['Result']='Y';
	}
	else
	{
		$result['Result']='N';
	}
	return $result;
}


function synchronizeSectionsServer($input='')
{
	global $CORE;
	//return $input;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	//update central DB
	$inputFields = $input['DB'];
	$lastTime = $input['LastTime'];
	$synchronizationType = $input['SynchronizationType'];
	
	if($synchronizationType=='put' || $synchronizationType=='all')
	{
		if(is_array($inputFields))
		{
			foreach($inputFields as $row)
			{
				$doUpdate = 'N';
				$inputSave = '';
				$code = $row['Code'];
				$rs = $DS->query("SELECT * FROM LangField WHERE Code='$code'");
				if(count($rs)==0)
				{
					//add new
					$inputSave['LangField'.DTR.'Code'] = addslashes($row['Code']);
					$inputSave['LangField'.DTR.'TimeSaved'] = $row['TimeSaved'];
					$inputSave['LangField'.DTR.'UserID'] = $row['UserID'];

					$inputSave['LangField'.DTR.'OwnerID'] = $row['OwnerID'];
					$inputSave['LangField'.DTR.'PermAll'] = $row['PermAll'];
					$inputSave['LangField'.DTR.'Value'] = addslashes($row['Value']);
					$inputSave['actionMode']='save';
					$where['LangField'] = "LangFieldID=''";
					if($doUpdate=='Y')
					{
						//print_r($inputSave);
						$DS->save($inputSave,$where,'update');				
					}
				}
				else
				{
					//update language field
					$inputSave['LangField'.DTR.'LangFieldID'] = $rs[0]['LangFieldID'];
					if(!empty($inputSave['LangField'.DTR.'LangFieldID']))
					{
						$inputSave['LangField'.DTR.'TimeSaved'] = $row['TimeSaved'];
						$inputSave['LangField'.DTR.'UserID'] = $row['UserID'];
						$inputSave['LangField'.DTR.'OwnerID'] = $row['OwnerID'];
						$inputSave['LangField'.DTR.'PermAll'] = $row['PermAll'];
						$languagesArray = explode("|",$row['PutLanguages']);
						if(is_array($languagesArray))
						{
							foreach($languagesArray as $lang)
							{
								if(!empty($lang))
								{
									$inputSave['LangField'.DTR.'Value'][$lang] = addslashes($CORE->getValue($row['Value'],$lang));
									$doUpdate = 'Y';
								}
							}
						} 
						//$inputSave['LangField'.DTR.'FileValue'] = addslashes($row['FileValue']);
						$inputSave['actionMode']='save';
						$where['LangField'] = "LangFieldID='".$inputSave['LangField'.DTR.'LangFieldID']."'";
						if($doUpdate=='Y')
						{
							//print_r($inputSave);
							$DS->save($inputSave,$where,'update');				
						}				
					}	
				}
			}
		}
	}
	//return central DB fields
	if($synchronizationType=='get' || $synchronizationType=='all')
	{
		if(!empty($lastTime))
		{
			$query = "SELECT * FROM LangField WHERE TimeSaved >= '$lastTime' ";
		}
		else
		{
			$query = "SELECT * FROM LangField ";
		}
		$rs = $DS->query($query);
	}	
	//$rs = $DS->query("SELECT * FROM LangField LIMIT 0,5");
	//$result['DB']=$rs;
	//$result = $inputSave;
	$result['DB']=$rs;
	$result['Result']='Y';
	
	return $result;
}

function manageIndexPage()
{
	global  $CORE;
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$sectionsObject = new SectionClass();
	
	if($input['actionMode']=='save')
	{
		$sectionsObject->setIndexPage($input);
	}
	
	//$file = file_get_contents("../index.html");
	//echo $file;
	$file = join('',file("../index.html"));
	$file = explode("</head>",$file);
	$file[0] = str_replace("<html>","",$file[0]);
	$file[0] = str_replace("<head>","",$file[0]);
	$file[0] = str_replace("</head>","",$file[0]);
	$file[1] = str_replace("</head>","",$file[1]);
	$file[1] = str_replace("<body>","",$file[1]);
	$file[1] = str_replace("</body>","",$file[1]);
	$file[1] = str_replace("</html>","",$file[1]);
	$result['DB']['Meta'] = $file[0];
	$result['DB']['Content'] = $file[1];
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	return $result;
}

function getSupportList($input='')
{
	global $CORE;
	//get input
	if(empty($input)) $input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$groupID = $input['GroupID'];
	
	//die('rrrrr');
	return '';
	//$file = join('',file("http://coorda.com/coobox/support/support_coomall.php?serial=".$config['SystemLicense']));
	//$result['DB']['SupportMessage'] = $file;

	$messageRS = $CORE->callService('manageMessages','coreServer',$input);
	$result['DB']['newMessage'] = $messageRS['DB']['NewMessages'];

	$messageRS = $CORE->callService('getClientMessages','mailServer',$input);
	$result['DB']['newMessage'] = $messageRS['DB']['ClientMessages'];
	//print_r($result['DB']['newMessage']);
	$input['filterMode'] = 'last';
	//$propertyRS = $CORE->callService('manageProperties','propertyServer',$input);
	$propertyRS = $CORE->callService('getResources','resourceServer',$input);
	$result['DB']['LastProduct'] = $propertyRS['DB']['Resources'];
	
	//$input['SectionID'] = 'guestbook';
	$commentRS = $CORE->callService('getResourceComments','resourceServer',$input);
	$result['DB']['LastComments'] = $commentRS['DB']['ResourceComments'];
	
	$ComboardmessageRS = $CORE->callService('getComboardMessages','comboardServer',$input);
	$result['DB']['Agenda'] = $ComboardmessageRS['DB']['ComboardMessagesByType']['task'];
	$result['DB']['message'] = $ComboardmessageRS['DB']['ComboardMessagesByType']['message'];
	return $result;
}

function setCodeLang($input='')
{
	global $CORE;
	//get input
	if(empty($input)) $input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	
	$CORE->setSessionVar('setCodeLang',$input['setCodeLang']);
		
	return $result;
}

?>