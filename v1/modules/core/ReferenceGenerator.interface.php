<?php
//Section entity WebService public methods
function manageReferenceGenerator($input='')
{
	global $CORE;
	//get input
	if(empty($input)){$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['ReferenceCodeID'];
	
	if($input['actionMode']=='delete')
	{
		if(!empty($input['ReferenceCode'.DTR.'ReferenceCodeID']))
		{
			$DS->query("DELETE FROM ReferenceCode WHERE ReferenceCodeID='".$input['ReferenceCode'.DTR.'ReferenceCodeID']."'");
			//$DS->query("DELETE FROM ReferenceCodeOption WHERE ReferenceGeneratorID='".$input['ReferenceGenerator'.DTR.'ReferenceGeneratorID']."'");			
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		foreach($input['ReferenceGenerator'.DTR.'ReferenceGeneratorCode'] as $key=>$row){
			if(!empty($row)){
				$where['ReferenceGenerator'] = "ReferenceGeneratorID='".$input['ReferenceGenerator'.DTR.'ReferenceGeneratorID'][$key]."'";
				$inputSave['actionMode']='save';
				$inputSave['ReferenceGenerator'.DTR.'ReferenceGeneratorCode'] = $row;
				$inputSave['ReferenceGenerator'.DTR.'ReferenceGeneratorName'] = $input['ReferenceGenerator'.DTR.'ReferenceGeneratorName'.$key];
				$inputSave['ReferenceGenerator'.DTR.'ReferenceGeneratorType'] = $key;
				$saveResult = $DS->save($inputSave,$where);
			}
		}
		
		/*if(is_array($input['ReferenceCode'.DTR.'ReferenceCode']) && !empty($input['ReferenceCode'.DTR.'ReferenceCode'][0])){
			$inputCode['ReferenceCode'.DTR.'ReferenceCode'] = implode(".",$input['ReferenceCode'.DTR.'ReferenceCode']);
			
			$where['ReferenceCode'] = "ReferenceCodeID='".$input['ReferenceCode'.DTR.'ReferenceCodeID']."'";
			$inputCode['actionMode']='save';
			$saveResult = $DS->save($inputCode,$where);
			//if(empty($entityID)) $entityID = $saveResult[0]['ReferenceCodeID'];
		}*/
	}	

	if(!empty($entityID))
	{
		$refRS = $DS->query("SELECT * FROM ReferenceCode WHERE ReferenceCodeID='$entityID'");
		$result['DB']['ReferenceCode'] = $refRS;
	}
	
	$result['DB']['ReferenceCode1'] = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorType='0'");
	$result['DB']['ReferenceCode2'] = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorType='1'");
	$result['DB']['ReferenceCode3'] = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorType='2'");
	$result['DB']['ReferenceCode4'] = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorType='3'");
	
	if(!empty($input['ReferenceCode'.DTR.'ReferenceCode'][0])){
		$refRS = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorCode='".$input['ReferenceCode'.DTR.'ReferenceCode'][0]."'");
		
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorID1'] = $refRS[0]['ReferenceGeneratorID'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorCode1'] = $refRS[0]['ReferenceGeneratorCode'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorName1'] = $refRS[0]['ReferenceGeneratorName'];
	}
	
	if(!empty($input['ReferenceCode'.DTR.'ReferenceCode'][1])){
		$refRS = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorCode='".$input['ReferenceCode'.DTR.'ReferenceCode'][1]."'");
		
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorID2'] = $refRS[0]['ReferenceGeneratorID'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorCode2'] = $refRS[0]['ReferenceGeneratorCode'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorName2'] = $refRS[0]['ReferenceGeneratorName'];
	}
	
	if(!empty($input['ReferenceCode'.DTR.'ReferenceCode'][2])){
		$refRS = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorCode='".$input['ReferenceCode'.DTR.'ReferenceCode'][2]."'");
		
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorID3'] = $refRS[0]['ReferenceGeneratorID'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorCode3'] = $refRS[0]['ReferenceGeneratorCode'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorName3'] = $refRS[0]['ReferenceGeneratorName'];
	}
	
	if(!empty($input['ReferenceCode'.DTR.'ReferenceCode'][3])){
		$refRS = $DS->query("SELECT * FROM ReferenceGenerator WHERE ReferenceGeneratorCode='".$input['ReferenceCode'.DTR.'ReferenceCode'][3]."'");
		
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorID4'] = $refRS[0]['ReferenceGeneratorID'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorCode4'] = $refRS[0]['ReferenceGeneratorCode'];
		$result['DB']['ReferenceGenerator']['ReferenceGeneratorName4'] = $refRS[0]['ReferenceGeneratorName'];
	}
	
	$input['treeType']='all';
	$input['downLevels']='all';
	$input['SectionType'] = 'front';
	$input['SectionViewType'] = 'resource.getResourcesOnPage';
	$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
	$inputValues = $sectionsRS['DB']['SectionsList'];
	//print_r($sectionsRS);
	$result['DB']['ResourceCategories'] = $inputValues;
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	return $result;
}
?>