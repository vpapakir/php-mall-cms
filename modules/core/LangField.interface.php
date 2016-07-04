<?php
//Section entity WebService public methods
function manageLangFields()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedLangFieldID'];
	$entityCode = $input['selectedLangFieldCode'];
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['LangField'.DTR.'LangFieldID']))
		{
			$DS->query("DELETE FROM LangField WHERE LangFieldID='".$input['LangField'.DTR.'LangFieldID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['LangFieldID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM LangField WHERE LangFieldID='".$input['LangFieldID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if($FM->deleteFile($filePath))
			//{
				//$DS->query("UPDATE Section SET ".$fileField."='' WHERE SectionID='".$input['SectionID']."'");
				$inputSave['LangField'.DTR.'LangFieldID']=$input['LangFieldID'];
				if(!empty($lang))
				{
					$inputSave['LangField'.DTR.$fileField][$lang]=' ';
				}
				else
				{
					$inputSave['LangField'.DTR.$fileField]=' ';
				}
				$inputSave['LangField'.DTR.$fileField]=' ';
				$inputSave['actionMode']='save';
				$where['LangField'] = "LangFieldID='".$inputSave['LangField'.DTR.'LangFieldID']."'";
				//print_r($inputSave);
				$DS->save($inputSave,$where);
			//}
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add' || $input['actionMode']=='next')
	{
		$CORE->setConfigVar("UseImageResize",'N');
		$CORE->setConfigVar("UseImagePreview",'N');
		$CORE->setInputVar('File'.DTR.'FilePath','images/langfields');
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(is_array($uploadRS))
		{
			foreach($uploadRS as $fileFieldName=>$fielResultValue)
			{
				if(eregi("_lang_",$fileFieldName))
				{
					$pos = strrpos($fileFieldName, "_");
					$lang = substr($fileFieldName,$pos+1);
					$fileFieldNameDB = str_replace("_lang_".$lang,"",$fileFieldName);
					
					$input['LangField'.DTR.$fileFieldNameDB][$lang]= $fielResultValue['file'];
				}
				else
				{	
					$input['LangField'.DTR.$fileFieldName]= $fielResultValue['file'];
				}
			}
		}
		//print_r($input);
		//if(is_array($input['LangField'.DTR.'modules'])) {$input['types'.DTR.'modules'] = '|'. implode("|",$input['types'.DTR.'modules']).'|'; }
		$where['LangField'] = "LangFieldID='".$input['LangField'.DTR.'LangFieldID']."'";

		if($input['actionMode']=='next')
		{
			$resultList1 = $DS->query("SELECT * FROM LangField  ORDER BY Code");
			foreach($resultList1 as $k=>$v)
			{
				if($input['LangField'.DTR.'LangFieldID'] == $v['LangFieldID'])
				{
					$entity=$resultList1[$k+1];
				}
			}
			$entityID = $entity['LangFieldID'];
		}
		
		if(!empty($input['LangField'.DTR.'Code']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT Code FROM LangField WHERE Code='".$input['LangField'.DTR.'Code']."'");
		}
		if(count($checkRS)<1 && !empty($input['LangField'.DTR.'Code'])  && !empty($input['LangField'.DTR.'Value']))
		{			
			$input['actionMode']='save';	
			$saveResult = $DS->save($input,$where);
		}
		//if(empty($entityID)) $entityID= $DS->dbLastID();
	}	
	
	//$section->getLangFields($input);
	//get language fields drop down
	if(!empty($input['searchWord']))
	{
		$resultList = $DS->query("SELECT * FROM LangField  WHERE (Code LIKE '%".$input['searchWord']."%' OR Value LIKE '%".$input['searchWord']."%') ORDER BY Code");
		if( !empty($resultList) && empty($entityID) ) $entityID=$resultList[0]['LangFieldID'];
		$result['searchWord'] = $input['searchWord'];
	}
	else
	{
		$resultList = $DS->query("SELECT * FROM LangField  ORDER BY Code");
	}
	
	if(!empty($entityID)){
		$fieldRS = $DS->query("SELECT * FROM LangField WHERE LangFieldID='$entityID'");
		$result['DB']['LangField'] = $fieldRS;
	}elseif(!empty($entityCode)){
		$fieldRS = $DS->query("SELECT * FROM LangField WHERE Code='$entityCode'");
		$result['DB']['LangField'] = $fieldRS;
	}
	
	$mode['name']='selectedLangFieldID';
	$mode['id']='LangFieldID';
	$mode['value']='Code';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('LangFieldNew.core.tip').' -';
	$result['Refs']['LangFields']= $CORE->getLists($resultList,$input['selectedLangFieldID'],$mode,$config['lang']);	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	return $result;
}

function synchronizeLangFieldsClient($input='')
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
	$in['SynchronizationMethod'] = 'synchronizeLangFieldsServer';
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


function synchronizeLangFieldsClientCheckStatus($input='')
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


function synchronizerCheckStatusLangFieldsServer($input='')
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


function synchronizeLangFieldsServer($input='')
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

?>