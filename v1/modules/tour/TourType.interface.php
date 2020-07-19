<?php
//XCMSPro: TourType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageTourTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityID = $input['TourTypeID'];
	if(empty($entityID) && !empty($input['TourTypeAlias']))
	{
		$tourTypeForIDRS = $DS->query("SELECT TourTypeID FROM TourType WHERE TourTypeAlias = '".$input['TourTypeAlias']."'");
		$entityID = $tourTypeForIDRS[0]['TourTypeID'];
		$input['TourTypeID'] = $entityID;
		$CORE->setInputVar("TourTypeID",$entityID);
	}	
	$entityAlias = $input['TourType'];
	$entityFieldID = $input['TourTypeFieldID'];
	$entityOptionID = $input['TourTypeOptionID'];

	//creat objects			
	$TourType = new TourTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$TourType->deleteTourType($input);
		$TourType->deleteTourTypeField($input);
		$TourType->deleteTourTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$TourType->setTourType($input);
		$TourType->setTourTypeField($input);		
		$TourType->setTourTypeOption($input);
		//$TourType->updateBoxPositions($input['TourTypeBox'.DTR.'TourTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyTourType')
	{
		$TourType->copyTourType($input);
	}	

	$TourTypesRS = $TourType->getTourTypes($input);
	$result['DB']['TourTypes'] = $TourTypesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['TourType'] = $TourType->getTourType($input);
		$result['DB']['TourTypeFields'] = $TourType->getTourTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['TourTypeField'] = $TourType->getTourTypeField($input);
			$result['DB']['TourTypeOptions'] = $TourType->getTourTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['TourTypeOption'] = $TourType->getTourTypeOption($input);
			}			
		}
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function manageTourFields()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$DS = new DataSource('main');
	$entityFieldID = $input['TourTypeFieldID'];
	if(empty($entityFieldID) && !empty($input['TourTypeFieldAlias']))
	{
		$tourTypeFieldForIDRS = $DS->query("SELECT TourTypeFieldID FROM TourTypeField WHERE TourTypeFieldAlias = '".$input['TourTypeFieldAlias']."'");
		$entityFieldID = $tourTypeFieldForIDRS[0]['TourTypeFieldID'];
		$input['TourTypeFieldID'] = $entityFieldID;
		$CORE->setInputVar("TourTypeFieldID",$entityFieldID);
	}	
	
	$entityOptionID = $input['TourTypeOptionID'];
	//creat objects			
	$TourType = new TourTypeClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$TourType->deleteTourTypeField($input);
		$TourType->deleteTourTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$TourType->setTourTypeField($input);		
		$TourType->setTourTypeOption($input);
		//$TourType->updateBoxPositions($input['TourTypeBox'.DTR.'TourTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyTourType')
	{
		$TourType->copyTourType($input);
	}	

	$result['DB']['TourTypeFields'] = $TourType->getTourTypeFields($input);
	if(!empty($entityFieldID))
	{
		$result['DB']['TourTypeField'] = $TourType->getTourTypeField($input);
		$result['DB']['TourTypeOptions'] = $TourType->getTourTypeOptions($input);
		if(!empty($entityOptionID))
		{
			$result['DB']['TourTypeOption'] = $TourType->getTourTypeOption($input);
		}			
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function getTourTemplate($input)
{
	$tourTypeObject = new TourTypeClass();
	return $tourTypeObject->getTourTemplate($input['TourType'],$input['TourID']);
}

/**
* Gets TourTypes. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourTypes($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('TourType.getTourTypes.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$TourType = new TourTypeServer(&$SERVER,&$DS);
	//get content
	$TourTypesRS = $TourType->getTourTypes($input);
	$SERVER->setOutput($TourTypesRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('TourType.getTourTypes.End','End');
	return $returnValue;
}
/**
* Gets TourType. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('TourType.getTourType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$TourType = new TourTypeServer(&$SERVER,&$DS);
	//get content
	$TourTypeRS = $TourType->getTourType($input);
	$SERVER->setOutput($TourTypeRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('TourType.getTourType.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageTourType($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('TourType.manageTourType.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$TourType = new TourTypeServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$TourType->setTourType($input);
		$TourType->setTourTypeBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$TourType->deleteTourType($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$TourType->deleteTourTypeBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$TourType->setTourTypeBox($input);
	}	

	if($input['actionMode']=='copyTourType')
	{	
		$TourType->copyTourType($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $TourType->setTourType($input);
	}
	else
	{
		$contentRS = $TourType->getTourType($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $TourType->getTourTypeBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('TourTypeType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$TourType->getTourTypesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('TourType.manageTourType.End','End');
	return $returnValue;
}

/**
* Get the references used in TourType. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTourTypeRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getTourTypeRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getTourTypeRefs.End','End');
	return $returnValue;
}




?>