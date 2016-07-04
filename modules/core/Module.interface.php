<?php
//XCMSPro: Module entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageModules()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ModuleID'];
	$entityAlias = $input['Module'];
	//creat objects			
	$Module = new ModuleClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$Module->deleteModule($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$Module->setModule($input);
	}

	$Module->updateModulesList($input);
	$ModulesRS = $Module->getModules($input);
	$result['DB']['Modules'] = $ModulesRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['Module'] = $Module->getModule($input);
	}
	
	$userGroupsRS = $CORE->callService("getUserGroups",'sessionServer');
	$result['DB']['UserGroups'] = $userGroupsRS['DB']['UserGroups'];
	//print_r($result['DB']['UserGroups']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

/**
* Gets Modules. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getModules()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects				
	$Module = new ModuleClass();
	//get content
	$ModulesRS = $Module->getModules($input);
	$result['DB']['Modules'] = $ModulesRS;

	return $result;
}
?>