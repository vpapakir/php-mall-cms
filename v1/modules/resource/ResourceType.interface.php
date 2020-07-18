<?php
//XCMSPro: ResourceType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageResourceTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['ResourceTypeID'];
	if(empty($entityID) && !empty($input['ResourceTypeAlias']))
	{
		$resourceTypeForIDRS = $DS->query("SELECT ResourceTypeID FROM ResourceType WHERE ResourceTypeAlias = '".$input['ResourceTypeAlias']."'");
		$entityID = $resourceTypeForIDRS[0]['ResourceTypeID'];
		$input['ResourceTypeID'] = $entityID;
		$CORE->setInputVar("ResourceTypeID",$entityID);
	}
	$entityAlias = $input['ResourceType'];
	
	$entityFieldID = $input['ResourceTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['ResourceTypeFieldAlias']))
	{
		$resourceTypeFieldForIDRS = $DS->query("SELECT ResourceTypeFieldID FROM ResourceTypeField WHERE ResourceTypeFieldAlias = '".$input['ResourceTypeFieldAlias']."'");
		$entityFieldID = $resourceTypeFieldForIDRS[0]['ResourceTypeFieldID'];
		$input['ResourceTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("ResourceTypeFieldID",$entityFieldID);
	}	
	$entityOptionID = $input['ResourceTypeOptionID'];
	//creat objects			
	$ResourceType = new ResourceTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ResourceType->deleteResourceType($input);
		$ResourceType->deleteResourceTypeField($input);
		$ResourceType->deleteResourceTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$ResourceType->setResourceType($input);
		$ResourceType->setResourceTypeField($input);		
		$ResourceType->setResourceTypeOption($input);
		//$ResourceType->updateBoxPositions($input['ResourceTypeBox'.DTR.'ResourceTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyResourceType')
	{
		$ResourceType->copyResourceType($input);
	}	

	$ResourceTypesRS = $ResourceType->getResourceTypes($input);
	$result['DB']['ResourceTypes'] = $ResourceTypesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['ResourceType'] = $ResourceType->getResourceType($input);
		$result['DB']['ResourceTypeFields'] = $ResourceType->getResourceTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['ResourceTypeField'] = $ResourceType->getResourceTypeField($input);
			$result['DB']['ResourceTypeOptions'] = $ResourceType->getResourceTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['ResourceTypeOption'] = $ResourceType->getResourceTypeOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}


function getResourceTemplate($input)
{
	$resourceTypeObject = new ResourceTypeClass();
	return $resourceTypeObject->getResourceTemplate($input['ResourceType'],$input['ResourceID']);
}

/**
* Gets ResourceTypes. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceTypes($input='')
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	
	$ResourceType = new ResourceTypeClass();
	$ResourceTypesRS = $ResourceType->getResourceTypes($input);
	$result['DB']['ResourceTypes'] = $ResourceTypesRS;
	return $result;
}
/**
* Gets ResourceType. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ResourceType.getResourceType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$ResourceType = new ResourceTypeServer(&$SERVER,&$DS);
	//get content
	$ResourceTypeRS = $ResourceType->getResourceType($input);
	$SERVER->setOutput($ResourceTypeRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ResourceType.getResourceType.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageResourceType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('ResourceType.manageResourceType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$ResourceType = new ResourceTypeServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$ResourceType->setResourceType($input);
		$ResourceType->setResourceTypeBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$ResourceType->deleteResourceType($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$ResourceType->deleteResourceTypeBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$ResourceType->setResourceTypeBox($input);
	}	

	if($input['actionMode']=='copyResourceType')
	{	
		$ResourceType->copyResourceType($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $ResourceType->setResourceType($input);
	}
	else
	{
		$contentRS = $ResourceType->getResourceType($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $ResourceType->getResourceTypeBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('ResourceTypeType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$ResourceType->getResourceTypesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('ResourceType.manageResourceType.End','End');
	return $returnValue;
}

/**
* Get the references used in ResourceType. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getResourceTypeRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getResourceTypeRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getResourceTypeRefs.End','End');
	return $returnValue;
}




?>