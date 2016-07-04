<?php
//Section entity WebService public methods
function manageLanguages()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedLanguageID'];
	//$section = new SectionClass();
	if($input['actionMode']=='delete')
	{
		if(!empty($input['Language'.DTR.'LanguageID']))
		{
			$DS->query("DELETE FROM Language WHERE LanguageID='".$input['Language'.DTR.'LanguageID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['Language'.DTR.'LanguageID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Language WHERE LanguageID='".$input['Language'.DTR.'LanguageID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Resource'.DTR.$fileField][$lang]=' ';}else{	$input['Resource'.DTR.$fileField]=' ';}
			$input['Language'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$where['Language'] = "LanguageID='".$input['Language'.DTR.'LanguageID']."'";
			
			$DS->save($input,$where);
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{	
		$CORE->setConfigVar("UseImageResize",'N');
		$CORE->setConfigVar("UseImagePreview",'N');		
		$CORE->setInputVar('File'.DTR.'FilePath','images/icons');
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'Language');	
		$where['Language'] = "LanguageID='".$input['Language'.DTR.'LanguageID']."'";
		$input['actionMode']='save';
		//print_r($input);
		$saveResult = $DS->save($input,$where);
		//if(empty($entityID)) $entityID= $DS->dbLastID();
	}	
	//get languages drop down
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM Language WHERE LanguageID='$entityID'");
		$result['DB']['Language'] = $fieldRS;
	}
	
	$resultList = $DS->query("SELECT * FROM Language  ORDER BY LanguageCode");
	$mode['name']='selectedLanguageID';
	$mode['id']='LanguageID';
	$mode['value']='LanguageName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('LanguageNew.core.tip').' -';
	$result['Refs']['Languages']= $CORE->getLists($resultList,$input['selectedLanguageID'],$mode,$config['lang']);	

	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Language'.DTR.'PermAll',$fieldRS[0]['PermAll'],$config['lang'],$mode);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];
	return $result;
}

function getLanguages()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$result['DB']['Languages'] = $DS->query("SELECT * FROM Language WHERE PermAll=1 ORDER BY LanguageCode");

	return $result;
}

?>