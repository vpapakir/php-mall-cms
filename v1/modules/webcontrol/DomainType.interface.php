<?php
//XCMSPro: DomainType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageDomainTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['DomainTypeID'];
	if(empty($entityID) && !empty($input['DomainTypeAlias']))
	{
		$DomainTypeForIDRS = $DS->query("SELECT DomainTypeID FROM DomainType WHERE DomainTypeAlias = '".$input['DomainTypeAlias']."'");
		$entityID = $DomainTypeForIDRS[0]['DomainTypeID'];
		$input['DomainTypeID'] = $entityID;
		$CORE->setInputVar("DomainTypeID",$entityID);
	}
	$entityAlias = $input['DomainType'];
	
	$entityFieldID = $input['DomainTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['DomainTypeFieldAlias']))
	{
		$DomainTypeFieldForIDRS = $DS->query("SELECT DomainTypeFieldID FROM DomainTypeField WHERE DomainTypeFieldAlias = '".$input['DomainTypeFieldAlias']."'");
		$entityFieldID = $DomainTypeFieldForIDRS[0]['DomainTypeFieldID'];
		$input['DomainTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("DomainTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['DomainTypeOptionID'];
	//creat objects			
	$DomainType = new DomainTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$DomainType->deleteDomainType($input);
		$DomainType->deleteDomainTypeField($input);
		$DomainType->deleteDomainTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$DomainType->setDomainType($input);
		$DomainType->setDomainTypeField($input);		
		$DomainType->setDomainTypeOption($input);
		//$DomainType->updateBoxPositions($input['DomainTypeBox'.DTR.'DomainTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyDomainType')
	{
		$DomainType->copyDomainType($input);
	}	

	$DomainTypesRS = $DomainType->getDomainTypes($input);
    //print_r($DomainTypesRS);
	/*foreach($DomainTypesRS as $id=>$value)
	{
		if($value['DomainTypeID']==1)
		{
			unset($DomainTypesRS[$id]);
		}
	}*/
	$result['DB']['DomainTypes'] = $DomainTypesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['DomainType'] = $DomainType->getDomainType($input);
		$result['DB']['DomainTypeFields'] = $DomainType->getDomainTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['DomainTypeField'] = $DomainType->getDomainTypeField($input);
			$result['DB']['DomainTypeOptions'] = $DomainType->getDomainTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['DomainTypeOption'] = $DomainType->getDomainTypeOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}


function getDomainTemplate($input)
{
	$DomainTypeObject = new DomainTypeClass();
	return $DomainTypeObject->getDomainTemplate($input['DomainType'],$input['DomainID']);
}

/**
* Gets DomainTypes. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getDomainTypes($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('DomainType.getDomainTypes.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$DomainType = new DomainTypeServer(&$SERVER,&$DS);
	//get content
	$DomainTypesRS = $DomainType->getDomainTypes($input);
	$SERVER->setOutput($DomainTypesRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('DomainType.getDomainTypes.End','End');
	return $returnValue;
}
/**
* Gets DomainType. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getDomainType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('DomainType.getDomainType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$DomainType = new DomainTypeServer(&$SERVER,&$DS);
	//get content
	$DomainTypeRS = $DomainType->getDomainType($input);
	$SERVER->setOutput($DomainTypeRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('DomainType.getDomainType.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageDomainType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('DomainType.manageDomainType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$DomainType = new DomainTypeServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$DomainType->setDomainType($input);
		$DomainType->setDomainTypeBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$DomainType->deleteDomainType($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$DomainType->deleteDomainTypeBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$DomainType->setDomainTypeBox($input);
	}	

	if($input['actionMode']=='copyDomainType')
	{	
		$DomainType->copyDomainType($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $DomainType->setDomainType($input);
	}
	else
	{
		$contentRS = $DomainType->getDomainType($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $DomainType->getDomainTypeBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('DomainTypeType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$DomainType->getDomainTypesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('DomainType.manageDomainType.End','End');
	return $returnValue;
}

/**
* Get the references used in DomainType. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getDomainTypeRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('Domain.getDomainTypeRefs.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$Domain = new DomainServer(&$SERVER,&$DS);
	$refName = $input['RefName'];
	//get refs
	$refsResult = $DS->query($refName,$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('Domain.getDomainTypeRefs.End','End');
	return $returnValue;
}




?>