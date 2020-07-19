<?php
//Section entity WebService public methods
function manageMailTemplates()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['MailTemplateID'];
	//$section = new SectionClass();
	if(empty($entityID) && !empty($input['MailTemplateCode']))
	{
		$templateIDRS = $DS->query("SELECT MailTemplateID FROM MailTemplate WHERE MailTemplateCode='".$input['MailTemplateCode']."' ");
		$entityID = $templateIDRS[0]['MailTemplateID'];
		$input['MailTemplateID'] = $entityID;
		$CORE->setInputVar('MailTemplateID',$entityID);
		
	}
	if($input['actionMode']=='delete')
	{
		if(!empty($input['MailTemplate'.DTR.'MailTemplateID']))
		{
			$DS->query("DELETE FROM MailTemplate WHERE MailTemplateID='".$input['MailTemplate'.DTR.'MailTemplateID']."'");
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$where['MailTemplate'] = "MailTemplateID='".$input['MailTemplate'.DTR.'MailTemplateID']."'";
		$input['actionMode']='save';
		//print_r($input);
		$saveResult = $DS->save($input,$where);
	}	
	//$section->getMailTemplates($input);
	//get language fields drop down
	if(!empty($entityID))
	{
		$fieldRS = $DS->query("SELECT * FROM MailTemplate WHERE MailTemplateID='$entityID'");
		$result['DB']['MailTemplate'] = $fieldRS;
	}
	
	$resultList = $DS->query("SELECT * FROM MailTemplate ORDER BY MailTemplateCode");
	$mode['name']='MailTemplateID';
	$mode['id']='MailTemplateID';
	$mode['value']='MailTemplateName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- '.lang('MailTemplateNew.core.tip').' -';
	$result['Refs']['MailTemplates']= $CORE->getLists($resultList,$input['MailTemplateID'],$mode,$config['lang']);	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']['languageCodes'] = $languagesList['languageCodes'];
	$result['DB']['Languages']['languageNames'] = $languagesList['languageNames'];
	return $result;
}

?>