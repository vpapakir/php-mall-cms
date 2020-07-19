<?php
//XCMSPro: Banner entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageBanners()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['BannerID'];
	//creat objects			
	$Banner = new BannerClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$Banner->deleteBanner($input);
	
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['BannerID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Banner WHERE BannerID='".$input['BannerID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Banner SET ".$fileField."='' WHERE BannerID='".$input['BannerID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['BannerImage']['file']))
		{
			$input['Banner'.DTR.'BannerImage']= $uploadRS['BannerImage']['file'];
		}		
		$Banner->setBanner($input);
		//$Banner->updateBoxPositions($input['BannerBox'.DTR.'BannerBoxID']);		
	}
	elseif($input['actionMode']=='copyBanner')
	{
		$Banner->copyBanner($input);
	}	

	if(!empty($entityID))
	{
		$BannerRS = $Banner->getBanner($input);
		$result['DB']['Banner'] = $BannerRS;	
	}
	$BannersRS = $Banner->getBanners($input);
	$result['DB']['Banners'] = $BannersRS;

	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['SectionGroupCode'] = 'main';
	$input['SectionType'] = 'front';
	$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
	$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];

	$input['treeType']='all';
	$input['downLevels']='all';
	$sectionsRS = $CORE->callService('getResourceCategoriesTree','resourceServer',$input);
	$result['DB']['CategoriesList'] = $sectionsRS['DB']['ResourceCategoriesList'];
	
	//print_r($result['DB']['SectionsList']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function addBanner()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$userID = 
	$entityID = $input['BannerID'];
	//creat objects			
	$Banner = new BannerClass();
	//get content
	if($input['actionMode']=='add')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
		}
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['BannerImage']['file']))
		{
			$input['Banner'.DTR.'BannerImage']= $uploadRS['BannerImage']['file'];
		}		
		$Banner->setBanner($input);
		//$Banner->updateBoxPositions($input['BannerBox'.DTR.'BannerBoxID']);		
	}else{
		if(empty($userID))
		{
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
	}
	
	if(!empty($entityID))
	{
		$BannerRS = $Banner->getBanner($input);
		$result['DB']['Banner'] = $BannerRS;	
	}
	$BannersRS = $Banner->getBanners($input);
	$result['DB']['Banners'] = $BannersRS;
	
	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['SectionGroupCode'] = 'main';
	$input['SectionType'] = 'front';
	$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
	$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];

	$input['treeType']='all';
	$input['downLevels']='all';
	$sectionsRS = $CORE->callService('getResourceCategoriesTree','resourceServer',$input);
	$result['DB']['CategoriesList'] = $sectionsRS['DB']['ResourceCategoriesList'];
	
	//print_r($result['DB']['SectionsList']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

/**
* Gets Banners. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getBanners()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$Banner = new BannerClass();
	//get content
	$BannersRS = $Banner->getBanners($input);
	$result['DB']['Banners']=$BannersRS;
	return $result;
}
/**
* Gets Banner. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getBanner($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('Banner.getBanner.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$Banner = new BannerServer(&$SERVER,&$DS);
	//get content
	$BannerRS = $Banner->getBanner($input);
	$SERVER->setOutput($BannerRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('Banner.getBanner.End','End');
	return $returnValue;
}


?>