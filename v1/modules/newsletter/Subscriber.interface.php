<?php
//XCMSPro: NewsletterSubscribers entity WebService public methods

function manageSubscribers()
{
	global $CORE;
	//get input
	$CORE->setDebug('newsletter.manageSubscribers.Start','Start');	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['NewsletterSubscriber'.DTR.'NewsletterSubscriberID'];
	if(empty($entityID)) {$entityID = $input['NewsletterSubscriberID'];}
	//echo ($input['NewsletterSubscriber'.DTR.'SubscriberNewsletters']);
	//creat objects	
	$NewsletterSubscriber = new NewsletterSubscriberClass();
	$NewsletterList = new NewsletterListClass();
	$subscriber = new NewsletterSubscriberClass();
	
	//set NewsletterSubscriber
	if($input['actionMode']=='delete')
	{
		$NewsletterSubscriber->setNewsletterSubscriber($input);
	}
	elseif($input['actionMode']=='save')
	{
		$NewsletterSubscriber->setNewsletterSubscriber($input);
	}
	//block or delete imported subscribers(from import option tags)
	if($input['actionMode']=='deleteImported' || $input['actionMode']=='blockImported')
	{
		$result['ChangeImportedSubscriberResult'] = $subscriber->importSetSubscribers($input);
	}
	
	//get NewsletterSubscribers
	$result['DB']['NewsletterSubscribers'] = $NewsletterSubscriber->getNewsletterSubscribers($input);
	
	//get NewsletterLists for Refs
	if($rs = $NewsletterList->getNewsletterListRefs()) {
		$result['DB']['NewsletterLists'] = $rs;
	}
	
	if(!empty($input['SubscriberStatus'])) {
		$entityID = '';
		$result['SubscriberOrderStatus'] = $input['SubscriberStatus'];
	}
	if(!empty($input['NewsletterSubscribersGroup'])) {
		$entityID = '';
		$result['OrderSubscribersGroup'] = $input['NewsletterSubscribersGroup'];
	}
	
	//get NewsletterSubscriber
	if(!empty($entityID))
	{
		$result['DB']['NewsletterSubscriber'] = $NewsletterSubscriber->getNewsletterSubscriber($input);
	}
	
	//get Languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	//jb 18.11.05 set active languages refs
	if(is_array($languagesList['languageCodes'])) {
		foreach($languagesList['languageCodes'] as $id=>$key) {
			$langRef[] = array('id'=>$id,'key'=>$key,'lang'=>$languagesList['languageNames'][$id]);
		}
		$result['Refs']['Languages'] = $langRef;
	}
		
	//get result
	$CORE->setDebug('newsletter.manageSubscribers.End','End');
	return $result;
}

function importSubscribers()
{
	global $CORE;
	$CORE->setDebug('newsletter.importSubscribers.Start','Start');
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//creat objects	
	$subscriber = new NewsletterSubscriberClass();
	$NewsletterList = new NewsletterListClass();

	if($input['actionMode']=='save')
	{
		$result['ImportSubscriberResult'] = $subscriber->importSubscribers($input);
	}

	if($input['actionMode']=='deleteImported' || $input['actionMode']=='blockImported')
	{
		$result['ChangeImportedSubscriberResult'] = $subscriber->importSetSubscribers($input);
	}
	
	/* old import from a file
	if(!empty($input['ImportSubscribersFile']))
	{
		$urlcontent = $input['ImportSubscribersFile'];
		$urlcontent = str_replace("//","/",$urlcontent);
		//$config['RootPath'].
		$filepath = $config['Content'].'ingletonwood/ingletonwood/en/'.$urlcontent;
		if(is_file($filepath))
		{
			$contentfile = file($filepath);
			$content = '';
			foreach($contentfile as $key=>$value)
			{
				$content .= $value;
			}
			
			$importFromFile = '<ImportedSubscribersFromFile>'.$content.'</ImportedSubscribersFromFile>';
			$SERVER->setOutput($importFromFile);
		}
		
	}
	*/

    //get NewsletterLists for Refs
	if($rs = $NewsletterList->getNewsletterListRefs()) {
		$result['DB']['NewsletterLists'] = $rs;
	}

	$CORE->setDebug('newsletter.importSubscribers.End','End');
	return $result;
}

function exportSubscribers($input='')
{
	global $CORE;
	$CORE->setDebug('newsletter.exportSubscribers.Start','Start');
	if(empty($input)) {$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//creat objects	
	$subscriber = new NewsletterSubscriberClass();
	$NewsletterList = new NewsletterListClass();

	if($input['actionMode']=='export')
	{
		$result['ExportedSubscribers'] = $subscriber->exportSubscribers($input);
	}

    //get NewsletterLists for Refs
	if($rs = $NewsletterList->getNewsletterListRefs()) {
		$result['DB']['NewsletterLists'] = $rs;
	}

	$CORE->setDebug('newsletter.exportSubscribers.End','End');
	return $result;
}
?>