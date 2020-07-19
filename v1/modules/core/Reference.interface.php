<?php
//Section entity WebService public methods
function manageReferences($input='')
{
	global $CORE;
	//get input
	if(empty($input)){$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedReferenceID'];
	
	$entityOptionID = $input['selectedReferenceOptionID'];
	$entityCode = $input['ReferenceCode'];
	if(!empty($entityCode))
	{
		$entityIDRS =$DS->query("SELECT ReferenceID FROM Reference WHERE ReferenceCode='$entityCode'");
		$entityID = $entityIDRS[0]['ReferenceID'];
		$input['selectedReferenceID'] = $entityID;
		$CORE->setInputVar('selectedReferenceID',$entityID);
	}
	//$section = new SectionClass();
	//print_r($input);
	if($input['actionMode']=='delete')
	{
		if(!empty($input['Reference'.DTR.'ReferenceID']))
		{
			$DS->query("DELETE FROM Reference WHERE ReferenceID='".$input['Reference'.DTR.'ReferenceID']."'");
			$DS->query("DELETE FROM ReferenceOption WHERE ReferenceID='".$input['Reference'.DTR.'ReferenceID']."'");			
		}
	}
	elseif($input['actionMode']=='deleteoption')
	{
		if(!empty($input['ReferenceOption'.DTR.'ReferenceOptionID']))
		{
			$DS->query("DELETE FROM ReferenceOption WHERE ReferenceOptionID='".$input['ReferenceOption'.DTR.'ReferenceOptionID']."'");
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$where['Reference'] = "ReferenceID='".$input['Reference'.DTR.'ReferenceID']."'";
		$input['actionMode']='save';
		//print_r($input);
		$saveResult = $DS->save($input,$where);
		//if(empty($entityID)) $entityID= $DS->dbLastID();
	}	
	elseif($input['actionMode']=='deleteoptionfile')
	{
		if(!empty($input['ReferenceOption'.DTR.'ReferenceOptionID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReferenceOption WHERE ReferenceOptionID='".$input['ReferenceOption'.DTR.'ReferenceOptionID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			//if(!empty($lang)){	$input['Resource'.DTR.$fileField][$lang]=' ';}else{	$input['Resource'.DTR.$fileField]=' ';}
			$input['ReferenceOption'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$where['ReferenceOption'] = "ReferenceOptionID='".$input['ReferenceOption'.DTR.'ReferenceOptionID']."'";
			$input['actionMode']='save';
			//print_r($input);
			$saveResult = $DS->save($input,$where);
		}
	}		
	elseif($input['actionMode']=='saveoption')
	{
		$FM = new FilesManager();
		$input = $FM->getUploadedFields($input,'ReferenceOption');	
		
		$where['ReferenceOption'] = "ReferenceOptionID='".$input['ReferenceOption'.DTR.'ReferenceOptionID']."'";
		$input['actionMode']='save';
		print_r($input);
		$saveResult = $DS->save($input,$where);
		if(empty($input['selectedReferenceOptionID'])) {$input['selectedReferenceOptionID'] = $DS->dbLastID(); $insertMode='Y'; }
		$entityOptionID = $input['selectedReferenceOptionID'];
		$refOptionObject = new ReferenceClass();
		$refOptionObject->updateReferenceOptionPositions($input['ReferenceOption'.DTR.'ReferenceOptionID'],$entityID);
	}	

	//===============================================Get ==================================
	$resultList = $DS->query("SELECT * FROM Reference");
	$mode='';	
	$mode['name']='ReferenceCode';
	$mode['id']='ReferenceCode';
	$mode['value']='ReferenceName';
	$mode['action']='submit();';
	$mode['options'][0]['id']='';	
	$mode['options'][0]['value']='- New reference -';
	$result['Refs']['References'] = $CORE->getLists($resultList,$input['ReferenceCode'],$mode,$config['lang']);
	
	//get selected ref
	if(!empty($entityID))
	{
		$refRS = $DS->query("SELECT * FROM Reference WHERE ReferenceID='$entityID'");
		$result['DB']['Reference'] = $refRS;
	}
	//get list of presentation types of a ref
	$mode='';
	$mode['code']='Y';
	$result['Refs']['ReferenceType'] = $CORE->getType('ReferenceType','Reference'.DTR.'ReferenceType',$refRS[0]['ReferenceType'],$config['lang'],$mode);
	//get list of modules
	//$mode='';
	//$mode['code']='Y';
	//$result['Refs']['ReferenceModules'] = $CORE->getType('ReferenceModules','Reference'.DTR.'ReferenceModules',$refRS[0]['ReferenceModules'],$config['lang'],$mode);
	//get list of statuses
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('YesNo','Reference'.DTR.'PermAll',$refRS[0]['PermAll'],$config['lang'],$mode);
	
	//get options
	if(!empty($entityID))
	{
		if(!empty($entityOptionID) && $insertMode!='Y')
		{
			$optionRS = $DS->query("SELECT * FROM ReferenceOption WHERE ReferenceOptionID='".$entityOptionID."' ORDER BY OptionPosition");
			//echo 'ttt';
			//print_r($result);
			$result['DB']['ReferenceOption'] = $optionRS;
		}

		$resultList = $DS->query("SELECT * FROM ReferenceOption WHERE ReferenceID='$entityID' ORDER BY OptionPosition");
		
		$result['DB']['ReferenceOptions'] = $resultList;
		$mode['name']='selectedReferenceOptionID';
		$mode['id']='ReferenceOptionID';
		$mode['value']='OptionName';
		$mode['action']='submit();';
		$mode['options'][0]['id']='';	
		$mode['options'][0]['value']='- '.lang('ReferenceNewOption.core.tip').' -';
		$result['Refs']['ReferenceOptions']= $CORE->getLists($resultList,$input['selectedReferenceOptionID'],$mode,$config['lang']);	
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

function manageSinhronizeReferences($input='')
{
	global $CORE;
	//get input
	if(empty($input)){$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['selectedReferenceID'];
	
	$entityOptionID = $input['selectedReferenceOptionID'];
	$entityCode = $input['ReferenceCode'];
	if(!empty($entityCode))
	{
		$entityIDRS =$DS->query("SELECT ReferenceID FROM Reference WHERE ReferenceCode='$entityCode'");
		$entityID = $entityIDRS[0]['ReferenceID'];
		$input['selectedReferenceID'] = $entityID;
		$CORE->setInputVar('selectedReferenceID',$entityID);
	}
	$ReferenceOldRS =$DS->query("SELECT * FROM Reference_old");
	$ReferenceRS =$DS->query("SELECT * FROM Reference");
	$i=0;
	foreach($ReferenceOldRS as $key=>$value){
		foreach($ReferenceRS as $id=>$row){
			if($value['ReferenceCode']==$row['ReferenceCode']){
				$i=1;
			}
		}		
		if($i==0){
			$i=0;
			$where['Reference'] = "ReferenceID='".$inputSave['Reference'.DTR.'ReferenceID']."'";
			$inputSave['actionMode']='save';
			$inputSave['Reference'.DTR.'ReferenceID'] = $inputSave['Reference'.DTR.'ReferenceID'];
			$inputSave['Reference'.DTR.'ReferenceCode'] = $value['ReferenceCode'];
			$inputSave['Reference'.DTR.'PermAll'] = $value['PermAll'];
			$inputSave['Reference'.DTR.'ReferenceName'] = $value['ReferenceName'];
			$inputSave['Reference'.DTR.'ReferenceType'] = $value['ReferenceType'];
			$inputSave['Reference'.DTR.'ReferenceModules'] = $value['ReferenceModules'];
			$inputSave['Reference'.DTR.'ReferenceModule'] = $value['ReferenceModule'];
			$inputSave['Reference'.DTR.'AccessGroups'] = $value['AccessGroups'];
			echo $value['ReferenceCode']."<br/>";
			$saveResult = $DS->save($inputSave,$where);
			$ReferenceOptionRS =$DS->query("SELECT * FROM ReferenceOption_old WHERE ReferenceID='".$value['ReferenceID']."'");
			if(is_array($ReferenceOptionRS)){
				foreach($ReferenceOptionRS as $option){
					$whereOP['ReferenceOption'] = "ReferenceOptionID='".$inputSaveOP['ReferenceOption'.DTR.'ReferenceOptionID']."'";
					$inputSaveOP['actionMode']='save';
					$inputSaveOP['ReferenceOption'.DTR.'ReferenceOptionID'] = $inputSaveOP['ReferenceOption'.DTR.'ReferenceOptionID'];
					$inputSaveOP['ReferenceOption'.DTR.'OptionCode'] = $option['OptionCode'];
					$inputSaveOP['ReferenceOption'.DTR.'ReferenceID'] = $saveResult[0]['ReferenceID'];
					$inputSaveOP['ReferenceOption'.DTR.'OptionName'] = $option['OptionName'];
					$inputSaveOP['ReferenceOption'.DTR.'OptionIcon'] = $option['OptionIcon'];
					$inputSaveOP['ReferenceOption'.DTR.'OptionPosition '] = $option['OptionPosition'];

					$saveResultOP = $DS->save($inputSaveOP,$whereOP);
				}
			}
		}
	}
	//$section = new SectionClass();
	//print_r($input);
	if($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$where['Reference'] = "ReferenceID='".$input['Reference'.DTR.'ReferenceID']."'";
		$input['actionMode']='save';
		//print_r($input);
		$saveResult = $DS->save($input,$where);
		//if(empty($entityID)) $entityID= $DS->dbLastID();
	}	
	elseif($input['actionMode']=='saveoption')
	{
		$where['ReferenceOption'] = "ReferenceOptionID='".$input['ReferenceOption'.DTR.'ReferenceOptionID']."'";
		$input['actionMode']='save';
		$saveResult = $DS->save($input,$where);
	}	

	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

?>