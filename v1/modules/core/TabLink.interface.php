<?php
//XCMSPro: TabLink entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageTabLinks()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['TabLinkID'];
	$entityAlias = $input['TabLink'];
	//creat objects			
	$TabLink = new TabLinkClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$TabLink->deleteTabLink($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$TabLink->setTabLink($input);
	}

	$TabLinksRS = $TabLink->getTabLinks($input);
	$result['DB']['TabLinks'] = $TabLinksRS;

	if(!empty($entityID) || !empty($entityAlias))
	{
		$result['DB']['TabLink'] = $TabLink->getTabLink($input);
	}
	
	$userGroupsRS = $CORE->callService("getUserGroups",'sessionServer');
	$result['DB']['UserGroups'] = $userGroupsRS['DB']['UserGroups'];
	//print_r($result['DB']['UserGroups']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

/**
* Gets TabLinks. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getTabLinks($in)
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$TabLink = new TabLinkClass();
	//get content
	$TabLinksRS = $TabLink->getTabLinks($input);
	$result['DB']['TabLinks'] = $TabLinksRS;

	return $result;
}
?>