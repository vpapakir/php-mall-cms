<?php
//Section entity WebService public methods
function manageOwners()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['Owner'.DTR.'OwnerID']))
		{
			$DS->query("DELETE FROM Owner WHERE OwnerID='".$input['Owner'.DTR.'OwnerID']."'");
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		//if(is_array($input['Owner'.DTR.'OwnerName']))
		//{
			//foreach($input['Owner'.DTR.'OwnerName'] as $langCode=>$value)
			//{
				//$OwnerName .= "<$langCode>".$value."</$langCode>";
			//}	
			//$input['Owner'.DTR.'OwnerName'] = $OwnerName;
		//}	
		$where['Owner'] = "OwnerID='".$input['Owner'.DTR.'OwnerID']."'";
		$input['actionMode']='save';
		//print_r($input);
		$saveResult = $DS->save($input,$where);
		//if(empty($entityID)) $entityID= $DS->dbLastID();
	}	
	
	//$section->getOwners($input);
	//get language fields drop down
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM Owner WHERE OwnerID='$entityID'");
		$result['DB']['Owner'] = $fieldRS;
	}
	
	$resultList = $DS->query("SELECT * FROM Owner ORDER BY OwnerCode");
	$mode['name']='OwnerID';
	$mode['id']='OwnerID';
	$mode['value']='OwnerName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('OwnerNew.core.tip').' -';
	$result['Refs']['Owners']= $CORE->getLists($resultList,$input['OwnerID'],$mode,$config['lang']);	

	//get activation status 
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Owner'.DTR.'PermAll',$fieldRS[0]['PermAll'],$config['lang'],$mode);

	//get is default status 
	$mode='';
	$mode['code']='Y';
	$result['Refs']['OwnerIsDefault'] = $CORE->getType('YesNo','Owner'.DTR.'OwnerIsDefault',$fieldRS[0]['OwnerIsDefault'],$config['lang'],$mode);
	
	$stylesRS = getStylesList();
	$result['DB']['Styles'] = $stylesRS['DB']['Styles'];
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];
	return $result;
}

function getOwners()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$owner = new OwnerClass();		
	$input['PermAll'] = 1;
	$result['DB']['Owners'] = $owner->getOwners($input);
	return $result;
}

function getOwner()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$owner = new OwnerClass();		
	$input['PermAll'] = 1;
	$result['DB']['Owner'] = $owner->getOwner($input);
	return $result;
}

function addOwner()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$owner = new OwnerClass();	
	
	if($input['actionMode']=='add')
	{
		$result['DB']['Owner'] = $owner->addOwner($input);
	}			

	$result['DB']['Owner'] = $owner->getOwner($input);
		
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];	
	return $result;
}




?>