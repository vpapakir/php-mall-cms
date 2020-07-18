<?php
//XCMSPro: ReservedPropertyType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservedPropertyTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['ReservedPropertyTypeID'];
	if(empty($entityID) && !empty($input['ReservedPropertyTypeAlias']))
	{
		$reservedPropertyTypeForIDRS = $DS->query("SELECT ReservedPropertyTypeID FROM ReservedPropertyType WHERE ReservedPropertyTypeAlias = '".$input['ReservedPropertyTypeAlias']."'");
		$entityID = $reservedPropertyTypeForIDRS[0]['ReservedPropertyTypeID'];
		$input['ReservedPropertyTypeID'] = $entityID;
		$CORE->setInputVar("ReservedPropertyTypeID",$entityID);
	}
	$entityAlias = $input['ReservedPropertyType'];
	
	$entityFieldID = $input['ReservedPropertyTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['ReservedPropertyTypeFieldAlias']))
	{
		$reservedPropertyTypeFieldForIDRS = $DS->query("SELECT ReservedPropertyTypeFieldID FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldAlias = '".$input['ReservedPropertyTypeFieldAlias']."'");
		$entityFieldID = $reservedPropertyTypeFieldForIDRS[0]['ReservedPropertyTypeFieldID'];
		$input['ReservedPropertyTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("ReservedPropertyTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['ReservedPropertyTypeOptionID'];
	//creat objects			
	$ReservedPropertyType = new ReservedPropertyTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ReservedPropertyType->deleteReservedPropertyType($input);
		$ReservedPropertyType->deleteReservedPropertyTypeField($input);
		$ReservedPropertyType->deleteReservedPropertyTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ReservedPropertyType->setReservedPropertyType($input);
		$ReservedPropertyType->setReservedPropertyTypeField($input);		
		$ReservedPropertyType->setReservedPropertyTypeOption($input);
		//$ReservedPropertyType->updateBoxPositions($input['ReservedPropertyTypeBox'.DTR.'ReservedPropertyTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyReservedPropertyType')
	{
		$ReservedPropertyType->copyReservedPropertyType($input);
	}	

	$ReservedPropertyTypesRS = $ReservedPropertyType->getReservedPropertyTypes($input);
	$result['DB']['ReservedPropertyTypes'] = $ReservedPropertyTypesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['ReservedPropertyType'] = $ReservedPropertyType->getReservedPropertyType($input);
		$result['DB']['ReservedPropertyTypeFields'] = $ReservedPropertyType->getReservedPropertyTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['ReservedPropertyTypeField'] = $ReservedPropertyType->getReservedPropertyTypeField($input);
			$result['DB']['ReservedPropertyTypeOptions'] = $ReservedPropertyType->getReservedPropertyTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['ReservedPropertyTypeOption'] = $ReservedPropertyType->getReservedPropertyTypeOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function manageReservedPropertyFields()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityFieldID = $input['ReservedPropertyTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['ReservedPropertyTypeFieldAlias']))
	{
		$tourTypeFieldForIDRS = $DS->query("SELECT ReservedPropertyTypeFieldID FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldAlias = '".$input['ReservedPropertyTypeFieldAlias']."'");
		$entityFieldID = $tourTypeFieldForIDRS[0]['ReservedPropertyTypeFieldID'];
		$input['ReservedPropertyTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("ReservedPropertyTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['ReservedPropertyTypeOptionID'];
	//creat objects			
	$ReservedPropertyType = new ReservedPropertyTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ReservedPropertyType->deleteReservedPropertyTypeField($input);
		$ReservedPropertyType->deleteReservedPropertyTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ReservedPropertyType->setReservedPropertyTypeField($input);		
		$ReservedPropertyType->setReservedPropertyTypeOption($input);
		//$ReservedPropertyType->updateBoxPositions($input['ReservedPropertyTypeBox'.DTR.'ReservedPropertyTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyReservedPropertyType')
	{
		$ReservedPropertyType->copyReservedPropertyType($input);
	}	

	$result['DB']['ReservedPropertyTypeFields'] = $ReservedPropertyType->getReservedPropertyTypeFields($input);
	if(!empty($entityFieldID))
	{
		$result['DB']['ReservedPropertyTypeField'] = $ReservedPropertyType->getReservedPropertyTypeField($input);
		$result['DB']['ReservedPropertyTypeOptions'] = $ReservedPropertyType->getReservedPropertyTypeOptions($input);
		if(!empty($entityOptionID))
		{
			$result['DB']['ReservedPropertyTypeOption'] = $ReservedPropertyType->getReservedPropertyTypeOption($input);
		}			
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function getReservedPropertyTemplate($input)
{
	$reservedPropertyTypeObject = new ReservedPropertyTypeClass();
	return $reservedPropertyTypeObject->getReservedPropertyTemplate($input['ReservedPropertyType'],$input['ReservedPropertyID']);
}

/**
* Gets ReservedPropertyTypes. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getReservedPropertyTypes($input='')
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	
	$ReservedPropertyType = new ReservedPropertyTypeClass();
	$ReservedPropertyTypesRS = $ReservedPropertyType->getReservedPropertyTypes($input);
	$result['DB']['ReservedPropertyTypes'] = $ReservedPropertyTypesRS;
	return $result;
}
/**
* Gets ReservedPropertyType. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getReservedPropertyType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ReservedPropertyType.getReservedPropertyType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ReservedPropertyType = new ReservedPropertyTypeServer(&$SERVER,&$DS);
	//get content
	$ReservedPropertyTypeRS = $ReservedPropertyType->getReservedPropertyType($input);
	$SERVER->setOutput($ReservedPropertyTypeRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ReservedPropertyType.getReservedPropertyType.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservedPropertyType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ReservedPropertyType.manageReservedPropertyType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$ReservedPropertyType = new ReservedPropertyTypeServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$ReservedPropertyType->setReservedPropertyType($input);
		$ReservedPropertyType->setReservedPropertyTypeBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$ReservedPropertyType->deleteReservedPropertyType($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$ReservedPropertyType->deleteReservedPropertyTypeBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$ReservedPropertyType->setReservedPropertyTypeBox($input);
	}	

	if($input['actionMode']=='copyReservedPropertyType')
	{	
		$ReservedPropertyType->copyReservedPropertyType($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $ReservedPropertyType->setReservedPropertyType($input);
	}
	else
	{
		$contentRS = $ReservedPropertyType->getReservedPropertyType($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $ReservedPropertyType->getReservedPropertyTypeBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('ReservedPropertyTypeType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$ReservedPropertyType->getReservedPropertyTypesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ReservedPropertyType.manageReservedPropertyType.End','End');
	return $returnValue;
}

/**
* Get the references used in ReservedPropertyType. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getReservedPropertyTypeRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getReservedPropertyTypeRefs.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$DatingProfile = new DatingProfileServer(&$SERVER,&$DS);
	$refName = $input['RefName'];
	//get refs
	$refsResult = $DS->query($refName,$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('datingProfile.getReservedPropertyTypeRefs.End','End');
	return $returnValue;
}




?>