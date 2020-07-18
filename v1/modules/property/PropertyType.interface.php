<?php
//XCMSPro: PropertyType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function managePropertyTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['PropertyTypeID'];
	if(empty($entityID) && !empty($input['PropertyTypeAlias']))
	{
		$propertyTypeForIDRS = $DS->query("SELECT PropertyTypeID FROM PropertyType WHERE PropertyTypeAlias = '".$input['PropertyTypeAlias']."'");
		$entityID = $propertyTypeForIDRS[0]['PropertyTypeID'];
		$input['PropertyTypeID'] = $entityID;
		$CORE->setInputVar("PropertyTypeID",$entityID);
	}
	$entityAlias = $input['PropertyType'];
	
	$entityFieldID = $input['PropertyTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['PropertyTypeFieldAlias']))
	{
		$propertyTypeFieldForIDRS = $DS->query("SELECT PropertyTypeFieldID FROM PropertyTypeField WHERE PropertyTypeFieldAlias = '".$input['PropertyTypeFieldAlias']."'");
		$entityFieldID = $propertyTypeFieldForIDRS[0]['PropertyTypeFieldID'];
		$input['PropertyTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("PropertyTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['PropertyTypeOptionID'];
	//creat objects			
	$PropertyType = new PropertyTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$PropertyType->deletePropertyType($input);
		$PropertyType->deletePropertyTypeField($input);
		$PropertyType->deletePropertyTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$PropertyType->setPropertyType($input);
		$PropertyType->setPropertyTypeField($input);		
		$PropertyType->setPropertyTypeOption($input);
		//$PropertyType->updateBoxPositions($input['PropertyTypeBox'.DTR.'PropertyTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyPropertyType')
	{
		$PropertyType->copyPropertyType($input);
	}	

	$PropertyTypesRS = $PropertyType->getPropertyTypes($input);
	$result['DB']['PropertyTypes'] = $PropertyTypesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['PropertyType'] = $PropertyType->getPropertyType($input);
		$result['DB']['PropertyTypeFields'] = $PropertyType->getPropertyTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['PropertyTypeField'] = $PropertyType->getPropertyTypeField($input);
			$result['DB']['PropertyTypeOptions'] = $PropertyType->getPropertyTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['PropertyTypeOption'] = $PropertyType->getPropertyTypeOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function managePropertyFields()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityFieldID = $input['PropertyTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['PropertyTypeFieldAlias']))
	{
		$tourTypeFieldForIDRS = $DS->query("SELECT PropertyTypeFieldID FROM PropertyTypeField WHERE PropertyTypeFieldAlias = '".$input['PropertyTypeFieldAlias']."'");
		$entityFieldID = $tourTypeFieldForIDRS[0]['PropertyTypeFieldID'];
		$input['PropertyTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("PropertyTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['PropertyTypeOptionID'];
	//creat objects			
	$PropertyType = new PropertyTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$PropertyType->deletePropertyTypeField($input);
		$PropertyType->deletePropertyTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$PropertyType->setPropertyTypeField($input);		
		$PropertyType->setPropertyTypeOption($input);
		//$PropertyType->updateBoxPositions($input['PropertyTypeBox'.DTR.'PropertyTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyPropertyType')
	{
		$PropertyType->copyPropertyType($input);
	}	

	$result['DB']['PropertyTypeFields'] = $PropertyType->getPropertyTypeFields($input);
	if(!empty($entityFieldID))
	{
		$result['DB']['PropertyTypeField'] = $PropertyType->getPropertyTypeField($input);
		$result['DB']['PropertyTypeOptions'] = $PropertyType->getPropertyTypeOptions($input);
		if(!empty($entityOptionID))
		{
			$result['DB']['PropertyTypeOption'] = $PropertyType->getPropertyTypeOption($input);
		}			
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function getPropertyTemplate($input)
{
	$propertyTypeObject = new PropertyTypeClass();
	return $propertyTypeObject->getPropertyTemplate($input['PropertyType'],$input['PropertyID']);
}

/**
* Gets PropertyTypes. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getPropertyTypes($input='')
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	
	$PropertyType = new PropertyTypeClass();
	$PropertyTypesRS = $PropertyType->getPropertyTypes($input);
	$result['DB']['PropertyTypes'] = $PropertyTypesRS;
	return $result;
}
/**
* Gets PropertyType. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getPropertyType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('PropertyType.getPropertyType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$PropertyType = new PropertyTypeServer(&$SERVER,&$DS);
	//get content
	$PropertyTypeRS = $PropertyType->getPropertyType($input);
	$SERVER->setOutput($PropertyTypeRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('PropertyType.getPropertyType.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function managePropertyType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('PropertyType.managePropertyType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$PropertyType = new PropertyTypeServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$PropertyType->setPropertyType($input);
		$PropertyType->setPropertyTypeBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$PropertyType->deletePropertyType($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$PropertyType->deletePropertyTypeBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$PropertyType->setPropertyTypeBox($input);
	}	

	if($input['actionMode']=='copyPropertyType')
	{	
		$PropertyType->copyPropertyType($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $PropertyType->setPropertyType($input);
	}
	else
	{
		$contentRS = $PropertyType->getPropertyType($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $PropertyType->getPropertyTypeBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('PropertyTypeType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$PropertyType->getPropertyTypesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('PropertyType.managePropertyType.End','End');
	return $returnValue;
}

/**
* Get the references used in PropertyType. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getPropertyTypeRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getPropertyTypeRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getPropertyTypeRefs.End','End');
	return $returnValue;
}




?>