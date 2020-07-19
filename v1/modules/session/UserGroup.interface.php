<?php
//XCMSPro: UserGroup entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageUserGroups()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['GroupID'];
	//creat objects			
	$UserGroup = new UserGroupClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$UserGroup->deleteUserGroup($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$UserGroup->setUserGroup($input);
	}
//echo "asdf$entityID";
//die();
	if(!empty($entityID))
	{
		$UserGroupRS = $UserGroup->getUserGroup($input);
		$result['DB']['UserGroup'] = $UserGroupRS;	
	}
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	$rightRS = $UserGroup->getSystemRights();
	
	$result['DB']['RightsList'] = $rightRS;
	
	//print_r($rightRS);
	
	return $result;
}


function getUserGroups()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['GroupID'];
	//creat objects			
	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;
	return $result;
}

?>