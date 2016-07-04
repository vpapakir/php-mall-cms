<?php
//Section entity WebService public methods
function manageSettings($input='')
{
	global $CORE;
	//get input
	if(empty($input)) $input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$groupID = $input['GroupID'];
	$StyleClass = new StyleClass();
	
	if(empty($groupID)){
		$defaultGoupRS = $DS->query("SELECT SettingGroupID FROM SettingGroup WHERE SettingGroupCode='main'");
		$groupID = $defaultGoupRS[0]['SettingGroupID'];
		$CORE->setInputVar("GroupID",$groupID);
	}
	$entityID = $input['SettingID'];
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['Setting'.DTR.'SettingID']))
		{
			$DS->query("DELETE FROM Setting WHERE SettingID='".$input['Setting'.DTR.'SettingID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['SettingID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Setting WHERE SettingID='".$input['SettingID']."'");
			//if($FM->deleteFile($fileFieldRS[0][$fileField]))
			//{
				$DS->query("UPDATE Setting SET ".$fileField."='' WHERE SettingID='".$input['SettingID']."'");
			//}
		}
	}		
	elseif($input['actionMode']=='save')
	{
		if(is_array($input['Setting'.DTR.'SettingID'])){
			foreach($input['Setting'.DTR.'SettingID'] as $id=>$value)
			{
				//$inputSave['Setting'.DTR.'SettingVariableName'] = $input['Setting'.DTR.'SettingVariableName'][$id];
				if(is_array($input['Setting'.DTR.'SettingValue_'.$value]))
				{
					$fieldValeResult='';
					$k=1;
					foreach($input['Setting'.DTR.'SettingValue_'.$value] as $itemIndex=>$itemValue)
					{
						if(is_numeric($itemIndex))
						{
							if($k==1)
							{
								$fieldValeResult .= "|$itemValue|";
								$k++;
							}
							else
							{
								$fieldValeResult .= "$itemValue|";
							}
						}
						else
						{
							if(trim($itemValue))
							{
								$fieldValeResult .= "<$itemIndex>".$itemValue."</$itemIndex>";
							}
							else
							{
								$fieldValeResult .= ' ';
							}
						}
					}
					$inputSave['Setting'.DTR.'SettingValue'] = $fieldValeResult;
				}
				else
				{
					if(!empty($input['Setting'.DTR.'SettingValue_'.$value])) {$inputSave['Setting'.DTR.'SettingValue'] = $input['Setting'.DTR.'SettingValue_'.$value];}
					else {$inputSave['Setting'.DTR.'SettingValue'] = $input['Setting'.DTR.'SettingValue'][$value];}
				}
				//print_r($input);
				$inputSave['Setting'.DTR.'SettingID'] = $value;
				
				//$inputSave['Setting'.DTR.'SettingName'] = $input['Setting'.DTR.'SettingName'][$id];
				//$inputSave['Setting'.DTR.'SettingValueType'] = $input['Setting'.DTR.'SettingValueType'][$id];
				//$inputSave['Setting'.DTR.'SettingValueOptions'] = $input['Setting'.DTR.'SettingValueOptions'][$id];
				//$inputSave['Setting'.DTR.'SettingType'] = $input['Setting'.DTR.'SettingType'][$id];
				//$inputSave['Setting'.DTR.'SettingDescription'] = $input['Setting'.DTR.'SettingDescription'][$id];
				//$inputSave['Setting'.DTR.'SettingGroup'] = $input['Setting'.DTR.'SettingGroup'][$id];
				//$inputSave['Setting'.DTR.'SettingModule'] = $input['Setting'.DTR.'SettingModule'][$id];
				//if(is_array($input['Setting'.DTR.'modules'])) {$input['types'.DTR.'modules'] = '|'. implode("|",$input['types'.DTR.'modules']).'|'; }
				
				
				$inputSave['actionMode']='save';
				$where['Setting'] = "SettingID='".$value."'";
				$saveResult = $DS->save($inputSave,$where);			
			}
		}    	
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		$CORE->setConfigVar("UseImageResize",'N');
		$CORE->setConfigVar("UseImagePreview",'N');				
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['SettingValue']['file']))
		{
			$input['Setting'.DTR.'SettingValue']= $uploadRS['SettingValue']['file'];
		}	
		if(is_array($input['Setting'.DTR.'SettingValue']))
		{
			if($input['Setting'.DTR.'SettingValueType']=='text')
			{
				foreach($input['Setting'.DTR.'SettingValue'] as $langCode=>$value)
				{
					if(trim($value))
					{
						$SettingValue .= "<$langCode>".$value."</$langCode>";
					}
				}
				if(empty($SettingValue)) {$SettingValue=' ';}
			}
			else
			{
				$SettingValue = '|'. implode("|",$input['Setting'.DTR.'SettingValue']).'|';
			}
			$input['Setting'.DTR.'SettingValue'] = $SettingValue;	
		}
		$where['Setting'] = "SettingID='".$input['Setting'.DTR.'SettingID'] ."'";
		
		//check group type
		$grupCodeRS = $DS->query("SELECT SettingGroupCode FROM SettingGroup WHERE SettingGroupID='".$input['Setting'.DTR.'SettingGroup']."'");
		$groupCodeValue = $grupCodeRS[0]['SettingGroupCode'];
		if(ereg('style',$groupCodeValue))
		{
			$input['Setting'.DTR.'SettingVariableName'] = str_replace($groupCodeValue.'.',"",$input['Setting'.DTR.'SettingVariableName']);
			$input['Setting'.DTR.'SettingVariableName'] = $groupCodeValue.'.'.$input['Setting'.DTR.'SettingVariableName'];
		}
					
		if(!empty($input['Setting'.DTR.'SettingVariableName']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT SettingVariableName FROM Setting WHERE SettingVariableName='".$input['Setting'.DTR.'SettingVariableName']."'");
		}
		//print_r($checkRS);
		if(count($checkRS)<1 && !empty($input['Setting'.DTR.'SettingVariableName']))
		{		
			$lastActioMode = $input['actionMode'];
			$input['actionMode']='save';		
			$saveResult = $DS->save($input,$where);
			$entityUpdateID = $input['Setting'.DTR.'SettingID'];
			if($lastActioMode=='add') {$entityID = $saveResult[0]['SettingID']; $entityUpdateID=$entityID; }
			
			if(!empty($entityUpdateID) && !empty($groupID))
			{
				$query = "SELECT SettingID, SettingPosition FROM Setting WHERE SettingGroup='$groupID' ORDER BY SettingPosition ASC";			
				$rs = $DS->query($query);
				$pi=2;
				if(is_array($rs))
				{
					foreach($rs as $row)
					{
						$DS->query("UPDATE Setting SET SettingPosition='$pi' WHERE SettingID='".$row['SettingID']."'");
						$pi = $pi+2;
					}	
				}			
			}
			
			if($input['Level2GroupID']=='11365480442006051812025318f111'){
				$StyleClass->setStyle($input);
			}
		}
	}		
	
	//$section->getSettings($input);
	//get language fields drop down
	/*
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM Setting WHERE SettingID='$entityID'");
		$result['DB']['Setting'] = $fieldRS;
	}
	*/
	$filter = " AND (AccessGroups LIKE '%|all|%' OR AccessGroups LIKE '%|".$user['GroupID']."|%' OR AccessGroups='' OR AccessGroups IS NULL) ";
	
	$resultList = $DS->query("SELECT * FROM SettingGroup WHERE SettingGroupParentID=0 $filter  ORDER BY SettingGroupCode");
	$result['DB']['SettingGroups'] = $resultList;

	$resultList = $DS->query("SELECT * FROM Reference ORDER BY ReferenceID");
	$result['DB']['SettingReferences'] = $resultList;

	if(!empty($groupID))
	{
		if(!empty($input['Level2GroupID'])) {$settinggroupID = $input['Level2GroupID'];} else {$settinggroupID = $groupID;}
		if($input['Level2GroupID']=='11365480442006051812025318f111'){
			$order = 'SettingName';
		}else{
			$order = 'SettingPosition';
		}
		$entityRS = $DS->query("SELECT * FROM Setting WHERE SettingGroup='$settinggroupID' ORDER BY $order ASC");
		$result['DB']['Settings'] = $entityRS;
		
		$groupRS = $DS->query("SELECT * FROM SettingGroup WHERE SettingGroupID='$groupID' ORDER BY SettingGroupCode ASC");
		$result['DB']['SettingGroup'] = $groupRS;		
		
		$level2GroupRS = $DS->query("SELECT * FROM SettingGroup WHERE SettingGroupParentID='$groupID' ORDER BY SettingGroupCode ASC");
		$result['DB']['SettingGroupLevel2'] = $level2GroupRS;		
	}
	if(!empty($entityID))
	{
		$entityRS = $DS->query("SELECT * FROM Setting WHERE SettingID='$entityID'");
		$result['DB']['Setting'] = $entityRS;
	}	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}


function getStylesList()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$query = "SELECT SettingGroupCode, SettingGroupName FROM SettingGroup WHERE SettingGroupCode LIKE 'style%' AND SettingGroupParentID=0 ORDER BY SettingGroupCode";	
	$stylesRS = $DS->query($query);
	$result['DB']['Styles'] = $stylesRS;
	return $result;
}
?>