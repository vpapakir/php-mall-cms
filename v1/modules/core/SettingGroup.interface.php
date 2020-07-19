<?php
//Section entity WebService public methods
function manageSettingGroups()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedSettingGroupID'];
	
	if(empty($entityID)) {$entityID = $input['Level2GroupID'];}
	if(empty($entityID) && empty($input['GroupParentID'])) {$entityID = $input['GroupID'];}
	
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['SettingGroup'.DTR.'SettingGroupID']))
		{
			$DS->query("DELETE FROM SettingGroup WHERE SettingGroupID='".$input['SettingGroup'.DTR.'SettingGroupID']."'");
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{		
		if(!empty($input['GroupParentID']))
		{
			$input['SettingGroup'.DTR.'SettingGroupParentID'] = $input['GroupParentID'];
		}	
		//if(is_array($input['SettingGroup'.DTR.'AccessGroups'])) {$input['SettingGroup'.DTR.'AccessGroups'] = '|'. implode("|",$input['SettingGroup'.DTR.'AccessGroups']).'|'; }
		$where['SettingGroup'] = "SettingGroupID='".$input['SettingGroup'.DTR.'SettingGroupID']."'";
		if(!empty($input['SettingGroup'.DTR.'SettingGroupCode']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT SettingGroupID FROM SettingGroup WHERE SettingGroupCode='".$input['SettingGroup'.DTR.'SettingGroupCode']."'");
		}
		if(count($checkRS)<1 && !empty($input['SettingGroup'.DTR.'SettingGroupCode']))
		{
			$input['actionMode']='save';
			$saveResult = $DS->save($input,$where);
		}
	}	
	
	//$section->getSettingGroups($input);
	//get language fields drop down
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM SettingGroup WHERE SettingGroupID='$entityID'");
		$result['DB']['SettingGroup'] = $fieldRS;
	}
	
	if(!empty($input['Level2GroupID'])) {$filter = " WHERE SettingGroupParentID='".$input['GroupID']."' ";} else {$filter=' WHERE SettingGroupParentID=0 ';}
	if(!empty($input['GroupParentID'])) {$filter = " WHERE SettingGroupParentID='".$input['GroupParentID']."' ";} else {$filter=' WHERE SettingGroupParentID=0 ';}
	
	$resultList = $DS->query("SELECT * FROM SettingGroup $filter  ORDER BY SettingGroupCode");
	$mode['name']='selectedSettingGroupID';
	$mode['id']='SettingGroupID';
	$mode['value']='SettingGroupName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('SettingGroupNew.core.tip').' -';
	$result['Refs']['SettingGroups']= $CORE->getLists($resultList,$entityID,$mode,$config['lang']);	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];
	
	$userGroupsRS = $CORE->callService("getUserGroups",'sessionServer');
	$result['DB']['UserGroups'] = $userGroupsRS['DB']['UserGroups'];
		
	return $result;
}

?>