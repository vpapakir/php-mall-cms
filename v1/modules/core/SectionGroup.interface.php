<?php
//Section entity WebService public methods
function manageSectionGroups()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedSectionGroupID'];
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['SectionGroup'.DTR.'SectionGroupID']))
		{
			$DS->query("DELETE FROM SectionGroup WHERE SectionGroupID='".$input['SectionGroup'.DTR.'SectionGroupID']."'");
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		//if(is_array($input['SectionGroup'.DTR.'AccessGroups'])) {$input['SectionGroup'.DTR.'AccessGroups'] = '|'. implode("|",$input['SectionGroup'.DTR.'AccessGroups']).'|'; }
		$where['SectionGroup'] = "SectionGroupID='".$input['SectionGroup'.DTR.'SectionGroupID']."'";
		$input['actionMode']='save';
		if(!empty($input['SectionGroup'.DTR.'SectionGroupCode']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='".$input['SectionGroup'.DTR.'SectionGroupCode']."'");
		}
		if(count($checkRS)<1)
		{
			$saveResult = $DS->save($input,$where);
		}
		updateSectionGroupPositions($input['SectionGroup'.DTR.'SectionGroupCode'],$input['SectionGroup'.DTR.'SectionGroupID']);
		
	}	
	
	//$section->getSectionGroups($input);
	//get language fields drop down
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM SectionGroup WHERE SectionGroupID='$entityID'");
		$result['DB']['SectionGroup'] = $fieldRS;
	}
	
	$resultList = $DS->query("SELECT * FROM SectionGroup ORDER BY SectionGroupPosition");
	$result['DB']['SectionGroups']= $resultList;
	$mode['name']='selectedSectionGroupID';
	$mode['id']='SectionGroupID';
	$mode['value']='SectionGroupName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('SectionGroupNew.core.tip').' -';
	$result['Refs']['SectionGroups']= $CORE->getLists($resultList,$input['selectedSectionGroupID'],$mode,$config['lang']);	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];
	
	$userGroupsRS = $CORE->callService("getUserGroups",'sessionServer');
	$result['DB']['UserGroups'] = $userGroupsRS['DB']['UserGroups'];

	$modulesRS = getModules();
	$result['DB']['Modules'] = $modulesRS['DB']['Modules'];
	
	return $result;
}

function updateSectionGroupPositions($entityID,$referenceID)
{
	global $CORE;
	//set global variables
	$DS = new DataSource('main');
	//$config = $this->_config;
	//$user = $this->_user;		
	$userID = $input['UserID'];
	$clientType = $config['ClientType'];	
	$ownerID = $config['OwnerID'];
	$input = $CORE->getInput();
	//set client side variables
	if(empty($entityID) || empty($referenceID))
	{
		return '';
	}
	$query = "SELECT SectionGroupID, SectionGroupPosition FROM SectionGroup ORDER BY SectionGroupPosition ASC";			
	$rs = $DS->query($query);
	$i=2;
	
	foreach($rs as $row)
	{
		$DS->query("UPDATE SectionGroup SET SectionGroupPosition='$i' WHERE SectionGroupID='".$row['SectionGroupID']."'");
		$i = $i+2;
	}
	//return $result;		
}	

?>