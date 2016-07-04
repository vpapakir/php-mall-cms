<?php
//XCMSPro: Newsletter entity WebService public methods

function manageNewsletters($input='')
{
	global $CORE;
	//get input
	$CORE->setDebug('newsletter.manageNewsletters.Start','Start');	
	if(empty($input)) {$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['Newsletter'.DTR.'NewsletterID'];
	if(empty($entityID)) {$entityID = $input['NewsletterID'];}
	$viewMode = $input['viewMode']; 
	//print_r($input);
	//creat objects	
	$Newsletter = new NewsletterServerClass();
	$NewsletterList = new NewsletterListClass();
	
	//set Newsletter
	if($input['actionMode']=='delete')
	{
		$Newsletter->setNewsletter($input);
	}
	elseif($input['actionMode']=='save')
	{
		$Newsletter->setNewsletter($input);
	}
	
	//get Newsletters
	if(empty($viewMode) || $viewMode=='details') {
		$result['DB']['Newsletters'] = $Newsletter->getNewsletters($input);
	}
	
	//get NewsletterLists for Refs
	if($rs = $NewsletterList->getNewsletterListRefs()) {
		$result['DB']['NewsletterLists'] = $rs;
	}
	
	if(!empty($input['NewsletterStatus'])) {
		$entityID = '';
		$result['NewsletterOrderStatus'] = $input['NewsletterStatus'];
	}
	if(!empty($input['NewsletterSubscribersGroup'])) {
		$entityID = '';
		$result['NewsletterOrderSubscribersGroup'] = $input['NewsletterSubscribersGroup'];
	}
	
	//get Newsletter
	if(!empty($entityID))
	{
		$result['DB']['Newsletter'] = $Newsletter->getNewsletter($input);
	} 
	
	
	
	//get newsletter templates
	$input['NewsletterIsTemplate'] = 'Y';
	$result['DB']['NewslettersTemplates'] = $Newsletter->getNewsletters($input);
	
	//get Languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
		
	//get result
	$CORE->setDebug('newsletter.manageNewsletters.End','End');
	return $result;
}

function sendNewsletter($input='')
{
	global $CORE;
	$CORE->setDebug('newsletter.sendNewsletter.Start','Start');
	if(empty($input)) {
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$Newsletter = new NewsletterServerClass();
	//if($CORE->hasRights('admin')) tmp commented becassue need to accept from event.php for cron script
	if(1)
	{	
		if($input['actionMode']=='sendTest') {
			$result['sendNewsletter'] = $Newsletter->sendTestNewsletter($input);
		} elseif($input['actionMode']=='setQueue') {
		  	 $result['sendNewsletter'] = $Newsletter->queueNewsletter($input);
		  } elseif($input['actionMode']=='send') {
		  		
		  		$result['sendNewsletter'] = $Newsletter->sendNewsletterToSubscribers($input);
		    }
	} else {
		//todo: systMessage 
	  }
	$CORE->setDebug('newsletter.sendNewsletter.End','End');
	return $result;
}
?>