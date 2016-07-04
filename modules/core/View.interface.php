<?php
//XCMSPro: View entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageViews()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ViewID'];
	$entityAlias = $input['ViewAlias'];
	
	//creat objects			
	$View = new ViewClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$View->deleteView($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$View->setView($input);
	}
	elseif($input['actionMode']=='addbox')
	{
		$View->setViewBox($input);
	}	
	elseif($input['actionMode']=='savebox')
	{
		$View->setViewBox($input);
		$View->updateBoxPositions($input['ViewBox'.DTR.'ViewBoxID']);			
	}	
	elseif($input['actionMode']=='deletebox')
	{
		$View->deleteViewBox($input);
	}	
	elseif($input['actionMode']=='copyview')
	{
		$View->copyView($input);
	}	
	
	
	$viewsRS = $View->getViews($input);
	$result['DB']['Views'] = $viewsRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$viewRS = $View->getView($input);
		$result['DB']['View'] = $viewRS;
		if(!empty($entityAlias)){
			$entityID = $result['DB']['View'][0]['ViewID'];
			$CORE->setInputVar('ViewID',$entityID);
			$input['ViewID'] = $entityID;
		}
		
		$result['DB']['ViewBoxes'] = $View->getViewBoxes($input);
		$result['DB']['ViewBoxes'] = $View->getViewBoxes($input);
		
		$result['DB']['BoxesDefinition'] = $CORE->getBoxesDefinition();
		
		
	}
	
	$input['Level2GroupID'] = '11365480442006051812025318f111';
	$sectionsRS = $CORE->callService('manageSettings','coreServer',$input);
	
	$result['DB']['Settings'][0]['SettingVariableName'] = " ";
	$result['DB']['Settings'][0]['SettingName'] = 'Default';
	$i=1;
	foreach($sectionsRS['DB']['Settings'] as $key=>$value)
	{
		if(ereg('box',$value['SettingVariableName']))
			{
				$result['DB']['Settings'][$i] = $value;
				$i++;
			}
	}
	//print_r($result['DB']['Settings']);
	$languagesList = $CORE->getLanguages($result['DB']['View']);
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

/**
* Gets views. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getViews($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('view.getViews.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$View = new ViewServer(&$SERVER,&$DS);
	//get content
	$viewsRS = $View->getViews($input);
	$SERVER->setOutput($viewsRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('view.getViews.End','End');
	return $returnValue;
}
/**
* Gets view. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getView($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('view.getView.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$View = new ViewServer(&$SERVER,&$DS);
	//get content
	$viewRS = $View->getView($input);
	$SERVER->setOutput($viewRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('view.getView.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageView($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('view.manageView.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$View = new ViewServer(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$View->setView($input);
		$View->setViewBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$View->deleteView($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$View->deleteViewBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$View->setViewBox($input);
	}	

	if($input['actionMode']=='copyView')
	{	
		$View->copyView($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $View->setView($input);
	}
	else
	{
		$contentRS = $View->getView($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $View->getViewBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('ViewType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$View->getViewsRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('view.manageView.End','End');
	return $returnValue;
}

/**
* Get the references used in View. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getViewRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getViewRefs.Start','Start');	
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
	$SERVER->setDebug('datingProfile.getViewRefs.End','End');
	return $returnValue;
}


function getWebsiteDefinition($input='')
{
	global  $CORE;
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$View = new ViewClass();	

	$rs = $View->getViewDefinition($input);
	$result['DB']['Definition'] = $rs;
	return $result;
}


?>