<?

function frontAdminController()
{
	global  $CORE, $_SERVER;
	$input = $CORE->getInput();
	$frontBackLinkAction = $input['frontBackLinkAction'];

	if($frontBackLinkAction=='save')
	{
		$frontBackLink = $_SERVER['HTTP_REFERER'];
		//echo 'tttttt='.$frontBackLink;
		if(!empty($frontBackLink))
		{
			//echo 'rrrr';
			$CORE->setSessionVar("frontBackLink",$frontBackLink);
		}
	}
	elseif($frontBackLinkAction=='do')
	{
		$session = $CORE->getSessionData();
		$frontBackLink = $session['frontBackLink'];
		//echo 'rrr='.$frontBackLink;
		if(trim($frontBackLink))
		{
			$CORE->setSessionVar("frontBackLink","");
			die(header("Location: ".$frontBackLink));
		}
	}
}

function getAdminMenu()
{

	global  $CORE;
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$sectionsObject = new SectionClass();	

	if(!empty($user['UserID']))
	{
		if($input['SectionGroupCode']=='adminmenushortcuts')
		{
			$DS = new DataSource('main');
			$defaultGoupRS = $DS->query("SELECT SectionGroupID FROM SectionGroup WHERE SectionGroupCode='adminmenushortcuts'");
			$groupID = $defaultGoupRS[0]['SectionGroupID'];
			$query = "SELECT * FROM Section WHERE SectionGroupID='$groupID' AND PermAll='1' ORDER BY SectionPosition"; 
			$result['DB']['Sections'] = $DS->query($query);
		}
		else
		{
			$input['treeType']='all';
			$input['downLevels']='all';
			$input['SectionGroupCode'] = 'adminmenu';
			$entityRS = $sectionsObject->getSectionsTree($input);
			$result['DB']['Sections'] = $entityRS;	
	
			$owner = new OwnerClass();		
			$input['PermAll'] = '1';
			$result['DB']['Owners'] = $owner->getOwners($input);		
		}
	}
	//print_r($result['DB']['Sections']);
	
/*
	$result[10]['SectionName']='Products';
	$result[10]['SectionAlias']='manageCategories';
	$result[11]['SectionName']='Product Types';
	$result[11]['SectionAlias']='manageResourceTypes';	
	
	$result[0]['SectionName']='Site map';
	$result[0]['SectionAlias']='manageSections';
	$result[1]['SectionName']='Settings';
	$result[1]['SectionAlias']='manageSettings';
	$result[2]['SectionName']='Language fields';
	$result[2]['SectionAlias']='manageLanguageFields';	
	$result[3]['SectionName']='Languages';
	$result[3]['SectionAlias']='manageLanguages';		
	$result[4]['SectionName']='References';
	$result[4]['SectionAlias']='manageReferences';	
	$result[5]['SectionName']='Email templates';
	$result[5]['SectionAlias']='manageMailTemplates';

	$result[20]['SectionName']='Countries';
	$result[20]['SectionAlias']='manageRegions';
	$result[21]['SectionName']='Shipping';
	$result[21]['SectionAlias']='manageShipping';
	$result[22]['SectionName']='Currencie';
	$result[22]['SectionAlias']='manageCurrencies';	

	$result[48]['SectionName']='Groups';
	$result[48]['SectionAlias']='manageOwners';
	
	$result[49]['SectionName']='User groups and rights';
	$result[49]['SectionAlias']='manageUserGroups';
			
	$result[50]['SectionName']='Users';
	$result[50]['SectionAlias']='manageUsers';


	$result[95]['SectionName']='Help tips';
	$result[95]['SectionAlias']='manageHelpTips';
		
	$result[96]['SectionName']='Banners';
	$result[96]['SectionAlias']='manageBanners';

	$result[97]['SectionName']='Mailbox';
	$result[97]['SectionAlias']='mailbox';

	$result[98]['SectionName']='Profile';
	$result[98]['SectionAlias']='profile';
	
	$result[99]['SectionName']='Support';
	$result[99]['SectionAlias']='support';
	
	$result[101]['SectionName']='Modules';
	$result[101]['SectionAlias']='manageModules';	
		
	$result[100]['SectionName']='Logout';
	$result[100]['SectionAlias']='logout';
	
	$out['DB'] = $result;
*/	
	return $result;
}

?>
